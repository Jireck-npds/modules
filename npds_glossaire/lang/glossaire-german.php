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
   case "Français" : $tmp = "Französisch"; break;
   case "Anglais" : $tmp = "English"; break;
   case "Allemand" : $tmp = "Deutsch"; break;
   case "Espagnol" : $tmp = "Spanisch"; break;
   case "Chinois" : $tmp = "Chinesisch"; break;
   case "Glossaire": $tmp = "Glossar"; break;
   case "Réponse(s)": $tmp = "Antwort(en)"; break;
   case "Définitions": $tmp = "Definitionen"; break;
   case "Termes": $tmp = "Bedingungen"; break;
   case "Terme": $tmp = "Bedingung"; break;
   case "Catégorie": $tmp = "Kategorie"; break;
   case "Quelques définitions": $tmp = "Einige Definitionen"; break;
   case "Définition": $tmp = "Definition"; break;
   case "Soumettre une définition": $tmp = "Einen Definition"; break;
   case "Une définition identique existe déjà !": $tmp = "Eine identische Definition existiert bereits !"; break;
   case "Liste des définitions": $tmp = "Liste der Definitionen"; break;
   case "La base est vide": $tmp = "La base est vide"; break;
   case "Configuration": $tmp = "Konfiguration"; break;
   case "Administration": $tmp = "Verwaltung"; break;
   case "Retour à l'administration": $tmp="Zurück zur Verwaltung"; break;
   case "Meta": $tmp = "Meta"; break;
   case "Editer": $tmp = "Bearbeiten"; break;
   case "Supprimer": $tmp = "Entfernen"; break;
   case "Définitions par page": $tmp = "Definitionen pro Seite"; break;
   case "Autorise la soumission": $tmp = "Ermächtigt Vorlage"; break;
   case "Autorise la recherche": $tmp = "Ermächtigt Forschung"; break;
   case "Site internet": $tmp = "Webseite"; break;
   case "Cliquer pour cacher ou déployer": $tmp = "Klicken Sie sich zu verstecken oder bereitstellen"; break;
   case "Sélectionner un dossier": $tmp = "Ordner auswählen"; break;
   case "Sélectionner": $tmp = "Wählen"; break;
   case "Rechercher par choix multiples": $tmp = "Suche nach Multiple-Choice"; break;
   case "Rechercher par lettre": $tmp = "Suche nach Buchstaben"; break;
   case "Merci pour votre proposition": $tmp = "Vielen Dank für Ihren Vorschlag"; break;
   case "Merci de respecter les consignes": $tmp = "Vielen Dank, den Anweisungen folgen"; break;
   case "Tous": $tmp = "Alle"; break;
   case "Valider": $tmp = "Bestätigen"; break;
   case "Autres": $tmp = "Andere"; break;
   case "Validation ou suppression des demandes": $tmp = "Validierung oder Löschanträge"; break;
   case "Oui": $tmp = "Ja"; break;
   case "Non": $tmp = "Nicht"; break;
   case "Fonctions": $tmp = "Funktionen"; break;
   case "Liste des définitions dans la base de données": $tmp = "Liste der Definitionen in der Datenbank"; break;
   case "Validation ou suppression des demandes": $tmp = ""; break;   
   case "Edition d'une définition": $tmp = "Bearbeiten einer Definition"; break;   
   default: $tmp = "Es gibt keine Übersetzung [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>