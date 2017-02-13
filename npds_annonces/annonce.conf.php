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
/* Module npds_annonces 3.0                                             */
/*                                                                      */
/*                                                                      */
/* Basé sur gadjo_annonces v 1.2 - Adaptation 2008 par Jireck et lopez  */
/* MAJ conformité XHTML pour REvolution 10.02 par jpb/phr en mars 2010  */
/* MAJ Dev - 2011                                                       */
/* Changement de nom du module version Rev16 par jpb/phr janv 2017      */
/************************************************************************/

$GS_version='3.0';

global $language, $NPDS_Prefix;


// table des catégories
$table_cat=$NPDS_Prefix."g_categories";

// table des annonces
$table_annonces=$NPDS_Prefix."g_annonces";

// intégration de TinyMce - true or false
$editeur=true;

// affichage de la zone de saisie du Prix - true or false
$aff_prix=true;

// nom de la monnaie courante
$prix_cur='[french]€uro(s)[/french] [english]€uro(s)[/english]';

// nombre max d'annonces par pages
$max=3;

// nombre de mois avant destruction d'une annonce
$obsol=1;

// message du moteur de recherche
$mess_no_result='[french]Aucune annonce ne correspond à votre recherche[/french] [english]No ads found corresponding to your search[/english]';

// chapeau de la page d'accueil
$mess_acc='<h2><img src="modules/npds_annonces/npds_annonces.png" alt="icon_npds_annonces"> [french]Petite(s) annonce(s)[/french] [english]Offer(s)[/english]  '.$Titlesitename.'</h2>';

// chapeau de la page de choix d'un utilisateur
$del_sup_chapo='[french]A partir de cette page, vous pouvez ajouter, modifier ou supprimer vos annonce(s)[/french] [english]From this page you can add, modify or delete your ad (s)[/english]';

$warning='[french]Attention, la suppression est irréversible, la modification d\'une annonce la remet en attente pour validation[/french] [english]The deletion is irreversible, the modification of an announcement puts it back on hold for validation[/english]';

//pour le pages de formulaire
$mess_requis='[french]Merci de remplir tous les champs marqués d\'un[/french] [english]Please fill all fields marked with[/english] <span class="text-danger"><i class="fa fa-asterisk"></i></span>';
?>