@php
    $label = Config::get('steps.form.label');   
@endphp

@props(['value'])

<label {{ $attributes->merge(['class' => $label]) }}>
    {{ $value ?? $slot }}
</label>
