<x-ui-elements.layout>
    <x-interactive.alert />
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i> 
                    vous voulez vraiment supprimer cette catégorie
                </div>
                <button class="btn capitalize close-modal" 
                type="button" data-id="delete">annuler</button>
                <button class="btn capitalize" type="sumbit">oui</button>
            </div>
        </form>
    </x-interactive.modal>
    <div class="desk:grid grid-cols-6 gap-8 bg-gray-100">
        <aside class="hidden desk:block h-100vh py-8 px-4 bg-white shadow-md">
            <ul class="list-none">
                <li class="text-xl font-semibold hover:bg-gray-300">
                    <a href="" class="inline-block py-2 px-4">
                        <i class="fa-solid fa-bag-shopping mr-2"></i> produits
                    </a>
                </li>
                <li class="text-xl font-semibold hover:bg-gray-300">
                    <a href="" class="inline-block py-2 px-4">
                        <i class="fa-solid fa-bag-shopping mr-2 hover:bg-gray-300"></i> produits
                    </a>
                </li>
            </ul>
        </aside>
        <main class="col-span-5 pt-8 px-4">
            <h4 class="font-body font-semibold mb-8">categories</h4>
            <section class="tablet:grid tablet:grid-cols-5 gap-12 p-4 bg-white tablet:mr-8 mb-12 shadow-md">
                <form class="col-span-2 py-4" action="{{route('store-category')}}" method="POST">
                    @csrf 
                    <h4 class="font-body font-semibold mb-8">ajouter</h4>
                    <x-form.input placeholder="nom de categorie ..." 
                    name="name" label="name" class="w-full" />
                    <x-form.textarea name="description" placeholder="description..." 
                    label="description" class="w-full" />
                    <button type="submit" class="btn capitalize w-full mb-8">
                        créer
                    </button>
                </form>
                <section class="col-span-3">                        
                    @if(!count($categories))
                        <div class="text-center">oops..., aucune categorie est disponible</div>
                    @else 
                        <h4 class="font-body font-semibold mb-8">liste</h3>
                        <main class="max-h-[400px] tablet:max-h-700p overflow-auto">
                            <header class="grid grid-cols-6 gap-4 py-4 pl-4 border-b border-solid border-gray-400 min-w-[600px]">
                                <div>Id</div>
                                <div>nom</div>
                                <div class="col-span-3">description</div>
                            </header>
                            @foreach($categories as $category)
                                <article class="grid grid-cols-6 gap-4 py-4 px-4 border-b border-solid border-gray-400 min-w-[600px]">
                                    <div>{{ $category->id }}</div>
                                    <div>{{ $category->name }}</div>
                                    <div class="col-span-3">{{ $category->description }}</div>
                                    <div>
                                        <button>
                                            <a href="{{route('edit-category',$category->id)}}" class="btn">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        </button>
                                        <button class="btn ml-2 open-modal" 
                                        data-route="{{route('delete-category',$category->id)}}" 
                                        data-id="delete">
                                                <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                </article>
                            @endforeach
                        </main>
                    @endif                          
                </section>
            </section>
        </main>
    </div>
</x-ui-elements.layout>