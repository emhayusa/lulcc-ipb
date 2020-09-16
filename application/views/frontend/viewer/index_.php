<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title><?php echo $title; ?></title>
    <base href="<?php echo $base_url;?>" />
	<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://js.arcgis.com/4.11/esri/css/main.css">
  	<link rel="stylesheet" href="assets/css/jquery-ui.css">

    <!-- Latest compiled JavaScript -->
    <script src="assets/js/jquery-1.12.4.js"></script>
    <script src="assets/js/jquery-ui.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script>
        const optionsa = {
            // tell Dojo where to load other packages
            dojoConfig: {
                async: true,
            packages: [
                {
					location: 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js',
                    name: 'Chart'
                }
            ]
            }
        };
	</script>
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
  .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        border-color: #666 #666 #fff;
    }
    
    .nav-tabs {
        border-bottom: 1px solid #666;
    }
    .tab-content{
        border: 1px solid transparent;
        border-color: #fff #666 #666;
    }
    .minus{
        float: right;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: .5;
    }
    
    .minus::after, .minus::before {
        box-sizing: border-box;
    }
    
    .bg-darkblue{
        background-color: #137082; /*#000428;/*#15325c;*/
    }
    .bg-telegram{
        background: #1c92d2;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right,  #1c92d2, #f2fcfe);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #1c92d2, #f2fcfe); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        
    }
    .bg-cosmic-fusion{
        background: #ff00cc;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #333399, #ff00cc);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #333399, #ff00cc); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                
    }
    .bg-frost{
        background: #4d4e89 /*#004e92;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #4d4e89, #9aaed7);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #4d4e89, #9aaed7); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        
    }
	//4d4e89
//9aaed7
	
      </style>
  </head>
<body>
<div class="progress" style="height: 5px;"><div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div>

<script type="text/javascript">
  
 var urlListKSP = "<?php echo base_url("api_old/listLayer");?>";
 var urlListJIGN = "<?php echo base_url("api_old/listJIGN");?>";
 var bypass = "<?php echo base_url("api_old/bypass");?>";
 var portalUrl = "https://www.arcgis.com";
 	 
 var map, view, locateWidget, oke;
 //var identify_flag = true;
 var testLayer;
 var identifyTask, params;
 var activeWidget = null;
 var distance, area;
 var servicesArray = [];
 var listSimpulArray = [];
 var boundaryFlag = false;
 var polygonGraphicsLayer;
 var sketchViewModel;
 var myVar11, myVar12;


/*
var subHeaderArray = [
	{ id: 0, services: 13, name: 'Forest Cover'},
	{ id: 1, services: 13, name: 'Forest Change'}
];
*/
var subHeaderArray = [];
<?php
foreach($subheaders as $p){
	echo 'val = { id: '.$p->id_subheader.', services: '.$p->commodity_id.', name: "'.$p->subheader_name.'"};';
	echo 'subHeaderArray.push(val);';
	
}
?>
var subHeaderServicesArray = [];

<?php

function clear($text){
		return str_replace(["\n","\r"],"",$text);
}

foreach($services_subheaders as $p){
	//('id_subheader, id_service, type, url, layer, name, definition, resolution, coverage, data_source, year, frequency, limitation, license, citation, ');
		
	echo '
	val = { id: '.$p->id_service.', header: '.$p->id_subheader.', tipe: '.$p->type.', name: "'.$p->name.'", service: "'.$p->url.'", sub:"'.$p->layer.'", komoditi:"'.$p->commodity_name.'", definisi: "'.clear($p->definition).'", resolusi: "'.$p->resolution.'", cakupan:"'.$p->coverage.'", sumber:"'.$p->data_source.'", tahun:"'.$p->year.'", frekuensi:"'.$p->frequency.'", keterbatasan:"'.clear($p->limitation).'", lisensi:"'.$p->license.'", sitasi:"'.$p->citation.'"};';
	echo '
	subHeaderServicesArray.push(val);';	
}
?>

/*
var subHeaderServicesArray = [
	{ id: 0, header: 0, tipe: 0, name: 'Dryland Primary Forest', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/Landcover_KLHK/Dryland_Primary_Forest/MapServer', sub:0, komoditi:'Forest', definisi:'Dryland forest such as lowland forest, mountain forest, or highland tropical forest which have not intervened by human or logging activity (SNI 7645-2010)', resolusi:'1:250.000', cakupan:'Indonesia', sumber:'Ministry of Environment and Forestry', tahun:'(2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016)', frekuensi:'', keterbatasan:'Data continuity was inconsistent (2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016).<br/>Using 3 different spatial resolution (Landsat 7-8 as the Primary Data, SPOT 1000m, SPOT 250m)', lisensi:'', sitasi:'http://webgis.menlhk.go.id:8080/pl/pl.htm'},
	{ id: 1, header: 0, tipe: 0, name: 'Dryland Secondary Forest', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/Landcover_KLHK/Dryland_Secondary_Forest/MapServer', sub:0,  komoditi:'Forest', definisi:'Dryland forest such as lowland forest, mountain forest, or highland tropical forest which already intervened by human or logging activity (SNI 7645-2010)', resolusi:'1:250.000', cakupan:'Indonesia', sumber:'Ministry of Environment and Forestry', tahun:'(2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016)', frekuensi:'', keterbatasan:'Data continuity was inconsistent (2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016).<br/>Using 3 different spatial resolution (Landsat 7-8 as the Primary Data, SPOT 1000m, SPOT 250m)', lisensi:'', sitasi:'http://webgis.menlhk.go.id:8080/pl/pl.htm'},
	{ id: 2, header: 0, tipe: 0, name: 'Plantation Forest', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/kawasan_hutan/MapServer', sub:0,  komoditi:'Forest', definisi:'All plantation forest that already planted include reboisation plantation. Identification also obtained from distribution of Planttaion Forest. (Perdirjen Planologi Kehutanan Nomor: P.1/VII-IPSDH/2015)', resolusi:'1:250.000', cakupan:'Indonesia', sumber:'Ministry of Environment and Forestry', tahun:'(2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016)', frekuensi:'', keterbatasan:'Data continuity was inconsistent (2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016).<br/>Using 3 different spatial resolution (Landsat 7-8 as the Primary Data, SPOT 1000m, SPOT 250m)', lisensi:'', sitasi:'http://webgis.menlhk.go.id:8080/pl/pl.htm'},
	{ id: 3, header: 0, tipe: 0, name: 'Primary Mangrove Forest', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/Landcover_KLHK/Primary_Mangrove_Forest/MapServer', sub:0,  komoditi:'Forest', definisi:'Part of Wetland Forest (SNI 7645 - 2010).<br/>Mangrove forest, nipah (Nypa sp.), nibung (Oncosperma sp.) located near from coastline which have not intervened by human or logging activity. (Perdirjen Planologi Kehutanan Nomor: P.1/VII-IPSDH/2015)', resolusi:'1:250.000', cakupan:'Indonesia', sumber:'Ministry of Environment and Forestry', tahun:'(2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016)', frekuensi:'', keterbatasan:'Data continuity was inconsistent (2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016).<br/>Using 3 different spatial resolution (Landsat 7-8 as the Primary Data, SPOT 1000m, SPOT 250m)', lisensi:'', sitasi:'http://webgis.menlhk.go.id:8080/pl/pl.htm'},
	{ id: 4, header: 0, tipe: 0, name: 'Secondary Mangrove Forest', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/Landcover_KLHK/Secondary_Mangrove_Forest/MapServer', sub:0,  komoditi:'Forest', definisi:'Part of Wetland Forest (SNI 7645 - 2010).<br />Mangrove forest, nipah (Nypa sp.), nibung (Oncosperma sp.) located near from coastline which already disturbed by reflecting logged pattern (path or spot), water bodies or burn marks. Especially for disturbed area that converted into pond/paddy field classified as pond/paddy field and if reflecting water bodies classified as water bodies or swamp.  (Perdirjen Planologi Kehutanan Nomor: P.1/VII-IPSDH/2015)', resolusi:'1:250.000', cakupan:'Indonesia', sumber:'Ministry of Environment and Forestry', tahun:'(2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016)', frekuensi:'', keterbatasan:'Data continuity was inconsistent (2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016).<br/>Using 3 different spatial resolution (Landsat 7-8 as the Primary Data, SPOT 1000m, SPOT 250m)', lisensi:'', sitasi:'http://webgis.menlhk.go.id:8080/pl/pl.htm'},
	{ id: 5, header: 0, tipe: 0, name: 'Primary Swamp Forest', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/Landcover_KLHK/Primary_Swamp_Forest/MapServer', sub:0,  komoditi:'Forest', definisi:'Part of Wetland Forest (SNI 7645 - 2010).<br />All forest cover that laid on swamps location such as peatland (include sago forest) which have not intervened by human or logging activity. (Perdirjen Planologi Kehutanan Nomor: P.1/VII-IPSDH/2015)', cakupan:'Indonesia', sumber:'Ministry of Environment and Forestry', tahun:'(2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016)', frekuensi:'', keterbatasan:'Data continuity was inconsistent (2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016).<br/>Using 3 different spatial resolution (Landsat 7-8 as the Primary Data, SPOT 1000m, SPOT 250m)', lisensi:'', sitasi:'http://webgis.menlhk.go.id:8080/pl/pl.htm'},
	{ id: 6, header: 0, tipe: 0, name: 'Secondary Swamp Forest', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/Landcover_KLHK/Secondary_Swamp_Forest/MapServer', sub:0,  komoditi:'Forest', definisi:'Part of Wetland Forest (SNI 7645 - 2010)<br/>All forest cover that laid on swamps location such as peatland (include sago forest & ex fired forest) which already disturbed by reflecting logged pattern (path or spot), bare land, or burn marks. However, if relfecting water bodies classified as water bodies or swamp. (Perdirjen Planologi Kehutanan Nomor: P.1/VII-IPSDH/2015)', resolusi:'1:250.000', cakupan:'Indonesia', sumber:'Ministry of Environment and Forestry', tahun:'(2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016)', frekuensi:'', keterbatasan:'Data continuity was inconsistent (2000, 2003, 2006, 2009, 2011, 2012, 2013, 2016).<br/>Using 3 different spatial resolution (Landsat 7-8 as the Primary Data, SPOT 1000m, SPOT 250m)', lisensi:'', sitasi:'http://webgis.menlhk.go.id:8080/pl/pl.htm'},
	{ id: 7, header: 0, tipe: 0, name: 'Fungsi Kawasan 2017', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/Fungsi_Kawasan_KLHK2017/Fungsi_Kawasan_KLHK_2017/MapServer', sub:0,  komoditi:'Forest', definisi:'Area that stated by the government either partially or within the province with a Decree of the Minister of Forestry as forest area with certain main functions. Consist of Protection Area, Conservation Area, Production Area, Limited Production Area, Conversion Production Area and Other Land Use', resolusi:'1:250.000', cakupan:'Indonesia', sumber:'Ministry of Environment and Forestry', tahun:'2017', frekuensi:'Every change of forest area that stated by government (Ministry of environment and Forestry)', keterbatasan:'Changes of status area occur frequently. Every change of status area always followed by new Government statement.', lisensi:'', sitasi:''},
	
	{ id: 8, header: 1, tipe: 0, name: 'Tree Cover Gain', service: 'http://50.18.182.188:6080/arcgis/rest/services/ForestGain_2000_2012_map/MapServer', sub:0,  komoditi:'Forest', definisi:'Identifies areas of tree cover gain', resolusi:'30 × 30 meters', cakupan:'Global land area (excluding Antarctica and other Arctic islands)', sumber:'Hansen, M. C., P. V. Potapov, R. Moore, M. Hancher, S. A. Turubanova, A. Tyukavina, D. Thau, S. V. Stehman, S. J. Goetz, T. R. Loveland, A. Kommareddy, A. Egorov, L. Chini, C. O. Justice, and J. R. G. Townshend. 2013. “High-Resolution Global Maps of 21st-Century Forest Cover Change.” Science 342 (15 November): 850–53. Data available from: earthenginepartners.appspot.com/science-2013-global-forest.', tahun:'2001-2012', frekuensi:'Every three years', keterbatasan:'When zoomed out (< zoom level 13), pixels of gain are shaded according to the density of gain at the 30 x 30 meter scale. Pixels with darker shading represent areas with a higher concentration of tree cover gain, whereas pixels with lighter shading indicate a lower concentration of tree cover gain. There is no variation in pixel shading when the data is at full resolution (= zoom level 13).<br/>The tree cover canopy density of the displayed data is >50%.', lisensi:'CC BY 4.0', sitasi:'Use the following credit when these data are displayed:<br/>Source: Hansen/UMD/Google/USGS/NASA, accessed through Global Forest Watch<br/>Use the following credit when these data are cited:<br />Hansen, M. C., P. V. Potapov, R. Moore, M. Hancher, S. A. Turubanova, A. Tyukavina, D. Thau, S. V. Stehman, S. J. Goetz, T. R. Loveland, A. Kommareddy, A. Egorov, L. Chini, C. O. Justice, and J. R. G. Townshend. 2013. “High-Resolution Global Maps of 21st-Century Forest Cover Change.” Science 342 (15 November): 850–53. Data available on-line from:http://earthenginepartners.appspot.com/science-2013-global-forest. Accessed through Global Forest Watch on [date]. www.globalforestwatch.org'},
	
	{ id: 9, header: 1, tipe: 0, name: 'Tree Cover Loss', service: 'http://50.18.182.188:6080/arcgis/rest/services/ForestLoss_2000_2012_map/MapServer', sub:0,  komoditi:'Forest', definisi:'Identifies areas of gross tree cover loss', resolusi:'30 × 30 meters', cakupan:'Global land area (excluding Antarctica and other Arctic islands)', sumber:'Hansen, M. C., P. V. Potapov, R. Moore, M. Hancher, S. A. Turubanova, A. Tyukavina, D. Thau, S. V. Stehman, S. J. Goetz, T. R. Loveland, A. Kommareddy, A. Egorov, L. Chini, C. O. Justice, and J. R. G. Townshend. 2013. “High-Resolution Global Maps of 21st-Century Forest Cover Change.” Science 342 (15 November): 850–53. Data available from: earthenginepartners.appspot.com/science-2013-global-forest.', tahun:'2001-2018', frekuensi:'Annual', keterbatasan:'When zoomed out (< zoom level 13), pixels of loss are shaded according to the density of loss at the 30 x 30 meter scale. Pixels with darker shading represent areas with a higher concentration of tree cover loss, whereas pixels with lighter shading indicate a lower concentration of tree cover loss. There is no variation in pixel shading when the data is at full resolution (= zoom level 13).<br/>The tree cover canopy density of the displayed data varies according to the selection - use the legend on the map to change the minimum tree cover canopy density threshold.', lisensi:'CC BY 4.0', sitasi:'Use the following credit when these data are displayed:<br/>Source: Hansen/UMD/Google/USGS/NASA, accessed through Global Forest Watch<br />Use the following credit when these data are cited:<br/>Hansen, M. C., P. V. Potapov, R. Moore, M. Hancher, S. A. Turubanova, A. Tyukavina, D. Thau, S. V. Stehman, S. J. Goetz, T. R. Loveland, A. Kommareddy, A. Egorov, L. Chini, C. O. Justice, and J. R. G. Townshend. 2013. “High-Resolution Global Maps of 21st-Century Forest Cover Change.” Science 342 (15 November): 850–53. Data available on-line from:http://earthenginepartners.appspot.com/science-2013-global-forest. Accessed through Global Forest Watch on [date]. www.globalforestwatch.org'}
];
*/

var subServicesArray = [];

<?php

foreach($services_no_subheader as $p){
	//('id_subheader, id_service, type, url, layer, name, definition, resolution, coverage, data_source, year, frequency, limitation, license, citation, ');
	//var_dump($p);	
	echo '
	val = { id: '.$p->id_service.', services: '.$p->id_commodity.', tipe: '.$p->type.', name: "'.$p->name.'", service: "'.$p->url.'", sub:"'.$p->layer.'", komoditi:"'.$p->commodity_name.'", definisi: "'.clear($p->definition).'", resolusi: "'.$p->resolution.'", cakupan:"'.$p->coverage.'", sumber:"'.$p->data_source.'", tahun:"'.$p->year.'", frekuensi:"'.clear($p->frequency).'", keterbatasan:"'.clear($p->limitation).'", lisensi:"'.clear($p->license).'", sitasi:"'.clear($p->citation).'"};';
	echo '
	subServicesArray.push(val);';	
}
?>

