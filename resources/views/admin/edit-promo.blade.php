<x-ui-elements.admin-layout>
    <form action="{{route('update-promo',$product->id)}}" method="POST" class="w-full max-w-[500px] mx-auto" autocomplete="off">
        @csrf
        @method("PATCH")
        <h5 class="font-body font-semibold mb-8"> promo</h5>
        <x-form.input type="number" class="w-full" label="prix de promo (Da)" 
        name="promo" value="{{$product->promo}}" :remove="true" min="0"/>
        <x-form.input type="date" class="w-full" label="date d'expiration" 
        name="expires" value="{{$product->expires}}" :remove="true"/>
        <x-interactive.btn type="submit" class="w-full mt-4">Terminer</x-interactive.btn>
    </form>
</x-ui-elements.admin-layout>
