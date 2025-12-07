<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Menu extends Component
{
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
            <ul
                {{ $attributes->class([
                    'menu w-full text-nowrap whitespace-nowrap'
                ])->merge() }}
            >
                {{ $slot }}
                </ul>
        HTML;
    }
}
