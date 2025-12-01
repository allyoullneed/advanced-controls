<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Tab extends Component
{
    public ?string $icon = null;
    public  string $label;
    public function __construct(
        ?string $icon = null,
         string $label
    ) {
        $this->icon = $icon;
        $this->label = $label;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <label class="tab">
            <input type="radio" name="my_tabs_2" />
            @if ($icon)
                <x-icon :name="$icon" class="size-4 me-2"/>
            @endif
            {{ $label }}
        </label>
        <div class="tab-content border-base-300 bg-base-100 p-10">
            {{ $slot }}
        </div>

        HTML;
    }
}
