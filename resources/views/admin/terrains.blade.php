@extends("admin.dashboard")

@section('dashcontent')

    <div ng-controller="terController" class="ui container" style="height:90%!important" id="mapContainer">
        <div style="overflow:hidden!important" class="ui top sidebar ui segment overlay">
            <div class="ui page center aligned grid" style="width:100%!important;padding:5px!important">
                <div class="one column row">
                    <div class="sixteen wide column">
                        <h3 id="qtName" class="ui olive header"></h3>
                    </div>
                </div>
                <div class="two columns row">
                    <div class="six wide column">
                        <h3 class="ui center aligned olive header" id="terName_fr"></h3>
                        <h3 class="ui center aligned olive header" id="terName_ar"></h3>
                        <div class="ui two mini horizontal statistics">
                            <div class="statistic">
                                <div class="value">
                                    <i class="envelope outline icon"></i>
                                </div>
                                <div class="label" id="terEmail">
                                
                                </div>
                            </div>
                            <div class="statistic">
                                <div class="value">
                                    <i class="phone icon"></i>
                                </div>
                                <div class="label" id="terPhone">
                                    
                                </div>
                            </div>
                            <div class="statistic">
                                <div class="value">
                                    <i class="map signs icon"></i>
                                </div>
                                <div class="label" id="terQt">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ten wide column">
                        <table class="ui very basic table">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <div id="btnPrevDay" class="ui icon basic button">
                                            <i class="left chevron icon"></i>
                                        </div>
                                    </th>
                                    <th colspan="2" class="center aligned">
                                        <div id="resCalendar" class="ui calendar">
                                            <div class="ui transparent input">
                                            <input type="text" placeholder="Selectinner une date">
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
                        <table  class="ui celled striped table">
                            <tbody id="resHours">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="one column row">
                    <div class="sixteen wide column">
                        <button id="editTerrBtn" class="ui labeled icon olive button">
                            <i class="edit outline icon"></i>
                            Modifier
                        </button>
                        <button id="deleteTerrBtn" class="ui labeled icon red button">
                            <i class="times icon"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="addTerrModal" class="ui tiny modal">
            <div class="ui center aligned olive header">Ajouter Terrain</div>
            <div class="content">
                <div class="ui grid">
                    <div class="two columns row">
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="terNameFr" type="text" placeholder="Nom du terrain" required>
                                <i class="id card icon"></i>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="terNameAr" dir="rtl" type="text" placeholder="اسم الملعب" required>
                                <i class="id card outline icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="two columns row">
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="terrEmail" type="email" placeholder="Email" required>
                                <i class="envelope icon"></i>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="terrTel" type="tel" placeholder="N° tel" required>
                                <i class="phone icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="one column centered row">
                        <div class="eight wide column">
                            <div id="qtNames" class="ui fluid dropdown search labeled icon basic button">
                                <i class="map signs icon"></i>
                                <span class="text">Quartiers</span>
                                <div class="menu">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="actions">
                <div id="btnAddTerr" class="ui olive left labeled icon button">
                    <i class="checkmark icon"></i>
                    Ajouter
                </div>
                <div id="btnCancelTerr" class="ui deny left labeled icon button">
                    <i class="times icon"></i>
                    Annuler
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

        <div id="editTerrModal" class="ui tiny modal">
            <div id="terrNameTitle" class="ui center aligned olive header"></div>
            <div class="content">
                <div class="ui grid">
                    <div class="two columns row">
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="terNameFrEdit" type="text" placeholder="Nom du terrain" required>
                                <i class="id card icon"></i>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="terNameArEdit" dir="rtl" type="text" placeholder="اسم الملعب" required>
                                <i class="id card outline icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="two columns row">
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="terrEmailEdit" type="email" placeholder="Email" required>
                                <i class="envelope icon"></i>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <div class="ui fluid right icon input">
                                <input id="terrTelEdit" type="tel" placeholder="N° tel" required>
                                <i class="phone icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="one column centered row">
                        <div class="eight wide column">
                            <div id="qtNamesEdit" class="ui fluid dropdown search labeled icon basic button">
                                <i class="map signs icon"></i>
                                <span class="text">Quartiers</span>
                                <div class="menu">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="actions">
                <div id="btnEditTerr" class="ui olive left labeled icon button">
                    <i class="checkmark icon"></i>
                    Modifier
                </div>
                <div id="btnCancelEditTerr" class="ui deny left labeled icon button">
                    <i class="times icon"></i>
                    Annuler
                </div>
            </div>
        </div>

        <div id="delTerrModal" class="ui tiny basic modal">
            <div class="ui icon header">
                <i class="trash icon"></i>
                Supprimer terrain
            </div>
            <div class="content">
                <p>Etes vous sure de vouloir supprimer ce terrain?</p>
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

        <div  style="margin-top:1em!important;height:100%!important" class="ui center aligned container">
            <div id="map">
                <div id="mapButtons" class="leaflet-bottom leaflet-left">
                    <div class="leaflet-bar leaflet-control">
                        <button id="addTerr" class="small circular olive ui icon button">
                            <i class="plus icon"></i>
                        </button>
                        <button id="geolocate" class="small circular olive ui icon button">
                            <i class="map marker alternate icon"></i>
                        </button>
                    </div>
                </div>
                <div id="mapButtons" class="leaflet-top leaflet-right">
                    <div class="leaflet-bar leaflet-control">
                        <button id="showQts" class="small olive ui icon button" data-tooltip="Afficher les quartiers" data-position="bottom right" data-variation="mini">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection