<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use AllYoullNeed\AdvancedControls\ComponentIndex;

use Illuminate\View\Component;

class Rating extends Component
{
    public string $id;
    public string $name;
    public ?string                $size;
    public object|int|string|null $showIndex;

    public function __construct(
        ?string $id = null,
        ?string $name = null,
        public int                      $maxValue = 5,
        public int                      $value    = 0,
               ?string                  $size     = null,
        public array|object|string|null $svg      = null,
        public bool|string              $mask     = false,
        public mixed                    $title    = null,
        public mixed                    $label    = null,
        public ?string                  $color    = null,
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = 'rating-' . uniqid();
        $this->name = $name ?? $this->id;
        $this->size = $size;
        $this->showIndex = new ComponentIndex();
    }
    
    public function render(): View|Closure|string
    {
        return <<<'HTML'
       
        <div x-data="{ rating: {{ $value }} }"
            {{ $attributes->except(['name'])->class([
                'flex flex-row items-center' => !$mask,
                'rating' => $mask,
                'rating-xl' => $size === 'xl',
                'rating-lg' => $size === 'lg',
                'rating-md' => $size === 'md',
                'rating-sm' => $size === 'sm',
                'rating-xs' => $size === 'xs'
            ])->merge() }}>
            @if ($mask)
                @for ($i = 1; $i <= $maxValue; $i++)
                    <input type="radio"
                    name="{{ $id }}"
                    value="{{ $i }}"
                    x-model="rating"
                    {{ $attributes->only([
                        'class', 'name'
                        ])->class([
                            'mask star',
                            'bg-orange-400'   => $color === null,
                            'bg-neutral'      => $color === 'neutral',
                            'bg-primary'      => $color === 'primary',
                            'bg-secondary'    => $color === 'secondary',
                            'bg-accent'       => $color === 'accent',
                            'bg-info'         => $color === 'info',
                            'bg-success'      => $color === 'success',
                            'bg-warning'      => $color === 'warning',
                            'bg-error'        => $color === 'error',
                            'mask-decagon'    => $mask === 'decagon',
                            'mask-diamond'    => $mask === 'diamond',
                            'mask-heart'      => $mask === 'heart',
                            'mask-hexagon'    => $mask === 'hexagon',
                            'mask-hexagon-2'  => $mask === 'hexagon-2',
                            'mask-pentagon'   => $mask === 'pentagon',
                            'mask-star'       => $mask === 'start',
                            'mask-star-2'     => $mask === 'star-2' || gettype($mask) !== 'string',
                            'mask-squircle'   => $mask === 'squircle',
                            'mask-triangle'   => $mask === 'triangle',
                            'mask-triangle-2' => $mask === 'triangle-2',
                            'mask-triangle-3' => $mask === 'triangle-3',
                            'mask-triangle-4' => $mask === 'triangle-4',
                        ])->merge()}}
                    name="{{ $attributes['name'] ?? $id }}"
                    aria-label="{{ $i }} star{{ $i != 1 ? 's' : '' }}" />
                @endfor
            @elseif ($slot->isNotEmpty())
                {{ $slot }}
            @else
                <div @class([
                    'flex flex-row items-center',
                ])>
                @for ($i = 1; $i <= $maxValue; $i++)
                <label for="{{ $id }}-{{ $i }}" @class([
                    'transition cursor-pointer hover:scale-125',
                    ])
                    x-bind:class="rating >= {{ $i }} || 'opacity-20'">
                    <input x-model="rating" id="{{ $id }}-{{ $i }}" type="radio" class="sr-only" value="{{ $i }}"
                        name="{{ $attributes['name'] ?? $id }}"
                        aria-label="{{ $i }} star{{ $i != 1 ? 's' : '' }}"
                        />
                    @if (gettype($svg) === 'object')
                        {!! $svg !!}
                    @elseif (gettype($svg) === 'array')
                        @php
                            $star = $svg[($i - 1) % count($svg)]
                        @endphp
                        @if (gettype($star) === 'object')
                            {!! $star !!}
                        @elseif (gettype($star) === 'string')
                            <x-icon
                                name="{{ $star }}"
                                @class([
                                    'size-8' => $size === 'xl',
                                    'size-7' => $size === 'lg',
                                    'size-6' => $size === 'md' || $size === null,
                                    'size-5' => $size === 'sm',
                                    'size-4' => $size === 'xs',
                                    'text-neutral'      => $color === 'neutral',
                                    'text-primary'      => $color === 'primary',
                                    'text-secondary'    => $color === 'secondary',
                                    'text-accent'       => $color === 'accent',
                                    'text-info'         => $color === 'info',
                                    'text-success'      => $color === 'success',
                                    'text-warning'      => $color === 'warning',
                                    'text-error'        => $color === 'error'
                                ]) />
                        @else
                            <x-icon @class([
                                'size-8' => $size === 'xl',
                                'size-7' => $size === 'lg',
                                'size-6' => $size === 'md' || $size === null,
                                'size-5' => $size === 'sm',
                                'size-4' => $size === 'xs',
                                'text-neutral'      => $color === 'neutral',
                                'text-primary'      => $color === 'primary',
                                'text-secondary'    => $color === 'secondary',
                                'text-accent'       => $color === 'accent',
                                'text-info'         => $color === 'info',
                                'text-success'      => $color === 'success',
                                'text-warning'      => $color === 'warning',
                                'text-error'        => $color === 'error'
                            ]) name="heroicon-s-star"/>
                        @endif
                    @elseif (gettype($svg) === 'string')
                        <x-icon
                            name="{{ $svg }}"
                            @class([
                                'size-8' => $size === 'xl',
                                'size-7' => $size === 'lg',
                                'size-6' => $size === 'md' || $size === null,
                                'size-5' => $size === 'sm',
                                'size-4' => $size === 'xs',
                                'text-neutral'      => $color === 'neutral',
                                'text-primary'      => $color === 'primary',
                                'text-secondary'    => $color === 'secondary',
                                'text-accent'       => $color === 'accent',
                                'text-info'         => $color === 'info',
                                'text-success'      => $color === 'success',
                                'text-warning'      => $color === 'warning',
                                'text-error'        => $color === 'error'
                            ]) />
                    @else
                        <x-icon @class([
                            'size-8' => $size === 'xl',
                            'size-7' => $size === 'lg',
                            'size-6' => $size === 'md' || $size === null,
                            'size-5' => $size === 'sm',
                            'size-4' => $size === 'xs',
                            'text-neutral'      => $color === 'neutral',
                            'text-primary'      => $color === 'primary',
                            'text-secondary'    => $color === 'secondary',
                            'text-accent'       => $color === 'accent',
                            'text-info'         => $color === 'info',
                            'text-success'      => $color === 'success',
                            'text-warning'      => $color === 'warning',
                            'text-error'        => $color === 'error'
                        ]) name="heroicon-s-star"/>
                    @endif
                </label>
                @endfor
                </div>

            @endif
        </div>
        HTML;
    }
}
