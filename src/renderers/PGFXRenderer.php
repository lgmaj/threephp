<?php

namespace threephp\renderers;

use pgfx\display\Graphics;
use pgfx\renderer\gd\GdImageRenderer;
use threephp\cameras\Camera;
use threephp\core\Face3;
use threephp\core\Face4;
use threephp\objects\Particle;
use threephp\scenes\Scene;

class PGFXRenderer extends Renderer
{
    public function render(Scene $scene, Camera $camera): void
    {
        parent::render($scene, $camera);

        $graphics = new Graphics();

        foreach ($this->renderList as $element) {
            if ($element instanceof Face3) {
                $graphics->beginFill($element->color);
                $graphics->moveTo($element->a->screen->x + $this->widthHalf, $element->a->screen->y + $this->heightHalf);
                $graphics->lineTo($element->b->screen->x + $this->widthHalf, $element->b->screen->y + $this->heightHalf);
                $graphics->lineTo($element->c->screen->x + $this->widthHalf, $element->c->screen->y + $this->heightHalf);
                $graphics->endFill();
            } else if ($element instanceof Face4) {
                $graphics->beginFill($element->color);
                $graphics->moveTo($element->a->screen->x + $this->widthHalf, $element->a->screen->y + $this->heightHalf);
                $graphics->lineTo($element->b->screen->x + $this->widthHalf, $element->b->screen->y + $this->heightHalf);
                $graphics->lineTo($element->c->screen->x + $this->widthHalf, $element->c->screen->y + $this->heightHalf);
                $graphics->lineTo($element->d->screen->x + $this->widthHalf, $element->d->screen->y + $this->heightHalf);
                $graphics->endFill();
            } else if ($element instanceof Particle) {
                $graphics->beginFill($element->material->color);
                $graphics->drawCircle($element->screen->x + $this->widthHalf, $element->screen->y + $this->heightHalf, $element->size);
                $graphics->endFill();
            }
        }

        $renderer = new GdImageRenderer($this->width, $this->height);
        $renderer->setBackgroundColor(0x232323);
        $renderer->render($graphics);
    }
}