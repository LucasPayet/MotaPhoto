    <?php
    $theme_uri = get_stylesheet_directory_uri(); 
    get_template_part("templates-part/contact") 
    ?>
    <div id="lightbox" class="lightbox-none font-SpaceMono upperc">
        <!-- <div class="lol"></div> -->
        <figure>
            <img id="lightboxImage" src="" alt="" >
            <figcaption>
                <span id="LbRef"></span><span id="LbCat"></span>
            </figcaption>
        </figure>
        <button id="Lb-close"></button>
        <nav id="lightbox-nav">
            <button class="Lb-nav-btn Lb-prev-btn" data-postid=""><img class="default" src=" <?php echo $theme_uri . '/assets/images/PrevDefault.svg' ?>" alt=""><img class="hover" src=" <?php echo $theme_uri . '/assets/images/PrevHover.svg' ?>" alt=""></button>
            <button class="Lb-nav-btn Lb-next-btn" data-postid=""><img class="default" src=" <?php echo $theme_uri . '/assets/images/NextDefault.svg' ?>" alt=""><img class="hover" src=" <?php echo $theme_uri . '/assets/images/NextHover.svg' ?>" alt=""></button>
        </nav>
    </div>
    <footer class="default-container justify-c">
        <nav class="max-w justify-c">
            <!-- id="footer-menu" -->
            <?php
            // Display the primary menu
            wp_nav_menu(array(
                'theme_location' => 'secondary-menu', // Replace 'primary-menu' with the name of your menu location
                'menu_class' => 'menu-footer ', // CSS class to be added to the <ul> element
                'container' => true, // Don't wrap the menu in a <div> container
            ));
            ?>
        </nav>
        </footer>
    <?php wp_footer() ?>
</body>
</html>