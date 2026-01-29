<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Stack extends Component
{
    public function __construct(
        public ?string $label      = null,
        public ?string $variant    = null,
        public ?string $size       = null,
        public ?string $color      = null,
        public ?string $icon       = null,
        public ?string $trailIcon  = null,
        public bool    $noSpinner  = false,
        public bool    $spinnerEnd = false,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div {{ $attributes->class(['w-full'])->merge() }}
        >   
            {{ $slot }}
        </div>
        HTML;
    }
}
