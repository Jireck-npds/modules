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
   case "Français" : $tmp = "Französisch"; break;
   case "Anglais" : $tmp = "English"; break;
   case "Allemand" : $tmp = "Deutsch"; break;
   case "Espagnol" : $tmp = "Spanisch"; break;
   case "Chinois" : $tmp = "Chinesisch"; break;

   case "à" : $tmp = "to"; break;
   case "Admin P.A" : $tmp = "Administrator"; break;
   case "Administration des catégories et sous-catégories" : $tmp = "Verwaltung von Kategorien und Unterkategorien"; break;
   case "Ajouter ou modifier une catégorie": $tmp = "Hinzufügen oder Entfernen einer Kategorie bearbeiten"; break;
   case "Ajouter une annonce" : $tmp = "Anzeige hinzufügen"; break;
   case "Ajouter une catégorie" : $tmp = "Kategorie hinzufügen"; break;
   case "Ajouter une sous-catégorie dans" : $tmp = "In der Subkategorie"; break;
   case "Annonce de" : $tmp = "Ankündigung"; break;
   case "Annonce" : $tmp = "Anzeige"; break;
   case "annonce(s) à valider" : $tmp = "Anzeige (n) zu validieren"; break;
   case "annonce(s) en ligne" : $tmp = "Online-Werbung"; break;
   case "annonce(s)" : $tmp = "Anzeige(s)"; break;
   case "Annonces à valider" : $tmp = "Die nächsten Anzeigen"; break;
   case "Annonces archivées" : $tmp = "Archivierten anzeigen"; break;
   case "Annonces en ligne" : $tmp = "Online-Inserate"; break;
   case "Annonces(s)" : $tmp = "Ankündigungen"; break;
   case "Arborescense en ligne" : $tmp = "Eine Baumstruktur Online"; break;
   case "Autres" : $tmp = "Andere"; break;
   case "Catégorie" : $tmp = "Kategorie"; break;
   case "Clic droit sur l'image puis enregistrer l'image sous": $tmp = "Rechtsklick auf das bild und speichern sie das bild"; break;
   case "Cliquer pour administrer": $tmp = "Klicken sie hier um zu verwalten"; break; 
   case "Cliquer pour déplier" : $tmp = "Klicken sie zu entfalten"; break;
   case "Cliquer pour visualiser" : $tmp = "Klicken zur ansicht"; break;
   case "Code postal" : $tmp = "Reißverschluss"; break;
   case "Email" : $tmp = "e-Mail"; break;
   case "en attente de validation" : $tmp = "wartet auf Bestätigung"; break;
   case "En ligne" : $tmp = "On line"; break;
   case "Enregistrer sur votre bureau sans changer le nom du fichier qui est spécialement codifié": $tmp = "Speichern sie auf ihrem desktop, ohne die dateinamen zu ändern, die speziell codiert"; break;
   case "et" : $tmp = "und"; break;
   case "Fermer" : $tmp = "Schließen"; break;
   case "Gérer P.A" : $tmp = "Verwalten anzeige"; break;
   case "Gestion de vos annonces" : $tmp = "Verwalten Sie Ihre Anzeigen"; break;
   case "Il y a" : $tmp = "Vor"; break;
   case "Instructions": $tmp = "Anleitung"; break;
   case "Le fichier doit être impérativement une image au format jpg": $tmp = "The file must be an image in jpg format"; break;
   case "Libellé de l'annonce" : $tmp = "Formulierung ad"; break;
   case "L'opération s'est bien passée": $tmp = "Die Operation verlief gut"; break;
   case "Maxi = largeur 900 pixels": $tmp = "Max = 900 Pixel breit"; break;
   case "Mentions légales des conditions d'utilisation des petites annonces" : $tmp = "Legal Nutzungsbedingungen von Anzeigen"; break;
   case "Mentions légales" : $tmp = "Impressum"; break;
   case "Mini = largeur 400 pixels": $tmp = "Die Mindestbreite = 400 Pixel"; break;
   case "Mode d'emploi" : $tmp = "Anleitung"; break;
   case "Modifier" : $tmp = "Veränderung"; break;
   case "Nom" : $tmp = "Name"; break;
   case "Normal = largeur 600 pixels": $tmp = "Normal = 600 Pixel Breite"; break;
   case "Outil de préparation image initialement au format jpg" : $tmp = "Die Datei hat ein Bild im jpg sein"; break;
   case "Outil" : $tmp = "Werkzeug"; break;
   case "P.A en ligne": $tmp = "Kleine Online-Werbung"; break;
   case "Passer P.A" : $tmp = "überspringen ad"; break;
   case "Placer ensuite le curseur à l'endroit où vous voulez mettre la photo puis cliquer sur l'icone téléchargement": $tmp = "Dann setzen Sie den Cursor in dem Sie das Foto setzen möchten und klicken Sie auf das Download-Symbol"; break;
   case "Pour passer ou gérer vos annonces vous devez être membre inscrit connecté" : $tmp = "So ändern oder verwalten Sie Ihre Anzeigen, die Sie angemeldet sein registriert sind, müssen"; break;
   case "Pour préparer une image" : $tmp = "Zur Herstellung eines Bildes"; break;
   case "Précédente" : $tmp = "Früher"; break;
   case "Prix en" : $tmp = "Preis"; break;
   case "Prix" : $tmp = "Preis"; break;
   case "publiée(s)" : $tmp = "veröffentlicht"; break;
   case "Rechercher dans les annonces" : $tmp = "Suchanzeigen"; break;
   case "Redimensionner": $tmp = "Die Größe"; break;
   case "Retour P.A": $tmp = "Zurück ad"; break;
   case "Retour" : $tmp = "Rückkehr"; break;
   case "Retournez sur la page de saisie de votre annonce": $tmp = "Schalten sie ihre anzeige einstiegsseite"; break;
   case "sans" : $tmp = "ohne"; break;
   case "Sélectionner sur votre ordinateur le fichier image .jpg à redimensionner": $tmp = "Wählen sie ihren computer .jpg bilddatei, um die größe"; break;
   case "Soumettre" : $tmp = "Einreichen"; break;
   case "Sous-catégorie" : $tmp = "Unterkategorie"; break;
   case "Suivante" : $tmp = "Nächste"; break;
   case "Supprimer" : $tmp = "Entfernen"; break;
   case "Tél fixe" : $tmp = "Festnetztelefon"; break;
   case "Tél portable" : $tmp = "Handy"; break;
   case "une fenêtre s'ouvrira où vous sélectionnerez le fichier photo préparée puis cliquez sur le bouton joindre": $tmp = "öffnet sich ein Fenster, wo Sie die vorbereitete Fotodatei auswählen und die Verknüpfung klicken"; break;
   case "Valider" : $tmp = "Bestätigen"; break;
   case "Ville" : $tmp = "Stadt"; break;
   case "vous avez" : $tmp = "sie"; break;

   
   default: $tmp = "Es gibt keine Übersetzung [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>