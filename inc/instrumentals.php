<?php
/**
 * BeatPress Instrumentals Custom Post Type and Custom Taxonomies
 * /instrumental and /genre
 *
 * @/inc/instrumentals.php
 * @package BeatPress
 */

// Security Layer
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access to BeatPress Script denied.' );
}

//CREATE POST TYPE INSTRUMENTALS
function create_posttype() {
 
    register_post_type( 'instrumentals',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Instrumentals', 'beatpress' ),
                'singular_name' => __( 'Instrumentals', 'beatpress' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'instrumentals'),
        )
    );
}
add_action( 'init', 'create_posttype' );
















/*
    add_action('post__dit_form_tag', 'update__dit_form');

    function update__dit_form() {
      echo ' enctype="multipart/form-data"';
      } // end update__dit_form

    add_action('add_meta_boxes', 'the_upload_metabox'); 
   
    function the_upload_metabox() {  
        // Define the custom attachment for posts  
        add_meta_box(  
            'wp_custom_attachment',  
            'Upload File',  
            'wp_custom_file_attachment'    
        );   
    } 

    // The custom file attachment function
    function wp_custom_file_attachment() {  
      
      global $post;
      $theFILE=  get_post_meta($post->ID,'wp_custom_attachment',true);
      wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');  
      $html = '
<p class="description">'; $html .= 'Upload the File.'; if(count($theFILE)>0 && is_array($theFILE)){ $html.="Uploaded File:".$theFILE[0]['url']; }
$html .= '</p>';
$html .= '<input id="wp_custom_attachment" title="select file" multiple="multiple" name="wp_custom_attachment[]" size="25" type="file" value="" />';  

    echo $html; 
      
    } 
     add_action('save_post', 'save_custom_meta_data');
    // Saving the uploaded file details
    function save_custom_meta_data($id) {  

	if(isset($_POST['wp_custom_attachment_nonce']))
        if(!wp_verify_nonce($_POST['wp_custom_attachment_nonce'], plugin_basename(__FILE__))) {  
          return $id;  
        } // end if  
            
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {  
          return $id;  
        } // end if  
         if(isset($_POST['post_type']))   
        if('page' == $_POST['post_type']) {  
          if(!current_user_can('edit_page', $id)) {  
            return $id;  
          } // end if  
        } else {  
            if(!current_user_can('edit_page', $id)) {  
                return $id;  
            } // end if  
        } // end if  

		
        // Make sure the file array isn't empty  
        if(!empty($_FILES['wp_custom_attachment']['name'])) {                         
            // Get the file type of the upload  
             $flag=0;
            for($i=0;$i<count($_FILES['wp_custom_attachment']['name']);$i++){
                if(!empty($_FILES['wp_custom_attachment']['name'][$i])){
                    $flag=1;
                // Use the WordPress API to upload the multiple files
                $upload[] = wp_upload_bits($_FILES['wp_custom_attachment']['name'][$i], null, file_get_contents($_FILES['wp_custom_attachment']['tmp_name'][$i]));  
                }
                }
                if($flag==1)
                update_post_meta($id, 'wp_custom_attachment', $upload);       
             
        } 
          
    } 
*/	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
function custom_post_type() {
		GLOBAL $option_checker;

// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Instrumentals', 'Post Type General Name', 'beatpress' ),
        'singular_name'       => _x( 'Instrumental', 'Post Type Singular Name', 'beatpress' ),
        'menu_name'           => __( 'Instrumentals', 'beatpress' ),
        'parent_item_colon'   => __( 'Parent Instrumental', 'beatpress' ),
        'all_items'           => __( 'All Instrumentals', 'beatpress' ),
        'view_item'           => __( 'View Instrumental', 'beatpress' ),
        'add_new_item'        => __( 'Add New Instrumental', 'beatpress' ),
        'add_new'             => __( 'Add New', 'beatpress' ),
        'edit_item'           => __( 'Edit Instrumental', 'beatpress' ),
        'update_item'         => __( 'Update Instrumental', 'beatpress' ),
        'menu_icon'           => 'dashicons-album',
        'search_items'        => __( 'Search Instrumental', 'beatpress' ),
        'not_found'           => __( 'Not Found', 'beatpress' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'beatpress' ),
    );
	// Set other options for Custom Post Type
    $args = array(
        'label'               => __( 'instrumentals', 'beatpress' ),
        'description'         => __( 'Your beats and instrumental are here', 'beatpress' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-album',
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 3,
        'can__xport'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
		 // This is where we add taxonomies to our CPT
        //'taxonomies'          => array( 'topics', 'category' ), //REMOVE TO REMOVE DEFAULT CATEGORIES
    );

	
	
	
	
	
	
	
	
	
	
	
register_taxonomy(
        'genre',
        //'tag',
        'instrumentals',
        array(
            'labels' => array(
                'name' => __( 'Genres', 'beatpress'),
                'add_new_item' => __( 'Add New Genre', 'beatpress' ),
                'new_item_name' => __( 'New Genre', 'beatpress' ),
				'edit_item' => __( 'Edit Genre', 'beatpress' ),
				'update_item' => __( 'Update Genre', 'beatpress' ),
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'show_admin_column' => true,
		)
);

if ($option_checker['use_beattags'] == 1) {

	register_taxonomy(
			'beat-tag',
			//'tag',
			'instrumentals',
			array(
				'labels' => array(
					'name' => __( 'Beat Tags', 'beatpress' ),
					'add_new_item' => __( 'Add New Beat Tag', 'beatpress' ),
					'new_item_name' => __( 'New Beat Tag', 'beatpress' )
				),
				'show_ui' => true,
				'show_tagcloud' => false,
				'hierarchical' => false,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'show_admin_column' => true,
				)
	);
}
	
	
    // Registering your Custom Post Type
    register_post_type( 'instrumentals', $args );
	
	
	
}


function namespace_add_custom_types( $query ) {
  if( (is_category() || is_tag()) && $query->is_archive() && empty( $query->query_vars['suppress_filters'] ) ) {
    $query->set( 'post_type', array(
     'post', 'instrumentals'
        ));
    }
    return $query;
}
add_filter( 'pre_get_posts', 'namespace_add_custom_types' );

add_action( 'init', 'custom_post_type');



/*REMOVE INSTRUMENTALS POST EDITOR
function remove_instrumentals__ditor(){
    remove_post_type_support( 'instrumentals', 'editor' );
}   
add_action( 'init', 'remove_instrumentals__ditor' );
*/







/*SHORTEN EXCERPT
function shorten_string($string, $wordsreturned)
//  Returns the first $wordsreturned out of $string.  If string
// contains fewer words than $wordsreturned, the entire string
// is returned.

{
$retval = $string;      //  Just in case of a problem
 
$array = explode(" ", $string);
if (count($array)<=$wordsreturned)
//  Already short enough, return the whole thing

{
$retval = $string;
}
else
//  Need to chop of some words

{
array_splice($array, $wordsreturned);
$retval = implode(" ", $array)." ...";
}
return $retval;
}
*/
























get_the_post_thumbnail($post->ID, "beatpress-playlist-image-size");
// GET FEATURED IMAGE
function ST4_get_featured_image($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
        return $post_thumbnail_img[0];
    }
}