/*
var subServicesArray = [
	{ id: 10, services: 1, tipe: 0, name: 'Oil Palm Cover', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/OilPalmAustin/MapServer', sub:0, komoditi:'Oil Palm', definisi:'', resolusi:'', cakupan:'', sumber:'', tahun:'', frekuensi:'', keterbatasan:'', lisensi:'', sitasi:''},
	//{ id: 1, services: 1, tipe: 0, name: 'Oil Palm Concession', service: '', sub:''},
	{ id: 11, services: 1, tipe: 0, name: 'Land Suitability', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/CommoditiesSuitability/MapServer', sub:3, komoditi:'Oil Palm', definisi:'Generating land suitability based on edaphic and climatic factor. Climatic suitability analyze based on SNI 7898:2014 and edaphic suitability analyze based on djaenudin et al 2011 . Edhapic factor obtained from soilgrids.org, climatic factor obtained from Worldclim.ord and Digital Elevation Model (DEM) obtained from tides.big.go.id/DEMNAS/. land suitability for this commodity combined from climate and edaphic suitability that derived based on method mentioned above', resolusi:'1 x 1 km sq', cakupan:'Indonesia', sumber:'pH in H2O , Kation Exchange Capacity, C org (all soil properties in 60cm soil depth) : Soilgrids.org<br/>Temperature, Precipitation, Wet/Dry season frequency : Worldclim.org<br/>DEM : DEMNAS (Indonesia Geospatial Agency) : http://tides.big.go.id/DEMNAS/', tahun:'', frekuensi:'-', keterbatasan:'1. not yet published in scientific paper<br/>2. Data obtained from differences source that has difference spatial resoultion (data resampled to 1 x 1 km sq based on climate data that has the biggest spatial resolution)', lisensi:'-', sitasi:'Djaenudin, D., Marwan, H., Subagjo, H., dan A. Hidayat. 2011. Petunjuk Teknis Evaluasi Lahan Untuk Komoditas Pertanian. Balai Besar Litbang Sumberdaya Lahan Pertanian, Badan Litbang Pertanian, Bogor. 36p<br/>SNI 7898 : 2014 about Prosedur Pemetaan Tingkat Kesesuaian Agroklimat<br/>Fick, S.E. and R.J. Hijmans, 2017. Worldclim 2: New 1-km spatial resolution climate surfaces for global land areas. International Journal of Climatology.<br />[BIG] Indonesia Geospatial Agency. http://tides.big.go.id/DEMNAS/#Info<br/>[ISRIC] International Soil Reference and Information Centre. https://soilgrids.org/#!/?layer=ORCDRC_M_sl2_250m&vector=1'},
	//{ id: 3, services: 2, tipe: 0, name: 'Paddy Cover', service: '', sub:2},
	//{ id: 4, services: 2, tipe: 0, name: 'Paddy Field', service: '', sub:''},
	{ id: 12, services: 2, tipe: 0, name: 'Land Suitability', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/CommoditiesSuitability/MapServer', sub:4, komoditi:'Paddy', definisi:'Generating land suitability based on edaphic and climatic factor. Climatic suitability analyze based on SNI 7898:2014 and edaphic suitability analyze based on djaenudin et al 2011 . Edhapic factor obtained from soilgrids.org, climatic factor obtained from Worldclim.ord and Digital Elevation Model (DEM) obtained from tides.big.go.id/DEMNAS/. land suitability for this commodity combined from climate and edaphic suitability that derived based on method mentioned above', resolusi:'1 x 1 km sq', cakupan:'Indonesia', sumber:'pH in H2O , Kation Exchange Capacity, C org (all soil properties in 60cm soil depth) : Soilgrids.org<br/>Temperature, Precipitation, Wet/Dry season frequency : Worldclim.org<br/>DEM : DEMNAS (Indonesia Geospatial Agency) : http://tides.big.go.id/DEMNAS/', tahun:'', frekuensi:'-', keterbatasan:'1. not yet published in scientific paper<br/>2. Data obtained from differences source that has difference spatial resoultion (data resampled to 1 x 1 km sq based on climate data that has the biggest spatial resolution)', lisensi:'-', sitasi:'Djaenudin, D., Marwan, H., Subagjo, H., dan A. Hidayat. 2011. Petunjuk Teknis Evaluasi Lahan Untuk Komoditas Pertanian. Balai Besar Litbang Sumberdaya Lahan Pertanian, Badan Litbang Pertanian, Bogor. 36p<br/>SNI 7898 : 2014 about Prosedur Pemetaan Tingkat Kesesuaian Agroklimat<br/>Fick, S.E. and R.J. Hijmans, 2017. Worldclim 2: New 1-km spatial resolution climate surfaces for global land areas. International Journal of Climatology.<br />[BIG] Indonesia Geospatial Agency. http://tides.big.go.id/DEMNAS/#Info<br/>[ISRIC] International Soil Reference and Information Centre. https://soilgrids.org/#!/?layer=ORCDRC_M_sl2_250m&vector=1'},
	//{ id: 6, services: 3, tipe: 0, name: 'Rubber Cover', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/CommoditiesSuitability/MapServer', sub:3},
	{ id: 13, services: 3, tipe: 0, name: 'Land Suitability', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/CommoditiesSuitability/MapServer', sub:1, komoditi:'Rubber', definisi:'Generating land suitability based on edaphic and climatic factor. Climatic suitability analyze based on SNI 7898:2014 and edaphic suitability analyze based on djaenudin et al 2011 . Edhapic factor obtained from soilgrids.org, climatic factor obtained from Worldclim.ord and Digital Elevation Model (DEM) obtained from tides.big.go.id/DEMNAS/. land suitability for this commodity combined from climate and edaphic suitability that derived based on method mentioned above', resolusi:'1 x 1 km sq', cakupan:'Indonesia', sumber:'pH in H2O , Kation Exchange Capacity, C org (all soil properties in 60cm soil depth) : Soilgrids.org<br/>Temperature, Precipitation, Wet/Dry season frequency : Worldclim.org<br/>DEM : DEMNAS (Indonesia Geospatial Agency) : http://tides.big.go.id/DEMNAS/', tahun:'', frekuensi:'-', keterbatasan:'1. not yet published in scientific paper<br/>2. Data obtained from differences source that has difference spatial resoultion (data resampled to 1 x 1 km sq based on climate data that has the biggest spatial resolution)', lisensi:'-', sitasi:'Djaenudin, D., Marwan, H., Subagjo, H., dan A. Hidayat. 2011. Petunjuk Teknis Evaluasi Lahan Untuk Komoditas Pertanian. Balai Besar Litbang Sumberdaya Lahan Pertanian, Badan Litbang Pertanian, Bogor. 36p<br/>SNI 7898 : 2014 about Prosedur Pemetaan Tingkat Kesesuaian Agroklimat<br/>Fick, S.E. and R.J. Hijmans, 2017. Worldclim 2: New 1-km spatial resolution climate surfaces for global land areas. International Journal of Climatology.<br />[BIG] Indonesia Geospatial Agency. http://tides.big.go.id/DEMNAS/#Info<br/>[ISRIC] International Soil Reference and Information Centre. https://soilgrids.org/#!/?layer=ORCDRC_M_sl2_250m&vector=1'},
	//{ id: 8, services: 4, tipe: 0, name: 'Coffee Cover', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/CommoditiesSuitability/MapServer', sub:4},
	{ id: 14, services: 4, tipe: 0, name: 'Land Suitability', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/CommoditiesSuitability/MapServer', sub:0, komoditi:'Coffee', definisi:'Generating land suitability based on edaphic and climatic factor. Climatic suitability analyze based on SNI 7898:2014 and edaphic suitability analyze based on djaenudin et al 2011 . Edhapic factor obtained from soilgrids.org, climatic factor obtained from Worldclim.ord and Digital Elevation Model (DEM) obtained from tides.big.go.id/DEMNAS/. land suitability for this commodity combined from climate and edaphic suitability that derived based on method mentioned above', resolusi:'1 x 1 km sq', cakupan:'Indonesia', sumber:'pH in H2O , Kation Exchange Capacity, C org (all soil properties in 60cm soil depth) : Soilgrids.org<br/>Temperature, Precipitation, Wet/Dry season frequency : Worldclim.org<br/>DEM : DEMNAS (Indonesia Geospatial Agency) : http://tides.big.go.id/DEMNAS/', tahun:'', frekuensi:'-', keterbatasan:'1. not yet published in scientific paper<br/>2. Data obtained from differences source that has difference spatial resoultion (data resampled to 1 x 1 km sq based on climate data that has the biggest spatial resolution)', lisensi:'-', sitasi:'Djaenudin, D., Marwan, H., Subagjo, H., dan A. Hidayat. 2011. Petunjuk Teknis Evaluasi Lahan Untuk Komoditas Pertanian. Balai Besar Litbang Sumberdaya Lahan Pertanian, Badan Litbang Pertanian, Bogor. 36p<br/>SNI 7898 : 2014 about Prosedur Pemetaan Tingkat Kesesuaian Agroklimat<br/>Fick, S.E. and R.J. Hijmans, 2017. Worldclim 2: New 1-km spatial resolution climate surfaces for global land areas. International Journal of Climatology.<br />[BIG] Indonesia Geospatial Agency. http://tides.big.go.id/DEMNAS/#Info<br/>[ISRIC] International Soil Reference and Information Centre. https://soilgrids.org/#!/?layer=ORCDRC_M_sl2_250m&vector=1'},
	//{ id: 10, services: 5, tipe: 0, name: 'Cocoa Cover', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/CommoditiesSuitability/MapServer', sub:1},
	{ id: 15, services: 5, tipe: 0, name: 'Land Suitability', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/UNDP/CommoditiesSuitability/MapServer', sub:2, komoditi:'Cocoa', definisi:'Generating land suitability based on edaphic and climatic factor. Climatic suitability analyze based on SNI 7898:2014 and edaphic suitability analyze based on djaenudin et al 2011 . Edhapic factor obtained from soilgrids.org, climatic factor obtained from Worldclim.ord and Digital Elevation Model (DEM) obtained from tides.big.go.id/DEMNAS/. land suitability for this commodity combined from climate and edaphic suitability that derived based on method mentioned above', resolusi:'1 x 1 km sq', cakupan:'Indonesia', sumber:'pH in H2O , Kation Exchange Capacity, C org (all soil properties in 60cm soil depth) : Soilgrids.org<br/>Temperature, Precipitation, Wet/Dry season frequency : Worldclim.org<br/>DEM : DEMNAS (Indonesia Geospatial Agency) : http://tides.big.go.id/DEMNAS/', tahun:'', frekuensi:'-', keterbatasan:'1. not yet published in scientific paper<br/>2. Data obtained from differences source that has difference spatial resoultion (data resampled to 1 x 1 km sq based on climate data that has the biggest spatial resolution)', lisensi:'-', sitasi:'Djaenudin, D., Marwan, H., Subagjo, H., dan A. Hidayat. 2011. Petunjuk Teknis Evaluasi Lahan Untuk Komoditas Pertanian. Balai Besar Litbang Sumberdaya Lahan Pertanian, Badan Litbang Pertanian, Bogor. 36p<br/>SNI 7898 : 2014 about Prosedur Pemetaan Tingkat Kesesuaian Agroklimat<br/>Fick, S.E. and R.J. Hijmans, 2017. Worldclim 2: New 1-km spatial resolution climate surfaces for global land areas. International Journal of Climatology.<br />[BIG] Indonesia Geospatial Agency. http://tides.big.go.id/DEMNAS/#Info<br/>[ISRIC] International Soil Reference and Information Centre. https://soilgrids.org/#!/?layer=ORCDRC_M_sl2_250m&vector=1'},
	{ id: 16, services: 6, tipe: 0, name: 'Devegetation Alert (IPB) 2018', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/EarlyWarning/2019/MapServer', sub:'', komoditi:'', definisi:'Extending the theme of deforestation, it is an urgent need to develop a near real-time deforestation detection system that provides accurate and up-to-date information of forest cover change that can be seen by the public to make sure the transparency of forest resources management. In this context, remote-sensing technology seems to be a powerful tool to monitor the forest cover change immediately<br />The uses of high temporal satellite imagery are necessary to develop methodologies that utilize information on daily variations of lands to detect the changes in forest cover.<br/>This study attempted to detect the change of forest cover quickly, which can be reflected by the change in inter-monthly period of temporal land surface dynamics based on two spectral indices: NDVI and OAI. Our results indicated that the use of MODIS data as a basic information in the near realtime system offers great promise to detect the forest cover change in Indonesia’s forestland, with the overall user’s accuracy was revealed to be 90.07%. Considering the accuracy of the near real-time detection system, the methodology proposed in this study provides useful information for forest monitoring at national level of Indonesia, and it can be updated with new information in monthly basis. The results of the detection system developed in this article also available publicly through the REDD+ situation room.', resolusi:'500 x 500 sq m', cakupan:'Indonesia', sumber:'Setiawan Y,  Kustiyo, Darmawan A. 2016. A simple method for developing near real-time nation wide forest monitoring for Indonesia using MODIS near-and shortwave infrared bands. Remote Sensing Letters. 7:4, 318-327. DOI:10.1080/2150704X.2015.1137645', tahun:'2018 - now', frekuensi:'Annual 8 days', keterbatasan:'The overall user’s accuracy was revealed to be approximately 90.07%, (9.93% of the forest cover change was recognized incorrectly). The producer’s accuracy was revealed to be 65.03%, (34.97% of the forest cover change area was not assigned to be a forest cover change by the system). This result showed the need to evaluate the threshold used to assign a change in forest cover. (Mentioned in paper)', lisensi:'', sitasi:'Setiawan Y,  Kustiyo, Darmawan A. 2016. A simple method for developing near real-time nation wide forest monitoring for Indonesia using MODIS near-and shortwave infrared bands. Remote Sensing Letters. 7:4, 318-327. DOI:10.1080/2150704X.2015.1137645'},
	{ id: 17, services: 6, tipe: 0, name: 'Devegetation Alert (IPB) 2019', service: 'https://forests2020.ipb.ac.id/arcgis/rest/services/EWS_2019_249/EWS_2019_249/MapServer', sub:'', komoditi:'', definisi:'Extending the theme of deforestation, it is an urgent need to develop a near real-time deforestation detection system that provides accurate and up-to-date information of forest cover change that can be seen by the public to make sure the transparency of forest resources management. In this context, remote-sensing technology seems to be a powerful tool to monitor the forest cover change immediately<br />The uses of high temporal satellite imagery are necessary to develop methodologies that utilize information on daily variations of lands to detect the changes in forest cover.<br/>This study attempted to detect the change of forest cover quickly, which can be reflected by the change in inter-monthly period of temporal land surface dynamics based on two spectral indices: NDVI and OAI. Our results indicated that the use of MODIS data as a basic information in the near realtime system offers great promise to detect the forest cover change in Indonesia’s forestland, with the overall user’s accuracy was revealed to be 90.07%. Considering the accuracy of the near real-time detection system, the methodology proposed in this study provides useful information for forest monitoring at national level of Indonesia, and it can be updated with new information in monthly basis. The results of the detection system developed in this article also available publicly through the REDD+ situation room.', resolusi:'500 x 500 sq m', cakupan:'Indonesia', sumber:'Setiawan Y,  Kustiyo, Darmawan A. 2016. A simple method for developing near real-time nation wide forest monitoring for Indonesia using MODIS near-and shortwave infrared bands. Remote Sensing Letters. 7:4, 318-327. DOI:10.1080/2150704X.2015.1137645', tahun:'2018 - now', frekuensi:'Annual 8 days', keterbatasan:'The overall user’s accuracy was revealed to be approximately 90.07%, (9.93% of the forest cover change was recognized incorrectly). The producer’s accuracy was revealed to be 65.03%, (34.97% of the forest cover change area was not assigned to be a forest cover change by the system). This result showed the need to evaluate the threshold used to assign a change in forest cover. (Mentioned in paper)', lisensi:'', sitasi:'Setiawan Y,  Kustiyo, Darmawan A. 2016. A simple method for developing near real-time nation wide forest monitoring for Indonesia using MODIS near-and shortwave infrared bands. Remote Sensing Letters. 7:4, 318-327. DOI:10.1080/2150704X.2015.1137645'},
	//{ id: 13, services: 6, tipe: 2, name: 'Deforestation Alert (GLAD)', service: 'https://tiles.globalforestwatch.org/glad_prod/tiles/{level}/{col}/{row}.png', sub:''},
	//{ id: 14, services: 6, tipe: 2, name: 'Deforestation Alert (FORMA)', service: 'https://storage.googleapis.com/forma-public/Forma250/tiles/forma_20190518/v1/{level}/{col}/{row}.png',sub:''},
];

*/
 var toolsArray = [
     { id: 0, logo:'basemap_off.png', name: 'Basemap'},
     { id: 1, logo:'Layers_off.png', name: 'Layers'},
     { id: 2, logo:'legend_off.png', name: 'Legend'},
     { id: 3, logo:'analisis_off.png', name: 'Analysis'},
     { id: 4, logo:'simpul_off.png', name: 'Jaringan Informasi Geospasial Nasional'},
     { id: 5, logo:'search_off.png', name: 'Pencarian'},
     { id: 6, logo:'help_off.png', name: 'Help'}
 ];

 var tipeSimpulArray = [
	  { id: 0, name: 'Kementrian/Lembaga'},
	  { id: 1, name: 'Pemerintah Daerah'}

 ];
 
 var tipeBatasArray = [
	  { id: 0, name: 'Provinsi'},
	  { id: 1, name: 'Kabupaten/Kota'}
 ];
 
 var listProvinsiArray = [
	{'id':0,'prov':'Aceh'},
	{'id':1,'prov':'Bali'},
	{'id':2,'prov':'Banten'},
	{'id':3,'prov':'Bengkulu'},
	{'id':4,'prov':'D.I. Yogyakarta'},
	{'id':5,'prov':'D.K.I. Jakarta'},
	{'id':6,'prov':'Gorontalo'},
	{'id':7,'prov':'Jambi'},
	{'id':8,'prov':'Jawa Barat'},
	{'id':9,'prov':'Jawa Tengah'},
	{'id':10,'prov':'Jawa Timur'},
	{'id':11,'prov':'Kalimantan Barat'},
	{'id':12,'prov':'Kalimantan Selatan'},
	{'id':13,'prov':'Kalimantan Tengah'},
	{'id':14,'prov':'Kalimantan Timur'},
	{'id':15,'prov':'Kalimantan Utara'},
	{'id':16,'prov':'Kepulauan Bangka Belitung'},
	{'id':17,'prov':'Kepulauan Riau'},
	{'id':18,'prov':'Lampung'},
	{'id':19,'prov':'Maluku'},
	{'id':20,'prov':'Maluku Utara'},
	{'id':21,'prov':'Nusa Tenggara Barat'},
	{'id':22,'prov':'Nusa Tenggara Timur'},
	{'id':23,'prov':'Papua'},
	{'id':24,'prov':'Papua Barat'},
	{'id':25,'prov':'Riau'},
	{'id':26,'prov':'Sulawesi Barat'},
	{'id':27,'prov':'Sulawesi Selatan'},
	{'id':28,'prov':'Sulawesi Tengah'},
	{'id':29,'prov':'Sulawesi Tenggara'},
	{'id':30,'prov':'Sulawesi Utara'},
	{'id':31,'prov':'Sumatera Barat'},
	{'id':32,'prov':'Sumatera Selatan'},
	{'id':33,'prov':'Sumatera Utara'}
 ]
 
 var listKabKot = [
	{'id':0,'kabkot':'Alor','prov':22},
{'id':1,'kabkot':'Bangli','prov':1},
{'id':2,'kabkot':'Belu','prov':22},
{'id':3,'kabkot':'Buleleng','prov':1},
{'id':4,'kabkot':'Dompu','prov':21},
{'id':5,'kabkot':'Ende','prov':22},
{'id':6,'kabkot':'Gianyar','prov':1},
{'id':7,'kabkot':'Jembrana','prov':1},
{'id':8,'kabkot':'Bima','prov':21},
{'id':9,'kabkot':'Kupang','prov':22},
{'id':10,'kabkot':'Karangasem','prov':1},
{'id':11,'kabkot':'Klungkung','prov':1},
{'id':12,'kabkot':'Kota Bima','prov':21},
{'id':13,'kabkot':'Kota Denpasar','prov':1},
{'id':14,'kabkot':'Kota Kupang','prov':22},
{'id':15,'kabkot':'Kota Mataram','prov':21},
{'id':16,'kabkot':'Lembata','prov':22},
{'id':17,'kabkot':'Lombok Barat','prov':21},
{'id':18,'kabkot':'Lombok Tengah','prov':21},
{'id':19,'kabkot':'Lombok Timur','prov':21},
{'id':20,'kabkot':'Lombok Utara','prov':21},
{'id':21,'kabkot':'Malaka','prov':22},
{'id':22,'kabkot':'Manggarai','prov':22},
{'id':23,'kabkot':'Manggarai Barat','prov':22},
{'id':24,'kabkot':'Manggarai Timur','prov':22},
{'id':25,'kabkot':'Ngada','prov':22},
{'id':26,'kabkot':'Rote Ndao','prov':22},
{'id':27,'kabkot':'Sabu Raijua','prov':22},
{'id':28,'kabkot':'Sikka','prov':22},
{'id':29,'kabkot':'Sumba Barat','prov':22},
{'id':30,'kabkot':'Sumba Barat Daya','prov':22},
{'id':31,'kabkot':'Sumba Tengah','prov':22},
{'id':32,'kabkot':'Sumba Timur','prov':22},
{'id':33,'kabkot':'Sumbawa','prov':21},
{'id':34,'kabkot':'Sumbawa Barat','prov':21},
{'id':35,'kabkot':'Tabanan','prov':1},
{'id':36,'kabkot':'Timor Tengah Selatan','prov':22},
{'id':37,'kabkot':'Timor Tengah Utara','prov':22},
{'id':38,'kabkot':'Nagekeo','prov':22},
{'id':39,'kabkot':'Flores Timur','prov':22},
{'id':40,'kabkot':'Badung','prov':1},
{'id':41,'kabkot':'Bandung','prov':8},
{'id':42,'kabkot':'Bandung Barat','prov':8},
{'id':43,'kabkot':'Bangkalan','prov':10},
{'id':44,'kabkot':'Banjarnegara','prov':9},
{'id':45,'kabkot':'Bantul','prov':4},
{'id':46,'kabkot':'Banyumas','prov':9},
{'id':47,'kabkot':'Banyuwangi','prov':10},
{'id':48,'kabkot':'Batang','prov':9},
{'id':49,'kabkot':'Bekasi','prov':8},
{'id':50,'kabkot':'Blitar','prov':10},
{'id':51,'kabkot':'Blora','prov':9},
{'id':52,'kabkot':'Bogor','prov':8},
{'id':53,'kabkot':'Bojonegoro','prov':10},
{'id':54,'kabkot':'Bondowoso','prov':10},
{'id':55,'kabkot':'Boyolali','prov':9},
{'id':56,'kabkot':'Ciamis','prov':8},
{'id':57,'kabkot':'Cianjur','prov':8},
{'id':58,'kabkot':'Cilacap','prov':9},
{'id':59,'kabkot':'Kota Cimahi','prov':8},
{'id':60,'kabkot':'Cirebon','prov':8},
{'id':61,'kabkot':'Demak','prov':9},
{'id':62,'kabkot':'Garut','prov':8},
{'id':63,'kabkot':'Gresik','prov':10},
{'id':64,'kabkot':'Grobogan','prov':9},
{'id':65,'kabkot':'Gunung Kidul','prov':4},
{'id':66,'kabkot':'Indramayu','prov':8},
{'id':67,'kabkot':'Jember','prov':10},
{'id':68,'kabkot':'Jepara','prov':9},
{'id':69,'kabkot':'Jombang','prov':10},
{'id':70,'kabkot':'Karanganyar','prov':9},
{'id':71,'kabkot':'Karawang','prov':8},
{'id':72,'kabkot':'Kebumen','prov':9},
{'id':73,'kabkot':'Kediri','prov':10},
{'id':74,'kabkot':'Kendal','prov':9},
{'id':75,'kabkot':'Kepulauan Seribu','prov':5},
{'id':76,'kabkot':'Klaten','prov':9},
{'id':77,'kabkot':'Kota Bandung','prov':8},
{'id':78,'kabkot':'Kota Banjar','prov':8},
{'id':79,'kabkot':'Kota Batu','prov':10},
{'id':80,'kabkot':'Kota Bekasi','prov':8},
{'id':81,'kabkot':'Kota Blitar','prov':10},
{'id':82,'kabkot':'Kota Bogor','prov':8},
{'id':83,'kabkot':'Kota Cilegon','prov':2},
{'id':84,'kabkot':'Kota Cirebon','prov':8},
{'id':85,'kabkot':'Kota Depok','prov':8},
{'id':86,'kabkot':'Kota Jakarta Barat','prov':5},
{'id':87,'kabkot':'Kota Jakarta Pusat','prov':5},
{'id':88,'kabkot':'Kota Jakarta Selatan','prov':5},
{'id':89,'kabkot':'Kota Jakarta Timur','prov':5},
{'id':90,'kabkot':'Kota Jakarta Utara','prov':5},
{'id':91,'kabkot':'Kota Kediri','prov':10},
{'id':92,'kabkot':'Kota Madiun','prov':10},
{'id':93,'kabkot':'Kota Magelang','prov':9},
{'id':94,'kabkot':'Kota Malang','prov':10},
{'id':95,'kabkot':'Kota Mojokerto','prov':10},
{'id':96,'kabkot':'Kota Pasuruan','prov':10},
{'id':97,'kabkot':'Kota Pekalongan','prov':9},
{'id':98,'kabkot':'Kota Probolinggo','prov':10},
{'id':99,'kabkot':'Kota Salatiga','prov':9},
{'id':100,'kabkot':'Kota Serang','prov':2},
{'id':101,'kabkot':'Kota Sukabumi','prov':8},
{'id':102,'kabkot':'Kota Surabaya','prov':10},
{'id':103,'kabkot':'Kota Surakarta','prov':9},
{'id':104,'kabkot':'Kota Tangerang','prov':2},
{'id':105,'kabkot':'Kota Tangerang Selatan','prov':2},
{'id':106,'kabkot':'Kota Tasikmalaya','prov':8},
{'id':107,'kabkot':'Kota Tegal','prov':9},
{'id':108,'kabkot':'Kota Yogyakarta','prov':4},
{'id':109,'kabkot':'Kudus','prov':9},
{'id':110,'kabkot':'Kulonprogo','prov':4},
{'id':111,'kabkot':'Kuningan','prov':8},
{'id':112,'kabkot':'Lamongan','prov':10},
{'id':113,'kabkot':'Lebak','prov':2},
{'id':114,'kabkot':'Lumajang','prov':10},
{'id':115,'kabkot':'Madiun','prov':10},
{'id':116,'kabkot':'Magelang','prov':9},
{'id':117,'kabkot':'Magetan','prov':10},
{'id':118,'kabkot':'Majalengka','prov':8},
{'id':119,'kabkot':'Malang','prov':10},
{'id':120,'kabkot':'Mojokerto','prov':10},
{'id':121,'kabkot':'Nganjuk','prov':10},
{'id':122,'kabkot':'Ngawi','prov':10},
{'id':123,'kabkot':'Pacitan','prov':10},
{'id':124,'kabkot':'Pamekasan','prov':10},
{'id':125,'kabkot':'Pandeglang','prov':2},
{'id':126,'kabkot':'Pangandaran','prov':8},
{'id':127,'kabkot':'Pasuruan','prov':10},
{'id':128,'kabkot':'Pati','prov':9},
{'id':129,'kabkot':'Pekalongan','prov':9},
{'id':130,'kabkot':'Pemalang','prov':9},
{'id':131,'kabkot':'Ponorogo','prov':10},
{'id':132,'kabkot':'Probolinggo','prov':10},
{'id':133,'kabkot':'Purbalingga','prov':9},
{'id':134,'kabkot':'Purwakarta','prov':8},
{'id':135,'kabkot':'Purworejo','prov':9},
{'id':136,'kabkot':'Rembang','prov':9},
{'id':137,'kabkot':'Sampang','prov':10},
{'id':138,'kabkot':'Semarang','prov':9},
{'id':139,'kabkot':'Serang','prov':2},
{'id':140,'kabkot':'Sidoarjo','prov':10},
{'id':141,'kabkot':'Sidoarjo/Pasuruan','prov':10},
{'id':142,'kabkot':'Situbondo','prov':10},
{'id':143,'kabkot':'Sleman','prov':4},
{'id':144,'kabkot':'Sragen','prov':9},
{'id':145,'kabkot':'Subang','prov':8},
{'id':146,'kabkot':'Sukabumi','prov':8},
{'id':147,'kabkot':'Sukoharjo','prov':9},
{'id':148,'kabkot':'Sumedang','prov':8},
{'id':149,'kabkot':'Sumenep','prov':10},
{'id':150,'kabkot':'Tangerang','prov':2},
{'id':151,'kabkot':'Tasikmalaya','prov':8},
{'id':152,'kabkot':'Tegal','prov':9},
{'id':153,'kabkot':'Temanggung','prov':9},
{'id':154,'kabkot':'Trenggalek','prov':10},
{'id':155,'kabkot':'Tuban','prov':10},
{'id':156,'kabkot':'Tulungagung','prov':10},
{'id':157,'kabkot':'Wonogiri','prov':9},
{'id':158,'kabkot':'Wonosobo','prov':9},
{'id':159,'kabkot':'Kota Semarang','prov':9},
{'id':160,'kabkot':'Brebes','prov':9},
{'id':161,'kabkot':'Kotabaru','prov':12},
{'id':162,'kabkot':'Tanahlaut','prov':12},
{'id':163,'kabkot':'Tanahbumbu','prov':12},
{'id':164,'kabkot':'Area Dalam Pembahasan','prov':12},
{'id':165,'kabkot':'Barito Kuala','prov':12},
{'id':166,'kabkot':'Kapuas','prov':13},
{'id':167,'kabkot':'Kota Banjarbaru','prov':12},
{'id':168,'kabkot':'Katingan','prov':13},
{'id':169,'kabkot':'Kota Banjarmasin','prov':12},
{'id':170,'kabkot':'Ketapang','prov':11},
{'id':171,'kabkot':'Kotawaringin Timur','prov':13},
{'id':172,'kabkot':'Kotawaringin Barat','prov':13},
{'id':173,'kabkot':'Banjar','prov':12},
{'id':174,'kabkot':'Tapin','prov':12},
{'id':175,'kabkot':'Hulu Sungai Selatan','prov':12},
{'id':176,'kabkot':'Hulu Sungai Tengah','prov':12},
{'id':177,'kabkot':'Hulu Sungai Utara','prov':12},
{'id':178,'kabkot':'Sukamara','prov':13},
{'id':179,'kabkot':'Balangan','prov':12},
{'id':180,'kabkot':'Kayong Utara','prov':11},
{'id':181,'kabkot':'Barito Timur','prov':13},
{'id':182,'kabkot':'Kota Palangkaraya','prov':13},
{'id':183,'kabkot':'Pulangpisau','prov':13},
{'id':184,'kabkot':'Tabalong','prov':12},
{'id':185,'kabkot':'Barito Selatan','prov':13},
{'id':186,'kabkot':'Lamandau','prov':13},
{'id':187,'kabkot':'Penajampaser Utara','prov':14},
{'id':188,'kabkot':'Kota Balikpapan','prov':14},
{'id':189,'kabkot':'Paser','prov':14},
{'id':190,'kabkot':'Kuburaya','prov':11},
{'id':191,'kabkot':'Kutaikartanegara','prov':14},
{'id':192,'kabkot':'Seruyan','prov':13},
{'id':193,'kabkot':'Kota Samarinda','prov':14},
{'id':194,'kabkot':'Gunungmas','prov':13},
{'id':195,'kabkot':'Melawi','prov':11},
{'id':196,'kabkot':'Barito Utara','prov':13},
{'id':197,'kabkot':'Kota Pontianak','prov':11},
{'id':198,'kabkot':'Kota Bontang','prov':14},
{'id':199,'kabkot':'Mempawah','prov':11},
{'id':200,'kabkot':'Kutai Timur','prov':14},
{'id':201,'kabkot':'Kutai Barat','prov':14},
{'id':202,'kabkot':'Bengkayang','prov':11},
{'id':203,'kabkot':'Sekadau','prov':11},
{'id':204,'kabkot':'Murung Raya','prov':13},
{'id':205,'kabkot':'Kota Singkawang','prov':11},
{'id':206,'kabkot':'Landak','prov':11},
{'id':207,'kabkot':'Sintang','prov':11},
{'id':208,'kabkot':'Berau','prov':14},
{'id':209,'kabkot':'Sanggau','prov':11},
{'id':210,'kabkot':'Mahakamulu','prov':14},
{'id':211,'kabkot':'Kapuas Hulu','prov':11},
{'id':212,'kabkot':'Sambas','prov':11},
{'id':213,'kabkot':'Bulungan','prov':15},
{'id':214,'kabkot':'Kota Tarakan','prov':15},
{'id':215,'kabkot':'Tanatidung','prov':15},
{'id':216,'kabkot':'Malinau','prov':15},
{'id':217,'kabkot':'Nunukan','prov':15},
{'id':218,'kabkot':'Area Dalam Pembahasan','prov':19},
{'id':219,'kabkot':'Area Dalam Pembahasan','prov':20},
{'id':220,'kabkot':'Area Dalam Pembahasan','prov':20},
{'id':221,'kabkot':'Buru','prov':19},
{'id':222,'kabkot':'Buru Selatan','prov':19},
{'id':223,'kabkot':'Halmahera Barat','prov':20},
{'id':224,'kabkot':'Halmahera Selatan','prov':20},
{'id':225,'kabkot':'Halmahera Tengah','prov':20},
{'id':226,'kabkot':'Halmahera Timur','prov':20},
{'id':227,'kabkot':'Halmahera Utara','prov':20},
{'id':228,'kabkot':'Halmahera Utara/Halmahera Barat','prov':20},
{'id':229,'kabkot':'Kepulauan Aru','prov':19},
{'id':230,'kabkot':'Kepulauan Sula','prov':20},
{'id':231,'kabkot':'Kota Ambon','prov':19},
{'id':232,'kabkot':'Kota Ternate','prov':20},
{'id':233,'kabkot':'Kota Tidore Kepulauan','prov':20},
{'id':234,'kabkot':'Kota Tual','prov':19},
{'id':235,'kabkot':'Maluku Barat Daya','prov':19},
{'id':236,'kabkot':'Maluku Tengah','prov':19},
{'id':237,'kabkot':'Maluku Tenggara','prov':19},
{'id':238,'kabkot':'Maluku Tenggara Barat','prov':19},
{'id':239,'kabkot':'Pulau Morotai','prov':20},
{'id':240,'kabkot':'Pulau Taliabu','prov':20},
{'id':241,'kabkot':'Seram Bagian Barat','prov':19},
{'id':242,'kabkot':'Seram Bagian Barat/Halmahera Selatan','prov':20},
{'id':243,'kabkot':'Seram Bagian Timur','prov':19},
{'id':244,'kabkot':'Asmat','prov':23},
{'id':245,'kabkot':'Biak Numfor','prov':23},
{'id':246,'kabkot':'Boven Digoel','prov':23},
{'id':247,'kabkot':'Deiyai','prov':23},
{'id':248,'kabkot':'Dogiyai','prov':23},
{'id':249,'kabkot':'Fak Fak','prov':24},
{'id':250,'kabkot':'Intan Jaya','prov':23},
{'id':251,'kabkot':'Jayapura','prov':23},
{'id':252,'kabkot':'Jayawijaya','prov':23},
{'id':253,'kabkot':'Kaimana','prov':24},
{'id':254,'kabkot':'Keerom','prov':23},
{'id':255,'kabkot':'Kepulauan Yapen','prov':23},
{'id':256,'kabkot':'Kota Jayapura','prov':23},
{'id':257,'kabkot':'Kota Sorong','prov':24},
{'id':258,'kabkot':'Lanny Jaya','prov':23},
{'id':259,'kabkot':'Mamberamo Raya','prov':23},
{'id':260,'kabkot':'Mamberamo Tengah','prov':23},
{'id':261,'kabkot':'Manokwari','prov':24},
{'id':262,'kabkot':'Manokwari Selatan','prov':24},
{'id':263,'kabkot':'Mappi','prov':23},
{'id':264,'kabkot':'Maybrat','prov':24},
{'id':265,'kabkot':'Merauke','prov':23},
{'id':266,'kabkot':'Mimika','prov':23},
{'id':267,'kabkot':'Nabire','prov':23},
{'id':268,'kabkot':'Nduga','prov':23},
{'id':269,'kabkot':'Paniai','prov':23},
{'id':270,'kabkot':'Pegunungan Arfak','prov':24},
{'id':271,'kabkot':'Pegunungan Bintang','prov':23},
{'id':272,'kabkot':'Puncak','prov':23},
{'id':273,'kabkot':'Puncak Jaya','prov':23},
{'id':274,'kabkot':'Raja Ampat','prov':24},
{'id':275,'kabkot':'Sarmi','prov':23},
{'id':276,'kabkot':'Sorong','prov':24},
{'id':277,'kabkot':'Sorong Selatan','prov':24},
{'id':278,'kabkot':'Supiori','prov':23},
{'id':279,'kabkot':'Tambrauw','prov':24},
{'id':280,'kabkot':'Teluk Bintuni','prov':24},
{'id':281,'kabkot':'Teluk Wondama','prov':24},
{'id':282,'kabkot':'Teluk Wondama/Manokwari Selatan','prov':24},
{'id':283,'kabkot':'Tolikara','prov':23},
{'id':284,'kabkot':'Waropen','prov':23},
{'id':285,'kabkot':'Yahukimo','prov':23},
{'id':286,'kabkot':'Yalimo','prov':23},
{'id':287,'kabkot':'Bantaeng','prov':27},
{'id':288,'kabkot':'Barru','prov':27},
{'id':289,'kabkot':'Bone','prov':27},
{'id':290,'kabkot':'Bulukumba','prov':27},
{'id':291,'kabkot':'Enrekang','prov':27},
{'id':292,'kabkot':'Gowa','prov':27},
{'id':293,'kabkot':'Jeneponto','prov':27},
{'id':294,'kabkot':'Area Dalam Pembahasan','prov':12},
{'id':295,'kabkot':'Kepulauan Selayar','prov':27},
{'id':296,'kabkot':'Kota Makassar','prov':27},
{'id':297,'kabkot':'Kota Palopo','prov':27},
{'id':298,'kabkot':'Kota Pare Pare','prov':27},
{'id':299,'kabkot':'Luwu','prov':27},
{'id':300,'kabkot':'Luwu Timur','prov':27},
{'id':301,'kabkot':'Luwu Utara','prov':27},
{'id':302,'kabkot':'Majene','prov':26},
{'id':303,'kabkot':'Mamasa','prov':26},
{'id':304,'kabkot':'Mamuju','prov':26},
{'id':305,'kabkot':'Mamuju Tengah','prov':26},
{'id':306,'kabkot':'Mamuju Utara','prov':26},
{'id':307,'kabkot':'Maros','prov':27},
{'id':308,'kabkot':'Pangkajene Kepulauan','prov':27},
{'id':309,'kabkot':'Pinrang','prov':27},
{'id':310,'kabkot':'Polewali Mandar','prov':26},
{'id':311,'kabkot':'Sidenreng Rappang','prov':27},
{'id':312,'kabkot':'Sinjai','prov':27},
{'id':313,'kabkot':'Soppeng','prov':27},
{'id':314,'kabkot':'Takalar','prov':27},
{'id':315,'kabkot':'Tana Toraja','prov':27},
{'id':316,'kabkot':'Toraja Utara','prov':27},
{'id':317,'kabkot':'Wajo','prov':27},
{'id':318,'kabkot':'Banggai','prov':28},
{'id':319,'kabkot':'Banggai Kepulauan','prov':28},
{'id':320,'kabkot':'Banggai Laut','prov':28},
{'id':321,'kabkot':'Bombana','prov':29},
{'id':322,'kabkot':'Buton','prov':29},
{'id':323,'kabkot':'Buton Selatan','prov':29},
{'id':324,'kabkot':'Buton Tengah','prov':29},
{'id':325,'kabkot':'Buton Utara','prov':29},
{'id':326,'kabkot':'Donggala','prov':28},
{'id':327,'kabkot':'Kolaka','prov':29},
{'id':328,'kabkot':'Kolaka Timur','prov':29},
{'id':329,'kabkot':'Kolaka Utara','prov':29},
{'id':330,'kabkot':'Konawe','prov':29},
{'id':331,'kabkot':'Konawe Kepulauan','prov':29},
{'id':332,'kabkot':'Konawe Selatan','prov':29},
{'id':333,'kabkot':'Konawe Utara','prov':29},
{'id':334,'kabkot':'Kota Bau Bau','prov':29},
{'id':335,'kabkot':'Kota Kendari','prov':29},
{'id':336,'kabkot':'Kota Palu','prov':28},
{'id':337,'kabkot':'Morowali','prov':28},
{'id':338,'kabkot':'Morowali Utara','prov':28},
{'id':339,'kabkot':'Muna','prov':29},
{'id':340,'kabkot':'Muna Barat','prov':29},
{'id':341,'kabkot':'Parigi Moutong','prov':28},
{'id':342,'kabkot':'Poso','prov':28},
{'id':343,'kabkot':'Sigi','prov':28},
{'id':344,'kabkot':'Tojo Una-Una','prov':28},
{'id':345,'kabkot':'Toli Toli','prov':28},
{'id':346,'kabkot':'Wakatobi','prov':29},
{'id':347,'kabkot':'Boalemo','prov':6},
{'id':348,'kabkot':'Bolaang Mongondow','prov':30},
{'id':349,'kabkot':'Bolaang Mongondow Timur','prov':30},
{'id':350,'kabkot':'Bolaang Mongondow Utara','prov':30},
{'id':351,'kabkot':'Bolaangmongondow Selatan','prov':30},
{'id':352,'kabkot':'Bone Bolango','prov':6},
{'id':353,'kabkot':'Kepulauan Sangihe','prov':30},
{'id':354,'kabkot':'Kepulauan Talaud','prov':30},
{'id':355,'kabkot':'Kota Bitung','prov':30},
{'id':356,'kabkot':'Kota Gorontalo','prov':6},
{'id':357,'kabkot':'Kota Kotamobagu','prov':30},
{'id':358,'kabkot':'Kota Manado','prov':30},
{'id':359,'kabkot':'Kota Tomohon','prov':30},
{'id':360,'kabkot':'Minahasa','prov':30},
{'id':361,'kabkot':'Minahasa Selatan','prov':30},
{'id':362,'kabkot':'Minahasa Tenggara','prov':30},
{'id':363,'kabkot':'Minahasa Utara','prov':30},
{'id':364,'kabkot':'Gorontalo Utara','prov':6},
{'id':365,'kabkot':'Kepulauan Siau Tagulandang Biaro','prov':30},
{'id':366,'kabkot':'Buol','prov':28},
{'id':367,'kabkot':'Pahuwato','prov':6},
{'id':368,'kabkot':'Solok Selatan','prov':31},
{'id':369,'kabkot':'Pesisir Selatan','prov':31},
{'id':370,'kabkot':'Kepulauan Mentawai','prov':31},
{'id':371,'kabkot':'Dharmasraya','prov':31},
{'id':372,'kabkot':'Kota Solok','prov':31},
{'id':373,'kabkot':'Kota Sawahlunto','prov':31},
{'id':374,'kabkot':'Kota Pariaman','prov':31},
{'id':375,'kabkot':'Solok','prov':31},
{'id':376,'kabkot':'Kota Padang Panjang','prov':31},
{'id':377,'kabkot':'Sijunjung','prov':31},
{'id':378,'kabkot':'Tanah Datar','prov':31},
{'id':379,'kabkot':'Kota Bukittinggi','prov':31},
{'id':380,'kabkot':'Kota Payakumbuh','prov':31},
{'id':381,'kabkot':'Kuantan Singingi','prov':25},
{'id':382,'kabkot':'Indragiri Hulu','prov':25},
{'id':383,'kabkot':'Lima Puluh Koto','prov':31},
{'id':384,'kabkot':'Lingga','prov':17},
{'id':385,'kabkot':'Indragiri Hilir','prov':25},
{'id':386,'kabkot':'Pasaman Barat','prov':31},
{'id':387,'kabkot':'Pelalawan','prov':25},
{'id':388,'kabkot':'Kota Pekanbaru','prov':25},
{'id':389,'kabkot':'Pasaman','prov':31},
{'id':390,'kabkot':'Kampar','prov':25},
{'id':391,'kabkot':'Kota Tanjungpinang','prov':17},
{'id':392,'kabkot':'Karimun','prov':17},
{'id':393,'kabkot':'Kota Batam','prov':17},
{'id':394,'kabkot':'Bintan','prov':17},
{'id':395,'kabkot':'Siak','prov':25},
{'id':396,'kabkot':'Rokan Hulu','prov':25},
{'id':397,'kabkot':'Kepulauan Anambas','prov':17},
{'id':398,'kabkot':'Rokan Hilir','prov':25},
{'id':399,'kabkot':'Natuna','prov':17},
{'id':400,'kabkot':'Kepulauan Meranti','prov':25},
{'id':401,'kabkot':'Bengkalis','prov':25},
{'id':402,'kabkot':'Kota Dumai','prov':25},
{'id':403,'kabkot':'Area Dalam Pembahasan','prov':31},
{'id':404,'kabkot':'Area Dalam Pembahasan','prov':31},
{'id':405,'kabkot':'Kota Padang','prov':31},
{'id':406,'kabkot':'Padang Pariaman','prov':31},
{'id':407,'kabkot':'Area Dalam Pembahasan','prov':31},
{'id':408,'kabkot':'Kota Gunung Sitoli','prov':33},
{'id':409,'kabkot':'Nias Barat','prov':33},
{'id':410,'kabkot':'Nias','prov':33},
{'id':411,'kabkot':'Mandailing Natal','prov':33},
{'id':412,'kabkot':'Kota Padangsidimpuan','prov':33},
{'id':413,'kabkot':'Nias Utara','prov':33},
{'id':414,'kabkot':'Padang Lawas','prov':33},
{'id':415,'kabkot':'Kota Sibolga','prov':33},
{'id':416,'kabkot':'Padang Lawas Utara','prov':33},
{'id':417,'kabkot':'Tapanuli Selatan','prov':33},
{'id':418,'kabkot':'Labuhan Batu Selatan','prov':33},
{'id':419,'kabkot':'Tapanuli Tengah','prov':33},
{'id':420,'kabkot':'Tapanuli Utara','prov':33},
{'id':421,'kabkot':'Humbang Hasundutan','prov':33},
{'id':422,'kabkot':'Aceh Singkil','prov':0},
{'id':423,'kabkot':'Toba Samosir','prov':33},
{'id':424,'kabkot':'Labuhanbatu','prov':33},
{'id':425,'kabkot':'Pakpak Bharat','prov':33},
{'id':426,'kabkot':'Samosir','prov':33},
{'id':427,'kabkot':'Labuhanbatu Utara','prov':33},
{'id':428,'kabkot':'Simeulue','prov':0},
{'id':429,'kabkot':'Kota Subulussalam','prov':0},
{'id':430,'kabkot':'Kota Pematangsiantar','prov':33},
{'id':431,'kabkot':'Kota Tanjung Balai','prov':33},
{'id':432,'kabkot':'Dairi','prov':33},
{'id':433,'kabkot':'Asahan','prov':33},
{'id':434,'kabkot':'Simalungun','prov':33},
{'id':435,'kabkot':'Karo','prov':33},
{'id':436,'kabkot':'Kota Tebing Tinggi','prov':33},
{'id':437,'kabkot':'Batubara','prov':33},
{'id':438,'kabkot':'Kota Binjai','prov':33},
{'id':439,'kabkot':'Serdang Bedagai','prov':33},
{'id':440,'kabkot':'Aceh Selatan','prov':0},
{'id':441,'kabkot':'Aceh Tenggara','prov':0},
{'id':442,'kabkot':'Kota Medan','prov':33},
{'id':443,'kabkot':'Deliserdang','prov':33},
{'id':444,'kabkot':'Aceh Barat Daya','prov':0},
{'id':445,'kabkot':'Gayo Lues','prov':0},
{'id':446,'kabkot':'Langkat','prov':33},
{'id':447,'kabkot':'Aceh Tamiang','prov':0},
{'id':448,'kabkot':'Kota Langsa','prov':0},
{'id':449,'kabkot':'Naganraya','prov':0},
{'id':450,'kabkot':'Aceh Barat','prov':0},
{'id':451,'kabkot':'Aceh Tengah','prov':0},
{'id':452,'kabkot':'Bener Meriah','prov':0},
{'id':453,'kabkot':'Kota Lhokseumawe','prov':0},
{'id':454,'kabkot':'Aceh Jaya','prov':0},
{'id':455,'kabkot':'Aceh Timur','prov':0},
{'id':456,'kabkot':'Aceh Utara','prov':0},
{'id':457,'kabkot':'Bireuen','prov':0},
{'id':458,'kabkot':'Pidie Jaya','prov':0},
{'id':459,'kabkot':'Pidie','prov':0},
{'id':460,'kabkot':'Kota Banda Aceh','prov':0},
{'id':461,'kabkot':'Aceh Besar','prov':0},
{'id':462,'kabkot':'Kota Sabang','prov':0},
{'id':463,'kabkot':'Nias Selatan','prov':33},
{'id':464,'kabkot':'Nias Selatan','prov':33},
{'id':465,'kabkot':'Kota Bandarlampung','prov':18},
{'id':466,'kabkot':'Pringsewu','prov':18},
{'id':467,'kabkot':'Pesawaran','prov':18},
{'id':468,'kabkot':'Tanggamus','prov':18},
{'id':469,'kabkot':'Kota Metro','prov':18},
{'id':470,'kabkot':'Lampung Barat','prov':18},
{'id':471,'kabkot':'Pesisir Barat','prov':18},
{'id':472,'kabkot':'Lampung Utara','prov':18},
{'id':473,'kabkot':'Lampung Tengah','prov':18},
{'id':474,'kabkot':'Kaur','prov':3},
{'id':475,'kabkot':'Ogan Komering Ulu Selatan','prov':32},
{'id':476,'kabkot':'Way Kanan','prov':18},
{'id':477,'kabkot':'Bengkulu Selatan','prov':3},
{'id':478,'kabkot':'Tulang Bawang Barat','prov':18},
{'id':479,'kabkot':'Tulangbawang','prov':18},
{'id':480,'kabkot':'Kota Pagar Alam','prov':32},
{'id':481,'kabkot':'Seluma','prov':3},
{'id':482,'kabkot':'Ogan Komering Ulu','prov':32},
{'id':483,'kabkot':'Kota Bengkulu','prov':3},
{'id':484,'kabkot':'Mesuji','prov':18},
{'id':485,'kabkot':'Ogan Komering Ulu Timur','prov':32},
{'id':486,'kabkot':'Kepahiang','prov':3},
{'id':487,'kabkot':'Lahat','prov':32},
{'id':488,'kabkot':'Bengkulu Tengah','prov':3},
{'id':489,'kabkot':'Empat Lawang','prov':32},
{'id':490,'kabkot':'Kota Prabumulih','prov':32},
{'id':491,'kabkot':'Muara Enim','prov':32},
{'id':492,'kabkot':'Rejang Lebong','prov':3},
{'id':493,'kabkot':'Belitung','prov':16},
{'id':494,'kabkot':'Kota Lubuk Linggau','prov':32},
{'id':495,'kabkot':'Ogan Ilir','prov':32},
{'id':496,'kabkot':'Penukal Abab Lematang Ilir','prov':32},
{'id':497,'kabkot':'Kota Palembang','prov':32},
{'id':498,'kabkot':'Bangka Selatan','prov':16},
{'id':499,'kabkot':'Musi Rawas','prov':32},
{'id':500,'kabkot':'Bengkulu Utara','prov':3},
{'id':501,'kabkot':'Lebong','prov':3},
{'id':502,'kabkot':'Belitung Timur','prov':16},
{'id':503,'kabkot':'Ogan Komering Ilir','prov':32},
{'id':504,'kabkot':'Musi Rawas Utara','prov':32},
{'id':505,'kabkot':'Muko-Muko','prov':3},
{'id':506,'kabkot':'Bangka Tengah','prov':16},
{'id':507,'kabkot':'Kota Pangkalpinang','prov':16},
{'id':508,'kabkot':'Kota Sungai Penuh','prov':7},
{'id':509,'kabkot':'Sarolangun','prov':7},
{'id':510,'kabkot':'Musi Banyuasin','prov':32},
{'id':511,'kabkot':'Kerinci','prov':7},
{'id':512,'kabkot':'Merangin','prov':7},
{'id':513,'kabkot':'Banyuasin','prov':32},
{'id':514,'kabkot':'Kota Jambi','prov':7},
{'id':515,'kabkot':'Bangka Barat','prov':16},
{'id':516,'kabkot':'Bangka','prov':16},
{'id':517,'kabkot':'Batanghari','prov':7},
{'id':518,'kabkot':'Muaro Jambi','prov':7},
{'id':519,'kabkot':'Bungo','prov':7},
{'id':520,'kabkot':'Tanjung Jabung Timur','prov':7},
{'id':521,'kabkot':'Tebo','prov':7},
{'id':522,'kabkot':'Tanjung Jabung Barat','prov':7},
{'id':523,'kabkot':'Lampung Selatan','prov':18},
{'id':524,'kabkot':'Lampung Timur','prov':18},
{'id':525,'kabkot':'Agam','prov':31},
{'id':526,'kabkot':'Gorontalo','prov':6},
{'id':527,'kabkot':'Malaka','prov':22}
  
 ]

 var serverSimpulArray = [
	  { id: 0, name: 'ArcGIS Server'},
	  { id: 1, name: 'WMS OGC'}
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
		
function openResult(name){
	alert(name);
	$('#resultView').toggle();
	intersect_test()
	//$("#"+name).show();
}
  
require([
     "esri/Basemap",
     "esri/core/watchUtils",
     "esri/identity/IdentityManager",
     "esri/identity/ServerInfo",
     "esri/geometry/geometryEngine",
     "esri/geometry/Point",
     "esri/geometry/Polyline",
     "esri/geometry/Polygon",
     "esri/geometry/support/webMercatorUtils",
     "esri/geometry/SpatialReference",
     "esri/Graphic",
     "esri/layers/FeatureLayer",
	 "esri/layers/GraphicsLayer",
     "esri/layers/MapImageLayer",
     "esri/layers/TileLayer",
     "esri/layers/WMSLayer",
     "esri/Map",
     "esri/request",
     "esri/symbols/SimpleMarkerSymbol",
     "esri/symbols/SimpleLineSymbol",
     "esri/symbols/SimpleFillSymbol",     
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
	 "esri/widgets/Sketch/SketchViewModel",
     "esri/widgets/Zoom",
     "esri/config",
	 "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js",
	 "esri/layers/support/Field",
     
    ],function(
    	Basemap,
    	watchUtils,
    	identityManager,
    	ServerInfo,
    	geometryEngine,
    	Point,
    	Polyline,
    	Polygon,
    	webMercatorUtils,
    	SpatialReference,
    	Graphic,
    	FeatureLayer,
    	GraphicsLayer,
    	MapImageLayer,
    	TileLayer, 
    	WMSLayer,
     	Map,
    	esriRequest,
    	SimpleMarkerSymbol,
    	SimpleLineSymbol,
    	SimpleFillSymbol,
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
		SketchViewModel,
	 	Zoom,
	 	esriConfig,
		Chart,
		Field
	 	){

	//esriConfig.request.proxyUrl = prox;
	function intersect_test(){
		alert('intersect');
	}
	function setup_css(){
		$("style").append('html, body, #viewDiv{padding: 0;margin: 0;height: 100%;width: 100%;overflow: hidden;}');
		//$("style").append('body{background-image: url("assets/images/logo_background.png");}');
		$("style").append('body{background-color:#fff}');
		$("style").append('#topLoader,#basemap,#simpul,#search,#help, #layerList,#menu_user,#user,#mainMenu,#bottomMenu,#extraMenu,#extraBottomMenu,#tools,#legend,#queryView,#downloadView, #metadataView,#atributView, #resultView{z-index:99;position:absolute;}');
		$("style").append('#basemap{width:300px;top:200px;right:80px;border:solid 1px #343a40}');
		$("style").append('#simpul{width:300px;top:200px;right:80px;border:solid 1px #343a40}');
		$("style").append('#search{width:300px;top:200px;right:80px;border:solid 1px #343a40}');
		$("style").append('#help{width:940px;top:5%;left:15%;border:solid 1px #343a40}');
		$("style").append('#layerList{width:500px;top:200px;right:80px;border:solid 1px #343a40}');
		$("style").append('#legend{width:300px;top:300px;right:80px;border:solid 1px #343a40}');
		//$("style").append('#queryView{width:500px;top:200px;right:80px;border:solid 1px #343a40}');
		//$("style").append('#downloadView{width:300px;top:100px;right:80px;border:solid 1px #343a40}');
		//$("style").append('#metadataView{width:500px;top:200px;right:80px;border:solid 1px #343a40}');
		//$("style").append('#atributView{width:700px;top:300px;right:80px;border:solid 1px #343a40}');
		$("style").append('#resultView{width:500px;top:10px;right:80px;border:solid 1px #343a40}');
		
		$("style").append('.over{max-height:600px;overflow-y:auto;overflow-x:hidden}');
		$("style").append('#metadataContent, #atributContent, #downloadContent, #queryContent, #legendContent,#layerListContent{max-height:500px;overflow-y:auto;overflow-x:hidden}');
		$("style").append('#tools{width:500px;top:400px;right:80px;border:solid 1px #343a40}');
		$("style").append('#user{width:250px;top:15px;right:80px;}');
		$("style").append('#extraMenu{height: 400px;background-color: rgba(255, 255, 255,1)}');
		$("style").append('#mainMenu{height: 400px;}');
		$("style").append('#extraBottomMenu{height: 95%;background-color: rgba(255, 255, 255,1)}');
		$("style").append('#bottomMenu{width:100%;height:48px;}');
		$("style").append('#mainMenu{left: 10px;top: 10px;}');
		$("style").append('#bottomMenu{bottom: 30px;}');
		$("style").append('#mainMenu{width:48px;}');
		$("style").append('#logo{display:block;height:50px;padding-bottom:10px}');
		$("style").append('#ksp{position: relative;padding-top:25px; padding-left:5px;}');
		$("style").append('.menu{height: 48px;}');
		$("style").append('#extraMenu{left: 65px;top: 85px;width: 320px;}');
		$("style").append('#extraBottomMenu{right: 70px;top: 15px;width: 320px;}');
		$("style").append('#tool{width:450px;}');
		$("style").append('#tool{position:relative;left:35%; padding-top:8px}');
		$("style").append('#menu_user{top: 15px;right: 15px;width: 52px;height:52px;background-color:rgba(255,255,255,1);}');
		$("style").append('#service{max-height:400px;overflow-y:auto;overflow-x:hidden;}');
		$("style").append('.card{border-radius: 0;border-style: none;}');
		$("style").append('.card-body{padding:0px;}');
		$("style").append('.custom-control-label {margin-left:10px}');
		$("style").append('.font-small{font-size: small;}');
		
		$("style").append('.close-icon,#logo,.menu,#menu_user,.headerExtraMenu,#switchIdentify,.custom-control-label,.menu_dropdown, .dataTable {cursor: pointer;}');
		$("style").append('.card-header{cursor:move;}');

		$("style").append('.card-header:first-child{border-radius:0;}');
		$("style").append('#basemap,#simpul,#search,#help, #layerList, #user, #extraMenu, #extraBottomMenu, .extraMenuContent, #tools,#legend, #queryView, #downloadView, #metadataView, #atributView, #resultView{display:none;}');
		$("style").append('div.esri-component.esri-scale-bar.esri-widget{padding-left:100px;}');
		//$("style").append('div.esri-ui-top-right.esri-ui-corner{padding-top:60px;padding-right: 10px;}');
		$("style").append('div.esri-component.esri-popup.esri-popup--is-docked.esri-popup--is-docked-top-right{padding-right:70px}');
		$("style").append('.activeMeasurement {background: #0079c1;color: #e4e4e4;}');
		$("style").append('.activeAnalysis {background: #0079c1;color: #e4e4e4;}');
		$("style").append('#tableWrapper{font-size: small;max-width: 700px;max-height:600px;overflow: auto;}');
		setup_component();
  	}

	function setup_component(){
		$("body").append('<div id="topLoader" class="d-flex justify-content-center align-items-center h-100 w-100"><img id="loadingImg" src="assets/images/loading.gif" /></div>');
		$("body").append('<div id="viewDiv"></div>');
		$("body").append('<div id="mainMenu"></div>');
		$("body").append('<div id="bottomMenu"></div>');
		$("body").append('<div id="extraMenu" class="border border-secondary"></div>');
		$("body").append('<div id="extraBottomMenu" class="border border-secondary"></div>');
		$("body").append(create_card('basemap', 'Basemap'));
		$("body").append(create_card('layerList', 'Layer Management'));
		$("body").append(create_card('legend', 'Legend'));
		$("body").append(create_card('tools', 'Analysis'));
		$("body").append(create_card('simpul', 'Nodes'));
		$("body").append(create_card('search', 'Search'));
		$("body").append(create_card('help', 'About'));
		//$("body").append(create_card('queryView', 'Query'));
		//$("body").append(create_card('downloadView', 'Status Download'));
		//$("body").append(create_card('metadataView', 'Download'));
		//$("body").append(create_card('atributView', 'Atribut Layer'));
		$("body").append(create_card('resultView', 'Analysis Result'));
		
		
		$("#basemap").find('.card-body').append('<div id="basemapContent" class="bg-white"></div>');
		$("#simpul").find('.card-body').append('<div id="simpulContent" class="bg-white"></div>');
		$("#search").find('.card-body').append('<div id="searchContent" class="bg-white"></div>');
		$("#help").find('.card-body').append('<div id="helpContent" class="bg-white"></div>');
		$("#layerList").find('.card-body').append('<div id="layerListContent" class="bg-white"></div>');
		$("#legend").find('.card-body').append('<div id="legendContent" class="bg-white"></div>');	
		//$("#queryView").find('.card-body').append('<div id="queryContent" class="bg-white"></div><div id="queryWrapper"></div>');
		//$("#downloadView").find('.card-body').append('<div id="downloadContent" class="bg-white"></div>');	
		//$("#metadataView").find('.card-body').append('<div id="metadataContent" class="bg-white"></div>');
		//$("#atributView").find('.card-body').append('<div id="atributContent" class="bg-white"></div><div id="tableWrapper"></div>');
		$("#resultView").find('.card-body').append('<div id="resultContent" class="bg-white"></div>');
		$("#tools").find('.card-body').append('<ul class="nav nav-tabs" id="myTab" role="tablist">'
				 
				  + '<li class="nav-item">'
				  + '  <a class="nav-link active" id="analysis-tab" data-toggle="tab" href="#analysis" role="tab" aria-controls="analysis" aria-selected="false">Analysis</a>'
				  + '</li>'
				   + '<li class="nav-item">'
				  + '  <a class="nav-link " id="measurement-tab" data-toggle="tab" href="#measurement" role="tab" aria-controls="measurement" aria-selected="true">Measurements</a>'
				  + '</li>'
				 // + '<li class="nav-item">'
				 // + '  <a class="nav-link" id="identify-tab" data-toggle="tab" href="#identify" role="tab" aria-controls="identify" aria-selected="false">Identify</a>'
				 // + '</li>'
				  + '</ul>'
				  + '<div class="tab-content" id="myTabContent">'
				  + '<div class="tab-pane fade show active" id="analysis" role="tabpanel" aria-labelledby="analyisis-tab"><div id="analysisContent" class="p-3"></div></div>'
				  + '<div class="tab-pane fade" id="measurement" role="tabpanel" aria-labelledby="measurement-tab">'
				  + '<div class="row p-3">'
				  + '<div class="col-sm"><button id="distanceButton" type="button" title="Measure Distance" class="btn btn-outline-primary btn-sm btn-block">Distance</button></div>'
				  + '<div class="col-sm"><button id="areaButton" type="button" title="Measure Area" class="btn btn-outline-primary btn-sm btn-block">Area</button></div>'
				  + '<div class="col-sm"><button id="clearMeasurement" type="button" title="Clear Measurement" class="btn btn-outline-primary btn-sm btn-block">Clear</button></div>'
			      + '</div><div id="measurementContent"></div></div>'
				
				//  + '<div class="tab-pane fade" id="identify" role="tabpanel" aria-labelledby="identify-tab"><div id="identifyContent" class="p-3"></div></div>'
				  + '</div>');
		
		$("#analysisContent").append('<div class="row p-3">'
		  + '<div class="col-sm"><button id="drawingButton" type="button" title="Query By Drawing" class="btn btn-outline-primary btn-sm btn-block">By Drawing</button></div>'
		  + '<div class="col-sm"><button id="boundaryButton" type="button" title="Query By Adm Boundary" class="btn btn-outline-primary btn-sm btn-block">By Boundary</button></div>'
		  + '<div class="col-sm"><button id="shapeButton" type="button" title="Query By Shape File" class="btn btn-outline-primary btn-sm btn-block">By Shape File</button></div>'
	      + '</div><div id="drawingTask" class="contentAnalysis"></div><div id="boundaryTask" class="contentAnalysis"></div><div id="shapeTask" class="contentAnalysis"></div>');
		
  	    $("#drawingTask").append("<div id='drawingContent'><div id='drawingStatus'></div><div id='drawingTool'></div></div>");
  	    $("#boundaryTask").append("<div id='boundaryContent'><div id='boundaryStatus'></div><div id='boundaryTool'></div></div>");      
  	    $("#shapeTask").append("<div id='shapeContent'><div id='shapeStatus'></div><div id='shapeTool'></div></div>");      
		$("#drawingStatus").html('<p class="p-3">Tidak ada layer aktif. Silahkan tambahkan layer ke peta.</p>');
		$("#drawingTool").hide();
		$("#boundaryStatus").html('<p class="p-3">Tidak ada layer aktif. Silahkan tambahkan layer ke peta.</p>');
		$("#boundaryTool").hide();
		$("#shapeStatus").html('<p class="p-3">Tidak ada layer aktif. Silahkan tambahkan layer ke peta.</p>');
		$("#shapeTool").hide();
        openAnalysis('drawing');   	
  	    closeDrawingContent();
  	    closeBoundaryContent();
		$("#drawingTool").html('<p class="p-3">Draw in the map the area you want to analyze</p>'+
		'<div class="col-md-12 pt-1">'+
							'<div class="custom-control custom-switch">'+
							  '<input type="checkbox" class="custom-control-input" id="switchDrawing">'+
							  '<label class="custom-control-label unselectable" for="switchDrawing">Start Drawing?</label>'+
							  '<label id="statusDrawing" class="font-weight-bold small pl-1">Drawing is not active</label>'+
							 '</div>'+
				 '</div>'
			);
			
			$('#switchDrawing').on('click',function() {
				console.log($(this).is(":checked"));

			  //console.log(map.layers.items.length);
			  
				draw_flag =  $(this).is(":checked");
				clearUpSelection();
				if(draw_flag){
					$('#statusDrawing').text("Drawing is active");
					$('#statusDrawing').addClass( "text-success" );
					// create a new sketch view model set its layer
					sketchViewModel.create("polygon");
					$('#resultContent').html('');
				}else{
					$('#statusDrawing').text("Drawing is not active");
					$('#statusDrawing').removeClass( "text-success" );
					sketchViewModel.cancel();
				}
				
		  });  
		  
			
			$('<div />', { id: 'formProvinsi', "class":'form-group'}).appendTo('#boundaryTool');
			$('<label />', { "for": 'tipeBatas' }).text("Regional Boundary Category").appendTo('#formProvinsi');
			$('<select />',{id: 'tipeBatas', "class":'form-control'}).appendTo('#formProvinsi');
			$('#tipeBatas').append('<option disabled selected="selected">Select Regional Boundary Category</option>');
		
			tipeBatasArray.forEach(function(obj) {
					$('#tipeBatas').append('<option value="'+obj.id+'">'+obj.name+'</option>');
			});
			
			$('<div />', { id: 'optionList'}).appendTo('#boundaryTool');
			
    	$('#tipeBatas').on('change', function() {
    		  idx = this.value;
			  $('#optionList').html('');
					$('<div />', { id: 'listProvinsi', "class":'form-group'}).appendTo('#optionList');
					$('<label />', { "for": 'daftarProvinsi' }).text("List of Province").appendTo('#listProvinsi');
					$('<select />',{id: 'daftarProvinsi', "class":'form-control'}).appendTo('#listProvinsi');
					$('#daftarProvinsi').empty();
					$('#daftarProvinsi').append('<option disabled selected="selected">Select Province</option>');

					listProvinsiArray.forEach(function(o) {
						$('#daftarProvinsi').append('<option value="'+o.id+'">'+o.prov+'</option>');
					});

			  if(idx == 1){
					$('<div />', { id: 'listKabKot', "class":'form-group'}).appendTo('#optionList');
					$('<label />', { "for": 'daftarKabKot' }).text("List of Regency/City").appendTo('#listKabKot');
					$('<select />',{id: 'daftarKabKot', "class":'form-control'}).appendTo('#listKabKot');
					$('#daftarKabKot').empty();
					$('#daftarKabKot').append('<option disabled selected="selected">Select Regency/City</option>');
					$('#daftarProvinsi').on('change', function() {
							id = this.value;
							var obj = $.grep(listKabKot, function(n){return n.prov == id;});
							
							$('#daftarKabKot').empty();
							$('#daftarKabKot').append('<option disabled selected="selected">Select Regency/City</option>');

							obj.forEach(function(o) {
									$('#daftarKabKot').append('<option value="'+o.id+'">'+o.kabkot+'</option>');
							});
					});
					
			  }
			  $('<input type="button" value="Process" class="btn btn-sm btn-primary form-control" id="processBoundary" />').appendTo('#optionList');
			  $('#processBoundary').click(function(){
				 //alert(idx);
				  view.graphics.removeAll();
				 if(idx == 0){
					 //provinsi
					select_prov = $('#daftarProvinsi').val();//.text()
					console.log($('#daftarProvinsi option:selected').text());
					if(select_prov != null){
						//alert('Execute provinsi');
						
						
						boundaryUrl = 'http://portal.ina-sdi.or.id/gis/rest/services/PPIG/Bts_Administrasi/MapServer/0';
						boundaryLyr = new FeatureLayer(boundaryUrl , {
							opacity: 0
						});
						prov = $('#daftarProvinsi option:selected').text();//.split(' ').join('');
						var query1 = boundaryLyr.createQuery();
						query1.where = "prov='"+ prov+ "'"; 
						query1.returnGeometry = true;				
						query1.returnCountOnly = false;
						query1.outFields = [ "prov" ];
						//query1.geometry = geom;
					
						$('#resultView').show();
						$('#resultContent').html('');
					    boundaryLyr.queryFeatures(query1).then(function(results){
									geom = results.features[0].geometry;
									calculateAnalysis(geom, 'Provinsi: ' + prov);
						});
						
				   
					}else{
						alert('Please choose Provinsi')
					}
				 }else{
					select_kab = $('#daftarKabKot').val();
					if(select_kab != null){
							boundaryUrl = 'http://portal.ina-sdi.or.id/gis/rest/services/PPIG/Bts_Administrasi/MapServer/1';
						boundaryLyr = new FeatureLayer(boundaryUrl , {
							opacity: 0
						});
						prov = $('#daftarKabKot option:selected').text();//.split(' ').join('');
						var query1 = boundaryLyr.createQuery();
						query1.where = "rtrwk='"+ prov+ "'"; 
						query1.returnGeometry = true;				
						query1.returnCountOnly = false;
						query1.outFields = [ "rtrwk" ];
						//query1.geometry = geom;
					
					$('#resultView').show();
					$('#resultContent').html('');
					boundaryLyr.queryFeatures(query1).then(function(results){
							geom = results.features[0].geometry;
							calculateAnalysis(geom, 'Kabupaten: ' + prov);
				    });
				   
					}else{
						alert('Please Select Regency/City')
					}
				 }
			  });
        });
		
		
		$("#shapeTool").html('<p>Add a zipped shapefile to the map.</p>' +
			'<p>'+
            'Download a sample of shapefile '+
            '<a href="assets/shape/ForestTest.zip">here.</a>'+
          '</p>'+
          '<form enctype="multipart/form-data" method="post" id="uploadForm">' +
          '  <div class="field">' +
          '    <label class="file-upload">' +
          '      <span><strong>Add File</strong></span>' +
          '      <input type="file" name="file" id="inFile" />' +
          '    </label>' +
          '  </div>' +
          '</form>' +
          '<span class="file-upload-status" style="opacity:1;" id="upload-status"></span>' +
          '<div id="fileInfo"></div>');
    
	
		//$("#identifyContent").append('<div class="custom-control custom-switch">'
		//		  +'<input type="checkbox" class="custom-control-input" id="switchIdentify">'
		//		  +'<label class="custom-control-label unselectable" for="switchIdentify">Identify Layer KSP on Map?</label>'
		//		  +'</div>');
		//$("#identifyContent").append('<div id="switchIdentifyMessage" class="p-2"></div>');
		$("#mainMenu").append('<div id="logo"></div>');
		//$("#mainMenu").append('<div id="logo" class="d-flex justify-content-center pt-2 bg-darkblue"></div>');
		$("#mainMenu").append('<div id="ksp"></div>');
	  	$("#bottomMenu").append('<div id="tool"></div>');
	  	$("#logo").append('<img src="assets/images/logo ecosystem.png" width="155px"  title="Land Cover Change Monitoring System">');
	  	$("#extraMenu").append("<button type='button' id='closeX' class='mr-3 mt-1 close tutup text-light' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <button type='button' class='mr-1 mt-1 close mon text-light' aria-label='Minus'><span aria-hidden='true'> - </span></button>");
	  	$("#extraBottomMenu").append("<button type='button' id='closeXB' class='mr-3 mt-2 close tutupB text-light' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <button type='button' class='mr-1 mt-2 close monB text-light' aria-label='Minus'><span aria-hidden='true'> - </span></button>");
	  	//var obj = $.grep(listSimpulArray, function(n){return n.tipe == 1;});
	  	servicesArray.forEach(function(obj) {
	  		$("#ksp").append('<div class="menu text-center align-items-center unselectable" id="ksp-'+obj.id+'"></div>');
		    $("#ksp-"+obj.id).append('<img src="assets/thumbnail/'+obj.logo+'" width="46px" height="46px" title="'+obj.name+'">');
		    $("#ksp-"+obj.id).on('click', function() {
	 			//fillMainMenu('ksp',obj.id);
		    	openMainMenu(obj.id, "ksp");
	 		});
		    $("#extraMenu").append("<div class='extraMenuContent bg-white' id='ksp-content-"+obj.id+"'></div>"); 
		    $("#ksp-content-"+obj.id).append("<div class='headerExtraMenu bg-darkblue pt-1 pb-1 pl-3 unselectable'><p class='mb-1 text-light font-weight-bold'>"+obj.name+"</p></div>");
			$("#ksp-content-"+obj.id).append("<div id='ksp-content2-"+ obj.id +"' style='max-height:550px;overflow-y:scroll; scrollbar-width: thin;'></div>");
		});
		
	  	toolsArray.forEach(function(obj) {
		    //console.log(obj);
		    $("#tool").append('<div class="d-inline menu text-center align-items-center p-2 unselectable" id="tool-'+obj.id+'"></div>');
		    $("#tool-"+obj.id).append('<img src="assets/images/'+obj.logo+'" width="47px" height="47px" title="'+obj.name+'">');
		    $("#tool-"+obj.id).on('click', function() {
	    		//fillMainMenu('tool',obj.id);
	    		openBottomMenu(obj.id,"tool");
	    		//openMainMenu(obj.id,"tool");
	   		});

		    $("#extraBottomMenu").append("<div class='extraMenuBottomContent' id='tool-content-"+obj.id+"'></div>");   		    
		    $("#tool-content-"+obj.id).append("<div class='headerExtraBottomMenu bg-darkblue p-3 unselectable'><p class='mb-1 text-light font-weight-bold'>"+obj.name+"</p></div>");
		});
		
		populateExtraMenuKSP();
	  	populateExtraMenuTools();

	  	setup_action();
  	    console.log("setup completed");
  		console.log("app ready!");
	}
	
    function closeDrawingContent(){
        $("#drawingStatus").show();
		$("#drawingTool").hide();
		clearUpSelection();
    }

    function closeBoundaryContent(){
		$("#boundaryStatus").show();
		$("#boundaryTool").hide();
		clearUpSelection();
    }
	
	function closeShapeContent(){
		$("#shapeStatus").show();
		$("#shapeTool").hide();
		clearUpSelection();
    }
  	
	 function generateFeatureCollection(fileName) {
          var name = fileName.split(".");
          // Chrome and IE add c:\fakepath to the value - we need to remove it
          // see this link for more info: http://davidwalsh.name/fakepath
          name = name[0].replace("c:\\fakepath\\", "");

          document.getElementById("upload-status").innerHTML =
            "<b>Loading </b>" + name;

          // define the input params for generate see the rest doc for details
          // https://developers.arcgis.com/rest/users-groups-and-items/generate.htm
          var params = {
            name: name,
            targetSR: view.spatialReference,
            maxRecordCount: 1,
            enforceInputFileSizeLimit: true,
            enforceOutputJsonSizeLimit: true
          };

          // generalize features to 10 meters for better performance
          params.generalize = true;
          params.maxAllowableOffset = 10;
          params.reducePrecision = true;
          params.numberOfDigitsAfterDecimal = 0;

          var myContent = {
            filetype: "shapefile",
            publishParameters: JSON.stringify(params),
            f: "json"
          };

          // use the REST generate operation to generate a feature collection from the zipped shapefile
          esriRequest(portalUrl + "/sharing/rest/content/features/generate", {
            query: myContent,
            body: document.getElementById("uploadForm"),
            responseType: "json"
          })
            .then(function(response) {
              var layerName =
                response.data.featureCollection.layers[0].layerDefinition.name;
              document.getElementById("upload-status").innerHTML =
                "<b>Loaded: </b>" + layerName;
              addShapefileToMap(response.data.featureCollection, name);
            })
            .catch(errorHandlerShape);
        }

        function errorHandlerShape(error) {
          document.getElementById("upload-status").innerHTML =
            "<p style='color:red;max-width: 500px;'>" + error.message + "</p>";
        }

        function addShapefileToMap(featureCollection, name) {
			//console.log(featureCollection);
          // add the shapefile to the map and zoom to the feature collection extent
          // if you want to persist the feature collection when you reload browser, you could store the
          // collection in local storage by serializing the layer using featureLayer.toJson()
          // see the 'Feature Collection in Local Storage' sample for an example of how to work with local storage
          var sourceGraphics = [];

          var layers = featureCollection.layers.map(function(layer) {
			//console.log(layer);
            var graphics = layer.featureSet.features.map(function(feature) {
              return Graphic.fromJSON(feature);
            });
			//console.log(graphics);
            sourceGraphics = sourceGraphics.concat(graphics);
           /* var featureLayer = new FeatureLayer({
			  title: name,
              objectIdField: "FID",
              source: graphics,
			  listMode:'hide',
              fields: layer.layerDefinition.fields.map(function(field) {
                return Field.fromJSON(field);
              })
            });
            return featureLayer;
			*/
            // associate the feature with the popup on click to enable highlight and zoom to
          });
          //map.addMany(layers);
          //view.goTo(sourceGraphics);
		  console.log(sourceGraphics[0].geometry);
		  calculateAnalysis(sourceGraphics[0].geometry, '');
          document.getElementById("upload-status").innerHTML = "";
        }

	function setup_variable(){

		$.ajax({
 	        type: "get",
 	        url: urlListKSP,
 	        dataType: "json",
 	        timeout: 5000,
 	        success: function(data) {
 	        	data.forEach(function(o){
 	        		servicesArray.push(o);
 	        	}); 
				setup_jign();
 	        },
 	        error: function(xhr, status) {
	        	console.log(status);
	        }
		});
	}

	function setup_jign(){

		$.ajax({
 	        type: "get",
 	        url: urlListJIGN,
 	        dataType: "json",
 	        timeout: 5000,
 	        success: function(data) {
 	        	data.forEach(function(o){
 	        		listSimpulArray.push(o);
 	        	}); 
 	        	setup_css();
 	        },
 	        error: function(xhr, status) {
	        	console.log(status);
	        }
		});
	}


    function generate_content_ksp(k, obj, o, url, j, id){
    	var menu = '<button type="button" class="btn btn-sm btn-dark float-right "  id="dropdownMenuLink'+k+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">&equiv;</button>'+
      	'<div class="dropdown-menu" aria-labelledby="dropdownMenuLink'+k+'">'+
        	'<a class="dropdown-item menu_dropdown" id="download_'+k+'" >Download </a>'+
            //'<a class="dropdown-item menu_dropdown" onclick="alert(\'download per wilayah\')">Download Per Wilayah</a>'+
            //'<a class="dropdown-item menu_dropdown" id="metadata_'+k+'" >Metadata</a>'+
            '<a class="dropdown-item menu_dropdown" id="atribut_'+k+'" >Atribut Tabel</a>'+
            '<a class="dropdown-item menu_dropdown" id="query_'+k+'" >Query</a>'+
          '</div>';
          	$('#container-ksp-content-'+ obj.id).append('<div class="row pl-3 border"><div class="custom-control custom-switch py-2 col-md-8"> <input type="checkbox" class="custom-control-input pl-2" id="ksp_'+k+'_'+id+'"> <label class="custom-control-label unselectable" for="ksp_'+k+'_'+id+'">'+o.name.split('_').join(' ')+'</label></div><div class="col-md-3 p-2">'+ menu +'</div></div>');
    
   	 
    
    
    }
    function populateExtraMenuKSP(){
		var k = 0;
		servicesArray.forEach(function(obj) {
		if(obj.subheader == true){
				var headers = $.grep(subHeaderArray, function(n){return n.services == obj.id;});
				//console.log(headers);
				z = 0;
				headers.forEach(function(o) {
					$('#ksp-content2-'+obj.id).append('<p class="pl-3 pt-2">'+ o.name + '</p>');
					$('<div />', { id: 'container-ksp-content-header-'+z,"class":'bg-light over'}).appendTo('#ksp-content2-'+obj.id);
					//$('#container-ksp-content-'+ obj.id).append('<div class="py-2 border unselectable bg-secondary" style="padding-left:45px; //cursor:pointer">'+o.name+'</div>');
					var services = $.grep(subHeaderServicesArray, function(n){return n.header == o.id;});
					
					services.forEach(function(m) {
						var menu = '<div id="info_'+m.id+'" class="esri-widget esri-widget--button toggle-button"><img src="assets/images/info.png" width="15px" height="15px"></div>';
						$('#container-ksp-content-header-'+ z).append('<div class="row pl-3 border"><div class="custom-control custom-switch py-2 col-md-9"> <input type="checkbox" class="custom-control-input pl-2" id="ksp_'+m.id+'"> <label class="custom-control-label unselectable" for="ksp_'+m.id+'">'+m.name+'</label></div><div class="col-md-1 p-2">'+ menu +'</div></div>');
						
						if (m.komoditi != ''){
						komoditi = '<tr>'+
							  '<td>Commodity</td>'+
							  '<td>'+m.komoditi+'</td>'+
							'</tr>'
					}else{
						komoditi = '';
					}
					
						$('body').append('<div class="modal fade" id="modal_'+m.id+'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">'+
						'<div class="modal-dialog modal-lg" role="document"><div class="modal-content">'+
						  '<div class="modal-header">'+
							'<h5 class="modal-title" id="exampleModalLongTitle">'+ o.name + ' - ' + m.name + '</h5>'+
							'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
							  '<span aria-hidden="true">&times;</span>'+
							'</button>'+
						  '</div>'+
						  '<div class="modal-body">'+
							'<table class="table table-striped">'+
							'  <tbody>'+
							komoditi +
							'<tr>'+
							  '<td width="30%">Service / Data Name</td>'+
							  '<td>'+m.name+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Data Definition</td>'+
							  '<td>'+m.definisi+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Resolution</td>'+
							  '<td>'+m.resolusi+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Geographical Coverage</td>'+
							  '<td>'+m.cakupan+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Data Source</td>'+
							  '<td>'+m.sumber+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Date of Content</td>'+
							  '<td>'+m.tahun+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Frequency of updates</td>'+
							  '<td>'+m.frekuensi+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Limitations (accuracy, data collection method, etc.)</td>'+
							  '<td>'+m.keterbatasan+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>License</td>'+
							  '<td>'+m.lisensi+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Citation</td>'+
							  '<td>'+m.sitasi+'</td>'+
							'</tr>'+
							'</tbody>'+
							'</table>'+
						  '</div>'+
						  '<div class="modal-footer">'+
							//'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
							//'<button type="button" class="btn btn-primary">Save changes</button>'+
						  '</div>'+
						'</div>'+
					  '</div>'+
					'</div>');
										$("#info_"+m.id).on('click',function() {
											//alert(m.name);
											$("#modal_"+m.id).modal('toggle');
										});
						                            		
                            			 $("#ksp_"+m.id).on('click',function() {
                            				 //console.log($(this).is(":checked"));
                            				  if($(this).is(":checked")){
												  if (m.tipe == 0){
													addLayerArcGISTiledSublayer("ksp_"+m.id, m.service, m.name + " -" + obj.name);
												  }else if (m.tipe == 2){
													addLayerWebTileLayer("ksp_"+m.id, m.service, m.name + " -" + obj.name);
												  }else{
													  if(m.sub == ""){
														addLayerArcGISMenu("ksp_"+m.id, m.service, m.name + " -" + obj.name);
													  }else{
														addLayerArcGISSublayer ("ksp_"+m.id, m.service, m.name + " -" + obj.name, {id:m.sub, title: obj.name});
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
							if(m.sub === ''){
								console.log(m);
								console.log('animasi');
									$('#container-ksp-content-header-'+ z).append('<div id="animasi" class="row pl-3 border"></div>');
									$('#animasi').append('<div id="playButton" class="esri-widget esri-widget--button toggle-button"><div><span class="toggle-button-icon esri-icon-play" aria-label="play icon"></span>Play</div>');
									
        //0 == root, 1 == sublayers
			/* 
          <div>
            <span
              class="toggle-button-icon esri-icon-pause"
              aria-label="pause icon"
            ></span>
            Pause
          </div>
        </div>
		*/
							}
										 k++;
					});
					z++;
				});
				//$('<div />', { id: 'container-ksp-content-'+obj.id,"class":'bg-light over'}).appendTo('#ksp-content-'+obj.id);
			}else{
				$('<div />', { id: 'container-ksp-content-'+obj.id,"class":'bg-light over'}).appendTo('#ksp-content-'+obj.id);
				var services = $.grep(subServicesArray, function(n){return n.services == obj.id;});
				services.forEach(function(o) {
					var menu = '<div id="info_'+o.id+'" class="esri-widget esri-widget--button toggle-button"><img src="assets/images/info.png" width="15px" height="15px"></div>';
					$('#container-ksp-content-'+ obj.id).append('<div class="row pl-3 border"><div class="custom-control custom-switch py-2 col-md-9"> <input type="checkbox" class="custom-control-input pl-2" id="ksp_'+o.id+'"> <label class="custom-control-label unselectable" for="ksp_'+o.id+'">'+o.name+'</label></div><div class="col-md-1 p-2">'+ menu +'</div></div>');
					if (o.komoditi != ''){
						komoditi = '<tr>'+
							  '<td>Commodity</td>'+
							  '<td>'+o.komoditi+'</td>'+
							'</tr>'
					}else{
						komoditi = '';
					}
					$('body').append('<div class="modal fade" id="modal_'+o.id+'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">'+
						'<div class="modal-dialog modal-lg" role="document"><div class="modal-content">'+
						  '<div class="modal-header">'+
							'<h5 class="modal-title" id="exampleModalLongTitle">'+ obj.name + ' - ' + o.name + '</h5>'+
							'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
							  '<span aria-hidden="true">&times;</span>'+
							'</button>'+
						  '</div>'+
						  '<div class="modal-body">'+
							'<table class="table table-striped">'+
							'  <tbody>'+
							komoditi +
							'<tr>'+
							  '<td width="30%">Service / Data Name</td>'+
							  '<td>'+o.name+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Data Definition</td>'+
							  '<td>'+o.definisi+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Resolution</td>'+
							  '<td>'+o.resolusi+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Geographical Coverage</td>'+
							  '<td>'+o.cakupan+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Data Source</td>'+
							  '<td>'+o.sumber+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Date Of Content</td>'+
							  '<td>'+o.tahun+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Frequency of updates</td>'+
							  '<td>'+o.frekuensi+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Limitations (accuracy, data collection method, etc.)</td>'+
							  '<td>'+o.keterbatasan+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>License</td>'+
							  '<td>'+o.lisensi+'</td>'+
							'</tr>'+
							'<tr>'+
							  '<td>Citation</td>'+
							  '<td>'+o.sitasi+'</td>'+
							'</tr>'+
							'</tbody>'+
							'</table>'+
						  '</div>'+
						  '<div class="modal-footer">'+
							//'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
							//'<button type="button" class="btn btn-primary">Save changes</button>'+
						  '</div>'+
						'</div>'+
					  '</div>'+
					'</div>');
										$("#info_"+o.id).on('click',function() {
											//alert(m.name);
											$("#modal_"+o.id).modal('toggle');
										});
                            		                            			
                            			 $("#ksp_"+o.id).on('click',function() {
                            				 //console.log($(this).is(":checked"));
                            				  if($(this).is(":checked")){
                                				   if (o.tipe == 0){
													addLayerArcGISTiledSublayer("ksp_"+o.id, o.service, o.name + " -" + obj.name);
												  }else{
													  if(o.sub == ""){
														addLayerArcGISMenu("ksp_"+o.id, o.service, o.name + " -" + obj.name);
													  }else{
														addLayerArcGISSublayer ("ksp_"+o.id, o.service, o.name + " -" + obj.name, {id:o.sub, title: obj.name});
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
										 
											if(o.sub === ''){
								//console.log(o);
								//console.log('animasi');
									$('#container-ksp-content-'+ obj.id).append('<div id="animasi-'+ o.id+'" class="row border"></div>');
									$('#animasi-'+ o.id).append('<div class="col-sm-3 border pt-1 pl-4" id="tombol"><div id="playButton-'+ o.id+'" class="esri-widget--button" style="width:50px"><div><span class="toggle-button-icon esri-icon-play" aria-label="play icon"></span></div></div><div id="pauseButton-'+ o.id+'" class="esri-widget--button" style="width:50px"><div><span class="toggle-button-icon esri-icon-pause" aria-label="pause icon"></span></div></div></div>');
									$('#pauseButton-'+ o.id).hide();
									$('#animasi-'+ o.id).append('<div class="col-sm-9 border pt-2" ><input id="range-'+ o.id+'" style="width:200px;" step=2 min=0 max=100 type="range" value="100" name="" list="tickmarks-'+ o.id+'"></div>');
									$('#animasi-'+ o.id).append('<datalist id="tickmarks-'+ o.id+'"></datalist>');//+
									$('#animasi-'+ o.id).append('<div id="valSeries-'+ o.id+'" class="pt-1" style="margin:0 auto;"></div>');
									
									
									$('#animasi-'+ o.id).hide();
									
									
									 $( '#playButton-'+ o.id ).click(function() {
										 var ele = document.getElementById('range-'+ o.id);
										 $( '#playButton-'+ o.id).hide();
										 $( '#pauseButton-'+ o.id).show();
										 
										 if(ele.value == ele.max )
											ele.value = 0;
										 ele.step = 1;
										 
										 foundLayer = map.allLayers.find(function(layer) {
														return layer.title === o.name + " -" + obj.name;
										 });
										 
										 
										 console.log(foundLayer);
										 items = foundLayer.sublayers.items;
										// console.log(items);
										 
										 ele.max = items.length;
										 $('#tickmarks-'+ o.id).empty();
										 sorted = [];
										 console.log(ele.value);
										
										 if(items[0].id > items[items.length-1].id)
												 items = items.reverse();
										 for(i = 0; i <  items.length; i++){
											  console.log(items[i].id + ' - ' + items[i].visible );
											  if(items[i].id <= ele.value)
												items[i].visible = true;
											   else
												items[i].visible = false;
											
											 $('#tickmarks-'+ o.id).append('<option value="'+(items[i].id+1)+'"></option>');
										 }
									
										// $('#tickmarks').append('<option value="'+ele.max+'"></option>');
										 if(o.id == 11)
										  myVar11 = setInterval(myTimer, 1000);
									     else
										  myVar12 = setInterval(myTimer, 1000);
										 
										 function myTimer(){
										   ele.stepUp();
										   console.log(ele.value);
										   console.log(items[ele.value-1]);
										   $( '#valSeries-'+ o.id ).html('<p>DAY: '+ items[ele.value-1].id + ', Tanggal: ' + items[ele.value-1].title +'</p>');
										   items[ele.value-1].visible = true;
										   if(ele.value >= items.length){
											    if(o.id == 11)
													clearInterval(myVar11);
												else
													clearInterval(myVar12);

												$( '#playButton-'+ o.id).show();
												$( '#pauseButton-'+ o.id).hide();
										   }
										   
										 }
										 
									 });
									 
									 $( '#pauseButton-'+ o.id ).click(function() {
										 $( '#playButton-'+ o.id).show();
										 $( '#pauseButton-'+ o.id).hide();
										   if(o.id == 11)
													clearInterval(myVar11);
												else
													clearInterval(myVar12);
										 
									 });
									 
										// }, 300);
        //0 == root, 1 == sublayers
		/*
		<div class="col-md-2 border"></div>
		<input type="range" list="tickmarks">

<datalist id="tickmarks">
  <option value="0"></option>
  <option value="10"></option>
  <option value="20"></option>
  <option value="30"></option>
  <option value="40"></option>
  <option value="50"></option>
  <option value="60"></option>
  <option value="70"></option>
  <option value="80"></option>
  <option value="90"></option>
  <option value="100"></option>
</datalist>

			/* <div
          id="playButton"
          class="esri-widget esri-widget--button toggle-button"
        >
          <div>
            <span
              class="toggle-button-icon esri-icon-play"
              aria-label="play icon"
            ></span>
            Play
          </div>
          <div>
            <span
              class="toggle-button-icon esri-icon-pause"
              aria-label="pause icon"
            ></span>
            Pause
          </div>
        </div>
		*/
							}
										 k++;
				});
				
			}
	});
		
  	}
  	
  	
  	function populateExtraMenuTools(){
		//Basemap
    	/*
		$('<div />', { id: 'basemap',"class":'bg-light p-3'}).appendTo('#tool-content-0');
		//Layers
    	$('<div />', { id: 'layers',"class":'bg-light p-3'}).appendTo('#tool-content-1');
		//Legend
    	$('<div />', { id: 'legends',"class":'bg-light p-3'}).appendTo('#tool-content-2');
		//Analysis
    	$('<div />', { id: 'analysis',"class":'bg-light p-3'}).appendTo('#tool-content-3');
		*/
    	//JIGN
    	$('<div />', { id: 'containerJIGN',"class":'bg-light p-3'}).appendTo('#simpulContent');
      	$('<div />', { id: 'formSimpul', "class":'form-group'}).appendTo('#containerJIGN');
    	$('<label />', { "for": 'tipeSimpul' }).text("Node Categories").appendTo('#formSimpul');
    	$('<select />',{id: 'tipeSimpul', "class":'form-control'}).appendTo('#formSimpul');
    	$('#tipeSimpul').append('<option disabled selected="selected">Select Categories</option>');
    
    	tipeSimpulArray.forEach(function(obj) {
    		    $('#tipeSimpul').append('<option value="'+obj.id+'">'+obj.name+'</option>');
    	});
    	$('<div />', { id: 'listSimpul', "class":'form-group'}).appendTo('#containerJIGN');
    	$('<label />', { "for": 'daftarSimpul' }).text("List of Nodes").appendTo('#listSimpul');
    	$('<select />',{id: 'daftarSimpul', "class":'form-control'}).appendTo('#listSimpul');
    	$('#daftarSimpul').append('<option disabled selected="selected">Select Nodes</option>');
    	$('<input type="button" value="Process" class="btn btn-sm btn-primary form-control" id="query" />').appendTo('#containerJIGN');
    	$('<div />', { id: 'service', "class": "p-2 ml-2"}).appendTo('#simpulContent');
    
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
    	$('<div />', { id: 'cari',"class":'w-100 bg-info p-4'}).appendTo('#searchContent');
		
		$('<div />', { id: 'containerHelp',"class":'p-3'}).appendTo('#helpContent');
		$('#containerHelp').append('<?php echo $about; ?>');
    }
	

	function create_card(id, title){
		return '<div id="'+id+'" class="card"><div class="card-header bg-frost unselectable"><strong class="mr-auto text-light">'+title+'</strong>'
			    + '<button type="button" class="ml-2 mb-1 close tutup text-light" aria-label="Close"><span aria-hidden="true">&times;</span></button><button type="button" class="ml-2 mb-2 close min text-light" aria-label="Minus"><span aria-hidden="true"> - </span></button></div>'
		  		+ '<div class="card-body p-2"></div></div>';
	}

	function setup_action(){
		 $('#basemap').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });
		 $('#simpul').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });
		 $('#search').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });
		 $('#help').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });
		   	
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
		 $('#queryView').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });
		// $( ".card-body" ).resizable();  
		 $('#downloadView').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });
		 $('#metadataView').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });
		   $('#resultView').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });
		 $('#atributView').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });
		 $('#tools').draggable({
		     handle: ".card-header",
		     containment: "parent" 
		   });
		
		   

		 $( ".min" ).click(function() {
			  //alert( "Handler for .dblclick() called." );
			  $(this).closest('.card').find('.card-body').toggle();//css("border", "solid 1px red");
			 // console.log($('.min span').html());
			  $(this).find('span').html($(this).find('span').html() == ' - ' ? '+' : ' - ');
			  //$(this).toggle();
			 // $(this).parent().css('height', '10px');
			  //$(this).closest('.card .card-body').fadeOut();
		  });

		 $( ".mon" ).click(function() {
			  //alert( "Handler for .dblclick() called." );
// 			  /console.log($(this).closest('div'));
			  //console.log($("#extraMenu").css("height"));
			  
			 
			  //alert( "Handler for .dblclick() called." );
			  //console.log($(this).closest('div'));
			 //console.log($("#extraMenu").css("height"));
 			  //.headerExtraMenu
			 // var p = 
				//console.log($(this).closest('div'));
				  var i = 0;
				  var k = 0;
				  $('#ksp').children().each(function(){
					    //console.log(i);
						//if(obj.includes('bg-primary'))
						if($(this).attr("class").includes('bg-primary'))
								k = i;
						i++;
				  });

				  console.log(k);
				  if($("#extraMenu").css("height") != "36px"){
					  //console.log('aa');
	    			  $("#extraMenu").css("height","36px");
				  	  var j = 0;
				      var l = 1;
				  
    				  $('#extraMenu').children().each(function(){
    						 // console.log($(this));
    						  if(j == (k+2))
    						  {
    							  //console.log($(this));
    			    			  $(this).children().each(function(){
    		    					if(l > 1)
    			    						$(this).hide();
    		    					l++;
    			    			  });
    				          }
    						  j++;
    						
    				  });
				  }else{
					  $("#extraMenu").css("height","400px");
				  	  var j = 0;
				      var l = 1;
				  
    				  $('#extraMenu').children().each(function(){
    						 // console.log($(this));
    						  if(j == (k+2))
    						  {
    							 // console.log($(this));
    			    			  $(this).children().each(function(){
    		    					if(l > 1)
    			    						$(this).show();
    		    					l++;
    			    			  });
    				          }
    						  j++;
    						
    				  });
	
				  }
					  /*
			  if($("#extraMenu").css("height") != "59px"){
				  console.log('aa');
    			  $("#extraMenu").css("height","59px");
    			  var i = 0;

    			 // console.log( $(this));
    			 // console.log($("#extraMenu").css("height"));
    			  $('#extraMenu').children().each(function(){
    					if(i > 1)
    						$(this).hide();
    					i++;
    			  });
    			  
		 	  }else{
			 	  console.log('bb');
		 		  $("#extraMenu").css("height","95%");
    			  var i = 1;
    			  $(this).closest('.extraMenuContent').children().each(function(){
    					if(i > 1)
    						$(this).show();
    					i++;
    			  });
		 	  }
			  //$(this).closest('.card .card-body').fadeOut();
			 */
				$(this).find('span').html($(this).find('span').html() == ' - ' ? '+' : ' - ');
		  });

		$( ".monB" ).click(function() {
			  //alert( "Handler for .dblclick() called." );
// 			  /console.log($(this).closest('div'));
			  //console.log($("#extraMenu").css("height"));
			  
			 
			  //alert( "Handler for .dblclick() called." );
			  //console.log($(this).closest('div'));
			 //console.log($("#extraMenu").css("height"));
 			  //.headerExtraMenu
			 // var p = 
				//console.log($(this).closest('div'));
				  var i = 0;
				  var k = 0;
/*
				  $('#ksp').children().each(function(){
					    //console.log(i);
						//if(obj.includes('bg-primary'))
						if($(this).attr("class").includes('bg-primary'))
								k = i;
						i++;
				  });*/

				  console.log(k);
				  if($("#extraBottomMenu").css("height") != "59px"){
					  //console.log('aa');
	    			  $("#extraBottomMenu").css("height","59px");
				  	  var j = 0;
				      var l = 1;
				  
    				  $('#extraBottomMenu').children().each(function(){
    						 // console.log($(this));
    						  if(j == (k+2))
    						  {
    							  //console.log($(this));
    			    			  $(this).children().each(function(){
    		    					if(l > 1)
    			    						$(this).hide();
    		    					l++;
    			    			  });
    				          }
    						  j++;
    						
    				  });
				  }else{
					  $("#extraBottomMenu").css("height","95%");
				  	  var j = 0;
				      var l = 1;
				  
    				  $('#extraBottomMenu').children().each(function(){
    						 // console.log($(this));
    						  if(j == (k+2))
    						  {
    							 // console.log($(this));
    			    			  $(this).children().each(function(){
    		    					if(l > 1)
    			    						$(this).show();
    		    					l++;
    			    			  });
    				          }
    						  j++;
    						
    				  });
	
				  }
					  /*
			  if($("#extraMenu").css("height") != "59px"){
				  console.log('aa');
    			  $("#extraMenu").css("height","59px");
    			  var i = 0;

    			 // console.log( $(this));
    			 // console.log($("#extraMenu").css("height"));
    			  $('#extraMenu').children().each(function(){
    					if(i > 1)
    						$(this).hide();
    					i++;
    			  });
    			  
		 	  }else{
			 	  console.log('bb');
		 		  $("#extraMenu").css("height","95%");
    			  var i = 1;
    			  $(this).closest('.extraMenuContent').children().each(function(){
    					if(i > 1)
    						$(this).show();
    					i++;
    			  });
		 	  }
			  //$(this).closest('.card .card-body').fadeOut();
			 */
				$(this).find('span').html($(this).find('span').html() == ' - ' ? '+' : ' - ');
		  });

		 $('.tutup').on('click',function() {
			  //console.log($(this).closest('.card'));
			  o = $(this).closest('.card');
			  //console.log($(this).attr("id"));   
			  
			  if($(this).attr("id") == null){
				o.fadeOut();
			  	$("#menu_"+o.attr('id')).toggleClass("border border-primary");
		 	  }else{
		 		 closeMainMenu();
		 	  }
		  });

		   $('.tutupB').on('click',function() {
			  //console.log($(this).closest('.card'));
			  o = $(this).closest('.card');
			  //console.log($(this).attr("id"));   
			  
			  if($(this).attr("id") == null){
				o.fadeOut();
			  	$("#menu_"+o.attr('id')).toggleClass("border border-primary");
		 	  }else{
		 		 closeBottomMenu();
		 	  }
		  });

		 $('#menu_user').on('click',function() {
			 $('#user').toggle();
			 $('#menu_user').toggleClass("border border-primary");
		  });
		/*
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
			*/
		  $('#clearMeasurement').on('click', function() {
				//alert('clear');
				 if (activeWidget) {
		               view.ui.remove(activeWidget);
		               activeWidget.destroy();
		               activeWidget = null;
		               var elements = document.getElementsByClassName("activeMeasurement");
		               for (var i = 0; i < elements.length; i++) {
		                 elements[i].classList.remove("activeMeasurement");
		               }
		         }
		  });
		
		 $('#query').on('click', function() {
		     	$("div#service").empty();
		     	if($('#daftarSimpul').val() == null){
		    		$("div#service").html("Pilih Tipe dan Simpul Jaringan terlebih dahulu");	
		    	}else{
		    		$("div#service").html("<img width='100px' src='assets/images/loading.gif' /><span id='msg'>tunggu sebentar.. </span>");
		    		var o = $.grep(listSimpulArray, function(obj){return obj.id == $('#daftarSimpul').val();})[0];
		    		if(o.server == 0){
		    			urel= o.url +"?f=pjson";
		    			//urel=urel.replace("http", "https");
		    			var sp = urel.split("//");
		    			var protocol = sp[0];
		    			var url = sp[1];
		    			
		    			//console.log(urel);
		    				$.ajax({
                 	        type: "post",
                 	        url: "api_old/arcgis",
                 	        dataType: "json",
                 	        data: {protocol: protocol, url: url},
                 	        timeout: 30000,
                 	        success: function(json) {
                 	        	 //console.log(json);
                 	        	 $("div#service").html("");
                 	        	 if(json == null)
                 	        	 {
                 	        		 $("div#service").html( "Request Failed: Folders is null");
                 	        	     $("div#service").append( "<p class='text-break pr-2'>Silahkan cek data di URL : <a href='" + o.url+ "' target='blank' >" + url+ "</a> </p>");	
                 	        	 }else{
                     	        	 
                	        	 var j=0;
    		                     //console.log(json.folders.length);
    		                     var k = 1;
    		                     $.each(json.folders, function( key, val ) {
    		                     	//items.push( "<li id='" + key + "'>" + val + "</li>" );
    		                     	//folders.push(val);
    		                     	//console.log(val);
    		                     	urel=o.url+"/"+val+"?f=pjson";
    				    			//urel=urel.replace("http", "https");
    				    			var sp = urel.split("//");
    				    			var protocol = sp[0];
    				    			var url = sp[1];

    		                     	$.post("api_old/arcgis",{protocol: protocol, url: url}).done(function(data) {
    										//console.log(data);
    										$.each(data.services, function( k, v ) {
    											//console.log(v.type);
    											if(v.type == "MapServer"){
    		                               			$("#service").append("<div class='row p-2'><div class='col-sm-3'><img class='img-fluid' src='"+ o.url+"/"+v.name+"/"+v.type+"/info/thumbnail' onerror='this.src=\"assets/images/no_thumb_layer.png\";'></div><div class='col-sm-7 text-break px-0'>"+v.name+"</div><div class='col-sm-1 mr-0'><input type='button' class='btn btn-info btn-sm' value='+' id='btn-"+j+"'></div></div>");
    		 	                                	//items.push(val.name);
    		 	                                	
    		 	                                	$('input#btn-'+j).on('click', function() {
    		 	                                		addLayerArcGIS( o.url+"/"+v.name+"/"+v.type, "JIGN ("+ o.name + ") - " + v.name);
    		 	                                		//console.log(map);
    		 			                            });
    		 	                                	j++;
    		 	                                	k++;
    		 	                                	//console.log(k);
    		 	                                }
    										});
    		                         });
    		                     	
    		                   	 });
    		                     $.each(json.services, function( key, val ) {
 			                     	//items.push( "<li id='" + key + "'>" + val + "</li>" );
 			                     	if(val.type == "MapServer"){
 			                     		$("#service").append("<div class='row p-2'><div class='col-sm-3'><img class='img-fluid' src='"+ o.url+"/"+val.name+"/"+val.type+"/info/thumbnail' onerror='this.src=\"assets/images/no_thumb_layer.png\";'></div><div class='col-sm-7 text-break px-0'>"+val.name+"</div><div class='col-sm-1 mr-0'><input type='button' class='btn btn-info btn-sm' value='+' id='btn-"+j+"'></div></div>");
 			                                //items.push(val.name);
 			                           	
 			                           	$('input#btn-'+j).on('click', function() {
 			                           		addLayerArcGIS( o.url+"/"+val.name+"/"+val.type, "JIGN ("+ o.name + ") - " + val.name);
 			                           		//console.log(map);
 				                            });
 			                           	j++;
 			                           }
 			                 	});
                 	           }
                 	        },
                 	        error: function(xhr, status) {
                	        	 //console.log(status);
                	        	 var err = status;
    		                     $("div#service").html( "Request Failed: " + err + " Koneksi Gagal.");
    		                     $("div#service").append( "<p class='text-break pr-2'>Silahkan cek koneksi URL : <a href='" + o.url+ "' target='blank' >" + url+ "</a> </p>");	
                    	        	
                	        }
                		});
		    			
		    		}else if(o.server == 1){
				    		//console.log(o.url);
				    		
				    		urlWMS= o.url+"?service=wms&request=GetCapabilities";
							var sp = urlWMS.split("//");
							var protocol = sp[0];
							var url = sp[1];
                        	//console.log(urlWMS);
                        	
                        		$.ajax({
                 	        type: "post",
                 	        url: "api_old/geoserver",
                 	        dataType: "xml",
                 	        data: {protocol: protocol, url: url},
                 	        timeout: 30000,
                 	        success: function(data) {
                 	        	 $("div#service").html("");
                 	        	 //console.log(data);
                 	        	 if(data == null)
                 	        	 {
                 	        		 $("div#service").html( "Request Failed: XML is null");
                 	        	     $("div#service").append( "<p class='text-break pr-2'>Silahkan data di URL : <a href='" + o.url+ "' target='blank' >" + url+ "</a> </p>");	
                 	        	 }else{
                     	        	 
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

               	          	  			 	     $("div#service").append("<div class='row p-2'><div class='col-sm-3'><img class='img-fluid' src='"+imageUrl+"' onerror='this.src=\"assets/images/no_thumb_layer.png\";'></div><div class='col-sm-7 text-break px-0'>"+ title+"</div><div class='col-sm-1 mr-0'><input type='button' class='btn btn-info btn-sm' value='+' id='btn-"+j+"'></div></div>");
               	                           	//items.push(val.name);
               	                           	
               	                           	$('input#btn-'+j).on('click', function() {
               	                           		addLayerWMSOGC(o.url, "JIGN ("+o.name+")", layer, title, legend);
               	                           		console.log(o.url);
               		                            });
               	                           	j++;
               	       	  			    });
               	       	  			    //console.log( $(this).find('Title').text() ); 
               	   	  	 				//if ($(this).children("Name").text().match(/postgis:/g) != null) {
               	   	  	 					//$("#wmsDirectoryLayer").append('<option value="' + $(this).children("Name").text() + '">' + $(this).children("Title").text() + '</option>');
               	   	  	 					//console.log($(this).children("Title").text());
               	   	  	 				//}
               	   	  				});
                 	           }
                 	        },
                 	        error: function(xhr, status) {
                	        	 //console.log(status);
                	        	 var err = status;
    		                     $("div#service").html( "Request Failed: " + err + " Koneksi Gagal.");
    		                     $("div#service").append( "<p class='text-break pr-2'>Silahkan cek koneksi URL : <a href='" + o.url+ "' target='blank' >" + url+ "</a> </p>");	
                    	        	
                	        }
                		});
                        	
		    		}
		    	}
		 });

	  		init_map();
	}

	function openBottomMenu(o, j){
		//alert(o + ' ' + j);
		
		switch(o){
			case 0:
				 $('#basemap').toggle();
				break;
			case 1:
				 $('#layerList').toggle();
				break;
			case 2:
				 $('#legend').toggle();
				break;
			case 3:
				 $('#tools').toggle();
				break;
			case 4:
				 $('#simpul').toggle();
				break;
			case 5:
				 $('#search').toggle();
				break;
			case 6:
				 $('#help').toggle();
				break;
			
			default :
				break;
			
		}
		/*
		$( ".menu" ).each(function( index ) {
	    	//$(this).removeClass("border border-primary bg-primary");
			var b = $(this).find('img:first');
			if(b.attr('src').includes('on')){
				var off = b.attr('src').replace('on', 'off');
				b.attr('src', off);
			}
			//console.log(b.attr('src'));
		});
		//$("#"+j+"-"+o).addClass("border border-primary bg-primary");
		
		var a = $("#"+j+"-"+o).find('img:first');
		//console.log(a.attr('src').replace('off', 'on'));
		var on = a.attr('src').replace('off', 'on');
		a.attr('src', on);
		
		$("#extraBottomMenu").show();
		$("#extraBottomMenu").css("height","95%");
		var i = 1;
		$('.headerExtraBottomMenu').closest('.extraMenuBottomContent').children().each(function(){
				if(i > 1)
					$(this).show();
				i++;
		});
		$( ".extraMenuBottomContent" ).each(function( index ) {
	    	$(this).hide();
		});
		$("#"+j+"-content-"+o).fadeIn();
		$(".monB").find('span').html(' - ');
		*/
	}
	
	function closeBottomMenu(){
		$("#extraBottomMenu").fadeOut();	
		/*$( ".menu" ).each(function( index ) {
	    	//$(this).removeClass("border border-primary bg-primary");
			var b = $(this).find('img:first');
			if(b.attr('src').includes('on')){
				var off = b.attr('src').replace('on', 'off');
				b.attr('src', off);
			}
		});*/
	}

	function openMainMenu(o, j){
		
		$( ".menu" ).each(function( index ) {
	    	//$(this).removeClass("border border-primary bg-primary");
			var b = $(this).find('img:first');
			if(b.attr('src').includes('on')){
				var off = b.attr('src').replace('on', 'off');
				b.attr('src', off);
			}
			//console.log(b.attr('src'));
		});
		//$("#"+j+"-"+o).addClass("border border-primary bg-primary");
		
		var a = $("#"+j+"-"+o).find('img:first');
		//console.log(a.attr('src').replace('off', 'on'));
		var on = a.attr('src').replace('off', 'on');
		a.attr('src', on);
		
		$("#extraMenu").show();
		$("#extraMenu").css("height","400px");
		var i = 1;
		$('.headerExtraMenu').closest('.extraMenuContent').children().each(function(){
				if(i > 1)
					$(this).show();
				i++;
		});
		$( ".extraMenuContent" ).each(function( index ) {
	    	$(this).hide();
		});
		$("#"+j+"-content-"+o).fadeIn();
		$(".mon").find('span').html(' - ');
	}

	function closeMainMenu(){
		$("#extraMenu").fadeOut();	
		$( ".menu" ).each(function( index ) {
	    	//$(this).removeClass("border border-primary bg-primary");
			var b = $(this).find('img:first');
			if(b.attr('src').includes('on')){
				var off = b.attr('src').replace('on', 'off');
				b.attr('src', off);
			}
		});
	}
	
	function init_map(){
		
		
		
	
  		map = new Map({
			     basemap: 'satellite',//'osm' //'topo'
		});
		
			//https://geoportal.menlhk.go.id/arcgis/rest/services/KLHK/Kawasan_Hutan_Juli2019/MapServer  
			/*
		 var layer = new MapImageLayer({
			   id: "series",
     		    url: queryMap,
         		title: queryMapTitle,
				sublayers: [{id:queryMapId, title:queryMapSubtitle}],
     		    visible:true
     	  });
     	  map.add(layer);
		  
		  var layer = new MapImageLayer({
			   id: "series",
     		    url: 'http://forests2020.ipb.ac.id/arcgis/rest/services/EarlyWarningDaily/EWS8_2019/MapServer',
         		title: 'Early Warning',
				opacity: 0,
				visible: true
				//listMode: 'hide'
     	  });
     	  map.add(layer);
		  */
		  
		view = new MapView({
				container: "viewDiv",
			     map: map,
			     /*
			     highlightOptions: {
			    	    color: [255, 255, 0, 1],
			    	    haloOpacity: 0.9,
			    	    fillOpacity: 0.2
			    	  },
			    	  */
			     center: [118,-2],
			     zoom: 6
		});
		
		polygonGraphicsLayer = new GraphicsLayer({listMode:'hide'});
       // map.add(polygonGraphicsLayer);
		
		//boundaryGraphicsLayer = new GraphicsLayer({});
        //map.add(boundaryGraphicsLayer);
		
		sketchViewModel = new SketchViewModel({
			view: view,
			layer: polygonGraphicsLayer,
			polygonSymbol: {
			   type: "simple-fill", // autocasts as SimpleFillSymbol
			   color: [178, 102, 234, 0.8],
			   style: "none",
			   outline: { // autocasts as SimpleLineSymbol
				color: [0, 0, 0],
				width: 1
			  }
			}
		  });
		  

	//	testLayer = new GraphicsLayer({title: 'highlighted', listMode:'hide'});
		//map.add(testLayer);
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
		/*
		view.watch("updating",function(updating){
			console.log("updating " + updating);
		});
		*/

  		init_widget();

	}

    function loadDrawingContent(){
		
		if(map.layers.items.length > 0){

			//drawing content show
		
			$("#drawingStatus").hide();
			$("#drawingTool").show();
			  
		}
    }
	
	function loadShapeContent(){
		
		if(map.layers.items.length > 0){

			//drawing content show
			$("#shapeStatus").hide();
			$("#shapeTool").show();
			  
		}
    }
	
	

    function loadBoundaryContent(){
		if(map.layers.items.length > 0){
			$("#boundaryStatus").hide();
			$("#boundaryTool").show();
		}
   }


	function init_watcher(){
		// Display the loading indicator when the view is updating
		watchUtils.whenTrue(view, "updating", function(evt) {
		   //showLoader();
		   //console.log("view updating true");
		   //console.log(expires);
		  // console.log(Date.now());
		
		});
		
		
		
			
			
		 
			  
			  

		// Hide the loading indicator when the view stops updating
		watchUtils.whenFalse(view, "updating", function(evt) {
			//closeLoader();
			//console.log("view updating false");
		});

		 // Listen to layerview create event for the layers
        view.on("layerview-create", function(event) {
            console.log(event.layer.title + " is " + event.layer.loadStatus);
			//console.log(event.layer.id.split('_'));
			if(event.layer.title.includes('Alert')){
				
				$('#animasi-'+event.layer.id.split('_')[1]).show();
			}
        });
        view.on("layerview-destroy", function(event) {
            console.log(event.layer.title + " is " + event.layer.loadStatus);
			if(typeof event.layer.title !== 'undefined'){
				if( event.layer.title !== null){
					if(event.layer.title.includes('Alert')){
						$('#animasi-'+event.layer.id.split('_')[1]).hide();
						  if(event.layer.id.split('_')[1] == 11)
															clearInterval(myVar11);
														else
															clearInterval(myVar12);
						  $( '#playButton-'+  event.layer.id.split('_')[1]).show();
						  $( '#pauseButton-'+ event.layer.id.split('_')[1]).hide();
					}
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
				
				//console.log(event.graphic.geometry);
				geom = event.graphic.geometry;
				calculateAnalysis(geom, '');
				
				$("#switchDrawing").attr("checked", false);
				$('#statusDrawing').text("Drawing is not active");
				$('#statusDrawing').removeClass( "text-success" );
				sketchViewModel.cancel();
			  }else if(event.state === "cancel"){
				$("#switchDrawing").attr("checked", false);
				$('#statusDrawing').text("Drawing is not active");
				$('#statusDrawing').removeClass( "text-success" );
				sketchViewModel.cancel();
				  
			  }
			});


        view.map.allLayers.on("change", function(event) {
            // change event fires after an item has been added, moved or removed from the collection.
            // event.moved - an array of moved layers
            // event.removed - an array of removed layers
            // event.added returns an array of added layers
            //console.log(map.layers.items);
            
            if (event.added.length > 0) {
              event.added.forEach(function(layer) {
                console.log("layer added: " + layer.title);
              });
            }
			
		      
    	 //if(map.layers.itemstype
		 
			  if(map.layers.items.length > 0){
					loadDrawingContent();
					loadBoundaryContent();
					loadShapeContent();
					
			  }else {
					closeDrawingContent();
					closeBoundaryContent();
					closeShapeContent();
			  }
		
            
          });
        
        locateWidget.on("locate", function(locateEvent){
            //console.log(locateEvent);
           // console.log("scale: %s", view.scale);
            //console.log("zoom: %s", view.zoom);
           // console.log(view.map.basemap.id);
            if(view.map.basemap.id == 'rbi')
            	view.zoom = 15;
          });

        locateWidget.on("locate-error", function(err){
              console.log(err);
        });

        view.popup.watch("visible", function(visible) {
            //var info = "<br>" + "<span> view popup visible </span> = " + visible;
            //displayMessage(info);
            if (visible == false)
    			view.graphics.removeAll();
			
			
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
       /* view.on("click", function(event) {

             //   view.graphics.removeAll();
			    if(boundaryFlag){
					
					
				}
					
        }); //view on clik
		*/
		
		 view.on("click", function(event) {

                view.graphics.removeAll();
				document.getElementById("viewDiv").style.cursor = "wait";
                async function identify(){
                   // console.log('a');
                    let collection = [];
                   // var identifyLayer = new GraphicsLayer({title: 'identify'});
                    
                    
					for(val of map.layers.items.reverse()){
						//console.log(val);
						if(val.visible && val.listMode == "show"){
							/*
							 featureLayer = new FeatureLayer({
			                	  url: val.url});
		                	 console.log(featureLayer);
		                	 */
    						layerIds = [];

		                	 if (val.sublayers !== undefined){
        				  		$.each(val.sublayers.items, function(key, val){
        				  			if(val.visible){
        				  				layerIds.push(val.id);
        							}
        				  		});
					    	}
    				  		params = new IdentifyParameters();
    				  		//PR cari tipe featurenya
    				  		if(true)
        	    	        	params.tolerance = 5;
    				  		else
    				  			params.tolerance = 3;
        	     	        params.layerIds = layerIds.reverse();
        	    	        params.layerOption = "visible";
        	    	        params.returnGeometry = true;
        	    	        params.returnFieldName = true;
        	    	        params.width = view.width;
        	    	        params.height = view.height;
    
        	    	        identifyTask = new IdentifyTask(val.url);
        	    	        params.geometry = event.mapPoint;
        	    	        params.mapExtent = view.extent;
        	    	        //document.getElementById("viewDiv").style.cursor = "au";
    
        	    	        // This function returns a promise that resolves to an array of features
        	    	        // A custom popupTemplate is set for each feature based on the layer it
        	    	        // originates from
        	    	        //console.log('b');

          	    	    // if(val.title.includes('KSP') || val.title.includes('JIGN')){
          	    	  
          	    	     await identifyTask
     	    	          .execute(params)
     	    	          .then(function(response) {
     	    	            var results = response.results;
     	    	            //console.log(response);
     	    	            return results.map(function(result) {
         	    	          //console.log(result);
     	    	              var feature = result.feature;
     	    	              var layerName = result.layerName;
     	    	              //console.log(feature.attributes);
     	    	              feature.attributes.layerName = layerName;



        	    	             
     	    	  			  
     	    	  			fieldInfos=[];
     	    	  			/*if(val.title.includes('KSP')){
                     	    	  		   bantu = val.url.split("/");
                   	    	              //console.log();
                   	    	             alias = bantu[bantu.length-2].toLowerCase()+'_'+result.layerId;
                   	    	             // feature.attributes.alias = alias.toLowerCase();
                   	    	             
                 						 allowed_field =[];
                 						 //console.log(alias);
                 						 //console.log(listAllowedLihat);
                 						 var obj = $.grep(listAllowedLihat, function(n){return n.alias_metadata === alias;})[0];
                 						 //console.log(obj);
                 						 var fields = obj.query_lihat.split("|");
                 						fields.forEach(function(im) {
                 	 						
                 							allowed_field.push(im);
                
                 							//fieldInfos.push({"fieldName":im});
                 							
                 						});
                 						// allowed_field.push("layerName");
                 						//allowed_field.push("Panjang Batas");
                   	    	            
                 						//console.log(allowed_field);
                 						
                     	    	  			$.each(feature.attributes,function(key ){
                     	    	  				//console.log(key);
                     	    	  				if(allowed_field.includes(key))
                     	    	  					fieldInfos.push({"fieldName":key});
                     	    	  			});
     	    	  			}else if(val.title.includes('JIGN')){*/
     	    	  				$.each(feature.attributes,function(key ){
         	    	  					fieldInfos.push({"fieldName":key});
         	    	  			});
     	    	  			//}
     	    	  		// console.log(fieldInfos);
     	    	  			
     	    	              feature.popupTemplate = {
     	    	                      // autocasts as new PopupTemplate()
     	    	                      //title: "{NAME}",
     	    	                      	title: "Layer: {layerName}",
     	    	                          content: [{
     	    	                            type:"fields"
     	    	                          }],
     	    	  	                    fieldInfos: fieldInfos,
     	    	  	                   //highlightEnabled: true
     	    	              	};
   	    	              	
   	    	              	  collection.push(feature);
     	    	              return feature;
     	    	            });
     	    	          })
 	    	     
        	    	        
    						//feature = await executeIdentifyTask(event);
    						
    						//console.log("c")
    						//console.log(collection);
    					//}//

						
						}
					
				}//loop for
    				//	console.log('d');
    					// console.log(collection);
    					
					if (collection.length > 0) {
						 collection.forEach(function(item) {
   						// console.log(item);
   						 geo = item.geometry.type;
						  		//console.log(geo);
						  		//console.log(item.geometry.paths);
					
					
						        
							    if(geo == "point"){
							          geom = new Point({
							              x:  item.geometry.x,
							              y: item.geometry.y,
							              spatialReference: new SpatialReference({wkid: item.geometry.spatialReference.wkid})
							            });
								  	  symbol = {
							                  type: "simple-marker", // autocasts as new SimpleMarkerSymbol()
							                  color: [0, 0, 255, 0.5],
							                  outline: {
							                    // autocasts as new SimpleLineSymbol()
							                    color: [0, 0, 255, 0.5],
							                    width: 4
							                  }
							                };
								  }else if(geo == "polyline") {

									  geom = new Polyline({
										  paths: item.geometry.paths,
										  spatialReference: { wkid: item.geometry.spatialReference.wkid }
										});
									  symbol = {
											    type: "simple-line", // autocasts as new SimpleLineSymbol()
											    color: [0, 0, 255, 0.5], // RGB color values as an array
											    width: 4
											  };
			
									 // console.log(item.geometry.paths[0]);
								  }else if(geo == "polygon"){
									  geom = new Polygon({
										  rings: item.geometry.rings,
										  spatialReference: { wkid: item.geometry.spatialReference.wkid }
										});
									  symbol =  {
									          type: "simple-fill", // autocasts as new SimpleFillSymbol()
									          style: "none",
									          outline: {
									            // autocasts as new SimpleLineSymbol()
									           color: [0, 0, 255, 0.5],
									            width: 4
									          }
									        };
									
								  }
							    
							    view.graphics.add(new Graphic({
					                geometry: geom,
					                 symbol: symbol
					           }));
   			              /* 
   						 */

   						  
							 //const featureLayer = new FeatureLayer({
			                	//  url: feature.attributes.url + "/"+feature.attributes.layerId });

						 });
						 view.popup.open({
   				            features: collection,
   				            location: event.mapPoint
   				      });
				     }
					 
				     
				    document.getElementById("viewDiv").style.cursor = "auto";		 

    		 }//async identify(){

                identify();
        }); //view on clik

        	 
	}
	
	function calculateAnalysis(geom, daerah ){
		
		//draw_disabled();
				 symbol =  {
									  type: "simple-fill", // autocasts as new SimpleFillSymbol()
									  style: "none",
									  outline: {
										// autocasts as new SimpleLineSymbol()
									   color: [0, 0, 255, 0.5],
										width: 4
									  }
									};
							
						 
						 view.goTo(geom);
						 var graphic = new Graphic(geom, symbol);

						 view.graphics.add(new Graphic({
								geometry: geom,
									 symbol: symbol
						   }));
				$('#resultView').show();
				var distance = geometryEngine.geodesicArea(geom, "hectares");
				distance = parseFloat(Math.round(distance * 100) / 100000).toFixed(2); // kilo ha
		  
				$('#resultContent').html("<p>Selected Area: "+ distance + " kha</p>");
				
				//console.log(map.layers.items);
				var layer = map.layers.items[map.layers.items.length-1];
				console.log(layer);

				layer.sublayers.items.forEach(function(a){
					console.log('yes');
					if(a.visible == true){
						console.log(a);
						
						statesUrl = layer.url + "/" + a.id;//queryLayer;
						console.log(statesUrl);
						utahLyr = new FeatureLayer({url: statesUrl});
					
						if(daerah != ''){
							$('#resultContent').append("<p>"+ daerah+ "</p>");
						}
						$('#resultContent').append("<p>Layer: "+ a.title+ "</p>");
						/*var planarSym = new SimpleFillSymbol({
										style: "solid",
										color: [ 255, 0, 0, 0.4 ],
										outline: new SimpleLineSymbol({
										  color: [255,0,0, , 0.5],
										  width: 1
										})
									  }); 
									 */ 
						 var query1 = utahLyr.createQuery();
							//query1.where = "1=1"; 
							query1.returnGeometry = true;				
							query1.returnCountOnly = false;
							query1.outFields = [ "*" ];
							query1.geometry = geom;
							//query1.mapExtent = view.extent;
							//query1.geometry = view.extent;
							//query1.geometryType="esriGeometryPolygon";
						   // query1.inSR=3857;
							//var intersect_geom=[];
							//var firstgraphics = [];
							$('#resultContent').append("<div id='resultContentLuasan"+a.id+"'></div>");
							$("#resultContentLuasan"+a.id).html("<img width='100px' src='assets/images/loading.gif' /><span id='msg'> please wait.. </span>");
						   utahLyr.queryFeatures(query1).then(function(results){
							   console.log(results.features);
							   console.log("resultContentLuasan"+a.id);
							   $("#resultContentLuasan"+a.id).html('');
								if(results.features.length > 0){
									console.log(utahLyr);
									
									var ls_list = [];
									var colors = [];
									
									if(typeof utahLyr.renderer.field !== 'undefined'){
										field = utahLyr.renderer.field;
										//console.log(utahLyr.renderer.uniqueValueInfos);
										utahLyr.renderer.uniqueValueInfos.forEach(function(o) {
											//console.log(o);
											ls_list.push(o.label);
											colors.push('rgb('+o.symbol.color.r+','+ o.symbol.color.g+','+ o.symbol.color.b+')');
										});
									
									}else{
										o = utahLyr.fields[0].name;
										field = o;
										ls_list.push( o);
									}
									console.log(field);
									console.log(ls_list);
								  //intersect = geometryEngine.intersect(geom, results.features[0].geometry);
								  var theGraphicsLayer = new GraphicsLayer({title: 'test intersect'});
								  intersect_geom = [];
								  results.features.forEach(function(o) {
									   //console.log(o.attributes.ls);
									   varjoss = geometryEngine.intersect(geom, o.geometry);
									   var area = geometryEngine.geodesicArea(varjoss, "hectares");
									   area = parseFloat(Math.round(area * 100) / 100000).toFixed(2); // kilo ha
									   if(typeof utahLyr.renderer.field !== 'undefined'){
											intersect_geom.push({field:o.attributes[field], 'luas': area});
									   }else{
											intersect_geom.push({field:String(field), 'luas': area});
									  }
									   //console.log(o.attributes[field]);
									   //intersect_geom.push(geometryEngine.intersect(geom, o.geometry))
									   //$("#queryResult").append(o);
										//$('#listFeatures').append('<option value="'+o.attributes.NAMOBJ+'">'+o.attributes.NAMOBJ+'</option>');
								  });
								  console.log(intersect_geom);
								  var merge_intersect = [];
								  
								  for(k=0; k < ls_list.length; k++){
								   //var obj = $.grep(intersect_geom, function(n){return n.ls === v;})[0];
									   var obj = $.grep(intersect_geom, function(n){return n.field == ls_list[k];});
									  //console.log(obj);
									  luas = 0;
									  obj.forEach(function(o) {
											luas = luas + parseFloat(o.luas);
									  });	
									  if(obj.length > 0)
										merge_intersect.push({field:ls_list[k], 'luas': luas.toFixed(2), 'color': colors[k]});
								  }
								  //console.log(intersect_geom);
								  //console.log(merge_intersect);
								  var labels = [];
								  var datas = [];
								  var warnas = [];
								  if(typeof utahLyr.renderer.field !== 'undefined'){
									  for(k=0;k<merge_intersect.length;k++){
											//console.log(merge_intersect[k]);
											
											$("#resultContentLuasan"+a.id).append(merge_intersect[k].field+": "+  merge_intersect[k].luas + " kha<br />");
											labels.push(merge_intersect[k].field);	  
											datas.push(merge_intersect[k].luas);	  
											warnas.push(merge_intersect[k].color);	  
									  }
									  
									   $('#resultContent').append('<br />');
								  $('#resultContent').append('<canvas id="myChart"></canvas>');
								 
									var ctx = document.getElementById('myChart').getContext('2d');
									var chart = new Chart(ctx, {
										// The type of chart we want to create
										type: 'pie',

										data: {
											labels: labels,
											datasets: [{
												data: datas,
												backgroundColor: warnas,
											}]
										},

										// Configuration options go here
										 options: {
											legend: {
												display: true,
												position: 'bottom',
											}
										 }
										
									});
								  }else{
									  $("#resultContentLuasan"+a.id).append("<p>Luas: "+  merge_intersect[0].luas + " kha</p>");
									  labels.push('luas');	
									  datas.push(merge_intersect[0].luas);
								  }
								  
									
								}else{
									$("#resultContentLuasan"+a.id).append("<p>Luas: 0 kha</p>");
								}
						   });
						
					}
				});
				/*
				for (i = 0; i < layer.sublayers.length; i++){
					
					console.log(layer.sublayers);
					if(layer.sublayers.items[i].visible == true){

						statesUrl = layer.url + "/" + layer.sublayers.items[i].id;//queryLayer;
						console.log(statesUrl);
						utahLyr = new FeatureLayer({url: statesUrl});
					
						if(daerah != ''){
							$('#resultContent').append("<p>"+ daerah+ "</p>");
						}
						$('#resultContent').append("<p>Layer: "+ layer.sublayers.items[i].title+ "</p>");
						/*var planarSym = new SimpleFillSymbol({
										style: "solid",
										color: [ 255, 0, 0, 0.4 ],
										outline: new SimpleLineSymbol({
										  color: [255,0,0, , 0.5],
										  width: 1
										})
									  }); 
									 / 
						 var query1 = utahLyr.createQuery();
							//query1.where = "1=1"; 
							query1.returnGeometry = true;				
							query1.returnCountOnly = false;
							query1.outFields = [ "*" ];
							query1.geometry = geom;
							//query1.mapExtent = view.extent;
							//query1.geometry = view.extent;
							//query1.geometryType="esriGeometryPolygon";
						   // query1.inSR=3857;
							//var intersect_geom=[];
							//var firstgraphics = [];
							$('#resultContent').append("<div id='resultContentLuasan"+i+"'></div>");
							$("#resultContentLuasan"+i).html("<img width='100px' src='assets/images/loading.gif' /><span id='msg'> please wait.. </span>");
						   utahLyr.queryFeatures(query1).then(function(results){
							   console.log(results.features);
							   console.log("resultContentLuasan"+i);
							   $("#resultContentLuasan"+i).html('');
								if(results.features.length > 0){
									console.log(utahLyr);
									
									var ls_list = [];
									var colors = [];
									
									if(typeof utahLyr.renderer.field !== 'undefined'){
										field = utahLyr.renderer.field;
										//console.log(utahLyr.renderer.uniqueValueInfos);
										utahLyr.renderer.uniqueValueInfos.forEach(function(o) {
											//console.log(o);
											ls_list.push(o.label);
											colors.push('rgb('+o.symbol.color.r+','+ o.symbol.color.g+','+ o.symbol.color.b+')');
										});
									
									}else{
										o = utahLyr.fields[0].name;
										field = o;
										ls_list.push( o);
									}
									console.log(field);
									console.log(ls_list);
								  //intersect = geometryEngine.intersect(geom, results.features[0].geometry);
								  var theGraphicsLayer = new GraphicsLayer({title: 'test intersect'});
								  intersect_geom = [];
								  results.features.forEach(function(o) {
									   //console.log(o.attributes.ls);
									   varjoss = geometryEngine.intersect(geom, o.geometry);
									   var area = geometryEngine.geodesicArea(varjoss, "hectares");
									   area = parseFloat(Math.round(area * 100) / 100000).toFixed(2); // kilo ha
									   if(typeof utahLyr.renderer.field !== 'undefined'){
											intersect_geom.push({field:o.attributes[field], 'luas': area});
									   }else{
											intersect_geom.push({field:String(field), 'luas': area});
									  }
									   //console.log(o.attributes[field]);
									   //intersect_geom.push(geometryEngine.intersect(geom, o.geometry))
									   //$("#queryResult").append(o);
										//$('#listFeatures').append('<option value="'+o.attributes.NAMOBJ+'">'+o.attributes.NAMOBJ+'</option>');
								  });
								  console.log(intersect_geom);
								  var merge_intersect = [];
								  
								  for(k=0; k < ls_list.length; k++){
								   //var obj = $.grep(intersect_geom, function(n){return n.ls === v;})[0];
									   var obj = $.grep(intersect_geom, function(n){return n.field == ls_list[k];});
									  //console.log(obj);
									  luas = 0;
									  obj.forEach(function(o) {
											luas = luas + parseFloat(o.luas);
									  });	
									  if(obj.length > 0)
										merge_intersect.push({field:ls_list[k], 'luas': luas.toFixed(2), 'color': colors[k]});
								  }
								  //console.log(intersect_geom);
								  //console.log(merge_intersect);
								  var labels = [];
								  var datas = [];
								  var warnas = [];
								  if(typeof utahLyr.renderer.field !== 'undefined'){
									  for(k=0;k<merge_intersect.length;k++){
											//console.log(merge_intersect[k]);
											
											$("#resultContentLuasan"+i).append(merge_intersect[k].field+": "+  merge_intersect[k].luas + " kha<br />");
											labels.push(merge_intersect[k].field);	  
											datas.push(merge_intersect[k].luas);	  
											warnas.push(merge_intersect[k].color);	  
									  }
									  
									   $('#resultContent').append('<br />');
								  $('#resultContent').append('<canvas id="myChart"></canvas>');
								 
									var ctx = document.getElementById('myChart').getContext('2d');
									var chart = new Chart(ctx, {
										// The type of chart we want to create
										type: 'pie',

										data: {
											labels: labels,
											datasets: [{
												data: datas,
												backgroundColor: warnas,
											}]
										},

										// Configuration options go here
										 options: {
											legend: {
												display: true,
												position: 'bottom',
											}
										 }
										
									});
								  }else{
									  $("#resultContentLuasan"+i).append("<p>Luas: "+  merge_intersect[0].luas + " kha</p>");
									  labels.push('luas');	
									  datas.push(merge_intersect[0].luas);
								  }
								  
									
								}else{
									$("#resultContentLuasan"+i).append("<p>Luas: 0 kha</p>");
								}
						   });
					}
			}*/
	}

	function getCurrentExtent(){
		//{"spatialReference":{"latestWkid":3857,"wkid":102100},"rings":[[[12059466.555351064,401041.94230133214],[12763910.208027061,401041.94230133214],[12763910.208027061,-156642.61606716528],[12059466.555351064,-156642.61606716528],[12059466.555351064,401041.94230133214]]]}
		 var spatialRef = '3857';
		 var xmin = view.extent.xmin;
		 var xmax = view.extent.xmax;
		 var ymin = view.extent.ymin;
		 var ymax = view.extent.ymax;

		 return '{"spatialReference":{"latestWkid":3857},"rings":[[['+xmin+','+ymax+'],['+xmax+','+ymax+'],['+xmax+','+ymin+'],['+xmin+','+ymin+'],['+xmin+','+ymax+']]]}';
	}

	 function convertExtentToPolygon (extent, spatialRef)
	  {
	    var xmin = extent.xmin;
	    var xmax = extent.xmax;
	    var ymin = extent.ymin;
	    var ymax = extent.ymax;

	    var topLeft = new Point(xmin, ymax, spatialRef);
	    var topRight = new Point(xmax, ymax, spatialRef);
	    var bottomRight = new Point(xmax, ymin, spatialRef);
	    var bottomLeft = new Point(xmin, ymin, spatialRef);

	    var rings = new Array(topLeft, topRight, bottomRight, bottomLeft, topLeft);

	    var newPolygon = new Polygon(spatialRef);
	    newPolygon.addRing(rings);
	    //console.log(newPolygon);
	    return newPolygon;
	}

	 /*
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
        //.then(showPopup); // Send the array of features to showPopup()
	
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
	*/
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
		      	      }/*,
		      	    {
		      	          title: "Zoom to",
		      	          className: "esri-icon-zoom-in-magnifying-glass",
		      	          id: "zoom-layer"
		      	      }*/
		      	      ],
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
                  map.layers.remove(layer);
                  console.log(layer.id);
                  $("#"+layer.id).attr('checked', false);
                  //if(map.layers.items.length < 1)
                	//  identify_disabled();
                }
              else if (id === "zoom-layer") {
                  // if the information action is triggered, then
                  // open the item details page of the service layer
                  //map.layers.remove(layer);
                  console.log(layer);
                  console.log(layer.fullExtent);
                  //view.goTo(
                  //$("#"+layer.id).attr('checked', false);
                  //if(map.layers.items.length < 1)
                	//  identify_disabled();
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

		/*
		
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
		*/
		var basemaps = [];
		<?php
			 foreach($basemaps as $p){
				if($p->active == 1){
					echo '
					var mapBaseLayer = new TileLayer({
						url: "'. $p->url .'"
					});
					
					'.$p->id.' = new Basemap({
							baseLayers: [mapBaseLayer],
							title: "'.$p->basemap_name.'",
							id: "'.$p->id.'",
							thumbnailUrl: "assets/images/'. $p->thumbnail.'"
						});
					basemaps.push('.$p->id.');
					';
				}
			 }
			 ?>
			 console.log(basemaps);
			/*
			[rbi, nkri, Basemap.fromId("topo"), Basemap.fromId("osm"),Basemap.fromId("satellite"),Basemap.fromId("streets-navigation-vector")]
		  var boundariesLayer = new MapImageLayer({
	  		   url: "https://portal.ina-sdi.or.id/server/rest/services/KSP19092017/Basemap_NKRI_NoBoundaries/MapServer"
	     	});
		  nkri = new Basemap({
	            baseLayers: [boundariesLayer],
	            title: "Peta Basemap NKRI NoBoundaries",
	            id: "nkri",
	            thumbnailUrl:"assets/images/bm_rbi_polos.png"
	        });
			*/
			
		var localSource = new LocalBasemapsSource({
            	basemaps : basemaps
			})

        var basemapGallery = new BasemapGallery({
            	  view: view,
            	  container: "basemapContent",//document.createElement("div"),
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
			 container: "legendContent",
             view: view,
             style: "classic" // other styles include 'classic'
           });

        //view.ui.add(scaleBar,"bottom-right");
		view.ui.add(homeWidget, "top-right");			
		view.ui.add(zoom, "top-right");
		view.ui.add(locateWidget, "top-right");
		//view.ui.add(bgExpand, "top-right");

 	  	/*var btnHtml = '<div id="btnCustom" class="esri-component esri-widget--button esri-widget" role="button" tabindex="0" aria-label="Integrated Layer Management" title="Integrated Layer Management">';
    		btnHtml += '<span aria-hidden="true" class="esri-icon esri-icon-layers"></span>';
    		btnHtml += '<span class="esri-icon-font-fallback-text">Integrated Layer Management</span></div></div>';
		*/

    	//$(".esri-ui-top-right").append(btnHtml);

    	//view.ui.add(legExpand, "top-right");
    	//var btnHtml = '<div id="btnLegend" class="esri-component esri-widget--button esri-widget" role="button" tabindex="0" aria-label="Legenda" title="Legenda">';
    	//	btnHtml += '<span aria-hidden="true" class="esri-icon esri-icon-layer-list"></span>';
    		//btnHtml += '<span class="esri-icon-font-fallback-text">Legenda</span></div></div>';


    	//$(".esri-ui-top-right").append(btnHtml);
    	

 	  //	var btnHtml = '<div id="btnTools" class="esri-component esri-widget--button esri-widget" role="button" tabindex="0" aria-label="Tools" title="Tools">';
		//btnHtml += '<span aria-hidden="true" class="esri-icon esri-icon-settings2"></span>';
		//btnHtml += '<span class="esri-icon-font-fallback-text">Tools</span></div></div>';

		//$(".esri-ui-top-right").append(btnHtml);
/*
    	$("#btnCustom").click(function(){
    		 $('#layerList').toggle();
    	});

       	$("#btnLegend").click(function(){
   			 $('#legend').toggle();
   		});

    	$("#btnTools").click(function(){
    		 $('#tools').toggle();
    	});
		*/
		/*

    	info = document.createElement("div");
		var att = document.createAttribute("class");       // Create a "class" attribute
		att.value = "esri-widget p-3";                           // Set the value of the class attribute
		info.setAttributeNode(att);
		at = document.createAttribute("style");       // Create a "class" attribute
		at.value = "width:250px;height:100px;";                           // Set the value of the class attribute
		info.setAttributeNode(at);  
		//info.class="esri-widget";
		info.innerHTML = "<p class='text-justify'>Portal Monitoring Hutan Indonesia ini merupakan project hasil kerjasama antara UNDP dan IPB</p>";
		*/
		/*
		var infoExpand = new Expand({
          expandIconClass: "esri-icon-question",	
    	  view: view,
    	  content: info,
    	  expandTooltip:"Info KSP"
    	});

		view.ui.add(infoExpand, "top-right");
		*/
		$("#drawingButton").click(function(){
			 clearUpSelection();
			 openAnalysis('drawing');  
			 loadDrawingContent();
   		});
		$("#shapeButton").click(function(){
			 clearUpSelection();
			 openAnalysis('shape');  
			 loadShapeContent();
   		});

   		
		$("#boundaryButton").click(function(){
			//draw_disabled();
			clearUpSelection();
			$("#switchDrawing").attr("checked", false);
			$('#statusDrawing').text("Drawing is not active");
			$('#statusDrawing').removeClass( "text-success" );
			sketchViewModel.cancel();
			
			openAnalysis('boundary'); 
			loadBoundaryContent();
 		});
		
		 document
         .getElementById("distanceButton")
         .addEventListener("click", function() {
			//console.log($(this));
        	 
        	 setActiveWidget(null);
           
           if (!this.classList.contains("active")) {
             setActiveWidget("distance");
            // console.log("distance");
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
		 
		 document
          .getElementById("uploadForm")
          .addEventListener("change", function(event) {
            var fileName = event.target.value.toLowerCase();

            if (fileName.indexOf(".zip") !== -1) {
              //is file a zip - if not notify user
              generateFeatureCollection(fileName);
            } else {
              document.getElementById("upload-status").innerHTML =
                '<p style="color:red">Add shapefile as .zip file</p>';
            }
          });
       

 		init_watcher();
	}
	
	
		
		 // this function is called from the polygon draw action events

        // to provide a visual feedback to users as they are drawing a polygon
		function clearUpSelection() {
			
		  //polygonGraphicsLayer.removeAll();
		  //console.log(view);
		  if (typeof view !== 'undefined') {
			  view.graphics.removeAll();
		  }
		  //if(view.graphics != null)
			//view.graphics.removeAll();
			//console.log("clear");
          //grid.clearSelection();
        }
		
		
    function openAnalysis(type){
    	 var elements = document.getElementsByClassName("activeAnalysis");
         for (var i = 0; i < elements.length; i++) {
           elements[i].classList.remove("activeAnalysis");
         }
	     $("#"+type+"Button").addClass('activeAnalysis');
	     $(".contentAnalysis").hide();
	     $("#"+type+"Task").show();
    }
    
	 function setActiveWidget(type) {
		 $("#measurementContent").html("");
		 $("#measurementContent").append("<div id='measure'></div>");
		 
         switch (type) {
           case "distance":
             activeWidget = new DistanceMeasurement2D({
               view: view,
               container: "measure",
               label: "Ukur Jarak"
             });

             // skip the initial 'new measurement' button
             activeWidget.viewModel.newMeasurement();

             //view.ui.add(activeWidget, "top-right");
              console.log("distance");
              setActiveButton(document.getElementById("distanceButton"));
             break;
           case "area":
             activeWidget = new AreaMeasurement2D({
               view: view,
               container: "measure",
               label: "Ukur Area"
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
         //selectedButton.classList.add("activeMeasurement");
         
         var elements = document.getElementsByClassName("activeMeasurement");
         for (var i = 0; i < elements.length; i++) {
           elements[i].classList.remove("activeMeasurement");
         }
         if (selectedButton) {
           selectedButton.classList.add("activeMeasurement");
         }
         
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
         //console.log("closeLoader");
	}

	function showLoader(){
		 $("#loadingImg").fadeIn();
         $("#topLoader").css("z-index","99");
        // console.log("showLoader");
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


	function addLayerArcGISMenu(id, url, title){
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
	
	function addLayerArcGIS(url, title){
		 //var url ="https://portal.ina-sdi.or.id/arcgis/rest/services/KSP/KAWASAN_KHUSUS_DAN_TRANSMIGRASI/MapServer"+token;
		var sp = url.split("//");
		var protocol = sp[0];
		var uri = sp[1];
		//sumbarprov.ina-sdi.or.id:8080XXXgeoserverXXXwms
		    			
		var protourl = bypass + "/"+ protocol + "/" + uri.split("/").join('XXX');
		//console.log(protourl);
		
     	  var layer = new MapImageLayer({
     		    url: protourl,
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

	function addLayerArcGISSublayer(id, url, title, sub){
		 //var url ="https://portal.ina-sdi.or.id/arcgis/rest/services/KSP/KAWASAN_KHUSUS_DAN_TRANSMIGRASI/MapServer"+token;
		 //console.log(sub);
    	  var layer = new MapImageLayer({
        	  	id: id,
    		    url: url,
        		title: title,
        		sublayers: [sub],
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
		//console.log(url + ' ' +  caption + ' ' + layer + ' ' + title + ' ' + legend);
		//add layer
		var sp = url.split("//");
		var protocol = sp[0];
		var uri = sp[1];
		//sumbarprov.ina-sdi.or.id:8080XXXgeoserverXXXwms
		    			
		var protourl = bypass + "/"+ protocol + "/" + uri.split("/").join('XXX');
		//console.log(protourl);
		  
		var layer = new WMSLayer({
    		  url: protourl,
    		  title: caption,
    		  featureInfoUrl: protourl.replace('wms','ows'),
    		  sublayers: [{
    		    name: layer,
    		    title: title,
    		    popupEnabled: true,
    		    queryable: true,
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

	function  populateAttributesTable(name, url, id) {
		//console.log('populate');
		 var alias = name.toLowerCase().split(' ').join('_') + '_' + id;
		 //$("#metadataResult").html("<img width='100px' src='assets/images/loading.gif' /><span id='msg'>tunggu sebentar.. </span>");
     	 $("#tableWrapper").html("<img width='100px' src='assets/images/loading.gif' /><span id='msg'>tunggu sebentar.. </span>");

     	fieldInfos=[];
		fieldArray=[];
		aliasArray=[];    
			 //console.log(alias);
			 //console.log(listAllowedLihat);
			 var obj = $.grep(listAllowedLihat, function(n){return n.alias_metadata === alias;})[0];
			// console.log(obj);
			 var fields = obj.query_lihat.split("|");
			 var aliases = obj.field_alias_lihat.split("|");

		     var index = fields.indexOf('OBJECTID');
		     var idx = aliases.indexOf('OBJECTID');
		     
		     if (index > -1) {
		    	 fields.splice(index, 1);
		     }

		     if (idx > -1) {
		    	 aliases.splice(idx, 1);
		     }
				//fields.splice( $.inArray("OBJECTID",  fields), 1 );
				//console.log(fields);
				//console.log($.inArray("OBJECTID_1",  data.fields));
				if($.inArray("OBJECTID_1",  fields) >= 0 ){
					field_identifier = "OBJECTID_1";					
				}else{
					aliasArray.push("OBJECTID");
					if(alias == 'kehutanan_1' || alias == 'kehutanan_3' ){
						fieldInfos.push({"fieldName":"OBJECTID_1"});
						fieldArray.push("OBJECTID_1");
						field_identifier = "OBJECTID_1";
					}else{
						fieldInfos.push({"fieldName":"OBJECTID"});
						fieldArray.push("OBJECTID");
						field_identifier = "OBJECTID";
					}
					
						//fieldInfos.push({"fieldName":"OBJECTID"});
						//fieldArray.push("OBJECTID");
						//field_identifier = "OBJECTID";
				}

				 
			fields.forEach(function(im) {

				fieldArray.push(im);

				fieldInfos.push({"fieldName":im});
				
			});

			aliases.forEach(function(im) {

				aliasArray.push(im);
				
			});

			//console.log(fieldArray);
		
						const featureLayer = new FeatureLayer({
		                	  url: url + "/"+id});
                        var query = featureLayer.createQuery();
                        query.where = "1=1"; 
                        query.returnGeometry = false;
                        query.returnCountOnly = false;
                        query.outFields = fieldArray ;
                        //$("#tableWrapper").html("<img width='100px' src='assets/images/loading.gif' /><span id='msg'>tunggu sebentar.. </span>");
                        
                       featureLayer.queryFeatures(query).then(function(results){
                         
                      	 $("#tableWrapper").html("");
                           let tableWrapper = document.getElementById("tableWrapper");
                           let table = document.createElement("table");
                           table.id = "dataTableAtribut";
                           table.className = "table table-striped table-hover";
                           //tableWrapper.appendChild(table); //appends the table to tableWrapper
                           let header = document.createElement("thead");
                           table.appendChild(header);
                           let tableRowHeader = document.createElement("tr");
                           header.appendChild(tableRowHeader);            
                			//console.log(response.data.fields.length);
                           for (let i = 0; i < results.fields.length; i++) {
                               let headTable = document.createElement("th");
                               headTable.innerHTML = results.fields[i].alias;
                               tableRowHeader.appendChild(headTable);
                           }

                          
                           let tableBody = document.createElement("tbody");
                           table.appendChild(tableBody);
                			
                			//console.log(response.data.features.length);
                           for (let j = 0; j < results.features.length; j++)
                              {
                                   let feature = results.features[j];
                                   let tableRowBody = document.createElement("tr");
                               tableBody.appendChild(tableRowBody);                  
                                   for (let i = 0; i < results.fields.length; i++)
                                   {
                                        let field = results.fields[i];
                                      let divTable = 
                                                    document.createElement("td");
                                         divTable.innerHTML = 
                                                    feature.attributes[field.name];
                                   tableRowBody.appendChild(divTable);        
                                   }
                              }
            
                           tableWrapper.appendChild(table);
                			
                           //require(["https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"], function () {
            
           /* $("#tableWrapper").html("");
            let tableWrapper = document.getElementById("tableWrapper");
            let table = document.createElement("table");
            table.id = "dataTableAtribut";
            table.className = "table table-striped table-hover";
            //tableWrapper.appendChild(table); //appends the table to tableWrapper
            let header = document.createElement("thead");
            table.appendChild(header);
            let tableRowHeader = document.createElement("tr");
            header.appendChild(tableRowHeader);            
 			//console.log(response.data.fields.length);
 			//console.log(aliases);
            for (let i = 0; i < aliases.length; i++) {
                let headTable = document.createElement("th");
                headTable.innerHTML = aliasArray[i];
                tableRowHeader.appendChild(headTable);
            }

            tableWrapper.appendChild(table);
            */
                           $(document).ready(function () {
                               //console.log('atribut');
                                  var table = $('#dataTableAtribut').DataTable();
                                  /*
                                var table = $('#dataTableAtribut').DataTable({
                                    		//"scrollY": 300,
                                    		//"paging": false,
                                    		"processing": true,
                                            "serverSide": true,
                                    		"searching": false,
                                    		"ordering": false,
                                    		"select": "single",
                                    		"ajax": {
                                                "url": "api/serverProcessing",
                                                "data": function ( d ) {
                                                    d.alias = alias;
                                                    d.token = oke;
                                                    // d.custom = $('#myInput').val();
                                                    // etc
                                                }
                                            },
                                            //"ajax": "querysawah.php",
                                            "columns": [
                                                { "data": "attributes.OBJECTID" },
                                                { "data": "attributes.NAMOBJ" },
                                                { "data": "attributes.JNSSWH" },
                                                { "data": "attributes.FCODE" },
                                                { "data": "attributes.AQDATE" },
                                                { "data": "attributes.PUDATE" },
                                                { "data": "attributes.REMARK" }
                                            ]
                                    	});
	

								*/
                               $('#dataTableAtribut tbody').on( 'click', 'tr', function () {
                                   if ( $(this).hasClass('selected') ) {
                                       $(this).removeClass('selected');
                                       view.graphics.removeAll();
                                   }
                                   else {
                                       table.$('tr.selected').removeClass('selected');
                                       $(this).addClass('selected');
                                       //console.log($(this).find('td').first().html());
                                       
                                       /*
                                       var pt = new Point({
                                    	   latitude: 49,
                                    	   longitude: -126
                                    	 });
                                    	 *////
                                    	 
                                    	 let objectid = $(this).find('td').first().html();
                                    	 var query = featureLayer.createQuery();
                                         query.where = field_identifier+"="+objectid; 
                                         query.returnGeometry = true;
                                         query.returnCountOnly = false;
                                         query.outFields = [field_identifier];
                                         //$("#tableWrapper").html("<img width='100px' src='assets/images/loading.gif' /><span id='msg'>tunggu sebentar.. </span>");
                                         view.graphics.removeAll();
                                        featureLayer.queryFeatures(query).then(function(results){
                                        	 //console.log(results);
                                        	 
                                             var geo = results.geometryType; //"polyline"
                                             var item = results.features[0];     							
     								        
         								    if(geo == "point"){
         								          geom = new Point({
         								              x:  item.geometry.x,
         								              y: item.geometry.y,
         								              spatialReference: new SpatialReference({wkid: item.geometry.spatialReference.wkid})
         								            });
         									  	  symbol = {
         								                  type: "simple-marker", // autocasts as new SimpleMarkerSymbol()
         								                  color: [0, 0, 255, 0.5],
         								                  outline: {
         								                    // autocasts as new SimpleLineSymbol()
         								                    color: [0, 0, 255, 0.5],
         								                    width: 4
         								                  }
         								                };
         									  }else if(geo == "polyline") {

         										  geom = new Polyline({
         											  paths: item.geometry.paths,
         											  spatialReference: { wkid: item.geometry.spatialReference.wkid }
         											});
         										  symbol = {
         												    type: "simple-line", // autocasts as new SimpleLineSymbol()
         												    color: [0, 0, 255, 0.5], // RGB color values as an array
         												    width: 4
         												  };
         				
         										 // console.log(item.geometry.paths[0]);
         									  }else if(geo == "polygon"){
         										  geom = new Polygon({
         											  rings: item.geometry.rings,
         											  spatialReference: { wkid: item.geometry.spatialReference.wkid }
         											});
         										  symbol =  {
         										          type: "simple-fill", // autocasts as new SimpleFillSymbol()
         										          style: "none",
         										          outline: {
         										            // autocasts as new SimpleLineSymbol()
         										           color: [0, 0, 255, 0.5],
         										            width: 4
         										          }
         										        };
         										
         									  }
                                        	 view.goTo(geom);
                                        	 var graphic = new Graphic(geom, symbol);

         									 view.graphics.add(new Graphic({
     								                geometry: geom,
		     							                 symbol: symbol
     								           }));
                                        });

                                      
       								  

                                    	 // go to the given point
                                    	//
                                   }
                               });
                               
                			});
                       });//features


		    
		   
		 
   }

   function  populateQuery(url, title, id, name) {
		//console.log('populate');
		var alias = name.toLowerCase().split(' ').join('_') + '_' + id;
       /*let queryurl = url + "/"+id;
      //alert("calling attribute table for Layer " + e.target.layerid);
       let queryOptions = {
              responseType: "json",
              query:  
              {
                   f: "json"
              }
         }
       */
      $("#queryWrapper").show();
      $("#queryWrapper").html("<img width='100px' src='assets/images/loading.gif' /><span id='msg'>tunggu sebentar.. </span>");
      //esriRequest(queryurl, queryOptions).then(response => {
      

    									fieldInfos=[];
    									//fieldArray=[];    
    				           
    										//console.log(data.fields);
    										/*
    										data.fields.splice( $.inArray("OBJECTID",  data.fields), 1 );
    										
    										console.log($.inArray("OBJECTID_1",  data.fields));
    										if($.inArray("OBJECTID_1",  data.fields) >= 0 ){
    											field_identifier = "OBJECTID_1";
    											
    										}else{
    											if(alias == 'kehutanan_1' || alias == 'kehutanan_3' ){
    												fieldInfos.push({"fieldName":"OBJECTID_1"});
    												//fieldArray.push("OBJECTID_1");
    												field_identifier = "OBJECTID_1";
    											}else{
    				    							fieldInfos.push({"fieldName":"OBJECTID"});
    				    							//fieldArray.push("OBJECTID");
    				    							field_identifier = "OBJECTID";
    											}
    										}
    										

    										console.log(field_identifier);
    										*/
    										 //console.log("The response is: ", response);
    								          $("#queryWrapper").html("");
    								         // $("#queryWrapper").html(response);
    										  
    								          $("#queryWrapper").append('<div class="form-group">'
    								        		    +'<select multiple class="form-control" id="listFields"></select>'
    								        		    +'</div>');

    								          var obj = $.grep(listAllowedLihat, function(n){return n.alias_metadata === alias;})[0];
    											// console.log(obj);
    											 //var fields = obj.query_lihat.split("|");
											fields =  obj.query_lihat.split("|");
    											aliases = obj.field_alias_lihat.split("|");
								        		    
    										for (var field in fields) {
    											
    											fieldInfos.push({"fieldName":fields[field]});
    											//fieldArray.push(data.fields[field]);
    											$('#listFields').append('<option value="'+fields[field]+'">'+fields[field] + ' (' + aliases[field] +') </option>');
    										}
      
         
          //$('#daftarSimpul').empty();
          //console.log(response.data.fields);
          
		 // data.fields.forEach(function(o) {
			  	//console.log(o);
			   //$('#listFields').append('<option value="'+o.name+'">'+o.name + ' (' + o.alias +') </option>');
		  //});	
		  
          $("#queryWrapper").append('<div class="row p-1">'
				  + '<div class="col">'
    				  + '<div class="row p-1">'
    				  	+ '<div class="col">'
    				  		+ '<button id="equal" type="button" title="equal" class="btn btn-outline-primary btn-sm btn-block">=</button>'
    				  	+ '</div>'
    				  	+ '<div class="col">'
    			  			+ '<button id="notequal" type="button" title="notequal" class="btn btn-outline-primary btn-sm btn-block"><></button>'
    			  		+ '</div>'
    			  		+ '<div class="col">'
    			  			+ '<button id="like" type="button" title="like" class="btn btn-outline-primary btn-sm btn-block">Like</button>'
    			  		+ '</div>'
    				  + '</div>'
    				  + '<div class="row p-1">'
          				  	+ '<div class="col">'
          				  		+ '<button id="greater" type="button" title="greater" class="btn btn-outline-primary btn-sm btn-block">></button>'
          				  	+ '</div>'
          				  	+ '<div class="col">'
          			  			+ '<button id="greaterequal" type="button" title="greater equal" class="btn btn-outline-primary btn-sm btn-block">>=</button>'
          			  		+ '</div>'
          			  		+ '<div class="col">'
          			  			+ '<button id="and" type="button" title="And" class="btn btn-outline-primary btn-sm btn-block">And</button>'
          			  		+ '</div>'
      				  + '</div>'
          				+ '<div class="row p-1">'
            			  	+ '<div class="col">'
            			  		+ '<button id="less" type="button" title="less" class="btn btn-outline-primary btn-sm btn-block"><</button>'
            			  	+ '</div>'
            			  	+ '<div class="col">'
            		  			+ '<button id="lessequal" type="button" title="lessequal" class="btn btn-outline-primary btn-sm btn-block"><=</button>'
            		  		+ '</div>'
            		  		+ '<div class="col">'
            		  			+ '<button id="or" type="button" title="or" class="btn btn-outline-primary btn-sm btn-block">Or</button>'
            		  		+ '</div>'
        			  	+ '</div>'
				  	+ '</div>'
				  + '<div class="col"><select multiple class="form-control" id="listUniqueValue"></select>'
    		      + '<button id="getUniqueButton" type="button" title="Get Unique Value" class="btn btn-outline-primary btn-sm btn-block">Get Unique Values</button>'
    		      + '</div>'
                  +'</div>');  
          $("#queryWrapper").append('<p class="p-1">SELECT * FROM \''+ title +'\' WHERE </p>');
          $("#queryWrapper").append('<textarea class="form-control p-1" rows="4" id="whereClause"></textarea>');
          $("#queryWrapper").append('<div class="row p-1"><div class="col"><button id="clearQuery" type="button" title="Clear Query" class="btn btn-outline-primary btn-sm btn-block">Clear Query</button></div><div class="col"><button id="applyQuery" type="button" title="Apply Query" class="btn btn-outline-primary btn-sm btn-block">Apply Query</button></div></div>');
          //require(["https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"], function () {
		 function fillWhere(selected){
      	  if($('#whereClause').val() == '')
          	  $('#whereClause').val(selected);
      	  else
          	  $('#whereClause').val($('#whereClause').val() + " " + selected);
		 }
          $(document).ready(function () {
              $('#listFields').click(function(){
            	  $('#listUniqueValue').empty();
              });
              $('#listFields').dblclick(function(){
            	  //console.log();
            	  var selected = $("#listFields option:selected").val();
            	  fillWhere(selected);
            	  
              });

              $('#listUniqueValue').dblclick(function(){
            	  //console.log();
            	  var selected = $("#listUniqueValue option:selected").text().split('-')[0];
            	  fillWhere(selected);
            	  
              });

              $('#getUniqueButton').click(function(){
                  //alert('clear query');
            	  var selected = $("#listFields option:selected").val();
            	  
            	//console.log('populate');
                  //alert("calling attribute table for Layer " + e.target.layerid);
                  const featureLayer = new FeatureLayer({
    		                	  url: url + "/"+id});
                  var query = featureLayer.createQuery();
                  query.where = "1=1"; 
                  query.returnGeometry = false;
                  query.returnCountOnly = false
                  query.outFields = [ selected ];
                  query.returnDistinctValues= true;
                  query.orderByFields = selected;
                  
                 featureLayer.queryFeatures(query).then(function(results){
                      const domain = featureLayer.getFieldDomain(selected, {feature: results.features[0]});
                      //console.log("domain", domain);
                      
                      if(domain == null){
                    	  let queryurl = url + "/"+id+"/query";
                          
                          let queryOptions = {
                                 responseType: "json",
                                 query:  
                                 {
                                      f: "json",
                                      where:"1=1",
                                      returnGeometry: false,
                                      returnCountOnly: false,
                                      outFields: selected,
                                      returnDistinctValues: true,
                                      orderByFields: selected

                                 }
                            }
                          
                          esriRequest(queryurl, queryOptions).then(response => {
        					  //console.log(response);
        					  $('#listUniqueValue').empty();
        					  response.data.features.forEach(function(o) {
        						  	//console.log(o.attributes[selected]);
        						    $('#listUniqueValue').append('<option value="'+o.attributes[selected]+'">\''+o.attributes[selected]+'\'</option>');
        					  });	
                          });
                      }else{
                    	  $('#listUniqueValue').empty();
                    	  domain.codedValues.forEach(function(o) {
    						  	//console.log(o.attributes[selected]);
    						    $('#listUniqueValue').append('<option value="'+o.code+'">\''+o.code + "\'-("+ o.name +")"+'</option>');
    					  });
                      }
                  });
                      
              });

              $('#applyQuery').click(function(){
                  //alert('clear query');
            	  var where = $("#whereClause").val();

            	  if(where != ''){
            	//console.log('populate');
            	 const featureLayer = new FeatureLayer({
    		                	  url: url + "/"+id});
                  var query = featureLayer.createQuery();
                  query.where = where; 
                  query.returnGeometry = false;
                  query.returnCountOnly = false
                  query.outFields = [ "*" ]; //check sesuai akses
                  query.orderByFields = 'NAMOBJ';
                  
                 featureLayer.queryFeatures(query).then(function(results){
					//console.log(results);
					$("#queryWrapper").fadeOut();
					  $("#queryContent").fadeIn();
					  $("#queryContent").html('');
					  if(results.features.length > 0){
						  $("#queryContent").append('<div id="queryResult"></div>');
						  //console.log(response);
						  $("#queryResult").html('');
							  
						  $("#queryResult").append("<p class='p-3'>Found: " + results.features.length + " features</p>");
						  $("#queryResult").append('<div class="col"><select multiple class="form-control" id="listFeatures"></select>');
  					  results.features.forEach(function(o) {
  						   //console.log(o.attributes.NAMOBJ);
  						   //$("#queryResult").append(o);
  						    $('#listFeatures').append('<option value="'+o.attributes.NAMOBJ+'">'+o.attributes.NAMOBJ+'</option>');
  					  });
  					  $("#queryContent").append('<div class="row p-3"><label for="nameQueryLayer">Nama Layer</label><input class="form-control" type="text" placeholder="nama layer" id="nameQueryLayer" value="Query Result ('+title+')"></div>');
  					  $("#queryContent").append('<div class="row p-3"><button id="drawQuery" type="button" title="Draw Query" class="btn btn-outline-primary btn-sm btn-block">Draw Query Result to Map</button></div>');
  					  $('#drawQuery').click(function(){
  		                  //alert('clear query');
  		                  
  		                 // console.log($('#whereClause').val());
  		                 
  		               		/*
      	    	            fieldInfos=[];
    
        	    	  			forbidden_field =["Shape","Shape_Length", "Shape_Area","layerName"];
    
        	    	  			$.each(feature.attributes,function(key, val){
        	    	  				//console.log(key);
        	    	  				if(!forbidden_field.includes(key))
        	    	  					fieldInfos.push({"fieldName":key});
        	    	  			});
    						*/

    						   var obj = $.grep(listAllowedLihat, function(n){return n.alias_metadata === alias;})[0];
							// console.log(obj);
							 //var fields = obj.query_lihat.split("|");
						fields =  obj.query_lihat.split("|");
						
    			
    									fieldInfos=[];
    									//fieldArray=[];    
    										//console.log(data.fields);
    										/*
    										data.fields.splice( $.inArray("OBJECTID",  data.fields), 1 );
    										
    										console.log($.inArray("OBJECTID_1",  data.fields));
    										if($.inArray("OBJECTID_1",  data.fields) >= 0 ){
    											field_identifier = "OBJECTID_1";
    											
    										}else{
    											if(alias == 'kehutanan_1' || alias == 'kehutanan_3' ){
    												fieldInfos.push({"fieldName":"OBJECTID_1"});
    												//fieldArray.push("OBJECTID_1");
    												field_identifier = "OBJECTID_1";
    											}else{
    				    							fieldInfos.push({"fieldName":"OBJECTID"});
    				    							//fieldArray.push("OBJECTID");
    				    							field_identifier = "OBJECTID";
    											}
    										}
    										

    										console.log(field_identifier);
    										*/
    										for (var field in fields) {
    											fieldInfos.push({"fieldName":fields[field]});
    											//fieldArray.push(data.fields[field]);
    										}

    										  const layer = new FeatureLayer({
    				  		                	  // URL to the service
    				  		                	  title: $("#nameQueryLayer").val(),
    				  		                	  url: url + "/"+id,
    				  		                	  definitionExpression: $('#whereClause').val(),
    				  		                	  popupTemplate:{
    					    	                      // autocasts as new PopupTemplate()
    					    	                      //title: "{NAME}",
    					    	                      	title:  $("#nameQueryLayer").val(),
    					    	                          content: [
    					    	                        	    {
    					    	                        	        type: "fields",
    					    	                        	        fieldInfos: fieldInfos
    					    	                        	}
    						    	                    ]
    					    	  	                   // fieldInfos: fieldInfos,
    					    	  	                   //highlightEnabled: true
    					    	              		}
    				  		                	});

    				  		                	map.add(layer);
    				  		                	$('#layerList').show();
    				  		                	layer
    				  		                	  .when(function() {
    				  		                	    return layer.queryExtent();
    				  		                	  })
    				  		                	  .then(function(response) {
    				  		                	    view.goTo(response.extent);
    				  		                	  });
  		                
  		              
  		              }); 
      		              
                	  }else{
                		$("#queryContent").html("<p class='p-3'>Found: " + response.data.features.length + " feature</p>");
                	  }
					  $("#queryContent").append('<div class="row p-3"><button id="reQuery" type="button" title="reQuery" class="btn btn-outline-primary btn-sm btn-block">Query Ulang</button></div>');
					  $('#reQuery').click(function(){
		                  //alert('clear query');
		                  $("#queryContent").fadeOut();
						  $("#queryWrapper").fadeIn();
		              });
                 });
                  /*
                  let queryurl = url + "/"+id+"/query";
                 //alert("calling attribute table for Layer " + e.target.layerid);
                  let queryOptions = {
                         responseType: "json",
                         query:  
                         {
                              f: "json",
                              where:where,
                              returnGeometry: false,
                              returnCountOnly: false,
                              outFields: '*',
                              orderByFields: 'NAMOBJ'

                         }
                    }
                  esriRequest(queryurl, queryOptions).then(response => {
					  //console.log(response);
					  $("#queryWrapper").fadeOut();
					  $("#queryContent").fadeIn();
					  $("#queryContent").html('');
					  if(response.data.features.length > 0){
						  $("#queryContent").append('<div id="queryResult"></div>');
						  //console.log(response);
						  $("#queryResult").html('');
							  
						  $("#queryResult").append("<p class='p-3'>Found: " + response.data.features.length + " features</p>");
						  $("#queryResult").append('<div class="col"><select multiple class="form-control" id="listFeatures"></select>');
    					  response.data.features.forEach(function(o) {
    						   //console.log(o.attributes.NAMOBJ);
    						   //$("#queryResult").append(o);
    						    $('#listFeatures').append('<option value="'+o.attributes.NAMOBJ+'">'+o.attributes.NAMOBJ+'</option>');
    					  });
    					  $("#queryContent").append('<div class="row p-3"><label for="nameQueryLayer">Nama Layer</label><input class="form-control" type="text" placeholder="nama layer" id="nameQueryLayer" value="Query Result ('+title+')"></div>');
    					  $("#queryContent").append('<div class="row p-3"><button id="drawQuery" type="button" title="Draw Query" class="btn btn-outline-primary btn-sm btn-block">Draw Query Result to Map</button></div>');
    					  $('#drawQuery').click(function(){
    		                  //alert('clear query');
    		                  
    		                 // console.log($('#whereClause').val());

    		                  const layer = new FeatureLayer({
    		                	  // URL to the service
    		                	  title: $("#nameQueryLayer").val(),
    		                	  url: url + "/"+id,
    		                	  definitionExpression: $('#whereClause').val()
    		                	});

    		                	map.add(layer);
    		                	$('#layerList').show();
    		                	layer
    		                	  .when(function() {
    		                	    return layer.queryExtent();
    		                	  })
    		                	  .then(function(response) {
    		                	    view.goTo(response.extent);
    		                	  });
    		              
    		              }); 
        		              
                  	  }else{
                  		$("#queryContent").html("<p class='p-3'>Found: " + response.data.features.length + " feature</p>");
                  	  }
					  $("#queryContent").append('<div class="row p-3"><button id="reQuery" type="button" title="reQuery" class="btn btn-outline-primary btn-sm btn-block">Query Ulang</button></div>');
					  $('#reQuery').click(function(){
		                  //alert('clear query');
		                  $("#queryContent").fadeOut();
						  $("#queryWrapper").fadeIn();
		              });
	             }).catch((err) => {
              	    if (err.name === 'AbortError') {
            	        console.log('Request aborted');
            	      } else {
            	        alert('Error encountered : ', err.message);
            	      }
            	    });
          	    */
            	  }else{
					alert('Silahkan isi query terlebih dahulu..');
            	  }
              });
              $('#clearQuery').click(function(){
                  //alert('clear query');
                  $('#whereClause').val('');
              });
              $('#equal').click(function(){
      			 var selected = $(this).text();
            	 fillWhere(selected);
              });
              $('#notequal').click(function(){
       			 var selected = $(this).text();
             	 fillWhere(selected);
               });
              $('#like').click(function(){
       			 var selected = $(this).text();
             	 fillWhere(selected);
               });
              $('#greater').click(function(){
       			 var selected = $(this).text();
             	 fillWhere(selected);
               });
              $('#greaterequal').click(function(){
       			 var selected = $(this).text();
             	 fillWhere(selected);
               });
              $('#and').click(function(){
       			 var selected = $(this).text();
             	 fillWhere(selected);
               });

              $('#less').click(function(){
       			 var selected = $(this).text();
             	 fillWhere(selected);
               });
              $('#lessequal').click(function(){
       			 var selected = $(this).text();
             	 fillWhere(selected);
               });

              $('#or').click(function(){
        			 var selected = $(this).text();
              	 fillWhere(selected);
                });

		   });
    
   }
  

   /*
   function zoomToLayer(layer) {
       return layer.queryExtent().then(function(response) {
         view.goTo(response.extent);
       });
   }*/
   
   $(function () {
		$(".progress").fadeOut();
		
	    setup_variable();
						
	});

	 
});

 </script>
</body>
</html>
