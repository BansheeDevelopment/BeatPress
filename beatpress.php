<?php
/*
Plugin Name: BeatPress
Plugin URI: https://beatpress.surcebeats.com/
Description: BeatPress for WordPress, your complete solution for selling beats online
Version: 11.2.46.0101-pm12
Author: Surce
Author URI: https://www.surcebeats.com/
*/

// Security Layer
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access to BeatPress Script denied.' );
}

//Copy Genre Catalog Taxonomy Template to Active Theme Directory
function bpactivation() {
	$file = get_template_directory() . '/taxonomy-genre.php';
	if ( file_exists( $file ) ) {
		//Genre Catalog File already exists, do nothing
	} else {
		copy(plugin_dir_path( __DIR__ ) . '/beatpress/inc/taxonomy-genre.php', get_template_directory() . '/taxonomy-genre.php');
	}
}
register_activation_hook( __FILE__, 'bpactivation' );



include( plugin_dir_path( __FILE__ ) . '/inc/dashboard.php');
include( plugin_dir_path( __FILE__ ) . '/inc/beatpress_beats.php');
include( plugin_dir_path( __FILE__ ) . '/inc/beatpress_catalog.php');
//include( plugin_dir_path( __FILE__ ) . '/inc/docs.php');
include( plugin_dir_path( __FILE__ ) . '/inc/payment_gateway.php');
include( plugin_dir_path( __FILE__ ) . '/inc/instrumentals.php');
include( plugin_dir_path( __FILE__ ) . '/inc/toolbox.php');
include( plugin_dir_path( __FILE__ ) . '/inc/mp3server.php');
include( plugin_dir_path( __FILE__ ) . '/inc/jplayer.php');
//include( plugin_dir_path( __FILE__ ) . '/inc/page_adder.php');
//include( plugin_dir_path( __FILE__ ) . '/inc/catalog_adder.php');



$myversion = '11.3.01.a-pm18';
$bpurl = 'https://beatpress.surcebeats.com';
$option_checker = get_option('beatpress_settings');

//DEV MODE
//$myversion = $myversion . '_js_dev_' . rand();
//DEV MODE


/*
function search_results_title() {
	if( is_search() ) {
	
		global $wp_query;
		
		if( $wp_query->post_count == 0 ) {
			echo 'nada';
		}
	
	}
}
add_action( 'pre_get_posts', 'search_results_title' );
*/





