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
        @once
        <style>
            .skewed-gallery {
                display: grid;
                grid-auto-flow: column;
                place-items: center;
                overflow: hidden;
            } .skewed-gallery > * {
                min-width: calc(100% + var(--skew, 100px));
                height: 0;
                min-height: 100%;
                object-fit: cover;
                clip-path: polygon(var(--skew, 100px) 0, 100% 0, calc(100% - var(--skew, 100px)) 100%, 0 100%);
                cursor: pointer;
                display:inline-block;
                vertical-align: middle;
            } .skewed-gallery > *:first-child {
                min-width: calc(100% + var(--skew, 100px)/2);
                place-self: start;
                clip-path: polygon(0 0, 100% 0, calc(100% - var(--skew, 100px)) 100%, 0 100%);
            } .skewed-gallery > *:last-child {
                min-width: calc(100% + var(--skew, 100px)/2);
                place-self: end;
                clip-path: polygon(var(--skew, 100px) 0, 100% 0, 100% 100%, 0 100%);
            } .skewed-gallery.skewed-left > * {
                min-width: calc(100% + var(--skew, 100px));
                height: 0;
                min-height: 100%;
                object-fit: cover;
                clip-path: polygon(0 0, calc(100% - var(--skew, 100px)) 0, 100% 100%, var(--skew, 100px) 100%);
                cursor: pointer;
                transition: .5s;
                display: inline-block;
                vertical-align: middle;
            } .skewed-gallery.skewed-left > *:first-child {
                min-width: calc(100% + var(--skew, 100px)/2);
                clip-path: polygon(0 0, calc(100% - var(--skew, 100px)) 0, 100% 100%, 0 100%);
            } .skewed-gallery.skewed-left > *:last-child {
                min-width: calc(100% + var(--skew, 100px)/2);
                clip-path: polygon(0 0, 100% 0, 100% 100%, var(--skew, 100px) 100%);
            }
        </style>
        @endonce
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
