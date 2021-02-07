var app = angular.module('FastFoot', ['ngRoute']);

app.controller('homeController',function($scope,$http){

  $('.masthead').visibility({
    once: false,
    onBottomPassed: function() {
      $('.fixed.menu').transition('fade in');
    },
    onBottomPassedReverse: function() {
      $('.fixed.menu').transition('fade out');
    }
  });

  // create sidebar and attach to menu open
  $('.ui.sidebar').sidebar('attach events', '.toc.item');

});

app.controller('navController',function($scope){
  $('.topButton').hide();
  $('#dashnavbar').visibility({
      once: false,
      onBottomPassed: function() {
        $('.topButton').transition('fade in');
        $('#hiddenNav').transition('fade in');
      },
      onBottomPassedReverse: function() {
        
        $('.topButton').transition('fade out');
        $('#hiddenNav').transition('fade out');

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
    })
    .modal('show');
  });

  $('.topButton').click(function () {
    $("html, body").animate({scrollTop: 0}, 1000);
  });
});

app.controller('eqController',function($scope,$http){

  $($(".navbaritem")[0]).addClass('active');
  $($("#hiddenNav").find(".navbaritem")[0]).addClass('active');

  var content = [];
  $.each($(".mainCard"),function(index,item){
    content.push({
      title:$(item).find('#teamTitle')[0].innerText,
      url: "#"+$(item)[0].id
    })
  });

  $('.topButton').click(function () {
      $("html, body").animate({scrollTop: 0}, 1000);
  });

  $('.ui.search')
  .search({
    source: content,
    onSelect : function(result,response){
      var id = result.url.replace('#','');
      $('#dim'+id).dimmer('show');
    }

  });
});

