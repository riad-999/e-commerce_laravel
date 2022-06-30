<x-ui-elements.layout>
    <main>
        <section class="h-70vh bg-gray-300 overflow-hidden mb-24">   
            <button class="block capitalize mx-auto relative top-3/4 py-2 px-4 xl:px-16 hover:bg-white hover:text-secondary bg-secondary text-white border border-transparent border-solid hover:border-secondary rounded transition-colors duration-500">
                <a>découvrez tout</a>
            </button>        
            {{-- <button class="btn hover:bg-white hover:text-secondary hover:border-secondary bg-secondary text-white block font-semibold capitalize mx-auto relative top-2/3 py-6 px-12"><a>découvrez tout</a></button> --}}

            {{-- <img class="slide-img block basis-1/3 h-full" src="storage/ui-images/slide1.webp" alt="image"/>    
            <img class="slide-img block basis-1/3 h-full" src="storage/ui-images/slide2.webp" alt="image"/>
            <img class="slide-img block basis-1/3 h-full" src="storage/ui-images/slide3.webp" alt="image"/>   --}}
        </section>

        <section class="mb-24">
            <h3 class="text-center pb-2">nouveau arrivage</h3>
            <div class="mx-auto w-32 border-b-2 border-secondary border-solid mb-12"></div>
            <div class="grid xl:grid-cols-3 gap-9 max-w-screen-xl mx-auto px-8 mb-12"> 
                <article class="h-20vh border border-solid shadow-sm border-gray-300"></article>
                <article class="h-20vh border border-solid shadow-sm border-gray-300"></article>
                <article class="h-20vh border border-solid shadow-sm border-gray-300"></article>
            </div>
            <button class="block capitalize mx-auto py-2 px-4 xl:px-16 hover:bg-white hover:text-secondary bg-secondary text-white border border-transparent border-solid hover:border-secondary rounded transition-colors duration-500">
                <a>découvrez plus</a>
            </button> 
        </section>

        <section class="bg-test py-8 mb-24">
            <h3 class="text-center pb-2">types</h3>
            <div class="mx-auto w-24 border-b-2 border-secondary border-solid mb-12"></div>
            <div class="grid xl:grid-cols-3 gap-9 max-w-screen-xl mx-auto px-8 mb-12">
                <article class="h-20vh border border-solid shadow-sm border-gray-300 bg-white"></article>
                <article class="h-20vh border border-solid shadow-sm border-gray-300 bg-white"></article>
                <article class="h-20vh border border-solid shadow-sm border-gray-300 bg-white"></article>
            </div>
            <button class="block capitalize mx-auto py-2 px-4 xl:px-16 hover:bg-white hover:text-secondary bg-secondary text-white border border-transparent border-solid hover:border-secondary rounded transition-colors duration-500">
                <a>voir plus</a>
            </button>
        </section>

        <section class="mb-24">
            <h3 class="text-center pb-2 mb-12">Nos services</h3>
            {{-- <div class="mx-auto w-32 border-b-2 border-secondary border-solid mb-12"></div> --}}
            <div class="grid xl:grid-cols-3 gap-9 max-w-screen-xl mx-auto px-8 mb-12"> 
                <article class="text-center p-8 bg-test">
                    <div><i class="fa-solid fa-truck-fast text-4xl text-secondary mb-8"></i></div>
                    <div class="text-3xl xl:text-4xl text-secondary mb-4 capitalize">livraison 58 wilayas</div>
                </article>
                <article class="text-center p-8 bg-test">
                    <div><i class="fa-solid fa-money-bill-wave text-4xl text-secondary mb-8"></i></div>
                    <div class="text-3xl xl:text-4xl text-secondary mb-4">Paiement à la Réception</div>
                </article>
                <article class="text-center p-8 bg-test">
                    <div><i class="fa-solid fa-sack-dollar text-4xl text-secondary mb-8"></i></div>
                    <div class="text-3xl xl:text-4xl text-secondary mb-4">Un Autre Service à offrir</div>
                </article>
            </div> 
        </section>
    </main>
</x-ui-elements.layout>
