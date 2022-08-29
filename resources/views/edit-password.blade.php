<x-ui-elements.profile-layout>
    <x-slot:side>
        <x-elements.profile-side-bar current="edit-profile" :id="$id"/>
    </x-slot>
    <form action="{{route('update-password',$id)}}" method="POST" class="desk:col-span-6 max-w-[500px]">
        @csrf
        @method('PATCH')
        <h5 class="text-black font-body font-semibold mb-8">changement de mot de pass</h5>
        <p class="mb-4">donnez votre noveau mot de pass</p>
        <x-form.input type="password" class="text-sm" label="noveau mot de pass *" name="password" />
        <x-form.input type="password" class="text-sm" name="password_confirmation" label="confirmation *" />
        <x-interactive.btn type="submit">valider</x-interactive.btn>
    </form>
</x-ui-elements.profile-layout>