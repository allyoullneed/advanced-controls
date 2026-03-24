<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

use AllYoullNeed\AdvancedControls\ComponentIndex;

class Table extends Component
{
    public ?string $parentColor = null;
    public ?string $parentSize  = null;
    public string|null $rowSeparator;

    public function __construct(
        public object|null $header          = null,
        public ?string     $rows            = null,
        public ?string     $columns         = null,
               ?string     $rowSeparator    = null,
        public ?string     $columnSeparator = null,

        public ?string $color = null,
        public ?string $size = null,

        public bool        $zebra   = false,
    ) {
        $this->parentColor  = $color;
        $this->parentSize   = $size;
        $this->rowSeparator = $rowSeparator;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @php
            $rowCount = count(explode(' ', $rows)) ?? $rowIndex->value();
            $colCount = count(explode(' ', $columns));
        @endphp
        <div {{ $attributes->class([
            'grid gap-x-4 gap-y-0 rounded-box',
            ])-> merge() }}
            @style([
                'grid-template-columns:' . $columns                               => $columns && !is_numeric($columns),
                'grid-template-columns: repeat(' . $columns . ', minmax(0, 1fr))' => is_numeric($columns),
            ])
            >
            
            @if ($columnSeparator)
                <div @class([
                    'pointer-events-none select-none grid col-span-full row-start-1 row-end-3 row-span-full grid-cols-subgrid gap-x-[inherit] gap-y-[inherit]',
                    'ayn-child:border-e-1 *:border-s-0 *:border-b-0 *:border-t-0',
                ])>
                    @for($i = 1; $i < $colCount; $i++)
                        <div @class(['row-start-1 row-end-1', $columnSeparator])></div>
                    @endfor
                </div>
            @endif

            @if ($header)
                <div {{ $header->attributes->class([
                    "grid col-span-full row-start-1 grid-cols-subgrid items-center gap-x-[inherit] gap-y-0 ayn-child:py-3",
                    'ayn-child:border-b-1 *:border-s-0 *:border-e-0 *:border-t-0' => $rowSeparator
                ])->merge() }}>
                    {{ $header }}
                </div>
            @endif

            <div @class([
                "grid col-span-full grid-cols-subgrid items-center gap-x-[inherit] gap-y-[inherit] ayn-child:py-3",
                'row-start-1' => !$header,
                'row-start-2' => $header,
                'ayn-child:border-b-1 *:last:border-b-0 *:border-s-0 *:border-e-0 *:border-t-0' => $rowSeparator,
                '[&>div:nth-child(even)]:bg-base-300/50' => $zebra
            ])>
            {{ $slot }}
            </div>

        </div>
        HTML;
    }
}
