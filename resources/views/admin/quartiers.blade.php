@extends("admin.dashboard")

@section('dashcontent')

    <div ng-controller="qtController" class="ui container" style="height:90%!important" id="mapContainer">
        <div style="overflow:hidden!important" class="ui top sidebar ui segment overlay">
            <div class="ui page center aligned grid">
                <div class="one column row">
                    <div class="sixteen wide column">
                        <h3 id="qtName" class="ui olive header"></h3>
                    </div>
                </div>
                <div class="one column row">
                    <div class="sixteen wide column">
                        <div class="ui two mini statistics">
                            <a id="qtTeams" class="statistic">
                                <div class="value" id="teamsCount">
                                    <i class="users icon"></i>
                                </div>
                                <div class="label">
                                    Equipes
                                </div>
                            </a>
                            <a id="qtTerrains" class="statistic">
                                <div class="value" id="stadCount">
                                    <i class="flag checkered icon"></i>
                                </div>
                                <div class="label">
                                    Terrains
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="one column row">
                    <div class="sixteen wide column">
                        <button id="editQtBtn" class="ui labeled icon olive button">
                            <i class="edit outline icon"></i>
                            Modifier
                        </button>
                        <button id="deleteQtBtn" class="ui labeled icon red button">
                            <i class="times icon"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="addQtModal" class="ui tiny modal">
            <div class="header">
                Ajouter Quartier
            </div>
            <div class="content">
                <div class="ui grid">
                    <div class="two columns row">

                        <div class="eight wide column">
                            <div class="ui fluid input">
                                <input id="qtNameFr" type="text" placeholder="Nom du quartier" required>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <div class="ui fluid input">
                                <input id="qtNameAr" dir="rtl" type="text" placeholder="اسم الحي" required>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="actions">
                <div id="btnAddQt" class="ui olive left labeled icon button">
                    <i class="checkmark icon"></i>
                    Ajouter
                </div>
                <div id="btnCancelQt" class="ui deny left labeled icon button">
                    <i class="times icon"></i>
                    Annuler
                </div>
            </div>
        </div>
        <div id="editQtModal" class="ui tiny modal">
            <div class="header">
                Modifier Quartier
            </div>
            <div class="content">
                <div class="ui grid">
                    <div class="two columns row">

                        <div class="eight wide column">
                            <div class="ui fluid input">
                                <input id="editqtNameFr" type="text" placeholder="Nom du quartier" required>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <div class="ui fluid input">
                                <input id="editqtNameAr" dir="rtl" type="text" placeholder="اسم الحي" required>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="actions">
                <div id="btnEditQt" class="ui olive left labeled icon button">
                    <i class="checkmark icon"></i>
                    Modifier
                </div>
                <div id="btnCancelEditQt" class="ui deny left labeled icon button">
                    <i class="times icon"></i>
                    Annuler
                </div>
            </div>
        </div>
        <div id="confirmModal" class="ui tiny basic modal">
            <div class="ui icon header">
                <i class="trash icon"></i>
                Supprimer le quartier
            </div>
            <div class="content">
                <p>Etes vous sure de vouloir supprimer ce quartier?</p>
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
        <div id="qtDataModal" class="ui modal">
            <div id="qtModalTitle" class="ui center aligned olive header"></div>
            <div class="scrolling content">
                <div id="qtModalCards" class="ui four cards">
                </div>
                <div id="qtModalItems" class="ui divided items">
                </div>
            </div>
        </div>
        <div  style="margin-top:1em!important;height:100%!important" class="ui center aligned container">
            <div id="map">
                <div id="mapButtons" class="leaflet-bottom leaflet-left">
                    <div class="leaflet-bar leaflet-control">
                        <button id="addQt" class="small circular olive ui icon button">
                            <i class="plus icon"></i>
                        </button>
                        <button id="geolocate" class=" small circular olive ui icon button">
                            <i class="map marker alternate icon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection