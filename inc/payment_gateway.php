<?php
/**
 * BeatPress Payment Gateway
 * Payment Gateway made for BeatPress Direct Purchases
 *
 * @/inc/payment_gateway.php
 * @package BeatPress
 */

// Security Layer
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access to BeatPress Script denied.' );
}

//BEATPRESS PAYMENT GATE
function beatpress_direct() { 
GLOBAL $option_checker;

$encryptionEnabled = $option_checker['bpdirectencryptsession'];
$paypal_image = $option_checker['custompplogo'];
$paypal = $option_checker['paypalemail']; //Your PayPal Email
$currency = 'USD'; //Currency Code

//Special Characters
$beatpress_direct = htmlspecialchars($_GET["beatpress_direct"]);
$bpsid = htmlspecialchars($_GET["bpsid"]);
$sURL = $_SERVER['REQUEST_URI'];
$sSITE = $_SERVER['SERVER_NAME'];



if ($beatpress_direct == 'true') {
	
	if ($paypal == ''){
		
		echo '<!DOCTYPE html>';
	
		echo '<html>';
	
		echo '<head>';
		echo '<link rel="shortcut icon" href="/wp-content/plugins/beatpress/imgs/system/requests_logo.png" type="image/x-icon">';
		echo '<link rel="icon" href="/wp-content/plugins/beatpress/imgs/system/requests_logo.png" type="image/x-icon">';

		echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">';
		echo '<title>' . __('BeatPress Direct ERROR', 'beatpress') . '</title>';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		echo '<meta name="robots" content="noindex, nofollow">';
		echo '</head>';
		
		
		echo '<body>';
		echo '<div style="position: fixed; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%); font-family: Arial, Helvetica, sans-serif;">';
		echo '<p style="text-align:center;"><i class="fas fa-exclamation-circle"></i> <strong>' . __('ERROR: Missing PayPal Email Address', 'beatpress') . '</strong><br>' . __('In order to receive payments first you have to save your PayPal email address', 'beatpress') . '.</p>';
		echo '<p style="color:#6099eb;font-size:60px;text-align:center;"><i class="fas fa-exclamation-triangle"></i></p>';
		echo '</div>';
		echo '</body>';
		echo '</html>';
		
		
		die();
		
	} else {
		
		if ($encryptionEnabled == '' || $encryptionEnabled == '0'){
			$beat = str_replace(' ', '%20', ucwords(htmlspecialchars($_GET["beat"])));
			$license = str_replace(' ', '%20', ucwords(htmlspecialchars($_GET["license"])));
			$purchase = htmlspecialchars($_GET["purchase"]);
			
			if (strpos($sURL,'&bpsid=') !== false) {
				//IF PURCHASE LINKS ARE NOT ENCRYPTED BUT LINK CONTAINS ENCRYPTED BPSID
				echo '<!DOCTYPE html>';
	
				echo '<html>';
	
				echo '<head>';
				echo '<link rel="shortcut icon" href="/wp-content/plugins/beatpress/imgs/system/requests_logo.png" type="image/x-icon">';
				echo '<link rel="icon" href="/wp-content/plugins/beatpress/imgs/system/requests_logo.png" type="image/x-icon">';

				echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">';
				echo '<title>' . __('BeatPress Direct ERROR', 'beatpress') . '</title>';
				echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
				echo '<meta name="robots" content="noindex, nofollow">';
				echo '</head>';
		
		
				echo '<body>';
				echo '<div style="position: fixed; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%); font-family: Arial, Helvetica, sans-serif;">';
				echo '<p style="text-align:center;"><i class="fas fa-exclamation-circle"></i> <strong>' . __('ERROR: Not valid link', 'beatpress') . '</strong><br>' . __('You can\'t use encrypted purchase links if the option is not enabled', 'beatpress') . '.</p>';
				echo '<p style="color:#6099eb;font-size:60px;text-align:center;"><i class="fas fa-exclamation-triangle"></i></p>';
				echo '</div>';
				echo '</body>';
				echo '</html>';
				
				die();
			}
			
		} else {
			$bpsid = my_simple_crypt( htmlspecialchars($_GET["bpsid"]), 'd' );
			parse_str($bpsid);
			$beat = str_replace(' ', '%20', ucwords($beat));
			$license = str_replace(' ', '%20', ucwords($license));
			
			if (strpos($sURL,'&beat=') !== false) {
				//IF PURCHASE LINKS ARE ENCRYPTED BUT LINK CONTAINS UNENCRYPTED BEAT NAME AND PRICE
				echo '<!DOCTYPE html>';
	
				echo '<html>';
	
				echo '<head>';
				echo '<link rel="shortcut icon" href="/wp-content/plugins/beatpress/imgs/system/requests_logo.png" type="image/x-icon">';
				echo '<link rel="icon" href="/wp-content/plugins/beatpress/imgs/system/requests_logo.png" type="image/x-icon">';

				echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">';
				echo '<title>' . __('BeatPress Direct ERROR', 'beatpress') . '</title>';
				echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
				echo '<meta name="robots" content="noindex, nofollow">';
				echo '</head>';
		
		
				echo '<body>';
				echo '<div style="position: fixed; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%); font-family: Arial, Helvetica, sans-serif;">';
				echo '<p style="text-align:center;"><i class="fas fa-exclamation-circle"></i> <strong>' . __('ERROR: Not valid link', 'beatpress') . '</strong><br>' . __('You can\'t use clean purchase links because they\'re encrypted', 'beatpress') . '.</p>';
				echo '<p style="color:#6099eb;font-size:60px;text-align:center;"><i class="fas fa-exclamation-triangle"></i></p>';
				echo '</div>';
				echo '</body>';
				echo '</html>';
				
				die();
			}

		}

		$purchase = ( (int)$purchase / 170486 );
		$purchase = round( $purchase, 2 );

		
		//echo my_simple_crypt( 'eUN6RWFoSGJROThNSS8rVk14a0pxcFJJQ2JZNTd2bWJyNXo2WVRRaUt2K3crTHNWYUc3Vnkvc3RXVmNmNVY5a1BLQmJRTWhtelRYZWVublRIcDhjQkFLNi8wQWZsZnhHMTArcUJ5em4zVjg9', 'd' );
		
		
		
		if ($option_checker['custompplogo'] == '') {
			//echo 'no hay imagen<br><br>';
			$buyurl = 'https://www.paypal.com/cgi-bin/webscr?&cmd=_xclick&business=' . $paypal . '&cy_code=' . $currency . '&amount=' . $purchase . '&item_name=' . $beat . '%20(' . $license . ')%20(' . $sSITE . ')' . '&image_url=' . get_home_url() . '/wp-content/plugins/beatpress/imgs/system/default_paypal_image.jpg' . '&return=' . get_home_url();
			//echo $buyurl;
		} else {
			//echo 'SI hay imagen<br><br>';
			$buyurl = 'https://www.paypal.com/cgi-bin/webscr?&cmd=_xclick&business=' . $paypal . '&cy_code=' . $currency . '&amount=' . $purchase . '&item_name=' . $beat . '%20(' . $license . ')%20(' . $sSITE . ')' . '&image_url=' . $paypal_image . '&return=' . get_home_url();
			//echo $buyurl;
		}
		
		//$buyurl = 'https://www.paypal.com/cgi-bin/webscr?&cmd=_xclick&business=' . $paypal . '&cy_code=' . $currency . '&amount=' . $purchase . '&item_name=' . $beat . '%20(' . $license . ')%20(' . $sSITE . ')';
		header('Refresh: 3; URL=' . $buyurl);

		echo '<!DOCTYPE html>';
	
		echo '<html>';
	
		echo '<head>';
		echo '<link rel="shortcut icon" href="/wp-content/plugins/beatpress/imgs/system/requests_logo.png" type="image/x-icon">';
		echo '<link rel="icon" href="/wp-content/plugins/beatpress/imgs/system/requests_logo.png" type="image/x-icon">';

		echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="BeatPress">';
		echo '<title>' . str_replace('%20', ' ', $beat) . ' ' . __('by', 'beatpress') . ' ' . $option_checker['producername'] . ' · ' . str_replace('%20', ' ', $license) . ' (BeatPress Direct Purchase)</title>';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		echo '<meta name="robots" content="noindex, nofollow">';
		echo '</head>';

		echo '<body>';
		echo '<div style="position: fixed; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%); font-family: Arial, Helvetica, sans-serif;">';
		
		
		if ($option_checker['producerlogo'] == '') {
			//echo 'no hay imagen<br><br>';
			echo '<p style="text-align:center;"><img height="30px" width="30px" src="' . get_home_url() . '/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog_170.jpg"></p>';
		} else {
			//echo 'SI hay imagen<br><br>';
			echo '<p style="text-align:center;"><img height="30px" width="30px" src="' . $option_checker['producerlogo'] . '"></p>';
		}		
		
		
		
		
		
		echo '<p style="text-align:center;"><i class="fas fa-shopping-cart"></i> <strong>' . str_replace('%20', ' ', $beat) . '</strong><br>' . str_replace('%20', ' ', $license) . '<br><strong>$' . $purchase . ' USD</strong></p>';
		echo '<p style="text-align:center; font-size: 10px;"><strong><i class="far fa-clock fa-spin"></i> ' . __('Processing, please wait...', 'beatpress') . '</strong></p>';
		echo '<p style="color:#6099eb;font-size:60px;text-align:center;"><i class="fas fa-circle-notch fa-spin"></i></p>';
		echo '</div>';
	
		
		echo '</body>';
	
		echo '</html>';

		die();
		
	}
	

} else {
	//echo 'Nothing to buy';
}

//Example of URL: https://www.surcebeats.com?beatpress_direct=true&beat=Bullseye&license=Untagged%20WAV%20Lease&purchase=6810915.7
}

add_action('init','beatpress_direct');

/*
$beatpress_direct = htmlspecialchars($_GET["beatpress_direct"]);

$bpsid = my_simple_crypt( htmlspecialchars($_GET["bpsid"]), 'd' );;

parse_str($bpsid);




$beat = str_replace(' ', '%20', ucwords($beat));
$license = str_replace(' ', '%20', ucwords($license));
$purchase = $purchase;
ENCRYPTED URLS with bpsid=*/