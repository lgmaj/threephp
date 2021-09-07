<?php

namespace threephp\core;

class Face4 extends Vector3
{
    public Vector3 $screen;

    public function __construct(public Vertex $a,
                                public Vertex $b,
                                public Vertex $c,
                                public Vertex $d,
                                public int    $color = 0xff0000)
    {
        parent::__construct(
            ($a->x + $b->x + $c->x + $d->x) / 4,
            ($a->y + $b->y + $c->y + $d->y) / 4,
            ($a->z + $b->z + $c->z + $d->z) / 4
        );

        $this->screen = new Vector3();
    }
}