<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Row extends Component
{
    public ?string $label = null;
    public function __construct(
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div {{ $attributes }}>
            {{ $slot }}
        </div>
        HTML;
    }
}