// LOAD PLUGIN TEXTDOMAIN FOR TRANSLATIONS
add_action('plugins_loaded', 'wan_load_textdomain');
function wan_load_textdomain() {
	load_plugin_textdomain( 'beatpress', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' ); 
}







// DASHBOARD WIDGET
add_action('wp_dashboard_setup', 'bp_dashboard_init');
  
function bp_dashboard_init() {
global $wp_meta_boxes;
global $myversion;
wp_add_dashboard_widget('custom_help_widget', '<img height="10" width="10" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> BeatPress ' . $myversion, 'bp_dashboard');
}
 
function bp_dashboard() {
	GLOBAL $option_checker;

	$b_published = wp_count_posts( 'instrumentals' )->publish;
	$b_scheduled = wp_count_posts( 'instrumentals' )->future;
	$b_draft = wp_count_posts( 'instrumentals' )->draft;
	$numGenre = wp_count_terms( 'genre', array( 'hide_empty'=> false, 'parent'    => 0 ));
	
	if ($option_checker['use_beattags'] == 1) {
		$numTags = wp_count_terms( 'beat-tag', array( 'hide_empty'=> false,	'parent'    => 0 ));
	} else {
		$numTags = 0;
	}
	
	echo '<span class="dashicons dashicons-chart-area"></span> <strong>' . $b_published . ' ' . __('beats published', 'beatpress') . '</strong><br>';
	echo '<span class="dashicons dashicons-clock"></span> <strong>' . $b_scheduled . ' ' . __('beats scheduled', 'beatpress') . '</strong><br>';
	echo '<span class="dashicons dashicons-clock"></span> <strong>' . $b_draft . ' ' . __('beats saved as drafts', 'beatpress') . '</strong><br>';
	echo '<span class="dashicons dashicons-menu"></span> <strong>' . $numGenre . ' ' . __('genres', 'beatpress') . '</strong><br>';

	if ($option_checker['use_beattags'] == 1) {
		echo '<span class="dashicons dashicons-tag"></span> <strong>' . $numTags . ' ' . __('beat tags', 'beatpress') . '</strong><br>';
	}

	echo '<hr><a href="/wp-admin/admin.php?page=beatpress-dashboard" style="width: -webkit-fill-available; cursor: pointer; background-color: #66a0ff; border: none; color: white; padding: 10px 27px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;">' . __('Open BeatPress Dashboard', 'beatpress') . '</a>';
	
}


// CUSTOM BEATPRESS FOLDER IN wp-content/uploads -> wp-content/uploads/beatpress
function beatpress_folder_upload() {
    $upload = wp_upload_dir();
    $upload_dir = $upload['basedir'];
    $upload_dir = $upload_dir . '/beatpress';
    if (! is_dir($upload_dir)) {
       mkdir( $upload_dir, 0755 );
    }
}
register_activation_hook( __FILE__, 'beatpress_folder_upload' );


// ADD CUSTOM IMAGE SUPPORT FOR CROP PLAYLIST IMAGES & IMPROVE LOAD TIME
add_theme_support( 'post-thumbnails' );
add_image_size( 'beatpress-playlist-image-size', 50, 50, true );
add_image_size( 'beatpress-playlist-image-featured-size', 170, 170, true );

// CUSTOM MESSAGE ON EMPTY CART
function my_custom_empty_cart_message($message) {
	return '<p class="my_empty_cart"><i class="far fa-comment-dots"></i> ' . __('It seems that your cart is empty.', 'beatpress') . '</p>';
}
add_filter('edd_empty_cart_message', 'my_custom_empty_cart_message');


// SUPPORT FOR FONT AWEOMSE
function your_function_name(){
	GLOBAL $option_checker;
	if ($option_checker['fa_support'] == 1) {
		echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">';
	}
};
add_action('wp_head', 'your_function_name');


















function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] . '/';
}




// REDIRECT ALL 404 ERRORS TO CATALOG
function wpd_do_stuff_on_404(){
	GLOBAL $option_checker;
	$x404 = $option_checker['option404catalog'];
	$current_url = home_url($_SERVER['REQUEST_URI']);
	


	
	if ( $option_checker['enableredirect'] == 1) {

		if( is_404() && $current_url !== url() . $option_checker['redirection2slash'] ){
			
			if ($x404 == '') {

			} else {
				
				if ($x404 == 'disable') {
				}
			
				if ($x404 == 'catalog') {
					if ($option_checker['catalogurl'] == '') {
						header("HTTP/1.1 301 Moved Permanently");
						header("Location: ".get_bloginfo('url'));
						exit();					
					} else {
						header("HTTP/1.1 301 Moved Permanently");
						header("Location: ".get_permalink( $option_checker['catalogurl'] ));
						exit();						
					}
				} 
			
				if ($x404 == 'homepage') {
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: ".get_bloginfo('url'));
					exit();				
				}
			}

		} else {
			
			if ($option_checker['redirection2slash'] == ''){
				
				//ENABLE REDIRECTION OF HOMEPAGE IF ORIGIN PAGE IS BLANK
				if ($current_url == url() . $option_checker['redirection2slash']){
					header("HTTP/1.1 302 Moved Temporarily");
					header("Location: ".$option_checker['redirection2destination']);
					exit();				
				}
				
				
			} else {
				
				if ($current_url == url() . $option_checker['redirection2slash']){
					header("HTTP/1.1 302 Moved Temporarily");
					header("Location: ".$option_checker['redirection2destination']);
					exit();				
				}
				
			}
			
			

		
		}
		
	} else {
		
		if( is_404() ){
			
			if ($x404 == '') {

			} else {
				
				if ($x404 == 'disable') {
				}
			
				if ($x404 == 'catalog') {
					if ($option_checker['catalogurl'] == '') {
						header("HTTP/1.1 301 Moved Permanently");
						header("Location: ".get_bloginfo('url'));
						exit();					
					} else {
						header("HTTP/1.1 301 Moved Permanently");
						header("Location: ".get_permalink( $option_checker['catalogurl'] ));
						exit();						
					}
				} 
			
				if ($x404 == 'homepage') {
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: ".get_bloginfo('url'));
					exit();				
				}
			}

		} 
		
	}
	

	
	
	
	
	
	
	
	
	
	
}
add_action( 'template_redirect', 'wpd_do_stuff_on_404' );







