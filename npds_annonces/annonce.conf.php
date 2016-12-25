<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/*                                                                      */
/* NPDS Copyright (c) 2002-2015 by Philippe Brunier                     */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* Module npds_annonces 3.0                                             */
/*                                                                      */
/*                                                                      */
/* Basé sur gadjo_annonces v 1.2 - Adaptation 2008 par Jireck et lopez  */
/* MAJ conformité XHTML pour REvolution 10.02 par jpb/phr en mars 2010  */
/* MAJ Dev - 2011                                                       */
/* Changement de nom du module version Rev16 par jpb/phr mars 2016      */
/************************************************************************/

$GS_version='3.0';

global $NPDS_Prefix;
$table_cat=$NPDS_Prefix."g_categories"; // table des catégories
$table_annonces=$NPDS_Prefix."g_annonces"; // table des annonces

$editeur=true;     // intégration des éditeurs (y compris de TinyMce) - true or false

$aff_prix=true;    // affichage de la zone de saisie du Prix - true or false
$prix_cur='€uros'; // nom de la monnaie courante

$max=5; // nombre max d'annonces par pages
$obsol=6; // nombre de mois avant destruction d'une annonce

// message du moteur de recherche
$mess_no_result='<p class="text-danger">Aucune annonce ne correspond à votre recherche</p>';

// chapeau de la page d'accueil
$mess_acc='Petites annonces du site '.$Titlesitename.'';

// chapeau de la page de choix d'un utilisateur
$del_sup_chapo='A partir de cette page, vous pouvez ajouter, modifier ou supprimer votre ou vos annonce(s).';
$warning='Attention, la suppression est irréversible, la modification d\'une annonce la remet en attente pour validation.';

//pour le pages de formulaire
$mess_requis='<p>Merci de remplir tous les champs marqués d\'un <span class="text-danger"><i class="fa fa-asterisk"></i></span></p>';
?>