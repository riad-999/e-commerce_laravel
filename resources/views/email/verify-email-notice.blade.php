<x-ui-elements.layout>
    <form action="{{route('resend-verify-email')}}" class="w-[90%] max-w-[700px] mx-auto mt-16">
        <p class="mb-4">
            merci de vous être inscrit sur notre site Web, 
            pour terminer nous devons d'abord vérifier votre e-mail. 
            nous vous avons envoyé un e-mail pour confirmation, 
            vérifiez votre e-mail.
        </p>
        <p>
            si vous n'avez reçue aucun mail renvoyez par clicker sur revoyer ci dessus.
            si vous ne revevez toujour pas, aller au <a href="#" class="underline text-black">votre parametere de compte</a> 
            pour verifier que l'email n'est pas faut.
        </p>
        <x-interactive.btn type="submit" class="block my-4 !px-8">
            renvoyer
        </x-interactive.btn>
        @if(session('message'))
            <p class="text-black">on vous a enoyer un notre email!</p>
        @endif
    </form>
</x-ui-elements.layout>