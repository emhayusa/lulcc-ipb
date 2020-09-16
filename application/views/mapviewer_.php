<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>Land Use Change Monitoring Tool - Indonesia</title>
    <base href="<?php echo $base_url;?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://js.arcgis.com/4.11/esri/css/main.css">
  	<link rel="stylesheet" href="assets/css/jquery-ui.css">

    <!-- Latest compiled JavaScript -->
    <script src="assets/js/jquery-1.12.4.js"></script>
    <script src="assets/js/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://js.arcgis.com/4.11/"></script>  
   
  	<style>
      .active-measurement {
        background: #0079c1;
        color: #e4e4e4;
      }
      
      .unselectable{
  -webkit-user-select:none;
  -khtml-user-select:none;
  -moz-user-select:none;
  -ms-user-select:none;
  -o-user-select:none;
  user-select:none;
}
.c-map, .map-icon-crosshair {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    margin: auto;
    fill: #555;
    width: 0.75rem;
    height: 0.75rem;
    pointer-events: none;
    z-index: 5;
}
      </style>
  </head>
<body>
<div class="progress" style="height: 5px;"><div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div>
<svg class="c-icon map-icon-crosshair" viewBox="0 0 45 45"></svg>
<script type="text/javascript">
  var host = "localhost";
 var map, view, locateWidget, polygonGraphicsLayer, sketchViewModel;
 var identify_flag = false;
 var draw_flag = false;
 var identifyTask, params;
 var activeWidget = null;

 
//http://50.18.182.188:6080/arcgis/rest/services/TreeCover2000/ImageServer
var servicesArray = [
	 { id: 0, logo:'forest_icon.png', name: 'Forest', subheader: true },
	 { id: 1, logo:'oil palm_logo.png', name: 'Oil Palm', subheader: false },
	 { id: 2, logo:'paddy_icon.png', name: 'Paddy', subheader: false },
	 { id: 3, logo:'rubber_icon.png', name: 'Rubber', subheader: false },
	 { id: 4, logo:'coffe_icon.png', name: 'Coffee', subheader: false  },
	 { id: 5, logo:'cocoa_icon.png', name: 'Cocoa', subheader: false }
	 /*
	 type --> 0, 1, 2 = tile, imagery, image
	 { id: 1, logo:'perencanaan.png', name: 'Land Cover', service: '' },
	 { id: 2, logo:'sarana_prasarana.png', name: 'Land Use', service: '' },
	 { id: 3, logo:'sumber_daya.png', name: 'Climate', service: '' },
	 { id: 4, logo:'batas_wilayah.png', name: 'Biodiversity', service: '' },
	 */
];

var subHeaderArray = [
	{ id: 0, services: 0, name: 'Forest Cover'},
	{ id: 1, services: 0, name: 'Deforestation Alert'},
	{ id: 2, services: 0, name: 'Forest Change'}
];

var subHeaderServicesArray = [
	{ id: 0, header: 0, tipe: 0, name: 'Primary Forest', service: 'http://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/HutanPrimer/MapServer', sub:''},
	{ id: 1, header: 0, tipe: 0, name: 'Secondary Forest', service: 'http://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/HutanSekunder/MapServer', sub:''},
	{ id: 2, header: 1, tipe: 0, name: 'Deforestation Alert (IPB)', service: '', sub:''},
	{ id: 3, header: 1, tipe: 2, name: 'Deforestation Alert (GLAD)', service: 'https://tiles.globalforestwatch.org/glad_prod/tiles/{level}/{col}/{row}.png', sub:''},
	{ id: 4, header: 1, tipe: 2, name: 'Deforestation Alert (FORMA)', service: 'https://storage.googleapis.com/forma-public/Forma250/tiles/forma_20190518/v1/{level}/{col}/{row}.png',sub:''},
	{ id: 5, header: 2, tipe: 0, name: 'Forest Gain', service: 'http://50.18.182.188:6080/arcgis/rest/services/ForestGain_2000_2012_map/MapServer', sub:''},
	{ id: 6, header: 2, tipe: 0, name: 'Forest Loss', service: 'http://50.18.182.188:6080/arcgis/rest/services/ForestLoss_2000_2012_map/MapServer', sub:''}
];

var subServicesArray = [
	{ id: 0, services: 1, tipe: 0, name: 'Oil Palm Cover', service: 'http://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/OilPalmAustin/MapServer', sub:''},
	{ id: 1, services: 1, tipe: 0, name: 'Oil Palm Concession', service: '', sub:''},
	{ id: 2, services: 1, tipe: 0, name: 'Land Suitability', service: '', sub:''},
	{ id: 3, services: 2, tipe: 0, name: 'Paddy Cover', service: 'http://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/CommoditiesSuitability/MapServer', sub:2},
	{ id: 4, services: 2, tipe: 0, name: 'Paddy Field', service: '', sub:''},
	{ id: 5, services: 2, tipe: 0, name: 'Land Suitability', service: '', sub:''},
	{ id: 6, services: 3, tipe: 0, name: 'Rubber Cover', service: 'http://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/CommoditiesSuitability/MapServer', sub:3},
	{ id: 7, services: 3, tipe: 0, name: 'Land Suitability', service: '', sub:''},
	{ id: 8, services: 4, tipe: 0, name: 'Coffee Cover', service: 'http://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/CommoditiesSuitability/MapServer', sub:4},
	{ id: 9, services: 4, tipe: 0, name: 'Land Suitability', service: '', sub:''},
	{ id: 10, services: 5, tipe: 0, name: 'Cocoa Cover', service: 'http://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/CommoditiesSuitability/MapServer', sub:1},
	{ id: 11, services: 5, tipe: 0, name: 'Land Suitability', service: '', sub:''}	
];
 
 var toolsArray = [
     { id: 0, logo:'jign.png', name: 'Jaringan Informasi Geospasial Nasional'},
     { id: 1, logo:'cari.png', name: 'Pencarian'}
 ];

 var tipeSimpulArray = [
	  { id: 0, name: 'Kementrian/Lembaga'},
	  { id: 1, name: 'Pemerintah Daerah'}

 ];

 var serverSimpulArray = [
	  { id: 0, name: 'ArcGIS Server'},
	  { id: 1, name: 'WMS OGC'}

 ];

 var listSimpulArray = [
	  { id: 0, name: 'Badan Informasi Geospasial', tipe:0, server:0, url:'http://portal.ina-sdi.or.id/arcgis/rest/services'},
	  { id: 1, name: 'Badan Meteorologi, Klimatologi, dan Geofisika', tipe:0, server:0, url:'http://gis.bmkg.go.id/arcgis/rest/services'},
	  { id: 2, name: 'Badan Nasional Penanggulangan Bencana', tipe:0, server:0, url:'http://geoservice.bnpb.go.id:6080/arcgis/rest/services/inaRISK'},
	  { id: 3, name: 'Kementerian Koordinator Bidang Perekonomian', tipe:0, server:1, url:'http://geoportal.satupeta.go.id:8080/geoserver/wms'},
	  { id: 4, name: 'Kementerian Lingkungan Hidup dan Lingkungan (KLHK)', tipe:0, server:0, url:'http://geoportal.menlhk.go.id/arcgis/rest/services'},
	  { id: 5, name: 'Provinsi Aceh', tipe:1, server:0, url:'http://gisportal.acehprov.go.id:6080/arcgis/rest/services'},
	  { id: 6, name: 'Provinsi Sumatera Barat', tipe:1, server:1, url:'http://sumbarprov.ina-sdi.or.id:8080/geoserver/wms'}	  
 ];

 var options = {
		  // These properties will be appended to the request URL in the following format:
		  // <url>?f=json
		  query: {
		    f: "json"
		  },
		  // Determine the format you want to read the response as.
		  // Default type is 'json'. Other values are 'xml', 'text', 'blob', 'arraybuffer', 'document'.
		  responseType: "json"
		};
  
