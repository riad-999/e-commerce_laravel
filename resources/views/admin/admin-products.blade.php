<x-ui-elements.admin-layout>
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i> 
                    vous voulez vraiment supprimer ce produit
                </div>
                <button class="btn capitalize close-modal" 
                type="button" data-id="delete">annuler</button>
                <button class="btn capitalize" type="sumbit">oui</button>
            </div>
        </form>
    </x-interactive.modal>
    <main class="mb-12 w-full max-w-[1600px] mx-auto">
        <h4 class="font-body font-semibold mb-8">liste des produits</h3>
        <section class="p-4 bg-white">
            <form class="py-4 border-b border-solid border-gray-400" autocomplete="off">
                <div class="flex flex-col desk:flex-row desk:items-baseline gap-4">  
                    <x-form.input type="search" placeholder="#id" name="id" 
                    class="w-24" value="{{ $id }}"/>
                    <x-form.input type="search" placeholder="nom de produit ..." 
                    name="name" value="{{ $name }}" class="w-[400px]"/>
                    <div>
                        <input type="checkbox" name="promo" 
                        value="true" id="promo" {{ $promo ? 'checked' : ''}} />
                        <label for="promo">promo</label>
                    </div>
                </div>
                <div>
                    <x-interactive.btn type="reset" :white="true">
                        reset
                    </x-interactive.btn>
                    <x-interactive.btn type="submit" class="ml-2">
                        chercher <i class="fa-solid fa-magnifying-glass ml-2"></i>
                    </x-interactive.btn>
                </div>
            </form>
            <section class="pt-8 pb-4 overflow-x-auto">
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
                                    <a href="{{route('edit-product',$product->id)}}" class="block">
                                        <img src="{{$product->colors[0]->main_image}}" width="100" alt="product image" />
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
                                {{-- <div>
                                    <span class="badge p-4 {{$product->archived ? 'bg-orange-300 text-orange-800' : 'bg-green-300 text-green-800'}}">
                                        {{!$product->archived ? 'à vendre' : 'archivé'}}
                                    </span>
                                </div> --}}
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
                                    <x-interactive.btn tabindex="0" class="btn" :white="true">
                                        ...
                                    </x-interactive.btn>
                                    <ul tabindex="0" class="dropdown-content menu shadow bg-white rounded-box w-52">
                                        <li class="hover:bg-gray-200"><a class="p-2" href="{{route('product',$product->id)}}">détails</a></li>
                                        <li class="hover:bg-gray-200"><a class="p-2" href="{{route('edit-product',$product->id)}}">moudifier</a></li>
                                        <li class="hover:bg-gray-200 p-2 cursor-pointer open-modal" data-id="delete" data-route="{{route('delete-product',$product->id)}}">
                                            supprimer  
                                        </li>
                                    </ul>
                                </div>
                                </div>
                            </article>
                        @endforeach
                        <div class="btn-group flex mt-12">
                            <button class="ml-auto btn" type="button">
                                <a href="{{$prevUrl}}"><i class="fa-solid fa-angles-left"></i></a>
                            </button>
                            <button class="btn capitalize">page {{$currentPage}} sur {{$lastPage}}</button>
                            <button class="mr-auto btn" type="button">
                                <a href="{{$nextUrl}}"><i class="fa-solid fa-angles-right"></i></a>
                            </button>
                        </div>
                    @endif
                </div>
            </section>
        </section>
    </main>
</x-ui-elements.admin-layout>

