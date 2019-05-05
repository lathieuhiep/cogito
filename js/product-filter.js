/**
 * Element events js v1.0.0
 * Copyright 2018-2020
 * Licensed under  ()
 */

( function( $ ) {

    "use strict";

    var product_btn_filter  =   $( '.btn-filter-product' );

    $( document ).ready( function () {

        filter_product();

    });

    function filter_product() {

        product_btn_filter.on( 'click', function () {

            var has_active = $(this).hasClass( 'active' );

            if ( has_active === false ) {

                $(this).parents( '.top-block__list' ).find('.btn-filter-product').removeClass( 'active' );
                $(this).addClass( 'active' );

                var content_product =   $(this).parents('.element-product-filter').find( '.element-product-filter__row' ),
                    data_settings   =   $(this).parents('.element-product-filter').data( 'settings' ),
                    product_tag_id  =   parseInt( $(this).data( 'id' ) ),
                    data_column     =   data_settings['column'],
                    data_limit      =   parseInt( data_settings['limit'] ),
                    data_orderby    =   data_settings['orderby'],
                    data_order      =   data_settings['order'];

                $.ajax({

                    url: cogito_products_filter_load.url,
                    type: 'POST',
                    data: ({

                        action: 'cogito_product_filter',
                        tag_id_product: product_tag_id,
                        column: data_column,
                        limit: data_limit,
                        orderby: data_orderby,
                        order: data_order

                    }),

                    beforeSend: function () {

                        content_product.addClass( 'filter-opacity' );

                    },

                    success: function( data ) {

                        if ( data ) {
                            content_product.empty().append( data );
                            content_product.removeClass( 'filter-opacity' );
                        }

                    }

                });

            }

        } )

    }

} )( jQuery );