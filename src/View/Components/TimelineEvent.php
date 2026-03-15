<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class TimelineEvent extends Component
{
    public function __construct(
        public ?string $color     = null,
        public mixed   $icon      = null,
        public mixed   $start     = null,
        public mixed   $end       = null,
        public ?string $size      = null,
        public bool    $swapped   = false,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <li {{ $attributes }}>
                <hr/>
                    
                @if (gettype($icon) === 'object')
                    {{ $icon->withAttributes(['class' => 'timeline-middle']) }}
                @elseif ($icon)
                    <x-icon @class([
                        'timeline-middle',
                        'size-7' => $size === 'xl',
                        'size-6' => $size === 'lg',
                        'size-5' => $size === 'md' || $size === null,
                        'size-4' => $size === 'sm',
                        'size-3' => $size === 'xs',
                        ]) :name="$icon"/>
                @endif

                @if (gettype($start) === 'object')
                    <div {{ $start->attributes->class([
                        'timeline-start' => !$swapped,
                        'timeline-end'   => $swapped,
                        ])->merge() }}>
                    {{ $start }}
                    </div>
                @elseif ($start)
                    <div @class([
                        'timeline-start' => !$swapped,
                        'timeline-end'   => $swapped,
                        ])>{{ $start }}</div>
                @endif
                
                @if (gettype($end) === 'object')
                    <div {{ $end->attributes->class([
                        'timeline-start' => $swapped,
                        'timeline-end'   => !$swapped,
                        ])->merge() }}>
                    {{ $end }}
                    </div>
                @elseif ($end)
                    <div @class([
                        'timeline-start' => $swapped,
                        'timeline-end'   => !$swapped,
                        ])>{{ $end }}</div>
                @endif
                <hr/>
            </li>
        HTML;
    }
}
