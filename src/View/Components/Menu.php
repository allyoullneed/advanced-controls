<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Menu extends Component
{

    public function __construct(
        ?string $id = null
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = uniqid();
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <ul
                {{ $attributes->class([
                    'menu' 
                ])->merge() }}
            >   
                {{ $slot }}
            </ul>
        HTML;
    }
}
