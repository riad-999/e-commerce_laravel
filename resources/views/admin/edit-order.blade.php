<x-ui-elements.admin-layout>
    <form action="{{route('update-order',$order->id)}}" method="POST" 
        class="max-w-[500px] mx-auto mb-12" autocomplete="off">
        <h5 class="font-body font-semibold mb-8">commande #{{$order->id}}</h5>
        <a href={{route('orders')}} class="inline-block mb-4 underline mr-2">
            <i class="fa-solid fa-left-long mr-2"></i> liste
        </a>
        @csrf
        @method("PATCH")
            <x-form.input name="track_code" class="w-full" value="{{$order->track_code}}" 
            label="code" />
            <x-form.input name="address" class="w-full" value="{{$order->address}}" 
            label="l'adresse" />
            <x-form.select :list="$wilayas" class="w-full" name="wilaya" 
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
            <x-form.input name="name" class="w-full" value="{{$order->name}}" 
                label="nom de client" />
            <x-form.textarea name="note" class="w-full" :content="$order->note" 
            label="note" />
            <div class="grid grid-cols-2 gap-2 mb-8">
                <x-interactive.btn :link="route('edit-order-products',$order->id)" class="w-full" :white="true">produits</x-interactive.btn>
                <x-interactive.btn :link="route('order',$order->id)" class="w-full" :white="true">commande</x-interactive.btn>
            </div>
        <div class="grid gap-2">
            <x-interactive.btn type="submit" class="w-full">Sauvgarder</x-interactive.btn>
            <x-interactive.btn type="reset" class="w-full" :white="true">Réinitialiser</x-interactive.btn>
        </div>
    </form>
    <script>
        const Wilayas = {{ Js::from($wilayas_) }};
    </script>
</x-ui-elements.admin-layout>