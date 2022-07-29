@props(['name','selected' => null,'disabled' => false,'edit' => false])

@php
    // dd($selected);
    $dsb = $disabled ? '!cursor-not-allowed opacity-50 pointer-events-none' : '';    
    $colors = [
        (object) [
            'name' => 'gris',
            'value' => '#808080'
        ], 
        (object) [
            'name' => 'noire',
            'value' => '#000000'
        ],
        (object) [
            'name' => 'rouge',
            'value' => '#FF0000'
        ],
        (object) [
            'name' => 'vert',
            'value' => '#008000'
        ],
        (object) [
            'name' => 'violet',
            'value' => '#800080'
        ]
    ];
@endphp

<div class="dropdown">
    <input type="hidden" class="color" id="{{$name}}" name="{{$name}}"
     value="{{ $selected ? $selected->value : null }}" {{ $disabled ? 'disabled' : null }}/>

    <label tabindex="0" class="btn color-label mb-4 capitalize w-[200px] 
    {{$dsb}}" >
        @if($selected === null) 
            séléctioner la coleur  <i class="fa-solid fa-angle-down ml-2"></i>
        @else
            <span>{{ $selected->name }}</span>
            <x-elements.color-square class="ml-2 inline-block" :color="$selected" />
        @endif
    </label>

    @if($edit)
        <x-form.edit class="ml-4" data-id="{{$name}}" data-dropdown='on' />
    @endif

    <div tabindex="0" class="dropdown-content menu shadow bg-white rounded-box w-52 max-h-72 overflow-y-auto !invisible">
        <button type="button" data-id="{{ null }}" class="color-item flex justify-between px-4 py-2 hover:bg-gray-300">
            <span>rien</span>
        </button>
        @foreach($colors as $color)
            <button type="button" data-id="{{ $color->value }}" class="color-item flex justify-between px-4 py-2 hover:bg-gray-300">
                <span>{{ $color->name }}</span>
                <x-elements.color-square class="ml-2 inline-block" :value="$color->value" />
            </button>
        @endforeach
    </div>
</div>