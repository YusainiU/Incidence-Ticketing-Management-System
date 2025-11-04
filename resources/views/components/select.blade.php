@php
    $select = Config::get('steps.form.select');
@endphp

@props(['disabled' => false])

<select 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => $select]) !!}
>
    {{ $options }}
</select>
