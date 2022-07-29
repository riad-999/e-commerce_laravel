<x-ui-elements.layout>
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i> 
                    vous voulez vraiment supprimer cette couleur
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
            <h4 class="font-body font-semibold mb-8">couleurs</h4>
            <section class="tablet:grid tablet:grid-cols-5 gap-12 p-4 bg-white tablet:mr-8 mb-12 shadow-md">
                <div class="col-span-2">
                    <h4 class="font-body font-semibold mb-8">ajouter</h4>
                    {{-- <div class="tabs mb-4">
                        <button type='button' data-id="simple" class="tab tab-lifted tab-active !text-base">simple</button> 
                        <button type="button" data-id="costume" class="tab tab-lifted !text-base">costume</button> 
                    </div> --}}
                    {{-- <form id="simple" data-tabcontent='true' 
                    action="{{route('store-color')}}" method="POST" autocomplete="off">
                        @csrf 
                        <x-form.input placeholder="nom de categorie ..." 
                        name="name" label="name" class="w-full" />

                        <div class="mb-4">
                            <label class="font-semibold block mr-4">Coleur 1 (*)</label>
                            <x-form.single-color-dropdown name="color1" />
                        </div>
                        <x-form.error name="color1" />
                        <div class="mb-4">
                            <label class="font-semibold mr-4 block">Coleur 2</label>
                            <x-form.single-color-dropdown name="color2" />
                        </div>
                        <x-form.error name="color2" />
                        <div class="mb-4">
                            <label class="font-semibold mr-4 block">Coleur 3</label>
                            <x-form.single-color-dropdown name="color3" />
                        </div>
                        
                        <button type="submit" class="btn capitalize w-full mb-8">
                            créer
                        </button>
                    </form> --}}

                    <form id="costume" data-tabcontent='true' 
                    action="{{route('store-color')}}" method="POST" autocomplete="off">
                        @csrf 
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

                        <button type="submit" class="btn capitalize w-full mb-8">
                            créer
                        </button>
                    </form>
                 </div>
                <section class="col-span-3">                        
                    @if(!count($colors))
                        <div class="text-center">oops..., aucune couleur est disponible</div>
                    @else 
                        <h4 class="font-body font-semibold mb-8">liste</h3>
                        <form class="flex mb-8" action="{{ route('colors') }}" autocomplete="off">
                            <input type="search" name="name" placeholder="chercher par nom..." 
                             class="pb-2 px-2 border-b border-solid border-gray-400 focus:outline-none" 
                             value="{{ $name }}" />
                            <x-interactive.btn type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </x-interactive.btn>
                        </form>
                        <main class="max-h-[400px] tablet:max-h-700p overflow-auto">
                            <header class="grid grid-cols-3 gap-4 py-4 pl-4 border-b border-solid border-gray-400 min-w-[600px]">
                                <div>nom</div>
                                <div>coleur</div>
                            </header>
                            @foreach($colors as $color)
                                <article class="grid grid-cols-3 gap-4 py-4 px-4 border-b border-solid border-gray-400 min-w-[600px]">
                                    <div>{{ $color->name }}</div>
                                    <div>
                                        <x-elements.color-square :color="$color" />
                                    </div>
                                    <div>
                                        <button>
                                            <a href="{{route('edit-color',$color->id)}}" class="btn border-none">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        </button>
                                        <button class="btn ml-2 open-modal border-none" 
                                        data-route="{{route('delete-color',$color->id)}}" 
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