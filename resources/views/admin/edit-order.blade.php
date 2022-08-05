<x-ui-elements.layout>
    <div class="tablet:grid grid-cols-6 gap-8">
        <x-ui-elements.admin-sidebar />
        <form action="{{route('update-order',$order->id)}}" method="POST" class="px-8 pt-8 tablet:mr-8 col-span-5" autocomplete="off">
            <h4 class="font-body font-semibold mb-8">commande #{{$order->id}}</h4>
            <x-interactive.btn :link="route('orders')" class="mb-12" :white="true">
                <i class="fa-solid fa-left-long mr-2"></i> liste
            </x-interactive.btn>
            @csrf
            @method("PATCH")
            <div class="flex flex-col tablet:flex-row gap-8">
                <div>
                    <x-form.input name="track_code" class="w-[250px]" value="{{$order->track_code}}" 
                    label="code" />
                    {{-- <x-form.select :list="$states" class="w-[250px]" name="state" 
                    :selected="$order->state" label="l'état"/> --}}
                    <x-form.input name="address" class="max-w-[250px]" value="{{$order->address}}" 
                    label="l'adresse" />
                    <x-form.select :list="$wilayas" class="w-[250px]" name="wilaya" 
                    :selected="$order->wilaya" label="wilaya"/>
                    
                    <div class="mb-8">              
                        @foreach($shipment_types as $item)
                            <div class="form-control radio-container">
                                <label class="label justify-start gap-2 cursor-pointer">
                                    @php
                                    $disabled = ($item->value == 'au bureau' && !$desk) ? 'disabled' : '';
                                    @endphp
                                    <input type="radio" name="shipment_type" {{$disabled}} value="{{$item->value}}" 
                                    class="radio checked:bg-primary" {{$order->shipment_type == $item->value ? 'checked' : ''}}/>
                                    <span>{{$item->name}}</span> 
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <x-form.input name="name" class="max-w-[250px]" value="{{$order->name}}" 
                    label="nom de client" />
                    <x-form.textarea name="note" class="max-w-[250px]" :content="$order->note" 
                    label="note" />
                    <div>
                        <x-interactive.btn :link="route('edit-order-products',$order->id)" class="mb-8" :white="true">produits</x-interactive.btn>
                        <x-interactive.btn :link="route('order',$order->id)" class="mb-8" :white="true">commande</x-interactive.btn>
                    </div>
                </div>
            </div>
            <div>
                <x-interactive.btn type="submit" class="w-max">sauvgarder</x-interactive.btn>
                <x-interactive.btn type="reset" class="w-max" :white="true">reset</x-interactive.btn>
            </div>
        </form>
    </div>
    <script>
        const Wilayas = {{ Js::from($wilayas_) }};
    </script>
</x-ui-elements.layout>