<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public  mixed  $figure = null
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div class="card bg-base-100 w-96 shadow-sm">
        @if ($figure)
        <figure>
            {{ $figure }}
        </figure>
        @endif
        <div class="card-body">
            <h2 class="card-title">Card Title</h2>
            <p>{{ $slot }}</p>
            <div class="card-actions justify-end">
            <button class="btn btn-primary">Buy Now</button>
            </div>
        </div>
        </div>
        HTML;
    }
}
