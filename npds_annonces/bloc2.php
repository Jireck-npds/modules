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

$ModPath='npds_annonces';
include ("modules/$ModPath/annonce.conf.php");

if ($title=='') $title="[french]Petites Annonces[/french] [english]Offers[/english]";

$result = sql_query("SELECT id_cat, count(en_ligne) FROM $table_annonces WHERE en_ligne='1' GROUP BY id_cat");
while (list($cat, $count) = sql_fetch_row($result)) {
   $num_ann[$cat]=$count;
   $num_ann_total+=$count;
}

$content = '<p class="text-center "><span class="badge badge-pill badge-default">'.$num_ann_total.'</span> [french]annonce(s)[/french] [english]offer(s)[/english] [french]publiée(s)[/french] [english]published[/english]</p>';
   $content .= '<p class="text-center"><a href="modules.php?ModPath=npds_annonces&amp;ModStart=index" class="btn btn-outline-primary btn-sm">[french]Consulter[/french] [english]Consult[/english]</a>';

if ($user)
   $content .=' <a href="modules.php?ModPath=npds_annonces&amp;ModStart=annonce_form" class="btn btn-outline-primary btn-sm">[french]Ajouter[/french] [english]Add[/english]</a>';

   $content .='</p>';

if ($admin) 
   $content .='<p class="text-center"><a class="btn btn-outline-primary btn-sm" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath=npds_annonces&amp;ModStart=admin/adm"><i class="fa fa-cogs" aria-hidden="true"></i> [french]Admin[/french] [english]Admin[/english]</a></p>';
   $content = aff_langue($content);
?>