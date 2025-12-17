<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Input extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $label = null,
        public ?string $placeholder = null,
        public ?string $error = null,
        public ?string $helper = null,
        public mixed $indicator = null,
        public ?string $color = null,
        public bool    $ghost = false,
        public ?string $icon  = null
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div class="grid grid-cols-1">
        @if ($title)
        <header class="font-base text-lg col-span-full">{{ $title }}</header>
        @endif
        <label
            {{ $attributes->except(['type'])
                ->class([
                    'input inline-flex gap-2 items-center',
                    'input-primary'   => $color == 'primary',
                    'input-secondary' => $color === 'secondary',
                    'input-accent'    => $color === 'accent',
                    'input-info'      => $color === 'info',
                    'input-success'   => $color === 'success',
                    'input-warning'   => $color === 'warning',
                    'input-error'     => $color === 'error',
                    'input-ghost'     => $ghost,
                    'indicator'       => $indicator,
                ])
                ->merge([
                ])
            }}>
            @if ($indicator)
                @if (gettype($indicator) === 'boolean')
                    <span class="indicator-item status"></span>
                @elseif (gettype($indicator) === 'string')
                    <span {{ $attributes->class([
                        'indicator-item status',
                        'status-primary' => $indicator == 'primary',
                        'status-secondary' => $indicator == 'secondary',
                        'status-accent' => $indicator == 'accent',
                        'status-info' => $indicator == 'info',
                        'status-success' => $indicator == 'success',
                        'status-warning' => $indicator == 'warning',
                        'status-error' => $indicator == 'error',
                    ])->merge() }}></span>
                @else
                    <span class="indicator-item">{{ $indicator }}</span>
                @endif
            @endif
            {{ dd(get_defined_vars()) }}
            @foreach($attributes as $attribute)
                {{ $attribute }}
            @endforeach
            {{ $label ?? $slot }}
            <input type="text"
                {{ $attributes->only(['type'])->merge([
                    'type' => 'text',
                    'placeholder' => $placeholder,
                ]) }}
            />
        </label>
        @if ($error || $helper)
        <span {{
            $attributes->class([
                'text-sm text-gray-500 mt-1 col-span-full',
                'text-error' => $error,
            ])->merge()
        }} class="">{{ $error ?? $helper }}</span>
        @endif
        </div>
        HTML;
    }
}
