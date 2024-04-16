<?php
/**
 * BeatPress Custom Post Type Taxonomy Genre
 * Used to display custom catalogs filtering by genres
 *
 * @active_theme/taxonomy-genre.php
 * @package BeatPress
 */

// Security Layer
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct access to BeatPress Script denied.' );
}

?>

<?php get_header(); ?>

  <?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>
  <div id="container">
    <div id="content" role="main">
	  
	  <?php
	  
	  echo do_shortcode('[beats_load_genre]');
	  echo term_description();
	  
	  ?>

    </div><!-- #content -->
  </div><!-- #container -->

  <?php //get_sidebar(); ?>
<?php get_footer(); ?>
