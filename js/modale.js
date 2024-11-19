// =================================================================================================================
//                                                    La modale
// =================================================================================================================

//  ---->  Sélection des boutons de contact et de l'overlay de la popup  <----
document.addEventListener("DOMContentLoaded", function () {
  const contactButtons = [
    document.getElementById("menu-item-2102"),
    document.getElementById("menu-item-0221"),
    document.querySelector(".contactPhoto"),
  ];
  const popupOverlay = document.querySelector(".popup-overlay");

  function handlePopup() {
    // Ajoute des écouteurs aux boutons de contact pour afficher la popup
    contactButtons.forEach((contactButton) => {
      if (contactButton) {
        contactButton.addEventListener("click", () => {
          if (popupOverlay) {
            popupOverlay.classList.remove("hiddenPopup");
          }
        });
      }
    });

    // Ajoute un écouteur pour fermer la popup en cliquant sur l'overlay
    if (popupOverlay) {
      popupOverlay.addEventListener("click", (event) => {
        if (event.target === popupOverlay) {
          popupOverlay.classList.add("hiddenPopup");
        }
      });
    }
  }

  handlePopup();

  //  ----->  Gestion de la Référence Photo  <-----

  const ref = document.querySelector(".reference");

  if (document.body.classList.contains("single-photo")) {
    function handleReference() {
      if (ref) {
        const referenceText = ref.textContent.trim();
        const referenceValue = referenceText.replace("Référence : ", "").trim();
        const menuRefPhoto = document.getElementById("menu-ref-photo");
        if (menuRefPhoto) {
          menuRefPhoto.value = referenceValue;
        }
      }
    }

    handleReference();
  }
});

