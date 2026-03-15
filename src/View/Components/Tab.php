<?php

namespace AllYouNeed\AdvancedControls\View\Components;

use Illuminate\View\Component;

class Tab extends Component
{
    public function __construct(
        public  mixed $label,
        public ?string $icon    = null
    ) {
        $this->icon = $icon;
        $this->label = $label;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @aware(['id', 'showIndex', 'tabAttributes', 'vertical'])
        @php
            $index = $showIndex?->increment();
        @endphp
        <label
            {{ (gettype($label) === 'object' ? $label->attributes : $attributes->only(['style']))->class([
                'tab whitespace-nowrap has-checked:tab-active flex items-center',
                'rounded-b-none' => $slot->isNotEmpty(),
                'col-start-1' => $vertical,
            ]) }}
        >
            <input class="appearance-none" type="radio" name="{{ $id }}" id="{{ $id }}-{{ $index }}" onfocus="this.blur()" @if ($index === 1) checked @endif/>
            @if ($icon)
                <x-icon :name="$icon" class="size-4 me-2"/>
            @endif
            {{ $label }}
        </label>
        @if ($slot->isNotEmpty())
        <div
            {{ $attributes->class([
                'tab-content w-full self-stretch order-1',      
                'col-start-2 row-span-3 h-auto' => $vertical,
                '-mt-px' => $vertical && $slot->isNotEmpty(),
            ])->merge($tabAttributes->getAttributes()) }}
        >
            {{ $slot }}
        </div>
        @endif

        HTML;
    }

        //     <div
        //     {{ $attributes->class([
        //         'tab-content w-full self-stretch -mt-px order-1',
        //         'col-start-2 row-span-3 h-auto' => $vertical,
        //     ])->merge($tabAttributes->getAttributes()) }}
        // >
        //     {{ $slot }}
        // </div>
}
