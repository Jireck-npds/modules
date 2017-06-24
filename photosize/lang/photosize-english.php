<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/*                                                                      */
/* NPDS Copyright (c) 2002-2017 by Philippe Brunier                     */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* module photosize version 2.2                                         */
/* photosize.php file 2009/2017                                         */
/* version rev16 jpb et phr                                             */
/*                                                                      */
/************************************************************************/

function phot_translate($phrase) {
 switch ($phrase) {
   case "Français" : $tmp = "French"; break;
   case "Anglais" : $tmp = "English"; break;
   case "Allemand" : $tmp = "German"; break;
   case "Espagnol" : $tmp = "Spanish"; break;
   case "Chinois" : $tmp = "Chinese"; break;
   case "Clic droit sur l'image puis enregistrer l'image sous": $tmp = "Right-click the image and save the image as"; break;
   case "Enregistrer sur votre bureau sans changer le nom du fichier qui est spécialement codifié": $tmp = "Save to your desktop without changing the name of the file that is specially coded"; break;
   case "Le fichier doit être impérativement une image au format jpg": $tmp = "The file must be an image in jpg format"; break;
   case "L'opération s'est bien passée": $tmp = "The operation went well"; break;
   case "Maxi = largeur 900 pixels": $tmp = "Maxi = width 900 pixels"; break;
   case "Mini = largeur 400 pixels": $tmp = "Mini = width 400 pixels"; break;
   case "Normal = largeur 600 pixels": $tmp = "Normal = width 600 pixels"; break;
   case "Outil de préparation image initialement au format jpg" : $tmp = "Image preparation tool originally in jpg format"; break;
   case "Placer ensuite le curseur à l'endroit où vous voulez mettre la photo puis cliquer sur l'icone téléchargement": $tmp = "Then place the cursor where you want to put the photo and then click on the download icon"; break;
   case "Redimensionner": $tmp = "Resize"; break;
   case "Retournez sur la page de saisie de votre publication": $tmp = "Return to your ad entry page"; break;
   case "Sélectionner sur votre ordinateur le fichier image .jpg à redimensionner": $tmp = "Select the .jpg image file to be resized on your computer"; break;
   case "une fenêtre s'ouvrira où vous sélectionnerez le fichier photo préparée puis cliquez sur le bouton joindre": $tmp = "a window will open where you will select the prepared photo file then click on the button join"; break;
   default: $tmp = "Translation error [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>