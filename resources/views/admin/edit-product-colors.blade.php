<x-ui-elements.admin-layout>
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-secondary"></i> 
                    vous voulez vraiment supprimer cette coleur
                </div>
                <x-interactive.btn class="w-[150px] mr-2 close-modal" :white="true" type="button" data-id="delete">
                    Annuler
                </x-interactive.btn>
                <x-interactive.btn class="w-[150px]" type="sumbit">
                    Oui
                </x-interactive.btn>
            </div>
        </form>
    </x-interactive.modal>
    <section class="max-w-[800px] mx-auto mb-12">
        <form action="{{route('store-product-color',$product->id)}}" method="POST" 
        class="bg-white max-w-[500px] mb-12" 
        enctype="multipart/form-data" autocomplete="off">
        @csrf
        <h5 class="font-body font-semibold mb-8">ajouter une coleur</h5>
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
            <div class="mb-4">
                <x-form.dropdown :colors="$colors" :selected="$selected" name="color" />
                <x-form.error name="color" />
            </div>
            <x-form.input type="number" name="quantity" placeholder="quantité..." label="quantité" class="w-full"/>
            <x-form.input type='file' name="main-image" label="image principale" class=" main-image w-full"/>
            <x-form.input type="file" name="other-images[]" class="other-images w-full" label="autres images" :margin="false" multiple />
            <x-interactive.btn type="submit" class="mt-8 w-full">Ajouter</x-interactive.btn>
        </form>
        <form action="{{route('update-product-colors',$product->id)}}" method="POST" 
        class="bg-white" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('PATCH')
            <h5 class="font-body font-semibold mb-8">produit #{{$product->id}}</h5>
            <div class="grid tablet:grid-cols-2 gap-8 mb-8">
                @foreach($product->colors as $color)
                    <article class="border p-2 border-solid border-gray-300">
                        <div class="flex justify-between gap-4 mb-8">
                            <h5 class="font-body mb-4 font-semibold">{{$color->name}}</h5>
                            @if(count($product->colors) > 1)
                                @php
                                    $url = route('delete-product-color',[
                                        'product_id' => $product->id,
                                        'color_id' => $color->id      
                                    ]);
                                @endphp
                                <button class="block btn border-none text-xl text-secondary open-modal" type="button" 
                                data-route="{{$url}}" data-id="delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif
                        </div>
                        <x-form.dropdown :colors="$colors" :name="$color->name" class="mb-4" :selected="$color" />
                        <x-form.input type="number" name="quantity-{{$color->name}}"  
                        label="quantité" class="w-full" value="{{$color->quantity}}"/>
                        <x-form.input type='file' label="image principale" name="main-image-{{$color->name}}" 
                        class="main-image w-full" />
                        <img src="{{config('globals.images_end_point') . $color->main_image}}" 
                        alt="prodcut image" class="main-Image mb-4 max-w-[300px]" />
                    
                        <x-form.input type="file" label="autres images" name="other-images-{{$color->name}}[]" 
                        class="other-images w-full" multiple />
                        <x-form.error name="other-images-{{$color->name}}" 
                        msg="assurez que toutes les fichier sont des images et ne dépassent pas 200KB."/>
                        {{-- @break --}}
                        {{-- @for($j = 0; $j < session("file-count-$color->name"); $j++)
                            @error("other-images-$color->name.$j")
                                <x-form.error name="other-images-{{$color->name}}.{{$j}}" 
                                msg="assurez que toutes les fichier sont des images et ne dépassent pas 200KB."/>
                                @break
                            @enderror
                        @endfor --}}
                        <div class="container flex gap-4 flex-wrap">
                            @foreach ($color->images as $image) 
                                <img src="{{$image->image}}" alt="image" width="100"/>
                            @endforeach
                        </div>                       
                    </article>
                @endforeach
            </div>
            <div class="w-full max-w-[300px] mx-auto">
                <x-interactive.btn type="submit" class="w-full mb-2">Modifier</x-interactive.btn>
                <x-interactive.btn type="reset" class="w-full" :link="route('edit-product-colors',$product->id)" :white="true">réinitialiser</x-interactive.btn>
            </div>
        </form>
    </section>
</x-ui-elements.admin-layout>