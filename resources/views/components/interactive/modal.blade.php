<div {{$attributes->merge([
    'class' => "shadow-lg bg-white rounded-2xl p-4 fixed border border-solid border-gray-400
    w-[95%] mx-auto desk:w-1/3 mx-auto top-1/3 left-1/2 -translate-x-1/2 Alert text-center 
    transition-opacity opacity-0 z-10 invisible"
])}}>
    {{$slot}}
</div>