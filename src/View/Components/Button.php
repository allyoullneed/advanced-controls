<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Button extends Component
{
    public ?string $icon = null;
    public function __construct(
        ?string $icon
    ) {
        $this->icon = $icon;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <button
            {{ $attributes->merge(['class' => 'btn']) }}
        >
            <span class="hidden in-data-loading:loading in-data-loading:loading-spinner"></span>
            
            @if($icon)
                <span class="block" @if($spinner) wire:loading.class="hidden" wire:target="{{ $spinnerTarget() }}" @endif>
                    <x-icon :name="$icon" />
                </span>
            @endif

            {{ $slot }}
        </button>
        HTML;
    }
}
