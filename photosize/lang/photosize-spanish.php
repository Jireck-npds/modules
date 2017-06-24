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
   case "Français" : $tmp = "Francés"; break;
   case "Anglais" : $tmp = "Inglés"; break;
   case "Allemand" : $tmp = "Alemán"; break;
   case "Espagnol" : $tmp = "Española"; break;
   case "Chinois" : $tmp = "Chino"; break;
   case "Clic droit sur l'image puis enregistrer l'image sous": $tmp = "Haga clic derecho sobre la imagen y guardar la imagen"; break;
   case "Enregistrer sur votre bureau sans changer le nom du fichier qui est spécialement codifié": $tmp = "Guardar en su escritorio sin necesidad de cambiar el nombre del archivo que está especialmente codificado"; break;
   case "Le fichier doit être impérativement une image au format jpg": $tmp = "El archivo tiene que ser una imagen en formato jpg"; break;
   case "L'opération s'est bien passée": $tmp = "La operación salió bien"; break;
   case "Maxi = largeur 900 pixels": $tmp = "Ancho máximo 900 píxeles"; break;
   case "Mini = largeur 400 pixels": $tmp = "Anchura mínima = 400 pixeles"; break;
   case "Normal = largeur 600 pixels": $tmp = "Anchura normal = 600 pixeles"; break;
   case "Outil de préparation image initialement au format jpg" : $tmp = "Herramienta de preparación imagen jpg inicialmente"; break;
   case "Placer ensuite le curseur à l'endroit où vous voulez mettre la photo puis cliquer sur l'icone téléchargement": $tmp = "A continuación, coloque el cursor donde desea poner la foto y haga clic en el icono de descarga"; break;
   case "Redimensionner": $tmp = "Cambiar el tamaño"; break;
   case "Retournez sur la page de saisie de votre publication": $tmp = "A su vez en la página de entrada de su publicación"; break;
   case "Sélectionner sur votre ordinateur le fichier image .jpg à redimensionner": $tmp = "Seleccione el archivo de imagen .jpg computadora para cambiar el tamaño"; break;
   case "une fenêtre s'ouvrira où vous sélectionnerez le fichier photo préparée puis cliquez sur le bouton joindre": $tmp = "se abrirá una ventana donde se selecciona el archivo de fotografía preparado y haga clic en el botón de unirse"; break; 
   default: $tmp = "Necesita una traducción [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>