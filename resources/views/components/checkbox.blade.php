@php
    $checkbox = Config::get('steps.form.checkbox');
@endphp

<input type="checkbox" {!! $attributes->merge(['class' => $checkbox]) !!}>
