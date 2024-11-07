// =================================================================================================================
//                                                 La page d'accueil
// =================================================================================================================

// Bouton charger plus de photos

jQuery(document).ready(function ($) {
  let page = 2; // Commence à la page 2, car la première page est déjà chargée
  let loading = false; // Empêche le chargement multiple

  // Événement au clic sur le bouton de chargement
  $("#loadMorePhotos").on("click", function () {
    if (!loading) {
      loading = true;

      $.ajax({
        url: natmota_js.ajax_url, // URL définie dans la localisation
        type: "POST",
        data: {
          action: "load_more_photos",
          page: page,
        },
        success: function (response) {
          if (response == 0) {
            // Fin du contenu
            $(".btnload").html("<p>Aucune autre photo disponible</p>");
          } else {
            // Ajoute les nouvelles photos à la fin du conteneur
            $(".photoContainer").append(response);
            page++; // Incrémente le numéro de page pour la prochaine requête
            loading = false; // Permet un nouveau chargement
          }
        },
      });
    }
  });
});

// ----->  Récupére les termes des taxonomies pour reseigner les champs de tri  <-----

jQuery(document).ready(function ($) {
  // Récupère les termes de la taxonomie "format"
  $.ajax({
    url: natmota_js.rest_url + "format",
    type: "GET",
    success: function (response) {
      if (Array.isArray(response)) {
        $("#formats").empty();

        // Ajoute une option par défaut pour inclure tous les formats
        $("#formats").append(`<option value="">Tous les formats</option>`);

        response.forEach((term) => {
          $("#formats").append(
            `<option value="${term.slug}">${term.name}</option>`
          );
        });
      } else {
        console.error("Unexpected response structure:", response);
      }
    },
    error: function (error) {
      console.error("Error fetching formats:", error);
    },
  });

  // Récupère les termes de la taxonomie "categorie"
  $.ajax({
    url: natmota_js.rest_url + "categorie",
    type: "GET",
    success: function (response) {
      if (Array.isArray(response)) {
        $("#categories").empty();

        // Ajoute une option par défaut pour inclure toutes les catégories
        $("#categories").append(
          `<option value="">Toutes les catégories</option>`
        );

        response.forEach((term) => {
          $("#categories").append(
            `<option value="${term.slug}">${term.name}</option>`
          );
        });
      } else {
        console.error("Unexpected response structure:", response);
      }
    },
    error: function (error) {
      console.error("Error fetching categories:", error);
    },
  });
});
