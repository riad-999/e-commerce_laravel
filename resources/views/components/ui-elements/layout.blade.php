@props(['title' => 'rezki e commerce', 'fixedw' => true])

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }}</title>
        <link rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="https://kit.fontawesome.com/1ef1b3e9cf.js" crossorigin="anonymous"></script>
    </head>
    <body {{$attributes->merge(['class' => 'font-body text-gray-600 relative'])}}>
        <x-ui-elements.navbar/>
        <x-ui-elements.sidebar/>
        <x-interactive.alert />
        <main class="{{$fixedw ? 'max-w-[1400px]' : ''}} mx-auto">
            {{ $slot }}
        </main>
    </body>
</html>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="/js/utils.js"></script>
<script src="/js/events.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="/js/swiper.js"></script>