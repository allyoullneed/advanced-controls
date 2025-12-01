<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Tabs extends Component
{
    public function __construct(
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div class="tabs tabs-border">
            {{ $slot }}
        </div>

        HTML;
    }
}
