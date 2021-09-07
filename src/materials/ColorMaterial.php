<?php

namespace threephp\materials;

class ColorMaterial
{
    public function __construct(public int   $color = 0xff0000,
                                public float $opacity = 1)
    {
    }
}