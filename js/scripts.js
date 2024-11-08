jQuery(document).ready(function () {
  jQuery(".js-example-basic-multiple").select2({
    minimumResultsForSearch: Infinity, // Désactive le champ de recherche
    dropdownAutoClose: "outsideClick", // Ferme la fenêtre lorsque vous cliquez en dehors de celle-ci
  });

  // Gestion des événements d'ouverture et fermeture de la liste déroulante
  jQuery(".js-example-basic-multiple")
    .on("select2:open", function () {
      // Ajouter la classe pour faire pivoter la flèche
      jQuery(this)
        .next(".select2-container")
        .find(".select2-selection__arrow b")
        .addClass("select2-arrow-rotated");
    })
    .on("select2:close", function () {
      // Retirer la classe pour remettre la flèche dans sa direction d'origine
      jQuery(this)
        .next(".select2-container")
        .find(".select2-selection__arrow b")
        .removeClass("select2-arrow-rotated");
    });
  // Fermer la fenêtre Select2 si on clique en dehors du conteneur
  jQuery(document).on("click", function (e) {
    // Vérifie si le clic est en dehors du conteneur Select2
    if (!jQuery(e.target).closest(".select2-container").length) {
      jQuery(".js-example-basic-multiple").select2("close");
    }
  });
});
