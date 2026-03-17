<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class TextArea extends Component
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
        public ?string $resize      = null,
        public ?string $color       = null,
        public bool    $ghost       = false,
        public ?int    $minlength   = 0,
        public ?int    $maxlength   = 0,
        public bool    $lengthIndicator = false,
    ) {
    }

    public function errorFieldName(): ?string
    {
        return $this->attributes->whereStartsWith('wire:model')->first() ?? $this->attributes['name']?? ''  ;
    }


    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div {{ $attributes->except(['type', 'value', 'required', 'rows', 'accept', 'wire:model'])->class([
            'relative flex flex-col w-full'
            ])->merge()
        }}>
        @if (gettype($title) === 'object')
        <header {{ $title->attributes->class(['font-base text-lg'])->merge() }}>{{ $title }}</header>
        @elseif ($title)
        <header class="font-base text-lg">{{ $title }}</header>
        @endif
        <label
            {{ $attributes->except(['type', 'value', 'required', 'accept', 'wire:model'])->merge() }}
            @class([
                'flex flex-wrap gap-2 items-center w-full'
            ])
            @if (($minlength > 0 || $maxlength > 0) && $lengthIndicator)
                x-data="{ length: 0, minlength: {{ $minlength }}, maxlength: {{ $maxlength }} }"
            @endif
            >

            @if (gettype($icon) === 'string')
                    <x-icon class="h-lh" :name="$icon"/>
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

            <textarea
                {{ $attributes->only(['name', 'value', 'required', 'rows', 'wire:model'])->class([
                    'w-full textarea',
                    'resize-none'                                                                          => $resize === 'none',
                    'resize-y'                                                                             => $resize === 'vertical' || $resize === 'y',
                    'resize-x'                                                                             => $resize === 'horizontal' || $resize === 'x',
                    'resize'                                                                               => $resize === 'both',
                    '!textarea-error'                                                                      => $errors->has($errorFieldName()),
                    'textarea-neutral border-neutral! focus:outline-neutral! focus:shadow-neutral'         => $color === 'neutral',
                    'textarea-primary border-primary! focus:outline-primary! focus:shadow-primary'         => $color === 'primary',
                    'textarea-secondary border-secondary! focus:outline-secondary! focus:shadow-secondary' => $color === 'secondary',
                    'textarea-accent border-accent! focus:outline-accent! focus:shadow-accent'             => $color === 'accent',
                    'textarea-info border-info! focus:outline-info! focus:shadow-info'                     => $color === 'info',
                    'textarea-success border-success! focus:outline-success! focus:shadow-success'         => $color === 'success',
                    'textarea-warning border-warning! focus:outline-warning! focus:shadow-warning'         => $color === 'warning',
                    'textarea-error border-error! focus:outline-error! focus:shadow-error'                 => $color === 'error',
                    'textarea-xs'                                                                          => $size === 'xs',
                    'textarea-sm'                                                                          => $size === 'sm',
                    'textarea-md'                                                                          => $size === 'md',
                    'textarea-lg'                                                                          => $size === 'lg',
                    'textarea-xl'                                                                          => $size === 'xl',
                ])->merge([
                        'placeholder' => $placeholder,
                        'minlength' => $minlength > 0 ? $minlength : null,
                        'maxlength' => $maxlength > 0 ? $maxlength : null,
                ]) }}


                @if(($minlength > 0 || $maxlength > 0) && $lengthIndicator)
                    x-init="$nextTick(() => length = $el.value?.length ?? 0)"
                    x-on:input="length = event.target.value.length"
                @endif
            >{{ $slot }}</textarea>


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

            @if (($minlength > 0 || $maxlength > 0) && $lengthIndicator)
                <div @class([
                    'absolute flex size-6 items-center justify-center v-popper--has-tooltip',
                    'bottom-2 right-2' => $resize !== 'none',
                    'bottom-1 right-1' => $resize === 'none'
                ])>
                    <svg class="absolute right-0 h-full w-full text-gray-200 dark:text-gray-700" viewBox="0 0 100 100" role="presentation">
                        <circle cx="50" cy="50" r="40" fill="none" stroke="currentColor" stroke-width="8"></circle>
                    </svg>
                    <svg class="absolute right-0 h-full w-full -rotate-90" viewBox="0 0 100 100" role="presentation"
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
