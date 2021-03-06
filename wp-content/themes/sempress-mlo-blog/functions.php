<?php
/**
 * SemPress functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package SemPress
 * @since SemPress 1.0.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
  $content_width = 600; /* pixels */

/**
 * Set a default theme color array for WP.com.
 */
$themecolors = array(
  'bg' => 'f0f0f0',
  'border' => 'cccccc',
  'text' => '555555',
  'shadow' => 'ffffff'
);

class improved_main_menu extends Walker_Nav_Menu {


	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
    if($depth == 0){
      $nav_class = 'sub_menu_container';
    }elseif($depth > 0){
      $nav_class = 'bellow_sub_menu';
    }
		$output .= "\n$indent<nav class=\"$nav_class\"><ul>\n";

	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></nav>\n";
	}
  function start_el(&$output, $item, $depth, $args) {
    global $wp_query;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    
    $class_names = $value = '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
    //Addind classes to the li and the a if there's sub elements for easier styling
    $button_more = '';
    if($args->has_children && $depth == 0){
      $link_class = 'has_sub_link_top';
      $button_more = '<button type="button" class="hollow_button menu_more_button button_thick">+</button>';
    }elseif($args->has_children && $depth > 0){
      $link_class = 'has_sub_link';
      $class_names .= " has_sub_li";
    }
    $class_names = ' class="' . esc_attr( $class_names ) . '"';

    $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

    $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
    $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
    $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

    $item_output = $args->before;
    //add a class to the link that has subitems
    $item_output .= '<a class="main_nav_link '.$link_class.'"'. $attributes .'>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $button_more;
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
	//Overwrite display_element function to add has_children attribute. Not needed in >= Wordpress 3.4
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];
		
		//display this element
		if ( is_array( $args[0] ) ) 
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) ) 
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] ); 
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
				unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}

}
if ( ! function_exists( 'sempress_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override sempress_setup() in a child theme, add your own sempress_setup to your child theme's
 * functions.php file.
 */
function sempress_setup() {
  global $themecolors;

  /**
   * Make theme available for translation
   * Translations can be filed in the /languages/ directory
   * If you're building a theme based on sempress, use a find and replace
   * to change 'sempress' to the name of your theme in all the template files
   */
  load_theme_textdomain( 'sempress', get_template_directory() . '/languages' );

  $locale = get_locale();
  $locale_file = get_template_directory() . "/languages/$locale.php";
  if ( is_readable( $locale_file ) )
    require_once( $locale_file );

  /**
   * Add default posts and comments RSS feed links to head
   */
  add_theme_support( 'automatic-feed-links' );
  
  /**
   * This theme uses post thumbnails
   */
  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 600, 9999 ); // Unlimited height, soft crop

  /**
   * This theme uses wp_nav_menu() in one location.
   */
  $walker = new improved_main_menu;

  register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'sempress'),
  ) );

  /**
   * Add support for the Aside, Gallery Post Formats...
   */
  add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery', 'quote', 'link', 'audio', 'video', 'status' ) );
  //add_theme_support( 'structured-post-formats', array( 'image', 'quote', 'link' ) );

  /**
   * This theme supports jetpacks "infinite-scroll"
   *
   * @see http://jetpack.me/support/infinite-scroll/
   */
  add_theme_support( 'infinite-scroll', array('container' => 'content', 'footer' => 'colophon') );
  
  /**
   * This theme supports a custom header
   */
  $custom_header_args = array(
    'width'         => 950,
    'height'        => 200,
    'header-text'   => false
  );
  add_theme_support( 'custom-header', $custom_header_args );
  
  /**
   * This theme supports custom backgrounds
   */
  $custom_background_args = array(
    'default-color' => $themecolors['bg'],
    'default-image' => get_template_directory_uri() . '/img/noise.png',
  );
  
  /**
   * Nicer WYSIWYG editor
   */
  add_editor_style( 'editor-style.css' );
}
endif; // sempress_setup

/**
 * Tell WordPress to run sempress_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'sempress_setup' );

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since 1.3.1
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function sempress_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'sempress' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'sempress_wp_title', 10, 2 );

/**
 * Adds "custom-color" support
 *
 * @since 1.3.0
 */
