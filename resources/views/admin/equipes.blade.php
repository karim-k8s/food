@extends('admin.dashboard')

@section('dashcontent')

    <div ng-controller="eqController" class="ui center aligned container">

        <div class="ui right aligned container">
            <div style="margin-top:1em!important;" class="ui right aligned search">
                <div style="righ:10px!important" class="ui large icon input">
                    <input class="prompt" type="text" placeholder="Search Teams">
                    <i class="search icon"></i>
                </div>
            </div>
        </div>
        <div  style="margin-top:1em!important;" class="ui five special stackable cards">
            @foreach ($teams as $team)
                <div id="team{{$team->team_id}}" class="mainCard card">
                    <div class="content">
                        <h1 id="teamTitle" class="ui center aligned header">{{$team->team_name}}</h1>
                    </div>
                    <div  style="backrgound-color:transparent!important;" id='dimteam{{$team->team_id}}' class="blurring dimmable image">
                        <div class="ui dimmer">
                            @if($team->team_status != 'abos')
                                <div class="content">
                                    <h2 class="ui red icon header">
                                        <i class="times icon"></i>
                                        Non abonné
                                    </h2>
                                </div>
                            @else
                                <div class="ui raised left aligned fluid card">
                                    <div class="content">
                                        <div class="center aligned header">Abonnement</div>
                                        <br>
                                        <div class="description">
                                            Type : {{$team->typeab_name}}
                                            
                                        </div>
                                        <br>
                                        <div class="description">
                                            Début : {{$team->abn_start}}
                                        </div>
                                            <br>
                                        <div class="description">
                                            Fin : {{$team->abn_end}}
                                        </div>
                                            <br>
                                        <div class="description">
                                            Heures Restantes : {{$team->abn_remaininghours}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        
                    </div>
                    <div class="content">
                        <div class="meta">
                            <span class="date">Locale : {{$team->quartier_name_fr}}</span>
                        </div>
                        <div class="meta">
                            <span class="date">Email : {{$team->team_email}}</span>
                        </div>
                        <div class="meta">
                            <span class="phone">N° tel : {{$team->phone}}</span>
                        </div>
                        <div class="meta">
                            <span class="date">Crée le {{$team->team_joined}}</span>
                        </div>
                    </div>
                    <!--<div class="extra content">
                        <span>
                            <i class="olive futbol outline icon"></i>
                            {{$team->team_stat_win}}
                        </span>
                        <span>
                            <i class="futbol outline icon"></i>
                            {{$team->team_stat_lose}}
                        </span>
                        <span>
                            <i class="red futbol outline icon"></i>
                            {{$team->team_stat_draw}}
                        </span>
                        <span class="right floated">
                            <i class="yellow trophy icon"></i>
                            3
                        </span>
                    </div>-->
                </div>
            @endforeach
        </div>
    </div>
    
@endsection