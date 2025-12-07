<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class MenuItem extends Component
{
    public string $id;
    public bool $checked = false;

    public function __construct(
        ?string $id = null
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = uniqid();
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @aware(['anchor'])
        <li 
            {{ $attributes->except(['href', 'wire:navigate'])->class([
                'w-full'
                ])->merge()
            }}
            >
            <a>
                {{ $slot }}
                </a>
            </li>
        HTML;
    }
}
