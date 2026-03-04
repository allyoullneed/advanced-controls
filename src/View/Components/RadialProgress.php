<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class RadialProgress extends Component
{
    public function __construct(
        public int     $value        = 0,
    ) {
    }
    
    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div {{ $attributes->class(['radial-progress'])->style(['--value:' . $value])->merge() }} :aria-valuenow="$value" role="progressbar">{{ $value }}%</div>
        HTML;
    }
}
