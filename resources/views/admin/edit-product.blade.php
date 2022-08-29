<x-ui-elements.admin-layout>
    <form action="{{route('update-product',$product->id)}}" method="POST" 
    class="mt-12 w-full p-4 max-w-[500px] mx-auto" autocomplete="off">
        @csrf
        @method('PATCH')
        <h4 class="font-body font-semibold mb-12">produit #({{$product->id}})</h4>
        <div class="mb-4">
            <a href="{{route('edit-product-colors',$product->id)}}" class="inline-block underline font-semibold">
                Couleurs
            </a>
            <a href="{{route('edit-promo',$product->id)}}" class="inline-block underline font-semibold ml-2">
                promo
            </a>
        </div>
        <x-form.input name="name" label="nom" class="w-full" 
        value="{{ $product->name }}" />
        <x-form.textarea name="description" class="w-full" 
        :content="$product->description" label="description"/>
        <div class="grid tablet:grid-cols-2 tablet:gap-4">
            <x-form.select name="category_id" title="choose the category" class="w-full"
            label='catégorie' :selected="$product->category_id" :list="$categories" />
            <x-form.select name="brand_id" title="choose the brand" class="w-full"
            label='mark' :selected="$product->brand_id" :list="$brands" />
        </div>
        <x-form.input type='number' name="price" class="w-full"
        label="prix" value="{{$product->price}}" />
        <div class="grid tablet:grid-cols-2 gap-4 mt-8">
            <x-interactive.btn type="reset" :white="true" class="w-full">
                Réinitialiser
            </x-interactive.btn>
            <x-interactive.btn type="submit" class="w-full">
                Moudifier
            </x-interactive.btn>
        </div>
    </form>
</x-ui-elements.admin-layout>