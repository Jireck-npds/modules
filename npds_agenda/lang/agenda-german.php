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
/* Traductions pagestec                                                 */
/************************************************************************/

function ag_translate($phrase) {
   switch ($phrase) {
   case "A valider": $tmp = "Zur Validierung"; break;
   case "Accès catégorie(s)": $tmp = "Zugang Kategorie"; break;
   case "Accueil": $tmp = "Willkommen"; break;
   case "Agenda": $tmp = "Tagebuch"; break;
   case "Ajout événement pour": $tmp = "Hinzufügen + Group"; break;
   case "1 : tous les membres ou n° id groupe": $tmp = "Hinzufügen Ereignis: 1 Alle Mitglieder - oder Gruppe"; break;
   case "Ajouter une catégorie": $tmp = "Kategorie hinzufügen"; break;
   case "Allemand" : $tmp = "Deutsch"; break;
   case "Anglais" : $tmp = "Englisch"; break;
   case "Année": $tmp = "Jahr"; break;
   case "Août": $tmp = "August"; break;
   case "AOUT": $tmp = "AUGUST"; break;
   case "Armistice 14-18": $tmp = "Waffenstillstand 14-18"; break;
   case "Armistice 39-45": $tmp = "Waffenstillstand 39-45"; break;
   case "Assomption": $tmp = "Assomption"; break;
   case "Aucun événement trouvé": $tmp = "Keine Termine gefunden"; break;
   case "Auteur": $tmp = "Autor"; break;
   case "Autre(s)": $tmp = "Andere(s)"; break;
   case "Autres": $tmp = "Andere"; break;
   case "AVRIL": $tmp = "APRIL"; break;
   case "Avril": $tmp = "April"; break;
   case "Calendrier": $tmp = "Kalender"; break;
   case "Catégories": $tmp = "Kategorien"; break;
   case "Catégorie": $tmp = "Kategorien"; break;
   case "Cet événement est maintenant effacé": $tmp = "Dieses Ereignis wurde nun gelöscht worden"; break;
   case "Cet événement est mis à jour": $tmp = "Dieses Ereignis wird aktualisiert"; break;
   case "Cet événement dure 1 jour": $tmp = "Diese Veranstaltung ist ein 1 Tag"; break;
   case "Cet événement dure plusieurs jours": $tmp = "Diese Veranstaltung dauert mehrere Tage"; break;
   case "Cet événement est maintenant effacé": $tmp = "Dieses Ereignis wird jetzt gelöscht"; break;
   case "Chemin des images": $tmp = "Bilder Straßenbau"; break;
   case "Choix catégorie": $tmp = "Wahl der Kategorie"; break;
   case "Chinois" : $tmp = "Chinesisch"; break;
   case "Cliquez pour éditer": $tmp = "Klicken Sie bearbeiten"; break;
   case "Configuration": $tmp = "Konfiguration"; break;
   case "Confirmez la suppression": $tmp = "Bestätigen Sie das Löschen"; break;
   case "D": $tmp = "S"; break;
   case "Décembre": $tmp = "Dezember"; break;
   case "Date": $tmp = "Datum"; break;
   case "DECEMBRE": $tmp = "DEZEMBER"; break;
   case "Description complète": $tmp = "Ausführliche Beschreibung"; break;
   case "Description": $tmp = "Beschreibung"; break;
   case "Editer un événement": $tmp = "Bearbeiten Sie ein Ereignis"; break;
   case "Editer": $tmp = "bearbeiten"; break;
   case "En Ligne": $tmp = "Online"; break;
   case "Espagnol" : $tmp = "Spanish"; break;
   case "Etape 1 : Séléctionner vos dates": $tmp = "Schritt 1: Wählen Sie Ihre Termine"; break;
   case "Etape 2 : Remplisser le formulaire": $tmp = "Schritt 2: Füllen Sie das Formular"; break;
   case "Etes-vous certain de vouloir supprimer cet événement": $tmp = "Sind Sie sicher, dass Sie dieses Ereignis zu löschen?"; break;
   case "Etre averti par mèl d'une proposition": $tmp = "Being per E-Mail an neue Ereignisse informiert"; break;
   case "Evénement": $tmp = "Ereignis"; break;
   case "Evénement(s) à venir": $tmp = "Die nächsten Veranstaltung"; break;
   case "Evénement(s) en cours ou passé(s)": $tmp = "aktuelle Ereignisse oder Vergangenheit"; break;
   case "Evénement nouveau dans agenda": $tmp = "neue Ereignisse in Kalender"; break;
   case "Février": $tmp = "Februar"; break;
   case "Fête du travail": $tmp = "Der Tag der Arbeit"; break;
   case "Fête nationale": $tmp = "Nationalfeiertag"; break;
   case "FEVRIER": $tmp = "FEBRUAR"; break;
   case "Fonctions": $tmp = "Funktionen"; break;
   case "Français" : $tmp = "Französisch"; break;
   case "Groupe": $tmp = "Gruppe"; break;
   case "Hors Ligne": $tmp = "offline"; break;
   case "ID": $tmp = "ID"; break;
   case "Image de la catégorie": $tmp = "Bild für die Kategorie"; break;
   case "J": $tmp = "D"; break;
   case "JANVIER": $tmp = "JANUAR"; break;
   case "Janvier": $tmp = "Januar"; break;
   case "Jeu": $tmp = "Spiel"; break;
   case "Jeudi de l'ascension": $tmp = "Christi Himmelfahrt"; break;
   case "Jour avec événement(s)": $tmp = "Day-Event mit"; break;
   case "Jour de l'an": $tmp = "Neujahr"; break;
   case "Jour férié": $tmp = "Urlaub"; break;
   case "Jour(s) sélectionné(s)": $tmp = "ausgewählten Tag"; break;
   case "JUILLET": $tmp = "JULI"; break;
   case "Juillet": $tmp = "Juli"; break;
   case "JUIN": $tmp = "JUNI"; break;
   case "Juin": $tmp = "Juni"; break;
   case "L": $tmp = "M"; break;
   case "La catégorie est créée": $tmp = "Die Kategorie wird erstellt"; break;
   case "La catégorie est effacée": $tmp = "Die Kategorie wird gelöscht"; break;
   case "La catégorie est mise à jour": $tmp = "Die Kategorie wird aktualisiert"; break;
   case "Les préférences pour l'agenda ont été enregistrées": $tmp = "Voreinstellungen für die Tagesordnung aufgenommen wurden"; break;
   case "Lieu": $tmp = "Platz"; break;
   case "Liste des événements": $tmp = "Liste der Veranstaltungen"; break;
   case "Liste de vos événements": $tmp = "Listen Sie Ihre Veranstaltungen"; break;
   case "Lundi de Pâques": $tmp = "Ostermontag"; break;
   case "Lundi de Pentecôte": $tmp = "Pfingstmontag"; break;
   case "M ": $tmp = "M "; break;
   case "M": $tmp = "D"; break;
   case "MAI": $tmp = "MAI"; break;
   case "Mai": $tmp = "Mai"; break;
   case "Email du destinataire": $tmp = "Mail-Empfänger"; break;
   case "Mar": $tmp = "Die"; break;
   case "Mars": $tmp = "März"; break;
   case "MARS": $tmp = "MARZ"; break;
   case "Mer": $tmp = "Mit"; break;
   case "Merci pour votre contribution, un administrateur la validera rapidement": $tmp = "Vielen Dank für Ihren Beitrag, wird ein Administrator bestätigen die schnell"; break;
   case "Modification événement pour agenda": $tmp = "Veranstaltung Agenda für den Wandel"; break;
   case "Modifier l'Evénement": $tmp = "Ereignis bearbeiten"; break;
   case "Modifier la catégorie": $tmp = "Kategorie wechseln"; break;
   case "Nombre d'évènement(s) par page (administration)": $tmp = "Anzahl der Ereignisse (admin)"; break;
   case "Nombre d'évènement(s) par page (utilisateur)": $tmp = "Anzahl der Ereignisse (user)"; break;
   case "Noël": $tmp = "Weihnachten"; break;
   case "NON": $tmp = "NEIN"; break;
   case "Non": $tmp = "Nein"; break;
   case "npds_agenda": $tmp = "npds_Tagebuch"; break;
   case "NOVEMBRE": $tmp = "NOVEMBER"; break;
   case "Novembre": $tmp = "November"; break;
   case "OCTOBRE": $tmp = "OKTOBER"; break;
   case "Octobre": $tmp = "Oktober"; break;
   case "OUI": $tmp = "JA"; break;
   case "Oui": $tmp = "Ja"; break;
   case "Par ville": $tmp = "Nach stadt"; break;
   case "par ville": $tmp = "nach stadt"; break;
   case "Par ville (défaut)": $tmp = "Nach stadt"; break;
   case "Par": $tmp = "Durch"; break;
   case "Pas de catégorie": $tmp = "Keine Kategorie"; break;
   case "Pas de catégorie ajoutée": $tmp = "Keine Kategorie hinzugefügt"; break;
   case "Posté par": $tmp = "Gepostet von"; break;
   case "pour la lettre": $tmp = "auf den Brief"; break;
   case "pour": $tmp = "für"; break;
   case "Proposer événement": $tmp = "Senden einer Veranstaltung"; break;
   case "Proposer un événement": $tmp = "Senden einer Veranstaltung"; break;
   case "Pour ajouter des dates, sélectionner le(s) jour(s) dans le calendrier": $tmp = "So fügen Sie Termine, wählen Sie den Tag im Kalender"; break;
   case "Résumé de l'événement": $tmp = "Ereignis-Übersicht"; break;
   case "Recherche": $tmp = "Suche"; break;
   case "Résumé": $tmp = "Zusammenfassung"; break;
   case "Retour édition catégorie": $tmp = "Zurück Verlags Kategorie"; break;
   case "Retour au calendrier": $tmp = "Zurück zum Kalender"; break;
   case "Retour au jour": $tmp = "Zurück in den Tag"; break;
   case "Retour": $tmp = "Rückkehr"; break;
   case "S": $tmp = "S"; break;
   case "Saisie obligatoire": $tmp = "Pflichtfeld"; break;
   case "Sam": $tmp = "Sam"; break;
   case "Sauver les modifications": $tmp = "Änderungen speichern"; break;
   case "Sélectionner catégorie": $tmp = "Seleccione categoría"; break;
   case "Sélectionnez une catégorie, cliquez pour modifier": $tmp = "Wählen Sie eine Kategorie, klicken Sie bearbeiten"; break;
   case "Sélection région ou département": $tmp = "Auswählen Region oder Abteilung"; break;
   case "Etape 1 : Sélectionner vos dates": $tmp = "Schritt 1: Wählen Sie Ihre Termine"; break;
   case "Sem": $tmp = "Woc"; break;
   case "SEPTEMBRE": $tmp = "SEPTEMBER"; break;
   case "Septembre": $tmp = "September"; break;
   case "Statut": $tmp = "Status"; break;
   case "Categorie": $tmp = "Kategorie"; break;
   case "Supercache": $tmp = "super Cache"; break;
   case "Supprimer la catégorie": $tmp = "Kategorie löschen"; break;
   case "Supprimer cet événement": $tmp = "Dieses Ereignis löschen"; break;
   case "Supprimer": $tmp = "entfernen"; break;
   case "Temps du cache (en secondes)": $tmp = "Cache-Zeit in Sekunden"; break;
   case "Titre de la catégorie": $tmp = "Kategorie Titel"; break;
   case "Titre": $tmp = "Titel"; break;
   case "Toussaint": $tmp = "Tous"; break;
   case "Trier par": $tmp = "Sortieren nach"; break;
   case "Un administrateur validera vos changements rapidement": $tmp = "Ein Administrator, um die Änderungen zu validieren schnell"; break;
   case "Un événement nouveau est à valider dans agenda": $tmp = "Ein neues Ereignis ist in der Tagesordnung zur Validierung"; break;
   case "V": $tmp = "F"; break;
   case "Validation après modification": $tmp = "Validierung nach Änderung"; break;
   case "Validation par l'admin": $tmp = "Validierung durch den Administrator"; break;
   case "Valider": $tmp = "bestätigen"; break;
   case "Vendredi Saint": $tmp = "Karfreitag"; break;
   case "Vide": $tmp = "leer"; break;
   case "Voir la fiche": $tmp = "Details sehen"; break;
   case "Voir": $tmp = "Ansicht"; break;
   case "Vos ajouts": $tmp = "Ihre Ergänzungen"; break;
   case "Vous n'avez pas rempli les champs obligatoires": $tmp = "Sie haben nicht die erforderlichen Felder ausgefüllt"; break;
   case "Vue annuelle": $tmp = "Jahr"; break;
   default: $tmp = "Es gibt keine Übersetzung [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>
