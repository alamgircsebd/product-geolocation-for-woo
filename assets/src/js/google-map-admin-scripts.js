(function($) {
    if ( ! $( '#wc_product_geolocation_admin_default_address' ).length ) {
        return;
    }

    var gmap, marker, address, geocoder;

    function initWPR_ADMIN_Map() {
        var lat        = $( '.wp_wpg_geolocation_geo_latitude-text' ).val(),
            lng        = $( '.wp_wpg_geolocation_geo_longitude-text' ).val(),
            zoom_label = parseInt( $( '.wp_wpg_geolocation_geo_zoom_label-number' ).val() ),
            map_area   = $( '#wc_product_geolocation_admin_default_address' );

        address = $( '.google_map_default_address-text' );

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

        var autocomplete = new google.maps.places.Autocomplete( address.get(0) );

        autocomplete.addListener( 'place_changed', function () {
            var place = autocomplete.getPlace(),
                location = place.geometry.location;

            updateMap( location.lat(), location.lng(), place.formatted_address );
        } );

        gmap.addListener( 'click', function ( e ) {
            updateMap( e.latLng.lat(), e.latLng.lng() );
        });

        marker.addListener( 'dragend', function ( e ) {
            updateMap( e.latLng.lat(), e.latLng.lng() );
        } );
    }

    function updateMap( lat, lng, formatted_address ) {
        $('.wp_wpg_geolocation_geo_latitude-text').val( lat ),
        $('.wp_wpg_geolocation_geo_longitude-text').val( lng );

        var curpoint = new google.maps.LatLng( lat, lng )

        gmap.setCenter( curpoint );
        marker.setPosition( curpoint );

        if ( ! formatted_address ) {
            geocoder.geocode( {
                location: {
                    lat: lat,
                    lng: lng
                }
            }, function ( results, status ) {
                if ( 'OK' === status ) {
                    address.val( results[0].formatted_address );
                }
            } )
        }
    }

    initWPR_ADMIN_Map();
})(jQuery);
