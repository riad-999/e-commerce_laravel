<x-ui-elements.admin-layout>
    <div class="tablet:grid grid-cols-6 gap-8 bg-gray-100">
        <x-interactive.modal id="state-form" data-form="true">
            <form action="" method="POST" autocomplete="off">
            @csrf
                @method('PATCH')
                @php
                   $title = $order->state == $states[0]->name ? "confirmer l'ordre" : "mettre l'ordre comme livré"; 
                @endphp
                <div class="text-center flex flex-col">
                    <h5 class="font-body font-semibold mb-8">
                        {{$title}}
                    </h5>
                    @if($order->state == $states[0]->name) 
                        <x-form.input type="hidden" name="state" value="{{$states[1]->name}}" />
                        <x-form.input name="track_code" class="max-w-[90%]" placeholder="code de suivi..." 
                        value="{{$order->track_code}}" />
                        <div>
                            <x-interactive.btn type="button" class="close-modal" data-id="state-form" :white="true">
                                Annuler
                            </x-interactive.btn>
                            <x-interactive.btn type="submit" class="ml-2">
                                Confirmer
                            </x-interactive.btn>
                        </div>
                    @elseif($order->state == $states[1]->name) 
                        <x-form.input type="hidden" name="state" value="{{$states[2]->name}}" />
                        <div>
                            <x-interactive.btn type="button" class="close-modal" data-id="state-form" :white="true">
                                Annuler
                            </x-interactive.btn>
                            <x-interactive.btn type="submit" class="ml-2">
                                Livré
                            </x-interactive.btn>
                        </div>
                    @endif
                </div>
            </form>
        </x-interactive.modal>
        <x-interactive.modal id="state-cancel" data-form="true">
            <form action="" method="POST" autocomplete="off">
                @csrf
                @method('PATCH')
                @php
                   $title = $order->state == $states[1]->name ? "annuler la confirmation" : "mettre en route"; 
                @endphp
                <div class="text-center flex flex-col">
                    <h5 class="font-body font-semibold mb-8">
                        {{$title}}
                    </h5>
                    @if($order->state == $states[1]->name) 
                        <x-form.input type="hidden" name="state" value="{{$states[0]->name}}" />
                        <x-form.input type="hidden" name="cancel" value="true" />
                        <div>
                            <x-interactive.btn type="button" class="close-modal" data-id="state-cancel" :white="true">
                                fermer
                            </x-interactive.btn>
                            <x-interactive.btn type="submit" class="ml-2">
                                Annuler
                            </x-interactive.btn>
                        </div>
                    @elseif($order->state == $states[2]->name) 
                        <x-form.input type="hidden" name="state" value="{{$states[1]->name}}" />
                        <x-form.input type="hidden" name="cancel" value="true" />   
                        <div>
                            <x-interactive.btn type="button" class="close-modal" data-id="state-cancel" :white="true">
                                Fermer
                            </x-interactive.btn>
                            <x-interactive.btn type="submit" class="ml-2">
                                en route
                            </x-interactive.btn>
                        </div>
                    @endif
                </div>
            </form>
        </x-interactive.modal>
        <main class="col-span-5 pt-8 px-2">
            <h4 class="font-body font-semibold mb-8">
                ordre #{{$order->id}} 
            </h4>
            <x-interactive.btn :link="route('orders')" class="mr-2 mb-8" :white="true">
                <i class="fa-solid fa-left-long mr-2"></i> liste
            </x-interactive.btn>
            <x-interactive.btn :link="route('edit-order',$order->id)" class="mb-8" :white="true">
                modifier
            </x-interactive.btn>
            <x-elements.order :order="$order" :states="$states"/>
        </main>
    </div>
</x-ui-elements.admin-layout>