<?php

namespace threephp\objects;

use threephp\core\Matrix4;
use threephp\core\Vector3;

class Object3D
{
    public Vector3 $position;
    public Vector3 $rotation;
    public Vector3 $scale;
    public Matrix4 $matrix;
    public Vector3 $screen;

    public function __construct()
    {
        $this->position = new Vector3(0, 0, 0);
        $this->rotation = new Vector3(0, 0, 0);
        $this->scale = new Vector3(1, 1, 1);

        $this->matrix = new Matrix4();
        $this->screen = new Vector3(0, 0, 0);
    }

    public function updateMatrix(): void
    {
        $this->matrix->identity();

        $this->matrix->multiplySelf(Matrix4::translationMatrix($this->position->x, $this->position->y, $this->position->z));
        $this->matrix->multiplySelf(Matrix4::rotationXMatrix($this->rotation->x));
        $this->matrix->multiplySelf(Matrix4::rotationYMatrix($this->rotation->y));
        $this->matrix->multiplySelf(Matrix4::rotationZMatrix($this->rotation->z));
        $this->matrix->multiplySelf(Matrix4::scaleMatrix($this->scale->x, $this->scale->y, $this->scale->z));
    }
}