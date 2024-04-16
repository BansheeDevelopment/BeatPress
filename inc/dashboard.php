<?php
/**
 * BeatPress Dashboard and Options Module
 * Used to display and show all active settings
 *
 * @/inc/dashboard.php
 * @package BeatPress
 */

// Security Layer
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access to BeatPress Script denied.' );
}

/* Display a notice that can be dismissed */

add_action('admin_notices', 'example_admin_notice');
function example_admin_notice() {
	global $current_user ;
	$user_id = $current_user->ID;
	
	/* Check that the user hasn't already clicked to ignore the message */
	
	if ( ! get_user_meta($user_id, 'beatpress_forum_notice_send') ) {
		
        echo '<div class="updated is-dismissible"><p>'; 
        printf(__('Thank you for choosing BeatPress for your bussiness.  Have you checked out our <a target="_blank" href="https://beatpress.surcebeats.com/forum">Forums?</a><span style="float: right;"><a href="%1$s">✖</a></span>'), '?beatpress_forum_notice1=0');
        echo "</p></div>";

	}
	
}

add_action('admin_init', 'beatpress_forum_notice1');
function beatpress_forum_notice1() {
	global $current_user;
	$user_id = $current_user->ID;
	
	/* If user clicks to ignore the notice, add that to their user meta */

	if ( isset($_GET['beatpress_forum_notice1']) && '0' == $_GET['beatpress_forum_notice1'] ) {

		add_user_meta($user_id, 'beatpress_forum_notice_send', 'true', true);
		header('Location: ' . $_SERVER["HTTP_REFERER"] );
		exit;
		
	}
	
}










add_action('admin_menu', 'beatpress_admin_page');
function beatpress_admin_page(){
	add_menu_page( 'BeatPress', 'BeatPress', 'administrator', 'beatpress-dashboard', 'beatpress_dashboard_callback', '/wp-content/plugins/beatpress/imgs/system/dashboard.png', '2' );
	add_submenu_page( 'beatpress-dashboard', '' . __('Dashboard', 'beatpress') . '', '' . __('Dashboard', 'beatpress') . '', 'administrator', 'beatpress-dashboard' );
	add_submenu_page( 'beatpress-dashboard', '' . __('Selling', 'beatpress') . '', '' . __('Selling', 'beatpress') . '', 'administrator', 'beatpress-selling', 'selling_callback' );
	add_submenu_page( 'beatpress-dashboard', '' . __('General', 'beatpress') . '', '' . __('General', 'beatpress') . '', 'administrator', 'beatpress-general', 'general_callback' );
	add_submenu_page( 'beatpress-dashboard', '' . __('Producer', 'beatpress') . '', '' . __('Producer', 'beatpress') . '', 'administrator', 'beatpress-producer-info', 'producer_info_callback' );
	add_submenu_page( 'beatpress-dashboard', '' . __('Licenses', 'beatpress') . '', '' . __('Licenses', 'beatpress') . '', 'administrator', 'beatpress-licenses-info', 'licenses_info_callback' );
	add_submenu_page( 'beatpress-dashboard', '' . __('Catalog', 'beatpress') . '', '' . __('Catalog', 'beatpress') . '', 'administrator', 'beatpress-catalog', 'beatpress_catalog_callback' );
	add_submenu_page( 'beatpress-dashboard', '' . __('Beat Pages', 'beatpress') . '', '' . __('Beat Pages', 'beatpress') . '', 'administrator', 'beatpress-pages', 'beatpages_callback' );
	add_submenu_page( 'beatpress-dashboard', '' . __('Changelog', 'beatpress') . '', '' . __('Changelog', 'beatpress') . '', 'administrator', 'beatpress-changes', 'changelog_callback' );
	add_submenu_page( 'beatpress-dashboard', '' . __('System', 'beatpress') . '', '' . __('System', 'beatpress') . '', 'administrator', 'beatpress-system', 'system_callback' );
}

// Register the settings
add_action('admin_init', 'beatpress_register_settings');
function beatpress_register_settings(){
// Security Check
if (!current_user_can('manage_options')) {
	//	wp_die('' . __('Unauthorized user', 'beatpress') . ''); // HACE CONFLICTO CON EL PLAYLIST Y DA ERROR Unauthorized user
}
    //this will save the option in the wp_options table as 'medinaplugin_settings'
    //the third parameter is a function that will validate your input values
    register_setting('beatpress_settings', 'beatpress_settings', 'beatpress_settings_validate');
	//register_setting( 'beatpress_settings', 'beatpress_settings', array('type' => 'string', 'sanitize_callback' => 'wp_kses_post') ); PETA EN WP 5.3.2

	
	
	
	
	
	
	
}

// Validate the settings
function beatpress_settings_validate($args){
// Security Check
if (!current_user_can('manage_options')) {
	wp_die('' . __('Unauthorized user', 'beatpress') . '');
}
    //$args will contain the values posted in your settings form, you can validate them as no spaces allowed, no special chars allowed or validate emails etc.
    //if(!isset($args['beatpress_email']) || !is_email($args['beatpress_email'])){
    //add a settings error because the email is invalid and make the form field blank, so that the user can enter again
    //$args['beatpress_email'] = '';
    //add_settings_error('beatpress_settings', 'beatpress_invalid_email', 'The typed e-mail address is not valid.', $type = 'error');   
    //}

	
    //make sure you return the args
    return $args;
}


//Display the validation errors and update messages
add_action('admin_notices', 'beatpress_admin_notices');
function beatpress_admin_notices(){
   settings_errors();
}


/*/Preloader for loading Dashboard ******* NOT WORKING IN NEW WP VERSIONS
add_action( 'admin_head', 'dashboard_preloader' );
function dashboard_preloader()
{
?>
<script type="text/javascript">
jQuery(document).ready(function() {
jQuery('body').css('overflow', 'hidden');
});
jQuery(window).load(function() { // makes sure the whole site is loaded
jQuery('#status').fadeOut(); // will first fade out the loading animation
jQuery('.pre-container').fadeOut('fast'); // will fade out the white DIV that covers the website.
jQuery('body').delay(350).css({'overflow':'visible'});
});
</script>
<div class="pre-container"><div class="container"><div class="item item-1"></div><div class="item item-2"></div><div class="item item-3"></div><div class="item item-4"></div></div></div>
<?php
}
*/























// MENU Dashboard
function beatpress_dashboard_callback(){ 

// Security Check
if (!current_user_can('manage_options')) {
	wp_die('' . __('Unauthorized user', 'beatpress') . '');
}

GLOBAL $myversion;
GLOBAL $bpurl;
GLOBAL $option_checker;
settings_fields('beatpress_settings');
$b_published = wp_count_posts( 'instrumentals' )->publish;
$b_scheduled = wp_count_posts( 'instrumentals' )->future;
$b_draft = wp_count_posts( 'instrumentals' )->draft;

?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">
	<link href="/wp-content/plugins/beatpress/css/beatpress_dashboard.css?<?php echo $myversion; ?>" rel="stylesheet" type="text/css" media="all">    <div class="wrap">
	
	<!--<img class="loadingLogo" src="/wp-content/plugins/beatpress/imgs/system/logo.png">-->
    <h2><img style="display:inline; vertical-align: -2px;" height="20px" width="20px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> BeatPress <i class="fas fa-check"></i> <?php _e('Dashboard', 'beatpress'); ?></h2>
    <form action="options.php" method="post"><?php
        settings_fields( 'beatpress_settings' );
        do_settings_sections( __FILE__ );

        //get the older values, wont work the first time
        $options = get_option( 'beatpress_settings' ); 
		
		// Creación de tabs al vuelo
		function admin_tabs($tabs, $current=NULL){
			if(is_null($current)){
				if(isset($_GET['page'])){
					$current = $_GET['page'];
				}
			}
			$content = '';
			$content .= '<h2 class="nav-tab-wrapper">';
			foreach($tabs as $location => $tabname){
				if($current == $location){
					$class = ' nav-tab-active';
				} else{
					$class = '';    
				}
				$content .= '<a class="nav-tab'.$class.'" href="?page='.$location.'">'.$tabname.'</a>';
			}
			$content .= '</h2>';
			return $content;
		}

		$beatpress_tabs = array(
			'beatpress-dashboard' => '<i class="fas fa-check"></i> ' . __('Dashboard', 'beatpress') . '',
			'beatpress-selling' => '<i class="fab fa-paypal"></i> ' . __('Selling', 'beatpress') . '',
			'beatpress-general' => '<i class="fas fa-asterisk"></i> ' . __('General', 'beatpress') . '',
			'beatpress-producer-info' => '<i class="fas fa-headphones"></i> ' . __('Producer', 'beatpress') . '',
			'beatpress-licenses-info' => '<i class="fas fa-file-invoice"></i> ' . __('Licenses', 'beatpress') . '',
			'beatpress-catalog' => '<i class="fas fa-compact-disc"></i> ' . __('Catalog', 'beatpress') . '',
			'beatpress-pages' => '<i class="fas fa-columns"></i> ' . __('Beat Pages', 'beatpress') . '',
			'beatpress-changes' => '<i class="fas fa-list-ol"></i> ' . __('Changelog', 'beatpress') . '',
			'beatpress-system' => '<i class="fas fa-cog"></i> ' . __('System', 'beatpress') . ''
		);

		echo admin_tabs($beatpress_tabs);
				
		?>
		
		 <table class="form-table">
		 
		 <?php 
		if ( date('m/d') == date('09/24') ) {
			 ?>
			 <th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-birthday-cake"></i> <?php _e('Notification', 'beatpress'); ?></h1></th>
			 <tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-birthday-cake"></i> BeatPress</th>
                <td>
                    <fieldset>
                        <label>
							<i class="fas fa-birthday-cake"></i> <?php _e('The first BeatPress version was released today!', 'beatpress'); ?><br><i class="fas fa-birthday-cake"></i> <?php _e('Why not help a fellow producer and let him know about BeatPress? (:', 'beatpress'); ?><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			<?php
		 }
		 ?>
		 
		 
		 <?php 
		if ( date('m/d') == date('04/17') ) {
			 ?>
			 <th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-birthday-cake"></i> <?php _e('Notification', 'beatpress'); ?></h1></th>
			 <tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-birthday-cake"></i> BeatPress</th>
                <td>
                    <fieldset>
                        <label>
							<i class="fas fa-birthday-cake"></i> <?php _e('What\'s up folks, today is Surce\'s birthday, the main developer of BeatPress so... Wish him a happy birthday!', 'beatpress'); ?><br><i class="fas fa-birthday-cake"></i> <a target="_blank" href="https://www.instagram.com/surcebeats">https://www.instagram.com/surcebeats</a><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			<?php
		 }
		 ?>
		 
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-key"></i> BeatPress</h1></th>
			


			
			<tr>
                <th style="cursor:default;" scope="row"><img style="display:inline; vertical-align: -2px;" height="14px" width="14px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> BeatPress</th>
                <td>
                    <fieldset>
                        <label>
							<i class="fas fa-code"></i> <?php _e('Version', 'beatpress'); ?> <?php echo $myversion ?>
							
							<?php bp_help('' . __('The actual BeatPress version this website is running.', 'beatpress') . '', '', '<img style="display:inline;" height="8px" width="8px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> BeatPress') ?>
							
							<br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-key"></i> <?php _e('License', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<i class="fas fa-unlock-alt"></i> <?php _e('Perpetual', 'beatpress'); ?>
							
							<?php bp_help('' . __('This is the type of BeatPress license you have installed in this website.', 'beatpress') . '', '' . __('You can purchase or extend your license to continue getting updates at', 'beatpress') . ' <a class="dashnocolor" target="_blank" href="http://beatpress.surcebeats.com?' . $_SERVER['SERVER_NAME'] . '">http://beatpress.surcebeats.com</a>', '<i class="fas fa-key"></i> ' . __('License', 'beatpress') . '') ?>
							
							<br>
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Your BeatPress license', 'beatpress'); ?>.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-music"></i> <?php _e('Overview', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
                           <strong><i class="fas fa-chart-line"></i> <?php echo $b_published ?></strong> <?php _e('beats published', 'beatpress'); ?><br>
                           <strong><i class="far fa-clock"></i> <?php echo $b_scheduled ?></strong> <?php _e('beats scheduled', 'beatpress'); ?><br>
                           <strong><i class="far fa-question-circle"></i> <?php echo $b_draft ?></strong> <?php _e('beats saved as drafts', 'beatpress'); ?><br>
                           <br>
							<?php 
								$numGenre = wp_count_terms( 'genre', array(
								'hide_empty'=> false,
								'parent'    => 0
							));
							?>
                           <strong><i class="fas fa-equals"></i> <?php echo $numGenre ?></strong> <?php _e('genres', 'beatpress'); ?><br>
						   <?php 
								if ($option_checker['use_beattags'] == 1) {
									$numTags = wp_count_terms( 'beat-tag', array(
									'hide_empty'=> false,
									'parent'    => 0
									));
								} else {
									$numTags = 0;
								}							
							?>
						   <?php 
								if ($option_checker['use_beattags'] == 1) {
									?><strong><i class="fas fa-tags"></i> <?php echo $numTags ?></strong> <?php _e('beat tags', 'beatpress'); ?><br><?php
								} else {
								}
							?>
                        </label>
                    </fieldset>
                </td>
            </tr>
		</table>
		
		<div class="wmess">
        <table class="form-table">
			<h1><i class="far fa-handshake"></i> <?php _e('Thank you for choosing BeatPress for your business!', 'beatpress'); ?></h1>
			<p><?php _e('We care about our business as much as you care about yours. In 2018 we understood and realized that in order', 'beatpress'); ?><br>
			<?php _e('to take our music business and career to the next level we have to take control over everything we offer.', 'beatpress'); ?></p>
			<p><?php _e('That\'s why BeatPress exists, not to fight against the big names in the market, but to remind them that', 'beatpress'); ?><br>
			<?php _e('it shouldn\'t be an all-in-one service. It should be original, something different and completely standalone.', 'beatpress'); ?></p>
			<p><?php _e('You can\'t stand out in an overwhelmed business if you don\'t offer something different to your customers', 'beatpress'); ?><br>
			<?php _e('and audience. That\'s why we are here, and that\'s why we made this possible.', 'beatpress'); ?></p>
			<p><?php _e('If you just don\'t give a foh about SEO for websites then go to', 'beatpress'); ?> <a target="_blank" href="https://www.beatstars.com/?beatpress">BeatStars</a> <?php _e('or', 'beatpress'); ?> <a target="_blank" href="https://airbit.com/?beatpress">AirBit</a> <?php _e('and sign up for an account', 'beatpress'); ?>,<br>
			<?php _e('they\'re really good people and they offer the easiest and most complete services out there.', 'beatpress'); ?></p>
		
			<br><div class="reflejo">
			<figure><img src="/wp-content/plugins/beatpress/imgs/system/logo.png"></figure>
			</div>
			
			<br>
			<h2><i class="fas fa-heart"></i> <?php _e('T h a n k y o u !', 'beatpress'); ?></h2>
			<p style="font-size:xx-small"><?php _e('Made by producers for producers', 'beatpress'); ?><br><?php _e('The BeatPress Team', 'beatpress'); ?></p>
			<p style="font-size:xx-small"><a target="_blank" href="<?php echo $bpurl . '?' . $_SERVER['SERVER_NAME']?>"><?php echo $bpurl ?></a></p>
		</table>
		</div>
		
    </form>
	<hr>
	
	<p style="font-size: 12px;margin-top: 24px;"><img style="display:inline;" height="32px" width="32px" src="/wp-content/plugins/beatpress/imgs/system/logo.png"><br><i class="far fa-copyright"></i> BeatPress <?php echo $myversion ?>. <?php _e('Proudly brought to you by', 'beatpress'); ?> <a target="_blank" href="https://www.banshee.pro">Banshee</a></p>
</div>

<?php }








// MENU Producer Info
function producer_info_callback(){ 

// Security Check
if (!current_user_can('manage_options')) {
	wp_die('' . __('Unauthorized user', 'beatpress') . '');
}
	
GLOBAL $myversion;
GLOBAL $option_checker;
settings_fields('beatpress_settings');

?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">
	<link href="/wp-content/plugins/beatpress/css/beatpress_dashboard.css?<?php echo $myversion; ?>" rel="stylesheet" type="text/css" media="all">    <div class="wrap">
    <h2><img style="display:inline; vertical-align: -2px;" height="20px" width="20px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> BeatPress <i class="fas fa-headphones"></i> <?php _e('Producer', 'beatpress'); ?></h2>
    <form action="options.php" method="post"><?php
        settings_fields( 'beatpress_settings' );
        do_settings_sections( __FILE__ );

        //get the older values, wont work the first time
        $options = get_option( 'beatpress_settings' ); 
		
		// Creación de tabs al vuelo
		function admin_tabs($tabs, $current=NULL){
			if(is_null($current)){
				if(isset($_GET['page'])){
					$current = $_GET['page'];
				}
			}
			$content = '';
			$content .= '<h2 class="nav-tab-wrapper">';
			foreach($tabs as $location => $tabname){
				if($current == $location){
					$class = ' nav-tab-active';
				} else{
					$class = '';    
				}
				$content .= '<a class="nav-tab'.$class.'" href="?page='.$location.'">'.$tabname.'</a>';
			}
			$content .= '</h2>';
			return $content;
		}

		$beatpress_tabs = array(
			'beatpress-dashboard' => '<i class="fas fa-check"></i> ' . __('Dashboard', 'beatpress') . '',
			'beatpress-selling' => '<i class="fab fa-paypal"></i> ' . __('Selling', 'beatpress') . '',
			'beatpress-general' => '<i class="fas fa-asterisk"></i> ' . __('General', 'beatpress') . '',
			'beatpress-producer-info' => '<i class="fas fa-headphones"></i> ' . __('Producer', 'beatpress') . '',
			'beatpress-licenses-info' => '<i class="fas fa-file-invoice"></i> ' . __('Licenses', 'beatpress') . '',
			'beatpress-catalog' => '<i class="fas fa-compact-disc"></i> ' . __('Catalog', 'beatpress') . '',
			'beatpress-pages' => '<i class="fas fa-columns"></i> ' . __('Beat Pages', 'beatpress') . '',
			'beatpress-changes' => '<i class="fas fa-list-ol"></i> ' . __('Changelog', 'beatpress') . '',
			'beatpress-system' => '<i class="fas fa-cog"></i> ' . __('System', 'beatpress') . ''
		);

		echo admin_tabs($beatpress_tabs);
				
		options_stripper_noAPI()
				
		?>
		
		<input class="savbut" style="width: 100%; cursor: pointer; background-color: #66a0ff; border: none; color: white; padding: 10px 27px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;" type="submit" value="<?php _e('Save changes', 'beatpress'); ?>" />

		
    </form>
	
	<p style="font-size: 12px;margin-top: 24px;"><img style="display:inline;" height="32px" width="32px" src="/wp-content/plugins/beatpress/imgs/system/logo.png"><br><i class="far fa-copyright"></i> BeatPress <?php echo $myversion ?>. <?php _e('Proudly brought to you by', 'beatpress'); ?> <a target="_blank" href="https://www.banshee.pro">Banshee</a></p>
</div>

<?php }






















