@extends("admin.dashboard")

@section('dashcontent')


    <div ng-controller="resController" class="ui center aligned container" id="resContainer">
        <div id="tabMenu" class="ui top attached tabular olive inverted two item pointing menu">
            <a class="item active" data-tab="first">
                <div class="ui tiny statistic">
                    <div class="value" style="color:white!important;">
                        <i class="map signs icon"></i>
                    </div>
                    <div class="label" style="color:white!important;">
                        Par Terrain
                    </div>
                </div>
            </a>
            <a class="item" data-tab="second">
                 <div class="ui tiny statistic">
                    <div class="value" style="color:white!important;">
                        <i class="users icon"></i>
                    </div>
                    <div class="label" style="color:white!important;">
                        Par Equipe
                    </div>
                </div>
            </a>
        </div>
        <div class="ui bottom attached tab segment active" data-tab="first">
            <div  style="margin-top:1em!important;" class="ui four special stackable cards">
                @foreach ($terrains as $terrain)
                    <div id="team{{$terrain->terrain_id}}" class="mainCard card">
                        <div class="center aligned content">
                            <div class="ui olive large header">
                                {{$terrain->terrain_name_fr}}
                            </div>
                            <div class=" meta">
                                {{$terrain->quartier_name_fr}}
                            </div>
                            <div class="description">
                                {{$terrain->terrain_email}}
                            </div>
                        </div>
                        <div class="extra content" onclick="showTerRes({{json_encode($terrain)}})">
                            <div class="ui basic green button">Reservations</div>
                        </div>
                    </div>
                @endforeach                
            </div>
        </div>

        <div class="ui bottom attached tab segment" data-tab="second">
            <div  style="margin-top:1em!important;" class="ui four special stackable cards">
            @foreach ($teams as $team)
                <div id="team{{$team->team_id}}" class="mainCard card">
                  
                    <div class="content">
                        <div class="ui center aligned olive header">
                            {{$team->team_name}}
                        </div>
                        <div class="description">
                            <span class="email"></span>{{$team->team_email}}
                        </div>
                    </div>
                    <div class="extra content">
                        <div onclick="showEqRes({{json_encode($team)}})" id="{{$team->team_id}}" class="ui basic green button">Reservations</div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>

        <div class="ui longer test modal" id="eqResModal" style="height:50%!important;">
            <div id="teamTitle" class="ui center aligned olive header">
            </div>
            <div class="scrolling image content" style="min-height:100%!important;">
                <div class="ui medium image">
                    <a id="eqQtName" class="ui ribbon label" autofocus="true" >
                    </a>
                    <a id="eqEmail" class="ui ribbon label" style="margin-top:30px!important">
                    </a>
                    <a id="eqPhone" class="ui ribbon label" style="margin-top:60px!important">
                    </a>
                    <img id="eqLogo"src="">
                </div>

                <div class="description" style="width:100%!important">
                    
                    <table class="ui very basic large table">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <div id="btnPrevDay" class="ui icon basic button">
                                        <i class="left chevron icon"></i>
                                    </div>
                                </th>
                                <th colspan="2" class="center aligned">
                                    <div id="eqResCalendar" class="ui calendar">
                                        <div class="ui transparent input">
                                            <input id="todayDate" type="text" placeholder="Selectinner une date">
                                        </div>
                                    </div>
                                </th>
                                <th colspan="2">
                                    <div id="btnNextDay" class="ui icon basic right floated button">
                                        <i class="right chevron icon"></i>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <div id="eqResList" class="ui divided items">
                    </div>
                </div>
            </div>
            <div class="actions">
                <div class="ui primary approve button">
                    <i class="remove icon"></i>
                    Fermer
                </div>
            </div>
        </div>

        <div class="ui longer test modal" id="terResModal" style="height:50%!important;">
                <div id="terTitle" class="ui center aligned olive header">
                </div>
                <div class="scrolling image content" style="min-height:100%!important;">
                    <div class="ui medium image">
                        <a id="terQtName" class="ui olive tiny ribbon label" autofocus="true" >
                        </a>
                        <a id="terEmail" class="ui olive tiny ribbon label" style="margin-top:25px!important">
                        </a>
                        <a id="terPhone" class="ui olive tiny ribbon label" style="margin-top:50px!important">
                        </a>
                        <div class="" id="miniMap">
                        </div>
                    </div>
    
                    <div class="description" style="width:100%!important">
                        
                        <table class="ui very basic large table">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <div id="btnPrevDayTer" class="ui icon basic button">
                                            <i class="left chevron icon"></i>
                                        </div>
                                    </th>
                                    <th colspan="2" class="center aligned">
                                        <div id="terResCalendar" class="ui calendar">
                                            <div class="ui transparent input">
                                                <input id="todayDate" type="text" placeholder="Selectionner une date">
                                            </div>
                                        </div>
                                    </th>
                                    <th colspan="2">
                                        <div id="btnNextDayTer" class="ui icon basic right floated button">
                                            <i class="right chevron icon"></i>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div id="terResList" class="ui divided items">
                        </div>
                    </div>
                </div>
                <div class="actions">
                    <div class="ui primary approve button">
                        <i class="remove icon"></i>
                        Fermer
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
    </div>

@endsection