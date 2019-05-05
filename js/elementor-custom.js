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

        $( document ).general_owlCarousel_item( element_post_carousel );

    };
    /* End element post carousel */

    /* Start element testimonial */
    let ElementTestimonialSlider   =   function( $scope, $ ) {

        let element_testimonial_slider  =   $scope.find('.element-testimonial__slides');

        $( document ).general_owlCarousel_item( element_testimonial_slider );

    };
    /* End element testimonial */

    $( window ).on( 'elementor/frontend/init', function() {

        /* Element slider */
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cogito-slides.default', ElementCarouselSlider );

        /* Element post carousel */
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cogito-post-carousel.default', ElementPostCarousel );

        /* Element testimonial carousel */
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cogito-testimonial.default', ElementTestimonialSlider );

    } );

})( jQuery );