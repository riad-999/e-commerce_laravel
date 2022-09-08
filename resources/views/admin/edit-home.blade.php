<x-ui-elements.admin-layout>
    {{-- @php
        dd(session('file-count'));
    @endphp --}}
    <form action="{{route('update-home')}}" method="POST" class="my-12 mx-auto max-w-[500px]" 
    autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <h5 class="font-body font-semibold mb-8">Modifier l'accuille</h5>
        <x-form.input name="top-note" class="w-full" 
        label="remarque de promo" :value="old('top-note') ? old('top-note') : $ui->top_note"/>
        <div>
            <label class="block font-semibold text-sm text-secondary">
                catégories
            </label>
            <div id="desk-category" class="pl-2 checks-container">
                <input type="hidden" name="categories" id="desk-categories" 
                value="{{old('categories') ? old('categories') : json_encode($ui->categories)}}" />
                @foreach($categories as $category)
                    @php
                        $checked = '';
                        if((old('categories') && in_array("$category->id", json_decode(old('categories')))) || 
                        in_array("$category->id",$ui->categories))
                            $checked = 'checked';
                    @endphp
                    <div class="flex items-center check" data-id="desk-categories" data-value="{{$category->id}}">
                        <input type="checkbox" id="{{$category->name}}" {{$checked}}
                        value="{{$category->id}}" class="cursor-pointer accent-black" />
                        <label for="{{$category->name}}" class="cursor-pointer select-none ml-2 py-2">
                            {{$category->name}}
                        </label>
                    </div>
                @endforeach
            </div>
            <x-form.input type="file" label="images (1200x600 ou 1920x1080)" name="images[]" 
                class="other-images w-full" multiple />
            <x-form.error name="images" />
            <div class="container flex flex-col gap-4" data-full="true">
                @for ($j = 0;$j < session()->get("file-count"); $j++)
                    @error("images.$j")
                        <x-form.error name="images.{{$j}}" 
                        msg="assurez que toutes les fichier sont des images et ne dépassent pas 400KB."/>
                        @break
                    @enderror
                @endfor
                @if(count($ui->images))
                    @foreach ($ui->images as $image) 
                        <img src="{{config('globals.ui_images_end_point') . $image}}" 
                        alt="image" class="w-full bock" />
                    @endforeach
                @else
                    <div class="text-center">aucune images n'est présente</div>
                @endif
            </div>         
        </div>
        <x-interactive.btn type="submit" class="mt-4 w-full">Terminer</x-interactive.btn>
    </form>
</x-ui-elements.admin-layout>