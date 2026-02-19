<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

use AllYouNeed\AdvancedControls\ComponentIndex;

class Tabs extends Component
{
    public string $id;
    public object $showIndex;
    public bool $vertical;
    public ComponentAttributeBag  $tabAttributes;

    public function __construct(
        ?string $id = null,
        public mixed   $tabs     = null,
               bool    $vertical = false,
        public ?string $variant  = null,
        public ?string $size     = null,
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = uniqid();

        $this->vertical = $vertical;
        $this->showIndex = new ComponentIndex();
        if ($vertical)
            $this->tabAttributes = new ComponentAttributeBag([]);
        else
            $this->tabAttributes = new ComponentAttributeBag([]);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div 
            {{ $attributes->class([
                'tabs [&>.tab-content]:hidden *:[.tab:has(:checked)_+_.tab-content]:block',
                'tabs-border'                              => $variant === 'border' && !$vertical,
                '[&>.tab]:border-e-3 [&>.tab]:has-checked:border-e-current' => $variant === 'border' && $vertical,
                'tabs-bordered'                            => $variant === 'border',
                'tabs-lift tabs-lifted'                    => $variant === 'lift',
                'tabs-box'                                 => $variant === 'box',
                '[&>.tab-content]:mt-0'                    => $variant === 'box' && $vertical,
                'tabs-vertical'                            => $vertical,
                'tabs-xs'                                  => $size === 'xs',
                'tabs-sm'                                  => $size === 'sm',
                'tabs-md'                                  => $size === 'md',
                'tabs-lg'                                  => $size === 'lg',
                'tabs-xl'                                  => $size === 'xl',
                'flex flex-wrap before:[&>.tab]:border-b-3'               => !$vertical,
                'grid grid-cols-[auto_1fr] grid-flow-col items-stretch before:[&>.tab]:border-e-3' => $vertical,
            ])->merge() }}
            style="grid-template-rows: repeat({{ $showIndex->count() }}, minmax(0, 1fr))"
        >
            {{ $slot }}
        </div>

        HTML;
    }
}
