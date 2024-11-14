// =================================================================================================================
//                                                 Home page
// =================================================================================================================

jQuery(document).ready(function ($) {
  // -----> Bouton charger plus de photos <-----

  // Variables de pagination et de chargement
  let page = 2; // Commence à la page 2, la première étant déjà chargée
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
        url: natmota_js.ajax_url,
        type: "POST",
        data: {
          action: "load_more_photos",
          page: page,
          format: selectedFormat,
          category: selectedCategory,
          sort: selectedSort,
          security: natmota_js.nonce,
        },
        success: function (response) {
          if (response == 0) {
            // Fin du contenu
            $(".btnload").html(
              '<button id="loadMorePhotos">Fin de la liste</button>'
            );
            $("#loadMorePhotos").prop("disabled", true);
          } else {
            // Ajout des nouvelles photos
            $(".photoContainer").append(response);
            page++; // Incrémente pour la prochaine requête
            loading = false; // Réinitialise l'état de chargement
          }
        },
      });
    }
  });

  // -----> Action avec les filtres <-----

  // Mise à jour du tri par format
$("#formats").on("change", function (event) {
  event.preventDefault(); // Empêche le repositionnement de la page
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


  // Fonction pour réinitialiser et charger les photos
  function resetAndLoadPhotos() {
    page = 2;
    $(".photoContainer").addClass("updating-content"); // Ajout d'une classe pour cacher le contenu
    $("#loadMorePhotos").prop("disabled", false).html("Charger plus");
    loadPhotos(); // Recharge les photos selon les nouveaux filtres
  }

  // Fonction pour charger les photos avec les filtres
  function loadPhotos() {
    $.ajax({
      url: natmota_js.ajax_url,
      type: "POST",
      data: {
        action: "load_more_photos",
        page: 1,
        security: natmota_js.nonce,
        format: selectedFormat,
        category: selectedCategory,
        sort: selectedSort,
      },
      success: function (response) {
        $(".photoContainer").html(
          response == 0 ? "<p>Aucune photo disponible.</p>" : response
        );
        $(".photoContainer").removeClass("updating-content"); // Retire la classe pour réafficher le contenu
      },
    });
  }

  // -----> Récupère les termes des taxonomies pour remplir les champs de tri <-----

  // Récupération des formats
  fetchTaxonomyTerms("format", "#formats", "Formats");

  // Récupération des catégories
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
    minimumResultsForSearch: Infinity, // Désactive la recherche
    dropdownAutoClose: "outsideClick", // Ferme au clic extérieur
  });

  // Gestion des événements d'ouverture et fermeture du Select2
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

  // Ferme Select2 si clic en dehors du conteneur
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".select2-container").length) {
      $(".js-example-basic-multiple").select2("close");
    }
  });
});
