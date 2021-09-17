<?php

namespace threephp\renderers;

use pgfx\display\Graphics;
use threephp\cameras\Camera;
use threephp\core\Face3;
use threephp\core\Face4;
use threephp\objects\Particle;
use threephp\scenes\Scene;

class PGFXRenderer extends Renderer
{
    public Graphics $graphics;

    public function __construct(Graphics $graphics = null)
    {
        parent::__construct();

        $this->graphics = $graphics ?? new Graphics();
    }

    public function render(Scene $scene, Camera $camera): void
    {
        parent::render($scene, $camera);

        foreach ($this->renderList as $element) {
            if ($element instanceof Face3) {
                $this->graphics->beginFill($element->color);
                $this->graphics->lineStyle(1, 0x007878);
                $this->graphics->moveTo($element->a->screen->x + $this->widthHalf, $element->a->screen->y + $this->heightHalf);
                $this->graphics->lineTo($element->b->screen->x + $this->widthHalf, $element->b->screen->y + $this->heightHalf);
                $this->graphics->lineTo($element->c->screen->x + $this->widthHalf, $element->c->screen->y + $this->heightHalf);
                $this->graphics->endFill();
            } else if ($element instanceof Face4) {
                $this->graphics->beginFill($element->color);
                $this->graphics->moveTo($element->a->screen->x + $this->widthHalf, $element->a->screen->y + $this->heightHalf);
                $this->graphics->lineTo($element->b->screen->x + $this->widthHalf, $element->b->screen->y + $this->heightHalf);
                $this->graphics->lineTo($element->c->screen->x + $this->widthHalf, $element->c->screen->y + $this->heightHalf);
                $this->graphics->lineTo($element->d->screen->x + $this->widthHalf, $element->d->screen->y + $this->heightHalf);
                $this->graphics->endFill();
            } else if ($element instanceof Particle) {
                $this->graphics->beginFill($element->material->color);
                $this->graphics->drawCircle($element->screen->x + $this->widthHalf, $element->screen->y + $this->heightHalf, $element->size);
                $this->graphics->endFill();
            }
        }
    }
}