<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{asset('semantic/semantic.css')}}">
        <link rel="stylesheet" href="{{asset('semantic/calendar.css')}}">
        <link rel="stylesheet" href="{{asset('css/style-team.css')}}">
        <link rel="stylesheet" href="{{asset('css/leaflet.css')}}">
        <link rel="stylesheet" href="{{asset('css/leaflet.draw.css')}}">
        <link rel="shortcut icon" href="{{asset('css/images/favicon50.png')}}" type="image/png">
        <title>SFE</title>

    </head>
    <body ng-app="FastFootTeam">
        <div class="preloader-wrapper">
            <div class="preloader">
                <img src="css/images/accueil.gif">
            </div>
        </div>

        @include('team.navbar')
        
        @yield('content')
        

        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/angular.min.js')}}"></script>
        <script src="{{asset('js/angular-route.js')}}"></script>
        <script src="{{asset('semantic/semantic.min.js')}}"></script>
        <script src="{{asset('semantic/calendar.js')}}"></script>
        <script src="{{asset('js/leaflet.js')}}"></script>
        <script src="{{asset('js/leaflet.draw.js')}}"></script>
        <script src="{{asset('js/accuratePosition.js')}}"></script>
        <script src="{{asset('js/app-team.js')}}"></script>
    </body>
</html>

