<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Dropdown extends Component
{
    public function __construct(
        public ?string $id = null,
        public ?bool   $hover = null,
        public ?string $align = null,
        public ?string $direction = null,
        public ?string $anchor = null,
        public string $zIndex = 'z-999',
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = uniqid();
        $this->hover = $hover !== null;
        $this->anchor = $anchor;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @if (!$anchor)
            <div
                {{ $attributes->merge([
                    'popovertarget' => $anchor ? 'popover-' . $anchor : null
                ])->except('class') }}
                {{ $attributes->except('class')->class([
                    'dropdown [&:not(details,.dropdown-open,.dropdown-hover:hover,:focus-within)>.dropdown-content]:hidden',
                    'dropdown-hover'                    => $hover,
                    'hover:[&>.dropdown-content]:block' => $hover,
                    'dropdown-start'                    => $align === 'start',
                    'dropdown-center'                   => $align === 'center',
                    'dropdown-end'                      => $align === 'end',
                    'dropdown-top'                      => $direction === 'top',
                    'dropdown-bottom'                   => $direction === 'bottom',
                    'dropdown-left'                     => $direction === 'left',
                    'dropdown-right'                    => $direction === 'right',
                    'contents'                          => $anchor
                ]) }}
            >
            <div
                {{ $trigger->attributes->class([
                    'focus:pointer-events-none' => !$hover
                ])->merge([
                    'tabindex' => 0
                ]) }}
            >
                {{ $trigger }}
            </div> 
            @else
            <button
                {{ $trigger->attributes->class([
                ])->merge([
                    'popovertarget' => 'popover-' . $anchor
                ]) }}
            >
                {{ $trigger }}
            </button>           
            @endif
            <div
                {{ $attributes->class([
                    $zIndex,
                    'dropdown' => $anchor !== null,
                    'dropdown-content' => $anchor === null
                ])->merge([
                    'tabindex' => -1,
                    'id'       => $anchor ? 'popover-' . $anchor : null,
                    'popover'  => $anchor ? '' : null,
                    'style'    => $anchor ? 'position-anchor:' . $anchor . ';' : null
                ]) }}
            >
                {{ $slot }}
                </div>
            @if (!$anchor)
            </div>
            @endif
        HTML;
    }
}