function sempress_customize_register( $wp_customize ) {
  global $themecolors;

  $wp_customize->add_setting( 'sempress_textcolor' , array(
    'default'     => '#'.$themecolors['text'],
    'transport'   => 'refresh',
  ) );
  
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sempress_textcolor', array(
    'label'      => __( 'Text Color', 'sempress' ),
    'section'    => 'colors',
    'settings'   => 'sempress_textcolor',
  ) ) );
  
  $wp_customize->add_setting( 'sempress_shadowcolor' , array(
    'default'     => '#'.$themecolors['shadow'],
    'transport'   => 'refresh',
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sempress_shadowcolor', array(
    'label'      => __( 'Shadow Color', 'sempress' ),
    'section'    => 'colors',
    'settings'   => 'sempress_shadowcolor',
  ) ) );
  
  $wp_customize->add_setting( 'sempress_bordercolor' , array(
    'default'     => '#'.$themecolors['border'],
    'transport'   => 'refresh',
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sempress_bordercolor', array(
    'label'      => __( 'Border Color', 'sempress' ),
    'section'    => 'colors',
    'settings'   => 'sempress_bordercolor',
  ) ) );
}
add_action( 'customize_register', 'sempress_customize_register' );


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function sempress_page_menu_args( $args ) {
  $args['show_home'] = true;
  return $args;
}
add_filter( 'wp_page_menu_args', 'sempress_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function sempress_widgets_init() {
  register_sidebar( array(
    'name' => __( 'Sidebar 1', 'sempress' ),
    'id' => 'sidebar-1',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => "</section>",
    'before_title' => '<h1 class="widget-title">',
    'after_title' => '</h1>',
  ) );

  register_sidebar( array(
    'name' => __( 'Sidebar 2', 'sempress' ),
    'id' => 'sidebar-2',
    'description' => __( 'An optional second sidebar area', 'sempress' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => "</section>",
    'before_title' => '<h1 class="widget-title">',
    'after_title' => '</h1>',
  ) );
}
add_action( 'init', 'sempress_widgets_init' );

if ( ! function_exists( 'sempress_enqueue_scripts' ) ) :
/**
 * Enqueue theme scripts
 *
 * @uses wp_enqueue_scripts() To enqueue scripts
 *
 * @since SemPress 1.1.1
 */
function sempress_enqueue_scripts() {
	/*
	 * Adds JavaScript to pages with the comment form to support sites with
	 * threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

  // Add HTML5 support to older versions of IE
  if ( isset( $_SERVER['HTTP_USER_AGENT'] ) &&
     ( false !== strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) ) &&
     ( false === strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE 9' ) ) ) {
    
    wp_enqueue_script('html5', get_template_directory_uri() . '/js/html5.js', false, '3.6');
  }
  
	// Loads our main stylesheet.
	wp_enqueue_style( 'sempress-style', get_stylesheet_uri() );
}
endif;

add_action( 'wp_enqueue_scripts', 'sempress_enqueue_scripts' );

if ( ! function_exists( 'sempress_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since SemPress 1.0.0
 */
function sempress_content_nav( $nav_id ) {
  global $wp_query;

  ?>
  <nav id="<?php echo $nav_id; ?>">
    <h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'sempress' ); ?></h1>

  <?php if ( is_single() ) : // navigation links for single posts ?>

    <?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'sempress' ) . '</span> %title' ); ?>
    <?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'sempress' ) . '</span>' ); ?>

  <?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

    <?php if ( get_next_posts_link() ) : ?>
    <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'sempress' ) ); ?></div>
    <?php endif; ?>

    <?php if ( get_previous_posts_link() ) : ?>
    <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'sempress' ) ); ?></div>
    <?php endif; ?>

  <?php endif; ?>

  </nav><!-- #<?php echo $nav_id; ?> -->
  <?php
}
endif; // sempress_content_nav