// MENU Producer Info
function licenses_info_callback(){ 

// Security Check
if (!current_user_can('manage_options')) {
	wp_die('' . __('Unauthorized user', 'beatpress') . '');
}
	
GLOBAL $myversion;
GLOBAL $option_checker;
settings_fields('beatpress_settings');

?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">
	<link href="/wp-content/plugins/beatpress/css/beatpress_dashboard.css?<?php echo $myversion; ?>" rel="stylesheet" type="text/css" media="all">    <div class="wrap">
    <h2><img style="display:inline; vertical-align: -2px;" height="20px" width="20px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> BeatPress <i class="fas fa-file-invoice"></i> <?php _e('Licenses', 'beatpress'); ?></h2>
    <form action="options.php" method="post"><?php
        settings_fields( 'beatpress_settings' );
        do_settings_sections( __FILE__ );

        //get the older values, wont work the first time
        $options = get_option( 'beatpress_settings' ); 
		
		// Creación de tabs al vuelo
		function admin_tabs($tabs, $current=NULL){
			if(is_null($current)){
				if(isset($_GET['page'])){
					$current = $_GET['page'];
				}
			}
			$content = '';
			$content .= '<h2 class="nav-tab-wrapper">';
			foreach($tabs as $location => $tabname){
				if($current == $location){
					$class = ' nav-tab-active';
				} else{
					$class = '';    
				}
				$content .= '<a class="nav-tab'.$class.'" href="?page='.$location.'">'.$tabname.'</a>';
			}
			$content .= '</h2>';
			return $content;
		}

		$beatpress_tabs = array(
			'beatpress-dashboard' => '<i class="fas fa-check"></i> ' . __('Dashboard', 'beatpress') . '',
			'beatpress-selling' => '<i class="fab fa-paypal"></i> ' . __('Selling', 'beatpress') . '',
			'beatpress-general' => '<i class="fas fa-asterisk"></i> ' . __('General', 'beatpress') . '',
			'beatpress-producer-info' => '<i class="fas fa-headphones"></i> ' . __('Producer', 'beatpress') . '',
			'beatpress-licenses-info' => '<i class="fas fa-file-invoice"></i> ' . __('Licenses', 'beatpress') . '',
			'beatpress-catalog' => '<i class="fas fa-compact-disc"></i> ' . __('Catalog', 'beatpress') . '',
			'beatpress-pages' => '<i class="fas fa-columns"></i> ' . __('Beat Pages', 'beatpress') . '',
			'beatpress-changes' => '<i class="fas fa-list-ol"></i> ' . __('Changelog', 'beatpress') . '',
			'beatpress-system' => '<i class="fas fa-cog"></i> ' . __('System', 'beatpress') . ''
		);

		echo admin_tabs($beatpress_tabs);
				
		options_stripper_noAPI()
				
		?>
		
		<input class="savbut" style="width: 100%; cursor: pointer; background-color: #66a0ff; border: none; color: white; padding: 10px 27px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;" type="submit" value="<?php _e('Save changes', 'beatpress'); ?>" />

		
    </form>
	
	<p style="font-size: 12px;margin-top: 24px;"><img style="display:inline;" height="32px" width="32px" src="/wp-content/plugins/beatpress/imgs/system/logo.png"><br><i class="far fa-copyright"></i> BeatPress <?php echo $myversion ?>. <?php _e('Proudly brought to you by', 'beatpress'); ?> <a target="_blank" href="https://www.banshee.pro">Banshee</a></p>
</div>

<?php }




























// MENU General
function general_callback(){ 

// Security Check
if (!current_user_can('manage_options')) {
	wp_die('' . __('Unauthorized user', 'beatpress') . '');
}
	
GLOBAL $myversion;
settings_fields('beatpress_settings');
GLOBAL $option_checker;

?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">
	<link href="/wp-content/plugins/beatpress/css/beatpress_dashboard.css?<?php echo $myversion; ?>" rel="stylesheet" type="text/css" media="all">    <div class="wrap">
    <h2><img style="display:inline; vertical-align: -2px;" height="20px" width="20px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> BeatPress <i class="fas fa-asterisk"></i> <?php _e('General', 'beatpress'); ?></h2>
    <form action="options.php" method="post"><?php
        settings_fields( 'beatpress_settings' );
        do_settings_sections( __FILE__ );

        //get the older values, wont work the first time
        $options = get_option( 'beatpress_settings' ); 
		
		// Creación de tabs al vuelo
		function admin_tabs($tabs, $current=NULL){
			if(is_null($current)){
				if(isset($_GET['page'])){
					$current = $_GET['page'];
				}
			}
			$content = '';
			$content .= '<h2 class="nav-tab-wrapper">';
			foreach($tabs as $location => $tabname){
				if($current == $location){
					$class = ' nav-tab-active';
				} else{
					$class = '';    
				}
				$content .= '<a class="nav-tab'.$class.'" href="?page='.$location.'">'.$tabname.'</a>';
			}
			$content .= '</h2>';
			return $content;
		}

		$beatpress_tabs = array(
			'beatpress-dashboard' => '<i class="fas fa-check"></i> ' . __('Dashboard', 'beatpress') . '',
			'beatpress-selling' => '<i class="fab fa-paypal"></i> ' . __('Selling', 'beatpress') . '',
			'beatpress-general' => '<i class="fas fa-asterisk"></i> ' . __('General', 'beatpress') . '',
			'beatpress-producer-info' => '<i class="fas fa-headphones"></i> ' . __('Producer', 'beatpress') . '',
			'beatpress-licenses-info' => '<i class="fas fa-file-invoice"></i> ' . __('Licenses', 'beatpress') . '',
			'beatpress-catalog' => '<i class="fas fa-compact-disc"></i> ' . __('Catalog', 'beatpress') . '',
			'beatpress-pages' => '<i class="fas fa-columns"></i> ' . __('Beat Pages', 'beatpress') . '',
			'beatpress-changes' => '<i class="fas fa-list-ol"></i> ' . __('Changelog', 'beatpress') . '',
			'beatpress-system' => '<i class="fas fa-cog"></i> ' . __('System', 'beatpress') . ''
		);

		echo admin_tabs($beatpress_tabs);
				
		options_stripper_noAPI()
				
		?>
		
		<input class="savbut" style="width: 100%; cursor: pointer; background-color: #66a0ff; border: none; color: white; padding: 10px 27px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;" type="submit" value="<?php _e('Save changes', 'beatpress'); ?>" />

		
    </form>
	
	<p style="font-size: 12px;margin-top: 24px;"><img style="display:inline;" height="32px" width="32px" src="/wp-content/plugins/beatpress/imgs/system/logo.png"><br><i class="far fa-copyright"></i> BeatPress <?php echo $myversion ?>. <?php _e('Proudly brought to you by', 'beatpress'); ?> <a target="_blank" href="https://www.banshee.pro">Banshee</a></p>
</div>

<?php }

































// MENU Selling
function selling_callback(){ 

// Security Check
if (!current_user_can('manage_options')) {
	wp_die('' . __('Unauthorized user', 'beatpress') . '');
}
	
GLOBAL $myversion;
settings_fields('beatpress_settings');
GLOBAL $option_checker;

?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">
	<link href="/wp-content/plugins/beatpress/css/beatpress_dashboard.css?<?php echo $myversion; ?>" rel="stylesheet" type="text/css" media="all">    <div class="wrap">
    <h2><img style="display:inline; vertical-align: -2px;" height="20px" width="20px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> BeatPress <i class="fab fa-paypal"></i> <?php _e('Selling', 'beatpress'); ?></h2>
    <form action="options.php" method="post"><?php
        settings_fields( 'beatpress_settings' );
        do_settings_sections( __FILE__ );

        //get the older values, wont work the first time
        $options = get_option( 'beatpress_settings' ); 
		
		// Creación de tabs al vuelo
		function admin_tabs($tabs, $current=NULL){
			if(is_null($current)){
				if(isset($_GET['page'])){
					$current = $_GET['page'];
				}
			}
			$content = '';
			$content .= '<h2 class="nav-tab-wrapper">';
			foreach($tabs as $location => $tabname){
				if($current == $location){
					$class = ' nav-tab-active';
				} else{
					$class = '';    
				}
				$content .= '<a class="nav-tab'.$class.'" href="?page='.$location.'">'.$tabname.'</a>';
			}
			$content .= '</h2>';
			return $content;
		}

		$beatpress_tabs = array(
			'beatpress-dashboard' => '<i class="fas fa-check"></i> ' . __('Dashboard', 'beatpress') . '',
			'beatpress-selling' => '<i class="fab fa-paypal"></i> ' . __('Selling', 'beatpress') . '',
			'beatpress-general' => '<i class="fas fa-asterisk"></i> ' . __('General', 'beatpress') . '',
			'beatpress-producer-info' => '<i class="fas fa-headphones"></i> ' . __('Producer', 'beatpress') . '',
			'beatpress-licenses-info' => '<i class="fas fa-file-invoice"></i> ' . __('Licenses', 'beatpress') . '',
			'beatpress-catalog' => '<i class="fas fa-compact-disc"></i> ' . __('Catalog', 'beatpress') . '',
			'beatpress-pages' => '<i class="fas fa-columns"></i> ' . __('Beat Pages', 'beatpress') . '',
			'beatpress-changes' => '<i class="fas fa-list-ol"></i> ' . __('Changelog', 'beatpress') . '',
			'beatpress-system' => '<i class="fas fa-cog"></i> ' . __('System', 'beatpress') . ''
		);

		echo admin_tabs($beatpress_tabs);
				
		options_stripper_noAPI()
				
		?>
		
		<input class="savbut" style="width: 100%; cursor: pointer; background-color: #66a0ff; border: none; color: white; padding: 10px 27px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;" type="submit" value="<?php _e('Save changes', 'beatpress'); ?>" />

		
    </form>
	
	<p style="font-size: 12px;margin-top: 24px;"><img style="display:inline;" height="32px" width="32px" src="/wp-content/plugins/beatpress/imgs/system/logo.png"><br><i class="far fa-copyright"></i> BeatPress <?php echo $myversion ?>. <?php _e('Proudly brought to you by', 'beatpress'); ?> <a target="_blank" href="https://www.banshee.pro">Banshee</a></p>
</div>

<?php }



























// MENU BeatPress Catalog
function beatpress_catalog_callback(){ 
// Security Check
if (!current_user_can('manage_options')) {
	wp_die('' . __('Unauthorized user', 'beatpress') . '');
}
GLOBAL $myversion;

?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">
	<link href="/wp-content/plugins/beatpress/css/beatpress_dashboard.css?<?php echo $myversion; ?>" rel="stylesheet" type="text/css" media="all">    <div class="wrap">
    <h2><img style="display:inline; vertical-align: -2px;" height="20px" width="20px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> BeatPress <i class="fas fa-compact-disc"></i> <?php _e('Catalog', 'beatpress'); ?></h2>
    <form action="options.php" method="post"><?php
        settings_fields( 'beatpress_settings' );
        do_settings_sections( __FILE__ );

        //get the older values, wont work the first time
        $options = get_option( 'beatpress_settings' ); 
		
		// Creación de tabs al vuelo
		function admin_tabs($tabs, $current=NULL){
			if(is_null($current)){
				if(isset($_GET['page'])){
					$current = $_GET['page'];
				}
			}
			$content = '';
			$content .= '<h2 class="nav-tab-wrapper">';
			foreach($tabs as $location => $tabname){
				if($current == $location){
					$class = ' nav-tab-active';
				} else{
					$class = '';    
				}
				$content .= '<a class="nav-tab'.$class.'" href="?page='.$location.'">'.$tabname.'</a>';
			}
			$content .= '</h2>';
			return $content;
		}

		$beatpress_tabs = array(
			'beatpress-dashboard' => '<i class="fas fa-check"></i> ' . __('Dashboard', 'beatpress') . '',
			'beatpress-selling' => '<i class="fab fa-paypal"></i> ' . __('Selling', 'beatpress') . '',
			'beatpress-general' => '<i class="fas fa-asterisk"></i> ' . __('General', 'beatpress') . '',
			'beatpress-producer-info' => '<i class="fas fa-headphones"></i> ' . __('Producer', 'beatpress') . '',
			'beatpress-licenses-info' => '<i class="fas fa-file-invoice"></i> ' . __('Licenses', 'beatpress') . '',
			'beatpress-catalog' => '<i class="fas fa-compact-disc"></i> ' . __('Catalog', 'beatpress') . '',
			'beatpress-pages' => '<i class="fas fa-columns"></i> ' . __('Beat Pages', 'beatpress') . '',
			'beatpress-changes' => '<i class="fas fa-list-ol"></i> ' . __('Changelog', 'beatpress') . '',
			'beatpress-system' => '<i class="fas fa-cog"></i> ' . __('System', 'beatpress') . ''
		);

		echo admin_tabs($beatpress_tabs);
		
		options_stripper_noAPI()
				
		?>
		
		<input class="savbut" style="width: 100%; cursor: pointer; background-color: #66a0ff; border: none; color: white; padding: 10px 27px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;" type="submit" value="<?php _e('Save changes', 'beatpress'); ?>" />
		
    </form>
	
	<p style="font-size: 12px;margin-top: 24px;"><img style="display:inline;" height="32px" width="32px" src="/wp-content/plugins/beatpress/imgs/system/logo.png"><br><i class="far fa-copyright"></i> BeatPress <?php echo $myversion ?>. <?php _e('Proudly brought to you by', 'beatpress'); ?> <a target="_blank" href="https://www.banshee.pro">Banshee</a></p>
</div>

<?php }





















// MENU Beat Pages
function beatpages_callback(){ 
// Security Check
if (!current_user_can('manage_options')) {
	wp_die('' . __('Unauthorized user', 'beatpress') . '');
}
GLOBAL $myversion;

?>


	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">
	<link href="/wp-content/plugins/beatpress/css/beatpress_dashboard.css?<?php echo $myversion; ?>" rel="stylesheet" type="text/css" media="all">    <div class="wrap">
    <h2><img style="display:inline; vertical-align: -2px;" height="20px" width="20px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> BeatPress <i class="fas fa-columns"></i> <?php _e('Beat Pages', 'beatpress'); ?></h2>
    <form action="options.php" method="post"><?php
        settings_fields( 'beatpress_settings' );
        do_settings_sections( __FILE__ );

        //get the older values, wont work the first time
        $options = get_option( 'beatpress_settings' ); 
		
		// Creación de tabs al vuelo
		function admin_tabs($tabs, $current=NULL){
			if(is_null($current)){
				if(isset($_GET['page'])){
					$current = $_GET['page'];
				}
			}
			$content = '';
			$content .= '<h2 class="nav-tab-wrapper">';
			foreach($tabs as $location => $tabname){
				if($current == $location){
					$class = ' nav-tab-active';
				} else{
					$class = '';    
				}
				$content .= '<a class="nav-tab'.$class.'" href="?page='.$location.'">'.$tabname.'</a>';
			}
			$content .= '</h2>';
			return $content;
		}

		$beatpress_tabs = array(
			'beatpress-dashboard' => '<i class="fas fa-check"></i> ' . __('Dashboard', 'beatpress') . '',
			'beatpress-selling' => '<i class="fab fa-paypal"></i> ' . __('Selling', 'beatpress') . '',
			'beatpress-general' => '<i class="fas fa-asterisk"></i> ' . __('General', 'beatpress') . '',
			'beatpress-producer-info' => '<i class="fas fa-headphones"></i> ' . __('Producer', 'beatpress') . '',
			'beatpress-licenses-info' => '<i class="fas fa-file-invoice"></i> ' . __('Licenses', 'beatpress') . '',
			'beatpress-catalog' => '<i class="fas fa-compact-disc"></i> ' . __('Catalog', 'beatpress') . '',
			'beatpress-pages' => '<i class="fas fa-columns"></i> ' . __('Beat Pages', 'beatpress') . '',
			'beatpress-changes' => '<i class="fas fa-list-ol"></i> ' . __('Changelog', 'beatpress') . '',
			'beatpress-system' => '<i class="fas fa-cog"></i> ' . __('System', 'beatpress') . ''
		);

		echo admin_tabs($beatpress_tabs);
		
		options_stripper_noAPI()
				
		?>
		
		<input class="savbut" style="width: 100%; cursor: pointer; background-color: #66a0ff; border: none; color: white; padding: 10px 27px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;" type="submit" value="<?php _e('Save changes', 'beatpress'); ?>" />
		
    </form>
	
	
	<p style="font-size: 12px;margin-top: 24px;"><img style="display:inline;" height="32px" width="32px" src="/wp-content/plugins/beatpress/imgs/system/logo.png"><br><i class="far fa-copyright"></i> BeatPress <?php echo $myversion ?>. <?php _e('Proudly brought to you by', 'beatpress'); ?> <a target="_blank" href="https://www.banshee.pro">Banshee</a></p>
</div>

<?php }


















