<?php
/**
 * BeatPress HTML5 Sound Player - jPlayer
 * HTML5 Sound Player - jPlayer
 *
 * @/inc/jplayer.php
 * @package BeatPress
 */

// Security Layer
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access to BeatPress Script denied.' );
}

// START JPLAYER
function jPlayerInit() {
?>

<!-- ============= FLEXBOX AUDIO PLAYER ============== -->
<div class="audio-player" xHn="1">

  <div id="jquery_jplayer_1" class="jp-jplayer"></div>
  <!-- Audio Player -->
  
  <!-- Visual Container -->
  <div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
    <div class="jp-type-playlist">
      <!-- Flexbox -->
      <div class="jp-gui jp-interface flex-wrap">  
        
        <!-- Play / Pause... Controls -->
        <div class="jp-controls flex-item">
          <button class="jp-play" role="button" tabindex="0"><i class="fas fa-play bp_playicon"></i></button>
		  <img src="/wp-content/plugins/beatpress/imgs/system/logo_placeholder_catalog.jpg" class="bp_beatimg">
        </div>
        <!-- End Flex Item -->
        <!-- Progress bar -->
        <div class="jp-progress-container flex-item">
          <!-- Progress Time -->
          <div class="jp-time-holder">
            <span class="jp-current-time" role="timer" aria-label="time">&nbsp;</span>
            <span class="jp-duration" role="timer" aria-label="duration">&nbsp;</span>
          </div>
          <!-- End Time holder -->

          <!-- Progress bar -->
          <div class="jp-progress">
            <div class="jp-seek-bar">
              <div class="jp-play-bar">
                <div class="bullet">
                </div>
              </div>
            </div>
          </div>
          <!-- End Progress bar -->

        </div>
        <!-- End Flex Item -->
        <!-- Album & Artist Info -->
        <div class="jp-now-playing flex-item">
          <div class="jp-track-name"></div>
          <div class="jp-artist-name"></div>
        </div>
        <!-- End Flex Item -->

        <!-- Loop / Shuffle / Playlist Toggles -->
        <div class="jp-toggles flex-item">
          <!-- Open Beat Page -->
          <button id="playlist-toggle" class="jp-show-playlist" role="button" tabindex="0"><!--<a class="openbeatlink" href="">--><i class="fas fa-external-link-alt"></i><!--</a>--></button>
          <!-- Shuffle Toggle -->
          <button class="jp-repeat" role="button" tabindex="0"><i class="fas fa-redo-alt"></i></button>

        </div>
        <!-- End Flex Item -->
        <!-- Volume controls -->
        <div class="jp-volume-controls flex-item">
          <button class="jp-mute" role="button" tabindex="0"><i class="fas fa-volume-up"></i></button>
          <!-- Volume Bar -->
          <div class="jp-volume-bar">
            <div class="jp-volume-bar-value">
              <div class="bullet">
              </div>
            </div>
          </div>
          <!-- End Volume Bar -->
        </div>
        <!-- End Flex Item -->
      </div>
      <!-- End Flexbox -->
      <!-- Playlist -->
      <div id="playlist-wrap" class="jp-playlist">
        <ul>
          <li>&nbsp;</li>
        </ul>
      </div>
      <!-- End Playlist -->
      <!-- No Flash / No HTML5 Warning -->
      <div class="jp-no-solution">
        <span><?php _e('Update Required', 'beatpress'); ?></span> <?php _e('To play the media you will need to either update your browser to a recent version or update your Flash plugin.', 'beatpress'); ?>
      </div>
    </div>
    <!-- Player Type Playlist -->
  </div>
  <!-- End Contaner -->

</div>
<!-- End Fixed Audio Player -->

<?php
}
