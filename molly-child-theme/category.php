<?php
get_header();
$cat = get_category( get_query_var( 'cat' ) );
$cat_slug = $cat->slug;
$the_cat_id = $cat->cat_ID;

$locale =  substr( get_locale(), 0, 2 );

switch ($locale) {
	case 'en':
		$my_cat = 'category';
		break;
	case 'it': case 'es':
		$my_cat = 'categoria';
		break;
	case 'de':
		$my_cat = 'kategorie';
		break;
	default:
		$my_cat = 'categorie';
}

$html = '';

	$args=array(
		'post_type' 		=> 'et_pb_layout',
		'post_name__in' 	=> array($my_cat . '-' . $cat_slug, $my_cat),
		'posts_per_page' 	=> 1,
		'orderby'			=> 'name',
		'order'				=> 'DESC',
	);
	$query = new WP_Query($args);
	if ($query->have_posts()) :
		//As I want to be sure that no category have been set (to avoid errors), I assure myself to "remove" it :).
		$html = str_replace('include_categories', 'unknown', $query->posts[0]->post_content);
		// Then I define it easily with the current category id :)...
		$html = str_replace('[et_pb_blog ', '[et_pb_blog include_categories="'.$the_cat_id.'" ', $html);
	endif;
?>

<div id="main-content">

<?php if ( $html =='' ) : ?>
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area" class="categorie">
<?php endif; ?>

			<?php
			if ($html) :
				echo do_shortcode($html);
			else :
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						$post_format = et_pb_post_format(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

					<?php
						$thumb = '';

						$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

						$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
						$classtext = 'et_pb_post_main_image';
						$titletext = get_the_title();
						$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
						$thumb = $thumbnail["thumb"];

						et_divi_post_format_content();

						if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
							if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
								printf(
									'<div class="et_main_video_container">
										%1$s
									</div>',
									$first_video
								);
							elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>
								<a href="<?php the_permalink(); ?>">
									<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
								</a>
						<?php
							elseif ( 'gallery' === $post_format ) :
								et_pb_gallery_images();
							endif;
						} ?>

					<?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
						<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php endif; ?>

						<?php
							et_divi_post_meta();

							if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_et_pb_use_builder', true ) ) ) ) {
								truncate_post( 270 );
							} else {
								the_content();
							}
						?>
					<?php endif; ?>

						</article> <!-- .et_pb_post -->
					<?php
						endwhile;

						if ( function_exists( 'wp_pagenavi' ) )
							wp_pagenavi();
						else
							get_template_part( 'includes/navigation', 'index' );
				else :
					get_template_part( 'includes/no-results', 'index' );
				endif;
			endif; /* Categorie */
			?>

<?php if ( $html == '' ) : ?>
			</div> <!-- #left-area -->
			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
<?php endif; ?>

</div> <!-- #main-content -->

<?php get_footer(); ?>