<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/*                                                                      */
/* NPDS Copyright (c) 2002-2017 by Philippe Brunier                     */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/* Module de gestion de galeries pour NPDS                              */
/*                                                                      */
/* (c) 2004-2005 Tribal-Dolphin - http://www.tribal-dolphin.net         */
/* (c) 2007 Xgonin, Lopez - http://modules.npds.org                     */
/* MAJ conformité XHTML pour REvolution 10.02 par jpb/phr en mars 2010  */
/* MAJ Dev - 2011                                                       */
/* npds_galerie v 3.0                                                   */
/* Changement de nom du module version Rev16 par jpb/phr mars 2017      */
/************************************************************************/

// Dimension max des images
$MaxSizeImg = 1000;

// Dimension max des images miniatures
$MaxSizeThumb = 300;

// Nombre d'images par ligne
$imglign = 4;

// Nombre de photos par page
$imgpage = 4;

// Nombre d'images à afficher dans le top commentaires
$nbtopcomment = 5;

// Nombre d'images à afficher dans le top votes
$nbtopvote = 5;

// Personnalisation de l'affichage
$view_alea = false;
$view_last = false;
$aff_vote = true;
$aff_comm = true;

// Autorisations pour les anonymes
$vote_anon = true;
$comm_anon = true;
$post_anon = true;

// Notification admin par email de la proposition
$notif_admin = true;

// Version du module
$npds_gal_version = "V 3.0";
?>