<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Dropdown extends Component
{
    public  string $id;
    public  bool   $hover;
    public ?string $anchor;

    public function __construct(
        ?string $id = null,
        ?bool $hover = null,
        ?string $anchor = null
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
                    'dropdown',
                    'dropdown-hover' => $hover,
                    'contents' => $anchor
                ]) }}
            >
            <div
                {{ $trigger->attributes->class([
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
