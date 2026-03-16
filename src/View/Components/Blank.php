<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Blank extends Component
{
    public function __construct() { }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        {{ $slot }}
        HTML;
    }
}
