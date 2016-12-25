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

include ("modules/npds_annonces/annonce.conf.php");

if ($title=="")
   $title="Petites Annonces";

global $long_chain;
if (!$long_chain) {$long_chain=20;}

$result = sql_query("SELECT id_cat, count(en_ligne) FROM $table_annonces WHERE en_ligne='1' GROUP BY id_cat");
while (list($cat, $count) = sql_fetch_row($result)) {
   $num_ann[$cat]=$count;
   $num_ann_total+=$count;
}
if ( $num_ann_total > 1 ){ $pluriel = "s"; }
$content = '<p class="text-xs-center "><span class="label label-default">Il y a '.$num_ann_total.' annonce'.$pluriel.' publi&eacute;e'.$pluriel.'</span>';
$content .= '<ul class="list-group">';
$select = sql_query("select * from $table_cat where id_cat2='0' order by id_cat");
while ($i= sql_fetch_assoc($select)) {
   $id_cat=$i['id_cat'];
   $categorie=stripslashes($i['categorie']);
   $content .= "<li class=\"list-group-item list-group-item-info\"><strong><a href=\"modules.php?ModPath=npds_annonces&amp;ModStart=list_ann&amp;id_cat=$id_cat&amp;categorie=".urlencode($categorie)."&amp;num_ann=$num_ann[$id_cat]\">".$categorie."</a></strong><span class=\"label label-default label-pill pull-xs-right\">".$num_ann[$id_cat]."</span></li>\n";
   $content .= '<ul class="list-group">';
   $select2=sql_query("select * from $table_cat where id_cat2='$id_cat' order by id_cat");
   while ($i2=sql_fetch_array($select2)) {
      $id_cat=$i2['id_cat'];
      $categorie=stripslashes($i2[categorie]);
      $content .= "<li class=\"list-group-item\"><em><a href=\"modules.php?ModPath=npds_annonces&amp;ModStart=list_ann&amp;id_cat=$id_cat&amp;categorie=".urlencode($categorie)."&amp;num_ann=$num_ann[$id_cat]\">".$categorie."</a></em><span class=\"label label-default label-pill pull-xs-right\">".$num_ann[$id_cat]."</span></li>\n";
   }
   $content .= '</ul><br />';
   }
$content .= "</ul>";
$content .= '<p class="text-xs-center"><a href="modules.php?ModPath=npds_annonces&amp;ModStart=index" class="btn btn-primary-outline btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Consulter</a>';
if ($user)
   $content .= '&nbsp;&nbsp;<a href="modules.php?ModPath=npds_annonces&amp;ModStart=annonce_form" class="btn btn-primary-outline btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter</a>';
$content .= '</p>';
if ($admin) {
   $content .= '<p class="text-xs-center"><a class="btn btn-primary-outline btn-sm" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath=npds_annonces&amp;ModStart=admin/adm"><i class="fa fa-cogs" aria-hidden="true"></i> Admin</a></p>';
}
?>