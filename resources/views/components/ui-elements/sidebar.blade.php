<aside class="z-50 fixed top-0 bottom-0 left-full xl:hidden bg-white">
    <form class="border-b border-solid border-gray-300 flex justify-center mb-12">
        <input type="search" class="block focus:outline-none placeholder-gray-400 py-4" autofocus placeholder="chercher ...">
        <x-interactive.simple-btn class="ml-2 text-gray-400" type="submit" :black="false">
            <i class="fa-solid fa-magnifying-glass"></i>
        </x-interactive.simple-btn>
    </form>
    <ul class="list-none p-0 mb-12 flex flex-col">
        <x-interactive.list-item class="border-y border-solid border-secondary w-full">accueil</x-interactive.list-item>
        <x-interactive.list-item class="border-b border-solid border-secondary w-full">boutique</x-interactive.list-item>
        <x-interactive.list-item class="border-b border-solid border-secondary w-full">contactes</x-interactive.list-item>
        <x-interactive.list-item class="border-b border-solid border-secondary w-full">à propos</x-interactive.list-item>
    </ul>
    <div class="flex justify-center gap-6">
        <x-interactive.simple-btn :big="true"><i class="fa-brands fa-instagram"></i></x-interactive.simple-btn>
        <x-interactive.simple-btn :big="true"><i class="fa-brands fa-facebook"></i></x-interactive.simple-btn>
        <x-interactive.simple-btn :big="true"><i class="fa-solid fa-right-to-bracket"></i></x-interactive.simple-btn>
    </div>
    {{-- <div>
        <button id="sidebar-btn" class="text-xl text-secondary mr-4 xl:hidden"><i class="fa-solid fa-bars"></i></button>
        <button class="text-xl text-secondary hidden xl:inline-block mr-4"><i class="fa-solid fa-magnifying-glass"></i></button>
        <button class="text-xl text-secondary"><i class="fa-solid fa-cart-shopping"></i></button>
    </div> --}}
</aside>