<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Select extends Component
{
    public string $id = '';
    public function __construct(
        public mixed   $title       = null,
        public mixed   $label       = null,
        public ?string $placeholder = null,
        public mixed   $error       = null,
        public mixed   $helper      = null,
        public mixed   $icon        = null,
        public mixed   $trailIcon   = null,
        public ?string $size        = null,
        public ?string $color       = null,
        public bool    $ghost       = false,
        public array   $options     = [],
        public bool    $multiple    = false,
        public ?int    $rows        = null,
        public ?int    $maxRows     = null
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @php
            $model = $attributes->whereStartsWith('wire:model');
            if ($model) {
                $model = substr($model, 2 + strpos($model, "="));
                $model = substr($model, 0, strlen($model) - 1);
            }
            else
                $model = $name
        @endphp
        <div 
            {{ $attributes->except([
                'name', 'id', 'value', 'required'
            ])->whereDoesntStartWith('wire:model')->class(['flex flex-col'])->merge() }}
            x-data="{
                options: [],
                selectedOptions: [],
                init() {
                    const selectElement = $el.querySelector('select');
                    selectElement.querySelectorAll('option').forEach((option) => {
                        option.addEventListener('mousedown', 
                            function (e) {
                                if (!e.shiftKey) {
                                    e.preventDefault();
                                    option.parentElement.focus();
                                    $data.toggleOption(this.value);
                                }
                                return false;
                        }, false );

                        this.options.push({ text: option.innerText, value: (option.value ?? option.innerText) });
                        if (option.selected || option.checked)
                            this.selectedOptions.push(option.value ?? option.innerText);
                    });
                    @if ($model)
                    $nextTick(function() { $wire.entangle('{{ $model }}'); });
                    @endif
                },
                toggleOption(value) {
                    @if($multiple)
                        const index = this.selectedOptions.findIndex((opt) => opt === value);
                        if (index >= 0)
                            this.selectedOptions.splice(index, 1);
                        else
                            this.selectedOptions.push(value);
                    @else
                        this.selectedOptions = [value];
                    @endif
                },
                removeOption(value) {
                    this.selectedOptions.splice(this.selectedOptions.findIndex((opt) => opt === value), 1);
                }
            }"
        > 
            @if (gettype($title) === 'object')
            <header {{ $title->attributes->class(['font-base text-lg'])->merge() }}>{{ $title }}</header>
            @elseif ($title)
            <header class="font-base text-lg">{{ $title }}</header>
            @endif
            
            <x-dropdown class="w-full">
                <x-slot:trigger
                    @class([
                        'select cursor-pointer custom-multiselect select-header w-full',
                        'select-neutral'   => $color === 'neutral',
                        'select-primary'   => $color === 'primary',
                        'select-secondary' => $color === 'secondary',
                        'select-accent'    => $color === 'accent',
                        'select-info'      => $color === 'info',
                        'select-success'   => $color === 'success',
                        'select-warning'   => $color === 'warning',
                        'select-error'     => $color === 'error',
                    ])
                    @style([ 
                        'height: unset' => $maxRows > 1,
                    ])>
                    <div @class([
                        'relative h-full w-full py-1 flex gap-2 items-center-safe overflow-y-auto'
                    ])>
                        @if (gettype($icon) === 'string')
                            <div class="h-lh aspect-square">
                                <x-icon :name="$icon"/>
                            </div>
                        @endif
                        @if (gettype($label) === 'string')
                            <div {{
                                $attributes->class([
                                'label-text',
                                'text-xs' => $size === 'xs',
                                'text-sm' => $size === 'sm',
                                'text-lg' => $size === 'lg',
                                'text-xl' => $size === 'xl',
                                ])
                            }}>
                                {{ $label }}
                            </div>
                        @endif
                        <div class="h-full relative flex items-center">
                            @if ($placeholder)
                                <span x-show="selectedOptions.length === 0"
                                class="absolute text-current/50 select-none">{{ $placeholder }}</span>
                            @endif
                            @if ($multiple)
                                <div
                                    @class([
                                        'row-start-1 flex flex-wrap gap-2 pillbox overflow-auto',
                                        'col-start-1' => $label === null,
                                        'col-start-2' => $label !== null,
                                    ])
                                    @style([
                                        'max-height: calc(' . (6 * $maxRows) . ' * var(--size-selector) + ' . (2 * ($maxRows - 1)) . ' * var(--spacing))' => $maxRows > 1
                                    ])>
                                    <template x-for="option in selectedOptions">
                                        <x-badge :color="$color" @mousedown.prevent="" class="pe-0">
                                            <x-slot class="flex items-center">
                                                <span x-text="options.find((opt) => opt.value === option)?.text"></span>
                                                <x-button noSpinner :color="$color" size="xs" @click.stop="$event.stopPropagation(); $event.preventDefault(); removeOption(option)" class="max-h-full aspect-square pill-remove btn-circle shadow-none outline-none" style="pointer-events:initial" value="${option}">✕</x-button>
                                            </x-slot>
                                        </x-badge>
                                    </template>
                                </div>
                            @else
                                <span x-text="options.find((opt) => opt.value === selectedOptions[0])?.text"></span>
                            @endif
                        </div>
                    </div>
                </x-slot:trigger>

                <select multiple
                    x-model="selectedOptions"
                    @class([
                        'w-full mt-1 select options-container [&>option+option]:mt-1',
                        'select-neutral [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-neutral),var(--color-neutral))] [&_option:checked]:text-neutral-content'         => $color === 'neutral',
                        'select-primary [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-primary),var(--color-primary))] [&_option:checked]:text-primary-content'         => $color === 'primary',
                        'select-secondary [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-secondary),var(--color-secondary))] [&_option:checked]:text-secondary-content' => $color === 'secondary',
                        'select-accent [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-accent),var(--color-accent))] [&_option:checked]:text-accent-content'             => $color === 'accent',
                        'select-info [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-info),var(--color-info))] [&_option:checked]:text-info-content'                     => $color === 'info',
                        'select-success [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-success),var(--color-success))] [&_option:checked]:text-success-content'         => $color === 'success',
                        'select-warning [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-warning),var(--color-warning))] [&_option:checked]:text-warning-content'         => $color === 'warning',
                        'select-error [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-error),var(--color-error))] [&_option:checked]:text-error-content'                 => $color === 'error',
                    ])
                    @if ($rows || count($options) > 0)
                        size="{{ $rows ?? min(12, count($options)) }}"
                    @endif
                    {{ $attributes->only(['name', 'id', 'required']) }}
                    {{ $attributes->whereStartsWith('wire:model') }}
                >
                    @foreach ($options as $value => $label)
                        <option value="{{ $value }}">{{ $label ?? $value }}</option>
                    @endforeach
                    {{ $slot }}
                </select>
                
                @if (gettype($label) === 'object')
                <div {{ $label->attributes->class([
                    'label-text flex order-first',                
                    'text-xs' => $size === 'xs',
                    'text-sm' => $size === 'sm',
                    'text-lg' => $size === 'lg',
                    'text-xl' => $size === 'xl',
                    ]) }}
                >
                    {{ $label }}
                </div>
                @endif
            </x-dropdown>

            @if (gettype($helper) === 'object')
                <span {{
                    $helper->attributes->class([
                        'helper-text text-sm text-gray-500',
                    ])->merge()
                }}>{{ $helper }}</span>
            @elseif ($helper)
                <span class="helper-text text-sm text-gray-500">{{ $helper }}</span>
            @endif
            
            @error('values.' . substr($attributes->get('name'), 0, -2)) <x-badge class="mt-1 order-last" type="error" size="sm">{{ $message }}</x-badge> @enderror
            @if ($error)
                <x-badge class="mt-1 order-last" type="error" size="sm">{{ $error }}</x-badge>
            @endif
        
        </div>
        HTML;
    }
}
