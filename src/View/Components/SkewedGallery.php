<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class SkewedGallery extends Component
{
    public function __construct(
        public string $skew = '100px',
        public bool $left = false,
        public array $pictures = []
    ) { }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div {{ $attributes->class([
                'skewed-gallery *:w-0',
                'skewed-left' => $left
            ])->merge() }}
            style="--skew:{{ $skew }}"
        >
            @if (count($pictures) > 0)
                @foreach ($pictures as $picture)
                    <img src="{{ $picture }}"/>
                @endforeach
            @else
                {{ $slot }}
            @endif
        </div>  
        HTML;
    }
}
