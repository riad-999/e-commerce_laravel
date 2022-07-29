@props(['label' => '','disabled' => false,'edit' => false,'margin' => 'mb-4','remove' => false])
@php
    $name = $attributes['name'];
    $dsb = $disabled ? 'cursor-not-allowed opacity-50' : '';
@endphp
<div class="{{ $margin }}">
    @if($label)
        <label class="block font-semibold" for={{ $name }}>
            {{$label}}
            @if($edit)
                <x-form.edit class="{{$label ? 'ml-2' : ''}}" data-id="{{$name}}"/>
            @endif
            @if($remove)
                <x-form.remove class="ml-2" data-id="{{$name}}"/>
            @endif
        </label>
    @endif
    <input {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge([
        'class' => "p-1 bg-gray-300 border border-gray-500 border-solid round $dsb",
        'id' => $name]
    ) }}/>
    <x-form.error name={{$name}} />
</div>