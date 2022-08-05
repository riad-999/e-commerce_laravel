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
      
    <h4 class="font-body font-semibold mb-8">produits de l'ordre #{{$order->id}}</h4>
    <x-interactive.btn :link="route('orders')" :white="true" class="mb-12">
        <i class="fa-solid fa-left-long mr-2"></i> liste
    </x-interactive.btn>
    <x-interactive.btn :link="route('edit-order',$order->id)" :white="true" class="mb-12 ml-2">
        commande
    </x-interactive.btn>

    <form method="POST" action="{{route('update-order-products',$order->id)}}" 
    autocomplete="off" class="mx-auto desk:mx-0 p-4 bg-white w-[95%] max-w-[700px]">
        @csrf
        @method("PATCH")
        @foreach ($order->products as $product)
            <article class="flex justify-between gap-4 py-4 border-b border-solid border-border">
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
                    <x-interactive.btn class="block open-modal" type="button" 
                    data-route="{{$url}}" data-id="delete">
                        <i class="fa-regular fa-trash-can"></i>
                    </x-interactive.btn>
                @endif
            </article>
        @endforeach
        <div class="mt-8">
            <x-interactive.btn type="submit" class="w-max">sauvgarder</x-interactive.btn>
            <x-interactive.btn type="reset" class="w-max">reset</x-interactive.btn>
        </div>
    </form>
</x-ui-elements.admin-layout>