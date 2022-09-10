<x-ui-elements.admin-layout>
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-secondary"></i> 
                    vous voulez vraiment supprimer cette wilaya ?
                </div>
                <x-interactive.btn type="button" class="close-modal w-full max-w-[100px]" data-id="delete" :white="true">
                    Annuler
                </x-interactive.btn>
                <x-interactive.btn type="submit" class="ml-2 w-full max-w-[100px]">
                    Oui
                </x-interactive.btn>
            </div>
        </form>
    </x-interactive.modal>
    <section class="flex flex-col desk:flex-row mx-auto justify-center max-w-[600px] desk:max-w-[1200px] gap-12 desk:gap-8">
        <form action="{{route('store-wilaya')}}" method="POST" class="w-full tablet:max-w-[400px]" autocomplete="off">
            @csrf
            <h5 class="font-body font-semibold mb-8">Ajouter</h5>
            <x-form.input name="id" type="number" label="code*" value="{{old('id')}}" class="w-full" placeholder="code du wilaya"/>
            <x-form.input name="name" label="nom*" class="w-full" value="{{old('name')}}" placeholder="nom du wilaya"/>
            <x-form.input name="home_shipment" class="w-full" type="number" value="{{old('home_shipment')}}" label="livraison à domicile(Da)*" />
            <x-form.input name="desk_shipment" class="w-full" type="number" value="{{old('desk_shipment')}}" label="livraison au bureau (Da) (vide s'il n'y a pas)" />
            <x-form.input name="duration" class="w-full" label="duration*" value="{{old('duration')}}" placeholder="xxh-xxh"/>
            <x-interactive.btn type="submit" class="w-full">Ajouter</x-interactive.btn>
        </form>
        <section class="w-full min-w-[320px] overflow-x-auto desk:max-w-[800px] mb-16">
            <h5 class="font-body font-semibold mb-8">wilayas</h5>
            <header class="hidden desk:grid grid-cols-wilayas gap-4 border-b py-4 mb-2 border-solid border-border">
                <div>Code</div>
                <div>nom</div>
                <div>à domicile</div>
                <div>au bureau</div>
                <div>duration</div>
            </header>
            <header class="grid desk:hidden grid-cols-3 gap-4 border-b py-4 mb-2 border-solid border-border">
                <div>wilaya</div>
                <div>Livraison</div>
            </header>
            <section class="border-b mb-2 border-solid border-border w-full max-h-[400px] desk:max-h-[600px] overflow-y-auto">
                @foreach($wilayas as $wilaya)
                    <article class="hidden desk:grid grid-cols-wilayas gap-4 py-2">
                        <div>{{$wilaya->id}}</div>
                        <div>{{$wilaya->name}}</div>
                        <div>{{$wilaya->home_shipment}}Da</div>
                        <div>{{$wilaya->desk_shipment ? $wilaya->desk_shipment . 'Da' : '-'}}</div>
                        <div>{{$wilaya->duration}}</div>
                        <div class="text-secondary">
                            <a class="inline-block" href="{{route('edit-wilaya',$wilaya->id)}}">
                                <i class="fa-solid fa-pen p-2"></i>
                            </a>
                            <button class="inline-block open-modal" data-id="delete" 
                            data-route="{{route('delete-wilaya',$wilaya->id)}}">
                                <i class="fa-solid fa-trash p-2"></i>
                            </button>
                        </div>
                    </article>
                    <article class="grid desk:hidden grid-cols-3 gap-4 py-2">
                        <div>
                            {{$wilaya->id}} {{$wilaya->name}}
                        </div>
                        <div>
                            <div>
                                à domicile: {{$wilaya->home_shipment}}Da
                            </div>
                            <div>
                                au bureau: {{$wilaya->desk_shipment ? $wilaya->desk_shipment . 'Da' : '-'}}
                            </div>
                            <div>{{$wilaya->duration}}</div>
                        </div>
                        <div class="text-secondary">
                            <a class="inline-block" href="{{route('edit-wilaya',$wilaya->id)}}">
                                <i class="fa-solid fa-pen p-2"></i>
                            </a>
                            <button type="button" class="inline-block open-modal" data-id="delete" data-route="{{route('delete-wilaya',$wilaya->id)}}">
                                <i class="fa-solid fa-trash p-2"></i>
                            </button>
                        </div>
                    </article>
                @endforeach
            </section>
        </section>
    </section>
</x-ui-elements.admin-layout>