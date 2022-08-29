<x-ui-elements.admin-layout>
    @php
        $cut_list = [];
        for($i = 5; $i <= 95; $i += 5) {
            array_push($cut_list,(object) ['name' => "$i%", 'value' => $i]);
        }
    @endphp
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-secondary"></i> 
                    vous voulez vraiment supprimer cette assocation ?
                </div>
                <x-interactive.btn type="button" class="close-modal" data-id="delete" :white="true">
                    Annuler
                </x-interactive.btn>
                <x-interactive.btn type="submit" class="ml-2">
                    Oui
                </x-interactive.btn>
            </div>
        </form>
    </x-interactive.modal>
    <x-interactive.modal id="update" data-form="true">
        <form action="" method="POST" autocomplete="off">
                @csrf
                @method('PATCH')
                <div class="text-left">
                    <div class="font-semibold text-secondary mb-8 text-center">Modifier</div>
                    <x-form.select type="number" class="w-full disabled:pointer-events-none disabled:opacity-40" 
                    name="cut" value="{{request()->input('cut')}}" label="réduction" :list="$cut_list" 
                    title="séléctioner la rédution" class="w-full"/>
                    <div class="grid grid-cols-2 gap-2">
                        <x-interactive.btn type="button" class="close-modal" data-id="update" :white="true">
                            Annuler
                        </x-interactive.btn>
                        <x-interactive.btn type="submit" class="ml-2">
                            Oui
                        </x-interactive.btn>
                    </div>
                </div>
            </form>
    </x-interactive.modal>
    <section class="grid tablet:grid-cols-10 gap-4 mt-12 mx-auto max-w-[900px] p-4">
        <section class="tablet:col-span-7 max-w-[500px] order-1 tablet:order-none">
            <h5 class="font-body font-semibold mb-4">produits</h5>
            <h5 class="font-body font-semibold mb-8">
                <a class="underline" href="{{route('edit-promo-code',$code->id)}}">
                    Code: {{$code->code}}
                </a>
            </h5>
            @if(count($products))
                <header class="grid grid-cols-3 gap-4 py-2 mb-2 border-b border-solid border-border">
                    <div class="col-span-2">produit</div>
                    <div>réduction</div>
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
                        <div class="flex">
                            <div class="inline-block w-[50px]">{{$product->cut}}%</div>
                            <div class="text-secondary ml-2">
                                <button class="p-1 open-modal" data-id="update" 
                                data-route="{{route('update-promo-code-assocations',['id' => $code->id, 'product_id' => $product->id])}}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="p-1 open-modal" data-id="delete" 
                                data-route="{{route('delete-promo-code-assocations',['id' => $code->id, 'product_id' => $product->id])}}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
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
            @else
                <div>
                    aucune association est trouvée!
                </div>
            @endif
        </section>
        <form class="tablet:col-span-3" autocomplete="off">
            @php
                array_unshift($cut_list,(object) ['name' => 'tous', 'value' => null]);
            @endphp
            <h5 class="font-body font-semibold mb-8">filtres</h5>
            <x-form.input name="id" label="id" placeholder="#" value="{{request()->input('id')}}" class="w-full"/>
            <x-form.input name="search" label="nom" value="{{request()->input('search')}}" placeholder="ecrire..." class="w-full"/>
            <x-form.select type="number" class="w-full disabled:pointer-events-none disabled:opacity-40" 
            name="cut" value="{{request()->input('cut')}}" label="réduction" :list="$cut_list" 
            :selected="request()->input('cut')" class="w-full"/>
            <x-interactive.btn type="submit" class="w-full mt-4">Filtrer</x-interactive.btn>
            <x-interactive.btn type="reset" class="w-full mt-4" :white="true">Réinitialiser</x-interactive.btn>
        </form>
    </section>
</x-ui-elements.admin-layout>