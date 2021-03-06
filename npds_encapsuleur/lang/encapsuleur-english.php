<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/* ===========================                                          */
/*                                                                      */
/* Encapsuleur  V 5.0                                                   */
/*                                                                      */
/* NPDS Copyright (c) 2002-2017 by Philippe Brunier                     */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
/* 05.01.2001 - martvin@box43.pl                                        */
/* 12.09.2002 - Achel_Jay, Benjee, Capcaverne                           */
/* 02.11.2002 - Snipe                                                   */
/* 25.11.2008 - Lopez - MAJ pouir Evolution                             */
/* 2010 et 2011 - Adaptation REvolution                                 */
/* 2017 Changement de nom du module version Rev16 par jpb/phr           */
/************************************************************************/


function encap_translate($phrase) {
 switch ($phrase) {
   case "Français" : $tmp = "French"; break;
   case "Anglais" : $tmp = "English"; break;
   case "Allemand" : $tmp = "German"; break;
   case "Espagnol" : $tmp = "Spanish"; break;
   case "Chinois" : $tmp = "Chinese"; break;
   case "Adresse web sans http:// si externe ou nom du fichier si interne": $tmp = "Web address without http:// if external or file name if internal"; break;
   case "(interne ou externe)": $tmp = "(internal ou external)"; break;
   case "Adresse" : $tmp = "Weblink"; break;
   case "Administration de l'encapsuleur": $tmp = "Encapsuler Administration"; break;
   case "Affichage du titre": $tmp = "Title visible"; break;
   case "Aide": $tmp = "FAQ"; break;
   case "Ajouter un enregistrement": $tmp = "Add a new record"; break;
   case "Annuler": $tmp = "Cancel"; break;
   case "Bloc": $tmp = "Block"; break;
   case "centrale seule": $tmp = "central alone"; break;
   case "choix": $tmp = "choice"; break;
   case "colonne centrale": $tmp = "central column"; break;
   case "colonne droite": $tmp = "right column"; break; 
   case "colonne gauche": $tmp = "left column"; break;
   case "Configuration des blocs du portail": $tmp = "Blocs configuration"; break;
   case "defaut": $tmp = "default"; break;
   case "Désolé, cette requête ne renvoie aucun résultat": $tmp = "Sorry, this request do not have any answer"; break;
   case "Display": $tmp = "Display"; break;
   case "effacé": $tmp = "deleted"; break;
   case "Effacer": $tmp = "Delete"; break;
   case "encapsulation(s) dans la table": $tmp = "encapsulation(s) in the table"; break;
   case "Enregistrement effectué": $tmp = "Record's add."; break;
   case "Enregistrement N°": $tmp = "Record number"; break;
   case "Enregistrer": $tmp = "Save"; break;
   case "Erreur de suppression de l'enregistrement": $tmp = "Suppression error"; break;
   case "Externe": $tmp = "External"; break;
   case "Fermer": $tmp = "Close"; break;
   case "Forme": $tmp = "Kind"; break;
   case "Hauteur": $tmp = "Height"; break;
   case "Il y a": $tmp = "There are"; break;
   case "Infos de configuration des blocs": $tmp = "Informations"; break; 
   case "Interne": $tmp = "Internal"; break;
   case "Le lien de votre page encapsulée est": $tmp = "The encapsulation link is"; break;
   case "Le lien n'existe pas": $tmp = "The link doesn't exist"; break;
   case "Le nom saisi existe déjà": $tmp = "The name allready exist"; break;
   case "Lien": $tmp = "Link"; break;
   case "Mise à Jour effectuée": $tmp = "Update done succesfully"; break;
   case "Mise à Jour non effectuée": $tmp = "Update failed"; break;
   case "Modifier cet enregistrement": $tmp = "Edit this record"; break;
   case "Nom": $tmp = "Name"; break;
   case "Non": $tmp = "No"; break;
   case "npds_encapsuleur": $tmp = "npds_encapsuleur";break;
   case "Oui": $tmp = "Yes"; break;
   case "Page en cours de création": $tmp = "Page under construction"; break;
   case "Pleine Page": $tmp = "Full Page"; break;
   case "Pour modifier un enregistrement, cliquez sur son nom": $tmp = "To modify a record, click on its name"; break;
   case "Scroll": $tmp = "Scroll"; break;
   case "Titre": $tmp = "Title"; break;
   case "Type": $tmp = "Type"; break;
   case "Veuillez saisir les informations selon les spécifications": $tmp = "Please enter information according to the specifications"; break;

   default: $tmp = "Translation error [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>