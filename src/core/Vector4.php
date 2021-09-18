<?php

namespace threephp\core;

class Vector4
{
    public function __construct(public float $x = 0,
                                public float $y = 0,
                                public float $z = 0,
                                public float $w = 1)
    {
    }
}