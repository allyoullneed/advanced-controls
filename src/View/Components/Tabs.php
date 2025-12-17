<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Tabs extends Component
{
    public string $id;
    public bool $vertical = false;
    public bool $checked = false;

    public function __construct(
        ?string $id = null
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = uniqid();
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        @php
        @endphp
        <div 
            {{ $attributes->class([
                'tabs *:p-2 md:*:p-6 flex',  
                '[&>.tab]:before:absolute [&>.tab]:before:bottom-0 [&>.tab]:before:grow [&>:.tab]:before:w-[80%] [&>.tab]:before:h-[3px] [&>.tab]:before:bg-black',
                'before:[&>.tab]:border-b-3' => !$vertical,
                'before:[&>.tab]:border-e-3' => $vertical
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
