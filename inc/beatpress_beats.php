<?php
/**
 * BeatPress Custom Post Type Pages
 * Instrumentals custom post type posts
 *
 * @/inc/beatpress_catalog.php
 * @package BeatPress
 */

// Security Layer
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access to BeatPress Script denied.' );
}

//BEAT PAGE TEMPLATE + SEO

// Class .only-show-mobile to only show on mobile devices

function beatpress_beats($content) {

	if ( get_post_type() == 'instrumentals') {
		
	$files = get_post_meta( get_the_ID(), 'bp_streaming_file', true ); //NEW MP3 FILE
	
	foreach( $files as $file ) {
		$encrypted = my_simple_crypt( $file['url'], 'e' );
		$downloadfile = $file['url'];
		break;
	}

	
	$name = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'name', true );
	$image = get_the_post_thumbnail_url(get_the_ID(), "beatpress-playlist-image-featured-size");
	$genre = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'genre', true );
	$slike = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'slike', true );
	$extlink = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'buy_external', true );
	
	$bpcol = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'collab', true );
	$bphoo = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'hook', true );

	$songid = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'songid', true );
	//$encrypted = my_simple_crypt( $songid, 'e' ); OLD MP3 FILE
	$eddnum = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'eddnum', true );
	$intro = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'intro', true );
	$p1 = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'p1', true );
	$p2 = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'p2', true );
	$p3 = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'p3', true );
	$lic_mp3 = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'lic_mp3', true );
	$lic_wav = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'lic_wav', true );
	$lic_premium = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'lic_premium', true );
	$lic_unlimited = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'lic_unlimited', true );
	$exclusive = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'exclusive', true );
	$sold = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'sold', true );
	$yt = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'yt', true );
	$newbeat = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'newbeat', true );
	$newbeaturl = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'newbeaturl', true );
	$imageJSON = get_the_post_thumbnail_url(get_the_ID(), "beatpress-playlist-image-featured-size");

	GLOBAL $option_checker;
	$catalogUrl = $option_checker['catalogurl'];
	$showEx = $option_checker['showexclusive'];
	$makeOffer = $option_checker['offerbeatpages'];
	$listenMoreLink = $option_checker['listenmore'];
	$freedl = $option_checker['freedownloads'];
	$socialLocker = $option_checker['sociallocker'];
	$seoIntro = $option_checker['seointro'];
	$genreIntro = $option_checker['seointrogenres'];
	$seiParagraphs = $option_checker['seoparagraphs'];
	$beattagsshow = $option_checker['beattags'];
	$tagsclick = $option_checker['clickablebeattags'];
	$enableYt = $option_checker['ytembed'];
	$ytLink = $option_checker['ytbacklink'];
	$theYtLink = $option_checker['youtubelink'];
	$ratingStar = $option_checker['beatratings'];
	$navigationLinks = $option_checker['nextprevious'];
	$producerName = $option_checker['producername'];
	$freeDisclaimer = $option_checker['freedisclaimer'];
	$enableBeatTagsTax = $option_checker['use_beattags'];
	$disqusEnabled = $option_checker['disquspage'];
	$disqusHTMLCode = $option_checker['disquscode'];
	$bp_sellingMode = $option_checker['purchasemode'];
	$bp_direct_encrypt = $option_checker['bpdirectencryptsession'];
	$bp_buttonsize = $option_checker['smallpb'];
	$bp_fluid = $option_checker['fluid'];

	
	$bp_licname1 = $option_checker['bp_lic_first_name'];
	$bp_licname2 = $option_checker['bp_lic_second_name'];
	$bp_licname3 = $option_checker['bp_lic_third_name'];
	$bp_licname4 = $option_checker['bp_lic_fourth_name'];
	
	$bp_shead1 = $option_checker['bp_lic_first_shead'];
	$bp_shead2 = $option_checker['bp_lic_second_shead'];
	$bp_shead3 = $option_checker['bp_lic_third_shead'];
	$bp_shead4 = $option_checker['bp_lic_fourth_shead'];
	
	$nofollowrule = $option_checker['bpexternalnofollow'];
	
	
	
	
	
/*
	//TEMP REDIRECT PROPAGE
	header("Location: $extlink", true, 302);
	exit;
*/
	
	
	
	
	
	

	
	
