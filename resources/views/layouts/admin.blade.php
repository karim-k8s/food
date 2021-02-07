<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{asset('semantic/semantic.css')}}">
        <link rel="stylesheet" href="{{asset('semantic/calendar.css')}}">
        <link rel="stylesheet" href="{{asset('css/style-admin.css')}}">
        <link rel="stylesheet" href="{{asset('css/leaflet.css')}}">
        <link rel="stylesheet" href="{{asset('css/leaflet.draw.css')}}">
        <link rel="shortcut icon" href="{{asset('css/images/favicon50.png')}}" type="image/png">
        <title>SFE</title>

    </head>
    <body ng-app='FastFoot'>

        
        @yield('content')
        
        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/angular.min.js')}}"></script>
        <script src="{{asset('js/angular-route.js')}}"></script>
        <script src="{{asset('semantic/semantic.min.js')}}"></script>
        <script src="{{asset('semantic/calendar.js')}}"></script>
        <script src="{{asset('js/leaflet.js')}}"></script>
        <script src="{{asset('js/leaflet.draw.js')}}"></script>
        <script src="{{asset('js/accuratePosition.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>



