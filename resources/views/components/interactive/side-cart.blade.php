@props(['cart'])

<aside class="fixed z-[9999] right-0 top-0 bottom-0 max-h-[100vh] 
overflow-auto border-l border-solid border-border bg-white 
transition duration-300 p-4 w-[80%] tablet:max-w-[400px] 
translate-x-full" id="side-cart">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h5 class="font-body font-semibold">
                votre panier
            </h5>
            <a href="{{route('cart')}}" class="underline">voir le panier</a>
        </div>
        <button type="button" id="close-side-cart" class="p-2 text-2xl text-black">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <section>
        @foreach($cart as $item)
            <article class="grid tablet:grid-cols-2 gap-4 {{!$loop->last ? 'border-b border-solid border-border' : ''}} py-4">
                <a href="{{route('show-product',$item->product_id)}}" class="block">
                    <img src="{{$item->image}}" class="block"/>
                </a>
                <div>
                    <div class="text-black font-semibold">{{$item->name}}</div>
                    <div>Qte: {{$item->quantity}}</div>
                    @if($item->promo)
                        <div class="text-pink">Unité: {{$item->promo}}Da</div>
                        <div>total: {{$item->quantity * $item->promo}}Da</div>
                    @else
                        <div>Unité: {{$item->price}}Da</div>
                        <div>total: {{$item->quantity * $item->price}}Da</div>
                    @endif
                </div>
            </article>
        @endforeach
    </section>
</aside>