$(document).ready(function($) {
    var Body = $('body');
    Body.addClass('preloader-site');
});
$(window).on('load',function() {
    $('.preloader-wrapper').fadeOut(3000);
    $('body').removeClass('preloader-site');

});


var app = angular.module('FastFootTeam', ['ngRoute']);

app.controller('teamNavController',function($http,$scope){
    $('.topButton').hide();
    $('#mainNav').visibility({
        once: false,
        onBottomPassed: function() {
            $('.topButton').transition('fade in');
            $('#hiddenMenu').transition('fade in');
        },
        onBottomPassedReverse: function() {
            $('.topButton').transition('fade out');
            $('#hiddenMenu').transition('fade out');
        }
    });

    
});

app.controller('indexController',function($http,$scope){
    

    /*var fonts = ['f1','f2','f3','f4','f5','f6','f7'];

    if($('#teamTitle')){
        $('#teamTitle').css('font-family',fonts[Math.floor(Math.random()*fonts.length)])
    }*/

    $('.menu .button').tab();
    $('.ui.dropdown').dropdown();
    $scope.scrollByButton = false;
    var hCont = $('.bgContainer').css('height').replace('px','');
    var hNav=($('#mainNav').css('height')).replace('px','');

    $('#intro').css('min-height','auto');
    $('#abnSection').css('min-height','auto');
    $('#terResSection').css('min-height','auto');

    $('#intro').css('min-height',$('#intro')[0].scrollHeight+'px');
    $('#abnSection').css('min-height',$('#abnSection')[0].scrollHeight+'px');
    $('#terResSection').css('min-height',$('#terResSection')[0].scrollHeight+'px');

    
    $('#terResSection').css('width',$('#mainNav').css('width').replace('px',''));
    $('#terResSection').css('margin','auto');

    $('#abnSection').css('width',$('#mainNav').css('width').replace('px',''));
    $('#abnSection').css('margin','auto');


    $('#intro').css('height',hCont-hNav);
    $('#terResSection').css('height',hCont-hNav);
    $('#abnSection').css('height',hCont-hNav - 200);

    

   

    $('#mainMap').css('height',(hCont-hNav)-$('#searchBar').css('height').replace('px','')-50);
    $('#mainMap').css('width','100%');

    $( window ).resize(function() {
        
        hCont = $('.bgContainer').css('height').replace('px','');
        hNav = ($('#mainNav').css('height')).replace('px','');    
        winHeight = $(window).height();

        $('#intro').css('height',hCont-hNav);
        $('#terResSection').css('height',hCont-hNav);
        $('#abnSection').css('height',hCont-hNav-200);

        $('#intro').css('min-height','auto');
        $('#abnSection').css('min-height','auto');
        $('#terResSection').css('min-height','auto');

        $('#intro').css('min-height',$('#intro')[0].scrollHeight+'px');
        $('#abnSection').css('min-height',$('#abnSection')[0].scrollHeight+'px');
        $('#terResSection').css('min-height',$('#terResSection')[0].scrollHeight+'px');
        
        $('#mainMap').css('height',(hCont-hNav)-$('#searchBar').css('height').replace('px','')-50);
        $('#mainMap').css('width','100%');

        $('#terResSection').css('width',$('#mainNav').css('width').replace('px',''));
        $('#terResSection').css('margin','auto');

        $('#abnSection').css('width',$('#mainNav').css('width').replace('px',''));
        $('#abnSection').css('margin','auto');
    });

    var TO = false;
    var scroll_static = true;
    var btnClicked = false;
    $(window).scroll(function(e){

        if( scroll_static ){
            scroll_static = false;
        }

        if(TO !== false){ clearTimeout(TO); }           
        TO = setTimeout(function(){
            scroll_static = true;
            btnClicked = false;
        }, 200); 
        
        if(btnClicked==false){
            /*if($('#intro').isInViewport()){
                activateMenuItem('introSecBtn');
            }*/
            var scrollTop =  $(window).scrollTop();
            if(scrollTop <= 50){
                activateMenuItem('introSecBtn');
            }
            if($('#terResSection').isInViewport()){
                activateMenuItem('terSecBtn');
            }
            if($('#abnSection').isInViewport()){
                activateMenuItem('abnSecBtn');
            }
            if($(window).scrollTop() + $(window).height() == $(document).height()) {
                activateMenuItem('contactusBtn');
            }
            if($('#contactusSection').isInViewport()){
                
            }
        }
    });

    $('#introSecBtn').click(function () {
        activateMenuItem('introSecBtn');
        btnClicked=true;
        $("html, body").animate({scrollTop: 0},1000);
    });
    $('#terSecBtn').click(function () {
        activateMenuItem('terSecBtn');
        btnClicked=true;
        $('html, body').animate({
            scrollTop: $("#terResSection").offset().top
        },1000);
    });
    $('#abnSecBtn').click(function () {
        activateMenuItem('abnSecBtn');
        btnClicked=true;
        $('html, body').animate({
            scrollTop: $("#abnSection").offset().top
        },1000);
    });
    
    $('#contactusBtn').click(function (e) {
        activateMenuItem('contactusBtn');
        btnClicked=true;
        $('html, body').animate({
            scrollTop: $(document).height()
        },1000);
    });
    $('.topButton').click(function () {
        activateMenuItem('introSecBtn');
        $("html, body").animate({scrollTop: 0},1000);
    });
    function activateMenuItem(itemId){
        $scope.scrollByButton = true;
        $('#terSecBtn').removeClass('activeItem');
        $('#abnSecBtn').removeClass('activeItem');
        $('#contactusBtn').removeClass('activeItem');
        $('#introSecBtn').removeClass('activeItem');
        $('#'+itemId+'').addClass('activeItem');
    }

    $.fn.isInViewport = function() {
        var elementTop = $(this).offset().top;
        var elementBottom = elementTop + $(this).outerHeight();
      
        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();
      
        return elementBottom > viewportTop && (elementTop+100) < viewportBottom;
    };

    $('#btnLoginUser').click(function(){
        
        $('#loginModal').modal({closable:false}).modal('show');
        $.tab('change tab', 'first');
        $('#btnCnxTab').addClass('active');
        $('#btnSigninTab').removeClass('active');
    });

    $('#btnSignupUser').click(function(){
        $('#loginModal').modal({closable:false}).modal('show');
        $.tab('change tab', 'second');
        $('#btnSigninTab').addClass('active');
        $('#btnCnxTab').removeClass('active');
    });

    $('#btnContinueSignUp').click(function(){

        var mailRegex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    
        $('#signupName').val($('#signupName').val().replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, ''));
        
        if($('#signupName').val().length>0){

            $('#signupName').parent().removeClass('error');

            if(mailRegex.test($('#signupEmail').val())){

                $('#signupEmail').parent().removeClass('error');

                if($('#signupPwd').val().length>=8){

                    $('#signupPwd').popup('destroy');
                    $('#signupPwd').removeClass('error');

                    $('#btnContinueSignUp').addClass('loading');
                    $('.btnCloseModal').addClass('disabled');
                    $('#btnContinueSignUp').addClass('disabled');
                    
                    $http.post('/checkUserMail',{'email':$('#signupEmail').val()}).then(sCallback,eCallback);
                    function sCallback(res){

                        $('#btnContinueSignUp').removeClass('loading');
                        $('#btnContinueSignUp').removeClass('disabled');
                        $('.btnCloseModal').removeClass('disabled');

                        if(res.data== 'email ok'){
                            $('#signupEmail').popup('destroy');
                            $('#loginModal').modal('close');
                            $('#finishSignUpModal').modal({closable:false}).modal('show');
                        }else{
                            $('#signupEmail').popup({
                                content : 'Ce email est deja utilisé'
                            }).popup('toggle');
                            $('#signupEmail').parent().addClass('error');
                        }
                    }
                    function eCallback(err){
                        console.log(err)
                    }
        
                }else{
                    $('#signupPwd').popup({
                        content : 'le mot de passe devrait avoir 8 caractères ou plus'
                    }).popup('toggle');
                    $('#signupPwd').addClass('error');
                }
            }else{
                $('#signupEmail').parent().addClass('error');
            }
        }else{
            $('#signupName').parent().addClass('error');
        }
        
        
    });

    $('#btnReturnToLogin').click(function(){
        $('#finishSignUpModal').modal('close');
        $('#loginModal').modal({closable:false}).modal('show');
    })
    
 

    $('.btnCloseModal').click(function(){
        $('#loginEmail').val('');
        $('#loginPwd').val('');
        $('#signupName').val('');
        $('#signupEmail').val('');
        $('#signupPwd').val('');
        $('#signupPhone').val('');
      
        //$('#signupQt').val('');
        $('#qtDropdown').dropdown('restore defaults');
    });

    $('#btnLogIn').click(function(){
        var mailRegex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);      
        $('#loginEmail').popup('destroy');
        $('#loginPwd').popup('destroy');
        if(mailRegex.test($('#loginEmail').val())){

            $('#loginEmail').parent().removeClass('error');

            if($('#loginPwd').val().length>=8){

                $('#loginPwd').removeClass('error');

                $('#btnLogIn').addClass('loading');
                $('.btnCloseModal').addClass('disabled');
                $('#btnLogIn').addClass('disabled');
                
                $http.post('/loginTeam',{
                    'usermail':$('#loginEmail').val(),
                    'userpwd':$('#loginPwd').val()
                }).then(sCallback,eCallback);

                function sCallback(res){

                    $('#btnLogIn').removeClass('loading');
                    $('#btnLogIn').removeClass('disabled');
                    $('.btnCloseModal').removeClass('disabled');

                    if(res.data == 'success'){
                        location.reload();
                    }else if(res.data =='emailError'){
                        $('#loginEmail').popup({
                            content : 'Email erronné'
                        }).popup('toggle');
                        $('#loginEmail').parent().addClass('error');
                    }else{
                        $('#loginEmail').popup('destroy');
                        $('#loginPwd').popup({
                            content : 'Mot de passe erronné'
                        }).popup('toggle');
                        $('#loginPwd').parent().addClass('error');
                        $('#loginEmail').parent().removeClass('error');
                    }
                }
                function eCallback(err){
                    console.log(err)
                }
    
            }else{
               
                $('#signupPwd').addClass('error');
            }
        }else{
            $('#loginEmail').parent().addClass('error');
        }
        
    });
   
    $('#btnSignUp').click(function(){
        var telRegex = new RegExp('\^[0][5-7]{1}[0-9]{8}$');
        
        if(telRegex.test($('#signupPhone').val())){

            $('#signupPhone').parent().removeClass('error');

            if($('#signupQt').val()){

                $('#qtDropdown').removeClass('error');
                $('#btnSignUp').addClass('loading');
                $('#btnSignUp').addClass('disabled');
                $('#btnReturnToLogin').addClass('disabled');

                $http.post('/signupTeam', {
                    'teamName':$('#signupName').val(),
                    'teamEmail':$('#signupEmail').val(),
                    'teamPhone':$('#signupPhone').val(),
                    'teamQt':$('#signupQt').val(),
                    'teamPwd':$('#signupPwd').val(),
                    'teamSt':$('#signupSt').val(),
                    }).then(sCallback,eCallback);
                    
                    
                    function sCallback(res){
             
                        $('#btnSignUp').removeClass('loading');
                        $('#btnSignUp').removeClass('disabled');
                        $('#btnReturnToLogin').removeClass('disabled');
            
                        if(res.data=='success'){
                            $('#alertMessage').html('<i class="info icon"></i>Vous etes bien Inscrit avec FastFoot, Veuillez vous connecter !');
                            $('#warningModal').modal({
                                onHide: function(){location.reload();}
                            }).modal('show');
                        }
                    }
                    function eCallback(err){
                        console.log(err)
                    }

            }else{
                $('#qtDropdown').addClass('error');
            }
        }else{
            $('#signupPhone').parent().addClass('error');
        }
    });
   
    $("#logoutBtn").click(function(){
        $('#logoutModal')
        .modal({
          closable  : false,
          onDeny    : function(){
            
          },
          onApprove : function() {
            event.preventDefault();
            document.getElementById('logout-form').submit();
          }
        }).modal('show');
    });

    $('#btnCancelEditTeam').click(function(){
        $('#editTeamModal').modal('hide');
        $('#editTeamPwd').val('');
        $('#editTeamName').val('');
        $('#editTeamPhone').val('');
      
        $('#editTeamQt').val('');
        $('#editTeamqtDropdown').dropdown('restore defaults');
    });


    $('#showEditUser').click(function(){
        $('#editTeamModal').modal({closable:false}).modal('show');
    });

    $('#btnEditTeam').click(function(){
        var telRegex = new RegExp('\^[0][5-7]{1}[0-9]{8}$');
        
        if($('#editTeamName').val().length>0){


            if(telRegex.test($('#editTeamPhone').val())){

                $('#editTeamPhone').parent().removeClass('error');
    
                if($('#editTeamQt').val()){
    
                    $('#editTeamqtDropdown').removeClass('error');
    
                    if($('#editTeamPwd').val().length>=8){
    
                        $('#editTeamPwd').popup('destroy');
                        $('#editTeamPwd').removeClass('error');
                        $('#btnEditTeam').addClass('loading');
                        $('#btnEditTeam').addClass('disabled');
                        $('#btnCancelEditTeam').addClass('disabled');
    
                        $http.post('/editTeam', {
                            'teamName':$('#editTeamName').val(),
                            'teamPhone':$('#editTeamPhone').val(),
                            'teamQt':$('#editTeamQt').val(),
                            'teamPwd':$('#editTeamPwd').val()
                        }).then(sCallback,eCallback);
                        
                        
                        function sCallback(res){
                
                            $('#btnEditTeam').removeClass('loading');
                            $('#btnEditTeam').removeClass('disabled');
                            $('#btnCancelEditTeam').removeClass('disabled');
                
                            if(res.data=='success'){
                                $('#alertMessage').html('<i class="info icon"></i>Votre profil est modifié !');
                                $('#warningModal').modal({
                                    onHide: function(){location.reload();}
                                }).modal('show');
                            }
                        }
                        function eCallback(err){
                            console.log(err)
                        }
                       
                    }else{
                        $('#editTeamPwd').popup({
                            content : 'le mot de passe devrait avoir 8 caractères ou plus'
                        }).popup('toggle');
                        $('#editTeamPwd').addClass('error');
                    }
    
                }else{
                    $('#editTeamqtDropdown').addClass('error');
                }
            }else{
                $('#editTeamPhone').parent().addClass('error');
            }
        }else{
            $('#editTeamName').parent().addClass('error');
        }
    });

    

    $('#btnShowInvits').click(function(){
        $('#invitsModal').modal({
            closable:false,
            autofocus:false,
            onVisible : function(){
                $http.post('/getInv',{}).then(sCallback,eCallback);

                function sCallback(response){

                    $('#invList').html('');
                    
                    if(response.data){
                        
                        $.each(response.data.invits,function(index,res){

                            var host = '';
                            for(i=0;i<response.data.invits.length;i++){
                                
                                
                                if(response.data.teams[i].team_id == res.hostteam_id){
                                    host = response.data.teams[i].team_name;
                                }
                            }
                            var now = new Date();
                            var resDate = new Date(res.match_start);

                            var diffDays = Math.ceil((resDate.getTime() - now.getTime()) / (1000 * 3600 * 24));

                            now = now.getDate()+'/'+now.getMonth()+'/'+now.getFullYear();
                            resDate = resDate.getDate()+'/'+resDate.getMonth()+'/'+resDate.getFullYear();

                            var item = '<div class="item">';
                            item += '<div class="content">';

                            item += '<h3 class="ui olive header">'+res.match_start.substring(11, 16)+'</h3>';

                            item += '<div class="meta">';
                            item += '<span class="cinema">Host : '+host+'</span><br><br>';
                            
                            item += '</div>';

                            item += '<div class="extra">';
                            resData = {
                                'resId':res.match_id
                            }
                            if(diffDays>=0){
                                item += '<div onclick="cancelInv('+res.match_id+')" class="ui right floated negative button"><i class="remove icon"></i>Anuuler</div>';
                                item += '<div onclick="approvInv('+res.match_id+')" class="ui right floated positive button"><i class="remove icon"></i>Accepter</div>';
                            }
                            item += '<div class="ui label"><i class="hourglass start icon"></i>Debut : '+res.match_start.substring(11, 16)+'</div>';
                            item += '<div class="ui label"><i class="hourglass end icon"></i>Fin : '+res.match_end.substring(11, 16)+'</div>';
                            item += '</div>';

                            item += '</div>';
                            item += '</div>';

                            $('#invList').append(item);
                        
                        
                        });

                    }
                }
                function eCallback(error){
                console.log(error);
                }
            }
        }).modal('show');
    });
    $('#btnShowAccepts').click(function(){
        $('#invitsModal').modal({
            closable:false,
            autofocus:false,
            onVisible : function(){
                $http.post('/getInv',{}).then(sCallback,eCallback);

                function sCallback(response){

                    $('#invList').html('');
                    
                    if(response.data){
                        
    $.each(response.data.accept,function(index,acc){

        var guest = [];
        for(i=0;i<response.data.teams.length;i++){
            
            var j = 0;
            if(response.data.teams[i].team_id == acc.guestteam_id){
                guest[j] = response.data.teams[i].team_name;
                var now = new Date();
                var accDate = new Date(acc.match_start);
        
                var diffDays = Math.ceil((accDate.getTime() - now.getTime()) / (1000 * 3600 * 24));
        
                now = now.getDate()+'/'+now.getMonth()+'/'+now.getFullYear();
                accDate = accDate.getDate()+'/'+accDate.getMonth()+'/'+accDate.getFullYear();
        
                var item = '<div class="item">';
                item += '<div class="content">';
        
                item += '<h3 class="ui olive header">'+acc.match_start.substring(11, 16)+'</h3>';
        
                item += '<div class="meta">';
                item += '<span class="cinema">Votre demande est accepté par : '+guest[j]+'</span><br><br>';
                
                item += '</div>';
        
                item += '<div class="extra">';
                resData = {
                    'resId':acc.match_id
                }
                item += '<div class="ui label"><i class="hourglass start icon"></i>Debut : '+acc.match_start.substring(11, 16)+'</div>';
                item += '<div class="ui label"><i class="hourglass end icon"></i>Fin : '+acc.match_end.substring(11, 16)+'</div>';
                item += '</div>';
        
                item += '</div>';
                item += '</div>';
        
                $('#invList').append(item);
            
                j++;
            }
        }
       
    
    });
}
}
function eCallback(error){
console.log(error);
}
}
}).modal('show');
});
    cancelInv = function(id){
        resData = {
            'id':id
          }
          $('#confCancelInvModal')
          .modal({
            closable  : false,
            onDeny    : function(){
              
            },
            onApprove : function() {
      
              $http.post('/cancelInv',resData).then(delSCallback,delECallback);
      
              function delSCallback(r){
      
                if(r.data == 'success'){
                  $('#alertMessage').html('<i class="info icon"></i>Invitation Annulée !');
                  $('#warningModal')
                  .modal({
                    onHide: function(){
                      location.reload();
                    }
                  })
                  .modal('show');
                }
      
              }
              function delECallback(e){
                console.log(e)
              }
            }
          }).modal('show');
    }
    approvInv = function(id){
        resData = {
            'id':id
          }
          $('#confApprovInvModal')
          .modal({
            closable  : false,
            onDeny    : function(){
              
            },
            onApprove : function() {
      
              $http.post('/approvInv',resData).then(delSCallback,delECallback);
      
              function delSCallback(r){
      
                if(r.data == 'success'){
                  $('#alertMessage').html('<i class="info icon"></i>Invitation Accepter !');
                  $('#warningModal')
                  .modal({
                    onHide: function(){
                      location.reload();
                    }
                  })
                  .modal('show');
                }
      
              }
              function delECallback(e){
                console.log(e)
              }
            }
          }).modal('show');
    }
    /*document.getElementById('compNbrEq').onchange = function(){
        console.log($('#compNbrEq').val())
        $('#compEquipes').dropdown({
            maxSelections: 2
        });
    }*/
});

