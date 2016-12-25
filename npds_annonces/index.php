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

// For More security
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security

include ("modules/$ModPath/annonce.conf.php");

include ("header.php");
   echo '<div class="card"><div class="card-block">';
   echo '<p class="lead">'.$mess_acc.'</p>';

// Purge
$obsol=time()-($obsol*25*86400);
$query="UPDATE $table_annonces set en_ligne='2' where (date<'$obsol')";
$succes= sql_query($query);

include ("modules/$ModPath/include/search_form.inc");

$result= sql_query("SELECT id_cat, count(en_ligne) FROM $table_annonces WHERE en_ligne='1' GROUP BY id_cat");
while (list($cat, $count)= sql_fetch_row($result)) {
$num_ann[$cat]=$count;
}
$result = sql_query("SELECT id_cat, count(en_ligne) FROM $table_annonces WHERE en_ligne='0' GROUP BY id_cat");
while (list($cat, $count)= sql_fetch_row($result)) {
$num_ann_apub[$cat]=$count;
$num_ann_apub_total+=$count;
}
$result= sql_query("SELECT id_cat, count(en_ligne) FROM $table_annonces WHERE en_ligne='2' GROUP BY id_cat");
while (list($cat, $count)= sql_fetch_row($result)) {
$num_ann_archive[$cat]=$count;
}

echo '<h3>Nombre d\'annonces en ligne par cat&eacute;gorie</h3>';

if (($admin) and $num_ann_apub_total>0) {
   echo '<p>Information pour l\'administrateur <a class="btn btn-danger-outline btn-sm" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm">'.$num_ann_apub_total.' annonce(s) &agrave; valider</a></p>';
}

$select= sql_query("select * from $table_cat where id_cat2='0' order by id_cat");
while ($i= sql_fetch_assoc($select)) {

   echo '<ul class="list-group">';
$id_cat=$i['id_cat'];
$categorie=stripslashes($i['categorie']);

   echo '<li class="list-group-item list-group-item-info">
      <h4><strong>'.$categorie.'</strong>';
if (!$num_ann[$id_cat]) $num_ann[$id_cat]=0;
if (!$num_ann_apub[$id_cat]) $num_ann_apub[$id_cat]=0;
if (!$num_ann_archive[$id_cat]) $num_ann_archive[$id_cat]=0;
   echo "<span class=\"label label-default pull-xs-right\">$num_ann[$id_cat]</span></h4>";

if ($num_ann>0)
   echo "<a class=\"btn btn-primary-outline btn-sm\" href='modules.php?ModPath=$ModPath&amp;ModStart=list_ann&amp;id_cat=$id_cat&amp;categorie=".urlencode($categorie)."&amp;num_ann=$num_ann[$id_cat]'><i class=\"fa fa-eye\" aria-hidden=\"true\"></i> Voir</a>";
   echo '</li>';
$select2= sql_query("select * from $table_cat where id_cat2='$id_cat' order by id_cat");
while ($i2= sql_fetch_assoc($select2)) {

$id_cat=$i2['id_cat'];
$categorie=stripslashes($i2['categorie']);

   echo '<ul class="list-group"><li class="list-group-item"><h4><em>'.$categorie.'</em>';
if (!$num_ann[$id_cat]) $num_ann[$id_cat]=0;
if (!$num_ann_apub[$id_cat]) $num_ann_apub[$id_cat]=0;
if (!$num_ann_archive[$id_cat]) $num_ann_archive[$id_cat]=0;
   echo "<span class=\"label label-default pull-xs-right\">$num_ann[$id_cat]</span></h4>";
if ($num_ann>0)
   echo "<a class=\"btn btn-primary-outline btn-sm\" href='modules.php?ModPath=$ModPath&amp;ModStart=list_ann&amp;id_cat=$id_cat&amp;categorie=".urlencode($categorie)."&amp;num_ann=$num_ann[$id_cat]'><i class=\"fa fa-eye\" aria-hidden=\"true\"></i> Voir</a>";
   echo "</li></ul>";
}
   echo "<br /></ul>";
}

if ($admin)
   echo '<br /><p><a class="btn btn-primary btn-sm" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm"><i class="fa fa-cogs" aria-hidden="true"></i> Admin</a></p>';
   
   echo '</div></div>';
include ("footer.php");
?>