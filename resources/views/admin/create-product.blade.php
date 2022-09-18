<x-ui-elements.admin-layout>
    <form action="/products/store" method="POST" 
    class="max-w-[900px] mx-auto" enctype="multipart/form-data" autocomplete="off">
    @csrf
        <div class="grid desk:grid-cols-2 gap-4">
            @for ($i = 1; $i <= $count; $i++)
                <div class="p-4 border border-solid border-border">
                    <h5 class="font-semibold mb-4 font-body">
                        {{$i === 1 ? '1er Coleur' : $i . "eme Coleur"}}
                    </h5>
                    {{-- <div class="dropdown">
                        <input type="hidden" class="color" id="color{{$i}}" name="color{{$i}}" />
                        <label tabindex="0" class="btn color-label mb-4 capitalize">
                            séléctioner la coleur  <i class="fa-solid fa-angle-down ml-2"></i>
                        </label>
                        <div tabindex="0" class="dropdown-content menu shadow bg-white rounded-box w-52 max-h-72 overflow-y-scroll !invisible">
                            @foreach($colors as $color)
                                <button type="button" data-id="{{ $color->id }}" class="color-item flex justify-between px-4 py-2 hover:bg-gray-300">
                                    <span>{{ $color->name }}</span>
                                    <x-elements.color class="ml-2 inline-block" :colors="$color->colors" />
                                </button>
                            @endforeach
                        </div>
                    </div> --}}
                    <x-form.dropdown :colors="$colors" class="mb-4" :name="'color' . $i" :selected="old('color' . $i)"/>
                    <x-form.error name="color{{$i}}" />
                    <x-form.input type="number" name="quantity{{$i}}" label="quantité" class="w-full" />
                    <x-form.input type='file' name="main-image{{$i}}" class="w-full main-image"/>
                    <x-form.input type="file" name="other-images{{$i}}[]" class="w-full other-images" :margin="false" multiple />
                    <x-form.error name="other-images{{$i}}" 
                    msg="assurez que toutes les fichier sont des images et ne dépassent pas 200KB."/>
                    <div class="container flex gap-4 flex-wrap"></div>  
                    {{-- @for ($j = 0;$j < session()->get("file-count$i"); $j++)
                        @error("other-images$i.$j")
                            <x-form.error name="other-images{{$i}}.{{$j}}" 
                            msg="assurez que toutes les fichier sont des images et ne dépassent pas 200KB."/>
                            @break
                        @enderror
                    @endfor --}}
                </div>
            @endfor
        </div>
        <div class="mx-auto max-w-[300px] mt-8">
            <x-interactive.btn type='submit' name="second-submit" class="w-full" value='true'>
                Terminer
            </x-interactive.btn>
            <x-interactive.btn :white="true" :link="route('initial-create-product')" class="mt-2 w-full" name="second-submit">
                Retour
            </x-interactive.btn>
        </div>
    </form>
</x-ui-elements.admin-layout>