<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

new class extends Component
{
    public ?string $icon = null;
    public function __construct(
        ?string $icon
    ) {
        $this->icon = $icon;
    }

    public function render(): View|Closure|string
    {
        return <<<'BLADE'
        <button
            {{ $attributes->merge(['class' => 'theme-toggle aspect-square']) }}
        >
            <span class="loading loading-spinner"></span>
            
            @if($icon)
                <span class="block" @if($spinner) wire:loading.class="hidden" wire:target="{{ $spinnerTarget() }}" @endif>
                    <x-svg :name="$icon" />
                </span>
            @endif

            {{ $slot }}
        </button>
        BLADE;
    }
}
