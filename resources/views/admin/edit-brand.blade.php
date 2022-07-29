<x-ui-elements.layout>
    <x-interactive.alert />
    <div class="desk:grid grid-cols-6 gap-8 bg-gray-100">
        <aside class="hidden desk:block h-100vh py-8 px-4 bg-white shadow-md">
            <ul class="list-none">
                <li class="text-xl font-semibold hover:bg-gray-300">
                    <a href="" class="inline-block py-2 px-4">
                        <i class="fa-solid fa-bag-shopping mr-2"></i> produits
                    </a>
                </li>
                <li class="text-xl font-semibold hover:bg-gray-300">
                    <a href="" class="inline-block py-2 px-4">
                        <i class="fa-solid fa-bag-shopping mr-2 hover:bg-gray-300"></i> produits
                    </a>
                </li>
            </ul>
        </aside>
        <main class="col-span-5 pt-8 px-4">
            <h4 class="font-body font-semibold mb-8">categories</h4>      
                <form class="bg-white p-4 rounded-lg tablet:w-1/2" method="POST" 
                autocomplete="off" action="{{ route('update-brand',$brand->id) }}">
                    @csrf
                    @method('PATCH')
                    <h5 class="font-body font-semibold mb-8">modifier {{$brand->name}}</h6>
                    <x-form.input name="name" value="{{ old('name') ? old('name') : $brand->name}}" 
                    label="nom" class="w-full" :edit="true" :disabled="true" />
                    <div>
                        <a href="{{route('brands')}}" class="btn">liste</a>
                        <button type="submit" class="btn ml-1">modifier</button>
                    </div>
                </form>                                                      
        </main>
    </div>
</x-ui-elements.layout>