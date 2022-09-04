<x-ui-elements.layout>
    <form class="mx-auto px-4 max-w-[1400px] mt-16" autocomplete="off">
        <section class="desk:grid grid-cols-5 items-start gap-12">
             <aside id="side-filters" class="fixed w-[300px] top-0 left-0 bottom-0 max-h-[100vh] overflow-auto
            translate-x-[-100%] bg-white shadow-md transition py-4 px-4 z-[10]
            desk:max-h-[unset] desk:overflow-visible desk:relative desk:w-full desk:translate-x-0 
            desk:shadow-none desk:z-0 desk:p-0">
                <div class="flex justify-between">
                    <div></div>
                    <button class="desk:hidden p-2 text-xl text-secondary" 
                    type="button" id="close-side-filters">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <x-interactive.btn class="hidden desk:inline-block w-full mb-12 shadow-md" type="submit">
                Chercher <i class="fa-solid fa-magnifying-glass ml-2 block"></i>
                </x-interactive.btn>
                <div class="flex justify-between items-center gap-2 mb-8 border-b border-solid border-border">
                    <input type="search" value="{{$search}}"
                    class="py-2 pl-2 w-full
                    focus:outline-none" name="search"
                    placeholder="chercher..."/>
                </div>
                <div class="flex items-center gap-4 mb-4">
                    <input type="checkbox" id="promo" name="promo" value="true"
                    class="translate-x-1 cursor-pointer accent-black" {{$promo ? 'checked' : ''}} />
                    <label for="promo" class="cursor-pointer select-none">Promo</label>
                </div>
                <div class="mb-4">
                    <x-form.input type="number" name="price" class="w-full"
                    value="{{$price ? $price : 0}}" min="0" label="prix max (Da)" />
                </div>
                <div class="border-b border-border border-solid py-2">
                    <button type="button" class="flex justify-between w-full py-2 toggle-drop-down" id="toggle-categories" data-id="desk-category">
                        <span class="inline-block">Types</span>
                        <i class="fa-solid fa-angle-down show"></i>
                        <i class="fa-solid fa-angle-up close !hidden"></i>
                    </button>
                    <div class="h-0 overflow-hidden transition-height duration-300">
                        <div id="desk-category" class="pl-2">
                            <input type="hidden" name="categories" id="desk-categories" value="{{$categories ? $categories : '[]'}}" />
                            @foreach($Categories as $category)
                                @php
                                    $checked = '';
                                    if($categories && in_array("$category->id", json_decode($categories)))
                                        $checked = 'checked';
                                @endphp
                                <div class="flex items-center check" data-id="desk-categories" data-value="{{$category->id}}">
                                    <input type="checkbox" id="{{$category->name}}" {{$checked}}
                                    value="{{$category->id}}" class="translate-x-1 cursor-pointer accent-black" />
                                    <label for="{{$category->name}}" class="cursor-pointer select-none ml-2 py-2">
                                        {{$category->name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="border-b border-border border-solid py-2">
                    <button type="button" class="flex justify-between w-full py-2 toggle-drop-down" id="toggle-brands" data-id="desk-brand">
                        <span class="inline-block">Markes</span>
                        <i class="fa-solid fa-angle-down show"></i>
                        <i class="fa-solid fa-angle-up close !hidden"></i>
                    </button>
                    <div class="h-0 overflow-hidden transition-height duration-300">
                        <div id="desk-brand" class="pl-2">
                            <input type="hidden" name="brands" id="desk-brands" value="{{$brands ? $brands : '[]'}}" />
                            @foreach($Brands as $brand)
                                @php
                                    $checked = '';
                                    if($brands && in_array("$brand->id", json_decode($brands)))
                                        $checked = 'checked';
                                @endphp
                                <div class="flex items-center check" data-id="desk-brands" data-value="{{$brand->id}}">
                                    <input type="checkbox" id="{{$brand->name}}" {{$checked}}
                                    value="{{$brand->id}}" class="translate-x-1 cursor-pointer accent-black" />
                                    <label for="{{$brand->name}}" class="cursor-pointer select-none ml-2 py-2">
                                        {{$brand->name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-12">
                    <x-interactive.btn class="w-full mb-2 shadow-md desk:hidden" type="submit">
                        Chercher <i class="fa-solid fa-magnifying-glass ml-2 block"></i>
                    </x-interactive.btn>
                    <x-interactive.btn class="w-full" type="reset" :link="route('products')" :white="true">
                        Réinitialiser
                    </x-interactive.btn>
                </div>
            </aside>
            <main class="col-span-4">
                @php
                    $sorts = [
                        (object)['value' => 'solds','label' => 'plus commandé'],
                        (object)['value' => 'price-desc','label' => 'prix déscendant'],
                        (object)['value' => 'price-asc','label' => 'prix ascendant'],
                        (object)['value' => 'recent','label' => 'plus récent'],
                        (object)['value' => 'ancient','label' => 'plus ancien'],
                    ];                    
                @endphp
                <header class="flex gap-8 justify-between">
                    <h4 class="mb-8 font-body font-semibold">
                        tous les sacs 
                        <span class="text-lg text-text font-normal">({{$total}} produit)</span>
                    </h4>
                    <div class="hidden desk:block">
                        <span class="inline-block mr-2">trie par: </span>
                        <div class="dropdown inline-block"> 
                            @php
                                foreach($sorts as $item) {
                                    if($item->value != $sort)
                                        continue;
                                    $label = $item->label;
                                    break;
                                }
                            @endphp
                            <label tabindex="0" class="w-[200px] block">
                                <x-interactive.btn :white="true" type="button" class="w-full" name="order-by" value="best-sells">
                                    {{$label}} <i class="fa-solid fa-angle-down ml-4"></i>
                                </x-interactive.btn>
                            </label>
                            <ul tabindex="0" class="dropdown-content menu bg-white shadow z-50 w-full">
                                @foreach($sorts as $item)
                                    <li>
                                        <button type="submit" name="order" value="{{$item->value}}" 
                                        class="p-2 {{$sort == $item->value ? 'bg-gray-100 text-secondary' : ''}} hover:bg-gray-100">
                                            {{$item->label}}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </header>
                <div class="grid desk:hidden grid-cols-2 gap-4">
                    <button id="open-side-filters" type="button" class="bg-white text-secondary border border-secondary border-solid py-2">
                        filtres <i class="fa-solid fa-sliders inline-block ml-4"></i>
                    </button>
                    <div class="desk:hidden">
                        <div class="dropdown block"> 
                            <label tabindex="0" class="block">
                                <x-interactive.btn :white="true" type="button" class="w-full block" name="order-by" value="best-sells">
                                    trie <i class="fa-solid fa-angle-down ml-4"></i>
                                </x-interactive.btn>
                            </label>
                            <ul tabindex="0" class="dropdown-content menu bg-white shadow z-50 w-full">
                                @foreach($sorts as $item)
                                    <li>
                                        <button type="submit" name="order" value="{{$item->value}}" 
                                        class="p-2 {{$sort == $item->value ? 'bg-gray-100 text-secondary' : ''}} hover:bg-gray-100">
                                            {{$item->label}}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @if(!count($products))
                    <div class="text-center mt-8">
                        <i class="fa-regular fa-face-frown-open text-6xl mb-4"></i>
                        <br/>oops, aucun produit disponible pour ces filtres
                    </div>
                @else
                    <section class="products-container grid grid-cols-2 tablet:grid-cols-3 gap-2 desk:gap-4 mb-12 mt-12 pb-8 border-b border-border border-solid">
                        @foreach ($products as $product)
                            <x-elements.product :product="$product" />
                        @endforeach
                    </section>
                    <div class="btn-group flex mb-12">
                        <x-interactive.btn :link="$prevUrl" class="ml-auto border-black border !border-solid">
                            <i class="fa-solid fa-angles-left"></i>
                        </x-interactive.btn>
                        <x-interactive.btn :white="true">
                            Page {{$currentPage}} Sur {{$lastPage}}
                        </x-iteractive.btn>
                        <x-interactive.btn :link="$nextUrl" class="mr-auto border-black border !border-solid">
                            <i class="fa-solid fa-angles-right"></i>
                        </x-interactive.btn>
                    </div>
                @endif
            </main>
        </section>
    </form>
    @if(count($products))
        <x-ui-elements.footer />
    @endif
</x-ui-elements.layout>