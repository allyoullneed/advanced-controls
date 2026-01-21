<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Pin extends Component
{
    public string $id = '';
    public function __construct(
        ?string $id = null,
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
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = "pin-" . uniqid();
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div
            {{ $attributes->class([
                'flex flex-col'
            ])->merge() }}
            x-data="{
                id: '{{ $id }}',
                value: '',
                inputs: [],
                init() {
                    $nextTick(() => {
                        document.getElementById(this.id).addEventListener('paste', (e) => {
                            const paste = (e.clipboardData || window.clipboardData).getData('text');

                                for (var i = 0; i < {{ $length }}; i++) {
                                this.inputs[i] = paste[i];
                            }

                            e.preventDefault()
                            this.handlePin()
                        })
                    })
                },
                next(el) {
                    this.handlePin()

                    if (el.value.length == 0) {
                        return
                    }

                    if (el.nextElementSibling) {
                        el.nextElementSibling.focus()
                        el.nextElementSibling.select()
                    }
                },
                remove(el, i) {
                    this.inputs[i] = ''
                    this.handlePin()

                    if (el.previousElementSibling) {
                        el.previousElementSibling.focus()
                        el.previousElementSibling.select()
                    }
                },
                handlePin() {
                    this.value = this.inputs.join('')

                    this.value.length === {{ $length }}
                        ? this.$dispatch('completed', this.value)
                        : this.$dispatch('incomplete', this.value)
                }
        }"
        >
            @if (gettype($title) === 'object')
            <header {{ $title->attributes->class(['font-base text-lg'])->merge() }}>{{ $title }}</header>
            @elseif ($title)
            <header class="font-base text-lg">{{ $title }}</header>
            @endif
            
            <div 
                id="{{ $id }}"
                @class(["flex items-center justify-start", "join" => $noGap, "gap-3" => !$noGap])
            >
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
                @foreach(range(0, $length - 1) as $i)
                    <input
                        @style([
                            $hide ? "text-security: $hideType;
                                    -webkit-text-security: $hideType;
                                    -moz-text-security $hideType;
                                    " : "",
                        ])
                        id="{{ $id }}-{{ $i }}"
                        maxlength="1"
                        x-model="inputs[{{ $i }}]"
                        @keydown.space.prevent
                        @keydown.backspace.prevent="remove($event.target, {{ $i }})"
                        @input="next($event.target)"
                        @if($numeric)
                            inputmode="numeric"
                            x-mask="9"
                        @endif
                        {{
                            $attributes->except(['name', 'color'])->whereDoesntStartWith('wire')->class([
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
                @endforeach
                @if (gettype($icon) === 'object')  
                <div {{ $icon->attributes->class(['flex order-first']) }}>
                    {{ $icon }}
                </div>
                @endif
                @if (gettype($label) === 'object')
                <div {{ $label->attributes->class(['label-text flex order-first']) }}>
                    {{ $label }}
                </div>
                @endif
                {{ $slot }}
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
            <input {{ $attributes->only(['name']) }}" class="hidden" x-bind:value="value"/>

            @if (gettype($helper) === 'object')
                <span {{
                    $helper->attributes->class([
                        'helper-text text-sm text-gray-500',
                    ])->merge()
                }}>{{ $helper }}</span>
            @elseif ($helper)
                <span class="helper-text text-sm text-gray-500">{{ $helper }}</span>
            @endif

        </div>
        HTML;
    }
}
