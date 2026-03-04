<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class TimelineEvent extends Component
{
    public function __construct(
        public ?bool $first = null,
        public bool $last = false,
        public ?string $color = null
    ) {
    }


                // <hr @class([
                //     'rounded-e-[var(--radius-selector)]' => !$vertical,
                //     'rounded-b-[var(--radius-selector)]' => $vertical,
                // ])/>

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @aware(['eventIndex'])
            <li {{ $attributes }}>
                @if (($first !== null && !$first) || $eventIndex->increment() > 1)
                    <hr/>
                @endif
                {{ $slot }}
                @if ($last !== null && !$last)
                    <hr/>
                @endif
            </li>
        HTML;
    }
}
