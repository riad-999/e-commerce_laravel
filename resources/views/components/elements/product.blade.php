@props(['product'])

<article>
    <a href="{{route('show-product',$product->id)}}" class="block">
        <img class="w-full object-cover border-b border-solid border-gray-400 mb-4" 
        src="{{$product->colors[0]->main_image}}" id='{{"img-$product->id"}}' alt="product image" />
    </a>
    <div class="font-semibold capitalize text-secondary">{{$product->name}}</div>
    <div class="capitalize">{{$product->category}}, {{$product->brand}}</div>
    <div class="flex flex-col tablet:flex-row gap-0 tablet:gap-4">
        <div class="font-extralight {{$product->promo ? 'line-through' : ''}}">{{$product->price}}Da</div>
        @if($product->promo)
            <div class="font-extralight text-trinary ">{{$product->promo}}Da</div>
        @endif
    </div>
    <div class="grid grid-cols-color gap-2 mt-4 colors-container">
        @foreach($product->colors as $color)
            @if($loop->index == 3)  
                <a href="{{route('show-product',$product->id)}}" class="flex justify-center items-center border border-solid border-border text-sm">...</a>
                @break
            @else
                <x-elements.color-square :color="$color" 
                class="cursor-pointer color-square {{$loop->index == 0 ? 'outline outline-secondary outline-2' : ''}}" 
                data-src="{{$color->main_image}}" data-id='{{"img-$product->id"}}'/>
            @endif
        @endforeach
    </div>
</article>