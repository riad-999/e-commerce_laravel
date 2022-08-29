@props(['current','id'])

<ul class="list-none m-0 text-black">
    <li>
        <a href="{{route('profile',$id)}}" class="py-2 px-4 hover:bg-gray-200 block 
        {{$current == 'profile' ? 'bg-gray-200' : '' }}">
            compte
        </a>
    </li>
    <li>
        <a href="{{route('edit-profile',$id)}}" class="py-2 px-4 hover:bg-gray-200 block 
        {{$current == 'edit-profile' ? 'bg-gray-200' : '' }}">
            modifier le compte
        </a>
    </li>
    <li>
        <a href="#" class="py-2 px-4 hover:bg-gray-200 block 
        {{$current == 'orders' ? 'bg-gray-200' : '' }}">
            commandes
        </a>
    </li>
    <li>
        <a href="#" class="py-2 px-4 hover:bg-gray-200 block 
        {{$current == 'saves' ? 'bg-gray-200' : '' }}">
            enregistrements.
        </a>
    </li>
</ul>