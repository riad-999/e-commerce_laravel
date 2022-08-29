<x-ui-elements.layout>
    <form action="{{route('register')}}" method="POST" class="w-[90%] max-w-[500px] mx-auto mt-16" >
        @csrf
        <h5 class="text-center text-black font-body font-semibold mb-8">créer un compte</h5>
        <x-form.input name="name" label="nom complet *" value="{{old('name')}}" class="w-full" placeholder="votre nom et prénom"/>
        <x-form.input type="email" name="email" label="email *" value="{{old('email')}}" class="w-full" placeholder="votre email"/>
        <div class="grid tablet:grid-cols-2 gap-4 pb-4 border-b border-border border-solid mb-4">
            <x-form.input type="password" name="password" label="mot de pass *" class="w-full text-sm" :margin="false"/>
            <x-form.input type="password" name="password_confirmation" label="confirmation *" class="w-full text-sm" :margin="false"/>
        </div>
        <x-form.input label="numéro de téléphone" value="{{old('number')}}" type="tel" name="number" class="w-full" placeholder="votre numéro"/>
        <x-form.input label="addresse" name="address" value="{{old('address')}}" class="w-full" placeholder="votre addresse"/>
        <x-form.select name="wilaya" title="choix de wilaya" class="w-full" 
        :list="$wilayas" :selected="old('wilaya')" label="la wilaya"/>
        {{-- <div class="mb-8">
            <input type="checkbox" name="subscribe" value="true" {{old('subscribe') ? 'checked' : ''}} id="subscribe" class="accent-black cursor-pointer" />
            <label for="subscribe" class="pl-2 cursor-pointer">
                s'abonner
            </label>
            <p class="text-[0.9rem]">
                quand vous abonner à notre journal vous aller recever des emails 
                sur les evenements, des code promo,...
            </p>
        </div> --}}
        <x-interactive.btn class="w-full">s'inscrire</x-interactive.btn>
    </form>
</x-ui-elements.layout>