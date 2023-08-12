<x-ui-elements.layout>
    @guest
        <x-interactive.modal id="auth-alert" class="bg-gray-100">
            <form action="{{route('login')}}" method="POST" class="text-left p-4">
                @csrf
                <input type="hidden" name="redirect" value="{{route('cart')}}" />
                <button type="button" class="absolute top-0 right-2 text-xl text-secondary p-2 close-modal" data-id="auth-alert">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <p class="mb-4">
                    connectez vous pour utiliser un code promo. <br/> ou 
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
    <main class="max-w-[1400px] mx-auto pt-8 px-4"> 
        <header class="pb-8 border-b border-solid border-border mb-8">
            <div class="mb-2">
                <a href="{{route('products')}}">
                    <i class="fa-solid fa-arrow-left mr-2"></i> 
                    <span class="underline">boutique</span>
                </a>
            </div>
            <span class="text-2xl font-semibold text-black inline-block mr-2">
                Votre Panier
            </span>
            <span class="text-sm">({{session('cart') ? count(session('cart')) : 0}} produits)</span>
        </header>
        <main>
            @if(!$cart)
                <section class="text-center pt-4">
                    <div>
                        oops, vous n'avait aucun produit dans votre panier, allez au boutique pour le remplire.
                    </div>
                    <div>
                        <x-interactive.btn class="w-full tablet:max-w-[400px] mx-auto mt-4" :link="route('products')">
                            Boutique
                        </x-interactive.btn>
                    </div>
                </section>
            @else
                <section class="grid desk:grid-cols-10 gap-8 items-start">
                    <section class="tablet:col-span-5 desk:col-span-6">
                        <header class="hidden desk:grid grid-cols-4 gap-8 pb-8">
                            <div class="col-span-2">Produit</div>
                            <div>Coût</div>
                            <div>Quantité</div>
                        </header>
                        @php
                            $sum = 0;
                        @endphp
                        @foreach($cart as $item)
                            <article class="grid grid-cols-2 desk:grid-cols-4 gap-4 span pb-8 {{$loop->first ? '' : 'pt-8'}} border-b border-solid border-border">
                                <img class="block" src="{{config('globals.images_end_point') . $item->image}}" />
                                <div class="desk:hidden">
                                    <div class="mb-4">
                                        <div class="font-semibold text-black">{{$item->brand}}</div>
                                        <div class="font-semibold text-black">{{$item->name}}</div>
                                    </div>
                                    <div class="grid desk:hidden grid-cols-2 gap-2 mb-2">
                                        <div>couleur: </div>
                                        <x-elements.color-square :color="$item->color"/>
                                    </div>
                                    <div class="grid desk:hidden grid-cols-2 gap-2 mb-2">
                                        <div>Coût: </div>
                                        @if($item->promo)
                                            @if(($item->cut && ($item->cut * $item->price / 100) < $item->promo))
                                            {{-- @if($item->cut) --}}
                                                @php
                                                    $sum += floor($item->cut * $item->price / 100) * $item->quantity;
                                                @endphp
                                                <div>
                                                    <div class="text-pink line-through">{{$item->promo}}Da</div>
                                                    <div class="text-green-500">{{floor($item->cut * $item->price / 100)}}Da</div>
                                                </div>
                                            @else
                                                @php
                                                    $sum += $item->promo * $item->quantity;
                                                @endphp
                                                <div class="text-pink">{{$item->promo}}Da</div>
                                            @endif
                                        @elseif($item->cut)
                                                @php
                                                    $sum += floor($item->cut * $item->price / 100) * $item->quantity;
                                                @endphp
                                                <div>
                                                    <div class="line-through">{{$item->price}}Da</div>
                                                    <div class="text-green-500">{{floor($item->cut * $item->price / 100)}}Da</div>
                                                </div>
                                            @else
                                                @php
                                                    $sum += $item->price * $item->quantity;
                                                @endphp
                                                <div>{{$item->price}}Da</div>
                                        @endif
                                    </div>
                                    <div class="tablet:grid desk:hidden grid-cols-2 gap-2 mb-2">
                                        <div class="hidden tablet:block">quantité: </div>
                                        <input type="hidden" name="{{$item->product_id}}-{{$item->color_id}}"
                                        value="{{$item->quantity}}" id="{{$item->product_id}}-{{$item->color_id}}"/>
                                        <div>
                                            <div class="flex text-center text-sm update-quantity" data-max="{{$item->max}}"
                                            data-id="{{$item->product_id}}-{{$item->color_id}}" data-product_id="{{$item->product_id}}" 
                                            data-color_id="{{$item->color_id}}" id="mob-{{$item->product_id}}-{{$item->color_id}}">
                                                <button class="bg-black text-white py-1 px-3 update-btn" data-flag="decrease">-</button>
                                                <div class="px-6 py-2 bg-gray-100 quantity">{{$item->quantity}}</div>
                                                <button class="bg-black text-white py-1 px-3 update-btn" data-flag="increase">+</button>
                                            </div>
                                        </div>
                                        <div class="my-2 col-span-2">
                                            <x-form.error :name="$item->product_id . '-' . $item->color_id" />
                                        </div>
                                    </div>
                                    <form action="{{route('delete-cart-item')}}" class="mt-2" method="POST">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="product_id" value="{{$item->product_id}}" />
                                        <input type="hidden" name="color_id" value="{{$item->color_id}}" />
                                        <button type="submit" class="underline">Supprimer</button> 
                                    </form>
                                </div>
                                <div class="hidden desk:grid grid-cols-3 gap-8 col-span-3">
                                    <div>
                                        <div class="font-semibold text-black">{{$item->brand}}</div>
                                        <div class="font-semibold text-black">{{$item->name}}</div>
                                        <div><x-elements.color-square :color="$item->color"/></div>
                                        <form action="{{route('delete-cart-item')}}" class="mt-2" method="POST">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="product_id" value="{{$item->product_id}}" />
                                            <input type="hidden" name="color_id" value="{{$item->color_id}}" />
                                            <button type="submit" class="underline">Supprimer</button> 
                                        </form>
                                    </div>
                                    <div>
                                        @if($item->promo)
                                            @if(($item->cut && ($item->cut * $item->price / 100) < $item->promo))
                                            {{-- @if($item->cut) --}}
                                                <div class="text-pink line-through">{{$item->promo}}Da</div>
                                                <div class="text-green-500">{{floor($item->cut * $item->price / 100)}}Da</div>
                                            @else
                                                <div class="text-pink">{{$item->promo}}Da</div>
                                            @endif
                                        @elseif($item->cut)
                                                <div class="line-through">{{$item->price}}Da</div>
                                                <div class="text-green-500">{{floor($item->cut * $item->price / 100)}}Da</div>
                                            @else
                                                <div>{{$item->price}}Da</div>
                                        @endif                    
                                    </div>
                                    <div>
                                        <div class="flex text-center text-sm update-quantity mb-2" data-max="{{$item->max}}"
                                        data-id="{{$item->product_id}}-{{$item->color_id}}" data-product_id="{{$item->product_id}}" 
                                        data-color_id="{{$item->color_id}}" id="desk-{{$item->product_id}}-{{$item->color_id}}">
                                            <button class="bg-black text-white py-1 px-2" data-flag="decrease">-</button>
                                            <div class="px-6 py-1 bg-gray-100 quantity">{{$item->quantity}}</div>
                                            <button class="bg-black text-white py-1 px-2" data-flag="increase">+</button>
                                        </div>
                                        <x-form.error :name="$item->product_id . '-' . $item->color_id" />
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </section>
                    <section class="tablet:col-span-5 desk:col-span-4 p-4 border-solid border border-border">
                        {{-- @if(!session('promo_code_id'))
                            <label for="code" class="font-semibold text-black text-sm">entrer le code promo</label>
                            <form action="{{route('apply-promo-code')}}" method="POST" class="grid grid-cols-6 gap-2 pb-4 border-b border-solid border-border mb-4">
                                @csrf
                                <div class="col-span-4">
                                    <input name="code" id="code" class="w-full p-2 border border-solid border-border" value="" placeholder="code promo..." />
                                    <x-form.error name="code" />
                                    @if(session('warning'))
                                        <div class="text-sm text-orange-600 font-semibold mt-2">
                                            aucun produit dans le panier n'est associé avec ce code promo
                                        </div>
                                    @endif
                                </div>
                                @auth
                                    <x-interactive.btn type="submit" class="col-span-2">
                                        Appliquer
                                    </x-interactive.btn>
                                @else
                                    <x-interactive.btn type="button" class="col-span-2 open-modal" data-id="auth-alert">
                                        Appliquer
                                    </x-interactive.btn>
                                @endauth
                            </form>
                        @else 
                            <form action="{{route('remove-promo-code')}}" method="POST" class="grid grid-cols-6 gap-2 pb-4 border-b border-solid border-border mb-4">
                                @csrf
                                <div class="col-span-4">
                                    <div name="code" id="code" class="w-full p-2">{{old('code')}}</div>
                                </div>
                                <x-interactive.btn type="submit" class="col-span-2">
                                    Enlever
                                </x-interactive.btn>
                            </form>
                        @endif --}}
                        <form action="{{route('validate-order')}}">
                            <div class="text-xl text-black font-semibold mb-2">
                                Sous-Total: <span id="sub-total">{{$sum}}Da</span>
                            </div>
                            <x-interactive.btn type="submit" class="w-full">
                                Valider la Commande
                            </x-interactive.btn>
                        </form>
                    </section>
                </section>
            @endif
        </main>
    </main>
</x-ui-elements.layout>




{{-- DROP EVENT IF EXISTS check_promo;
CREATE EVENT `check_promo`
  ON SCHEDULE EVERY 6 HOUR  STARTS '2022-08-17 00:00:00'
  ON COMPLETION PRESERVE
DO BEGIN
   UPDATE products SET promo = NULL, expires = NULL 
   WHERE expires = CURDATE();
END; --}}