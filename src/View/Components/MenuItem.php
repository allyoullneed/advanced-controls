<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class MenuItem extends Component
{
    public ?string $label;
    public bool $collapsible;
    public bool $title;
    


    public function __construct(
        ?string $label = null,
        ?bool $collapsible = false,
        ?bool $title = false
    ) {
        $this->label       = $label;
        $this->collapsible = $collapsible;
        $this->title       = $title;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @aware(['anchor'])
        <li 
            {{ $attributes->except(['href', 'wire:navigate', 'wire:navigate.hover', 'open', 'title'])->merge() }}
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
                        >{{ $label }}</summary>
                        {{ $slot }}
                        </details>
                @else
                    <a
                        {{ $attributes->class([
                                'select-none',
                            'menu-title' => $title
                        ]) }}
                    >{{ $label }}</a>
                    {{ $slot }}
                @endif
            @elseif ($label)
                <a {{ $attributes->only((['href', 'wire:navigate', 'wire:navigate.hover'])) }}>{{ $label }}</a>
            @else
                <a {{ $attributes->only((['href', 'wire:navigate', 'wire:navigate.hover'])) }}>{{ $slot }}</a>
            @endif
            </li>
        HTML;
    }
}
