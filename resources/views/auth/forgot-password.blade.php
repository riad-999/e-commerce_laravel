<x-ui-elements.layout>
    <form action="{{route('password.email')}}" method="POST" class="w-[90%] max-w-[500px] mx-auto mt-16" >
        @csrf
        <h5 class="text-black font-body font-semibold mb-8">changement de mot de pass</h5>
        <p class="mb-4">donnez l'email de votre compte afin de changer le mot de pass</p>
        <x-form.input type="email" class="w-full" label="email *" name="email" />
        <x-interactive.btn type="submit">suivant</x-interactive.btn>
    </form>
</x-ui-elements.layout>