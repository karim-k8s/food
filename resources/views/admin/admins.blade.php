@extends("admin.dashboard")

@section('dashcontent')

    <div ng-controller="admController" class="ui center aligned container">
        <div id="tabMenu" class="ui top attached tabular olive inverted one item menu">
            <a class="item active" data-tab="first">
                <div class="ui mini statistic">
                    <div class="value" style="color:white!important;">
                        <i class="shield alternate big icon"></i>
                    </div><br>
                    <div class="value" style="color:white!important;">
                        Mon Profil
                    </div>
                </div>
            </a>
        </div>
        <div class="ui bottom attached tab segment active" data-tab="first" id="abns">
            <h1 class="ui header">{{$myInfo['0']->admin_name}}</h1>

            <div class="ui two columns divided grid">
                <div class="row">
                    <div class="twelve wide column">
                        <div class="ui big labels">
                             <br><br>
                             <div class="ui basic label">
                                <i class="hashtag olive icon"></i> 
                                N° Badge : 
                                <div class="detail">{{$myInfo['0']->admin_badge}}</div>
                            </div>
                            <br><br>
                            <div class="ui label">
                                <i class="envelope olive icon"></i> 
                                Email : 
                                <div class="detail">{{$myInfo['0']->admin_email}}</div>
                            </div>
                            <br><br>
                            <div class="ui basic label">
                                <i class="phone olive icon"></i> 
                                N° Tel : 
                                <div class="detail">{{$myInfo['0']->admin_phone}}</div>
                            </div>
                            <br><br>
                        </div>
                        <button onclick="editAdmin({{json_encode($myInfo['0'])}})" class="fluid ui icon button">
                            <i class="edit outline icon"></i>  Modifier mon profil
                        </button>
                        
                        @if (strpos($myInfo['0']->admin_badge, 'root') !== false)
                        <button id="btnAddAdmin" class="fluid ui olive icon button">
                            <i class="plus icon"></i>  Ajouter un admin
                        </button>
                            <div  style="margin-top:1em!important;" class="ui three stackable cards">
                                @foreach ($admins as $ad)
                                    

                                    @if ($ad->admin_badge != $myInfo['0']->admin_badge)
                                        <div class="card">
                                            <div class="content">
                                                <div class="olive header">
                                                    {{$ad->admin_name}}
                                                </div>
                                                <div class="description">
                                                    <div class="basic label">
                                                        <i class="hashtag olive icon"></i> 
                                                        N° Badge : {{$ad->admin_badge}}
                                                    </div><br>
                                                    <div class="basic label">
                                                        <i class="envelope olive icon"></i> 
                                                        Email : {{$ad->admin_email}}
                                                    </div><br>
                                                    <div class="basic label">
                                                        <i class="phone olive icon"></i> 
                                                        N° Tel : {{$ad->admin_phone}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="extra content">
                                                <div class="ui two buttons">
                                                    <div onclick="makeRoot({{json_encode($ad)}})" class="ui basic green icon button">
                                                        <i class="cog icon"></i>
                                                    </div>
                                                    <div onclick="removeAdmin({{json_encode($ad)}})" class="ui basic red icon button">
                                                        <i class="remove icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                @endforeach
                            </div>
                            
                        @endif
                    </div>
                    <div class="four wide column">
                        <h3>Statistiques du site</h3>
                        <div class="ui horizontal tiny statistics">
                            <div class="statistic">
                                <div class="value">
                                    <i class="futbol outline olive icon"></i> {{$stats['teams']}}
                                </div>
                                <div class="label">
                                    Equipes
                                </div>
                            </div>
                            <div class="statistic">
                                <div class="value">
                                    <i class="map signs olive icon"></i> {{$stats['terrains']}}
                                </div>
                                <div class="label">
                                    Terrains
                                </div>
                            </div>
                            <div class="statistic">
                                <div class="value">
                                    <i class="building olive icon"></i> {{$stats['quartiers']}}
                                </div>
                                <div class="label">
                                    Quartiers
                                </div>
                            </div>
                            <div class="ui statistic">
                                <div class="value">
                                    <i class="credit card outline olive icon"></i> {{$stats['abonnements']}}
                                </div>
                                <div class="label">
                                    Abonnements
                                </div>
                            </div>
                            @if (strpos($myInfo['0']->admin_badge, 'root') !== false)
                                <div class="ui statistic">
                                    <div class="value">
                                        <i class="user olive icon"></i> {{$stats['admins']}}
                                    </div>
                                    <div class="label">
                                        Admins
                                    </div>
                                </div>
                                <div class="ui statistic">
                                    <div class="value">
                                        <i class="shield alternate olive icon"></i> {{$stats['rootAdmins']}}
                                    </div>
                                    <div class="label">
                                        Root Admins
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
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

        <div id="delAdminModal" class="ui tiny basic modal">
            <div class="ui icon header">
                <i class="trash icon"></i>
                Supprimer un admin
            </div>
            <div class="content">
                <p>Etes vous sure de vouloir supprimer cet Admin?</p>
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
        <div id="makeRootModal" class="ui tiny basic modal">
            <div class="ui icon header">
                <i class="cog icon"></i>
                Rendre ROOT
            </div>
            <div class="content">
                <p>Etes vous sure de vouloir rendre cet Admin un ROOT?</p>
            </div>
            <div class="actions">
                <div class="ui basic red  cancel inverted button">
                    <i class="remove icon"></i>
                    Non
                </div>
                <div class="ui green ok inverted button">
                    <i class="checkmark icon"></i>
                    Oui
                </div>
            </div>
        </div>
         <div id="addAdminModal" class="ui tiny modal">
            <div class="ui center aligned olive header">Ajouter Admin</div>
            <div class="content">
                <div class="ui grid">
                    <div class="two columns row">
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="adminName" type="text" placeholder="Nom d'admin" required>
                                <i class="id card icon"></i>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="badgeNum" type="text" placeholder="N° badge (CIN)" required>
                                <i class="hashtag icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="two columns row">
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="adminEmail" type="email" placeholder="Email" required>
                                <i class="envelope icon"></i>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="adminTel" type="tel" placeholder="N° tel" required>
                                <i class="phone icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="two columns row">
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="pwdAdmin" type="password" placeholder="Mot de passe" required>
                                <i class="lock icon"></i>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="confPwdAmdin" type="password" placeholder="Confirmer le mot de passe" required>
                                <i class="lock icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="actions">
                <div id="btnConfAddAdmin" class="ui olive left labeled icon button">
                    <i class="checkmark icon"></i>
                    Ajouter
                </div>
                <div id="btnCancelAdd" class="ui deny left labeled icon button">
                    <i class="times icon"></i>
                    Annuler
                </div>
            </div>
        </div>
         <div id="editAdminModal" class="ui tiny modal">
            <div class="ui center aligned olive header">Modifier Mon Profil</div>
            <div class="content">
                <div class="ui grid">
                    <div class="one column row">
                        <div class="sixteen wide center aligned column">
                            <div class="basic label">
                                <i class="hashtag olive icon"></i> 
                                N° Badge : <span class="detail" id="badgeNumEdit"></span>
                            </div>
                        </div>
                    </div>
                    <div class="two columns row">
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="adminNameEdit" type="text" placeholder="Nom d'admin" required>
                                <i class="id card icon"></i>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="adminTelEdit" type="tel" placeholder="N° tel" required>
                                <i class="phone icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="two columns row">
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="pwdAdminEdit" type="password" placeholder="Nouveau Mot de passe" required>
                                <i class="lock icon"></i>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="confPwdAmdinEdit" type="password" placeholder="Confirmer le mot de passe" required>
                                <i class="lock icon"></i>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
            <div class="actions">
                <div id="btnConfEditAdmin" class="ui olive left labeled icon button">
                    <i class="edit outline icon"></i>
                    Modifier
                </div>
                <div id="btnCancelEdit" class="ui deny left labeled icon button">
                    <i class="times icon"></i>
                    Annuler
                </div>
            </div>
        </div>
    </div>
@endsection