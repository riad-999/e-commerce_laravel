@props(['link' => null,'white' => false])

@php
    $color = 'bg-secondary text-white hover:bg-black';
    $border = '';
    if($white) {
        $color = 'bg-transparent text-black';
        // $border = 'border !border-solid border-black';
    }
@endphp

@if($link) 
    <a {{ $attributes->merge([
        'class' => "btn border-none py-1
        px-4 $color rounded-none
        hover:opacity-60 normal-case 
        border !border-solid border-black",
        'href' => $link
    ])}}>{{$slot}}</a>
@else
    <button {{ $attributes->merge([
        'class' => "btn border-none py-1
        px-4 $color rounded-none
        hover:opacity-60 normal-case 
        border !border-solid border-black"
    ])}}>
        {{ $slot }}
    </button>
@endif