app.controller('terSectController',function($http,$scope){
    
    if($('#teamTitle').html()){
        var titleNums = '';
        if($('#teamTitle').html().match(/\d+/g)){
            titleNums = $('#teamTitle').html().match(/\d+/g)[0];
        }
        
        var title = $('#teamTitle').html().replace(/\d+/g,'');
    
        $('#teamTitle').html(title+'<b style="font-family:f1!important;font-size:1.5em;">'+titleNums+'</b>');
    }

    $scope.currDate;
    $scope.currDate = new Date();

    var initDate = new Date();
    var endDate = new Date();
    endDate.setDate(initDate.getDate() + 30);
    var dd =  $scope.currDate.getDate();
    var mm =  $scope.currDate.getMonth()+1;
    var yy =  $scope.currDate.getFullYear();

    var ds = dd+'/'+mm+'/'+yy;
    
    
    var map = L.map('mainMap',{
        zoomControl: false
    });
    map.setView([33.5722678, -7.6570322], 12);
    map.dragging.enable();
    L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3'],
        attribution: '© Google Maps'     
    }).addTo(map);

    L.control.zoom({
            position:'bottomright'
    }).addTo(map);

    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    $http.post('/getMapData').then(sGetQt, eGetQt);
    function sGetQt(response){
        $scope.qtNames = [];
        quartiers = L.geoJSON(response.data[1],{
        onEachFeature : function(feature,layer){

            $scope.qtNames.push({
                name:feature.properties.name_fr,
                value: feature.properties.id
            });

            var letters = '0123456789ABCDEF';
            var randColor = '#';
            for (var i = 0; i < 6; i++) {
                randColor += letters[Math.floor(Math.random() * 16)];
            }
            layer.bindTooltip(feature.properties.name_fr);
            layer.setStyle({fillColor: randColor, color: randColor, opacity: 0.5});
            
        }
        
        });
        quartiers.addTo(map);

        $('#qtNames').html('');
        $('#qtNames').append('<option value="">Quartier</option>');
        $.each($scope.qtNames,function(id,qt){
            $('#qtNames').append('<option value="'+qt.value+'">'+qt.name+'</option>');
        });

        $scope.terrains = L.geoJson(response.data[0],{
            onEachFeature : function(feature,layer){
                layer.on('click',function(e){
                    $scope.terId = feature.properties.id;
                    $scope.terName = feature.properties.name_fr;
                    $("#terName_fr").text(feature.properties.name_fr);
                    $("#terEmail").html(feature.properties.email);
                    $("#terPhone").html(feature.properties.phone);

                    for(var i=0;i<$scope.qtNames.length;i++){
                        if($scope.qtNames[i].value==feature.properties.qtId){
                        $("#terQt").html($scope.qtNames[i].name);
                        } 
                    }
                    
                    $('.ui.sidebar').sidebar('toggle');

                });   
            }
        });
        $scope.terrains.addTo(map);
        
    }

    function eGetQt(error){
        console.log(error);
    }
    var searchDiv = $('#searchDiv');
    var searchInputsDiv = $('#searchInputsDiv');
    changeToInputs = function(){
        $('#searchElts').transition({
            animation:'fade out',
            duration: '700ms',
            onComplete:function(){
                $('#searchDiv').replaceWith(searchInputsDiv);
                $('#searchElts').transition('fade in', '500ms');
                $(window).trigger('resize');
                ititalizeSearchElts();
            }
        });
    }

    changeToSearch = function(){
        
        $('#qtNames').dropdown('restore defaults');
        $('#resCalendar').calendar('clear');
        $(window).trigger('resize');
        $('#searchElts').transition({
            animation:'fade out',
            duration: '500ms',
            onComplete:function(){
                $('#searchInputsDiv').replaceWith(searchDiv);
                $('#searchElts').transition('fade in', '500ms');
                $(window).trigger('resize');
                ititalizeSearchElts();
            }
        });
        
        
    }

    function ititalizeSearchElts (){
        $('.ui.dropdown').dropdown();
        $scope.qtId = '';
        $scope.resTime = '';
        $scope.terName = '';
        if(document.getElementById('qtNames')){
            document.getElementById('qtNames').onchange = function(e){
                $('.ui.sidebar').sidebar('hide');
                if($('#qtNames').val()){
    
                    $scope.terrains.removeFrom(map);
                    $scope.qtId = $('#qtNames').val();
                    var data = {
                        'qtId':$scope.qtId,
                        'resTime': $scope.resTime
                    }
                    $http.post('/getResTers',data).then(successCB,errorCB);
                    function successCB(response){
                        $scope.terrains = L.geoJson(response.data.ters,{
                            onEachFeature : function(feature,layer){
                                layer.on('click',function(e){
                                    $scope.terId = feature.properties.id;
                                    $scope.terName = feature.properties.name_fr;
                                    $("#terName_fr").text(feature.properties.name_fr);
                                    $("#terEmail").html(feature.properties.email);
                                    $("#terPhone").html(feature.properties.phone);
                        
                                    for(var i=0;i<$scope.qtNames.length;i++){
                                        if($scope.qtNames[i].value==feature.properties.qtId){
                                            $("#terQt").html($scope.qtNames[i].name);
                                        } 
                                    }
                                    
                                    $('.ui.sidebar').sidebar('toggle');
                    
                                });   
                            }
                        });
                        $scope.terrains.addTo(map);
                    }
                    function errorCB(error){
                        console.log(error);
                    }
                }
            }
        }else{
            var data = {
                'qtId':$scope.qtId,
                'resTime': $scope.resTime
            }
            $http.post('/getResTers',data).then(successCB,errorCB);
            function successCB(response){
                $scope.terrains = L.geoJson(response.data.ters,{
                    onEachFeature : function(feature,layer){
                        layer.on('click',function(e){
                            $scope.terId = feature.properties.id;
                            $scope.terName = feature.properties.name_fr;
                            $("#terName_fr").text(feature.properties.name_fr);
                            $("#terEmail").html(feature.properties.email);
                            $("#terPhone").html(feature.properties.phone);
                
                            for(var i=0;i<$scope.qtNames.length;i++){
                                if($scope.qtNames[i].value==feature.properties.qtId){
                                    $("#terQt").html($scope.qtNames[i].name);
                                } 
                            }
                            
                            $('.ui.sidebar').sidebar('toggle');
            
                        });   
                    }
                });
                $scope.terrains.addTo(map);
            }
            function errorCB(error){
                console.log(error);
            }
        }
        var todayDate = new Date();
        $('#resCalendar').calendar({
            type: 'datetime',     
            firstDayOfWeek: 1,    
            constantHeight: true,
            today: true,
            startMode: 'day',
            monthFirst: false,
            disableMinute: true,
            minDate:todayDate,
            initialDate: null,
            text: {
                days: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                months: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
                monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                today: "Aujourd'hui",
                now: 'Maintenant',
                am: 'AM',
                pm: 'PM'
            },
            onChange: function (date, text, mode) {
                if(date){
                    $scope.terrains.removeFrom(map);
                    var rd = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()+' '+date.getHours()+':'+date.getMinutes();
                    $scope.resTime = rd;
                    var data = {
                        'qtId':$scope.qtId,
                        'resTime': $scope.resTime
                    }
                    $http.post('/getResTers',data).then(successCB,errorCB);
                    function successCB(response){
                        $scope.terrains = L.geoJson(response.data.ters,{
                            onEachFeature : function(feature,layer){
                                layer.on('click',function(e){
                                    $scope.terId = feature.properties.id;
                                    $scope.terName = feature.properties.name_fr;
                                    $("#terName_fr").text(feature.properties.name_fr);
                                    $("#terEmail").html(feature.properties.email);
                                    $("#terPhone").html(feature.properties.phone);
                        
                                    for(var i=0;i<$scope.qtNames.length;i++){
                                        if($scope.qtNames[i].value==feature.properties.qtId){
                                            $("#terQt").html($scope.qtNames[i].name);
                                        } 
                                    }
                                    
                                    $('.ui.sidebar').sidebar('toggle');
                    
                                });   
                            }
                        });
                        $scope.terrains.addTo(map);
                    }
                    function errorCB(error){
                        console.log(error);
                    }
                }
            }
        });
    }
    
    $('#resTerrBtn').click(function(){
        $http.post('/getUserType').then(sCallback,eCallback);
        function sCallback(res){
            if(res.data == 'etudiant' || res.data == 'enseignant'){
                $('#cinModal').modal({
                    autofocus: false,
                    closable:false,
                    onApprove:function(){
                        $http.post('/checkUserCin',{'cin':$('#cin').val()}).then(sCallback,eCallback);
                        function sCallback(res){

                            $('#btnCheckCin').removeClass('loading');
                            $('#btnCheckCin').removeClass('disabled');
                            $('.btnCloseModal').removeClass('disabled');

                            if(res.data== 'cin ok'){
                                $('#cin').popup('destroy');
                                $('#cinModal').modal('close');
                                resCalan();
                            }
                        
                        }
                        function eCallback(err){
                            console.log(err)
                        }
                    },
                    onDeny:function(){
                    }
                }).modal('show');
    }
        else{
            resCalan();
        }
}
function eCallback(err){
    console.log(err)
}

    });

    function resCalan(){
        $('#terrName').html($scope.terName);
        $('#terrPlanningModal').modal({
            autofocus: false,
            closable:false,
            onShow:function(){
                $('#resTerCalendar').calendar({
                    type: 'date',     
                    firstDayOfWeek: 1,    
                    constantHeight: true,
                    today: true,
                    startMode: 'day',
                    monthFirst: false,
                    initialDate: null,
                    minDate: initDate,
                    maxDate: endDate,
                    text: {
                      days: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                      months: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
                      monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                      today: "Aujourd'hui",
                      now: 'Maintenant',
                      am: 'AM',
                      pm: 'PM'
                    },
                    onChange: function (date, text, mode) {
                        $('.ui.sidebar').sidebar('hide');
                        $scope.currDate = date;
                        if(date.getFullYear()==initDate.getFullYear() && date.getMonth()==initDate.getMonth() && date.getDate()==initDate.getDate()){
                            $('#btnPrevDay').addClass('disabled');
                        }else{
                            $('#btnPrevDay').removeClass('disabled');
                        }
                        if(date.getFullYear()==endDate.getFullYear() && date.getMonth()==endDate.getMonth() && date.getDate()==endDate.getDate()){
                            $('#btnNextDay').addClass('disabled');
                        }else{
                            $('#btnNextDay').removeClass('disabled');
                        }

                        var data ={
                            'terId':$scope.terId,
                            'm':date.getMonth()+1,
                            'd':date.getDate(),
                            'y':date.getFullYear()
                        }

                        $http.post('/getResPlan',data).then(sCallback,eCallback);

                        function sCallback(response){
                            $('#resHours').html('');
                            var nowDate = new Date();
                            var nowYear = nowDate.getFullYear();
                            var nowMonth = nowDate.getMonth()+1;
                            var nowDay = nowDate.getDate();
                            var nowHour = nowDate.getHours();
                            
                            for(var i=0;i<24;i++){
                                var elt ='';
                                elt+='<div class="six columns row">';
                    
                                for(var j=0;j<6;j++){
                                  hr = i+j;
                                  var x = (nowDay == $scope.currDate.getDate() && nowMonth == ($scope.currDate.getMonth()+1) && nowYear == $scope.currDate.getFullYear() && hr <= nowHour);
                                  if(hr<10){
                                    if(x){
                                        elt += '<div class="column"><button class="ui disabled fluid button" onclick="makeRes(this)"> 0'+hr+' : 00</button></div>';
                                    }else{
                                        elt += '<div class="column"><button class="ui positive fluid button" onclick="makeRes(this)"> 0'+hr+' : 00</button></div>';
                                    }
                                       
                                  }else{
                                    if(x){
                                        elt += '<div class="column"><button class="ui disabled fluid button" onclick="makeRes(this)"> '+hr+' : 00</button></div>';
                                    }else{
                                        elt += '<div class="column"><button class="ui positive fluid button" onclick="makeRes(this)"> '+hr+' : 00</button></div>';
                                    }
                                    
                                  }     
                                }
                                elt+='</div>';
                                $('#resHours').append(elt);
                                i+=5
                            }
                            
                            
                            for(var i=0;i<response.data.resList.length;i++){
                                resDate = new Date(response.data.resList[i].res_start);
                                resHour = resDate.getHours();
                                
                                if(resHour<10){
                                  $($('#resHours .column')[resHour]).replaceWith('<div class="column"><button onclick="makeRes(this)" class="ui disabled fluid button"> 0'+resHour+' : 00</button></div>');
                                }else{
                                  $($('#resHours .column')[resHour]).replaceWith('<div class="column"><button onclick="makeRes(this)" class="ui disabled fluid button"> '+resHour+' : 00</button></div>');
                                }
                            }
                            for(var i=0;i<response.data.myResList.length;i++){
                                resDate = new Date(response.data.resList[i].res_start);
                                resId = response.data.resList[i].res_id;
                                resHour = resDate.getHours();
                                var x = (nowDay == $scope.currDate.getDate() && nowMonth == ($scope.currDate.getMonth()+1) && nowYear == $scope.currDate.getFullYear() && resHour <= nowHour);
                                if(x){
                                    $($($('#resHours .column')[resHour]).find('.button')).addClass('red');
                                }else{
                                    if(resHour<10){
                                        $($('#resHours .column')[resHour]).replaceWith('<div class="column"><button onclick="cancelRes('+resId+')" class="ui red fluid button"> 0'+resHour+' : 00</button></div>');
                                    }else{
                                        $($('#resHours .column')[resHour]).replaceWith('<div class="column"><button onclick="cancelRes('+resId+')" class="ui red fluid button"> '+resHour+' : 00</button></div>');
                                    }
                                }
                            }
                        }
                        function eCallback(error){
                            console.log(error);
                        }
                    }
                });
                $('#resTerCalendar').calendar('set date',ds,'true','true');
            }
        }).modal('show');
    }

    $('#btnSignupRedir').click(function(){
        $('.ui.sidebar').sidebar('hide');
        $("html, body").animate({
            scrollTop: 0
        },1000);
        $('#btnSignupUser').click();
    });
    
    $('#btnSignup2').click(function(){
        $('.ui.sidebar').sidebar('hide');
        $("html, body").animate({
            scrollTop: 0
        },1000);
        $('#btnSignupUser').click();
    });

    makeRes = function(hour){
        
        $('#resModalTitle').html('Reserver '+$scope.terName);
        $('#resStartLabel').html($(hour).html());
        var hr = parseInt($(hour).html().substr(0,3));
        if(hr<10 ){
            $('#resEndLabel').html('0'+(hr+1)+' : 00');
        }else{
            if(hr==23 ){
                $('#resEndLabel').html('00 : 00');
            }else{
                $('#resEndLabel').html((hr+1)+' : 00');
            }
        }
        $('#completeResModal').modal({
            autofocus: false,
            closable:false,
            onApprove:function(){

                if($('#typeResList').val()){
                    $('#btnApprove').addClass('loading');
                    $('#btnApprove').addClass('disabled');
                    $("#typeResList").parent().removeClass('error');
                    
                    var resData = {};
                    if($("#invTeam").val().length>0){
                        resData = {
                            'typeRes':$('#typeResList').val(),
                            'terId':$scope.terId,
                            'resStart':$scope.currDate.getFullYear()+'-'+($scope.currDate.getMonth()+1)+'-'+$scope.currDate.getDate() +' '+($(hour).html()).replace(/\s/g,''),
                            'invTeam':$("#invTeam").val()
                        }

                    }else{
                        resData = {
                            'typeRes':$('#typeResList').val(),
                            'terId':$scope.terId,
                            'resStart':$scope.currDate.getFullYear()+'-'+($scope.currDate.getMonth()+1)+'-'+$scope.currDate.getDate() +' '+($(hour).html()).replace(/\s/g,''),
                            'invTeam':'00'
                        }
                    }
                    

                    $http.post('/addRes',resData).then(rsCallback,reCallback);
                    function rsCallback(response){
                        $('#btnApprove').removeClass('loading');
                        $('#btnApprove').removeClass('disabled');
                        if(response.data == 'success'){
                            $('#alertMessage').html('<i class="info icon"></i>Réservation réussie !');
                            $('#warningModal')
                            .modal({
                              onHide: function(){
                                location.reload();
                              }
                            })
                            .modal('show');
                          }else{
                            $('#alertMessage').html('<i class="exclamation triangle red icon"></i>Votre abonnement a été expiré , veuillez le renouveler');
                            $('#warningModal').modal('show');
                        }
                    }
                    function reCallback(error){
                        console.log(error)
                    }


                }else{
                    $("#typeResList").parent().addClass('error');
                }
                return false;
            },
            onDeny:function(){
                $("#typeResList").parent().removeClass('error');
                $('#btnApprove').removeClass('loading');
                $('#btnApprove').removeClass('disabled');
                $("#typeResList").parent().dropdown('restore defaults');
                $("#invTeam").parent().dropdown('restore defaults');
                $('#terrPlanningModal').modal('show');
            }
        }).modal('show');
    }

    cancelRes = function(resId){
        resData = {
          'resId':resId
        }
        $('#confCancelResModal')
        .modal({
          closable  : false,
          onDeny    : function(){
            $("#typeResList").parent().removeClass('error');
            $('#btnApprove').removeClass('loading');
            $('#btnApprove').removeClass('disabled');
            $("#typeResList").parent().dropdown('restore defaults');
            $("#invTeam").parent().dropdown('restore defaults');
            $('#terrPlanningModal').modal('show');
            $('#terrPlanningModal').modal('show');
          },
          onApprove : function() {
    
            $http.post('/cancelRes',resData).then(delSCallback,delECallback);
    
            function delSCallback(r){
    
              if(r.data == 'success'){
                $('#alertMessage').html('<i class="info icon"></i>Reservation Annulée !');
                $('#warningModal')
                .modal({
                  onHide: function(){
                    location.reload();
                  }
                })
                .modal('show');
              }else{
                $('#alertMessage').html('<i class="exclamation triangle red icon"></i>Vous ne pouvez pas annuler cette réservation car il reste moins de deux heures pour commencer la session');
                $('#warningModal').modal('show');
              }
    
            }
            function delECallback(e){
              console.log(e)
            }
          }
        }).modal('show');
    }

    
    $("#btnPrevDay").click(function(){

        var yestDate = new Date($scope.currDate);
    
        yestDate.setDate($scope.currDate.getDate()-1);
    
        d = yestDate.getDate();
        m = yestDate.getMonth()+1;
        y = yestDate.getFullYear();

        $('#resTerCalendar').calendar('set date',d+'/'+m+'/'+y,'true','true');
    });
    
    $("#btnNextDay").click(function(){
        var tmrDate = new Date($scope.currDate);
        
        tmrDate.setDate($scope.currDate.getDate()+1);
      
        d = tmrDate.getDate();
        m = tmrDate.getMonth()+1;
        y = tmrDate.getFullYear();
    
        $('#resTerCalendar').calendar('set date',d+'/'+m+'/'+y,'true','true');
    });

    $('.subLabel').click(function(){
        $('.ui.sidebar').sidebar('hide');
        $("html, body").animate({
            scrollTop: 0
        },1000);
        $('#btnSignupUser').click();
    });
    
    var myPosition;
    $('#geolocate').click(function(){

        $('#mapDimmer').addClass('active');
        function onAccuratePositionFound (e) {
            $('#mapDimmer').removeClass('active');
            if(myPosition){
                myPosition.removeFrom(map);
            }
        
            var bleuIcon = L.icon({
                iconUrl: '/css/images/sp.png',
                iconSize:     [50, 50],
                popupAnchor:  [0, -20]
            });
            map.flyTo(e.latlng, 18,);

            myPosition =  L.marker(e.latlng,{icon: bleuIcon})
            .addTo(map)
            .bindPopup("Voila votre position").openPopup();
        }
        map.on('accuratepositionfound', onAccuratePositionFound);
        map.findAccuratePosition({
            maxWait: 2000,
            desiredAccuracy: 30
        });
    });
    $('.ui.sidebar')
            .sidebar({context:$('#mainMap')})
            .sidebar('setting', 'transition', 'overlay')
            .sidebar('setting','dimPage',false);
});

