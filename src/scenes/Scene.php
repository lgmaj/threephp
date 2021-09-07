<?php

namespace threephp\scenes;

class Scene
{
    public array $objects;

    public function __construct()
    {
        $this->objects = [];
    }

    public function add($object)
    {
        array_push($this->objects, $object);
    }
}