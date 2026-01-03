<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Avatar extends Component
{
    public function __construct(
        public mixed $picture  = null,
        public ?string $name   = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <span
            {{ $attributes->class([
            ])->merge() }}
        >
            {{ $name ?? $slot }}
        </span>
        HTML;
    }
}
