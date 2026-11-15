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
            {{ $attributes->class([
                'flex items-center gap-2' => $name
            ])->merge() }}
        >
            @if (gettype($picture) === 'string')
                <img class="avatar h-full object-contain aspect-square rounded-full" src="{{ $picture }}" alt="{{ $name ?? 'Unknown user' }}"/>
            @elseif ($picture)
                @if ($picture->attributes->has('path'))
                    <img {{ $picture->attributes->only(['class'])->class(["avatar h-full rounded-full aspect-square rounded-full"]) }} src="{{ $picture->attributes->get('path') }}" alt="{{ $name ?? 'Unknown user' }}"/>
                @else
                    {{ $picture }}
                @endif
            @elseif (gettype($placeholder) === 'object')
                {{ $placeholder }}
            @elseif ($placeholder)
                <div class="avatar rounded-full aspect-square h-full">
                    <x-icon :name="$placeholder" aria-label="Guest"/>
                </div>
            @else
                <div class="avatar rounded-full aspect-square h-full">
                    <x-icon :name="config('advanced-controls.icon-packages')[config('advanced-controls.icons')]['user']" aria-label="Guest"/>
                </div>
            @endif
            @if (is_object($name))
            <div {{ $name->attributes->class(['overflow-hidden whitespace-nowrap aspect-auto!'])->merge() }}>
                {{ $name }}
            </div>
            @else
            {{ $name ?? $slot }}
            @endif
        </span>
        HTML;
    }
}
