<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Skeleton extends Component
{
    public function __construct() { }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @if ($slot->isEmpty())
            <div 
                {{ $attributes->class([
                    'skeleton'
                ])->merge() }}
            ></div>
        @else
            <span 
                {{ $attributes->class([
                    'skeleton skeleton-text'
                ])->merge() }}
            >
                {{ $slot }}
            </span>
        @endif  

        HTML;
    }
}
