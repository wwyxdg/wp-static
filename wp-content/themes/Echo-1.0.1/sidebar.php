<div class="col-lg-3 col-xl-3 sidebar-right border-left border-light d-none d-xl-block pl-lg-5">
    <?php
        if (is_page() && is_active_sidebar('sidebar-page')) {
            dynamic_sidebar( 'sidebar-page' );
        } elseif (is_single() && is_active_sidebar('sidebar-single')) {
            dynamic_sidebar( 'sidebar-single' );
        } elseif ((is_archive() || is_search()) && is_active_sidebar('sidebar-archive')) {
            dynamic_sidebar( 'sidebar-archive' );
        } else {
            dynamic_sidebar( 'main-sidebar' );
        }
    ?>

</div>