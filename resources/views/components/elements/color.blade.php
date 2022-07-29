@props(['colors'])

@php
    if(count($colors) === 1) 
        $grid = 'grid-cols-1 grid-rows-1';
    if(count($colors) === 2) 
        $grid = 'grid-cols-2 grid-rows-1';
    if(count($colors) === 3) 
        $grid = 'grid-cols-3 grid-rows-1';
@endphp

<div {{ $attributes->merge(['class' => "w-30p h-30p inline-grid $grid"]) }}>
    @foreach ($colors as $color)
        <div style="background-color: {{ $color }}"></div>
    @endforeach
</div>