app.controller('abnSectController',function($http,$scope){
    
    
    showAbnInfo  = function(abT){
        
        if(abT){
            var abnInfo = abT.attributes.abnInfo.nodeValue.split(',');
        
            if(abnInfo.length>0){
                $('#abnMonths').removeClass('hidden');
                $('#abnHours').removeClass('hidden');
                $('#abnPrice').removeClass('hidden');
                $('#abnMonths').html(abnInfo[0]+' Jours');
                $('#abnHours').html(abnInfo[1]+' Heures');
                $('#abnPrice').html(abnInfo[2]+' USD');
            }else{
                $('#abnMonths').addClass('hidden');
                $('#abnHours').addClass('hidden');
                $('#abnPrice').addClass('hidden');
            }
        }
    }
    
    $('#newAbnBtn').click(function(){
        $('#abnModalTitle').html("S'abonner");
        $('#abnModal').modal({
            closable:false,
            autofocus:false,
            onApprove:function(){
                if($('#nvAbnType').val().length>0){
                    $('#btnApprovePay').addClass('loading');
                    $('#btnApprovePay').addClass('disabled');
                    $('#btnCancelPay').addClass('disabled');

                    data = {
                        'newAbn':'true',
                        'typeAbId': $('#nvAbnType').val()
                    }
    
                    $http.post('/paymentProcess',data).then(psCallback,peCallback);
    
                    function psCallback(response){
                        location.replace(response.data);
                        //console.log(response.data)
                    }
    
                    function peCallback(error){
                        console.log(error)
                    }
                }
                return false;
            },
            onDeny:function(){
                $('#nvAbnType').dropdown('restore defaults');
                $('#abnMonths').addClass('hidden');
                $('#abnHours').addClass('hidden');
                $('#abnPrice').addClass('hidden');
            }
        }).modal('show');
    });

    $('#reAbnBtn').click(function(){
        $('#abnModalTitle').html("S'abonner");
        $('#abnModal').modal({
            closable:false,
            autofocus:false,
            onApprove:function(){
                if($('#nvAbnType').val().length>0){
                    $('#btnApprovePay').addClass('loading');
                    $('#btnApprovePay').addClass('disabled');
                    $('#btnCancelPay').addClass('disabled');

                    data = {
                        'newAbn':'false',
                        'typeAbId': $('#nvAbnType').val()
                    }
    
                    $http.post('/paymentProcess',data).then(psCallback,peCallback);
    
                    function psCallback(response){
                        location.replace(response.data);
                    }
    
                    function peCallback(error){
                        console.log(error)
                    }
                }
                return false;
            },
            onDeny:function(){
                $('#nvAbnType').dropdown('restore defaults');
                $('#abnMonths').addClass('hidden');
                $('#abnHours').addClass('hidden');
                $('#abnPrice').addClass('hidden');
            }
        }).modal('show');
    });

    
});