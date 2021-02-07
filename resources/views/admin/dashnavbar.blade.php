<div ng-controller="navController">
    <div id="dashnavbar" style="margin: 0em 0em !important;" class="ui six item olive inverted mini pointing labeled icon menu">
        <a class="navbaritem item"  href="/admin/equipes">
            <i class="users icon"></i>
            Equipes
        </a>
        <a class="navbaritem item" href="/admin/terrains">
            <i class="flag outline icon"></i>
            Terrains
        </a>
        <a class="navbaritem item" href="/admin/quartiers">
            <i class="map outline icon"></i>
            Quartiers
        </a>
        <a class="navbaritem item"  href="/admin/reservations">
            <i class="calendar alternate outline icon"></i>
            Réservations
        </a>
        <a class="navbaritem item"  href="/admin/abonnements">
            <i class="credit card outline icon"></i>
            Abonnements
        </a>
        <a class="navbaritem item"  href="/admin/admins">
                <i class="address card outline icon"></i>
            Admins
        </a>
    </div>
    
    <div id="hiddenNav" style="margin: 0em 0em !important;" class="ui six item olive top fixed hidden inverted mini pointing labeled icon menu">
        <a class="navbaritem item"  href="/admin/equipes">
            <i class="users icon"></i>
            Equipes
        </a>
        <a class="navbaritem item"  href="/admin/terrains">
            <i class="flag outline icon"></i>
            Terrains
        </a>
        <a class="navbaritem item"  href="/admin/quartiers">
            <i class="map outline icon"></i>
            Quartiers
        </a>
        <a class="navbaritem item"  href="/admin/reservations">
            <i class="calendar alternate outline icon"></i>
            Réservations
        </a>
        <a class="navbaritem item"  href="/admin/abonnements">
            <i class="credit card outline icon"></i>
            Abonnements
        </a>
        <a class="navbaritem item"  href="/admin/admins">
                <i class="address card outline icon"></i>
            Admins
        </a>
    </div>

    <button class="hidden big ui olive floated circular icon  button topButton">
        <i class="arrow up icon"></i>
    </button>
    <div id="logoutModal" class="ui tiny basic modal">
        <div class="ui icon header">
            <i class="power off icon"></i>
            Se Deconnecter
        </div>
        <div class="content">
            <p>Êtes-vous sûr de vouloir vous déconnecter?</p>
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
    
    <a  id="logoutBtn" class="big ui olive floated circular icon button logoutButton" onclick="">
        <i class="power off icon"></i>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>