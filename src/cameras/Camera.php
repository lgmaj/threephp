<?php

namespace threephp\cameras;

use threephp\core\Matrix4;
use threephp\core\Vector3;

class Camera extends Vector3
{
    public Vector3 $up;
    public Vector3 $target;
    public float $zoom;
    public float $focus;
    public float $roll;
    public Matrix4 $matrix;

    public function __construct(float $x = 0, float $y = 0, float $z = 0)
    {
        parent::__construct($x, $y, $z);

        $this->up = new Vector3(0, 1, 0);
        $this->target = new Vector3(0, 0, 0);
        $this->zoom = 3;
        $this->focus = 500;
        $this->roll = 0;

        $this->matrix = new Matrix4();
        $this->updateMatrix();
    }

    public function updateMatrix(): void
    {
        $this->matrix->lookAt($this, $this->target, $this->up);
    }

    public function __toString()
    {
        return sprintf("Camera (%s, %s, %s)", $this->x, $this->y, $this->z);
    }

}