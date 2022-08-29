@props(['title' => 'rezki e commerce'])

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }}</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="https://kit.fontawesome.com/1ef1b3e9cf.js" crossorigin="anonymous"></script>
    </head>
    <body {{$attributes->merge(['class' => 'font-body text-gray-600 relative bg-gray-100'])}}>
        <x-interactive.alert />
        <div class="desk:flex">
            <x-ui-elements.admin-sidebar />
            <x-ui-elements.sidebar/>
            <main class="w-full">
                <x-ui-elements.admin-navbar />
                <div class="desk:ml-4">
                    {{$slot}}
                </div> 
            </main>
        </div>
    </body>
</html>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="/js/utils.js"></script>
<script src="/js/events.js"></script>