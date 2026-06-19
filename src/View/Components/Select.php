<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Select extends Component
{
    public string $id = '';
    public function __construct(
              ?string  $id          = null,
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
        public bool    $filter      = false,
        public ?int    $rows        = null,
        public int     $maxRows     = 1,
        public bool    $disabled    = false,
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = 'select-' .  uniqid();
    }
    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @error($attributes->whereStartsWith('wire:model')->first())
            @php
            $color = 'error'
            @endphp
        @enderror
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
                'name', 'id', 'value', 'required', 'aria-label'
            ])->class(['flex flex-col'])->merge() }}

            x-data="{
                options: [],
                selectedOptions: [],
                init() {
                    const selectElement = $el.querySelector('select');
                    selectElement.querySelectorAll('option').forEach((option) => {
                        option.addEventListener('mousedown', function (e) { e.preventDefault() });
                        option.addEventListener('click', 
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
            x-modelable="selectedOptions"
            
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
                    ])
                    onblur="var filter = document.getElementById('filter-{{ $id }}'); if (filter) { filter.value = ''; filterSelect(filter, document.getElementById('{{ $id }}')); }">
                    <div @class([
                        'relative h-full w-full py-1 flex gap-2 items-center-safe overflow-y-auto'
                    ])>
                        @if (gettype($icon) === 'object')
                            <div {{ $icon->attributes->class(["h-lh aspect-square"])->merge() }}>
                            {{ $icon }}
                            </div>
                        @elseif (gettype($icon) === 'string')
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
                        <div class="w-full h-full relative flex items-center">
                            @if ($placeholder)
                                <span x-show="(selectedOptions ? selectedOptions.length : 0) === 0"
                                class="absolute text-current/50 select-none">{{ $placeholder }}</span>
                            @endif
                            @if ($multiple)
                                <div
                                    @class([
                                        'row-start-1 flex flex-wrap gap-2 pillbox overflow-auto items-center',
                                        'col-start-1' => $label === null,
                                        'col-start-2' => $label !== null,
                                    ])
                                    @style([
                                        'min-height: calc(6 * var(--size-selector) + 2 * var(--spacing)); max-height: calc(' . (6 * $maxRows) . ' * var(--size-selector) + ' . (2 * ($maxRows - 1)) . ' * var(--spacing))' => $maxRows > 1
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
                                <span x-text="options.find((opt) => opt.value === (selectedOptions ? selectedOptions[0] : null))?.text"></span>
                            @endif
                        </div>
                    </div>
                </x-slot:trigger>

                @if ($filter)
                    @once
                    <script>
                        function filterSelect(searchInput, select) {
                            var keyword = searchInput.value;
                            var regex = new RegExp(keyword, 'i');
                            var found = 0;

                            for (var i = 0; i < select.length; i++) {
                                var txt = select.options[i].text;
                                if (!regex.test(txt)) {
                                    select.options[i].setAttribute('disabled', 'disabled');
                                    select.options[i].classList.add('hidden');
                                } else {
                                    found += 1;
                                    select.options[i].removeAttribute('disabled')
                                    select.options[i].classList.remove('hidden');
                                }
                                select.style.setProperty('--options-filtered', found);
                            }
                        }
                    </script>
                    @endonce
                    <div class="p-2 h-full flex flex-col">
                        <x-input :color="$color" autofocus id="filter-{{ $id }}" class="w-full" placeholder="Filter options..." onkeyup="filterSelect(this, document.getElementById('{{ $id }}'))" class="w-full"/>
                @endif
                <select multiple
                    id="{{ $id }}"
                    x-model="selectedOptions"
                    {{ $attributes->whereStartsWith(['aria']) }}
                    @if (!$multiple)
                    onclick="document.activeElement.blur()"
                    @endif
                    @class([
                        'w-full flex-col items-stretch max-h-fit mt-1 grow select options-container space-y-1 space-y-reverse **:space-y-1 **:space-y-reverse [&_option]:content-center',
                        "pointer-fine:[&_option]:h-8 pointer-coarse:[&_option]:h-12",
                        "pointer-fine:h-[calc(1.5rem_+_min(var(--options-filtered),_var(--options-shown,12))_*_2.25rem_+_1px)]",
                        'select-neutral [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-neutral),var(--color-neutral))] [&_option:checked]:text-neutral-content'         => $color === 'neutral',
                        'select-primary [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-primary),var(--color-primary))] [&_option:checked]:text-primary-content'         => $color === 'primary',
                        'select-secondary [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-secondary),var(--color-secondary))] [&_option:checked]:text-secondary-content' => $color === 'secondary',
                        'select-accent [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-accent),var(--color-accent))] [&_option:checked]:text-accent-content'             => $color === 'accent',
                        'select-info [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-info),var(--color-info))] [&_option:checked]:text-info-content'                     => $color === 'info',
                        'select-success [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-success),var(--color-success))] [&_option:checked]:text-success-content'         => $color === 'success',
                        'select-warning [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-warning),var(--color-warning))] [&_option:checked]:text-warning-content'         => $color === 'warning',
                        'select-error [&_option:checked]:bg-[linear-gradient(to_bottom,var(--color-error),var(--color-error))] [&_option:checked]:text-error-content'                 => $color === 'error',
                    ])
                    @if($rows)
                        style="--options-shown: {{ $rows }}"
                    @endif
                    {{ $attributes->only(['name', 'id', 'required']) }}
                >
                    @foreach ($options as $value => $label)
                        <option value="{{ $value }}">{{ $label ?? $value }}</option>
                    @endforeach
                    {{ $slot }}
                </select>
                @if ($filter)
                </div>
                @endif

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
        HTML;
    }
}
