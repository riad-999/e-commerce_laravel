<x-ui-elements.admin-layout>
    <section class="mt-12">
        <form action="{{route('update-promo-code-cut',['id' => $id, 'cut' => $cut])}}" 
            method="POST" class="mb-8 w-full max-w-[500px] mx-auto p-4" autocomplete="off">
            @csrf
            @method('PATCH')
            <h5 class="font-body font-semibold mb-4 desk:mb-8">modifier la réduction</h5>
            @php
                $cut_list = [];
                for($i = 5; $i <= 95; $i += 5) {
                    array_push($cut_list,(object) ['name' => "$i%", 'value' => $i]);
                }
            @endphp
            <x-form.select type="number" class="w-full disabled:pointer-events-none disabled:opacity-40" 
            name="cut" title="séléctionez la réduction" value="{{old('cut') ? old('cut') : $cut}}" 
            label="réduction" :list="$cut_list" :selected="old('cut') ? old('cut') : $cut"/>
            <x-interactive.btn type="submit" class="w-full mt-4">Modifier</x-interactive.btn>
            <div class="border-b border-solid border-border pb-4"></div>
        </form>
        <section class="w-full max-w-[500px] mx-auto p-4">
            <h5 class="font-body font-semibold mb-4 desk:mb-8">produits</h5>
            <header class="grid grid-cols-promo-code-products gap-4 py-2 border-b border-solid border-border mb-2">
                <div>produit</div>
                <div>prix</div>
                <div></div>
            </header>
            <main class="border-b border-border border-solid max-h-[400px] desk:max-h-[40vh] overflow-y-auto">
                @foreach($products as $product)
                    <article class="grid grid-cols-promo-code-products gap-4 py-2">
                        <div>
                            <div>#{{$product->id}}, <br/>{{$product->name}}</div>
                        </div>
                        <div>
                            @if($product->promo)
                                <span class="line-through block">{{$product->price}}Da</span>
                                <span class="text-pink ml-2">{{$product->promo}}Da</span>
                            @else       
                                <span>{{$product->price}}Da</span>
                            @endif
                        </div>
                        <button>
                            <i class="fa-solid fa-trash text-xl text-secondary"></i>
                        </button>
                    </article>
                @endforeach
            </main>
        </section>
    </section>
</x-ui-elements.admin-layout>