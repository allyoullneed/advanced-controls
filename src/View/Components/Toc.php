<?php

namespace AllYoullNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Toc extends Component
{
    public function __construct(
        public ?string $title    = null,
        public mixed   $headings = [],
        public string $color = "neutral",
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <nav aria-hidden="true"
            {{ $attributes->class(['toc pointer-events-none'])->merge() }}
            style="--toc-border-highlight: var(--color-{{ $color ?? 'accent' }})" 
        >
            <x-menu @class([
                "!gap-0 bg-base-100 pointer-events-auto ayn-child:border-base-content/10 sticky top-24",
                "[&>li]:border-s-3" => !$title,
                "[&>li:not(:first-child)]:border-s-3" => $title,
            ])>
                @if ($title)
                    <x-menuItem title class="py-1 text-lg" style="font-variant-caps: small-caps">
                        {{ $title }}
                    </x-menuItem>
                @endif
                @foreach ($headings as $heading)
                    <x-menuItem
                        id="toc-{{ $heading['anchor'] }}"
                        @class([
                            "py-1 whitespace-nowrap block hover:text-primary transition-colors",
                            "text-sm" => $heading['level'] > 1,
                            "text-lg" => $heading['level'] == 1
                        ])
                        @style(['padding-inline-start: ' . ($heading['level'] - 2) . 'rem' => $heading['level'] > 2])
                        onclick="document.getElementById('{{ $heading['anchor'] }}').scrollIntoView({ behavior: 'smooth' });"
                        :label="$heading['label']"
                    />
                @endforeach
                {{ $slot }}
            </x-menu>
        </nav>
        @once
        <script>
            window.addEventListener('livewire:navigated', function() {

                const anchors = [...document.querySelectorAll('article>h1,article>article>h1>div,article>h2>div,article>h3>div,article>h4>div,article>h5>div,article>h6>div')].reverse();
                const tocs = [...document.querySelectorAll('nav.toc')];
                
                if (typeof(anchors) != 'undefined' && anchors != null && typeof(tocs) != 'undefined' && tocs != null) {
                    const highlight = () => {
                        tocs.forEach((toc) => {
                            const links = [...toc.querySelectorAll('ul > li[id]')];
                            if (anchors && links && links.length > 0) {
                                if (window.scrollY <= 0) {
                                    links[0].classList.add('border-[var(--toc-border-highlight)]');
                                }
                                else if ((window.innerHeight + Math.round(window.scrollY)) >= document.body.offsetHeight) {
                                    links[links.length - 1].classList.add('border-[var(--toc-border-highlight)]');
                                }
                                else {
                                    const activeAnchor = anchors.find((anchor) => anchor.getBoundingClientRect().top < window.innerHeight / 4);
                                    const id = (activeAnchor ?? anchors[anchors.length - 1]).getAttribute('id') ?? '';
                                    links.find(link => link.id === `toc-${id}`)?.classList.add('border-[var(--toc-border-highlight)]');
                                }
                            }
                        });

                    };
                    highlight();
                    window.addEventListener('scroll', (event) => {
                        tocs.forEach((toc) => {
                            const links = [...toc.querySelectorAll('ul > li[id]')];
                            links.forEach((link, index) => { link.classList.remove("border-[var(--toc-border-highlight)]")});
                        });
                        highlight();
                    });
                }
            });
        </script>
        @endonce
        HTML;
    }
}
