@props(['color','value' => null])

@if($value)
    <div {{ $attributes->merge([
        'class' => "w-[24px] h-[24px] border border-solid border-gray-400",
        'style' => "background-color: $value"
        ]) 
    }}></div>
@else 
    @php
        $cols = [];
        if($color->value1) {
            $grid = 'grid-cols-1';
            array_push($cols,$color->value1);
        }
        if($color->value2) {
            $grid = 'grid-cols-2';
            array_push($cols,$color->value2);
        }
        if($color->value3) {
            $grid = 'grid-cols-3';
            array_push($cols,$color->value3);
        }
    @endphp
    <div {{ $attributes->merge([
        'class' => "w-[25px] h-[25px] inline-grid $grid border border-solid border-border"
    ]) }}>
        @foreach ($cols as $col)
            <div style="background-color: {{ $col }}"></div>
        @endforeach
    </div>
@endif