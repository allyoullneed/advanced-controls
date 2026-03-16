<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(
        public ?string $label   = null,
        public mixed   $icon    = null,
        public ?string $color   = null,
        public ?string $type    = null,
        public ?string $variant = null,
        public ?string $size    = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div
            {{ $attributes->class([
                'badge select-none cursor-default max-w-full',
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
                    <x-icon :name="$icon" class="h-lh"/>
                @elseif ($icon)
                    <div
                        {{ $icon->attributes->merge() }}
                    >
                    {{ $icon }}
                    </div>
                @endif
            @elseif ($type === 'success')
                <x-icon name="heroicon-o-check-circle" class="shrink-0 h-lh"/>
            @elseif ($type === 'warning')
                <x-icon name="heroicon-o-exclamation-triangle" class="shrink-0 h-lh"/>
            @elseif ($type === 'error')
                <x-icon name="heroicon-o-x-circle" class="shrink-0 h-lh"/>
            @elseif (($type === "" || $type === "info") && $icon === null)
                <x-icon name="heroicon-o-information-circle" class="shrink-0 h-lh"/>
            @endif
            @if (gettype($label ?? $slot) === 'object')
                {{ $label ?? $slot }}
            @else
                <div class="whitespace-nowrap overflow-hidden text-ellipsis">
                {{ $label ?? $slot }}
                </div>
            @endif
        </div>
        HTML;
    }
}
