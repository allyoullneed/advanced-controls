<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Password extends Component
{
    public function __construct(
        public mixed   $title       = null,
        public mixed   $label       = null,
        public ?string $placeholder = '',
        public mixed   $error       = null,
        public mixed   $helper      = null,
        public mixed   $icon        = null,
        public mixed   $trailIcon   = null,
        public mixed   $eye     = null,
        public bool    $eyeFocus    = false,
        public ?string $color       = null,
        public bool    $ghost       = false,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <x-input type="password" 
            :title="$title"
            :label="$label"
            :placeholder="$placeholder"
            :error="$error"
            :helper="$helper"
            :color="$color"
            :ghost="$ghost"
            :icon="$icon"
            :trailIcon="$trailIcon"
            {{ $attributes }}
        >
            @if ($eye)
                @if (gettype($eye) === 'boolean')
                    <x-button variant="ghost" size="sm"
                        class="p-1 text-base-content btn-circle order-last"
                        :tabIndex="!$eyeFocus ? -1 : null"
                        onclick="
                            var eyeButton = this.nextElementSibling;
                            this.classList.add('hidden');
                            eyeButton.classList.remove('hidden');
                            this.previousElementSibling.setAttribute('type', 'text');
                            if (document.activeElement == this)
                                eyeButton.focus({ focusVisible: true });
                        ">
                        <x-icon name="heroicon-o-eye"/>
                    </x-button>
                    <x-button variant="ghost" size="sm"
                        class="p-1 text-base-content btn-circle order-last hidden"
                        :tabIndex="!$eyeFocus ? -1 : null"
                        onclick="
                            var eyeButton = this.previousElementSibling;
                            this.classList.add('hidden');
                            eyeButton.classList.remove('hidden');
                            eyeButton.previousElementSibling.setAttribute('type', 'password');
                            if (document.activeElement == this)
                                eyeButton.focus({ focusVisible: true });
                        ">
                        <x-icon name="heroicon-o-eye-slash"/>
                    </x-button>
                @else
                @endif
            @endif
        </x-input>
        HTML;
    }
}
