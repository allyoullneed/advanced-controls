<?php

namespace AllYouNeed\AdvancedControls\View\Components;


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
        <dialog id="{{ $id }}" class="fixed max-w-none w-[100vw] max-h-none h-[100vh] place-items-center hidden open:grid bg-transparent open:bg-[#0006]">
            {{ $slot }}
        </dialog>
        HTML;
    }
}