require([
     "esri/Basemap",
     "esri/core/watchUtils",
     "esri/identity/IdentityManager",
     "esri/identity/ServerInfo",
     "esri/Graphic",
     "esri/layers/MapImageLayer",
	 "esri/layers/FeatureLayer",
	 "esri/layers/ImageryLayer",
     "esri/layers/TileLayer",
	 "esri/layers/WebTileLayer",
     "esri/layers/WMSLayer",
     "esri/Map",
     "esri/request",
     "esri/tasks/IdentifyTask",
     "esri/tasks/support/IdentifyParameters",
     "esri/views/MapView",
     "esri/widgets/AreaMeasurement2D",
     "esri/widgets/BasemapGallery",
     "esri/widgets/BasemapGallery/support/LocalBasemapsSource",
     "esri/widgets/DistanceMeasurement2D",
     "esri/widgets/Expand",
     "esri/widgets/Home",
     "esri/widgets/LayerList",
     "esri/widgets/Legend",
     "esri/widgets/Locate",
     "esri/widgets/Search",
     "esri/widgets/ScaleBar",
     "esri/widgets/Zoom",
	 "esri/layers/GraphicsLayer",
	 "esri/widgets/Sketch/SketchViewModel",
	 "esri/config"
     
    ],function(
    	Basemap,
    	watchUtils,
    	identityManager,
    	ServerInfo,
    	Graphic,
    	MapImageLayer,
		FeatureLayer,
		ImageryLayer,
    	TileLayer,
		WebTileLayer,
    	WMSLayer,
     	Map,
    	esriRequest,
    	IdentifyTask,
    	IdentifyParameters,
	 	MapView,
	 	AreaMeasurement2D,
	 	BasemapGallery,
	 	LocalBasemapsSource,
	 	DistanceMeasurement2D,
	 	Expand,
	 	Home,
	 	LayerList,
	 	Legend,
	 	Locate,
	 	Search,
	 	ScaleBar,
	 	Zoom,
		GraphicsLayer,
		SketchViewModel,
		esriConfig
	 	){
 	
	esriConfig.request.proxyUrl = "http://"+ host +"/PHP/proxy.php";
	
	function setup_css(){
		$("style").append('html, body, #viewDiv{padding: 0;margin: 0;height: 100%;width: 100%;overflow: hidden;}');
		//$("style").append('body{background-image: url("assets/images/logo_map_small.png");}');
		$("style").append('#topLoader,#layerList,#menu_user,#user,#mainMenu,#extraMenu,#tools,#legend{z-index:99;position:absolute;}');
		$("style").append('#layerList{width:300px;top:200px;right:80px;}');
		$("style").append('#legend{width:300px;top:300px;right:80px;}');
		$("style").append('.over{max-height:700px;overflow-y:auto;overflow-x:hidden}');
		$("style").append('#legendContent,#layerListContent{max-height:500px;overflow-y:auto;overflow-x:hidden}');
		$("style").append('#tools{width:400px;top:400px;right:80px;}');
		$("style").append('#mainMenu,#extraMenu{height: 96%;background-color: rgba(255, 255, 255, 1)}');
		$("style").append('#mainMenu{left: 15px;top: 15px;}');
		$("style").append('#tool,#mainMenu{width:48px;}');
		$("style").append('#logo{display:block;}');
		$("style").append('#ksp{position: relative;padding-top:10px;}');
		$("style").append('.menu{height: 48px;}');
		$("style").append('#extraMenu{left: 70px;top: 15px;width: 420px;}');
		$("style").append('#tool{position:absolute;bottom:0px;height:130px;}');
		$("style").append('#service{max-height:500px;overflow-y:auto;overflow-x:hidden;}');
		$("style").append('.card{border-radius: 0;border-style: none;}');
		$("style").append('.card-body{padding:0px;}');
		$("style").append('.custom-control-label {margin-left:10px}');
		
		$("style").append('.close-icon,#logo,.menu,.headerExtraMenu,#switchIdentify,.custom-control-label {cursor: pointer;}');
		$("style").append('.card-header{cursor:move;}');

		$("style").append('.card-header:first-child{border-radius:0;}');
		$("style").append('#layerList, #extraMenu, .extraMenuContent, #tools,#legend{display:none;}');
		$("style").append('div.esri-component.esri-scale-bar.esri-widget{padding-left:100px;}');
		$("style").append('div.esri-component.esri-popup.esri-popup--is-docked.esri-popup--is-docked-top-right{padding-right:70px}');
		$("style").append('.bg-new{background-color: #cfdde9!important;}');
  	}

	function setup_component(){
		$("body").append('<div id="topLoader" class="d-flex justify-content-center align-items-center h-100 w-100"><img id="loadingImg" src="assets/images/loading.gif" /></div>');
		$("body").append('<div id="viewDiv"></div>');
		$("body").append('<div id="mainMenu"></div>');
		$("body").append('<div id="extraMenu"></div>');
		$("body").append(create_card('user', 'Profil Pengguna'));
		$("body").append(create_card('layerList', 'Layer List'));
		$("body").append(create_card('legend', 'Legenda'));
		$("body").append(create_card('tools', 'Tools'));
		$("#user").find('.card-body').append('<div class="p-2"><div class="row"><div class="col">Selamat Datang!</div></div>'
        		+'<div class="row"><div class="col">Username</div><div class="col font-weight-bold">Username</div></div>'
        		+'<div class="row"><div class="col">Level</div><div class="col font-weight-bold">Level</div></div>'
        		+'<div class="row pt-2"><div class="col"><button type="button" class="btn btn-primary btn-sm">Pengaturan</button></div>'
        		+'<div class="col text-right"><button type="button" class="btn btn-danger btn-sm">Logout</button></div></div></div>');
		$("#layerList").find('.card-body').append('<div id="layerListContent" class="bg-white"></div>');
		$("#legend").find('.card-body').append('<div id="legendContent" class="bg-white"></div>');	
		$("#tools").find('.card-body').append('<ul class="nav nav-tabs" id="myTab" role="tablist">'
				  + '<li class="nav-item">'
				  + '  <a class="nav-link active" id="analysis-tab" data-toggle="tab" href="#analysis" role="tab" aria-controls="analysis" aria-selected="true">Analysis</a>'
				  + '</li>'
				  + '<li class="nav-item">'
				  + '  <a class="nav-link" id="identify-tab" data-toggle="tab" href="#identify" role="tab" aria-controls="identify" aria-selected="false">Identify</a>'
				  + '</li>'
				  + '</ul>'
				  + '<div class="tab-content" id="myTabContent">'
				  + '<div class="tab-pane fade show active" id="analysis" role="tabpanel" aria-labelledby="analysis-tab"><div id="analysisContent" class="p-3"></div></div>'
				  + '<div class="tab-pane fade" id="identify" role="tabpanel" aria-labelledby="identify-tab"><div id="identifyContent" class="p-3"></div></div>'
				  + '</div>');
		/*
		<div class="custom-control custom-switch">
  <input type="checkbox" class="custom-control-input" id="customSwitch1">
  <label class="custom-control-label" for="customSwitch1">Toggle this switch element</label>
</div>
		$("#measurementContent").append('<button class="action-button esri-icon-minus" id="distanceButton" type="button" title="Measure distance between two or more points"></button>'
      			  + '<button class="action-button esri-icon-polygon" id="areaButton" type="button" title="Measure area"></button>');
		$("#measurementContent").append('<div id="measurementLine"></div>');
		$("#measurementContent").append('<div id="measurementArea"></div>');
		
		*/
		$("#analysisContent").append('<p>Draw in the map the area you want to analyze</p>');
		$("#analysisContent").append('<div class="custom-control custom-switch">'+
							  '<input type="checkbox" class="custom-control-input" id="switchDrawing">'+
							  '<label class="custom-control-label unselectable" for="switchDrawing">Drawing Mode?</label>'+
							  '<label id="statusDrawing" class="font-weight-bold small pl-1"></label>'+
							 '</div>');
		$("#analysisContent").append('<div id="analysisContentResult" class="pt-2"></div>');
		
		$("#identifyContent").append('<div class="custom-control custom-switch">'
				  +'<input type="checkbox" class="custom-control-input" id="switchIdentify">'
				  +'<label class="custom-control-label unselectable" for="switchIdentify">Identify Layer on Map?</label>'
				  +'</div>');
		$("#identifyContent").append('<div id="switchIdentifyMessage" class="p-2"></div>');
		$("#menu_user").append('<img src="assets/images/user1.png" />');	
		$("#mainMenu").append('<div id="logo" class="d-flex justify-content-center"></div>');
		$("#mainMenu").append('<div id="ksp"></div>');
	  	$("#mainMenu").append('<div id="tool"></div>');
	  	$("#logo").append('<img src="assets/images/logo_map.png" width="48px" height="48px" title="Portal Monitoring Hutan Indonesia">');
	  	$("#extraMenu").append("<button type='button' id='closeX' class='mr-3 mt-2 close text-light' aria-label='Close'><span aria-hidden='true'>&times;</span></button>");
	  	//var obj = $.grep(listSimpulArray, function(n){return n.tipe == 1;});
	  	servicesArray.forEach(function(obj) {
	  		$("#ksp").append('<div class="menu text-center align-items-center p-2 unselectable" id="ksp-'+obj.id+'"></div>');
		    $("#ksp-"+obj.id).append('<img src="assets/images/'+obj.logo+'" width="32px" height="32px" title="'+obj.name+'">');
		    $("#ksp-"+obj.id).on('click', function() {
	 			//fillMainMenu('ksp',obj.id);
		    	openMainMenu(obj.id, "ksp");
	 		});
		    $("#extraMenu").append("<div class='extraMenuContent' id='ksp-content-"+obj.id+"'></div>"); 
		    $("#ksp-content-"+obj.id).append("<div class='headerExtraMenu bg-dark p-3 unselectable'><p class='mb-1 text-light font-weight-bold'>"+obj.name+"</p></div>");
		});
	  	toolsArray.forEach(function(obj) {
		    //console.log(obj);
		    $("#tool").append('<div class="menu text-center align-items-center p-2 unselectable" id="tool-'+obj.id+'"></div>');
		    $("#tool-"+obj.id).append('<img src="assets/images/'+obj.logo+'" width="32px" height="32px" title="'+obj.name+'">');
		    $("#tool-"+obj.id).on('click', function() {
	    		//fillMainMenu('tool',obj.id);
	    		openMainMenu(obj.id,"tool");
	   		 });

		    $("#extraMenu").append("<div class='extraMenuContent' id='tool-content-"+obj.id+"'></div>");   		    
		    $("#tool-content-"+obj.id).append("<div class='headerExtraMenu bg-dark p-3 unselectable'><p class='mb-1 text-light font-weight-bold'>"+obj.name+"</p></div>");
		});

		populateExtraMenuKSP();
	  	populateExtraMenuTools();
		
	}
	/*
	 { id: 0, logo:'forest_icon.png', name: 'Forest', subheader: true },
	 { id: 1, logo:'oil palm_logo.png', name: 'Oil Palm', subheader: false },
	 { id: 2, logo:'paddy_icon.png', name: 'Paddy', subheader: false },
	 { id: 3, logo:'rubber_icon.png', name: 'Rubber', subheader: false },
	 { id: 4, logo:'coffe_icon.png', name: 'Coffee', subheader: false  },
	 { id: 5, logo:'cocoa_icon.png', name: 'Cocoa', subheader: false }

];

var subHeaderArray = [{
	{ id: 0, services: 0, name='Deforestation Alert'},
	{ id: 1, services: 0, name='Forest Change'}
}];

var subHeaderServicesArray = [{
	{ id: 0, header: 0, tipe: 0, name='Deforestation Alert (IPB)', service: ''},
	*/
  	function populateExtraMenuKSP(){
		var k = 0;
  		servicesArray.forEach(function(obj) {
      			//var obj = $.grep(servicesArray, function(n){return n.id == 0;})[0];
      		//console.log(obj.service);
			if(obj.subheader == true){
				var headers = $.grep(subHeaderArray, function(n){return n.services == obj.id;});
				//console.log(headers);
				z = 0;
				headers.forEach(function(o) {
					$('#ksp-content-'+obj.id).append('<p class="pl-3 pt-2">'+ o.name + '</p>');
					$('<div />', { id: 'container-ksp-content-header-'+z,"class":'bg-light over'}).appendTo('#ksp-content-'+obj.id);
					//$('#container-ksp-content-'+ obj.id).append('<div class="py-2 border unselectable bg-secondary" style="padding-left:45px; //cursor:pointer">'+o.name+'</div>');
					var services = $.grep(subHeaderServicesArray, function(n){return n.header == o.id;});
					services.forEach(function(m) {
						$('#container-ksp-content-header-'+ z).append('<div class="row pl-3 border"><div class="custom-control custom-switch py-2 col-md-9"> <input type="checkbox" class="custom-control-input pl-2" id="switchIdentify'+k+'"> <label class="custom-control-label unselectable" for="switchIdentify'+k+'">'+m.name+'</label></div>');//<div class="col-md-1 p-2">'+ menu +'</div></div>');
                            		
                            			 $("#switchIdentify"+k).on('click',function() {
                            				 //console.log($(this).is(":checked"));
                            				  if($(this).is(":checked")){
												  if (m.tipe == 1){
													addLayerArcGISTiledSublayer("ksp_"+k, m.service, m.name + " -" + obj.name);
												  }else if (m.tipe == 2){
													addLayerWebTileLayer("ksp_"+k, m.service, m.name + " -" + obj.name);
												  }else{
													  if(m.sub == ""){
														addLayerArcGIS("ksp_"+k, m.service, m.name + " -" + obj.name);
													  }else{
														addLayerArcGISSublayer ("ksp_"+k, m.service, m.name + " -" + obj.name, m.sub);
													  }
												  }
                                				  //console.log(o.name.split(' ').join('')  + "" + o.id);
                            				  }else{
												  //alert('remove');
													foundLayer = map.allLayers.find(function(layer) {
														return layer.title === m.name + " -" + obj.name;
													});
													//findLayerById(layerId)
													map.remove(foundLayer);
											  }
                            				 //addLayerArcGIS(o.url+"/"+v.name+"/"+v.type, o.name + " - " + v.name);
                            				  //console.log(map.layers.items.length);
                            			  	  
                            			 });
										 k++
					});
					z++;
				});
				//$('<div />', { id: 'container-ksp-content-'+obj.id,"class":'bg-light over'}).appendTo('#ksp-content-'+obj.id);
			}else{
				$('<div />', { id: 'container-ksp-content-'+obj.id,"class":'bg-light over'}).appendTo('#ksp-content-'+obj.id);
				var services = $.grep(subServicesArray, function(n){return n.services == obj.id;});
				services.forEach(function(o) {
					$('#container-ksp-content-'+ obj.id).append('<div class="row pl-3 border"><div class="custom-control custom-switch py-2 col-md-9"> <input type="checkbox" class="custom-control-input pl-2" id="switchIdentify'+k+'"> <label class="custom-control-label unselectable" for="switchIdentify'+k+'">'+o.name+'</label></div>');//<div class="col-md-1 p-2">'+ menu +'</div></div>');
                            		
                            			 $("#switchIdentify"+k).on('click',function() {
                            				 //console.log($(this).is(":checked"));
                            				  if($(this).is(":checked")){
                                				   if (o.tipe == 1){
													addLayerArcGISTiledSublayer("ksp_"+k, o.service, o.name + " -" + obj.name);
												  }else{
													  if(o.sub == ""){
														addLayerArcGIS("ksp_"+k, o.service, o.name + " -" + obj.name);
													  }else{
														addLayerArcGISSublayer ("ksp_"+k, o.service, o.name + " -" + obj.name, o.sub);
													  }
												  }
                                				  //console.log(o.name.split(' ').join('')  + "" + o.id);
                            				  }else{
												  //alert('remove');
													foundLayer = map.allLayers.find(function(layer) {
														return layer.title === o.name + " -" + obj.name;
													});
													//findLayerById(layerId)
													map.remove(foundLayer);
											  }
                            				 //addLayerArcGIS(o.url+"/"+v.name+"/"+v.type, o.name + " - " + v.name);
                            				  //console.log(map.layers.items.length);
                            			  	  
                            			 });
										 k++
				});
				
			}
    		//console.log(obj.service + " " + i);
           /*if(obj.service != ''){
                  		var url = obj.service;
                		//var folders = [];
                		//var items = [];
                		
                		//requestAccess(url, 'container	Wilayah');
                   	 esriRequest(url, options).then(function(response) {
                		  // In this case, we simply print out the response to the page.
                		  var responseJSON = JSON.stringify(response, null, 2);
                		  //console.log(responseJSON);
                		  //console.log(response.data);
                		  if(obj.type == 0){
							  var layers = response.data.layers;
                			
                    		layers.forEach(function(o) {
								//console.log(o);
                        		if(o.parentLayerId == -1){
                            		if(o.subLayerIds != null){
		                    		  //  $('#container-ksp-content-'+ obj.id).append('<div class="py-2 border unselectable bg-secondary" style="padding-left:45px; //cursor:pointer">'+o.name+'</div>');
                            		}else{
								
                            			$('#container-ksp-content-'+ obj.id).append('<div class="row pl-3 border"><div class="custom-control custom-switch py-2 col-md-9"> <input type="checkbox" class="custom-control-input pl-2" id="switchIdentify'+obj.id+'"> <label class="custom-control-label unselectable" for="switchIdentify'+obj.id+'">'+o.name+'</label></div>');//<div class="col-md-1 p-2">'+ menu +'</div></div>');
                            		
                            			 $("#switchIdentify"+obj.id).on('click',function() {
                            				 //console.log($(this).is(":checked"));
                            				  if($(this).is(":checked")){
                                				  addLayerArcGISTiledSublayer("ksp_"+obj.id, url, o.name + " -" + obj.name);
                                				  //console.log(o.name.split(' ').join('')  + "" + o.id);
                            				  }else{
												  //alert('remove');
													foundLayer = map.allLayers.find(function(layer) {
														return layer.title === o.name + " -" + obj.name;
													});
													//findLayerById(layerId)
													map.remove(foundLayer);
											  }
                            				 //addLayerArcGIS(o.url+"/"+v.name+"/"+v.type, o.name + " - " + v.name);
                            				  //console.log(map.layers.items.length);
                            			  	  
                            			 });

                             			j++;
                               			 
                            			//$('input#btn-'+j).on('click', function() {
                                		//addLayerArcGIS(o.url+"/"+v.name+"/"+v.type, o.name + " - " + v.name);
                                		//console.log(map);
		                            //});
                            		}	//items.push(val.name);
	                                	
                        		}
                            	
						  });
						  }else{
							$('#container-ksp-content-'+ obj.id).append('<div class="row pl-3 border"><div class="custom-control custom-switch py-2 col-md-9"> <input type="checkbox" class="custom-control-input pl-2" id="switchIdentify'+obj.id+'"> <label class="custom-control-label unselectable" for="switchIdentify'+obj.id+'">'+response.data.name +'</label></div>');//<div class="col-md-1 p-2">'+ menu +'</div></div>');
                            		
                            			 $("#switchIdentify"+obj.id).on('click',function() {
                            				 //console.log($(this).is(":checked"));
                            				  if($(this).is(":checked")){
												  //console.log(url);
                                				  addLayerArcGISImageServer("ksp_"+obj.id, url, response.data.name + " -" + obj.name);
                                				  //console.log(o.name.split(' ').join('')  + "" + o.id);
                            				  }else{
												  //alert('remove');
													foundLayer = map.allLayers.find(function(layer) {
														return layer.title === o.name + " -" + obj.name;
													});
													//findLayerById(layerId)
													map.remove(foundLayer);
											  }
                            				 //addLayerArcGIS(o.url+"/"+v.name+"/"+v.type, o.name + " - " + v.name);
                            				  //console.log(map.layers.items.length);
                            			  	  
                            			 });

                             			j++;  
						  }
                    	
                	}).otherwise(function(e){
                	            console.log(e);
                	        }); 
              		
      				
      		}*/
         
  		});
  	}
  	function populateExtraMenuTools(){
    	//jign
    	$('<div />', { id: 'containerJIGN',"class":'bg-light p-3'}).appendTo('#tool-content-0');
      	$('<div />', { id: 'formSimpul', "class":'form-group'}).appendTo('#containerJIGN');
    	$('<label />', { "for": 'tipeSimpul' }).text("Kategori Simpul").appendTo('#formSimpul');
    	$('<select />',{id: 'tipeSimpul', "class":'form-control'}).appendTo('#formSimpul');
    	$('#tipeSimpul').append('<option disabled selected="selected">Pilih Kategori Simpul</option>');
    
    	tipeSimpulArray.forEach(function(obj) {
    		    $('#tipeSimpul').append('<option value="'+obj.id+'">'+obj.name+'</option>');
    	});
    	$('<div />', { id: 'listSimpul', "class":'form-group'}).appendTo('#containerJIGN');
    	$('<label />', { "for": 'daftarSimpul' }).text("Daftar Simpul Jaringan").appendTo('#listSimpul');
    	$('<select />',{id: 'daftarSimpul', "class":'form-control'}).appendTo('#listSimpul');
    	$('#daftarSimpul').append('<option disabled selected="selected">Pilih Simpul Jaringan</option>');
    	$('<input type="button" value="Akses Simpul Jaringan" class="btn btn-sm btn-secondary form-control" id="query" />').appendTo('#containerJIGN');
    	$('<div />', { id: 'service', "class": "p-2 ml-2"}).appendTo('#tool-content-0');
    
    	$('#tipeSimpul').on('change', function() {
    		  idx = this.value;
    		  var obj = $.grep(listSimpulArray, function(n){return n.tipe == idx;});
    		  //console.log(obj);
    		  $('#daftarSimpul').empty();
    		  obj.forEach(function(o) {
    			    $('#daftarSimpul').append('<option value="'+o.id+'">'+o.name+'</option>');
    		  });					  
        });
    
    
    	//Search
    	$('<div />', { id: 'cari',"class":'w-100 bg-secondary p-4'}).appendTo('#tool-content-1');
    }
	

	function create_card(id, title){
		return '<div id="'+id+'" class="card"><div class="card-header bg-dark unselectable"><strong class="mr-auto text-light">'+title+'</strong>'
			    + '<button type="button" class="ml-2 mb-1 close text-light" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
		  		+ '<div class="card-body"></div></div>';
	}

	function identify_disabled(){
		identify_flag =  false;
  		$("#switchIdentify").attr('checked', false);
  		$('#switchIdentifyMessage').text("Tidak ada layer aktif untuk identifikasi");
  		
	}
	function setup_action(){
		 $('#layerList').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });

		 $('#user').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });

		 $('#legend').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });

		 $('#tools').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });
		
		   

		 $( ".card-header" ).dblclick(function() {
			  //alert( "Handler for .dblclick() called." );
			  $(this).closest('.card').find('.card-body').toggle();//css("border", "solid 1px red");
			  //$(this).closest('.card .card-body').fadeOut();
		  });

		 $( ".headerExtraMenu" ).dblclick(function() {
			  //alert( "Handler for .dblclick() called." );
			  //console.log($(this).closest('div'));
			  console.log($("#extraMenu").css("height"));
			  if($("#extraMenu").css("height") != "59px"){
    			  $("#extraMenu").css("height","59px");
    			  var i = 1;
    			  $(this).closest('.extraMenuContent').children().each(function(){
    					if(i > 1)
    						$(this).hide();
    					i++;
    			  });
		 	  }else{
		 		  $("#extraMenu").css("height","96%");
    			  var i = 1;
    			  $(this).closest('.extraMenuContent').children().each(function(){
    					if(i > 1)
    						$(this).show();
    					i++;
    			  });
		 	  }
			  //$(this).closest('.card .card-body').fadeOut();
		  });
		

		 $('.close').on('click',function() {
			  //console.log($(this).closest('.card'));
			  o = $(this).closest('.card');
			  //console.log($(this).attr("id"));   
			  
			  if($(this).attr("id") == null){
				o.fadeOut();
			  	$("#menu_"+o.attr('id')).toggleClass("border border-secondary");
		 	  }else{
		 		 closeMainMenu();
		 	  }
		  });

		 $('#menu_user').on('click',function() {
			 $('#user').toggle();
			 $('#menu_user').toggleClass("border border-secondary");
		  });

		 $('#switchIdentify').on('click',function() {
			 //console.log($(this).is(":checked"));

			  //console.log(map.layers.items.length);
		  	  if(map.layers.items.length > 0){
				identify_flag =  $(this).is(":checked");
				if(identify_flag)
					$('#switchIdentifyMessage').text("Fitur identifikasi aktif");
				else
					$('#switchIdentifyMessage').text("");
		  	  }else	{
		  		//show msg
			  	identify_disabled();
			  	//$('#switchIdentifyMessage').text("");
		  	  }
		  });

		 $('#query').on('click', function() {
		     	$("div#service").empty();
		     	if($('#daftarSimpul').val() == null){
		    		$("div#service").html("Pilih Tipe dan Simpul Jaringan terlebih dahulu");	
		    	}else{
		    		//$("div#service").append("<span id='msg'>sedang mengakses SJ.. tunggu sebentar.. </span>");
		    		var o = $.grep(listSimpulArray, function(obj){return obj.id == $('#daftarSimpul').val();})[0];
		    		if(o.server == 0){
		    			var url = o.url + "?f=pjson";
		    			//var folders = [];
		    			//var items = [];
		    			$.getJSON(url)
	                   .done(function( json ) {
	                     //console.log( "Folders: " + json.folders );
	                     //console.log( "Services: " + json.services.name );
	                     var j=0;
	                     //console.log(json.folders.length);
	                     var k = 1;
	                     $.each(json.folders, function( key, val ) {
	                     	//items.push( "<li id='" + key + "'>" + val + "</li>" );
	                     	//folders.push(val);
	                     	$.getJSON(o.url+"/"+val+"?f=pjson").done(function(data) {
									//console.log(data.services);
									$.each(data.services, function( k, v ) {
										//console.log(v.type);
										if(v.type == "MapServer"){
	                               			$("#service").append("<div class='row'><div class='col-sm-3'><img class='img-fluid' src='"+ o.url+"/"+v.name+"/"+v.type+"/info/thumbnail' onerror='this.src=\"assets/images/no_thumb_layer.png\";'></div><div class='col-sm-7 text-break px-0'>"+v.name+"</div><div class='col-sm-1 mr-0'><input type='button' class='btn btn-info btn-sm' value='+' id='btn-"+j+"'></div></div>");
	 	                                	//items.push(val.name);
	 	                                	
	 	                                	$('input#btn-'+j).on('click', function() {
	 	                                		addLayerArcGIS(o.url+"/"+v.name+"/"+v.type, v.name + " - " + o.name);
	 	                                		//console.log(map);
	 			                            });
	 	                                	j++;
	 	                                	k++;
	 	                                	console.log(k);
	 	                                }
									});
 	                         });
	                         
	                   	 });

	                     $.each(json.services, function( key, val ) {
		                     	//items.push( "<li id='" + key + "'>" + val + "</li>" );
		                     	if(val.type == "MapServer"){
		                     		$("#service").append("<div class='row'><div class='col-sm-3'><img class='img-fluid' src='"+ o.url+"/"+val.name+"/"+val.type+"/info/thumbnail' onerror='this.src=\"assets/images/no_thumb_layer.png\";'></div><div class='col-sm-7 text-break px-0'>"+val.name+"</div><div class='col-sm-1 mr-0'><input type='button' class='btn btn-info btn-sm' value='+' id='btn-"+j+"'></div></div>");
		                                //items.push(val.name);
		                           	
		                           	$('input#btn-'+j).on('click', function() {
		                           		addLayerArcGIS( o.url+"/"+val.name+"/"+val.type, val.name + " - " + o.name);
		                           		//console.log(map);
			                            });
		                           	j++;
		                           }
		                 });
	                    
	                 
	                   })
	                   .fail(function( jqxhr, textStatus, error ) {
	                     var err = textStatus + ", " + error;
	                     $("div#service").html( "Request Failed: " + err + " Koneksi Gagal.");
	                     $("div#service").append( "<p class='text-break pr-2'>Silahkan cek koneksi URL : <a href='" + url+ "' target='blank' >" + url+ "</a> </p>");	
	                 });
	               
	                 /*
		    			$.getJSON( url, function( data ) {
		    			console.log(data);
	                   var items = [];
	                   $.each( data, function( key, val ) {
	                     items.push( "<li id='" + key + "'>" + val + "</li>" );
	                   });
	                  
	                   $( "<ul/>", {
	                     "class": "my-new-list",
	                     html: items.join( "" )
	                   }).appendTo( "body" );
	                 });
	                 */
		    		}else if(o.server == 1){
				    		//console.log(o.url);
	 			    	$.ajax({
	 			        type: "get",
	 			        url: o.url+"?service=wms&request=GetCapabilities",
	 			        dataType: "xml",
	 			        success: function(data) {
	 			            /* handle data here */
	 			            
	 			            //$("#show_table").html(data);
	 			            //console.log(data);
	   	  			    $(data).find('Layer').each(function(){
	       	  			    var j = 0;
	       	  			    $(this).find('Layer').each(function(){
	           	  			      //console.log($(this).find('Name').first().text());
		          	  			      var layer = $(this).find('Name').first().text();
		          	  			  	  var title = $(this).find('Title').first().text(); 
		          	  			  	  //console.log( layer, title );
		          	  			  	  var width = 300;
		          	  			  	  var height = 200;
		          	  			  	  var b = $(this).find('EX_GeographicBoundingBox'); 
		          	  			  	  var bbox = b.children('westBoundLongitude').text()+ ','+b.children('southBoundLatitude').text()+ ','+b.children('eastBoundLongitude').text()+ ','+b.children('northBoundLatitude').text();
		          	  			  	  //console.log(bbox);
		          	  			     var imageUrl = o.url + '?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetMap&FORMAT=image/png&TRANSPARENT=true&STYLES&LAYERS='+layer+'&SRS=EPSG:4326&WIDTH='+width+'&HEIGHT='+height+'&BBOX='+bbox;
									 // http://sumbarprov.ina-sdi.or.id:8080/geoserver/ows?service=WMS&request=GetLegendGraphic&format=image%2Fpng&width=20&height=20&layer=Bappeda%3Aadministrasikabupaten_ar_50k_130020180313220746&style=polygon
		          	  			     var l = $(this).find('Style').children('LegendURL').children('OnlineResource').attr('xlink:href');
		          	  			     console.log(l);
		          	  			     var legend = l
		          	  			     //'http://sumbarprov.ina-sdi.or.id:8080/geoserver/Bappeda/ows?service=WMS&request=GetLegendGraphic&format=image%2Fpng&width=20&height=20&layer=administrasikabupaten_ar_50k_130020180313220746';
									 // .attr("Symbol");
		          	  			     //$(t).children('td').eq(1);
		          	  			     //first().next()

	          	  			 	     $("div#service").append("<div class='row'><div class='col-sm-3'><img class='img-fluid' src='"+imageUrl+"' onerror='this.src=\"assets/images/no_thumb_layer.png\";'></div><div class='col-sm-7 text-break px-0'>"+ title+"</div><div class='col-sm-1 mr-0'><input type='button' class='btn btn-info btn-sm' value='+' id='btn-"+j+"'></div></div>");
	                           	//items.push(val.name);
	                           	
	                           	$('input#btn-'+j).on('click', function() {
	                           		addLayerWMSOGC(o.url, o.name, layer, title, legend);
	                           		//console.log(title);
		                            });
	                           	j++;
	       	  			    });
	       	  			    //console.log( $(this).find('Title').text() ); 
	   	  	 				//if ($(this).children("Name").text().match(/postgis:/g) != null) {
	   	  	 					//$("#wmsDirectoryLayer").append('<option value="' + $(this).children("Name").text() + '">' + $(this).children("Title").text() + '</option>');
	   	  	 					//console.log($(this).children("Title").text());
	   	  	 				//}
	   	  				});
	 			        },
	 			        error: function(xhr, status) {
	 			            /* handle error here */
	 			            //$("#show_table").html(status);
		  			        $("div#service").html( "Request Failed: " + status + " Koneksi Gagal" );	
	 			        }
	 			    });

		    		}
		    	}
		 });
		 
		 	
			 $('#switchDrawing').on('click',function() {
				 //console.log($(this).is(":checked"));

				  //console.log(map.layers.items.length);
				 	draw_flag =  $(this).is(":checked");
					if(draw_flag){
						//$('#statusDrawing').text("Fitur search by area aktif");
						//$('#statusDrawing').toggleClass( "text-success" );
						
						clearUpSelection();
						// create a new sketch view model set its layer
						sketchViewModel.create("rectangle");
					}else{
						//$('#statusDrawing').text("Fitur search by area tidak aktif");
						//$('#statusDrawing').toggleClass( "text-success" );
						sketchViewModel.cancel();
					}
			  });
	}

	function openMainMenu(o, j){
		$( ".menu" ).each(function( index ) {
	    	$(this).removeClass("border border-secondary bg-new");
		});
		$("#"+j+"-"+o).addClass("border border-secondary bg-new");
		$("#extraMenu").show();
		$( ".extraMenuContent" ).each(function( index ) {
	    	$(this).hide();
		});
		$("#"+j+"-content-"+o).fadeIn();
	}

	function closeMainMenu(){
		$("#extraMenu").fadeOut();	
		$( ".menu" ).each(function( index ) {
	    	$(this).removeClass("border border-secondary bg-secondary");
		});
	}
	
	function init_map(){
		
		var mapBaseLayer = new TileLayer({
  		   url: "https://portal.ina-sdi.or.id/arcgis/rest/services/IGD/RupabumiIndonesia/MapServer"
     	});
    
      	 // Create a Basemap with the WebTileLayer. The thumbnailUrl will be used for
          // the image in the BasemapToggle widget.
        rbi = new Basemap({
            baseLayers: [mapBaseLayer],
            title: "Peta RBI",
            id: "rbi",
            thumbnailUrl:"assets/images/bm_rbi_small.png"
        });
		
  		map = new Map({
			     basemap: "osm"
		});
		
		
		 var layer = new MapImageLayer({
			   id: "Batas Wilayah",
     		    url: "http://portal.ina-sdi.or.id/arcgis/rest/services/Batas_Wilayah/Batas_Wilayah_50K/MapServer",
         		title: "Batas Administrasi",
				sublayers: [{id:5, title:'Kabupaten/Kota'}],
     		    visible:true
     	  });
     	  map.add(layer);
		  /*
		  const featureLayer = new FeatureLayer({
		                	  url: 'http://portal.ina-sdi.or.id/arcgis/rest/services/Batas_Wilayah/Batas_Wilayah_50K/MapServer/5'});
                        var query = featureLayer.createQuery();
                        query.where = "1=1"; 
                        query.returnGeometry = false;
                        query.returnCountOnly = false;
                        query.outFields = ['NAMOBJ'] ;
                        //$("#tableWrapper").html("<img width='100px' src='assets/images/loading.gif' /><span id='msg'>tunggu sebentar.. </span>");
                        
                       featureLayer.queryFeatures(query).then(function(results){
						   console.log(results);
					   });
					   */
   	
     	  $('#layerList').show();
    	  layer.when(function() {
    	    	if(layer.fullExtent != null){
    	          //view.goTo(layer.fullExtent);
    	    	}
    	  });
		  
		view = new MapView({
				container: "viewDiv",
			     map: map,
			     center: [118,-2],
			     zoom: 6
		});
		
		view.ui.components = (["attribution"]);
		
		view.when(function() {
              // This function will execute once the promise is resolved
              console.log("view loaded successfully");
              closeLoader();
            })
            .catch(errorHandler)
            .always(function() {
              console.log("always is called");
            });
			
		polygonGraphicsLayer = new GraphicsLayer({title:"Graphic Layer", listMode:'hide'});
        map.add(polygonGraphicsLayer);
		/*
		
		view.watch("updating",function(updating){
			console.log("updating " + updating);
		});
		*/
	}

	function init_watcher(){
		// Display the loading indicator when the view is updating
		watchUtils.whenTrue(view, "updating", function(evt) {
		   showLoader();
		   console.log("view updating true");
		});

		// Hide the loading indicator when the view stops updating
		watchUtils.whenFalse(view, "updating", function(evt) {
			closeLoader();
			console.log("view updating false");
		});

		 // Listen to layerview create event for the layers
        view.on("layerview-create", function(event) {
            console.log(event.layer.title + " is " + event.layer.loadStatus);
        });
        view.on("layerview-destroy", function(event) {
            console.log(event.layer.title + " is " + event.layer.loadStatus);
        });

        view.map.allLayers.on("change", function(event) {
            // change event fires after an item has been added, moved or removed from the collection.
            // event.moved - an array of moved layers
            // event.removed - an array of removed layers
            // event.added returns an array of added layers
            if (event.added.length > 0) {
              event.added.forEach(function(layer) {
                console.log("layer added: " + layer.title);
              });
            }
          });
        
        locateWidget.on("locate", function(locateEvent){
            console.log(locateEvent);
            console.log("scale: %s", view.scale);
            console.log("zoom: %s", view.zoom);
            console.log(view.map.basemap.id);
            if(view.map.basemap.id == 'rbi')
            	view.zoom = 15;
          });

        locateWidget.on("locate-error", function(err){
              console.log(err);
        });

        watchUtils.whenTrue(view, "stationary", function() {
            // Get the new center of the view only when view is stationary.
            if (view.center) {
             console.log("the view center changed. x: " +
                view.center.x.toFixed(2) +
                " y: " +
                view.center.y.toFixed(2));
            }

            // Get the new extent of the view only when view is stationary.
            if (view.extent) {
                console.log("xmin:" +
                view.extent.xmin.toFixed(2) +
                " xmax: " +
                view.extent.xmax.toFixed(2) +
                "ymin:" +
                view.extent.ymin.toFixed(2) +
                " ymax: " +
                view.extent.ymax.toFixed(2));
            }
            if (view.zoom) {
                console.log("zoom:" + view.zoom);
                if(view.map.basemap.id == 'rbi'){
	                if(view.zoom < 4){
		                view.zoom = 4;
		                //view.center = [118,-2];
	                }else if(view.zoom > 15){
	                	view.zoom = 15;
		            }
                }
            }
          });

        // Listen the view's click event.
        view.on("click", function(event) {
          //console.log('view click event');
          //console.log('identify_flag : ' + identify_flag);
		  if (identify_flag){
	          console.log('x: "' + event.mapPoint.x.toFixed(2) +" y: " +event.mapPoint.y.toFixed(2));
				//console.log(event);
				console.log(map.layers.items.length);
				list_layers = [];
				$.each(map.layers.items, function(key, val){
					//console.log(key);
					if(val.visible){
						list_layers.push(val);
					}
					//console.log(val.id + " " + val.visible);
				});
				//if hidden all
				//console.log(list_layers[list_layers.length - 1]);
				if(list_layers.length > 0){
				  	var layer_top = list_layers[list_layers.length - 1];
			  		console.log(layer_top.url);
			  		//console.log(layer_top.sublayers.items);
			  		$("#switchIdentifyMessage").text("Fitur identifikasi aktif");
			  		layerIds = [];
			  		$.each(layer_top.sublayers.items, function(key, val){
			  			if(val.visible){
			  				layerIds.push(val.id);
						}
			  		});
			  		console.log(layerIds);
			  		if(layerIds.length > 0){
    			  		identifyTask = new IdentifyTask(layer_top.url);
    			  		params = new IdentifyParameters();
    	    	        params.tolerance = 3;
    	     	        params.layerIds = layerIds.reverse();
    	    	        params.layerOption = "top";
    	    	        params.width = view.width;
    	    	        params.height = view.height;
    			  		executeIdentifyTask(event);	
			  		}else{
			  			$("#switchIdentifyMessage").text("Set visible salah satu sub layer untuk melakukan proses identify");
			  		}
				}else{
					$("#switchIdentifyMessage").text("Set visible salah satu layer untuk melakukan proses identify");
				}
		  }
        });
		
		sketchViewModel.on("create", function(event) {
		  if (event.state === "complete") {
			// remove the graphic from the layer associated with the sketch widget
			// instead use the polygon that user created to query features that
			// intersect it.
			//polygonGraphicsLayer.remove(event.graphic);
			//selectFeatures(event.graphic.geometry);
			view.goTo(event.graphic);
			console.log(event.graphic.geometry);
			draw_disabled();
			showAnalysisResult();
		  }
		});
			  
	}

	// Executes each time the view is clicked
    function executeIdentifyTask(event) {
      // Set the geometry to the location of the view click
      params.geometry = event.mapPoint;
      params.mapExtent = view.extent;
      document.getElementById("viewDiv").style.cursor = "wait";

      // This function returns a promise that resolves to an array of features
      // A custom popupTemplate is set for each feature based on the layer it
      // originates from
      identifyTask
        .execute(params)
        .then(function(response) {
          var results = response.results;

          return results.map(function(result) {
            var feature = result.feature;
            var layerName = result.layerName;

            feature.attributes.layerName = layerName;
            //console.log(feature.attributes);
			
			fieldInfos=[];

			forbidden_field =["Shape","Shape_Length", "Shape_Area","layerName"];

			$.each(feature.attributes,function(key, val){
				//console.log(key);
				if(!forbidden_field.includes(key))
					fieldInfos.push({"fieldName":key});
			});

			
			
            feature.popupTemplate = {
                    // autocasts as new PopupTemplate()
                    //title: "{NAME}",
                    	title: "Layer: {layerName}",
                        content: [{
                          type:"fields"
                        }],
	                    fieldInfos: fieldInfos
            	};
            return feature;
          });
        })
        .then(showPopup); // Send the array of features to showPopup()
	
      // Shows the results of the Identify in a popup once the promise is resolved
      function showPopup(response) {
        if (response.length > 0) {
          view.popup.open({
            features: response,
            location: event.mapPoint
          });
        }
        document.getElementById("viewDiv").style.cursor = "auto";
      }
	}
	function defineActions(event) {
		  // The event object contains an item property.
		  // is is a ListItem referencing the associated layer
		  // and other properties. You can control the visibility of the
		  // item, its title, and actions using this object.

		  var item = event.item;

		
			 
		  if (item.parent == null) {
		    // An array of objects defining actions to place in the LayerList.
		    // By making this array two-dimensional, you can separate similar
		    // actions into separate groups with a breaking line.
		    var slider = document.createElement("div");
		    slider.setAttribute("id", "slider"+item.layer.id);
			//info.class="esri-widget";
			var op = item.layer.opacity * 100;
			var slider_input = document.createElement("input");
			slider_input.setAttribute("id", "slider"+item.layer.id);
			slider_input.setAttribute("type", "range");
			slider_input.setAttribute("class", "form-control-range");
			slider_input.setAttribute("value", op);
			slider_input.setAttribute("min", 0);
			slider_input.setAttribute("max", 100);
			slider.innerHTML = '<label for="formControlRange">Layer Opacity</label>';
			slider.appendChild(slider_input);
			   item.panel = {
					  title: 'Set layer opacity',
					  className: "esri-icon-environment-settings", 
			 	      content: slider,
			 	      open: false,
			 	      visible: true
	 	    	};
			   //console.log('slider'+item.layer.id);
			   //document
		         //.getElementById('slider'+item.layer.id)
		        slider_input.addEventListener("change", function() {
		        	 //console.log(this.value);
		        	 item.layer.opacity = $(this).val()/100;
		         });
		       item.actionsSections = [
		    	 [
				      {
		      	          title: "Delete layer",
		      	          className: "esri-icon-trash",
		      	          id: "delete-layer"
		      	      }],
		      	    [
		        	      {
		  				  title: "Move layer up",
		  				  className: "esri-icon-up",
		        	          id: "move-layer-up"
		        	      },
		      	      {
		  				  title: "Move layer down",
		  				  className: "esri-icon-down",
		      	          id: "move-layer-down"
		      	      }],
		      [
		        {
		          title: "Go to full extent",
		          className: "esri-icon-zoom-out-fixed",
		          id: "full-extent"
		        },
		        {
		          title: "Layer information",
		          className: "esri-icon-description",
		          id: "information"
		        }
		      ]
		     
		      /*
		      [
		        {
		          title: "Increase opacity",
		          className: "esri-icon-up",
		          id: "increase-opacity"
		        },
		        {
		          title: "Decrease opacity",
		          className: "esri-icon-down",
		          id: "decrease-opacity"
		        },
		      ],*/
      	  
		    ];
		  }
	}
		  
	function init_widget(){
		var  layerList = new LayerList({
  	 	  view: view,
	 	  container: "layerListContent",
	 	  // executes for each ListItem in the LayerList
	 	  listItemCreatedFunction: defineActions
	 	  /*listItemCreatedFunction: function(event){
	 	    const item = event.item;
	 	    // displays the legend for each layer list item
	 	   // console.log(item.layer);
	 	    //console.log(item.title);
  	 	    
	 	    if (item.parent == null){
		 	    item.panel = {
			 	      content: item.title
	 	    	};
	 	    }
	 	  }*/
	 	});

	   	  layerList.on("trigger-action", function(event) {
              // The layer visible in the view at the time of the trigger.
              //var visibleLayer = USALayer.visible ? USALayer : censusLayer;

              // Capture the action id.
              var id = event.action.id;
              //console.log(event);
              //console.log(event.action.active);
              //console.log(event.action.title);
              //console.log(event.item.layer);
              var layer = event.item.layer;
              
              if (id === "full-extent") {
                // if the full-extent action is triggered then navigate
                // to the full extent of the visible layer
                view.goTo(layer.fullExtent);
              } else if (id === "information") {
                // if the information action is triggered, then
                // open the item details page of the service layer
                window.open(layer.url);
              } else if (id === "increase-opacity") {
                // if the increase-opacity action is triggered, then
                // increase the opacity of the GroupLayer by 0.25
				
                if (layer.opacity < 1) {
                	layer.opacity += 0.25;
                  //demographicGroupLayer.opacity += 0.25;
                }
              } else if (id === "decrease-opacity") {
                // if the decrease-opacity action is triggered, then
                // decrease the opacity of the GroupLayer by 0.25

                if (layer.opacity > 0) {
                  layer.opacity -= 0.25;
                  
                }
              } else if (id === "delete-layer") {
                  // if the information action is triggered, then
                  // open the item details page of the service layer
				  console.log(layer.id); 
				  if(layer.id.includes("ksp_")){
					console.log(layer.id);  
					var res = layer.id.split("_");
					$("#switchIdentify"+res[1]).attr('checked', false);
				  }
                  map.layers.remove(layer);
                  if(map.layers.items.length < 1)
                	  identify_disabled();
                }
               else if (id === "move-layer-up") {
                  // if the information action is triggered, then
                  // open the item details page of the service layer
                  //map.layers.reorder(layer, 0);
                  if(map.layers.length > 1){
                	 map.layers.reorder(layer, map.layers.indexOf(layer)+1);
                	 //console.log(map.layers.indexOf(layer));
                  	//console.log(map.layers);
                  }
                }
               else if (id === "move-layer-down") {
                   // if the information action is triggered, then
                   // open the item details page of the service layer
                   //map.layers.reorder(layer, 0);
                   if(map.layers.indexOf(layer) > 0){
                 	 map.layers.reorder(layer, map.layers.indexOf(layer)-1);
                 	 //console.log(map.layers.indexOf(layer));
                   	//console.log(map.layers);
                   }
                 }
              
            });

		var searchWidget = new Search({
	          view: view,
	          container:"cari"
	        });
	 	
		var scaleBar = new ScaleBar({
			  view: view,
			  unit:'metric'
			});
		
		var homeWidget = new Home({
			  view: view
			});

		var zoom = new Zoom({
            	view: view
          	});

		locateWidget = new Locate({
			  view: view,   // Attaches the Locate button to the view
			  graphic: new Graphic({
			    symbol: { 
				    	type: "simple-marker" 
					}  
			 	 })
			});

		var localSource = new LocalBasemapsSource({
            	basemaps : [rbi, Basemap.fromId("topo"), Basemap.fromId("osm"),Basemap.fromId("satellite"),Basemap.fromId("streets-navigation-vector")]
			})

        var basemapGallery = new BasemapGallery({
            	  view: view,
            	  container: document.createElement("div"),
            	  source: localSource
            });

            	// Create an Expand instance and set the content
            	// property to the DOM node of the basemap gallery widget

        var bgExpand = new Expand({
                  expandIconClass: "esri-icon-basemap",	
            	  view: view,
            	  content: basemapGallery,
            	  expandTooltip:"Basemap Gallery"
            });
		
		var legend = new Legend({
			 container:"legendContent",
             view: view,
             style: "classic" // other styles include 'classic'
           });

        /*
        var legExpand = new Expand({
             content: legend,
             expandIconClass: "esri-icon-layer-list",
             view: view,
             expanded: false,
             expandTooltip:"Legenda"
           });
		*/

        view.ui.add(scaleBar,"bottom-left");
		view.ui.add(homeWidget, "top-right");			
		view.ui.add(zoom, "top-right");
		view.ui.add(locateWidget, "top-right");
		view.ui.add(bgExpand, "top-right");

 	  	var btnHtml = '<div id="btnCustom" class="esri-component esri-widget--button esri-widget" role="button" tabindex="0" aria-label="Layer List" title="Layer List">';
    		btnHtml += '<span aria-hidden="true" class="esri-icon esri-icon-layers"></span>';
    		btnHtml += '<span class="esri-icon-font-fallback-text">Layer List</span></div></div>';


    	$(".esri-ui-top-right").append(btnHtml);

    	//view.ui.add(legExpand, "top-right");
    	var btnHtml = '<div id="btnLegend" class="esri-component esri-widget--button esri-widget" role="button" tabindex="0" aria-label="Legenda" title="Legenda">';
    		btnHtml += '<span aria-hidden="true" class="esri-icon esri-icon-layer-list"></span>';
    		btnHtml += '<span class="esri-icon-font-fallback-text">Legenda</span></div></div>';


    	$(".esri-ui-top-right").append(btnHtml);
    	

 	  	var btnHtml = '<div id="btnTools" class="esri-component esri-widget--button esri-widget" role="button" tabindex="0" aria-label="Tools" title="Tools">';
		btnHtml += '<span aria-hidden="true" class="esri-icon esri-icon-settings2"></span>';
		btnHtml += '<span class="esri-icon-font-fallback-text">Tools</span></div></div>';

		//$(".esri-ui-top-right").append(btnHtml);
		
    	$("#btnCustom").click(function(){
    		 $('#layerList').toggle();
    	});

       	$("#btnLegend").click(function(){
   			 $('#legend').toggle();
   		});

    	$("#btnTools").click(function(){
    		 $('#tools').toggle();
    	});

    	info = document.createElement("div");
		var att = document.createAttribute("class");       // Create a "class" attribute
		att.value = "esri-widget p-3";                           // Set the value of the class attribute
		info.setAttributeNode(att);
		at = document.createAttribute("style");       // Create a "class" attribute
		at.value = "width:200px;height:100px;";                           // Set the value of the class attribute
		info.setAttributeNode(at);  
		//info.class="esri-widget";
		info.innerHTML = "<p class='text-justify'>Portal Monitoring Hutan Indonesia ini merupakan project hasil kerjasama antara UNDP dan IPB</p>";
		
		var infoExpand = new Expand({
          expandIconClass: "esri-icon-question",	
    	  view: view,
    	  content: info,
    	  expandTooltip:"Info KSP"
    	});

		view.ui.add(infoExpand, "top-right");
		
		sketchViewModel = new SketchViewModel({
				view: view,
				layer: polygonGraphicsLayer,
				polygonSymbol: {
				   type: "simple-fill", // autocasts as SimpleFillSymbol
				   color: [20, 20, 20, 0.5],
				   style: "solid",
				   outline: { // autocasts as SimpleLineSymbol
					color: [255, 0, 0],
					width: 1
				  }
				}
			  });
		/*
		 document
         .getElementById("distanceButton")
         .addEventListener("click", function() {
           setActiveWidget(null);
           if (!this.classList.contains("active")) {
             setActiveWidget("distance");
           } else {
             setActiveButton(null);
           }
         });

       document
         .getElementById("areaButton")
         .addEventListener("click", function() {
           setActiveWidget(null);
           if (!this.classList.contains("active")) {
             setActiveWidget("area");
           } else {
             setActiveButton(null);
           }
         });

      */
	}

	 function setActiveWidget(type) {
         switch (type) {
           case "distance":
             activeWidget = new DistanceMeasurement2D({
               view: view,
               container: "measurementLine"
             });

             // skip the initial 'new measurement' button
             activeWidget.viewModel.newMeasurement();

             //view.ui.add(activeWidget, "top-right");
             setActiveButton(document.getElementById("distanceButton"));
             break;
           case "area":
             activeWidget = new AreaMeasurement2D({
               view: view,
               container: "measurementArea"
             });

             // skip the initial 'new measurement' button
             activeWidget.viewModel.newMeasurement();

             //view.ui.add(activeWidget, "top-right");
             setActiveButton(document.getElementById("areaButton"));
             break;
           case null:
             if (activeWidget) {
               view.ui.remove(activeWidget);
               activeWidget.destroy();
               activeWidget = null;
             }
             break;
         }
       }

       function setActiveButton(selectedButton) {
         // focus the view to activate keyboard shortcuts for sketching
         view.focus();
         selectedButton.classList.add("activeMeasurement");
         /*
         var elements = document.getElementsByClassName("active");
         for (var i = 0; i < elements.length; i++) {
           elements[i].classList.remove("active");
         }
         if (selectedButton) {
           selectedButton.classList.add("active");
         }
         */
       }

	function errorHandler(error) {
		 if (error.name && error.message) {
	         console.log(error.name + ' ' + error.message);
	     } else {
	    	 console.log(error);
	     }
	}

	function closeLoader(){
		 $("#loadingImg").fadeOut();
         $("#topLoader").css("z-index","0");
         console.log("closeLoader");
	}

	function showLoader(){
		 $("#loadingImg").fadeIn();
         $("#topLoader").css("z-index","99");
         console.log("showLoader");
	}



	function init(){
		$.ajax({
			  xhr: function()
			  {	  
			    var xhr = new window.XMLHttpRequest();
			    //Download progress
			    xhr.addEventListener("progress", function(evt){
			      if (evt.lengthComputable) {
			        var percentComplete = Math.ceil((evt.loaded / evt.total)*100);
			        //Do something with download progress
			        //$('#message').text(percentComplete);
			        $('.progress-bar').css('width', percentComplete + '%');
			      }
			    }, false);
			    return xhr;
			  },
			  type: 'GET',
			  url: "/",
			  data: {},
			  success: function(data){
			    //Do something success-ish
				    $(".progress").fadeOut()
				    setup_css();
				    setup_component();
				    setup_action();
				    console.log("setup completed");
				    //$("body").append('<div id="viewDiv"></div>');
			  }
		});

	}


	function addLayerArcGIS(id, url, title){
		 //var url ="https://portal.ina-sdi.or.id/arcgis/rest/services/KSP/KAWASAN_KHUSUS_DAN_TRANSMIGRASI/MapServer"+token;
     	  var layer = new MapImageLayer({
			   id: id,
     		    url: url,
         		title: title,
     		    visible:true
     	  });
     	  map.add(layer);
   	
     	  $('#layerList').show();
    	  layer.when(function() {
    	    	if(layer.fullExtent != null){
    	          //view.goTo(layer.fullExtent);
    	    	}
    	  });
     	
	}
	
	function addLayerArcGISImageServer(id, url, title){
		  var layer = new ImageryLayer({
    		    url: url,
        		title: title,
    		    visible:true
    	  });
    	  map.add(layer);
    	  //console.log(layer);
  	     $('#layerList').show();
  	  
   	  layer.when(function() {
   	    	if(layer.fullExtent != null){
   	          //view.goTo(layer.fullExtent);
   	    	}
   	  });
    	
	}

	function addLayerArcGISSublayer(id,url, title, sub){
		 //var url ="https://portal.ina-sdi.or.id/arcgis/rest/services/KSP/KAWASAN_KHUSUS_DAN_TRANSMIGRASI/MapServer"+token;
    	  var layer = new MapImageLayer({
			   id: id,
    		    url: url,
        		title: title,
        		sublayers: [{id:sub, title: title}],
    		    visible:true
    	  });
    	  map.add(layer);
    	  //console.log(layer);
  	     $('#layerList').show();
  	  
   	  layer.when(function() {
   	    	if(layer.fullExtent != null){
   	          //view.goTo(layer.fullExtent);
   	    	}
   	  });
    	
	}
	
	function addLayerArcGISTiledSublayer(id, url, title){
		 //var url ="https://portal.ina-sdi.or.id/arcgis/rest/services/KSP/KAWASAN_KHUSUS_DAN_TRANSMIGRASI/MapServer"+token;
    	  var layer = new TileLayer({
			  id: id,
    		    url: url,
        		title: title,
    		    visible:true
    	  });
    	  map.add(layer);
    	  //console.log(layer);
  	     $('#layerList').show();
  	  
   	  layer.when(function() {
   	    	if(layer.fullExtent != null){
   	          //view.goTo(layer.fullExtent);
   	    	}
   	  });
    	
	}
	
		function addLayerWebTileLayer(id, url, title){
		 //var url ="https://portal.ina-sdi.or.id/arcgis/rest/services/KSP/KAWASAN_KHUSUS_DAN_TRANSMIGRASI/MapServer"+token;
    	  var layer = new WebTileLayer({
			  urlTemplate: url,
			  id: id,
        		title: title,
    		    visible:true
    	  });
    	  map.add(layer);
    	  //console.log(layer);
  	     $('#layerList').show();
  	  
   	  layer.when(function() {
   	    	if(layer.fullExtent != null){
   	          //view.goTo(layer.fullExtent);
   	    	}
   	  });
    	
	}
	
	function addLayerWMSOGC(url, caption, layer, title, legend){
		var layer = new WMSLayer({
    		  url: url,
    		  title: caption,
    		  sublayers: [{
    		    name: layer,
    		    title: title,
    		    //popupEnabled: true,
    		    //queryable: true,
    		    legendUrl: legend
    		  }],
    		  visible:true
    		});
	     	map.add(layer);

	     	$('#layerList').show();
	     	layer.when(function() {
     	    	if(layer.fullExtent != null){
     	          //view.goTo(layer.fullExtent);
     	    	}
     	    });
	     	//console.log(layer.queryExtent());
	}
	
	function clearUpSelection() {
         //view.graphics.removeAll();
		  $("#analysisContentResult").html("");
		  polygonGraphicsLayer.removeAll();
		  console.log("clear");
          //grid.clearSelection();
    }
	
	function draw_disabled(){
			draw_flag =  false;
			$("#switchDrawing").attr('checked', false);
	}
	
	function showAnalysisResult(){
		$("#analysisContentResult").append("<hr style='border: 0;border-bottom: 1px dashed #ccc;'></hr>");
		$("#analysisContentResult").append("<h5>Selected Area</h5>");
		$("#analysisContentResult").append("<p>1.19 Mha</p>");
		$("#analysisContentResult").append("<h5>Tree Cover</h5>");
		$("#analysisContentResult").append("<p>1.15 Mha</p>");
		$("#analysisContentResult").append("<h5>Tree Cover Loss</h5>");
		$("#analysisContentResult").append("<p>91.6 kha</p>");
		$("#analysisContentResult").append("<h5>Tree Cover Gain</h5>");
		$("#analysisContentResult").append("<p>22.1 kha</p>");
		/*
		SELECTED AREA
1.19Mha
TREE COVER - 2010 with >30% canopy density
1.15Mha
TREE COVER LOSS (2001-01-01 to 2018-12-31) with >30% canopy density
91.6kha
TREE COVER GAIN - 2001-2012
22.1kha
This algorithm approximates the results by sampling the selected area. Results are more accurate at closer zoom levels.*/
	}
		
	$(function () {
		$(".progress").fadeOut();
		setup_css();
		setup_component();
		setup_action();
		console.log("setup completed");
		console.log("app ready!");
		init_map();
		init_widget();
		init_watcher();		
	});
});
 </script>
</body>
</html>
