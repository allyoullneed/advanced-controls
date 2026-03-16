<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Loading extends Component
{
    public function __construct(
        public string $variant = 'spinner',
        public ?string $color  = null,
        public ?string $size   = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <span {{ 
            $attributes->class([
                'loading',
                'loading-spinner'  => $variant === 'spinner',
                'loading-dots'     => $variant === 'dots',
                'loading-ring'     => $variant === 'ring',
                'loading-ball'     => $variant === 'ball',
                'loading-bars'     => $variant === 'bars',
                'loading-infinity' => $variant === 'infinity',
                'text-primary'     => $color === 'primary',
                'text-secondary'   => $color === 'secondary',
                'text-accent'      => $color === 'accent',
                'text-neutral'     => $color === 'neutral',
                'text-info'        => $color === 'info',
                'text-success'     => $color === 'success',
                'text-warning'     => $color === 'warning',
                'text-error'       => $color === 'error',
                'loading-xl'       => $size === 'xl',
                'loading-lg'       => $size === 'lg',
                'loading-md'       => $size === 'md',
                'loading-sm'       => $size === 'sm',
                'loading-xs'       => $size === 'xs',
            ])->merge() }}>{{ $variant }}</span>
        HTML;
    }
}
