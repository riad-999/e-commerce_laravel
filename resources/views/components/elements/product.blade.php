@props(['product'])

<article class="flex flex-col justify-between">
    <a href="{{route('show-product',$product->id)}}" class="block min-h-[100px]">
        <img class="w-full object-cover border-b border-solid border-gray-400 mb-4" 
        src="{{config('globals.images_end_point') . $product->colors[0]->main_image}}" 
        id='{{"img-$product->id"}}' alt="product image" loading="lazy" />
    </a>
    <div class="font-semibold capitalize text-secondary">{{$product->name}}</div>
    <div class="capitalize">{{$product->category}}, {{$product->brand}}</div>
    <div class="flex gap-2 flex-col desk:flex-row justify-between desk:items-center">
        <div class="flex flex-col tablet:flex-row gap-0 tablet:gap-4">
            <div class="font-extralight {{$product->promo ? 'line-through' : ''}}">{{$product->price}}Da</div>
            @if($product->promo)
                <div class="font-extralight text-trinary ">{{$product->promo}}Da</div>
            @endif
        </div>
        @if($product->expires)
            <div class="text-red-600 text-sm font-semibold">offre limité</div>
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
                data-src="{{config('globals.images_end_point') . $color->main_image}}" data-id='{{"img-$product->id"}}'/>
            @endif
        @endforeach
    </div>
</article>