<x-ui-elements.layout>
    <main class="mx-auto max-w-screen-xl mt-24 px-8">
        <h4 class="mb-8 font-body font-semibold">tous les sacs <span class="text-lg text-text font-normal">(49 sacs)</span></h4>
        <div class="grid grid-cols-2 gap-4">
            <button class="bg-white text-secondary border border-secondary border-solid lg:hidden py-2">
                filtres <i class="fa-solid fa-angles-right inline-block ml-2"></i>
            </button>
            <button class="bg-white text-secondary border border-secondary border-solid lg:hidden py-2">
                trie <i class="fa-solid fa-angle-down inline-block ml-2"></i>
            </button>
        </div>
        <form class="hidden lg:flex items-baseline mb-12 border-b border-solid border-gray-200 pb-4">
            <button class="bg-white text-secondary border border-secondary border-solid py-2 px-6">
                trie <i class="fa-solid fa-angle-down inline-block ml-2"></i>
            </button>
            <div class="flex gap-8 mx-auto">
                <button type="button" class="py-2 px-4">Mark<span class="inline-block ml-4"><i class="fa-solid fa-angle-down"></i></span></button>
                <button type="button" class="py-2 px-4">Type <span class="inline-block ml-4"><i class="fa-solid fa-angle-down"></i></span></button>
                <button type="button" class="py-2 px-4">Coleur <span class="inline-block ml-4"><i class="fa-solid fa-angle-down"></i></span></button>
                <div class="flex items-center gap-4">
                    <input type="checkbox" id="promo" class="translate-x-1 cursor-pointer" />
                    <label for="promo" class="cursor-pointer select-none">Promo</label>
                </div>
            </div>
            <button type="submit" class="bg-secondary text-white py-2 px-6 rounded"><i class="fa-solid fa-sliders inline-block mr-2"></i>Filtrage</button>
        </form>
























        
        <section class="grid md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-6 mb-32 mt-12">
            <x-elements.product/>
            <x-elements.product/>
            <article>
                <a href="#" class="block">
                    <img class="w-full object-cover border-b border-solid border-gray-400 mb-4" src="/storage/ui-images/slide1.webp" alt="product image" />
                    <div class="font-semibold capitalize text-secondary">Liverpol Los Angeles</div>
                    <div class="capitalize">boyfriend blazer</div>
                    <div class="font-extralight inline-block line-through">2000 DA</div>
                    <div class="font-extralight text-trinary inline-block">1200 DA</div>
                    <div class="grid grid-cols-color xl:grid-cols-color-xl grid-rows-color xl:grid-rows-color-xl gap-2 xl:gap-4 mt-4">
                        <div class="border-b border-solid border-secondary"><div class="bg-black w-90 h-90 mx-auto"></div></div>
                        <div><div class="bg-cyan-600 w-90 h-90  mx-auto"></div></div>
                        <div><div class="bg-pink-400 w-90 h-90  mx-auto"></div></div>
                    </div>
                </a>
            </article>
            <article>
                    <a href="#" class="block">
                        <img class="w-full object-cover border-b border-solid border-gray-400 mb-4" src="/storage/ui-images/slide1.webp" alt="product image" />
                        <div class="flex justify-between lg:block">
                            <div class="font-semibold capitalize text-secondary">Liverpol Los Angeles</div>
                            <div>
                                <div class="font-extralight lg:inline-block">2000 DA</div>
                            </div>
                        </div>
                        <div class="capitalize">boyfriend blazer</div>
                        <div class="grid grid-cols-color xl:grid-cols-color-xl grid-rows-color xl:grid-rows-color-xl gap-2 xl:gap-4 mt-4">
                            <div class="border-b border-solid border-secondary"><div class="bg-black w-90 h-90 mx-auto"></div></div>
                            <div><div class="bg-cyan-600 w-90 h-90  mx-auto"></div></div>
                            <div><div class="bg-pink-400 w-90 h-90  mx-auto"></div></div>
                        </div>
                    </a>
            </article>
            <x-elements.product/>
            <x-elements.product/>
            <article>
                <a href="#" class="block">
                    <img class="w-full object-cover border-b border-solid border-gray-400 mb-4" src="/storage/ui-images/slide1.webp" alt="product image" />
                    <div class="font-semibold capitalize text-secondary">Liverpol Los Angeles</div>
                    <div class="capitalize">boyfriend blazer</div>
                    <div class="font-extralight inline-block line-through">2000 DA</div>
                    <div class="font-extralight text-trinary inline-block">1200 DA</div>
                    <div class="grid grid-cols-color xl:grid-cols-color-xl grid-rows-color xl:grid-rows-color-xl gap-2 xl:gap-4 mt-4">
                        <div class="border-b border-solid border-secondary"><div class="bg-black w-90 h-90 mx-auto"></div></div>
                        <div><div class="bg-cyan-600 w-90 h-90  mx-auto"></div></div>
                        <div><div class="bg-pink-400 w-90 h-90  mx-auto"></div></div>
                    </div>
                </a>
            </article>
            <x-elements.product/>
        </section>
    </main> 
</x-ui-elements.layout>