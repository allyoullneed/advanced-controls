<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Collapse extends Component
{
    public string $href;
    public ?string $label = null;
    public function __construct(
        string $href,
        ?string $label
    ) {
        $this->href = $href;
        $this->label = $label;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <button type="button" class="collapse-toggle btn btn-primary" id="shadow-collapse" aria-expanded="false" aria-controls="shadow-collapse-heading" data-collapse="#shadow-collapse-heading" >
        Collapse
        <span class="icon-[tabler--chevron-down] collapse-open:rotate-180 size-4"></span>
        </button>
        <div id="shadow-collapse-heading" class="collapse hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="shadow-collapse" >
            <div class="bg-primary/20 mt-3 rounded-md p-3">
                <p class="text-primary">
                The collapsible body remains concealed by default until the collapse plugin dynamically adds specific classes.
                These classes are instrumental in styling each element, dictating the overall appearance, and managing visibility
                through CSS transitions.
                </p>
            </div>
        </div>
        HTML;
    }
}
