// =================================================================================================================
//                                                    La lightbox
// =================================================================================================================

//  ---->  Sélection de la croix de fermeture et de l'overlay de la lightbox  <----
const lightboxClose = document.querySelector("#lightboxClose");
const lightboxOverlay = document.querySelector("#lightboxOverlay");

// Sélectionne toutes les images lightbox-target pour en faire un tableau
const lightboxTargets = Array.from(
  document.querySelectorAll(".lightbox-target")
);

// -----> Fonction pour gérer l'affichage de la lightbox <-----
function lightboxLoading() {
  const balisePhoto = document.querySelector("#lightboxImage");
  const lightboxCategory = document.querySelector(".lightboxCategory");
  const lightboxRef = document.querySelector(".lightboxRef");

  // Utilise l'event delegation pour détecter les clics sur les éléments .lightbox-target
  document.addEventListener("click", (event) => {
    if (event.target.classList.contains("lightbox-target")) {
      const photo = event.target;

      // Récupère les attributs data avec dataset
      const fullSizeUrl = photo.dataset.fullsize;
      const category = photo.dataset.category;
      const reference = photo.dataset.reference;

      balisePhoto.src = fullSizeUrl;
      lightboxCategory.textContent = category;
      lightboxRef.textContent = reference;

      // Vérifie si l'overlay existe et supprime la classe "showNow"
      if (lightboxOverlay) {
        lightboxOverlay.classList.remove("showNow");
      }
    }
  });

  // Ajoute un écouteur de clic à lightboxOverlay pour la fermer en cliquant sur la croix
  if (lightboxOverlay) {
    lightboxClose.addEventListener("click", () => {
      lightboxOverlay.classList.add("showNow"); // Masque la lightbox
    });
  }
}

// Appelle la fonction une fois le DOM chargé
document.addEventListener("DOMContentLoaded", lightboxLoading);