/*
$ip = $_SERVER['REMOTE_ADDR']; 
$ipdat = @json_decode(file_get_contents( "http://www.geoplugin.net/json.gp?ip=" . $ip)); 
$randomy = (rand(1, 999));

if ($yt == ''){
	
} else {
	$redurl = 'https://www.youtube.com/watch?v=' . $yt;
	
	if ($randomy >= 666){
		echo '<a target="_blank" rel="nofollow" href="' . $redurl . '"><i class="fab fa-youtube"></i> View this beat in YouTube</a><br><br>';
	}

	if ($ipdat->geoplugin_continentName == 'Africa' && $randomy >= 666){
		header("Location: $redurl", true, 302);
		exit;
	}
}
*/




	

	/*
	$output .= '<a style="display: inline-block;" href="https://www.surcebeats.com/category/beats' . $category1link . '"><i class="fab fa-slack-hash"></i>' . $category1 . '</a>&nbsp;';
	$output .= '<a style="display: inline-block;" href="https://www.surcebeats.com/category/beats' . $category2link . '"><i class="fab fa-slack-hash"></i>' . $category2 . '</a>&nbsp;';
	*/

	/*
	if ( !function_exists( 'edd_get_cart_quantity' ) ) { 
		require_once '/includes/cart/functions.php'; 
	} 
	// NOTICE! Understand what this does before running. 
	$result = edd_get_cart_quantity(); 
    echo $result;
	*/
	GLOBAL $myversion;
	GLOBAL $bpurl;
	
	count_beat_views();
	
	$output .= '<!-- This beat page has been dynamically generated with BeatPress Version ' . $myversion . ' by Surce -->';
	$output .= '<!-- Get BeatPress for free at ' . $bpurl . ' -->';
	//$output .= $encrypted . ' ' . $file['url'];
	

	
	//Navigation Buttons
	if ($navigationLinks == 1) {
		$output .= '<div class="navbro">';
		if (strlen(get_previous_post()->post_title) > 0) {
			$output .= '<a class="nav" href="' . get_permalink( get_adjacent_post( false, '', true ) ) . '"><i class="fas fa-angle-double-left"></i></a>';
		} else {
			if (! $theYtLink == '') {
				$output .= '<a class="nav" target="_blank" href="' . $theYtLink .'?sub_confirmation=1"><i class="fab fa-youtube"></i></a>';
			} else {
				$output .= '<a class="nav" target="_blank" href="' . get_permalink( $catalogUrl ) . '"><i class="fas fa-compact-disc fa-spin"></i></a>';
			}
		}
		if (strlen(get_next_post()->post_title) > 0) {
			$output .= '<a class="nav navright" href="' . get_permalink( get_adjacent_post( false, '', false ) ) . '"><i class="fas fa-angle-double-right"></i></a>';
		} else {
			if (! $theYtLink == '') {
				$output .= '<a class="nav navright" target="_blank" href="' . $theYtLink .'?sub_confirmation=1"><i class="fab fa-youtube"></i></a>';
			} else {
				$output .= '<a class="nav navright" target="_blank" href="' . get_permalink( $catalogUrl ) . '"><i class="fas fa-compact-disc fa-spin"></i></a>';
			}
			
		}
		$output .= '</div><br>';
	}
	
	
	
	if ($option_checker['searchbox_top_pages'] == 1) {
		$output .= '<form class="beatsearch" action="/">
		<input type="search" name="s" placeholder="' . __('Search beat name, artist, genre, tags...', 'beatpress') . '" >
		<button name="post_type" value="instrumentals" type="hidden"><i class="searchicon fas fa-search"></i></button>
		</form><div class="bpsep"></div>';
	}	
	
	
	
	


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	if ( has_post_thumbnail() ) {
		$image = get_the_post_thumbnail($post->ID, "beatpress-playlist-image-size", array('title' => '' . sprintf( __('Listen to %s, a %s Type Beat', 'beatpress' ), $name, $slike ) . '', 'alt' => $name . ' instrumental'));
	} else {
		$image = '<img src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog.jpg" title="' . sprintf( __('Listen to %s, a %s Type Beat', 'beatpress' ), $name, $slike ) . '" alt="' . $name . ' instrumental">';
	}
	

	
	
	
	
	
	
	//SHOW YOUTUBE
	//$yt = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'yt', true );
	//$output .= '<br><br><br><i class="fas fa-sort-down"></i> ' . $yt;
	
	
	
	

	
		
	if ($bp_fluid == '' or $bp_fluid == 'compact') {
		$output .= '<div class="beatholder bh_compact bp_ca" xNd="' . $name . '" xId="' . $encrypted . '">';
	} elseif ($bp_fluid == 'fluid') {
		$output .= '<div class="beatholder bh_fluid bp_ca" xNd="' . $name . '" xId="' . $encrypted . '">';
	} elseif ($bp_fluid == 'fluid-xtrasmall') {
		$output .= '<div class="beatholder bh_fluid bh_xtrasmall bp_ca" xNd="' . $name . '" xId="' . $encrypted . '">';
	}
	
	
	$output .= '<span class="imgcont"><span title="' . __('Now listening:', 'beatpress') . ' ' . $name . '" class="ppplistening"><i class="fas fa-circle-notch fa-spin"></i></span>' . $image . '</span> <span class="titleholder"><span class="bp_titledot">&nbsp;&nbsp;<i class="fas fa-play bh_playhelp"></i>&nbsp;&nbsp;<strong>' . $name . '</strong>';
		
	if (($bpcol != '') || ($bphoo == 'yes')) {
		$output .= '<br><span class="bpextradetails">';
		
		if ($bpcol != '') {
			$output .= '<span class="bpcollabbox"><i class="fas fa-user-friends"></i> Ft. ' . $bpcol . ' </span>';
		}
		
		if ($bphoo == 'yes') {
			$output .= '<span class="bphookbox">(With Hook)</span>';
		}
		
		$output .= '</span>';
		
	}
	
	$output .= '</span></span>';
	
	
	
	
    $output .= '<p class="beat-category">';
	if ($option_checker['typebeatcatalog'] == 1) {
		$output .= '<span title="' . sprintf( __('%s Type Beat', 'beatpress' ), $slike ) . '" class="cattb"><strong><i class="fas fa-user-circle"></i> ' . $slike . '</strong></span>';
	}
	
	if ($option_checker['beatcategorycatalog'] == 1) {
		$genres = get_the_terms( $post->ID, 'genre' );
		if (!$genres[0]->name == '') {
			$output .= '<span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[0]->name ) . '" class="cat"><strong><i class="fab fa-slack-hash"></i> ' . $genres[0]->name . '</strong></span>';
		}
		if (!$genres[1]->name == '') {
			$output .= '<span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[1]->name ) . '" class="cat"><strong><i class="fab fa-slack-hash"></i> ' . $genres[1]->name . '</strong></span>';
		}
		if (!$genres[2]->name == '') {
			$output .= '<span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[2]->name ) . '" class="cat"><strong><i class="fab fa-slack-hash"></i> ' . $genres[2]->name . '</strong></span>';
		}
		
	}
	
	//$genres = get_terms( array('taxonomy' => 'genre', 'hide_empty' => false) );

    $output .= '</p>'; // Markup closing tags.
	
	
	
	
	
	
	
	$output .= '<span class="bp_addbuttons">';
	 
	
	//DOWNLOAD BUTTON LANDING
	if ($sold == 'yes'){
		$output .= '<a class="sicons pldownload iBk" title="' . sprintf( __('%s was exclusively sold and is no longer available', 'beatpress' ), $name ) . '"><i class="fas fa-times-circle"></i></a>';
	} else {
		
		if ($bp_sellingMode == 'external'){

		
			if ($extlink == '') {
				$output .= '<a class="sicons pldownload iBk" title="' . __('Broken Link', 'beatpress') . '"><i class="fas fa-unlink"></i></a>';
			} else {
				if ($nofollowrule == '1') {
					$output .= '<a target="_blank" rel="nofollow" href="' . $extlink . '" class="sicons pldownload iBk" title="' . sprintf( __('Download %s Instrumental', 'beatpress' ), $name ) . '"><i class="fas fa-download"></i></a>';
				} else {
					$output .= '<a target="_blank" href="' . $extlink . '" class="sicons pldownload iBk" title="' . sprintf( __('Download %s Instrumental', 'beatpress' ), $name ) . '"><i class="fas fa-download"></i></a>';
				}

			}

			
			
			
			
		} else { //NO MODO EXTERNAL
			
		}
		
	}
		
		
		
	
	$output .= '<a class="bp_box_color bp_pppseparator bp_butsep_buy" title="' . sprintf( __('%s Purchase Options', 'beatpress' ), $name ) . '" data-bpid="' . $eddnum . '" active="0"><span class="icon_cont"></span></a>';
	
	
	
	
	
	
	
	
	
	
	
	
	
	//OLD BUTTON
	/*
	
	if ($sold == 'yes'){
		if ($bp_buttonsize == 1){
			$output .= '<a class="bp_box_color purchaselink_sold bp_mid_buy iBk" title="' . $name . ' is no longer available" ><span class="icon_cont"><i class="fas fa-ban"></i></span></a>';
		} else {
			$output .= '<a class="bp_box_color purchaselink_sold bp_big_buy iBk" title="' . $name . ' is no longer available" ><span class="icon_cont"><i class="fas fa-ban"></i></span> <span class="text_cont">SOLD</span></a>';
		}
	} else {
		if ($bp_buttonsize == 1){
			$output .= '<a class="bp_box_color bp_pppseparator bp_butsep_buy iBk" title="' . $name . ' purchase options" data-bpid="' . $eddnum . '" active="0"><span class="icon_cont"><i class="fas fa-download"></i></span></a>';
		} else {
			$output .= '<a class="bp_box_color bp_pppseparator bp_butsep_buy iBk" title="' . $name . ' purchase options" data-bpid="' . $eddnum . '" active="0"><span class="icon_cont"><i class="fas fa-download"></i></span> <span class="text_cont"></span></a>';
		}
	}ç
	
	*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    $output .= '</span>'; // Markup closing tags.
	
	$output .= '</div>';
	
	
	
	
	
	
	
	
	
	/*
	
    $output .= '<p class="buttons">';
	$output .= '<span title="Now listening: ' . $name . '" class="sicons ppplistening iBk"><i class="fas fa-circle-notch fa-spin"></i></span>';
	
    $output .= '</p>'; // Markup closing tags.
	
	$output .= '</div>';
	
	*/
	


	
	
	
	


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	//echo get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'name', true );
	//https://jeremyhixon.com/tool/wordpress-meta-box-generator-v2-beta/

	
	if ($sold == 'yes') {
		$output .= '<span class="soldbox" target="_blank"><span class="lictype">' . __('Not Available', 'beatpress') . '</span><span id="ex_lictype" class="price"><i class="fas fa-ban"></i></span><span class="lictype2">' . __('Beat has been sold', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-times"></i></span></span>';
		if ($listenMoreLink == 1) {
			$output .= '<span class="loadholder" id="bpLoadStatic"><a href="' . get_permalink( $catalogUrl ) . '" id="loadt" class="loadmoreBtn"><i class="fas fa-caret-down"></i> ' . __('Listen More Beats', 'beatpress') . ' <i class="fas fa-caret-down"></i></a></span>';
		}	
		$output .= '<div class="bpsep"></div>';
		$output .= '<p id="beatsold"><i id="soldp" class="fas fa-times-circle"></i> ' . sprintf( __('%s was exclusively sold', 'beatpress' ), $name ) . '</h2>';
		$output .= '<p><i class="fas fa-info-circle"></i> ' . __('This beat is no longer available for any kind of licensing or purchase', 'beatpress') . '.';
		if ($newbeat == '') {
		} else {
			 $output .= ' ' . __('Anyway, you may be interested in', 'beatpress') . ' <a href="' . $newbeaturl .'"><strong><i class="fas fa-external-link-alt"></i> ' . $newbeat . '</strong> <i class="fas fa-star fa-spin"></i> </a>, ' . '' . __('which is a pretty similar beat', 'beatpress') . '.';
		}
		$output .= '</p>';

	} else {
		
		/*
		
		//Discount if social URL
		
		if (isset($_SERVER['HTTP_REFERER'])) { // check there was a referrer

			$uri = parse_url($_SERVER['HTTP_REFERER']); // use the parse_url() function to create an array containing information about the domain
			//echo $uri['host']; // echo the host
		
			if (strpos($uri['host'],'youtube') !== false) {
				$output .= '<h2 id="discount"><i class="fas fa-percentage"></i> Limited time offer!</h2>';
				$output .= '<p><i id="soc_dis" class="fas fa-asterisk fa-spin"></i> <i class="fab fa-youtube"></i> Only for YouTube users! Use the discount code <strong>YOUTUBE20</strong> at checkout to get a <strong><i class="fas fa-money-bill-alt"></i> 20% OFF</strong> in your purchase</p>';
			}
			
			if (strpos($uri['host'],'google') !== false) {
				$output .= '<h2 id="discount"><i class="fas fa-percentage"></i> Limited time offer!</h2>';
				$output .= '<p><i id="soc_dis" class="fas fa-asterisk fa-spin"></i> <i class="fab fa-google"></i> Only for Google users! Use the discount code <strong>GOOGLE15</strong> at checkout to get a <strong><i class="fas fa-money-bill-alt"></i> 15% OFF</strong> in your purchase</p>';
			}
			
			if (strpos($uri['host'],'facebook') !== false) {
				$output .= '<h2 id="discount"><i class="fas fa-percentage"></i> Limited time offer!</h2>';
				$output .= '<p><i id="soc_dis" class="fas fa-asterisk fa-spin"></i> <i class="fab fa-facebook-f"></i> Only for Facebook users! Use the discount code <strong>FACEBOOK12</strong> at checkout to get a <strong><i class="fas fa-money-bill-alt"></i> 12% OFF</strong> in your purchase</p>';
			}
			
			if (strpos($uri['host'],'twitter') !== false) {
				$output .= '<h2 id="discount"><i class="fas fa-percentage"></i> Limited time offer!</h2>';
				$output .= '<p><i id="soc_dis" class="fas fa-asterisk fa-spin"></i> <i class="fab fa-twitter"></i> Only for Twitter users! Use the discount code <strong>TWITTER21</strong> at checkout to get a <strong><i class="fas fa-money-bill-alt"></i> 21% OFF</strong> in your purchase</p>';
			}
			
		}
		
		*/
		
		
		
		//PURCHASE MODE BEATPRESS DIRECT
		if ($bp_sellingMode == 'direct' || $bp_sellingMode == ''){
			
			
			
			if ($bp_direct_encrypt == 1){
				
				$output .= '<div class="bp_flexcont">';
				$output .= '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=' . $bp_licname1 . '&purchase=' . $lic_mp3 * 170486, e) . '" target="_blank"><span class="lictype">' . $bp_licname1 . '</span><span id="mp3t" class="price">$' . $lic_mp3 . '</span><span class="lictype2">' . $bp_shead1 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				$output .= '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=' . $bp_licname2 . '&purchase=' . $lic_wav * 170486, e) . '" target="_blank"><span class="lictype">' . $bp_licname2 . '</span><span id="mp3t" class="price">$' . $lic_wav . '</span><span class="lictype2">' . $bp_shead2 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				$output .= '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=' . $bp_licname3 . '&purchase=' . $lic_premium * 170486, e) . '" target="_blank"><span class="lictype">' . $bp_licname3 . '</span><span id="mp3t" class="price">$' . $lic_premium . '</span><span class="lictype2">' . $bp_shead3 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				$output .= '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=' . $bp_licname4 . '&purchase=' . $lic_unlimited * 170486, e) . '" target="_blank"><span class="lictype">' . $bp_licname4 . '</span><span id="mp3t" class="price">$' . $lic_unlimited . '</span><span class="lictype2">' . $bp_shead4 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
		
				if ($showEx == 1) {
			
					if ($makeOffer == '1') {
						$output .= '<a class="purchbox" target="_blank" href="/contact"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">~</span><span class="lictype2">' . __('Make an Offer', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-pencil-alt"></i></span></a>';
					} else {
						$output .= '<a class="purchbox" target="_blank" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=Exclusive%20Rights&purchase=' . $exclusive * 170486, e ) . '"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">$' . $exclusive . '</span><span class="lictype2">' . sprintf( __('%s Is Yours', 'beatpress' ), $name ) . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
					}
				}
	
				$output .= '</div>';

				
			} else {
				
				$output .= '<div class="bp_flexcont">';
				
				$output .= '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=' . $bp_licname1 . '&purchase=' . $lic_mp3 * 170486 . '" target="_blank"><span class="lictype">' . $bp_licname1 . '</span><span id="mp3t" class="price">$' . $lic_mp3 . '</span><span class="lictype2">' . $bp_shead1 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				$output .= '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=' . $bp_licname2 . '&purchase=' . $lic_wav * 170486 . '" target="_blank"><span class="lictype">' . $bp_licname2 . '</span><span id="mp3t" class="price">$' . $lic_wav . '</span><span class="lictype2">' . $bp_shead2 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				$output .= '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=' . $bp_licname3 . '&purchase=' . $lic_premium * 170486 . '" target="_blank"><span class="lictype">' . $bp_licname3 . '</span><span id="mp3t" class="price">$' . $lic_premium . '</span><span class="lictype2">' . $bp_shead3 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				$output .= '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=' . $bp_licname4 . '&purchase=' . $lic_unlimited * 170486 . '" target="_blank"><span class="lictype">' . $bp_licname4 . '</span><span id="mp3t" class="price">$' . $lic_unlimited . '</span><span class="lictype2">' . $bp_shead4 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
		
				if ($showEx == 1) {
			
					if ($makeOffer == '1') {
						$output .= '<a class="purchbox" target="_blank" href="/contact"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">~</span><span class="lictype2">' . __('Make an Offer', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-pencil-alt"></i></span></a>';
					} else {
						$output .= '<a class="purchbox" target="_blank" href="/?beatpress_direct=true&beat=' . $name . '&license=Exclusive%20Rights&purchase=' . $exclusive * 170486 . '"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">$' . $exclusive . '</span><span class="lictype2">' . sprintf( __('%s Is Yours', 'beatpress' ), $name ) . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
					}
				}
				
				$output .= '</div>';

				
			}
			
			
			if ($listenMoreLink == 1) {
				$output .= '<span class="loadholder" id="bpLoadStatic"><a href="' . get_permalink( $catalogUrl ) . '" id="loadt" class="loadmoreBtn"><i class="fas fa-caret-down"></i> ' . __('Listen More Beats', 'beatpress') . ' <i class="fas fa-caret-down"></i></a></span><br>';
			}	
			
			
			//FREE DOWNLOADS SECTION
			if ($freedl == 1) {
				$output .= '<p id="download_shortcut"><i class="fas fa-cloud-download-alt"></i> ' . __('Grab the free download', 'beatpress') . '</p>';
				$output .= '<div class="socialaction" id="grabfree">';
			
				if ($freeDisclaimer == 1) {
					$output .= '<p><strong><i class="fas fa-exclamation-triangle"></i> ' . __('DISCLAIMER:', 'beatpress') . '</strong> ' . __('Free downloads are not “Free Beats”. They’re marked as free and available as free download for listening and evaluation purposes only. Purchase or license an instrumental to obtain rights to the beat. Any monetization / synchronization way is strictly prohibited', 'beatpress') . '.</p>';
				}

				if ($socialLocker == 1) {

					$output .= do_shortcode( '[sociallocker id="16188"]<p><a class="bp_button" href="' . $downloadfile . '" target="_blank"><i class="fas fa-download"></i> &nbsp;' . sprintf( __('Click here to download %s', 'beatpress' ), $name ) . '</a></p>
					[/sociallocker]' );

				} else {
							
					$output .= '<p><a class="bp_button" href="' . $downloadfile . '" target="_blank"><i class="fas fa-download"></i> &nbsp;' . sprintf( __('Click here to download %s', 'beatpress' ), $name ) . '</a></p>';
				
				}
			
				$output .= '</div>';
			
			}

		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		//PURCHASE MODE EASY DIGITAL DOWNLOADS
		if ($bp_sellingMode == 'edd'){

		$output .= '<div class="bp_flexcont">';
		$output .= '<form id="edd_purchase_' . $eddnum . '-1" class="edd_download_purchase_form edd_purchase_' . $eddnum . ' purchbox" method="post"><span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer"><meta itemprop="price" content="' . $lic_mp3 . '"><meta itemprop="priceCurrency" content="USD"></span><a href="" class="edd-add-to-cart" data-nonce="' .  wp_create_nonce( 'edd-add-to-cart-' . $eddnum ) . '" data-action="edd_add_to_cart" data-download-id="' . $eddnum . '" data-variable-price="yes" data-price-mode="multi" data-price="' . $lic_mp3 . '"><span class="lictype">' . $bp_licname1 . '</span><span id="mp3t" class="price">$' . $lic_mp3 . '</span><span class="lictype2">' . $bp_shead1 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span><span class="edd-add-to-cart-label"></span><span class="edd-loading" style="margin-left:-18px;margin-top:-15px;height:50px;width:50px;" aria-label="Loading"></span></a><input type="hidden" name="download_id" value="' . $eddnum . '"><input type="hidden" name="edd_options[price_id][]" id="edd_price_option_' . $eddnum . '_1" class="edd_price_option_' . $eddnum . '" value="1"><input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart"><span id="' . $eddnum . '-1" class="edd-cart-ajax-alert" aria-live="assertive"><span class="edd-cart-added-alert" style="display: none; color:white; top:5px; margin-left:-10px;"><p><i class="fas fa-check-circle"></i></p></span></span></form>';
		$output .= '<form id="edd_purchase_' . $eddnum . '-2" class="edd_download_purchase_form edd_purchase_' . $eddnum . ' purchbox" method="post"><span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer"><meta itemprop="price" content="' . $lic_wav . '"><meta itemprop="priceCurrency" content="USD"></span><a href="" class="edd-add-to-cart" data-nonce="' .  wp_create_nonce( 'edd-add-to-cart-' . $eddnum ) . '" data-action="edd_add_to_cart" data-download-id="' . $eddnum . '" data-variable-price="yes" data-price-mode="multi" data-price="' . $lic_wav . '"><span class="lictype">' . $bp_licname2 . '</span><span id="wavt" class="price">$' . $lic_wav . '</span><span class="lictype2">' . $bp_shead2 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span><span class="edd-add-to-cart-label"></span><span class="edd-loading" style="margin-left:-18px;margin-top:-15px;height:50px;width:50px;" aria-label="Loading"></span></a><input type="hidden" name="download_id" value="' . $eddnum . '"><input type="hidden" name="edd_options[price_id][]" id="edd_price_option_' . $eddnum . '_2" class="edd_price_option_' . $eddnum . '" value="2"><input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart"><span id="' . $eddnum . '-2" class="edd-cart-ajax-alert" aria-live="assertive"><span class="edd-cart-added-alert" style="display: none; color:white; top:5px; margin-left:-10px;"><p><i class="fas fa-check-circle"></i></p></span></span></form>';
		$output .= '<form id="edd_purchase_' . $eddnum . '-3" class="edd_download_purchase_form edd_purchase_' . $eddnum . ' purchbox" method="post"><span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer"><meta itemprop="price" content="' . $lic_premium . '"><meta itemprop="priceCurrency" content="USD"></span><a href="" class="edd-add-to-cart" data-nonce="' .  wp_create_nonce( 'edd-add-to-cart-' . $eddnum ) . '" data-action="edd_add_to_cart" data-download-id="' . $eddnum . '" data-variable-price="yes" data-price-mode="multi" data-price="' . $lic_premium . '"><span class="lictype">' . $bp_licname3 . '</span><span id="premiumt" class="price">$' . $lic_premium . '</span><span class="lictype2">' . $bp_shead3 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span><span class="edd-add-to-cart-label"></span><span class="edd-loading" style="margin-left:-18px;margin-top:-15px;height:50px;width:50px;" aria-label="Loading"></span></a><input type="hidden" name="download_id" value="' . $eddnum . '"><input type="hidden" name="edd_options[price_id][]" id="edd_price_option_' . $eddnum . '_3" class="edd_price_option_' . $eddnum . '" value="3"><input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart"><span id="' . $eddnum . '-3" class="edd-cart-ajax-alert" aria-live="assertive"><span class="edd-cart-added-alert" style="display: none; color:white; top:5px; margin-left:-10px;"><p><i class="fas fa-check-circle"></i></p></span></span></form>';
		$output .= '<form id="edd_purchase_' . $eddnum . '-4" class="edd_download_purchase_form edd_purchase_' . $eddnum . ' purchbox" method="post"><span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer"><meta itemprop="price" content="' . $lic_unlimited . '"><meta itemprop="priceCurrency" content="USD"></span><a href="" class="edd-add-to-cart" data-nonce="' .  wp_create_nonce( 'edd-add-to-cart-' . $eddnum ) . '" data-action="edd_add_to_cart" data-download-id="' . $eddnum . '" data-variable-price="yes" data-price-mode="multi" data-price="' . $lic_unlimited . '"><span class="lictype">' . $bp_licname4 . '</span><span id="unlimitedt" class="price">$' . $lic_unlimited . '</span><span class="lictype2">' . $bp_shead4 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span><span class="edd-add-to-cart-label"></span><span class="edd-loading" style="margin-left:-18px;margin-top:-15px;height:50px;width:50px;" aria-label="Loading"></span></a><input type="hidden" name="download_id" value="' . $eddnum . '"><input type="hidden" name="edd_options[price_id][]" id="edd_price_option_' . $eddnum . '_4" class="edd_price_option_' . $eddnum . '" value="4"><input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart"><span id="' . $eddnum . '-4" class="edd-cart-ajax-alert" aria-live="assertive"><span class="edd-cart-added-alert" style="display: none; color:white; top:5px; margin-left:-10px;"><p><i class="fas fa-check-circle"></i></p></span></span></form>';
		
		
		
		
		
		
		
		
		
		if ($bp_direct_encrypt == 1){
				
			if ($showEx == 1) {
			
				if ($makeOffer == '1') {
					$output .= '<a class="purchbox" target="_blank" href="/contact"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">~</span><span class="lictype2">' . __('Make an Offer', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-pencil-alt"></i></span></a>';
				} else {
					$output .= '<a class="purchbox" target="_blank" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=Exclusive%20Rights&purchase=' . $exclusive * 170486, e ) . '"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">$' . $exclusive . '</span><span class="lictype2">' . sprintf( __('%s Is Yours', 'beatpress' ), $name ) . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				}
			}

		} else {
			
			if ($showEx == 1) {
			
				if ($makeOffer == '1') {
					$output .= '<a class="purchbox" target="_blank" href="/contact"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">~</span><span class="lictype2">' . __('Make an Offer', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-pencil-alt"></i></span></a>';
				} else {
					$output .= '<a class="purchbox" target="_blank" href="/?beatpress_direct=true&beat=' . $name . '&license=Exclusive%20Rights&purchase=' . $exclusive * 170486 . '"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">$' . $exclusive . '</span><span class="lictype2">' . sprintf( __('%s Is Yours', 'beatpress' ), $name ) . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				}
			}
			
		}
		
		$output .= '</div>';

	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		if ($listenMoreLink == 1) {
			$output .= '<span class="loadholder" id="bpLoadStatic"><a href="' . get_permalink( $catalogUrl ) . '" id="loadt" class="loadmoreBtn"><i class="fas fa-caret-down"></i> ' . __('Listen More Beats', 'beatpress') . ' <i class="fas fa-caret-down"></i></a></span>';
		}	

		/*$output .= '<p id="op_contact"><a target="_blank" href="/contact"><i class="fas fa-envelope"></i> Still got questions? Need assistance? Contact me</a></p>';*/
		$output .= '<p id="op_cart"><i class="fas fa-cart-plus"></i> ' . __('Your cart', 'beatpress') . '</p>';
		$output .= do_shortcode( '[download_cart]' );
		
	
		
		//FREE DOWNLOADS SECTION
		if ($freedl == 1) {
			$output .= '<p id="download_shortcut"><i class="fas fa-cloud-download-alt"></i> ' . __('Grab the free download', 'beatpress') . '</p>';
			$output .= '<div class="socialaction" id="grabfree">';
			
			if ($freeDisclaimer == 1) {
				$output .= '<p><strong><i class="fas fa-exclamation-triangle"></i> ' . __('DISCLAIMER:', 'beatpress') . '</strong> ' . __('Free downloads are not “Free Beats”. They’re marked as free and available as free download for listening and evaluation purposes only. Purchase or license an instrumental to obtain rights to the beat. Any monetization / synchronization way is strictly prohibited', 'beatpress') . '.</p>';
			}

			if ($socialLocker == 1) {

				$output .= do_shortcode( '[sociallocker id="16188"]<p><a class="bp_button" href="' . $downloadfile . '" target="_blank"><i class="fas fa-download"></i> &nbsp;' . sprintf( __('Click here to download %s', 'beatpress' ), $name ) . '</a></p>
				[/sociallocker]' );

			} else {
							
				$output .= '<p><a class="bp_button" href="' . $downloadfile . '" target="_blank"><i class="fas fa-download"></i> &nbsp;' . sprintf( __('Click here to download %s', 'beatpress' ), $name ) . '</a></p>';
				
			}
			
			$output .= '</div>';
			
		}
		
		
		}
		
		
		
		
		//PURCHASE MODE EXTERNAL
		if ($bp_sellingMode == 'external'){
			
			if ($extlink == '') {
				$output .= '<span class="purchbox_external"><span class="lictype">' . __('Beat Link Not Found', 'beatpress') . '</span><span id="mp3t" class="price"><i class="fas fa-exclamation-circle"></i></span><span class="lictype2"><i class="fas fa-external-link-alt"></i> ' . __('Missing External Link', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-times"></i></span></span>';
				//$output .= '<span class="purchbox_external"><span class="lictype">Beat Link Not Found</span><span id="mp3t" class="price"><i class="fas fa-exclamation-circle"></i></span><span class="lictype2">No External URL Found</span><span class="fontaw_cont"><i class="fas fa-times"></i></span></span>';
			} else {
				if ($nofollowrule == '1') {
					$output .= '<a rel="nofollow" href="' . $extlink . '" target="_blank">';
					$output .= '<span class="purchbox_external"><span class="lictype">' . __('Click here to download', 'beatpress') . '</span><span id="mp3t" class="price">' . $name . '</span><span class="lictype2">' . __('Multiple Options', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-file-download"></i></span></span>';
					$output .= '</a>';
				} else {
					$output .= '<a href="' . $extlink . '" target="_blank">';
					$output .= '<span class="purchbox_external"><span class="lictype">' . __('Click here to download', 'beatpress') . '</span><span id="mp3t" class="price">' . $name . '</span><span class="lictype2">' . __('Multiple Options', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-file-download"></i></span></span>';
					$output .= '</a>';
				}

			}
		
			if ($listenMoreLink == 1) {
				$output .= '<span class="loadholder" id="bpLoadStatic"><a href="' . get_permalink( $catalogUrl ) . '" id="loadt" class="loadmoreBtn"><i class="fas fa-caret-down"></i> ' . __('Listen More Beats', 'beatpress') . ' <i class="fas fa-caret-down"></i></a></span>';
			}	

			$output .= '<br>';
		}
		

		
		
		

		
	}
	
	
	


	
	//Introduction Module
	if ($seoIntro == 1) {
		if ($intro == '') {
		} else {
			if ($genreIntro == 1) {
				if (get_the_term_list( $post->ID, 'genre', '', ', ' ) == ''){
					$output .= '<h2 id="texter1"><i class="fas fa-comments"></i> ' . sprintf( __('%s  - %s Instrumental', 'beatpress' ), $slike, $name ) . '</h2>';
				} else {
					$output .= '<h2 id="texter1"><i class="fas fa-comments"></i> ' . sprintf( __('%s  - %s Instrumental', 'beatpress' ), $slike, $name ) . ' (' . strip_tags ( get_the_term_list( $post->ID, 'genre', '', ', ' ) ) . ' Beat)</h2>';
				}
			} else {
				$output .= '<h2 id="texter1"><i class="fas fa-comments"></i> ' . sprintf( __('%s Introduction', 'beatpress' ), $name ) . '</h2>';
			}
			$output .= '<p>';
			$output .= $intro;
			$output .= '</p>';
		}
	}
	
	
	
	
	
	//Introduction Module
	if ($seiParagraphs == 1) {
		if ($p1 == '' AND $p2 =='' AND $p3 =='') {
		} else {
			$output .= '<h2 id="texter2"><i class="fas fa-info-circle"></i> ' . sprintf( __('About this %s Type Beat', 'beatpress' ), $slike ) . '</h2>';
			if ($p1 == '') {
			} else {
				$output .= '<p>' . $p1 . '</p>';
			}
			if ($p2 == '') {
			} else {
				$output .= '<p>' . $p2 . '</p>';
			}
			if ($p3 == '') {
			} else {
				$output .= '<p>' . $p3 . '</p>';
			}
		}
	}

	
	
	//$posttags = get_the_terms( $id, 'beat-tag');
	//Tags & Hashtags
	if ($beattagsshow == 1 && $enableBeatTagsTax == 1) {
		$output .= '<h3 id="taggy"><i class="fas fa-tags"></i> ' . sprintf( __('%s Tags', 'beatpress' ), $name ) . '</h3>';
		$output .= '<p>';
		$terms = get_the_terms( $post->ID, 'beat-tag' );
		if ($terms) {
			if ($tagsclick == 1) {
				foreach($terms as $term) {
				$output .= '<a title="' . sprintf( __('Browse the %s Beat Tag', 'beatpress' ), $term->name ) . '" href="/beat-tag/' . $term->slug . '"><i class="fas fa-tag"></i> ' . $term->name . '</a> &nbsp;&nbsp;';
				} 
			} else {
				foreach($terms as $term) {
				$output .= '<i class="fas fa-tag"></i> ' . $term->name . ' &nbsp;&nbsp;';
				} 
			}

		}
		$output .= '</p>';
	}
	
	
	
	//Genre Switcher
	$output .= '<p class="genremixer"><i class="fab fa-slack-hash"></i> ' . __('Browse beats by genre', 'beatpress') . '</p>';
		$genres = get_the_terms( $post->ID, 'genre' );
		if (!$genres[0]->name == '') {
			$output .= '<a href="' . get_term_link($genres[0]) . '"><span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[0]->name ) . '" class="cat_c"><strong><i class="fab fa-slack-hash"></i> ' . $genres[0]->name . '</strong></span></a>';
		}
		if (!$genres[1]->name == '') {
			$output .= '<a href="' . get_term_link($genres[1]) . '"><span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[1]->name ) . '" class="cat_c"><strong><i class="fab fa-slack-hash"></i> ' . $genres[1]->name . '</strong></span></a>';
		}
		if (!$genres[2]->name == '') {
			$output .= '<a href="' . get_term_link($genres[2]) . '"><span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[2]->name ) . '" class="cat_c"><strong><i class="fab fa-slack-hash"></i> ' . $genres[2]->name . '</strong></span></a>';
		}
		if (!$genres[3]->name == '') {
			$output .= '<a href="' . get_term_link($genres[3]) . '"><span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[3]->name ) . '" class="cat_c"><strong><i class="fab fa-slack-hash"></i> ' . $genres[3]->name . '</strong></span></a>';
		}
		$output .= '<br><br>';
	
	
	
	
	
	
	
	/* OLD WAY TO SHOW GENRES
	$output .= '<div class="genrelist" style="display:none;">';
	
	$genres = get_terms( array('taxonomy' => 'genre', 'hide_empty' => false) );
	foreach ( $genres as $term) {
		$output .= '<div class="col-md-3"><a href="' . get_term_link( $term ) . '"><i class="fab fa-slack"></i> ' . $term->name . '</a></div>';
	}

	$output .= '<p class="clearfix"></p>';
	$output .= '</div>';
	*/
	
	
	
	
	
	
	
	
	
	
	
	
	/*
	$args=array(
		'public'   => true,
		'_builtin' => false
	);
	$operator = 'and';
	$taxonomies=get_taxonomies($args, 'names',$operator); 
	if  ($taxonomies) {
		foreach ($taxonomies  as $taxonomy ) {
			$terms = get_terms( array(
				'taxonomy' => 'genre',
				'hide_empty' => false,
			) );
			foreach ( $terms as $term) {
				$output .= '<a href="' . $term->slug . '">' . $term->name . '</a> ';
			}
		}
	}  

	$output .= '<p class="clearfix"></p>';
	$output .= '</div>';
*/

	
	//YouTube Box
	if ($enableYt == 1) {
		//If autoembed option is activated show it
		if ($yt == 'NO' OR $yt == '') {
		} else {
			if ($ytLink == 1) {
				$output .= '<p id="ytparagraph"><i id="yticon" class="fab fa-youtube"></i> ' . __('Play this', 'beatpress') . ' <a id="ytanchor" target="_blank" href="https://www.youtube.com/watch?v=' . $yt . '">' . $slike . ' ' . __('Type Beat', 'beatpress') . '</a> ' . __('on YouTube', 'beatpress') . '</p><iframe width="100%" height="157" src="https://www.youtube.com/embed/' . $yt . '?rel=0&amp;start=4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
			} else {
				$output .= '<h3 id="ytparagraph"><i id="yticon" class="fab fa-youtube"></i> ' . sprintf( __('Play this %s Type Beat on YouTube', 'beatpress' ), $slike ) . '</h3><iframe width="100%" height="157" src="https://www.youtube.com/embed/' . $yt . '?rel=0&amp;start=4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
			}
			if ($theYtLink == ''){
				
				
			} else {
				$output .= '<a target="_blank" href="' . $theYtLink .'?sub_confirmation=1"><p id="ytbell"><i class="fas fa-bell"></i> ' . __('Subscribe on YouTube!', 'beatpress') . '</p></a>';
			}
			
		}
	}
	
	
	//Beat Ratings
	if ($ratingStar == 1) {
		$output .= '<p id="pratings"><i class="fas fa-thumbs-up"></i> ' . sprintf( __('Rate %s, feedback is always welcome', 'beatpress' ), $name ) . '</p>';
		$output .= do_shortcode( '[ec_stars_rating]' );		
		$output .= '<br>';		
	}



	
	//Navigation Buttons
	if ($navigationLinks == 1) {
		$output .= '<div class="navbro">';
		if (strlen(get_previous_post()->post_title) > 0) {
			$output .= '<a class="nav" href="' . get_permalink( get_adjacent_post( false, '', true ) ) . '"><i class="fas fa-angle-double-left"></i> ' . __('Previous beat', 'beatpress') . '</a>';
		} else {
			if (! $theYtLink == '') {
				$output .= '<a class="nav" target="_blank" href="' . $theYtLink .'?sub_confirmation=1"><i class="fab fa-youtube"></i> ' . __('Subscribe', 'beatpress') . '</a>';
			} else {
				$output .= '<a class="nav" target="_blank" href="' . get_permalink( $catalogUrl ) . '"><i class="fas fa-compact-disc fa-spin"></i> ' . __('Full Catalog', 'beatpress') . '</a>';
			}
		}
		if (strlen(get_next_post()->post_title) > 0) {
			$output .= '<a class="nav navright" href="' . get_permalink( get_adjacent_post( false, '', false ) ) . '">' . __('Next beat', 'beatpress') . ' <i class="fas fa-angle-double-right"></i></a>';
		} else {
			if (! $theYtLink == '') {
				$output .= '<a class="nav navright" target="_blank" href="' . $theYtLink .'?sub_confirmation=1">' . __('Subscribe', 'beatpress') . ' <i class="fab fa-youtube"></i></a>';
			} else {
				$output .= '<a class="nav navright" target="_blank" href="' . get_permalink( $catalogUrl ) . '">' . __('Full Catalog', 'beatpress') . ' <i class="fas fa-compact-disc fa-spin"></i></a>';
			}
			
		}
		$output .= '</div><br>';
	}

	if ($disqusEnabled == 1) {
		
		if ($disqusCode = '') {
			
			$output .= '<div class="bp_disqus">Disqus Code Not Found</div>';
			
		} else {
			$output .= '<div class="bp_disqus">';

			$output .= $disqusHTMLCode;
			$output .= '</div>';

		}
		
		
		
		
	}


	


	
	/*Genre displayer
	$output .= '<div class="box box-2 clearfix"><div class="box-content" style="">';
	$output .= '<span style="font-size: small;"><i class="fa fa-arrow-right"></i> Click the following links to listen and download more <a href="https://www.surcebeats.com/category/beats' . $category1link . '" title="' . $category1 . ' Beats & Instrumentals">' . $category1 . '</a> and <a href="https://www.surcebeats.com/category/beats' . $category2link . '" title="' . $category2 . ' Beats & Instrumentals">' . $category2 . '</a> beats and instrumentals.</span>';
	$output .= '</div></div>';*/

	/*Subbcategories Show
	$subcategories = get_categories('&child_of=1443&hide_empty');
	$output .= '<div class="box box-2 clearfix"><div class="box-content" style="">';
	$output .= '<div class="toggle"><i style="color:#18a3d3;" class="fa fa-arrow-right"></i> <a style="color:#18a3d3;font-size:small; text-decoration: none;font-weight:normal;" class="toggle-title">Click here to browse beats by genre</a><div class="toggle-content" style="display: none;">';
	$output .= '<p><hr>';
	foreach ($subcategories as $subcategory) {
		$output .= sprintf('<a href="%s"></i> %s Beats</a> <i class="fa fa-ellipsis-h"></i> ', get_category_link($subcategory->term_id), apply_filters('get_term', $subcategory->name));
	}
	$output .= '</p>';
	$output .= '</div></div></div></div>';*/
		
	/*Button to go back to the store
	$output .= '<div class="box box-2 clearfix"><div class="box-content" style="">';
	$output .= '<p style="font-size:small;"><a href="/store"><i class="fa fa-arrow-left"></i> Click here to go back to the store and listen more instrumentals.</a></p>';
	$output .= '</div></div>';*/

	
	//Schema Markup
	$output .= '<script type="application/ld+json">
				{
					"@context": "http://schema.org/",
					"@type": "Product",
					"name": "' . $name . ' Instrumental",
					"image": "' . $imageJSON . '",
					"description": "' . sprintf( __('%s, an %s Type Beat produced by %s', 'beatpress' ), $name, $slike, $producerName ) . '",
					"brand": {
					"@type": "Person",
					"name": "' . $producerName . '"
					},
					"offers": {
					"@type": "Offer",
					"price": "' . $lic_mp3 . '",
					"priceCurrency": "USD",
					"url": "' . get_permalink( $post->ID ) . '"
					}
				}
				</script>';

				
				
				
if ( ! is_admin() ) {
    jPlayerInit();
} else {
   
}

	

	
			
	
	
	
	
//"startDate": "2013-09-14T21:30"

							
  return $output;
		
		
		
		
		
		
		
		
		
	}
	
	return $content;
}
add_filter('the_content', 'beatpress_beats');