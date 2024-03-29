<nav class="bg-gray-100 border-b border-gray-400 border-solid sticky top-0 mb-12 py-2 z-[100]">
    <div class="flex justify-between items-baseline max-w-[1600px] mx-auto px-4">
        <a href="{{route('home')}}" class="block desk:hidden"><h3 class="font-body font-semibold">Logo</h3></a>
        <div>
            <ul class="list-none p-0 m-0 hidden desk:flex items-baseline">
                <div class="text-2xl text-black font-semibold mr-4"><a href="{{route('home')}}">Logo</a></div>
                <x-interactive.list-item :url="route('products')">Boutique</x-interactive.list-item>
                <x-interactive.list-item url="#">à Propos</x-interactive.list-item>
            </ul>
        </div>
        <div class="flex gap-4 items-center">
            <div class="flex items-center gap-2">
                <div class="hidden desk:block">
                    <div class="dropdown inline-block ml-2 relative"> 
                        <label tabindex="0" class="block text-black cursor-pointer">
                            <i class="fa-solid fa-user"></i>
                        </label>
                        <ul tabindex="0" class="dropdown-content menu bg-white shadow z-50 w-max">
                            <a href="{{route('profile')}}" class="block">
                                <li class="py-2 px-4 hover:bg-gray-100 cursor-pointer">Compte</li>
                            </a> 
                            <form action="{{route('logout')}}" method="POST" class="py-2 px-4 hover:bg-gray-100 cursor-pointer">
                                @csrf
                                <button type="submit">
                                    Se Déconnecter
                                </button>
                            </form>
                        </ul>
                    </div>           
                </div>
                <button id="open-adminbar" class="text-xl text-secondary ml-2 desk:hidden">
                    <i class="fa-solid fa-angles-left"></i>
                </button>
                <button id="open-sidebar" class="text-xl text-secondary desk:hidden ml-2">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <form class="hidden desk:flex" action="{{route('admin-products')}}" autocomplete="off">
                <input type="search" name="name" placeholder="chercher un produit..." 
                    class="px-2 border border-solid border-gray-400" />
                <x-interactive.btn type="submit" class="hover:border-secondary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </x-interactive.btn>
            </form>
        </div>
    </div>
</nav>