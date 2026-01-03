<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public ?string $label   = null,
        public ?string $variant = null,
        public ?string $size    = null,
        public ?string $color   = null,
        public ?string $icon   = null,
        public ?string $trailIcon   = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <button
            {{ $attributes->class([
                'btn',
                'btn-neutral'        => $color === 'neutral',
                'btn-primary'        => $color === 'primary',
                'btn-secondary'      => $color === 'secondary',
                'btn-accent'         => $color === 'accent',
                'btn-info'           => $color === 'info',
                'btn-success'        => $color === 'success',
                'btn-warning'        => $color === 'warning',
                'btn-error'          => $color === 'error',
                'btn-soft'           => $variant === 'soft',
                'btn-outline'        => $variant === 'outline',
                'btn-gradient'       => $variant === 'gradient',
                'btn-ghost btn-text' => $variant === 'ghost',
                'btn-dash btn-outline border-dashed' => $variant === 'dash',
                'btn-xl'             => $size === 'xl',
                'btn-lg'             => $size === 'lg',
                'btn-md'             => $size === 'md',
                'btn-sm'             => $size === 'sm',
                'btn-xs'             => $size === 'xs'
            ])->merge() }}
        >
            <span class="not-in-data-loading:hidden in-data-loading:loading in-data-loading:loading-spinner"></span>
            
            @if(gettype($icon) === 'string')
                <span  class="h-lh aspect-square">
                    <x-icon :name="$icon" />
                </span>
            @elseif ($icon)
                {{ $icon }}
            @endif
            {{ $label ?? $slot }}
            @if(gettype($trailIcon) === 'string')
                <span  class="h-lh aspect-square">
                    <x-icon :name="$trailIcon" />
                </span>
            @elseif ($trailIcon)
                {{ $trailIcon }}
            @endif
        </button>
        HTML;
    }
}
