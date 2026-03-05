<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Range extends Component
{
    public function __construct(
        public mixed   $title       = null,
        public mixed   $label       = null,
        public mixed   $append      = null,
        public ?string $placeholder = null,
        public mixed   $helper      = null,
        public ?string $error       = null,
        public mixed   $icon        = null,
        public mixed   $trailIcon   = null, 
        public ?string $size        = null,
        public ?string $color       = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div {{ $attributes->except([
                    'type', 'value', 'required', 'autocomplete'
                ])->whereDoesntStartWith('wire:model')->class([
            'flex flex-col w-full'
            ])->merge()
        }}>
        @if (gettype($title) === 'object')
        <header {{ $title->attributes->class(['font-base text-lg'])->merge() }}>{{ $title }}</header>
        @elseif ($title)
        <header class="font-base text-lg">{{ $title }}</header>
        @endif
        <label
            {{ $attributes->except([
                    'type', 'value', 'required', 'autocomplete'
                ])->whereDoesntStartWith('wire:model')->class([
                    'flex gap-2 items-center w-full whitespace-nowrap',
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
                        'label-text basis-[max-content] whitespace-nowrap overflow-x-hidden text-ellipsis',  
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
                {{ $attributes->only(['name', 'value', 'required', 'autocomplete'])->merge([
                        'type' => 'range',
                        'placeholder' => $placeholder,
                ]) }}
                {{ $attributes->whereStartsWith('wire:model') }}
                @class([
                    'range peer',
                    'range-primary'   => $color === 'primary',
                    'range-secondary' => $color === 'secondary',
                    'range-accent'    => $color === 'accent',
                    'range-info'      => $color === 'info',
                    'range-success'   => $color === 'success',
                    'range-warning'   => $color === 'warning',
                    'range-error'     => $color === 'error',
                    'range-xs'        => $size === 'xs',
                    'range-sm'        => $size === 'sm',
                    'range-md'        => $size === 'md',
                    'range-lg'        => $size === 'lg',
                    'range-xl'        => $size === 'xl',
                ])
            />

            @if (gettype($icon) === 'object')  
                <div {{ $icon->attributes->class(['flex order-first']) }}>
                    {{ $icon }}
                </div>
            @endif

            @if (gettype($label) === 'object')
                <div {{ $label->attributes->class([
                    'label-text basis-[max-content] whitespace-nowrap overflow-x-hidden text-ellipsis order-first',             
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
                    'label-text basis-[max-content] whitespace-nowrap overflow-x-hidden text-ellipsis',
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
        
        @error($attributes->whereStartsWith('wire:model')->first()) <x-badge class="mt-1 order-last truncate" type="error" size="sm">{{ $message }}</x-badge> @enderror
        @if ($error)
            <x-badge class="mt-1 order-last truncate" type="error" size="sm">{{ $error }}</x-badge>
        @endif

        </div>
        HTML;
    }
}
