<x-ui-elements.admin-layout>   
    <form class="max-w-[400px] mx-auto" method="POST" 
    autocomplete="off" action="{{ route('update-brand',$brand->id) }}">
        @csrf
        @method('PATCH')
        <h5 class="font-body font-semibold mb-8">modifier {{$brand->name}}</h5>
        <x-form.input name="name" value="{{ old('name') ? old('name') : $brand->name}}" label="nom" class="w-full"/>
        <x-interactive.btn type="submit" class="w-full mb-2">Modifier</x-interactive.btn>
        <x-interactive.btn type="reset" class="w-full" :white="true">Réinitialiser</x-interactive.btn>
    </form>                                                      
</x-ui-elements.admin-layout>