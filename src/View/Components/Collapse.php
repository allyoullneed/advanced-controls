<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Collapse extends Component
{
    public function __construct(
        public mixed $label    = null,
        public bool  $arrow    = false,
        public bool  $plus     = false,
        public bool  $keepOpen = false
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'

        <div 
        @if(!$keepOpen)
        tabindex="0" 
        @endif
        {{
            $attributes->class([
                'collapse',
                'collapse-arrow' => $arrow && !$plus,
                'collapse-plus' => $plus
                ])->merge()
        }}>
        @if ($keepOpen)
        <input type="checkbox" />
        @endif
        <div class="collapse-title font-semibold">{{ $label }}</div>
        <div class="collapse-content text-sm">
            {{ $slot }}
        </div>
        </div>
        HTML;
    }
}
