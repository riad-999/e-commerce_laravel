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
    <section class="max-w-[600px] mx-auto">
        <h5 class="font-body font-semibold mb-8">produits de l'ordre #{{$order->id}}</h5>
        <div class="mb-4">
            <a href={{route('orders')}} class="inline-block underline mr-2">
                <i class="fa-solid fa-left-long mr-2"></i> liste
            </a>
            <a href={{route('order', $order->id)}} class="inline-block underline">
                commande
            </a>
        </div>
        <form method="POST" action="{{route('update-order-products',$order->id)}}" 
        autocomplete="off" class="mx-auto desk:mx-0 bg-white w-[95%] max-w-[700px]">
            @csrf
            @method("PATCH")
            @foreach ($order->products as $product)
                <article class="flex justify-between items-start gap-4 py-4 {{!$loop->last ? 'border-b border-solid border-border' : ''}}">
                    @php
                        $name = "$product->product_id-$product->color_id";
                    @endphp
                    <div>
                        <div class="mb-2">produit: <span class="font-semibold">{{$product->pname}}</span></div>
                        <div class="mb-4">couleur: <span class="font-semibold">{{$product->cname}}</span></div>
                        <x-form.input type="number" name="{{$name}}" min="1" 
                        value="{{old($name) ? old($name) : $product->quantity}}" 
                        class="w-[100px]" label="quantité" min="1" max="{{$product->pcquantity}}"/>
                    </div>
                    @if(count($order->products) > 1)
                        @php
                            $url = route('delete-order-product',[
                                'id' => $order->id,
                                'product_id' => $product->product_id,
                                'color_id' => $product->color_id        
                            ]);
                        @endphp
                        <button class="block open-modal text-secondary" type="button" 
                        data-route="{{$url}}" data-id="delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    @endif
                </article>
            @endforeach
            <div class="grid gap-2 mt-4">
                <x-interactive.btn type="submit" class="w-full">Sauvgarder</x-interactive.btn>
                <x-interactive.btn type="reset" :white="true" class="w-full">Réinitialiser</x-interactive.btn>
            </div>
        </form>
    </section>
</x-ui-elements.admin-layout>