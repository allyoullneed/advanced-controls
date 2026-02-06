<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Indicator extends Component
{
    public ?string $indicator = null;

    public function __construct(
        public ?string $label = null,
        public ?string $color = null,
        public ?string $position = null,
        public bool $noIndicator = false,
    ) {
    }

    public function parse_position(?    string $position): array
    {
        $arr_position = [];
        if ($position) {
            $arr_position = explode("-", $position);
           if (count($arr_position) > 2) 
                throw new Exception('In indicator, the position must be a combination of two of the following values: top, bottom, and left, right or start, end.');
            foreach ($arr_position as $pos) {
                if (!in_array($pos, ['top', 'bottom', 'start', 'end', 'left', 'right']))
                    throw new Exception('In indicator, the position must be a combination of two of the following values: top, bottom, and left, right or start, end.');
            }
        }
        return $arr_position;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @renderif ($noIndicator)
            {{ $slot }}
        @else
            @php
                $arr_position = $parse_position($position);
            @endphp
            <div
                {{ $attributes->except(['position', 'size'])->class([
                    'indicator',
                    ])->merge() }}
            >
                @if ($indicator)
                    <div {{ $indicator->attributes->except(['position', 'size'])->class([
                        'flex justify-center items-center indicator-item',
                        'indicator-top'    => in_array('top'   , $arr_position),
                        'indicator-bottom' => in_array('bottom', $arr_position),
                        'indicator-left'   => in_array('left'  , $arr_position),
                        'indicator-right'  => in_array('right' , $arr_position),
                        'indicator-start'  => in_array('start' , $arr_position),
                        'indicator-end'    => in_array('end'   , $arr_position),
                        'indicator-middle' => $arr_position != [] && !in_array('top', $arr_position)   && !in_array('bottom', $arr_position),
                        'indicator-center' => $arr_position != [] && !in_array('start', $arr_position) && !in_array('end', $arr_position),
                    ]) }}
                    class="indicator-item ">
                        {{ $indicator }}
                    </div>
                @else
                    <span 
                        {{ $attributes->except(['position', 'size'])->class([
                            'indicator-item status',
                            'indicator-top'    => in_array('top'   , $arr_position),
                            'indicator-bottom' => in_array('bottom', $arr_position),
                            'indicator-left'   => in_array('left'  , $arr_position),
                            'indicator-right'  => in_array('right' , $arr_position),
                            'indicator-start'  => in_array('start' , $arr_position),
                            'indicator-end'    => in_array('end'   , $arr_position),
                            'indicator-middle' => $arr_position != [] && !in_array('top', $arr_position)   && !in_array('bottom', $arr_position),
                            'indicator-center' => $arr_position != [] && !in_array('start', $arr_position) && !in_array('end', $arr_position),
                            'status-primary'   => $color === 'primary',
                            'status-secondary' => $color === 'secondary',
                            'status-accent'    => $color === 'accent',
                            'status-info'      => $color === 'info',
                            'status-success'   => $color === 'success',
                            'status-warning'   => $color === 'warning',
                            'status-error'     => $color === 'error',
                        ]) }}
                    >
                    </span>
                @endif
                {{ $slot }}
            </div>
        @endrenderif
        HTML;
    }
}
