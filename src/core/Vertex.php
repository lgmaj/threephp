<?php

namespace threephp\core;

class Vertex extends Vector3
{
    public Vector3 $screen;

    public function __construct(float $x = 0, float $y = 0, float $z = 0)
    {
        parent::__construct($x, $y, $z);
        $this->screen = new Vector3();
    }

    public function __toString()
    {
        return sprintf("Vertex (%s, %s, %s)", $this->x, $this->y, $this->z);
    }
}