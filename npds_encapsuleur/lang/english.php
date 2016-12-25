<?php
/************************************************************************/
/* NPDS V : Net Portal Dynamic System                                   */
/* ===========================                                          */
/*                                                                      */
/* This version name NPDS Copyright (c) 2001-2011 by Philippe Brunier   */
/*                                                                      */
/* Encapsuleur  V 5.0                                                   */
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
/* Changement de nom du module version Rev16 par jpb/phr mars 2016      */
/************************************************************************/

function encap_translate($phrase) {
settype($englishname,'string');
switch($phrase) {
       case "Pleine Page": $tmp = "Full Page"; break;
       case "Page en cours de création": $tmp = "Page under construction"; break;
       case "Administration de l'encapsuleur": $tmp = "Encapsuler Administration"; break;
       case "Désolé, cette requête ne renvoie aucun résultat.": $tmp = "Sorry, this request do not have any answer."; break;
       case "Il y a": $tmp = "There are"; break;
       case "encapsulation(s) dans la table": $tmp = "encapsulation(s) in the table"; break;
       case "Pour modifier un enregistrement, cliquez sur son nom": $tmp = "To modify a record, click on its name"; break;
       case "Display": $tmp = "Display"; break;
       case "Nom": $tmp = "Name"; break;
       case "Type": $tmp = "Type"; break;
       case "Forme": $tmp = "Kind"; break;
       case "Adresse": $tmp = "URL"; break;
       case "Hauteur": $tmp = "Height"; break;
       case "Scroll": $tmp = "Scroll"; break;
       case "Bloc": $tmp = "Block"; break;
       case "Titre": $tmp = "Title"; break;
       case "Ajouter un enregistrement": $tmp = "Add a new record"; break;
       case "Modifier cet enregistrement :": $tmp = "Edit this record :"; break;
       case "Annuler": $tmp = "Cancel"; break;
       case "(interne ou externe)": $tmp = "(internal ou external)"; break;
       case "Interne": $tmp = "Internal"; break;
       case "Externe": $tmp = "External"; break;
       case "(adresse web sans http:// si externe ou nom du fichier si interne)": $tmp = "(web address without http:// if external or file name if internal)"; break;
       case "defaut": $tmp = "default"; break;
       case "Affichage du titre": $tmp = "Title visible"; break;
       case "no": $tmp = "no"; break;
       case "non": $tmp = "no"; break;
       case "oui": $tmp = "yes"; break;
       case "Non": $tmp = "no"; break;
       case "Oui": $tmp = "yes"; break;
       case "Enregistrer": $tmp = "Save"; break;
       case "Effacer": $tmp = "Delete"; break;
       case "Lien": $tmp = "Link"; break;
       case "Le lien de votre page encapsulée est": $tmp = "The encapsulation link is"; break;
       case "Enregistrement effectué !": $tmp = "Record's add."; break;
       case "le nom saisi existe déja": $tmp = "The name allready exist"; break;
       case "Mise à Jour effectuée !": $tmp = "Update done succesfully"; break;
       case "Mise à Jour non effectuée !": $tmp = "Update failed"; break;
       case "Enregistrement N° ": $tmp = "Record number "; break;
       case "effacé !": $tmp = "deleted!"; break;
       case "Erreur de suppression de l'enregistrement": $tmp = "Suppression error"; break;
       case "Le lien n'existe pas.": $tmp = "The link doesn't exist"; break;
       case "Infos de configuration des blocs": $tmp = "Informations"; break;       
       case "Configuration des blocs du portail": $tmp = "Blocs configuration"; break;
       case "choix": $tmp = "choice"; break;
       case "centrale seule": $tmp = "central alone"; break;       
       case "colonne centrale": $tmp = "central column"; break;       
       case "colonne droite": $tmp = "right column"; break;       
       case "colonne gauche": $tmp = "left column"; break;
       case "Fermer": $tmp = "Close"; break;       
       
       
       
       case "npds_encapsuleur": $tmp = "npds_encapsuleur"; break;       

  default: $tmp="Need to be translated [** $phrase **]"; break;
  }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>

