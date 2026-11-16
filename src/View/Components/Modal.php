<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public ?string $id = null
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = 'modal' . uniqid();
    }
    
    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <dialog id="{{ $id }}"
        {{ $attributes->class([
            'modal'
            ])->merge()
        }}>
            {{ $slot }}
        </dialog>
        HTML;
    }
}
