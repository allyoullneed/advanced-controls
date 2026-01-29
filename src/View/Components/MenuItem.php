<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class MenuItem extends Component
{
    public function __construct(
        public ?string $label = null,
        public mixed   $icon  = null,
        public bool $collapsible = false,
        public bool $title = false
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @if ($label || !$slot->isEmpty())
        <li 
            {{ $attributes->except(['class', 'href', 'target', 'wire:navigate', 'wire:navigate.hover', 'wire:current', 'wire:current.ignore', 'open'])->merge() }}
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
                                ])->merge()->except(['open']) }}
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
                        {{ $attributes->only((['class', 'href', 'target', 'wire:navigate', 'wire:navigate.hover', 'wire:current', 'wire:current.ignore']))->class([
                            'min-w-max select-none',
                            'menu-title' => $title
                        ])->merge() }}
                    >
                        @if (gettype($icon) === 'string')
                            <x-icon class="h-lh" :name="$icon"/>
                        @else
                            {{ $icon }}
                        @endif
                        @if (gettype($label) === 'object')
                            <div {{ $label->attributes }}>
                                {{ $label }}
                            </div>
                        @else
                            {{ $label }}
                        @endif
                    </a>
                    {{ $slot }}
                @endif
            @elseif ($label)
                <a {{ $attributes->only((['class', 'href', 'target', 'wire:navigate', 'wire:navigate.hover', 'wire:current', 'wire:current.ignore']))->class([
                    'min-w-max select-none',
                    'menu-title' => $title
                ])->merge() }}>
                    @if (gettype($icon) === 'string')
                        <x-icon class="h-lh" :name="$icon"/>    
                    @else
                        {{ $icon }}
                    @endif
                    {{ $title }}{{ $label }}
                </a>
            @else
                <a {{ $attributes->only((['class', 'href', 'target', 'wire:navigate', 'wire:navigate.hover', 'wire:current', 'wire:current.ignore']))->class([
                    'min-w-max select-none',
                    'menu-title' => $title
                ])->merge() }}>
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
