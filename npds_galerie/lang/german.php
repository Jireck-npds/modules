<?php
/************************************************************************/
/* NPDS : Net Portal Dynamic System                                     */
/* ===========================                                          */
/*                                                                      */
/* TD-Galerie Language File Copyright (c) 2004-2005 by Tribal-Dolphin   */
/*                                                                      */
/************************************************************************/

function gal_trans($phrase) {
    switch ($phrase) {
       case "Catégories": $tmp = "Categories"; break;
       case "Galeries": $tmp = "Galeries"; break;
       case "Aucune catégorie trouvée": $tmp = "No category found "; break;
       case "Créée le": $tmp = "Created on"; break;
       case "Accueil": $tmp = "Home"; break; //ok
       case "Aucune galerie trouvée": $tmp = "No galery found "; break;
       case "Aucune image trouvée": $tmp = "No picture found "; break;       
       case "affichage(s)": $tmp = "view(s)"; break;
       case "commentaire(s)": $tmp = "comment(s)"; break;       
       case "Informations sur l'image": $tmp = "File information"; break;
       
       
       case "Taille du fichier": $tmp = "File Size"; break;
       case "Dimensions": $tmp = "Dimensions"; break;
       case "Affichées": $tmp = "Displayed"; break;
       case "fois": $tmp = "times"; break;
       case "Ajoutez votre commentaire": $tmp = "Add your comment"; break;
       case "Commentaire": $tmp = "Comment"; break;
       case "Noter cette image": $tmp = "Rate this file"; break;
       case "Note ": $tmp = "Rating "; break;
       case "vote(s)": $tmp = "vote(s)"; break;
       case "Erreur": $tmp = "Error"; break;
       case "Vous avez déjà noté cette photo": $tmp = "Sorry but you have already rated this file"; break;
       case "Vous avez déjà commenté cette photo": $tmp = "Sorry but you have already commented this file"; break;
       case "Envoyer comme e-carte": $tmp = "Send an e-card"; break;
       case "De la part de": $tmp = "From"; break;
       case "Votre nom": $tmp = "Your name"; break;
       case "Votre adresse e-mail": $tmp = "Your email address"; break;
       case "A": $tmp = "To"; break;
       case "Nom du destinataire": $tmp = "Recipient name"; break;
       case "Adresse e-mail du destinataire": $tmp = "Recipient email address"; break;
       case "Sujet": $tmp = "Subject"; break;
       case "Message": $tmp = "Message"; break;
       case "Si votre e-carte ne s'affiche pas correctement, cliquez ici": $tmp = "If the e-card does not display correctly, click this link"; break;
       case "Résultat": $tmp = "Result"; break;
       case "Votre E-carte n'à pas été envoyée": $tmp = "Your Ecard wasn't sent."; break;
       case "Votre E-carte à été envoyée": $tmp = "Ecard was sent successfully"; break;
       case "Votre adresse mail est incorrecte.": $tmp = "Your address mail is incorrect."; break;
       case "Le nom du destinataire ne peut être vide.": $tmp = "Recipient name cannot be empty."; break;
       case "L'adresse mail du destinataire est incorrecte.": $tmp = "The mail address of recipient is incorrect."; break;
       case "Le sujet ne peut être vide.": $tmp = "Subject cannot be empty."; break;
       case "Le message ne peut être vide.": $tmp = "Message cannot be empty."; break;
       case "Une e-carte pour vous": $tmp = "An e-card for you"; break;
       case "Photos aléatoires": $tmp = "Random files"; break;
       case "Derniers ajouts": $tmp = "Last additions"; break;
       case "Suspendre le Diaporama": $tmp = "Stop Slideshow"; break;
       case "Diaporama": $tmp = "Slideshow"; break;
       case "E-carte": $tmp = "E-card"; break;
       case "Nombre d'images": $tmp = "Number of pictures"; break;
       case "Nombre de commentaires": $tmp = "Number of comments"; break; 
       case "Nombre de notes": $tmp = "Number of notes"; break; 
       case "Top-Commentaires": $tmp = "Top-Comments"; break;
       case "Top-Votes": $tmp = "Top-Vote"; break;
       case "Proposer des images": $tmp = "Propose some pictures"; break;
       case "Top": $tmp = "Top"; break;
       case "IMAGES": $tmp = "PICTURES"; break;
       case "des images les plus commentées": $tmp = "of most commented pictures"; break;
       case "des images les plus notées": $tmp = "of most noted pictures"; break;
       case "Ajouter": $tmp = "Add"; break;
       case "Envoyer": $tmp = "Send"; break;
       case "Vous n'avez accés à aucune galerie": $tmp = "You do not have access to any galery"; break;
       case "Proposer des images": $tmp = "To propose pictures"; break;
       case "Photo envoyée avec succés, elle sera traitée par le webmaster": $tmp = "Photo sent successfully, it will be treated by the webmaster"; break;
       case " proposé par ": $tmp = " proposed by "; break;
       case "Nouvelle soumission de Photos": $tmp = "New soumission of photo"; break;
       case "Des photos viennent d'être proposées dans la galerie photo du site ": $tmp = "Photos were submitted in the photo gallery of the site "; break;
       case " par ": $tmp = " by "; break;
       case "Galerie Privée, connectez vous": $tmp = " Private galery, connect you"; break;
       case "Galerie temporaire": $tmp = "Temporary gallery"; break; 
       case "Image": $tmp = "Picture"; break;
       case "Description": $tmp = "Description"; break;

       case "Administration des galeries": $tmp = "Administration of the galeries"; break;


       case "Ajout catégorie": $tmp = "Add category"; break; //ok
       case "Ajout sous-catégorie": $tmp = "Add subcategory"; break; //ok
       case "Ajout images": $tmp = "Add pictures"; break; //ok
       case "Ajout galerie": $tmp = "Add gallery"; break; //ok
       case "Arborescence": $tmp = "Tree structure"; break; //ok
       case "Configuration": $tmp = "Setup"; break; //ok

       case "Nombre de catégories": $tmp = "Number of categories"; break; //ok
       case "Nombre de sous-catégories": $tmp = "Number of subcategories"; break; //ok
       case "Nombre d'images": $tmp = "Number of images"; break; //ok
       case "Nombre de galeries": $tmp = "Number of galleries"; break; //ok

       case "Informations": $tmp = "Informations"; break;

       case "Aucune sous-catégorie trouvée": $tmp = "No subcategory found"; break;

       case "Nom de la catégorie": $tmp = "Name of the category"; break;
       case "Nom de la sous-catégorie": $tmp = "Name of the subcategory"; break;
       case "Nom de la galerie": $tmp = "Name of the gallery"; break;
       case "Ajouter": $tmp = "Add"; break;
       case "Valider": $tmp = "Submit"; break;
       case "Cette catégorie existe déjà": $tmp = "This category already exists"; break;
       case "Erreur lors de l'ajout de la catégorie": $tmp = "Error during the addition of the category"; break;
       case "Administrateurs": $tmp = "Admins only"; break;
       case "Accès pour": $tmp = "Access for"; break;
       case "Catégorie parente": $tmp = "Parent category"; break;
       case "Cette sous-catégorie existe déjà": $tmp = "This subcategory already exists"; break;
       case "Cette galerie existe déjà": $tmp = "This gallery already exists"; break;
       case "Erreur lors de l'ajout de la sous-catégorie": $tmp = "Error during the addition of the subcategory"; break;
       case "Erreur lors de l'ajout de la galerie": $tmp = "Error during the addition of the gallery"; break;
       case "Catégorie": $tmp = "Category"; break;
       case "Sous-catégorie": $tmp = "Subcategory"; break;
       case "Galerie": $tmp = "Gallery"; break;
       case "Galerie": $tmp = "Gallery"; break;
       case "Image": $tmp = "Picture"; break;
       case "Description": $tmp = "Description"; break;
       case "Ce fichier n'est pas un fichier jpg ou gif": $tmp = "This file is not a jpg or gif file"; break;
       case "Image ajoutée avec succès": $tmp = "Image added successfully"; break;
       case "Impossible d'ajouter l'image en BDD": $tmp = "Impossible to add the image in DB"; break;
       case "Dimension maximale de l'image en pixels": $tmp = "Maximal dimension of the picture in pixels"; break;
       case "Dimension maximale de la miniature en pixels": $tmp = "Maximal dimension of the miniature in pixels"; break;
       case "Dimension maximale de l'image incorrecte": $tmp = "Incorrect maximal picture dimension"; break;
       case "Dimension maximale de la miniature incorrecte": $tmp = "Incorrect maximal miniature dimension"; break;
       case "Nombre d'images par ligne": $tmp = "Images per line"; break;
       case "Nombre d'images par page": $tmp = "Images per page"; break;
       case "Choisissez": $tmp = "Choose"; break;
       case "Les anonymes peuvent voter ?": $tmp = "Anonymous can rate ?"; break;
       case "Les anonymes peuvent poster un commentaire ?": $tmp = "Anonymous can comments ?"; break;
       case "Les anonymes peuvent envoyer des E-Cartes ?": $tmp = "Anonymous can send ECards ?"; break;
       case "Nombre de commentaires": $tmp = "Number of comments"; break;
       case "Nombre de votes": $tmp = "Number of rating"; break; //ok
       case "Afficher des photos aléatoires ?": $tmp = "View random images?"; break;
       case "Afficher les derniers ajouts ?": $tmp = "View last added images?";break;
       case "Vous allez supprimer la catégorie": $tmp = "You go to delete the category"; break;
       case "Vous allez supprimer la sous-catégorie": $tmp = "You go to delete the subcategory"; break;
       case "Vous allez supprimer la galerie": $tmp = "You go to delete the gallery"; break;
       case "Vous allez supprimer une image": $tmp = "You go to delete the picture"; break;
       case "Confirmer": $tmp = "Confirm"; break;
       case "Annuler": $tmp = "Cancel"; break;
       case "Miniature supprimée": $tmp = "Thumb deleted"; break;
       case "Miniature non supprimée": $tmp = "Thumb not deleted"; break;
       case "Image supprimée": $tmp = "Picture deleted"; break;
       case "Image non supprimée": $tmp = "Picture not deleted"; break;
       case "Enregistrement supprimé": $tmp = "Record deleted"; break;
       case "Enregistrement non supprimé": $tmp = "Record not deleted"; break;
       case "Galerie supprimée": $tmp = "Gallery deleted"; break;
       case "Galerie non supprimée": $tmp = "Gallery not deleted"; break;
       case "Sous-catégorie supprimée": $tmp = "Subcategory deleted"; break;
       case "Sous-catégorie non supprimée": $tmp = "Subcategory not deleted"; break;
       case "Catégorie supprimée": $tmp = "Category deleted"; break;
       case "Catégorie non supprimée": $tmp = "Category not deleted"; break;
       case "Votes supprimés": $tmp = "Rating deleted"; break;
       case "Votes non supprimés": $tmp = "Rating not deleted"; break;
       case "Commentaires supprimés": $tmp = "Comments deleted"; break;
       case "Commentaires non supprimés": $tmp = "Comments not deleted"; break;
       case "Effacer": $tmp = "Delete"; break;
       case "Modifier": $tmp = "Modify"; break;
       case "Nom actuel": $tmp = "Current name"; break;
       case "Nouveau nom": $tmp = "New name"; break;
       case "Images vues": $tmp = "Viewed images"; break; //ok
       case "Afficher les votes ?": $tmp = "Show ratings?"; break;
       case "Afficher les commentaires ?": $tmp = "Show comments?"; break;
       case "Galerie temporaire": $tmp = "Temporary' gallery"; break;
       case "Import images": $tmp = "Import pictures"; break; //ok
       case "MAJ ordre": $tmp = "Update order"; break;
       case "Importer": $tmp = "Import"; break;
       case "Nombre d'images à afficher dans le top commentaires": $tmp = "Number of pictures to display in top comment"; break;
       case "Nombre d'images à afficher dans le top votes": $tmp = "Number of pictures to display in top vote"; break;
       case "Notifier par email l'administrateur de la proposition de photos ?": $tmp = "Email notify the administrator of the proposal photos ?"; break;
       case "Export catégorie": $tmp = "Export category"; break; //ok
       case "Exporter": $tmp = "Export"; break;       
       
       case "Tableau récapitulatif": $tmp = "Summary table"; break; //ok
       case "Version du module": $tmp = "Version"; break; //ok
       
       
       default: $tmp = "Translation error <b>[** $phrase **]</b>"; break;      
    }
    return $tmp;
}
?>