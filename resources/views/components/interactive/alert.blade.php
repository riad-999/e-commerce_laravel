@if(session('alert'))
    @php
        $alert = session('alert');
        $message = $alert->message;
        $class = '';
        if($alert->type === 'success') {
            $class="bg-green-400";
        }
        if($alert->type === 'error') {
            $class="bg-red-400";
        }
        if($alert->type === 'warning') {
            $class="bg-orange-400";
        }
    @endphp
    
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
    </div>
@endif