<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class SelectOption extends Component
{
    public string $text;
    public function __construct(
              ?string $text = null,
        public string $value,
        public mixed  $icon = null,

    ) {
        $this->text = $text ?? $value;
    }
    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <span data-role="option" class="flex gap-1 items-center" data-value="{{ $value }}">
            @if (is_object($icon))
                {{ $icon }}
            @elseif ($icon)
                <img src="{{ $icon }}" class="h-lh aspect-square"/>
            @endif
            {{ $text }}
        </span>
        HTML;
    }
}
