<!DOCTYPE html>
<html>

    <head>
    
        <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" type="text/css" href="{{ elixir('css/app.css') }}">

        @include('layouts.partials_master.csrf')

    </head>

    <body>
        @include('layouts.partials_master.navbar')

        <div class="container">
            @yield('content')
        </div>

        @include('layouts.partials_master.footer')

        <script type="text/javascript" src="{{ elixir('js/app.js') }}"></script>
    </body>

</html>