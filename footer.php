    <?php get_template_part("templates-part/contact") ?>   
    <footer class="default-container justify-c">
        <nav class="max-w justify-c">
            <!-- id="footer-menu" -->
            <?php
            // Display the primary menu
            wp_nav_menu(array(
                'theme_location' => 'secondary-menu', // Replace 'primary-menu' with the name of your menu location
                'menu_class' => 'menu ', // CSS class to be added to the <ul> element
                'container' => true, // Don't wrap the menu in a <div> container
            ));
            ?>
        </nav>
        </footer>
    <?php wp_footer() ?>
</body>
</html>