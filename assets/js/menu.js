// =================================================================================================================
//                                                  burger menu 
// =================================================================================================================

// Sélectionne le bouton du menu burger et son icône, le menu burger lui-même et tous les liens
const burgerMenuButton = document.querySelector(".burgerMenu");
const burgerIcon = document.querySelector(".burgerIcon");
const crossIcon = document.querySelector(".crossIcon");
const burgerMenu = document.querySelector(".burger-menu");
const menuLinks = document.querySelectorAll(".burger-menu a");

// Fonction pour vérifier la taille de la fenêtre et retirer la classe "open" si la largeur dépasse 767px
function burgerMenuMobile() {
  function checkWindowSize() {
    if (window.innerWidth > 767) {
      burgerMenu.classList.remove("open");
      burgerIcon.classList.remove("hiddenNow");
      crossIcon.classList.add("hiddenNow");
      document.body.style.overflow = "auto";
    }
  }

  // Vérifie et observe la taille de la fenêtre
  checkWindowSize();
  window.addEventListener("resize", checkWindowSize);

  // Ajoute un événement de clic sur le bouton du menu burger
  burgerMenuButton.addEventListener("click", () => {
    burgerMenu.classList.toggle("open");
    const isOpen = burgerMenu.classList.contains("open");

    // Met à jour l'affichage des icônes
    if (isOpen) {
      burgerIcon.classList.add("hiddenNow");
      crossIcon.classList.remove("hiddenNow");
    } else {
      burgerIcon.classList.remove("hiddenNow");
      crossIcon.classList.add("hiddenNow");
    }

    // Désactive le défilement du corps de la page si le menu est ouvert
    document.body.style.overflow = isOpen ? "hidden" : "auto";
  });

  // Ajoute un événement de clic sur les liens du menu burger
  menuLinks.forEach((link) => {
    link.addEventListener("click", () => {
      burgerMenu.classList.remove("open");
      burgerIcon.classList.remove("hiddenNow");
      crossIcon.classList.add("hiddenNow");

      // Réactive le défilement du corps de la page à la fermeture du menu
      document.body.style.overflow = "auto";
    });
  });
}

burgerMenuMobile();
