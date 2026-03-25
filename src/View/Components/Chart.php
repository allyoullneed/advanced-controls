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
        @once
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @endonce
        @foreach ($include as $additionalScript)
        <script src="{{ $additionalScript }}"></script>
        @endforeach
        <div class="relative">
        <canvas @class([
            'dark:invert dark:hue-rotate-180' => gettype($darkClass) === 'boolean' && $darkClass,
            $darkClass => gettype($darkClass) === 'string'
        ]) id="{{ $id }}"></canvas>
        </div>

        <script>
        const {{ $id }} = document.getElementById('{{ $id }}');



        new Chart({{ $id }}, {
            plugins: [{{ implode(',', $plugins) }}],
            type: '{{ $type }}',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: {!! json_encode($datasets) !!}
            }, 
            @if ($options)
                options: {!! json_encode($options) !!}
            @else
                options: {
                    plugins: {
                        legend: {
                            display: {{ $showLegend ? 'true' : 'false' }},
                        },
                        @if ($title)
                        title: {
                            display: true,
                            text: '{{ $title }}',
                            padding: {
                                top: 10,
                                bottom: 30
                            }
                        }
                        @endif
                    },
                    scales: {
                        y: {
                        beginAtZero: true
                        }
                    },
                    tooltip: {
                        enabled: false
                    }
                }
            @endif
        });
        </script>
        HTML;
    }
}