// ADD NEW COLUMN
function ST4_columns_head($defaults) {
	if( get_post_type() == 'instrumentals' ) {
		$defaults['beattitle'] = __('Beat Title', 'beatpress');
		$defaults['artwork'] = __('Artwork', 'beatpress');
		$defaults['views'] = __('Views', 'beatpress');
		$defaults['buy__xternal'] = __('External Link', 'beatpress');
		$defaults['yt'] = __('Video', 'beatpress');
		return $defaults;
	} else {
		return $defaults;
	}
}
 
// SHOW THE FEATURED IMAGE
function ST4_columns_content($column_name, $post_ID) {
	
    if ($column_name == 'beattitle') {
		
        $namer = get_post_meta( get_the_ID(), 'beatpress_toolbox_name', true );
        if ($namer) {
            echo $namer;
		} else {
			echo __('N/A', 'beatpress');
        }
		
		

    }
	
    if ($column_name == 'yt') {
		
        $vidlnk = get_post_meta( get_the_ID(), 'beatpress_toolbox_yt', true );
        if ($vidlnk) {
            echo '<a href="https://www.youtube.com/watch?v=' . $vidlnk . '" target="_blank">📹</a>';
		} else {
			echo __('N/A', 'beatpress');
        }
		

    }
	
    if ($column_name == 'artwork') {
		
		if ( has_post_thumbnail() ) {
			$post_featured_image = get_the_post_thumbnail($post_ID, "beatpress-playlist-image-size");
			echo $post_featured_image;
		} else {
			$post_featured_image = '<img src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog.jpg" title="' . __('No artwork set', 'beatpress') . '">';
			echo $post_featured_image;
		}
		
		

    }
	
    if ($column_name == 'views') {
        $counter = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'songplays', true );
        if ($counter) {
            echo $counter;
		} else {
			echo '0';
        }
    }
	
	
    if ($column_name == 'buy__xternal') {
        $counter = get_post_meta( get_the_ID(), 'beatpress_toolbox_buy_external', true );
        if ($counter) {
            echo '<a href="' . $counter . '" target="_blank">⧉ ' . $counter . '</a>';
		} else {
			echo __('No External Link', 'beatpress');
        }
    }
}
add_filter('manage_posts_columns', 'ST4_columns_head');
add_action('manage_posts_custom_column', 'ST4_columns_content', 10, 2);


function my_column_width() {
    echo '<style type="text/css">';
    echo '.column-artwork { text-align: center; width:50px !important; overflow:hidden }';
    echo '.column-views { text-align: center; width:50px !important; overflow:hidden }';
    echo '</style>';
}
add_action('admin_head', 'my_column_width');
























