<x-ui-elements.admin-layout>
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i> 
                    vous voulez vraiment supprimer cette coleur

                </div>
                <button class="btn capitalize close-modal" 
                type="button" data-id="delete">annuler</button>
                <button class="btn capitalize" type="sumbit">oui</button>
            </div>
        </form>
    </x-interactive.modal>
    <form action="{{route('store-product-color',$product->id)}}" method="POST" 
    class="mt-4 mx-auto desk:mx-0 p-4 bg-white w-[95%] max-w-[700px]" 
    enctype="multipart/form-data" autocomplete="off">
        @csrf
        <h5 class="font-body font-semibold mb-12">ajouter une coleur</h5>
        <div class="tablet:grid grid-cols-2 gap-4 items-start">
            @php
            $selected = null;
                if(old('color')) {
                   foreach($colors as $color) {
                        if($color->id == old('color')) {
                            $selected = $color;
                        }
                   }
                }
            @endphp
            <div>
                <x-form.dropdown :colors="$colors" :selected="$selected" name="color" />
                <x-form.error name="color" />
            </div>
            <x-form.input type="number" name="quantity" placeholder="quantité..." :margin="false" label="quantité" class="w-full"/>
            <div>
                <x-form.input type='file' name="main-image" :margin="false" label="image principale" class=" main-image w-full"/>
            </div>
            <div>
                <x-form.input type="file" name="other-images[]" class="other-images w-full" label="autres images" :margin="false" multiple />
            </div>
        </div>
        <div class="grid desk:block mt-8 grid-cols-2 gap-2">
            <x-interactive.btn type="submit">ajouter</x-interactive.btn>
        </div>
    </form>
    <form action="{{route('update-product-colors',$product->id)}}" method="POST" 
    class="mt-4 mx-auto desk:mx-0 p-4 bg-white w-[95%] max-w-[700px]" 
    enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PATCH')
        <h5 class="font-body font-semibold mb-12">produit #{{$product->id}}</h5>
        <div class="tablet:grid grid-cols-2 gap-8">
            @foreach($product->colors as $color)
                <article class="p-4 border-b border-solid border-gray-300">
                    <div class="flex justify-between">
                        <h5 class="font-body mb-4 font-semibold">{{$color->name}}</h5>
                        @if(count($product->colors) > 1)
                            @php
                                $url = route('delete-product-color',[
                                    'product_id' => $product->id,
                                    'color_id' => $color->id      
                                ]);
                            @endphp
                            <x-interactive.btn class="block open-modal" type="button" 
                            data-route="{{$url}}" data-id="delete">
                                <i class="fa-regular fa-trash-can"></i>
                            </x-interactive.btn>
                        @endif
                    </div>
                    <x-form.dropdown :colors="$colors" :name="$color->name" class="mb-4" :selected="$color" />
                    <x-form.input type="number" name="quantity-{{$color->name}}"  
                    label="quantité" class="w-full" value="{{$color->quantity}}"/>
                    <x-form.input type='file' label="image principale" name="main-image-{{$color->name}}" 
                    class="main-image w-full" />
                    <img src="{{$color->main_image}}" alt="prodcut image" class="main-Image mb-4 max-w-[300px]" />
                
                    <x-form.input type="file" label="autres images" name="other-images-{{$color->name}}[]" 
                    class="other-images w-full" multiple />
                    <div class="container flex gap-4 flex-wrap">
                        @foreach ($color->images as $image) 
                            <img src="{{$image->image}}" alt="image" width="100"/>
                        @endforeach
                    </div>                          
                </article>
            @endforeach
        </div>
        <div class="grid desk:block mt-8 grid-cols-2 gap-2">
            <x-interactive.btn type="submit">modifier</x-interactive.btn>
            <x-interactive.btn type="reset" :white="true">reset</x-interactive.btn>
        </div>
    </form>
</x-ui-elements.admin-layout>