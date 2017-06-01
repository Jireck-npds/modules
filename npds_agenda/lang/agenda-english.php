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
/* Module npds_agenda 2.0                                               */
/*                                                                      */
/* Auteur Oim                                                           */
/* Changement de nom du module version Rev16 par jpb/phr janv 2017      */
/************************************************************************/

function ag_translate($phrase) {
   switch ($phrase) {
   case "A valider": $tmp = "To validate"; break;
   case "Accès catégorie(s)": $tmp = "Access catégories"; break;
   case "Accueil": $tmp = "Home"; break;
   case "Agenda": $tmp = "Diary"; break;
   case "Ajout événement pour": $tmp = "Add for"; break;
   case "1 : tous les membres ou n° id groupe": $tmp = "1 All members - or id groups"; break;
   case "Ajouter une catégorie": $tmp = "Add a category"; break;
   case "Allemand" : $tmp = "German"; break;
   case "Anglais" : $tmp = "English"; break;
   case "Année": $tmp = "Year"; break;
   case "Août": $tmp = "August"; break;
   case "AOUT": $tmp = "AUGUST"; break;
   case "Armistice 14-18": $tmp = "Armistice 14-18"; break;
   case "Armistice 39-45": $tmp = "Armistice 39-45"; break;
   case "Assomption": $tmp = "Assumption"; break;
   case "Aucun événement trouvé": $tmp = "Not event find"; break;
   case "Auteur": $tmp = "Author"; break;
   case "Autre(s)": $tmp = "Other(s)"; break;
   case "Autres": $tmp = "Other"; break;
   case "AVRIL": $tmp = "APRIL"; break;
   case "Avril": $tmp = "April"; break;
   case "Calendrier": $tmp = "Calendar"; break;
   case "Catégories": $tmp = "Categories"; break;
   case "Catégorie": $tmp = "Category"; break;
   case "Cet événement est maintenant effacé": $tmp = "This event is now clears"; break;
   case "Cet événement est mis à jour": $tmp = "This event is updated"; break;
   case "Cet événement dure 1 jour": $tmp = "This event lasts 1 day"; break;
   case "Cet événement dure plusieurs jours": $tmp = "The event lasts several days"; break;
   case "Cet événement est maintenant effacé": $tmp = "This event is now clears"; break;
   case "Chemin des images": $tmp = "Path of images"; break;
   case "Choix catégorie": $tmp = "Select catégory"; break;
   case "Chinois" : $tmp = "Chinese"; break;
   case "Cliquez pour éditer": $tmp = "Click to edit"; break;
   case "Configuration": $tmp = "Configuration"; break;
   case "Confirmez la suppression": $tmp = "Confirm delete"; break;
   case "D": $tmp = "S"; break;
   case "Décembre": $tmp = "December"; break;
   case "Date": $tmp = "Date"; break;
   case "DECEMBRE": $tmp = "DECEMBER"; break;
   case "Description complète": $tmp = "Description supplements"; break;
   case "Description": $tmp = "Description"; break;
   case "Editer un événement": $tmp = "To publish an event"; break;
   case "Editer": $tmp = "Edit"; break;
   case "En Ligne": $tmp = "On line"; break;
   case "Espagnol" : $tmp = "Spanish"; break;
   case "Etape 1 : Séléctionner vos dates": $tmp = "Step 1: Select your dates"; break;
   case "Etape 2 : Remplisser le formulaire": $tmp = "Step 2: fill the form"; break;
   case "Etes-vous certain de vouloir supprimer cet événement": $tmp = "Are you sure you want to delete this event?"; break;
   case "Etre averti par mèl d'une proposition": $tmp = "Being informed by mail of a new event"; break;
   case "Evénement": $tmp = "Event"; break;
   case "Evénement(s) à venir": $tmp = "Upcoming events"; break;
   case "Evénement(s) en cours ou passé(s)": $tmp = "Events in current or past"; break;
   case "Evénement nouveau dans agenda": $tmp = "New event in calendar"; break;
   case "Février": $tmp = "February"; break;
   case "Fête du travail": $tmp = "Labor Day"; break;
   case "Fête nationale": $tmp = "National Day"; break;
   case "FEVRIER": $tmp = "FEBRUARY"; break;
   case "Fonctions": $tmp = "Functions"; break;
   case "Français" : $tmp = "French"; break;
   case "Groupe": $tmp = "Group"; break;
   case "Hors Ligne": $tmp = "Off line"; break;
   case "ID": $tmp = "ID"; break;
   case "Image de la catégorie": $tmp = "Image of the category"; break;
   case "J": $tmp = "T"; break;
   case "JANVIER": $tmp = "JANUARY"; break;
   case "Janvier": $tmp = "January"; break;
   case "Jeu": $tmp = "Thi"; break;
   case "Jeudi de l'ascension": $tmp = "Thursday the ascenscion"; break;
   case "Jour avec événement(s)": $tmp = "Day with event(s)"; break;
   case "Jour de l'an": $tmp = "New Year's Day"; break;
   case "Jour férié": $tmp = "Public holiday"; break;
   case "Jour(s) sélectionné(s)": $tmp = "Day(s) selected"; break;
   case "JUILLET": $tmp = "JULY"; break;
   case "Juillet": $tmp = "July"; break;
   case "JUIN": $tmp = "JUNE"; break;
   case "Juin": $tmp = "June"; break;
   case "L": $tmp = "M"; break;
   case "La catégorie est créée": $tmp = "The category is created"; break;
   case "La catégorie est effacée": $tmp = "The category will be deleted"; break;
   case "La catégorie est mise à jour": $tmp = "The subject is updated"; break;
   case "Le": $tmp = "The"; break;
   case "Les": $tmp = "The"; break;
   case "Les préférences pour l'agenda ont été enregistrées": $tmp = "The preferences for Diary are registered"; break;
   case "Lieu": $tmp = "Place"; break;
   case "Liste des événements": $tmp = "Events list"; break;
   case "Liste de vos événements": $tmp = "List your events"; break;
   case "Lundi de Pâques": $tmp = "Easter Monday"; break;
   case "Lundi de Pentecôte": $tmp = "Whit Monday"; break;
   case "M ": $tmp = "W"; break;
   case "M": $tmp = "T"; break;
   case "MAI": $tmp = "MAY"; break;
   case "Mai": $tmp = "May"; break;
   case "Email du destinataire": $tmp = "Mail recipient"; break;
   case "Mar": $tmp = "Tue"; break;
   case "Mars": $tmp = "March"; break;
   case "MARS": $tmp = "MARCH"; break;
   case "Mer": $tmp = "Wen"; break;
   case "Merci pour votre contribution, un administrateur la validera rapidement": $tmp = "Thank you for your contribution, an administrator will validate quickly"; break;
   case "Modification événement pour agenda": $tmp = "Change event for agenda"; break;
   case "Modifier l'Evénement": $tmp = "Edit the Event"; break;
   case "Modifier la catégorie": $tmp = "To modify category"; break;
   case "Nombre d'évènement(s) par page (administration)": $tmp = "Number of events by page (admin)"; break;
   case "Nombre d'évènement(s) par page (utilisateur)": $tmp = "Number of events by page (user)"; break;
   case "Noël": $tmp = "Christmas"; break;
   case "NON": $tmp = "NO"; break;
   case "Non": $tmp = "No"; break;
   case "npds_agenda": $tmp = "npds_diary"; break;
   case "NOVEMBRE": $tmp = "NOVEMBER"; break;
   case "Novembre": $tmp = "November"; break;
   case "OCTOBRE": $tmp = "OCTOBER"; break;
   case "Octobre": $tmp = "October"; break;
   case "OUI": $tmp = "YES"; break;
   case "Oui": $tmp = "Yes"; break;
   case "Par ville": $tmp = "By city"; break;
   case "par ville": $tmp = "by city"; break;
   case "Par ville (défaut)": $tmp = "By city (default)"; break;
   case "Par": $tmp = "By"; break;
   case "Pas de catégorie": $tmp = "No category"; break;
   case "Pas de catégorie ajoutée": $tmp = "No category add"; break;
   case "Posté par": $tmp = "Posted by"; break;
   case "pour la lettre": $tmp = "for letter"; break;
   case "pour": $tmp = "for"; break;
   case "Proposer événement": $tmp = "Submit event"; break;
   case "Proposer un événement": $tmp = "Submit an event"; break;
   case "Pour ajouter des dates, sélectionner le(s) jour(s) dans le calendrier": $tmp = "To add dates, select the day (s) in the calendar"; break;
   case "Résumé de l'événement": $tmp = "Summary of the event"; break;
   case "Recherche": $tmp = "Search"; break;
   case "Résumé": $tmp = "Abstract"; break;
   case "Retour édition catégorie": $tmp = "Return to edit category"; break;
   case "Retour au calendrier": $tmp = "Back to calendar"; break;
   case "Retour au jour": $tmp = "Back to day"; break;
   case "Retour": $tmp = "Back"; break;
   case "S": $tmp = "S"; break;
   case "Saisie obligatoire": $tmp = "Mandatory field"; break;
   case "Sam": $tmp = "Sat"; break;
   case "Sauver les modifications": $tmp = "Save the changes"; break;
   case "Sélectionner catégorie": $tmp = "Select category"; break;
   case "Sélectionnez une catégorie, cliquez pour modifier": $tmp = "Select a category, click to edit"; break;
   case "Sélection région ou département": $tmp = "Select region or department"; break;
   case "Etape 1 : Sélectionner vos dates": $tmp = "Step 1: Select your dates"; break;
   case "Sem": $tmp = "Week"; break;
   case "SEPTEMBRE": $tmp = "SEPTEMBER"; break;
   case "Septembre": $tmp = "September"; break;
   case "Statut": $tmp = "Status"; break;
   case "Categorie": $tmp = "Catégory"; break;
   case "Supercache": $tmp = "Supercache"; break;
   case "Supprimer la catégorie": $tmp = "Delete category"; break;
   case "Supprimer cet événement": $tmp = "Delete this event"; break;
   case "Supprimer": $tmp = "Delete"; break;
   case "Temps du cache (en secondes)": $tmp = "Time of the mask (in seconds)"; break;
   case "Titre de la catégorie": $tmp = "Title of the category"; break;
   case "Titre": $tmp = "Title"; break;
   case "Toussaint": $tmp = "Toussaint"; break;
   case "Trier par": $tmp = "Order by"; break;
   case "Un administrateur validera vos changements rapidement": $tmp = "An administrator will validate your changes quickly"; break;
   case "Un événement nouveau est à valider dans agenda": $tmp = "A new event is to be validated in the agenda"; break;
   case "V": $tmp = "F"; break;
   case "Validation après modification": $tmp = "Validation after edit"; break;
   case "Validation par l'admin": $tmp = "Validation by admin"; break;
   case "Valider": $tmp = "Validate"; break;
   case "Vendredi Saint": $tmp = "Good Friday"; break;
   case "Vide": $tmp = "Empty"; break;
   case "Voir la fiche": $tmp = "See details"; break;
   case "Voir": $tmp = "See"; break;
   case "Vos ajouts": $tmp = "Adding your(s)"; break;
   case "Vous n'avez pas rempli les champs obligatoires": $tmp = "You have not completed the required fields"; break;
   case "Vue annuelle": $tmp = "Year calendar"; break;
   default: $tmp = "Translation error [** $phrase **]"; break;
   }
   return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>