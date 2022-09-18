<x-ui-elements.admin-layout>
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-secondary"></i> 
                    vous voulez vraiment supprimer ce produit
                </div>
                <x-interactive.btn class="w-[150px] mr-2 close-modal" :white="true" type="button" data-id="delete">
                    Annuler
                </x-interactive.btn>
                <x-interactive.btn class="w-[150px]" type="sumbit">
                    Oui
                </x-interactive.btn>
            </div>
        </form>
    </x-interactive.modal>
    <section class="grid desk:grid-cols-4 gap-8 items-start">
        <form class="border border-solid border-gray-400 desk:order-1 p-4 max-w-[500px]" autocomplete="off"> 
            <x-form.input type="search" placeholder="#id" name="id" class="w-full" value="{{ $id }}"/>
            <x-form.input type="search" placeholder="nom de produit ..." name="name" value="{{ $name }}" class="w-full"/>
            <div class="mb-4">
                <input type="checkbox" name="promo" class="mr-2 accent-black"
                value="true" id="promo" {{ $promo ? 'checked' : ''}} />
                <label for="promo" class="cursor-pointer">promo</label>
            </div>
            <x-interactive.btn type="submit" class="w-full mb-2">
                Chercher
            </x-interactive.btn>
            <x-interactive.btn :link="route('admin-products')" :white="true" class="w-full">
                Réinitialiser
            </x-interactive.btn>
        </form>
        <section class="pb-4 overflow-x-auto desk:col-span-3">
            <div class="flex justify-between gap-2 mb-8">
                <h4 class="font-body font-semibold">liste des produits</h3>
                <x-interactive.btn :link="route('initial-create-product')">
                    Ajouter
                </x-interactive.btn>
            </div>
            <div class="min-w-[800px]">
                @if(!count($products))
                    <div class="text-center">oops..., aucun produit disponible pour ces filtres</div>
                @else
                    <header class="grid grid-cols-5 gap-4 py-4 border-b border-solid border-border">
                        <div class="col-span-2">Produit</div>
                        <div>Prix</div>
                        <div>Date</div>
                        <div></div>
                    </header>
                    @foreach($products as $product)
                        <article class="grid grid-cols-5 justify-between items-center py-4 border-b border-solid border-border">
                            <div class="flex items-center gap-6 col-span-2">
                                <a href="{{route('show-product',$product->id)}}" class="block">
                                    <img src="{{config('globals.images_end_point') . $product->colors[0]->main_image}}" width="100" alt="product image" />
                                </a>
                                <div>
                                    <span class="block">#{{$product->id}}</span>
                                    <span class="block font-semibold">{{$product->name}}</span>
                                    <span class="block">{{$product->brand}}, {{$product->category}}</span>
                                    <span class="block">{{count($product->colors)}} couleurs</span>
                                </div>
                            </div>
                            <div class="{{ $product->promo ? 'text-pink' : ''}}">
                                {{$product->promo ? $product->promo : $product->price}}Dz
                            </div>
                            <div>
                                @php
                                    $createDate = null;
                                    if($product->created_at)
                                        $createDate = new DateTime($product->created_at);
                                    $date = $createDate ? $createDate->format('Y-m-d') : '-';
                                @endphp
                                {{$date}}
                            </div>
                            <div>
                                <div class="dropdown dropdown-top">
                                <button type="button" tabindex="0" :white="true">
                                    ...
                                </button>
                                <ul tabindex="0" class="dropdown-content menu shadow bg-white rounded-box w-52">
                                    <li class="hover:bg-gray-200"><a class="p-2" href="{{route('show-product',$product->id)}}">détails</a></li>
                                    <li class="hover:bg-gray-200"><a class="p-2" href="{{route('edit-product',$product->id)}}">modifier</a></li>
                                    <li class="hover:bg-gray-200 p-2 cursor-pointer open-modal" data-id="delete" data-route="{{route('delete-product',$product->id)}}">
                                        supprimer  
                                    </li>
                                </ul>
                            </div>
                            </div>
                        </article>
                    @endforeach
                    <div class="btn-group flex my-12">
                        <x-interactive.btn :link="$prevUrl" class="ml-auto border-black border !border-solid">
                            <i class="fa-solid fa-angles-left"></i>
                        </x-interactive.btn>
                        <x-interactive.btn :white="true">
                            Page {{$currentPage}} Sur {{$lastPage}}
                        </x-iteractive.btn>
                        <x-interactive.btn :link="$nextUrl" class="mr-auto border-black border !border-solid">
                            <i class="fa-solid fa-angles-right"></i>
                        </x-interactive.btn>
                    </div>
                @endif
            </div>
        </section>
    </section>
</x-ui-elements.admin-layout>

