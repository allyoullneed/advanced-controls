<?php

namespace AllYouNeed\AdvancedControls\View\Components;

use Illuminate\View\Component;

class Toast extends Component
{
    public function __construct(
        public string $position = 'toast-top toast-end',
        public string $listenTo = 'notify',
        public int $duration = 8000,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        <div x-data="{
                notifications: [],
                displayDuration: {{ $duration }},

                addNotification({ type = 'info', variant = null, sender = null, title = null, message = null, html = null}) {
                    const id = Date.now()
                    const notification = html ? { id, html } : { id, type, variant, sender, title, message };

                    // Keep only the most recent 20 notifications
                    if (this.notifications.length >= 20) {
                        this.notifications.splice(0, this.notifications.length - 19)
                    }

                    // Add the new notification to the notifications stack
                    this.notifications.push(notification)
                },

                removeNotification(id) {
                    setTimeout(() => {
                        this.notifications = this.notifications.filter(
                            (notification) => notification.id !== id,
                        )
                    }, 400);
                },
            }" x-on:{{ $listenTo ?? 'notify'}}.window="addNotification({
                    type: $event.detail.type,
                    variant: $event.detail.variant,
                    sender: $event.detail.sender,
                    title: $event.detail.title,
                    message: $event.detail.message,
                    html: $event.detail.html,
                })">