function horizontal() {
	$content = '<a href="/"><div class="addy flicker-1"><i class="fas fa-play"></i>&nbsp; ' . __('Check out my beats and instrumentals!', 'beatpress') . '</div></a>';
	return $content;
}
add_shortcode('ad1', 'horizontal');



// BEATPRESS VERSION
function version_lo() {
	GLOBAL $myversion;
	return '<strong>' . __('BeatPress Plugin for WordPress', 'beatpress' ) . '</strong><br>Version: ' . $myversion . '<br>' . __('Developed by ', 'beatpress') . 'Surce';
}
add_shortcode('version', 'version_lo');

// BEATPRESS BRANDING
function BPbranding() {
	GLOBAL $myversion;
    echo '<br><p class="bpnote">' . __('Powered by BeatPress', 'beatpress') . ' ' . $myversion . '</p>';
}

// REGISTER CSS AND JS ON LOAD
add_action( 'wp_loaded', 'wpse_register_scripts' );
function wpse_register_scripts() {
	GLOBAL $myversion;
    wp_register_script( 'beatpress', plugins_url('/js/beatpress.js', __FILE__), false, $myversion, 'all');
    wp_register_style( 'surcecustomcss', plugins_url('/css/beatpress_styles.css', __FILE__), false, $myversion, 'all');
    wp_register_script( 'jplayerjs', plugins_url('/assets/jplayer/jquery.jplayer.min.js', __FILE__), false, $myversion, 'all');
    wp_register_style( 'jplayercss', plugins_url('/assets/jplayer/css/jplayer.flat.css', __FILE__), false, $myversion, 'all');
	
	
	
	GLOBAL $option_checker;
	if ($option_checker['colorschene'] == ''){
		wp_register_style( 'custom_color', plugins_url('/css/colors/bp_colors_default.css', __FILE__), false, $myversion, 'all');
	} else {
		if ($option_checker['colorschene'] == 'default'){
			wp_register_style( 'custom_color', plugins_url('/css/colors/bp_colors_default.css', __FILE__), false, $myversion, 'all');
		}
		if ($option_checker['colorschene'] == 'purple'){
			wp_register_style( 'custom_color', plugins_url('/css/colors/bp_colors_purple.css', __FILE__), false, $myversion, 'all');
		}
		if ($option_checker['colorschene'] == 'blue'){
			wp_register_style( 'custom_color', plugins_url('/css/colors/bp_colors_blue.css', __FILE__), false, $myversion, 'all');
		}
		if ($option_checker['colorschene'] == 'orange'){
			wp_register_style( 'custom_color', plugins_url('/css/colors/bp_colors_orange.css', __FILE__), false, $myversion, 'all');
		}
		if ($option_checker['colorschene'] == 'red'){
			wp_register_style( 'custom_color', plugins_url('/css/colors/bp_colors_red.css', __FILE__), false, $myversion, 'all');
		}
		if ($option_checker['colorschene'] == 'pink'){
			wp_register_style( 'custom_color', plugins_url('/css/colors/bp_colors_pink.css', __FILE__), false, $myversion, 'all');
		}
		if ($option_checker['colorschene'] == 'limegreen'){
			wp_register_style( 'custom_color', plugins_url('/css/colors/bp_colors_limegreen.css', __FILE__), false, $myversion, 'all');
		}
	}
	
}

