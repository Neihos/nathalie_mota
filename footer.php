</body>
<footer class="motaFooter">
    <?php 
		// menu footer déclaré dans functions.php
		wp_nav_menu(array('theme_location' => 'footer')); 
	?>	

    <?php
    // Ajoute la modale si l'on clique sur contact
     get_template_part( 'template_parts/template/modale' );
    ?>

</footer>
<?php wp_footer(); ?>

</html>