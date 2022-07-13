@props(['title' => 'rezki e commerce'])

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }}</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="https://kit.fontawesome.com/1ef1b3e9cf.js" crossorigin="anonymous"></script>

        <script src="/js/events.js" defer></script>
    </head>
    <body class='font-body text-gray-600 relative'>
        <x-ui-elements.navbar/>
        <x-ui-elements.sidebar/>
        {{ $slot }}
    </body>
</html>
{{-- <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="/js/swiper.js"></script> --}}