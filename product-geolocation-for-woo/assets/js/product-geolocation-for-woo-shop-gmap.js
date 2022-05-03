( function ( $ ) {
    initWPR_Shop_Product_Map = {
        map: null,
        markers: [],
        marker_clusterer: null,
        info_window: null,

        init: function () {
            var self = this;

            var map_area = $( '#product_geolocation_for_woo_render_gmap' );

            self.map = new google.maps.Map( map_area.get(0), {
                zoom: parseInt( $( '.wp_wpg_geolocation_geo_zoom_label' ).val() ),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            self.info_window = new google.maps.InfoWindow();
            self.setMarkers();

            self.map.addListener( 'clusterclick', function (cluster) {
                var bounds  = cluster.getBounds(),
                    markers = cluster.getMarkers();

                var bounds_props = Object.keys( bounds ),
                    bound_1st_prop_props = Object.keys( bounds[ bounds_props[0] ] ),
                    f = bounds[ bounds_props[0] ][ bound_1st_prop_props[0] ],
                    b = bounds[ bounds_props[0] ][ bound_1st_prop_props[1] ];

                if ( f === b ) {
                    var html = '<div class="wpr-wpg-gmap-info-windows-in-popup">';

                    markers.forEach( function ( marker ) {
                        html += self.getInfoWindowContent(marker.info);
                    } );

                    html += '</div>';

                    $.magnificPopup.open({
                        items: {
                            type: 'inline',
                            src: html
                        }
                    });
                }
            } );
        },

        setMarkers: function () {
            var items = $( '[name="wpr_wpg_geolocation[]"]' );

            if ( ! items.length ) {
                var search = window.location.search,
                    latitude = $( '.wp_wpg_geolocation_geo_latitude' ).val(),
                    longitude = $( '.wp_wpg_geolocation_geo_longitude' ).val(),
                    queries = search.replace( '?', '' ).split( '&' ),
                    i = 0;

                if ( queries.length ) {
                    var query = '',
                        param = '',
                        value = '';

                    for ( i = 0; i < queries.length; i++ ) {
                        query = queries[i].split( '=' );

                        param = query[0].toLowerCase();
                        value = query[1];

                        if ( 'latitude' === param ) {
                            latitude = value;
                        } else if ( 'longitude' === param ) {
                            longitude = value;
                        }
                    }
                }

                this.map.setCenter(
                    new google.maps.LatLng( latitude, longitude )
                );

                return;
            }

            var self = this,
                bound = new google.maps.LatLngBounds();

            var marker_icon = {
                url: WPR_WPG_LOCALIZE.wpr_wpg_gmap_icon,
                scaledSize: new google.maps.Size(32, 32)
            };

            if ( self.marker_clusterer ) {
                self.marker_clusterer.clearMarkers();
            }

            self.markers = [];

            items.each( function () {
                var id = $( this ).val(),
                    latitude = $( this ).data( 'latitude' ),
                    longitude = $( this ).data( 'longitude' ),
                    info = $( this ).data( 'info' );

                var curpoint = new google.maps.LatLng( latitude, longitude );

                bound.extend( curpoint );

                var marker_options = {
                    position: curpoint,
                    map: self.map,
                    info: info
                };

                marker_options.icon = marker_icon;

                var marker = new google.maps.Marker( marker_options );

                marker.addListener( 'click', function () {
                    if ( ! info ) {
                        return;
                    }

                    var info_window_content = self.getInfoWindowContent( info );

                    self.info_window.setContent( info_window_content );
                    self.info_window.open( self.map, marker );
                    self.map.panTo( curpoint );
                } );

                self.markers.push(marker);
            } );

            self.map.setCenter( bound.getCenter() );
            self.map.fitBounds(bound);

            var i = 0, styles = [];

            for ( i = 0; i < 5; i++ ) {
                styles.push( {
                    url: WPR_WPG_LOCALIZE.wpr_wpg_gmap_cluster_icon,
                    height: 40,
                    width: 40,
                    textColor: '#fddace',
                    textSize: 13,
                    backgroundSize: '40px'
                } );
            }

            self.marker_clusterer = new MarkerClusterer( self.map, self.markers, {
                gridSize: 40,
                styles: styles
            } );
        },

        getInfoWindowContent: function ( info ) {
            var content = '<div class="wpr-wpg-gmap-info-window"><div class="wp-wpg-geolocation-clearfix"><div class="wpr-wpg-gmap-info-window-title"> <h3 class="info-title"> <a href="{link}">{title}</a> </h3> <address>{address}</address> </div> <div class="wpr-wpg-gmap-info-window-img"> <img class="info-image" src="{image}" alt="{title}"></div></div></div>';
            var infoProp;

            for ( infoProp in info ) {
                var content = content.replace( '{' + infoProp + '}', info[infoProp] );
            }

            return content;
        }
    };

    if ( $( '#product_geolocation_for_woo_render_gmap' ).length ) {
        initWPR_Shop_Product_Map.init();
    }
} )( jQuery );
