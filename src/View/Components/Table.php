<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

use AllYouNeed\AdvancedControls\ComponentIndex;

class Table extends Component
{
    public string|null $rowSeparator;

    public function __construct(
        public string|null $rows         = null,
        public string|null $columns      = null,
               string|null $rowSeparator = null,
        public string|null $columnSeparator = null,

        public bool        $zebra   = false,
    ) {
        $this->rowSeparator = $rowSeparator;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @php
            $rowCount = count(explode(' ', $rows)) ?? $rowIndex->value();
            $colCount = count(explode(' ', $columns));
        @endphp
        <div class="overflow-x-auto">
            <div {{ $attributes->class([
                'grid gap-x-4 gap-y-0',
                ])-> merge() }}
                @style([
                    'grid-template-columns:' . $columns                               => $columns && !is_numeric($columns),
                    'grid-template-columns: repeat(' . $columns . ', minmax(0, 1fr))' => is_numeric($columns),
                    
                ])
                >
                
                @if ($columnSeparator)
                    <div @class([
                        'pointer-events-none select-none grid col-span-full row-start-1 row-span-4 grid-cols-subgrid gap-x-[inherit] gap-y-[inherit]',
                        'ayn-child:border-e-1 *:border-s-0 *:border-b-0 *:border-t-0',
                    ])>
                        @for($i = 1; $i < $colCount; $i++)
                            <div @class(['row-start-1 row-end-1', $columnSeparator])></div>
                        @endfor
                    </div>
                @endif

                <div @class([
                    "grid col-span-full row-start-1 row-span-4 grid-cols-subgrid items-center gap-x-[inherit] gap-y-[inherit] ayn-child:py-3",
                    '[&>div:nth-child(odd):not(:first-child)]:bg-base-300/50' => $zebra,
                    'ayn-child:border-b-1 *:last:border-b-0 *:border-s-0 *:border-e-0 *:border-t-0' => $rowSeparator
                ])>
                {{ $slot }}
                </div>

            </div>
        </div>
        HTML;
    }
}
