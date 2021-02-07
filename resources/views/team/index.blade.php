@extends('layouts.team')


<div class="bgContainer"></div>
@section('content')

  <div id="mainContainer" ng-controller="indexController" class="ui center aligned container">
    <div id="intro">
        <div>
            @if((session('role')=='team') && session('email'))
                <br>
                <h1 id="teamTitle" class="ui huge olive header" style="font-family:f2!important;font-size:4em;">
                    {{$team->team_name}}
                </h1>
                <br>
                <div class="ui stackable two column grid">
                    <div class="row">
                        <div class="six wide column">
                            <div class="ui medium centered rounded image">
                                <!--<a class="ui olive ribbon large fluid label">{{$team->team_name}}</a>-->
                                <img  src="/storage/eqLogos/{{$team->logo}}" alt="">
                            </div>                    
                        </div>
                        <div id="teamDetails" class="ten wide column">
                            <div class="ui small horizontal inverted statistics">
                                <div class="statistic">
                                    <div class="value">
                                        <i class="envelope olive icon"></i> 
                                    </div>
                                    <div class="label">
                                        Email : {{$team->team_email}}
                                    </div>
                                </div>
                                <div class="statistic">
                                    <div class="value">
                                        <i class="phone olive icon"></i> 
                                    </div>
                                    <div class="label">
                                        N° Tel : {{$team->phone}}
                                    </div>
                                </div>
                                <div class="statistic">
                                    <div class="value">
                                        <i class="map signs olive icon"></i> 
                                    </div>
                                    <div class="label">
                                        Quartier : {{$team->quartier_name_fr}}
                                    </div>
                                </div>
                                <div class="statistic">
                                    <div class="value">
                                        <i class="calendar alternate olive icon"></i> 
                                    </div>
                                    <div class="label">
                                        Ajouté le : {{$team->team_joined}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="sixteen wide column">
                            <div class="ui olive raised segment">
                                <br>
                                <div class="ui four columns stackable grid">
                                    <div class="four wide column">
                                        <div class="ui olive statistic">
                                            <div class="value">
                                                {{$teamStats['matches']}}
                                            </div>
                                            <div class="label">
                                                Matches Joués
                                            </div>
                                        </div>
                                    </div>
                                    <div class="four wide column">
                                        <div class="ui olive statistic">
                                            <div class="value">
                                                {{$teamStats['entrainements']}}
                                            </div>
                                            <div class="label">
                                                Sessions d'entrainement
                                            </div>
                                        </div>
                                    </div>
                                    <div class="four wide column">
                                        <div class="ui olive statistic">
                                            <div class="value">
                                                {{$teamStats['abns']}}
                                            </div>
                                            <div class="label">
                                                Abonnements
                                            </div>
                                        </div>
                                    </div>
                                    <div class="four wide column">
                                        @if ($teamStats['favTerrain'])
                                            <div class="ui olive statistic">
                                                <div class="text value">
                                                    {{$teamStats['favTerrain']}}
                                                </div>
                                                <div class="label">
                                                    Terrain Favoris
                                                </div>
                                            </div>
                                        @else
                                            <div class="ui olive statistic">
                                                <div class="value">
                                                    <i class="remove icon"></i>
                                                </div>
                                                <div class="label">
                                                    Terrain Favoris
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <br><br><br>
                                <div class="ui three columns stackable center aligned grid">
                                    <div class="row">
                                        <div class="three wide column">
                                            <div class="ui floating circular red label">{{$accepts}}</div>
                                            <div id="btnShowAccepts" class="ui animated fade olive fluid button">
                                                <div class="hidden content">Acceptation</div>
                                                <div class="visible content">
                                                    <i class="large check icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="three wide column">
                                            <div class="ui floating circular red label">{{$invits}}</div>
                                            <div id="btnShowInvits" class="ui animated fade olive fluid button">
                                                <div class="hidden content">Invitations</div>
                                                <div class="visible content">
                                                    <i class="large flag checkered icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="three wide column">
                                            <div class="ui floating circular red label">{{$comps}}</div>
                                            <div id="btnShowCurrComps" class="ui animated fade olive fluid button">
                                                <div class="hidden content">Compétitions en cours</div>
                                                <div class="visible content">
                                                    <i class="large icons">
                                                        <i class="trophy icon"></i>
                                                        <i class="inverted corner sync icon"></i>
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="three wide column">
                                            <div id="btnAddComp" class="ui animated fade olive fluid button">
                                                <div class="hidden content">Organisez une compétition</div>
                                                <div class="visible content">
                                                    <i class="large icons">
                                                        <i class="trophy icon"></i>
                                                        <i class="inverted corner add icon"></i>
                                                    </i>
                                                </div>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="ui centered big image">
                    <img class="" src="css/images/logoMod2.png" alt="">
                </div>
                <div class="ui segment presentSeg">
                        <h1 class="ui olive big header" style="font-family:f2!important; margin-top:25px!important;font-size:3em">Jouons Au Foot Ensemble</h1>
                        <h4>jouer au football n'importe quand, n'importe où.</h4><br>

                    <div class="ui center aligned container">
                        <div class="ui four stackable fluid columns grid">
                            <div class="fluid row">
                                <div class="four wide column">
                                    <img class="ui centered tiny image" src="css/images/tshirtFoot.png">
                                    <h5>Créez Votre Equipe</h5>
                                    <p>créez votre équipe et commencez à rivaliser avec d'autres équipes</p>
                                </div>
                                <div class="four wide column">
                                    <img class="ui centered tiny image" src="css/images/terrain.png">
                                    <h5>Cherchez un Terrains</h5>
                                    <p>sélectionnez un des nombreux champs disponibles dans tous les quartiers de casablanca</p>
                                </div>
                                <div class="four wide column">
                                    <img class="ui centered tiny image" src="css/images/match.png">
                                    <h5>Plannifiez des Matches</h5>
                                    <p>choisissez la date et l'heure, choisissez votre adversaire et planifiez un match</p>
                                </div>
                                <div class="four wide column">
                                    <img class="ui centered tiny image" src="css/images/trophee.png">
                                    <h5>Organisez des Compétitions</h5>
                                    <p>créer un événement et inviter d'autres équipes à rejoindre ou rejoindre un événement déjà en cours</p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <button id="btnSignup2" style="margin-bottom:25px!important;margin-top:30px!important" class="ui large olive button">
                            Inscrivez-vous gratuitement
                        </button>
                    </div>
                    

                </div>
            @endif
        </div>
    </div>
    <div ng-controller="terSectController" style="background-color: transparent!important;" class="ui white vertical stripe center aligned  segment" id="terResSection">
        <div id="searchBar">
            <div class="ui stackable grid" style="margin-bottom:5px!important;margin-top:5px!important;">
                <div class="one column row">
                <div class="sixteen wide column">
                        <h1 class="ui centered inverted header" style="font-family:f2!important;">Trouver un terrain de football près de chez vous</h1>
                </div>
                </div>
            </div>
            <div id="searchElts">
                <div hidden style="display:none!important">
                    <div id="searchInputsDiv" class="ui stackable grid" style="margin-bottom:10px!important;margin-top:5px!important;z-index:auto!important;" >   
                        <div class="four columns row">
                            <div class="column">

                            </div>
                            <div class="column">
                                <select id="qtNames" class="ui search fluid dropdown">
                                    <option value="">Quartier</option>
                                </select>
                            </div>

                            <div class="column">
                                <div id="resCalendar" class="ui calendar">
                                    <div class="ui left icon fluid input">
                                        <input id="todayDate" type="text" placeholder="Selectinner une date">
                                        <i class="calendar alternate outline icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div onclick="changeToSearch()" class="column">
                                <i id="closeSearchBtn" class="close circular link icon" style="color:white!important;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="searchDiv" class="ui stackable grid" style="margin-bottom:20px!important;margin-top:5px!important;">
                    <div class="three columns row">
                        <div class="column"></div>

                        <div class="column">
                            <div style="color: white" class="ui transparent inverted icon fluid input">
                                <input onclick="changeToInputs()" type="text" placeholder="Recherecher une reservation">
                                <i class="search icon"></i>
                            </div>
                        </div>
                        <div class="column"></div>
                    </div>
                </div>
            </div>
        </div>

        
        <div id="mainMap">
            <div id="mapDimmer" class="ui inverted dimmer">
                <div class="ui olive loader"></div>
            </div>
            <div id="mapButtons" class="leaflet-bottom leaflet-left">
                <div class="leaflet-bar leaflet-control">
                    <button id="geolocate" class="small circular olive ui icon button">
                        <i class="map marker alternate icon"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div ng-controller="abnSectController" style="background-color: transparent!important;" class="ui vertical stripe quote segment" id="abnSection">
        
        <div class="ui segment" style="background-color: transparent!important;"> 
            
            @if((session('role')=='team') && session('email'))
                <h1 class="ui centered inverted header" style="font-family:f2!important;margin-bottom:20px!important;margin-top:3em!important;">Mon Abonnement</h1><br><br>
                <div class="ui four stackable columns grid">
                    <div class="row">
                        <div class="eight wide column">
                            <div class="ui big left aligned fluid label">
                                <i class="hourglass start olive icon"></i> 
                                Debut : 
                                <div class="detail">{{$abnInfo->abn_start}}</div>
                            </div><br><br>
                            @php
                                $date = new DateTime($abnInfo->abn_end);
                                $now = new DateTime();

                                $dateDiff = $date->diff($now)->format("%d");

                                if($dateDiff <= 7){
                                    echo '<div class="ui big left aligned red fluid label">';
                                }else{
                                    echo '<div class="ui big left aligned fluid label">';
                                }
                            @endphp
                                <i class="hourglass end olive icon"></i> 
                                Fin : 
                                <div class="detail">{{$abnInfo->abn_end}}</div>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <div class="ui big left aligned fluid label">
                                <i class="credit card outline olive icon"></i> 
                                Type : 
                                <div class="detail">{{$abnInfo->typeab_name}}</div>
                            </div><br><br>
                            @if ($abnInfo->abn_remaininghours <= 3 )
                                <div class="ui big left aligned red fluid label">
                            @else
                                <div class="ui big left aligned fluid label">
                            @endif
                                <i class="stopwatch olive icon"></i> 
                                Heures restantes : 
                                <div class="detail">{{$abnInfo->abn_remaininghours}}</div>
                            </div><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="five wide column"></div>
                        <div class="six wide column">
                                @if ($abnInfo->typeab_id==5)
                                    <button id="newAbnBtn" class="ui olive labeled fluid icon big button"><i class="credit card outline icon"></i>  S'abonner</button>
                                @else
                                    @if ($abnInfo->abn_remaininghours <= 3 || $dateDiff <= 7)
                                        <button id="reAbnBtn" class="ui olive labeled icon big fluid button"><i class="sync icon"></i>  Renouveler mon abonnement</button>
                                    @endif         
                                @endif
                        </div>
                        <div class="five wide column"></div>
                    </div>
                </div>

            @else
                <h1 class="ui centered inverted header" style="font-family:f2!important;margin-bottom:20px!important;margin-top:3em!important;">Abonnements</h1>
                <div class="ui stackable grid" style="margin-bottom:5px!important;margin-top:5px!important;">
                    <div class="four columns row">
                        @foreach ($abnTypes as  $abType)
                        @if($abType->typeab_name !== 'Version local')
                            <div class="column">
                                <div class="ui raised olive fluid segment" style="">
                                    <img class="ui small centered fluid image" src="css/images/t{{$abType->typeab_id}}.png">
                                    <h3 class="ui center aligned olive header" style="font-family:f2!important;">{{$abType->typeab_name}}</h3>
                                    <div class="ui fluid olive large label">
                                        {{$abType->typeab_duration}} Jours
                                    </div><br><br>
                                    <div class="ui fluid olive large label">
                                        {{$abType->typerab_hoursamount}} Heures
                                    </div><br><br>
                                    <div class="ui fluid olive large label">
                                        {{$abType->typeab_price}} USD
                                    </div><br><br><br><br>
                                    <div class="ui subLabel large bottom attached label">
                                        <a>Commencez gratuitement</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
            
        </div>
    </div>

    <div class="ui inverted vertical footer segment" id="contactusSection">
        
        <div class="ui container">   
            <div class="ui stackable inverted equal width stackable grid">
                <div class="column">
                    <h3 class="ui inverted header" style="font-family:f2!important;margin-top:10px!important">Contactez nous</h3><br>
                    <i onclick="window.open('https://facebook.com/','_blank');" style="/*color:#3B5998!important*/" class="big facebook link icon"></i>
                    <i onclick="window.open('https://instagram.com/','_blank');" style="/*color:#cd486b!important*/" class="big instagram link icon"></i>
                    <i onclick="window.open('https://twitter.com/','_blank');" style="/*color:#1dcaff!important" class="big twitter link icon"></i>
                </div>
                <div class="column">
                    <a class="ui medium image">
                        <img src="css/images/logoMod2.png" alt="">
                    </a>
                </div>
                <div class="column">
                    <h3 class="ui inverted header" style="font-family:f2!important;margin-top:10px!important">App bientot disponible</h3><br>
                    <img src="css/images/footer-appstore.png" alt="">
                    <img src="css/images/footer-googleplay.png" alt="">
                    <!--<i class="big google play icon"></i>
                    <i class="big app store icon"></i>-->
                </div>
            </div>
            FastFoot 2020  <i class="copyright outline icon"></i> Created by: Dahour tarik & Fahmi anouar
        </div>
    </div>


    <div style="overflow:hidden!important;" class="ui top sidebar segment overlay">
        <div class="ui page center aligned grid">
            <div class="one column row">
                <h3 class="ui center aligned olive huge header" id="terName_fr">
            </div>
            <div class="one column row">
                <div class="sixteen wide column">
                    <div class="ui three mini statistics">
                        <div class="statistic">
                            <div class="value">
                                <i class="envelope outline olive icon"></i>
                            </div>
                            <div class="label" id="terEmail">
                            </div>
                        </div>
                        <div class="statistic">
                            <div class="value">
                                <i class="phone olive icon"></i>
                            </div>
                            <div class="label" id="terPhone">
                            </div>
                        </div>
                        <div class="statistic">
                            <div class="value">
                                <i class="map signs olive icon"></i>
                            </div>
                            <div class="label" id="terQt">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="one column row">
                <div class="sixteen wide column">
                    @if((session('role')=='team') && session('email'))
                        <button id="resTerrBtn" class="ui labeled icon olive button">
                            <i class="calendar check outline icon"></i>
                            Reserver ce terrain
                        </button>
                    @else
                        <button id="btnSignupRedir" class="ui labeled icon olive button">
                            <i class="calendar check outline icon"></i>
                            Reserver ce terrain
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="loginModal" style="background:rgba(0,0,0,0)!important;" class="ui mini modal">
        <i class="close icon btnCloseModal"></i>
        <img class="ui centered small image" src="css/images/logomod3.png" alt="">

        <div class="ui top attached two buttons menu" style="background:rgba(0,0,0,0)!important;">

          <button class="ui active button" data-tab="first" id="btnCnxTab">Connexion</button>
          <button class="ui button" data-tab="second" id="btnSigninTab">S'inscrire</button>

        </div>
        <div id="loginTab" class="ui bottom attached tab segment active" data-tab="first">
            <br><br>
            <div class="ui grid">
                <div class="one column row">
                  <div class="sixteen wide column">
                      <h3 class="ui header"><i class="envelope olive icon"></i> Email :</h3>
                      <div class="ui fluid input">
                        <input id="loginEmail" type="email" placeholder="Email" required>
                      </div>
                  </div>
                </div>
                <div class="one column row">
                  <div class="sixteen wide column">
                      <h3 class="ui header"><i class="lock olive icon"></i> Mot de passe :</h3>
                      <div class="ui fluid input">
                        <input id="loginPwd" type="password" placeholder="Mot de passe" required>
                      </div>
                  </div>
                </div>
            </div> <br><br>
            
            <div id="btnLogIn" class="ui olive fluid button">
                <i class="unlock alternate icon"></i> Connexion
            </div>
            
        </div>

        <div id="signupTab" class="ui bottom attached tab segment" data-tab="second">
            <br><br>
            <div class="ui grid" style="overflow-y: auto!important">
                <div class="one column row">
                  <div class="sixteen wide column">
                      <h4 class="ui header"><i class="address card olive icon"></i> Nom d'equipe :</h4>
                      <div class="ui fluid input">
                        <input id="signupName" type="text" placeholder="Nom d'equipe" required>
                      </div>
                  </div>
                </div>
                <div class="one column row">
                  <div class="sixteen wide column">
                      <h4 class="ui header"><i class="envelope olive icon"></i> Email :</h4>
                      <div class="ui fluid input">
                        <input id="signupEmail" type="email" placeholder="Email" required>
                      </div>
                  </div>
                </div>
                
                <div class="one column row">
                  <div class="sixteen wide column">
                      <h4 class="ui header"><i class="hashtag olive icon"></i> Mot de passe :</h4>
                      <div class="ui fluid input">
                        <input id="signupPwd" type="password" placeholder="Mot de passe" required>
                      </div>
                  </div>
                </div>
            </div> <br><br>
            
            <div id="btnContinueSignUp"  class="ui olive fluid button">
                 S'inscrire  <i class="arrow right icon"></i>
            </div>
        </div>
    </div>

    <div id="finishSignUpModal" style="background:rgba(0,0,0,0)!important;" class="ui mini modal">
        <i class="close icon btnCloseModal"></i>
        <img class="ui centered small image" src="css/images/logomod3.png" alt="">
        <h4 class="ui center aligned header"  style="background:rgba(0,0,0,0)!important;color:white!important;">
            Completez Votre Profil
        </h4>
        <div class="content">
            <div class="ui grid">
                <div class="one column row">
                    <div class="sixteen wide column">
                        <h4 class="ui header"><i class="phone olive icon"></i> N° tel :</h4>
                        <div class="ui fluid input">
                            <input id="signupPhone" type="tel" placeholder="N° tel" required>
                        </div>
                    </div>
                </div>
              
                <div class="one column row">
                    <div class="sixteen wide column">
                        <h4 class="ui header"><i class="map signs olive icon"></i>Selectionnez votre quartier :</h4>
                        <div id='qtDropdown' class="ui selection fluid dropdown">
                            <input type="hidden" id="signupQt">
                            <i class="dropdown icon"></i>
                            <div class="default text">Quartier</div>
                            <div class="menu">
                                @foreach ($qts as $qt )
                                    <div class="item" data-value="{{$qt->quartier_id}}">{{$qt->quartier_name_fr}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="one column row">
                    <div class="sixteen wide column">
                        <h4 class="ui header"><i class="map signs olive icon"></i>Votre statut :</h4>
                        <div id='stDropdown' class="ui selection fluid dropdown">
                            <input type="hidden" id="signupSt">
                            <i class="dropdown icon"></i>
                            <div class="default text">Autre</div>
                            <div class="menu">
                                    <div class="item" data-value="enseignant">Enseignant</div>
                                    <div class="item" data-value="etudiant">Etudiant</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ui two bottom attached buttons">
           <button id="btnReturnToLogin"  class="ui button">
                <i class="arrow left icon"></i>  Retour
            </button>
            <button id="btnSignUp"  class="ui olive button">
                <i class="checkmark icon"></i> S'inscrire
            </button>
        </div>
        
        
    </div>

    
    <div id="cinModal" style="background:rgba(0,0,0,0)!important;" class="ui mini modal">
    <i class="close icon btnCloseModal"></i>
        <img class="ui centered small image" src="css/images/logomod3.png" alt="">
        <h4 class="ui center aligned header"  style="background:rgba(0,0,0,0)!important;color:white!important;">
            Tapez votre CIN
        </h4>
  <div class="content">
  <div class="ui grid">
                <div class="one column row">
                    <div class="sixteen wide column">
                        <h4 class="ui header"><i class="check olive icon"></i> CIN :</h4>
                        <div class="ui fluid input">
                            <input id="cin" type="text" placeholder="CIN" required>
                        </div>
                    </div>
                </div>

            </div>
  </div>
  <div class="actions">
    <div id="btnCheckCin" class="ui approve button">Valider</div>
    
  </div>
</div>

    @if((session('role')=='team') && session('email'))
        <div id="editTeamModal" style="background:rgba(0,0,0,0)!important;" class="ui mini modal">
            <img class="ui centered small image" src="css/images/logomod3.png" alt="">
            <h4 class="ui center aligned header"  style="background:rgba(0,0,0,0)!important;color:white!important;">
                Modifier Votre Profil
            </h4>
            <div class="content">
                <div class="ui grid">
                    <div class="one column row">
                        <div class="sixteen wide column">
                            <h4 class="ui header"><i class="address card olive icon"></i> Nom d'equipe :</h4>
                            <div class="ui fluid input">
                                <input id="editTeamName" value="{{$team->team_name}}" type="text" placeholder="Nom d'equipe" required>
                            </div>
                        </div>
                    </div>
                    <div class="one column row">
                        <div class="sixteen wide column">
                            <h4 class="ui header"><i class="phone olive icon"></i> N° tel :</h4>
                            <div class="ui fluid input">
                                <input id="editTeamPhone" value="{{$team->phone}}" type="tel" placeholder="N° tel" required>
                            </div>
                        </div>
                    </div>
                    
                   

                    <div class="one column row">
                        <div class="sixteen wide column">
                            <h4 class="ui header"><i class="map signs olive icon"></i>Selectionnez votre quartier :</h4>
                            <div id='editTeamqtDropdown' class="ui selection fluid dropdown">
                                <input type="hidden" id="editTeamQt" value="{{$team->quartier_id}}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Quartier</div>
                                <div class="menu">
                                    @foreach ($qts as $qt )

                                        @if ($team->quartier_id == $qt->quartier_id)
                                            <div class="item active selected" data-value="{{$qt->quartier_id}}">{{$qt->quartier_name_fr}}</div>
                                        @else
                                            <div class="item" data-value="{{$qt->quartier_id}}">{{$qt->quartier_name_fr}}</div>
                                        @endif
                                        
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="one column row">
                        <div class="sixteen wide column">
                            <h4 class="ui header"><i class="lock olive icon"></i> Mot de passe :</h4>
                            <div class="ui fluid input">
                                <input id="editTeamPwd" type="password" placeholder="Mot de passe" required>
                            </div>
                        </div>
                    </div>
                    <div class="two stackable columns row">
                        <div class="eight wide center aligned column">
                            <button id="btnEditTeam" class="ui labeled icon olive fluid button">
                                <i class="edit icon"></i>
                                Modifier
                            </button>
                        </div>
                        <div class="eight wide column">
                            <button id="btnCancelEditTeam" class="ui right labeled icon fluid button">
                                Annuler
                                <i class="remove icon"></i>
                            </button>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    @endif

    <div id="terrPlanningModal" class="ui modal" style="min-height:50%!important;">
        <div id="terrName" class="ui center aligned olive large header">
            
        </div>
        <div class="ui grid" style="width:100%!important;margin:5px!important;">
            <div class="one column row">
                <div class="sixteen wide column">
                   
                    <div class="ui center aligned grid" >
                        <div class="three columns row">
                            <div class="column">
                                <div id="btnPrevDay" class="ui icon basic button">
                                    <i class="left chevron icon"></i>
                                </div>
                            </div>
                            <div class="column">
                                <div id="resTerCalendar" class="ui calendar">
                                    <div class="ui transparent input">
                                        <input type="text" placeholder="Selectinner une date">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div id="btnNextDay" class="ui icon basic button">
                                    <i class="right chevron icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui divider"></div>
                    <div id="resHours" class="ui center aligned internally celled grid" style="width:100%!important;">
                        
                    </div>
                    <div class="ui divider"></div>
                    
                </div>
            </div>
        </div>

        <div class="actions">
            <div class="ui cancel icon button">
                <i class="remove icon"></i>Fermer
            </div>
        </div>

    </div>

    <div id="completeResModal" class="ui mini modal">

        <div id="resModalTitle" class="ui center aligned olive header">
             
        </div>

        <div class="content">
            @if((session('role')=='team') && session('email'))
                <div class="ui grid">
                    <div class="one column row">
                        <div class="sixteen wide column">
                            <h3 class="ui header"><i class="calendar check outline olive icon"></i> Type de reservation :</h3>
                            <select id="typeResList" class="ui search fluid dropdown">
                                <option value="">Type De reservation</option>
                                @foreach ($typeRes as $tr)
                                    <option value="{{$tr->typeres_id}}">{{$tr->typeres_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="one column row">
                        <div class="sixteen wide column">
                            <h3 class="ui header"><i class="hourglass start olive icon"></i> Debut :</h3>
                            <div id="resStartLabel" style="text-align:center!important"class="ui basic large fluid label"></div>
                        </div>
                    </div>
                    <div class="one column row">
                        <div class="sixteen wide column">
                            <h3 class="ui header"><i class="hourglass end olive icon"></i> Fin :</h3>
                            <div id="resEndLabel" style="text-align:center!important"class="ui basic large fluid label"></div>
                        </div>
                    </div>
                    <div class="one column row">
                        <div class="sixteen wide column">
                            <h3 class="ui header"><i class="user plus olive icon"></i> Inviter une equipe :</h3>
                            <select id="invTeam" class="ui search fluid dropdown">
                                <option value="">Equipe</option>
                                @foreach ($teams as $tm)
                                    <option value="{{$tm->team_id}}">{{$tm->team_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div> <br>
            @endif
            
            
        </div>

        <div class="actions">
            <div id="btnApprove" class="ui approve icon olive button">
                <i class="checkmark icon"></i>Reserver
            </div>
            <div class="ui deny icon button">
                <i class="remove icon"></i>Annuler
            </div>
        </div>

    </div>


     <div id="warningModal" class="ui tiny basic modal">
        <div id="alertMessage" class="ui icon header">
        </div>
        <div class="actions">
            <div class="ui ok inverted button">
                <i class="checkmark icon"></i>
                OK
            </div>
        </div>
    </div>

    <div id="confCancelResModal" class="ui tiny basic modal">
        <div class="ui icon header">
            <i class="trash icon"></i>
            Annuler la reservation
        </div>
        <div class="content">
            <p>Etes vous sure de vouloir annuler cette reservation?</p>
        </div>
        <div class="actions">
            <div class="ui basic cancel inverted button">
                <i class="remove icon"></i>
                Non
            </div>
            <div class="ui red ok inverted button">
                <i class="checkmark icon"></i>
                Oui
            </div>
        </div>
    </div>

    <div id="confCancelInvModal" class="ui tiny basic modal">
        <div class="ui icon header">
            <i class="trash icon"></i>
            Annuler l'invitation
        </div>
        <div class="content">
            <p>Etes vous sure de vouloir annuler cette invitation?</p>
        </div>
        <div class="actions">
            <div class="ui basic cancel inverted button">
                <i class="remove icon"></i>
                Non
            </div>
            <div class="ui red ok inverted button">
                <i class="checkmark icon"></i>
                Oui
            </div>
        </div>
    </div>
    <div id="confApprovInvModal" class="ui tiny basic modal">
        <div class="ui icon header">
            <i class="check icon"></i>
            Accepter l'invitation
        </div>
        <div class="content">
            <p>Etes vous sure de vouloir accepter cette invitation?</p>
        </div>
        <div class="actions">
            <div class="ui basic cancel inverted button">
                <i class="remove icon"></i>
                Non
            </div>
            <div class="ui green ok inverted button">
                <i class="checkmark icon"></i>
                Oui
            </div>
        </div>
    </div>

    <div id="abnModal" class="ui mini modal">

        <div id="abnModalTitle" class="ui center aligned olive big header">
             
        </div>

        <div class="content">
            @if((session('role')=='team') && session('email'))
                <div class="ui grid">
                    <div class="one column row">
                        <div class="sixteen wide column">
                            <h3 class="ui header"><i class="credit card outline olive icon"></i> Type d'abonnement :</h3>
                            <select id="nvAbnType" class="ui search fluid dropdown" onchange ="showAbnInfo(this.selectedOptions[0])">
                                <option value="">Type</option>
                                @foreach ($abnTypes as $abT)
                                @if($abT->typeab_name !== 'Version local')
                                    <option value="{{$abT->typeab_id}}" abnInfo="{{$abT->typeab_duration}},{{$abT->typerab_hoursamount}},{{$abT->typeab_price}}">{{$abT->typeab_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="one column row">
                        <div class="sixteen wide center aligned column">
                            <div id="abnMonths" class="ui fluid center aligned olive hidden large label"></div>
                        </div>
                    </div>
                    <div class="one column row">
                        <div class="sixteen wide center aligned column">
                            <div id="abnHours" class="ui fluid center aligned olive hidden large label"></div>
                        </div>
                    </div>
                    <div class="one column row">
                        <div class="sixteen wide center aligned column">
                            <div id="abnPrice" class="ui fluid center aligned olive hidden large label"></div>
                        </div>
                    </div> 
                </div> <br>
            @endif
            
            
        </div>

        <div class="actions">
            <div class="two buttons">
                <div id="btnApprovePay" class="ui approve icon facebook labeled button">
                    <i class="paypal icon"></i>Confirmer
                </div>
                <div id="btnCancelPay" class="ui deny icon labeled button">
                    <i class="remove icon"></i>Annuler
                </div>
            </div>
        </div>

    </div>
    
    <div id="invitsModal" class="ui small modal">
        <div class="ui center aligned olive header">
             Invitations
        </div>

        <div class="content">
                <div class="ui grid">
                    <div class="one column row">
                        <div class="sixteen wide column">
                            
                        </div>
                    </div>
                    
                </div> <br>
                @if (session('email') && session('role')=='team')
                    <div id="invList" class="ui divided items">
                    </div>
                
                @endif
        </div>

        
        <div class="actions">
            
            <div class="ui deny icon button">
                <i class="remove icon"></i>Annuler
            </div>
        </div>
    </div>
  </div>

@endsection