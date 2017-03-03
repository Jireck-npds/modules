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
   case "A valider": $tmp = ""; break;
   case "Accès catégorie(s)": $tmp = ""; break;
   case "Accueil": $tmp = ""; break;
   case "Agenda": $tmp = ""; break;
   case "Ajout + Groupe": $tmp = ""; break;
   case "Ajout d'événement : 1 Tous les membres - ou groupe": $tmp = ""; break;
   case "Ajouter une catégorie": $tmp = ""; break;
   case "Allemand" : $tmp = ""; break;
   case "Anglais" : $tmp = ""; break;
   case "Année": $tmp = ""; break;
   case "Août": $tmp = ""; break;
   case "AOUT": $tmp = ""; break;
   case "Armistice 14-18": $tmp = ""; break;
   case "Armistice 39-45": $tmp = ""; break;
   case "Assomption": $tmp = ""; break;
   case "Astérisque = saisie obligatoire": $tmp = ""; break;
   case "Aucun évènement trouvé": $tmp = ""; break;
   case "Auteur": $tmp = ""; break;
   case "Autre(s)": $tmp = ""; break;
   case "Autres": $tmp = ""; break;
   case "AVRIL": $tmp = ""; break;
   case "Avril": $tmp = ""; break;
   case "Calendrier": $tmp = ""; break;
   case "Catégories": $tmp = ""; break;
   case "Catégorie": $tmp = ""; break;
   case "Cet évènement est maintenant effacé": $tmp = ""; break;
   case "Cet évènement est mis à jour": $tmp = ""; break;
   case "Cet évènement dure 1 jour": $tmp = ""; break;
   case "Cet évènement dure plusieurs jours": $tmp = ""; break;
   case "Cet évènement est maintenant effacé": $tmp = ""; break;
