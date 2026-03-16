<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public ?string            $label         = null,
        public ?string            $href          = null,
        public ?string            $variant       = null,
        public ?string            $size          = null,
        public ?string            $color         = null,
        public ?string            $icon          = null,
        public ?string            $trailIcon     = null,
        public string|object $loadIndicator = 'spinner',
        public bool               $indicatorEnd  = false,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @if ($href)
            <a
                href="{{ $href }}"
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
        @else
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
                @if (gettype($loadIndicator) === 'object')
                    {{ $loadIndicator->withAttributes(['class' => 'not-in-data-loading:hidden' . ($indicatorEnd ? ' order-last' : '')]) }}
                @elseif (in_array($loadIndicator, ['spinner', 'dots', 'ring', 'ball', 'bars', 'infinity']))
                    <x-loading @class([
                        'not-in-data-loading:hidden',
                        'order-last' => $indicatorEnd
                     ])
                     :variant="$loadIndicator" />
                @elseif ($loadIndicator !== '0')
                    <x-loading @class([
                        'not-in-data-loading:hidden',
                        'order-last' => $indicatorEnd
                        ]) />
                @endif
        @endif
            
            @if(gettype($icon) === 'string')
                <span @class([
                    'w-6 flex justify-center items-center',
                    'in-data-loading:hidden' => $loadIndicator && !$indicatorEnd
                ])
                >
                    <x-icon :name="$icon" />
                </span>
            @elseif ($icon)
                {{ $icon }}
            @endif

            {{ $label ?? $slot }}

            @if(gettype($trailIcon) === 'string')
                <span @class([
                    'w-6',
                    'in-data-loading:hidden' => $loadIndicator && $indicatorEnd
                ])
                >
                    <x-icon :name="$trailIcon" />
                </span>
            @elseif ($trailIcon)
                {{ $trailIcon }}
            @endif

        @if ($href)
            </a>
        @else
            </button>
        @endif
        HTML;
    }
}
