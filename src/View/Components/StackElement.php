<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class StackElement extends Component
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
        <template {{ $attributes->only(['x-if', 'x-show'])}}>
            <div {{ $attributes->only(['class']) }}>
                {{ $slot }}
            </div>
        </template>
        HTML;
    }
}
