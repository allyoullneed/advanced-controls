<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Tabs extends Component
{
    public string $id;

    public function __construct(
        ?string $id = null,
        public bool $vertical   = false,
        public ?string $variant = null,
        public ?string $size    = null,
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = uniqid();
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div 
            {{ $attributes->class([
                'tabs [&>.tab-content]:p-2 md:[&>.tab-content]:p-6 [&>.tab-content]:hidden *:[.tab:has(:checked)_+_.tab-content]:block flex flex-wrap',
                'tabs-border tabs-bordered'          => $variant === 'border',
                'tabs-lift tabs-lifted'              => $variant === 'lift',
                'tabs-box'                           => $variant === 'box',
                'tabs-vertical'                      => $vertical,
                'tabs-xs'                            => $size === 'xs',
                'tabs-sm'                            => $size === 'sm',
                'tabs-md'                            => $size === 'md',
                'tabs-lg'                            => $size === 'lg',
                'tabs-xl'                            => $size === 'xl',
                'before:[&>.tab]:border-b-3'         => !$vertical,
                'before:[&>.tab]:border-e-3'         => $vertical,
            ])->merge() }}
        >
            {{ $slot }}
            <script>
                document.currentScript.parentElement.getElementsByClassName('tab')[0].firstElementChild.setAttribute('checked', true);
            </script>
        </div>

        HTML;
    }
}
