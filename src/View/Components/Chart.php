<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Chart extends Component
{
    public string $id;
    public function __construct(
               ?string     $id          = null,
        public ?string     $title       = null,
        public string      $type        = 'line',
        public bool        $showLegend  = false,
        public array       $labels      = [],
        public array       $datasets    = [],
        public array       $options     = [],
        public array       $plugins     = [],
        public array       $include     = [],
        public bool|string $darkClass   = false
    ) {
        if ($id)
            $this->id = $id;
        else
            $this->id = 'chart_' . uniqid();
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div class="relative">
        <canvas @class([
            'dark:invert dark:hue-rotate-180' => gettype($darkClass) === 'boolean' && $darkClass,
            $darkClass => gettype($darkClass) === 'string'
        ]) id="{{ $id }}"></canvas>
        </div>

        <script>
            fetch("https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js", { cache: 'force-cache' })
            .then((response) => response.text())
            .then((text) => eval(text))
            .then(() => {
                @if ($include)
                    Promise.all([
                        {!! implode(',', array_map(fn ($lib) => 'fetch("' . $lib . '", { cache: "force-cache" }).then((response) => response.text()).then((text) => eval(text))', $include)) !!}
                    ]).then(() => {
                        new Chart(document.getElementById('{{ $id }}'), {
                            plugins: [{{ implode(',', $plugins) }}],
                            type: '{{ $type }}',
                            data: {
                                labels: {!! json_encode($labels) !!},
                                datasets: {!! json_encode($datasets) !!}
                            }, 
                            @if ($options)
                                options: {!! json_encode($options) !!}
                            @endif
                        });
                    });
                @else
                    new Chart(document.getElementById('{{ $id }}'), {
                        plugins: [{{ implode(',', $plugins) }}],
                        type: '{{ $type }}',
                        data: {
                            labels: {!! json_encode($labels) !!},
                            datasets: {!! json_encode($datasets) !!}
                        }, 
                        @if ($options)
                            options: {!! json_encode($options) !!}
                        @endif
                    });
                @endif
            })
        </script>
        HTML;
    }
}
