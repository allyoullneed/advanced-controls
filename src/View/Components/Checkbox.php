<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Checkbox extends Component
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
            $this->id = 'checkbox-' . uniqid();
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
                    'group grid grid-cols-[auto_auto] items-center gap-1',
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
                    type="checkbox"
                    name="{{ $name }}"
                    value="{{ $value }}"
                    {{ $attributes->except(['type'])->class([
                            'checkbox',
                            'checkbox-neutral'   => ($type ?? $color) == 'neutral',
                            'checkbox-primary'   => ($type ?? $color) == 'primary',
                            'checkbox-secondary' => ($type ?? $color) === 'secondary',
                            'checkbox-accent'    => ($type ?? $color) === 'accent',
                            'checkbox-info'      => ($type ?? $color) === 'info',
                            'checkbox-success'   => ($type ?? $color) === 'success',
                            'checkbox-warning'   => ($type ?? $color) === 'warning',
                            'checkbox-error'     => ($type ?? $color) === 'error',
                            'checkbox-xl'        => $size === 'xl',
                            'checkbox-lg'        => $size === 'lg',
                            'checkbox-md'        => $size === 'md',
                            'checkbox-sm'        => $size === 'sm',
                            'checkbox-xs'        => $size === 'xs',
                            'order-last'         => $must_prepend,
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
                type="checkbox"
                name="{{ $name }}"
                value="{{ $value }}"
                {{ $attributes
                    ->class([
                        'checkbox',
                        'checkbox-neutral'   => ($type ?? $color) == 'neutral',
                        'checkbox-primary'   => ($type ?? $color) == 'primary',
                        'checkbox-secondary' => ($type ?? $color) === 'secondary',
                        'checkbox-accent'    => ($type ?? $color) === 'accent',
                        'checkbox-info'      => ($type ?? $color) === 'info',
                        'checkbox-success'   => ($type ?? $color) === 'success',
                        'checkbox-warning'   => ($type ?? $color) === 'warning',
                        'checkbox-error'     => ($type ?? $color) === 'error',
                        'checkbox-xl'        => $size === 'xl',
                        'checkbox-lg'        => $size === 'lg',
                        'checkbox-md'        => $size === 'md',
                        'checkbox-sm'        => $size === 'sm',
                        'checkbox-xs'        => $size === 'xs',
                    ])
                    ->merge()
                }}
            />
        @endif

        HTML;
    }
}
