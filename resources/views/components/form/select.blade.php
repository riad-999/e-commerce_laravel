@props(['list','title','label' => ''])
@php
    $name = $attributes['name'];
@endphp

<div>
    <label class="mb-2 block font-semibold" for={{ $name }}>{{$label}}</label>
    <select {{ $attributes->merge(['class' => "block select w-full max-w-xs", 'id' => $name])}}>
    <option disabled selected>{{ $title }}</option>
    @foreach ($list as $item)
        <option value="{{ $item->value }}">{{$item->name}}</option>
    @endforeach
    </select>
    @error($name)
        <small class="text-red-500 text-sm font-semibold">{{ $message }}</small>
    @enderror
</div>