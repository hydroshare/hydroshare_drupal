var map;

function hydroshare_viz_script_makemap(wms, layer, style) {
    map = new OpenLayers.Map('hydroshare_vizualization', {
        projection: 'EPSG:3857',
        layers: [
            new OpenLayers.Layer.Google(
                "Google Physical",
                {type: google.maps.MapTypeId.TERRAIN}
            ),
            new OpenLayers.Layer.Google(
                "Google Streets", // the default
                {numZoomLevels: 20}
            ),
            new OpenLayers.Layer.Google(
                "Google Hybrid",
                {type: google.maps.MapTypeId.HYBRID, numZoomLevels: 20}
            ),
            new OpenLayers.Layer.Google(
                "Google Satellite",
                {type: google.maps.MapTypeId.SATELLITE, numZoomLevels: 22}
            )
        ],
        center: new OpenLayers.LonLat(-101.2, 39.9).transform('EPSG:4326', 'EPSG:3857'),
        zoom:4 
    });
    map.addControl(new OpenLayers.Control.LayerSwitcher());
    var svc = new OpenLayers.Layer.WMS(wms, wms, {isBaseLayer:false, transparent:true, layers:[layer], styles:[style]});            
    map.addLayers([svc]);
    
    var url = 'http://ga.renci.org/ga_resources/extent/' + layer + "?srid=3857&callback=?";
    var extent = null;
    $.ajax({
        type: 'GET',
        url: url,
        async: false,
        jsonpCallback: 'jsonCallback',
        contentType: "application/json",
        dataType: 'jsonp', 
        success: function(json) {
           extent = json;
        },
        error: function(e) {
           console.log(e.message);
        }
    });
    map.zoomToExtent(extent);
}
