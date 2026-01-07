<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class MenuItem extends Component
{
    public function __construct(
        public ?string $label = null,
        public mixed   $icon  = null,
        public ?string $href  = null,
        public bool $collapsible = false,
        public bool $title = false
    ) {
        $this->label       = $label;
        $this->collapsible = $collapsible;
        $this->title       = $title;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @if ($label || !$slot->isEmpty())
        <li 
            {{ $attributes->except(['wire:navigate', 'wire:navigate.hover', 'open', 'title'])->merge() }}
            >
            @if ($label && !$slot->isEmpty())
                @if ($collapsible)
                    <details class="inline-block"
                        {{ $attributes->only(['open'])}}
                        >
                        <summary 
                            {{ $attributes->class([
                                'select-none',
                                'menu-title' => $title
                                ])->merge()->except(['open', 'title']) }}
                        >
                            @if (gettype($icon) === 'string')
                                <x-icon class="h-lh" :name="$icon"/>
                            @else
                                {{ $icon }}
                            @endif
                            {{ $label }}
                        </summary>
                        {{ $slot }}
                        </details>
                @else
                    <a
                        href="{{ $href }}"
                        {{ $attributes->class([
                                'select-none',
                            'menu-title' => $title
                        ]) }}
                    >
                        @if (gettype($icon) === 'string')
                            <x-icon class="h-lh" :name="$icon"/>
                        @else
                            {{ $icon }}
                        @endif
                        {{ $label }}
                    </a>
                    {{ $slot }}
                @endif
            @elseif ($label)
                <a href="{{ $href }}" {{ $attributes->only((['wire:navigate', 'wire:navigate.hover'])) }}>
                    @if (gettype($icon) === 'string')
                        <x-icon class="h-lh" :name="$icon"/>
                    @else
                        {{ $icon }}
                    @endif
                    {{ $label }}
                </a>
            @else
                <a href="{{ $href }}" {{ $attributes->only((['wire:navigate', 'wire:navigate.hover'])) }}>
                    @if (gettype($icon) === 'string')
                        <x-icon class="h-lh" :name="$icon"/>
                    @else
                        {{ $icon }}
                    @endif
                    {{ $slot }}
                </a>
            @endif
            </li>
        @endif
        HTML;
    }
}
