@props(['review'])

@php
    $time = strtotime($review->date);
    $date = date('d-m-Y',$time);
@endphp

<article {{$attributes->merge([
    'class' => "py-4"
])}}>
    <div class="flex gap-8 items-center">
        <div>{{$review->name}}</div>
        @can('isAdmin')
            <form action="{{route('delete-feeback',['product_id' => $review->product_id, 'user_id' => $review->user_id])}}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="underline">
                    Supprimer
                </button>
            </form>
        @endcan
    </div>
    <div class="mb-4">{{$date}}</div>
    <x-elements.score :score="$review->score" />
    <p class="max-w-[60ch]"> 
        {{$review->feedback}}
    </p>
</article>