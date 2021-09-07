<?php

namespace threephp\objects;

use threephp\materials\ColorMaterial;

class Particle extends Object3D
{
    public int $size = 1;

    public function __construct(public ColorMaterial $material)
    {
        parent::__construct();
    }
}