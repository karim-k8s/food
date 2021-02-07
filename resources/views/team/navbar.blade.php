
<div ng-controller="teamNavController">
    <div class="ui container">
        <div id="mainNav" class="ui large secondary menu">
            <a class="ui medium image">
                <img src="css/images/logomod3.png" alt="">
            </a>
            

            @if((session('role')=='team') && session('email'))
                <div class="right item">
                    <button id="showEditUser" class="ui olive icon button" style="margin-right: 5px!important">
                        <i class="edit icon"></i>
                    </button>
                    <button id="logoutBtn" class="ui red icon button">
                        <i class="power off icon"></i>
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        <!-- Cross-site request forgeries -->
                    </form>
                </div>
            @else
                <div class="right item">
                    <button id="btnLoginUser" class="ui icon button">
                        <i style="color:white!important" class="sign in alternate icon"></i>
                    </button>
                    <button id="btnSignupUser" class="ui olive icon button">
                        <i class="user plus icon"></i>
                    </button>
                </div>
            @endif
        </div>
        
    </div>

    <div id="sideMenu" class="ui vertical icon big buttons" style="">
        <button class="ui icon button activeItem" id="introSecBtn">
            <i class="home olive icon"></i>
        </button>
        <button class="ui icon button" id="terSecBtn">
            <i class="calendar alternate outline olive icon"></i>
        </button>
        <button class="ui icon button" id="abnSecBtn">
            <i class="credit card outline olive icon"></i>
        </button>
        <button class="ui icon button" id="contactusBtn">
            <i class="paper plane olive icon"></i>
        </button>
    </div>

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

    <button class="big ui olive floated circular icon  button topButton hidden">
        <i class="arrow up icon"></i>
    </button>
</div>