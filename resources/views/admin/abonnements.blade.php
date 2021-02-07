@extends("admin.dashboard")

@section('dashcontent')

    <div ng-controller="abController" class="ui container">

         <div class="ui center aligned content" style="margin-top:10px!important">
            <div class="ui grid">
                <div class="three stackable equal width columns row">
                    <div class="column"></div>
                    <div class="column">
                        <select id='abnTeamId' class="ui fluid large search dropdown">
                            <option value="">Equipes</option>
                            @foreach ($teams as $team )
                                <option value="{{$team->team_id}}">{{$team->team_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="column">
                        <button id="findAbnBtn" class="ui left floated large olive icon button">
                            <i class="search icon"></i>
                        </button>
                        <button id="resetFilter" class="ui left floated large olive icon button">
                            <i class="remove icon"></i>
                        </button>
                    </div>
                </div>
                <div class="three stackable equal width columns row">
                    <div class="column">
                        <select id="typeAbs" class="ui fluid dropdown">
                            <option value="">Type d'abonnement</option>
                            @foreach ($types as $type )
                                <option value="{{$type->typeab_id}}">{{$type->typeab_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="column">
                        <div id="abStartDate" class="ui calendar">
                            <div class="ui left icon fluid input">
                                <i class="calendar alternate outline icon"></i>
                                <input id="" type="text" placeholder="Mois de debut">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div id="abEndDate" class="ui fluid calendar">
                            <div class="ui left icon fluid input">
                                <i class="calendar alternate outline icon"></i>
                                <input id="" type="text" placeholder="Mois de fin">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tabMenu" class="ui top attached tabular olive inverted one item menu">
                <a class="item active" data-tab="first">
                    <div class="ui mini statistic">
                        <div class="value" style="color:white!important;">
                            <i class="credit card outline icon"></i>
                        </div>
                        <div class="value" style="color:white!important;">
                            Abonnements
                        </div>
                    </div>
                </a>
            </div>
            <div class="ui bottom attached tab segment active" data-tab="first" id="abns">
                <div  style="margin-top:1em!important;" class="ui three stackable  cards">
                    @foreach ($abonnements as $ab)
                        @if ($ab->abn_remaininghours <= 5)
                            <div id="team{{$ab->abn_id}}" class="red card">
                        @else
                            <div id="team{{$ab->abn_id}}" class="card">
                        @endif
                            <div class="content">
                                @php
                                {{
                                    $dateStart=date_create(date('Y-m-d'));
                                    $dateEnd=date_create("$ab->abn_end");
                                    $diff=date_diff($dateStart,$dateEnd);
                                    $diff=$diff->format("%R%a");
                                }}
                                @endphp
                                @if ($diff>=0)
                                    @if ($diff>5)
                                        <div class="ui top left attached olive label">
                                            <i class="hourglass start icon"></i>Debut : {{$ab->abn_start}}
                                        </div>
                                        <div class="ui bottom right attached olive label">
                                            <i class="hourglass end icon"></i>Fin : {{$ab->abn_end}}
                                        </div>
                                    @else
                                        <div class="ui top left attached red label">
                                            <i class="hourglass start icon"></i>Debut : {{$ab->abn_start}}
                                        </div>
                                        <div class="ui bottom right attached red label">
                                            <i class="hourglass end icon"></i>Fin : {{$ab->abn_end}}
                                        </div>
                                    @endif

                                @else
                                    <div class="ui top left attached label">
                                        <i class="hourglass start icon"></i>Debut : {{$ab->abn_start}}
                                    </div>
                                    <div class="ui bottom right attached label">
                                        <i class="hourglass end icon"></i>Fin : {{$ab->abn_end}}
                                    </div>

                                @endif
                                
                                <br>
                                <div class="ui right floated olive header">
                                    {{$ab->team_name}}
                                </div>
                                <div class="description">
                                    <div class="ui center aligned two tiny statistics">
                                        <div class="statistic">
                                            <div class="value">
                                                <i class="credit card outline icon"></i>
                                            </div>
                                            <div class="label">
                                                {{$ab->typeab_name}}
                                            </div>
                                        </div>
                                        @if ($ab->abn_remaininghours <= 5)
                                            <div class="red statistic">
                                        @else
                                            <div class="statistic">
                                        @endif
                                            <div class="value">
                                                {{$ab->abn_remaininghours}}
                                            </div>
                                            <div class="label">
                                                {{date("Y-m-d")}}
                                            </div>  
                                        </div>
                                    </div>
                                </div><br>
                            </div>
                        </div>
                    @endforeach 
                </div>
               
            </div>

        </div>
    </div>

@endsection