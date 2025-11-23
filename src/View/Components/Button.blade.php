<?php
namespace AllYouNeed\AdvancedControls\View\Components;

use Livewire\Component;

class Button extends Component
{
    //

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <button class="btn">
                <span class="loading loading-spinner"></span>
            
                {{ $slot }}
            </button>
        HTML;
    }
};
