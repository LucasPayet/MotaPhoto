<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();

	$theme_uri = get_stylesheet_directory_uri();

	$post_id = $post->ID;
	$post_date = get_the_date('Y');
	$featured_image_id = get_post_thumbnail_id($post_id);
	$featured_image_src = wp_get_attachment_image_src($featured_image_id, 'full');

	$taxonomies = get_object_taxonomies(get_post_type());

	// On récupère les champs ACF nécessaires
	$type=get_field('type', $post_id);
	$ref=get_field('référence', $post_id);

	//prev and next post id by category
	// $custom_post_type = get_post_type();
	// $previous_post = get_adjacent_post( $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' );
	// $previous_post_link = get_permalink($previous_post);
	// $previous_post_image = wp_get_attachment_image_src($previous_post->ID);
	// $next_post = get_adjacent_post( $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' );
	// $next_post_link = get_permalink($next_post);
	// $next_post_image = wp_get_attachment_image_src($next_post->ID);
	$next_post = get_next_post();
	$previous_post = get_previous_post();
	$next_post_image = get_the_post_thumbnail_url($next_post->ID);
	$prev_post_image = get_the_post_thumbnail_url($prev_post->ID);

?>
	<section class="default-container align-c">
		<!-- Display the featured image -->
		<article class="max-w grid-section font-SpaceMono">
		<?php
		$custom_field_value = get_post_meta(get_the_ID(), 'mon-album-acf', true);
		if (!empty($custom_field_value)) {
			echo '<p>Custom Field Content: ' . esc_html($custom_field_value) . '</p>';
		}
		?>
		<div class="post-info">
			<h1 class="post-title"> <?php echo get_the_title() ?></h1>
			<div class="taxonomy">
				<p id="ref" style="text-transform:uppercase;">Référence : <?php echo $ref ?></p>
				<?php
				foreach ($taxonomies as $taxonomy) {
					$terms = get_the_terms(get_the_ID(), $taxonomy);
					if ($terms && !is_wp_error($terms)) {
						echo '<p style="text-transform:uppercase;">' . esc_html($taxonomy) . ' : ';
						foreach ($terms as $term) {
							echo esc_html($term->name);
						}
						echo '</p>';
					}
				} ?>
				<p style="text-transform:uppercase;">Type : <?php echo $type ?></p>
				<p style="text-transform:uppercase;">Année : <?php echo $post_date ?></p>
			</div>
			<div class="flex-wrap h-118">
				<p class="title-interest">Cette photo vous intéresse ?</p>
				<button id="ContactRef" class="submit-btn contact_ref btn-style-no">Contact</button>
			</div>
		</div>
		<div class="featured-image">
			<img width="100%" src="<?php echo $featured_image_src[0] ?>" class="grid-post">
			<div class="h-118 grid-post-nav">
				<img src=" <?php echo get_the_post_thumbnail_url(get_next_post(), array(81,71)) ?>" width="81px" style="height: 71px">
				<?php if (get_previous_post()) : ?>
					<a href="<?php echo get_post_permalink(get_previous_post())?>"id="previous-post"><img src="<?php echo $theme_uri . '\assets\images\prev.svg'  ?>" alt="" srcset=""></a>
				<?php endif;
				if (get_next_post()) : ?>
					<a href="<?php echo get_post_permalink(get_next_post())?>" id="next-post"><img src="<?php echo $theme_uri . '\assets\images\next.svg'  ?>" alt="" srcset=""></a>
				<?php endif; ?>
			</div>
		</div>
		
<!-- 
		// if (has_post_thumbnail()) {
		// 	echo '<div class="featured-image">';
		// 	the_post_thumbnail(array(563, 844)); // You can specify the image size here (e.g., 'thumbnail', 'medium', 'large', 'full')
		// 	echo '</div>';
		// }

			// Display the content
			// the_content();

			// Display custom field content -->
		
		</article>
	</section>
	<!-- // get_template_part( 'template-parts/content/content-single' ); -->
	<!-- // End of the loop. -->
<?php
endwhile;

get_footer();

// $custom_field_value = get_post_meta(get_the_ID(), 'album', true);
// if (!empty($custom_field_value)) {
// 	echo '<p>Custom Field Content: ' . esc_html($custom_field_value) . '</p>';
// }

// $taxonomies = get_object_taxonomies(get_post_type());
// foreach ($taxonomies as $taxonomy) {
// 	$terms = get_the_terms(get_the_ID(), $taxonomy);
// 	if ($terms && !is_wp_error($terms)) {
// 		echo '<div class="taxonomy-' . esc_attr($taxonomy) . '">';
// 		echo '<p style="text-transform:uppercase;">' . esc_html($taxonomy) . ' : ';
// 		foreach ($terms as $term) {
// 			echo '<a href="' . esc_url(get_term_link($term)) . ' ">' . esc_html($term->name) . '</a> ';
// 		}
// 		echo '</p></div>';
// 	}
// }