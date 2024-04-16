<?php
/**
 * BeatPress Catalog
 * Main beats catalog, genre options are inherited
 *
 * @/inc/beatpress_catalog.php
 * @package BeatPress
 */

// Security Layer
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access to BeatPress Script denied.' );
}

//Playlist Invoker

function beatpress_catalog($content) {
	//echo get_the_ID();
	GLOBAL $option_checker;
	GLOBAL $myversion;
	GLOBAL $bpurl;


	
	//CHECK IF CATALOG PAGE IS SELECTED PAGE
	if ( in_the_loop() && get_the_ID() == $option_checker['catalogurl']) {
		echo '<!-- This beat store page has been dynamically generated with BeatPress Version ' . $myversion . ' by Banshee -->';
		echo '<!-- Get BeatPress for free at ' . $bpurl . ' -->';

		//$total_beats = wp_count_posts( 'instrumentals' )->publish;
		$content = '';
		
		if ($option_checker['catalogpagetitle'] == 1) {
			echo '<h1 class="bp_headingtitle">' . get_the_title() . '</h1>';
		}
			
	
		if ($option_checker['catalogbanner'] == '') {
		} else {
			if ($option_checker['bannertitle_override'] == '') {
				echo '<img width="100%" src="' . $option_checker['catalogbanner'] . '" /><span class="bpsep"></span>';
			} else {
				echo '<img width="100%" alt="' . $option_checker['bannertitle_override'] . '" title="' . $option_checker['bannertitle_override'] . '" src="' . $option_checker['catalogbanner'] . '" /><span class="bpsep"></span>';
			}
			

		}
		

	

		featured_beat_caller();
		
		
		if ($option_checker['searchbox_top'] == 1) {
			echo '<form class="beatsearch" action="/">
			<input type="search" name="s" placeholder="' . __('Search beat name, artist, genre, tags...', 'beatpress') . '" >
			<button name="post_type" value="instrumentals" type="hidden"><i class="fas fa-search searchicon"></i></button>
			</form><span class="bpsep"></span>';
		}		

		
		echo do_shortcode('[beats_load]'); 
		echo '<span class="bpsep"></span>';
		echo '<span class="loadholder" id="bpLoadAjax" data-page="1" data-url="'.admin_url("admin-ajax.php").'"><p id="loadt" class="loadmoreBtn"><i class="fas fa-caret-down"></i> ' . __('Load More Beats', 'beatpress') . ' <i class="fas fa-caret-down"></i></p></span>';
		jPlayerInit();
		
		//Genres List Bottom
		
		if ($option_checker['browsebeatsgenre'] == 1) {
		
			echo '<br><div class="bp_dump_genrelist">';
		
			$terms = get_terms('genre');
			if ( !empty( $terms ) && !is_wp_error( $terms ) ){
				foreach ( $terms as $term ) {
					
					

					
					
					
					
					if ($option_checker['showonlygenres'] == 1){
						if ($term->count >= 5){
							echo '<a title="' . $option_checker['titlefirst'] . ' ' . $term->name . ' ' . $option_checker['titlelast'] . ' (' . $term->count . ' Beats)" href="' . get_term_link($term->term_id) . '" class="cattb_bpgenres"><i class="fab fa-slack-hash"></i> ' . $term->name . ' (' . $term->count . ')</a>';
						}
					} else {
						echo '<a title="' . $option_checker['titlefirst'] . ' ' . $term->name . ' ' . $option_checker['titlelast'] . ' (' . $term->count . ' Beats)" href="' . get_term_link($term->term_id) . '" class="cattb_bpgenres"><i class="fab fa-slack-hash"></i> ' . $term->name . ' (' . $term->count . ')</a>';
					}
					
					

					
				}
			}

			echo '<br></div>';
	
		}
		
		
		
		
		
		
		
		
		
		
		
		
		//Social Networks
		if ($option_checker['catalogsnetworks'] == 1) {
			
			echo '<br><span class="bp_socials">';
			
			if ($option_checker['twitterlink'] == '') {
			} else {
				echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['twitterlink'] . '" title="' . sprintf( __('Follow %s on Twitter', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fa-twitter fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
			}
			
			if ($option_checker['facebooklink'] == '') {
			} else {
				echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['facebooklink'] . '" title="' . sprintf( __('Follow %s on Facebook', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fa-facebook-f fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
			}
						
			if ($option_checker['soundcloudlink'] == '') {
			} else {
				echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['soundcloudlink'] . '" title="' . sprintf( __('Follow %s on SoundCloud', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fa-soundcloud fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
			}
									
			if ($option_checker['instagramlink'] == '') {
			} else {
				echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['instagramlink'] . '" title="' . sprintf( __('Follow %s on Instagram', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fa-instagram fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
			}
												
			if ($option_checker['youtubelink'] == '') {
			} else {
				echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['youtubelink'] . '" title="' . sprintf( __('Follow %s on YouTube', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fa-youtube fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
			}
			
			if ($option_checker['redditlink'] == '') {
			} else {
				echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['redditlink'] . '" title="' . sprintf( __('Follow %s on Reddit', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fa-reddit-alien fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
			}
			
			if ($option_checker['bstalink'] == '') {
			} else {
				echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['bstalink'] . '" title="' . sprintf( __('Follow %s on BeatStars', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fab fa-bootstrap fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
			}
						
			if ($option_checker['airbilink'] == '') {
			} else {
				echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['airbilink'] . '" title="' . sprintf( __('Follow %s on Airbit', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fab fa-autoprefixer fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
			}
			
			echo '</span>';
			
		}	
		
		if (!$option_checker['catalogseo1'] == '') {
			echo '<p id="paragraph1">' . $option_checker['catalogseo1'] . '</p>';
		}
		
		if (!$option_checker['catalogpricing'] == '') {
			echo '<p id="pricing">' . $option_checker['catalogpricing'] . '</p>';
		}
		
	

		//Parallax Non Intrusive Advertising
		if ($option_checker['supportads'] == 1) {
		} else {
			echo '<br><a target="_blank" href="https://github.com/BansheeDevelopment/BeatPress?' . $_SERVER['SERVER_NAME'] . '"><div class="ad-parallax-wrapper"><div class="ad-parallax-container">';
			echo '<img title="' . __('Powered by BeatPress', 'beatpress') . ' ' . $myversion . '" alt="' . __('Powered by BeatPress', 'beatpress') . ' ' . $myversion . '" height="32px" width="32px" src="/wp-content/plugins/beatpress/imgs/system/logo.png">';
			echo '</div></div></a><br>';		
		}
	}

	return $content;

}
add_filter('the_content', 'beatpress_catalog');




function featured_beat_caller(){
	GLOBAL $option_checker;

	if ($option_checker['enablefeatured'] == 1) {
		
		$featuredbeat = $option_checker['currentfeaturedbeat']; 

		$files = get_post_meta( $featuredbeat, 'bp_streaming_file', true ); //NEW MP3 FILE
	
		foreach( $files as $file ) {
			$encrypted = my_simple_crypt( $file['url'], 'e' );
			break;
		}
		
		$title = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'name', true );
		$slike = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'slike', true );
		$intro = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'intro', true );
		$genres = get_the_terms( $featuredbeat, 'genre' );
		$name = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'name', true );
		$songid = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'songid', true );
		//$encrypted = my_simple_crypt( $songid, 'e' );
		$sold = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'sold', true );
		$eddnum = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'eddnum', true );
		$lic_mp3 = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'lic_mp3', true );
		$lic_wav = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'lic_wav', true );
		$lic_premium = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'lic_premium', true );
		$lic_unlimited = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'lic_unlimited', true );
		$exclusive = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'exclusive', true );
		$extlink = get_post_meta( $featuredbeat, 'beatpress_toolbox_' . 'buy_external', true );

		
		$bp_sellingMode = $option_checker['purchasemode'];
		$bp_buttonsize = $option_checker['smallpb'];
		$bp_direct_encrypt = $option_checker['bpdirectencryptsession'];
		$bp_interlinking = $option_checker['cataloginterlinking'];
	
		$bp_licname1 = $option_checker['bp_lic_first_name'];
		$bp_licname2 = $option_checker['bp_lic_second_name'];
		$bp_licname3 = $option_checker['bp_lic_third_name'];
		$bp_licname4 = $option_checker['bp_lic_fourth_name'];
	
		$bp_shead1 = $option_checker['bp_lic_first_shead'];
		$bp_shead2 = $option_checker['bp_lic_second_shead'];
		$bp_shead3 = $option_checker['bp_lic_third_shead'];
		$bp_shead4 = $option_checker['bp_lic_fourth_shead'];
		
		$showEx = $option_checker['showexclusivecatalog'];
		$nofollowrule = $option_checker['bpexternalnofollow'];

		$makeOffer = $option_checker['offercatalog'];

		
		if ($sold == 'yes'){
			
			if( current_user_can('administrator')) {
				echo '<p><strong>' . __('Message for site administrator:', 'beatpress') . '</strong> ' . __('Your featured beat has been marked as sold, change it to feature a new beat', 'beatpress') . ' <a href="/wp-admin/admin.php?page=beatpress-catalog#featureselect">' . __('clicking here', 'beatpress') . '</a>.</p>';
			}
			
		} else {
			
			
			





			
			if (has_post_thumbnail( $featuredbeat )){
				$image = get_the_post_thumbnail($featuredbeat, "beatpress-playlist-image-featured-size", array('title' => '' . sprintf( __('Listen to %s, a %s Type Beat', 'beatpress' ), $name, $slike ) . '', 'alt' => $name . ' Instrumental', 'class' => 'ftimaged'));
				$innerimage = get_the_post_thumbnail($featuredbeat, array( 20, 20, 'class' => ' tinydescimg ') );
			} else {
				$image = '<img class="ftimaged" src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog_170.jpg" title="' . sprintf( __('Listen to %s, a %s Type Beat', 'beatpress' ), $name, $slike ) . '" alt="' . $name . ' Instrumental">';
				$innerimage = '<img class="tinydescimg" src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog.jpg" height="20px" width="20px" title="' . sprintf( __('Listen to %s, a %s Type Beat', 'beatpress' ), $name, $slike ) . '" alt="' . $name . ' Instrumental">';
			}
	
			echo '<div id="featured_cont" xnd="' . $name . '" xid="' . $encrypted . '">';
			echo '<span id="image_featured_beat" class="featyfeat"><span title="' . __('Now listening:', 'beatpress') . ' ' . $title . '" class="ppplistening ppplistening_feat" style="display: none;"><i class="fas fa-circle-notch fa-spin"></i></span>';
			echo $image;
			echo '</span>';

			echo '<span id="metadata_container">';
			echo '<span class="tinyft"><i class="fas fa-award"></i> ' . __('Featured Beat', 'beatpress') . '</span>';
			echo '<span id="title_spanner_link">' . $title . '</span>';
			if ($option_checker['producerlogo'] == '') {
				echo '<span class="ftprodby"><img width="22" height="22" alt="" title="' . __('Produced by', 'beatpress') . ' ' . $option_checker['producername'] . '" src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog_170.jpg" id="producer_logo" /> ' . $option_checker['producername'] . '</span>';
			} else {
				echo '<span class="ftprodby"><img width="22" height="22" alt="" title="' . __('Produced by', 'beatpress') . ' ' . $option_checker['producername'] . '" src="' . $option_checker['producerlogo'] . '" id="producer_logo" /> ' . $option_checker['producername'] . '</span>';
			}
			
			if ($option_checker['featuredtextrow'] == '') {			
				echo '<span class="ftdesc"><i class="fas fa-align-left"></i> ' . $intro . '</span>';
			}
			
			echo '</span>';
	
			echo '<span id="buttons_featured">';
		
			if ($option_checker['opennewwindowcatalog'] == 1) {
				if ($bp_interlinking == '1'){
				} else {
					echo '<a class="openlinkfeatured iBk ppplink" title="' . sprintf( __('Download %s Instrumental', 'beatpress' ), $name ) . '" target="_blank" href="' . get_post_permalink($featuredbeat) . '"><span class="text_contfeatured"><i class="fas fa-download"></i></span></a>';
				}
				
				
				
			} else {
				
				if ($bp_interlinking == '1'){
				} else {
					echo '<a class="openlinkfeatured iBk ppplink" title="' . sprintf( __('Download %s Instrumental', 'beatpress' ), $name ) . '" href="' . get_post_permalink($featuredbeat) . '"><span class="text_contfeatured"><i class="fas fa-download"></i></span></a>';
				}
			}
		
			echo '<a class="bp_box_color purchaselinkfeatured iBk" title="' . sprintf( __('%s Purchase Options', 'beatpress' ), $name ) . '"><span class="icon_contfeatured"><i class="fas fa-cart-plus"></i></span> <span class="text_contfeatured">' . __('ADD TO CART', 'beatpress') . '</span></a>';
			echo '<span class="clearfix bp_clearfix"></span>';
		
			if (!$genres[0]->name == '') {
				echo '<span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[0]->name ) . '" class="catft"><strong><i class="fab fa-slack-hash"></i> ' . $genres[0]->name . '</strong></span>';
			}
			
			if (!$genres[1]->name == '') {
				echo '<span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[1]->name ) . '" class="catft"><strong><i class="fab fa-slack-hash"></i> ' . $genres[1]->name . '</strong></span>';
			}
			if (!$genres[2]->name == '') {
				echo '<span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[2]->name ) . '" class="catft"><strong><i class="fab fa-slack-hash"></i> ' . $genres[2]->name . '</strong></span>';
			}

			echo '</span>';	
		
			echo '</div>'; //END ID FEATURED_CONT
			
			
			
			
			
			
			
			
			
			
			
			
			
			


			if (!$option_checker['enablemodalbox'] == '1') {
				echo '<div class="bnbuttons bppadder">';
				echo '<span class="bpsep"></span>';
			} else {
				echo '<div class="bnbuttons bpmodal"><div class="bpmodal-body"><span class="bpmodalwidget"><span id="bottomplayer" xNd="' . $name . '" xId="' . $encrypted . '" class="modcloser pwidget"><span class="fa-stack fa-2x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-play fa-stack-1x fa-inverse"></i></span></span> <span class="modcloser"></span> <span class="nocloser cwidget"><span class="fa-stack fa-2x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-times fa-stack-1x fa-inverse"></i></span></span></span><div class="bpmodal-content">';
			}

		
			echo '<div class="bp-beat-desc">';
			echo '<div class="title_desc_catalog">' . $innerimage . ' ' . $name . '</div>';
			
			if ($option_checker['producerlogo'] == '') {
				echo '<span class="ftprodby"><img width="22" height="22" alt="" title="' . __('Produced by', 'beatpress') . ' ' . $option_checker['producername'] . '" src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog_170.jpg" id="producer_logo" /> ' . $option_checker['producername'] . '</span>';
			} else {
				echo '<span class="ftprodby"><img width="22" height="22" alt="" title="' . __('Produced by', 'beatpress') . ' ' . $option_checker['producername'] . '" src="' . $option_checker['producerlogo'] . '" id="producer_logo" /> ' . $option_checker['producername'] . '</span>';
			}
			echo '</div>';	
			
			
			
			
			
			
			
			
			//PURCHASE MODE DIRECT
			if ($bp_sellingMode == 'direct'){
		
				if ($bp_direct_encrypt == 1){
					

				echo '<div class="bp_flexcont">'; //FLEXBOX START
				
				echo '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=' . $bp_licname1 . '&purchase=' . $lic_mp3 * 170486, e) . '" target="_blank"><span class="lictype">' . $bp_licname1 . '</span><span id="mp3t" class="price">$' . $lic_mp3 . '</span><span class="lictype2">' . $bp_shead1 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				echo '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=' . $bp_licname2 . '&purchase=' . $lic_wav * 170486, e) . '" target="_blank"><span class="lictype">' . $bp_licname2 . '</span><span id="mp3t" class="price">$' . $lic_wav . '</span><span class="lictype2">' . $bp_shead2 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				echo '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=' . $bp_licname3 . '&purchase=' . $lic_premium * 170486, e) . '" target="_blank"><span class="lictype">' . $bp_licname3 . '</span><span id="mp3t" class="price">$' . $lic_premium . '</span><span class="lictype2">' . $bp_shead3 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				echo '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=' . $bp_licname4 . '&purchase=' . $lic_unlimited * 170486, e) . '" target="_blank"><span class="lictype">' . $bp_licname4 . '</span><span id="mp3t" class="price">$' . $lic_unlimited . '</span><span class="lictype2">' . $bp_shead4 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';

		
				if ($showEx == 1) {
			
					if ($makeOffer == "1") {
						echo '<a class="purchbox" target="_blank" href="/contact"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">~</span><span class="lictype2">' . __('Make an Offer', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-pencil-alt"></i></span></a>';
					} else {
						echo '<a class="purchbox" target="_blank" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=Exclusive%20Rights&purchase=' . $exclusive * 170486, e ) . '"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">$' . $exclusive . '</span><span class="lictype2">' . sprintf( __('%s Is Yours', 'beatpress' ), $name ) . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
					}
				}
				
				echo '</div>'; //FLEXBOX END

				
			} else {
				
				echo '<div class="bp_flexcont">'; //FLEXBOX START
				
				echo '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=' . $bp_licname1 . '&purchase=' . $lic_mp3 * 170486 . '" target="_blank"><span class="lictype">' . $bp_licname1 . '</span><span id="mp3t" class="price">$' . $lic_mp3 . '</span><span class="lictype2">' . $bp_shead1 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				echo '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=' . $bp_licname2 . '&purchase=' . $lic_wav * 170486 . '" target="_blank"><span class="lictype">' . $bp_licname2 . '</span><span id="mp3t" class="price">$' . $lic_wav . '</span><span class="lictype2">' . $bp_shead2 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				echo '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=' . $bp_licname3 . '&purchase=' . $lic_premium * 170486 . '" target="_blank"><span class="lictype">' . $bp_licname3 . '</span><span id="mp3t" class="price">$' . $lic_premium . '</span><span class="lictype2">' . $bp_shead3 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				echo '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=' . $bp_licname4 . '&purchase=' . $lic_unlimited * 170486 . '" target="_blank"><span class="lictype">' . $bp_licname4 . '</span><span id="mp3t" class="price">$' . $lic_unlimited . '</span><span class="lictype2">' . $bp_shead4 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
		
				if ($showEx == 1) {
			
					if ($makeOffer == "1") {
						echo '<a class="purchbox" target="_blank" href="/contact"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">~</span><span class="lictype2">' . __('Make an Offer', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-pencil-alt"></i></span></a>';
					} else {
						echo '<a class="purchbox" target="_blank" href="/?beatpress_direct=true&beat=' . $name . '&license=Exclusive%20Rights&purchase=' . $exclusive * 170486 . '"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">$' . $exclusive . '</span><span class="lictype2">' . sprintf( __('%s Is Yours', 'beatpress' ), $name ) . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
					}
				}
				
				echo '</div>'; //FLEXBOX END

				
			}				
				
			}
			
			
			
			
			
			
			
			
			
			
			//EASY DIGITAL DOWNLOADS PURCHASE MODE
			if ($bp_sellingMode == 'edd'){

			
			
			$eddnonce = wp_create_nonce( 'edd-add-to-cart-' . $eddnum);
			
			echo '<div class="bp_flexcont">';

			echo '<form id="edd_purchase_' . $eddnum . '-1" class="edd_download_purchase_form edd_purchase_' . $eddnum . ' purchbox" method="post"><span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer"><meta itemprop="price" content="' . $lic_mp3 . '"><meta itemprop="priceCurrency" content="USD"></span><a href="" class="edd-add-to-cart" data-nonce="' .  $eddnonce . '" data-action="edd_add_to_cart" data-download-id="' . $eddnum . '" data-variable-price="yes" data-price-mode="multi" data-price="' . $lic_mp3 . '"><span class="lictype">' . $bp_licname1 . '</span><span id="mp3t" class="price">$' . $lic_mp3 . '</span><span class="lictype2">' . $bp_shead1 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span><span class="edd-add-to-cart-label"></span><span id="loadbig" class="edd-loading loadbig" aria-label="Loading"></span></a><input type="hidden" name="download_id" value="' . $eddnum . '"><input type="hidden" name="edd_options[price_id][]" id="edd_price_option_' . $eddnum . '_1" class="edd_price_option_' . $eddnum . '" value="1"><input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart"><span id="' . $eddnum . '-1" class="edd-cart-ajax-alert" aria-live="assertive"><span class="edd-cart-added-alert" style="display: none; color:white; top:5px; margin-left:-10px;"><p><i class="fas fa-check-circle"></i></p></span></span></form>';
	
			echo '<form id="edd_purchase_' . $eddnum . '-2" class="edd_download_purchase_form edd_purchase_' . $eddnum . ' purchbox" method="post"><span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer"><meta itemprop="price" content="' . $lic_wav . '"><meta itemprop="priceCurrency" content="USD"></span><a href="" class="edd-add-to-cart" data-nonce="' .  $eddnonce . '" data-action="edd_add_to_cart" data-download-id="' . $eddnum . '" data-variable-price="yes" data-price-mode="multi" data-price="' . $lic_wav . '"><span class="lictype">' . $bp_licname2 . '</span><span id="wavt" class="price">$' . $lic_wav . '</span><span class="lictype2">' . $bp_shead2 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span><span class="edd-add-to-cart-label"></span><span class="edd-loading loadbig" aria-label="Loading"></span></a><input type="hidden" name="download_id" value="' . $eddnum . '"><input type="hidden" name="edd_options[price_id][]" id="edd_price_option_' . $eddnum . '_2" class="edd_price_option_' . $eddnum . '" value="2"><input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart"><span id="' . $eddnum . '-2" class="edd-cart-ajax-alert" aria-live="assertive"><span class="edd-cart-added-alert" style="display: none; color:white; top:5px; margin-left:-10px;"><p><i class="fas fa-check-circle"></i></p></span></span></form>';
	
			echo '<form id="edd_purchase_' . $eddnum . '-3" class="edd_download_purchase_form edd_purchase_' . $eddnum . ' purchbox" method="post"><span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer"><meta itemprop="price" content="' . $lic_premium . '"><meta itemprop="priceCurrency" content="USD"></span><a href="" class="edd-add-to-cart" data-nonce="' .  $eddnonce . '" data-action="edd_add_to_cart" data-download-id="' . $eddnum . '" data-variable-price="yes" data-price-mode="multi" data-price="' . $lic_premium . '"><span class="lictype">' . $bp_licname3 . '</span><span id="premiumt" class="price">$' . $lic_premium . '</span><span class="lictype2">' . $bp_shead3 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span><span class="edd-add-to-cart-label"></span><span class="edd-loading loadbig" aria-label="Loading"></span></a><input type="hidden" name="download_id" value="' . $eddnum . '"><input type="hidden" name="edd_options[price_id][]" id="edd_price_option_' . $eddnum . '_3" class="edd_price_option_' . $eddnum . '" value="3"><input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart"><span id="' . $eddnum . '-3" class="edd-cart-ajax-alert" aria-live="assertive"><span class="edd-cart-added-alert" style="display: none; color:white; top:5px; margin-left:-10px;"><p><i class="fas fa-check-circle"></i></p></span></span></form>';
	
			echo '<form id="edd_purchase_' . $eddnum . '-4" class="edd_download_purchase_form edd_purchase_' . $eddnum . ' purchbox" method="post"><span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer"><meta itemprop="price" content="' . $lic_unlimited . '"><meta itemprop="priceCurrency" content="USD"></span><a href="" class="edd-add-to-cart" data-nonce="' .  $eddnonce . '" data-action="edd_add_to_cart" data-download-id="' . $eddnum . '" data-variable-price="yes" data-price-mode="multi" data-price="' . $lic_unlimited . '"><span class="lictype">' . $bp_licname4 . '</span><span id="unlimitedt" class="price">$' . $lic_unlimited . '</span><span class="lictype2">' . $bp_shead4 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span><span class="edd-add-to-cart-label"></span><span class="edd-loading loadbig" aria-label="Loading"></span></a><input type="hidden" name="download_id" value="' . $eddnum . '"><input type="hidden" name="edd_options[price_id][]" id="edd_price_option_' . $eddnum . '_4" class="edd_price_option_' . $eddnum . '" value="4"><input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart"><span id="' . $eddnum . '-4" class="edd-cart-ajax-alert" aria-live="assertive"><span class="edd-cart-added-alert" style="display: none; color:white; top:5px; margin-left:-10px;"><p><i class="fas fa-check-circle"></i></p></span></span></form>';
			


			
			
			
			
			
				if ($bp_direct_encrypt == 1){

				if ($showEx == 1) {
			
					if ($makeOffer == "1") {
						echo '<a class="purchbox" target="_blank" href="/contact"><span class="lictype">' . __('Exclusive Rights', 'beatpress'). '</span><span id="ex_lictype" class="price">~</span><span class="lictype2">' . __('Make an Offer', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-pencil-alt"></i></span></a>';
					} else {
						echo '<a class="purchbox" target="_blank" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=Exclusive%20Rights&purchase=' . $exclusive * 170486, e ) . '"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">$' . $exclusive . '</span><span class="lictype2">' . sprintf( __('%s Is Yours', 'beatpress' ), $name ) . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
					}
				}
				

				
			} else {
				
				if ($showEx == 1) {
			
					if ($makeOffer == "1") {
						echo '<a class="purchbox" target="_blank" href="/contact"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">~</span><span class="lictype2">' . __('Make an Offer', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-pencil-alt"></i></span></a>';
					} else {
						echo '<a class="purchbox" target="_blank" href="/?beatpress_direct=true&beat=' . $name . '&license=Exclusive%20Rights&purchase=' . $exclusive * 170486 . '"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">$' . $exclusive . '</span><span class="lictype2">' . sprintf( __('%s Is Yours', 'beatpress' ), $name ) . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
					}
				}
				

				
			}				
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			echo '</div>';

			
			}
			
			
			//PURCHASE MODE EXTERNAL
			if ($bp_sellingMode == 'external'){

				echo '<a href="' . get_post_permalink($featuredbeat) . '">';
				echo '<span class="purchbox_external"><span class="lictype">' . __('Click here to download', 'beatpress') . '</span><span id="mp3t" class="price">' . $name . '</span><span class="lictype2">' . __('Multiple Options', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-file-download"></i></span></span>';
				echo '</a>';

			}
		
			
			
			
			
			
			
			
			
		
		if ($option_checker['seointrocatalog'] == '1'){
			echo '<div class="bp-beat-desc">';
			echo '<span class="catalogftdesc"><strong><i class="fas fa-align-left"></i> ' . __('Beat Description', 'beatpress') . '</strong>: ' . $intro . '</span>';
			echo '</div>';			
		}
		
		if (!$option_checker['enablemodalbox'] == '1') {
			echo '</div>';
		} else {
			echo '</div></div></div>';
		}
			//END PURCHASE
		
			echo '<span class="bpsep"></span>';

		}

	}
		
}



/*
function featured_beat( $beat ){
	featured_beat_caller( $beat );
	jPlayerInit();
}
add_shortcode('featured_beat', 'featured_beat');
*/













//Format Catalog Design & Individual Post Data Retriever
function catalog_formatter() {
	GLOBAL $option_checker;
	//$rnder = rand(10000, 99999);
	
	$files = get_post_meta( get_the_ID(), 'bp_streaming_file', true ); //NEW MP3 FILE
	
	
	
	foreach( $files as $file ) {

		$encrypted = my_simple_crypt( $file['url'], 'e' );
		break;
	}

	//$image = the_post_thumbnail ('beatpress-playlist-image-size');
	$name = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'name', true );
	$nameO = $name;
	$songid = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'songid', true );
	//$encrypted = my_simple_crypt( $songid, 'e' );
	$sold = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'sold', true );
	$slike = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'slike', true );
	$eddnum = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'eddnum', true );
	$intro = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'intro', true );
	$lic_mp3 = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'lic_mp3', true );
	$lic_wav = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'lic_wav', true );
	$lic_premium = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'lic_premium', true );
	$lic_unlimited = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'lic_unlimited', true );
	$exclusive = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'exclusive', true );
	$extlink = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'buy_external', true );
	$bpcol = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'collab', true );
	$bphoo = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'hook', true );
	$bp_sellingMode = $option_checker['purchasemode'];
	$bp_buttonsize = $option_checker['smallpb'];
	$bp_fluid = $option_checker['fluid'];
	$bp_direct_encrypt = $option_checker['bpdirectencryptsession'];
	$bp_interlinking = $option_checker['cataloginterlinking'];

	
	$bp_licname1 = $option_checker['bp_lic_first_name'];
	$bp_licname2 = $option_checker['bp_lic_second_name'];
	$bp_licname3 = $option_checker['bp_lic_third_name'];
	$bp_licname4 = $option_checker['bp_lic_fourth_name'];
	
	$bp_shead1 = $option_checker['bp_lic_first_shead'];
	$bp_shead2 = $option_checker['bp_lic_second_shead'];
	$bp_shead3 = $option_checker['bp_lic_third_shead'];
	$bp_shead4 = $option_checker['bp_lic_fourth_shead'];
	$showEx = $option_checker['showexclusivecatalog'];

	$nofollowrule = $option_checker['bpexternalnofollow'];
	
	$makeOffer = $option_checker['offercatalog'];


	
	
	
	if ( has_post_thumbnail() ) {
		$image = get_the_post_thumbnail($post->ID, "beatpress-playlist-image-size", array('title' => '' . sprintf( __('Listen to %s, a %s Type Beat', 'beatpress' ), $name, $slike ) . '', 'alt' => $name . ' instrumental'));
		$innerimage = get_the_post_thumbnail($post->ID, array( 20, 20, 'class' => ' tinydescimg ') );
	} else {
		$image = '<img src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog.jpg" title="' . sprintf( __('Listen to %s, a %s Type Beat', 'beatpress' ), $name, $slike ) . '" alt="' . $name . ' Instrumental">';
		$innerimage = '<img class="tinydescimg" src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog.jpg" height="20px" width="20px" title="Listen to ' . $name . ', a ' . $slike . ' Type Beat" alt="' . $name . ' Instrumental">';

	}
	
	if ($sold == 'yes'){
		$name = $name . ' ' . __('(SOLD)', 'beatpress') . '';
	}
	
	
	
	
	
	
	
	//SHOW YOUTUBE
	//$yt = get_post_meta( get_the_ID(), 'beatpress_toolbox_' . 'yt', true );
	//echo '<br><br><br><i class="fas fa-sort-down"></i> ' . $yt;
	
	
	
	
	
	///////////////OPTION WORKING IN DISPLAY SOLD BEATS
	if ($option_checker['displaysoldcatalog'] == 0 && $sold == 'yes') {
		
	} else {

	
	if ($bp_fluid == '' or $bp_fluid == 'compact') {
		echo '<div class="beatholder bh_compact bp_ca" xNd="' . $nameO . '" xId="' . $encrypted . '">';
	} elseif ($bp_fluid == 'fluid') {
		echo '<div class="beatholder bh_fluid bp_ca" xNd="' . $nameO . '" xId="' . $encrypted . '">';
	} elseif ($bp_fluid == 'fluid-xtrasmall') {
		echo '<div class="beatholder bh_fluid bh_xtrasmall bp_ca" xNd="' . $nameO . '" xId="' . $encrypted . '">';
	}
	
	
	
	
	
	
	echo '<span class="imgcont"><span title="' . __('Now listening:', 'beatpress') . ' ' . $nameO . '" class="ppplistening"><i class="fas fa-circle-notch fa-spin"></i></span>' . $image . '</span> <span class="titleholder"><span class="bp_titledot">&nbsp;&nbsp;<i class="fas fa-play bh_playhelp"></i>&nbsp;&nbsp;<strong>' . $nameO . '</strong>';
		
	if (($bpcol != '') || ($bphoo == 'yes')) {
		echo '<br><span class="bpextradetails">';
		
		if ($bpcol != '') {
			echo '<span class="bpcollabbox"><i class="fas fa-user-friends"></i> Ft. ' . $bpcol . ' </span>';
		}
		
		if ($bphoo == 'yes') {
			echo '<span class="bphookbox">(With Hook)</span>';
		}
		
		echo '</span>';
		
	}
	
	echo '</span></span>';
	
	
	
	
	
	
	
	
    echo '<span class="beat-category">';
	if ($option_checker['typebeatcatalog'] == 1) {
		echo '<span title="' . sprintf( __('%s Type Beat', 'beatpress' ), $slike ) . '" class="cattb"><strong><i class="fas fa-user-circle"></i> ' . $slike . '</strong></span>';
	}
	
	if ($option_checker['beatcategorycatalog'] == 1) {
		$genres = get_the_terms( $post->ID, 'genre' );
		if (!$genres[0]->name == '') {
			echo '<span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[0]->name ) . '" class="cat"><strong><i class="fab fa-slack-hash"></i> ' . $genres[0]->name . '</strong></span>';
		}
		if (!$genres[1]->name == '') {
			echo '<span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[1]->name ) . '" class="cat"><strong><i class="fab fa-slack-hash"></i> ' . $genres[1]->name . '</strong></span>';
		}
		if (!$genres[2]->name == '') {
			echo '<span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[2]->name ) . '" class="cat"><strong><i class="fab fa-slack-hash"></i> ' . $genres[2]->name . '</strong></span>';
		}
		if (!$genres[3]->name == '') {
			echo '<span title="' . sprintf( __('%s Beats & Instrumentals', 'beatpress' ), $genres[3]->name ) . '" class="cat"><strong><i class="fab fa-slack-hash"></i> ' . $genres[3]->name . '</strong></span>';
		}
		
	}
	
	
	//$genres = get_terms( array('taxonomy' => 'genre', 'hide_empty' => false) );

    echo '</span>'; // Markup closing tags.
	
    echo '<span class="bp_addbuttons">';
	

		
	/* SHARE STILL NOT AVAILABLE
	echo '<a class="sicons pppshare iBk" href=""><i class="fas fa-share-alt"></i></a>';
	*/
	
	//echo $bp_interlinking;
	
	


	
	
	if ($sold == 'yes'){
		
		if ($bp_interlinking == '1'){
		} else {
			echo '<a href="' . get_post_permalink() . '" class="sicons pldownload iBk" title="' . sprintf( __('View %s Instrumental Page', 'beatpress' ), $nameO ) . '"><i class="fas fa-link"></i></a>';
		}
		
		
	} else {
		
		if ($bp_sellingMode == 'external'){
			
			
			
			if ($bp_interlinking == '1'){
			} else {
				echo '<a href="' . get_post_permalink() . '" class="sicons pldownload iBk" title="' . sprintf( __('Download %s Instrumental', 'beatpress' ), $nameO ) . '"><i class="fas fa-download"></i></a>';
			}

			
			
		} else {
			
			if ($bp_interlinking == '1'){
			} else {
				echo '<a href="' . get_post_permalink() . '" class="sicons pldownload iBk" title="' . sprintf( __('Download %s Instrumental', 'beatpress' ), $nameO ) . '"><i class="fas fa-download"></i></a>';
			}


		}
		
	}
	
	
	if ($sold == 'yes'){
		
		if ($bp_sellingMode == 'external'){

		} else {
			if ($bp_buttonsize == 1){
				echo '<a class="bp_box_color purchaselink_sold bp_mid_buy iBk" title="' . sprintf( __('%s was exclusively sold and is no longer available', 'beatpress' ), $nameO ) . '" ><span class="icon_cont"><i class="fas fa-ban"></i></span></a>';
			} else {
				echo '<a class="bp_box_color purchaselink_sold bp_big_buy iBk" title="' . sprintf( __('%s was exclusively sold and is no longer available', 'beatpress' ), $nameO ) . '" ><span class="icon_cont"><i class="fas fa-ban"></i></span> <span class="text_cont">' . __('SOLD', 'beatpress') . '</span></a>';
			}			
		}
		
	} else {
	
		if ($bp_sellingMode == 'external'){

		} else {
		
			if ($bp_buttonsize == 1){
				echo '<a class="bp_box_color purchaselink bp_mid_buy iBk" title="' . sprintf( __('%s Purchase Options', 'beatpress' ), $nameO ) . '" data-bpid="' . $eddnum . '" active="0"><span class="icon_cont"><i class="fas fa-cart-plus"></i></span></a>';
			} else {
				echo '<a class="bp_box_color purchaselink bp_big_buy iBk" title="' . sprintf( __('%s Purchase Options', 'beatpress' ), $nameO ) . '" data-bpid="' . $eddnum . '" active="0"><span class="icon_cont"><i class="fas fa-cart-plus"></i></span> <span class="text_cont">' . __('ADD', 'beatpress') . '</span></a>';
			}
		}
		
	}
	

	
	
	
	echo '<a class="bp_box_color bp_pppseparator bp_butsep_buy" data-bpid="' . $eddnum . '" active="0"><span class="icon_cont"></span></a>';

	
	
	
	
	
	
    echo '</span>'; // Markup closing tags.
	
	echo '</div>';
	
	
	
	
	if ($sold == 'yes'){
		echo '<div class="bnbuttons bppadder">';
		
		if ($option_checker['seointrocatalog'] == '1'){
			echo '<div class="bp-beat-desc">';
			echo '<span class="title_desc_catalog"><i class="fas fa-bookmark"></i> ' . $name . '</span>';
			if ($option_checker['producerlogo'] == '') {
				echo '<span class="ftprodby"><img width="22" height="22" alt="" title="' . __('Produced by', 'beatpress') . ' ' . $option_checker['producername'] . '" src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog_170.jpg" id="producer_logo" /> ' . $option_checker['producername'] . '</span>';
			} else {
				echo '<span class="ftprodby"><img width="22" height="22" alt="" title="' . __('Produced by', 'beatpress') . ' ' . $option_checker['producername'] . '" src="' . $option_checker['producerlogo'] . '" id="producer_logo" /> ' . $option_checker['producername'] . '</span>';
			}
			if ($option_checker['featuredtextrow'] == '') {			
				echo '<span class="ftdesc"><i class="fas fa-align-left"></i> ' . $intro . '</span>';
			}
			echo '</div><hr>';			
		}
		
		echo '<div class="soldbeats"><span class="psoldholder"><i id="soldp" class="fas fa-times-circle"></i> ' . sprintf( __('%s was exclusively sold and is no longer available', 'beatpress' ), $nameO ) . '</span><br>';
		echo '<span><i class="fas fa-info-circle"></i> ' . __('This beat is no longer available for any kind of licensing or purchase', 'beatpress') . '.</span></div>';
		echo '</div>';
	} else {
		
		
		
		
		
		
		
		
				
		//PURCHASE MODE BEATPRESS DIRECT
		if ($bp_sellingMode == 'direct' || $bp_sellingMode == ''){
			
				if (!$option_checker['enablemodalbox'] == '1') {
				echo '<div class="bnbuttons bppadder">';
		} else {
			echo '<div class="bnbuttons bpmodal"><span class="bpmodal-body"><span class="bpmodalwidget"><span id="bottomplayer" xNd="' . $nameO . '" xId="' . $encrypted . '" class="modcloser pwidget"><span class="fa-stack fa-2x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-play fa-stack-1x fa-inverse"></i></span></span> <span class="modcloser"></span> <span class="nocloser cwidget"><span class="fa-stack fa-2x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-times fa-stack-1x fa-inverse"></i></span></span></span><span class="bpmodal-content">';
		}
		
		
		echo '<span class="bp-beat-desc">';
		echo '<span class="title_desc_catalog">' . $innerimage . ' ' . $name . '</span>';
			
		if ($option_checker['producerlogo'] == '') {
			echo '<span class="ftprodby"><img width="22" height="22" alt="" title="' . __('Produced by', 'beatpress') . ' ' . $option_checker['producername'] . '" src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog_170.jpg" id="producer_logo" /> ' . $option_checker['producername'] . '</span>';
		} else {
			echo '<span class="ftprodby"><img width="22" height="22" alt="" title="' . __('Produced by', 'beatpress') . ' ' . $option_checker['producername'] . '" src="' . $option_checker['producerlogo'] . '" id="producer_logo" /> ' . $option_checker['producername'] . '</span>';
			}
		echo '</span>';			

			
			if ($bp_direct_encrypt == 1){
				echo '<div class="bp_flexcont">';
				echo '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=' . $bp_licname1 . '&purchase=' . $lic_mp3 * 170486, e) . '" target="_blank"><span class="lictype">' . $bp_licname1 . '</span><span id="mp3t" class="price">$' . $lic_mp3 . '</span><span class="lictype2">' . $bp_shead1 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				echo '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=' . $bp_licname2 . '&purchase=' . $lic_wav * 170486, e) . '" target="_blank"><span class="lictype">' . $bp_licname2 . '</span><span id="mp3t" class="price">$' . $lic_wav . '</span><span class="lictype2">' . $bp_shead2 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				echo '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=' . $bp_licname3 . '&purchase=' . $lic_premium * 170486, e) . '" target="_blank"><span class="lictype">' . $bp_licname3 . '</span><span id="mp3t" class="price">$' . $lic_premium . '</span><span class="lictype2">' . $bp_shead3 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				echo '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=' . $bp_licname4 . '&purchase=' . $lic_unlimited * 170486, e) . '" target="_blank"><span class="lictype">' . $bp_licname4 . '</span><span id="mp3t" class="price">$' . $lic_unlimited . '</span><span class="lictype2">' . $bp_shead4 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';

		
				if ($showEx == 1) {
			
					if ($makeOffer == "1") {
						echo '<a class="purchbox" target="_blank" href="/contact"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">~</span><span class="lictype2">' . __('Make an Offer', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-pencil-alt"></i></span></a>';
					} else {
						echo '<a class="purchbox" target="_blank" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=Exclusive%20Rights&purchase=' . $exclusive * 170486, e ) . '"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">$' . $exclusive . '</span><span class="lictype2">' . sprintf( __('%s Is Yours', 'beatpress' ), $name ) . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
					}
				}
				echo '</div>';

				
			} else {
				echo '<div class="bp_flexcont">';
				echo '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=' . $bp_licname1 . '&purchase=' . $lic_mp3 * 170486 . '" target="_blank"><span class="lictype">' . $bp_licname1 . '</span><span id="mp3t" class="price">$' . $lic_mp3 . '</span><span class="lictype2">' . $bp_shead1 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				echo '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=' . $bp_licname2 . '&purchase=' . $lic_wav * 170486 . '" target="_blank"><span class="lictype">' . $bp_licname2 . '</span><span id="mp3t" class="price">$' . $lic_wav . '</span><span class="lictype2">' . $bp_shead2 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				echo '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=' . $bp_licname3 . '&purchase=' . $lic_premium * 170486 . '" target="_blank"><span class="lictype">' . $bp_licname3 . '</span><span id="mp3t" class="price">$' . $lic_premium . '</span><span class="lictype2">' . $bp_shead3 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				echo '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=' . $bp_licname4 . '&purchase=' . $lic_unlimited * 170486 . '" target="_blank"><span class="lictype">' . $bp_licname4 . '</span><span id="mp3t" class="price">$' . $lic_unlimited . '</span><span class="lictype2">' . $bp_shead4 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';

		
				if ($showEx == 1) {
			
					if ($makeOffer == "1") {
						echo '<a class="purchbox" target="_blank" href="/contact"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">~</span><span class="lictype2">' . __('Make an Offer', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-pencil-alt"></i></span></a>';
					} else {
						echo '<a class="purchbox" target="_blank" href="/?beatpress_direct=true&beat=' . $name . '&license=Exclusive%20Rights&purchase=' . $exclusive * 170486 . '"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">$' . $exclusive . '</span><span class="lictype2">' . sprintf( __('%s Is Yours', 'beatpress' ), $name ) . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
					}
				}
				
				echo '</div>';

				
			}
			
					if ($option_checker['seointrocatalog'] == '1'){
			echo '<span class="bp-beat-desc">';
			echo '<span class="catalogftdesc"><strong><i class="fas fa-align-left"></i> ' . __('Beat Description', 'beatpress') . '</strong>: ' . $intro . '</span>';
			echo '</span>';			
		}

			
				if (!$option_checker['enablemodalbox'] == '1') {
			echo '</div>';
		} else {
			echo '</span></span></div>';
		}
			
			

		}
		
		
		
		
		
		
		
		

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		//PURCHASE MODE EDD
		if ($bp_sellingMode == 'edd'){

		

		$eddnonce = wp_create_nonce( 'edd-add-to-cart-' . $eddnum);
		
		if (!$option_checker['enablemodalbox'] == '1') {
			echo '<div class="bnbuttons bppadder">';
		} else {
			echo '<div class="bnbuttons bpmodal"><span class="bpmodal-body"><span class="bpmodalwidget"><span id="bottomplayer" xNd="' . $nameO . '" xId="' . $encrypted . '" class="modcloser pwidget"><span class="fa-stack fa-2x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-play fa-stack-1x fa-inverse"></i></span></span> <span class="modcloser"></span> <span class="nocloser cwidget"><span class="fa-stack fa-2x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-times fa-stack-1x fa-inverse"></i></span></span></span><span class="bpmodal-content">';
		}
		
		
		echo '<span class="bp-beat-desc">';
		echo '<span class="title_desc_catalog">' . $innerimage . ' ' . $name . '</span>';
			
		if ($option_checker['producerlogo'] == '') {
			echo '<span class="ftprodby"><img width="22" height="22" alt="" title="' . __('Produced by', 'beatpress') . ' ' . $option_checker['producername'] . '" src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog_170.jpg" id="producer_logo" /> ' . $option_checker['producername'] . '</span>';
		} else {
			echo '<span class="ftprodby"><img width="22" height="22" alt="" title="' . __('Produced by', 'beatpress') . ' ' . $option_checker['producername'] . '" src="' . $option_checker['producerlogo'] . '" id="producer_logo" /> ' . $option_checker['producername'] . '</span>';
			}
		echo '</span>';			

		echo '<div class="bp_flexcont">'; //START FLEXBOX
		
		echo '<form id="edd_purchase_' . $eddnum . '-1" class="edd_download_purchase_form edd_purchase_' . $eddnum . ' purchbox" method="post"><span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer"><meta itemprop="price" content="' . $lic_mp3 . '"><meta itemprop="priceCurrency" content="USD"></span><a href="" class="edd-add-to-cart" data-nonce="' .  $eddnonce . '" data-action="edd_add_to_cart" data-download-id="' . $eddnum . '" data-variable-price="yes" data-price-mode="multi" data-price="' . $lic_mp3 . '"><span class="lictype">' . $bp_licname1 . '</span><span id="mp3t" class="price">$' . $lic_mp3 . '</span><span class="lictype2">' . $bp_shead1 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span><span class="edd-add-to-cart-label"></span><span id="loadbig" class="edd-loading loadbig" aria-label="Loading"></span></a><input type="hidden" name="download_id" value="' . $eddnum . '"><input type="hidden" name="edd_options[price_id][]" id="edd_price_option_' . $eddnum . '_1" class="edd_price_option_' . $eddnum . '" value="1"><input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart"><span id="' . $eddnum . '-1" class="edd-cart-ajax-alert" aria-live="assertive"><span class="edd-cart-added-alert" style="display: none; color:white; top:5px; margin-left:-10px;"><p><i class="fas fa-check-circle"></i></p></span></span></form>';
	
		echo '<form id="edd_purchase_' . $eddnum . '-2" class="edd_download_purchase_form edd_purchase_' . $eddnum . ' purchbox" method="post"><span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer"><meta itemprop="price" content="' . $lic_wav . '"><meta itemprop="priceCurrency" content="USD"></span><a href="" class="edd-add-to-cart" data-nonce="' .  $eddnonce . '" data-action="edd_add_to_cart" data-download-id="' . $eddnum . '" data-variable-price="yes" data-price-mode="multi" data-price="' . $lic_wav . '"><span class="lictype">' . $bp_licname2 . '</span><span id="wavt" class="price">$' . $lic_wav . '</span><span class="lictype2">' . $bp_shead2 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span><span class="edd-add-to-cart-label"></span><span class="edd-loading loadbig" aria-label="Loading"></span></a><input type="hidden" name="download_id" value="' . $eddnum . '"><input type="hidden" name="edd_options[price_id][]" id="edd_price_option_' . $eddnum . '_2" class="edd_price_option_' . $eddnum . '" value="2"><input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart"><span id="' . $eddnum . '-2" class="edd-cart-ajax-alert" aria-live="assertive"><span class="edd-cart-added-alert" style="display: none; color:white; top:5px; margin-left:-10px;"><p><i class="fas fa-check-circle"></i></p></span></span></form>';
	
		echo '<form id="edd_purchase_' . $eddnum . '-3" class="edd_download_purchase_form edd_purchase_' . $eddnum . ' purchbox" method="post"><span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer"><meta itemprop="price" content="' . $lic_premium . '"><meta itemprop="priceCurrency" content="USD"></span><a href="" class="edd-add-to-cart" data-nonce="' .  $eddnonce . '" data-action="edd_add_to_cart" data-download-id="' . $eddnum . '" data-variable-price="yes" data-price-mode="multi" data-price="' . $lic_premium . '"><span class="lictype">' . $bp_licname3 . '</span><span id="premiumt" class="price">$' . $lic_premium . '</span><span class="lictype2">' . $bp_shead3 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span><span class="edd-add-to-cart-label"></span><span class="edd-loading loadbig" aria-label="Loading"></span></a><input type="hidden" name="download_id" value="' . $eddnum . '"><input type="hidden" name="edd_options[price_id][]" id="edd_price_option_' . $eddnum . '_3" class="edd_price_option_' . $eddnum . '" value="3"><input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart"><span id="' . $eddnum . '-3" class="edd-cart-ajax-alert" aria-live="assertive"><span class="edd-cart-added-alert" style="display: none; color:white; top:5px; margin-left:-10px;"><p><i class="fas fa-check-circle"></i></p></span></span></form>';
	
		echo '<form id="edd_purchase_' . $eddnum . '-4" class="edd_download_purchase_form edd_purchase_' . $eddnum . ' purchbox" method="post"><span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer"><meta itemprop="price" content="' . $lic_unlimited . '"><meta itemprop="priceCurrency" content="USD"></span><a href="" class="edd-add-to-cart" data-nonce="' .  $eddnonce . '" data-action="edd_add_to_cart" data-download-id="' . $eddnum . '" data-variable-price="yes" data-price-mode="multi" data-price="' . $lic_unlimited . '"><span class="lictype">' . $bp_licname4 . '</span><span id="unlimitedt" class="price">$' . $lic_unlimited . '</span><span class="lictype2">' . $bp_shead4 . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span><span class="edd-add-to-cart-label"></span><span class="edd-loading loadbig" aria-label="Loading"></span></a><input type="hidden" name="download_id" value="' . $eddnum . '"><input type="hidden" name="edd_options[price_id][]" id="edd_price_option_' . $eddnum . '_4" class="edd_price_option_' . $eddnum . '" value="4"><input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart"><span id="' . $eddnum . '-4" class="edd-cart-ajax-alert" aria-live="assertive"><span class="edd-cart-added-alert" style="display: none; color:white; top:5px; margin-left:-10px;"><p><i class="fas fa-check-circle"></i></p></span></span></form>';
		
		if ($option_checker['showexclusivecatalog'] == 1) {
			
			if ($option_checker['offercatalog'] == '1') {
				echo '<a class="purchbox" target="_blank" href="/contact"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="ex_lictype" class="price">~</span><span class="lictype2">' . __('Make an Offer', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-pencil-alt"></i></span></a>';
			} else {
				
				if ($bp_direct_encrypt == 1){		
					echo '<a class="purchbox" href="/?beatpress_direct=true&bpsid=' . my_simple_crypt( 'beat=' . $name . '&license=Exclusive%20Rights&purchase=' . $exclusive * 170486, e) . '" target="_blank"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="mp3t" class="price">$' . $exclusive . '</span><span class="lictype2">' . sprintf( __('%s Is Yours', 'beatpress' ), $name ) . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				} else {
					echo '<a class="purchbox" href="/?beatpress_direct=true&beat=' . $name . '&license=Exclusive%20Rights&purchase=' . $exclusive * 170486 . '" target="_blank"><span class="lictype">' . __('Exclusive Rights', 'beatpress') . '</span><span id="mp3t" class="price">$' . $exclusive . '</span><span class="lictype2">' . sprintf( __('%s Is Yours', 'beatpress' ), $name ) . '</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
				}


			}

			//echo '<a class="purchbox_exclusive" target="_blank" href="/beatpress/?bp=2&beatname=' . $name . '&lic=exclusive&expr=' . $exclusive * 170486 . '"><span class="lictype">Exclusive Rights</span><span id="ex_lictype" class="price">$' . $exclusive . '</span><span class="lictype2">' . $name . ' is yours</span><span class="fontaw_cont"><i class="fas fa-plus"></i></span></a>';
		}
		
		echo '</div>'; //END FLEXBOX
		

		if ($option_checker['seointrocatalog'] == '1'){
			echo '<span class="bp-beat-desc">';
			echo '<span class="catalogftdesc"><strong><i class="fas fa-align-left"></i> ' . __('Beat Description', 'beatpress') . '</strong>: ' . $intro . '</span>';
			echo '</span>';			
		}
		
		if (!$option_checker['enablemodalbox'] == '1') {
			echo '</div>';
		} else {
			echo '</span></span></div>';
		}
		
		//END PURCHASE
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
			//PURCHASE MODE EXTERNAL
		if ($bp_sellingMode == 'external'){
			
		if (!$option_checker['enablemodalbox'] == '1') {
			echo '<div class="bnbuttons bppadder">';
		} else {
			echo '<div class="bnbuttons bpmodal"><span class="bpmodal-body"><span class="bpmodalwidget"><span id="bottomplayer" xNd="' . $nameO . '" xId="' . $encrypted . '" class="modcloser pwidget"><span class="fa-stack fa-2x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-play fa-stack-1x fa-inverse"></i></span></span> <span class="modcloser"></span> <span class="nocloser cwidget"><span class="fa-stack fa-2x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-times fa-stack-1x fa-inverse"></i></span></span></span><span class="bpmodal-content">';
		}
		
		
		echo '<span class="bp-beat-desc">';
		echo '<span class="title_desc_catalog">' . $innerimage . ' ' . $name . '</span>';
			
		if ($option_checker['producerlogo'] == '') {
			echo '<span class="ftprodby"><img width="22" height="22" alt="" title="' . __('Produced by', 'beatpress') . ' ' . $option_checker['producername'] . '" src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog_170.jpg" id="producer_logo" /> ' . $option_checker['producername'] . '</span>';
		} else {
			echo '<span class="ftprodby"><img width="22" height="22" alt="" title="' . __('Produced by', 'beatpress') . ' ' . $option_checker['producername'] . '" src="' . $option_checker['producerlogo'] . '" id="producer_logo" /> ' . $option_checker['producername'] . '</span>';
			}
		echo '</span>';			

			

			echo '<a href="' . get_post_permalink() . '">';
			echo '<span class="purchbox_external"><span class="lictype">' . __('Click here to download', 'beatpress') . '</span><span id="mp3t" class="price">' . $name . '</span><span class="lictype2">' . __('Multiple Options', 'beatpress') . '</span><span class="fontaw_cont"><i class="fas fa-file-download"></i></span></span>';
			echo '</a>';

						
			echo '<br>';
			
				
		if ($option_checker['seointrocatalog'] == '1'){
			echo '<span class="bp-beat-desc">';
			echo '<span class="catalogftdesc"><strong><i class="fas fa-align-left"></i> ' . __('Beat Description', 'beatpress') . '</strong>: ' . $intro . '</span>';
			echo '</span>';			
		}
		
		if (!$option_checker['enablemodalbox'] == '1') {
			echo '</div>';
		} else {
			echo '</span></span></div>';
		}
		}
	
	

		
	
	
	
	
	}

	}
	
	
	

}




