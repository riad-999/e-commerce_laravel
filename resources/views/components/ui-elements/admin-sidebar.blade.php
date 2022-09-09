<div class="hidden desk:block desk:w-[30%] max-w-[270px]"></div>
<aside class="fixed right-0 desk:right-auto top-0 desk:left-0 bottom-0
h-[100vh] max-h-[100vh] w-full  desk:w-[30%] max-w-[270px] overflow-y-auto py-8
bg-gray-100 shadow-md  border-r border-solid border-border z-[200] desk:z-auto translate-x-full 
desk:translate-x-0 transition duration-300" id="adminbar">
    <header class="flex justify-between desk:justify-start items-center mb-12 px-4">
        <div class="flex items-center">
            <div>
                <i class="fa-solid fa-unlock text-secondary text-2xl"></i>
            </div>
            <div class="text-center ml-8">
                <h5 class="font-body text-secondary font-semibold">
                    {{config('app.name')}}
                </h5>
                <div class="text-sm">Admin</div>
            </div>
        </div>
        <button class="self-start desk:hidden" id="close-adminbar">
            <i class="fa-solid fa-xmark text-secondary text-2xl"></i>
        </button>
    </header>
    <ul class="list-none">
        <x-elements.admin-sidebar-item url="#">
            <x-slot:icone>
                <i class="fa-solid fa-house"></i>
            </x-slot>
            Dashboard
        </x-elements.admin-sidebar-item>
        <x-elements.admin-sidebar-item :url="route('admin-products')">
            <x-slot:icone>
                <i class="fa-solid fa-bag-shopping"></i>
            </x-slot>
            Produits
        </x-elements.admin-sidebar-item>
        <x-elements.admin-sidebar-item :url="route('orders')">
            <x-slot:icone>
                <i class="fa-solid fa-cart-shopping"></i>
            </x-slot>
            Commandes
        </x-elements.admin-sidebar-item> 
        <x-elements.admin-sidebar-item :url="route('edit-home')">
            <x-slot:icone>
                <i class="fa-solid fa-display"></i>
            </x-slot>
            accuille
        </x-elements.admin-sidebar-item>
        <x-elements.admin-sidebar-item :url="route('orders')">
            <x-slot:icone>
                <i class="fa-solid fa-list-check"></i>
            </x-slot>
            Catégories
        </x-elements.admin-sidebar-item>
        <x-elements.admin-sidebar-item :url="route('brands')">
            <x-slot:icone>
                <i class="fa-solid fa-shop"></i>
            </x-slot>
            Marques
        </x-elements.admin-sidebar-item>
        <x-elements.admin-sidebar-item :url="route('wilayas')">
            <x-slot:icone>
                <i class="fa-solid fa-location-dot"></i>
            </x-slot>
            Wilayas
        </x-elements.admin-sidebar-item>
        <x-elements.admin-sidebar-item :url="route('orders')">
            <x-slot:icone>
                <i class="fa-solid fa-fill"></i>
            </x-slot>
            Couleurs
        </x-elements.admin-sidebar-item>
        <x-elements.admin-sidebar-item :url="route('promo-codes')">
            <x-slot:icone>
                <i class="fa-solid fa-rectangle-ad"></i>
            </x-slot>
            Codes promo
        </x-elements.admin-sidebar-item>
        {{-- <x-elements.admin-sidebar-item :url="route('orders')">
            <x-slot:icone>
                <i class="fa-solid fa-square-check"></i>
            </x-slot>
            Séléction
        </x-elements.admin-sidebar-item> --}}
        <x-elements.admin-sidebar-item :url="route('orders')">
            <x-slot:icone>
                <i class="fa-solid fa-user-group"></i>
            </x-slot>
            Admins
        </x-elements.admin-sidebar-item>
        <x-elements.admin-sidebar-item :url="route('orders')">
            <x-slot:icone>
                <i class="fa-solid fa-gear"></i>
            </x-slot>
            parametères
        </x-elements.admin-sidebar-item>
    </ul>
</aside>