<x-ui-elements.admin-layout>
    <section class="max-w-[1000px] mx-auto mb-32">
        <section class="mb-16">
            <h5 class="font-body font-semibold mb-4">statistiques</h5>
            <section class="grid tablet:grid-cols-3 gap-4">
                <article class="p-4 border border-solid border-border flex 
                gap-4 items-center text-secondary font-semibold text-2xl rounded-md justify-center">
                    <div>
                        <i class="fa-solid fa-bag-shopping text-pink"></i>
                    </div>
                    <div>
                        {{$products}} Produits
                    </div>
                </article>
                <article class="p-4 border border-solid border-border flex 
                gap-4 items-center text-secondary font-semibold text-2xl rounded-md justify-center">
                    <div>
                        <i class="fa-solid fa-cart-flatbed text-pink"></i>
                    </div>
                    <div>
                        {{$orders_count}} Commandes
                    </div>
                </article>
                <article class="p-4 border border-solid border-border flex 
                gap-4 items-center text-secondary font-semibold text-2xl rounded-md justify-center">
                    <div>
                        <i class="fa-solid fa-sack-dollar text-pink"></i>
                    </div>
                    <div>
                        {{$sales}}Da Totale
                    </div>
                </article>
            </section>
        </section>
        <section class="mb-16">
            <section class="flex gap-8 justify-between items-center">
                <h5 class="font-body font-semibold mb-4">Commandes</h5>
                <form class="dropdown inline-block mb-4"> 
                    @php
                        $year = intval(now()->format('Y'));
                        $label = $year;
                        $years = [$year, $year - 1, $year - 2];
                        foreach($years as $year) {
                            if(request('year') == $year)
                                $label = $year;
                        }
                    @endphp
                    <label tabindex="0" class="w-[150px] block">
                        <x-interactive.btn :white="true" type="button" class="w-full" name="order-by" value="best-sells">
                            {{$label}} <i class="fa-solid fa-angle-down ml-4"></i>
                        </x-interactive.btn>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu bg-white shadow z-50 w-full">
                        @foreach($years as $year)
                            <li class="w-full">
                                <button type="submit" name="year" value="{{$year}}" 
                                class="p-2 {{request('year') == $year || $label == $year ? 'bg-gray-100 text-secondary' : ''}}
                                hover:bg-gray-100 w-full text-center">
                                    {{$year}}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </form>
            </section>
            <canvas id="myChart" class="w-full"></canvas>
        </section>
        <section>
            <h5 class="font-body font-semibold mb-4">en traitment ({{count($orders)}})</h5>
            <section class="px-4 border border-solid border-border">
                <header class="grid grid-cols-admin1 gap-4 mb-2 py-2">
                <div>id</div>
                <div>le client</div>
                <div>le coût</div>
                <div>l'état & wilaya</div>
                <div>la date</div>
                <div></div>
            </header>
            @foreach($orders as $order)
                <article class="grid grid-cols-admin1 gap-4 justify-between items-center py-4 border-b border-solid border-gray-400">
                    <div>
                        {{$order->id}}
                    </div>
                    <div>
                        {{$order->name}} <br/>
                        {{$order->number}} <br/>
                        {{-- <span class="text-sm">{{$order->email}}</span> --}}
                    </div>
                    <div>
                        total: {{'total'}}Da <br/>
                        livarison: {{$order->shipment}}Da
                    </div>
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
                        <span class="block mb-2">{{$order->wilaya}}</span>
                        <span class="badge block w-[128px] ml-0 text-center {{$class}}">{{$order->state}}</span>
                    </div>
                    <div>
                        @php
                            $order_date = new DateTime($order->created_at);
                            $order_date = $order_date->format('d-m-Y');
                        @endphp
                        {{$order_date}}
                    </div>
                    <div>
                        <div class="dropdown dropdown-top">
                            <x-interactive.btn tabindex="0" class="!border-none" :white="true">
                                ...
                            </x-interactive.btn>
                            <ul tabindex="0" class="dropdown-content menu shadow bg-white rounded-box w-52">
                                <li class="hover:bg-gray-200"><a class="p-2" href="{{route('order',$order->id)}}">détails</a></li>
                                <li class="hover:bg-gray-200"><a class="p-2" href="{{route('edit-order',$order->id)}}">moudifier</a></li>
                                <li class="hover:bg-gray-200 p-2 cursor-pointer open-modal" data-id="delete" data-route="{{route('delete-order',$order->id)}}">
                                    supprimer  
                                </li>
                            </ul>
                        </div>
                    </div>
                </article>
                @if($loop->index == 9)
                    @break
                @endif
            @endforeach
            <article class="flex justify-center">
                <x-interactive.btn :link="route('orders')" class="w-[200px] my-4">Plus</x-interactive.btn>
            </article>
        </section>
    </section>
</x-ui-elements.admin-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script>
    let xValues = @json($graph->months);
    let yValues = @json($graph->orders);
    let min = {{min($graph->orders) - 10 < 0 ? 0 : min($graph->orders) - 10}};
    let max = {{max($graph->orders) + 10}};

    new Chart("myChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
            fill: false,
            lineTension: 0,
            backgroundColor: "rgba(0,0,255,1.0)",
            borderColor: "rgba(0,0,255,0.1)",
            data: yValues
            }]
        },
        options: {
            legend: {display: false},
            scales: {yAxes: [{ticks: {min, max}}]}
        }
    });
</script>