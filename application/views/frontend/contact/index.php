 <!-- Start Map -->
 <div>
  <div class="mapouter"><div class="gmap_canvas"><iframe width=100% height="400" id="gmap_canvas" src="https://maps.google.com/maps?q=faculty%20forestry%20bogor&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.mahjong-play.com"></a></div><style>.mapouter{position:relative;text-align:right;height:500px;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width: 100%;}</style></div>
</div>
<!-- End Map -->

<!-- Start Content -->
<div id="content">
  <div class="container">

    <div class="row">

      <div class="col-md-8">

        <!-- Classic Heading -->
        <h4 class="classic-title"><span>Contact Us</span></h4>

        <!-- Start Contact Form -->
        <form role="form" id="contactForm" data-toggle="validator" class="shake">
          <div class="form-group">
            <div class="controls">
              <input type="text" id="name" placeholder="Name" required data-error="Please enter your name">
              <div class="help-block with-errors"></div>
            </div>
          </div>
          <div class="form-group">
            <div class="controls">
              <input type="email" class="email" id="email" placeholder="Email" required data-error="Please enter your email">
              <div class="help-block with-errors"></div>
            </div>
          </div>
          <div class="form-group">
            <div class="controls">
              <input type="text" id="msg_subject" placeholder="Subject" required data-error="Please enter your message subject">
              <div class="help-block with-errors"></div>
            </div>
          </div>
          <div class="form-group">
            <div class="controls">
              <textarea id="message" rows="7" placeholder="Massage" required data-error="Write your message"></textarea>
              <div class="help-block with-errors"></div>
            </div>  
          </div>

          <button type="submit" id="submit" class="btn-system btn-large">Send</button>
          <div id="msgSubmit" class="h3 text-center hidden"></div> 
          <div class="clearfix"></div>   

        </form>     
        <!-- End Contact Form -->

      </div>

      <div class="col-md-4">

        <!-- Classic Heading -->
        <h4 class="classic-title"><span>Information</span></h4>

        <!-- Some Info -->
        <p>Departemen KSHE Fakultas Kehutanan IPB</p>

        <!-- Divider -->
        <div class="hr1" style="margin-bottom:10px;"></div>

        <!-- Info - Icons List -->
        <ul class="icons-list">
          <li><i class="fa fa-globe">  </i> <strong>Address:</strong> Jl. Ulin Lingkar Akademik, Bogor – West Java - Indonesia</li>
          <li><i class="fa fa-envelope-o"></i> <strong>Email:</strong> ecosystem@apps.ipb.ac.id</li>          
        </ul>

        <!-- Divider -->
        <div class="hr1" style="margin-bottom:15px;"></div>

        <!-- Classic Heading -->
        <h4 class="classic-title"><span>Working Hours</span></h4>

        <!-- Info - List -->
        <ul class="list-unstyled">
          <li><strong>Monday - Friday</strong> - 9am to 5pm</li>
          <li><strong>Saturday</strong> - 9am to 2pm</li>
          <li><strong>Sunday</strong> - Closed</li>
        </ul>

      </div>

    </div>

  </div>
</div>
<!-- End content -->
<script type="text/javascript" src="assets/frontend/js/script.js"></script>
<script type="text/javascript" src="assets/frontend/js/form-validator.min.js"></script>  
<script type="text/javascript" src="assets/frontend/js/contact-form-script.js"></script>
<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.expsensor=false">
</script>
<!-- Google Maps JS Only for Contact Pages -->
<script type="text/javascript">
  var map;
  var plain = new google.maps.LatLng(-6.5573771, 106.7285332);
  var mapCoordinates = new google.maps.LatLng(-6.5573771, 106.7285332);


  var markers = [];
  var image = new google.maps.MarkerImage(
    'assets/frontend/images/map-marker.png',
    new google.maps.Size(84, 70),
    new google.maps.Point(0, 0),
    new google.maps.Point(60, 60)
    );

  function addMarker() {
    markers.push(new google.maps.Marker({
      position: plain,
      raiseOnDrag: false,
      icon: image,
      map: map,
      draggable: false
    }
    ));

  }

  function initialize() {
    var mapOptions = {
      backgroundColor: "#ffffff",
      zoom: 15,
      disableDefaultUI: true,
      center: mapCoordinates,
      zoomControl: false,
      scaleControl: false,
      scrollwheel: false,
      disableDoubleClickZoom: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      styles: [{
        "featureType": "landscape.natural",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#ffffff"
        }
        ]
      }
      , {
       "featureType": "landscape.man_made",
       "stylers": [{
         "color": "#ffffff"
       }
       , {
         "visibility": "off"
       }
       ]
     }
     , {
       "featureType": "water",
       "stylers": [{
         "color": "#80C8E5"
       }
       , {
         "saturation": 0
       }
       ]
     }
     , {
       "featureType": "road.arterial",
       "elementType": "geometry",
       "stylers": [{
         "color": "#999999"
       }
       ]
     }
     , {
       "elementType": "labels.text.stroke",
       "stylers": [{
         "visibility": "off"
       }
       ]
     }
     , {
       "elementType": "labels.text",
       "stylers": [{
         "color": "#333333"
       }
       ]
     }

     , {
       "featureType": "road.local",
       "stylers": [{
         "color": "#dedede"
       }
       ]
     }
     , {
       "featureType": "road.local",
       "elementType": "labels.text",
       "stylers": [{
         "color": "#666666"
       }
       ]
     }
     , {
       "featureType": "transit.station.bus",
       "stylers": [{
         "saturation": -57
       }
       ]
     }
     , {
       "featureType": "road.highway",
       "elementType": "labels.icon",
       "stylers": [{
         "visibility": "off"
       }
       ]
     }
     , {
       "featureType": "poi",
       "stylers": [{
         "visibility": "off"
       }
       ]
     }

     ]

   }
   ;
   map = new google.maps.Map(document.getElementById('google-map'), mapOptions);
   addMarker();

 }
 google.maps.event.addDomListener(window, 'load', initialize);
</script>
