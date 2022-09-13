<x-ui-elements.layout>
    <main class="mt-12 grid tablet:grid-cols-8 gap-4 mx-auto max-w-[1400px]">
        <section class="tablet:col-span-3 desk:col-span-2 
        order-last tablet:order-first tablet:border-r border-t 
        tablet:border-t-0 border-solid border-border pl-4 pt-4 tablet:pt-0">
            <x-elements.profile-side-bar current="saves" :id="$user->id"/>
        </section>
        <section class="tablet:col-span-5 desk:col-span-6 p-4">
           <h5 class="font-body font-semibold mb-8 normal-case">produits enregistrés</h5>
           @if(!count($products))
                <div>vous n'avez aucun produit enregistré.</div>
           @else
                <section class="w-full max-w-[600px] grid tablet:grid-cols-2 gap-4">
                    @foreach($products as $product)
                        <article class="py-2 mb-8 border-b border-solid border-border">
                            <a class="mb-4 block" href="{{route('show-product',$product->id)}}">
                                <img src="{{config('globals.images_end_point') . $product->image}}"
                                alt="image de produit" class="w-full min-h-[200px]" loading="lazy" />
                            </a>
                            <div class="flex gap-4 justify-between">
                                <div class="font-semibold text-secondary">
                                    {{$product->name}}
                                </div>
                                <div class="mr-4 text-secondary text-xl relative">
                                    <button data-save="true" id="{{'save-' . $product->id}}" data-state="saved" data-product="{{$product->id}}">
                                        <div  class="absolute right-0 top-[-48px] transition scale-0 bg-secondary text-white py-2 px-4
                                        duration-300 overflow-hidden text-sm z-[5] save-notice"></div>
                                        <i class="fa-solid fa-bookmark" data-icone="saved-icone"></i>
                                        <i class="fa-regular fa-bookmark !hidden" data-icone="unsaved-icone"></i>
                                    </button>
                                </div>
                            </div>
                            @if($product->promo)
                                <div class="font-semibold text-pink">{{$product->promo}}Da</div>
                            @else
                                <div class="font-semibold">{{$product->price}}Da</div>
                            @endif
                        </article>  
                    @endforeach
                </section>
           @endif
        </section>
    </main>
</x-ui-elements.layout>