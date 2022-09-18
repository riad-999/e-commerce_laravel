<x-ui-elements.admin-layout> 
    <form id="costume" data-tabcontent='true' class="max-w-[400px] mx-auto"
    action="{{route('update-color',$id)}}" method="POST" autocomplete="off">
        @csrf 
        @method('PATCH')
        <h5 class="font-body font-semibold mb-8">modifier</h5>
        <x-form.input placeholder="nom de categorie ..." name="name" label="name" 
        class="w-full" value="{{ old('name') ? old('name') : $color->name }}"/>
        <x-form.input type="color" 
        value="{{ old('color1') ? old('color1') : ($color->value1 ? $color->value1 :'#010101') }}"
        name="color1" label="couleur 1 (*)" />
        <x-form.input type="color" name="color2" label="couleur 2" 
        :disabled="$color->value2 ? false : true" :edit="$color->value2 ? false : true" :remove="true"
        value="{{ old('color2') ? old('color2') : ($color->value2 ? $color->value2 :'#010101') }}" />
        <x-form.input type="color" :disabled="$color->value2 ? false : true" 
        :edit="$color->value2 ? false : true" :remove="true" name="color3" label="couleur 3"
        value="{{ old('color3') ? old('color3') : ($color->value3 ? $color->value3 :'#010101') }}" />
        <x-interactive.btn type="submit" class="mt-8 w-full mb-2">
            Modifier
        </x-interactive.btn>
        <x-interactive.btn type="reset" class="w-full" :white="true">
            Réinitialiser
        </x-interactive.btn>
    </form>                                                   
</x-ui-elements.admin-layout>