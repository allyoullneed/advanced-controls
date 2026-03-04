<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

use AllYouNeed\AdvancedControls\ComponentIndex;

class Timeline extends Component
{
    public ComponentIndex $eventIndex;

    public function __construct(
        public mixed $events,
        public bool $vertical = false,
    ) {
        $this->eventIndex = new ComponentIndex();
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <ul {{ $attributes->class([
                'timeline',
                'timeline-vertical' => $vertical
                ])->merge()
            }}>
            {{ $slot }}
        </ul>
        HTML;
    }
}
