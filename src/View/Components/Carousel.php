<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

use AllYoullNeed\AdvancedControls\ComponentIndex;

class Carousel extends Component
{
    public object|int|string|null $slideIndex;
    public ComponentAttributeBag  $slideAttributes;

    public function __construct(
        public  mixed $slides       = null,
        public ?int   $count        = null,
        public  float $timePerSlide = 4,
        public  float $rotationTime = 1,
        public  bool  $indicators   = false,
    ) {
        $this->slideIndex = new ComponentIndex();
        $this->slideAttributes = new ComponentAttributeBag();
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @php
            if (!$count)
                $count = $slideIndex->value();
        @endphp
        <div {{ $attributes->class(['overflow-hidden'])->merge() }}>
            @once
            <style>
                .carousel > div {
                    --unit:     1s;

                    --total: calc(var(--delay) + var(--duration) + var(--transition));
                    --total-duration: calc(var(--total) * var(--unit));

                    --delay-start: calc(var(--delay) / var(--total) * 100%);
                    --transition-start: calc((var(--delay) + var(--transition)) / var(--total) * 100%);
                    
                    --timing: linear(0, 
                        0 var(--delay-start), 
                        1 var(--transition-start), 
                        1);

                    animation: sliderotation calc(var(--slides) * var(--total-duration)) steps(var(--slides)) calc(var(--duration) * var(--unit)) infinite,
                               var(--total-duration) var(--timing) infinite calc(var(--duration) * var(--unit)) smooth;
                    animation-composition: add;
                    transition: transform;
                }
                .carousel template {
                    display: contents;
                }
                .carousel > div > *  {
                    width: calc(100% / var(--slides_per_stop) - 1rem * (var(--slides_per_stop) - 1) / var(--slides_per_stop));
                    flex: none;
                }
                @keyframes smooth {
                    from { transform: translateX(0) }
                    to   { transform: translateX(calc(-1 * (100% + 1rem) / var(--slides_per_stop))) }
                }
                @keyframes sliderotation {
                    from { transform: translateX(0) }
                    to   { transform: translateX(calc(-1 * var(--slides) * (100% + 1rem) / var(--slides_per_stop))) }
                }
            </style>
            @endonce
            <div class="carousel w-full h-full overflow-visible p-0"
                @style([
                    '--slides:' . ($slides ? count($slides) : $count),
                    '--duration: ' . $timePerSlide,
                    '--delay: 0' ,
                    '--transition: '. $rotationTime
                ])
                @if ($slides)
                x-data="{
                    slides: {{ json_encode($slides) }}
                }"
                @endif
            >
                <div class="flex w-full flex-row gap-4 *:object-cover">
                    {{ $slot }}
                    {{ $slot }}
                </div>
            </div>
        </div>
        HTML;
    }
}
