@props(['color'])

@php
    $cols = [];
    if($color->value1) {
        $grid = 'grid-cols-1 grid-rows-1';
        array_push($cols,$color->value1);
    }
    if($color->value2) {
        $grid = 'grid-cols-2 grid-rows-1';
        array_push($cols,$color->value2);
    }
    if($color->value3) {
        $grid = 'grid-cols-3 grid-rows-1';
        array_push($cols,$color->value3);
    }
@endphp

<div {{ $attributes->merge(['class' => "w-8 h-8 inline-grid $grid"]) }}>
    @foreach ($cols as $col)
        <div style="background-color: {{ $col }}"></div>
    @endforeach
</div>