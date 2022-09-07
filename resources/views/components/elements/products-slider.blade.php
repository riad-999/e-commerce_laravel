@props(['groups', 'len', 'cat'])

<div {{$attributes->merge(['class' => 'swiper'])}}> 
    <div class="swiper-wrapper" id="cat-{{$cat}}-container">
        @foreach($groups as $group)
            <div class="grid gap-4 swiper-slide desk:px-[50px]" style="grid-template-columns: repeat({{$len}},1fr);">
                @foreach($group as $product)
                    <article class="border border-solid shadow-sm border-gray-300 bg-white">
                        <a class="block mb-4" href="{{route('show-product',$product->id)}}">
                            <img src="{{config('globals.images_end_point') . $product->image}}" 
                            alt="image du produit" class="min-h-[150px] w-full" loading="lazy"/>
                        </a>
                        <div class="px-2 py-4">
                            <div class="text-secondary font-semibold mb-2">{{$product->name}}</div>
                            @if($product->promo)
                                <div class="text-pink">
                                    {{$product->promo}}Da
                                </div>
                            @else 
                                <div class="text-secondary">
                                    {{$product->price}}Da
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endforeach
    </div>
    @if(count($groups) > 1)
        <div class="swiper-pagination text-secondary absolute top-[90%] left-[50%] translate-x-[-50%] z-[5]"></div>
        <div class="swiper-button-prev hidden desk:block text-secondary"></div>
        <div class="swiper-button-next hidden desk:block text-secondary"></div>
    @endif
</div>