<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Vacancy search</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>

    <body>
        <div id="app">
            @include('partials.navbar')

            <div class="container">
                @yield('content')
            </div>

            @include('partials.footer')
        </div>

        <script>
            var ALGOLIA_APP_ID = "{{ env('ALGOLIA_APP_ID') }}";
            var ALGOLIA_SEARCH_KEY = "{{ env('ALGOLIA_SEARCH_KEY') }}";
            var ALGOLIA_INDEX = "vacancies";
        </script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
