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
            <div class="carousel"
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
                <div>
                    {{ $slot }}
                    {{ $slot }}
                </div>
            </div>
        </div>
        HTML;
    }
}
