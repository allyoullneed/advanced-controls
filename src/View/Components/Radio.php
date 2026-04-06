<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Radio extends Component
{
    public function __construct(
        public ?string $id           = null,
        public ?string $name         = null,
        public ?string $value        = null,
        public mixed   $title        = null,
        public mixed   $label        = null,
        public mixed   $labelBefore  = null,
        public mixed   $labelChecked = null,
        public ?string $color        = null,
        public ?string $size         = null,
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = 'radio-' . uniqid();
    }
    
    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @aware(['parentColor', 'parentSize'])
        @error($attributes->whereStartsWith('wire:model')->first())
            @php
            $color = 'error'
            @endphp
        @enderror
        @php
            if (!$color)
                $color = $parentColor;
            if (!$size)
                $size = $parentSize;

            $must_prepend = $labelBefore !== null;
            if ($label && $must_prepend)
                throw new Exception('Cannot declare a label both before and after the toggle');
            
            if (!isset($label)) 
                $label = $labelBefore;
        @endphp
        @if ($label)
            <div @class([
                    'group grid grid-cols-[auto_auto] items-center gap-x-2 gap-y-1',
                    'justify-between' => $must_prepend,
                    'justify-start'   => !$must_prepend,
                    'text-xl'         => $size === 'xl',
                    'text-lg'         => $size === 'lg',
                    'text-base'       => $size === 'md',
                    'text-sm'         => $size === 'sm',
                    'text-xs'         => $size === 'xs',
                ])
            >
                @if ($title)
                <header class="font-base text-lg col-span-full">{{ $must_prepend }}{{ $title }}</header>
                @endif
                <input id="{{ $id }}"
                    type="radio"
                    name="{{ $name }}"
                    value="{{ $value }}"
                    {{ $attributes->except(['type'])->class([
                            'radio',
                            'radio-neutral'   => ($type ?? $color) == 'neutral',
                            'radio-primary'   => ($type ?? $color) == 'primary',
                            'radio-secondary' => ($type ?? $color) === 'secondary',
                            'radio-accent'    => ($type ?? $color) === 'accent',
                            'radio-info'      => ($type ?? $color) === 'info',
                            'radio-success'   => ($type ?? $color) === 'success',
                            'radio-warning'   => ($type ?? $color) === 'warning',
                            'radio-error'     => ($type ?? $color) === 'error',
                            'radio-xl'        => $size === 'xl',
                            'radio-lg'        => $size === 'lg',
                            'radio-md'        => $size === 'md',
                            'radio-sm'        => $size === 'sm',
                            'radio-xs'        => $size === 'xs',
                            'order-last'      => $must_prepend,
                        ])
                        ->merge()
                    }}
                />
                <label for="{{ $id }}"
                    {{ (gettype($label) === 'object' ? $label->attributes : $attributes)->except('wire:model')->class([
                        'label label-text relative cursor-pointer select-none whitespace-nowrap',
                        'grid grid-cols-1' => $labelChecked,
                    ])->merge() }}
                >
                    @if ($labelChecked)
                        <span @class([
                            'col-start-1 row-start-1 group-has-checked:opacity-0 transition-opacity duration-250',
                            'justify-self-end' => $must_prepend,
                        ])>{{ $label }}</span>
                        <span @class([
                            'col-start-1 row-start-1 group-not-has-checked:opacity-0 transition-opacity duration-250',
                            'justify-self-end' => $must_prepend,
                        ])>{{ $labelChecked }}</span>
                    @else
                        {{ $label }}
                    @endif
                </label>
            </div>
        @else
            <input id="{{ $id }}"
                type="radio"
                name="{{ $name }}"
                value="{{ $value }}"
                {{ $attributes
                    ->class([
                        'radio',
                        'radio-neutral'   => ($type ?? $color) == 'neutral',
                        'radio-primary'   => ($type ?? $color) == 'primary',
                        'radio-secondary' => ($type ?? $color) === 'secondary',
                        'radio-accent'    => ($type ?? $color) === 'accent',
                        'radio-info'      => ($type ?? $color) === 'info',
                        'radio-success'   => ($type ?? $color) === 'success',
                        'radio-warning'   => ($type ?? $color) === 'warning',
                        'radio-error'     => ($type ?? $color) === 'error',
                        'radio-xl'        => $size === 'xl',
                        'radio-lg'        => $size === 'lg',
                        'radio-md'        => $size === 'md',
                        'radio-sm'        => $size === 'sm',
                        'radio-xs'        => $size === 'xs',
                    ])
                    ->merge()
                }}
            />
        @endif

        HTML;
    }
}
