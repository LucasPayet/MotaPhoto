<?php
$theme_uri = get_stylesheet_directory_uri();
$related_query = new WP_Query( get_query_var('newquery'));


// $theme_uri = get_query_var('uri');
if ($related_query->have_posts()) :
    while ($related_query->have_posts()) :
        $related_query->the_post();
        $postId = $post->ID;
        $Rref = get_field('référence', $postId);
        $RTermCat = get_the_terms( $postId, 'categorie' );
        $Rcat = $RTermCat[0]->name;
        ?>
        <article class="relativ font-SpaceMono">
            <img src="<?php echo get_the_post_thumbnail_url(); ?>" data-cat="<?php echo $Rcat; ?>" data-ref="<?php echo $Rref; ?>" class="img-template">
            <div class="overlay">
                <a href="<?php echo get_post_permalink() ?>" class="eye"><img src="<?php echo $theme_uri . "/assets/images/Icon_eye.png" ?>"></a>
                <button class="btn-style-no s-tl"><img src="<?php echo $theme_uri . "/assets/images/Icon_fullscreen.svg" ?>"></button>
                <span class="s s-right upperc"><?php echo $Rref; ?></span>
                <span class="s s-left upperc"><?php echo $Rcat; ?></span>
            </div>
        </article>
    <?php endwhile;
    wp_reset_postdata();
// else :
//     // wp_send_json_error(
//     //     array(
//     //         'message' => 'Custom error message',
//     //         'content' => '<article class="relativ font-SpaceMono"><p>Aucune photo ne correspond au filtre !</p></article>'
//     //     )
//     // );
    

endif;
