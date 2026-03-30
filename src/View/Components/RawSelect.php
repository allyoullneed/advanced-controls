<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class RawSelect extends Component
{
    public string $id = '';
    public function __construct(
        public mixed   $title       = null,
        public mixed   $label       = null,
        public ?string $placeholder = null,
        public mixed   $error       = null,
        public mixed   $helper      = null,
        public ?string $size        = null,
        public ?string $color       = null,
        public bool    $ghost       = false,
        public bool    $clearable   = false,
        public array   $options     = [],
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @error($attributes->whereStartsWith('wire:model')->first())
            @php
            $color = 'error'
            @endphp
        @enderror
        <div 
            {{ $attributes->class(['flex flex-col'])->merge() }}
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
                                return false;
                                }
                        }, false );
                        this.options.push({ text: option.innerText, value: (option.value ?? option.innerText) });
                        if (option.selected || option.checked)
                            this.selectedOptions.push(option.value ?? option.innerText);
                    });
                    selectElement.setAttribute('x-model', 'selectedOptions');
                },
                toggleOption(value) {
                    const index = this.selectedOptions.findIndex((opt) => opt === value);
                    if (index >= 0)
                        this.selectedOptions.splice(index, 1);
                    else
                        this.selectedOptions.push(value);
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
            <div class="relative w-full h-full flex flex-wrap items-center justify-stretch">
                <select {{ $attributes->whereStartsWith('wire:model') }}
                    @class([
                        'select peer w-full',
                        'select-neutral [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-neutral),var(--color-neutral))] [&_option:checked]:text-neutral-content'         => $color === 'neutral',
                        'select-primary [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-primary),var(--color-primary))] [&_option:checked]:text-primary-content'         => $color === 'primary',
                        'select-secondary [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-secondary),var(--color-secondary))] [&_option:checked]:text-secondary-content' => $color === 'secondary',
                        'select-accent [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-accent),var(--color-accent))] [&_option:checked]:text-accent-content'             => $color === 'accent',
                        'select-info [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-info),var(--color-info))] [&_option:checked]:text-info-content'                     => $color === 'info',
                        'select-success [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-success),var(--color-success))] [&_option:checked]:text-success-content'         => $color === 'success',
                        'select-warning [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-warning),var(--color-warning))] [&_option:checked]:text-warning-content'         => $color === 'warning',
                        'select-error [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-error),var(--color-error))] [&_option:checked]:text-error-content'                 => $color === 'error',
                        'select-xs'    => $size === 'xs',
                        'select-sm'    => $size === 'sm',
                        'select-md'    => $size !== 'xs' && $size !== 'sm' && $size !== 'lg' && $size !== 'xl',
                        'select-lg'    => $size === 'lg',
                        'select-xl'    => $size === 'xl',
                        'select-ghost' => $ghost,

                    ])>
                    @if ($clearable)
                    <option value></option>
                    @endif
                    @foreach ($options as $value => $label)
                        <option value="{{ $value }}">{{ $label ?? $value }}</option>
                    @endforeach
                    {{ $slot }}
                </select>
                @if ($placeholder)
                    <span class="absolute left-2 peer-has-[option:not([value='']):checked]:hidden text-current/50 select-none">{{ $placeholder }}</span>
                @endif

                @if (gettype($helper) === 'object')
                    <span {{
                        $helper->attributes->class([
                            'helper-text text-left text-sm text-gray-500',
                        ])->merge()
                    }}>{{ $helper }}</span>
                @elseif ($helper)
                    <span class="helper-text text-left text-sm text-gray-500">{{ $helper }}</span>
                @endif
                
                @error($attributes->whereStartsWith('wire:model')->first())
                    <x-badge class="mt-1 order-last h-[unset]" type="error" size="sm">{{ $message }}</span></x-badge>
                @enderror
                @if ($error)
                    <x-badge class="mt-1 order-last h-[unset]" type="error" size="sm"><span class="block truncate">{{ $error }}</span></x-badge>
                @endif
            </div>
        </div>
        HTML;
    }
}
