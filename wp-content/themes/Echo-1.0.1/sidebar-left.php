<div class="col-md-3 col-lg-2 col-xl-2 sidebar-left d-none d-md-block ">
    <?php
        if ((is_archive() || is_search()) && is_active_sidebar('sidebar-archive-left')) {
            dynamic_sidebar( 'sidebar-archive-left' );
        } else {
            dynamic_sidebar( 'main-sidebar-left' );
        }
    ?>
</div>