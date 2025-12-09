<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Alert extends Component
{
    public ?string $title       = null;
    public ?string $description = null;
    public ?string $type        = null;
    public ?string $style       = null;
    public  mixed $icon         = null;

    public function __construct(
        ?string $title,
        ?string $description,
        ?string $type  = null,
        ?string $style = null,
         mixed $icon  = null
    ) {
        $this->title = $title;
        $this->description = $description;
        if ($type === 'info' || $type === 'success' || $type === 'warning' || $type === 'error')
            $this->type = $type;
        if ($style === 'soft' || $style === 'outline' || $style === 'dash')
            $this->style = $style;
        $this->icon = $icon;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div
            {{ $attributes->class([
                'alert pb-0',
                'flex gap-4'             => $icon !== '',
                'alert-info'             => $type === 'info',
                'alert-success'          => $type === 'success',
                'alert-warning'          => $type === 'warning',
                'alert-error'            => $type === 'error',
                'alert-soft'             => $style === 'soft',
                'alert-outline'          => $style === 'outline',
                'alert-dash alert-outline border-dashed' => $style === 'dash'
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
            @elseif ($icon === null)
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
                        'flex gap-2 mb-4 justify-self-end ayn-child:where(.btn):btn-sm'
                    ])->merge() }}
                >
                {{ $actions }}
                </div>
            @endif

        </div>
        HTML;
    }
}
