<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public mixed   $figure      = null,
        public mixed   $title       = null,
        public mixed   $actions     = null,
        public bool    $horizontal  = false,
        public bool    $separators  = false,
        public ?string $color       = null,
        public ?string $size        = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div {{
            $attributes->class([
                'card border-1',
                'card-side' => $horizontal,
                'border-base-300'  => $color === null,
                'border-neutral'   => $color === 'neutral',
                'border-primary'   => $color === 'primary',
                'border-secondary' => $color === 'secondary',
                'border-accent'    => $color === 'accent',
                'border-info'      => $color === 'info',
                'border-success'   => $color === 'success',
                'border-warning'   => $color === 'warning',
                'border-error'     => $color === 'error',
                'card-xs'          => $size === "xs",
                'card-sm'          => $size === "sm",
                'card-md'          => $size === "md",
                'card-lg'          => $size === "lg",
                'card-xl'          => $size === "xl",
            ])->merge()
        }}> 
            @if ($figure)
            <figure {{
                $figure->attributes->class([
                ])->merge()
            }}>
                {{ $figure }}
            </figure>
            @endif
            <div class="card-body ayn-child:[:where(.card-actions)]:justify-end">
                @if ($title)
                    @if (gettype($title) === 'string')
                        <h2>{{ $title }}</h2>
                    @else
                        <h2 {{ $title->attributes->class(["card-title"])->merge() }}>{{ $title }}</h2>
                    @endif
                    @if ($separators)
                        <hr class="mt-3 border-t-[length:var(--border)] border-base-content/10">
                    @endif
                @endif
                
                <div {{ $slot->attributes->class(['grow-1'])->merge() }}>
                    {{ $slot }}
                </div>
                    
                @if ($actions)
                    @if ($separators)
                        <hr class="mt-3 border-t-[length:var(--border)] border-base-content/10">
                    @endif
                    <div {{ $actions->attributes->class([
                        'card-actions',
                        'ayn-desc:[:where(button.btn)]:btn-neutral ayn-desc:[:where(button.btn)]:text-neutral-content'     => $color === 'neutral',
                        'ayn-desc:[:where(button.btn)]:btn-primary ayn-desc:[:where(button.btn)]:text-primary-content'     => $color === 'primary',
                        'ayn-desc:[:where(button.btn)]:btn-secondary ayn-desc:[:where(button.btn)]:text-secondary-content' => $color === 'secondary',
                        'ayn-desc:[:where(button.btn)]:btn-accent ayn-desc:[:where(button.btn)]:text-accent-content'       => $color === 'accent',
                        'ayn-desc:[:where(button.btn)]:btn-info ayn-desc:[:where(button.btn)]:text-info-content'           => $color === 'info',
                        'ayn-desc:[:where(button.btn)]:btn-success ayn-desc:[:where(button.btn)]:text-success-content'     => $color === 'success',
                        'ayn-desc:[:where(button.btn)]:btn-warning ayn-desc:[:where(button.btn)]:text-warning-content'     => $color === 'warning',
                        'ayn-desc:[:where(button.btn)]:btn-error ayn-desc:[:where(button.btn)]:text-error-content'         => $color === 'error',
                    ])->merge() }}>
                        {{ $actions }}
                    </div>
                @endif
            </div>
        </div>
        HTML;
    }
}