if ( ! function_exists( 'sempress_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own sempress_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since SemPress 1.0.0
 */
function sempress_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <article id="comment-<?php comment_ID(); ?>" class="comment <?php $comment->comment_type; ?>">
      <footer>
        <address class="comment-author vcard hcard h-card">
          <?php echo get_avatar( $comment, 50 ); ?>
          <?php printf( __( '%s <span class="says">says:</span>', 'sempress' ), sprintf( '<cite class="fn p-name">%s</cite>', get_comment_author_link() ) ); ?>
        </address><!-- .comment-author .vcard -->
        <?php if ( $comment->comment_approved == '0' ) : ?>
          <em><?php _e( 'Your comment is awaiting moderation.', 'sempress' ); ?></em>
          <br />
        <?php endif; ?>

        <div class="comment-meta commentmetadata">
          <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>">
          <?php
            /* translators: 1: date, 2: time */
            printf( __( '%1$s at %2$s', 'sempress' ), get_comment_date(), get_comment_time() ); ?>
          </time></a>
          <?php edit_comment_link( __( '(Edit)', 'sempress' ), ' ' ); ?>
        </div><!-- .comment-meta .commentmetadata -->
      </footer>

      <div class="comment-content"><?php comment_text(); ?></div>

      <div class="reply">
        <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
      </div><!-- .reply -->
    </article><!-- #comment-## -->

  <?php
}
endif; // ends check for sempress_comment()

if ( ! function_exists( 'sempress_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own sempress_posted_on to override in a child theme
 *
 * @since SemPress 1.0.0
 */
function sempress_posted_on() {
  printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date updated dt-updated" datetime="%3$s" itemprop="dateModified">%4$s</time></a><address class="byline"> <span class="sep"> by </span> <span class="author p-author vcard hcard h-card" itemprop="author" itemscope itemtype="http://schema.org/Person"><a class="url uid u-url u-uid fn p-name" href="%5$s" title="%6$s" rel="author" itemprop="url"><span itemprop="name">%7$s</span></a></span></address>', 'sempress' ),
    esc_url( get_permalink() ),
    esc_attr( get_the_time() ),
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
    esc_attr( sprintf( __( 'View all posts by %s', 'sempress' ), get_the_author() ) ),
    esc_html( get_the_author() )
  );
}
endif;

/**
 * Adds post-thumbnail support :)
 *
 * @since SemPress 1.0.0
 */
function sempress_post_thumbnail($content) {
  if ( has_post_thumbnail() && get_the_post_thumbnail() ) {
    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-thumbnail');
    $class = "aligncenter";
    if ($image['1'] < "480")
      $class="alignright";

    $post_thumbnail = '<p>'.get_the_post_thumbnail( null, "post-thumbnail", array( "class" => $class, "itemprop" => "image" ) ).'</p>';

    return $post_thumbnail . $content;
  } else {
    return $content;
  }
}
add_action('the_content', 'sempress_post_thumbnail', 1);

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since SemPress 1.3.0
 */
function sempress_content_width() {
  if ( is_page_template( 'full-width-page.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
    global $content_width;
    $content_width = 880;
  }
}
add_action( 'template_redirect', 'sempress_content_width' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since SemPress 1.0.0
 */
function sempress_body_classes( $classes ) {
  // Adds a class of single-author to blogs with only 1 published author
  if ( ! is_multi_author() ) {
    $classes[] = 'single-author';
  }
  
  if ( get_header_image() ) {
    $classes[] = 'custom-header';
  }

  return $classes;
}
add_filter( 'body_class', 'sempress_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @since SemPress 1.0.0
 */
function sempress_post_classes( $classes ) {
  // Adds a class for microformats v2
  $classes[] = 'h-entry';
  
  // adds microformats 2 activity-stream support
  // for pages and articles
  if ( get_post_type() == "page" ) {
    $classes[] = "h-as-page";
  }
  if ( !get_post_format() && get_post_type() == "post" ) {
    $classes[] = "h-as-article";
  }
  
  // adds some more microformats 2 classes based on the
  // posts "format"
  switch ( get_post_format() ) {
    case "aside":
    case "status":
      $classes[] = "h-as-note";
      break;
    case "audio":
      $classes[] = "h-as-audio";
      break;
    case "video":
      $classes[] = "h-as-video";
      break;
    case "image":
      $classes[] = "h-as-image";
      break;
    case "link":
      $classes[] = "h-as-bookmark";
      break;
  }
  
  return $classes;
}
add_filter( 'post_class', 'sempress_post_classes' );

/**
 * Adds microformats v2 support to the comment_author_link.
 *
 * @since SemPress 1.0.0
 */
function sempress_author_link( $link ) {
  // Adds a class for microformats v2
  return preg_replace('/(class\s*=\s*[\"|\'])/i', '${1}u-url ', $link);
}
add_filter( 'get_comment_author_link', 'sempress_author_link' );

/**
 * Adds microformats v2 support to the get_avatar() method.
 *
 * @since SemPress 1.0.0
 */
function sempress_get_avatar( $tag ) {
  // Adds a class for microformats v2
  return preg_replace('/(class\s*=\s*[\"|\'])/i', '${1}u-photo ', $tag);
}
add_filter( 'get_avatar', 'sempress_get_avatar' );

/**
 * Returns true if a blog has more than 1 category
 *
 * @since SemPress 1.0.0
 */
function sempress_categorized_blog() {
  if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
    // Create an array of all the categories that are attached to posts
    $all_the_cool_cats = get_categories( array(
      'hide_empty' => 1,
    ) );

    // Count the number of categories that are attached to the posts
    $all_the_cool_cats = count( $all_the_cool_cats );

    set_transient( 'all_the_cool_cats', $all_the_cool_cats );
  }

  if ( '1' != $all_the_cool_cats ) {
    // This blog has more than 1 category so sempress_categorized_blog should return true
    return true;
  } else {
    // This blog has only 1 category so sempress_categorized_blog should return false
    return false;
  }
}

if ( ! function_exists( 'sempress_featured_gallery' ) ) :
/**
 * Displays first gallery from post content. Changes image size from thumbnail
 * to large, to display a larger first image.
 *
 * @since 1.3.1
 *
 * @return void
 */
function sempress_featured_gallery() {
	$pattern = get_shortcode_regex();

	if ( preg_match( "/$pattern/s", get_the_content(), $match ) ) {
		if ( 'gallery' == $match[2] ) {
			if ( ! strpos( $match[3], 'size' ) )
				$match[3] .= ' size="medium"';

			echo do_shortcode_tag( $match );
		}
	}
}
endif;

/**
 * Flush out the transients used in sempress_categorized_blog
 *
 * @since SemPress 1.0.0
 */
function sempress_category_transient_flusher() {
  // Like, beat it. Dig?
  delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'sempress_category_transient_flusher' );
add_action( 'save_post', 'sempress_category_transient_flusher' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function sempress_enhanced_image_navigation( $url ) {
  global $post, $wp_rewrite;

  $id = (int) $post->ID;
  $object = get_post( $id );
  if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
    $url = $url . '#main';

  return $url;
}
add_filter( 'attachment_link', 'sempress_enhanced_image_navigation' );

/**
 * Display the id for the post div.
 *
 * @param string $id.
 */
function sempress_post_id( $post_id = null ) {
  if ($post_id) {
    echo 'id="' . $post_id  . '"';
  } else {
    echo 'id="' . sempress_get_post_id()  . '"';
  } 
}

/**
 * Retrieve the id for the post div.
 *
 * @return string The post-id.
 */
function sempress_get_post_id() {
  $post_id = "post-" . get_the_ID();
  
  return apply_filters('sempress_post_id', $post_id, get_the_ID());
}

/**
 * adds the new HTML5 input types to the comment-form
 *
 * @param string $form
 * @return string
 */
function sempress_comment_input_types($fields) {
  if (get_option("require_name_email", false)) {
    $fields['author'] = preg_replace('/<input/', '<input required', $fields['author']);
    $fields['email'] = preg_replace('/"text"/', '"email" required', $fields['email']);
  } else {
    $fields['email'] = preg_replace('/"text"/', '"email"', $fields['email']);
  }

  $fields['url'] = preg_replace('/"text"/', '"url"', $fields['url']);

  return $fields;
}
add_filter("comment_form_default_fields", "sempress_comment_input_types");

/**
 * adds the new HTML5 input type to the search-field
 *
 * @param string $form
 * @return string
 */
function sempress_search_form_input_type($form) {
  return preg_replace('/"text"/', '"search" placeholder="'.__('Search here&hellip;', 'sempress').'"', $form);
}
add_filter("get_search_form", "sempress_search_form_input_type");

/**
 * adds the new HTML5 input types to the comment-text-area
 *
 * @param string $form
 * @return string
 */
function sempress_comment_field_input_type($field) {
  return preg_replace('/<textarea/', '<textarea required', $field);
}
add_filter("comment_form_field_comment", "sempress_comment_field_input_type");

/**
 * hide blog item types on single pages and posts
 */
function sempress_blog_itemscope() {
  if (!is_singular()) {
    echo ' itemscope itemtype="http://schema.org/Blog"';
  }
}

/**
 * hide blog item properties on single pages and posts
 */
function sempress_blog_itemprop($prop) {
  if (!is_singular()) {
    echo ' itemprop="'.$prop.'"';
  }
}

/**
 * This theme was built with PHP, Semantic HTML, CSS, love, and a SemPress.
 */
