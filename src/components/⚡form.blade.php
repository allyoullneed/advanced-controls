<?php

use Livewire\Component;
use Statamic\Facades\Form;
use Statamic\Fields\Tab;

new class extends Component
{
    public string $handle;
    public bool $splitSections;
    public ?string $titleElement;

    public array $tabs = [];

    public function mount(
        string $in,
        ?bool $splitSections = true,
        ?string $titleElement = "h2"
    ) {
        $this->handle        = $in;
        $this->splitSections = $splitSections;
        $this->titleElement    = $titleElement;

        $formTag = Form::find($this->handle);
        $tabs = $formTag->blueprint()->tabs()->all();
        $tabs = array_map(fn($tab) => array($tab->handle() => $tab->contents()), $tabs);
        $this->tabs =  array_merge(...array_values($tabs));
    }
};
?>

<div>
<form action="POST" action="http://alpha.local/!/forms/external_research_application">
    @foreach ($tabs as $tab)
        @foreach ($tab['sections'] as $section)
            @if (array_key_exists('display', $section))
                {{ $section['display'] }}
            @endif
        @endforeach
    @endforeach
</form>

<statamic:form:create class="grid grid-cols-12 items-stretch gap-4" :in="$handle">
    @if (isset($success))
        <x-alert icon="o-check-circle" class="col-span-full alert-success">
            {{ $success }}
        </x-alert>
    @else
        @if (isset($errors) && !empty($errors))
            <x-alert icon="o-x-circle" class="col-span-full alert-error">
                @foreach($errors as $error)
                    {{ $error }}<br>
                @endforeach
            </x-alert>
        @endif
        @foreach($sections as $section)
            @if (!empty(array_filter($section['fields'], function ($field) { return $field['visibility'] != 'hidden'; })))
                <div class="bg-base-200 rounded-lg p-5 col-span-full grid gap-y-4 grid-cols-subgrid">
                    @if ($titleElement and $section['display'])
                    <{{ $titleElement }} class="col-span-full">{{ $section['display'] }}</{{ $titleElement }}>
                    @endif
                    @isset($section['instructions'])
                    {{ $section['instructions'] }}
                    @endisset
                    @foreach ($section['fields'] as $field)
                        @if ($field['type'] == 'spacer')
                        <div></div>
                        @else
                            @if ($field['visibility'] == 'hidden')
                                <input type="hidden" name="{{ $field['handle'] }}" value="{{ $field['default'] }}"/>
                            @else
                                <div class="{{ 
                                    $field['width'] == 100 ? 'col-span-full' :
                                    ($field['width'] == 75 ? 'col-span-9' :
                                    ($field['width'] == 66 ? 'col-span-8' :
                                    ($field['width'] == 50 ? 'col-span-6' :
                                    ($field['width'] == 33 ? 'col-span-4' : 'col-span-3'))))
                                }}">
                                    {!! $field['field'] !!}
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            @endif
        @endforeach
    @endif

    <div class="bg-base-200 rounded-lg p-5 col-span-full flex justify-end">
        <x-button class="btn btn-primary" type="submit" data-action="submit">{{ $submit_label ?? 'Submit' }}</x-button>
    </div>
</statamic:form:create>

</div>