@if(session('alert'))
    @php
        $alert = session('alert');
        $message = $alert->message;
        $class = '';
        if($alert->type === 'success') {
            $border = 'border-green-700 border-solid border';
            $class="text-green-700";
        }
        if($alert->type === 'error') {
            $border = 'border-red-700 border-solid border';
            $class="text-red-700";
        }
        if($alert->type === 'warning') {
            $border = 'border-orange-700 border-solid border';
            $class="text-orange-700";
        }
    @endphp
    
    <div class="bg-black bg-opacity-30 fixed inset-0 flex justify-center items-center 
    transition-opacity opacity-0 !opacity-100 Alert z-[100]">
        <div class="{{"$border"}} shadow-lg p-4 
        w-[95%] max-w-[500px] m-auto text-center bg-white">
            <i class="fa-solid fa-circle-exclamation {{$class}} mr-2"></i>
            @if(is_array($message))
                @foreach($message as $msg)
                    <span class="block text-left"> <i class="fa-solid text-[0.5rem] fa-circle mr-2"></i> {{ $msg }}</span>
                @endforeach
            @else
                <span>{{ $message }}</span>
            @endif
            <button type="button" class="block w-full tablet:max-w-[300px] mx-auto 
            border border-solid border-secondary py-2 px-4 mt-12" id="alert-close">
                Ok
            </button>
            {{-- <x-interactive.btn class="mt-4 block mx-auto" id="alert-close" type="button">
                ok
            </x-interactive.btn> --}}
        </div>
    </div>
@endif

{{-- 
<div class="{{$class}} shadow-lg rounded-2xl p-4 fixed 
desk:w-1/3 w-[95%] mx-auto top-1/3 left-1/2 -translate-x-1/2 Alert text-center
transition-opacity opacity-0 opacity-100 Alert z-10">
    <i class="fa-solid fa-circle-exclamation mb-4 text-xl"></i>
    @if(is_array($message))
        @foreach($message as $msg)
            <span class="block text-left"> <i class="fa-solid text-[0.5rem] fa-circle"></i> {{ $msg }}</span>
        @endforeach
    @else
        <span>{{ $message }}</span>
    @endif
    <button class="btn mt-4 block mx-auto" id="alert-close" type="button">
        ok
    </button>
</div> --}}