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

	// $current_category = get_the_terms($post_id, "categories");

	$type=get_field('type', $post_id);
	$ref=get_field('référence', $post_id);
	$next_post = get_next_post();
	$previous_post = get_previous_post();
	$next_post_image = get_the_post_thumbnail_url($next_post->ID);
	$prev_post_image = get_the_post_thumbnail_url($prev_post->ID);
	
	$categories = get_the_terms( $post_id, 'categorie' );
	$category_ids = get_the_category($post_id, array('fields' => 'ids'));
	
	
?>
	<section class="default-container justify-c">
		<!-- Display the featured image -->
		<article class="max-w grid-section font-SpaceMono">
			<?php
			$custom_field_value = get_post_meta(get_the_ID(), 'mon-album-acf', true);
			if (!empty($custom_field_value)) {
				echo '<p>Custom Field Content: ' . esc_html($custom_field_value) . '</p>';
			}
			?>
			<div class="post-info resp-pad-54">
				<h1 class="post-title upperc"> <?php echo get_the_title() ?></h1>
				<div class="taxonomy">
					<p id="ref" class="upperc">Référence : <?php echo $ref ?></p>
					<?php
					foreach ($taxonomies as $taxonomy) {
						$terms = get_the_terms(get_the_ID(), $taxonomy);
						if ($terms && !is_wp_error($terms)) {
							echo '<p class="upperc">' . esc_html($taxonomy) . ' : ';
							foreach ($terms as $term) {
								echo esc_html($term->name);
							}
							echo '</p>';
						}
					} ?>
					<p class="upperc">Type : <?php echo $type ?></p>
					<p class="upperc">Année : <?php echo $post_date ?></p>
				</div>
			</div>
			<div class="interested flex-wrap h-110 resp-pad-54">
					<p class="title-interest">Cette photo vous intéresse ?</p>
					<button id="ContactRef" class="submit-btn contact_ref btn-style-no">Contact</button>
				</div>
			<div class="featured-image">
				<img width="100%" src="<?php echo $featured_image_src[0] ?>">
			</div>
			<div class="h-110 grid-post-nav">
				<?php if (get_previous_post()) : ?>
					<a href="<?php echo get_post_permalink(get_previous_post())?>"class="previous-post"><img src="<?php echo $theme_uri . '\assets\images\prev.svg'  ?>" alt="" srcset=""></a>
				<?php endif; ?>
				<img src=" <?php echo get_the_post_thumbnail_url(get_previous_post(), array(81,71)) ?>" class="previmg" width="81px" style="height: 71px">
				<img src=" <?php echo get_the_post_thumbnail_url(get_next_post(), array(81,71)) ?>" width="81px" style="height: 71px">
				
				<?php if (get_next_post()) : ?>
					<a href="<?php echo get_post_permalink(get_next_post())?>" id="next-post"><img src="<?php echo $theme_uri . '\assets\images\next.svg'  ?>" alt="" srcset=""></a>
				<?php endif; ?>
			</div>
		</article>
	</section>
	<section id="related-sect" class="default-container justify-c resp-pad-29">
		<div class="max-w font-SpaceMono">
			<h2 class="top-sep" id="related">VOUS AIMEREZ AUSSI</h2>
			<div class="photo-grid">
				<?php
					$related_query = array(
						'post_type' => 'album',
						'posts_per_page' => 2,
						'tax_query' => array(
							array(
								'taxonomy' => 'categorie',
								'field' => 'term_id',
								'terms' => $categories[0]->term_id,
							)),
						'post__not_in' => array($post_id),
						);
					set_query_var('newquery', $related_query);
					set_query_var('uri', $theme_uri);
					get_template_part('./templates-part/post_query');
				?>
				
				
			</div>
			<div class="w-100 justify-c margin-00"><a href=" <?php echo home_url() ?>" class="submit-btn contact_ref txt-c">Toutes les photos</a></div>
		</div>
		
	</section>
	<?php
endwhile;

get_footer();