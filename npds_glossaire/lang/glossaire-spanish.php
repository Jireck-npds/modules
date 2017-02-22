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
   case "Français" : $tmp = "Francés"; break;
   case "Anglais" : $tmp = "Inglés"; break;
   case "Allemand" : $tmp = "Alemán"; break;
   case "Espagnol" : $tmp = "Española"; break;
   case "Chinois" : $tmp = "Chino"; break;
   case "Glossaire": $tmp = "Glosario"; break;
   case "Réponse(s)": $tmp = "Respuesta"; break;
   case "Définitions": $tmp = "Definiciones"; break;
   case "Termes": $tmp = "Condiciones"; break;
   case "Terme": $tmp = "Expresión"; break;
   case "Catégorie": $tmp = "Categoría"; break;
   case "Quelques définitions": $tmp = "Algunas definiciones"; break;
   case "Définition": $tmp = "Definiciones"; break;
   case "Soumettre une définition": $tmp = "Presentar una definición"; break;
   case "Une définition identique existe déjà !": $tmp = "Una definición idéntica ya existe !"; break;
   case "Liste des définitions": $tmp = "Lista de definiciones"; break;
   case "La base est vide": $tmp = "La base está vacía"; break;
   case "Configuration": $tmp = "Configuración"; break;
   case "Administration": $tmp = ""; break;
   case "Retour à l'administration": $tmp="Administración"; break;
   case "Meta": $tmp = "Meta"; break;
   case "Editer": $tmp = "editar"; break;
   case "Supprimer": $tmp = "Quitar"; break;
   case "Définitions par page": $tmp = "Definiciones por página"; break;
   case "Autorise la soumission": $tmp = "Autoriza la presentación"; break;
   case "Autorise la recherche": $tmp = "Autoriza la investigación"; break;
   case "Site internet": $tmp = "Sitio Internet"; break;
   case "Cliquer pour cacher ou déployer": $tmp = "Haga clic para ocultar o desplegar"; break;
   case "Sélectionner un dossier": $tmp = "Seleccionar carpeta"; break;
   case "Sélectionner": $tmp = "Seleccionar"; break;
   case "Rechercher par choix multiples": $tmp = "Búsqueda por opción múltiple"; break;
   case "Rechercher par lettre": $tmp = "Búsqueda por letra"; break;
   case "Merci pour votre proposition": $tmp = "Gracias por su propuesta"; break;
   case "Merci de respecter les consignes": $tmp = "Gracias Por favor, siga las instrucciones"; break;
   case "Tous": $tmp = "todos"; break;
   case "Valider": $tmp = "Validar"; break;
   case "Autres": $tmp = "Otro"; break;
   case "Validation ou suppression des demandes": $tmp = "Validación o deleción solicitudes"; break;
   case "Oui": $tmp = "sí"; break;
   case "Non": $tmp = "no"; break;
   case "Fonctions": $tmp = "funciones"; break;
   case "Liste des définitions dans la base de données": $tmp = "Lista de definiciones en la base de datos"; break;
   case "Validation ou suppression des demandes": $tmp = "Validación o deleción solicitudes"; break;   
   case "Edition d'une définition": $tmp = ""; break;
   default: $tmp = "Necesita una traducción [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>