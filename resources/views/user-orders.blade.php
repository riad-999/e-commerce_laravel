<x-ui-elements.layout>
    <main class="mt-12 grid tablet:grid-cols-8 gap-4 mx-auto max-w-[1400px]">
        <section class="tablet:col-span-3 desk:col-span-2 
        order-last tablet:order-first tablet:border-r border-t 
        tablet:border-t-0 border-solid border-border pl-4 pt-4 tablet:pt-0">
            <x-elements.profile-side-bar current="profile" :id="$user->id"/>
        </section>
        <section class="tablet:col-span-5 desk:col-span-6 p-4">
           <h5 class="font-body font-semibold mb-2 normal-case">Historique des Commandes</h5>
           @if(!count($orders))
                <div>vous n'avez rien commandé.</div>
           @else
                <section class="w-full max-w-[500px]">
                    @foreach($orders as $order)
                        <article class="py-2 mb-8 border-b border-solid border-border">
                            <div class="flex justify-between gap-4 pb-4 text-sm">
                                <div class="font-semibold text-secondary">{{$order->state}}</div>
                                <div>
                                    @php
                                        $sub_total = 0;
                                        $time= strtotime($order->created_at); 
                                        $date = date('d-m-Y', $time);
                                    @endphp
                                    {{$date}}
                                </div>
                            </div>
                            <section>
                                @foreach ($order->products as $product)
                                    <article>
                                        <a href="{{route('show-user-orders',$order->id)}}" class="flex gap-2 justify-between p-2">
                                            <div class="w-[20%]">
                                                <img src="{{IMAGES_END_POINT . $product->main_image}}" alt="l'image du prouit">
                                            </div>
                                            <div class="w-[75%]">
                                                <div>{{$product->pname}}</div>
                                                <div>{{$product->cname}} x {{$product->quantity}}</div>
                                                <div class="text-sm">{{$product->price}}Da</div>
                                            </div>
                                        </a>
                                        @php
                                            $sub_total += $product->price * $product->quantity;
                                        @endphp
                                    </article>
                                @endforeach
                                <div class="text-right py-2">
                                    <div class="mb-1">Livraison: {{$order->shipment}}Da</div>
                                    <div>Totale: {{$sub_total + $order->shipment}}Da</div>
                                </div>
                            </section>
                        </article>  
                    @endforeach
                </section>
           @endif
        </section>
    </main>
</x-ui-elements.layout>