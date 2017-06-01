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
   case "A valider": $tmp = "A validar"; break;
   case "Accès catégorie(s)": $tmp = "categoría (s) de acceso"; break;
   case "Accueil": $tmp = "Recepción"; break;
   case "Agenda": $tmp = "Agenda"; break;
   case "Ajout événement pour": $tmp = "Adición + Grupo"; break;
   case "1 : tous les membres ou n° id groupe": $tmp = "La adición de evento: Todos los miembros - o grupo"; break;
   case "Ajouter une catégorie": $tmp = "Añadir categoría"; break;
   case "Allemand" : $tmp = "Alemán"; break;
   case "Anglais" : $tmp = "Inglés"; break;
   case "Année": $tmp = "Año"; break;
   case "Août": $tmp = "Augusto"; break;
   case "AOUT": $tmp = "AUGUSTO"; break;
   case "Armistice 14-18": $tmp = "Armisticio 14-18"; break;
   case "Armistice 39-45": $tmp = "39-45 armisticio"; break;
   case "Assomption": $tmp = "Suposición"; break;
   case "Aucun événement trouvé": $tmp = "No se han encontrado eventos"; break;
   case "Auteur": $tmp = "Autor"; break;
   case "Autre(s)": $tmp = "Otro(s)"; break;
   case "Autres": $tmp = "Otro"; break;
   case "AVRIL": $tmp = "ABRIL"; break;
   case "Avril": $tmp = "Abril"; break;
   case "Calendrier": $tmp = "Calendario"; break;
   case "Catégories": $tmp = "Categorías"; break;
   case "Catégorie": $tmp = "Categoría"; break;
   case "Cet événement est maintenant effacé": $tmp = "Este evento se ha borrado"; break;
   case "Cet événement est mis à jour": $tmp = "Este evento se actualiza"; break;
   case "Cet événement dure 1 jour": $tmp = "Este evento es un 1 día"; break;
   case "Cet événement dure plusieurs jours": $tmp = "Este evento dura varios días"; break;
   case "Cet événement est maintenant effacé": $tmp = "Este evento se ha borrado"; break;
   case "Saisie obligatoire": $tmp = "Campo obligatorio"; break;
   case "Chemin des images": $tmp = "Imágenes de carreteras"; break;
   case "Choix catégorie": $tmp = "Categoría de elección"; break;
   case "Chinois" : $tmp = "Chino"; break;
   case "Cliquez pour éditer": $tmp = "Haga clic para editar"; break;
   case "Configuration": $tmp = "Configuración"; break;
   case "Confirmez la suppression": $tmp = "Confirmar la eliminación"; break;
   case "D": $tmp = "D"; break;
   case "Décembre": $tmp = "Diciembre"; break;
   case "Date": $tmp = "Fecha"; break;
   case "DECEMBRE": $tmp = "DICIEMBRE"; break;
   case "Description complète": $tmp = "Descripción completa"; break;
   case "Description": $tmp = "Descripción"; break;
   case "Editer un événement": $tmp = "Editar un evento"; break;
   case "Editer": $tmp = "Editar"; break;
   case "En Ligne": $tmp = "En línea"; break;
   case "Espagnol" : $tmp = "Español"; break;
   case "Etape 1 : Séléctionner vos dates": $tmp = "Paso 1: Seleccione sus fechas"; break;
   case "Etape 2 : Remplisser le formulaire": $tmp = "Paso 2: Rellene el formulario"; break;
   case "Etes-vous certain de vouloir supprimer cet événement": $tmp = "¿Está seguro de que desea eliminar este evento?"; break;
   case "Etre averti par mèl d'une proposition": $tmp = "Ser informado por correo electrónico de nuevos eventos"; break;
   case "Evénement": $tmp = "Evento"; break;
   case "Evénement(s) à venir": $tmp = "Evento próximo"; break;
   case "Evénement(s) en cours ou passé(s)": $tmp = "Eventos o pasado actuales"; break;
   case "Evénement nouveau dans agenda": $tmp = "Nuevos eventos en el calendario"; break;
   case "Février": $tmp = "Febrero"; break;
   case "Fête du travail": $tmp = "Fiesta del Trabajo"; break;
   case "Fête nationale": $tmp = "Fiesta Nacional"; break;
   case "FEVRIER": $tmp = "FEBRERO"; break;
   case "Fonctions": $tmp = "Funciones"; break;
   case "Français" : $tmp = "Francés"; break;
   case "Groupe": $tmp = "Grupo"; break;
   case "Hors Ligne": $tmp = "Fuera de linea"; break;
   case "ID": $tmp = "ID"; break;
   case "Image de la catégorie": $tmp = "Imagen para la categoría"; break;
   case "J": $tmp = "J"; break;
   case "JANVIER": $tmp = "ENERO"; break;
   case "Janvier": $tmp = "Enero"; break;
   case "Jeu": $tmp = "Jue"; break;
   case "Jeudi de l'ascension": $tmp = "Jueves de la ascensión"; break;
   case "Jour avec événement(s)": $tmp = "Evento de un día con"; break;
   case "Jour de l'an": $tmp = "Año Nuevo"; break;
   case "Jour férié": $tmp = "Día feriado"; break;
   case "Jour(s) sélectionné(s)": $tmp = "Día seleccionado"; break;
   case "JUILLET": $tmp = "JULIO"; break;
   case "Juillet": $tmp = "Julio"; break;
   case "JUIN": $tmp = "JUNIO"; break;
   case "Juin": $tmp = "Junio"; break;
   case "L": $tmp = "L"; break;
   case "La catégorie est créée": $tmp = "Se crea la categoría"; break;
   case "La catégorie est effacée": $tmp = "La categoría se borra"; break;
   case "La catégorie est mise à jour": $tmp = "La categoría se actualiza"; break;
   case "Les préférences pour l'agenda ont été enregistrées": $tmp = "Se registraron las preferencias de la agenda"; break;
   case "Lieu": $tmp = "Lugar"; break;
   case "Liste des événements": $tmp = "Lista de eventos"; break;
   case "Liste de vos événements": $tmp = "Lista de sus eventos"; break;
   case "Lundi de Pâques": $tmp = "Lunes de Pascua"; break;
   case "Lundi de Pentecôte": $tmp = "Lunes de Pentecostés"; break;
   case "M ": $tmp = "M "; break;
   case "M": $tmp = "M"; break;
   case "MAI": $tmp = "MAYO"; break;
   case "Mai": $tmp = "Mayo"; break;
   case "Email du destinataire": $tmp = "Destinatario de correo"; break;
   case "Mar": $tmp = "Mar"; break;
   case "Mars": $tmp = "Marzo"; break;
   case "MARS": $tmp = "MARZO"; break;
   case "Mer": $tmp = "Mié"; break;
   case "Merci pour votre contribution, un administrateur la validera rapidement": $tmp = "Gracias por su contribución, un administrador validará la rapidez"; break;
   case "Modification événement pour agenda": $tmp = "La agenda de actividades para el cambio"; break;
   case "Modifier l'Evénement": $tmp = "Editar Evento"; break;
   case "Modifier la catégorie": $tmp = "Cambio de categoría"; break;
   case "Nombre d'évènement(s) par page (administration)": $tmp = "Número de eventos (admin)"; break;
   case "Nombre d'évènement(s) par page (utilisateur)": $tmp = "Número de eventos (user)"; break;
   case "Noël": $tmp = "Navidad"; break;
   case "NON": $tmp = "NO"; break;
   case "Non": $tmp = "No"; break;
   case "npds_agenda": $tmp = "npds_agenda"; break;
   case "NOVEMBRE": $tmp = "NOVIEMBRE"; break;
   case "Novembre": $tmp = "Noviembre"; break;
   case "OCTOBRE": $tmp = "OCTUBRE"; break;
   case "Octobre": $tmp = "Octubre"; break;
   case "OUI": $tmp = "SÍ"; break;
   case "Oui": $tmp = "Si"; break;
   case "Par ville": $tmp = "Por la ciudad"; break;
   case "par ville": $tmp = "Por la ciudad"; break;
   case "Par ville (défaut)": $tmp = "Por la ciudad"; break;
   case "Par": $tmp = "Por"; break;
   case "Pas de catégorie": $tmp = "Sin categoría"; break;
   case "Pas de catégorie ajoutée": $tmp = "No se añadió la categoría"; break;
   case "Posté par": $tmp = "Publicado por"; break;
   case "pour la lettre": $tmp = "a la carta"; break;
   case "pour": $tmp = "para"; break;
   case "Proposer événement": $tmp = "Enviar un evento"; break;
   case "Proposer un événement": $tmp = "Enviar un evento"; break;
   case "Pour ajouter des dates, sélectionner le(s) jour(s) dans le calendrier": $tmp = "Para agregar fechas, seleccione el día en el calendario"; break;
   case "Résumé de l'événement": $tmp = "Resumen del evento"; break;
   case "Recherche": $tmp = "Búsqueda"; break;
   case "Résumé": $tmp = "Resumen"; break;
   case "Retour édition catégorie": $tmp = "Volver categoría editorial"; break;
   case "Retour au calendrier": $tmp = "Volver al calendario"; break;
   case "Retour au jour": $tmp = "De vuelta en el día"; break;
   case "Retour": $tmp = "Retorno"; break;
   case "S": $tmp = "S"; break;
   case "Sam": $tmp = "Sáb"; break;
   case "Sauver les modifications": $tmp = "Guardar cambios"; break;
   case "Sélectionner catégorie": $tmp = "Seleccione categoría"; break;
   case "Sélectionnez une catégorie, cliquez pour modifier": $tmp = "Seleccione una categoría, haga clic para editar"; break;
   case "Sélection région ou département": $tmp = "Selección de región o departamento"; break;
   case "Etape 1 : Sélectionner vos dates": $tmp = "Paso 1: Seleccione sus fechas"; break;
   case "Sem": $tmp = "Sem"; break;
   case "SEPTEMBRE": $tmp = "SEPTIEMBRE"; break;
   case "Septembre": $tmp = "Septiembre"; break;
   case "Statut": $tmp = "Estatus"; break;
   case "Categorie": $tmp = "Categoría"; break;
   case "Supercache": $tmp = "Super Cache"; break;
   case "Supprimer la catégorie": $tmp = "Eliminar categoría"; break;
   case "Supprimer cet événement": $tmp = "Eliminar este evento"; break;
   case "Supprimer": $tmp = "Quitar"; break;
   case "Temps du cache (en secondes)": $tmp = "Tiempo de caché en segundos"; break;
   case "Titre de la catégorie": $tmp = "Título de la categoría"; break;
   case "Titre": $tmp = "Título"; break;
   case "Toussaint": $tmp = "Toussaint"; break;
   case "Trier par": $tmp = "Ordenar por"; break;
   case "Un administrateur validera vos changements rapidement": $tmp = "Un administrador validará sus cambios de forma rápida"; break;
   case "Un événement nouveau est à valider dans agenda": $tmp = "Un nuevo evento es validar en la agenda"; break;
   case "V": $tmp = "V"; break;
   case "Validation après modification": $tmp = "Validación tras su modificación"; break;
   case "Validation par l'admin": $tmp = "Validación por el administrador"; break;
   case "Valider": $tmp = "Validar"; break;
   case "Vendredi Saint": $tmp = "Viernes Santo"; break;
   case "Vide": $tmp = "Vacía"; break;
   case "Voir la fiche": $tmp = "Ver detalles"; break;
   case "Voir": $tmp = "Ver"; break;
   case "Vos ajouts": $tmp = "Sus adiciones"; break;
   case "Vous n'avez pas rempli les champs obligatoires": $tmp = "No ha rellenado todos los campos requeridos"; break;
   case "Vue annuelle": $tmp = "Año"; break;
   default: $tmp = "Necesita una traducción [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>