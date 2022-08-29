{{-- <div {{$attributes->merge([
    'class' => "shadow-lg bg-white rounded-2xl p-4 
    fixed border border-solid border-gray-400
    w-[95%] mx-auto tablet:max-w-[550px] 
    mx-auto top-[20%] left-1/2 -translate-x-1/2 invisible
    text-center transition-opacity duration-300 opacity-0 z-10"
])}}>
    {{$slot}}
</div> --}}

<div {{$attributes->merge([
    'class' => "fixed inset-0 bg-black bg-opacity-20 invisible opacity-0 transition-opacity duration-300"
])}}>
    <div class="bg-white p-4 absolute
    border border-solid border-secondary
    w-[95%] mx-auto tablet:max-w-[550px] 
    top-[30%] left-1/2 -translate-x-1/2
    text-center z-100">
        {{$slot}}
    </div>
</div>