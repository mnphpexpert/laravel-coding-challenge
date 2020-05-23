<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Coding Challenger</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <script defer src="https://use.fontawesome.com/releases/v5.13.0/js/all.js"></script>
    </head>
    <body>

        <div id="app">

            <activity-logs :resource="{{ named_route_info_json('api.activity-logs.index') }}"></activity-logs>

        </div>


        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
