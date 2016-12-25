<?php
/************************************************************************/
/* Module de gestion de galeries d'images pour NPDS                     */
/* ===========================                                          */
/*                                                                      */
/* npds_galerie configuration du module                                 */
/*                                                                      */
/************************************************************************/

// Dimension max des images
$MaxSizeImg = 1024;

// Dimension max des images miniatures
$MaxSizeThumb = 240;

// Nombre d'images par ligne
$imglign = 4;

// Nombre de photos par page
$imgpage = 8;

// Nombre d'images à afficher dans le top commentaires
$nbtopcomment = 5;

// Nombre d'images à afficher dans le top votes
$nbtopvote = 5;

// Personnalisation de l'affichage
$view_alea = true;
$view_last = true;
$aff_vote = true;
$aff_comm = true;

// Autorisations pour les anonymes
$vote_anon = true;
$comm_anon = true;
$post_anon = true;

// Notification admin par email de la proposition
$notif_admin = true;

// Version du module
$npds_gal_version = "3";
?>