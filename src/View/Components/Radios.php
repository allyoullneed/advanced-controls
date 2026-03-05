<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Radios extends Component
{
    public function __construct(
        public ?string $id = null,
        public mixed   $title        = null,
        public mixed   $helper       = null,
        public ?string $error        = null,
        public ?string $color        = null,
        public ?bool   $inline       = false,
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
            'flex flex-wrap ',
            'flex-row gap-y-1' => $inline,
            'flex-col' => !$inline,
        ])->merge() }}>
            @if (gettype($title) === 'object')
            <header {{ $title->attributes->class(['font-base text-lg'])->merge() }}>{{ $title }}</header>
            @elseif ($title)
            <header class="font-base text-lg">{{ $title }}</header>
            @endif
            <input type="hidden"/>
            
            <div @class(['flex flex-wrap gap-1']) @style(['flex-direction: inherit'])>
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
                        'w-full helper-text text-sm text-gray-500',
                    ])->merge()
                }}>{{ $helper }}</span>
            @elseif ($helper)
                <span class="w-full helper-text text-sm text-gray-500">{{ $helper }}</span>
            @endif
            
            @error($attributes->whereStartsWith('wire:model')->first()) <x-badge class="mt-1 order-last truncate" type="error" size="sm">{{ $message }}</x-badge> @enderror
            @if ($error)
                <x-badge class="mt-1 order-last truncate" type="error" size="sm">{{ $error }}</x-badge>
            @endif

        </div>
        HTML;
    }
}
