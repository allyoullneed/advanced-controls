<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Dropdown extends Component
{
    public function __construct(
        public ?string $id        = null,
        public ?bool   $hover     = null,
        public ?string $align     = null,
        public ?string $direction = null,
        public ?string $anchor    = null,
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
                id="{{ $id }}"
                {{ $attributes->merge([
                    'popovertarget' => $anchor ? 'popover-' . $anchor : null
                ])->except('class') }}
                {{ $attributes->except('class')->class([
                    'relative dropdown [&:not(details,.dropdown-open,.dropdown-hover:hover,:focus-within)>.dropdown-content]:hidden',
                    'dropdown-hover'                    => $hover,
                    'hover:[&>.dropdown-content]:block' => $hover,
                    'dropdown-start'                    => $align     === 'start',
                    'dropdown-center'                   => $align     === 'center',
                    'dropdown-end'                      => $align     === 'end',
                    'dropdown-top'                      => $direction === 'top',
                    'dropdown-bottom'                   => $direction === 'bottom',
                    'dropdown-left'                     => $direction === 'left',
                    'dropdown-right'                    => $direction === 'right',
                    'contents'                          => $anchor
                ]) }}
                onfocusin="var autofocusElement = this.querySelector('[autofocus]'); if (autofocusElement) autofocusElement.focus({ preventscroll: true })"
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
                    'z-1000 pointer-coarse:fixed pointer-coarse:left-10 pointer-coarse:top-10 pointer-coarse:w-[calc(100vw_-_5rem)]  pointer-coarse:h-[calc(100vh_-_5rem)]',
                    'dropdown'                           => $anchor !== null,
                    'dropdown-content absolute'          => $anchor === null,
                    'inset-e-1/2 translate-x-1/2'        => (!$direction || $direction === 'top' || $direction === 'bottom') && $align     === 'center',
                    'inset-e-0'                          => (!$direction || $direction === 'top' || $direction === 'bottom') && $align     === 'end',
                    'top-auto origin-bottom bottom-full' => $direction === 'top',
                    'inset-e-full'                       => $direction === 'left',
                    'inset-s-full'                       => $direction === 'right',     
                    'bottom-1/2 translate-y-1/2'         => ($direction === 'left' || $direction === 'right') && $align === 'center',
                    'bottom-0'                           => ($direction === 'left' || $direction === 'right') && $align === 'end',
                    'origin-[100%] top-0'                => ($direction === 'left' || $direction === 'right') && (!$align || $align === 'start'),
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
