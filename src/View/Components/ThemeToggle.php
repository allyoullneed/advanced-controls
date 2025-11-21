<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class ThemeToggle extends Component
{
    public function __construct()
    {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div>
                <label
                    for="theme-toggle"
                    x-data="{
                        theme: $persist(window.matchMedia('(prefers-color-scheme: dark)').matches ? '{{ $darkTheme }}' : '{{ $lightTheme }}').as('mary-theme'),
                        init() {
                            document.documentElement.classList.add(this.theme)
                        },
                        toggle() {
                            this.theme = this.theme === '{{ $lightTheme }}' ? '{{ $darkTheme }}' : '{{ $lightTheme }}';
                            localStorage.setItem('theme', this.theme);
                        }
                    }"
                    {{ $attributes->class("swap swap-rotate") }}
                >
                    <input id="theme-toggle" type="checkbox" class="theme-controller opacity-0" @click="toggle()" :value="theme" />
                    <x-icon x-ref="sun" name="o-sun" class="dark:hidden" />
                    <x-icon x-ref="moon" name="o-moon" class="hidden dark:inline"  />
                </label>
                <script>
                    window.addEventListener('storage', (event) => {
                        if (event.key === 'theme')
                            document.documentElement.classList.replace(event.oldValue.replace(/\"/g, ''), event.newValue.replace(/\"/g, ''));
                    });
                </script>
            </div>
        HTML;
    }
}

