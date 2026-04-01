<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Alert extends Component
{
    public function __construct(
        public ?string $title       = null,
        public ?string $description = null,
        public ?string $color       = null,
        public ?string $type        = null,
        public ?string $variant     = null,
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
                'alert grid grid-cols-1 justify-start gap-y-3',
                'alert-primary'          => ($type ?? $color) === 'primary',
                'alert-info'             => ($type ?? $color) === 'info',
                'alert-success'          => ($type ?? $color) === 'success',
                'alert-warning'          => ($type ?? $color) === 'warning',
                'alert-error'            => ($type ?? $color) === 'error',
                'alert-soft'             => $variant === 'soft' || $variant === 'ghost',
                'alert-outline'          => $variant === 'outline',
                'alert-dash alert-outline border-dashed' => $variant === 'dash'
                ])->merge() }}
            role="alert">
            <div
                @class([
                'alert grid-cols-1 p-0 border-none bg-transparent shadow-none',
                'alert-primary'          => ($type ?? $color) === 'primary',
                'alert-info'             => ($type ?? $color) === 'info',
                'alert-success'          => ($type ?? $color) === 'success',
                'alert-warning'          => ($type ?? $color) === 'warning',
                'alert-error'            => ($type ?? $color) === 'error',
                'alert-soft'             => $variant === 'soft' || $variant === 'ghost',
                'alert-outline'          => $variant === 'outline',
                'alert-dash alert-outline border-dashed' => $variant === 'dash'
                ])
                @if ($attributes->has(':class'))
                    :class="{!! $attributes->get(':class') !!}"
                @endif
            >
                <div class="flex items-start gap-4">
                    @if (isset($icon) && $icon !== "")
                        @if (gettype($icon) === 'string')
                            <x-icon :name="$icon" class="shrink-0 size-6"/>
                        @else
                            <div
                                {{ $icon->attributes}}
                            >
                            {{ $icon }}
                            </div>
                        @endif
                    @elseif ($type === 'info' || $type === 'success' || $type === 'warning' || $type === 'error')
                        <x-icon :name="config('advanced-controls.icon-packages')[config('advanced-controls.icons')][$type]" class="shrink-0 size-6"/>    
                    @elseif ($type === "" && $icon === null)
                        <x-icon :name="config('advanced-controls.icon-packages')[config('advanced-controls.icons')]['info']" class="shrink-0 size-6"/>
                    @endif
                    <div class="basis-fullblock self-center flex flex-col items-start">
                        @if ($title)
                            @if (gettype($title) === 'object')
                                <span {{
                                    $title->attributes->class([
                                        'block font-bold' => $description != null
                                    ])->merge()
                                }}>{{ $title }}</span>
                            @else
                                <span {{
                                    $attributes->except(['class'])->class([
                                        'block font-bold' => $description != null
                                    ])
                                }}>{{ $title }}</span>
                            @endif
                        @endif
                        @if (gettype($description) === 'object' && $slot->isNotEmpty())
                            <span {{ $attributes->except(['class'])->class(['text-xs' => $title != null])->merge() }}>
                                <span {{ $description->attributes->class(['text-xs' => $title != null])->merge() }}>
                                    {{ $description }}
                                </span>
                                {{ $slot }}
                            </span>
                        @elseif (gettype($description) === 'object')
                            <span {{ $description->attributes->class(['text-xs' => $title != null])->merge() }}>
                                {{ $description }}
                            </span>
                        @elseif ($description || $slot->isNotEmpty())
                            <span {{ $attributes->except(['class'])->class(['text-xs' => $title != null])->merge() }}>
                                {{ $description }}
                                {{ $slot }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @if (isset($actions))
                <div 
                    {{ $actions->attributes->except(['class'])->class([
                        'ayn-child:[:where(.btn)]:btn-sm'
                    ])->merge() }}
                >
                {{ $actions }}
                </div>
            @endif
        </div>
        HTML;
    }
}
