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
   case "Français" : $tmp = "Französisch"; break;
   case "Anglais" : $tmp = "English"; break;
   case "Allemand" : $tmp = "Deutsch"; break;
   case "Espagnol" : $tmp = "Spanisch"; break;
   case "Chinois" : $tmp = "Chinesisch"; break;
   case "Clic droit sur l'image puis enregistrer l'image sous": $tmp = "Rechtsklick auf das Bild und speichern Sie das Bild"; break;
   case "Enregistrer sur votre bureau sans changer le nom du fichier qui est spécialement codifié": $tmp = "Speichern Sie auf Ihrem Desktop, ohne die Dateinamen zu ändern, die speziell codiert"; break;
   case "Le fichier doit être impérativement une image au format jpg": $tmp = "Die Datei hat ein Bild im jpg sein"; break;
   case "L'opération s'est bien passée": $tmp = "Die Operation verlief gut"; break;
   case "Maxi = largeur 900 pixels": $tmp = "Maximale Breite 900 Pixel"; break;
   case "Mini = largeur 400 pixels": $tmp = "Die Mindestbreite = 400 Pixel"; break;
   case "Normal = largeur 600 pixels": $tmp = "Normal = 600 Pixel Breite"; break;
   case "Outil de préparation image initialement au format jpg" : $tmp = "Bild Preparation Tool zunächst jpg"; break;
   case "Placer ensuite le curseur à l'endroit où vous voulez mettre la photo puis cliquer sur l'icone téléchargement": $tmp = "Dann setzen Sie den Cursor in dem Sie das Foto setzen möchten und klicken Sie auf das Download-Symbol"; break;
   case "Redimensionner": $tmp = "Die Größe"; break;
   case "Retournez sur la page de saisie de votre publication": $tmp = "Schalten Sie die Einstiegsseite Ihrer Publikation"; break;
   case "Sélectionner sur votre ordinateur le fichier image .jpg à redimensionner": $tmp = "Wählen Sie Ihren Computer .jpg-Bilddatei , um die Größe"; break;
   case "une fenêtre s'ouvrira où vous sélectionnerez le fichier photo préparée puis cliquez sur le bouton joindre": $tmp = "öffnet sich ein Fenster, wo Sie die vorbereitete Fotodatei auswählen und die Verknüpfung klicken"; break;
   default: $tmp = "Es gibt keine Übersetzung [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>