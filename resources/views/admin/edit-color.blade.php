<x-ui-elements.layout>
    <x-interactive.alert />
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
            <form id="costume" data-tabcontent='true' class="bg-white p-4 rounded-lg tablet:w-1/2"
            action="{{route('update-color',$id)}}" method="POST" autocomplete="off">
                @csrf 
                @method('PATCH')
                <h4 class="font-body font-semibold mb-8">modifier</h4>
                <x-form.input placeholder="nom de categorie ..." :disabled="old('name') ? false : true" :edit="true"
                name="name" label="name" class="w-full" value="{{ old('name') ? old('name') : $color->name }}"/>
                
                <x-form.input type="color" :disabled="old('color1') ? false : true" :edit="true"
                value="{{ old('color1') ? old('color1') : ($color->value1 ? $color->value1 :'#010101') }}"
                name="color1" label="couleur 1 (*)" />

                <x-form.input type="color" name="color2" label="couleur 2" 
                :disabled="old('color2') ? false : true" :edit="true" :remove="true"
                value="{{ old('color2') ? old('color2') : ($color->value2 ? $color->value2 :'#010101') }}" />

                <x-form.input type="color" :disabled="old('color3') ? false : true" :remove="true"
                value="{{ old('color3') ? old('color3') : ($color->value3 ? $color->value3 :'#010101') }}" 
                name="color3" label="couleur 3" :edit="true" />

                <button type="reset" class="btn capitalize mb-8">
                    reset
                </button>
                <button type="submit" class="btn capitalize ml-4 mb-8">
                    modifier
                </button>
            </form>                                                   
        </main>
    </div>
</x-ui-elements.layout>