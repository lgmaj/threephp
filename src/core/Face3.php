<?php

namespace threephp\core;

class Face3 extends Vector3
{
    public Vector3 $screen;

    public function __construct(public Vertex $a,
                                public Vertex $b,
                                public Vertex $c,
                                public int    $color = 0xff0000)
    {
        parent::__construct(
            ($a->x + $b->x + $c->x) / 3,
            ($a->y + $b->y + $c->y) / 3,
            ($a->z + $b->z + $c->z) / 3
        );

        $this->screen = new Vector3();
    }
}