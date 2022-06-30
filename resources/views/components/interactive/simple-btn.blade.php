@props(['black' => true, 'big' => false])

<button {{ $attributes->class(['text-xl', 'text-2xl' => $big ,'text-secondary' => $black])}}>{{ $slot }}</button>