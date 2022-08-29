<x-ui-elements.layout>
    <main class="mt-12 grid tablet:grid-cols-8 gap-4 mx-auto max-w-[1400px]">
        <section class="tablet:col-span-3 desk:col-span-2 
        order-last tablet:order-first tablet:border-r border-t 
        tablet:border-t-0 border-solid border-border pl-4 pt-4 tablet:pt-0">
            <x-elements.profile-side-bar current="profile" :id="$user->id"/>
        </section>
        <section class="tablet:col-span-5 desk:col-span-6 p-4">
           <h4 class="font-body font-semibold mb-2">{{$user->name}}</h4>
           <div class="mb-2">{{$user->email}}</div>
           @if($user->address)
                <div class="mb-2">
                    <span>{{$user->wilaya}}</span>
                </div>
            @endif
           @if($user->address)
                <div class="mb-2">
                    <i class="fa-solid fa-location-dot mr-2 text-black"></i> 
                    <span>{{$user->address}}</span>
                </div>
            @endif
            @if($user->address)
                <div class="mb-4">
                    <i class="fa-solid fa-phone mr-2 text-black"></i>
                    <span>{{$user->number}}</span>
                </div>
            @endif
            <x-interactive.btn :link="route('edit-profile',$user->id)">
                Modifier le Profile
            </x-interactive.btn>
        </section>
    </main>
</x-ui-elements.layout>