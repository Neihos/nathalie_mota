// =================================================================================================================
//                                                    Global Javascript
// =================================================================================================================
 // Ajouter une span dans le menu header et footer pour éviter de perdre en SEO pour des balise "a" vide

 function ajouterElementDansMenu(menuId, liId, liClasses, spanText) {
   // Sélectionne l'élément ul avec l'ID donné
   const menu = document.getElementById(menuId);

   if (!menu) {
     console.error(`L'élément avec l'ID '${menuId}' est introuvable.`);
     return;
   }

   // Crée un nouvel élément <li>
   const liElement = document.createElement("li");

   // Ajoute l'ID au <li>
   liElement.id = liId;

   // Ajoute les classes au <li>
   liElement.className = liClasses;

   // Crée un élément <span>
   const spanElement = document.createElement("span");

   // Insère le texte dans <span>
   spanElement.textContent = spanText;

   // Ajoute le <span> à l'intérieur du <li>
   liElement.appendChild(spanElement);

   // Ajoute le <li> au menu (dans l'ul)
   menu.appendChild(liElement);
 }

 // Appeler la fonction pour le menu-footer
 ajouterElementDansMenu(
   "menu-footer", // ID du menu
   "menu-item-1984", // ID du <li>
   "menu-item", // Classes du <li>
   "Tous droits réservés" // Texte du <span>
 );

 // Appeler la fonction pour le menu-principale
 ajouterElementDansMenu(
   "menu-header", // ID du menu
   "menu-item-2102", // ID du <li>
   "menu-item", // Classes du <li>
   "Contact" // Texte du <span>
 );

  // Appeler la fonction pour le burger menu
 ajouterElementDansMenu(
   "menu-header-1", // ID du menu
   "menu-item-0221", // ID du <li>
   "menu-item", // Classes du <li>
   "Contact" // Texte du <span>
 );