//   case "Champ obligatoire": $tmp = ""; break;
   case "Chemin des images": $tmp = ""; break;
   case "Choix catégorie": $tmp = ""; break;
   case "Chinois" : $tmp = ""; break;
   case "Cliquez pour éditer": $tmp = ""; break;
   case "Configuration": $tmp = ""; break;
   case "Confirmez la suppression": $tmp = ""; break;
   case "D": $tmp = ""; break;
   case "Décembre": $tmp = ""; break;
   case "Date": $tmp = ""; break;
   case "DECEMBRE": $tmp = ""; break;
   case "Description complète": $tmp = ""; break;
   case "Description": $tmp = ""; break;
   case "Editer un évènement": $tmp = ""; break;
   case "Editer": $tmp = ""; break;
   case "En Ligne": $tmp = ""; break;
   case "Espagnol" : $tmp = ""; break;
   case "Etape 1 : Séléctionner vos dates": $tmp = ""; break;
   case "Etape 2 : Remplisser le formulaire": $tmp = ""; break;
   case "Etes-vous certain de vouloir supprimer cet évènement": $tmp = ""; break;
   case "Etre averti par mail d'un nouvel evenement": $tmp = "B"; break;
   case "Evènement": $tmp = ""; break;
   case "Evènement(s) à venir": $tmp = ""; break;
   case "Evènement(s) en cours ou passé(s)": $tmp = ""; break;
   case "Evènement nouveau dans agenda": $tmp = ""; break;
   case "Février": $tmp = ""; break;
   case "Fête du travail": $tmp = ""; break;
   case "Fête nationale": $tmp = ""; break;
   case "FEVRIER": $tmp = ""; break;
   case "Fonctions": $tmp = ""; break;
   case "Français" : $tmp = ""; break;
   case "Groupe": $tmp = ""; break;
   case "Hors Ligne": $tmp = ""; break;
   case "ID": $tmp = ""; break;
   case "Image de la catégorie": $tmp = ""; break;
   case "J": $tmp = ""; break;
   case "JANVIER": $tmp = ""; break;
   case "Janvier": $tmp = ""; break;
   case "Jeu": $tmp = ""; break;
   case "Jeudi de l'ascension": $tmp = ""; break;
   case "Jour avec évènement(s)": $tmp = ""; break;
   case "Jour de l'an": $tmp = ""; break;
   case "Jour férié": $tmp = ""; break;
   case "Jour(s) sélectionné(s)": $tmp = ""; break;
   case "JUILLET": $tmp = ""; break;
   case "Juillet": $tmp = ""; break;
   case "JUIN": $tmp = ""; break;
   case "Juin": $tmp = ""; break;
   case "L": $tmp = ""; break;
   case "La catégorie est créée": $tmp = ""; break;
   case "La catégorie est effacée": $tmp = ""; break;
   case "La catégorie est mise à jour": $tmp = ""; break;
   case "Les préférences pour l'agenda ont été enregistrées": $tmp = ""; break;
   case "Lieu": $tmp = ""; break;
   case "Liste des évènements": $tmp = ""; break;
   case "Liste de vos évènements": $tmp = ""; break;
   case "Lundi de Pâques": $tmp = ""; break;
   case "Lundi de Pentecôte": $tmp = ""; break;
   case "M ": $tmp = ""; break;
   case "M": $tmp = ""; break;
   case "MAI": $tmp = ""; break;
   case "Mai": $tmp = ""; break;
   case "Mail du receveur": $tmp = ""; break;
   case "Mar": $tmp = ""; break;
   case "Mars": $tmp = ""; break;
   case "MARS": $tmp = ""; break;
   case "Mer": $tmp = ""; break;
   case "Merci pour votre contribution, un administrateur la validera rapidement": $tmp = ""; break;
   case "Modification évènement pour agenda": $tmp = ""; break;
   case "Modifier l'Evènement": $tmp = ""; break;
   case "Modifier la catégorie": $tmp = ""; break;
   case "Nbre d'évènements (pagination)": $tmp = ""; break;
   case "Dans la partie module": $tmp = ""; break;
   case "Dans la partie admin": $tmp = ""; break;
   case "Noël": $tmp = ""; break;
   case "NON": $tmp = ""; break;
   case "Non": $tmp = ""; break;
   case "npds_agenda": $tmp = ""; break;
   case "NOVEMBRE": $tmp = ""; break;
   case "Novembre": $tmp = ""; break;
   case "OCTOBRE": $tmp = ""; break;
   case "Octobre": $tmp = ""; break;
   case "OUI": $tmp = ""; break;
   case "Oui": $tmp = ""; break;
   case "Par ville": $tmp = ""; break;
   case "par ville": $tmp = ""; break;
   case "Par ville (défaut)": $tmp = ""; break;
   case "Par": $tmp = ""; break;
   case "Pas de catégorie": $tmp = ""; break;
   case "Pas de catégorie ajoutée": $tmp = ""; break;
   case "Posté par": $tmp = ""; break;
   case "pour la lettre": $tmp = ""; break;
   case "pour": $tmp = ""; break;
   case "Proposer évènement": $tmp = ""; break;
   case "Proposer un évènement": $tmp = ""; break;
   case "Pour ajouter des dates, sélectionner le(s) jour(s) dans le calendrier": $tmp = ""; break;
   case "Résumé de l'évènement": $tmp = ""; break;
   case "Recherche": $tmp = ""; break;
   case "Résumé": $tmp = ""; break;
   case "Retour édition catégorie": $tmp = ""; break;
   case "Retour au calendrier": $tmp = ""; break;
   case "Retour au jour": $tmp = ""; break;
   case "Retour": $tmp = ""; break;
   case "S": $tmp = ""; break;
   case "Sam": $tmp = ""; break;
   case "Sauver les modifications": $tmp = ""; break;
   case "Sélectionner catégorie": $tmp = ""; break;
   case "Sélectionnez une catégorie, cliquez pour modifier": $tmp = ""; break;
   case "Sélectionner si nécessaire": $tmp = "S"; break;
   case "Sélection région ou département": $tmp = ""; break;
   case "Etape 1 : Sélectionner vos dates": $tmp = ""; break;
   case "Sem": $tmp = ""; break;
   case "SEPTEMBRE": $tmp = ""; break;
   case "Septembre": $tmp = ""; break;
   case "Statut": $tmp = ""; break;
   case "Categorie": $tmp = ""; break;
   case "Supercache": $tmp = ""; break;
   case "Supprimer la catégorie": $tmp = ""; break;
   case "Supprimer cet évènement": $tmp = ""; break;
   case "Supprimer": $tmp = ""; break;
   case "Temps du cache (en secondes)": $tmp = ""; break;
   case "Titre de la catégorie": $tmp = ""; break;
   case "Titre": $tmp = ""; break;
   case "Toussaint": $tmp = ""; break;
   case "Trier par": $tmp = ""; break;
   case "Un administrateur validera vos changements rapidement": $tmp = ""; break;
   case "Un évènement nouveau est à valider dans agenda": $tmp = "A new event is to be validated in the agenda"; break;
   case "V": $tmp = "F"; break;
   case "Validation après modification": $tmp = ""; break;
   case "Validation par l'admin": $tmp = ""; break;
   case "Valider": $tmp = ""; break;
   case "Vendredi Saint": $tmp = ""; break;
   case "Vide": $tmp = ""; break;
   case "Voir la fiche": $tmp = ""; break;
   case "Voir": $tmp = ""; break;
   case "Vos ajouts": $tmp = ""; break;
   case "Vous n'avez pas rempli les champs obligatoires": $tmp = ""; break;
   case "Vue annuelle": $tmp = ""; break;
   default: $tmp = "Necesita una traducción [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>