<?php

namespace threephp\renderers;

use threephp\cameras\Camera;
use threephp\core\Face3;
use threephp\core\Face4;
use threephp\core\Matrix4;
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
        $focuszoom = $camera->focus * $camera->zoom;

        foreach ($scene->objects as $object) {
            if ($object instanceof Mesh) {
                $this->matrix->multiply($camera->matrix, $object->matrix);

                foreach ($object->geometry->vertices as $vertex) {
                    $vertex->screen->copy($vertex);

                    $this->matrix->transform($vertex->screen);

                    $divisorZ = $camera->focus + $object->screen->z;
                    $vertex->screen->z = $divisorZ == 0 ? 0 : $focuszoom / ($camera->focus + $vertex->screen->z);

                    $vertex->visible = $vertex->screen->z > 0;

                    $vertex->screen->x *= $vertex->screen->z;
                    $vertex->screen->y *= $vertex->screen->z;
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
                $object->screen->copy($object->position);

                $camera->matrix->transform($object->screen);

                $divisorZ = $camera->focus + $object->screen->z;
                $object->screen->z = $divisorZ == 0 ? 0 : $focuszoom / $divisorZ;

                if ($object->screen->z < 0)
                    continue;

                $object->screen->x *= $object->screen->z;
                $object->screen->y *= $object->screen->z;

                $this->renderList[] = $object;
            }
        }
    }
}