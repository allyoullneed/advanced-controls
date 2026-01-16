<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Checkboxes extends Component
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
        <div {{ $attributes->except(['name'])->class([
            'flex flex-wrap ',
            'flex-row gap-y-1' => $inline,
            'flex-col' => !$inline,
        ])->merge() }}>
            <header class="w-full font-base text-lg">{{ $title }}</header>
            <input type="hidden" name="{{ $attributes->get('name') }}"/>
            
            <div @class(['flex gap-1']) @style(['flex-direction: inherit'])>
                @foreach ($options as $value => $label)
                    <x-checkbox
                        :name="$attributes->get('name')"
                        :label="$label ?? $value"
                        :value="$value"
                        :color="$color"
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
            
            @error('values.' . substr($attributes->get('name'), 0, -2)) <x-badge class="mt-1 order-last" type="error" size="sm">{{ $message }}</x-badge> @enderror
            @if ($error)
                <x-badge class="mt-1 order-last" type="error" size="sm">{{ $error }}</x-badge>
            @endif

        </div>
        HTML;
    }
}
