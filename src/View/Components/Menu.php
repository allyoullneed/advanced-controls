<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Menu extends Component
{

    public bool $isSubMenu = false;

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
            @aware(['isSubMenu'])
            <ul
                {{ $attributes->class([
                    'menu  [&_ul]:min-w-[calc(100%-.5rem)]'
                ])->merge() }}
            >
                {{ $isSubMenu }} {{ $slot }}
                </ul>
        HTML;
    }
}
