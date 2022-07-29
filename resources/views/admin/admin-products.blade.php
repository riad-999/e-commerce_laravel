<x-ui-elements.layout>
    <div class="grid grid-cols-6 gap-8 bg-gray-100">
        <aside class="h-100vh py-8 px-4 bg-white shadow-md">
            <ul class="list-none">
                <li class="text-xl font-semibold hover:bg-gray-300">
                    <a href="" class="inline-block py-2 px-4">
                        <i class="fa-solid fa-bag-shopping mr-2"></i> produits
                    </a>
                </li>
                <li class="text-xl font-semibold hover:bg-gray-300">
                    <a href="" class="inline-block py-2 px-4">
                        <i class="fa-solid fa-bag-shopping mr-2 hover:bg-gray-300"></i> produits
                    </a>
                </li>
            </ul>
        </aside>
        <main class="col-span-5 pt-8 pl-4">
            <h4 class="font-body font-semibold mb-8">liste des produits</h3>
            <section class="p-4 bg-white mr-8 mb-12 shadow-md">
                <form class="flex justify-between items-baseline gap-4 py-4 border-b border-solid border-gray-400" autocomplete="off">  
                    <div class="flex gap-4 items-baseline">
                        <x-form.input type="search" placeholder="#id" name="id" 
                        class="w-24" value="{{ $id }}"/>
                        <x-form.input type="search" placeholder="nom de produit ..." 
                        name="name" value="{{ $name }}"/>
                        <div>   
                            <input type="checkbox" name="archived" 
                            value="true" id="archived" {{ $archived ? 'checked' : ''}} />
                            <label for="archived">produits archivés</label>
                        </div>
                        <div>
                            <input type="checkbox" name="promo" 
                            value="true" id="promo" {{ $promo ? 'checked' : ''}} />
                            <label for="promo">promo</label>
                        </div>
                        <button type="submit" class="btn capitalize ml-8">
                            chercher <i class="fa-solid fa-magnifying-glass ml-2"></i>
                        </button>
                    </div>
                </form>
                <section class="pt-8 pb-4">
                    @if(!count($products))
                        <div class="text-center">oops..., aucun produit disponible pour ces filtres</div>
                    @else
                        @foreach($products as $product)
                            <article class="grid grid-cols-6 justify-between items-center py-4 border-b border-solid border-gray-400">
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
                                <div>
                                    <span class="badge p-4 {{$product->archived ? 'bg-orange-300 text-orange-800' : 'bg-green-300 text-green-800'}}">
                                        {{!$product->archived ? 'à vendre' : 'archivé'}}
                                    </span>
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
                                    <button class="btn py-0 px-4 w-min">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
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
                </section>
            </section>
        </main>
    </div>
</x-ui-elements.layout>

