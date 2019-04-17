<?php
//Global variable redux
global $cogito_options;

$cogito_footer_multi_column     =   $cogito_options ["cogito_footer_multi_column"];
$cogito_footer_multi_column_l   =   $cogito_options ["cogito_footer_multi_column_1"];
$cogito_footer_multi_column_2   =   $cogito_options ["cogito_footer_multi_column_2"];
$cogito_footer_multi_column_3   =   $cogito_options ["cogito_footer_multi_column_3"];
$cogito_footer_multi_column_4   =   $cogito_options ["cogito_footer_multi_column_4"];

if( is_active_sidebar( 'cogito-sidebar-footer-multi-column-1' ) || is_active_sidebar( 'cogito-sidebar-footer-multi-column-2' ) || is_active_sidebar( 'cogito-sidebar-footer-multi-column-3' ) || is_active_sidebar( 'cogito-sidebar-footer-multi-column-4' ) ) :

?>

    <div class="site-footer__multi--column">
        <div class="container">
            <div class="row">
                <?php
                for( $i = 0; $i < $cogito_footer_multi_column; $i++ ):

                    $j = $i +1;

                    if ( $i == 0 ) :
                        $cogito_col = $cogito_footer_multi_column_l;
                    elseif ( $i == 1 ) :
                        $cogito_col = $cogito_footer_multi_column_2;
                    elseif ( $i == 2 ) :
                        $cogito_col = $cogito_footer_multi_column_3;
                    else :
                        $cogito_col = $cogito_footer_multi_column_4;
                    endif;

                    if( is_active_sidebar( 'cogito-sidebar-footer-multi-column-'.$j ) ):
                ?>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-<?php echo esc_attr( $cogito_col ); ?>">

                        <?php dynamic_sidebar( 'cogito-sidebar-footer-multi-column-'.$j ); ?>

                    </div>

                <?php
                    endif;

                endfor;
                ?>
            </div>
        </div>
    </div>

<?php endif; ?>