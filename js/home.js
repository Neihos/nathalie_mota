// =================================================================================================================
//                                                 La page d'accueil
// =================================================================================================================

// Bouton charger plus de photos

jQuery(document).ready(function ($) {
  let page = 2; // Commence à la page 2, car la première page est déjà chargée
  let loading = false; // Empêche le chargement multiple

  // Variables pour le tri
  let selectedFormat = "";
  let selectedCategory = "";
  let selectedSort = "";

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
          format: selectedFormat,
          category: selectedCategory,
          sort: selectedSort,
        },
        success: function (response) {
          if (response == 0) {
            // Fin du contenu
            $(".btnload").html(
              '<button id="loadMorePhotos">Fin de la liste</button>'
            );
            $("#loadMorePhotos").prop("disabled", true);
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

  // Met à jour les variables de tri quand l'utilisateur sélectionne un format
  $("#formats").on("change", function () {
    selectedFormat = $(this).val();
    page = 2; // Réinitialise la page pour charger les résultats du début
    $(".photoContainer").empty(); // Vide le conteneur des photos
    $("#loadMorePhotos").prop("disabled", false);
    $("#loadMorePhotos").html("Charger plus");
    loadPhotos(); // Recharge les photos en fonction des nouveaux filtres
  });

  // Met à jour les variables de tri quand l'utilisateur sélectionne une catégorie
  $("#categories").on("change", function () {
    selectedCategory = $(this).val();
    page = 2; // Réinitialise la page pour charger les résultats du début
    $(".photoContainer").empty(); // Vide le conteneur des photos
    $("#loadMorePhotos").prop("disabled", false);
    $("#loadMorePhotos").html("Charger plus");
    loadPhotos(); // Recharge les photos en fonction des nouveaux filtres
  });

  // Met à jour les variables de tri quand l'utilisateur sélectionne un mode de tri
  $("#trie").on("change", function () {
    selectedSort = $(this).val();
    page = 2; // Réinitialise la page pour charger les résultats du début
    $(".photoContainer").empty(); // Vide le conteneur des photos
    $("#loadMorePhotos").prop("disabled", false);
    $("#loadMorePhotos").html("Charger plus");
    loadPhotos(); // Recharge les photos en fonction des nouveaux filtres
  });

  // Fonction pour charger les photos en fonction des filtres
  function loadPhotos() {
    $.ajax({
      url: natmota_js.ajax_url, // URL définie dans la localisation
      type: "POST",
      data: {
        action: "load_more_photos",
        page: 1,
        format: selectedFormat,
        category: selectedCategory,
        sort: selectedSort,
      },
      success: function (response) {
        if (response == 0) {
          $(".photoContainer").html("<p>Aucune photo disponible.</p>");
        } else {
          $(".photoContainer").html(response);
        }
      },
    });
  }

  // ----->  Récupère les termes des taxonomies pour renseigner les champs de tri  <-----

  // Récupère les termes de la taxonomie "format"
  $.ajax({
    url: natmota_js.rest_url + "format",
    type: "GET",
    success: function (response) {
      if (Array.isArray(response)) {
        $("#formats").empty();
        // Ajoute une option par défaut pour inclure tous les formats
        $("#formats").append(`<option value="">Formats</option>`);
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
          `<option value="">Catégories</option>`
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

