<?php

namespace AllYouNeed\AdvancedControls\View\Components;

use Illuminate\View\Component;

class Timeline extends Component
{


    public function __construct(
        public mixed $events     = null,
        public bool  $vertical   = false,
        public bool  $iconsStart = false,
        public bool  $fix        = false,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <ul {{ $attributes->class([
                'timeline [&>li:first-child>hr:first-child]:hidden [&>li:last-child>hr:last-child]:hidden',
                'grid grid-rows-[auto_auto_auto] justify-start *:row-span-full *:grid *:!grid-rows-subgrid' => $fix && !$vertical,
                'timeline-vertical' => $vertical,
                'grid grid-cols-[auto_auto_auto] justify-start gap-x-2 *:items-center *:col-span-full *:!grid-cols-subgrid [&>li>hr]:col-start-2' => $fix &&  $vertical,
                '[&_:is(.timeline-start,.timeline-end)]:mt-1' => $fix && $vertical && $iconsStart,
                'timeline-snap-icon' => $iconsStart
                ])->merge()
            }}>
            {{ $slot }}
        </ul>
        HTML;
    }
}
