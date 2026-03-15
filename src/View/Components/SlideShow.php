<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

use AllYouNeed\AdvancedControls\ComponentIndex;

class SlideShow extends Component
{
    public object|int|string|null $showIndex;
    public string $showCondition;
    public ComponentAttributeBag  $slideAttributes;

    public function __construct(
        public mixed         $slides       = null,
        public ?int          $count        = null,
        public bool          $templateSlot = false,
        public bool          $buttons      = false,
        public bool          $indicators   = false,
        public int|bool|null $autoplay     = null,
        public bool          $withPause    = false,
    ) {
        if ($count === null)
            $this->count = count($slides ?? []);
        $this->showIndex = new ComponentIndex();
        $this->showCondition = "return 'currentSlideIndex === ' .   \$showIndex->value();";
        $this->slideAttributes = new ComponentAttributeBag(['x-cloak' => 1, 'noDefaultClass' => 1]);
    }
    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div 
            {{ $attributes->class(['relative w-full rounded-box overflow-hidden'])->merge() }}
            x-data="{
                count: {{ $count }},
                currentSlideIndex: 1,
                @if ($slides && $templateSlot)
                    slides: {{ json_encode($slides) }},
                @endif
                @if ($autoplay)
                    autoplayIntervalTime: {{ gettype($autoplay) == 'boolean' ? 5000 : $autoplay }},
                    isPaused: false,
                    autoplayInterval: null,
                    autoplay() {
                        this.autoplayInterval = setInterval(() => {
                            if (! this.isPaused) {
                                this.next(false)
                            }
                        }, this.autoplayIntervalTime)
                    },
                    setAutoplayInterval(newIntervalTime) {
                        clearInterval(this.autoplayInterval)
                        this.autoplayIntervalTime = newIntervalTime
                        this.autoplay()
                    },   
                @endif
                previous() {                
                    if (this.currentSlideIndex > 1)           
                        this.currentSlideIndex = this.currentSlideIndex - 1;
                    else
                        this.currentSlideIndex = this.count;
                    @if (($buttons || $indicators) && $autoplay)
                        clearInterval(this.autoplayInterval);
                        this.autoplay();
                    @endif
                },            
                next(resetAutoplay = true) {                
                    if (this.currentSlideIndex < this.count)  
                        this.currentSlideIndex = this.currentSlideIndex + 1;
                    else
                        this.currentSlideIndex = 1;
                    @if (($buttons || $indicators) && $autoplay)
                    if (resetAutoplay) {
                        clearInterval(this.autoplayInterval);
                        this.autoplay();
                    }
                    @endif
                },  
            }"
            @if ($autoplay)
                x-init="autoplay"
            @endif
        >
            @if ($buttons)
            <x-button type="button" class="p-0 aspect-square shadow-none absolute left-5 top-1/2 z-20 flex rounded-full -translate-y-1/2 opacity-40 hover:opacity-60 transition" no-spinner aria-label="previous slide" x-on:click="previous()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="3" class="size-5 md:size-6 pr-0.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </x-button>

            <x-button type="button" class="p-0 aspect-square shadow-none absolute right-5 top-1/2 z-20 flex rounded-full -translate-y-1/2 opacity-40 hover:opacity-60 transition" no-spinner aria-label="next slide" x-on:click="next()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="3" class="size-5 md:size-6 pl-0.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </x-button>
            @endif
            @if ($autoplay && $withPause)
                <button type="button" class="absolute bottom-5 right-5 z-20 rounded-full text-white opacity-50 transition hover:opacity-80 focus-visible:opacity-80 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-dark active:outline-offset-0" aria-label="pause carousel" x-on:click="(isPaused = !isPaused), setAutoplayInterval(autoplayIntervalTime)" x-bind:aria-pressed="isPaused">
                    <svg x-cloak x-show="isPaused" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-7">
                        <path fill-rule="evenodd" d="M2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm6.39-2.908a.75.75 0 0 1 .766.027l3.5 2.25a.75.75 0 0 1 0 1.262l-3.5 2.25A.75.75 0 0 1 8 12.25v-4.5a.75.75 0 0 1 .39-.658Z" clip-rule="evenodd">
                    </svg>
                    <svg x-cloak x-show="!isPaused" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-7">
                        <path fill-rule="evenodd" d="M2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm5-2.25A.75.75 0 0 1 7.75 7h.5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-.75.75h-.5a.75.75 0 0 1-.75-.75v-4.5Zm4 0a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-.75.75h-.5a.75.75 0 0 1-.75-.75v-4.5Z" clip-rule="evenodd">
                    </svg>
                </button>
            @endif
            <div class="slide h-full grid *:col-start-1 *:row-start-1" x-transition.opacity.duration.1000ms>
                {{ $slot }}
            </div>


            @if (gettype($indicators) === 'object')
                {{ indicators }}
            @elseif ($indicators)
                <div class="absolute rounded-sm bottom-3 md:bottom-5 left-1/2 z-1 flex -translate-x-1/2 gap-4 md:gap-3 bg-base-200/75 px-1.5 py-1 md:px-2" role="group" aria-label="slides" >
                    @for ($i = 1; $i <= $count; $i++)
                        <button class="cursor-pointer size-2 rounded-full transition bg-on-surface dark:bg-on-surface-dark" x-on:click="currentSlideIndex = {{ $i }}" x-bind:class="[currentSlideIndex === {{ $i }} ? 'bg-base-content/75' : 'bg-base-content/50']" x-bind:aria-label="slide{{ $i }}"></button>
                    @endfor
                </div>
            @endif
        </div>

        HTML;
    }
}
