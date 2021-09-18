<?php

namespace threephp\renderers;

use threephp\cameras\Camera;
use threephp\core\Face3;
use threephp\core\Face4;
use threephp\core\Matrix4;
use threephp\core\Vector3;
use threephp\core\Vector4;
use threephp\objects\Mesh;
use threephp\objects\Particle;
use threephp\scenes\Scene;

class Renderer
{
    protected Matrix4 $matrix;
    protected array $renderList = [];

    protected int $width;
    protected int $height;
    protected int $widthHalf;
    protected int $heightHalf;

    public function __construct()
    {
        $this->matrix = new Matrix4();
    }

    public function setSize(int $width, int $height): void
    {
        $this->width = $width;
        $this->height = $height;

        $this->widthHalf = $width / 2;
        $this->heightHalf = $height / 2;
    }

    public function render(Scene $scene, Camera $camera): void
    {

        foreach ($scene->objects as $object) {
            if ($object instanceof Mesh) {
                $this->matrix->multiply($camera->matrix, $object->matrix);

                foreach ($object->geometry->vertices as $vertex) {
                    $vertex->screen->copy($vertex);

                    $this->matrix->transform($vertex->screen);

                    $camera->projectionMatrix->transform($vertex->screen);

                    $vertex->visible = $vertex->screen->z > 0 && $object->screen->z < 1;

                    $vertex->screen->x *= $this->widthHalf;
                    $vertex->screen->y *= $this->heightHalf;
                }

                foreach ($object->geometry->faces as $face) {
                    if ($face instanceof Face3) {
                        if ($face->a->visible && $face->b->visible && $face->c->visible && (
                                ($face->c->screen->x - $face->a->screen->x) * ($face->b->screen->y - $face->a->screen->y) -
                                ($face->c->screen->y - $face->a->screen->y) * ($face->b->screen->x - $face->a->screen->x) > 0)) {
                            $face->screen->z = ($face->a->screen->z + $face->b->screen->z + $face->c->screen->z) * 0.3;
                            $this->renderList[] = $face;
                        }
                    }

                    if ($face instanceof Face4) {
                        if ($face->a->visible && $face->b->visible && $face->c->visible && (
                                ($face->d->screen->x - $face->a->screen->x) * ($face->b->screen->y - $face->a->screen->y) -
                                ($face->d->screen->y - $face->a->screen->y) * ($face->b->screen->x - $face->a->screen->x) > 0 ||
                                ($face->b->screen->x - $face->c->screen->x) * ($face->d->screen->y - $face->c->screen->y) -
                                ($face->b->screen->y - $face->c->screen->y) * ($face->d->screen->x - $face->c->screen->x) > 0)) {
                            $face->screen->z = ($face->a->screen->z + $face->b->screen->z + $face->c->screen->z + $face->d->screen->z) * 0.25;;
                            $this->renderList[] = $face;
                        }
                    }
                }
            } else if ($object instanceof Particle) {
                $screen = toVector4($object->position);

                $camera->matrix->transform($screen);
                $camera->projectionMatrix->transform($screen);

                $size = division($screen->x, $screen->w) -
                    division(($screen->x + $camera->projectionMatrix->n11), ($screen->w + $camera->projectionMatrix->n14));

                $object->zsize = abs($size) * $object->size;

                $object->screen->copy(toVector3($screen));

                //if ($object->screen->z > 0 && $object->screen->z < 1
                //    && $object->screen->x + $object->zsize > -1 && $object->screen->x - $object->zsize < 1
                //    && $object->screen->y + $object->zsize > -1 && $object->screen->y - $object->zsize < 1) {
                $object->zsize *= $this->widthHalf;
                $object->screen->x *= $this->widthHalf;
                $object->screen->y *= $this->heightHalf;
                $this->renderList[] = $object;
                // }
            }
        }
    }
}

function toVector4(Vector3 $v): Vector4
{
    return new Vector4($v->x, $v->y, $v->z, 1.0);
}

function toVector3(Vector4 $v): Vector3
{
    return new Vector3($v->x / $v->w, $v->y / $v->w, $v->z / $v->w);
}


function division($a, $b): float
{
    return $b !== 0 ? $a / $b : 0;
}