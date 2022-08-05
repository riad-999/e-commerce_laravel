<x-ui-elements.admin-layout>
    <form action="{{route('update-product',$product->id)}}" method="POST" 
    class="mt-8 mx-auto w-[95%] p-4 bg-white desk:w-[600px] desk:mx-0" 
    autocomplete="off">
        @csrf
        @method('PATCH')
        <h4 class="font-body font-semibold mb-12">produit #({{$product->id}})</h4>
        <div class="mb-4">
            <x-interactive.btn :link="route('edit-product-colors',$product->id)" :white="true" class="mr-2">
                Coleurs
            </x-interactive.btn>
            <x-interactive.btn type="button" :link="route('edit-product-promo',$product->id)" :white="true">
                promo
            </x-interactive.btn>
        </div>
        <x-form.input name="name" label="nom" class="w-full tablet:w-[400px]" 
        value="{{ $product->name }}" />
        <x-form.textarea name="description" class="w-full tablet:w-[400px]" 
        :content="$product->description" label="description"/>
        <x-form.input type='number' name="price" class="w-full tablet:w-[400px]"
        label="prix" value="{{$product->price}}" />
        <div class="flex gap-8">
            <x-form.select name="category_id" title="choose the category" 
            label='catégorie' :selected="$product->category_id" :list="$categories" />
            <x-form.select name="brand_id" title="choose the brand" 
            label='mark' :selected="$product->brand_id" :list="$brands" />
        </div>
        <div>
            <x-interactive.btn type="reset" :white="true" class="mr-2">
                reset
            </x-interactive.btn>
            <x-interactive.btn type="submit">
                moudifier
            </x-interactive.btn>
        </div>
    </form>
</x-ui-elements.admin-layout>