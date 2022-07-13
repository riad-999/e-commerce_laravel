<x-ui-elements.layout>
    @if($first)
        <form action="/products/create" method="POST" autocomplete="on"
        class="mt-8 bg-gray-100 p-4 mx-auto max-w-screen-md">
            @csrf
            <x-form.input name="name" label="name" />
            <x-form.textarea name="description" />
            <div class="flex gap-8 mb-8">
                <x-form.select name="category" title="choose the category" label='category' :list="$categories" />
                <x-form.select name="brand" title="choose the brand" label='brand' :list="$brands" />
            </div>
            <div class="flex gap-8 mb-8">
                <x-form.input type='number' class="w-100p" name="price" label="prix" />
                <x-form.input type='number' class="w-100p" name="count" label="nombre des coleur"/>
            </div>
            <button class="btn capitalize bg-black text-white" name="first-submit" value='true' type="submit">suivant</button>
        </form>
    @else
        <form action="/products/store" method="POST" autocomplete="on" 
        class="mt-8 bg-gray-100 p-4 mx-auto max-w-screen-md" 
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="count" value="{{ $count }}" />
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
                    <x-form.input type="number" name="quantity{{$i}}" label="quantité" class="mb-4 w-24" />
                    <x-form.input type='file' name="main-image{{$i}}" class="mb-4 main-image"/>
                    <x-form.input type="file" name="other-images{{$i}}[]" class="mb-4 other-images" multiple />
                </div>
            @endfor
            <button class="btn capitalize bg-black text-white" name="second-submit" value='true' type="submit">terminer</button>
        </form>
    @endif
</x-ui-elements.layout>