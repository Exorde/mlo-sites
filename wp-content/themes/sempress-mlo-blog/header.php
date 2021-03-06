<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package SemPress
 * @since SemPress 1.0.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://microformats.org/profile/specs" />
<link rel="profile" href="http://microformats.org/profile/hatom" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php include 'inc/wp_statics.php'; ?>
<?php include 'inc/global_statics.php'; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?><?php sempress_blog_itemscope(); ?>>
<?php include 'inc/general_menu.php'; ?>
<div id="page" class="hfeed h-feed feed">
<?php do_action( 'before' ); ?>
  <header id="main_header" role="banner">
    <section>
      <?php include 'inc/global_logo.php'; ?>
      <h1 id="site-title" class="p-name"<?php sempress_blog_itemprop("name"); ?>><a id="home_link" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"<?php sempress_blog_itemprop("url"); ?>><?php bloginfo( 'name' ); ?></a></h1>
      <h2 id="site-description" class="e-content"<?php sempress_blog_itemprop("description"); ?>><?php bloginfo( 'description' ); ?></h2>
    </section>
    
    <?php if (get_header_image()) { ?>
      <img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="header image" id="site-image" />
    <?php } ?>
    
    <nav id="main_nav" class="menu_container" role="navigation">
      <h1 class="assistive-text section-heading"><a href="#main_nav" title="<?php esc_attr_e( 'Main menu', 'sempress' ); ?>"><?php _e( 'Main menu', 'sempress' ); ?></a></h1>
      <div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'sempress' ); ?>"><?php _e( 'Skip to content', 'sempress' ); ?></a></div>

      <?php $walker = new improved_main_menu;?>
      <?php wp_nav_menu( array( 'theme_location' => 'primary', 'walker' => $walker ) ); ?>
    </nav><!-- #main_nav -->
  </header><!-- #branding -->

  <main>
