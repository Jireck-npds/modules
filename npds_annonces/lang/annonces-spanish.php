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
   case "Admin P.A" : $tmp = "Administración"; break;
   case "Administration des catégories et sous-catégories" : $tmp = "Administración de categorías y subcategorías"; break;
   case "Ajouter ou modifier une catégorie": $tmp = "Añadir o editar una categoría"; break;
   case "Ajouter une annonce" : $tmp = "Agregar anuncio"; break;
   case "Ajouter une catégorie" : $tmp = "Añadir categoría"; break;
   case "Ajouter une sous-catégorie dans" : $tmp = "Añadir subcategoría"; break;
   case "Annonce de" : $tmp = "Anuncio"; break;
   case "Annonce" : $tmp = "Anuncio"; break;
   case "annonce(s) à valider" : $tmp = "anuncio (s) para validar"; break;
   case "annonce(s) en ligne" : $tmp = "anuncio en línea"; break;
   case "annonce(s)" : $tmp = "anuncio(s)"; break;
   case "Annonces à valider" : $tmp = "Próximos anuncios"; break;
   case "Annonces archivées" : $tmp = "Anuncios archivados"; break;
   case "Annonces en ligne" : $tmp = "Los anuncios en línea"; break;
   case "Annonces(s)" : $tmp = "Anuncios"; break;
   case "Arborescense en ligne" : $tmp = "Una estructura de árbol en línea"; break;
   case "Autres" : $tmp = "Otro"; break;
   case "Catégorie" : $tmp = "Categoría"; break;
   case "Clic droit sur l'image puis enregistrer l'image sous": $tmp = "Haga clic derecho sobre la imagen y guardar la imagen"; break;
   case "Cliquer pour administrer": $tmp = "Haga clic para administrar"; break; 
   case "Cliquer pour déplier" : $tmp = "Haga clic para desplegar"; break;
   case "Cliquer pour visualiser" : $tmp = "Haga clic para ver"; break;
   case "Code postal" : $tmp = "Código postal"; break;
   case "Email" : $tmp = "Correo electrónico"; break;
   case "en attente de validation" : $tmp = "en espera de validación"; break;
   case "En ligne" : $tmp = "En línea"; break;
   case "Enregistrer sur votre bureau sans changer le nom du fichier qui est spécialement codifié": $tmp = "Guardar en su escritorio sin necesidad de cambiar el nombre del archivo que está especialmente codificado"; break;
   case "et" : $tmp = "y"; break;
   case "Fermer" : $tmp = "Cerrar"; break;
   case "Gérer P.A" : $tmp = "Manejo de anuncio"; break;
   case "Gestion de vos annonces" : $tmp = "Administración de los anuncios"; break;
   case "Il y a" : $tmp = "Hay"; break;
   case "Instructions": $tmp = "Instrucciones"; break;
   case "Le fichier doit être impérativement une image au format jpg": $tmp = "El archivo tiene que ser una imagen en formato jpg"; break;
   case "Libellé de l'annonce" : $tmp = "Anuncio etiqueta"; break;
   case "L'opération s'est bien passée": $tmp = "La operación salió bien"; break;
   case "Maxi = largeur 900 pixels": $tmp = "Max = ancho 900 píxeles"; break;
   case "Mentions légales des conditions d'utilisation des petites annonces" : $tmp = "Términos legales de uso de los anuncios"; break;
   case "Mentions légales" : $tmp = "Notas legales"; break;
   case "Mini = largeur 400 pixels": $tmp = "Anchura mínima = 400 pixeles"; break;
   case "Mode d'emploi" : $tmp = "Modo de empleo"; break;
   case "Modifier" : $tmp = "Cambio"; break;
   case "Nom" : $tmp = "Appellido"; break;
   case "Normal = largeur 600 pixels": $tmp = "anchura normal = 600 pixeles"; break;
   case "Outil de préparation image initialement au format jpg" : $tmp = "Herramienta de preparación imagen jpg inicialmente"; break;
   case "Outil" : $tmp = "Herramienta"; break;
   case "P.A en ligne": $tmp = "Pequeño publicidad online"; break;
   case "Passer P.A" : $tmp = "Saltar anuncio"; break;
   case "Placer ensuite le curseur à l'endroit où vous voulez mettre la photo puis cliquer sur l'icone téléchargement": $tmp = "A continuación, coloque el cursor donde desea poner la foto y haga clic en el icono de descarga"; break;
   case "Pour passer ou gérer vos annonces vous devez être membre inscrit connecté" : $tmp = "Para cambiar o administrar sus anuncios debe estar registrado logged"; break;
   case "Pour préparer une image" : $tmp = "Para preparar una imagen"; break;
   case "Précédente" : $tmp = "Anterior"; break;
   case "Prix en" : $tmp = "Precio"; break;
   case "Prix" : $tmp = "Precio"; break;
   case "publiée(s)" : $tmp = "publicado"; break;
   case "Rechercher dans les annonces" : $tmp = "Anuncios de búsqueda"; break;
   case "Redimensionner": $tmp = "Cambiar el tamaño"; break;
   case "Retour P.A": $tmp = "Volver anuncio"; break;
   case "Retour" : $tmp = "Regreso"; break;
   case "Retournez sur la page de saisie de votre annonce": $tmp = "A su vez en la página de inscripción ad"; break;
   case "sans" : $tmp = "sin"; break;
   case "Sélectionner sur votre ordinateur le fichier image .jpg à redimensionner": $tmp = "Seleccione el archivo de imagen .jpg computadora para cambiar el tamaño"; break;
   case "Soumettre" : $tmp = "Enviar"; break;
   case "Sous-catégorie" : $tmp = "Subcategoría"; break;
   case "Suivante" : $tmp = "Siguiente, próximo"; break;
   case "Supprimer" : $tmp = "Quitar"; break;
   case "Tél fixe" : $tmp = "Teléfono fijo"; break;
   case "Tél portable" : $tmp = "Teléfono móvil"; break;
   case "une fenêtre s'ouvrira où vous sélectionnerez le fichier photo préparée puis cliquez sur le bouton joindre": $tmp = "se abrirá una ventana donde se selecciona el archivo de fotografía preparado y haga clic en el botón de unirse"; break;
   case "Valider" : $tmp = "Validar"; break;
   case "Ville" : $tmp = "Ciudad"; break;
   case "vous avez" : $tmp = "usted tiene que"; break;
  
   default: $tmp = "Necesita una traducción [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>