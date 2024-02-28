<?php

get_header();
$theme_uri = get_stylesheet_directory_uri();

function get_posts_years_array() {
    global $wpdb;
    $result = array();
    $years = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT YEAR(post_date) FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_type = 'album' GROUP BY YEAR(post_date) DESC"
        ),
        ARRAY_N
    );
    if ( is_array( $years ) && count( $years ) > 0 ) {
        foreach ( $years as $year ) {
            $result[] = $year[0];
        }
    }
    return $result;
}
?>
<section class="default-container">
    <div class=" h-hero">
        <div class="home-hero w-100 font-SpaceMono">
            
            <?php
            $the_query = new WP_Query( array ( 'post_type' => 'album', 'orderby' => 'rand', 'posts_per_page' => '1' ) );
            // output the random post
            while ( $the_query->have_posts() ) : $the_query->the_post();
                echo '<img src="' . get_the_post_thumbnail_url() . '" alt="" width="100%">';
            endwhile;
            ?>
            <h1 class="center stroke font-hero-h1">PHOTOGRAPHE EVENT</h1>
        </div>
    </div>
</section>
<section class="default-container">
    <div class="filter-container max-w margin-a font-Poppins">
        <div class="dropdown-container">
            <div id="Filtre_Catégories" class="dropdown-toggle click-dropdown upperc">
                CATÉGORIES
            </div>
            <!-- <button class="upperc dropbtn" onclick="myFunction()">catégories</button> -->
            <div class="dropdown-menu">
                <ul>
                <li><option class="filter-me" data-cat="all">Toutes les catégories</option></li>
                <?php
                    $args = array(
                        'taxonomy' => 'categorie',
                        'orderby' => 'name',
                        'order'   => 'ASC'
                    );
                    $cats = get_categories($args);

                    foreach($cats as $cat) {
                        $name = $cat->name;
                        $val = $cat->slug;
                    ?>
                        <li><option class="filter-me" data-cat = <?php echo $val . ">" . $name; ?></option></li>
                    <?php };
                ?>
                </ul>
            </div>
        </div>
        <div class="dropdown-container">
            <div id="Filtre_Formats" class="dropdown-toggle click-dropdown upperc">
                FORMATS
            </div>
            <!-- <button class="upperc dropbtn" onclick="myFunction()">catégories</button> -->
            <div class="dropdown-menu">
                <ul>
                    <li><option class="filter-me" data-format="all">Toutes les formats</option></li>
                <?php
                    $args = array(
                        'taxonomy' => 'format',
                        'orderby' => 'name',
                        'order'   => 'ASC'
                    );
                    $formats = get_categories($args);

                    foreach($formats as $format) {
                        $val = $format->name;
                    ?>
                        <li><option class="filter-me" data-format = <?php echo $val . ">" . $val; ?></option></li>
                    <?php };
                ?>
                </ul>
            </div>
        </div>
        <div class="dropdown-container">
            <div id="Filtre_Date" class="dropdown-toggle click-dropdown upperc">
                TRIER PAR
            </div>
            <!-- <button class="upperc dropbtn" onclick="myFunction()">catégories</button> -->
            <div class="dropdown-menu">
                <ul>
                <li><option class="filter-me" data-year="all">Toutes les dates</option></li>
                <?php
                    $years = get_posts_years_array();
                    foreach($years as $year) {
                    ?>
                        <li><option class="filter-me" data-year = <?php echo $year . ">" . $year; ?></option></li>
                    <?php };
                ?>
                </ul>
            </div>
        </div>
        <!-- <div class="dropdown-container">
            <div class="dropdown-content">
                <button class="upperc">formats</button>
                <?php
                    $args = array(
                        'taxonomy' => 'format',
                        'orderby' => 'name',
                        'order'   => 'ASC'
                    );
                    $formats = get_categories($args);

                    foreach($formats as $format) {
                        $val = $format->name;
                    ?>
                        <span value = <?php echo $val . ">" . $val; ?></span>
                    <?php };
                ?>
            </div>
        </div>
        
        <div class="dropdown">
            <div class="dropdown-content">
                <button class="upperc">catégories</button>
                <?php
                    $years = get_posts_years_array();
                    foreach($years as $year) {
                    ?>
                        <span value = <?php echo $year . ">" . $year; ?></span>
                    <?php };
                ?>
            </div>
        </div> -->

    </div>
    <div class="max-w margin-a font-SpaceMono">
        <div id="post-container" class="photo-grid">
            <?php
                $related_query = array(
                    'post_type' => 'album',
                    'posts_per_page' => 8,
                    );
                set_query_var('newquery', $related_query);
                set_query_var('uri', $theme_uri);
                get_template_part('./templates-part/post_query');
            ?>
            
            
        </div>
        <div class="w-100 margin-00"><button id="load-more-button" class="submit-btn contact_ref  margin-a">Charger plus</button></div>

    </div>
    
</section>

<?php
get_footer();