@props(['list','title' => null,'label' => '','margin' => true, 'disabled' => false,'selected' => null,'edit' => false])
@php
    $name = $attributes['name'];
    // $dsb = $disabled ? 'cursor-not-allowed' : '';
    // $crs = $disabled ? 'cursor-not-allowed' : '';
    $mrgn = $margin ? 'mb-4' : ''
@endphp

<div class="{{$mrgn}} select-container">
    @if($label)
        <label class="mb-2 inline-block font-semibold text-sm text-black" for="{{ $name }}">
            {{$label}}
        </label>
    @endif
    @if($edit)
        <x-form.edit class="ml-4" data-id="{{$name}}"/>
    @endif
    <select {{ $disabled ? 'disabled' : '' }} 
    {{ $attributes->merge(['class' => "block rounded-none select $mrgn", 'id' => $name])}}>
        @if($title)
            <option disabled selected>{{ $title }}</option>
        @endif
        @foreach ($list as $item)
            <option value="{{ $item->value }}" 
            {{ $item->value == $selected ? 'selected' : ''}} >{{$item->name}}</option>
        @endforeach
    </select>
    <x-form.error name={{$name}} />
</div>