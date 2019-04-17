
<?php if( is_active_sidebar( 'cogito-sidebar-main' ) ): ?>

    <aside class="<?php echo esc_attr( cogito_col_sidebar() ); ?> site-sidebar">
        <?php dynamic_sidebar( 'cogito-sidebar-main' ); ?>
    </aside>

<?php endif; ?>