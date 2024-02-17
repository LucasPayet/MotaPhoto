<!doctype html>
<html lang="fr">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
    <style type="text/css" media="screen">
        html { margin-top: 0 !important; }
        @media screen and ( max-width: 782px ) {
            html { margin-top: 0 !important; }
        }
    </style>
</head>
<section class="default-container justify-c">
    <?php
    //if (!wp_is_mobile()){ ?>
    <header class="max-w">
        <?php 
        if (has_custom_logo()){
        ?>
        <div id="logo">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <img src="<?php echo get_theme_mod('montheme_logo'); ?>" alt="logo planty">
            </a>
        </div> <?php } ?>
        <nav id="header-menu">
            <div id="logo">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <img src="<?php echo get_theme_mod('montheme_logo'); ?>" alt="MotaPhto Logo">
                </a>
            </div>
            <?php
            // Display the primary menu
            wp_nav_menu(array(
                'theme_location' => 'primary-menu', // Replace 'primary-menu' with the name of your menu location
                'menu_class' => 'menu', // CSS class to be added to the <ul> element
                'container' => true, // Don't wrap the menu in a <div> container
            ));
            ?>
        </nav>
    </header>
    <?php //} ?>
    
</section>