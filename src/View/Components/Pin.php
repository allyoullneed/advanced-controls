<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Pin extends Component
{
    public string $id = '';
    
    public function __construct(
        ?string $id = null,
        public mixed   $value     = null,
        public mixed   $title     = null,
        public mixed   $label     = null,
        public mixed   $helper    = null,
        public mixed   $icon      = null,
        public ?string $color     = null,
        public mixed   $trailIcon = null,
        public int     $length    = 6,
        public bool    $noGap     = false,
        public bool    $hide      = false,
        public bool    $numeric   = false,
        public ?string $error     = null,
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = "pin-" . uniqid();
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
    $chars = $value ? str_split($value) : [];
    $chars = array_pad($chars, $length, '');

    // Determine binding mode
    $wireModelAttr = $attributes->whereStartsWith('wire:model')->first();
    $isWireModel = $wireModelAttr !== null;
    
    // Determine the modifier (live, blur, or default)
    $wireModifier = 'default';
    if ($isWireModel) {
        $wireModelKey = array_key_first($attributes->whereStartsWith('wire:model')->getAttributes());
        if (str_contains($wireModelKey, '.live')) {
            $wireModifier = 'live';
        } elseif (str_contains($wireModelKey, '.blur')) {
            $wireModifier = 'blur';
        } else {
            $wireModifier = 'default';
        }
    }
    
    $isAlpineValue = $attributes->whereStartsWith('::value') != null || $attributes->whereStartsWith(':value') != null;
    
    // Extract the Alpine property name from ::value or :value
    $alpineProperty = null;
    if ($attributes->whereStartsWith('::value')->first()) {
        $alpineProperty = trim($attributes->whereStartsWith('::value')->first());
    } elseif ($attributes->whereStartsWith(':value')->first()) {
        $alpineProperty = trim($attributes->whereStartsWith(':value')->first());
    }
    
    // Extract the Livewire property name
    $wireProperty = $wireModelAttr ? trim($wireModelAttr) : null;
@endphp

<div 
    id="{{ $id }}"
    x-data="
    {
        chars: {{ json_encode($chars) }},
        length: {{ $length }},
        focusedIndex: 0,
        isWireModel: {{ $isWireModel ? 'true' : 'false' }},
        isAlpineValue: {{ $isAlpineValue ? 'true' : 'false' }},
        alpineProperty: {{ $alpineProperty ? "'$alpineProperty'" : 'null' }},
        wireProperty: {{ $wireProperty ? "'$wireProperty'" : 'null' }},
        wireModifier: '{{ $wireModifier }}',

        init() {
            if (this.isAlpineValue && this.alpineProperty) {
                this.$watch(this.alpineProperty, (newValue) => {
                    if (newValue !== this.getValue()) {
                        this.updateFromParent(newValue);
                    }
                });
            }
            $nextTick(() => {
                $el.addEventListener('paste', (e) => {
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    setValue(paste);

                    e.preventDefault();
                });
            });
            this.focus = function (option) {
                console.log('start focus');
                console.log(this.querySelector('input'));
                this.querySelector('input').focus(option);
                console.log('end focus');
            }
        },

        getValue() {
            return this.chars.join('');
        },
        setValue(value) {
            for (var i = 0; i < length; i++) {
                this.chars[i] = value[i];
            }
        },
        focusInput(index) {
            if (index >= 0 && index < this.length) {
                this.focusedIndex = index;
                this.$nextTick(() => {
                    const input = this.$refs['{{ $id }}' + index];
                    if (input) {
                        input.focus();
                        input.select();
                    }
                });
            }
        },
        handleInput(index, event) {
            const target = event.target;
            const value = event.target.value;

            if (value.length > 1) {
                const chars = value.split('');
                for (let i = 0; i < Math.min(chars.length, this.length - index); i++) {
                    this.chars[index + i] = chars[i];
                }
                let nextIndex = index + chars.length;
                if (nextIndex >= this.length) {
                    nextIndex = this.length - 1;
                }
                this.focusInput(nextIndex);
            } else if (value) {
                this.chars[index] = value;
                if (index < this.length - 1) {
                    this.focusInput(index + 1);
                }
            }

            this.updateBindings('input');

            if (value.length >= 1 && target.nextElementSibling) {
                target.nextElementSibling.focus();
                target.nextElementSibling.select()
            }
        },
        handleBackspace(index, event) {
            const target = event.target;
            if (target.value.length >= 1) {
                target.value = '';
                this.chars[index] = '';
            } else {
                if (target.previousElementSibling)
                    target.previousElementSibling.value = '';
                this.chars[index - 1] = '';
            }
            this.updateBindings('input');

            if (target.previousElementSibling) {
                target.previousElementSibling.focus()
                target.previousElementSibling.select()
            }
        },
        handleKeydown(index, event) {
            if (event.key === 'ArrowLeft' && index > 0) {
                event.target.previousElementSibling.focus();
                event.target.previousElementSibling.select();
            } else if (event.key === 'ArrowRight' && index < this.length - 1) {
                event.target.nextElementSibling.focus();
                event.target.nextElementSibling.select();
            }

            if (event.key === 'Delete' && this.chars[index]) {
                this.chars[index] = '';
                this.updateBindings('input');
            }
        },
        handleFocus(index) {
            this.focusedIndex = index;
            this.$nextTick(() => {
                const input = this.$refs['input-' + index];
                if (input) input.select();
            });
        },
        handleContainerBlur(event) {
            const container = event.currentTarget;
            const relatedTarget = event.relatedTarget;

            if (!relatedTarget || !container.contains(relatedTarget)) {
                this.handleBlur();
            }
        },
        handleBlur() {
            // For Alpine, we always update immediately
            if (this.isAlpineValue && this.alpineProperty) {
                this.$data[this.alpineProperty] = this.getValue();
            }

            // Update on blur for wire:model.blur only
            if (this.isWireModel && this.wireProperty && this.wireModifier === 'blur') {
                this.updateLivewire();
            }
        },
        updateBindings(trigger) {
            const value = this.getValue();

            if (this.isAlpineValue && this.alpineProperty) {
                this.$data[this.alpineProperty] = value;
            }

            if (this.isWireModel && this.wireProperty) {
                if (this.wireModifier === 'live') {
                    this.updateLivewire();
                } else if (this.wireModifier === 'default') {
                    this.updateHiddenInput(value);
                }
            }
        },
        updateHiddenInput(value) {
            this.$nextTick(() => {
                const hiddenInput = this.$refs['hidden-input'];
                if (hiddenInput) {
                    hiddenInput.value = value;
                    hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                }
            });
        },
        updateLivewire() {
            if (this.isWireModel && this.wireProperty) {
                const value = this.getValue();
                this.$wire.set(this.wireProperty, value);
                window.dispatchEvent(new CustomEvent('input-update', {
                    detail: { id: this.id, value: value }
                }));
            }
        },
        updateFromParent(value) {
            const newChars = value ? String(value).split('') : [];
            for (let i = 0; i < this.length; i++) {
                this.chars[i] = newChars[i] || '';
            }
        },
        updateFromLivewire(value) {
            this.updateFromParent(value);
        }
    }"
    {{ $attributes->class(["flex flex-col"])->merge() }}
    @focusout="handleContainerBlur($event)"
>
<style>
    main  {
        interpolate-size: allow-keywords;
    }

    .error-label {
    opacity: 1;
    height: auto;
    overflow: hidden;
    transform-origin: bottom;
    transition: height 0.5s;
    }

    @starting-style {
    .error-label {
        opacity: 0;
        height: 0;
    }
    }
</style>
    <!-- Hidden input bound to Livewire for default wire:model -->
    @if($isWireModel && $wireModifier === 'default')
        <input 
            type="hidden" 
            wire:model="{{ $wireProperty }}"
            x-ref="hidden-input"
            :value="getValue()"
        />
    @endif

    @if (gettype($title) === 'object')
        <header {{ $title->attributes->class(['font-base text-lg'])->merge() }}>{{ $title }}</header>
    @elseif ($title)
        <header class="font-base text-lg">{{ $title }}</header>
    @endif
    

    <div class="flex items-center justify-stretch gap-2">
        @if (gettype($icon) === 'string')
            <div class="flex h-lh">
                <x-icon :name="$icon"/>
            </div>
        @endif
        @if (gettype($label) === 'string')
            <div class="label-text">
                {{ $label }}
            </div>
        @endif
        @for($i = 0; $i < $length; ++$i)
            <input
                id="{{ $id }}-{{$i}}"
                maxlength="1"
                :value="chars[{{ $i }}]"
                @input="handleInput({{ $i }}, $event)"
                @keydown.backspace.prevent="handleBackspace({{ $i }}, $event)"
                @keydown="handleKeydown({{ $i }}, $event)"
                @focus="handleFocus({{ $i }})"
                autocomplete="off"
                @if($numeric)
                    inputmode="numeric"
                    x-mask="9"
                @endif
                @if ($attributes->has('autofocus') && $i ===0)
                autofocus
                @endif
                {{
                    $attributes->except(['autofocus', 'class', 'name', 'color'])->whereDoesntStartWith('wire')->class([
                        'peer input input-border min-w-6 max-w-12 p-0 font-bold text-xl text-center',
                        'join-item' => $noGap,
                        'input-primary border-primary outline-primary!'       => $color === 'primary',
                        'input-secondary border-secondary outline-secondary!' => $color === 'secondary',
                        'input-accent border-accent outline-accent!'          => $color === 'accent',
                        'input-info border-info outline-info!'                => $color === 'info',
                        'input-success border-success outline-success!'       => $color === 'success',
                        'input-warning border-warning outline-warning!'       => $color === 'warning',
                        'input-error border-error outline-error!'             => $color === 'error',
                    ])->merge(['type' => 'text'])
                }}
            />
        @endfor
        @if ($trailIcon)
            @if (gettype($trailIcon) === 'string')
                <div class="flex h-lh order-last">
                    <x-icon :name="$trailIcon"/>
                </div>
            @elseif (gettype($trailIcon) === 'object')  
                <div {{ $trailIcon->attributes->class(['flex order-last']) }}>
                    {{ $trailIcon }}
                </div>
            @endif
        @endif
    </div>

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
        <x-badge class="error-label will-change-[height] h-auto transition-[height] duration-250 col-span-full mt-1 order-last h-[unset]" type="error" size="sm">{{ $message }}</span></x-badge>
    @enderror
    @if ($error)
        <x-badge class="absolute bottom-0 translate-y-1/1 error-label will-change-[height] h-auto transition-[height] duration-250 col-span-full mt-1 order-last h-[unset]" type="error" size="sm"><span class="block truncate">{{ $error }}</span></x-badge>
    @endif
</div>
HTML;
    }
}
