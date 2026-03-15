<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Toggle extends Component
{
    public function __construct(
        public ?string $id             = null,
        public mixed   $title          = null,
        public mixed   $label          = null,
        public mixed   $labelBefore    = null,
        public mixed   $labelChecked   = null,
        public mixed   $helper         = null,
        public ?string $error          = null,
        public ?string $color          = null,
        public ?string $size           = null,
        public string  $value          = "1",
        public ?string $valueUnchecked = null,
        public bool    $checked        = false,
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = 'toggle-' . uniqid();
    }
    
    public function errorFieldName(): ?string
    {
        return $this->attributes->whereStartsWith('wire:model')->first() ?? $this->attributes['name'];
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
            <div {{ $attributes->whereDoesntStartWith('wire:model')->except(['type', 'name', 'value', 'checked'])->class([
                    'group grid grid-cols-[auto_1fr] items-center gap-x-2 gap-y-1 justify-start',
                    'grid grid-cols-[auto_1fr] items-center gap-x-2 gap-y-1' => $label,
                    'justify-between' => $must_prepend,
                    'justify-start'   => !$must_prepend,
                    'text-xl'         => $size === 'xl',
                    'text-lg'         => $size === 'lg',
                    'text-base'       => $size === 'md',
                    'text-sm'         => $size === 'sm',
                    'text-xs'         => $size === 'xs',
                ]) }}
            >
                @if ($title)
                    <header class="font-base text-lg col-span-full">{{ $title }}</header>
                @endif
                <label
                    {{ (gettype($label) === 'object' ? $label->attributes : $attributes->except(['type', 'name', 'value', 'checked', 'class']))->class([
                        'label label-text flex items-center gap-1.5 relative cursor-pointer select-none',
                    ])->merge() }}
                >
                    <input id="{{ $id }}" type="checkbox"
                        value="{{ $value }}"
                        {{ $attributes->except([
                            'type', 'class'
                            ])->class([
                                'toggle switch',
                                'outline-2 outline-offset-2 outline-error'   => $errors->has($errorFieldName()),
                                'toggle-neutral switch-neutral'     => ($type ?? $color) == 'neutral',
                                'toggle-primary switch-primary'     => ($type ?? $color) == 'primary',
                                'toggle-secondary switch-secondary' => ($type ?? $color) === 'secondary',
                                'toggle-accent switch-accent'       => ($type ?? $color) === 'accent',
                                'toggle-info switch-info'           => ($type ?? $color) === 'info',
                                'toggle-success switch-success'     => ($type ?? $color) === 'success',
                                'toggle-warning switch-warning'     => ($type ?? $color) === 'warning',
                                'toggle-error switch-error'         => ($type ?? $color) === 'error',
                                'toggle-xl switch-xl'               => $size === 'xl',
                                'toggle-lg switch-lg'               => $size === 'lg',
                                'toggle-md switch-md'               => $size === 'md',
                                'toggle-sm switch-sm'               => $size === 'sm',
                                'toggle-xs switch-xs'               => $size === 'xs',
                                'order-last'                        => $must_prepend,
                            ])->merge([
                                'checked' => $checked
                            ])
                        }}
                    />
                    @if ($labelChecked)
                        <div class="grid grid-cols-1">
                            <span @class([
                                'col-start-1 row-start-1 group-has-checked:opacity-0 transition-opacity duration-250',
                                'justify-self-end' => $must_prepend,
                            ])>{{ $label }}</span>
                            <span @class([
                                'col-start-1 row-start-1 group-not-has-checked:opacity-0 transition-opacity duration-250',
                                'justify-self-end' => $must_prepend,
                            ])>{{ $labelChecked }}</span>
                        </div>
                    @else
                        {{ $label }}
                    @endif
                </label>
                @if (gettype($helper) === 'object')
                    <span {{
                        $helper->attributes->class([
                            'helper-text text-left text-sm text-gray-500 col-span-full',
                        ])->merge()
                    }}>{{ $helper }}</span>
                @elseif ($helper)
                    <span class="helper-text text-left text-sm text-gray-500 col-span-full">{{ $helper }}</span>
                @endif
                
                @error($attributes->whereStartsWith('wire:model')->first())
                    <x-badge class="mt-1 order-last h-[unset]" type="error" size="sm">{{ $message }}</span></x-badge>
                @enderror
                @if ($error)
                    <x-badge class="mt-1 order-last h-[unset]" type="error" size="sm"><span class="block truncate">{{ $error }}</span></x-badge>
                @endif
                
                {{ $slot }}
            </div>
        @else
            <div {{ $attributes->whereDoesntStartWith('wire:model')->except(['type', 'name', 'value', 'checked'])->class([
                    'group grid grid-cols-[auto_1fr] items-center justify-start'=> !$label,
                    'grid grid-cols-[auto_1fr] items-center' => $label,
                    'justify-between' => $must_prepend,
                    'justify-start'   => !$must_prepend,
                ]) }}
            >
                @if ($title)
                    <header class="font-base text-lg col-span-full">{{ $title }}</header>
                @endif
                <input type="checkbox"
                    value="{{ $value }}"
                    {{ $attributes->class([
                            'toggle switch',
                            'ring-2 ring-offset-2 ring-error'   => $errors->has($errorFieldName()),
                            'toggle-neutral switch-neutral'     => ($type ?? $color) == 'neutral',
                            'toggle-primary switch-primary'     => $color == 'primary',
                            'toggle-secondary switch-secondary' => $color === 'secondary',
                            'toggle-accent switch-accent'       => $color === 'accent',
                            'toggle-info switch-info'           => $color === 'info',
                            'toggle-success switch-success'     => $color === 'success',
                            'toggle-warning switch-warning'     => $color === 'warning',
                            'toggle-error switch-error'         => $color === 'error',
                            'toggle-xl switch-xl'               => $size === 'xl',
                            'toggle-lg switch-lg'               => $size === 'lg',
                            'toggle-md switch-md'               => $size === 'md',
                            'toggle-sm switch-sm'               => $size === 'sm',
                            'toggle-xs switch-xs'               => $size === 'xs',
                        ])->merge([
                            'checked' => $checked
                        ])
                    }}
                />

                @if (gettype($helper) === 'object')
                    <span {{
                        $helper->attributes->class([
                            'helper-text text-left text-sm text-gray-500 col-span-full',
                        ])->merge()
                    }}>{{ $helper }}</span>
                @elseif ($helper)
                    <span class="helper-text text-left text-sm text-gray-500 col-span-full">{{ $helper }}</span>
                @endif

                @error($attributes->whereStartsWith('wire:model')->first())
                    <x-badge class="mt-1 order-last h-[unset]" type="error" size="sm">{{ $message }}</span></x-badge>
                @enderror
                @if ($error)
                    <x-badge class="mt-1 order-last h-[unset]" type="error" size="sm"><span class="block truncate">{{ $error }}</span></x-badge>
                @endif
            </div>
        @endif

        HTML;
    }
}
