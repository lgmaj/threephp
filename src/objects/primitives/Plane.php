<?php

namespace threephp\objects\primitives;

use threephp\core\Face4;
use threephp\core\Geometry;
use threephp\core\Vertex;

class Plane extends Geometry
{
    public function __construct($width, $height)
    {
        parent::__construct();

        $width_half = $width / 2;
        $height_half = $height / 2;

        $this->v(-$width_half, $height_half, 0);
        $this->v($width_half, $height_half, 0);
        $this->v($width_half, -$height_half, 0);
        $this->v(-$width_half, -$height_half, 0);

        $this->f4(0, 1, 2, 3);
    }

    private function v(float $x, float $y, float $z): void
    {
        $this->vertices[] = new Vertex($x, $y, $z);
    }

    private function f4(int $a, int $b, int $c, int $d): void
    {
        $this->faces[] = new Face4($this->vertices[$a], $this->vertices[$b], $this->vertices[$c], $this->vertices[$d]);
    }
}