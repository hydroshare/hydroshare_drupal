var map;

function hydroshareMakeMap(wms, layer, style) {
    map = new OpenLayers.Map('map', {
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
}
