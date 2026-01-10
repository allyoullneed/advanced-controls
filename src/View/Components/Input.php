<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Input extends Component
{
    public function __construct(
        public mixed   $title       = null,
        public mixed   $label       = null,
        public mixed   $append      = null,
        public ?string $placeholder = null,
        public mixed   $error       = null,
        public mixed   $helper      = null,
        public mixed   $icon        = null,
        public mixed   $trailIcon   = null,
        public string  $type        = 'text',
        public ?string $size        = null,
        public ?string $color       = null,
        public bool    $ghost       = false,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div {{ $attributes->except(['type', 'value', 'required', 'maxlength', 'accept'])->class([
            'flex flex-col w-full'
            ])->merge()
        }}>
        @if ($title)
        <header class="font-base text-lg">{{ $title }}</header>
        @endif
        <label
            {{ $attributes->except(['type', 'value', 'required', 'maxlength', 'accept'])
                ->class([
                    'flex gap-2 items-center w-full whitespace-nowrap',
                    'input'                                               => $type  !== 'file',
                    'input-primary border-primary outline-primary!'       => $type  !== 'file' && $color === 'primary',
                    'input-secondary border-secondary outline-secondary!' => $type  !== 'file' && $color === 'secondary',
                    'input-accent border-accent outline-accent!'          => $type  !== 'file' && $color === 'accent',
                    'input-info border-info outline-info!'                => $type  !== 'file' && $color === 'info',
                    'input-success border-success outline-success!'       => $type  !== 'file' && $color === 'success',
                    'input-warning border-warning outline-warning!'       => $type  !== 'file' && $color === 'warning',
                    'input-error border-error outline-error!'             => $type  !== 'file' && $color === 'error',
                    'input-xs'                                            => $type  !== 'file' && $size === 'xs',
                    'input-sm'                                            => $type  !== 'file' && $size === 'sm',
                    'input-md'                                            => $type  !== 'file' && $size !== 'xs' && $size !== 'sm' && $size !== 'lg' && $size !== 'xl',
                    'input-lg'                                            => $type  !== 'file' && $size === 'lg',
                    'input-xl'                                            => $type  !== 'file' && $size === 'xl',
                    'input-ghost'     => $ghost,
                ])
                ->merge([   
                ])
            }}>

            @if (gettype($icon) === 'string')
                <div class="flex h-lh">
                    <x-icon :name="$icon"/>
                </div>
            @endif

            @if (gettype($label) === 'string')
                <div 
                    @class([
                        'label-text basis-[max-content] shrink whitespace-nowrap overflow-x-hidden text-ellipsis',
                        'text-xs' => $size === 'xs',
                        'text-sm' => $size === 'sm',
                        'text-lg' => $size === 'lg',
                        'text-xl' => $size === 'xl',
                    ])
                >
                    {{ $label }}
                </div>
            @endif

            <input
                {{ $attributes->only(['accept', 'value', 'required', 'maxlength'])->merge([
                        'type' => $type,
                        'placeholder' => $placeholder,
                ]) }}
                @class([
                    'peer basis-1/4 grow',
                    'input file-input px-0 border rounded-sm inline-flex items-center'                                                    => $type  === 'file',
                    'border-[color-mix(in_oklab,oklch(20%_.0132_233.32)_40%,#0000)]'                                                      => $type  === 'file' && $color !== 'primary' && $color !== 'secondary' && $color !== 'accent' && $color !== 'info' && $color !== 'success' && $color !== 'warning' && $color !== 'error',
                    'input-primary file:rounded-none file:bg-primary file:text-primary-content border-primary outline-primary!'           => $type  === 'file' && $color === 'primary',
                    'input-secondary file:rounded-none file:bg-secondary file:text-secondary-content border-secondary outline-secondary!' => $type  === 'file' && $color === 'secondary',
                    'input-accent file:rounded-none file:bg-accent file:text-accent-content border-accent outline-accent!'                => $type  === 'file' && $color === 'accent',
                    'input-info file:rounded-none file:bg-info file:text-info-content border-info outline-info!'                          => $type  === 'file' && $color === 'info',
                    'input-success file:rounded-none file:bg-success file:text-success-content border-success outline-success!'           => $type  === 'file' && $color === 'success',
                    'input-warning file:rounded-none file:bg-warning file:text-warning-content border-warning outline-warning!'           => $type  === 'file' && $color === 'warning',
                    'input-error file:rounded-none file:bg-error file:text-error-content border-error outline-error!'                     => $type  === 'file' && $color === 'error',
                    'input-xs'                                                                                                            => $type  === 'file' && $size === 'xs',
                    'input-sm'                                                                                                            => $type  === 'file' && $size === 'sm',
                    'input-md'                                                                                                            => $type  === 'file' && $size !== 'xs' && $size !== 'sm' && $size !== 'lg' && $size !== 'xl',
                    'input-lg'                                                                                                            => $type  === 'file' && $size === 'lg',
                    'input-xl'                                                                                                            => $type  === 'file' && $size === 'xl',
                ])
            />

            @if (gettype($icon) === 'object')  
                <div {{ $icon->attributes->class(['flex order-first']) }}>
                    {{ $icon }}
                </div>
            @endif

            @if (gettype($label) === 'object')
                <div {{ $label->attributes->class([
                    'label-text basis-[max-content] basis-[max-content] shrink whitespace-nowrap overflow-x-hidden text-ellipsis order-first',                
                    'text-xs' => $size === 'xs',
                    'text-sm' => $size === 'sm',
                    'text-lg' => $size === 'lg',
                    'text-xl' => $size === 'xl',
                    ]) }}>
                    {{ $label }}
                </div>
            @endif

            @if ($append)
                <div {{
                    (gettype($append) === 'object' ? $append->attributes : $attributes)->class([
                    'label-text basis-[max-content] basis-[max-content] shrink whitespace-nowrap overflow-x-hidden text-ellipsis',
                    'text-xs' => $size === 'xs',
                    'text-sm' => $size === 'sm',
                    'text-lg' => $size === 'lg',
                    'text-xl' => $size === 'xl',
                    ])
                }}>
                    {{ $append }}
                </div>
            @endif

            @if ($trailIcon)
                @if (gettype($trailIcon) === 'string')
                    <div class="flex h-lh order-last">
                        <x-icon :name="$trailIcon"/>
                    </div>
                @elseif (gettype($trailIcon) === 'object')  
                    <div {{ $trailIcon->attributes->class(['flex order-last']) }}>
                        {{ $trailIcon }}
                    </div>
                @endif
            @endif
            
            {{ $slot }}

        </label>

        @if (gettype($helper) === 'object')
        <span {{
            $helper->attributes->class([
                'helper-text text-sm text-gray-500',
            ])->merge()
        }}>{{ $helper }}</span>
        @elseif ($helper)
        <span class="helper-text text-sm text-gray-500">{{ $helper }}</span>
        @endif
        @if ($error)
        <span {{
            $helper->attributes->class([
                'helper-text text-error text-sm text-gray-500',
            ])->merge()
        }}>{{ $error }}</span>
        @endif
        </div>
        HTML;
    }
}
