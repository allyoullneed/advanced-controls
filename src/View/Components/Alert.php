<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Alert extends Component
{
    public function __construct(
        public ?string $title       = null,
        public ?string $description = null,
        public ?string $color       = null,
        public ?string $type        = null,
        public ?string $variant       = null,
        public  mixed  $icon        = null
    ) {
        if ($type === 'info' || $type === 'success' || $type === 'warning' || $type === 'error')
            $this->type = $type;
        if ($variant === 'soft' || $variant === 'outline' || $variant === 'dash')
            $this->variant = $variant;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div
            {{ $attributes->class([
                'alert pb-0',
                'flex gap-4'             => $icon !== '',
                'alert-primary'          => ($type ?? $color) === 'primary',
                'alert-info'             => ($type ?? $color) === 'info',
                'alert-success'          => ($type ?? $color) === 'success',
                'alert-warning'          => ($type ?? $color) === 'warning',
                'alert-error'            => ($type ?? $color) === 'error',
                'alert-soft'             => $variant === 'soft',
                'alert-outline'          => $variant === 'outline',
                'alert-dash alert-outline border-dashed' => $variant === 'dash'
                ])->merge() }}
            role="alert"
        >
            @if (isset($icon) && $icon !== "")
                @if (gettype($icon) === 'string')
                    <x-icon :name="$icon" class="mb-4 shrink-0 size-6"/>
                @else
                    <div
                        {{ $icon->attributes->merge(['class' => 'mb-4']) }}
                    >
                    {{ $icon }}
                    </div>
                @endif
            @elseif ($type === 'success')
                <x-icon name="heroicon-o-check-circle" class="mb-4 shrink-0 size-6"/>
            @elseif ($type === 'warning')
                <x-icon name="heroicon-o-exclamation-triangle" class="mb-4 shrink-0 size-6"/>
            @elseif ($type === 'error')
                <x-icon name="heroicon-o-x-circle" class="mb-4 shrink-0 size-6"/>
            @elseif (($type === "" || $type === "info") && $icon === null)
                <x-icon name="heroicon-o-information-circle" class="mb-4 shrink-0 size-6"/>
            @endif
            <div class="basis-full mb-4 block">
                @if ($title)
                    <span class="block font-bold">{{ $title }}</span>
                @endif
                    <span 
                        {{ $attributes->class(['text-xs' => $title != null])->merge() }}
                    >
                        @if ($description)
                            {{ $description }}
                        @endif
                        {{ $slot }}
                    </span>
            </div>
            @if (isset($actions))
                <div 
                    {{ $actions->attributes->class([
                        'flex gap-2 mb-4 justify-self-end ayn-child:[:where(.btn)]:btn-sm'
                    ])->merge() }}
                >
                {{ $actions }}
                </div>
            @endif

        </div>
        HTML;
    }
}
