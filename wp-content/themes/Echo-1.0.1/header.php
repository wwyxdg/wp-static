<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Echo
 */
$echo_option = get_option('echo_option');
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(''); ?>>
<header class="header header-sticky">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="navbar-brand">
				<img src="<?php echo echo_get_logo_url() ?>" class="" alt="<?php bloginfo( 'name' ); ?>">
			</a>
			<div class="d-lg-none">
				<button class="navbar-toggler site-search-toggler px-2 mr-1" type="button">
					<i class="text-xl iconfont icon-sousuo"></i>
				</button>
				<button class="navbar-toggler mobile-menu-toggler px-2" type="button" >
					<i class="text-xl iconfont icon-Dial-numbers"></i>
				</button>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="navbar-nav site-menu ml-4 mr-auto">
				<?php
					if ( function_exists( 'wp_nav_menu' ) && has_nav_menu('header-menu') ) {
						wp_nav_menu( array( 'container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'header-menu' ) );
					} else {
						_e('<li><a href="/wp-admin/nav-menus.php">Please set up your first menu at [Admin -> Appearance -> Menus]</a></li>', 'echo');
					}
				?>
				</ul>
				<ul class="navbar-nav order-1 order-lg-2">
					<li class="nav-item">
						<a class="nav-link site-search-toggler" href="javascript:;"><i class="text-xl iconfont icon-sousuo"></i></a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>
