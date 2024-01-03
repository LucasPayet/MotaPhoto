<?php

get_header();

?>
<section class="default-container">
    <div class="max-w">
        <div class="home-hero w-100 font-SpaceMono">
            <h1 class="center stroke font-hero-h1">PHOTOGRAPHE EVENT</h1>
            <?php
            $the_query = new WP_Query( array ( 'post_type' => 'album', 'orderby' => 'rand', 'posts_per_page' => '1' ) );
            // output the random post
            while ( $the_query->have_posts() ) : $the_query->the_post();
                echo '<img src="' . get_the_post_thumbnail_url() . '" alt="" width="100%">';
            endwhile;
            ?>
        </div>
    </div>
</section>

<h1>HelloWorld</h1>