<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Row extends Component
{
    public ?string $label = null;
    
    public function __construct(
        public bool $collapsible = false,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @aware(['rowSeparator'])
        @renderif ($collapsible)
            <x-collapse @class([
                'col-span-full grid grid-cols-subgrid items-center-safe [&>input]:col-span-full'
                ])
                :keep-open="$attributes->has('keep-open')"
                :arrow="$attributes->has('arrow')"
                :plus="$attributes->has('plus')"
                :label="gettype($label) === 'object' ? $label->withAttributes($label->attributes->merge(['class' => 'col-span-full grid grid-cols-subgrid items-center-safe p-0'])->getAttributes()) : $label"
            >
                <x-slot @class(['col-span-full grid grid-cols-subgrid items-center-safe -mx-4'])>
                    {{ $slot }}
                </x-slot>
                
            </x-collapse>
        @endrenderif
        @renderif (!$collapsible)
            {{ $attributes->has('subrow') }}
            <div {{ $attributes->class([
                    'col-span-full grid grid-cols-subgrid items-center-safe px-4',
                    $rowSeparator
                ])->merge() }}>
                {{ $slot }}
            </div>
        @endrenderif
        HTML;
    }
}