app.controller('terController',function($scope,$http){

  $($(".navbaritem")[1]).addClass('active');
  
  var map = L.map('map',{
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
  
  var options = {
    draw: {
        polyline: false,
        polygon:false,
        circle:false,
        circlemarker: false,
        rectangle:false,
        marker:false
    },
    edit: {
        featureGroup: drawnItems,
        remove:false
    }
  };

  var drawControl = new L.Control.Draw(options);
  //drawControl.addTo(map);

  var selectedFeature = null;
  var curLayer;
  var curId;
  var terrains;
  var quartiers;
  var editedLayer;
  var qtShown = false;
  var qtNames = [];
  $scope.currDate;
  $scope.currlayerId;

  $http.get('/admin/getTers').then(sGetQt, eGetQt);
  function sGetQt(response){

    quartiers = L.geoJSON(response.data[1],{
      onEachFeature : function(feature,layer){

        qtNames.push({
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

    $('#qtNames').dropdown({values: qtNames,placeholder:'Quartier'});

    if(localStorage.getItem("qtShown")!='false'){
      quartiers.addTo(map);
      localStorage.setItem('qtShown','true');
      $("#showQts").html('<i class="eye slash icon"></i>');
      $("#showQts").attr('data-tooltip','Masquer les quartiers');
    }else{
      $("#showQts").html('<i class="eye icon"></i>');
      $("#showQts").attr('data-tooltip','Afficher les quartiers');
    }

    terrains = L.geoJson(response.data[0],{
      onEachFeature : function(feature,layer){
        layer.on('click',function(e){
          
          curLayer = e.target;

          drawnItems._layers = {};
          drawnItems.addLayer(e.target);
          $scope.currlayerId = feature.properties.id

          $("#terName_fr").text(feature.properties.name_fr);
          $("#terName_ar").text(feature.properties.name_ar);
          $("#terEmail").html(feature.properties.email);
          $("#terPhone").html(feature.properties.phone);

          for(var i=0;i<qtNames.length;i++){
            if(qtNames[i].value==feature.properties.qtId){
              $("#terQt").html(qtNames[i].name);
            } 
          }
          
          $('.ui.sidebar').sidebar('toggle');

          var TodayDate = new Date();

          var d = TodayDate.getDate();
          var m = TodayDate.getMonth()+1;
          var y = TodayDate.getFullYear();

          $('#resCalendar').calendar('set date',d+'/'+m+'/'+y,'true','true');
        });   
      }
    });
    terrains.addTo(map);
    
  }

  function eGetQt(error){
    console.log(error);
  }

  var drawnLayer;
  map.on(L.Draw.Event.CREATED, function (event) {

    drawnLayer = event.layer;

    drawnItems.addLayer(drawnLayer);
    
     $('#addTerrModal')
    .modal({context:'#map',closable:false})
    .modal('show');
  });

  map.on(L.Draw.Event.EDITED, function (e) {

    var layers = e.layers;

    $('#qtNames').dropdown({values: qtNames,placeholder:'Quartier'});

    if(jQuery.isEmptyObject(layers._layers)){
      editedLayer = curLayer.toGeoJSON();
    }else{
      layers.eachLayer(function(layer){
        editedLayer = layer.toGeoJSON();
      });
    }
    
    $('#terrNameTitle').html(editedLayer.properties.name_fr);
    $('#terNameFrEdit').val(editedLayer.properties.name_fr);
    $('#terNameArEdit').val(editedLayer.properties.name_ar);
    $('#terrEmailEdit').val(editedLayer.properties.email);
    $('#terrTelEdit').val(editedLayer.properties.phone);
    $('#qtNamesEdit').dropdown({values: qtNames,placeholder:'Quartier'});
    $("#qtNamesEdit").dropdown('set selected', editedLayer.properties.qtId);

    $('#editTerrModal')
      .modal({context:'#map'})
      .modal('setting', 'closable', false)
      .modal('show');
  });

  map.on('draw:editstop', function (e) {

    map.removeControl(drawControl);

  });

  $("#addTerr").click(function(e){

    e.cancelBubble = true;
    if (e.stopPropagation) e.stopPropagation();

    new L.Draw.Marker(map).enable();

  });
  
  $("#showQts").click(function(){
    if(localStorage.getItem('qtShown')=='true'){
      quartiers.removeFrom(map);
      localStorage.setItem('qtShown','false');
      $("#showQts").html('<i class="eye icon"></i>');
      $("#showQts").attr('data-tooltip','Afficher les quartiers');
    }else{
      quartiers.addTo(map);
      localStorage.setItem('qtShown','true');
      $("#showQts").html('<i class="eye slash icon"></i>');
      $("#showQts").attr('data-tooltip','Masquer les quartiers');
    }
  });

  $("#btnAddTerr").click(function(){

    /* https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript*/
    var telRegex = new RegExp('\^[0][5-7]{1}[0-9]{8}$');
    var mailRegex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);

    $('#terNameFr').val($('#terNameFr').val().replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, ''));
    $('#terNameAr').val($('#terNameAr').val().replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, ''));

    if($('#terNameFr').val().length>0){

      $('#terNameFr').parent().removeClass('error');

      if($('#terNameAr').val().length>0){

        $('#terNameAr').parent().removeClass('error');

        if(mailRegex.test($('#terrEmail').val())){

          $('#terrEmail').parent().removeClass('error');

          if(telRegex.test($('#terrTel').val())){

            $('#terrTel').parent().removeClass('error');

            if($("#qtNames").find(".selected").attr('data-value')){

              $('#qtNames').removeClass('error');

              $('#btnAddTerr').addClass('loading');
              $('#btnAddTerr').addClass('disabled');

              var json = drawnLayer.toGeoJSON();
              var data = {
                'terrNameFr' : $('#terNameFr').val().trim(),
                'terrNameAr' :$('#terNameAr').val().trim(),
                'terrEmail' :$('#terrEmail').val().trim(),
                'terrPhone' :$('#terrTel').val().trim(),  
                'qtId' :$("#qtNames").find(".selected").attr('data-value'),              
                'geom': json.geometry
              }

              $http.post('/admin/addTerr', data).then(sCallback, eCallback);
              function sCallback(response){
                if(response.data=="success"){
                  $('#btnAddTerr').removeClass('loading');
                  $('#btnAddTerr').removeClass('disabled');
                  
                  $('#alertMessage').html('<i class="info icon"></i>Terrain Ajouté !');
                  $('#warningModal')
                  .modal({
                    onHide: function(){
                      location.reload();
                    }
                  })
                  .modal('show');
                }
              }

              function eCallback(error){
                console.log(error);
              }
            
            }else{
              $('#qtNames').addClass('error')
            }
          }else{

            $('#terrTel').parent().addClass('error')
          }
        }else{
          $('#terrEmail').parent().addClass('error')
        }
      }else{
        $('#terNameAr').parent().addClass('error')
      }
    }else{
      $('#terNameFr').parent().addClass('error')
    }
  });

  $('#btnCancelTerr').click(function(){
    $('#terNameFr').parent().removeClass('error');
    $('#terNameAr').parent().removeClass('error');
    $('#terrEmail').parent().removeClass('error');
    $('#terrTel').parent().removeClass('error');
    $('#qtNames').parent().removeClass('error');
    $('#terNameFr').val('');
    $('#terNameAr').val('');
    $('#terrEmail').val('');
    $('#terrTel').val('');
    $("#qtNames").dropdown('restore defaults');
    drawnItems.removeLayer(drawnLayer);
  });

  var myPosition;
  $('#geolocate').click(function(){
    function onAccuratePositionFound (e) {
      if(myPosition){
        myPosition.removeFrom(map);
      }
      
        var greenIcon = L.icon({
            iconUrl: '/css/images/sp.png',
            iconSize:     [50, 50],
            popupAnchor:  [0, -20]
        });
        map.setView(e.latlng, 18);

        myPosition =  L.marker(e.latlng,{icon: greenIcon})
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
        .sidebar({context:$('#map')})
        .sidebar('setting', 'transition', 'overlay');

  $('#resCalendar').calendar({
    type: 'date',     
    firstDayOfWeek: 1,    
    constantHeight: true,
    today: true,
    startMode: 'day',
    monthFirst: false,
    initialDate: null,
    text: {
      days: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
      months: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Orctobre', 'Novembre', 'Decembre'],
      monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      today: "Aujourd'hui",
      now: 'Maintenant',
      am: 'AM',
      pm: 'PM'
    },
    onChange: function (date, text, mode) {
      $scope.currDate = date;

      $('#resHours').html('');

      var data ={
        'terrain_id':$scope.currlayerId,
        'month':date.getMonth()+1,
        'day':date.getDate(),
        'year':date.getFullYear()

      }
      $('td.positive').popup();

      $http.post('/admin/getTerRes', data).then(sCallback, eCallback);
      function sCallback(response){

        if(response.data.status=='success'){
          var resHour;
          var resDate;

          for(var i=0;i<24;i++){
            var elt ='';
            elt+='<tr>';

            for(var j=0;j<6;j++){
              hr = i+j;
              if(hr<10){
                elt += '<td> 0'+hr+' : 00</td>';
              }else{
                elt += '<td> '+hr+' : 00</td>';
              }     
            }
            elt+='</tr>';
            $('#resHours').append(elt);
            i+=5
          }
        }

        for(var i=0;i<response.data.data.length;i++){
          resDate = new Date(response.data.data[i].res_start);
          resHour = resDate.getHours();
          if(resHour<10){
            $($('#resHours td')[resHour]).replaceWith('<td class="positive" data-tooltip="'+response.data.data[i].team_name+' : '+response.data.data[i].typeres_name+'" data-position="bottom right" data-variation="mini"> 0'+resHour+' : 00</td>');
          }else{
            $($('#resHours td')[resHour]).replaceWith('<td class="positive" data-tooltip="'+response.data.data[i].team_name+' : '+response.data.data[i].typeres_name+'" data-position="top center" data-variation="mini"> '+resHour+' : 00</td>');
          }
        }

      }
      function eCallback(error){
        console.log(error);
      }
    }
  });

  $("#btnPrevDay").click(function(){
    var yestDate = new Date($scope.currDate);

    yestDate.setDate($scope.currDate.getDate()-1);

    d = yestDate.getDate();
    m = yestDate.getMonth()+1;
    y = yestDate.getFullYear();

    $('#resCalendar').calendar('set date',d+'/'+m+'/'+y,'true','true');
  });

  $("#btnNextDay").click(function(){
    var tmrDate = new Date($scope.currDate);
    
    tmrDate.setDate($scope.currDate.getDate()+1);
  
    d = tmrDate.getDate();
    m = tmrDate.getMonth()+1;
    y = tmrDate.getFullYear();

    $('#resCalendar').calendar('set date',d+'/'+m+'/'+y,'true','true');
  });

  $('#editTerrBtn').click(function(){
    $('.ui.sidebar').sidebar('hide');
    drawControl.addTo(map);
    $('.leaflet-draw-edit-edit')[0].click();
  });

  $('#btnCancelEditTerr').click(function(){
    $('#terrNameTitle').val('');
    $('#terNameFrEdit').val('');
    $('#terNameArEdit').val('');
    $('#terrEmailEdit').val('');
    $('#terrTelEdit').val('');
    $("#qtNamesEdit").dropdown('set selected', '');
  });

  $('#btnEditTerr').click(function(){
    var telRegex = new RegExp('\^[0][5-7]{1}[0-9]{8}$');
    var mailRegex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);

    $('#terNameFrEdit').val($('#terNameFrEdit').val().replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, ''));
    $('#terNameArEdit').val($('#terNameArEdit').val().replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, ''));

    if($('#terNameFrEdit').val().length>0){

      $('#terNameFrEdit').parent().removeClass('error');

      if($('#terNameArEdit').val().length>0){

        $('#terNameArEdit').parent().removeClass('error');

        if(mailRegex.test($('#terrEmailEdit').val())){

          $('#terrEmailEdit').parent().removeClass('error');

          if(telRegex.test($('#terrTelEdit').val())){

            $('#terrTelEdit').parent().removeClass('error');

            if($("#qtNamesEdit").find(".selected").attr('data-value')){

              $('#qtNamesEdit').removeClass('error');

              $('#btnAddTerrEdit').addClass('loading');
              $('#btnAddTerrEdit').addClass('disabled');

              var data = {
                'terrId':editedLayer.properties.id,
                'terrNameFr' : $('#terNameFrEdit').val().trim(),
                'terrNameAr' :$('#terNameArEdit').val().trim(),
                'terrEmail' :$('#terrEmailEdit').val().trim(),
                'terrPhone' :$('#terrTelEdit').val().trim(),  
                'qtId' :$("#qtNamesEdit").find(".selected").attr('data-value'),              
                'geom': editedLayer.geometry
              }

              $http.post('/admin/editTerr', data).then(sCallback, eCallback);
              function sCallback(response){
                if(response.data=="success"){
                  $('#btnAddTerr').removeClass('loading');
                  $('#btnAddTerr').removeClass('disabled');
                  $('#alertMessage').html('<i class="info icon"></i>Terrain Modifié !');
                  $('#warningModal')
                  .modal({
                    onHide: function(){
                      location.reload();
                    }
                  })
                  .modal('show');
                }
              }

              function eCallback(error){
                console.log(error);
              }
            
            }else{
              $('#qtNamesEdit').addClass('error')
            }
          }else{

            $('#terrTelEdit').parent().addClass('error')
          }
        }else{
          $('#terrEmailEdit').parent().addClass('error')
        }
      }else{
        $('#terNameArEdit').parent().addClass('error')
      }
    }else{
      $('#terNameFrEdit').parent().addClass('error')
    }
  });

  $('#deleteTerrBtn').click(function(){

    var qtId = this.name;
    var data = {
      'terrId' : $scope.currlayerId
    }
    
    $('#delTerrModal')
    .modal({
      closable  : false,
      onDeny    : function(){
        
      },
      onApprove : function() {
        
        $http.post('/admin/deleteTerr',data).then(sDelQt,eDelQt);
        function sDelQt(response){
          if(response.data=="success"){

            $('#alertMessage').html('<i class="info icon"></i>Terrain Supprimé !');
            $('#warningModal')
            .modal({
              onHide: function(){
                location.reload();
              }
            })
            .modal('show');

          }else if(response.data=="reserved"){

            $('#alertMessage').html('<i class="info icon"></i>Vous ne pouvez pas supprimer ce terrain car il contient des reservations');
            $('#warningModal').modal('show');

          }
        
        }
        function eDelQt(error){
          console.log(error);
        }

      }
    })
    .modal('show');
  });

  $('.leaflet-control-zoom').find('a')[0].innerHTML ='<i class="search plus icon"></i>';
  $($('.leaflet-control-zoom').find('a')[0]).addClass('small circular olive icon button');
  $($('.leaflet-control-zoom').find('a')[0]).removeClass('leaflet-control-zoom-in');
  $('.leaflet-control-zoom').find('a')[1].innerHTML ='<i class="search minus icon"></i>';
  $($('.leaflet-control-zoom').find('a')[1]).removeClass('leaflet-control-zoom-out');
  $($('.leaflet-control-zoom').find('a')[1]).addClass('big circular olive icon button');

});

app.controller('qtController',function($scope,$http){

  $('.ui.accordion').accordion();

  $($(".navbaritem")[2]).addClass('active');

  var map = L.map('map',{
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

  var options = {
      draw: {
          polyline: false,
          polygon:false,
          circle:false,
          circlemarker: false,
          rectangle:false,
          marker:false
      },
      edit: {
          featureGroup: drawnItems,
          remove:false
      }
  };

  var drawControl = new L.Control.Draw(options);
  
  var selectedFeature = null;
  var curLayer;
  var curId;
  var quartiers;
  var editedLayer;

  $http.get('/admin/getQts').then(sGetQt, eGetQt);
  function sGetQt(response){
    
    quartiers = L.geoJson(response.data,{
      onEachFeature : function(feature,layer){
        var letters = '0123456789ABCDEF';
        var randColor = '#';
        for (var i = 0; i < 6; i++) {
          randColor += letters[Math.floor(Math.random() * 16)];
        }
        layer.bindTooltip(feature.properties.name_fr);
        layer.setStyle({fillColor: randColor, color: randColor, opacity: 0.7});

        layer.on('click',function(e){
        

          curLayer = e.target;
          curId = curLayer.feature.properties.id;

          drawnItems._layers = {};
          drawnItems.addLayer(e.target);
          
          $("#qtName").text(feature.properties.name_fr);
          $("#teamsCount").html('<i class="users icon"></i>  '+ feature.properties.qtData.teams.length);
          $("#stadCount").html('<i class="flag checkered icon"></i>  '+ feature.properties.qtData.terrains.length);
          $('#deleteQtBtn').attr('name',feature.properties.id);

          $("#qtTeams").click(function(){
            
            $('#qtModalItems').html('');
            $('#qtModalCards').html('');
            $("#qtModalTitle").html(curLayer.feature.properties.name_fr);
            $.each(curLayer.feature.properties.qtData.teams,function(index,team){
              console.log(team)
              var card = '<div class="ui tiny card">';
              card += '<div class="content">';
              card += '<div class="ui center aligned header">'+team.team_name+'</div>';
              card += '</div>';
              card += '</div>';

              $('#qtModalCards').append(card);
            });

            if($("#teamsCount").html()!='<i class="users icon"></i>  0'){
              $("#qtDataModal").removeClass('mini');
              $("#qtDataModal").addClass('small');
              $('#qtDataModal')
                .modal({
                  context:'#map'
                })
                .modal('show');

            }else{
              $('#alertMessage').html("<i class='info icon'></i>Pas d'equipes !");
              $('#warningModal')
                .modal({
                  context:'#map'
                })
                .modal('show');
            }
            
          });

          $("#qtTerrains").click(function(){
            $('#qtModalCards').html('');
            $('#qtModalItems').html('');
            $("#qtModalTitle").html(curLayer.feature.properties.name_fr);
            $.each(curLayer.feature.properties.qtData.terrains,function(index,terrain){
              var item = '<div class="item">';
              item += '<div class="content">';
              item += '<div class="header">'+terrain.terrain_name_fr+'</div>';
              item += '<div class="extra">';
              item += '<a href="mailto:'+terrain.terrain_email+'" target="_top" class="ui label"><i class="envelope outline icon"></i>'+terrain.terrain_email+'</a>';
              item += '<a href="tel:'+terrain.terrain_phone+'" class="ui label"><i class="phone icon"></i>'+terrain.terrain_phone+'</a>';
              item += '</div>';
              item += '</div>';
              item += '</div>';

              $('#qtModalItems').append(item);
            });

            if($("#stadCount").html()!='<i class="flag checkered icon"></i>  0'){
              $("#qtDataModal").removeClass('small');
              $("#qtDataModal").addClass('mini');
              $('#qtDataModal')
                .modal({
                  context:'#map'
                })
                .modal('show');

            }else{
              $('#alertMessage').html("<i class='info icon'></i>Pas de terrains !");
              $('#warningModal')
                .modal({
                  context:'#map'
                })
                .modal('show');
            }
            
          });
  
          $('.ui.sidebar').sidebar('toggle');
        });

        
      }
    });
    quartiers.addTo(map);
    
  }

  function eGetQt(error){
    console.log(error);
  }

  
  var drawnLayer;
  map.on(L.Draw.Event.CREATED, function (event) {

    drawnLayer = event.layer;

    drawnItems.addLayer(drawnLayer);
    
    $('#addQtModal')
      .modal({context:'#map'})
      .modal('setting', 'closable', false)
      .modal('show');
  });

  map.on(L.Draw.Event.EDITED, function (e) {

    var layers = e.layers;

    if(jQuery.isEmptyObject(layers._layers)){
      editedLayer = curLayer.toGeoJSON();
    }else{
      layers.eachLayer(function(layer){
        editedLayer = layer.toGeoJSON();
      });
    }
    
    $('#editqtNameFr').val(editedLayer.properties.name_fr);
    $('#editqtNameAr').val(editedLayer.properties.name_ar);

    $('#editQtModal')
      .modal({context:'#map'})
      .modal('setting', 'closable', false)
      .modal('show');

  });
  map.on('draw:editstop', function (e) {

    map.removeControl(drawControl);

  });

  $('#deleteQtBtn').click(function(){

    var qtId = this.name;
    var data = {
      'qtId' : qtId
    }
    
    $('#confirmModal')
    .modal({
      closable  : false,
      onDeny    : function(){
        
      },
      onApprove : function() {
        
        $.each(drawnItems._layers, function( index, layer ) {

          if(layer.feature.properties.id == qtId){
            var qtData = layer.feature.properties.qtData;

            if(qtData.teams.length == 0 && qtData.terrains.length == 0){

              $http.post('/admin/delQt',data).then(sDelQt,eDelQt);
              function sDelQt(response){
                if(response.data=="success"){

                  $('#alertMessage').html('<i class="info icon"></i>Quartier Supprimé !');
                  $('#warningModal')
                  .modal({
                    onHide: function(){
                      location.reload();
                    }
                  })
                  .modal('show');

                }
              }
              function eDelQt(error){
                console.log(error);
              }

            }else{
              $('#alertMessage').html('<i class="info icon"></i>Vous ne pouvez pas supprimer ce quartier car il est deja associé');
              $('#warningModal').modal('show');
            }
          }
        });

      }
    })
    .modal('show');
  });
  $('#btnCancelQt').click(function(){
    $('#qtNameFr').parent().removeClass('error');
    $('#qtNameAr').parent().removeClass('error');
    $('#qtNameFr').val('');
    $('#qtNameAr').val('');
    drawnItems.removeLayer(drawnLayer);
    
  });
  $('#btnAddQt').click(function(){

    if($('#qtNameFr').val().length>0){

      $('#qtNameFr').parent().removeClass('error');

      if($('#qtNameAr').val().length>0){

        $('#qtNameAr').parent().removeClass('error');
        $('#btnAddQt').addClass('loading');
        $('#btnAddQt').addClass('disabled');
        var json = drawnLayer.toGeoJSON();
        var data = {
          'qtNameFr' : $('#qtNameFr').val().trim(),
          'qtNameAr' :$('#qtNameAr').val().trim(),
          'geom': json.geometry
        }

        $http.post('/admin/addQt', data).then(sCallback, eCallback);
        function sCallback(response){
          if(response.data=="success"){
            $('#btnAddQt').removeClass('loading');
            $('#btnAddQt').removeClass('disabled');
            $('#alertMessage').html('<i class="info icon"></i>Quartier Ajouté !');
            $('#warningModal')
            .modal({
              onHide: function(){
                location.reload();
              }
            })
            .modal('show');
          }
        }

        function eCallback(error){
          console.log(error);
        }
      }else{

        $('#qtNameAr').parent().removeClass('error')
      }
    }else{

      $('#qtNameFr').parent().addClass('error')
    }

  });
  
  $("#editQtBtn").click(function(){

    $('.ui.sidebar').sidebar('hide');
    drawControl.addTo(map);
    $('.leaflet-draw-edit-edit')[0].click();
    
  });

  $("#btnEditQt").click(function(){

    if($('#editqtNameFr').val().length>0){

      $('#editqtNameFr').parent().removeClass('error');

      if($('#editqtNameAr').val().length>0){

        $('#editqtNameAr').parent().removeClass('error');
        $('#btnEditQt').addClass('loading');
        $('#btnEditQt').addClass('disabled');

        var data = {
          'id' : editedLayer.properties.id,
          'qtNameFr' : $('#editqtNameFr').val().trim(),
          'qtNameAr' :$('#editqtNameAr').val().trim(),
          'geom': editedLayer.geometry
        }

        $http.post('/admin/editQt', data).then(sCallback, eCallback);
        function sCallback(response){
          if(response.data=="success"){
            $('#btnEditQt').removeClass('loading');
            $('#btnEditQt').removeClass('disabled');
            $('#alertMessage').html('<i class="info icon"></i>Quartier Modifié !');
            $('#warningModal')
            .modal({
              onHide: function(){
                location.reload();
              }
            })
            .modal('show');
          }
        }

        function eCallback(error){
          console.log(error);
        }
      }else{

        $('#editqtNameAr').parent().removeClass('error')
      }
    }else{

      $('#editqtNameFr').parent().addClass('error')
    }
  });
  $('#btnCancelEditQt').click(function(){
    $('#editqtNameFr').parent().removeClass('error');
    $('#editqtNameAr').parent().removeClass('error');
    $('#editqtNameFr').val('');
    $('#editqtNameAr').val('');
    editedLayer = null;
    
  });

  $('.leaflet-control-zoom').find('a')[0].innerHTML ='<i class="search plus icon"></i>';
  $($('.leaflet-control-zoom').find('a')[0]).addClass('small circular olive icon button');
  $($('.leaflet-control-zoom').find('a')[0]).removeClass('leaflet-control-zoom-in');
  $('.leaflet-control-zoom').find('a')[1].innerHTML ='<i class="search minus icon"></i>';
  $($('.leaflet-control-zoom').find('a')[1]).removeClass('leaflet-control-zoom-out');
  $($('.leaflet-control-zoom').find('a')[1]).addClass('big circular olive icon button');
  
  var myPosition;
  $('#geolocate').click(function(){
    function onAccuratePositionFound (e) {
      if(myPosition){
        myPosition.removeFrom(map);
      }
      
        var greenIcon = L.icon({
            iconUrl: '/css/images/sp.png',
            iconSize:     [50, 50],
            popupAnchor:  [0, -20]
        });
        map.setView(e.latlng, 18);

        myPosition =  L.marker(e.latlng,{icon: greenIcon})
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
        .sidebar({context:$('#map')})
        .sidebar('setting', 'transition', 'overlay')

  $('#addQt').click(function(){
    new L.Draw.Polygon(map, drawControl.options.polygon).enable();
  });
});

app.controller('resController',function($scope,$http){

  $scope.currDate;

  $scope.currTer;

  $($(".navbaritem")[3]).addClass('active');
  $($("#hiddenNav").find(".navbaritem")[3]).addClass('active');
  
  $('.menu .item').tab();

  showEqRes = function (t){
    $('#eqResModal').modal({
      centered: false,
      autofocus: false,
      allowMultiple: false,
      onShow: function(){
        $('#eqResCalendar').calendar({
          type: 'date',     
          firstDayOfWeek: 1,    
          constantHeight: true,
          today: true,
          startMode: 'day',
          monthFirst: false,
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

            $scope.currDate = date;
            
            var data ={
              'teamId':t.team_id,
              'm':date.getMonth()+1,
              'd':date.getDate(),
              'y':date.getFullYear()
            }

            $http.post('/admin/getResEq',data).then(sCallback,eCallback);

            function sCallback(response){

              $('#eqResList').html('');

              if(response.data.length>0){
                $.each(response.data,function(index,res){

                  var now = new Date();
                  var resDate = new Date(res.res_start);

                  var diffDays = Math.ceil((resDate.getTime() - now.getTime()) / (1000 * 3600 * 24)); 

                  now = now.getDate()+'/'+now.getMonth()+'/'+now.getFullYear();
                  resDate = resDate.getDate()+'/'+resDate.getMonth()+'/'+resDate.getFullYear();

                  var item = '<div class="item">';
                  item += '<div class="content">';

                  item += '<h3 class="ui olive header">'+res.res_start.substring(11, 16)+'</h3>';

                  item += '<div class="meta">';
                  item += '<span class="cinema">Type de reservation : '+res.typeres_name+'</span><br><br>';
                  item += '<span class="cinema">Terrain : '+res.terrain_name_fr+'</span>';
                  item += '</div>';

                  item += '<div class="extra">';
                  
                  if(diffDays>=0){
                    item += '<div onclick="cancelRes('+res.res_id+')" class="ui right floated negative button"><i class="remove icon"></i>Anuuler</div>';
                  }
                  item += '<div class="ui label"><i class="hourglass start icon"></i>Debut : '+res.res_start.substring(11, 16)+'</div>';
                  item += '<div class="ui label"><i class="hourglass end icon"></i>Fin : '+res.res_end.substring(11, 16)+'</div>';
                  item += '</div>';

                  item += '</div>';
                  item += '</div>';

                  $('#eqResList').append(item);
                  resData = {
                    'resId':res.res_id
                  }
                 
                });
              }
            }
            function eCallback(error){
              console.log(error);
            }
          }
        });
      }
    }).modal('show');

    $scope.currDate = new Date();

    var dd =  $scope.currDate.getDate();
    var mm =  $scope.currDate.getMonth()+1;
    var yy =  $scope.currDate.getFullYear();

    var ds = dd+'/'+mm+'/'+yy;
    
    $('#eqResCalendar').calendar('set date',ds,'true','true');

    $('#eqLogo').attr('src','/storage/eqLogos/'+t.logo);
    $('#teamTitle').html('Les Reservations du '+t.team_name);
    $('#eqQtName').html('<i class="map signs icon"></i>'+t.quartier_name_fr);
    $('#eqEmail').html('<i class="envelope icon"></i>'+t.team_email);
    $('#eqPhone').html('<i class="phone icon"></i>'+t.phone);
  };

  var map = L.map('miniMap',{
    zoomControl: false
  });
  map.setView([33.5722678, -7.6570322], 12);
  map.dragging.enable();
  L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
      maxZoom: 20,
      subdomains:['mt0','mt1','mt2','mt3'],
      attribution: '© Google Maps'     
  }).addTo(map);
  

  showTerRes =  function(t){

    $('#terResModal').modal({
      centered: false,
      autofocus: false,
      allowMultiple: false,
      onShow:function(){
        $('#terResCalendar').calendar({
          type: 'date',     
          firstDayOfWeek: 1,    
          constantHeight: true,
          today: true,
          startMode: 'day',
          monthFirst: false,
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

            $scope.currDate = date;
            
            var data ={
              'terId':t.terrain_id,
              'm':date.getMonth()+1,
              'd':date.getDate(),
              'y':date.getFullYear()
            }

            $http.post('/admin/getResTer',data).then(sCallback,eCallback);

            function sCallback(response){

              $('#terResList').html('');

              if(response.data.length>0){
                $.each(response.data,function(index,res){

                  var now = new Date();
                  var resDate = new Date(res.res_start);

                  var diffDays = Math.ceil((resDate.getTime() - now.getTime()) / (1000 * 3600 * 24));

                  now = now.getDate()+'/'+now.getMonth()+'/'+now.getFullYear();
                  resDate = resDate.getDate()+'/'+resDate.getMonth()+'/'+resDate.getFullYear();

                  var item = '<div class="item">';
                  item += '<div class="content">';

                  item += '<h3 class="ui olive header">'+res.res_start.substring(11, 16)+'</h3>';

                  item += '<div class="meta">';
                  item += '<span class="cinema">Type de reservation : '+res.typeres_name+'</span><br><br>';
                  item += '<span class="cinema">Equipe : '+res.team_name+'</span>';
                  item += '</div>';

                  item += '<div class="extra">';
                  resData = {
                    'resId':res.res_id
                  }
                  if(diffDays>=0){
                    item += '<div onclick="cancelRes('+res.res_id+')" class="ui right floated negative button"><i class="remove icon"></i>Anuuler</div>';
                  }
                  item += '<div class="ui label"><i class="hourglass start icon"></i>Debut : '+res.res_start.substring(11, 16)+'</div>';
                  item += '<div class="ui label"><i class="hourglass end icon"></i>Fin : '+res.res_end.substring(11, 16)+'</div>';
                  item += '</div>';

                  item += '</div>';
                  item += '</div>';

                  $('#terResList').append(item);
                  
                
                });
              }
            }
            function eCallback(error){
              console.log(error);
            }
          }
        });
      },
      onHide:function(){
        $scope.currTer.removeFrom(map);
        $scope.currTer = undefined;
      },
      onVisible:function(){
        map.invalidateSize();
        $('#miniMap').css('z-index','14');
        $('#terQtName').css('z-index','15');
        $('#terEmail').css('z-index','15');
        $('#terPhone').css('z-index','15');

        terCoords = JSON.parse(t.latlngs).coordinates;
        terCoords = [terCoords[1], terCoords[0]];

        map.setView(terCoords, 16);
        $scope.currTer = L.marker(terCoords);
        $scope.currTer.addTo(map);
        $scope.currTer.bindTooltip(t.terrain_name_fr);
      }
    }).modal('show');

    
    $scope.currDate = new Date();

    var dd =  $scope.currDate.getDate();
    var mm =  $scope.currDate.getMonth()+1;
    var yy =  $scope.currDate.getFullYear();

    var ds = dd+'/'+mm+'/'+yy;
    
    $('#terResCalendar').calendar('set date',ds,'true','true');

    
    $('#terTitle').html('Les Reservations du '+t.terrain_name_fr);
    $('#terQtName').html('<i class="map signs icon"></i>'+t.quartier_name_fr);
    $('#terEmail').html('<i class="envelope icon"></i>'+t.terrain_email);
    $('#terPhone').html('<i class="phone icon"></i>'+t.terrain_phone);
  }
  cancelRes = function(resId){
    resData = {
      'resId':resId
    }
    $('#confCancelResModal')
    .modal({
      closable  : false,
      onDeny    : function(){
        
      },
      onApprove : function() {

        $http.post('/admin/delRes',resData).then(delSCallback,delECallback);

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

    $('#eqResCalendar').calendar('set date',d+'/'+m+'/'+y,'true','true');
  });

  $("#btnNextDay").click(function(){
    var tmrDate = new Date($scope.currDate);
    
    tmrDate.setDate($scope.currDate.getDate()+1);
  
    d = tmrDate.getDate();
    m = tmrDate.getMonth()+1;
    y = tmrDate.getFullYear();

    $('#eqResCalendar').calendar('set date',d+'/'+m+'/'+y,'true','true');
  });

  $("#btnPrevDayTer").click(function(){
     
    var yestDate = new Date($scope.currDate);

    yestDate.setDate($scope.currDate.getDate()-1);

    d = yestDate.getDate();
    m = yestDate.getMonth()+1;
    y = yestDate.getFullYear();

    $('#terResCalendar').calendar('set date',d+'/'+m+'/'+y,'true','true');
  });

  $("#btnNextDayTer").click(function(){
    var tmrDate = new Date($scope.currDate);
    
    tmrDate.setDate($scope.currDate.getDate()+1);
  
    d = tmrDate.getDate();
    m = tmrDate.getMonth()+1;
    y = tmrDate.getFullYear();

    $('#terResCalendar').calendar('set date',d+'/'+m+'/'+y,'true','true');
  });

});

app.controller('abController',function($scope,$http){

  $scope.startDate;

  $($(".navbaritem")[4]).addClass('active');
  $($("#hiddenNav").find(".navbaritem")[4]).addClass('active');

  $('.ui.dropdown').dropdown();

  $('#abStartDate').calendar({
    type: 'month',
    disableMinute: true,
    text: {
      months: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
      monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      today: "Aujourd'hui",
      now: 'Maintenant',
    },
    onChange: function (date, text, mode) {
      $('#abEndDate').calendar({
        type: 'month',
        minDate: date,
        startCalendar: $('#abStartDate'),
        disableMinute: true,
        text: {
          months: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
          monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          today: "Aujourd'hui",
          now: 'Maintenant',
        }
      });
    }
  });

  $('#abEndDate').calendar({
    type: 'month',
    disableMinute: true,
    text: {
      months: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
      monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      today: "Aujourd'hui",
      now: 'Maintenant',
    }
  });

  $('#resetFilter').click(function(){
    $('#typeAbs').dropdown('restore defaults');
    $('#abnTeamId').dropdown('restore defaults');
    $('#abStartDate').calendar('set date','');
    $('#abEndDate').calendar('set date','');
  });

  $('#findAbnBtn').click(function(){

    $('#abns').addClass('loading');
    
    var startDate = '';
    var endDate = '';
    var typeAbSelected = '';
    var abnTeamId = '';

    if($('#typeAbs').val()){
      typeAbSelected = $('#typeAbs').val();
    }

    if($('#abnTeamId').val()){
      abnTeamId = $('#abnTeamId').val();
    }

    if($('#abStartDate').calendar('get date')) {
      startDate = new Date($('#abStartDate').calendar('get date'));
      startDate =  (startDate.getFullYear())+'-'+(startDate.getMonth()+1)+'-'+(startDate.getDate());
    }
    if($('#abEndDate').calendar('get date')){
      endDate = new Date($('#abEndDate').calendar('get date'));
      endDate = (endDate.getFullYear())+'-'+(endDate.getMonth()+1)+'-'+(endDate.getDate());
    }

    var data = {
      'teamId':abnTeamId,
      'typeAbn' : typeAbSelected,
      'startDate': startDate,
      'endDate': endDate
    }

    $http.post('/admin/findAbn',data).then(fScallback,fEcallback);

    function fScallback(response){
      $('#abns').replaceWith($(response.data).find('#abns'));
    }

    function fEcallback(error){
      console.log(error)
    }
    
  });

});


app.controller('admController',function($scope,$http){
  $($(".navbaritem")[5]).addClass('active');
  $($("#hiddenNav").find(".navbaritem")[5]).addClass('active');

  makeRoot = function(ad){
    $('#makeRootModal').modal({
      closable  : false,
      onDeny    : function(){
        
      },
      onApprove : function() {

        $http.post('/admin/makeRoot',ad).then(delSCallback,delECallback);

        function delSCallback(r){

          if(r.data == 'success'){
            $('#alertMessage').html('<i class="info icon"></i>cet Admin est maintenant un ROOT !');
            $('#warningModal')
            .modal({
              onHide: function(){
                location.reload();
              }
            })
            .modal('show');
          }else{
            if(r.data=='alreadyRoot'){
              $('#alertMessage').html('<i class="info icon"></i>Cet Admin est deja un ROOT');
              $('#warningModal').modal('show');
            }else{
              $('#alertMessage').html('<i class="info icon"></i>Vous ne pouvez pas le rendre ROOT');
              $('#warningModal').modal('show');
            }
            
          }

        }
        function delECallback(e){
          console.log(e)
        }
      }
    }).modal('show');
  }

  removeAdmin = function(ad){

    $('#delAdminModal').modal({
      closable  : false,
      onDeny    : function(){
        
      },
      onApprove : function() {

        $http.post('/admin/delAdmin',ad).then(delSCallback,delECallback);

        function delSCallback(r){

          if(r.data == 'success'){
            $('#alertMessage').html('<i class="info icon"></i>Admin Supprimé !');
            $('#warningModal')
            .modal({
              onHide: function(){
                location.reload();
              }
            })
            .modal('show');
          }else{
            $('#alertMessage').html('<i class="info icon"></i>Vous ne pouvez pas supprimer cet admin');
            $('#warningModal').modal('show');
          }

        }
        function delECallback(e){
          console.log(e)
        }
      }
    }).modal('show');
  }

  $('#btnAddAdmin').click(function(){
    $('#addAdminModal').modal({
      closable:false
    }).modal('show');
  });

  $('#btnConfAddAdmin').click(function(){
     /* https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript*/
     var telRegex = new RegExp('\^[0][5-7]{1}[0-9]{8}$');
     var mailRegex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
 
     $('#adminName').val($('#adminName').val().replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, ''));
 
     if($('#adminName').val().length>0){
 
       $('#adminName').parent().removeClass('error');
 
       if($('#badgeNum').val().length>0){
 
         $('#badgeNum').parent().removeClass('error');
 
         if(mailRegex.test($('#adminEmail').val())){
 
           $('#adminEmail').parent().removeClass('error');
 
           if(telRegex.test($('#adminTel').val())){
 
             $('#adminTel').parent().removeClass('error');
 
             if($('#pwdAdmin').val().length>=8){
 
               $('#pwdAdmin').removeClass('error');
               $('#pwdAdmin').popup('destroy');

               if($('#pwdAdmin').val()==$('#confPwdAmdin').val()){

                $('#confPwdAmdin').popup('destroy');
                $('#confPwdAmdin').removeClass('error');
                $('#btnConfAddAdmin').addClass('loading');
                $('#btnConfAddAdmin').addClass('disabled');
 
                
                var data = {
                  'adminName' : $('#adminName').val().trim(),
                  'adminBagde' :$('#badgeNum').val().trim(),
                  'adminEmail' :$('#adminEmail').val().trim(),
                  'adminPhone' :$('#adminTel').val().trim(),
                  'adminPassword' :$('#pwdAdmin').val(),  
                  
                }
  
                $http.post('/admin/addAdmin', data).then(sCallback, eCallback);
                function sCallback(response){
                  if(response.data=="success"){
                    $('#btnConfAddAdmin').removeClass('loading');
                    $('#btnConfAddAdmin').removeClass('disabled');
                    $('#alertMessage').html('<i class="info icon"></i>Admin Ajouté !');
                    $('#warningModal')
                    .modal({
                      onHide: function(){
                        location.reload();
                      }
                    })
                    .modal('show');
                  }else{
                    $('#btnConfAddAdmin').removeClass('loading');
                    $('#btnConfAddAdmin').removeClass('disabled');
                    $('#alertMessage').html('<i class="exclamation triangle red icon"></i>'+response.data+' !');
                    $('#warningModal')
                    .modal({
                      onHidden: function(){
                        $('#addAdminModal').modal({
                          closable:false
                        }).modal('show');
                      }
                    })
                    .modal('show');
                  }
                }
  
                function eCallback(error){
                  console.log(error);
                }
             
               }else{
                $('#confPwdAmdin').popup({
                  content : 'Confirmez votre mot de passe'
                }).popup('toggle');
                $('#confPwdAmdin').addClass('error');

               }
             }else{
               
               $('#pwdAdmin').popup({
                content : 'le mot de passe devrait avoir 8 caractères ou plus'
              }).popup('toggle');
              $('#pwdAdmin').addClass('error');
             }
           }else{
 
             $('#adminTel').parent().addClass('error');
           }
         }else{
           $('#adminEmail').parent().addClass('error');
         }
       }else{
         $('#badgeNum').parent().addClass('error');
       }
     }else{
       $('#adminName').parent().addClass('error');
     }
  });
  $('#btnCancelAdd').click(function(){
    $('#adminName').val('');
    $('#adminName').parent().removeClass('error');
    $('#badgeNum').val('');
    $('#badgeNum').parent().removeClass('error');
    $('#adminEmail').val('');
    $('#adminEmail').parent().removeClass('error');
    $('#adminTel').val('');
    $('#adminTel').parent().removeClass('error');
    $('#pwdAdmin').val('');
    $('#pwdAdmin').parent().removeClass('error');
    $('#confPwdAmdin').val('');
    $('#confPwdAmdin').parent().removeClass('error');
    $('#pwdAdmin').popup('destroy');
    $('#confPwdAmdin').popup('destroy');
  });

  editAdmin = function(ad){
    $('#badgeNumEdit').html(ad.admin_badge);
    $('#adminNameEdit').val(ad.admin_name);
    $('#adminTelEdit').val(ad.admin_phone);
    $('#editAdminModal').modal({
      closable:false
    }).modal('show');

    $('#btnConfEditAdmin').click(function(){

      $('#adminNameEdit').val($('#adminNameEdit').val().replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, ''));
      var telRegex = new RegExp('\^[0][5-7]{1}[0-9]{8}$');
 
      if($('#adminNameEdit').val().length>0){
 
        $('#adminNameEdit').parent().removeClass('error');
 
        if(telRegex.test($('#adminTelEdit').val())){
 
          $('#adminTelEdit').parent().removeClass('error');
            
          if($('#pwdAdminEdit').val().length>=8){
               
            $('#pwdAdminEdit').removeClass('error');            
            $('#pwdAdminEdit').popup('destroy');
              
            if($('#pwdAdminEdit').val()==$('#confPwdAmdinEdit').val()){
                
              $('#confPwdAmdinEdit').popup('destroy');              
              $('#confPwdAmdinEdit').removeClass('error');
              $('#btnConfEditAdmin').addClass('loading');
              $('#btnConfEditAdmin').addClass('disabled');

              var data = {
                'adminName' : $('#adminNameEdit').val().trim(),
                'adminBagde' :ad.admin_badge,
                'adminEmail' :ad.admin_email,
                'adminPhone' :$('#adminTelEdit').val().trim(),
                'adminPassword' :$('#pwdAdminEdit').val()                
              }

              $http.post('/admin/editAdmin', data).then(sCallback, eCallback);
                function sCallback(response){
                  if(response.data=="success"){
                    $('#btnConfEditAdmin').removeClass('loading');
                    $('#btnConfEditAdmin').removeClass('disabled');
                    $('#alertMessage').html('<i class="info icon"></i>Profil Modifié !');
                    $('#warningModal')
                    .modal({
                      onHide: function(){
                        location.reload();
                      }
                    })
                    .modal('show');
                  }else{

                  }
                }
  
                function eCallback(error){
                  console.log(error);
                }
                                              
            }else{                
              $('#confPwdAmdinEdit').popup({              
                content : 'Confirmez votre mot de passe'              
              }).popup('toggle');              
              $('#confPwdAmdinEdit').addClass('error');              
            }                                                                
          }else{                           
            $('#pwdAdminEdit').popup({          
              content : 'le mot de passe devrait avoir 8 caractères ou plus'          
            }).popup('toggle');                                  
            $('#pwdAdminEdit').addClass('error');                                     
          }                       
        }else{                                     
          $('#adminTelEdit').parent().addClass('error');
        }
     }else{
       $('#adminNameEdit').parent().addClass('error');
     }
    });

  }

  $('#btnCancelEdit').click(function(){
    $('#badgeNumEdit').html('');
    $('#adminNameEdit').val('');
    $('#adminTelEdit').val('');
    $('#pwdAdminEdit').val('');
    $('#confPwdAmdinEdit').val('');
  });
  
});

$('.message .close').on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  })