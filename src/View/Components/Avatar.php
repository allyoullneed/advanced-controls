<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Avatar extends Component
{
    public function __construct(
        public mixed $picture       = null,
        public mixed $placeholder   = null,
        public ?string $name        = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <span
            {{ $attributes->except(['class'])->class([
                'avatar flex justify-start items-center ayn-desc:max-h-[5lh]',
                'gap-2' => $name
            ])->merge() }}
        >
            <div {{ $attributes->only(['class'])->class(["rounded-full aspect-square"]) }}>
                @if (gettype($picture) === 'string')
                    <img class="object-contain aspect-square rounded-full" src="{{ $picture }}"/>
                @elseif ($picture)
                    {{ $picture }}
                @elseif (gettype($placeholder) === 'object')
                    {{ $placeholder }}
                @elseif ($placeholder)
                    <x-icon :name="$placeholder"/>
                @else
                    <x-icon name="heroicon-s-user" class="mt-2"/>
                @endif
            </div>
            {{ $name ?? $slot }}
        </span>
        HTML;
    }
}
