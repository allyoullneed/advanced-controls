<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Div extends Component
{
    public ?string $parentColor = null;
    public ?string $parentSize  = null;
    public function __construct(
        public ?string $color       = null,
        public ?string $size        = null
    ) {
        $this->parentColor = $color;
        $this->parentSize  = $size;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div>
            {{ $slot }}
        </div>
        HTML;
    }
}
