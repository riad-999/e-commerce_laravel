@props(['review'])

@php
    $time = strtotime($review->date);
    $date = date('d-m-Y',$time);
@endphp

<article {{$attributes->merge([
    'class' => "py-4"
])}}>
    <div>{{$review->name}}</div>
    <div class="mb-4">{{$date}}</div>
    <x-elements.score :score="$review->score" />
    <p class="max-w-[60ch]"> 
        {{$review->feedback}}
    </p>
</article>