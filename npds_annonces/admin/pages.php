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

$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=index*']['title']="[french]Petites Annonces[/french][english]Ads[/english]+|$title+";
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=index*']['run']="yes";

$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=list_ann*']['title']="[french]Petites Annonces[/french][english]Ads[/english]+|$title+";
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=list_ann*']['run']="yes";


$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=annonce_form*']['title']="[french]Petites Annonces[/french][english]Ads[/english]+|$title+";
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=annonce_form*']['run']="yes";
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=annonce_form*']['TinyMce']=1;
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=annonce_form*']['TinyMce-theme']="short";

$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=modif_ann*']['title']="[french]Petites Annonces[/french][english]Ads[/english]+|$title+";
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=modif_ann*']['run']="yes";
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=modif_ann*']['TinyMce']=1;
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=modif_ann*']['TinyMce-theme']="short";

$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=admin*']['title']="[french]Petites Annonces[/french][english]Ads[/english]+|$title+";
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=admin*']['run']="yes";
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=admin*']['TinyMce']=1;
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=admin*']['TinyMce-theme']="full";

?>