<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Tabs extends Component
{
    public function __construct(
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <nav class="tabs tabs-bordered" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
            <button type="button" class="tab active-tab:tab-active active" id="tabs-basic-item-1" data-tab="#tabs-basic-1" aria-controls="tabs-basic-1" role="tab" aria-selected="true" >
                Home
            </button>
            <button type="button" class="tab active-tab:tab-active" id="tabs-basic-item-2" data-tab="#tabs-basic-2" aria-controls="tabs-basic-2" role="tab" aria-selected="false" >
                Profile
            </button>
            <button type="button" class="tab active-tab:tab-active" id="tabs-basic-item-3" data-tab="#tabs-basic-3" aria-controls="tabs-basic-3" role="tab" aria-selected="false" >
                Messages
            </button>
        </nav>

        <div class="mt-3">
            <div id="tabs-basic-1" role="tabpanel" aria-labelledby="tabs-basic-item-1">
                <p class="text-base-content/80">
                Welcome to the <span class="text-base-content font-semibold">Home tab!</span> Explore the latest updates and news here.
                </p>
            </div>
            <div id="tabs-basic-2" class="hidden" role="tabpanel" aria-labelledby="tabs-basic-item-2">
                <p class="text-base-content/80">
                This is your <span class="text-base-content font-semibold">Profile</span> tab, where you can update your personal information and manage your account details.
                </p>
            </div>
            <div id="tabs-basic-3" class="hidden" role="tabpanel" aria-labelledby="tabs-basic-item-3">
                <p class="text-base-content/80">
                <span class="text-base-content font-semibold">Messages:</span> View your recent messages, chat with friends, and manage your conversations.
                </p>
            </div>
        </div>
        HTML;
    }
}