// ENQUEUE CSS AND JS ON LOAD
add_action( 'wp_enqueue_scripts', 'wpse_enqueue_scripts' );
function wpse_enqueue_scripts() {
   wp_enqueue_script( 'beatpress' );
   wp_enqueue_script( 'jplayerjs' );
   wp_enqueue_style( 'jplayercss' );
   wp_enqueue_style( 'surcecustomcss' );
   wp_enqueue_style( 'custom_color' );
}





// COUNT BEAT VIEWS
function count_beat_views() {
   if(is_single()) {
      global $post;
      $count = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'songplays', true );
      $newcount = $count + 1;
      update_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'songplays', $newcount );
   }
}




// ADD INSTRUMENTALS POST TYPE TO BLOG ARCHIVE
function add_my_post_types_to_query( $query ) {
	GLOBAL $option_checker;
	if ($option_checker['cptinblog'] == 1) {
		if ( is_home() && $query->is_main_query() )
			$query->set( 'post_type', array( 'post', 'instrumentals' ) );
		return $query;
	}
}
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );


//DISABLE AUTOSAVE DRAFTS
add_action( 'admin_init', 'disable_autosave' );
function disable_autosave() {
        wp_deregister_script( 'autosave' );
}



//SHOW CURRENT YEAR BY TYPING [year]
function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');
























// Hay que trabajar en esto para que no sea un shortcode marronero
//SHOW LATEST BEATS IN EACH POST & INSTRUMENTAL
function recent_posts_function($atts){
// Attributes
extract( shortcode_atts(
    array(
        'posts' => '10',
    ),
	$atts
	)
);
query_posts(
     array(
		'orderby' => 'date', 
		'order' => 'DESC' , 
		'posts_per_page' => $posts,
		'post_type' => 'instrumentals'
     )
);  
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
	$trew = array(
		'title' => get_the_title() . '',
	);
    $return_string .= '<a class="extrabeats" href="' . get_the_permalink() .'" rel="bookmark">' . get_the_post_thumbnail($post_id, array(20,20), $trew ) . ' <i class="fas fa-link"></i> ' . get_the_title() .'</a><br>';
    endwhile;
    endif;
    wp_reset_query();
    return $return_string;
}

function register_shortcodes(){
    add_shortcode('recent-beats', 'recent_posts_function');
}
add_action( 'init', 'register_shortcodes');










