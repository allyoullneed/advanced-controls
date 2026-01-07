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
                'w-max flex gap-2 items-center'
            ])->merge() }}
        >
            @if (gettype($picture) === 'string')
                <img class="h-lh aspect-square" :src="$picture"/>
            @else
                {{ $picture }}
            @endif
            {{ $name ?? $slot }}
        </span>
        HTML;
    }
}
