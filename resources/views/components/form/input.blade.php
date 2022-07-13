@props(['label' => ''])
@php
    $name = $attributes['name'];
@endphp
<div>
    <label class="mb-2 block font-semibold" for={{ $name }}>{{$label}}</label>
    <input {{ $attributes->merge([
        'class' => 'block p-1 bg-gray-300 border border-gray-500 border-solid round',
        'id' => $name]
    ) }}/>
    @error($name)
        <small class="text-red-500 text-sm font-semibold">{{ $message }}</small>
    @enderror
</div>