// Una vez quitado el shortcode marronero de arriba utilizarlo como función
function wpb_after_post_content($content){
	GLOBAL $option_checker;
	GLOBAL $myversion;
	$sharing = $option_checker['showshare'];
	$latestbeats = $option_checker['latestbeatsw'];
	
	if ( ! $sharing == '' ) {
		if ( $sharing == 'all' ) {
			if ( get_post_type() == 'post' || get_post_type() == 'instrumentals' ) {
				//Share Buttons
				$content .= '<p class="sharing" id="pshare"><i class="fas fa-share-alt-square"></i> ' . __('Share this page', 'beatpress') . '</p> ';
				$content .= '<div id="socialbox"><a rel="nofollow" href="http://twitter.com/share?url=' . get_permalink(get_post()) . '&text=' . get_the_title(get_post()) . '" target="_blank" class="share-btn twitter"><i class="fab fa-twitter"></i></a>';
				$content .= '<a rel="nofollow" href="http://www.facebook.com/sharer/sharer.php?u=' . get_permalink(get_post()) . '" target="_blank" class="share-btn facebook"><i class="fab fa-facebook-f"></i></a>';
				$content .= '<a rel="nofollow" href="http://reddit.com/submit?url=' . get_permalink(get_post()) . '&title=' . get_the_title(get_post()) . '" target="_blank" class="share-btn reddit"><i class="fab fa-reddit-alien"></i></a>';
				$content .= '<a rel="nofollow" href="https://api.whatsapp.com/send?text=' . get_the_title(get_post()) . ' ' . get_permalink(get_post()) . '"  target="_blank" class="share-btn whatsapp"><i class="fab fa-whatsapp"></i></a>';
				$content .= '</div><br>';
			}
		}
		if ( $sharing == 'beats' ) {
			if ( get_post_type() == 'instrumentals') {
				//Share Buttons
				$content .= '<p class="sharing" id="pshare"><i class="fas fa-share-alt-square"></i> ' . __('Share this page', 'beatpress') . '</p> ';
				$content .= '<div id="socialbox"><a rel="nofollow" href="http://twitter.com/share?url=' . get_permalink(get_post()) . '&text=' . get_the_title(get_post()) . '" target="_blank" class="share-btn twitter"><i class="fab fa-twitter"></i></a>';
				$content .= '<a rel="nofollow" href="http://www.facebook.com/sharer/sharer.php?u=' . get_permalink(get_post()) . '" target="_blank" class="share-btn facebook"><i class="fab fa-facebook-f"></i></a>';
				$content .= '<a rel="nofollow" href="http://reddit.com/submit?url=' . get_permalink(get_post()) . '&title=' . get_the_title(get_post()) . '" target="_blank" class="share-btn reddit"><i class="fab fa-reddit-alien"></i></a>';
				$content .= '<a rel="nofollow" href="https://api.whatsapp.com/send?text=' . get_the_title(get_post()) . ' ' . get_permalink(get_post()) . '"  target="_blank" class="share-btn whatsapp"><i class="fab fa-whatsapp"></i></a>';
				$content .= '</div><br>';
			}
		}
	}
		
	if ( ! $latestbeats == '' ) {
		if ( $latestbeats == 'all' ) {
			if ( get_post_type() == 'post' || get_post_type() == 'instrumentals' ) {
				//Latest Beats
				$content .= '<p class="extraf"><i class="fas fa-compact-disc fa-spin"></i> ' . __('Check out the latest beats', 'beatpress') . '</p>';
				$content .= do_shortcode('[recent-beats posts="5"]');
			}
		}
		if ( $latestbeats == 'beats' ) {
			if ( get_post_type() == 'instrumentals') {
				//Latest Beats
				$content .= '<p class="extraf"><i class="fas fa-compact-disc fa-spin"></i> ' . __('Check out the latest beats', 'beatpress') . '</p>';
				$content .= do_shortcode('[recent-beats posts="5"]');
			}
		}
	}
	
	
	//Parallax Non Intrusive Advertising
	if ( ! $option_checker['supportads'] == 1 && get_post_type() == 'instrumentals') {
		$content .= '<br><a target="_blank" href="http://beatpress.surcebeats.com?' . $_SERVER['SERVER_NAME'] . '"><div class="ad-parallax-wrapper"><div class="ad-parallax-container">';
		$content .= '<img title="' . __('Powered by BeatPress', 'beatpress') . ' ' . $myversion . '" alt="' . __('Powered by BeatPress', 'beatpress') . ' ' . $myversion . '" height="32px" width="32px" src="/wp-content/plugins/beatpress/imgs/system/logo.png">';
		$content .= '</div></div></a>';		
	}
	
		
    return $content;
}
add_filter( "the_content", "wpb_after_post_content" );






