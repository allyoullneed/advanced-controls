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
        @aware(['id'])
        <label class="tab">
            <input type="radio" name="{{ $id }}"/>
            @if ($icon)
                <x-icon :name="$icon" class="size-4 me-2"/>
            @endif
            {{ $label }}
        </label>
        <div 
            {{ $attributes->class([
                'tab-content p-2 md:p-6'
            ])->merge() }}
        >
            {{ $slot }}
        </div>

        HTML;
    }
}
