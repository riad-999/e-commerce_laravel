<x-ui-elements.admin-layout>
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-secondary"></i> 
                    vous voulez vraiment supprimer ce code promo ?
                </div>
                <x-interactive.btn type="button" class="close-modal w-full max-w-[100px]" data-id="delete" :white="true">
                    Annuler
                </x-interactive.btn>
                <x-interactive.btn type="submit" class="ml-2 w-full max-w-[100px]">
                    Oui
                </x-interactive.btn>
            </div>
        </form>
    </x-interactive.modal>
    <section class="flex flex-col desk:flex-row gap-12 desk:gap-4 justify-between mt-12 p-4 mx-auto max-w-[600px] desk:max-w-[1200px]">
        <form action="{{route('store-promo-code')}}" method="POST" class="w-full desk:w-[40%]" autocomplete="off">
            @csrf   
            <h5 class="font-body font-semibold mb-4 desk:mb-">créer</h5>
            <x-form.input name="code" value="{{old('code')}}" placeholder="le code promo..." class="w-full" label="code"/>
            <x-form.input type="date" name="expires" value="{{old('expires')}}" class="w-full" label="date d'éxpiration" />
            <div class="mb-4">
                <input type="radio" class="accent-secondary" name="type" value="custome" 
                checked id="custome" data-radio="true" data-id="fixe-cut">
                <label for="custome" class="inline-block ml-2 font-semibold cursor-pointer">Personnalisé</label>
            </div>
            <div class="mb-2">
                <input type="radio" class="accent-secondary" name="type" value="fixe" 
                {{old('type') == 'fixe' ? 'checked' : ''}} id="fixe" data-radio="true" data-active="true" 
                data-id="fixe-cut">
                <label for="fixe" class="inline-block ml-2 font-semibold cursor-pointer">Fixe</label>
                <div><x-form.error name="type" /></div>
            </div>
            @php
                $cut_list = [];
                for($i = 5; $i <= 95; $i += 5) {
                    array_push($cut_list,(object) ['name' => "$i%", 'value' => $i]);
                }
            @endphp
            <x-form.select type="number" class="w-full disabled:pointer-events-none disabled:opacity-40" name="fixe-cut" :disabled="old('type') != 'fixe'"
            value="{{old('fixe-cut')}}" label="réduction fixe" :list="$cut_list" :selected="old('fixe-cut')"/>
            <x-interactive.btn type="submit" class="w-full mt-4">Créer</x-interactive.btn>
        </form>
        <div class="w-full desk:w-[55%]">
            <h5 class="font-body font-semibold mb-4 desk:mb-8">codes promos</h5>
            @if(!count($codes))
                <p>aucun code promo est disponible, créez un.</p>
            @else
                <header class="grid grid-cols-3 gap-4 py-2 border-b border-solid border-border mb-2">
                    <div>Code</div>
                    <div>éxpiration</div>
                    <div></div>
                </header>
                @foreach($codes as $code)
                    <article class="py-2 grid grid-cols-3 gap-4">
                        <div>
                            <span class="block">{{$code->code}}</span>
                            <small class="text-sm">{{$code->for_all ? "fixe ($code->for_all_cut%)" : 'personnalisé'}}</small>
                        </div>
                        <div>{{date('d-m-Y',strtotime($code->expires))}}</div>
                        <div class="text-secondary">
                            <a class="inline-block" href="{{route('edit-promo-code',$code->id)}}">
                                <i class="fa-solid fa-pen p-2"></i>
                            </a>
                            <button class="inline-block open-modal" data-id="delete" data-route="{{route('delete-promo-code',$code->id)}}">
                                <i class="fa-solid fa-trash p-2"></i>
                            </button>
                        </div>
                    </article>  
                @endforeach
            @endif
        </div>
    </section>
</x-ui-elements.admin-layout>