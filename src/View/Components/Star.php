<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Star extends Component
{
    public function __construct(
        public ?string $svg = null,
    ) {
    }
    
    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @aware(['id', 'name', 'starIndex', 'size', 'value'])
        <label for="{{ $id }}-{{ $starIndex->increment() }}" class="transition cursor-pointer hover:scale-125">
            <input 
                id="{{ $id }}-{{ $starIndex->value() }}"
                type="radio"
                class="sr-only"
                value="{{ $starIndex->value() }}"
                @checked($value === $starIndex->value())
                name="{{ $name }}"
                aria-label="{{ $starIndex->value() }} stars">

            @if ($svg)
                <x-icon
                    {{ $attributes->class([
                        'size-8' => $size === 'xl',
                        'size-7' => $size === 'lg',
                        'size-6' => $size === 'md' || $size === null,
                        'size-5' => $size === 'sm',
                        'size-4' => $size === 'xs',
                    ])->merge() }}
                    :name="$svg" />
            @else
                {{ $slot }}
            @endif
        </label>
        HTML;
    }
}
