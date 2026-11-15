<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Badge extends Component
{
public ?string $color   = null;
    public function __construct(
        public ?string $label   = null,
        public mixed   $icon    = null,
        ?string $color   = null,
        public ?string $type    = null,
        public ?string $variant = null,
        public ?string $size    = null,
    ) { 
        $this->color = $color;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @aware(['parentColor'])
        <div
            {{ $attributes->class([
                'badge',
                'badge-neutral'   => ($type ?? $color ?? $parentColor) === 'neutral',
                'badge-primary'   => ($type ?? $color ?? $parentColor) === 'primary',
                'badge-secondary' => ($type ?? $color ?? $parentColor) === 'secondary',
                'badge-accent'    => ($type ?? $color ?? $parentColor) === 'accent',
                'badge-info'      => ($type ?? $color ?? $parentColor) === 'info',
                'badge-success'   => ($type ?? $color ?? $parentColor) === 'success',
                'badge-warning'   => ($type ?? $color ?? $parentColor) === 'warning',
                'badge-error'     => ($type ?? $color ?? $parentColor) === 'error',
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
                        {{ $icon->attributes->class(["shrink-0 aspect-square h-lh"])->merge() }}
                    >
                    {{ $icon }}
                    </div>
                @endif
            @elseif ($type === 'info' || $type === 'success' || $type === 'warning' || $type === 'error')
                <x-icon :name="config('advanced-controls.icon-packages')[config('advanced-controls.icons')][$type]" class="shrink-0 h-lh"/>    
            @elseif ($type === "" && $icon === null)
                <x-icon :name="config('advanced-controls.icon-packages')[config('advanced-controls.icons')]['info']" class="shrink-0 h-lh"/>
            @endif
                {{ $label ?? $slot }}
        </div>
        HTML;
    }
}