function cart_adder_beatpress(){
	GLOBAL $option_checker;
	
	if( !function_exists('is_plugin_active') ) {
			
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			
	}
		
		
	if( is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' ) && $option_checker['purchasemode'] == 'edd' ) {

		//Show cart always on CPT
		if ( is_singular( 'instrumentals' ) ) {
			//Cart Button Corner
			echo '<a href="' . edd_get_checkout_uri() . '" class="button-badge">';
			echo '<i class="fas fa-cart-arrow-down cart-icony"></i>';
			echo '<span class="badgex header-cart edd-cart-quantity">' . edd_get_cart_quantity() . '</span>';
			echo '</a>';
		}
	
		//Show cart if items are 1 or ++
		if ( edd_get_cart_quantity() >= 1 ) {
			//Cart Button Corner
			echo '<a href="' . edd_get_checkout_uri() . '" class="button-badge">';
			echo '<i class="fas fa-cart-arrow-down cart-icony"></i>';
			echo '<span class="badgex header-cart edd-cart-quantity">' . edd_get_cart_quantity() . '</span>';
			echo '</a>';
		}
	
		//Show cart if slug is store
		if ( get_the_ID() == $option_checker['catalogurl'] ) {
			//Cart Button Corner
			echo '<a href="' . edd_get_checkout_uri() . '" class="button-badge">';
			echo '<i class="fas fa-cart-arrow-down cart-icony"></i>';
			echo '<span class="badgex header-cart edd-cart-quantity">' . edd_get_cart_quantity() . '</span>';
			echo '</a>';
		}

	}
	
	if( !is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' ) && $option_checker['purchasemode'] == 'edd' ) {
		echo '<div class="bp_admin_notice"><i class="fas fa-exclamation-triangle"></i> ' . __('Easy Digital Downloads is selected as your BeatPress Selling Mode, but the plugin Easy Digital Downloads is non active or not installed.', 'beatpress') . '<br>' . __('Please select a different BeatPress Selling Mode', 'beatpress') . ' <a style="color: black;" target="_blank" href="/wp-admin/admin.php?page=beatpress-selling">' . __('clicking here', 'beatpress') . '</a>, ' . __('or install', 'beatpress') . ' <a style="color: black;" target="_blank" rel="nofollow" href="https://wordpress.org/plugins/easy-digital-downloads/">Easy Digital Downloads</a>.</div>';
	}

	
}
add_filter( "wp_footer", "cart_adder_beatpress" );










//REMOVE PRIVATE FROM TITLE
function the_title_trim($title) {
	$title = attribute_escape($title);
	$findthese = array(
		'#Protected:#',
		'#Private:#'
	);
	$replacewith = array(
		'', // What to replace "Protected:" with
		'' // What to replace "Private:" with
	);
	$title = preg_replace($findthese, $replacewith, $title);
	return $title;
}
add_filter('the_title', 'the_title_trim');



//REMOVE INSTRUMENTALS POST EDITOR
function remove_downloads_editor(){
    remove_post_type_support( 'instrumentals', 'editor' );
					//header("HTTP/1.1 302 Moved Temporarily");				 		//FUERA
					//header('Location: https://surcebeats.beatstars.com'); 		//FUERA
					//exit();				 										//FUERA

}   
add_action( 'init', 'remove_downloads_editor' );






