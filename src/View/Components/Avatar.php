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
            {{ $attributes->except(['class'])->class([
                'avatar flex justify-start items-center gap-2'
            ])->merge() }}
        >
            <div {{ $attributes->only(['class'])->class(["rounded-full aspect-square"]) }}>
                @if (gettype($picture) === 'string')
                    <img class="object-contain aspect-square rounded-full" src="{{ $picture }}"/>
                @elseif ($picture)
                    {{ $picture }}
                @else
                    <x-icon name="heroicon-s-user" class="mt-2"/>
                @endif
            </div>
            {{ $name ?? $slot }}
        </span>
        HTML;
    }
}
