<x-ui-elements.layout>
    <section class="grid items-start desk:grid-cols-3 gap-8 mx-auto tablet:max-w-[600px] desk:max-w-[900px] p-4 mt-12">
        <section class="desk:order-1 p-2 border border-solid border-border w-full">
            <div class="pb-4 mb-4 border-b border-solid border-border">
                @foreach(session('cart') as $item)
                    <article class="flex justify-between gap-2">
                        <span class="text-black">{{$item->name}} ({{$item->color->name}})</span>
                        <span class="inline-block w-max">
                            X {{$item->quantity}}
                        </span>
                    </article>
                @endforeach
            </div>
             @php
                if(old('shipment_type') == 'au bureau')
                    $shipment = $wilaya->desk;
                else 
                    $shipment = $wilaya->home;
            @endphp
            <div class="flex justify-between gap-2">
                <div>Livraison</div> 
                <div class="font-semibold text-secondary text-right" id="top-cost">
                    {{$shipment}}Da
                </div>
            </div>
            <div id="sub-total" data-amount="{{$sub_total}}" class="flex justify-between gap-2">
                <div>Sous-Totale</div> <div class="font-semibold text-secondary text-right">{{$sub_total}}Da</div>
            </div>
            <div class="flex justify-between gap-2">
                <div>Totale</div>
                <div class="font-semibold text-secondary text-right" id="total">{{$sub_total + $shipment}}Da</div>
            </div>
        </section>
        <form action="{{route('store-order')}}" method="POST" class="desk:col-span-2" autocomplete="off">
            @csrf
            <h5 class="font-body font-semibold mb-8">Commander</h5>
            <x-form.input name="name" class="w-full" placeholder="votre nom complet" 
            value="{{old('name') ? old('name') : ($user ? $user->name : '')}}" label="nom complet*" />
            <x-form.input name="email" type="email" class="w-full" placeholder="votre email" 
            value="{{old('email') ? old('email') : ($user ? $user->email : '')}}" label="email*" />

            <x-form.input name="address" class="w-full" placeholder="l'address de livraison..."
            value="{{old('address') ? old('address') : ($user ? $user->address : '')}}" 
            label="l'adresse*" />
            <x-form.input name="number" type="tel" class="w-full" 
            value="{{old('number') ? old('number') : ($user ? $user->number : '')}}" 
            label="numéro de tel*" placeholder="numéro de tel..."/>
            <x-form.select :list="$wilayas" class="w-full" name="wilaya" 
            :selected="old('wilaya') ? old('wilaya') : $wilaya->name" label="wilaya*" />
            <div class="mb-4">              
                @foreach($shipment_types as $item)
                    <div class="form-control radio-container">
                        <label class="label justify-start gap-2 cursor-pointer">
                            <input type="radio" name="shipment_type" value="{{$item->value}}" {{$item->value == 'au bureau' ? (!$wilaya->desk ? 'disabled' : '') : ''}}
                            class="radio checked:bg-secondary" {{old('shipment_type') == $item->value || $item->value == 'à domicile' ? 'checked' : ''}}/>
                            <span>{{$item->name}}</span> 
                        </label>
                    </div>
                @endforeach
                <x-form.error name="shipment_type" />
            </div>
            <div class="mb-4">
                <div class="mb-2">
                    durrée: 
                    <span id="duration">
                        {{$wilaya->duration}}   
                    </span>
                </div>
                <div class="mb-2">
                    livraison: 
                    <span id="cost">
                        {{$old_type == 'au bureau' ? $wilaya->desk . 'Da' : $wilaya->home . 'Da'}}   
                    </span>
                </div>
            </div>
            <x-form.textarea name="note" class="w-full" :content="old('note')" 
            label="note" placeholder="une note supplémentaire ..." />
            <x-interactive.btn type="submit" class="w-full mt-4">commander</x-interactive.btn>    
        </form>
    </section>
    <script>
        const Wilayas = {{ Js::from($wilayas_) }};
    </script>
</x-ui-elements.layout>