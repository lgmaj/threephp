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

        $this->vertices[] = new Vertex(-$width_half, $height_half, 0);
        $this->vertices[] = new Vertex($width_half, $height_half, 0);
        $this->vertices[] = new Vertex($width_half, -$height_half, 0);
        $this->vertices[] = new Vertex(-$width_half, -$height_half, 0);

        $this->faces[] = new Face4(
            $this->vertices[0],
            $this->vertices[1],
            $this->vertices[2],
            $this->vertices[3]
        );
    }
}