            <div x-on:mouseenter="$dispatch('pause-auto-dismiss')" x-on:mouseleave="$dispatch('resume-auto-dismiss')" 
                {{ $attributes->class([
                    'group pointer-events-none fixed inset-x-8 z-999 flex max-w-full flex-col gap-2 bg-transparent px-6 py-6'
                ])->merge() }}
            >
                <template x-for="(notification, index) in notifications" x-bind:key="notification.id">  
                    <div>
                        <!-- HTML Notification  -->
                        <template x-if="notification.html">
                            <div
                                class="flex pointer-events-auto relative transition duration-300 ease-in-out"
                                x-data="{ isVisible: false, timeout: null }"
                                x-cloak x-show="isVisible" role="alert"
                                x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                                x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)"
                                x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id)}, displayDuration))"
                                x-transition:enter=""
                                x-transition:enter-end="translate-y-0"
                                x-transition:enter-start="translate-y-8"
                                x-transition:leave=""
                                x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                                x-transition:leave-start="translate-x-0 opacity-100"
                            >
                                <div x-html="notification.html"></div>
                                <x-button label="✕" class="border-0 ml-1 shadow-none aspect-square rounded-full" aria-label="dismiss notification" x-on:click="(isVisible = false), removeNotification(notification.id)"/>
                            </div>
                        </template>
                        <!-- Info Notification  -->
                        <template x-if="notification.type === 'info'">     
                            <x-alert
                                type="info" role="alert"
                                class="pointer-events-auto relative"
                                ::class="[notification.variant ? 'alert-' + notification.variant : '', notification.variant === 'outline' ? 'bg-base-200' : '']"
                                x-data="{ isVisible: false, timeout: null }"
                                x-show="isVisible" x-cloak
                                x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                                x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)"
                                x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id)}, displayDuration))"
                                x-transition:enter="transition duration-300 ease-out"
                                x-transition:enter-end="translate-y-0"
                                x-transition:enter-start="translate-y-8"
                                x-transition:leave="transition duration-300 ease-in"
                                x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                                x-transition:leave-start="translate-x-0 opacity-100"
                            >
                                <x-slot:title x-show="notification.title"  x-text="notification.title"></x-slot:title>
                                <x-slot:description x-show="notification.message">
                                    <x-avatar x-show="notification.sender" class="block font-bold mt-2">
                                        <img alt="Avatar" x-bind:src="notification.sender?.avatar" class="size-8 rounded-full mr-2 inline-block align-middle"/>
                                        <span x-text="notification.sender?.name"></span>
                                    </x-avatar>
                                    <span x-html="notification.message"></span>
                                </x-slot:description>
                                <x-slot:actions>
                                    <x-button label="✕" color="info" ::class="notification.variant ? 'btn-' + notification.variant : ''" class="border-0 ml-auto shadow-none aspect-square rounded-full" aria-label="dismiss notification" x-on:click="(isVisible = false), removeNotification(notification.id)"/>
                                </x-slot:actions>
                        </x-alert>
                        </template>

                        <!-- Success Notification  -->
                        <template x-if="notification.type === 'success'">
                            <x-alert
                                type="success" role="alert"
                                class="pointer-events-auto relative"
                                ::class="[notification.variant ? 'alert-' + notification.variant : '', notification.variant === 'outline' ? 'bg-base-200' : '']"
                                x-data="{ isVisible: false, timeout: null }"
                                x-show="isVisible" x-cloak
                                x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                                x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)"
                                x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id)}, displayDuration))"
                                x-transition:enter="transition duration-300 ease-out"
                                x-transition:enter-end="translate-y-0"
                                x-transition:enter-start="translate-y-8"
                                x-transition:leave="transition duration-300 ease-in"
                                x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                                x-transition:leave-start="translate-x-0 opacity-100"
                            >
                                <x-slot:title x-show="notification.title"  x-text="notification.title"></x-slot:title>
                                <x-slot:description x-show="notification.message">
                                    <x-avatar x-show="notification.sender" class="block font-bold mt-2">
                                        <img alt="Avatar" x-bind:src="notification.sender?.avatar" class="size-8 rounded-full mr-2 inline-block align-middle"/>
                                        <span x-text="notification.sender?.name"></span>
                                    </x-avatar>
                                    <span x-html="notification.message"></span>
                                </x-slot:description>
                                <x-slot:actions>
                                    <x-button label="✕" color="success" ::class="notification.variant ? 'btn-' + notification.variant : ''" class="border-0 ml-auto shadow-none aspect-square rounded-full" aria-label="dismiss notification" x-on:click="(isVisible = false), removeNotification(notification.id)"/>
                                </x-slot:actions>
                            </x-alert>
                        </template>

                        <!-- Warning Notification  -->
                        <template x-if="notification.type === 'warning'"> 
                            <x-alert
                                type="warning" role="alert"
                                class="pointer-events-auto relative"
                                ::class="[notification.variant ? 'alert-' + notification.variant : '', notification.variant === 'outline' ? 'bg-base-200' : '']"
                                x-data="{ isVisible: false, timeout: null }"
                                x-show="isVisible" x-cloak
                                x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                                x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)"
                                x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id)}, displayDuration))"
                                x-transition:enter="transition duration-300 ease-out"
                                x-transition:enter-end="translate-y-0"
                                x-transition:enter-start="translate-y-8"
                                x-transition:leave="transition duration-300 ease-in"
                                x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                                x-transition:leave-start="translate-x-0 opacity-100"
                            >
                                <x-slot:title x-show="notification.title"  x-text="notification.title"></x-slot:title>
                                <x-slot:description x-show="notification.message">
                                    <x-avatar x-show="notification.sender" class="block font-bold mt-2">
                                        <img alt="Avatar" x-bind:src="notification.sender?.avatar" class="size-8 rounded-full mr-2 inline-block align-middle"/>
                                        <span x-text="notification.sender?.name"></span>
                                    </x-avatar>
                                    <span x-html="notification.message"></span>
                                </x-slot:description>
                                <x-slot:actions>
                                    <x-button label="✕" color="warning" ::class="notification.variant ? 'btn-' + notification.variant : ''" class="border-0 ml-auto shadow-none aspect-square rounded-full" aria-label="dismiss notification" x-on:click="(isVisible = false), removeNotification(notification.id)"/>
                                </x-slot:actions>
                            </x-alert>
                        </template>

                        <!-- Error Notification  -->             
                        <template x-if="notification.type === 'error'">     
                            <x-alert
                                type="error" role="alert"
                                class="pointer-events-auto relative"
                                ::class="[notification.variant ? 'alert-' + notification.variant : '', notification.variant === 'outline' ? 'bg-base-200' : '']"
                                x-data="{ isVisible: false, timeout: null }"
                                x-show="isVisible" x-cloak
                                x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                                x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)"
                                x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id)}, displayDuration))"
                                x-transition:enter="transition duration-300 ease-out"
                                x-transition:enter-end="translate-y-0"
                                x-transition:enter-start="translate-y-8"
                                x-transition:leave="transition duration-300 ease-in"
                                x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                                x-transition:leave-start="translate-x-0 opacity-100"
                            >
                                <x-slot:title x-show="notification.title"  x-text="notification.title"></x-slot:title>
                                <x-slot:description x-show="notification.message">
                                    <x-avatar x-show="notification.sender" class="block font-bold mt-2">
                                        <img alt="Avatar" x-bind:src="notification.sender?.avatar" class="size-8 rounded-full mr-2 inline-block align-middle"/>
                                        <span x-text="notification.sender?.name"></span>
                                    </x-avatar>
                                    <span x-html="notification.message"></span>
                                </x-slot:description>
                                <x-slot:actions>
                                    <x-button label="✕" color="error" ::class="notification.variant ? 'btn-' + notification.variant : ''" class="border-0 ml-auto shadow-none aspect-square rounded-full" aria-label="dismiss notification" x-on:click="(isVisible = false), removeNotification(notification.id)"/>
                                </x-slot:actions>
                            </x-alert>
                        </template>

                        <template x-if="!notification.html && notification.type !== 'info' && notification.type !== 'success' && notification.type !== 'warning' && notification.type !== 'error'">     
                            <x-alert
                                role="alert"
                                class="pointer-events-auto relative"
                                ::class="[notification.variant ? 'alert-' + notification.variant : '', notification.variant === 'outline' ? 'bg-base-200' : '']"
                                x-data="{ isVisible: false, timeout: null }"
                                x-cloak x-show="isVisible"
                                x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                                x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)"
                                x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id)}, displayDuration))"
                                x-transition:enter="transition duration-300 ease-out"
                                x-transition:enter-end="translate-y-0"
                                x-transition:enter-start="translate-y-8"
                                x-transition:leave="transition duration-300 ease-in"
                                x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                                x-transition:leave-start="translate-x-0 opacity-100"
                            >
                                <x-slot:title x-show="notification.title"  x-text="notification.title"></x-slot:title>
                                <x-slot:description x-show="notification.message">
                                    <x-avatar x-show="notification.sender" class="block font-bold mt-2">
                                        <img alt="Avatar" x-bind:src="notification.sender?.avatar" class="size-8 rounded-full mr-2 inline-block align-middle"/>
                                        <span x-text="notification.sender?.name"></span>
                                    </x-avatar>
                                    <span x-html="notification.message"></span>
                                </x-slot:description>
                                <x-slot:actions>
                                    <x-button label="✕" ::class="notification.variant ? 'btn-' + notification.variant : ''" class="border-0 ml-auto shadow-none aspect-square rounded-full" aria-label="dismiss notification" x-on:click="(isVisible = false), removeNotification(notification.id)"/>
                                </x-slot:actions>
                            </x-alert>
                        </template>

                    </div>
                </template>
            </div>
        </div>
        HTML;
    }
}