class Rational_Meta_Box {
	private $screens = array(
		'instrumentals',
	);
	
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
	}

	public function add_meta_boxes() {
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'beatpress-toolbox',
				__( 'BeatPress Page Generator', 'beatpress' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'advanced',
				'default'
			);
		}
	}

	public function add_meta_box_callback( $post ) {
		$rnder = rand(10000, 99999);
		wp_nonce_field( 'beatpress_toolbox_data', 'beatpress_toolbox_nonce' );
		echo '<img style="margin-top: 5px;" height="52px" width="200px" src="/wp-content/plugins/beatpress/imgs/system/cptlogotop.png">';
		echo '<br><br>';
		
		echo '<strong style="font-size: 16px;"><em><i class="far fa-file-audio"></i> ' . __('Select MP3 File', 'beatpress') . '</em></strong><br><p style="color:#878787;font-size:xx-small;"><strong>*' . __('Upload the tagged MP3 file of your beat - 128kbps Recommended', 'beatpress') . '.</strong></p>';
		
		 $files = get_post_meta( $post->ID, 'bp_streaming_file', true );
		 
		if( ! empty( $files ) ) {
			//echo '<i class="fas fa-music"></i> ' . __('Your MP3 file', 'beatpress') . ': <br>' . "\r\n";
			foreach( $files as $file ) {
				echo '<br><audio controls><source src="' . $file['url'] . '?' . $rnder . '" type="audio/mpeg">' . __('Your browser does not support the audio elements', 'beatpress') . '.</audio><br><a style="text-decoration:none;color:#878787;font-size:xx-small;" target="_blank" href="' . $file['url'] . '?' . $rnder . '"><i class="fas fa-link"></i> ' . $file['url'] . '</a><br><br>';
				break;
			}
			echo "\r\n";
		}
		echo __('Upload beat', 'beatpress') . ':' . "\r\n";
		echo '<input type="file" name="bp_streaming_file[]" accept=".mp3" />';
		echo '<br><br>';
	
		$this->generate_fields( $post );
	
	}

	public function generate_fields( $post ) {
		GLOBAL $myversion;
		$output = '';
		echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">';
		echo '<style>::placeholder { color: #cccccc; opacity: 1; } </style>';
		
		$beattitle  = get_post_meta( $post->ID, 'beatpress_toolbox_name', true );
		$buyexternal = get_post_meta( $post->ID, 'beatpress_toolbox_buy_external', true );
		$eddidentifier = get_post_meta( $post->ID, 'beatpress_toolbox_eddnum', true );
		$sliker = get_post_meta( $post->ID, 'beatpress_toolbox_slike', true );
		$pmp3p = get_post_meta( $post->ID, 'beatpress_toolbox_lic_mp3', true );
		$pwavp = get_post_meta( $post->ID, 'beatpress_toolbox_lic_wav', true );
		$ppremiump = get_post_meta( $post->ID, 'beatpress_toolbox_lic_premium', true );
		$punlimitedp = get_post_meta( $post->ID, 'beatpress_toolbox_lic_unlimited', true );
		$pexclusivep = get_post_meta( $post->ID, 'beatpress_toolbox__xclusive', true );
		$bpcollab = get_post_meta( $post->ID, 'beatpress_toolbox_collab', true );
		$bphook = get_post_meta( $post->ID, 'beatpress_toolbox_hook', true );
		$bpsold = get_post_meta( $post->ID, 'beatpress_toolbox_sold', true );
		$bpnewbeat = get_post_meta( $post->ID, 'beatpress_toolbox_newbeat', true );
		$bpnewbeaturl = get_post_meta( $post->ID, 'beatpress_toolbox_newbeaturl', true );
		$bpyt = get_post_meta( $post->ID, 'beatpress_toolbox_yt', true );
		$bpseointro = get_post_meta( $post->ID, 'beatpress_toolbox_intro', true );
		$bpseop1 = get_post_meta( $post->ID, 'beatpress_toolbox_p1', true );
		$bpseop2 = get_post_meta( $post->ID, 'beatpress_toolbox_p2', true );
		$bpseop3 = get_post_meta( $post->ID, 'beatpress_toolbox_p3', true );

		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-angle-right"></i></span> ';
		echo '<label for="beatpress_toolbox_name">' . __( 'Beat Title', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<input maxlength="30" class="large-text" placeholder="' . __('Title of your beat', 'beatpress') . '" class="text" type="text" id="beatpress_toolbox_name" name="beatpress_toolbox_name" value="' . esc_attr( $beattitle ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*The title of your beat, it will be used along the whole page', 'beatpress') . '</p><br/>';
		echo '</div>';

		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-external-link-alt"></i></span> ';
		echo '<label for="beatpress_toolbox_buy_external">' . __( 'External Link', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<input maxlength="150" class="large-text" placeholder="https://bsta.rs/..." class="text" type="text" id="beatpress_toolbox_buy_external" name="beatpress_toolbox_buy_external" value="' . esc_attr( $buyexternal ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Link to the external website where you also published this beat (Ex: BeatStars / AirBit)', 'beatpress') . '</p>';
		echo '<p style="font-size:xx-small; margin-top: -7px;" ><i class="fas fa-info-circle"></i> <em>' . __('Used only with', 'beatpress') . ' <a target="_blank" href="/wp-admin/admin.php?page=beatpress-selling">' . __('External Purchase Mode', 'beatpress') . '</a></em></p><br/>';
		echo '</div>';

		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-list-ol"></i></span> ';
		echo '<label for="beatpress_toolbox_eddnum">' . __( 'EDD Identifier', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<input maxlength="20" class="large-text" placeholder="133" class="text" type="text" id="beatpress_toolbox_eddnum" name="beatpress_toolbox_eddnum" value="' . esc_attr( $eddidentifier ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Type here the Easy Digital Downloads Product ID to link this beat page to the product page.', 'beatpress') . '</p>';
		echo '<p style="font-size:xx-small; margin-top: -7px;" ><i class="fas fa-info-circle"></i> <em>' . __('Used only with', 'beatpress') . ' <a target="_blank" href="/wp-admin/admin.php?page=beatpress-selling">' . __('Easy Digital Downloads Purchase Mode', 'beatpress') . '</a></em></p><br/>';
		echo '</div>';		
		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-user-tag"></i></span> ';
		echo '<label for="beatpress_toolbox_slike">' . __( 'Sounds Like & Type Beat', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<input maxlength="50" class="large-text" placeholder="' . __('Offset X Quavo', 'beatpress') . '" class="text" type="text" id="beatpress_toolbox_slike" name="beatpress_toolbox_slike" value="' . esc_attr( $sliker ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Type here the artist that sounds like this beat. Leave blank to avoid Type Beat references.', 'beatpress') . '</p><br/>';
		echo '</div>';		
				
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="far fa-money-bill-alt"></i></span> ';
		echo '<label for="beatpress_toolbox_lic_mp3">' . __( 'MP3 Lease Price', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<input maxlength="10" class="large-text" placeholder="19.95" class="text" type="text" id="beatpress_toolbox_lic_mp3" name="beatpress_toolbox_lic_mp3" value="' . esc_attr( $pmp3p ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Price that will be showed in the purchase buttons.', 'beatpress') . '</p><br/>';
		echo '</div>';	

		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="far fa-money-bill-alt"></i></span> ';
		echo '<label for="beatpress_toolbox_lic_wav">' . __( 'WAV Lease Price', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<input maxlength="10" class="large-text" placeholder="39.95" class="text" type="text" id="beatpress_toolbox_lic_wav" name="beatpress_toolbox_lic_wav" value="' . esc_attr( $pwavp ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Price that will be showed in the purchase buttons.', 'beatpress') . '</p><br/>';
		echo '</div>';	
	
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="far fa-money-bill-alt"></i></span> ';
		echo '<label for="beatpress_toolbox_lic_premium">' . __( 'Premium Lease Price', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<input maxlength="10" class="large-text" placeholder="99.95" class="text" type="text" id="beatpress_toolbox_lic_premium" name="beatpress_toolbox_lic_premium" value="' . esc_attr( $ppremiump ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Price that will be showed in the purchase buttons.', 'beatpress') . '</p><br/>';
		echo '</div>';	
		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="far fa-money-bill-alt"></i></span> ';
		echo '<label for="beatpress_toolbox_lic_unlimited">' . __( 'Unlimited Lease Price', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<input maxlength="10" class="large-text" placeholder="199.95" class="text" type="text" id="beatpress_toolbox_lic_unlimited" name="beatpress_toolbox_lic_unlimited" value="' . esc_attr( $punlimitedp ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Price that will be showed in the purchase buttons.', 'beatpress') . '</p><br/>';
		echo '</div>';	
		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="far fa-money-bill-alt"></i></span> ';
		echo '<label for="beatpress_toolbox__xclusive">' . __( 'Exclusive Rights Price', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<input maxlength="10" class="large-text" placeholder="999.95" class="text" type="text" id="beatpress_toolbox__xclusive" name="beatpress_toolbox__xclusive" value="' . esc_attr( $pexclusivep ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Price that will be showed in the exclusive rights purchase button, a purchase link will be automatically generated by BeatPress.', 'beatpress') . '</p><br/>';
		echo '</div>';
		
		
		
		
		
		
		
		
		
		
		
		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-user-friends"></i></span> ';
		echo '<label for="beatpress_toolbox_collab">' . __( 'Beat Collaboration', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<input maxlength="25" class="large-text" placeholder="Your Friend\'s Name" class="text" type="text" id="beatpress_toolbox_collab" name="beatpress_toolbox_collab" value="' . esc_attr( $bpcollab ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Is this beat a collab? If yes type the name of your producer friend, if not leave blank.', 'beatpress') . '</p><br/>';
		echo '</div>';	
		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-microphone-alt"></i></span> ';
		echo '<label for="beatpress_toolbox_hook">' . __( 'Beat Contains Hook?', 'beatpress' ) . '</label></em></strong><br/>';
		//echo '<input class="text" type="text" id="beatpress_toolbox_hook" name="beatpress_toolbox_hook" value="' . esc_attr( $bpsold ) . '"   />Text Check<br>';
		echo '<input type="radio" id="beatpress_toolbox_hook" name="beatpress_toolbox_hook" value="no"';
		echo checked( $bphook, 'no' );
		echo '/>' . __('No, this beat doesn\'t contains any hook', 'beatpress') . '<br>';
		echo '<input type="radio" id="beatpress_toolbox_hook" name="beatpress_toolbox_hook" value="yes"';
		echo checked( $bphook, 'yes' );
		echo '/>' . __('Yes, this beat contains a vocal hook', 'beatpress') . '<br>';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Select "Yes" if the beat contains a vocal hook. Leave blank or click "No" to remove any hook reference.', 'beatpress') . '</p><br/>';
		echo '</div>';			
		
		
		
		
		
		
		
		
		
		
		
		
		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-exclamation-circle"></i></span> ';
		echo '<label for="beatpress_toolbox_sold">' . __( 'Exclusively Sold?', 'beatpress' ) . '</label></em></strong><br/>';
		//echo '<input class="text" type="text" id="beatpress_toolbox_sold" name="beatpress_toolbox_sold" value="' . esc_attr( $bpsold ) . '"   />Text Check<br>';
		echo '<input type="radio" id="beatpress_toolbox_sold" name="beatpress_toolbox_sold" value="no"';
		echo checked( $bpsold, 'no' );
		echo '/>' . __('No, I still got the full rights to the beat', 'beatpress') . '<br>';
		echo '<input type="radio" id="beatpress_toolbox_sold" name="beatpress_toolbox_sold" value="yes"';
		echo checked( $bpsold, 'yes' );
		echo '/>' . __('Yes, it has been sold', 'beatpress') . '<br>';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Select "Yes" if the beat has been exclusively sold to remove any download or purchase option. Leave blank or click "No" to mark it as available.', 'beatpress') . '</p><br/>';
		echo '</div>';	
		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-certificate"></i></span> ';
		echo '<label for="beatpress_toolbox_newbeat">' . __( 'Similar Beat Title', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<input maxlength="30" class="large-text" placeholder="Spaceship" class="text" type="text" id="beatpress_toolbox_newbeat" name="beatpress_toolbox_newbeat" value="' . esc_attr( $bpnewbeat ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Once a beat has been exclusively sold there\'s a way to redirect your visitors to a similar beat, type here the title of that similar beat you\'d like to send your visitors to or leave blank to remove similar beat references.', 'beatpress') . '</p><br/>';
		echo '</div>';	
		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-external-link-alt"></i></span> ';
		echo '<label for="beatpress_toolbox_newbeaturl">' . __( 'Similar Beat URL', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<input maxlength="150" class="large-text" placeholder="/instrumentals/spaceship-drake-type-beat" class="text" type="text" id="beatpress_toolbox_newbeaturl" name="beatpress_toolbox_newbeaturl" value="' . esc_attr( $bpnewbeaturl ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*The URL of the similar beat that your visitors will be able to click.', 'beatpress') . '</p><br/>';
		echo '</div>';
		

		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fab fa-youtube"></i></span> ';

		echo '<label for="beatpress_toolbox_yt">' . __( 'YouTube Video ID', 'beatpress' ) . '</label></em></strong><br/>';
		if ($bpyt == '') {
			echo '';
		} else {
			echo '<a style="font-size: 10px; text-decoration: none;" target="_blank" href="https://studio.youtube.com/video/' . esc_attr( $bpyt ) . '/edit"><i class="fas fa-edit"></i> Edit Video on YouTube Studio</a><br>';
		}
		echo '<input maxlength="15" class="large-text" placeholder="lbsC0P8V5fw" class="text" type="text" id="beatpress_toolbox_yt" name="beatpress_toolbox_yt" value="' . esc_attr( $bpyt ) . '"   />';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Type here the YouTube Video ID of that beat if you would like to automatically embed the video on this page. Leave blank to remove YouTube embeds.', 'beatpress') . '</p><br/>';
		echo '</div>';		
		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-comments"></i></span> ';
		echo '<label for="beatpress_toolbox_intro">' . __( 'SEO Introduction', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<textarea rows="5" placeholder="' . __('Write here a brief introduction for that beat, it can be used as the Meta Description so keep it short. Recommended 160 characters maximum.', 'beatpress') . '" maxlength="400" class="large-text" type="text" id="beatpress_toolbox_intro" name="beatpress_toolbox_intro" value="">' . esc_attr( $bpseointro ) . '</textarea>';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*Type here the introduction / excerpt of this beat page. Recommended 160 characters.', 'beatpress') . '</p><br/>';
		echo '</div>';	
		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-align-left"></i></span> ';
		echo '<label for="beatpress_toolbox_p1">' . __( 'SEO Paragraph 1', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<textarea rows="5" placeholder="' . __('Here you can write longer stuff about this beat, you should target multiple and related keywords. I encourage you to make a small keyword research to keep it overperforming.', 'beatpress') . '" maxlength="1000" class="large-text" type="text" id="beatpress_toolbox_p1" name="beatpress_toolbox_p1" value="">' . esc_attr( $bpseop1 ) . '</textarea>';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*This is a SEO Paragraph that will be added to the beat page. Leave them all blank (1, 2 and 3) to remove any paragraph text. Recommended 200 words per paragraph. This paragraph is HTML ready.', 'beatpress') . '</p><br/>';
		echo '</div>';	
		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-align-left"></i></span> ';
		echo '<label for="beatpress_toolbox_p2">' . __( 'SEO Paragraph 2', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<textarea rows="5" placeholder="' . __('You can write more here! Remember, those paragraphs are HTML ready, but your visitors want to listen to your beats, not read about them...', 'beatpress') . '" maxlength="1000" class="large-text" type="text" id="beatpress_toolbox_p2" name="beatpress_toolbox_p2" value="">' . esc_attr( $bpseop2 ) . '</textarea>';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*This is a SEO Paragraph that will be added to the beat page. Leave them all blank (1, 2 and 3) to remove any paragraph text. Recommended 200 words per paragraph. This paragraph is HTML ready.', 'beatpress') . '</p><br/>';
		echo '</div>';			
		
		echo '<div class="wrap"><strong style="font-size: 16px;"><em><span><i class="fas fa-align-left"></i></span> ';
		echo '<label for="beatpress_toolbox_p3">' . __( 'SEO Paragraph 3', 'beatpress' ) . '</label></em></strong><br/>';
		echo '<textarea rows="5" placeholder="' . __('So don\'t write a book for each beat and keep this human readable.', 'beatpress') . '" maxlength="1000" class="large-text" type="text" id="beatpress_toolbox_p3" name="beatpress_toolbox_p3" value="">' . esc_attr( $bpseop3 ) . '</textarea>';
		echo '<p style="font-size:xx-small; margin-top: -1px;" >' . __('*This is a SEO Paragraph that will be added to the beat page. Leave them all blank (1, 2 and 3) to remove any paragraph text. Recommended 200 words per paragraph. This paragraph is HTML ready.', 'beatpress') . '</p><br/>';
		echo '</div>';	

		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
		echo '<p style="font-size: 12px;"><img style="display:inline;" height="32px" width="32px" src="/wp-content/plugins/beatpress/imgs/system/logo.png"><br><i class="far fa-copyright"></i> BeatPress ' . $myversion . '. ' . __('Proudly brought to you by', 'beatpress') . ' <a target="_blank" href="https://github.com/BansheeDevelopment/BeatPress">Banshee</a></p>';

	}

	/**
	 * Generates the HTML for table rows.
	 */
	public function row_format( $label, $input ) {
		return sprintf(
			'<tr><th scope="row">%s</th><td>%s</td></tr>',
			$label,
			$input
		);
	}

	
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['beatpress_toolbox_nonce'] ) )
			return $post_id;

		$nonce = $_POST['beatpress_toolbox_nonce'];
		if ( !wp_verify_nonce( $nonce, 'beatpress_toolbox_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		if ( isset( $_POST['beatpress_toolbox_name'] ) ) {
			$beattitle = sanitize_text_field( $_POST['beatpress_toolbox_name'] );
			update_post_meta( $post_id, 'beatpress_toolbox_name', $beattitle );
		}
 
		if ( isset( $_POST['beatpress_toolbox_buy_external'] ) ) {
			$buyexternal = sanitize_text_field( $_POST['beatpress_toolbox_buy_external'] );
			update_post_meta( $post_id, 'beatpress_toolbox_buy_external', $buyexternal );
		}

		if ( isset( $_POST['beatpress_toolbox_eddnum'] ) ) {
			$eddidentifier = sanitize_text_field( $_POST['beatpress_toolbox_eddnum'] );
			update_post_meta( $post_id, 'beatpress_toolbox_eddnum', $eddidentifier );
		}

		if ( isset( $_POST['beatpress_toolbox_slike'] ) ) {
			$sliker = sanitize_text_field( $_POST['beatpress_toolbox_slike'] );
			update_post_meta( $post_id, 'beatpress_toolbox_slike', $sliker );
		}

		if ( isset( $_POST['beatpress_toolbox_lic_mp3'] ) ) {
			$pmp3p = sanitize_text_field( $_POST['beatpress_toolbox_lic_mp3'] );
			update_post_meta( $post_id, 'beatpress_toolbox_lic_mp3', $pmp3p );
		}

		if ( isset( $_POST['beatpress_toolbox_lic_wav'] ) ) {
			$pwavp = sanitize_text_field( $_POST['beatpress_toolbox_lic_wav'] );
			update_post_meta( $post_id, 'beatpress_toolbox_lic_wav', $pwavp );
		}

		if ( isset( $_POST['beatpress_toolbox_lic_premium'] ) ) {
			$ppremiump = sanitize_text_field( $_POST['beatpress_toolbox_lic_premium'] );
			update_post_meta( $post_id, 'beatpress_toolbox_lic_premium', $ppremiump );
		}
	
		if ( isset( $_POST['beatpress_toolbox_lic_unlimited'] ) ) {
			$punlimitedp = sanitize_text_field( $_POST['beatpress_toolbox_lic_unlimited'] );
			update_post_meta( $post_id, 'beatpress_toolbox_lic_unlimited', $punlimitedp );
		}
	
		if ( isset( $_POST['beatpress_toolbox__xclusive'] ) ) {
			$pexclusivep = sanitize_text_field( $_POST['beatpress_toolbox__xclusive'] );
			update_post_meta( $post_id, 'beatpress_toolbox__xclusive', $pexclusivep );
		}
		
		if ( isset( $_POST['beatpress_toolbox_collab'] ) ) {
			$bpcollab = sanitize_text_field( $_POST['beatpress_toolbox_collab'] );
			update_post_meta( $post_id, 'beatpress_toolbox_collab', $bpcollab );
		}
		
		if ( isset( $_POST['beatpress_toolbox_hook'] ) ) {
			$bphook = sanitize_text_field( $_POST['beatpress_toolbox_hook'] );
			update_post_meta( $post_id, 'beatpress_toolbox_hook', $bphook );
		}
	
		if ( isset( $_POST['beatpress_toolbox_sold'] ) ) {
			$bpsold = sanitize_text_field( $_POST['beatpress_toolbox_sold'] );
			update_post_meta( $post_id, 'beatpress_toolbox_sold', $bpsold );
		}
		
		if ( isset( $_POST['beatpress_toolbox_newbeat'] ) ) {
			$bpnewbeat = sanitize_text_field( $_POST['beatpress_toolbox_newbeat'] );
			update_post_meta( $post_id, 'beatpress_toolbox_newbeat', $bpnewbeat );
		}	
		
		if ( isset( $_POST['beatpress_toolbox_newbeaturl'] ) ) {
			$bpnewbeaturl = sanitize_text_field( $_POST['beatpress_toolbox_newbeaturl'] );
			update_post_meta( $post_id, 'beatpress_toolbox_newbeaturl', $bpnewbeaturl );
		}
		
		if ( isset( $_POST['beatpress_toolbox_yt'] ) ) {
			$bpyt = sanitize_text_field( $_POST['beatpress_toolbox_yt'] );
			update_post_meta( $post_id, 'beatpress_toolbox_yt', $bpyt );
		}	

		if ( isset( $_POST['beatpress_toolbox_intro'] ) ) {
			$bpseointro = sanitize_text_field( $_POST['beatpress_toolbox_intro'] );
			update_post_meta( $post_id, 'beatpress_toolbox_intro', $bpseointro );
		}	

		if ( isset( $_POST['beatpress_toolbox_p1'] ) ) {
			$bpseop1 = wp_kses_post( $_POST['beatpress_toolbox_p1'] );
			update_post_meta( $post_id, 'beatpress_toolbox_p1', $bpseop1 );
		}

		if ( isset( $_POST['beatpress_toolbox_p2'] ) ) {
			$bpseop2 = wp_kses_post( $_POST['beatpress_toolbox_p2'] );
			update_post_meta( $post_id, 'beatpress_toolbox_p2', $bpseop2 );
		}
	
		if ( isset( $_POST['beatpress_toolbox_p3'] ) ) {
			$bpseop3 = wp_kses_post( $_POST['beatpress_toolbox_p3'] );
			update_post_meta( $post_id, 'beatpress_toolbox_p3', $bpseop3 );
		}
			
	}
}
new Rational_Meta_Box;





/*
add_filter( 'the_content', 'filter_the_content_in_the_main_loop' );
 
function filter_the_content_in_the_main_loop( $content ) {
 
     if ( is_post_type_archive ( 'instrumentals' ) ) {
          $content .= 'GOTCHA';
     }
 
    return $content;
}
*/



//AUTOMATICALLY PUT BEATPRESS INTRODUCTION AS EXCERPT

function keep_my_links($text) {
	GLOBAL $post;
	GLOBAL $option_checker;
	
	if ($option_checker['archivestyling'] == 1) {
		
		if($post->post_type == 'instrumentals' ){
		
			$text = '';
			
			$text .= '<a class="playplink_arc" title="' . __('Listen', 'beatpress') . ' ' . get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'name', true ) . ' ' . __('Instrumental', 'beatpress') . '" href="' . get_permalink($post->ID) . '"><span class="text_contfeatured"><i class="fas fa-external-link-alt"></i></span></a>';
		
			$genres = get_the_terms( $post->ID, 'genre' );

		
			if (!$genres[0]->name == '') {
				$text .= '<a href="' . get_term_link($genres[0]) . '"><span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[0]->name ) . '" class="cat_c"><strong><i class="fab fa-slack-hash"></i> ' . $genres[0]->name . '</strong></span></a>';
			}
			if (!$genres[1]->name == '') {
				$text .= '<a href="' . get_term_link($genres[1]) . '"><span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[1]->name ) . '" class="cat_c"><strong><i class="fab fa-slack-hash"></i> ' . $genres[1]->name . '</strong></span></a>';
			}
			if (!$genres[2]->name == '') {
				$text .= '<a href="' . get_term_link($genres[2]) . '"><span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[2]->name ) . '" class="cat_c"><strong><i class="fab fa-slack-hash"></i> ' . $genres[2]->name . '</strong></span></a>';
			}
			if (!$genres[3]->name == '') {
				$text .= '<a href="' . get_term_link($genres[3]) . '"><span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[3]->name ) . '" class="cat_c"><strong><i class="fab fa-slack-hash"></i> ' . $genres[3]->name . '</strong></span></a>';
			}
		
			$text .= '<br>';
			$text .= '<i class="fas fa-align-left"></i> ' . get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'intro', true );
				
		

			return $text;

		} else {

			return $text;
		}
		
	} else {

		return $text;
	}
	
}
//remove_filter('get_the__xcerpt', 'wp_trim__xcerpt');
add_filter('get_the_excerpt', 'keep_my_links');





add_action( 'init', function () {
    $wpseo_front = WPSEO_Frontend::get_instance();

    remove_filter( 'pre_get_document_title', array( $wpseo_front, 'title' ), 15 );
    remove_filter( 'wp_title', array( $wpseo_front, 'title' ), 15 );
} );



function change_my_title($title) {
	
	GLOBAL $option_checker;
	
	if ($option_checker['archivenames'] == 1) {
		
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		
		if( is_tax('genre') ){
			
			
			

			
			return $option_checker['titlefirst'] . ' ' . $term->name . ' ' . $option_checker['titlelast'];
			
		} else {
			
			return $title;
			
		}
		
	} else {
		
		return $title;
		
	}
	
	
}

add_filter('pre_get_document_title', 'change_my_title', 999);
add_filter('wp_title', 'change_my_title', 999);










/*
add_filter('the_content', 'trim_content');

function trim_content($content)
{
    if(is_archive())
    {
        //use your own trick to get the first 50 words. I'm getting the first 100 characters just to show an example.
        $content = (strlen($content) <= 20)? $content : wp_html__xcerpt($content, 20);
    }

    return $content;
}

*/


/*
add_filter('taxonomy_template', 'XXDD');
function XXDD( $template ){

    //Add option for plugin to turn this off? If so just return $template

    //Check if the taxonomy is being viewed 
    //Suggested: check also if the current template is 'suitable'

    if( is_tax('genred') ){
        $template = plugin_dir_path(__FILE__ ) . '/inc/taxonomy-genre.php';
	}
	
    return $template;
}
*/

/*

function my_function( $query ){

    if ( is_tax( 'genre' ) ) {
		$custom_category_text = '<div class="alert alert-block">added text</div>';
		$content = $custom_category_text;
		return $content;
    }
	
}
add_action( 'pre_get_posts', 'my_function' );
add_filter('the_content', 'my_function');
*/






/*

function my_functionx2 ( $query ){
    if ( is_post_type_archive( 'instrumentals' ) ) {
         echo 'Instrumentals Archives';
    }
}
add_action( 'pre_get_posts', 'my_functionx2' );
*/

















/*


    add_filter( 'taxonomy_archive ', 'slug_tax_page_one' );
    function slug_tax_page_one( $template ) {
        if ( is_tax( 'genre' ) ) {
             global $wp_query;
             $page = $wp_query->query_vars['paged'];
            if ( $page = 0 ) {
                $template = get_stylesheet_directory(). '/taxonomy-page-one.php';
				echo 'TEST';
            }
        }

        return $template;

    }
*/



//MODIFY SEARCH TO LOOK ONLY FOR INSTRUMENTALS IF POST_TYPE IS INSTRUMENTALS
function my_pre_get_posts($query) {
	
	$url = '//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	
	if (strpos($url,'&post_type=instrumentals') !== false) {
		if( is_search() && $query->is_main_query() ) {
			$query->set('post_type', 'instrumentals');
		} 		
	}

    if( is_admin() ) 
        return;



}

add_action( 'pre_get_posts', 'my_pre_get_posts', 999 );
































add_action('post_edit_form_tag', 'update_edit_form' );
function update_edit_form() {
    echo ' enctype="multipart/form-data"';
}

function my_test_metabox_out( $post ) {

    $files = get_post_meta( $post->ID, 'bp_streaming_file', true );
    if( ! empty( $files ) ) {
        echo 'Files uploaded:' . "\r\n";
        foreach( $files as $file ) {
            echo '<img src="' . $file['url'] . '" width="100" height="100" />';
        }
        echo "\r\n";
    }
    echo 'Upload files:' . "\r\n";
    echo '<input type="file" name="bp_streaming_file[]" multiple />';

}

add_action( 'save_post', 'my_files_save' );

function my_files_save( $post_id ) {
	
	GLOBAL $option_checker;
	$id = get_the_ID();

    if( ! isset( $_FILES ) || empty( $_FILES ) || ! isset( $_FILES['bp_streaming_file'] ) )
        return 'Not found';

    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }
    //$upload_overrides = array( 'test_form' => false );
	$upload_overrides = array( 'test_form' => false,'unique_filename_callback' => 'my_cust_filename' );


    $files = $_FILES['bp_streaming_file'];
	
    foreach ($files['name'] as $key => $value) {
      if ($files['name'][$key]) {
		
        $uploadedfile = array(
            'name'     => $files['name'][$key],
            'type'     => $files['type'][$key],
            'tmp_name' => $files['tmp_name'][$key],
            'error'    => $files['error'][$key],
            'size'     => $files['size'][$key]
		);
		

        $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
		//@unlink('https://trapbeats.us/wp-content/beatpress/' . $option_checker['producername'] . '_' . $id . $ext);

        if ( $movefile && !isset( $movefile['error'] ) ) {
            $ufiles = get_post_meta( $post_id, 'bp_streaming_file', true );
            if( empty( $ufiles ) ) $ufiles = array();
            $ufiles[] = $movefile;
            update_post_meta( $post_id, 'bp_streaming_file', $ufiles );

        }
		
      }
	  
    }

}

function my_cust_filename($dir, $name, $ext){
	GLOBAL $option_checker;
	$id = get_the_ID();
	$filenamebp = $option_checker['producername'];
	$filenamebp = str_replace(' ', '-', $filenamebp);
	$filenamebp = preg_replace('/[^A-Za-z0-9\-]/', '', $filenamebp);
	if ($ext == '.mp3'){
		return 'beatpress/' . $filenamebp . '_' . $id . '_(free_for_non_profit_only)' . $ext;
	}
	
}

