(function ($) {

    /* Start element slider */
    let ElementCarouselSlider   =   function( $scope, $ ) {

        let element_slides = $scope.find( '.element-slides' );

        $( document ).general_owlCarousel_item( element_slides );

    };
    /* End element slider */

    /* Start element post carousel */
    let ElementPostCarousel   =   function( $scope, $ ) {

        let element_post_carousel = $scope.find( '.element-post-carousel' );

        $( document ).general_multi_owlCarouse( element_post_carousel );

    };
    /* End element post carousel */

    $( window ).on( 'elementor/frontend/init', function() {

        /* Element slider */
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cogito-slides.default', ElementCarouselSlider );

        /* Element post carousel */
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cogito-post-carousel.default', ElementPostCarousel );

    } );

})( jQuery );