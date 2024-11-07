  // =================================================================================================================
  //                                                    La modale
  // =================================================================================================================

//  ---->  Sélection des boutons de contact et de l'overlay de la popup  <----
const contactButtons = [
  document.getElementById("menu-item-19"),
  document.querySelector(".contactPhoto"),
];
const popupOverlay = document.querySelector(".popup-overlay");

//  ----->  Fonction pour gérer l'affichage de la modale  <-----
function modalLoading() {
  contactButtons.forEach((contactButton) => {
    if (contactButton) {
      // Ajoute un écouteur de clic pour afficher la popup
      contactButton.addEventListener("click", () => {
        if (popupOverlay) {
          popupOverlay.classList.remove("hiddenPopup");
        }
      });
    }
  });

  // Ajoute un écouteur de clic à l'overlay pour le fermer en cliquant à l'extérieur du contenu
  if (popupOverlay) {
    popupOverlay.addEventListener("click", (event) => {
      // Vérifie si le clic a eu lieu sur l'overlay (et non à l'intérieur du contenu)
      if (event.target === popupOverlay) {
        popupOverlay.classList.add("hiddenPopup"); // Masque la popup
      }
    });
  }
}

// Appelle la fonction une fois le DOM chargé
document.addEventListener("DOMContentLoaded", modalLoading);


// Démarrage de jQuery
jQuery(document).ready(function ($) {

//  ----->  Récupérer la référence des photos pour la modale  <-----
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
  });

