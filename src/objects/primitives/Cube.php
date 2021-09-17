<?php

namespace threephp\objects\primitives;

use threephp\core\Face4;
use threephp\core\Geometry;
use threephp\core\Vertex;

class Cube extends Geometry
{
    public function __construct($width, $height, $depth)
    {
        parent::__construct();

        $width_half = $width / 2;
        $height_half = $height / 2;
        $depth_half = $depth / 2;

        $this->v($width_half, $height_half, -$depth_half);
        $this->v($width_half, -$height_half, -$depth_half);
        $this->v(-$width_half, -$height_half, -$depth_half);
        $this->v(-$width_half, $height_half, -$depth_half);
        $this->v($width_half, $height_half, $depth_half);
        $this->v($width_half, -$height_half, $depth_half);
        $this->v(-$width_half, -$height_half, $depth_half);
        $this->v(-$width_half, $height_half, $depth_half);

        $this->f4(0, 1, 2, 3);
        $this->f4(4, 7, 6, 5);
        $this->f4(0, 4, 5, 1);
        $this->f4(1, 5, 6, 2);
        $this->f4(2, 6, 7, 3);
        $this->f4(4, 0, 3, 7);
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