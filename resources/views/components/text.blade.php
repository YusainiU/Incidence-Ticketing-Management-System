@php
    $textarea = Config::get('steps.form.textarea');
@endphp

@props(['disabled' => false])

<textarea 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => $textarea]) !!}
>
    {{ $textValue }}
</textarea>
