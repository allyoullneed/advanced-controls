<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Link extends Component
{
    public string $href;
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
        <a href="{{ $href }}" class="link">
            @if ($label)
                Coinx {{ $label }}
            @else
                Coinx {{ $slot }}
            @endif
        </a>
        HTML;
    }
}
