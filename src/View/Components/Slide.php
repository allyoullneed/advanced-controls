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
            $index = $showIndex?->value();
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
            @else
                <img src="{{ $image }}" alt="" class="row-start-1 col-start-1"/>
            @endif
            <div {{ $attributes->only(['class'])->class(['inset-0 row-start-1 col-start-1 z-1']) }}>
                {{ $slot->withAttributes(['class']) }}
            </div>
        </div>
        HTML;
    }
}
