<x-ui-elements.admin-layout>
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-secondary"></i> 
                    vous voulez vraiment supprimer cette catégorie
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
    <main class="max-w-[900px] mx-auto mb-12">
        <section class="grid desk:tablet:grid-cols-2 gap-12 bg-white tablet:mr-8 mb-12">
            <form action="{{route('store-category')}}" method="POST" class="max-w-[400px]">
                @csrf 
                <h5 class="font-body font-semibold mb-8">ajouter</h5>
                <x-form.input placeholder="nom de categorie ..." 
                name="name" label="name" class="w-full" />
                <x-interactive.btn type="submit" class="w-full">
                    Ajouter
                </x-interactive.btn>
            </form>
            <section>                        
                @if(!count($categories))
                    <div class="text-center">oops..., aucune categorie est disponible</div>
                @else 
                    <h5 class="font-body font-semibold mb-8">categories</h5>
                    <main class="max-h-[400px] tablet:max-h-[700px] overflow-auto">
                        <header class="grid grid-cols-3 gap-4 py-4 pl-4 border-b border-solid border-gray-400">
                            <div>Id</div>
                            <div>nom</div>
                        </header>
                        @foreach($categories as $category)
                            <article class="grid grid-cols-3 gap-4 items-center p-4 border-b border-solid border-gray-400">
                                <div>{{ $category->id }}</div>
                                <div>{{ $category->name }}</div>
                                <div>
                                    <a href="{{route('edit-category',$category->id)}}" class="p-2 text-xl text-secondary">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button class="ml-2 p-2 text-xl btn open-modal border-none text-secondary" 
                                    data-route="{{route('delete-category',$category->id)}}" 
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
    </main>
</x-ui-elements.admin-layout>