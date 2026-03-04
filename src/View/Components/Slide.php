<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Slide extends Component
{
    public function __construct(
        public mixed $image = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @aware(['showIndex', 'showCondition', 'slideAttributes'])
        @php
            $index = $showIndex?->increment();
        @endphp
        <div
            {{ $attributes->except(['class'])->class([
                'grid grid-cols-1 items-stretch justify-stretch',
            ])->merge($slideAttributes?->getAttributes() ?? []) }}
            @if ($showCondition)
                x-show="{{ eval($showCondition) }}"
            @endif
        >
            @if (gettype($image) === 'object')
                {{ $image }}
            @elseif ($image)
                <img src="{{ $image }}" alt="" class="object-cover row-start-1 col-start-1"/>
            @endif
            @if ($slot->isnotEmpty())
            <div {{ $attributes->only(['class'])->class(['inset-0 row-start-1 col-start-1']) }}>
                {{ $slot->withAttributes(['class']) }}
            </div>
            @endif
        </div>
        HTML;
    }
}
