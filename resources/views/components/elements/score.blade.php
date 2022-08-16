@props(['score','count' => null])


<div {{$attributes->merge([
    'class' => "text-secondary"
])}}>
    @php
        $score = floor($score * 2) / 2;
    @endphp
    @for($i = 1; $i <= 5; $i++)
        @if($i <= $score)
            <i class="fa-solid fa-star"></i>
        @endif
        @if ($i > $score && ($i - 1) < $score)
            <i class="fa-solid fa-star-half-stroke"></i>
        @elseif($i > $score)
            <i class="fa-regular fa-star"></i>
        @endif
    @endfor
    @if($count)
        <span class="ml-2 text-sm">({{$count}})</span>
    @endif
</div>