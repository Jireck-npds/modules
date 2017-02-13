<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/* ===========================                                          */
/*                                                                      */
/* monmodule : moi 2016                                                 */
/*                                                                      */
/* NPDS Copyright (c) 2002-2017 by Philippe Brunier                     */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

function ann_translate($phrase) {
 switch ($phrase) {
   case "Français" : $tmp = "Francés"; break;
   case "Anglais" : $tmp = "Inglés"; break;
   case "Allemand" : $tmp = "Alemán"; break;
   case "Espagnol" : $tmp = "Española"; break;
   case "Chinois" : $tmp = "Chino"; break;

   case "à" : $tmp = "to"; break;
   case "Admin P.A" : $tmp = "Admin"; break;
   case "Administration des catégories et sous-catégories" : $tmp = "Admin categories and subcategories"; break;
   case "Ajouter ou modifier une catégorie": $tmp = "Add or edit a category"; break;
   case "Ajouter une annonce" : $tmp = "Add offer"; break;
   case "Ajouter une catégorie" : $tmp = "Add category"; break;
   case "Ajouter une sous-catégorie dans" : $tmp = "Add in sub-category"; break;
   case "Annonce de" : $tmp = "Offer by"; break;
   case "Annonce" : $tmp = "Offer"; break;
   case "annonce(s) à valider" : $tmp = "offer(s) to validate"; break;
   case "annonce(s) en ligne" : $tmp = "valid offer(s)"; break;
   case "annonce(s)" : $tmp = "offer(s)"; break;
   case "Annonces à valider" : $tmp = "Offers to validate"; break;
   case "Annonces archivées" : $tmp = "Offers off"; break;
   case "Annonces en ligne" : $tmp = "Offers on line"; break;
   case "Annonces(s)" : $tmp = "Offer(s)"; break;
   case "Arborescense en ligne" : $tmp = "Online Tree"; break;
   case "Autres" : $tmp = "Other"; break;
   case "Catégorie" : $tmp = "Category"; break;
   case "Clic droit sur l'image puis enregistrer l'image sous": $tmp = "Right-click the image and save the image as"; break;
   case "Cliquer pour administrer": $tmp = "Click to admin"; break; 
   case "Cliquer pour déplier" : $tmp = "Click to expand"; break;
   case "Cliquer pour visualiser" : $tmp = "Click to view"; break;
   case "Code postal" : $tmp = "Postal code"; break;
   case "Email" : $tmp = "Email"; break;
   case "en attente de validation" : $tmp = "waiting for validation"; break;
   case "En ligne" : $tmp = "On line"; break;
   case "Enregistrer sur votre bureau sans changer le nom du fichier qui est spécialement codifié": $tmp = "Save to your desktop without changing the name of the file that is specially coded"; break;
   case "et" : $tmp = "and"; break;
   case "Fermer" : $tmp = "Closed"; break;
   case "Gérer P.A" : $tmp = "Manage offer"; break;
   case "Gestion de vos annonces" : $tmp = "Manage your(s) offer(s)"; break;
   case "Il y a" : $tmp = "There are"; break;
   case "Instructions": $tmp = "Instructions"; break;
   case "Le fichier doit être impérativement une image au format jpg": $tmp = "The file must be an image in jpg format"; break;
   case "Libellé de l'annonce" : $tmp = "Ad text"; break;
   case "L'opération s'est bien passée": $tmp = "The operation went well"; break;
   case "Maxi = largeur 900 pixels": $tmp = "Maxi = width 900 pixels"; break;
   case "Mentions légales des conditions d'utilisation des petites annonces" : $tmp = "Terms of use of classified ads"; break;
   case "Mentions légales" : $tmp = "Legal Notice"; break;
   case "Mini = largeur 400 pixels": $tmp = "Mini = width 400 pixels"; break;
   case "Mode d'emploi" : $tmp = "Manuel"; break;
   case "Modifier" : $tmp = "Edit"; break;
   case "Nom" : $tmp = "Name"; break;
   case "Normal = largeur 600 pixels": $tmp = "Normal = width 600 pixels"; break;
   case "Outil de préparation image initialement au format jpg" : $tmp = "Image preparation tool originally in jpg format"; break;
   case "Outil" : $tmp = "Tool"; break;
   case "P.A en ligne": $tmp = "Offers on line"; break;
   case "Passer P.A" : $tmp = "Ad offer"; break;
   case "Placer ensuite le curseur à l'endroit où vous voulez mettre la photo puis cliquer sur l'icone téléchargement": $tmp = "Then place the cursor where you want to put the photo and then click on the download icon"; break;
   case "Pour passer ou gérer vos annonces vous devez être membre inscrit connecté" : $tmp = "To place or manage your ads you must be a registered member"; break;
   case "Pour préparer une image" : $tmp = "To prepare image"; break;
   case "Précédente" : $tmp = "Previous"; break;
   case "Prix en" : $tmp = "Price in"; break;
   case "Prix" : $tmp = "Price"; break;
   case "publiée(s)" : $tmp = "published"; break;
   case "Rechercher dans les annonces" : $tmp = "Search ads"; break;
   case "Redimensionner": $tmp = "Resize"; break;
   case "Retour P.A": $tmp = "Return Offer"; break;
   case "Retour" : $tmp = "Home"; break;
   case "Retournez sur la page de saisie de votre annonce": $tmp = "Return to your ad entry page"; break;
   case "sans" : $tmp = "without"; break;
   case "Sélectionner sur votre ordinateur le fichier image .jpg à redimensionner": $tmp = "Select the .jpg image file to be resized on your computer"; break;
   case "Soumettre" : $tmp = "Submit"; break;
   case "Sous-catégorie" : $tmp = "Sub-category"; break;
   case "Suivante" : $tmp = "Next"; break;
   case "Supprimer" : $tmp = "Del"; break;
   case "Tél fixe" : $tmp = "Fixed phone"; break;
   case "Tél portable" : $tmp = "Cellular"; break;
   case "une fenêtre s'ouvrira où vous sélectionnerez le fichier photo préparée puis cliquez sur le bouton joindre": $tmp = "a window will open where you will select the prepared photo file then click on the button join"; break;
   case "Valider" : $tmp = "Valid"; break;
   case "Ville" : $tmp = "City"; break;
   case "vous avez" : $tmp = "you have"; break;
  
   default: $tmp = "Necesita una traducción [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>