/**
 * JavaScript for the socialmedia settings page
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://github.com/ushahidi/Ushahidi_Web
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
	function showMap()
	{
	
		var map;
		var thisLayer;
		var proj_4326 = new OpenLayers.Projection('EPSG:4326');
		var proj_900913 = new OpenLayers.Projection('EPSG:900913');
		var markers;

		var latitude_field = $(document.getElementById("latitude"));
		var longitude_field = $(document.getElementById("longitude"));

		document.getElementById("socialmedia-map").innerHtml = '';

		if (markers) {
			markers.destroy();
			markers = null;
		}

		// Now initialise the map
		var options = {
			units: "km",
			numZoomLevels: 9,
			controls:[],
			projection: proj_900913,
			'displayProjection': proj_4326,
			maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34),
			maxResolution: 156543.0339
		};

		map = new OpenLayers.Map('socialmedia-map', options);

		<?php echo map::layers_js(FALSE); ?>
		map.addLayers(<?php echo map::layers_array(FALSE); ?>);

		map.addControl(new OpenLayers.Control.Navigation());
		map.addControl(new OpenLayers.Control.Zoom());
		map.addControl(new OpenLayers.Control.MousePosition({
			formatOutput: Ushahidi.convertLongLat
		}));
		map.addControl(new OpenLayers.Control.LayerSwitcher());

		// Create the markers layer
		markers = new OpenLayers.Layer.Markers("Markers");
		map.addLayer(markers);

		// create a lat/lon object
		var latitude, longitude;
		if (latitude_field.val() != "" && longitude_field.val() != "") {
			latitude = latitude_field.val();
			longitude = longitude_field.val();
		}
		var myPoint = new OpenLayers.LonLat(longitude, latitude);
		myPoint.transform(proj_4326, map.getProjectionObject());

		// create a marker positioned at a lon/lat
		var marker = new OpenLayers.Marker(myPoint);
		markers.addMarker(marker);

		// display the map centered on a latitude and longitude (Google zoom levels)
		map.setCenter(myPoint, <?php echo $default_zoom; ?>);

		map.addLayer(vectorLayer);

		radius_field.change(draw_circle);
	}

$(document).ready(showMap);