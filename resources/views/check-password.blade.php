<x-ui-elements.profile-layout>
    <x-slot:side>
        <x-elements.profile-side-bar current="edit-profile" :id="$id"/>
    </x-slot>
    <form action="{{route('check-password')}}" method="POST" class="desk:col-span-6 max-w-[500px]">
        @csrf
        <h5 class="text-black font-body font-semibold mb-8">changement de mot de pass</h5>
        <p class="mb-4">donnez votre mot de passe actuel pour continuer</p>
        <x-form.input type="password" class="text-sm" name="password" label="mot de pass *" />
        <x-interactive.btn type="submit">valider</x-interactive.btn>
    </form>
</x-ui-elements.profile-layout>