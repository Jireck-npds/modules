<?php
/************************************************************************/
/* Module de gestion de galeries pour NPDS                              */
/* ===========================                                          */
/*                                                                      */
/* TD-Galerie Language File Copyright (c) 2004-2005 by Tribal-Dolphin   */
/*                                                                      */
/************************************************************************/

function adm_gal_trans($phrase) {
    switch ($phrase) {
       case "Administration des galeries": $tmp = "Administration of the galeries"; break;
       case "Accueil": $tmp = "Home"; break;
       case "Ajouter une cat�gorie": $tmp = "Add a category"; break;
       case "Ajouter une sous-cat�gorie": $tmp = "Add a subcategory"; break;
       case "Ajouter des images": $tmp = "Add pictures"; break;
       case "Ajouter une galerie": $tmp = "Add a gallery"; break;
       case "Voir l'arborescence": $tmp = "See the tree structure"; break;
       case "Configuration": $tmp = "Setup"; break;
       case "Nombre de cat�gories :": $tmp = "Number of categories:"; break;
       case "Nombre de sous-cat�gories :": $tmp = "Number of subcategories:"; break;
       case "Nombre d'images :": $tmp = "Number of images:"; break;
       case "Nombre de galeries :": $tmp = "Number of galleries:"; break;
       case "Informations": $tmp = "Informations"; break;
       case "Aucune cat�gorie trouv�e": $tmp = "No category found"; break;
       case "Aucune sous-cat�gorie trouv�e": $tmp = "No subcategory found"; break;
       case "Aucune galerie trouv�e": $tmp = "No gallery found"; break;
       case "Nom de la cat�gorie :": $tmp = "Name of the category:"; break;
       case "Nom de la sous-cat�gorie :": $tmp = "Name of the subcategory:"; break;
       case "Nom de la galerie :": $tmp = "Name of the gallery:"; break;
       case "Ajouter": $tmp = "Add"; break;
       case "Valider": $tmp = "Submit"; break;
       case "Cette cat�gorie existe d�j�": $tmp = "This category already exists"; break;
       case "Erreur lors de l'ajout de la cat�gorie": $tmp = "Error during the addition of the category"; break;
       case "Administrateurs": $tmp = "Admins only"; break;
       case "Acc�s pour :": $tmp = "Access for"; break;
       case "Cat�gorie parente :": $tmp = "Parent category:"; break;
       case "Cette sous-cat�gorie existe d�j�": $tmp = "This subcategory already exists"; break;
       case "Cette galerie existe d�j�": $tmp = "This gallery already exists"; break;
       case "Erreur lors de l'ajout de la sous-cat�gorie": $tmp = "Error during the addition of the subcategory"; break;
       case "Erreur lors de l'ajout de la galerie": $tmp = "Error during the addition of the gallery"; break;
       case "Cat�gorie :": $tmp = "Category:"; break;
       case "Sous-cat�gorie": $tmp = "Subcategory"; break;
       case "Galerie": $tmp = "Gallery"; break;
       case "Galerie :": $tmp = "Gallery:"; break;
       case "Image :": $tmp = "Picture:"; break;
       case "Description :": $tmp = "Description:"; break;
       case "Ce fichier n'est pas un fichier jpg ou gif": $tmp = "This file is not a jpg or gif file"; break;
       case "Image ajout�e avec succ�s": $tmp = "Image added successfully"; break;
       case "Impossible d'ajouter l'image en BDD": $tmp = "Impossible to add the image in DB"; break;
       case "Dimension maximale de l'image en pixels :": $tmp = "Maximal dimension of the picture in pixels:"; break;
       case "Dimension maximale de la miniature en pixels :": $tmp = "Maximal dimension of the miniature in pixels:"; break;
       case "Dimension maximale de l'image incorrecte": $tmp = "Incorrect maximal picture dimension"; break;
       case "Dimension maximale de la miniature incorrecte": $tmp = "Incorrect maximal miniature dimension"; break;
       case "Nombre d'images par ligne :": $tmp = "Images per line:"; break;
       case "Nombre d'images par page :": $tmp = "Images per page:"; break;
       case "Choisissez": $tmp = "Choose"; break;
       case "Les anonymes peuvent voter ?": $tmp = "Anonymous can rate ?"; break;
       case "Les anonymes peuvent poster un commentaire ?": $tmp = "Anonymous can comments ?"; break;
       case "Les anonymes peuvent envoyer des E-Cartes ?": $tmp = "Anonymous can send ECards ?"; break;
       case "Nombre de commentaires :": $tmp = "Number of comments"; break;
       case "Nombre de votes :": $tmp = "Number of rating"; break;
       case "Afficher des photos al�atoires ?": $tmp = "View random images?"; break;
       case "Afficher les derniers ajouts ?": $tmp = "View last added images?";break;
       case "Vous allez supprimer la cat�gorie": $tmp = "You go to delete the category"; break;
       case "Vous allez supprimer la sous-cat�gorie": $tmp = "You go to delete the subcategory"; break;
       case "Vous allez supprimer la galerie": $tmp = "You go to delete the gallery"; break;
       case "Vous allez supprimer une image": $tmp = "You go to delete the picture"; break;
       case "Confirmer": $tmp = "Confirm"; break;
       case "Annuler": $tmp = "Cancel"; break;
       case "Miniature supprim�e": $tmp = "Thumb deleted"; break;
       case "Miniature non supprim�e": $tmp = "Thumb not deleted"; break;
       case "Image supprim�e": $tmp = "Picture deleted"; break;
       case "Image non supprim�e": $tmp = "Picture not deleted"; break;
       case "Enregistrement supprim�": $tmp = "Record deleted"; break;
       case "Enregistrement non supprim�": $tmp = "Record not deleted"; break;
       case "Galerie supprim�e": $tmp = "Gallery deleted"; break;
       case "Galerie non supprim�e": $tmp = "Gallery not deleted"; break;
       case "Sous-cat�gorie supprim�e": $tmp = "Subcategory deleted"; break;
       case "Sous-cat�gorie non supprim�e": $tmp = "Subcategory not deleted"; break;
       case "Cat�gorie supprim�e": $tmp = "Category deleted"; break;
       case "Cat�gorie non supprim�e": $tmp = "Category not deleted"; break;
       case "Votes supprim�s": $tmp = "Rating deleted"; break;
       case "Votes non supprim�s": $tmp = "Rating not deleted"; break;
       case "Commentaires supprim�s": $tmp = "Comments deleted"; break;
       case "Commentaires non supprim�s": $tmp = "Comments not deleted"; break;
       case "Effacer": $tmp = "Delete"; break;
       case "Modifier": $tmp = "Modify"; break;
       case "Nom actuel :": $tmp = "Current name:"; break;
       case "Nouveau nom :": $tmp = "New name:"; break;
       case "Images vues :": $tmp = "Viewed images:"; break;
       case "Afficher les votes ?": $tmp = "Show ratings?"; break;
       case "Afficher les commentaires ?": $tmp = "Show comments?"; break;
       case "Galerie temporaire": $tmp = "Temporary' gallery"; break;
       case "Importer des images": $tmp = "Import pictures"; break;
       case "MAJ ordre": $tmp = "Update order"; break;
       case "Importer": $tmp = "Import"; break;
       case "Nombre d'images � afficher dans le top commentaires": $tmp = "Number of pictures to display in top comment"; break;
       case "Nombre d'images � afficher dans le top votes": $tmp = "Number of pictures to display in top vote"; break;
       case "Notifier par email l'administrateur de la proposition de photos ?": $tmp = "Email notify the administrator of the proposal photos ?"; break;
       case "Exporter une cat�gorie": $tmp = "Export one category"; break;
       case "Exporter": $tmp = "Export"; break;

       default: $tmp = "Translation error <b>[** $phrase **]</b>"; break;
    }
    return $tmp;
}
?>