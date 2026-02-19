<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

use AllYouNeed\AdvancedControls\ComponentIndex;

class Carousel extends Component
{
    public object|int|string|null $showIndex;
    public ComponentAttributeBag  $slideAttributes;

    public function __construct(
        public  mixed $slides       = null,
        public ?int   $count        = null,
        public  float $timePerSlide = 5.,
        public  bool  $indicators   = false,
    ) {
        $this->showIndex = new ComponentIndex();
        $this->slideAttributes = new ComponentAttributeBag(['class' => 'carousel-slide',]);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @php
            if (!$count)
                $count = $showIndex->count();
        @endphp
        <div {{ $attributes->class(['overflow-x-hidden'])->merge() }}>
            <style>
                .carousel > div {
                    animation: sliderotation calc(var(--slides) * var(--time-per-slide)) steps(var(--slides)) infinite,
                                smooth var(--time-per-slide) ease infinite;
                    animation-composition: add;
                    transition: transform;
                }
                .carousel template {
                    display: contents;
                }
                .carousel .carousel-slide {
                    width: calc(100% / var(--slides_per_stop) - 1rem * (var(--slides_per_stop) - 1) / var(--slides_per_stop));
                    flex: none;
                }
                @keyframes smooth {
                    0% { transform: translateX(0) }
                    75% { transform: translateX(0) }
                    100%   { transform: translateX(calc(-1 * (100% + 1rem) / var(--slides_per_stop))) }
                }
                @keyframes sliderotation {
                    from { transform: translateX(0) }
                    to   { transform: translateX(calc(-1 * var(--slides) * (100% + 1rem) / var(--slides_per_stop))) }
                }
            </style>
            <div class="carousel w-full overflow-visible p-0"
                @if ($slides)
                x-data="{
                    slides: {{ json_encode($slides) }}
                }"
                @endif
            >
                <div class="flex w-full flex-row gap-4"
                    @style([
                        '--time-per-slide:' . $timePerSlide . 's',
                        '--slides:' . ($slides ? count($slides) : $count),
                ])>
                    {{ $slot }}
                    {{ $slot }}
                </div>
            </div>
        </div>
        HTML;
    }
}
