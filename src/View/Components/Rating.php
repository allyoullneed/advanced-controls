<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Rating extends Component
{
    public function __construct(
        public ?string $id = null,
        public int     $maxValue     = 5,
        public int     $value        = 0,
        public mixed   $svg          = null,
        public mixed   $title        = null,
        public mixed   $label        = null,
        public ?string $color        = null,
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = 'rating-' . uniqid();
    }
    
    public function render(): View|Closure|string
    {
        return <<<'HTML'
       
        @if ($svg)
            <div x-data="{ currentVal: {{ $value }} }" class="flex items-center gap-1">
                @for ($i = 1; $i <= $maxValue; $i++)
                <label for="star-{{ $i }}" class="transition cursor-pointer hover:scale-125 has-focus:scale-125">
                    <span class="sr-only">{{ $i }} star{{ $i > 1 ? 's' : '' }}</span>
                    <input x-model="currentVal" id="star-{{ $i }}" type="radio" class="sr-only" value="{{ $i }}"
                        name="{{ $attributes['name'] ?? $id }}" />
                    @if (gettype($svg) === 'boolean')
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor" class="size-5" x-bind:class="currentVal >= {{ $i }} ? 'text-amber-500' : 'text-onSurface dark:text-onSurfaceDark'">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd">
                    </svg>
                    @else
                        {!! $svg !!}
                    @endif
                </label>
                @endfor
            </div>
        @else
            <div class="rating">
                @for ($i = 1; $i <= $maxValue; $i++)
                    <input type="radio"
                    :name="$id"
                    {{ $attributes->only([
                        'name', 'mask   '
                        ])->merge()}}
                    name="{{ $attributes['name'] ?? $id }}" class="mask mask-star-2 bg-orange-400" aria-label="{{ $i }} star" />
                @endfor
            </div>
        @endif
        HTML;
    }
}
