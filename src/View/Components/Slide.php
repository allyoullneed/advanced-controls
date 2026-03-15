<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Slide extends Component
{
    public function __construct(
        public mixed $image = null,
        public string $align = '',
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
                'flex ' . $align => strlen($align) > 0,
                'relative'  => !$slideAttributes?->has('noDefaultClass'),
            ])->merge($slideAttributes?->except(['noDefaultClass'])->getAttributes() ?? []) }}
            @if ($showCondition)
                x-show="{{ eval($showCondition) }}"
            @endif
        >
            @if (gettype($image) === 'object')
                {{ $image }}
            @elseif ($image)
                <img src="{{ $image }}" alt="" class="w-full"/>
            @endif
            <div {{ $attributes->only(['class'])->class([
                    'grid grid-cols-1 grid-rows-1 *:row-start-1 *:col-start-1',
                    'absolute top-0 w-full h-full' => $image
                ]) }}>
                {{ $slot }}
            </div>
        </div>
        HTML;
    }
}