<x-ui-elements.admin-layout>
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-secondary"></i> 
                    vous voulez vraiment supprimer cette coleur
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
    <section class="grid desk:grid-cols-3 gap-8 mb-12 max-w-[1000px] mx-auto">
        <form id="costume" data-tabcontent='true' class="max-w-[400px]"
        action="{{route('store-color')}}" method="POST" autocomplete="off">
            @csrf 
            <h5 class="font-body font-semibold mb-4">ajouter</h5>
            <x-form.input placeholder="nom de categorie ..." 
            name="name" label="name" class="w-full" value="{{ old('name') }}"/>
            <x-form.input type="color" value="{{ old('color1') ? old('color1') : '#010101'}}"
            name="color1" label="couleur 1 (*)" />
            <x-form.input type="color" 
            :disabled="old('color2') ? false : true" :edit="true"
            name="color2" label="couleur 2" value="{{ old('color2') ? old('color2') : '#010101' }}" />
            <x-form.input type="color" value="{{ old('color3') ? old('color3') : '#010101' }}" 
            :disabled="old('color3') ? false : true"
            name="color3" label="couleur 3" :edit="true" /> 
            <x-interactive.btn type="submit" class="w-full mt-4">
                Ajouter
            </x-interactive.btn>
        </form>
        <section class="col-span-2 overflow-x-auto">                        
            @if(!count($colors))
                <div class="text-center">oops..., aucune couleur est disponible</div>
            @else 
                <h5 class="font-body font-semibold mb-4">coleurs</h5>
                <form class="flex mb-8" action="{{ route('colors') }}" autocomplete="off">
                    <input type="search" name="name" placeholder="chercher par nom..." 
                        class="px-2 border-b border-solid border-gray-400 w-full focus:outline-none" 
                        value="{{ $name }}" />
                    <x-interactive.btn type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </x-interactive.btn>
                </form>
                <main>
                    <header class="grid grid-cols-3 gap-4 py-4 pl-4 border-b border-solid border-gray-400 min-w-[550px]">
                        <div>nom</div>
                        <div>coleur</div>
                    </header>
                    <section class="min-w-[550px] max-h-[400px] tablet:max-h-700p overflow-y-auto">
                        @foreach($colors as $color)
                            <article class="grid grid-cols-3 gap-4 py-4 px-4 border-b border-solid border-gray-400">
                                <div>{{ $color->name }}</div>
                                <div>
                                    <x-elements.color-square :color="$color" />
                                </div>
                                <div>
                                    <button>
                                        <a href="{{route('edit-color',$color->id)}}" class="p-2 text-xl text-secondary">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </button>
                                    <button class="ml-2 p-2 text-xl btn open-modal border-none text-secondary" 
                                        data-route="{{route('delete-color',$color->id)}}" 
                                        data-id="delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                </div>
                            </article>
                        @endforeach
                    </section>
    
                </main>
            @endif                          
        </section>
    </section>
</x-ui-elements.admin-layout>