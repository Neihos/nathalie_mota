// =================================================================================================================
//                                                 Home page
// =================================================================================================================

jQuery(document).ready(function ($) {
  // Variables globales pour la pagination et les filtres
  let currentPage = 1;
  let selectedFormat = "";
  let selectedCategory = "";
  let selectedSort = "";

  // -----> Action avec les filtres <-----

  // Mise à jour du tri par format
  $("#formats").on("change", function (event) {
    event.preventDefault();
    selectedFormat = $(this).val();
    resetAndLoadPhotos();
  });

  $("#categories").on("change", function (event) {
    event.preventDefault();
    selectedCategory = $(this).val();
    resetAndLoadPhotos();
  });

  $("#trie").on("change", function (event) {
    event.preventDefault();
    selectedSort = $(this).val();
    resetAndLoadPhotos();
  });

  // -----> Action avec le bouton Charger plus <-----
  $("#loadMorePhotos").on("click", function () {
    currentPage++; // Incrémentation de la page
    loadPhotos(false); // Charge les photos sans réinitialiser le conteneur
  });

  // Fonction pour réinitialiser et charger les photos
  function resetAndLoadPhotos() {
    currentPage = 1; // Réinitialise à la première page
    $(".photoContainer").addClass("updating-content"); // Cache le contenu pendant le chargement
    $("#loadMorePhotos").prop("disabled", false).html("Charger plus");
    loadPhotos(true); // Recharge les photos en réinitialisant le conteneur
  }

  // Fonction pour charger les photos avec les filtres
  function loadPhotos(resetContainer) {
    $.ajax({
      url: natmota_js.ajax_url,
      type: "POST",
      data: {
        action: "load_more_photos",
        page: currentPage,
        security: natmota_js.nonce,
        format: selectedFormat,
        category: selectedCategory,
        sort: selectedSort,
      },
      success: function (response) {
        if (resetContainer) {
          $(".photoContainer").html(
            response == 0 ? "<p>Aucune photo disponible.</p>" : response
          );
        } else {
          if (response == 0) {
            // Pas plus de photos à charger
            $("#loadMorePhotos").prop("disabled", true).html("Fin de la liste");
          } else {
            $(".photoContainer").append(response); // Ajoute les nouvelles photos à la liste existante
          }
        }
        $(".photoContainer").removeClass("updating-content"); // Réaffiche le contenu
      },
      error: function () {
        console.error(
          "Une erreur s'est produite lors du chargement des photos."
        );
      },
    });
  }

  // -----> Récupère les termes des taxonomies pour remplir les champs de tri <-----
  fetchTaxonomyTerms("format", "#formats", "Formats");
  fetchTaxonomyTerms("categorie", "#categories", "Catégories");

  function fetchTaxonomyTerms(taxonomy, selector, defaultOption) {
    $.ajax({
      url: `${natmota_js.rest_url}${taxonomy}`,
      type: "GET",
      success: function (response) {
        if (Array.isArray(response)) {
          $(selector)
            .empty()
            .append(`<option value="">${defaultOption}</option>`);
          response.forEach((term) => {
            $(selector).append(
              `<option value="${term.slug}">${term.name}</option>`
            );
          });
        } else {
          console.error("Unexpected response structure:", response);
        }
      },
      error: function (error) {
        console.error(`Error fetching ${taxonomy}:`, error);
      },
    });
  }

  // -----> Initialisation de Select2 et personnalisation des filtres <-----
  $(".js-example-basic-multiple").select2({
    minimumResultsForSearch: Infinity,
    dropdownAutoClose: "outsideClick",
  });

  $(".js-example-basic-multiple")
    .on("select2:open", function () {
      $(this)
        .next(".select2-container")
        .find(".select2-selection__arrow b")
        .addClass("select2-arrow-rotated");
    })
    .on("select2:close", function () {
      $(this)
        .next(".select2-container")
        .find(".select2-selection__arrow b")
        .removeClass("select2-arrow-rotated");
    });

  $(document).on("click", function (e) {
    if (!$(e.target).closest(".select2-container").length) {
      $(".js-example-basic-multiple").select2("close");
    }
  });
});