//DUPLICATE POSTS
function rd_duplicate_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}
 
	/*
	 * Nonce verification
	 */
	if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
		return;
 
	/*
	 * get the original post id
	 */
	$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );
 
	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;
 
	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {
 
		/*
		 * new post data array
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
 
		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );
 
		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
 
		/*
		 * duplicate all post meta just in two SQL queries
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				if( $meta_key == '_wp_old_slug' ) continue;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}
 
 
		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
 
/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="' . __('Duplicate this item', 'beatpress') . '" rel="permalink">' . __('Duplicate', 'beatpress') . '</a>';
	}
	return $actions;
}
 
add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );







//EXCLUDE DOWNLOADS FROM SEARCH RESULTS
add_action( 'pre_get_posts', 'jdn_modify_query' );
function jdn_modify_query( $query ) {
 
 // First, make sure this isn't the admin and is the main query, otherwise bail
 if( is_admin() || ! $query->is_main_query() )
 return;
 
 // If this is a search result query
 if( $query->is_search() ) {
 // Gather all searchable post types
 $in_search_post_types = get_post_types( array( 'exclude_from_search' => false ) );
 // The post type you're removing, in this example 'page'
 $post_type_to_remove = 'download';
 // Make sure you got the proper results, and that your post type is in the results
 if( is_array( $in_search_post_types ) && in_array( $post_type_to_remove, $in_search_post_types ) ) {
 // Remove the post type from the array
 unset( $in_search_post_types[ $post_type_to_remove ] );
 // set the query to the remaining searchable post types
 $query->set( 'post_type', $in_search_post_types );
 }
 }
}










//DISABLE RIGHT CLICK AND TEXT SELECT IF NOT ADMINISTRATOR
function joe_disable_right_click(){ 
GLOBAL $option_checker;
if ($option_checker['rightclickselect'] == 1) {
	if ( current_user_can('administrator') ) {
	} else {
		?>
		<script language="Javascript">
			/*<![CDATA[*/
			document.oncontextmenu = function(){return false;};
			/*]]>*/
		</script>
		<script type="text/javascript">
			/*<![CDATA[*/
			document.onselectstart=function(){
				if (event.srcElement.type != "text" && event.srcElement.type != "textarea" && event.srcElement.type != "password") {
					return false;
				}
				else {
					return true;
				}
			};
		if (window.sidebar) {
			document.onmousedown=function(e){
				var obj=e.target;
				if (obj.tagName.toUpperCase() == "INPUT" || obj.tagName.toUpperCase() == "TEXTAREA" || obj.tagName.toUpperCase() == "PASSWORD") {
					return true;
				}
				else {
					return false;
				}
			};
		}
		/*]]>*/
		</script>
		<script type="text/javascript" language="JavaScript1.1">
			/*<![CDATA[*/
			if (parent.frames.length > 0) { top.location.replace(document.location); }
			/*]]>*/
		</script>
		<script language="Javascript">
			/*<![CDATA[*/
			document.ondragstart = function(){return false;};
			/*]]>*/
		</script>
		<?php
	}	
}
}
add_action( 'wp_head', 'joe_disable_right_click' );






function my_simple_crypt( $string, $action = 'e' ) {
	GLOBAL $myversion;
	GLOBAL $option_checker;
	$pname = $option_checker['producername'];
	$domain = $_SERVER['HTTP_HOST'];

    // you may change these values to your own
	
	if (isset($pname)) {
		$secret_key = 'beatpress_3dbn8%397nd9' . $pname . $myversion . $domain;
		$secret_iv = 'beatpress_3omd(30dbdbD' . $pname . $myversion . $domain;
	} else {
		$secret_key = 'beatpress_3dbn8%397nd9' . $myversion . $domain;
		$secret_iv =  'beatpress_3omd(30dbdbD' . $myversion . $domain;
	}
	
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
 
    return $output;
}





/*
// REDIRECT TO BEATPRESS SETTINGS ON BEATPRESS ACTIVATION
function beatpress_active_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'admin.php?page=beatpress-dashboard' ) ) );
    }
}
add_action( 'activated_plugin', 'beatpress_active_redirect' );
*/


// ADD BEATPRESS SETTINGS LINK TO PLUGINS PAGE
function add_settings_link($links)
{
    $settings_link = '<a href="admin.php?page=beatpress-dashboard">' . __('BeatPress Settings', 'beatpress') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

add_filter('plugin_action_links_' . plugin_basename( __FILE__ ), 'add_settings_link');










/*
register_activation_hook( __FILE__, 'myplugin_plugin_activate' );
function myplugin_plugin_activate() {
settings_fields('beatpress_settings');
	
    if (FALSE === get_option('producername') && FALSE === update_option('producername',FALSE)) add_option('producername', 'DEFAULT');
        
}
*/





?>