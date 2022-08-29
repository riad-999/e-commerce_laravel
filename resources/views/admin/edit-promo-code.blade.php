<x-ui-elements.admin-layout>
    {{-- <section class="flex flex-col desk:flex-row gap-12 desk:gap-4 justify-between mt-12 p-4 mx-auto max-w-[600px] desk:max-w-[1200px]"> --}}
        <form action="{{route('update-promo-code',$code->id)}}" method="POST" autocomplete="off" class="w-full max-w-[500px] mx-auto">
            @csrf   
            @method('PATCH')
            <h5 class="font-body font-semibold mb-4 desk:mb-16 text-center">modifier le code</h5>
            <a href="{{route('promo-codes')}}" class="underline block mb-4">codes</a>
            @if(!$code->for_all)
                <div class="mb-4">
                    <a href="{{route('promo-code-assocations',$code->id)}}" class="inline-block mr-4 underline">produits</a>
                    <a href="{{route('create-promo-code-assocations', $code->id)}}" class="underline">associer</a>
                </div>
            @endif
            <x-form.input name="code" value="{{old('code') ? old('code') : $code->code}}" placeholder="le code promo..." class="w-full" label="code"/>
            <x-form.input type="date" name="expires" value="{{old('expires') ? old('expires') : $code->expires}}" class="w-full" label="date d'éxpiration" />
            <div class="mb-4">
                <input type="radio" class="accent-secondary" name="type" value="custome" 
                {{(old('type') == 'custome' || !$code->for_all) ? 'checked' : ''}} 
                id="custome" data-radio="true" data-id="fixe-cut">
                <label for="custome" class="inline-block ml-2 font-semibold cursor-pointer">Personnalisé</label>
            </div>
            <div class="mb-2">
                <input type="radio" class="accent-secondary" name="type" value="fixe" 
                {{(old('type') == 'fixe' || $code->for_all) ? 'checked' : ''}} 
                id="fixe" data-radio="true" data-active="true" 
                data-id="fixe-cut">
                <label for="fixe" class="inline-block ml-2 font-semibold cursor-pointer">Fixe</label>
                <div><x-form.error name="type" /></div>
                <div class="text-orange-600">remarque: si vous changer le type du code promo à fixe toutes les assocations seront supprimées</div>
            </div>
            @php
                $cut_list = [];
                for($i = 5; $i <= 95; $i += 5) {
                    array_push($cut_list,(object) ['name' => "$i%", 'value' => $i]);
                }
            @endphp
            <x-form.select type="number" class="w-full disabled:pointer-events-none disabled:opacity-40" 
            name="fixe-cut" :disabled="!$code->for_all && old('type') != 'fixe'" value="{{old('fixe-cut')}}" 
            label="réduction fixe" :list="$cut_list" :selected="old('fixe-cut') ? old('fixe-cut') : $code->for_all_cut"/>
            <x-interactive.btn type="submit" class="w-full mt-4">Modifier</x-interactive.btn>
        </form>
        {{-- <section class="w-full desk:w-[50%]" id="custom-section">
            <form action="{{route('store-promo-code-cut',$code->id)}}" method="POST" class="mb-8 w-[80%] pb-4 border-b border-solid border-border" autocomplete="off">
                @csrf
                <h5 class="font-body font-semibold mb-4 desk:mb-8">Créer une association</h5>
                <x-form.select type="number" class="w-full disabled:pointer-events-none disabled:opacity-40" 
                name="create-cut" title="séléctionez la réduction" value="{{old('create-cut')}}" 
                label="réduction" :list="$cut_list" :selected="old('create-cut')"/>
                <x-interactive.btn type="submit" class="w-full mt-4">Suivant</x-interactive.btn>
            </form>
            <h5 class="font-body font-semibold mb-4">associations</h5>
            @if(!count($code->cuts))
                <p>aucun code associations pour ce code promo est diponible, créez un.</p>
            @else
                <header class="grid grid-cols-3 gap-4 py-2 border-b border-solid border-border mb-2">
                    <div>réduction</div>
                    <div></div>
                    <div></div>
                </header>
                <main class="max-h-[400px] desk:max-h-[35vh] overflow-y-auto border-b border-solid border-border">
                    @foreach($code->cuts as $cut)
                        <article class="py-2 grid grid-cols-3 gap-4">
                            <div>
                                <span class="block">{{$cut->cut}}%</span>
                                <small class="text-sm">{{$cut->products}}produits</small>
                            </div>
                            <div>
                                <a class="inline-block underline" 
                                href="{{route('promo-code-cut-assocations',['id' => $code->id, 'cut' => $cut->cut])}}">
                                    associations
                                </a>
                            </div>
                            <div class="text-secondary">
                                <a class="inline-block" 
                                href="{{route('edit-promo-code-cut', ['id' => $code->id, 'cut' => $cut->cut])}}">
                                    <i class="fa-solid fa-pen p-2"></i>
                                </a>
                                <a class="inline-block" 
                                href="{{route('edit-promo-code',$code->id)}}">
                                    <i class="fa-solid fa-trash p-2"></i>
                                </a>
                            </div>
                        </article>  
                    @endforeach
                </main>
            @endif
        </section> --}}
    {{-- </section> --}}
</x-ui-elements.admin-layout>