// MENU Changelog
function changelog_callback(){
// Security Check
if (!current_user_can('manage_options')) {
	wp_die('' . __('Unauthorized user', 'beatpress') . '');
}
GLOBAL $myversion;
?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">
	<link href="/wp-content/plugins/beatpress/css/beatpress_dashboard.css?<?php echo $myversion; ?>" rel="stylesheet" type="text/css" media="all">    <div class="wrap">
    <h2><img style="display:inline; vertical-align: -2px;" height="20px" width="20px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> BeatPress <i class="fas fa-list-ol"></i> <?php _e('Changelog', 'beatpress'); ?></h2>
    <form action="options.php" method="post"><?php
		
		// Creación de tabs al vuelo
		function admin_tabs($tabs, $current=NULL){
			if(is_null($current)){
				if(isset($_GET['page'])){
					$current = $_GET['page'];
				}
			}
			$content = '';
			$content .= '<h2 class="nav-tab-wrapper">';
			foreach($tabs as $location => $tabname){
				if($current == $location){
					$class = ' nav-tab-active';
				} else{
					$class = '';    
				}
				$content .= '<a class="nav-tab'.$class.'" href="?page='.$location.'">'.$tabname.'</a>';
			}
			$content .= '</h2>';
			return $content;
		}

		$beatpress_tabs = array(
			'beatpress-dashboard' => '<i class="fas fa-check"></i> ' . __('Dashboard', 'beatpress') . '',
			'beatpress-selling' => '<i class="fab fa-paypal"></i> ' . __('Selling', 'beatpress') . '',
			'beatpress-general' => '<i class="fas fa-asterisk"></i> ' . __('General', 'beatpress') . '',
			'beatpress-producer-info' => '<i class="fas fa-headphones"></i> ' . __('Producer', 'beatpress') . '',
			'beatpress-licenses-info' => '<i class="fas fa-file-invoice"></i> ' . __('Licenses', 'beatpress') . '',
			'beatpress-catalog' => '<i class="fas fa-compact-disc"></i> ' . __('Catalog', 'beatpress') . '',
			'beatpress-pages' => '<i class="fas fa-columns"></i> ' . __('Beat Pages', 'beatpress') . '',
			'beatpress-changes' => '<i class="fas fa-list-ol"></i> ' . __('Changelog', 'beatpress') . '',
			'beatpress-system' => '<i class="fas fa-cog"></i> ' . __('System', 'beatpress') . ''
		);

		echo admin_tabs($beatpress_tabs);
				
		?>
		




        <table class="form-table">
		
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-rocket"></i> <?php _e('Current Version', 'beatpress'); ?></h1></th>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> <?php echo $myversion ?></th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Public Release (Platinum Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (17 / Jun / 2023)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed a bug in the beatpress.js which made changes weren't supposed to be made while listening beats.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added some minor changes in the CSS.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-car"></i> <?php _e('Previous Versions', 'beatpress'); ?></h1></th>
			
			<tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 11.2.46.0101-pm12</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Public Release (Platinum Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (01 / Mar / 2020)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added an option to prevent page authority spread across with beat landing pages (make sure to mark them as noindex if you're going to use this option).</span><br>
                            <span><i class="fas fa-calendar-check"></i> Make sure to mark beat pages as noindex if you're going to use the option.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 11.2.45.2901-pm10</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Public Release (Platinum Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (29 / Jan / 2020)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Bugfixes and improvements.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 11.1.22.3112-pm9</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Public Release (Platinum Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (31 / Dec / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a way to display custom genre catalogs on genre archive pages instead of default WordPress & Theme archive pages.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Support to make the genre catalogs work with most of WordPress Themes without breaking the theme code.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Genre catalogs code injected in active theme directory on BeatPress plugin activation.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added support for WordPress 5.3.2.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Removed some syntax PHP bugs which caused annoying error logs on error_log file.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added Google Analytics code detection via JavaScript to prevent errors and/or code issues.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Redesigned BeatPress Player with white background.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added new controls to BeatPress Players to define new design.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a way to add collaboration artists and a tag to show if it's a beat with hook or not.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			<tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 10.3.4.0710-pm8</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Public Release (Platinum Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (07 / Oct / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added support for Google Analytics Events, now you can track beat plays and some clicks in realtime.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Styling changes in the Dashboard.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed two bugs in the BeatPress CSS stylings which prevented cache plugins to properly minify the styles.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added 'Beat Title' row in the Instrumentals WordPress Panel, sometimes beats were hard to find.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added 'Visit plugin site' button in the WordPress plugins section, I'm a dimbooooooo!</span><br>
                            <span><i class="fas fa-calendar-check"></i> Graphics rebranding D:</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed a bug in jQuery code which prevented it to work when minified with different cache plugins.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Resized PHP processed requests logo to make server handled petitions smaller.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Sanitized some settings fields with wp_kses_post to allow HTML content but no harmful code.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Modified modal boxes background color in mobile devices to fit full height.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fugbixes!</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 10.2.2509-pm2-1</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Public Release (Platinum Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (25 / Sep / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed a bug while uploading MP3s into Instrumentals, we've mistakenly added it while editing text in bulk for translations.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 10.1.2509-pm1-1</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Public Release (Platinum Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (25 / Sep / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Oh sh*t... Here we go again.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 9.25.2409-gm1</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Golden Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (24 / Sep / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added WordPress support for translations.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Deleted Google+ in Sharing Widget since it's no longer available.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Deleted Google+ in BeatPress Tools Widget.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Resized the whole Dashboard to fit translations properly.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 8.11.2209-gm16</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Golden Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (21 / Sep / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed a jQuery/CSS issue where pppspinner never dissapeared.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed a jQuery/CSS issue with pppspinner in the featured beat caller.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added material design animation on catalog clicks.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added scrolling / draggable option on the player bubbles (doesn't work on mobiles).</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a loading circle in the play/pause button using the jPlayer seeking event.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a separator between the latest beat in the catalog and the load more catalog button.</span><br>
                            <span><i class="fas fa-calendar-check"></i> The search bar now does have opacity to fit different website colors and color changes smoothly on hover.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed a problem in the featured beat catalog text description that was showed only with tablet resolutions.</span><br>
                            <span><i class="fas fa-calendar-check"></i> The beatholder class (the beats box showed un in the catalog) now works smoothly with animations.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added an option to hide the SEO Introduction text that's showed by default in the featured beat box.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Redesigned the whole way how external purchase mode works, the workflow was buggy and the available elements too.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added interlinking to external purchase mode to increase interaction and decrease bounce rate.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed a little CSS issue in the beatholder property that appeared when we added an animation.</span><br>
                            <span><i class="fas fa-calendar-check"></i> We've increased the fadeOut animation of the ppplistening property from 7000 to 10000.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a missing space between the play icon and the title.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed CSS opacity in ppplistening property.</span><br>
                            <span><i class="fas fa-calendar-check"></i> I hate to add that so much changes, that means more things to fix bihhhhhhhh.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Removed noopener and noreferer relationships from external links.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed a bug in the plshare property.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed a bug while exclusive buttons weren't getting showed as expected.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed a bug in the purchase buttons, added CSS flexibility, they should fit always.</span><br>
                            <span><i class="fas fa-calendar-check"></i> A lot of deprecated code let's see how do we remove it all without breaking everything.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a small padding in the catalog buttons while modal box is not enabled.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Uncommented and fixed a bunch of deprecated jQuery code.</span><br>
                            <span><i class="fas fa-calendar-check"></i> We've also modified the CSS border-radius of the modal windows to fit the new design.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Removed an absolutely non-sense padding:1px; in modal boxes that caused all text to be blurry in desktops.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added gradient to the modals based on the selected theme color.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Redesigned some elements in the Beatpress Dashboard (yes, here!).</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a preloader while the Dashboard is loading elements.</span><br>
                            <span><i class="fas fa-calendar-check"></i> We've added a new option to the genre boxes at the catalog bottom to show only genres containing more than 5 beats inside.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added support to multiple catalog stylings in the CSS code and PHP queries.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a CSS property to the beat player to avoid users to select text on it.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed some issues in the ppplistening property that wasn't being showed in the same in different websites / themes.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Resized the beat player.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 7.15.1410-g6</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Golden Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (14 / Sep / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added material design on click animation to beatholder class.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Several improvements and tweaks in jQuery player.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Additional state buffering for jQuery player.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed an issue where a class was missed in the featured beat caller.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Removed bugs and added some more as usual, changes are bugs.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 7.12.1010-g4</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Golden Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (12 / Sep / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Changed volume bar to fit audio bar color in all different color schemes.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Encrypted audio paths and BeatPress Direct links are now encrypted with different keys for each website automatically.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 6.08.05010-g3</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Golden Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (10 / Sep / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Loads of tweaks in the now playing section of each beat when you click on a beat.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added multiple catalog viewing options, compact (shrinked catalog) and fluid (wider catalog).</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a way to remove the 'ADD' text from purchase buttons and make them smaller to fit in mobile screens.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixes and improvements in Beatpress stylesheets and CSS code.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixes in the BeatPress Dashboard (yes, it's here!).</span><br>
							<span><i class="fas fa-calendar-check"></i> Fugbixes.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 6.07.26008-g2</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Golden Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (26 / Aug / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added an option to make External Service links nofollow to prevent domain authority drop.</span><br>
							<span><i class="fas fa-calendar-check"></i> Bugs smashed, Surce pest control is on point.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 6.06.1008-g1</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Golden Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (10 / Aug / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added custom PayPal logo at BeatPress Direct checkout pages.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Important issue fixed in the non-intrusive BeatPress advertising parallax.</span><br>
							<span><i class="fas fa-calendar-check"></i> A lot of bugfixing bruh.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 6.05.2405-r4</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Silver Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (24 / May / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Removed the extra subscription button in the 'Latest Beats' module.</span><br>
							<span><i class="fas fa-calendar-check"></i> Added a way to check if Easy Digital Downloads is installed (or active) while Easy Digital Downloads selling mode is active.</span><br>
							<span><i class="fas fa-calendar-check"></i> Added a warning notice to let admin know that Easy Digital Downloads is not installed or active while Easy Digital Downloads selling mode is active.</span><br>
							<span><i class="fas fa-calendar-check"></i> Added some minor changes in the backdash code used in the Genre Archives customization settings.</span><br>
							<span><i class="fas fa-calendar-check"></i> In BeatPress Direct purchases now the website URL will be showed in the receipt and purchase.</span><br>
							<span><i class="fas fa-calendar-check"></i> Changed blue color to darker blue.</span><br>
							<span><i class="fas fa-calendar-check"></i> Fixed round borders issue in the search box (only happening iOS).</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 6.04.1005c-r1</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Silver Master)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (10 / May / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed optional Catalog H1 Heading CSS styling issues.</span><br>
							<span><i class="fas fa-calendar-check"></i> Moved the optional Catalog H1 Heading before the banner (if any).</span><br>
							<span><i class="fas fa-calendar-check"></i> We've introduced BeatPress Documentation, you can now read any option documentation by clicking "<?php bp_help('' . __('Hi there!', 'beatpress') . '', '' . __('I\'m supposed to be a documentation file!', 'beatpress') . '', '<i class="fas fa-life-ring"></i></i> ' . __('I\'m here to help you out!', 'beatpress') . '') ?>".</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 6.03.0305c</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (03 / May / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Minor changes in purchase buttons stylings and @media rules.</span><br>
							<span><i class="fas fa-calendar-check"></i> BeatPress is now able to auto-host its MP3 files, you can upload them right in the ''<a target="_blank" href="/wp-admin/post-new.php?post_type=instrumentals"><i class="fas fa-link"></i> BeatPress Page Generator</a>'' window.</span><br>
							<span><i class="fas fa-calendar-check"></i> Removed bloat code used to make the previous MP3 support work.</span><br>
							<span><i class="fas fa-calendar-check"></i> We've also made changes in the auto-generated Structured Data in each beat page due to Google changes in needed information.</span><br>
							<span><i class="fas fa-calendar-check"></i> Changes in the BeatPress ADs module to make it fit in any WordPress available theme.</span><br>
							<span><i class="fas fa-calendar-check"></i> Changes in the BeatPress ADs module CSS styling.</span><br>
							<span><i class="fas fa-calendar-check"></i> Added BeatStars and Airbit in the social networks panel (aren't they?).</span><br>
							<span><i class="fas fa-calendar-check"></i> Updated auto-included Font Awesome to the latest released version.</span><br>
							<span><i class="fas fa-calendar-check"></i> Fixed some bugs in the MP3 auto-host file system.</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>
						
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 5.33.1704d</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (17 / Apr / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Changed BeatPress Page Generator textarea max values to 500.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Changed BeatPress Page Generator input max values to 150.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added placeholders in the BeatPress Page Generator fields.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added new settings tab ''<i class="fab fa-paypal"></i> Selling'' to select your purchase mode.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added three options to sell your beats (BeatPress Direct, Easy Digital Downloads and External Services) under the ''<i class="fab fa-paypal"></i> Selling'' tab.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a small landing page to the encrypted streaming links.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added the metatags ''noindex nofollow'' to the automatically generated encrypted streaming links pages, some of them were indexed in Google so it's a must.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a small landing page to the automatically generated BeatPress Direct Purchase popup windows.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added the metatags ''noindex nofollow'' to the automatically generated BeatPress Direct Purchase popup windows to prevent indexing.</span><br>
							<span><i class="fas fa-calendar-check"></i> Resized the beats player for better integration in mobile devices.</span><br>
							<span><i class="fas fa-calendar-check"></i> Added <i class="fas fa-circle" style="color: #ef5c38;"></i> Orange, <i class="fas fa-circle" style="color: #df959d;"></i> Pink and <i class="fas fa-circle" style="color: #a6c029;"></i> Limegreen colors.</span><br>
							<span><i class="fas fa-calendar-check"></i> Minor changes in jQuery functions to match theme colors (dependant of jp-play-bar class).</span><br>
                        </label>
                    </fieldset>
                </td>
            </tr>

			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 4.15.0403e</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (04 / Mar / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a play button in the archive pages when the ''Archive Styling'' option is active to decrease bounce rate.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added extra CSS stylings for this new play button.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Minor changes in the JavaScript code to make it able to run together with the following critical error.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Critical error fixed due to a PHP typo which contained an space while generating extra thumbnails for BeatPress stylings.</span><br>
                            <span><i class="fas fa-calendar-check"></i> If you're running into image issues with this version use <a rel="nofollow noopener noreferer" target="_blank" href="https://wordpress.org/plugins/regenerate-thumbnails-advanced/"><i class="fas fa-link"></i> this plugin</a> to regenerate your thumbnails.</span><br>
                            <span><i class="fas fa-info-circle"></i> Fresh installations should not have problems, use the previous plugin <strong>only</strong> if you come from older versions.</span><br><br />
                        </label>
                    </fieldset>
                </td>
            </tr>

			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 4.04.0303e</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (03 / Mar / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> CSS Styling improvements.</span><br>
                           <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
						
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 4.031.2702d</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (27 / Feb / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added support to show producers social networks in catalog page.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added Reddit social network in 'Producer' settings tab.</span><br>
                           <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
	
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 4.03.1702c</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (17 / Feb / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Changes in the the purchase buttons CSS styling, now they look gorgeous, they'll convert more.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added support for different purchase buttons stylings (SuperStars, AeroBit, BeatClick).</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed CSS styling issues with long titled beats, titles were cutted off, not anymore.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed CSS styling in the "ADD" and "Add to cart" buttons.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed some typos, my main language is spanish so...</span><br>
                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 3.54.3001d</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (27 / Jan / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Major changes in the HTML markup for bettwe cross-browser integration.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Major changes in the CSS and JS assets to make the new HTML markup work properly.</span><br>
                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 3.18.2701b</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (27 / Jan / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added a custom BeatPress clearfix for different styling purposes.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added interlinking in the Genre archives for better user experience and internal LinkJuice distribution.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Now it match your BeatPress theme color when you move your mouse around your beats / catalog!</span><br>
                            <span><i class="fas fa-calendar-check"></i> We've created two CSS classes for the genre boxes, the clickable and the informational.</span><br>
                            <span><i class="fas fa-calendar-check"></i> No bugs spotted yet</span><br>
                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 3.16.2001c</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (20 / Jan / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added Disqus support in individual beat pages to increase engagement.</span><br>
                            <span><i class="fas fa-calendar-check"></i> No bugs spotted yet</span><br>
                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 3.12.1701d</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (17 / Jan / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> The previous improvements made in the desktop player weren't working in the Modal Widget Play button, so we've fixed that.</span><br>
                            <span><i class="fas fa-calendar-check"></i> I mean, I've fixed that. I'm a person, not a company... Yet.</span><br>
                            <span><i class="fas fa-calendar-check"></i> What are bugs bro</span><br>
                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 3.06.1601c</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (16 / Jan / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added an option for URL forwarding to external services such as BeatStars or AirBit.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Still no bugs bro let's pray</span><br>
                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
			

            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 3.05.1501e</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (15 / Jan / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Removed the option to show all genres in each beat page, beat pages PageRank was spreading over all genres instead of the related ones.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Removed additional jQuery code to make the genres thing possible in each beat page.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Improvements in the Desktop player, now it shows the beat artwork and the beat name.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Compatibility for WordPress 5.0.3.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Bruhfixing</span><br>
                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
					
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 3.04.0901d</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (09 / Jan / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed CSS classes that weren't properly parsed when using minification processes from cache plugins such as Swift Performance or WP-Rocket.</span><br>
                            <span><i class="fas fa-calendar-check"></i> Added an option to completely disable the Instrumentals taxonomy ''Beat Tags''.</span><br>
                            <span><i class="fas fa-calendar-check"></i> I've added this option to prevent PageRank re-distribution to thin content pages that often are marked by site admins as no-follow.</span><br>
                            <span><i class="fas fa-calendar-check"></i> The bugfixing was intense bro</span><br>
                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
						
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 3.03.0401c</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (04 / Jan / 2019)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed a SEO Yoast integration problem with "the_content" filter used to output the catalog</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed CSS main compatibility problems</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed color scheme metadata</span><br>
                            <span><i class="fas fa-calendar-check"></i> Disabled useless options that may decrease compatibility with popular themes</span><br>
                            <span><i class="fas fa-calendar-check"></i> Fixed a shitload of bugs</span><br>
                            <span><i class="fas fa-calendar-check"></i> New colors added</span><br>
                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 2.83.2312g</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (23 / Dec / 2018)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Compatibility Issues with common WordPress Themes</span><br>
                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			<tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 2.82.2212f</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (22 / Dec / 2018)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Removed PHP Errors</span><br>
                            <span><i class="fas fa-calendar-check"></i> Compatibility for PHP 7.3</span><br>
                            <span><i class="fas fa-calendar-check"></i> Improvements in BeatPress Payment Gateway</span><br>

                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
						
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> 1.53.1412d</th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Stable)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (13 / Dec / 2018)</span><br>
                            <span><i class="fas fa-calendar-check"></i> Bugfixes</span><br>
                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-car-crash"></i> <?php _e('Beta Builds', 'beatpress'); ?></h1></th>
			
            <tr>
                <th scope="row" style="cursor:default;"><i class="far fa-calendar-alt"></i> <?php _e('Beta Builds', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label style="cursor:default;">
                            <span><i class="far fa-calendar-plus"></i> Private Release (Early build)</span><br>
                            <span><i class="far fa-calendar-minus"></i> (01 / Aug / 2018)</span><br><br>
                            <span><i class="fas fa-heart"></i> <?php _e('So many thanks to all our beta-testers and supporters', 'beatpress'); ?><br><strong><a target="_blank" href="https://www.instagram.com/surcebeats/">Surce Beats</a>, <a target="_blank" href="https://www.instagram.com/brainiacbeats/">Brainiac Beats</a>, <a target="_blank" href="https://statickidz.com/">Adrián Barrio</a>, <a target="_blank" href="https://www.instagram.com/clioenllamas/">Clioenllamas</a> <?php _e('and', 'beatpress'); ?> <a target="_blank" href="https://www.instagram.com/fatkingdombeats/">Fat Kingdom</a>.</strong></span><br>
                            <br />
                        </label>
                    </fieldset>
                </td>
            </tr>
			
        </table>
		
    </form>
	<hr>
	
	<p style="font-size: 12px;margin-top: 24px;"><img style="display:inline;" height="32px" width="32px" src="/wp-content/plugins/beatpress/imgs/system/logo.png"><br><i class="far fa-copyright"></i> BeatPress <?php echo $myversion ?>. <?php _e('Proudly brought to you by', 'beatpress'); ?> <a target="_blank" href="https://www.banshee.pro">Banshee</a></p>
</div>

<?php

}






// MENU System
function system_callback(){
// Security Check
if (!current_user_can('manage_options')) {
	wp_die('' . __('Unauthorized user', 'beatpress') . '');
}
GLOBAL $myversion;
GLOBAL $wp_version;
GLOBAL $option_checker;

settings_fields('beatpress_settings');

?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">
	<link href="/wp-content/plugins/beatpress/css/beatpress_dashboard.css?<?php echo $myversion; ?>" rel="stylesheet" type="text/css" media="all">    <div class="wrap">
    <h2><img style="display:inline; vertical-align: -2px;" height="20px" width="20px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> BeatPress <i class="fas fa-cog"></i> <?php _e('System', 'beatpress'); ?></h2>
    <form action="options.php" method="post"><?php
        settings_fields( 'beatpress_settings' );
        do_settings_sections( __FILE__ );

        //get the older values, wont work the first time
        $options = get_option( 'beatpress_settings' ); 
		
		// Creación de tabs al vuelo
		function admin_tabs($tabs, $current=NULL){
			if(is_null($current)){
				if(isset($_GET['page'])){
					$current = $_GET['page'];
				}
			}
			$content = '';
			$content .= '<h2 class="nav-tab-wrapper">';
			foreach($tabs as $location => $tabname){
				if($current == $location){
					$class = ' nav-tab-active';
				} else{
					$class = '';    
				}
				$content .= '<a class="nav-tab'.$class.'" href="?page='.$location.'">'.$tabname.'</a>';
			}
			$content .= '</h2>';
			return $content;
		}

		$beatpress_tabs = array(
			'beatpress-dashboard' => '<i class="fas fa-check"></i> ' . __('Dashboard', 'beatpress') . '',
			'beatpress-selling' => '<i class="fab fa-paypal"></i> ' . __('Selling', 'beatpress') . '',
			'beatpress-general' => '<i class="fas fa-asterisk"></i> ' . __('General', 'beatpress') . '',
			'beatpress-producer-info' => '<i class="fas fa-headphones"></i> ' . __('Producer', 'beatpress') . '',
			'beatpress-licenses-info' => '<i class="fas fa-file-invoice"></i> ' . __('Licenses', 'beatpress') . '',
			'beatpress-catalog' => '<i class="fas fa-compact-disc"></i> ' . __('Catalog', 'beatpress') . '',
			'beatpress-pages' => '<i class="fas fa-columns"></i> ' . __('Beat Pages', 'beatpress') . '',
			'beatpress-changes' => '<i class="fas fa-list-ol"></i> ' . __('Changelog', 'beatpress') . '',
			'beatpress-system' => '<i class="fas fa-cog"></i> ' . __('System', 'beatpress') . ''
		);

		echo admin_tabs($beatpress_tabs);
		
		if(ini_get('memory_limit')) {
			$memory_limit = ini_get('memory_limit');
		} else {
			$memory_limit = __('N/A', 'wp-serverinfo');
		}
		global $wpdb;
		$databasers = $wpdb->get_var("SELECT VERSION() AS version");

				
		?>
        <table class="form-table">


			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-server"></i> <?php _e('Web Server', 'beatpress'); ?></h1></th>
		
			<tr>
                <th style="cursor:default;" scope="row"><img style="display:inline; vertical-align: -2px;" height="14px" width="14px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> <?php _e('BeatPress Version', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<img style="display:inline; vertical-align: -2px;" height="14px" width="14px" src="/wp-content/plugins/beatpress/imgs/system/dashboard.png"> <strong><?php echo $myversion ?></strong><br>
						</label>
                    </fieldset>
                </td>
            </tr>
							
			<tr>
                <th style="cursor:default;" scope="row"><i class="fab fa-wordpress-simple"></i> <?php _e('WordPress Version', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<i class="fab fa-wordpress-simple"></i> <strong><?php echo $wp_version ?></strong>
						</label>
                    </fieldset>
                </td>
            </tr>							
							
			<tr>
                <th style="cursor:default;" scope="row"><i class="fab fa-php"></i> <?php _e('PHP Version', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<i class="fab fa-php"></i> <strong><?php echo phpversion() ?>
							
							<?php bp_help('' . __('Recommended version', 'beatpress') . ' 7.2.18', '', '<i class="fab fa-php"></i> ' . __('PHP Version', 'beatpress') . '') ?>
							
							</strong>
						</label>
                    </fieldset>
                </td>
            </tr>								
					
			<tr>
                <th style="cursor:default;" scope="row"><i class="fab fa-php"></i> <?php _e('Memory Limit', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<i class="fab fa-php"></i> <strong><?php echo $memory_limit ?>
							
							<?php bp_help('' . __('Recommended', 'beatpress') . ' 128M', '', '<i class="fab fa-php"></i> ' . __('Memory Limit', 'beatpress') . '') ?>
							
							</strong>
						</label>
                    </fieldset>
                </td>
            </tr>							

			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-database"></i> <?php _e('Database', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<i class="fas fa-database"></i> <strong><?php echo $databasers ?></strong>
						</label>
                    </fieldset>
                </td>
            </tr>			
							
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-microchip"></i> <?php _e('OS', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<i class="fas fa-microchip"></i> <strong>OS <?php echo PHP_OS ?></strong>
						</label>
                    </fieldset>
                </td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-globe-africa"></i> <?php _e('Domain', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<i class="fas fa-globe-africa"></i> <strong><?php echo get_site_url() ?></strong>
						</label>
                    </fieldset>
                </td>
            </tr>

			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-sitemap"></i> <?php _e('Server', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<i class="fas fa-sitemap"></i> <strong><?php echo $_SERVER["SERVER_SOFTWARE"] ?>
							
							<?php bp_help('' . __('Recommended', 'beatpress') . ' LiteSpeed', '', '<i class="fas fa-sitemap"></i> ' . __('Server', 'beatpress') . '') ?>
							
							</strong>
						</label>
                    </fieldset>
                </td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-map-pin"></i> <?php _e('IP Address', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<i class="fas fa-map-pin"></i> <strong><a href="https://iplocation.com/?ip=<?php echo $_SERVER["SERVER_ADDR"] ?>" target="_blank"><?php echo $_SERVER["SERVER_ADDR"] ?></a>
							
							<?php bp_help('' . __('This is the IP address of your web server, not your internet access IP', 'beatpress') . '', '', '<i class="fas fa-map-pin"></i> ' . __('IP Address', 'beatpress') . '') ?>
							
							</strong>
						</label>
                    </fieldset>
                </td>
            </tr>

        </table>
		
    </form>
	<hr>
	
	<p style="font-size: 12px;margin-top: 24px;"><img style="display:inline;" height="32px" width="32px" src="/wp-content/plugins/beatpress/imgs/system/logo.png"><br><i class="far fa-copyright"></i> BeatPress <?php echo $myversion ?>. <?php _e('Proudly brought to you by', 'beatpress'); ?> <a target="_blank" href="https://www.banshee.pro">Banshee</a></p>
</div>

<?php }







// Show options only if options page is current options page but
// generate hidden objects to make them both save no matter which page is 
function options_stripper_noAPI() {
	GLOBAL $option_checker;
	settings_fields('beatpress_settings');
	
	
	
	







	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// Display Selling Options Only if Page is Selling Options
	if (strpos(curPageURL(), 'beatpress-selling') !== false) {
		?> 
			<table class="form-table">
		<?php
	} else {
		?> 
			<table style="display:none;" class="form-table">	
		<?php
	}
	
	?> 
	
		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-credit-card"></i> <?php _e('Payments', 'beatpress'); ?></h1></th>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-shopping-cart"></i> <?php _e('Purchase Mode', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="radio" name="beatpress_settings[purchasemode]" value="direct" <?php checked('direct', $option_checker['purchasemode'], true); ?> /><?php _e('Sell your beats using BeatPress Direct (Default)', 'beatpress'); ?>
						
						<?php bp_help('' . __('This is the default selling mode of BeatPress. Actually, it doesn\'t handle the files delivery automatically so if you\'re using BeatPress Direct for your leases you should keep in mind that you should send your untagged beats once the payments are received.', 'beatpress') . '', '' . __('This purchase mode is pretty similar to SoundClick since there\'s no automatic delivery, but still useful agaisnt chargebacks. Exclusive rights purchases are always processed using BeatPress Direct.', 'beatpress'). '', '<i class="fas fa-directions"></i>BeatPress Direct') ?>
						
						<br />
						<input type="radio" name="beatpress_settings[purchasemode]" value="edd" <?php checked('edd', $option_checker['purchasemode'], true); ?> /><?php _e('Sell your beats using Easy Digital Downloads', 'beatpress'); ?>
						
						<?php bp_help('' . __('Easy Digital Downloads is an external plugin managed and created by Sandhills Development, we\'ve made BeatPress able to work together with Easy Digital Downloads and handle the beat purchases because we think it\'s the most advanced eCommerce plugin for WordPress out there.', 'beatpress') . '', '' . __('The Easy Digital Downloads team is really professional and they\'re always willing to help releasing documentation about their own plugins, so in long term it\'s the smartest way to work with.', 'beatpress') . '', '<i class="fas fa-file-export"></i> Easy Digital Downloads') ?>
						
						<br />     
						<input type="radio" name="beatpress_settings[purchasemode]" value="external" <?php checked('external', $option_checker['purchasemode'], true); ?> /><?php _e('Sell your beats using an external service (Ex: BeatStars / AirBit)', 'beatpress'); ?>
						
						<?php bp_help('' . __('You can also use BeatPress to link your HTML5 ready and SEO friendly catalog with your external BeatStars ProPage or Airbit Infinity Store. By using the external purchase mode you can easily redirect your customers and listeners to the most advanced beat stores out there.', 'beatpress') . '', '' . __('We really love and respect the hard work BeatStars and Airbit are putting in their projects. They made this possible and who knows, maybe in a near future there are better ways to integrate BeatStars and Airbit with BeatPress.', 'beatpress') . '', '<i class="fas fa-external-link-square-alt"></i> ' . __('External Services', 'beatpress'). '') ?>
						
						<br />   
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <i class="fas fa-directions"></i> <strong>BeatPress Direct</strong>: <?php _e('With this option your website will automatically redirect your customers to a PayPal purchase window', 'beatpress'); ?>.</span><br />     
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <i class="fas fa-file-export"></i> <strong>Easy Digital Downloads</strong>: <?php _e('You will need to install Easy Digital Downloads plugin to make it handle BeatPress purchase requests', 'beatpress'); ?>.</span><br />     
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <i class="fas fa-external-link-square-alt"></i> <strong><?php _e('External', 'beatpress'); ?></strong>: <?php _e('You will need an external service like BeatStars or AirBit to sell your beats, but you\'ll also get the SEO benefits of having your own website', 'beatpress'); ?>.</span><br />     
						
					</label>
				</fieldset>
			</td>
		</tr>
		
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fab fa-paypal"></i> <?php _e('PayPal E-Mail Address', 'beatpress'); ?></th>
			<td>
				<input type="text" placeholder="<?php _e('Your PayPal email', 'beatpress'); ?>" name="beatpress_settings[paypalemail]" value="<?php echo $option_checker['paypalemail']; ?>" />
				
				<?php bp_help('' . __('We need your PayPal email address to handle your sales, even if you\'re not using BeatPress Direct as your main Purchase Mode.', 'beatpress') . '', '' . __('That\'s because exclusive rights purchases are always handled by BeatPress Direct, so you better make sure you type your PayPal address properly!', 'beatpress') . '', '<i class="fab fa-paypal"></i> ' . __('PayPal E-Mail Address', 'beatpress') . '') ?>
				
				<br />
				<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Will be used to handle BeatPress Direct and exclusive purchases at runtime', 'beatpress'); ?>.</span>
			</td>
		</tr>
		
	
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-file-image"></i> <?php _e('Custom PayPal Logo', 'beatpress'); ?></th>
				<td>
				
					<?php
					if(function_exists( 'wp_enqueue_media' )){
						wp_enqueue_media();
					}else{
						wp_enqueue_style('thickbox');
						wp_enqueue_script('media-upload');
						wp_enqueue_script('thickbox');
					}?>

					<?php 
					if ($option_checker['custompplogo'] == '') {
						echo '<img class="header_logo_paypal" src="/wp-content/plugins/beatpress/imgs/system/default_paypal_image.jpg" height="58" width="487"/>';
					} else {
						echo '<img class="header_logo_paypal" src="' . $option_checker['custompplogo'] . '" height="58" width="487"/>';
					}
					?>
					<br />
					<!--<img class="header_logo_paypal" src="<?php echo $option_checker['custompplogo']; ?>" title="Recommended size 64x64" height="64" width="64"/><br />-->
					<input style="display:none;" class="header_logo_paypal_url" type="text" name="beatpress_settings[custompplogo]" size="60" value="<?php echo $option_checker['custompplogo']; ?>"> 
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Recommended size 750 x 90 px', 'beatpress'); ?>.</span>
					
					<?php bp_help('' . __('This image is supposed to be the image that will be showed at the PayPal checkout page when the payments are processed using BeatPress Direct. Recommended size is 750px width and 90px height, if there\'s no image selected this default BeatPress logo will be showed instead.', 'beatpress') . '<br><br><a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/22.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/22.jpg"></a>', '', '<i class="fas fa-image"></i> ' . __('Custom PayPal Logo', 'beatpress'). '') ?>
					
					<br /> 
					<a style="font-size: 12px;" href="#" class="header_logo_paypal_upload"><?php _e('Upload', 'beatpress'); ?></a>					

					<script>
					jQuery(document).ready(function($) {
						$('.header_logo_paypal_upload').click(function(e) {
							e.preventDefault();

							var custom_uploader = wp.media({
								title: '<?php _e('Custom PayPal Logo', 'beatpress'); ?>',
								button: {
									text: '<?php _e('Upload PayPal Logo', 'beatpress'); ?>'
								},
								multiple: false  // Set this to true to allow multiple files to be selected
							})
							.on('select', function() {
								var attachment = custom_uploader.state().get('selection').first().toJSON();
								$('.header_logo_paypal').attr('src', attachment.url);
								$('.header_logo_paypal_url').val(attachment.url);

							})
							.open();
						});
					});
					</script>
							
				</td>
            </tr>
			

		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-lock"></i> <?php _e('Encrypt', 'beatpress'); ?> BeatPress Direct</th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[bpdirectencryptsession]" value="1" <?php checked('1', $option_checker['bpdirectencryptsession']); ?> /> <?php _e('Encrypt', 'beatpress'); ?> BeatPress Direct <?php _e('purchase links', 'beatpress'); ?>
						
						<?php bp_help('' . __('We\'ve created this encryption layer only for BeatPress Direct and exclusive rights purchases, when you enable this option the direct purchase URLs dynamically generated by BeatPress are automatically encrypted with SHA256 protection.', 'beatpress') . '', '' . __('Please enable this option to prevent third parties to modify the purchase price, title or even the license they\'re buying.', 'beatpress') . '', '<i class="fas fa-lock"></i> ' . __('Encrypt', 'beatpress') . ' BeatPress Direct') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Click this option to encrypt the purchase links generated by', 'beatpress'); ?> BeatPress Direct.</span><br />
						<?php
						
						if ($option_checker['bpdirectencryptsession'] == '' || $option_checker['bpdirectencryptsession'] == 0){
							echo '<span style="font-size: xx-small;" class="description"><i class="fas fa-lock-open"></i> ' . __('Currently non encrypted', 'beatpress') . '<br><a target="_blank" href="/?beatpress_direct=true&beat=beat%20name%20example&license=license%20type%20example&purchase=17040075.7"><i class="fas fa-external-link-alt"></i> ' . __('URL Example', 'beatpress') . '</a></span><br />';
						} else {
							echo '<span style="font-size: xx-small;" class="description"><i class="fas fa-lock"></i> ' . __('Purchase links are currently encrypted', 'beatpress') . '<br><a target="_blank" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=beat%20name%20example&license=license%20type%20example&purchase=17040075.7', 'e' ). '"><i class="fas fa-external-link-alt"></i> ' . __('URL Example', 'beatpress') . '</a></span><br /><br />';
						
							?>

							<span style="font-size: xx-small;" class="description"><i class="fas fa-lock"></i> Link Generator</span>
							<br>

							<input type="text" placeholder="<?php _e('Description...', 'beatpress'); ?>" name="beatpress_settings[link_gen_desc]" value="<?php echo $option_checker['link_gen_desc']; ?>" /><br>
							<input type="text" placeholder="<?php _e('License...', 'beatpress'); ?>" name="beatpress_settings[link_gen_license]" value="<?php echo $option_checker['link_gen_license']; ?>" /><br>
							<input type="text" placeholder="<?php _e('Price...', 'beatpress'); ?>" name="beatpress_settings[link_gen_price]" value="<?php echo $option_checker['link_gen_price']; ?>" /><br>

							

							<?php
																				
							echo '<span style="font-size: xx-small;" class="description"><a target="_blank" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $option_checker['link_gen_desc'] . '&license=' . $option_checker['link_gen_license'] . '&purchase=' . $option_checker['link_gen_price'] * 170486 . '', 'e' ). '"><i class="fas fa-external-link-alt"></i> ' . __('Save options to generate', 'beatpress') . '</a></span><br /><br />';
														
						}
						?>
						
					</label>
				</fieldset>
			</td>
		</tr>
		

		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-external-link-square-alt"></i> <?php _e('External Service NoFollow', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[bpexternalnofollow]" value="1" <?php checked('1', $option_checker['bpexternalnofollow']); ?> /> <?php _e('Make External Service links NoFollow', 'beatpress'); ?>
						
						<?php bp_help('' . __('We all know how important it is for SEO purposes to have some dofollow links, but we all should know too that making a bunch of dofollow links inside your side could also make your domain authority decrease.', 'beatpress') . '', '' . __('If you\'d like to enable make your hyperlinks pointing to bsta.rs or air.bi NoFollow just enable this option.', 'beatpress') . '<br><br><i class="fas fa-exclamation-circle"></i>  ' . __('Important: Enabling this option will only work while External Service selling mode is enabled.', 'beatpress') . '', '<i class="fas fa-lock"></i> ' . __('External Service NoFollow', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Enable this option to enable NoFollow rule towards External Service links', 'beatpress'); ?>.</span><br />
					
					</label>
				</fieldset>
			</td>
		</tr>
				

			
        </table>
	<?php
	
	
	
	
	
	
	






	
// Display General Options Only if Page is General Options
	if (strpos(curPageURL(), 'beatpress-general') !== false) {
		?> 
			<table class="form-table">
		<?php
	} else {
		?> 
			<table style="display:none;" class="form-table">	
		<?php
	}
	
	?> 
	

		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-sliders-h"></i> <?php _e('General Settings', 'beatpress'); ?></h1></th>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-heart"></i> <?php _e('Support', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[supportads]" value="1" <?php checked('1', $option_checker['supportads']); ?> /> <?php _e('Do not support BeatPress on my website', 'beatpress'); ?>
						
						<?php bp_help('' . __('By activating this option you can disable the non-intrusive BeatPress banner that\'s showed at the bottom of your catalog and dynamically generated beat pages...', 'beatpress') . '', '' . __('Support your BeatPress family!', 'beatpress') . '<br><br><a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/01.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/01.jpg"></a>', '<i class="fas fa-heart"></i> ' . __('Support', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Hide or show the BeatPress promotional bar on your beat pages and catalog', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-cart-plus"></i> <?php _e('Purchase Button', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[smallpb]" value="1" <?php checked('1', $option_checker['smallpb']); ?> /> <?php _e('Use small purchase button', 'beatpress'); ?>
						
						<?php bp_help('' . __('By activating this option you\'ll make your purchase buttons smaller and BeatPress will hide the "ADD" text next to it.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/26.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/26.jpg"></a>', '<i class="fas fa-cart-plus"></i> ' . __('Purchase Button', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('By activating this option you\'ll make your purchase buttons smaller and BeatPress will hide the "ADD" text next to it', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-align-center"></i> <?php _e('Beat Boxes Styling', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="radio" name="beatpress_settings[fluid]" value="compact" <?php checked('compact', $option_checker['fluid'], true); ?> /> <?php _e('Compact (Default)', 'beatpress'); ?>
						
						<?php bp_help('' . __('This is the default beats viewing and this is how your beats are showed in your catalog and beat pages as soon as you install and activate BeatPress.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/23.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/23.jpg"></a>', '<i class="fas fa-align-center"></i> ' . __('Beat Boxes Styling', 'beatpress') . '') ?>
						
						<br />
						<input type="radio" name="beatpress_settings[fluid]" value="fluid" <?php checked('fluid', $option_checker['fluid'], true); ?> /> <?php _e('Fluid', 'beatpress'); ?>
						
						<?php bp_help('' . __('By activating this option you\'ll make catalog wider and more reliable for mobile devices.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/24.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/24.jpg"></a>', '<i class="fas fa-align-center"></i> ' . __('Beat Boxes Styling', 'beatpress') . '') ?>
						
						<br />     
						<input type="radio" name="beatpress_settings[fluid]" value="fluid-xtrasmall" <?php checked('fluid-xtrasmall', $option_checker['fluid'], true); ?> /> <?php _e('Fluid', 'beatpress'); ?> Xtrasmall
						
						<?php bp_help('' . __('By activating this option you\'ll make catalog wider and more reliable for mobile devices and... Xtra Small, as its name says.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/25.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/25.jpg"></a>', '<i class="fas fa-align-center"></i> ' . __('Beat Boxes Styling', 'beatpress') . '') ?>
						
						<br />   
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Activate this option to change the catalog styling in all your pages', 'beatpress'); ?>.</span>
						
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-paste"></i> <?php _e('Add to Blog Page', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[cptinblog]" value="1" <?php checked('1', $option_checker['cptinblog']); ?> /> <?php _e('Add "Instrumentals" also to blog page', 'beatpress'); ?>
						
						<?php bp_help('' . __('Okay, first you should know that WordPress isn\'t a beat store, it\'s a blog. And what does that mean? That means that you should blog about something related with your craft, that\'s what a SEO should mainly do in a website and... Well, also linkbuilding, but that\'s not our thing here.', 'beatpress') . '', '' . __('Once you know that WordPress is a blog you have to choose if your website is going to have blog posts (to attract a related audience to your products) or it\'s going to be just a beat store thanks to BeatPress. If you\'re not into the blogging thing we encourage you to activate this option and your beats will be showed too as blog posts.', 'beatpress') . '', '<i class="fas fa-paste"></i> ' . __('Add to Blog Page', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Activating this option can lower the positions of your blog posts since now the usual posts and the instrumentals will be showed there', 'beatpress'); ?>.</span><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('By default they\'re separated and added in their own archive', 'beatpress'); ?> (<a target="_blank" href="/instrumentals">/instrumentals</a>), <?php _e('but you can add them to your blog too', 'beatpress'); ?>.</span><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Your blog posts page is', 'beatpress'); ?> <a target="_blank" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ) ?>"><?php echo get_permalink( get_option( 'page_for_posts' ) ) ?></a></span>
						
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-mouse-pointer"></i> <?php _e('Restrict Mouse Actions', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[rightclickselect]" value="1" <?php checked('1', $option_checker['rightclickselect']); ?> /> <?php _e('Disable right click and text selection', 'beatpress'); ?>
						
						<?php bp_help('' . __('We encourage you to keep this option disabled because it can annoy your visitors and customers and that may increase your', 'beatpress') . ' <a class="dashnocolor" target="_blank" href="https://support.google.com/analytics/answer/1009409?hl=en">' . __('bounce rate', 'beatpress') . '</a> ' . __('and impact negatively on your website performance.', 'beatpress') . '', '' . __('We\'ve implemented this option in early builds of BeatPress when streaming links weren\'t encrypted with SHA256 encryption, but since there\'s no direct access to any MP3 files there\'s no reason to keep this option enabled.', 'beatpress') . '<br><br>' . __('By default the direct link to any BeatPress MP3 file is encrypted and processed with the MP3 Server module (which is really, really fast!).', 'beatpress') . '', '<i class="fas fa-mouse-pointer"></i> ' . __('Restrict Mouse Actions', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('By activating this option you\'ll make your visitors unable to right click to inspect element or easily select text from your website', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-share-alt"></i> <?php _e('Sharing Widget', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="radio" name="beatpress_settings[showshare]" value="all" <?php checked('all', $option_checker['showshare'], true); ?> /> <?php _e('Share in beat pages and blog posts', 'beatpress'); ?>
						
						<?php bp_help('' . __('Giving your customers and listeners a way to share your craft is always a way to increase your exposure and reach to a targetted audience, so don\'t miss this option since it\'s really helpful.', 'beatpress') . '', '' . __('By activating this option the sharing widget will be showed in all your landing beat pages and also your regular blog posts (if you\'re into the blogging thing).', 'beatpress') . '<br><br><a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/02.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/02.jpg"></a>', '<i class="fas fa-share-alt"></i> ' . __('Sharing Widget', 'beatpress') . '') ?>
						
						<br />
						<input type="radio" name="beatpress_settings[showshare]" value="beats" <?php checked('beats', $option_checker['showshare'], true); ?> /> <?php _e('Share only in beat pages', 'beatpress'); ?>
						
						<?php bp_help('' . __('Giving your customers and listeners a way to share your craft is always a way to increase your exposure and reach to a targetted audience, so don\'t miss this option since it\'s really helpful.', 'beatpress') . '', '' . __('By activating this option the sharing widget will be showed ONLY in your landing beat pages, that means that regular blog posts will not show the sharing widget.', 'beatpress') . '<br><br><a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/02.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/02.jpg"></a>', '<i class="fas fa-share-alt"></i> ' . __('Sharing Widget', 'beatpress') . '') ?>
						
						<br />     
						<input type="radio" name="beatpress_settings[showshare]" value="no" <?php checked('no', $option_checker['showshare'], true); ?> /> <?php _e('Don\'t show the share buttons', 'beatpress'); ?>
						
						<?php bp_help('' . __('Giving your customers and listeners a way to share your craft is always a way to increase your exposure and reach to a targetted audience, so don\'t miss this option since it\'s really helpful.', 'beatpress') . '', '' . __('By activating this option the sharing widget will not be showed. Your regular blog posts and your landing beat pages will not show the sharing widget :(', 'beatpress') . '<br><br><a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/02.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/02.jpg"></a>', '<i class="fas fa-share-alt"></i> ' . __('Sharing Widget', 'beatpress') . '') ?>
						
						<br />   
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Select where you want to show your visitors the share buttons', 'beatpress'); ?>.</span>
						
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-volume-up"></i> <?php _e('Latest Beats', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="radio" name="beatpress_settings[latestbeatsw]" value="all" <?php checked('all', $option_checker['latestbeatsw'], true); ?> /> <?php _e('Latest beats in beat pages and blog posts', 'beatpress'); ?>
						
						<?php bp_help('' . __('That\'s a great way to increase the click ratio of your visitors and show Google they\'re are interested in your content, it\'s kown that Google takes that in consideration for their search results so the more an user interact with your website the better for your rankings.', 'beatpress') . '', '' . __('By activating this option the latest beats widget will be showed in all your landing beat pages and also your regular blog posts (if you\'re into the blogging thing).', 'beatpress') . '<br><br><a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/03.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/03.jpg"></a>', '<i class="fas fa-volume-up"></i> ' . __('Latest Beats', 'beatpress') . '') ?>
						
						<br />
						<input type="radio" name="beatpress_settings[latestbeatsw]" value="beats" <?php checked('beats', $option_checker['latestbeatsw'], true); ?> /> <?php _e('Latest beats only in beat pages', 'beatpress'); ?>
						
						<?php bp_help('' . __('That\'s a great way to increase the click ratio of your visitors and show Google they\'re are interested in your content, it\'s kown that Google takes that in consideration for their search results so the more an user interact with your website the better for your rankings.', 'beatpress') . '', '' . __('By activating this option the latest beats widget will be showed ONLY in your landing beat pages, that means that regular blog posts will not show the latest beats widget.', 'beatpress') . '<br><br><a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/03.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/03.jpg"></a>', '<i class="fas fa-volume-up"></i> ' . __('Latest Beats', 'beatpress') . '') ?>
						
						<br />     
						<input type="radio" name="beatpress_settings[latestbeatsw]" value="no" <?php checked('no', $option_checker['latestbeatsw'], true); ?> /> <?php _e('Don\'t show the latest beats section', 'beatpress'); ?>
						
						<?php bp_help('' . __('That\'s a great way to increase the click ratio of your visitors and show Google they\'re are interested in your content, it\'s kown that Google takes that in consideration for their search results so the more an user interact with your website the better for your rankings.', 'beatpress') . '', '' . __('By activating this option the latest beats widget will not be showed. Your regular blog posts and your landing beat pages will not show the latest beats widget :(', 'beatpress') . '<br><br><a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/03.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/03.jpg"></a>', '<i class="fas fa-volume-up"></i> ' . __('Latest Beats', 'beatpress') . '') ?>
						
						<br />   
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Select where you want to show your visitors the latest five beats you uploaded', 'beatpress'); ?>.</span>
						
					</label>
				</fieldset>
			</td>
		</tr>

		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-palette"></i> <?php _e('Color Scheme', 'beatpress'); ?></h1></th>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-fill-drip"></i> <?php _e('Select Color', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="radio" name="beatpress_settings[colorschene]" value="default" <?php checked('default', $option_checker['colorschene'], true); ?> /> <i class="fas fa-circle" style="color: #000000;"></i> <?php _e('Default color (Black over White)', 'beatpress'); ?><br />   
						<input type="radio" name="beatpress_settings[colorschene]" value="purple" <?php checked('purple', $option_checker['colorschene'], true); ?> /> <i class="fas fa-circle" style="color: #7a00bc;"></i> <?php _e('Purple (Purple over White)', 'beatpress'); ?><br />   
						<input type="radio" name="beatpress_settings[colorschene]" value="blue" <?php checked('blue', $option_checker['colorschene'], true); ?> /> <i class="fas fa-circle" style="color: #245fbf;"></i> <?php _e('Blue (Blue over White)', 'beatpress'); ?><br />   
						<input type="radio" name="beatpress_settings[colorschene]" value="orange" <?php checked('orange', $option_checker['colorschene'], true); ?> /> <i class="fas fa-circle" style="color: #ef5c38;"></i> <?php _e('Orange (Orange over White)', 'beatpress'); ?><br />   
						<input type="radio" name="beatpress_settings[colorschene]" value="red" <?php checked('red', $option_checker['colorschene'], true); ?> /> <i class="fas fa-circle" style="color: #ce0000;"></i> <?php _e('Red (Red over White)', 'beatpress'); ?><br />   
						<input type="radio" name="beatpress_settings[colorschene]" value="pink" <?php checked('pink', $option_checker['colorschene'], true); ?> /> <i class="fas fa-circle" style="color: #df959d;"></i> <?php _e('Pink (Pink over White)', 'beatpress'); ?><br />   
						<input type="radio" name="beatpress_settings[colorschene]" value="limegreen" <?php checked('limegreen', $option_checker['colorschene'], true); ?> /> <i class="fas fa-circle" style="color: #a6c029;"></i> <?php _e('Limegreen (Limegreen over White)', 'beatpress'); ?><br />   
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('We know there are thousands of colors and themes, so select the color scheme that accurately fits your website', 'beatpress'); ?>.</span>
						
					</label>
				</fieldset>
			</td>
		</tr>
		
		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fab fa-font-awesome"></i> <?php _e('Icon Support', 'beatpress'); ?></h1></th>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fab fa-font-awesome"></i> <?php _e('Include FontAwesome', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[fa_support]" value="1" <?php checked('1', $option_checker['fa_support']); ?> /> <?php _e('Auto-include the latest version of Font Awesome in your website', 'beatpress'); ?>
						
						<?php bp_help('' . __('BeatPress is using the latest version of vector font icons included in Font Awesome, that means that no matter the screen resolution they will be showed always in a great way without the usual blurs that are created by images, they\'ll always look on point.', 'beatpress') . '', '' . __('Font Awesome is not included by default in BeatPress because some WordPress themes are used to auto-include it, so if your website doesn\'t show up the icons that means that you just need to activate this option. We\'ll take care about that.', 'beatpress') . '<br><br><a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/04.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/04.jpg"></a>', '<i class="fab fa-font-awesome"></i> ' . __('Include FontAwesome', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('BeatPress does use Font Awesome instead of images to show up quickly all the icons used by the application', 'beatpress'); ?>.<br> <i class="fa fa-info-circle"></i> <?php _e('If your website doesn\'t show up the icons then enable this option', 'beatpress'); ?>.</strong></span>
						
					</label>
				</fieldset>
			</td>
		</tr>

		
		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-brain"></i> <?php _e('Core Functions', 'beatpress'); ?></h1></th>

		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-archive"></i> <?php _e('Archive Styling', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[archivestyling]" value="1" <?php checked('1', $option_checker['archivestyling']); ?> /> <?php _e('Replace WordPress styling on Instrumentals Archives', 'beatpress'); ?>
						
						<?php bp_help('' . __('We\'ve been dealing with the WordPress stylings for years, until now. There\'s a way to transform those boring archives into something more user friendly. By activating this option you\'ll transform your Genre archives into something perfect for your customers and visitors.', 'beatpress') . '', '' . __('We tried to show a custom genre playlist at the top of each Genre archive, but since there\'s no API or documentation available except creating a child theme template we decided to remove any customized playlist for now, BeatPress is global and it should work with most of the WordPress themes out there, if we create a child theme template we\'ll need to create one for each available theme, such an impossible thing.', 'beatpress') . '<br><br><a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/05.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/05.jpg"></a>', '<i class="fas fa-archive"></i> ' . __('Archive Styling', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('If you check this option the Instrumentals Archives excerpt will be automatically taken from the SEO Introduction option of each beat page', 'beatpress'); ?>.<br> <i class="fa fa-info-circle"></i> <?php _e('In addition, it will also show all the genres of that beat', 'beatpress'); ?>. <strong><?php _e('(Max: 4 genres)', 'beatpress'); ?></strong></span>
						
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-font"></i> <?php _e('Instrumentals Archive Titles', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[archivenames]" value="1" <?php checked('1', $option_checker['archivenames']); ?> /> <?php _e('Replace the title on Instrumentals Archive pages', 'beatpress'); ?>
						
						<?php bp_help('' . __('By enabling this option you can modify the way and the title that Genre archives have to be showed up in Google, it\'s pretty useful because WordPress archives were used to be useless, until now. For each Genre a Genre archive is automatically generated, so play with it here and there and try to make it catchy for Google users.', 'beatpress') . '', '' . __('You can make them all show up in Google as "Buy and Download %GENRE% Beats For Free" or "Download 2019 %GENRE% Beats and Instrumentals", options are endless so play with it accordingly.', 'beatpress') . '<br><br><a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/06.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/06.jpg"></a>', '<i class="fas fa-font"></i> ' . __('Instrumentals Archive Titles', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('If you check this option you\'ll be able to change the default title of the Instrumentals archives', 'beatpress'); ?>.<br> <i class="fa fa-info-circle"></i> <?php _e('Type below how you\'d like to show your beat genre archives', 'beatpress'); ?>.</span><br />
						<input type="text" placeholder="<?php _e('Before', 'beatpress'); ?>" name="beatpress_settings[titlefirst]" value="<?php echo $option_checker['titlefirst']; ?>" /> <strong><?php _e('"GENRE"', 'beatpress'); ?></strong> <input type="text" placeholder="<?php _e('After', 'beatpress'); ?>" name="beatpress_settings[titlelast]" value="<?php echo $option_checker['titlelast']; ?>" /><br />
						<span style="font-size: xx-small;" class="description"><?php _e('Actual example', 'beatpress'); ?>: <u><?php echo $option_checker['titlefirst']; ?> Trap <?php echo $option_checker['titlelast']; ?></u></span>
					</label>
				</fieldset>
			</td>
		</tr>
	
			
        </table>
	<?php
	
	
	
	
	
	








	
	// Display Producer Options Only if Page is Producer Options
	if (strpos(curPageURL(), 'beatpress-producer-info') !== false) {
		?> 
			<table class="form-table">
		<?php
	} else {
		?> 
			<table style="display:none;" class="form-table">	
		<?php
	}
	
	?> 
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-male"></i> <?php _e('Your Information', 'beatpress'); ?></h1></th>
		
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-user-check"></i> <?php _e('Producer Name', 'beatpress'); ?> </th>
				<td>
					<input type="text" placeholder="<?php _e('Who are you fam?', 'beatpress'); ?>" name="beatpress_settings[producername]" value="<?php echo $option_checker['producername']; ?>" />
					
					<?php bp_help('' . __('That is... Your producer name, your A.K.A., your artistic name.', 'beatpress') . '', '' . __('You can also make it work as a team by adding Team at the end of the name if the website you\'re building up is a showcase of different producers.', 'beatpress') . '', '<i class="fas fa-user-check"></i> ' . __('Producer Name', 'beatpress') . '') ?>
					
					<br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Will be used to customize some text fields', 'beatpress'); ?>.</span>
				</td>
            </tr>

			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-envelope-open"></i> <?php _e('Your E-Mail Address', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="<?php _e('Your business email', 'beatpress'); ?>" name="beatpress_settings[businessemail]" value="<?php echo $option_checker['businessemail']; ?>" />
					
					<?php bp_help('' . __('Your personal / business email address, it can be the same as your PayPal address or not so that\'s why there are two email options.', 'beatpress') . '', '' . __('Some people like to keep their businesses separate from their personal life and we have to respect that.', 'beatpress') . '', '<i class="fas fa-envelope-open"></i> ' . __('Your E-Mail Address', 'beatpress') . '') ?>
					
					<br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Will be used to handle in-app contact forms and BeatPress updates via e-mail', 'beatpress'); ?>.</span>
				</td>
            </tr>





			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-image"></i> <? _e('Your Logo', 'beatpress'); ?></th>
				<td>
				
					<?php
					if(function_exists( 'wp_enqueue_media' )){
						wp_enqueue_media();
					}else{
						wp_enqueue_style('thickbox');
						wp_enqueue_script('media-upload');
						wp_enqueue_script('thickbox');
					}?>

					<?php 
					if ($option_checker['producerlogo'] == '') {
						echo '<img class="header_logo" src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog_170.jpg" height="64" width="64"/>';
					} else {
						echo '<img class="header_logo" src="' . $option_checker['producerlogo'] . '" height="64" width="64"/>';
					}
					?>
					
					<?php bp_help('' . __('You may wonder why a business logo should have a help option... Ok, just to let you know to keep it square but also to clarify that BeatPress will not resize this image so please keep the size according to the tiny image that it should be. You can even use a 1024x1024px image, but it will dramatically increase your page speed load time.', 'beatpress') . '', '', '<i class="fas fa-image"></i> ' . __('Your Logo', 'beatpress') . '') ?>
					
					<br />
					<!--<img class="header_logo" src="<?php echo $option_checker['producerlogo']; ?>" title="Recommended size 64x64" height="64" width="64"/><br />-->
					<input style="display:none;" class="header_logo_url" type="text" name="beatpress_settings[producerlogo]" size="60" value="<?php echo $option_checker['producerlogo']; ?>">
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Recommended size 128 x 128 px', 'beatpress'); ?>.</span><br />
					<a style="font-size: 12px;" href="#" class="header_logo_upload"><?php _e('Upload', 'beatpress'); ?></a>					

					<script>
					jQuery(document).ready(function($) {
						$('.header_logo_upload').click(function(e) {
							e.preventDefault();

							var custom_uploader = wp.media({
								title: '<?php _e('Logo Image', 'beatpress'); ?>',
								button: {
									text: '<?php _e('Upload Logo', 'beatpress'); ?>'
								},
								multiple: false  // Set this to true to allow multiple files to be selected
							})
							.on('select', function() {
								var attachment = custom_uploader.state().get('selection').first().toJSON();
								$('.header_logo').attr('src', attachment.url);
								$('.header_logo_url').val(attachment.url);

							})
							.open();
						});
					});
					</script>
							
				</td>
            </tr>
			

			
			
			
			
			
			
		
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			

			
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-users"></i> <?php _e('Social', 'beatpress'); ?></h1></th>
			
			
			
			<tr>
				<th style="cursor:default;" scope="row"><i class="fas fa-user-circle"></i> <?php _e('Links in catalog page', 'beatpress'); ?></th>
				<td>
					<fieldset>
						<label>
							<input type="checkbox" name="beatpress_settings[catalogsnetworks]" value="1" <?php checked('1', $option_checker['catalogsnetworks']); ?> /> <?php _e('Show links to your social networks below your catalog', 'beatpress'); ?>
							
							<?php bp_help('' . __('By activating this option you can showcase a list of icons linking to your social networks at the bottom of your catalog page. Leave blank the social networks you don\'t have an account in to make them don\'t get showed up.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/07.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/07.jpg"></a>', '<i class="fas fa-user-circle"></i> ' . __('Links in catalog page', 'beatpress') . '') ?>
							
							<br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Enable this option to show or hide your social networks below your catalog page', 'beatpress'); ?>.<br />
						</label>
					</fieldset>
				</td>
			</tr>
		
			<tr>
                <th style="cursor:default;" scope="row"><i class="fab fa-twitter"></i> <?php _e('Twitter URL', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="https://..." name="beatpress_settings[twitterlink]" value="<?php echo $option_checker['twitterlink']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Will be used to display a link to your Twitter profile, leave blank to do not display', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fab fa-facebook"></i> <?php _e('Facebook URL', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="https://..." name="beatpress_settings[facebooklink]" value="<?php echo $option_checker['facebooklink']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Will be used to display a link to your Facebook profile, leave blank to do not display', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fab fa-soundcloud"></i> <?php _e('SoundCloud URL', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="https://..." name="beatpress_settings[soundcloudlink]" value="<?php echo $option_checker['soundcloudlink']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Will be used to display a link to your SoundCloud profile, leave blank to do not display', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fab fa-instagram"></i> <?php _e('Instagram URL', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="https://..." name="beatpress_settings[instagramlink]" value="<?php echo $option_checker['instagramlink']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Will be used to display a link to your Instagram profile, leave blank to do not display', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fab fa-youtube"></i> <?php _e('YouTube URL', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="https://..." name="beatpress_settings[youtubelink]" value="<?php echo $option_checker['youtubelink']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Will be used to display a link to your YouTube profile, leave blank to do not display', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fab fa-reddit-alien"></i> <?php _e('Reddit URL', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="https://..." name="beatpress_settings[redditlink]" value="<?php echo $option_checker['redditlink']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Will be used to display a link to your Reddit profile, leave blank to do not display', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fab fa-bootstrap"></i> <?php _e('BeatStars URL', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="https://..." name="beatpress_settings[bstalink]" value="<?php echo $option_checker['bstalink']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Will be used to display a link to your BeatStars profile, leave blank to do not display', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fab fa-autoprefixer"></i> <?php _e('Airbit URL', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="https://..." name="beatpress_settings[airbilink]" value="<?php echo $option_checker['airbilink']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Will be used to display a link to your Airbit profile, leave blank to do not display', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
        </table>
	<?php













	
	// Display License Options Only if Page is Licenses Options
	if (strpos(curPageURL(), 'beatpress-licenses-info') !== false) {
		?> 
			<table class="form-table">
		<?php
	} else {
		?> 
			<table style="display:none;" class="form-table">	
		<?php
	}
	
	?> 
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-file-invoice"></i> <?php _e('First License', 'beatpress'); ?></h1></th>
		
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-sort-numeric-up"></i> <?php _e('License Name', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="<?php _e('Untagged MP3 Lease', 'beatpress'); ?>" name="beatpress_settings[bp_lic_first_name]" value="<?php echo $option_checker['bp_lic_first_name']; ?>" />
					
					<?php bp_help('' . __('Here you can modify the heading, default price and subheading of the first license (commonly the Untagged MP3 Lease / Basic Lease).', 'beatpress') . '<br><br>' . __('Those are the prices that are showed by default in your catalog and in your landing beat pages, if you specify a different price for this license in a single beat page then it will override the default price (this price).', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/08.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/08.jpg"></a>', '<i class="fas fa-file-invoice"></i> ' . __('First License', 'beatpress') . '') ?>
					
					<br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The name of your first license', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-dollar-sign"></i> <?php _e('License Price', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="$19.95" name="beatpress_settings[bp_lic_first_price]" value="<?php echo $option_checker['bp_lic_first_price']; ?>" /> <br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The price of your first license', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-book-open"></i> <?php _e('Sub-Heading', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="<?php _e('MP3', 'beatpress'); ?>" name="beatpress_settings[bp_lic_first_shead]" value="<?php echo $option_checker['bp_lic_first_shead']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The sub-heading of your first license', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			
			
			
			

			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-file-invoice"></i> <?php _e('Second License', 'beatpress'); ?></h1></th>
		
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-sort-numeric-up"></i> <?php _e('License Name', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="<?php _e('Untagged WAV Lease', 'beatpress'); ?>" name="beatpress_settings[bp_lic_second_name]" value="<?php echo $option_checker['bp_lic_second_name']; ?>" />
					
					<?php bp_help('' . __('Here you can modify the heading, default price and subheading of the second license (commonly the Untagged WAV Lease / Silver Lease).', 'beatpress') . '<br><br>' . __('Those are the prices that are showed by default in your catalog and in your landing beat pages, if you specify a different price for this license in a single beat page then it will override the default price (this price).', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/09.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/09.jpg"></a>', '<i class="fas fa-file-invoice"></i> ' . __('Second License', 'beatpress') . '') ?>
					
					<br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The name of your second license', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-dollar-sign"></i> <?php _e('License Price', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="$39.95" name="beatpress_settings[bp_lic_second_price]" value="<?php echo $option_checker['bp_lic_second_price']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The price of your second license', 'beatpress'); ?>.</span>
				</td>
            </tr>

			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-book-open"></i> <?php _e('Sub-Heading', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="<?php _e('WAV', 'beatpress'); ?>" name="beatpress_settings[bp_lic_second_shead]" value="<?php echo $option_checker['bp_lic_second_shead']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The sub-heading of your second license', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			
			
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-file-invoice"></i> <?php _e('Third License', 'beatpress'); ?></h1></th>
		
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-sort-numeric-up"></i> <?php _e('License Name', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="<?php _e('Untagged Premium', 'beatpress'); ?>" name="beatpress_settings[bp_lic_third_name]" value="<?php echo $option_checker['bp_lic_third_name']; ?>" />
					
					<?php bp_help('' . __('Here you can modify the heading, default price and subheading of the third license (commonly the Untagged Premium Lease / Track-outs Lease).', 'beatpress') . '<br><br>' . __('Those are the prices that are showed by default in your catalog and in your landing beat pages, if you specify a different price for this license in a single beat page then it will override the default price (this price).', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/10.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/10.jpg"></a>', '<i class="fas fa-file-invoice"></i> ' . __('Third License', 'beatpress') . '') ?>
					
					<br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The name of your third license', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-dollar-sign"></i> <?php _e('License Price', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="$99.95" name="beatpress_settings[bp_lic_third_price]" value="<?php echo $option_checker['bp_lic_third_price']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The price of your third license', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-book-open"></i> <?php _e('Sub-Heading', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="<?php _e('Trackouts + Stems', 'beatpress'); ?>" name="beatpress_settings[bp_lic_third_shead]" value="<?php echo $option_checker['bp_lic_third_shead']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The sub-heading of your third license', 'beatpress'); ?>.</span>
				</td>
            </tr>


						
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-file-invoice"></i> <?php _e('Fourth License', 'beatpress'); ?></h1></th>
		
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-sort-numeric-up"></i> <?php _e('License Name', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="<?php _e('Untagged Unlimited', 'beatpress'); ?>" name="beatpress_settings[bp_lic_fourth_name]" value="<?php echo $option_checker['bp_lic_fourth_name']; ?>" />
					
					<?php bp_help('' . __('Here you can modify the heading, default price and subheading of the fourth license (commonly the Untagged Unlimited Lease / Unlimited Track-outs Lease).', 'beatpress') . '<br><br>' . __('Those are the prices that are showed by default in your catalog and in your landing beat pages, if you specify a different price for this license in a single beat page then it will override the default price (this price).', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/11.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/11.jpg"></a>', '<i class="fas fa-file-invoice"></i> ' . __('Fourth License', 'beatpress') . '') ?>
					
					<br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The name of your fourth license', 'beatpress'); ?>.</span>
				</td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-dollar-sign"></i> <?php _e('License Price', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="$199.95" name="beatpress_settings[bp_lic_fourth_price]" value="<?php echo $option_checker['bp_lic_fourth_price']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The price of your fourth license', 'beatpress'); ?>.</span>
				</td>
            </tr>

			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-book-open"></i> <?php _e('Sub-Heading', 'beatpress'); ?></th>
				<td>
					<input type="text" placeholder="<?php _e('Trackouts + Stems', 'beatpress'); ?>" name="beatpress_settings[bp_lic_fourth_shead]" value="<?php echo $option_checker['bp_lic_fourth_shead']; ?>" /><br />
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The sub-heading of your fourth license', 'beatpress'); ?>.</span>
				</td>
            </tr>

			
			
			
			
			
        </table>
	<?php















	
	// Display Catalog Options Only if Page is Catalog Options
	if (strpos(curPageURL(), 'beatpress-catalog') !== false) {
		?> 
			<table class="form-table">
		<?php
	} else {
		?> 
			<table style="display:none;" class="form-table">	
		<?php
	}
	
	?> 
	
		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-image"></i> <?php _e('Banner Settings', 'beatpress'); ?></h1></th>

			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-image"></i> <?php _e('Catalog Page Banner', 'beatpress'); ?></th>
				<td>
				
					<?php
					if(function_exists( 'wp_enqueue_media' )){
						wp_enqueue_media();
					}else{
						wp_enqueue_style('thickbox');
						wp_enqueue_script('media-upload');
						wp_enqueue_script('thickbox');
					}?>

					<?php 
					if ($option_checker['catalogbanner'] == '') {
						echo '<img class="catalogbanner" src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog_170.jpg" height="63" width="300"/>';
					} else {
						echo '<img class="catalogbanner" src="' . $option_checker['catalogbanner'] . '" height="63" width="300"/>';
					}
					?>
					
					<br />
					<!--<img class="catalogbanner" src="<?php echo $option_checker['catalogbanner']; ?>" title="Recommended size 64x64" height="64" width="64"/><br />-->
					<input style="display:none;" class="catalog_logo_url" type="text" name="beatpress_settings[catalogbanner]" size="60" value="<?php echo $option_checker['catalogbanner']; ?>">
					<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Recommended size 1920 x 400 px', 'beatpress'); ?>. </span>
					
					<?php bp_help('' . __('That\'s your website banner, pretty similar to a slider, but without all the excess of JavaScript code that it needs and that will increase your website load time for sure. The recommended resolution in pixels is 1920x400 px, but it will fit the width of your catalog page so play with it accordinly.', 'beatpress') . '', '', '<i class="fas fa-image"></i> ' . __('Catalog Page Banner', 'beatpress') . '') ?>
					
					<br />
					<a style="font-size: 12px;" href="#" class="catalogbanner_upload"><?php _e('Upload', 'beatpress'); ?></a>					

					<script>
					jQuery(document).ready(function($) {
						$('.catalogbanner_upload').click(function(e) {
							e.preventDefault();

							var custom_uploader = wp.media({
								title: '<?php _e('Custom Banner', 'beatpress'); ?>',
								button: {
									text: '<?php _e('Upload Banner', 'beatpress'); ?>'
								},
								multiple: false  // Set this to true to allow multiple files to be selected
							})
							.on('select', function() {
								var attachment = custom_uploader.state().get('selection').first().toJSON();
								$('.catalogbanner').attr('src', attachment.url);
								$('.catalog_logo_url').val(attachment.url);

							})
							.open();
						});
					});
					</script>
							
				</td>
            </tr>
			
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-images"></i> <?php _e('Catalog Banner Title', 'beatpress'); ?></th>
			<td>
				<input type="text" placeholder="<?php _e('Type related keywords...', 'beatpress'); ?>" name="beatpress_settings[bannertitle_override]" value="<?php echo $option_checker['bannertitle_override']; ?>" />
				
				<?php bp_help('' . __('Here you should type some related keywords and with your domain, also keyword variations are useful but don\'t make it look spammy. Try to put as many possible keywords but making an understandable 20/25 words sentence, it\'s still useful for SEO purposes.', 'beatpress') . '<br><br>' . __('Example: Trap Beats and Trap Instrumentals - The best place to download Trap Beats and Instrumentals for your next album or mixtape!', 'beatpress') . '<br><br><a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/12.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/12.jpg"></a>', '', '<i class="fas fa-images"></i> ' . __('Catalog Banner Title', 'beatpress') . '') ?>
				
				<br />
				<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Specify the "alt" and "title" attributes of your catalog page banner', 'beatpress'); ?>.</span>
			</td>
        </tr>	
		
		
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-sliders-h"></i> <?php _e('Catalog Settings', 'beatpress'); ?></h1></th>
	
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-align-left"></i> <?php _e('Display page title', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<?php $frontpage_id = get_option( 'page_on_front' ); ?>

						<input type="checkbox" name="beatpress_settings[catalogpagetitle]" value="1" <?php checked('1', $option_checker['catalogpagetitle']); ?> /> <?php _e('Show the title of your catalog page', 'beatpress'); ?>
						
						<?php bp_help('' . __('That\'s not the same title as the previous option title, that\'s the title of your catalog page. It\'s automatically extracted from the WordPress page you\'ve selected as the catalog page (usually the front page).', 'beatpress') . '<br><br>' . __('It will be showed up as an H1 heading, the most important heading for SEO purposes so if you can\'t see any title on your catalog page you better keep this option enabled, some themes doesn\'t show the H1 heading if the content is dynamically generated.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/13.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/13.jpg"></a><br><br><a class="dashnocolor" target="_blank" href="/wp-admin/post.php?post=' . $frontpage_id . '&action=edit&classic-editor"><i class="fas fa-external-link-alt"></i> ' . __('Edit your Front Page title here', 'beatpress') . '</a>', '<i class="fas fa-align-left"></i> ' . __('Display page title', 'beatpress') . '');?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the title of your catalog page straight before your catalog page, that\'s a must for SEO purposes', 'beatpress'); ?>.<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Some themes don\'t show the title by default when the content is dynamically generated so thats why that option is here', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-sliders-h"></i> <?php _e('Use Modal Box', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[enablemodalbox]" value="1" <?php checked('1', $option_checker['enablemodalbox']); ?> /> <?php _e('Use modal box instead of slides to show purchase buttons', 'beatpress'); ?>
						
						<?php bp_help('' . __('BeatPress has two ways to display the purchase buttons in your beats catalog, by using slides (the default) and by using a modal popup (or commonly modal box). Both of them are responsive and SEO friendly, but in mobile devices we think the conversion rate is higher by using modal boxes.', 'beatpress') . '<br><br>' . __('The best way to know if you need to use slides (this option disabled) or modal boxes (this option enabled) is to try them both. In our private tests the slides performed better in SEO terms and rankings, but most of the leads came from modal boxes so feel free to choose the one you like the most.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/14.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/14.jpg"></a>', '<i class="fas fa-sliders-h"></i> ' . __('Use Modal Box', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Use Modal Boxes (inner popups) instead of jQuery slides to show the purchase buttons on your beats catalog', 'beatpress'); ?>.<br />
					</label>
				</fieldset>
			</td>
		</tr>
			
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-compact-disc"></i> <?php _e('Catalog Page', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<?php $args = array( 'echo' => 1, 'selected' => $option_checker['catalogurl'], 'name'  => 'beatpress_settings[catalogurl]'); wp_dropdown_pages($args); ?> 
						
						<?php bp_help('' . __('In order to show your catalog first you need to create a catalog page, and then select here that page that you\'ve just created. You may think... Oh why? Because BeatPress can be installed in fresh WordPress installations and also in already developed websites trying to migrate and redesign the whole thing, that\'s why we don\'t want to automatically create pages in any website.', 'beatpress') . '', '' . __('You can create a new page', 'beatpress') . ' <a class="dashnocolor" target="_blank" href="/wp-admin/post-new.php?post_type=page">' . __('right here', 'beatpress') . '</a> ' . __('and if needed, you should be able to select it as the Front Page in your Theme Options.', 'beatpress') . '', '<i class="fas fa-compact-disc"></i> ' . __('Catalog Page', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The page where your complete beats catalog will be showed', 'beatpress'); ?></span><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Current URL:', 'beatpress'); ?> <strong><a target="_blank" href="<?php echo get_permalink( $option_checker['catalogurl'] ); ?>"><?php echo get_permalink( $option_checker['catalogurl'] ); ?></a></strong></span><br />
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-align-left"></i> <?php _e('SEO Paragraph 1', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<textarea cols="70" rows="5" type="textarea" placeholder="<?php _e('I think you should write some stuff here...', 'beatpress'); ?>" name="beatpress_settings[catalogseo1]"><?php echo $option_checker['catalogseo1']; ?></textarea>
						
						<?php bp_help('' . __('What\'s a SEO Paragraph? Well, keep in mind that BeatPress is a SEO focused plugin, that means that everything we implement in the source code is focused in Search Engine Optimization, everyone in the game is doing a great game in YouTube SEO but what about websites? An iFrame is just not enough to get into leads, and we all are missing the 40% of internet traffic in sales and exposure because of that, it\'s in your hands to change that or not, that\'s why BeatPress exists.', 'beatpress') . '', '' . __('The recommended lenght of that SEO Paragraph is at least 2500 well written words with understandable sentences, Google doesn\'t like empty phrases so that means no spinned texts, no plagiarized texts and always SEO focused, targeting as many related keywords as possible. If you think 2500 words is not enough you can take it to 5k or even 10k, set your own limit and test yourself! It\'s HTML ready so feel free to play with it if you know what you doing.', 'beatpress') . '', '<i class="fas fa-align-left"></i> ' . __('SEO Paragraph 1', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Type here what you\'d like to show in below the title (if existing) of your Catalog page', 'beatpress'); ?>.<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Leave blank to disable SEO Paragraph 1', 'beatpress'); ?>.</span><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Recommended: 2500 words minimum', 'beatpress'); ?>.</span><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('*This paragraph is HTML ready', 'beatpress'); ?>. </span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-align-left"></i> <?php _e('Licenses HTML Code', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<textarea cols="70" rows="5" type="textarea" placeholder="<?php _e('I think you should write some stuff here too...', 'beatpress'); ?>" name="beatpress_settings[catalogpricing]"><?php echo $option_checker['catalogpricing']; ?></textarea>
						
						<?php bp_help('' . __('This text box works as the previous SEO Paragraph, but it\'s intended to show your different beat licenses and prices.', 'beatpress') . '', '' . __('Keep it short and feel free to place even the CSS code right here.', 'beatpress') . '', '<i class="fas fa-align-left"></i> ' . __('Licenses HTML Code', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Almost any professional WordPress theme contains a Pricing Table module, paste the output HTML code here', 'beatpress'); ?>.<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('It will be showed at the very bottom of your catalog page, below the bottom SEO Paragraph', 'beatpress'); ?>.</span><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Leave blank to disable Licenses HTML Code', 'beatpress'); ?>.</span><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('*This paragraph is HTML ready', 'beatpress'); ?>. </span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-ban"></i> <?php _e('Display Sold Beats', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[displaysoldcatalog]" value="1" <?php checked('1', $option_checker['displaysoldcatalog']); ?> /> <?php _e('Show the exclusively sold beats', 'beatpress'); ?>
						
						<?php bp_help('' . __('There\'s no need to explain what this option does, but there are a few things you should know about. If the option to show the exclusively sold beats is active and you want to move a beat to the bottom of your playlist you just need to go to the', 'beatpress') . ' <a class="dashnocolor" target="_blank" href="/wp-admin/edit.php?post_type=instrumentals">' . __('Instrumentals', 'beatpress') . '</a> ' . __('menu, find the beat that was exclusively sold and click on "Quick Edit".', 'beatpress') . '', '' . __('Then you just have to modify the year date (which is the creation date) of that beat, for example:', 'beatpress') . '<br><br><em>05-May 06, 2005 @ 17:53</em><br>' . __('instead of', 'beatpress') . '<br><em>05-May 06, ' . date("Y") . ' @ 17:53</em>.', '<i class="fas fa-align-left"></i> ' . __('Display Sold Beats', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the beats exclusively sold or marked as sold, they will be still playable', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-external-link-alt"></i> <?php _e('Open in new window', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[opennewwindowcatalog]" value="1" <?php checked('1', $option_checker['opennewwindowcatalog']); ?> /> <?php _e('Open your beats in a new window', 'beatpress'); ?>
						
						<?php bp_help('' . __('By enabling this option you can make your visitors open a new page each time they click on any download button. That\'s sometimes helpful to increase the time each user has your page open and would decrease the bounce rate.', 'beatpress') . '', '' . __('Keep in mind that you should keep this option deactivated by default and enable it only if you see that\'s performing worse than usual.', 'beatpress') . '', '<i class="fas fa-external-link-alt"></i> ' . __('Open in new window', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('By default beats are opened in the same window when click on a beat link straight in the the catalog section', 'beatpress'); ?>.</span><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Your beat pages will be opened in a new window if you activate this option', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-sort-numeric-down"></i> <?php _e('Beats to display', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<select name="beatpress_settings[defaultbeatscatalog]" selected="<?php echo $option_checker['defaultbeatscatalog']; ?>">
							<option value="10" <?php echo $option_checker['defaultbeatscatalog'] == 10 ? ' selected ' : ' dis '; ?> >10</option>
							<option value="15" <?php echo $option_checker['defaultbeatscatalog'] == 15 ? ' selected ' : ' dis '; ?> >15</option>
							<option value="20" <?php echo $option_checker['defaultbeatscatalog'] == 20 ? ' selected ' : ' dis '; ?> >20</option>
							<option value="25" <?php echo $option_checker['defaultbeatscatalog'] == 25 ? ' selected ' : ' dis '; ?> >25</option>
							<option value="30" <?php echo $option_checker['defaultbeatscatalog'] == 30 ? ' selected ' : ' dis '; ?> >30</option>
						</select>
						<?php _e('beats', 'beatpress'); ?>
						
						<?php bp_help('' . __('The amount of beats that can be showed at once should be defined by how powerful your webhost is, the more powerful the more beats you can show at once. The recommended value for small and cheap webhosts is 10 or 15, for powerful and up-to-date webhosts the recommended value is 30.', 'beatpress') . '', '' . __('This is a heavy task for your webhost so please select a suitable option for it. If your website is hosted in a small and cheap webhost and you start receiving more and more visits your website could get down.', 'beatpress') . '', '<i class="fas fa-sort-numeric-down"></i> ' . __('Beats to display', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The number of beats that will be displayed by default on your beats catalog page', 'beatpress'); ?>.</span><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('*This is a heavy task for your web server, recommended value from 10 to 20', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-search"></i> <?php _e('Beats Search', 'beatpress'); ?></h1></th>

		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-search"></i> <?php _e('Display Search Box', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[searchbox_top]" value="1" <?php checked('1', $option_checker['searchbox_top']); ?> /> <?php _e('Display the search box on the top of the catalog', 'beatpress'); ?>
						
						<?php bp_help('' . __('Imagine that you\'re looking for a concrete beat and you can\'t find it in the catalog, it\'s such a frustrating user and customer experience. That\'s why this option is here, to make your visitors and customers able to search within your beats by tag, genres, names or even titles. It also decrease the bounce rate so it should be a must.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/15.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/15.jpg"></a><br><br><i class="fas fa-exclamation-circle"></i> ' . __('Important: Enabling this option will show the search box in your catalog page, if you want to show it also in your landing beat pages you have to enable it too if you want to show it in your', 'beatpress') . ' <i class="fas fa-columns"></i> ' . __('Beat Pages', 'beatpress') . '.', '<i class="fas fa-search"></i> ' . __('Display Search Box', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('With this options your visitors will be able to search within your beats by beat name, artist type, tag, genres...', 'beatpress'); ?></span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<th id="featureselect" style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-award"></i> <?php _e('Featured Beats', 'beatpress'); ?></h1></th>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-award"></i> <?php _e('Show Featured Beat', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[enablefeatured]" value="1" <?php checked('1', $option_checker['enablefeatured']); ?> /> <?php _e('Show a featured beat on your catalog', 'beatpress'); ?>
					
						<?php bp_help('' . __('By activating this option you can showcase one of your best beats at the top of your catalog. It\'s responsive and should work with most themes so feel free to feature one of your best beats, it\'s by far the most listened and viewed one.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/16.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/16.jpg"></a>', '<i class="fas fa-award"></i> ' . __('Show Featured Beat', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide a featured beat at the top of your beats catalog', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-trophy"></i> <?php _e('Select Featured Beat', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<?php $args = array('show_option_none'  => 'Select a beat', 'post_type' => 'instrumentals', 'hierarchical' => true, 'selected' => $option_checker['currentfeaturedbeat'], 'name'  => 'beatpress_settings[currentfeaturedbeat]'); featured_beat_dropdown($args); ?><br />

						
						
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The beat that will be featured at the top of your catalog', 'beatpress'); ?>.</span><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Current URL:', 'beatpress'); ?> <strong><a target="_blank" href="<?php echo get_permalink( $option_checker['currentfeaturedbeat'] ); ?>"><?php echo get_permalink( $option_checker['currentfeaturedbeat'] ); ?></a></strong></span><br />
					</label>
				</fieldset>
			</td>
		</tr>
				
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-text-width"></i> <?php _e('Hide Featured Beat Text', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[featuredtextrow]" value="1" <?php checked('1', $option_checker['featuredtextrow']); ?> /> <?php _e('Hide SEO Introduction on your featured beat', 'beatpress'); ?>
						
						<?php bp_help('' . __('By activating this option you\'ll hide the default SEO Introduction text that\'s showed by default when you select a featured beat.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/27.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/27.jpg"></a>', '<i class="fas fa-text-width"></i> ' . __('Hide Featured Beat Text', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide a the SEO Introduction text of your featured beat', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-filter"></i> <?php _e('Landing Buttons', 'beatpress'); ?></h1></th>
			
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-hand-holding-usd"></i> <?php _e('Exclusive Rights', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[showexclusivecatalog]" value="1" <?php checked('1', $option_checker['showexclusivecatalog']); ?> /> <?php _e('Show the exclusive rights purchase button', 'beatpress'); ?>
						
						<?php bp_help('' . __('That\'s exactly what the title says, a way to show your customers an exclusive rights purchase button. As we previously told you exclusive rights purchases are always processed by BeatPress Direct purchase mode, so if you want you can encrypt the purchase links in the', 'beatpress') . ' "<i class="fab fa-paypal"></i> ' . __('Selling', 'beatpress') . '" ' . __('tab.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/17.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/17.jpg"></a><br><br><i class="fas fa-exclamation-circle"></i> ' . __('Important: Enabling this option will show the exclusive rights purchase button in your catalog page, if you want to show it also in your landing beat pages you have to enable it too in your', 'beatpress') . ' <i class="fas fa-columns"></i> ' . __('Beat Pages', 'beatpress') . '.', '<i class="fas fa-hand-holding-usd"></i> ' . __('Exclusive Rights', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the "Exclusive Rights" button to sell beats with the BeatPress PayPal handler', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="far fa-money-bill-alt"></i> <?php _e('Make an Offer', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[offercatalog]" value="1" <?php checked('1', $option_checker['offercatalog']); ?> /> <?php _e('Show the Make an Offer button', 'beatpress'); ?>
						
						<?php bp_help('' . __('This module is under construction, actually it does redirect to the /contact URL of your website.', 'beatpress') . '', '', '<i class="far fa-money-bill-alt"></i> ' . __('Make an Offer', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Select if you want to show a make an offer button instead of the fixed exclusive rights price in your beats catalog', 'beatpress'); ?></span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fab fa-buffer"></i> <?php _e('Catalog > Beat Interlinking', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[cataloginterlinking]" value="1" <?php checked('1', $option_checker['cataloginterlinking']); ?> /> <?php _e('Don\'t link from catalogs to internal beat pages', 'beatpress'); ?>
						
						<?php bp_help('' . __('By activating this button you\'ll remove any download button from your catalog linking to internal beat pages to prevent authority spread across them. This option is useful if you want to just use the catalog instead of the beat pages too (make sure to mark them as noindex).', 'beatpress') . '', '', '<i class="fab fa-buffer"></i> ' . __('Catalog > Beat Interlinking', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Prevents interlinking across catalogs and beat pages to avoid authority spread.', 'beatpress'); ?></span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-bolt"></i> <?php _e('SEO', 'beatpress'); ?></h1></th>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-bolt"></i> <?php _e('SEO Introduction', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[seointrocatalog]" value="1" <?php checked('1', $option_checker['seointrocatalog']); ?> /> <?php _e('Display the SEO Introduction added to each beat page', 'beatpress'); ?>
						
						<?php bp_help('' . __('This option is a must if your beat store is going to be SEO focused, basically it extracts the SEO Introduction you wrote in each landing beat page to show it in straight in your catalog. Google will see a lot of related keywords and names and will start loving it because there\'s a lot of content.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/18.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/18.jpg"></a>', '<i class="fas fa-bolt"></i> ' . __('SEO Introduction', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide in your catalog the SEO Introduction written in individual beat pages', 'beatpress'); ?> <strong><?php _e('(RECOMMENDED)', 'beatpress'); ?></strong>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-times"></i> <?php _e('404 Errors', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="radio" name="beatpress_settings[option404catalog]" value="disable" <?php checked('disable', $option_checker['option404catalog'], true); ?> /> <?php _e('Disable 404 Errors redirection', 'beatpress'); ?>
						
						<?php bp_help('' . __('If you\'re an experienced website owner you may have been dealing with 404 errors, and you may know how hardly a bunch of those may negatively impact your rankings performance.', 'beatpress') . '', '' . __('By selecting this option you will keep those 404 errors and you\'ll need to fix them manually by making manual redirections.', 'beatpress') . '', '<i class="fas fa-times"></i> ' . __('404 Errors', 'beatpress') . '') ?>
						
						<br />
						<input type="radio" name="beatpress_settings[option404catalog]" value="catalog" <?php checked('catalog', $option_checker['option404catalog'], true); ?> /> <?php _e('Redirect 404 Errors to catalog page', 'beatpress'); ?>
						
						<?php bp_help('' . __('If you\'re an experienced website owner you may have been dealing with 404 errors, and you may know how hardly a bunch of those may negatively impact your rankings performance.', 'beatpress') . '', '' . __('By selecting this option you will automatically redirect all those 404 errors to your catalog page, which is probably the best page to get them redirected to.', 'beatpress') . '', '<i class="fas fa-times"></i> ' . __('404 Errors', 'beatpress') . '') ?>
						
						<br />     
						<input type="radio" name="beatpress_settings[option404catalog]" value="homepage" <?php checked('homepage', $option_checker['option404catalog'], true); ?> /> <?php _e('Redirect 404 Errors to homepage', 'beatpress'); ?>
						
						<?php bp_help('' . __('If you\'re an experienced website owner you may have been dealing with 404 errors, and you may know how hardly a bunch of those may negatively impact your rankings performance.', 'beatpress') . '', '' . __('By selecting this option you will automatically redirect all those 404 errors to your homepage, which is probably the one of the best pages to get them redirected to, just in case if your catalog page isn\'t your homepage.', 'beatpress') . '', '<i class="fas fa-times"></i> ' . __('404 Errors', 'beatpress') . '') ?>
						
						<br />   
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('BeatPress is a SEO focused plugin, that\'s why we care about the usual WordPress problems that may affect your SEO performance', 'beatpress'); ?>.</span><br />   
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('A bunch of 404 errors may get your website involved into Google penalties regarding impressions and positions', 'beatpress'); ?>.</span><br />   
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Use this option to automatically redirect all those "404 Errors : Not Found" to your catalog page or your homepage', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-directions"></i> <?php _e('External Services', 'beatpress'); ?></h1></th>

		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-directions"></i> <?php _e('External Service Redirection', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[enableredirect]" value="1" <?php checked('1', $option_checker['enableredirect']); ?> /> <?php _e('Enable URL redirection to third party services (such as BeatStars or AirBit)', 'beatpress'); ?>
						
						<?php bp_help('' . __('We guess you don\'t have your BeatStars ProPage or Airbit Infinity Store installed as your main domain because of SEO purposes, but... What if you can make a ghost page which redirects exactly to your ProPage or Infinity Store? Something like... https://yourwebsite.com/propage or even https://yourwebsite.com/store ? It\'s a great thing for branding and also you can push it forward by installing a banner in the SEO Paragraph :)', 'beatpress') . '', '' . __('We know everyone shouldn\'t know about SEO for being able to decently maintain a great website, but just in case, the redirection is a', 'beatpress') . ' <a class="dashnocolor" target="_blank" href="https://www.ltnow.com/difference-301-302-redirects-seo/"><i class="fas fa-external-link-alt"></i>' . __('302 Redirection', 'beatpress') . '</a>, ' . __('that means that it doesn\'t pass link juice or even authority from your domain to the BeatStars or Airbit link, there\'s no need to worry about that anymore, it\'s like a ', 'beatpress') . '<a class="dashnocolor" target="_blank" href="https://backlinko.com/nofollow-link"><i class="fas fa-external-link-alt"></i> ' . __('nofollow link', 'beatpress') . '</a>.', '<i class="fas fa-times"></i> ' . __('External Service Redirection', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Useful if you\'d like to have an URL pointing and forwarding directly to your BeatStars / AirBit catalog', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>	

		<tr>
			<th style="cursor:default;" scope="row"><i class="fab fa-chrome"></i> <?php _e('URL to Redirect', 'beatpress'); ?></th>
			<td>
			
			<?php 
				echo url();
			?>
				<input type="text" placeholder="<?php _e('typesomething...', 'beatpress'); ?>" name="beatpress_settings[redirection2slash]" value="<?php echo $option_checker['redirection2slash']; ?>" /> <strong><a target="_blank" href="<?php echo url() . $option_checker['redirection2slash'] ?>"><i class="fas fa-share-square"></i></a></strong><br />
				<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('This is the URL you\'re going to forward', 'beatpress'); ?></span>
			</td>
        </tr>	
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fab fa-chrome"></i> <?php _e('Destination URL', 'beatpress'); ?></th>
			<td>
				<input type="text" placeholder="<?php _e('https://youruser.beatstars.com', 'beatpress'); ?>" name="beatpress_settings[redirection2destination]" value="<?php echo $option_checker['redirection2destination']; ?>" /><br />
				<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('This is where your previous URL will get redirected', 'beatpress'); ?>.</span>
			</td>
        </tr>	

		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-link"></i> <?php _e('Redirection Status', 'beatpress'); ?> </th>
			<td>
				<?php 
				
					if ( $option_checker['enableredirect'] == 1 ){
						echo '<i style="color: green;" class="fas fa-circle"></i> ' . __('Redirection Enabled', 'beatpress') . '';
						echo '<br /><span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> ' . __('You\'re forwarding', 'beatpress') . ' <strong>' . url() . $option_checker['redirection2slash'] . '</strong> >> <strong>' . $option_checker['redirection2destination'] . '</strong>.</span>';
					} else {
						echo '<i style="color: red;" class="fas fa-circle"></i> ' . __('Redirection Disabled', 'beatpress') . '';
						echo '<br /><span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> ' . __('Redirection and URL forwarding to external service is disabled', 'beatpress') . '.</span>';
					}
					
				
				
				?>

			</td>
        </tr>	


		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-exclamation-circle"></i> <strong><?php _e('Very Important', 'beatpress'); ?></strong></th>
			<td>
				<span class="description"><i class="fa fa-info-circle"></i> <?php _e('This redirection is performed using a "302 Moved Temporarily" redirection. That means that it will not pass PageRank or', 'beatpress'); ?> <br /><?php _e('link juice from your domain to the BeatStars / AirBit domain (which is pretty similar to a rel="nofollow" link)', 'beatpress'); ?>.</span><br /><br />
				<span class="description"><i class="fa fa-info-circle"></i> <?php _e('That\'s useful if you\'re using BeatPress only for SEO purposes as a secondary beat shop and BeatStars or AirBit', 'beatpress'); ?><br /><?php _e('as your main one because everyone knows how it works and the conversion ratio to sales is higher', 'beatpress'); ?>.</span><br /><br />
				<span class="description"><i class="fa fa-info-circle"></i> <?php _e('By using this option, if your external service (BeatStars or AirBit) goes down, got hacked, or suddenly stops', 'beatpress'); ?><br /> <?php _e('working you\'ll be able to temporarily redirect all your traffic to your BeatPress website and at least keep some beat sales', 'beatpress'); ?>.</span><br /><br />
				<span class="description"><i class="fa fa-info-circle"></i> <?php _e('The counterpart is; if your website (your BeatPress one) goes down, got hacked, or suddenly stops working, you\'ll', 'beatpress'); ?><br /> <?php _e('need to know how to make it work again in order to get that redirection working again, so, if you don\'t know how', 'beatpress'); ?><br /> <?php _e('to protect / manage your website (this website) you better keep this option deactivated', 'beatpress'); ?>.</span><br /><br />
				<span class="description"><i class="fa fa-info-circle"></i> <?php _e('If you don\'t know what does this mean keep this option deactivated', 'beatpress'); ?>.</span>
			</td>
        </tr>	






		
		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fab fa-slack-hash"></i> <?php _e('Genres', 'beatpress'); ?></h1></th>

		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-user-circle"></i> <?php _e('Display Type Beat Box', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[typebeatcatalog]" value="1" <?php checked('1', $option_checker['typebeatcatalog']); ?> /> <?php _e('Display the artist type beat box of each beat', 'beatpress'); ?>
						
						<?php bp_help('' . __('By activating this option you can make your catalog show a Type Beat box before the different genre boxes that are showed up close to the title.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/19.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/19.jpg"></a>', '<i class="fas fa-user-circle"></i> ' . __('Display Type Beat Box', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the artist type beat box of each beat in the beats catalog', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>	
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fab fa-slack-hash"></i> <?php _e('Display Genres Boxes', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[beatcategorycatalog]" value="1" <?php checked('1', $option_checker['beatcategorycatalog']); ?> /> <?php _e('Display the genres of each beat', 'beatpress'); ?>
						
						<?php bp_help('' . __('By activating this option you can make your catalog show genres boxes after the Type Beat box that is showed up close to the title.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/20.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/20.jpg"></a>', '<i class="fab fa-slack-hash"></i> ' . __('Display Genres Boxes', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the genres of each beat in the beats catalog', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-cubes"></i> <?php _e('Browse Beats by Genre', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[browsebeatsgenre]" value="1" <?php checked('1', $option_checker['browsebeatsgenre']); ?> /> <?php _e('List all available genres at the catalog bottom', 'beatpress'); ?>
						
						<?php bp_help('' . __('By activating this option you can list all your available genres at the bottom of your catalog, showing a beats count and the genre category.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/21.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/21.jpg"></a>', '<i class="fas fa-cubes"></i> ' . __('Browse Beats by Genre', 'beatpress') . '') ?>
						
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the genres of each beat in the beats catalog', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
		
		
		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-eye-slash"></i> <?php _e('Do Not List All Genres', 'beatpress'); ?></th> <!-- EXTENDED PREVIOUS -->
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[showonlygenres]" value="1" <?php checked('1', $option_checker['showonlygenres']); ?> /> <?php _e('Show only genres containing more than 5 beats inside', 'beatpress'); ?>
						
						<?php bp_help('' . __('I\'m sure it have happened to you at least once, we visit a website looking for something, we click somewhere and boom, just one post which desn\'t have what we were looking for.', 'beatpress') . '<br><br>' . __('Then we close the tab and go back to Google to keep searching, by activating this option you\'ll show only the genres that contains at leats 5 beats inside.', 'beatpress') . '', '<a target="_blank" class="dashnocolor" href="/wp-content/plugins/beatpress/docs/28.jpg"><img width="200px" src="/wp-content/plugins/beatpress/docs/28.jpg"></a>', '<i class="fas fa-cubes"></i> ' . __('Do Not List All Genres', 'beatpress') . '') ?>
					
						<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Pages with thin content are used to be useless for visitors and increase bounce rate', 'beatpress'); ?>.</span>
					</label>
				</fieldset>
			</td>
		</tr>
			
        </table>
	<?php
	







	
	
	
	
	
	

	
	// Display Beat Pages Options Only if Page is Beat Pages Options
	if (strpos(curPageURL(), 'beatpress-pages') !== false) {
		?> 
			<table class="form-table">
		<?php
	} else {
		?> 
			<table style="display:none;" class="form-table">	
		<?php
	}
	
	?> 
	
		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-search"></i> <?php _e('Beats Search', 'beatpres'); ?></h1></th>

		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-search"></i> <?php _e('Display Search Box', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="beatpress_settings[searchbox_top_pages]" value="1" <?php checked('1', $option_checker['searchbox_top_pages']); ?> /> <?php _e('Display the search box on the top of your beat pages', 'beatpress'); ?><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('With this options your visitors will be able to search within your beats by beat name, artist type, tag, genres...', 'beatpress'); ?></span>
					</label>
				</fieldset>
			</td>
		</tr>

		<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-filter"></i> <?php _e('Landing Buttons', 'beatpress'); ?></h1></th>
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-align-justify"></i> <?php _e('Listen more beats', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[listenmore]" value="1" <?php checked('1', $option_checker['listenmore']); ?> /> <?php _e('Add a link to your complete catalog', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the "Listen More Beats" button linking to your full beats catalog', 'beatpress'); ?>.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-hand-holding-usd"></i> <?php _e('Exclusive Rights', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[showexclusive]" value="1" <?php checked('1', $option_checker['showexclusive']); ?> /> <?php _e('Show the exclusive rights purchase button', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the "Exclusive Rights" button to sell beats with the BeatPress PayPal handler', 'beatpress'); ?>.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			<tr>
				<th style="cursor:default;" scope="row"><i class="far fa-money-bill-alt"></i> <?php _e('Make an Offer', 'beatpress'); ?></th>
				<td>
					<fieldset>
						<label>
							<input type="checkbox" name="beatpress_settings[offerbeatpages]" value="1" <?php checked('1', $option_checker['offerbeatpages']); ?> /> <?php _e('Show the Make an Offer button', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Select if you want to show a make an offer button instead of the fixed exclusive rights price in beat pages', 'beatpress'); ?></span>
						</label>
					</fieldset>
				</td>
			</tr>
			
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-arrow-alt-circle-down"></i> <?php _e('Free Downloads', 'beatpress'); ?></h1></th>
		
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-cloud-download-alt"></i> <?php _e('Free Downloads', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[freedownloads]" value="1" <?php checked('1', $option_checker['freedownloads']); ?> /> <?php _e('Display the free download section', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the download section in individual beat pages', 'beatpress'); ?>.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>

			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-user-plus"></i> <?php _e('Social Locker', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[sociallocker]" value="1" <?php checked('1', $option_checker['sociallocker']); ?> /> <?php _e('Use Social Locker plugin to offer free downloads', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Make the users perform a social action to get the free downloads in individual beat pages, useless if the Free Downloads option is not activated', 'beatpress'); ?>.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-exclamation-triangle"></i> <?php _e('Downloads Disclaimer', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[freedisclaimer]" value="1" <?php checked('1', $option_checker['freedisclaimer']); ?> /> <?php _e('Show "Free Downloads" disclaimer', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Let your visitors know that beats marked as "FREE" are not free beats, they\'re just Free Downloads and need to get a lease to get rights to the beat', 'beatpress'); ?>.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-bolt"></i> <?php _e('SEO', 'beatpress'); ?></h1></th>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-bolt"></i> <?php _e('SEO Introduction', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[seointro]" value="1" <?php checked('1', $option_checker['seointro']); ?> /> <?php _e('Display the SEO Introduction added to each beat page', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the SEO Introduction written in individual beat pages', 'beatpress'); ?>. <strong><?php _e('(RECOMMENDED)', 'beatpress'); ?></strong></span>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-bolt"></i> <?php _e('Genres in SEO Introduction', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[seointrogenres]" value="1" <?php checked('1', $option_checker['seointrogenres']); ?> /> <?php _e('Add the genres of each beat to the SEO Introduction (H2 Heading)', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the list of genres in the SEO Introduction of each beat page', 'beatpress'); ?>.<strong><?php _e('(RECOMMENDED)', 'beatpress'); ?></strong></span><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('The SEO Introduction module is an H2, one of the off-page SEO most important headings known', 'beatpress'); ?>.</strong></span>
                        </label>
                    </fieldset>
                </td>
            </tr>

			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-bolt"></i> <?php _e('SEO Paragraphs', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[seoparagraphs]" value="1" <?php checked('1', $option_checker['seoparagraphs']); ?> /> <?php _e('Display the SEO Paragraphs added to each beat page', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the SEO Paragraphs written in individual beat pages', 'beatpress'); ?>. <strong><?php _e('(RECOMMENDED)', 'beatpress'); ?></strong></span>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-tags"></i> <?php _e('Tags', 'beatpress'); ?></h1></th>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-plug"></i> <?php _e('Enable Beat Tags', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[use_beattags]" value="1" <?php checked('1', $option_checker['use_beattags']); ?> /> <?php _e('Enable Beat Tags taxonomy', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Enabling them will be good to increase user interaction with your individual beat pages, showing Google that users are interested in your content', 'beatpress'); ?>.</span><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Also, it will also distribute your PageRank within your beat-tag pages, which could end up in ranking penalties', 'beatpress'); ?>.</span><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('If you don\'t know what I\'m talking about just keep this option disabled', 'beatpress'); ?>.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>	
						
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-tag"></i> <?php _e('Display Beat Tags', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[beattags]" value="1" <?php checked('1', $option_checker['beattags']); ?> /> <?php _e('Display the Beat Tags added to each beat page', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Show or hide the Beat Tags you entered in individual beat pages', 'beatpress'); ?>.</span><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <strong><?php _e('*IMPORTANT:', 'beatpress'); ?></strong> <?php _e('This option is useless if the option "Enable Beat Tags" is disabled', 'beatpress'); ?>.</span><br />
                        </label>
                    </fieldset>
                </td>
            </tr>	
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-tags"></i> <?php _e('Clickable Beat Tags', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[clickablebeattags]" value="1" <?php checked('1', $option_checker['clickablebeattags']); ?> /> <?php _e('Make the beat tags clickable', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Auto-generate an hyperlink to each beat tag to make your visitors able to navigate through the beat tags in individual beat pages', 'beatpress'); ?>.</span><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <strong><?php _e('*IMPORTANT:', 'beatpress'); ?></strong> <?php _e('This option is useless if the option "Enable Beat Tags" is disabled', 'beatpress'); ?>.</span><br />
                        </label>
                    </fieldset>
                </td>
            </tr>	
			
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fab fa-youtube"></i> <?php _e('YouTube', 'beatpress'); ?></h1></th>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fab fa-youtube"></i> <?php _e('YouTube Embed', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input id="embedder" type="checkbox" name="beatpress_settings[ytembed]" value="1" <?php checked('1', $option_checker['ytembed']); ?> /> <?php _e('Automatically embed the YouTube Video in beat pages', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('This may help your video to reach higher positions in the YouTube Search results', 'beatpress'); ?>.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>
			


			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-link"></i> <?php _e('YouTube Backlink', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[ytbacklink]" value="1" <?php checked('1', $option_checker['ytbacklink']); ?> /> <?php _e('Automatically add a text backlink to your video', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('This may help your video to reach higher positions in the Google and YouTube search results, but it\'s useless if the embed option is not activated', 'beatpress'); ?>.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>	

			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-star-half-alt"></i> <?php _e('Ratings', 'beatpress'); ?></h1></th>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-star-half-alt"></i> <?php _e('Beat Ratings', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[beatratings]" value="1" <?php checked('1', $option_checker['beatratings']); ?> /> <?php _e('Show public beat ratings', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Enable public ratings for every beat uploaded in individual beat pages', 'beatpress'); ?>.</span><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Plugin EC Stars Ratings must be installed', 'beatpress'); ?>, <a target="_blank" href="https://wordpress.org/plugins/ec-stars-rating/"><?php _e('click here to download', 'beatpress'); ?></a>.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>
			
			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-comment-alt"></i> <?php _e('Comments', 'beatpress'); ?></h1></th>
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="far fa-comment-alt"></i> <?php _e('Enable Disqus Comments', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[disquspage]" value="1" <?php checked('1', $option_checker['disquspage']); ?> /> <?php _e('Check this option to enable Disqus comments on individual beat pages', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Engagement in websites is key for SEO nowadays, enable this option and paste the Disqus code below to active Disqus on your individual beat-pages', 'beatpress'); ?>.</span><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('First you have to create a "Disqus Account" in order to show the comments section', 'beatpress'); ?>, <a target="_blank" href="https://help.disqus.com/installation/universal-embed-code"><?php _e('click here to register', 'beatpress'); ?></a>.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>

		<tr>
			<th style="cursor:default;" scope="row"><i class="fas fa-align-left"></i> <?php _e('Disqus HTML Code', 'beatpress'); ?></th>
			<td>
				<fieldset>
					<label>
						<textarea cols="70" rows="5" type="textarea" placeholder="<?php _e('Type here your Disqus code...', 'beatpress'); ?>" name="beatpress_settings[disquscode]"><?php echo $option_checker['disquscode']; ?></textarea><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Type here the JavaScript code that Disqus provided you', 'beatpress'); ?>.<br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('It will be showed in ALL your beat pages', 'beatpress'); ?>.</span><br />
						<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('*This paragraph is HTML ready', 'beatpress'); ?>. </span>
					</label>
				</fieldset>
			</td>
		</tr>

			<th style="cursor:default;" scope="row"><h1 style="color: #66a0ff;"><i class="fas fa-bars"></i> <?php _e('Theming', 'beatpress'); ?></h1></th>						
			
			<tr>
                <th style="cursor:default;" scope="row"><i class="fas fa-arrow-alt-circle-right"></i> <?php _e('Next > Previous', 'beatpress'); ?></th>
                <td>
                    <fieldset>
                        <label>
							<input type="checkbox" name="beatpress_settings[nextprevious]" value="1" <?php checked('1', $option_checker['nextprevious']); ?> /> <?php _e('Add a "Previous beat" and "Next beat" at the top and bottom of each beat page', 'beatpress'); ?><br />
							<span style="font-size: xx-small;" class="description"><i class="fa fa-info-circle"></i> <?php _e('Useful if your WordPress theme doesn\'t contains a previous / next button by default', 'beatpress'); ?>.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>

        </table>
	<?php
	
	
	
	
	
	
	
	
	
	
	

	
	
	
	
	
	
	
	
	
	
	
		
	
	
	
	
	
	
	
	
}

// Current URL Checker + Query Strings to Strip Options
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}


function bp_help($txter1, $txter2, $bphtitle){
	
	if ($txter2 == '') {
		echo '<div class="tooltip"><i class="far fa-question-circle"></i><span class="tooltiptext tooltip-bottom"><strong><i class="fas fa-question-circle"></i> ' . __('BeatPress Documentation', 'beatpress') . '</strong><br><em>' . $bphtitle . '</em><br><br>' . $txter1 . '</span></div>';
	} else {
		echo '<div class="tooltip"><i class="far fa-question-circle"></i><span class="tooltiptext tooltip-bottom"><strong><i class="fas fa-question-circle"></i> ' . __('BeatPress Documentation', 'beatpress') . '</strong><br><em>' . $bphtitle . '</em><br><br>' . $txter1 . '<br><br>' . $txter2 . '</span></div>';
	}
	
}



// Featured Beat Dropdown
function featured_beat_dropdown( $args = array( 'post_type' => 'post', 'show_option_none'  => 'Select a post', 'name' => null, 'selected' => '', 'echo' => true ) ){

    $posts = get_posts(
        array(
            'post_type'  => $args['post_type'],
            'numberposts' => -1
        )
    );

    $dropdown = '';

    if( $posts ){

        if( !is_string($args['name']) ){

            $args['name'] = $args['post_type'].'_select';
        }

        $dropdown .= '<select id="'.$args['name'].'" name="'.$args['name'].'">';

            $dropdown .= '<option value="-1">'.$args['show_option_none'].'</option>';

            $args['selected'] = intval($args['selected']);

            foreach( $posts as $p ){

                $selected = '';
                if( $p->ID == $args['selected'] ){

                    $selected = ' selected';
                }

                $dropdown .= '<option value="' . $p->ID . '"'.$selected.'>' . esc_html( $p->post_title ) . '</option>';
            }

        $dropdown .= '</select>';           
    }

    if($args['name'] === false){

        return $dropdown;
    }
    else{

        echo $dropdown;
    }
}