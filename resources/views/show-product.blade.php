<x-ui-elements.layout>
    @if(session('side-cart'))
         <x-interactive.side-cart :cart="session('cart')"/>
    @endif
    <x-interactive.modal id="cart-alert" class="bg-gray-100">
        <form class="text-left tablet:grid grid-cols-6 gap-4" action="{{route("add-to-cart")}}" method="POST" autocomplete="off">
            @csrf
            <button type="button" data-id="cart-alert" class="close-modal absolute top-2 right-4 text-xl text-black">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <img class="block w-full mt-6 mb-4 tablet:my-0  col-span-3" id="cart-image" 
            src="{{IMAGES_END_POINT . $product->colors[0]->main_image}}"/>
            <div class="text-left col-span-3">
                <h6 class="font-semibold tracking-wide font-body pr-4">
                    {{$product->name}}
                </h6>
                <div class="text-secondary font-semibold {{$product->promo ? 'line-through' : ''}}">
                    prix: {{$product->price}}Da
                </div>

                @if($product->promo)
                    <div class="text-pink font-semibold">promo!: {{$product->promo}}Da</div>
                @endif
                <div class="grid gap-2 mt-4">
                    <div class="text-sm font-semibold left-quantity text-pink">{{$product->colors[0]->quantity}} disponible</div>
                    <x-form.input type="number" name="quantity" data-submit="cart" label="quantité"
                    max="{{$product->colors[0]->quantity}}" min="1" value="1" class="w-full" :margin="false"/>
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <input type="hidden" name="color_id" id="color_id" value="">
                    <x-interactive.btn class="w-full disabled:bg-secondary disabled:opacity-20" id="cart" name="cart"
                    type="submit" data-id="cart-alert">
                        ajouter
                    </x-interactive.btn>
                </div>
            </div>
        </form>
    </x-interactive.modal>
    @guest
        <x-interactive.modal id="auth-alert" class="bg-gray-100">
            <form action="{{route('login')}}" method="POST" class="text-left p-4">
                @csrf
                <input type="hidden" name="redirect" value="{{route('show-product',$product->id)}}" />
                <button type="button" class="absolute top-0 right-2 text-xl text-secondary p-2 close-modal" data-id="auth-alert">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <p class="mb-4">
                    connectez vous pour réaliser cette action, ou 
                    <a href="{{route('register')}}" class="underline">inscrivez vous</a> 
                </p>
                @if(session('registered'))
                    <p class="mb-4">votre compte a été bien enregistré, connectez vous</p>
                @endif
                <x-form.input name="name" label="nom *" value="{{old('name')}}" 
                    class="w-full" placeholder="votre nom" />
                <x-form.input type="password" name="password" label="mot de pass *" 
                    class="w-full text-sm" />
                <div class="mb-2">
                    <input type="checkbox" id="remember_me" name="remember_me" value="true" {{old('remember_me') ? 'checked' : ''}} id="remember_me" class="accent-black cursor-pointer" />
                    <label for="remember_me" class="pl-2 cursor-pointer">
                        souvenez moi
                    </label>
                </div>
                <small class="text-sm underline"><a href="{{route('password.request')}}">mot de pass oublié ?</a></small>
                <x-interactive.btn class="w-full mt-4">se connecter</x-interactive.btn>
            </form>
        </x-interactive.modal>
    @endguest
    <main class="mx-auto max-w-[1600px] mb-12">
        <a href="{{route('products')}}" class="mt-4 pl-4 desk:pl-12 inline-block">
            <i class="fa-solid fa-arrow-left mr-2"></i> 
            <span class="underline">boutique</span>
        </a>
        <section class="flex flex-col tablet:flex-row items-start gap-4 tablet:gap-8 px-4 mt-4 mb-12">
            <section class="swiper mx-0 mb-4 desk:mb-0 tablet:w-[40%] max-w-[600px]">
                <div class="swiper-wrapper" id="images-container">
                    <img class="swiper-slide block desk:px-12" 
                    src="{{IMAGES_END_POINT . $product->colors[0]->main_image}}">
                    @foreach($product->colors[0]->images as $image) 
                        <img class="swiper-slide block desk:px-12" 
                        src="{{IMAGES_END_POINT . $image->image}}">
                    @endforeach
                </div>
                <div class="swiper-pagination text-secondary"></div>
                <div class="swiper-button-prev hidden desk:block text-secondary"></div>
                <div class="swiper-button-next hidden desk:block text-secondary"></div>
            </section>
            <section class="tablet:w-[55%] max-w-[600px]">
                <div class="flex justify-between items-start">
                    <div>
                        <h5 class="font-semibold tracking-wide font-body">
                            {{$product->name}}
                        </h5>
                        <h6 class="mb-2">{{$product->category}}, {{$product->brand}}</h6>
                        @if($product->score)
                            <x-elements.score :score="$product->score" :count="count($product->reviews)" class="mb-8" />
                        @endif
                    </div>
                    @php
                        if(auth()->check())
                            $auth = true;
                        else 
                            $auth = false;
                    @endphp
                    @cannot('isAdmin')
                        <div class="mr-4 text-secondary text-xl relative">
                            <button data-id="auth-alert" class="{{$auth ? '' : 'open-modal'}}" 
                            id="save-btn" data-state="{{isset($product->saved) && $product->saved ? 'saved' : 'unsaved'}}" 
                            data-product="{{$auth ? $product->id : ''}}">
                                <div class="absolute right-0 top-[-48px] transition scale-0 duration-300 
                                overflow-hidden text-sm z-[5] bg-secondary text-white py-2 px-4 save-notice"></div>
                                @if(isset($product->saved) && $product->saved)
                                    <i class="fa-solid fa-bookmark" data-icone="saved-icone"></i>
                                    <i class="fa-regular fa-bookmark !hidden" data-icone="unsaved-icone"></i>
                                @else
                                    <i class="fa-solid fa-bookmark !hidden" data-icone="saved-icone"></i>
                                    <i class="fa-regular fa-bookmark" data-icone="unsaved-icone"></i>
                                @endif
                            </button>
                        </div>
                    @endcannot
                </div>
                <div class="text-sm mb-2 text-pink left-quantity">{{$product->colors[0]->quantity}} diponible</div>
                <div class="grid grid-cols-color gap-4 mb-4 colors-container" id="colors-container">
                    @foreach($product->colors as $color)
                            @php
                                $main_image = [IMAGES_END_POINT . $color->main_image];
                                $others = [];
                                foreach($color->images as $image) {
                                    array_push($others, IMAGES_END_POINT . $image->image);
                                }
                                $images = json_encode(array_merge($main_image, $others));
                            @endphp
                            <x-elements.color-square :color="$color" data-color="{{$color->id}}" 
                            data-product="{{$product->id}}" class="cursor-pointer color-square
                            {{$loop->index == 0 ? 'outline-secondary outline-2 outline' : ''}}"
                            data-images="{{$images}}" data-id="images-container" data-quantity="{{$color->quantity}}"/>
                    @endforeach
                </div>
                @if($product->solds)
                    <div class="text-sm">{{$product->solds}} commandé(s)</div>
                @endif
                <div class="mb-4">
                    <div id="price" class="text-secondary font-semibold {{$product->promo ? 'line-through' : ''}}">
                        prix: {{$product->price}}Da
                    </div>
                    @if($product->promo)
                        <div class="text-pink font-semibold" id="promo">promo!: {{$product->promo}}Da</div>
                        <div class="text-black font-semibold">l'offre se termine dans:</div>
                        @if($product->expires)
                            <x-elements.countdown :date="$product->expires" />
                        @endif
                    @endif
                </div>
                <div class="grid desk:grid-cols-2 mb-8">
                    {{-- <form action="{{route('cart')}}" method="POST" 
                    class="cart-form" id="cart-form2" data-buy="true">
                        @csrf
                        <x-interactive.btn class="w-full" 
                        name="cart" value="">
                            Commander
                        </x-interactive.btn> --}}
                    {{-- </form> --}}
                    <x-interactive.btn class="add-to-cart open-modal" id="add-to-cart"
                    data-color="{{$product->colors[0]->id}}" data-product="{{$product->id}}" 
                    data-id="cart-alert" data-image="{{$main_image[0]}}" :white="true">
                        Ajouter <span class="inline-block ml-2">+</span><i class="fa-solid fa-cart-shopping"></i>
                    </x-interactive.btn>
                    <div></div>
                </div>
                @if($product->description)
                    <h5 class="font-body font-semibold">description</h5>
                    <p>
                        {{$product->description}}
                    </p>
                @endif
            </section>
        </section>
        @if(count($product->reviews))
            <section class="border-y border-solid border-border px-4">
                <button class="block w-full text-left px-2 py-8 toggle-drop-down" id="toggle-reviews" data-id="reviews">
                    <h5 class="font-body inline-block font-semibold">
                        feedback 
                        <i class="fa-solid fa-angle-down ml-4 show"></i>
                        <i class="fa-solid fa-angle-up close ml-4 !hidden"></i>
                    </h5>
                </button>
                <section class="h-0 overflow-hidden transition-height duration-300">
                    <div id="reviews">
                        @foreach($product->reviews as $review)
                            <x-elements.review :review="$review" 
                            class="{{!$loop->last ? 'border-b border-solid border-border' : ''}}"/>
                        @endforeach
                    </div>
                </section>
            </section>
        @endif
    </main>
</x-ui-elements.layout>