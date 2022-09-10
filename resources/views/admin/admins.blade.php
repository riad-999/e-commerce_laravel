<x-ui-elements.admin-layout>
    <x-interactive.modal id="delete" data-form="true">
        <form action="" method="POST">
            @csrf
            @method('delete')
            <div class="text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-secondary"></i> 
                    vous voulez vraiment supprimer l'admin ?
                </div>
                <x-interactive.btn type="button" class="close-modal w-full max-w-[100px]" data-id="delete" :white="true">
                    Annuler
                </x-interactive.btn>
                <x-interactive.btn type="submit" class="ml-2 w-full max-w-[100px]">
                    Oui
                </x-interactive.btn>
            </div>
        </form>
    </x-interactive.modal>
    <section class="flex flex-col desk:flex-row mx-auto justify-center max-w-[600px] desk:max-w-[1200px] gap-12 desk:gap-8">
        <form action="{{route('store-admin')}}" method="POST" class="w-full tablet:max-w-[400px]" autocomplete="off">
            @csrf
            <h5 class="text-black font-body font-semibold mb-8">Ajouter un admin</h5>
            <x-form.input name="name" label="nom" value="{{old('name')}}" class="w-full" placeholder="votre nom"/>
            <x-form.input type="email" name="email" label="email *" value="{{old('email')}}" class="w-full" placeholder="l'email"/>
            <div class="grid tablet:grid-cols-2 gap-4 mb-4">
                <x-form.input type="password" name="password" label="mot de pass *" class="w-full text-sm" :margin="false"/>
                <x-form.input type="password" name="password_confirmation" label="confirmation *" class="w-full text-sm" :margin="false"/>
            </div>
            <x-interactive.btn type="submit" class="w-full">Ajouter</x-interactive.btn>
        </form>
        <section class="w-full min-w-[320px] overflow-x-auto desk:max-w-[800px] mb-16">
            <h5 class="font-body font-semibold mb-8">Admins</h5>
            <header class="grid grid-cols-admins gap-4 border-b py-4 mb-2 border-solid border-border">
                <div>nom</div>
                <div>email</div>
                <div></div>
            </header>
            <section class="border-b mb-2 border-solid border-border w-full max-h-[400px] desk:max-h-[600px] overflow-y-auto">
                @foreach($admins as $admin)
                    <article class="grid grid-cols-admins gap-4 py-2">
                        <div>{{$admin->name}}</div>
                        <div>{{$admin->email}}</div>
                        @if(!$admin->is_privileged)
                            <div class="text-secondary">
                                <button class="inline-block open-modal" data-id="delete" 
                                data-route="{{route('delete-user',$admin->id)}}">
                                    <i class="fa-solid fa-trash p-2"></i>
                                </button>
                            </div>
                        @endif
                    </article>
                @endforeach
            </section>
            <div class="underline mt-8"><a href="{{route('users')}}">utilisateurs</a></div>
        </section>
    </section>
</x-ui-elements.admin-layout>