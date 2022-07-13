@props(['colors'])

@php
    $list = ['none','asus', 'msi', 'amd'];
@endphp

<div class="flex gap-8">
    <x-form.select name="color1" title="choose the color 1" :list="$list" />
    <x-form.select name="color2" title="choose the color 2" :list="$list" />
    <x-form.select name="color3" title="choose the color 3" :list="$list" />
</div>