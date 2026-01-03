<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $color = null,
        public ?string $type  = null,
        public ?string $variant = null,
        public ?string $size  = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div
            {{ $attributes->class([
                'badge select-none cursor-default',
                'badge-neutral'   => ($type ?? $color) === 'neutral',
                'badge-primary'   => ($type ?? $color) === 'primary',
                'badge-secondary' => ($type ?? $color) === 'secondary',
                'badge-accent'    => ($type ?? $color) === 'accent',
                'badge-info'      => ($type ?? $color) === 'info',
                'badge-success'   => ($type ?? $color) === 'success',
                'badge-warning'   => ($type ?? $color) === 'warning',
                'badge-error'     => ($type ?? $color) === 'error',
                'badge-soft'      => $variant === 'soft',
                'badge-outline'   => $variant === 'outline',
                'badge-dash badge-outline border-dashed' => $variant === 'dash',
                'badge-xl'    => $size === 'xl',
                'badge-lg'    => $size === 'lg',
                'badge-md'    => $size === 'md',
                'badge-sm'    => $size === 'sm',
                'badge-xs'    => $size === 'xs',
                ])->merge() }}
        >
            @if (isset($icon) && $icon !== "")
                @if (gettype($icon) === 'string')
                    <x-icon :name="$icon" class="mb-4 shrink-0 size-6"/>
                @else
                    <div
                        {{ $icon->attributes->merge(['class' => 'mb-4']) }}
                    >
                    {{ $icon }}
                    </div>
                @endif
            @elseif ($type === 'success')
                <x-icon name="heroicon-o-check-circle" class="mb-4 shrink-0 size-6"/>
            @elseif ($type === 'warning')
                <x-icon name="heroicon-o-exclamation-triangle" class="mb-4 shrink-0 size-6"/>
            @elseif ($type === 'error')
                <x-icon name="heroicon-o-x-circle" class="mb-4 shrink-0 size-6"/>
            @elseif (($type === "" || $type === "info") && $icon === null)
                <x-icon name="heroicon-o-information-circle" class="mb-4 shrink-0 size-6"/>
            @endif
            {{ $label ?? $slot }}
        </div>
        HTML;
    }
}
