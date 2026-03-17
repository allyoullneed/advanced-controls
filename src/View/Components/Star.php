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
        @aware(['id', 'name', 'showIndex', 'size'])
        <label for="{{ $id }}-{{ $showIndex->increment() }}" class="transition cursor-pointer hover:scale-125"
            x-bind:class="rating >= {{ $showIndex?->value() }} || 'opacity-20'">
            <input x-model="rating" id="{{ $id }}-{{ $showIndex->value() }}" type="radio" class="sr-only" value="{{ $showIndex->value() }}" name="{{ $name }}" aria-label="{{ $showIndex->value() }} stars">      
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
