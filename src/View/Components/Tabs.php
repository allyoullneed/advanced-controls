<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Tabs extends Component
{
    public string $id;
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
        <div class="tabs tabs-border">
            {{ $slot }}
            <script>
                document.currentScript.parentElement.getElementsByClassName('tab')[0].firstElementChild.setAttribute('checked', true);
            </script>
        </div>

        HTML;
    }
}
