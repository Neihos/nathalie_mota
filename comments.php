<?php
// comments.php - Fichier requis pour la compatibilité avec WordPress
if ( post_password_required() ) {
    return;
}

if ( comments_open() || get_comments_number() ) :
    // Si des commentaires existent ou si l'ajout est activé, affiche la liste et le formulaire de commentaires.
    ?>
    <div id="comments" class="comments-area">
        <?php
        wp_list_comments(); // Liste les commentaires.
        comment_form(); // Formulaire pour soumettre un commentaire.
        ?>
    </div>
<?php
endif;
?>
