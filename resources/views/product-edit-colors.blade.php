<x-ui-elements.layout>
    <form action="" method="POST" 
    class="mt-8 bg-gray-100 p-4 mx-auto max-w-screen-md" 
    enctype="multipart/form-data" autocomplete="on">
    @csrf
        @foreach($product->colors as $color)
            <div class="pt-4 mt-4 {{ $loop->index !== 0 ? 'border-t border-solid border-gray-300' : '' }}">
                <div class="text-2xl mb-6 font-semibold">{{$color->name}}</div>
                <x-form.dropdown :colors="$colors" :name="$color->name" :selected="$color" 
                :disabled="true" :edit="true" />
                {{-- <x-form.error name="color{{$i}}" /> --}}

                <x-form.input type="number" name="quantity-{{$color->name}}"  
                label="quantité" class="mb-4 w-24" :edit="true" :disabled="true"/>

                <x-form.input type='file' label="image principale" name="main-image-{{$color->name}}" 
                class="mb-4 main-image" :edit="true" :disabled="true" />
                <img src="{{$color->main_image}}" alt="prodcut image" width="200" class="main-Image" />
                <x-form.input type="file" label="autres images" name="other-images-{{$color->name}}[]" 
                class="mb-4 other-images" :edit="true" :disabled="true" multiple />
                <div class="container flex gap-4 my-8 flex-wrap">
                    @foreach ($color->images as $image) 
                        <img src="{{$image->image}}" alt="image" width="100"/>
                    @endforeach
                </div>
                {{-- <x-form.error name="other-images{{$i}}" />
                @for ($j = 0;$j < session()->get("file-count$i"); $j++)
                    @error("other-images$i.$j")
                        <x-form.error name="other-images{{$i}}.{{$j}}" 
                        msg="assurez que tous les fichier sont des images."/>
                        @break
                    @enderror
                @endforeach --}}
            </div>
        @endforeach
        <button class="btn capitalize bg-black text-white" name="second-submit" value='true' type="submit">modifier</button>
        <button class="btn capitalize bg-black text-white" name="second-submit" value='true' type="submit">cancel</button>
    </form>
</x-ui-elements.layout>