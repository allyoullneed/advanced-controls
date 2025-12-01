<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Alert extends Component
{
    public ?string $title       = null;
    public ?string $description = null;
    public ?string $type        = null;
    public ?string $icon        = null;

    public function __construct(
        ?string $title,
        ?string $description,
        ?string $type = null
    ) {
        $this->title = $title;
        $this->description = $description;
        if ($type === 'info' || $type === 'success' || $type === 'warning' || $type === 'error')
            $this->type = $type;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div
            {{ $attributes->class([
                'alert',
                'alert-info' => $type === 'info',
                'alert-success' => $type === 'success',
                'alert-warning' => $type === 'warning',
                'alert-error' => $type === 'error',
                ])->merge() }}
            role="alert"
        >
            @if (isset($icon))
                <div
                    {{ $icon->attributes }}
                >
                {{ $icon }}
                </div>
            @elseif ($type === 'success')
                <x-icon name="heroicon-o-check-circle" class="w-6 aspect-square"/>
            @elseif ($type === 'warning')
                <x-icon name="heroicon-o-exclamation-triangle" class="w-6 aspect-square"/>
            @elseif ($type === 'error')
                <x-icon name="heroicon-o-x-circle" class="w-6 aspect-square"/>
            @else
                <x-icon name="heroicon-o-information-circle" class="w-6 aspect-square"/>
            @endif
            <div>
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
                        '*:btn-sm btn-outline justify-self-end'
                    ])->merge() }}
                >
                {{ $actions }}
                </div>
            @endif

        </div>
        HTML;
    }
}
