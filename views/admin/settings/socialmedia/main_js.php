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


$(document).ready(function() {
	var map;
	var thisLayer;
	var proj_4326 = new OpenLayers.Projection('EPSG:4326');
	var proj_900913 = new OpenLayers.Projection('EPSG:900913');
	var markers;

	var latitude_field = $(document.getElementById("latitude"));
	var longitude_field = $(document.getElementById("longitude"));
	var radius_field = $(document.getElementById("radius"));
	var circle = null;
	var vectorLayer = new OpenLayers.Layer.Vector("Circle Layer");

	var draw_circle = function() {
		vectorLayer.removeAllFeatures();
		var radius_value = radius_field.val();
		
		if (radius_value != "")
		{

			var point = new OpenLayers.Geometry.Point(longitude_field.val(), latitude_field.val());
			point.transform(
				proj_4326,
				map.getProjectionObject()
			);

			var radius_circle = OpenLayers.Geometry.Polygon.createRegularPolygon(
				point,
				radius_value  * 1000, //using km
				100,
				0
			);

			var circleStyle = {
				strokeColor: "#00ff00",
				fillColor: "#00ff00",
				fillOpacity: 0.5,
				strokeWidth: 3,
				strokeDashstyle: "solid",
			};

			circle = new OpenLayers.Feature.Vector(radius_circle, null, circleStyle);
			vectorLayer.addFeatures([circle]);

			if (radius_value == 10) {
				map.setCenter(point, 11);
			} else if (radius_value <= 20) {
				map.setCenter(point, 10);
			} else if (radius_value <= 40) {
				map.setCenter(point, 9);
			} else if (radius_value <= 80) {
				map.setCenter(point, 8);
			} else if (radius_value <= 100) {
				map.setCenter(point, 7);
			} else if (radius_value <= 200) {
				map.setCenter(point, 6);
			} else if (radius_value <= 600) {
				map.setCenter(point, 5);
			} else {
				map.setCenter(point, 4);
			}
		}
	}

	function showMap()
	{
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
		} else {
			latitude = "<?php echo $latitude; ?>";
			longitude = "<?php echo $longitude; ?>";
		}
		var myPoint = new OpenLayers.LonLat(longitude, latitude);
		myPoint.transform(proj_4326, map.getProjectionObject());

		// create a marker positioned at a lon/lat
		var marker = new OpenLayers.Marker(myPoint);
		markers.addMarker(marker);

		// display the map centered on a latitude and longitude (Google zoom levels)
		map.setCenter(myPoint, <?php echo $default_zoom; ?>);

		map.addLayer(vectorLayer);

		// Detect Map Clicks
		map.events.register("click", map, function(e){
			var lonlat = map.getLonLatFromViewPortPx(e.xy);
			var lonlat2 = map.getLonLatFromViewPortPx(e.xy);
			m = new OpenLayers.Marker(lonlat);
			markers.clearMarkers();
			markers.addMarker(m);

			lonlat2.transform(proj_900913,proj_4326);
			// Update form values (jQuery)
			latitude_field.val(lonlat2.lat);
			longitude_field.val(lonlat2.lon);

			draw_circle();
		});

		radius_field.change(draw_circle);
		draw_circle();
	}

	showMap();
});


function socialMediaSettingsAction(action, confirmAction)
{
        $("#action").attr("value", action);
        $("#SocialMediaSettings").submit();
}
