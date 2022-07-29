<x-ui-elements.layout>
    <div class="grid grid-cols-6 gap-8 bg-gray-100">
        <x-ui-elements.admin-sidebar />
        <x-interactive.modal id="delete" data-form="true">
            <form action="" method="POST" autocomplete="off">
                @csrf
                @method('delete')
                <div class="text-center">
                    <div class="font-body font-semibold mb-8">
                        vous voullez vraiment supprimer la commande ?
                    </div>
                    <x-interactive.btn type="button" class="close-modal" data-id="delete" :white="true">
                        Annuler
                    </x-interactive.btn>
                    <x-interactive.btn type="submit" class="ml-2">
                        oui
                    </x-interactive.btn>
                </div>
            </form>
        </x-interactive.modal>
        <main class="col-span-5 pt-8 pl-4">
            <h4 class="font-body font-semibold mb-8">liste des ordres</h3>
            <section class="grid grid-cols-5 items-start gap-4 mr-8 mb-12">
                <section class="pt-8 pb-4 col-span-4 bg-white shadow-md p-4">
                    @if(!count($orders))
                        <div class="text-center">oops..., aucun ordre disponible pour ces filtres</div>
                    @else
                        <header class="grid grid-cols-admin1 gap-4 mb-8">
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
                                        <x-interactive.btn tabindex="0" class="btn">
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
                <form autocomplete="off" class='bg-white shadow-md p-4'> 
                        <x-form.input type="search" placeholder="#id" name="id" 
                        class="w-24" value="{{$id}}"/>
                        <x-form.input type="search" placeholder="nom de produit ..." 
                        name="name" value="{{$name}}" class="w-full" />
                        <x-form.select name="wilaya" title="choix de wilaya" 
                        :list="$wilayas" :selected="$wilaya" label="la wilaya"/>
                        <x-form.select name="state" label="l'état"
                        :list="$states" :selected="$state ? $state : $states[0]->value"/>
                        <x-form.input type="date" name="date" value="{{$date}}" />
                        <button type="reset" class="btn capitalize">
                            reset
                        </button>
                        <button type="submit" class="btn capitalize ml-2">
                            chercher <i class="fa-solid fa-magnifying-glass ml-2"></i>
                        </button>
                </form>
            </section>
        </main>
    </div>
</x-ui-elements.layout>
