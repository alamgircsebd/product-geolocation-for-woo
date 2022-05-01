(function($) {
    if ( ! $( '#product_geolocation_for_woo_render_gmap' ).length ) {
        return;
    }

    var gmap, marker, geocoder;

    function initWPR_Product_Map() {
        var lat        = $( '.wp_wpg_geolocation_geo_latitude' ).val(),
            lng        = $( '.wp_wpg_geolocation_geo_longitude' ).val(),
            zoom_label = parseInt( $( '.wp_wpg_geolocation_geo_zoom_label' ).val() ),
            map_area   = $( '#product_geolocation_for_woo_render_gmap' );

        var curpoint = new google.maps.LatLng( lat, lng );

        gmap = new google.maps.Map( map_area.get(0), {
            center: curpoint,
            zoom: zoom_label ? zoom_label : 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        marker = new google.maps.Marker( {
            position: curpoint,
            map: gmap,
            draggable: true
        } );

        geocoder = new google.maps.Geocoder;
    }

    initWPR_Product_Map();
})(jQuery);
