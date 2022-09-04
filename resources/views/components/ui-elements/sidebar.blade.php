<aside id="sidebar" class="fixed top-0 bottom-0 right-0 !translate-x-full transition duration-300 w-full max-w-[500px] desk:hidden 
h-[100vh] max-h-[100vh] overflow-y-hidden bg-white py-2 border-l border-solid border-border z-[200]">
    <header class="flex items-center pb-2 mb-8 border-b border-solid border-border px-4">
        <h5 class="font-body text-black font-semibold mx-auto">
            {{config('app.name')}}
        </h5>
        <button id="close-sidebar" class="p-2 text-black text-2xl">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </header>
    <div class="px-2">
        <form action="{{route('products')}}" class="border-b border-solid border-border flex justify-center mb-12">
            <input type="search" name="search" class="block focus:outline-none w-full placeholder-gray-400 py-3" autofocus placeholder="chercher ...">
            <x-interactive.simple-btn class="ml-2 px-4 text-black" type="submit" :black="false">
                <i class="fa-solid fa-magnifying-glass"></i>
            </x-interactive.simple-btn>
        </form>
        <ul class="list-none p-0 mb-12 flex flex-col">
            <x-interactive.list-item :url="route('home')" class="border-y border-solid border-secondary w-full">accueil</x-interactive.list-item>
            <x-interactive.list-item :url="route('products')" class="border-b border-solid border-secondary w-full">boutique</x-interactive.list-item>
            <x-interactive.list-item url="#" class="border-b border-solid border-secondary w-full">à propos</x-interactive.list-item>
        </ul>
        <div class="grid grid-cols-2 gap-2 mb-12">
            @guest
                <x-interactive.btn :link="route('login')">Se Connecter</x-interactive.btn>
                <x-interactive.btn :link="route('register')" :white="true" class="ml-2">S'inscrire</x-interactive.btn>
            @endguest
            @auth
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <x-interactive.btn class="w-full" type="submit">Se Déconnecter</x-interactive.btn>
                </form>
                <x-interactive.btn :link="route('profile',auth()->user()->id)" :white="true" class="ml-2">
                    compte <i class="fa-solid fa-user ml-2"></i>
                </x-interactive.btn>
            @endauth
        </div>
        <div class="flex justify-center gap-6">
            <x-interactive.simple-btn :big="true"><i class="fa-brands fa-instagram"></i></x-interactive.simple-btn>
            <x-interactive.simple-btn :big="true"><i class="fa-brands fa-facebook"></i></x-interactive.simple-btn>
        </div>
    </div>
</aside>