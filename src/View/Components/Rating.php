<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use AllYoullNeed\AdvancedControls\ComponentIndex;

use Illuminate\View\Component;

class Rating extends Component
{
    public string $id;
    public string $name;
    public ?string                $size;
    public object|int|string|null $starIndex;

    public function __construct(
        ?string $id = null,
        ?string $name = null,
        public mixed                    $title     = null,
        public mixed                    $label     = null,
        public mixed                    $append    = null,
        public mixed                    $icon      = null,
        public mixed                    $trailIcon = null,
        public int                      $maxValue  = 5,
        public int                      $value     = 0,
               ?string                  $size      = null,
        public array|object|string|null $svg       = null,
        public bool|string              $mask      = false,
        public mixed                    $helper    = null,
        public ?string                  $error     = null,
        public ?string                  $color     = null,
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = 'rating-' . uniqid();
        $this->name = $name ?? $this->id;
        $this->size = $size;
        $this->starIndex = new ComponentIndex();
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

            <div
                {{ $attributes->except(['name'])->whereDoesntStartWith(['wire:model'])->class([
                    '[&_input]:opacity-20 [&_input:checked]:opacity-100 [&_input:has(~input:checked)]:opacity-100',
                    '[&_label]:opacity-20 [&_label:has(~label>input:checked)]:opacity-100 [&_label:has(input:checked)]:opacity-100',
                    'flex flex-row items-center' => !$mask,
                    'rating' => $mask,
                    'rating-xl' => $size === 'xl',
                    'rating-lg' => $size === 'lg',
                    'rating-md' => $size === 'md',
                    'rating-sm' => $size === 'sm',
                    'rating-xs' => $size === 'xs'
                ])->merge() }}>
                @if ($mask)
                    @for ($i = 1; $i <= $maxValue; $i++)
                        <input type="radio"
                        name="{{ $id }}"
                        value="{{ $i }}"
                        @checked($value === $i)
                        {{ $attributes->whereStartsWith('wire:') }}
                        {{ $attributes->only([
                            'class', 'name'
                            ])->class([
                                'mask star',
                                'bg-orange-400'   => $color === null,
                                'bg-neutral'      => $color === 'neutral',
                                'bg-primary'      => $color === 'primary',
                                'bg-secondary'    => $color === 'secondary',
                                'bg-accent'       => $color === 'accent',
                                'bg-info'         => $color === 'info',
                                'bg-success'      => $color === 'success',
                                'bg-warning'      => $color === 'warning',
                                'bg-error'        => $color === 'error',
                                'mask-decagon'    => $mask === 'decagon',
                                'mask-diamond'    => $mask === 'diamond',
                                'mask-heart'      => $mask === 'heart',
                                'mask-hexagon'    => $mask === 'hexagon',
                                'mask-hexagon-2'  => $mask === 'hexagon-2',
                                'mask-pentagon'   => $mask === 'pentagon',
                                'mask-star'       => $mask === 'start',
                                'mask-star-2'     => $mask === 'star-2' || gettype($mask) !== 'string',
                                'mask-squircle'   => $mask === 'squircle',
                                'mask-triangle'   => $mask === 'triangle',
                                'mask-triangle-2' => $mask === 'triangle-2',
                                'mask-triangle-3' => $mask === 'triangle-3',
                                'mask-triangle-4' => $mask === 'triangle-4',
                            ])->merge()}}
                        @style([
                            "background-color: " . $color => $color && !in_array($color, ['neutral', 'primary', 'secondary', 'accent', 'info', 'success', 'warning', 'error'])
                        ])
                        name="{{ $attributes['name'] ?? $id }}"
                        aria-label="{{ $i }} star{{ $i != 1 ? 's' : '' }}" />
                    @endfor
                @elseif ($slot->isNotEmpty())
                    {{ $slot }}
                @else
                    <div @class([
                        'flex flex-row items-center',
                    ])>
                        @if ($icon)
                            @if (gettype($icon) === 'string')
                                <div class="flex h-lh order-last">
                                    <x-icon :name="$icon"/>
                                </div>
                            @elseif (gettype($icon) === 'object')
                                <div {{ $icon->attributes->class(['flex order-last']) }}>
                                    {{ $icon }}
                                </div>
                            @endif
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
                        @else
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
                        @for ($i = 1; $i <= $maxValue; $i++)
                        <label for="{{ $id }}-{{ $i }}" @class([
                            'transition cursor-pointer hover:scale-125',
                            ])
                            @class([
                                'text-neutral'      => $color === 'neutral',
                                'text-primary'      => $color === 'primary',
                                'text-secondary'    => $color === 'secondary',
                                'text-accent'       => $color === 'accent',
                                'text-info'         => $color === 'info',
                                'text-success'      => $color === 'success',
                                'text-warning'      => $color === 'warning',
                                'text-error'        => $color === 'error'
                            ])
                            @style([
                                "color: " . $color => $color && !in_array($color, ['neutral', 'primary', 'secondary', 'accent', 'info', 'success', 'warning', 'error'])
                            ])
                            >
                            <input
                                id="{{ $id }}-{{ $i }}"
                                type="radio"
                                class="sr-only"
                                value="{{ $i }}"
                                @checked($value === $i)
                                name="{{ $attributes['name'] ?? $id }}"
                                aria-label="{{ $i }} star{{ $i != 1 ? 's' : '' }}"
                                {{ $attributes->whereStartsWith('wire:') }} />

                            @if (gettype($svg) === 'object')
                                {!! $svg !!}
                            @elseif (gettype($svg) === 'array')
                                @php
                                    $star = $svg[($i - 1) % count($svg)]
                                @endphp
                                @if (gettype($star) === 'object')
                                    {!! $star !!}
                                @elseif (gettype($star) === 'string')
                                    <x-icon
                                        name="{{ $star }}"
                                        @class([
                                            'size-8' => $size === 'xl',
                                            'size-7' => $size === 'lg',
                                            'size-6' => $size === 'md' || $size === null,
                                            'size-5' => $size === 'sm',
                                            'size-4' => $size === 'xs',
                                        ]) />
                                @else
                                    <x-icon @class([
                                        'size-8' => $size === 'xl',
                                        'size-7' => $size === 'lg',
                                        'size-6' => $size === 'md' || $size === null,
                                        'size-5' => $size === 'sm',
                                        'size-4' => $size === 'xs',
                                        'text-neutral'      => $color === 'neutral',
                                        'text-primary'      => $color === 'primary',
                                        'text-secondary'    => $color === 'secondary',
                                        'text-accent'       => $color === 'accent',
                                        'text-info'         => $color === 'info',
                                        'text-success'      => $color === 'success',
                                        'text-warning'      => $color === 'warning',
                                        'text-error'        => $color === 'error'
                                    ]) name="heroicon-s-star"/>
                                @endif
                            @elseif (gettype($svg) === 'string')
                                <x-icon
                                    name="{{ $svg }}"
                                    @class([
                                        'size-8' => $size === 'xl',
                                        'size-7' => $size === 'lg',
                                        'size-6' => $size === 'md' || $size === null,
                                        'size-5' => $size === 'sm',
                                        'size-4' => $size === 'xs',
                                        'text-neutral'      => $color === 'neutral',
                                        'text-primary'      => $color === 'primary',
                                        'text-secondary'    => $color === 'secondary',
                                        'text-accent'       => $color === 'accent',
                                        'text-info'         => $color === 'info',
                                        'text-success'      => $color === 'success',
                                        'text-warning'      => $color === 'warning',
                                        'text-error'        => $color === 'error'
                                    ]) />
                            @else
                                <x-icon @class([
                                    'size-8' => $size === 'xl',
                                    'size-7' => $size === 'lg',
                                    'size-6' => $size === 'md' || $size === null,
                                    'size-5' => $size === 'sm',
                                    'size-4' => $size === 'xs',
                                    'text-neutral'      => $color === 'neutral',
                                    'text-primary'      => $color === 'primary',
                                    'text-secondary'    => $color === 'secondary',
                                    'text-accent'       => $color === 'accent',
                                    'text-info'         => $color === 'info',
                                    'text-success'      => $color === 'success',
                                    'text-warning'      => $color === 'warning',
                                    'text-error'        => $color === 'error'
                                ]) name="heroicon-s-star"/>
                            @endif
                        </label>
                        @endfor
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

                        @if (gettype($append) === 'object')
                            <div {{ $append->attributes->class([
                                'label-text basis-[max-content] whitespace-nowrap overflow-x-hidden text-ellipsis order-first',
                                'text-xs' => $size === 'xs',
                                'text-sm' => $size === 'sm',
                                'text-lg' => $size === 'lg',
                                'text-xl' => $size === 'xl',
                                ]) }}>
                                {{ $append }}
                            </div>
                        @else
                            <div
                                @class([
                                    'label-text basis-[max-content] whitespace-nowrap overflow-x-hidden text-ellipsis',          
                                    'text-xs' => $size === 'xs',
                                    'text-sm' => $size === 'sm',
                                    'text-lg' => $size === 'lg',
                                    'text-xl' => $size === 'xl',
                                ])
                            >
                                {{ $append }}
                            </div>
                        @endif
                    </div>

                @endif
            </div>

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
