@props(['url'])

<li {{$attributes->merge(['class' => 'p-2 text-center'])}}>
    <a href="{{$url}}" class="block">
        <div class="text-black font-semibold text-xl">{{ $slot }}</div>
    </a>
</li>