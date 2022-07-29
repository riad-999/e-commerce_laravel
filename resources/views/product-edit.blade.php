<x-ui-elements.layout>
    <form action="/products/store" method="POST" 
    class="mt-8 bg-gray-100 p-4 mx-auto max-w-screen-md" 
    enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PATCH')
        <div class="flex gap-8 mb-8 items-end">
            <button class="" value='true' type="button">
                <a href="/products/edit/{{$product->id}}/colors" class="bg-black text-white btn capitalize">coleurs</a>
            </button>
            <button class="" value='true' type="button">
                <a href="/products/{{$product->id}}/promo" class="bg-black text-white btn capitalize">promo</a>
            </button>
        </div>
        <x-form.input name="name" class="mb-8" label="name" 
        :disabled="true" :edit="true" value="{{ $product->name }}" />
        <x-form.textarea name="description" class="mb-8" 
        :disabled="true" :edit="true" :content="$product->description"/>

        <div class="flex gap-8 mb-8">
            <x-form.select name="category" title="choose the category" 
            label='category' :selected="$product->category_id" :list="$categories" 
            :disabled="true" :edit="true"/>
            <x-form.select name="brand" title="choose the brand" 
            label='brand' :selected="$product->brand_id" :list="$brands"
            :disabled="true" :edit="true" />
        </div>
        <x-form.input type='number' class="w-100p mb-8" name="price" 
        label="prix" :disabled="true" :edit="true" value="{{$product->price}}" />

        <button class="btn capitalize bg-black text-white" name="second-submit" value='true' type="submit">modifier</button>
        <button class="btn capitalize bg-black text-white" name="second-submit" value='true' type="submit">cancel</button>
    </form>
</x-ui-elements.layout>