<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Api extends CI_Controller {
    
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */    
    
    function __construct(){
        parent::__construct();
       // $this->load->model('service_model');
        //$this->load->model('jign_model');        
    }
    
    
    
    public function cekService(){
        $Obj = (object)[];
        $Obj->currentVersion = 10.6;
        $Obj->folders = array("Bogor", "CITRA_SATELIT", "IGD");
        $Obj->services = array(["name"=>"intersectModel", "type" => "GPServer"],["name"=>"sampleWorldCities", "type" => "MapServer"]); 
        echo json_encode($Obj);
    }
    
    public function testService(){
        $Obj = ['currentVersion' => 10.6, 'folders' => array("Bogor", "CITRA_SATELIT", "IGD"), 'services' => array(["name"=>"intersectModel", "type" => "GPServer"],["name"=>"sampleWorldCities", "type" => "MapServer"])];
        echo json_encode($Obj);
    }
    
    
    public function listLayer(){
           //$Obj = $this->service_model->get_service_api();
            //var_dump($obj);
			/*
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
	 *
];
*/
		   $Obj = (object)[];
		   $Obj = [
					array('id' => 0,  'logo' => 'forest_off.png', 'name' => 'Forest', 'subheader' => true),
					array('id' => 1,  'logo' => 'OilPalm_off.png', 'name' => 'Oil Palm', 'subheader' => false),
					array('id' => 2,  'logo' => 'paddy_off.png', 'name' => 'Paddy', 'subheader' => false),
					array('id' => 3,  'logo' => 'rubber_off.png', 'name' => 'Rubber', 'subheader' => false),
					array('id' => 4,  'logo' => 'kopi_off.png', 'name' => 'Coffee', 'subheader' => false),
					array('id' => 5,  'logo' => 'cocoa_off.png', 'name' => 'Cocoa', 'subheader' => false),
					array('id' => 6,  'logo' => 'warning_off.png', 'name' => 'Early Warning', 'subheader' => false)
				  ];
		   
           echo json_encode($Obj);
        
    }
	
	public function listJIGN()
	{
		/*
		 var listSimpulArray = [
	  { id: 0, name: 'Badan Informasi Geospasial', tipe:0, server:0, url:'http://portal.ina-sdi.or.id/arcgis/rest/services'},
	  { id: 1, name: 'Badan Meteorologi, Klimatologi, dan Geofisika', tipe:0, server:0, url:'http://gis.bmkg.go.id/arcgis/rest/services'},
	  { id: 2, name: 'Badan Nasional Penanggulangan Bencana', tipe:0, server:0, url:'http://geoservice.bnpb.go.id:6080/arcgis/rest/services/inaRISK'},
	  { id: 3, name: 'Kementerian Koordinator Bidang Perekonomian', tipe:0, server:1, url:'http://geoportal.satupeta.go.id:8080/geoserver/wms'},
	  { id: 4, name: 'Kementerian Lingkungan Hidup dan Lingkungan (KLHK)', tipe:0, server:0, url:'http://geoportal.menlhk.go.id/arcgis/rest/services'},
	  { id: 5, name: 'Provinsi Aceh', tipe:1, server:0, url:'http://gisportal.acehprov.go.id:6080/arcgis/rest/services'},
	  { id: 6, name: 'Provinsi Sumatera Barat', tipe:1, server:1, url:'http://sumbarprov.ina-sdi.or.id:8080/geoserver/wms'}	  
 ];
 */
		  $Obj = (object)[];
		   $Obj = [
					array('id' => 0, 'name' => 'Badan Informasi Geospasial', 'tipe' => 0, 'server' => 0, 'url' => 'http://portal.ina-sdi.or.id/arcgis/rest/services'),
					array('id' => 1, 'name' => 'Badan Meteorologi, Klimatologi, dan Geofisika', 'tipe' => 0, 'server' => 0, 'url' => 'http://gis.bmkg.go.id/arcgis/rest/services'),
					array('id' => 2, 'name' => 'Badan Nasional Penanggulangan Bencana', 'tipe' => 0, 'server' => 0, 'url' => 'http://service1.inarisk.bnpb.go.id:6080/arcgis/rest/services'),
					array('id' => 3, 'name' => 'Kementerian Koordinator Bidang Perekonomian', 'tipe' => 0, 'server' => 1, 'url' => 'http://geoportal.satupeta.go.id:8080/geoserver/wms'),
					array('id' => 4, 'name' => 'Kementerian Lingkungan Hidup dan Kehutanan (KLHK)', 'tipe' => 0, 'server' => 0, 'url' => 'http://geoportal.menlhk.go.id/arcgis/rest/services'),
					array('id' => 5, 'name' => 'Provinsi Aceh', 'tipe' => 1, 'server' => 0, 'url' => 'http://gisportal.acehprov.go.id:6080/arcgis/rest/services'),
					array('id' => 6, 'name' => 'Provinsi Sumatera Barat', 'tipe' => 1, 'server' => 1, 'url' => 'http://sumbarprov.ina-sdi.or.id:8080/geoserver/wms'),
					array('id' => 7, 'name' => 'Kementrian Pertanian', 'tipe' => 0, 'server' => 0, 'url' => 'http://sig.pertanian.go.id/ArcGIS/rest/services')
					
				  ];
		   
           echo json_encode($Obj);
	}
	
	public function arcgis(){
       
            header('Content-Type: application/json');
            $protocol= $this->input->post("protocol");
            $url= $this->input->post("url");
            $protourl = $protocol."//".$url;
            //$protourl = "http://portal.ina-sdi.or.id/arcgis/rest/services?f=pjson";
            $ch = curl_init();
            $header = array("Accept: application/json");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
          
            
            //curl_setopt($ch, CURLOPT_ENCODING, "gzip");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_URL, $protourl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
            
            $obj = json_decode(curl_exec($ch));
            //print_r($obj);
            echo json_encode($obj);
            curl_close($ch);
        
    }
   
    
    public function geoserver(){
        
            header('Content-Type: application/xml');
            $protocol= $this->input->post("protocol");
            $url= $this->input->post("url");
            $protourl = $protocol."//".$url;
            //$protourl = "http://portal.ina-sdi.or.id/arcgis/rest/services?f=pjson";
            $ch = curl_init();
            $header = array("Accept: application/xml");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
           
            //curl_setopt($ch, CURLOPT_ENCODING, "gzip");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_URL, $protourl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
            
            echo curl_exec($ch);
            //$obj = json_decode(curl_exec($ch));
            //print_r($obj);
            //echo json_encode($obj);
            curl_close($ch);
        
    }
	
	public function bypass($protocol, $url, $export=''){
        //echo $protocol. " " . $url;
        //echo "<br />";
        //current_url();
       

       if(!empty($export))
           $url = $url ."XXX". $export;
        $url = str_replace("XXX", "/", $url);
        //die();
        $protourl = $protocol."//".$url;
        //$protourl = "http://portal.ina-sdi.or.id/arcgis/rest/services?f=pjson";
        $query =  $_SERVER['QUERY_STRING'];
        //echo "<br />";
        //die($protourl . "?" . $query);
        $ch = curl_init();
        //$header = array("Accept: application/xml");
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        //curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_URL, $protourl . "?" . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
        
        if(strpos($url,"/export"))
            header ('Content-Type: image/png');
        echo curl_exec($ch);
        //$obj = json_decode(curl_exec($ch));
        //print_r($obj);
        //echo json_encode($obj);
        curl_close($ch);
        
    }
    
    
}
    