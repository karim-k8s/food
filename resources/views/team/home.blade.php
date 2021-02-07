<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{asset('semantic/semantic.css')}}">
        <link rel="stylesheet" href="{{asset('semantic/calendar.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link rel="shortcut icon" href="{{asset('css/images/favicon50.png')}}" type="image/png">

        <title>Fast Foot</title>

    </head>
    <body ng-controller="homeController">
        
        <div style="background:black!important" class="ui large top fixed hidden inverted menu">
        <div style="background:black!important" class="ui container">
            <a class="active item">Acceuil</a>
            <a class="item">Terrains</a>
            <a class="item">Compétitions</a>
            <a class="item">Nos Tarifs</a>
            <div class="right item">
               
            </div>
        </div>
        </div>

        <!-- Sidebar Menu -->
        <div class="ui vertical inverted sidebar menu">
            <a class="active item">Acceuil</a>
            <a class="item">Terrains</a>
            <a class="item">Compétitions</a>
            <a class="item">Nos Tarifs</a>
            
        </div>


        <!-- Page Contents -->
        <div class="pusher">
        <div class="bgContainer"></div>
        <div style="background-color: transparent!important;" class="ui inverted vertical masthead center aligned segment">

            <div class="ui container">
            <div style="border:none!important;" class="ui large secondary inverted pointing menu">
                <a class="toc item">
                <i class="sidebar icon"></i>
                </a>
                <a class="active item">Acceuil</a>
                <a class="item">Terrains</a>
                <a class="item">Compétitions</a>
                <a class="item">Nos Tarifs</a>
                <div class="right item">    
                    <a class="ui inverted button">Connexion</a>
                    <a class="ui inverted button" >S'inscrire</a>
                </div>
            </div>
            </div>

            <div class="ui center aligned container">
                
                <h1 class="ui inverted header"></h1>
                <img class="ui huge centered image" src="/css/images/fastfoot.png">
            </div>

        </div>

        <div  style="background-color: white!important;" class="ui white vertical stripe segment">
            <div class="ui middle aligned stackable grid container">
            <div class="row">
                <div class="eight wide column">
                <h3 class="ui header">We Help Companies and Companions</h3>
                <p>We can give your company superpowers to do things that they never thought possible. Let us delight your customers and empower your needs...through pure data analytics.</p>
                <h3 class="ui header">We Make Bananas That Can Dance</h3>
                <p>Yes that's right, you thought it was the stuff of dreams, but even bananas can be bioengineered.</p>
                </div>
                <div class="six wide right floated column">
                <img src="assets/images/wireframe/white-image.png" class="ui large bordered rounded image">
                </div>
            </div>
            <div class="row">
                <div class="center aligned column">
                <a class="ui huge button">Check Them Out</a>
                </div>
            </div>
            </div>
        </div>


        <div style="background-color: white!important;" class="ui vertical stripe quote segment">
            <div class="ui equal width stackable internally celled grid">
            <div class="center aligned row">
                <div class="column">
                <h3>"What a Company"</h3>
                <p>That is what they all say about us</p>
                </div>
                <div class="column">
                <h3>"I shouldn't have gone with their competitor."</h3>
                <p>
                    <img src="assets/images/avatar/nan.jpg" class="ui avatar image"> <b>Nan</b> Chief Fun Officer Acme Toys
                </p>
                </div>
            </div>
            </div>
        </div>


        <div class="ui inverted vertical footer segment">
            <div class="ui container">
            <div class="ui stackable inverted divided equal height stackable grid">
                <div class="three wide column">
                <h4 class="ui inverted header">About</h4>
                <div class="ui inverted link list">
                    <a href="#" class="item">Sitemap</a>
                    <a href="#" class="item">Contact Us</a>
                    <a href="#" class="item">Religious Ceremonies</a>
                    <a href="#" class="item">Gazebo Plans</a>
                </div>
                </div>
                <div class="three wide column">
                <h4 class="ui inverted header">Services</h4>
                <div class="ui inverted link list">
                    <a href="#" class="item">Banana Pre-Order</a>
                    <a href="#" class="item">DNA FAQ</a>
                    <a href="#" class="item">How To Access</a>
                    <a href="#" class="item">Favorite X-Men</a>
                </div>
                </div>
                <div class="seven wide column">
                <h4 class="ui inverted header">Footer Header</h4>
                <p>Extra space for a call to action inside the footer that could help re-engage users.</p>
                </div>
            </div>
            </div>
        </div>
        </div>


        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/angular.min.js')}}"></script>
        <script src="{{asset('js/angular-route.js')}}"></script>
        <script src="{{asset('semantic/semantic.min.js')}}"></script>
        <script src="{{asset('semantic/calendar.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        
    </body>
</html>



