@props(['content' => '','disabled' => false,'edit' => false,'label' => '','margin' => true])

@php
    $name = $attributes['name'];
    $dsb = $disabled ? 'cursor-not-allowed opacity-50' : '';
    $mrg = $margin ? 'mb-4' : '';
@endphp

<div class="{{$mrg}}">
    @if($label)
        <label class="inline-block mb-2 font-semibold text-sm" for={{ $name }}>
            {{$label}}
        </label>
    @endif
    @if($edit)
        <x-form.edit class="ml-4" data-id="{{$name}}" />
    @endif
    <textarea {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge([
        'class' => "block h-[150px] p-1 border border-gray-200 border-solid $dsb",
        'id' => $name]
    ) }} spellcheck="false" >{{$content}}</textarea>
    <x-form.error name={{$name}} />
</div>