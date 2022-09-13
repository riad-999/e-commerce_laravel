<x-ui-elements.layout>
    <x-interactive.modal id="feedback" class="bg-gray-100" data-form="true">
        <form action="" method="POST" class="text-left p-4">
            @csrf
            <button type="button" class="absolute top-0 right-2 text-xl text-secondary p-2 close-modal" data-id="feedback">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <input id="review" type="hidden" name="score" value="4" /> 
            <div class="text-xl font-semibold text-secondary text-center mb-2">Votre Evaluation Sur le Produit</div>
            <div class="flex justify-center items-center gap-2 mb-4 text-secondary text-xl">
                @for ($i = 1; $i <= 5; $i++)
                    <div class="cursor-pointer" data-rate="{{$i}}" id="star{{$i}}" data-star="true">
                        <i class="fa-solid fa-star {{$i <= 4 ? '' : '!hidden'}}" data-type="solid"></i>
                        <i class="fa-regular fa-star {{$i > 4 ? '' : '!hidden'}}" data-type="empty"></i>
                    </div>
                @endfor
                <div class="text-sm" id="review-value">(4)</div>
            </div>
            <x-form.textarea label="commentaire" name="feedback" class="w-full" placeholder="votre feedback sur le produit..." />
            <x-interactive.btn class="w-full mt-4">Terminer</x-interactive.btn>
        </form>
    </x-interactive.modal>
    <main class="mt-12 grid tablet:grid-cols-8 gap-4 mx-auto max-w-[1400px]">
        <section class="tablet:col-span-3 desk:col-span-2 
        order-last tablet:order-first tablet:border-r border-t 
        tablet:border-t-0 border-solid border-border pl-4 pt-4 tablet:pt-0">
            <x-elements.profile-side-bar current="pending-reviews" :id="$user->id"/>
        </section>
        <section class="tablet:col-span-5 desk:col-span-6 p-4">
           <h5 class="font-body font-semibold mb-8 normal-case">en attend d'avis</h5>
           @if(!count($products))
                <div>vous n'avez aucun produit en attend.</div>
           @else
                <section class="w-full max-w-[600px] grid tablet:grid-cols-2 gap-4">
                    @foreach($products as $product)
                        <article class="py-2 mb-8 border-b border-solid border-border">
                            <a class="mb-4 block" href="{{route('show-product',$product->id)}}">
                                <img src="{{config('globals.images_end_point') . $product->image}}"
                                alt="image de produit" class="w-full min-h-[200px]" loading="lazy" />
                            </a>
                            <div class="font-semibold text-secondary mb-2">
                                {{$product->name}}
                            </div>
                            <div class="mr-4 text-secondary text-xl relative">
                                <x-interactive.btn type="button" class="open-modal" data-id="feedback" 
                                data-route="{{route('store-review',$product->id)}}">
                                    feedback
                                </x-interactive.btn>
                            </div>
                        </article>  
                    @endforeach
                </section> 
           @endif
        </section>
    </main>
</x-ui-elements.layout>