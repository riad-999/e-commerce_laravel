<x-ui-elements.admin-layout>
    <form action="{{route('update-wilaya', $wilaya->id)}}" method="POST" class="w-full mx-auto tablet:max-w-[400px]" autocomplete="off">
        @csrf
        @method('PATCH')
        <h5 class="font-body font-semibold mb-8">Ajouter</h5>
        <x-form.input name="id" type="number" label="code*" 
        value="{{old('id') ? old('id') : $wilaya->id}}" class="w-full" placeholder="code du wilaya"/>
        <x-form.input name="name" label="nom*" class="w-full" 
        value="{{old('name') ? old('name') : $wilaya->name}}" placeholder="nom du wilaya"/>
        <x-form.input name="home_shipment" class="w-full" type="number" 
        value="{{old('home_shipment') ? old('home_shipment') : $wilaya->home_shipment}}" 
        label="livraison à domicile(Da)*" />
        <x-form.input name="desk_shipment" class="w-full" type="number" 
        value="{{old('desk_shipment') ? old('desk_shipment') : $wilaya->desk_shipment}}" 
        label="livraison au bureau (Da) (vide s'il n'y a pas)" />
        <x-form.input name="duration" class="w-full" label="duration*" 
        value="{{old('duration') ? old('duration') : $wilaya->duration}}" placeholder="xxh-xxh"/>
        <x-interactive.btn type="submit" class="w-full">Modifier</x-interactive.btn>
    </form>
</x-ui-elements.admin-layout>