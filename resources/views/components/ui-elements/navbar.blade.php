<div class='bg-secondary text-white tracking-2 text-center py-4 px-6 text-xs font-semibold'>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Distinctio, provident!</div>
<nav class="bg-white border-b border-gray-400 border-solid sticky top-0 z-10">
    <div class="flex justify-between items-baseline py-2 px-8 desk:max-w-screen-xl desk:mx-auto">
        <h3>Logo</h3>
        <ul class="list-none p-0 m-0 hidden desk:flex">
            <x-interactive.list-item>accueil</x-interactive.list-item>
            <x-interactive.list-item>boutique</x-interactive.list-item>
            <x-interactive.list-item>contactes</x-interactive.list-item>
            <x-interactive.list-item>à propos</x-interactive.list-item>
        </ul>
        <div>
            <button id="sidebar-btn" class="text-xl text-secondary mr-4 desk:hidden"><i class="fa-solid fa-bars"></i></button>
            <button class="text-xl text-secondary hidden desk:inline-block mr-4"><i class="fa-solid fa-magnifying-glass"></i></button>
            <button class="text-xl text-secondary"><i class="fa-solid fa-cart-shopping"></i></button>
        </div>
    </div>
</nav>