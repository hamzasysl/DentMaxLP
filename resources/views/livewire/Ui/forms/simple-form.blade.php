@php
    $view = match ($layout ?? 'vertical') {
        'horizontal' => 'livewire.Ui.forms.simple-form-horizontal',
        'lead', 'lead-inline', 'lead-compact', 'lead-band' => 'livewire.Ui.forms.simple-form-lead',
        default      => 'livewire.Ui.forms.simple-form-vertical',
    };
@endphp

@include($view)
