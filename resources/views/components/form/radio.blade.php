@props(['list','label' => '','margin' => true, 'disabled' => false,'checked' => null,'edit' => false])

@php
    $name = $attributes['name'];
    $dsb = $disabled ? 'opacity-50' : '';
    $mrgn = $margin ? 'mb-4' : ''
@endphp

<div class="{{$mrgn}}">
    @if($label)
        <label class="mb-2 inline-block font-semibold" for="{{ $name }}">
            {{$label}}
        </label>
    @endif  
    @if($edit)
        <x-form.edit class="{{$label ? 'ml-4' : ''}} mb-2" data-name="{{$name}}"/>
    @endif
    @foreach($list as $item)
        <div class="form-control radio-container">
            <label class="label justify-start gap-2 cursor-pointer">
                <input type="radio" name="{{$name}}" {{$disabled ? 'disabled' : ''}} value="{{$item->value}}" 
                class="radio checked:bg-primary" {{$checked == $item->value ? 'checked' : ''}}/>
                <span>{{$item->name}}</span> 
            </label>
        </div>
    @endforeach
</div>