<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

use AllYouNeed\AdvancedControls\ComponentIndex;

class Tabs extends Component
{
    public string $id;
    public ComponentIndex $showIndex;
    public bool $vertical;
    public ComponentAttributeBag  $tabAttributes;

    public function __construct(
        ?string $id = null,
        public mixed       $tabs     = null,
        public string|null $align    = null,
               bool        $vertical = false,
        public ?string     $variant  = null,
        public ?string     $size     = null,
        public bool        $fix      = false,
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
    
    // @style([
    //     'grid-template-columns: repeat(' . $showIndex->value() . ', auto) 1fr' => !$vertical
    // ])

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div 
            {{ $attributes->class([
                'tabs [&>.tab-content]:hidden *:[.tab:has(:checked)_+_.tab-content]:block',
                'tabs-border'                              => $variant === 'border' && !$vertical,
                '[&>.tab]:border-e-3 [&>.tab]:has-checked:border-e-current' => $variant === 'border' && $vertical,
                'tabs-bordered'                               => $variant === 'border',
                'tabs-lift tabs-lifted [&>label]:!border-b-0' => $variant === 'lift',
                'tabs-box'                                    => $variant === 'box',
                '[&>.tab-content]:mt-0'                       => $variant === 'box' && $vertical,
                '[&>.tab-content]:-mt-px'                     => $variant === 'lift' && !$vertical,
                'tabs-vertical'                               => $vertical,
                'tabs-xs'                                     => $size === 'xs',
                'tabs-sm'                                     => $size === 'sm',
                'tabs-md'                                     => $size === 'md',
                'tabs-lg'                                     => $size === 'lg',
                'tabs-xl'                                     => $size === 'xl',
                'justify-start'                               => $align === 'start',
                'justify-center'                              => $align === 'center',
                'justify-end'                                 => $align === 'end',
                '[&>.tab]:grow'                               => $align === 'stretch',
                'flex flex-wrap content-start before:[&>.tab]:border-b-3'               => !$vertical,
                'grid grid-cols-[auto_1fr] grid-flow-col items-stretch before:[&>.tab]:border-e-3' => $vertical,
                '[&>label]:has-checked:before:!w-[calc(100%_+_2_*_min(var(--radius-field,.375rem),.75rem)_-_1.5px)] [&>label]:before:!h-[min(var(--radius-field,.375rem),.75rem)] [&>label]:before:!bg-size-[min(var(--radius-field,.375rem),.75rem)]' => $fix,
                '[&>div]:rounded-box' => $fix,
                '[&>div]:rounded-[var(--radius-box)] [&>div]:first-of-type:rounded-ss-none' => $fix && $variant === 'lift' && ($align === null || $align === 'start' || $align === 'stretch'),
                '[&>label]:first-of-type:before:![--radius-start:radial-gradient(circle_at_top_left,_var(--tab-radius-grad))] [&>label]:first-of-type:before:![var(--radius-start),var(--radius-end)] [&>label]:before:!bg-position-[0_0,100%_0] [&>div]:rounded-[var(--radius-box)]' => $fix && $variant === 'lift' && ($align === 'center' || $align === 'end'),
                '[&>label]:last-of-type:before:!bg-(image:--radius-start) [&>div]:last-of-type:rounded-se-none' => $fix && $variant === 'lift' && ($align === 'end' || $align === 'stretch'),
            ])->merge() }}
        >
            {{ $slot }}
        </div>

        HTML;
    }
}
