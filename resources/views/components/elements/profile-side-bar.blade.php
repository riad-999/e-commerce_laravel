@props(['current'])

<ul class="list-none m-0 text-black">
    <li>
        <a href="{{route('profile')}}" class="py-2 px-4 hover:bg-gray-200 block 
        {{$current == 'profile' ? 'bg-gray-200' : '' }}">
            compte
        </a>
    </li>
    <li>
        <a href="{{route('edit-profile')}}" class="py-2 px-4 hover:bg-gray-200 block 
        {{$current == 'edit-profile' ? 'bg-gray-200' : '' }}">
            modifier le compte
        </a>
    </li>
    <li>
        <a href="{{route('user-orders')}}" class="py-2 px-4 hover:bg-gray-200 block 
        {{$current == 'user-orders' ? 'bg-gray-200' : '' }}">
            commandes
        </a>
    </li>
    <li>
        <a href="{{route('saved-products')}}" class="py-2 px-4 hover:bg-gray-200 block 
        {{$current == 'saves' ? 'bg-gray-200' : '' }}">
            enregistrements.
        </a>
    </li>
    <li>
        <a href="{{route('pending-reviews')}}" class="py-2 px-4 hover:bg-gray-200 block 
        {{$current == 'pending-reviews' ? 'bg-gray-200' : '' }}">
            en attend d'avis.
        </a>
    </li>
</ul>