<x-ui-elements.admin-layout>
    <section class="max-w-[700px] mx-auto">   
        <h5 class="text-black font-body font-semibold mb-8">utitlisateurs</h5>
        <header class="grid grid-cols-2 gap-4 border-b py-4 mb-2 border-solid border-border">
            <div>nom</div>
            <div>email</div>
        </header>
        @foreach ($users as $user)
            <article>
                <article class="grid grid-cols-2 gap-4 py-2">
                    <div>{{$user->name}}</div>
                    <div>{{$user->email}}</div>
                </article>
            </article>
        @endforeach
        <div class="btn-group flex my-12">
            <x-interactive.btn :link="$prevUrl" class="ml-auto border-black border !border-solid">
                <i class="fa-solid fa-angles-left"></i>
            </x-interactive.btn>
            <x-interactive.btn :white="true">
                Page {{$currentPage}} Sur {{$lastPage}}
            </x-iteractive.btn>
            <x-interactive.btn :link="$nextUrl" class="mr-auto border-black border !border-solid">
                <i class="fa-solid fa-angles-right"></i>
            </x-interactive.btn>
        </div>
    </section>
</x-ui-elements.admin-layout>