<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Checkbox extends Component
{
    public function __construct(
        public ?string $id = null,
        public mixed   $title        = null,
        public mixed   $label        = null,
        public mixed   $labelBefore  = null,
        public mixed   $labelChecked = null,
        public ?string $color        = null,
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = 'checkbox-' . uniqid();
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
            <input id="{{ $id }}" type="checkbox"
                {{ $attributes->except([
                    'type'
                    ])
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
                        'order-last'         => $must_prepend,
                    ])
                    ->merge()
                }}
            />
            <label :for="$id"
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
            <input type="checkbox"
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
                    ])
                    ->merge()
                }}
            />
        @endif

        HTML;
    }
}
