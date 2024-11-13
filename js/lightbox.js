// =================================================================================================================
//                                                    La lightbox
// =================================================================================================================

// ----> Sélection de la croix de fermeture, de l'icône d'ouverture et de l'overlay de la lightbox <----
const lightboxClose = document.querySelector("#lightboxClose");
const lightboxOverlay = document.querySelector("#lightboxOverlay");
const openLightbox = document.querySelector(".photoCardLightbox"); // On va modifier cette partie

// Sélection des flèches de navigation
const arrowLightboxLeft = document.querySelector(".arrowLightboxLeft");
const arrowLightboxRight = document.querySelector(".arrowLightboxRight");

// Déclaration de currentIndex en dehors de la fonction pour la navigation
let currentIndex = 0;

// -----> Fonction pour gérer l'affichage de la lightbox <-----
function lightboxLoading() {
  const balisePhoto = document.querySelector("#lightboxImage");
  const lightboxCategory = document.querySelector(".lightboxCategory");
  const lightboxRef = document.querySelector(".lightboxRef");

  // Fonction pour charger une image en fonction de l'index
  function loadImageAtIndex(index) {
    const lightboxTargets = Array.from(
      document.querySelectorAll(".lightbox-target")
    );
    const photo = lightboxTargets[index];
    if (!photo) return; // Vérifie si l'image existe pour éviter les erreurs
    const fullSizeUrl = photo.dataset.fullsize;
    const category = photo.dataset.category;
    const reference = photo.dataset.reference;

    balisePhoto.src = fullSizeUrl;
    lightboxCategory.textContent = category;
    lightboxRef.textContent = reference;
    currentIndex = index; // Met à jour l'index actuel

    // Vérifie si l'overlay existe et supprime la classe "showNow"
    if (lightboxOverlay) {
      lightboxOverlay.classList.remove("showNow");
    }
  }

  // Utilise event delegation pour détecter les clics sur les éléments .photoCardLightbox
  document.addEventListener("click", (event) => {
    // On vérifie si le clic est sur l'élément .photoCardLightbox
    if (event.target.closest(".photoCardLightbox")) {
      // Trouve l'élément parent contenant les données de l'image
      const photo = event.target
        .closest(".homePhoto-item")
        .querySelector(".lightbox-target");
      if (photo) {
        const lightboxTargets = Array.from(
          document.querySelectorAll(".lightbox-target")
        );
        currentIndex = lightboxTargets.indexOf(photo);
        loadImageAtIndex(currentIndex);
      }
    }
  });

  // Navigation vers l'image précédente
  if (arrowLightboxLeft) {
    arrowLightboxLeft.addEventListener("click", (event) => {
      event.stopPropagation();
      const lightboxTargets = Array.from(
        document.querySelectorAll(".lightbox-target")
      );
      if (currentIndex > 0) {
        loadImageAtIndex(currentIndex - 1);
      } else {
        loadImageAtIndex(lightboxTargets.length - 1);
      }
    });
  }

  // Navigation vers l'image suivante
  if (arrowLightboxRight) {
    arrowLightboxRight.addEventListener("click", (event) => {
      event.stopPropagation();
      const lightboxTargets = Array.from(
        document.querySelectorAll(".lightbox-target")
      );
      if (currentIndex < lightboxTargets.length - 1) {
        loadImageAtIndex(currentIndex + 1);
      } else {
        loadImageAtIndex(0);
      }
    });
  }

  // Ajoute un écouteur de clic à lightboxOverlay pour fermer la lightbox
  if (lightboxOverlay) {
    lightboxClose.addEventListener("click", () => {
      lightboxOverlay.classList.add("showNow"); // Masque la lightbox
    });
  }
}

// Appelle la fonction une fois le DOM chargé
document.addEventListener("DOMContentLoaded", lightboxLoading);

// ------> Création de la carte photo <-----

// Fonction pour ajouter l'overlay à chaque photo après chargement
function addOverlayToPhotos() {
  // Sélectionne toutes les images avec la classe .lightbox-target
  const lightboxTargets = document.querySelectorAll(".lightbox-target");

  lightboxTargets.forEach((photo) => {
    // Vérifie si l'overlay existe déjà, sinon crée-le
    if (!photo.closest(".homePhoto-item").querySelector(".photoCard")) {
      // Crée l'overlay
      const overlay = document.createElement("div");
      overlay.classList.add("photoCard");

      // Utilise les URLs des icônes définies dans natmota_js
      const eyeIconPath = natmota_js.eye_icon;
      const squareIconPath = natmota_js.square_icon;

      // Récupère les data de l'image
      const pageUrl = photo.dataset.link;
      const category = photo.dataset.category;
      const reference = photo.dataset.reference;
      const fullSizeUrl = photo.dataset.fullsize;

      // Ajoute le contenu à l'overlay (icônes et texte dynamiques)
      overlay.innerHTML = `
        <div class="photoCardIcon">
          <a href="${pageUrl}" class="eyeIcon"><img src="${eyeIconPath}" alt="Icone oeil"></a>
        </div>
        <div class="photoCardLightbox">
          <!-- Retire le href et permet d'ouvrir l'image dans la lightbox -->
          <img src="${squareIconPath}" alt="Icone carré">
        </div>
        <div class="photoCardText">
          <p class="reference">${reference}</p>
          <p class="category">${category}</p>
        </div>
      `;

      // Ajoute l'overlay à l'élément parent de la photo
      const photoContainer = photo.closest(".homePhoto-item");
      photoContainer.appendChild(overlay);

      // Gère l'affichage de l'overlay au survol de la photo
      photoContainer.addEventListener("mouseenter", function () {
        overlay.style.display = "block"; // Affiche l'overlay
      });

      photoContainer.addEventListener("mouseleave", function () {
        overlay.style.display = "none"; // Masque l'overlay
      });
    }
  });
}

// Crée un MutationObserver pour écouter les ajouts d'éléments .lightbox-target
const observer = new MutationObserver(function (mutationsList) {
  mutationsList.forEach(function (mutation) {
    if (mutation.type === "childList") {
      addOverlayToPhotos(); // Relance la fonction si un changement est détecté
    }
  });
});

// Observer l'ajout de nouveaux éléments dans la section qui contient les photos
const config = { childList: true, subtree: true };
const photoContainer = document.querySelector(".photoContainer"); // Remplace .photoContainer par le bon parent
if (photoContainer) {
  observer.observe(photoContainer, config);
}

// Appel à la fonction pour ajouter l'overlay aux photos existantes
document.addEventListener("DOMContentLoaded", addOverlayToPhotos);
