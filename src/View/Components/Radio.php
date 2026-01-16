<?php

namespace AllYouNeed\AdvancedControls\View\Components;


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
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = 'radio-' . uniqid();
    }
    
    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @php
            $must_prepend = $labelBefore !== null;
            if ($label && $must_prepend)
                throw new Exception('Cannot declare a label both before and after the toggle');
            
            if (!isset($label)) 
                $label = $labelBefore;
        @endphp
        @if ($label)
        <div {{ $attributes->class([
                'group grid grid-cols-[auto_auto] items-center gap-x-2 gap-y-1',
                'justify-between' => $must_prepend,
                'justify-start'   => !$must_prepend,
            ]) }}
        >
            @if ($title)
            <header class="font-base text-lg col-span-full">{{ $must_prepend }}{{ $title }}</header>
            @endif
            <input id="{{ $id }}"
                type="radio"
                name="{{ $name }}"
                value="{{ $value }}"
                {{ $attributes->except(['type'])
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
                        'order-last'      => $must_prepend,
                    ])
                    ->merge()
                }}
            />
            <label for="{{ $id }}"
                {{ (gettype($label) === 'object' ? $label->attributes : $attributes)->class([
                    'text-sm dropping-texts relative cursor-pointer select-none',
                ])->merge() }}
            >
                @if ($labelChecked)
                    <div class="inline group-has-checked:hidden">{{ $label }}</div>
                    <div class="hidden group-has-checked:inline">{{ $labelChecked }}</div>
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
                    ])
                    ->merge()
                }}
            />
        @endif

        HTML;
    }
}