/*
//ALLOW SHORTCODES ON WP CATEGORIES
add_filter( 'term_description', 'do_shortcode' );
add_filter( 'category_description', 'do_shortcode' );
add_filter( 'post_tag_description', 'do_shortcode' );
*/

//Display Inital Posts
function script_load_more($args = array()) {
    //initial posts load
    echo '<div id="ajax-primary" class="content-area">';
        echo '<div id="ajax-content" class="content-area">';
            ajax_script_load_more($args);
        echo '</div>';
    echo '</div>';
}

add_shortcode('beats_load', 'script_load_more');

//Load More Callback
function ajax_script_load_more($args) {
GLOBAL $option_checker;


    //init ajax
    $ajax = false;
    //check ajax call or not
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $ajax = true;
    }
    //number of posts per page default
	
	if ($option_checker['defaultbeatscatalog'] == ''){
		$num = 15;
	} else {
		$num = $option_checker['defaultbeatscatalog'];
		//$num = 150;
	}
	

    
    //page number
    $paged = $_POST['page'] + 1;
    //args
    $args = array(
        'post_type' => 'instrumentals',
        'post_status' => 'publish',
        'posts_per_page' =>$num,
        'paged'=>$paged
    );
    //query
    $query = new WP_Query($args);
    //check
    if ($query->have_posts()):
        //loop articales
        while ($query->have_posts()): $query->the_post();
            //include articles template

			catalog_formatter();

            //include 'ajax-content.php';
        endwhile;
    else:
        echo 0;
    endif;
    //reset post data
    wp_reset_postdata();
    //check ajax call
    if($ajax) die();
}
add_action('wp_ajax_nopriv_ajax_script_load_more', 'ajax_script_load_more');
add_action('wp_ajax_ajax_script_load_more', 'ajax_script_load_more');



















