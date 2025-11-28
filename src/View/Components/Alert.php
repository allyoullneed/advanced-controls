<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Alert extends Component
{
    public ?string $label = null;
    public function __construct(
        string $href,
        ?string $label
    ) {
        $this->href = $href;
        $this->label = $label;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div class="alert" role="alert">
            @if ($label)
                {{ $label }}
            @endif
            {{ $slot }}
        </div>
        HTML;
    }
}
