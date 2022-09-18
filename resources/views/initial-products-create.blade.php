<x-ui-elements.admin-layout>
    <form action="{{route('initial-store-product')}}" method="POST" class="max-w-[500px] mx-auto" autocomplete="off">
        @csrf
        <x-form.input name="name" label="name" class="w-full" value="{{ old('name',session()->get('name')) }}" />
        <x-form.textarea name="description" class="w-full" label="description" content="{{ old('description',session()->get('description')) }}"/>
        <div class="grid grid-cols-2 gap-2">
            <x-form.select name="category" :selected="old('category')" title="choisir la category" class="w-full" label='category' :list="$categories" />
            <x-form.select name="brand" :selected="old('brand')" title="choisir la marque" class="w-full" label='brand' :list="$brands" />
        </div>
        <div class="grid grid-cols-2 gap-2 mb-4">
            <x-form.input type='number' class="w-100p" name="price"
            label="prix" class="w-full" value="{{ old('price', session()->get('price')) }}"/>
            <x-form.input type='number' class="w-100p" name="count"
            label="nombre des coleurs" class="w-full" value="{{ old('count',session()->get('count')) }}" />
        </div>
        <x-interactive.btn class="w-full" type="submit">Suivant</x-interactive.btn>
    </form>
</x-ui-elements.admin-layout>