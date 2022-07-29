@props(['link' => null,'white' => false])

@php
    $color = 'bg-black text-white hover:bg-black';
    $border = '';
    if($white) {
        $color = 'bg-transparent text-black';
        $border = 'border !border-solid border-black';
    }
@endphp

@if($link) 
    <a {{ $attributes->merge([
        'class' => "btn border-none py-2 rounded-none
        px-4 $color $border 
        hover:opacity-60 normal-case",
        'href' => $link
    ])}}>{{$slot}}</a>
@else
    <button {{ $attributes->merge([
        'class' => "btn border-none py-2 
        px-4 $color $border rounded-none
        hover:opacity-60 normal-case"
    ])}}>
        {{ $slot }}
    </button>
@endif