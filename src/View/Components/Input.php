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
        public mixed   $helper      = null,
        public ?string $error       = null,
        public mixed   $icon        = null,
        public mixed   $trailIcon   = null,
        public string  $type        = 'text',
        public ?string $size        = null,
        public ?string $color       = null,
        public bool    $ghost       = false,
        public ?int    $minlength   = 0,
        public ?int    $maxlength   = 0,
        public bool    $lengthIndicator = false,
    ) {
    }

    public function errorFieldName(): ?string
    {
        return $this->attributes->whereStartsWith('wire:model')->first() ?? $this->attributes['name'];
    }


    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div {{ $attributes->except([
                    'type', 'value', 'required', 'accept', 'wire:model'
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
                    'type', 'value', 'required', 'accept', 'wire:model'
                ])->whereDoesntStartWith('wire:model')->class([
                    'flex gap-2 items-center w-full whitespace-nowrap',
                    'cursor-pointer'                                      => $type === 'color',
                    'ps-0'                                                => $type  === 'color' && !$label && !$icon,
                    'pe-0'                                                => $type  === 'color' && !$append && !$trailIcon,
                    'input'                                               => $type  !== 'file',
                    '!input-error'                                        => $type  !== 'file' && $errors->has($errorFieldName()),
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
                    'input-ghost'                                         => $ghost,
                ])
                ->merge([   
                ])
            }}
            @if (($minlength > 0 || $maxlength > 0) && $lengthIndicator)
                x-data="{ length: 0, minlength: {{ $minlength }}, maxlength: {{ $maxlength }} }"
            @endif
            >

            @if (gettype($icon) === 'string')
                <div class="flex h-lh">
                    <x-icon :name="$icon"/>
                </div>
            @endif

            @if (gettype($label) === 'string')
                <div 
                    @class([
                        'label-text basis-[max-content] whitespace-nowrap overflow-x-hidden text-ellipsis',
                        'shrink'  => $type !== 'color', 
                        'grow'    => $type === 'color',                        
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
                {{ $attributes->only(['name', 'value', 'required'])->merge([
                        'type' => $type,
                        'placeholder' => $placeholder,
                        'minlength' => $minlength > 0 ? $minlength : null,
                        'maxlength' => $maxlength > 0 ? $maxlength : null,
                ]) }}
                {{ $attributes->whereStartsWith('wire:model') }}
                @class([
                    'peer',
                    'basis-1/4 grow'                                                                                                      => $type !== 'color',
                    'basis-[2lh] shrink'                                                                                                  => $type === 'color',
                    'input file-input px-0 border rounded-sm inline-flex items-center'                                                    => $type  === 'file',
                    '!input-error'                                                                                                        => $type  === 'file' && $errors->has($errorFieldName()),
                    'border-[color-mix(in_oklab,oklch(20%_.0132_233.32)_40%,#0000)]'                                                      => $type  === 'file' && $color === 'neutral',
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
                @if(($minlength > 0 || $maxlength > 0) && $lengthIndicator)
                    x-init="$nextTick(() => length = $el.value?.length ?? 0)"
                    x-on:input="length = event.target.value.length"
                @endif
            />

            @if (gettype($icon) === 'object')  
                <div {{ $icon->attributes->class(['flex order-first']) }}>
                    {{ $icon }}
                </div>
            @endif

            @if (gettype($label) === 'object')
                <div {{ $label->attributes->class([
                    'label-text basis-[max-content] whitespace-nowrap overflow-x-hidden text-ellipsis order-first',
                    'shrink'  => $type !== 'color', 
                    'grow'    => $type === 'color',               
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
                    'shrink'  => $type !== 'color', 
                    'grow'    => $type === 'color',
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

            @if (($minlength > 0 || $maxlength > 0) && $lengthIndicator)
                <div class="relative flex size-6 items-center justify-center v-popper--has-tooltip">
                    <svg class="absolute right-0 h-full w-full text-gray-200 dark:text-gray-700" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="40" fill="none" stroke="currentColor" stroke-width="8"></circle>
                    </svg>
                    <svg class="absolute right-0 h-full w-full -rotate-90" viewBox="0 0 100 100"
                    :class="{
                        'text-green-600':  length / maxlength < .5,
                        'text-amber-400':  length / maxlength >= .5 && length / maxlength < .75,
                        'text-orange-600': length / maxlength >= .75 && length / maxlength < .9,
                        'text-red-600':    length / maxlength >= .9
                    }">
                        <circle cx="50" cy="50" r="40" fill="none" stroke="currentColor" stroke-width="8" stroke-dasharray="251.2"
                            x-bind:stroke-dashoffset="(maxlength - length) / maxlength * 251.2" stroke-linecap="round"
                        ></circle>
                    </svg>
                    <span x-text="minlength > length  ? length - minlength : (maxlength > length ? maxlength - length : null)" class="text-xs absolute"></span>
                </div>
            @endif

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
        
        @error('values.' . $attributes->get('name')) <x-badge class="mt-1 order-last" type="error" size="sm">{{ $message }}</x-badge> @enderror
        @if ($error)
            <x-badge class="mt-1 order-last" type="error" size="sm">{{ $error }}</x-badge>
        @endif

        </div>
        HTML;
    }
}
