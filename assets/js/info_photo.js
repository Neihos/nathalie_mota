// Démarrage de jQuery
jQuery(document).ready(function ($) {

  /*********************************************/
  /***** Récupérer la référence des photos *****/
  /*********************************************/

  const ref = $(".reference");

  function getRef_event() {
    if (ref.length) {
      // Vérifie si l'élément existe
      // Récupère le texte entier, puis extrait uniquement la valeur après "Référence : "
      const referenceText = ref.text().trim();
      const referenceValue = referenceText.replace("Référence : ", "").trim();

      // Insère uniquement la valeur extraite dans le champ
      $("#menu-ref-photo").val(referenceValue);
    }
  }
  getRef_event();

  /**********************************************************/
  /***** Zone photos apparentées class= sliderContainer *****/
  /**********************************************************/

  // Sélectionner les flèches et récupérer les images à utiliser
  const arrow_left = $(".arrow-left");
  const arrow_right = $(".arrow-right");
  const img_previous = $(".previousImg");
  const img_next = $(".nextImg");

  /** -->Fonction pour gérer les événements sur la flèche gauche<-- **/
  function arrow_left_event() {
    arrow_left.click(function () {
      let previousPostUrl = $(this).data("previous");
      const lastPostUrl = $(this).data("last");

      // Redirige vers le dernier post si on est au début de la série
      if (previousPostUrl === "#") {
        previousPostUrl = lastPostUrl;
      }
      window.location.href = previousPostUrl;
    });

    // Fait apparaitre les images du slider au hover
    arrow_left.hover(
      function () {
        img_previous.removeClass("hiddenNow");
      },
      function () {
        img_previous.addClass("hiddenNow");
      }
    );
  }
  arrow_left_event();

  /** -->Fonction pour gérer les événements sur la flèche droite<-- **/

  function arrow_right_event() {
    arrow_right.click(function () {
      let nextPostUrl = $(this).data("next");
      const firstPostUrl = $(this).data("first");

      // Redirige vers le premier post si on est à la fin de la série
      if (nextPostUrl === "#") {
        nextPostUrl = firstPostUrl;
      }
      window.location.href = nextPostUrl;
    });

    // Fait apparaitre les images du slider au hover
    arrow_right.hover(
      function () {
        img_next.removeClass("hiddenNow");
      },
      function () {
        img_next.addClass("hiddenNow");
      }
    );
  }
  arrow_right_event();

  // Fermeture de jQuery
});