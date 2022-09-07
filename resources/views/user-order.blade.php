<x-ui-elements.layout>
    <main class="mt-12 grid tablet:grid-cols-8 gap-4 mx-auto max-w-[1400px]">
        <section class="tablet:col-span-3 desk:col-span-2 
        order-last tablet:order-first tablet:border-r border-t 
        tablet:border-t-0 border-solid border-border pl-4 pt-4 tablet:pt-0">
            <x-elements.profile-side-bar current="profile" :id="$user->id"/>
        </section>
        <section class="tablet:col-span-5 desk:col-span-6 p-4">
            <section class="py-4 mb-8 border-b border-solid border-gray-400">
                <div>
                    <span class="block text-xl font-semibold">
                        date: {{date("d-m-Y", strtotime($order->created_at)); }}
                    </span>
                </div>
            </section>
            <section class="flex flex-col desk:flex-row gap-8 desk:gap-32 mb-8 pb-4 border-b border-solid border-gray-400">
                <div>
                    <div class="text-2xl w-[50px] h-[50px] rounded-full bg-gray-400 flex items-center justify-center mb-2">
                        <i class="fa-solid fa-user block"></i>
                    </div>
                    <h5 class="font-body font-semibold mb-4">info</h5>
                    <div>
                        {{$order->name}} <br/>
                        {{$order->email}} <br/>
                        {{$order->number}} <br/>
                    </div>
                </div>
                <div>
                    <div class="text-2xl w-[50px] h-[50px] rounded-full bg-gray-400 flex items-center justify-center mb-2">
                        <i class="fa-solid fa-truck"></i>
                    </div>
                    <h5 class="font-body font-semibold mb-4">colis</h5>
                    <div>
                        @php
                            $class = '';
                            if($order->state === 'en traitment')
                                $class = 'bg-orange-400 text-orange-800';
                            if($order->state === 'en route')
                                $class = 'bg-cyan-400 text-cyan-800';
                            if($order->state === 'livré')
                                $class = 'bg-green-400 text-green-800';
                        @endphp
                        code de suivi: 
                        <span class="font-semibold block">
                            {{$order->track_code ? $order->track_code : 'indisponible!'}}
                        </span>
                        <span class="badge block w-[128px] ml-0 text-center mt-2 {{$class}}">
                            {{$order->state}}
                        </span>
                    </div>
                </div>
                <div>
                    <div class="text-2xl w-[50px] h-[50px] rounded-full bg-gray-400 flex items-center justify-center mb-2">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h5 class="font-body font-semibold mb-4">address</h5>
                    <div>
                        <div class="max-w-[30ch]">{{$order->address}}</div>
                        <span class="font-semibold block">{{$order->wilaya}}, {{$order->shipment_type}}</span>
                    </div>
                </div>
            </section>
            @if($order->note)
                <section class="mb-8 pb-4 border-b border-solid border-border">
                    <h5 class="font-body font-semibold mb-2">note</h5>
                    <p class="max-w-[55ch]">{{$order->note}}</p>
                </section>
            @endif
            <section class="overflow-auto mb-8">
                <div class="min-w-[300px] max-w-[900px] border border-b-0 border-solid border-gray-400">
                    <header class="grid grid-cols-2 desk:grid-cols-6 gap-4 p-2 border-b-2 border-solid border-gray-400">
                        <div class="desk:col-span-3">Produit</div>
                        <div class="desk:hidden">info</div>
                        <div class="hidden desk:block">Prix</div>
                        <div class="hidden desk:block">Quantité</div>
                        <div class="hidden desk:block">Totale</div>
                    </header>
                    <section>
                        @php
                            $sub_total = 0;
                        @endphp
                        @foreach($order->products as $product)
                            <article class="grid grid-cols-2 gap-4 desk:grid-cols-6 items-center p-2 border-b border-solid border-gray-400 hover:bg-gray-200">
                                <div class="flex gap-2 desk:col-span-3 items-center">
                                    <img class="block w-[50px] desk:w-[100px] mr-2" src="{{$product->main_image}}" alt="product image" />
                                    <div>{{$product->pname}}, {{$product->cname}}</div>
                                </div>
                                <div class="desk:hidden">
                                    <span>{{$product->price}}Da x {{$product->quantity}}</span>
                                    <br/>
                                    <span>total:</span> totalDa
                                </div>
                                <div class="hidden desk:block">{{$product->price}}Da</div>
                                <div class="hidden desk:block">{{$product->quantity}}</div>
                                <div class="hidden desk:block">{{$product->price * $product->quantity}}Da</div>
                            </article>
                            @php
                                $sub_total += $product->price * $product->quantity;
                            @endphp
                        @endforeach
                    </section>
                </div>
            </section>
            <section class="flex flex-col tablet:flex-row items-start gap-8">
                <div class="p-4 border border-solid border-border rounded-md">
                    <div class="mb-2">
                        <span class="w-[100px] inline-block">sous total:</span>
                        <span>{{$sub_total}}Da</span>
                    </div>
                    <div class="mb-2">
                        <span class="w-[100px] inline-block">livriason:</span>
                        <span>{{$order->shipment}}Da</span>
                    </div>
                    <div class="mb-2">
                        <span class="w-[100px] inline-block text-xl font-semibold">totale:</span>
                        <span class="text-xl font-semibold">{{$sub_total + $order->shipment}}Da</span>
                    </div>
                </div>
            </section>
        </section>
    </main>
</x-ui-elements.layout>