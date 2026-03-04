<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Table extends Component
{

    public function __construct(
        public string|null $rows = null,
        public string|null $columns = null,
        public mixed $content = null
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div class="overflow-x-auto">
            <div {{ $attributes->class([
                'grid gap-x-4'
                ])-> merge() }}
                @style([
                    'grid-template-columns:' . $columns                     => !is_numeric($columns),
                    'grid-template-columns: repeat(' . $columns . ', auto)' => is_numeric($columns),
                    'grid-template-rows:' . $rows                           => !is_numeric($rows),
                    'grid-template-rows: repeat(' . $rows . ', auto)'       => is_numeric($rows),
                ])
                >
                <div class="grid col-span-full row-start-1 row-span-4 grid-cols-subgrid">
                {{ $slot }}
                </div>
                <div class="pointer-events-none select-none grid col-span-full row-start-1 row-span-4 grid-cols-subgrid [&>div_+_div]:border-s-1 [&>div_+_div]:border-base-300">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        HTML;
    }
}
