<?php
// =================================================================================================================
//                                              Parts for single-photo page
// =================================================================================================================
?>

<section id="lightboxOverlay" class="lightboxOverlay showNow">
    <div id="lightboxContainer">
        <button class="lightboxTop">                
            <img id="lightboxClose" src="<?php echo get_template_directory_uri(); ?>/assets/images/cross.svg" alt="Fermer">
        </button>
        <div class="lightboxGlobal">
            <button class="arrowLightboxLeft arrowLightbox">
                <img id="before_arrow_lightbox" src="<?php echo get_template_directory_uri(); ?>/assets/images/before_arrow.svg" alt="Précédent">
                <p class="btnArrowLeft">Précédente</p>                    
            </button>
            <figure class="lightboxDisplayImg">
                <img id="lightboxImage" src="" alt="Photo en pleine taille">
                <figcaption class="lightboxLink">   
                    <p class="lightboxCategory">Catégorie</p>
                    <p class="lightboxRef">Référence</p>
                </figcaption>
            </figure>                
            <button class="arrowLightboxRight arrowLightbox">
                <p class="btnArrowRight">Suivante</p>
                <img id="next_arrow_lightbox" src="<?php echo get_template_directory_uri(); ?>/assets/images/next_arrow.svg" alt="Suivant">                                       
            </button>
        </div>    
            
    </div>
</section>