<?php
/**
 * BeatPress Admin Toolbox
 * Small toolbox to help admins to easily share content
 *
 * @/inc/toolbox.php
 * @package BeatPress
 */

// Security Layer
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access to BeatPress Script denied.' );
}

//CUSTOM POST TYPE INSTRUMENTALS ADDITIONAL BOX
function add_custom_meta_box()
{
    add_meta_box('demo-meta-box', '' . __('BeatPress Tools', 'beatpress') . '', 'custom_meta_box_markup', is_single(), 'side', 'high', null);
}
add_action("add_meta_boxes", "add_custom_meta_box");

function custom_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
    ?>
        <div>
            <?php
				$rnder1 = rand(10000, 99999);
                $checkbox_value = get_post_meta($object->ID, "meta-box-checkbox", true);
				echo '<div style="font-size:x-small;">';
				echo '<a target="_blank" href="https://www.google.com/search?q=info:' . get_permalink(get_post()) . '">' . __('Fetch Preview', 'beatpress') . '</a> > ' . __('Check Google Preview', 'beatpress') . '<br>';
				echo '<a target="_blank" href="https://www.google.com/search?q=site:' . get_permalink(get_post()) . '">' . __('Search Result', 'beatpress') . '</a> > ' . __('Check Indexation', 'beatpress') . '<br>';
				echo '<a target="_blank" href="https://developers.google.com/speed/pagespeed/insights/?url=' . get_permalink(get_post()) . '">' . __('PageSpeed Insights', 'beatpress') . '</a> > ' . __('Post Speed', 'beatpress') . '<br>';
				echo '<a target="_blank" href="https://www.totalping.com/?name=' . get_the_title(get_post()) . '&url=' . get_permalink(get_post()) . '&rss=' . get_permalink(get_post()) . 'feed/">' . __('TotalPing', 'beatpress') . '</a> > ' . __('Ping Tool', 'beatpress') . '<br>';
				echo '<a target="_blank" href="http://pingomatic.com/ping/?title=' . get_the_title(get_post()) . '&blogurl=' . get_permalink(get_post()) . '&rssurl=' . get_permalink(get_post()) . 'feed/&chk_weblogscom=on&chk_blogs=on&chk_feedburner=on&chk_newsgator=on&chk_myyahoo=on&chk_pubsubcom=on&chk_blogdigger=on&chk_weblogalot=on&chk_newsisfree=on&chk_topicexchange=on&chk_google=on&chk_tailrank=on&chk_skygrid=on&chk_collecta=on&chk_superfeedr=on">' . __('PingoMatic', 'beatpress') . '</a> > ' . __('Ping Tool', 'beatpress') . '<br>';
				echo '<a target="_blank" href="https://www.copyscape.com/?q=' . get_permalink(get_post()) . '">' . __('CopyScape', 'beatpress') . '</a> > ' . __('Check Plagiarism', 'beatpress') . '<br>';
				echo '<a target="_blank" href="https://www.seoptimer.com/' . get_permalink(get_post()) . '">' . __('SEOptimer', 'beatpress') . '</a> > ' . __('Domain SEO Audit', 'beatpress') . '<br>';
				echo '<a target="_blank" href="https://image.thum.io/get/width/1200/crop/1200/' . get_permalink(get_post()) . '?' . $rnder1 . '">' . __('Thum.io', 'beatpress') . '</a> > ' . __('Get Screenshot', 'beatpress') . '';
				echo '<hr><p style="font-size:xx-small">' . __('*Use these previous tools only when you post new content', 'beatpress') . '.</p>';
				echo '<p><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=' . get_permalink(get_post()) . '"><img src="/wp-content/plugins/beatpress/imgs/sharing/facebook.png"></a> <a target="_blank" href="https://twitter.com/home?status=' . get_the_title(get_post()) . ' > ' . get_permalink(get_post()) . '"><img src="/wp-content/plugins/beatpress/imgs/sharing/twitter.png"></a> <a target="_blank" href="http://www.reddit.com/submit?title=' . get_the_title(get_post()) . '&url=' . get_permalink(get_post()) . '"><img src="/wp-content/plugins/beatpress/imgs/sharing/reddit.png"></a> <a target="_blank" href="https://pinterest.com/pin/create/button/?url=' . get_permalink(get_post()) . '&media=' . get_the_post_thumbnail_url(get_post()) . '&description=' . get_the_title(get_post()) . '"><img src="/wp-content/plugins/beatpress/imgs/sharing/pinterest.png"></a></p>';
				echo '</div>';
			?>
        </div>
    <?php  
}