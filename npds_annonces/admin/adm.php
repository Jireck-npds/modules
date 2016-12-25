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
if (!strstr($PHP_SELF,'admin.php')) { Access_Error(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}

include ("modules/$ModPath/annonce.conf.php");

// Creation automatique des tables
$result=sql_list_tables();
while (list($table)=sql_fetch_row($result)) {
   $tables[]=$table;
}
if (!array_search($table_cat,$tables)) {
   $sql_query="CREATE TABLE IF NOT EXISTS ".$table_cat." (
     id_cat mediumint(11) NOT NULL auto_increment,
     id_cat2 mediumint(11) NOT NULL default '0',
     categorie varchar(30) NOT NULL default '',
     KEY id (id_cat)
     )";
   $result = sql_query($sql_query);
}
if (!array_search($table_annonces,$tables)) {
   $sql_query="CREATE TABLE IF NOT EXISTS ".$table_annonces." (
     id bigint(20) NOT NULL auto_increment,
     id_user bigint(20) default NULL,
     id_cat mediumint(11) default NULL,
     tel varchar(20) NOT NULL default '',
     tel_2 varchar(20) NOT NULL default '',
     code varchar(5) NOT NULL default '',
     ville varchar(40) NOT NULL default '',
     date varchar(20) NOT NULL default '',
     text mediumtext NOT NULL,
     en_ligne TINYINT(1) NOT NULL DEFAULT '0',
     prix DECIMAL (10,2) NOT NULL DEFAULT '0',
     KEY id (id)
     )";
   $result = sql_query($sql_query);
}
// Creation automatique des tables

   $query="select id from $table_annonces where en_ligne='1'";
   $result= sql_query($query);
   $num_ann_total= sql_num_rows($result);

   $query="select id from $table_annonces where en_ligne='0'";
   $result= sql_query($query);
   $num_ann_apub_total= sql_num_rows($result);

   $query="select id from $table_annonces where en_ligne='2'";
   $result= sql_query($query);
   $num_ann_archive_total= sql_num_rows($result);

   echo '<div class="row" id="adm_men">';
   echo '<p class="lead">'.$mess_acc.'</p>';
   echo '<ul class="list-group">';
   echo '<li class="list-group-item"><h4>Nombre d\'annonces en ligne
         <span class="label label-default pull-xs-right">'.$num_ann_total.'</span></h4></li>';
   echo '<li class="list-group-item"><h4>Nombre d\'annonces &agrave; valider
         <span class="label label-default pull-xs-right text-danger">'.$num_ann_apub_total.'</span></h4></li>';
   echo '<li class="list-group-item"><h4>Nombre d\'annonces archiv&eacute;es
         <span class="label label-default pull-xs-right">'.$num_ann_archive_total.'</span></h4></li>';
   echo '</ul>';
   echo '<hr />';
   echo "<p><a href=\"admin.php?op=Extend-Admin-SubModule&ModPath=$ModPath&ModStart=admin/adm_cat\" class=\"btn btn-primary-outline btn-sm\">Ajouter ou modifier une cat&eacute;gorie</a></p>";
   
   echo '<hr />';

   $result= sql_query("SELECT id_cat, count(en_ligne) FROM $table_annonces WHERE en_ligne='1' GROUP BY id_cat");
   while (list($cat, $count)= sql_fetch_row($result)) {
      $num_ann[$cat]=$count;
   }
   $result= sql_query("SELECT id_cat, count(en_ligne) FROM $table_annonces WHERE en_ligne='0' GROUP BY id_cat");
   while (list($cat, $count)= sql_fetch_row($result)) {
      $num_ann_apub[$cat]=$count;
   }
   $result= sql_query("SELECT id_cat, count(en_ligne) FROM $table_annonces WHERE en_ligne='2' GROUP BY id_cat");
   while (list($cat, $count)= sql_fetch_row($result)) {
      $num_ann_archive[$cat]=$count;
   }
   $select= sql_query("select * from $table_cat where id_cat2='0' order by id_cat");
   while ($i= sql_fetch_assoc($select)) {
      echo '<ul class="list-group">';
      $id_cat=$i[id_cat];
      $categorie=stripslashes($i[categorie]);

      echo '<li class="list-group-item list-group-item-info">
      <h4><strong>'.$categorie.'</strong>';
      if (!$num_ann[$id_cat]) $num_ann[$id_cat]=0;
      if (!$num_ann_apub[$id_cat]) $num_ann_apub[$id_cat]=0;
      if (!$num_ann_archive[$id_cat]) $num_ann_archive[$id_cat]=0;
      echo "<span class=\"label label-default pull-xs-right\">$num_ann[$id_cat] / <span class=\"text-danger\">$num_ann_apub[$id_cat]</span> / $num_ann_archive[$id_cat]</span></h4>\n";

      echo '<a href="admin.php?op=Extend-Admin-SubModule&ModPath='.$ModPath.'&ModStart=admin/adm_ann&id_cat='.$id_cat.'" class="btn btn-primary-outline btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editer</a>';
      echo "</li>\n";
      $select2= sql_query("select * from $table_cat where id_cat2='$id_cat' order by id_cat");
      while ($i2= sql_fetch_assoc($select2)) {
         
         echo "<ul class=\"list-group\"><li class=\"list-group-item\"><h4><em>".stripslashes($i2[categorie])."</em>\n";
         $id_cat=$i2[id_cat];
         if (!$num_ann[$id_cat]) $num_ann[$id_cat]=0;
         if (!$num_ann_apub[$id_cat]) $num_ann_apub[$id_cat]=0;
         if (!$num_ann_archive[$id_cat]) $num_ann_archive[$id_cat]=0;
         echo "<span class=\"label label-default pull-xs-right\">$num_ann[$id_cat] / <span class=\"text-danger\">$num_ann_apub[$id_cat]</span> / $num_ann_archive[$id_cat]</span></h4>\n";

         echo "<a href='admin.php?op=Extend-Admin-SubModule&ModPath=$ModPath&ModStart=admin/adm_ann&id_cat=".$id_cat."' class=\"btn btn-primary-outline btn-sm\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> Editer</a>\n";
         echo '</li></ul>';
      }
      echo "<br /></ul>";
   }
   echo '<br />';
   echo '<p><a href="modules.php?ModPath='.$ModPath.'&ModStart=index" class="btn btn-primary-outline"><i class="fa fa-eye" aria-hidden="true"></i> P.A en ligne</a></p>';

   echo '</div>';
   include ("footer.php");
?>