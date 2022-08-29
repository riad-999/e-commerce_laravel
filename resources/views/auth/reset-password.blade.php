<x-ui-elements.layout>
    <form action="{{route('reset-password',$id)}}" method="POST" class="w-[90%] max-w-[500px] mx-auto mt-16" >
        @csrf
        @method("PATCH")
        <h5 class="text-black font-body font-semibold mb-8">changement de mot de passe</h5>
        <p class="mb-4">donnez votre noveau mot de passe</p>
        <x-form.input type="password" class="w-full text-sm" label="mot de passe*" name="password" />
        <x-form.input type="password" class="w-full text-sm" label="confirmer le mot de passe *" name="password_confirmation" />
        <x-interactive.btn type="submit">Changer</x-interactive.btn>
    </form>
</x-ui-elements.layout>

@php
    session()->forget('alert');
@endphp