<?php

namespace threephp\core;

class Color
{
    public int $hex;
    public int $r;
    public int $g;
    public int $b;

    public function __construct(int $hex)
    {
        $this->setHex($hex);
    }

    public function setHex(int $hex): void
    {
        $this->hex = $hex;
        $this->updateRGBA();
    }

    public function setRGBA(int $r, int $g, int $b)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;

        $this->updateHex();
    }

    public function updateHex(): void
    {
        $this->hex = $this->r << 16 | $this->g << 8 | $this->b;
    }

    public function updateRGBA(): void
    {
        $this->r = $this->hex >> 16 & 0xff;
        $this->g = $this->hex >> 8 & 0xff;
        $this->b = $this->hex & 0xff;
    }

    public function __toString(): string
    {
        return sprintf("Color ( r: %d, g: %d, b: %d, hex: %d )", $this->r, $this->g, $this->b, $this->hex);
    }
}