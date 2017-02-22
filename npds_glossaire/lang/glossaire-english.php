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
/* Module npds_glossaire v 3.0 pour revolution 16                       */
/* by team jpb/phr 2017                                                 */
/*                                                                      */
/* From Glossaire version 1.3 pour myPHPNuke 1.8                        */
/* Copyright © 2001, Pascal Le Boustouller                              */
/* Tribal-dolphin 2008                                                  */
/************************************************************************/

function glo_translate($phrase) {
 switch ($phrase) {
   case "Français" : $tmp = "French"; break;
   case "Anglais" : $tmp = "English"; break;
   case "Allemand" : $tmp = "German"; break;
   case "Espagnol" : $tmp = "Spanish"; break;
   case "Chinois" : $tmp = "Chinese"; break;
   case "Glossaire": $tmp = "Glossary"; break;
   case "Réponse(s)": $tmp = "Response(s)"; break;
   case "Définitions": $tmp = "Definitions"; break;
   case "Termes": $tmp = "Terms"; break;
   case "Terme": $tmp = "Term"; break;
   case "Catégorie": $tmp = "Category"; break;
   case "Quelques définitions": $tmp = "Some definitions"; break;
   case "Définition": $tmp = "Definition"; break;
   case "Soumettre une définition": $tmp = "Submit definition"; break;
   case "Une définition identique existe déjà !": $tmp = "The definition already exist!"; break;
   case "Liste des définitions": $tmp = "All definitions"; break;
   case "La base est vide": $tmp = "The DataBase is empty"; break;
   case "Configuration": $tmp = "Configuration"; break;
   case "Administration": $tmp = "Administration"; break;
   case "Retour à l'administration": $tmp="Back to administration"; break;
   case "Meta": $tmp = "Meta"; break;
   case "Editer": $tmp = "Edit"; break;
   case "Supprimer": $tmp = "Delete"; break;
   case "Définitions par page": $tmp = "Definitions by page"; break;
   case "Autorise la soumission": $tmp = "Authorize submit"; break;
   case "Autorise la recherche": $tmp = "Authorize search"; break;
   case "Site internet": $tmp = "Web Link"; break;
   case "Cliquer pour cacher ou déployer": $tmp = "Click to hide or deploy"; break;
   case "Sélectionner un dossier": $tmp = "Select a folder"; break;
   case "Sélectionner": $tmp = "Select"; break;
   case "Rechercher par choix multiples": $tmp = "Search multiple choices"; break;
   case "Rechercher par lettre": $tmp = "Search by letter"; break;
   case "Merci pour votre proposition": $tmp = "Thanks for your submission"; break;
   case "Merci de respecter les consignes": $tmp = "Please enter information according to the specifications"; break;
   case "Tous": $tmp = "All"; break;
   case "Valider": $tmp = "Submit"; break;
   case "Autres": $tmp = "Other"; break;
   case "Validation ou suppression des demandes": $tmp = "Validating or deleting requests"; break;
   case "Oui": $tmp = "Yes"; break;
   case "Non": $tmp = "No"; break;
   case "Fonctions": $tmp = "Functions"; break;
   case "Liste des définitions dans la base de données": $tmp = "List of definitions in the database"; break;
   case "Validation ou suppression des demandes": $tmp = "Validating or deleting requests"; break;   
   case "Edition d'une définition": $tmp = "Editing a definition"; break;  
   default: $tmp = "Translation error [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>