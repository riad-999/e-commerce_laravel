<x-ui-elements.layout>
    <form action="{{route('login')}}" method="POST" class="w-[90%] max-w-[500px] mx-auto mt-16" >
        @csrf
        <h5 class="text-center text-black font-body font-semibold mb-8">se connecter</h5>
        @if(session('registered'))
            <p class="text-center mb-4">votre compte a été bien enregistré, connectez vous</p>
        @endif
        <x-form.input name="name" label="nom *" value="{{old('name')}}" 
            class="w-full" placeholder="votre nom" />
        <x-form.input type="password" name="password" label="mot de pass *" 
            class="w-full text-sm" />
        <div class="mb-4">
            <input type="checkbox" id="remember_me" name="remember_me" value="true" {{old('remember_me') ? 'checked' : ''}} id="remember_me" class="accent-black cursor-pointer" />
            <label for="remember_me" class="pl-2 cursor-pointer">
                souvenez moi
            </label>
        </div>
        <div class="mb-4">
            <x-form.error name="notice" />
        </div>
        <small class="text-sm underline"><a href="{{route('password.request')}}">mot de pass oublié ?</a></small>
        <x-interactive.btn class="w-full mt-4">se connecter</x-interactive.btn>
    </form>
</x-ui-elements.layout>