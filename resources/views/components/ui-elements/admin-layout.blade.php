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
        {{-- <x-ui-elements.navbar /> --}}
        <x-interactive.alert />
        <div class="desk:grid grid-cols-6 gap-8">
            <x-ui-elements.admin-sidebar />
            <main class="col-span-5 pt-8">
                {{$slot}}
            </main>
        </div>
    </body>
</html>
<script src="/js/events.js"></script>