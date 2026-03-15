<?php

namespace AllYouNeed\AdvancedControls\View\Components;


use Illuminate\View\Component;

class Collapse extends Component
{
    public function __construct(
        public mixed $label    = null,
        public bool  $left = false,
        public bool  $arrow    = false,
        public bool  $plus     = false,
        public bool  $keepOpen = false,
        public bool  $fix      = true
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'

        <div 
        @if(!$keepOpen)
        tabindex="0"
        @endif
        {{
            $attributes->class([
                'collapse rounded-box ayn-child:[:where(.collapse-title)]:font-semibold',
                        'relative w-full grid grid-cols-[minmax(0px,1fr)] grid-rows-[max-content_0fr] overflow-hidden',
                        '[visibility:revert-layer] [isolation:isolate]',
                        '[transition:grid-template-rows_0.2s]',
                        '[&[tabindex]:focus-within]:grid-rows-[max-content_1fr]',
                        '[&[tabindex]:focus-within>.collapse-title]:cursor-[unset]',
                        '[&[tabindex]:focus-within>.collapse-content]:pb-4',
                        '[&[tabindex]:focus-within>.collapse-content]:[content-visibility:visible]',
                        '[&[tabindex]:focus-within>.collapse-content]:min-h-fit',
                        "[&:has(>input:is([type='checkbox'],[type='radio']):checked)]:grid-rows-[max-content_1fr]",
                        "[&>:where(input:is([type='checkbox'],[type='radio']):checked_~_.collapse-title)]:cursor-[unset]",
                        "[&>:where(input:is([type='checkbox'],[type='radio']):checked_~_.collapse-content)]:pb-4",
                        "[&>:where(input:is([type='checkbox'],[type='radio']):checked_~_.collapse-content)]:[content-visibility:visible]",
                        "[&>:where(input:is([type='checkbox'],[type='radio']):checked_~_.collapse-content)]:min-h-fit",

                        "[&[tabindex]:focus-within>.collapse-title]:after:[transform:translateY(-50%)_rotate(225deg)]" => $arrow,
                        "[&>:where(input:is([type='checkbox'],[type='radio']):checked_~_.collapse-title)]:after:[transform:translateY(-50%)_rotate(225deg)]" => $arrow,
                        "[&[tabindex]:focus-within>.collapse-title]:after:content-['−']" => $plus && !$arrow,
                        "[&>:where(input:is([type='checkbox'],[type='radio']):checked_~_.collapse-title)]:after:content-['−']" => $plus && !$arrow,
                'collapse-arrow' => $arrow && !$plus,
                'collapse-plus' => $plus
                ])->merge()
        }}>
        @if ($keepOpen)
        <input type="checkbox" class="col-start-1 row-start-1 w-full p-4 pe-12 z-1 appearance-none opacity-0"/>
        @endif

        @if (gettype($label) === 'object')
            <div {{ $label->attributes->class([
                'collapse-title',
                        'relative w-full p-4 pe-12 min-h-lh col-start-1 row-start-1',
                        '[transition:background-color_0.2s_ease-out] cursor-pointer',
                        'after:block after:absolute after:w-[0.5rem] after:h-[0.5rem] after:[transform:translateY(-100%)_rotate(45deg)] after:top-1/2' => $arrow,
                        'after:inset-e-[1.4rem] after:origin-[75%_75%_0px] after:shadow-[2px_2px] after:pointer-none after:duration-200' => $arrow,
                        "after:block after:absolute after:w-[0.5rem] after:h-[0.5rem] after:content-['+'] after:top-[.9rem] after:inset-e-[1.4rem] after:pointer-none" => $plus && !$arrow,
                'after:start-5 after:end-auto pe-4 ps-12' => ($arrow || $plus) && $left,
            ])->merge() }}>{{ $label }}</div>
        @else
            <div @class([
                'collapse-title',
                        'relative w-full p-4 pe-12 min-h-lh col-start-1 row-start-1',
                        '[transition:background-color_0.2s_ease-out] cursor-pointer',
                        'after:block after:absolute after:w-[0.5rem] after:h-[0.5rem] after:[transform:translateY(-100%)_rotate(45deg)] after:top-1/2' => $arrow,
                        'after:inset-e-[1.4rem] after:origin-[75%_75%_0px] after:shadow-[2px_2px] after:pointer-none after:duration-200' => $arrow,
                        "after:block after:absolute after:w-[0.5rem] after:h-[0.5rem] after:content-['+'] after:top-[.9rem] after:inset-e-[1.4rem] after:pointer-none" => $plus && !$arrow,
                'row-start-1 col-start-1' => $fix,
                'after:start-5 after:end-auto pe-4 ps-12' => ($arrow || $plus) && $left,
            ])>{{ $label }}</div>
        @endif
        
        @if (gettype($slot) === 'object')
            <div {{ $slot->attributes->class([
                'collapse-content',
                        'min-h-0 px-4 cursor-[unset] [content-visibility:hidden] col-start-1 row-start-2',
                        '[transition:_content-visibility_0.2s_allow-discrete,_visibility_0.2s_allow-discrete,_min-height_0.2s_ease-out_allow-discrete,_padding_0.1s_ease-out_20ms,_background-color_0.2s_ease-out]',
            ])->merge() }}>{{ $slot }}</div>
        @else
            <div @class([
                'collapse-content text-sm',
                        'min-h-0 px-4 cursor-[unset] [content-visibility:hidden] col-start-1 row-start-2',
                        '[transition:_content-visibility_0.2s_allow-discrete,_visibility_0.2s_allow-discrete,_min-height_0.2s_ease-out_allow-discrete,_padding_0.1s_ease-out_20ms,_background-color_0.2s_ease-out]',
            ])>{{ $slot }}</div>
        @endif
        
        </div>
        HTML;
    }
}