//Display Inital On Genres
function script_load_more_genre($args = array()) {
    //initial posts load
    echo '<div id="ajax-primary" class="content-area">';
        echo '<div id="ajax-content" class="content-area">';
            ajax_script_load_more_genre($args);
        echo '</div>';
    echo '</div>';
}

add_shortcode('beats_load_genre', 'script_load_more_genre');

//Load More Callback on Genres
function ajax_script_load_more_genre($args) {
GLOBAL $option_checker;

$catalogUrl = $option_checker['catalogurl'];

    //init ajax
    $ajax = false;
    //check ajax call or not
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $ajax = true;
    }
    //number of posts per page default
	
	if ($option_checker['defaultbeatscatalog'] == ''){
		$num = 15;
	} else {
		$num = $option_checker['defaultbeatscatalog'];
		//$num = 150;
	}
	
	jPlayerInit();
	
	if ($option_checker['catalogbanner'] == '') {
	} else {
		if ($option_checker['bannertitle_override'] == '') {
			echo '<img width="100%" src="' . $option_checker['catalogbanner'] . '" /><span class="bpsep"></span>';
		} else {
			echo '<img width="100%" alt="' . $option_checker['bannertitle_override'] . '" title="' . $option_checker['bannertitle_override'] . '" src="' . $option_checker['catalogbanner'] . '" /><span class="bpsep"></span>';
		}
	}
	
	if ($option_checker['searchbox_top'] == 1) {
		echo '<form class="beatsearch" action="/">
		<input type="search" name="s" placeholder="' . __('Search beat name, artist, genre, tags...', 'beatpress') . '" >
		<button name="post_type" value="instrumentals" type="hidden"><i class="fas fa-search searchicon"></i></button>
		</form><span class="bpsep"></span>';
	}
	

	
	$generoID = get_queried_object()->term_id;
	$generoSLUG = get_queried_object()->slug;
	$generoNAME = get_queried_object()->name;
	//echo $generoID . ' ' . $generoSLUG;

    
    //page number
    $paged = $_POST['page'] + 1;
    //args
    $args = array(
        'post_type' => 'instrumentals',
        'post_status' => 'publish',
        'posts_per_page' =>$num,
        'paged'=>$paged,
		'genre'=>$generoSLUG
    );
    //query
    $query = new WP_Query($args);
    //check
    if ($query->have_posts()):
        //loop articales
		
		
		
        while ($query->have_posts()): $query->the_post();
			catalog_formatter();
			
            //include 'ajax-content.php';
        endwhile;
		echo '<span class="bpsep"></span>';
		echo '<span class="loadholder" id="bpLoadStatic"><a href="' . get_permalink( $catalogUrl ) . '" id="loadt" class="loadmoreBtn"><i class="fas fa-caret-down"></i> ' . __('Listen More Beats', 'beatpress') . ' <i class="fas fa-caret-down"></i></a></span>';	
	
    else:
        echo 0;
    endif;
    //reset post data
    wp_reset_postdata();
    //check ajax call
	
	
	
	
	
	
	
	
	
	//Genres List Bottom
	if ($option_checker['browsebeatsgenre'] == 1) {
		echo '<br><div class="bp_dump_genrelist">';
		$terms = get_terms('genre');
		if ( !empty( $terms ) && !is_wp_error( $terms ) ){
			foreach ( $terms as $term ) {
				if ($option_checker['showonlygenres'] == 1){
					if ($term->count >= 5){
						echo '<a title="' . $option_checker['titlefirst'] . ' ' . $term->name . ' ' . $option_checker['titlelast'] . ' (' . $term->count . ' Beats)" href="' . get_term_link($term->term_id) . '" class="cattb_bpgenres"><i class="fab fa-slack-hash"></i> ' . $term->name . ' (' . $term->count . ')</a>';
					}
				} else {
					echo '<a title="' . $option_checker['titlefirst'] . ' ' . $term->name . ' ' . $option_checker['titlelast'] . ' (' . $term->count . ' Beats)" href="' . get_term_link($term->term_id) . '" class="cattb_bpgenres"><i class="fab fa-slack-hash"></i> ' . $term->name . ' (' . $term->count . ')</a>';
				}
			}
		}
		echo '<br></div>';
	}

	
	
	
	//Social Networks
	if ($option_checker['catalogsnetworks'] == 1) {
			
		echo '<br><span class="bp_socials">';
			
		if ($option_checker['twitterlink'] == '') {
		} else {
			echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['twitterlink'] . '" title="' . sprintf( __('Follow %s on Twitter', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fa-twitter fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
		}
		
		if ($option_checker['facebooklink'] == '') {
		} else {
			echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['facebooklink'] . '" title="' . sprintf( __('Follow %s on Facebook', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fa-facebook-f fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
		}
						
		if ($option_checker['soundcloudlink'] == '') {
		} else {
			echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['soundcloudlink'] . '" title="' . sprintf( __('Follow %s on SoundCloud', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fa-soundcloud fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
		}
									
		if ($option_checker['instagramlink'] == '') {
		} else {
			echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['instagramlink'] . '" title="' . sprintf( __('Follow %s on Instagram', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fa-instagram fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
		}
												
		if ($option_checker['youtubelink'] == '') {
		} else {
			echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['youtubelink'] . '" title="' . sprintf( __('Follow %s on YouTube', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fa-youtube fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
		}
			
		if ($option_checker['redditlink'] == '') {
		} else {
			echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['redditlink'] . '" title="' . sprintf( __('Follow %s on Reddit', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fa-reddit-alien fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
		}
			
		if ($option_checker['bstalink'] == '') {
		} else {
			echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['bstalink'] . '" title="' . sprintf( __('Follow %s on BeatStars', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fab fa-bootstrap fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
		}
						
		if ($option_checker['airbilink'] == '') {
		} else {
			echo '<a class="bp_socials_button" rel="nofollow" target="_blank" href="' . $option_checker['airbilink'] . '" title="' . sprintf( __('Follow %s on Airbit', 'beatpress' ), $option_checker['producername'] ) . '"><span class="fa-stack fa-1x"><i class="fas fa-circle fa-stack-2x"></i><i class="fab fab fa-autoprefixer fa-stack-1x fa-inverse bp_socials_inner"></i></span></a>';
		}
			
		echo '</span>';
			
	}	
	
	echo '<br><h2>' . $option_checker['titlefirst'] . ' ' . $generoNAME . ' ' . $option_checker['titlelast'] . '</h2>';

	
	
	
    if($ajax) die();
	
}
add_action('wp_ajax_nopriv_ajax_script_load_more', 'ajax_script_load_more_genre');
add_action('wp_ajax_ajax_script_load_more', 'ajax_script_load_more_genre');



















