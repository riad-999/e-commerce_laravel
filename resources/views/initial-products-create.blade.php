<x-ui-elements.layout>
    <form action="/products/initial-store" method="POST"
    class="mt-8 bg-gray-100 p-4 mx-auto max-w-screen-md">
        @csrf
        <x-form.input name="name" label="name" value="{{ old('name',session()->get('name')) }}" />
        <x-form.textarea name="description" content="{{ old('description',session()->get('description')) }}"/>
        <div class="flex gap-8 mb-8">
            <x-form.select name="category" title="choose the category" label='category' :list="$categories" />
            <x-form.select name="brand" title="choose the brand" label='brand' :list="$brands" />
        </div>
        <div class="flex gap-8 mb-8">
            <x-form.input type='number' class="w-100p" name="price"
             label="prix" value="{{ old('price', session()->get('price')) }}"/>
            <x-form.input type='number' class="w-100p" name="count"
             label="nombre des coleur" value="{{ old('count',session()->get('count')) }}" />
        </div>
        <button class="btn capitalize bg-black text-white" name="first-submit" value='true' type="submit">suivant</button>
    </form>
</x-ui-elements.layout>