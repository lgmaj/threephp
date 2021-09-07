<?php

namespace threephp\objects;

use threephp\core\Geometry;
use threephp\materials\ColorMaterial;

class Mesh extends Object3D
{
    public function __construct(public Geometry $geometry, public ColorMaterial $material)
    {
        parent::__construct();
    }
}