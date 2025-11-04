@php
    $input = Config::get('steps.form.input-normal');
@endphp

@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $input]) !!}>
