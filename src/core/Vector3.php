<?php

namespace threephp\core;

class Vector3
{
    public function __construct(public float $x = 0,
                                public float $y = 0,
                                public float $z = 0)
    {
    }

    public function copy(Vector3 $v): void
    {
        $this->x = $v->x;
        $this->y = $v->y;
        $this->z = $v->z;
    }

    public function sub($v1, $v2): void
    {
        $this->x = $v1->x - $v2->x;
        $this->y = $v1->y - $v2->y;
        $this->z = $v1->z - $v2->z;
    }

    public function cross(Vector3 $v): void
    {
        $tx = $this->x;
        $ty = $this->y;
        $tz = $this->z;

        $this->x = $ty * $v->z - $tz * $v->y;
        $this->y = $tz * $v->x - $tx * $v->z;
        $this->z = $tx * $v->y - $ty * $v->x;
    }

    public function length(): float
    {
        return sqrt($this->x * $this->x + $this->y * $this->y + $this->z * $this->z);
    }

    public function negate(): void
    {
        $this->x = -$this->x;
        $this->y = -$this->y;
        $this->z = -$this->z;
    }

    public function normalize(): Vector3
    {
        $ool = $this->length() > 0 ? 1.0 / $this->length() : 0;

        $this->x *= $ool;
        $this->y *= $ool;
        $this->z *= $ool;
        return $this;
    }

    public function dot(Vector3 $v): float
    {
        return $this->x * $v->x + $this->y * $v->y + $this->z * $v->z;
    }

    public function __toString()
    {
        return sprintf("Vector3 (%s, %s, %s)", $this->x, $this->y, $this->z);
    }
}