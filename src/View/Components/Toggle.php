<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Toggle extends Component
{
    public function __construct(
        public ?string $id = null,
        public mixed   $title = null,
        public mixed   $label = null,
        public ?string $color  = null,
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = 'toggle-' . uniqid();
    }


    public function prepend(&$attributes, &$__laravel_slots): bool {
        return $attributes->has('label-before') || isset($__laravel_slots['label-before'])
               || $attributes->has('label:before') || isset($__laravel_slots['label:before']);
    }

    
    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @php
            $must_prepend = $prepend($attributes, $__laravel_slots);
            $labelChecked = null;
        @endphp
        @if ($label && $must_prepend)
            @php
                throw new Exception('Cannot declare a label both before and after the toggle');
            @endphp
        @endif
        @if (!isset($label))
            @if ($attributes->has('label:before'))
                @php
                    $label = $attributes->get('label:before');
                @endphp
            @elseif (isset($__laravel_slots['label:before']))
                @php
                    $label = $__laravel_slots['label:before'];
                @endphp
            @elseif ($attributes->has('label-before'))
                @php
                    $label = $attributes->get('label-before');
                @endphp
            @elseif (isset($__laravel_slots['label-before']))
                @php
                    $label = $__laravel_slots['label-before'];
                @endphp
            @endif
        @endif
        @if ($attributes->has('label:checked'))
            @php
                $labelChecked = $attributes->get('label:checked');
            @endphp
        @elseif (isset($__laravel_slots['label:checked']))
            @php
                $labelChecked = $__laravel_slots['label:checked'];
            @endphp
        @elseif ($attributes->has('label-checked'))
            @php
                $labelChecked = $attributes->get('label-checked');
            @endphp
        @elseif (isset($__laravel_slots['label-checked']))
            @php
                $labelChecked = $__laravel_slots['label-checked'];
            @endphp
        @endif
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
                        'toggle switch',
                        'toggle-primary switch-primary'     => ($type ?? $color) == 'primary',
                        'toggle-secondary switch-secondary' => ($type ?? $color) === 'secondary',
                        'toggle-accent switch-accent'       => ($type ?? $color) === 'accent',
                        'toggle-info switch-info'           => ($type ?? $color) === 'info',
                        'toggle-success switch-success'     => ($type ?? $color) === 'success',
                        'toggle-warning switch-warning'     => ($type ?? $color) === 'warning',
                        'toggle-error switch-error'         => ($type ?? $color) === 'error',
                        'order-last'                        => $must_prepend,
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
                        'toggle switch',
                        'toggle-primary switch-primary'     => $color == 'primary',
                        'toggle-secondary switch-secondary' => $color === 'secondary',
                        'toggle-accent switch-accent'       => $color === 'accent',
                        'toggle-info switch-info'           => $color === 'info',
                        'toggle-success switch-success'     => $color === 'success',
                        'toggle-warning switch-warning'     => $color === 'warning',
                        'toggle-error switch-error'         => $color === 'error',    
                    ])
                    ->merge()
                }}
            />
        @endif

        HTML;
    }
}
