<?php

namespace threephp\core;

class Geometry
{
    public array $vertices;
    public array $faces;

    public function __construct()
    {
        $this->vertices = [];
        $this->faces = [];
    }
}