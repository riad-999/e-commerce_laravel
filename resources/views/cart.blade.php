<x-ui-elements.layout>
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
                        <x-interactive.btn class="w-max mx-auto mt-4" :link="route('products')">
                            Boutique
                        </x-interactive.btn>
                    </div>
                </section>
            @else
                <section class="grid desk:grid-cols-10 gap-8 items-start">
                    <section class="tablet:col-span-5 desk:col-span-6">
                        <header class="hidden desk:grid grid-cols-4 gap-8 pb-8">
                            <div class="col-span-2">Produit</div>
                            <div>Prix</div>
                            <div>Quantité</div>
                        </header>
                        @foreach($cart as $item)
                            <article class="grid grid-cols-2 desk:grid-cols-4 gap-4 span pb-8 {{$loop->first ? '' : 'pt-8'}} border-b border-solid border-border">
                                <img class="block" src="{{IMAGES_END_POINT . $item->image}}" />
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
                                            <div class="text-pink">{{$item->promo}}Da</div>
                                        @else
                                            <div>{{$item->price}}Da</div>
                                        @endif
                                    </div>
                                    <div class="grid desk:hidden grid-cols-2 gap-2 mb-2">
                                        <div class="hidden tablet:block">quantité: </div>
                                        <input type="hidden" name="{{$item->product_id}}-{{$item->color_id}}"
                                        value="{{$item->quantity}}" id="{{$item->product_id}}-{{$item->color_id}}"/>
                                        <div class="flex text-center text-sm update-quantity" data-max="{{$item->max}}"
                                        data-id="{{$item->product_id}}-{{$item->color_id}}" data-product_id="{{$item->product_id}}" 
                                        data-color_id="{{$item->color_id}}" id="mob-{{$item->product_id}}-{{$item->color_id}}">
                                            <button class="bg-black text-white py-1 px-3 update-btn" data-flag="decrease">-</button>
                                            <div class="px-6 py-2 bg-gray-100 quantity">{{$item->quantity}}</div>
                                            <button class="bg-black text-white py-1 px-3 update-btn" data-flag="increase">+</button>
                                        </div>
                                    </div>
                                    <form action="{{route('delete-cart-item')}}" method="POST" class="mt-4">
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
                                            <div class="text-pink">{{$item->promo}}Da</div>
                                        @else
                                            <div>{{$item->price}}Da</div>
                                        @endif                     
                                    </div>
                                    <div>
                                        <div class="flex text-center text-sm update-quantity" data-max="{{$item->max}}"
                                        data-id="{{$item->product_id}}-{{$item->color_id}}" data-product_id="{{$item->product_id}}" 
                                        data-color_id="{{$item->color_id}}" id="desk-{{$item->product_id}}-{{$item->color_id}}">
                                            <button class="bg-black text-white py-1 px-2" data-flag="decrease">-</button>
                                            <div class="px-6 py-1 bg-gray-100 quantity">{{$item->quantity}}</div>
                                            <button class="bg-black text-white py-1 px-2" data-flag="increase">+</button>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </section>
                    <section class="tablet:col-span-5 desk:col-span-4 p-4 border-solid border border-border">
                        <label for="promo-code" class="font-semibold text-black text-sm">entrer le code promo</label>
                        <form class="grid grid-cols-6 gap-2 pb-4 border-b border-solid border-border mb-4">
                            <input name="promo-code" id="promo-code" class="p-2 col-span-4 border border-solid border-border" placeholder="code promo..." />
                            <x-interactive.btn type="submit" class="col-span-2">
                                Appliquer
                            </x-interactive.btn>
                        </form>
                        <form action="">
                            <div class="text-xl text-black font-semibold mb-2">
                                @php
                                $sum = 0;
                                foreach($cart as $itm) {
                                        if($itm->promo)
                                            $sum += $itm->promo * $itm->quantity;
                                        else 
                                            $sum += $itm->price * $itm->quantity;
                                } 
                                @endphp
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