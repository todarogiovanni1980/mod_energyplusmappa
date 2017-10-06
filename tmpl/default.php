<?php
/**
 * @version     1.2.6
 * @package     com_energyplusmgm
 * @subpackage  mod_energyplusmgmmappa
 * @copyright   Copyright (C) 2014. Tutti i diritti riservati.
 * @license     GNU General Public License versione 2 o successiva; vedi LICENSE.txt
 * @author      Todaro Giovanni <giovanni.todaro@itd.cnr.it> - http://www.pa.itd.cnr.it
 */
defined('_JEXEC') or die;
$paramfontedati = $params->get('fontedati', '');
if (!$paramfontedati) {
	$paramfontedati .= JURI::base() ;
} 

$paramfontedati .= "/index.php?option=com_energyplusmgm&view=anagraficacentridicosto&format=xml&show=1&mapcluster=1";

$paramstazionimeteo = $params->get('stazionimeteo', 0);
if ($paramstazionimeteo) {
	$mostracentricosto = "if (dataPhoto.idStazioneMeteo) markers.push(marker);";
} else {
	$mostracentricosto  = "markers.push(marker);";
}
$paramcluster = $params->get('cluster', 50);
  
?>



<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

<!--<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB5JnWYD-lbEjOo8GVMxbvorkfI7rhgRac&sensor=false&extension=.js'></script> -->

<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDo8zjzl5VAYkIPixQi-4LxBJrU9sGR3Rw&sensor=false&extension=.js'></script>

<script type='text/javascript' src='http://energyplusmgm.pa.itd.cnr.it/libraries/js-marker-clusterer/markerclusterer_compiled.js'></script>

<script src='<?php echo $paramfontedati;?>'></script>

<script> 
    google.maps.event.addDomListener(window, 'load', init);
    var map;
    function init() {
        var myLatLng = {lat: 41.908614, lng: 12.485720};
		
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 6,
			center: myLatLng,
			
			mapTypeId: google.maps.MapTypeId.TERRAIN 
		});
		
		var markers = [];
        for (var i = 0; i < data.count; i++) {
			var dataPhoto = data.centricosto[i];
			var latLng = new google.maps.LatLng(dataPhoto.latitudine,
			  dataPhoto.longitudine);
			  
			var contentString = '<div id="content">'+
			  '<div id="siteNotice">'+
			  '</div>'+
			  '<h1 id="firstHeading" class="firstHeading">'+ dataPhoto.nome +'</h1>'+
			  '<hr>'+
			  '<div id="bodyContent">'+
			  
			  '<p>Indirizzo: '+ dataPhoto.indirizzo +'.</p>'+
			   
			  '<p><img src="http://energyplusmgm.pa.itd.cnr.it/images/logoconsumielettrici.png" alt="logoconsumielettrici" style="width: 32px; vertical-align: middle;" >Consumi Elettrici: '+ dataPhoto.consumielettrici +' kWh/anno.</p>'+
			  '<p><img src="http://energyplusmgm.pa.itd.cnr.it/images/logoconsumitotali.png" alt="logoconsumitotali" style="width: 32px; vertical-align: middle;" >Consumi Totali: '+ dataPhoto.consumitotali +' Tep/anno.</p>';
			
			link = 'http://energyplusmgm.pa.itd.cnr.it/index.php?option=com_energyplusmgm&view=stazionemeteo&id='+ dataPhoto.idStazioneMeteo ;
			if (dataPhoto.link) link = dataPhoto.link;
			
			if (dataPhoto.idStazioneMeteo) contentString += '<a target=blank href="'+link+'"><img src="http://energyplusmgm.pa.itd.cnr.it/images/logostazionemeteo.png" alt="logostazionemeteo" style="width: 32px; vertical-align: middle;" >Stazione Meteo</a> .</p>';
			
			contentString += '</div></div>';
			
			var iconaStazioneMeteo = 'http://energyplusmgm.pa.itd.cnr.it/images/SEGNAPOSTO%20SEDE%20CNR%20CON%20METEO.png';
			var iconaCentroCosto = 'http://energyplusmgm.pa.itd.cnr.it/images/SEGNAPOSTO%20SEDE%20CNR.png';		  
			if (dataPhoto.idStazioneMeteo) {
			  var marker = new google.maps.Marker({
			    position: latLng,
			    title: dataPhoto.nome,
			    icon: iconaStazioneMeteo
			  });
			} else {
			  var marker = new google.maps.Marker({
			    position: latLng,
			    title: dataPhoto.nome,
			    icon: iconaCentroCosto
			  });
			}
          
			var prev_infowindow =false;
           	var infowindow = new google.maps.InfoWindow()
			google.maps.event.addListener(marker,'click', (function(marker,contentString,infowindow){ 
			    return function() {
				    
					if( prev_infowindow ) {
						prev_infowindow.close();
					}					
					prev_infowindow = infowindow;
					
			       infowindow.setContent(contentString);
			       infowindow.open(map,marker);
			    };
			})(marker,contentString,infowindow)); 
		  
          <?php echo $mostracentricosto; ?>
        }
        
        
		var styles = [{
	        url: 'https://raw.githubusercontent.com/googlemaps/js-marker-clusterer/gh-pages/images/m1.png',
	        width: 53,
	        height: 53,
	        textColor: '#ffffff'
	      }, {
	        url: 'https://raw.githubusercontent.com/googlemaps/js-marker-clusterer/gh-pages/images/m1.png',
	        width: 53,
	        height: 53,
	        textColor: '#ffffff'
	      }, {
	        url: 'https://raw.githubusercontent.com/googlemaps/js-marker-clusterer/gh-pages/images/m1.png',
	        width: 53,
	        height: 53,
	        textColor: '#ffffff'
	      }, {
	        url: 'https://raw.githubusercontent.com/googlemaps/js-marker-clusterer/gh-pages/images/m1.png',
	        width: 78,
	        height: 78,
	        textColor: '#ffffff'
	      }, {
	        url: 'https://raw.githubusercontent.com/googlemaps/js-marker-clusterer/gh-pages/images/m1.png',
	        width: 90,
	        height: 90,
	        textColor: '#ffffff'
	    }];
      
		//set style options for marker clusters (these are the default styles)
		var mcOptions = {gridSize: <?php echo $paramcluster; ?>,  maxZoom: 15, styles: styles};
		var markerCluster = new MarkerClusterer(map, markers,mcOptions);
	}
</script>

<style>
    #mappa {
        height:400px;
        width:100%;
    }
    
    .gm-style-iw h4, .gm-style-iw p {
        margin: 0;
        padding: 0;
    }
    .gm-style-iw a {
        color: #4272db;
    }
    
    .gm-style-mtc {
	 // display: none;
	}
</style>

<style >
      
      #map-container {
        padding: 6px;
        border-width: 1px;
        border-style: solid;
        border-color: #ccc #ccc #999 #ccc;
        -webkit-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
        -moz-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
        box-shadow: rgba(64, 64, 64, 0.1) 0 2px 5px;
        width: 990px;
      }
      #map {
        width: 990px;
        height: 626px;
      }
    </style>

<div id="map-container"><div id="map"></div></div>