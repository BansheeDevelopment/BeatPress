<?php
/**
 * BeatPress Audio Stream Server
 * Audio Stream Server made to encrypt direct access to MP3 files
 *
 * @/inc/mp3_server.php
 * @package BeatPress
 */

// Security Layer
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access to BeatPress Script denied.' );
}

// BEATPRESS MP3 URL OBFUSCATOR
function mp3obfuscator() { 
	//$before = 'https://dl.dropboxusercontent.com/s/'; // The text before the link
	$before = ''; // The text before the link
	//$after = '?dl=1'; // The post-text code after the link
	$after = ''; // The post-text code after the link
	//Special Characters
	$listen = htmlspecialchars($_GET["listen"]);
	$code = htmlspecialchars($_GET["code"]);
	$decrypted = my_simple_crypt( $code, 'd' );
	
	if (isset($_SERVER['HTTP_REFERER'])) { // check there was a referrer
		$REF = parse_url($_SERVER['HTTP_REFERER']); // use the parse_url() function to create an array containing information about the domain
		if (strpos($REF['host'], $_SERVER['HTTP_HOST']) !== false) { // if the referer is the domain then create the encrypted streaming url
			if ($listen == '1') {
				$url = $before . $decrypted . $after;
				header("X-Robots-Tag: noindex", true);
				header("Location: $url");
				
				echo '<!DOCTYPE html>';
	
				echo '<html>';
	
				echo '<head>';
				echo '<title>' . __('BeatPress Audio Streaming Server', 'beatpress') . '</title>';
				echo '<meta name="robots" content="noindex, nofollow">';
				echo '</head>';

				echo '<body>';
				echo '</body>';
	
				echo '</html>';

				
				die();
			}
		}
	} else {
		
				if ( $listen == '1' ) {

				
				header("X-Robots-Tag: noindex", true);
				
				echo '<!DOCTYPE html>';
	
				echo '<html>';
	
				echo '<head>';
				echo '<meta name="viewport" content="width=device-width, initial-scale=1">';

				echo '<link rel="shortcut icon" href="/wp-content/plugins/beatpress/imgs/system/requests_logo.png" type="image/x-icon">';
				echo '<link rel="icon" href="/wp-content/plugins/beatpress/imgs/system/requests_logo.png" type="image/x-icon">';

				echo '<title>' . __('BeatPress Audio Streaming Server', 'beatpress') . '</title>';
				echo '<meta name="robots" content="noindex, nofollow">';
				echo '</head>';

				echo '<body>';
				
				echo '<div style="position: fixed; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%); font-family: Arial, Helvetica, sans-serif;">';
				echo '<p style="text-align:center;"><strong>' . __('You can\'t view this page', 'beatpress') . '</strong><br>' . __('Streaming links are encrypted by default', 'beatpress') . '.</p>';
				echo '<p style="color:#6099eb;font-size:60px;text-align:center;">!!!</p>';
				echo '</div>';

				echo '</body>';
	
				echo '</html>';

				
				die();
}
	}

}

add_action('init','mp3obfuscator');