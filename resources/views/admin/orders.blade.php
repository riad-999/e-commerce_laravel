<x-ui-elements.admin-layout>
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-secondary"></i> 
                    vous voulez vraiment supprimer cette commande
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
    <section class="grid desk:grid-cols-4 items-start gap-8 mb-12">
        <section class="pb-4 order-1 desk:order-none desk:col-span-3 bg-white overflow-x-auto">
            <h4 class="font-body font-semibold mb-8">liste des commandes</h4>
            <section class="min-w-[900px]">
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
                                    <x-interactive.btn tabindex="0" class="btn !border-none" :white="true">
                                        ...
                                    </x-interactive.btn>
                                    <ul tabindex="0" class="dropdown-content menu shadow bg-white rounded-box w-52">
                                        <li class="hover:bg-gray-200"><a class="p-2" href="{{route('order',$order->id)}}">détails</a></li>
                                        <li class="hover:bg-gray-200"><a class="p-2" href="{{route('edit-order',$order->id)}}">modifier</a></li>
                                        <li class="hover:bg-gray-200 p-2 cursor-pointer open-modal" data-id="delete" data-route="{{route('delete-order',$order->id)}}">
                                            supprimer  
                                        </li>
                                    </ul>
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
                @endif
            </section>
        </section>
        <form autocomplete="off" class='border border-solid border-border p-4 w-full max-w-[500px]'> 
            <x-form.input type="search" placeholder="#id" name="id" 
            class="w-full" value="{{$id}}" label="num" />
            <x-form.input type="search" placeholder="nom de produit ..." 
            name="name" value="{{$name}}" class="w-full" label="nom de client" />
            <x-form.select name="wilaya" title="choix de wilaya" class="w-full"
            :list="$wilayas" :selected="$wilaya" label="la wilaya"/>
            <x-form.select name="state" label="l'état" class="w-full"
            :list="$states" :selected="$state ? $state : $states[0]->value"/>
            <x-form.input type="date" name="date" class="w-full" label="la date" value="{{$date}}" />
            <x-interactive.btn type="submit" class="w-full mb-4">
                Chercher
            </x-interactive.btn>
            <x-interactive.btn :link="route('orders')" :white="true" class="w-full">
                Réinitialiser
            </x-interactive.btn>
        </form>
    </section>
</x-ui-elements.admin-layout>
