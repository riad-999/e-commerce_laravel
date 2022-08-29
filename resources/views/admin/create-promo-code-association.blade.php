<x-ui-elements.admin-layout>
    @php
        $cut_list = [];
        for($i = 5; $i <= 95; $i += 5) {
            array_push($cut_list,(object) ['name' => "$i%", 'value' => $i]);
        }
    @endphp
    <section class="grid tablet:grid-cols-10 gap-4 mt-12 mx-auto max-w-[900px] p-4">
        <section class="tablet:col-span-7 max-w-[500px] order-2 tablet:order-none">
            <h5 class="font-body font-semibold mb-4 normal-case">Associer les Produits</h5>
            <h5 class="font-body font-semibold mb-8">
                <a class="underline" href="{{route('edit-promo-code',$code->id)}}">
                    Code: {{$code->code}}
                </a>
            </h5>
            <a class="block mb-4 underline" href="{{route('promo-code-assocations',$code->id)}}">produits</a> 
            <x-form.select type="number" class="w-full disabled:pointer-events-none disabled:opacity-40" 
            name="cut" value="{{request()->input('cut')}}" id="cut-select" label="réduction" :list="$cut_list" 
            class="w-full" :selected="session('selected_cut')"/>
            <section id="add-promo-code">
                @if(count($products))
                    <header class="grid grid-cols-3 gap-4 py-2 mb-2 border-b border-solid border-border">
                        <div class="col-span-2">produit</div>
                        <div class="justify-self-center">réduction</div>
                    </header>
                    @foreach($products as $product)
                        <article class="grid grid-cols-3 gap-4 py-2">
                            <div class="grid grid-cols-product-promo gap-2 col-span-2">
                                <div>
                                    <img src="{{IMAGES_END_POINT . $product->main_image}}" class="w-full" alt="product image" />
                                </div>
                                <div>
                                    <div>#{{$product->id}}, {{$product->name}}</div>
                                    <div>
                                        @if($product->promo)
                                            <span class="line-through">{{$product->price}}Da</span>
                                            <span class="text-pink ml-2">{{$product->price}}Da</span>
                                        @else
                                            <span>{{$product->price}}Da</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="justify-self-center">
                                @if($product->cut)
                                    <button type="button" class="p-2 text-xl text-secondary" data-added="true">
                                        {{$product->cut}}%
                                    </button>
                                @else
                                    <button type="button"  class="p-2 text-xl text-secondary" data-add="true" 
                                    data-product="{{$product->id}}" data-code="{{$code->id}}">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                @endif
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
                @else
                    <div>
                        aucune association est trouvée!
                    </div>
                @endif
            </section>
        </section>
        <form class="tablet:col-span-3 w-full" autocomplete="off">
            @php
                array_unshift($cut_list,(object) ['name' => 'tous', 'value' => null]);
            @endphp
            <h5 class="font-body font-semibold mb-8">filtres</h5>
            <x-form.input name="id" label="id" placeholder="#" value="{{request()->input('id')}}" class="w-full"/>
            <x-form.input name="search" label="nom" value="{{request()->input('search')}}" placeholder="ecrire..." class="w-full"/>
            <x-interactive.btn type="submit" class="w-full mt-4">Filtrer</x-interactive.btn>
        </form>
    </section>
</x-ui-elements.admin-layout>