<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public mixed  $figure      = null,
        public mixed  $title       = null,
        public mixed  $description = null,
        public mixed  $actions     = null,
        public bool   $horizontal  = false,
        public bool   $separators  = false
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div {{
            $attributes->class([
                'card bg-base-100 shadow-xl',
                'card-side' => $horizontal
            ])->merge()
        }}> 
            @if ($figure)
            <figure {{
                $figure->attributes->class([
                ])->merge()
            }}>
                {{ $figure }}
            </figure>
            @endif
            <div class="card-body">
                @if ($title)
                    @if (gettype($title) === 'string')
                        <h2>{{ $title }}</h2>
                    @else
                        <h2 {{ $title->attributes->class(["card-title"])->merge() }}>{{ $title }}</h2>
                    @endif
                    @if ($separators)
                        <hr class="mt-3 border-t-[length:var(--border)] border-base-content/10">
                    @endif
                @endif
                @isset($description)
                    <p>{{ $description }}</p>
                @endisset
                @if (gettype($slot) === 'string')
                    <p>{{ $description ?? $slot }}</p>
                @else
                    <div {{ $slot->attributes }}>
                        {{ $slot }}
                    </div>
                @endif
                @if ($actions)
                    @if ($separators)
                        <hr class="mt-3 border-t-[length:var(--border)] border-base-content/10">
                    @endif
                    <div class="card-actions justify-end">
                        {{ $actions }}
                    </div>
                @endif
            </div>
        </div>
        HTML;
    }
}
