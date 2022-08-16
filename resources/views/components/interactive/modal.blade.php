<div {{$attributes->merge([
    'class' => "shadow-lg bg-white rounded-2xl p-4 
    fixed border border-solid border-gray-400
    w-[95%] mx-auto tablet:max-w-[550px] 
    mx-auto top-[20%] left-1/2 -translate-x-1/2 invisible
    text-center transition-opacity duration-300 opacity-0 z-10"
])}}>
    {{$slot}}
</div>