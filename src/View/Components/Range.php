<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Range extends Component
{
    public function __construct(
        public mixed    $title          = null,
        public int      $value          = 0,
        public int      $min            = 0,
        public int      $max            = 100,
        public int      $step           = 1,
        public mixed    $label          = null,
        public mixed    $append         = null,
        public ?string  $placeholder    = null,
        public mixed    $helper         = null,
        public ?string  $error          = null,
        public mixed    $icon           = null,
        public mixed    $trailIcon      = null, 
        public ?string  $size           = null,
        public ?string  $color          = null,
        public bool|int $showSteps      = false,
        public bool|int $minor = false,
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

            @if ($showSteps)
            @php
                if (gettype($showSteps) === 'boolean')
                    $showSteps = $step;
                if ($minor) {
                    if (gettype($minor) === 'boolean') {
                        $minor = $showSteps;
                        $showSteps = 2 * $showSteps;
                    }
                }
                else
                    $minor = $showSteps;
                $s = $min + $showSteps;
            @endphp
            <div @class([
                        'w-full flex flex-col items-stretch gap-1',
                        'range-xs'        => $size === 'xs',
                        'range-sm'        => $size === 'sm',
                        'range-md'        => $size !== 'xl' && $size !== 'lg' && $size !== 'sm' && $size !== 'xs',
                        'range-lg'        => $size === 'lg',
                        'range-xl'        => $size === 'xl',
                    ])>
                <input
                    {{ $attributes->only(['name', 'value', 'required', 'autocomplete'])->merge([
                        'type' => 'range',
                        'min'  => $min,
                        'max'  => $max,
                        'step' => $step,
                        'value' => $value,
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
                <div 
                    class="relative flex justify-between *:flex *:flex-col *:items-center *: *:h-[calc(.5rem+1lh)]"
                    @style([
                        'margin-inline: calc(var(--range-thumb-size) / 2)'
                    ])
                >
                <div class="relative">
                    <div class="w-px h-2 bg-base-content"></div>
                    <span class="absolute top-2">{{ $min }}</span>
                </div>
                @for ($m = $min + $minor; $m < $max; $m += $minor)
                    @if ($m == $s)
                        <div class="absolute" style="left: {{ 100 * ($m - $min) / ($max - $min) }}%">
                            <div class="w-px h-2 bg-base-content"></div>
                            <span class="absolute top-2">{{ $m }}</span>
                        </div>
                        @php
                            $s += $showSteps;
                        @endphp
                    @else
                        @if ($m > $s)
                            <div class="absolute" style="left: {{ 100 * ($s - $min) / ($max - $min) }}%">
                                <div class="w-px h-2 bg-base-content"></div>
                                <span class="absolute top-2">{{ $s }}</span>
                            </div>
                            @php
                                $s += $showSteps;
                            @endphp
                        @endif
                        <div class="absolute opacity-50" style="left: {{ 100 * ($m - $min) / ($max - $min) }}%">
                            <div class="w-px h-2 bg-base-content"></div>
                            <span class="absolute top-2 text-xs">{{ $m }}</span>
                        </div>
                    @endif
                @endfor
                <div class="relative">
                    <div class="w-px h-2 bg-base-content"></div>
                    <span class="absolute top-2">{{ $max }}</span>
                </div>
                </div>
            </div>
            @else
            <input
                {{ $attributes->only(['name', 'value', 'required', 'autocomplete'])->merge([
                        'type' => 'range',
                        'min'  => $min,
                        'max'  => $max,
                        'step' => $step,
                        'value' => $value,
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
            @endif

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
                    'helper-text text-left text-sm text-gray-500',
                ])->merge()
            }}>{{ $helper }}</span>
        @elseif ($helper)
            <span class="helper-text text-left text-sm text-gray-500">{{ $helper }}</span>
        @endif
        
        @error($attributes->whereStartsWith('wire:model')->first())
            <x-badge class="mt-1 order-last h-[unset]" type="error" size="sm">{{ $message }}</span></x-badge>
        @enderror
        @if ($error)
            <x-badge class="mt-1 order-last h-[unset]" type="error" size="sm"><span class="block truncate">{{ $error }}</span></x-badge>
        @endif

        </div>
        HTML;
    }
}
