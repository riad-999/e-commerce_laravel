<x-ui-elements.admin-layout>
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-secondary"></i> 
                    vous voulez vraiment supprimer cette marque
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
    <section class="grid desk:grid-cols-2 gap-8 max-w-[900px] mx-auto mb-12">
        <form action="{{route('store-brand')}}" method="POST" class="max-w-[400px]">
            @csrf 
            <h5 class="font-body font-semibold mb-8">Ajouter</h5>
            <x-form.input placeholder="nom de categorie ..." name="name" label="nom" class="w-full" />
            <x-interactive.btn type="submit" class="w-full">
                Ajouter
            </x-interactive.btn>
        </form>
        <section>                        
            @if(!count($brands))
                <div class="text-center">aucune marque est disponible</div>
            @else 
                <h5 class="font-body font-semibold">Marques</h5>
                <main class="max-h-[400px] tablet:max-h-[700px] overflow-auto">
                    <header class="grid grid-cols-3 gap-4 py-4 p-4 border-b border-solid border-gray-400">
                        <div>Id</div>
                        <div>nom</div>
                    </header>
                    @foreach($brands as $brand)
                        <article class="grid grid-cols-3 gap-4 p-4 items-center border-b border-solid border-gray-400">
                            <div>{{ $brand->id }}</div>
                            <div>{{ $brand->name }}</div>
                            <div>
                                <a href="{{route('edit-brand',$brand->id)}}" class="p-2 text-xl text-secondary">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                <button class="ml-2 p-2 text-xl btn open-modal border-none text-secondary" 
                                data-route="{{route('delete-brand',$brand->id)}}" 
                                data-id="delete">
                                        <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </article>
                    @endforeach
                </main>
            @endif                          
        </section>
    </section>
</x-ui-elements.layout-admin>