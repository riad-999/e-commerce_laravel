<x-ui-elements.layout :fixedw="false">
    <main>
        <section class="mt-12 mb-12 mx-auto max-w-[1500px] desk:px-4 relative">
            <div class="swiper">   
                <div class="swiper-wrapper" id="images-container">
                    @foreach($ui->images as $image) 
                        <img class="block desk:px-[50px] min-h-[300px] max-h-[600px] swiper-slide"
                        src="{{config('globals.ui_images_end_point') . $image}}">
                    @endforeach
                </div>
                <div class="swiper-pagination text-secondary absolute top-[90%] left-[50%] translate-x-[-50%] z-[5]"></div>
                <div class="swiper-button-prev hidden desk:block text-secondary"></div>
                <div class="swiper-button-next hidden desk:block text-secondary"></div>
            </div>
            <div class="block absolute top-[70%] left-[50%] translate-x-[-50%] 
            w-full max-w-[128px] desk:max-w-[250px] z-[5]">
                <x-interactive.btn :link="route('products')" class="w-full !border-none">
                    Découvrir
                </x-interactive.btn>
            </div>
        </section>
        @if(count($most_ordered))
            <section class="py-8 mb-12 bg-test relative">
                <h3 class="text-center pb-2">plus commandés</h3>
                <div class="mx-auto w-24 border-b-2 border-secondary border-solid mb-12"></div>
                <div class="mx-auto max-w-[1500px] desk:px-4">
                    <div class="swiper mb-8 tablet:hidden"> 
                        <div class="swiper-wrapper" id="most-ordered-container">
                            @foreach($most_ordered_g2 as $group)
                                <div class="grid grid-cols-2 gap-4 swiper-slide px-4 desk:px-[50px]">
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
                        <div class="swiper-pagination text-secondary absolute top-[10px] left-[50%] translate-x-[-50%] z-[5]"></div>
                    </div>
                    <div class="swiper mb-8 hidden tablet:flex"> 
                        <div class="swiper-wrapper" id="most-ordered-2-container">
                            @foreach($most_ordered as $group)
                                <div class="grid grid-cols-3 gap-4 swiper-slide px-4 desk:px-[50px]">
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
                        @if(count($most_ordered) > 1)
                            <div class="swiper-pagination text-secondary absolute top-[90%] left-[50%] translate-x-[-50%] z-[5]"></div>
                            <div class="swiper-button-prev hidden desk:block text-secondary"></div>
                            <div class="swiper-button-next hidden desk:block text-secondary"></div>
                        @endif
                    </div>
                    <div class="mx-auto max-w-[250px]">
                        <x-interactive.btn :link="route('products')" class="!border-none w-full">
                            Voir Tous
                        </x-interactive.btn>
                    </div>
                </div>
            </section>
        @endif
        @foreach($cats_g1 as $category_groups)
            @if(count($category_groups))
                <section class="mb-12 relative">
                    <div class="mx-auto max-w-[1400px] p-4">
                        <h3 class="text-center pb-2">{{$category_groups[0][0]->category}}</h3>
                        <div class="mx-auto w-32 border-b-2 border-secondary border-solid mb-12"></div>
                        <x-elements.products-slider :groups="$category_groups" :cat="$category_groups[0][0]->category_id" 
                            len="3" class="mb-8"/>
                        @php
                            $query = '?categories=["' . $category_groups[0][0]->category_id . '"]';
                        @endphp
                        <div class="mx-auto max-w-[250px]">
                            <x-interactive.btn :link="route('products') . $query" class="!border-none w-full max-">
                                Voir
                            </x-interactive.btn>
                        </div>
                    </div> 
                </section>
            @endif
        @endforeach
        <section class="mb-24">
            <h3 class="text-center pb-2 mb-12">Nos services</h3>
            {{-- <div class="mx-auto w-32 border-b-2 border-secondary border-solid mb-12"></div> --}}
            <div class="grid xl:grid-cols-3 gap-9 max-w-screen-xl mx-auto px-8 mb-12"> 
                <article class="text-center p-8 bg-test">
                    <div><i class="fa-solid fa-truck-fast text-4xl text-secondary mb-8"></i></div>
                    <div class="text-3xl xl:text-4xl text-secondary mb-4 capitalize">livraison 58 wilayas</div>
                </article>
                <article class="text-center p-8 bg-test">
                    <div><i class="fa-solid fa-money-bill-wave text-4xl text-secondary mb-8"></i></div>
                    <div class="text-3xl xl:text-4xl text-secondary mb-4">Paiement à la Réception</div>
                </article>
                <article class="text-center p-8 bg-test">
                    <div><i class="fa-solid fa-sack-dollar text-4xl text-secondary mb-8"></i></div>
                    <div class="text-3xl xl:text-4xl text-secondary mb-4">Un Autre Service à offrir</div>
                </article>
            </div> 
        </section>
    </main>
</x-ui-elements.layout>
