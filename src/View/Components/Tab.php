<?php

namespace AllYouNeed\AdvancedControls\View\Components;

use Illuminate\View\Component;

class Tab extends Component
{
    public function __construct(
        public  string $label,
        public ?string $icon    = null
    ) {
        $this->icon = $icon;
        $this->label = $label;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @aware(['id'])
        <label
            @class([
                'tab has-checked:tab-active'
            ])
        >
            <input class="appearance-none" type="radio" name="{{ $id }}"/>
            @if ($icon)
                <x-icon :name="$icon" class="size-4 me-2"/>
            @endif
            {{ $label }}
        </label>
        <div
            {{ $attributes->class([
                'tab-content w-full order-1'
            ])->merge() }}
        >
            {{ $slot }}
        </div>

        HTML;
    }
}
