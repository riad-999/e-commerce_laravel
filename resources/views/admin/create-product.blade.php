<x-ui-elements.layout>
    <form action="/products/store" method="POST" 
    class="mt-8 bg-gray-100 p-4 mx-auto max-w-screen-md" 
    enctype="multipart/form-data" autocomplete="on">
    @csrf
    {{-- <input type="hidden" name="count" value="{{ $count }}" /> --}}
        @for ($i = 1; $i <= $count; $i++)
            <div class="pt-4 mt-4 {{ $i !== 1 ? 'border-t border-solid border-gray-300' : '' }}">
                <div class="text-2xl mb-6 font-semibold">{{$i === 1 ? '1er Coleur' : $i . "eme Coleur"}}</div>
                <div class="dropdown">
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
                </div>
                <x-form.error name="color{{$i}}" />
                <x-form.input type="number" name="quantity{{$i}}" label="quantité" class="mb-4 w-24" />
                <x-form.input type='file' name="main-image{{$i}}" class="mb-4 main-image"/>
                <x-form.input type="file" name="other-images{{$i}}[]" class="mb-4 other-images" multiple />
                <x-form.error name="other-images{{$i}}" />
                @for ($j = 0;$j < session()->get("file-count$i"); $j++)
                    @error("other-images$i.$j")
                        <x-form.error name="other-images{{$i}}.{{$j}}" 
                        msg="assurez que toutes les fichier sont des images et ne dépassent pas 200KB."/>
                        @break
                    @enderror
                @endfor
            </div>
        @endfor
        <button class="btn capitalize bg-black text-white" name="second-submit" value='true' type="submit">terminer</button>
        <button class="btn capitalize bg-black text-white" value='true' type="button">
            <a href="/products/initial-create">go back</a>
        </button>
    </form>
</x-ui-elements.layout>