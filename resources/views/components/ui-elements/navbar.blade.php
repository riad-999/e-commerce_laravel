<div class='bg-secondary text-white tracking-2 text-center py-4 px-8 text-xs font-semibold'>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Distinctio, provident!</div>
<nav class="bg-white border-b border-gray-400 border-solid sticky top-0">
    <div class="flex justify-between items-baseline py-2 px-4 max-w-[1400px] desk:mx-auto">
        <a href="{{route('home')}}" class="block desk:hidden"><h3>Logo</h3></a>
        <div>
            <ul class="list-none p-0 m-0 hidden desk:flex items-baseline">
                <li class="mr-2">
                    <a href="{{route('home')}}" class="block"><h3>Logo</h3></a>
                </li>
                {{-- <x-interactive.list-item :url="route('home')">accueil</x-interactive.list-item> --}}
                <x-interactive.list-item :url="route('products')">Boutique</x-interactive.list-item>
                <x-interactive.list-item url="#">à Propos</x-interactive.list-item>
                @guest
                    <x-interactive.list-item :url="route('register')">S'inscrire</x-interactive.list-item>
                @endguest
            </ul>
        </div>
        <div class="flex gap-4">
            <form action="{{route('products')}}" class="hidden tablet:flex justify-center w-[30vw] desk:w-[40vw] max-w-[400px] border-b border-solid border-border">
                <input type="search" name="search" class="block focus:outline-none w-full placeholder-gray-400 px-2 py-2" autofocus placeholder="chercher ...">
                <x-interactive.simple-btn class="ml-2 px-4" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </x-interactive.simple-btn>
            </form>
            <div class="flex items-center gap-2">
                <div class="hidden desk:block">
                    @guest
                        <x-interactive.btn :link="route('login')">Se Connecter</x-interactive.btn>
                    @endguest
                    @auth
                        <div class="dropdown inline-block ml-2 relative"> 
                            <label tabindex="0" class="block text-black cursor-pointer">
                                <i class="fa-solid fa-user"></i>
                            </label>
                            <ul tabindex="0" class="dropdown-content menu bg-white shadow z-50">
                                <a href="{{route('profile',auth()->user()->id)}}" class="block">
                                    <li class="py-2 px-4 hover:bg-gray-100 cursor-pointer">Compte</li>
                                </a> 
                                <a href="#" class="block">
                                    <li class="py-2 px-4 hover:bg-gray-100 cursor-pointer">Commandes</li>
                                </a>
                                <a href="#" class="block">
                                    <li class="py-2 px-4 hover:bg-gray-100 cursor-pointer">Enregistrements</li>
                                </a>
                                <form action="{{route('logout')}}" method="POST" class="py-2 px-4 hover:bg-gray-100 cursor-pointer">
                                    @csrf
                                    <button type="submit">
                                        Se Déconnecter
                                    </button>
                                </form>
                            </ul>
                        </div>
                        {{-- <button :link="route('login')" class="ml-2 text-black">
                            <i class="fa-solid fa-user"></i>
                        </button> --}}
                    @endauth                
                </div>
                <a href="{{route('cart')}}" class="block p-2 text-xl desk:text-2xl">
                    <button><i class="fa-solid fa-cart-shopping text-black"></i></button>
                </a>
                <button id="open-sidebar" class="text-xl text-secondary desk:hidden ml-2">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</nav>
<form action="{{route('products')}}" class="tablet:hidden flex justify-center border-b border-solid border-border">
    <input type="search" name="search" class="block focus:outline-none w-full placeholder-gray-400 px-2 py-3" autofocus placeholder="chercher ...">
    <x-interactive.simple-btn class="ml-2 px-4" type="submit">
        <i class="fa-solid fa-magnifying-glass"></i>
    </x-interactive.simple-btn>
</form>