@props(['url'])

<li class="hover:bg-gray-200 transition duration-300 {{url()->current() == $url ? 'bg-gray-200' : ''}} font-body font-semibold text-xl py-2">
    <a href="{{$url}}" class="flex items-center py-2 px-4 text-secondary">
        <span class="inline-block">{{$icone}}</span>
        <span class="inline-block ml-8">{{$slot}}</span>
    </a>
</li>