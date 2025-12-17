<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Menu extends Component
{

    public function __construct(
        ?string $id = null,
        ?bool $hover = null
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = uniqid();
        $this->hover = $hover !== null;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <ul
                {{ $attributes->class([
                    'menu  [&_ul]:min-w-[calc(100%-.5rem)]'
                ])->merge() }}
            >{{ $slot }}
                </ul>
        HTML;
    }
}
