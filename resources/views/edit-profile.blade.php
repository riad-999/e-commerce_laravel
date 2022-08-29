<x-ui-elements.layout>
    <main class="mt-12 grid tablet:grid-cols-8 gap-4 mx-auto max-w-[1400px]">
        <section class="tablet:col-span-3 desk:col-span-2 
        order-last tablet:order-first tablet:border-r border-t 
        tablet:border-t-0 border-solid border-border pl-4 pt-4 tablet:pt-0">
            <x-elements.profile-side-bar current="edit-profile" :id="$user->id"/>
        </section>
        <section class="tablet:col-span-5 desk:col-span-6 p-4">
            <form action="{{route('update-profile',$user->id)}}" method="POST" class="desk:col-span-6 max-w-[500px]">
                @csrf
                @method('PATCH')
                <h5 class="text-black font-body font-semibold mb-8">modifier le compte</h5>
                <x-form.input name="name" label="nom complet *" 
                value="{{old('name') ? old('name')  : $user->name }}" 
                class="w-full" placeholder="votre nom et prénom"/>
                <x-form.input type="email" name="email" label="email *" 
                value="{{old('email') ? old('email') : $user->email}}" 
                class="w-full mb-4 border-b border-solid border-border" 
                placeholder="votre email"/>
                <x-form.input label="numéro de téléphone" 
                value="{{old('number') ? old('number') : $user->number}}" 
                type="tel" name="number" class="w-full" placeholder="votre numéro"/>
                <x-form.input label="addresse" name="address" 
                value="{{old('address') ? old('address') : $user->address}}" 
                class="w-full" placeholder="votre addresse"/>
                <x-form.select name="wilaya" title="choix de wilaya" class="w-full" 
                :list="$wilayas" :selected="old('wilaya') ? old('wilaya') : $user->wilaya"  
                label="la wilaya"/>
                <x-interactive.btn :link="route('show-check-password',$user->id)" :white="true">
                    Changer le mode de pass
                </x-interactive.btn>
                <div class="grid tablet:grid-cols-2 gap-2 mt-8">
                    <x-interactive.btn type="submit">Sauvgarder</x-interactive.btn>
                    <x-interactive.btn type="reset" :white="true">réinitialiser</x-interactive.btn>
                </div>
            </form>
    </main>
</x-ui-elements.layout>