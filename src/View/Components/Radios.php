<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Radios extends Component
{
    public function __construct(
        public ?string $id = null,
        public mixed   $title        = null,
        public mixed   $helper       = null,
        public ?string $error        = null,
        public ?string $color        = null,
        public ?bool   $horizontal       = false,
        public array   $options      = [],
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = 'checkbox-' . uniqid();
    }
    
    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div {{ $attributes->except(['name'])->whereDoesntStartWith('wire:model')->class([
            'flex flex-col flex-wrap',
            'flex-col' => !$horizontal,
        ])->merge() }}>
            @if (gettype($title) === 'object')
            <header {{ $title->attributes->class(['font-base text-lg'])->merge() }}>{{ $title }}</header>
            @elseif ($title)
            <header class="font-base text-lg">{{ $title }}</header>
            @endif
            <input type="hidden"/>
            
            <div @class([
                'flex flex-wrap gap-1',
                'flex-row' => $horizontal,
                'flex-col' => !$horizontal,
                ])>
                @foreach ($options as $value => $label)
                    <x-radio
                        :name="$attributes->get('name')"
                        :label="$label ?? $value"
                        :value="$value"
                        :color="$color"
                        {{ $attributes->whereStartsWith('wire:model') }}
                    />
                @endforeach
                {{ $slot }}
            </div>
            @if (gettype($helper) === 'object')
                <span {{
                    $helper->attributes->class([
                        'w-full helper-text text-left text-sm text-gray-500',
                    ])->merge()
                }}>{{ $helper }}</span>
            @elseif ($helper)
                <span class="w-full helper-text text-left text-sm text-gray-500">{{ $helper }}</span>
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
