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

// cartouche de sécurité ==> requis !!
if (!strstr($PHP_SELF,'admin.php')) { Access_Error(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}


$f_meta_nom ='npds_annonces';
//==> controle droit
admindroits($aid,$f_meta_nom);
//<== controle droit

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

   $query="SELECT id FROM $table_annonces WHERE en_ligne='1'";
   $result= sql_query($query);
   $num_ann_total= sql_num_rows($result);

   $query="SELECT id FROM $table_annonces WHERE en_ligne='0'";
   $result= sql_query($query);
   $num_ann_apub_total= sql_num_rows($result);

   $query="SELECT id FROM $table_annonces WHERE en_ligne='2'";
   $result= sql_query($query);
   $num_ann_archive_total= sql_num_rows($result);

   GraphicAdmin($hlpfile);

   echo '<div id="adm_men">';   

   echo $mess_acc;
   
   echo '<h3>Administration des P.A</h3>';

   echo '<hr />';

   echo '<h4 class="lead">Annonces en ligne
         <span class="badge badge-pill badge-success float-right">'.$num_ann_total.'</span></h4>';
   echo '<h4 class="lead">Annonces à valider
         <span class="badge badge-pill badge-warning float-right">'.$num_ann_apub_total.'</span></h4>';
   echo '<h4 class="lead">Annonces archivées
         <span class="badge badge-pill badge-danger float-right">'.$num_ann_archive_total.'</span></h4>';

   echo '<hr />';

   echo "<p><a href=\"admin.php?op=Extend-Admin-SubModule&ModPath=$ModPath&ModStart=admin/adm_cat\" class=\"btn btn-outline-primary btn-sm\">Ajouter ou modifier une catégorie</a></p>";

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
   $select= sql_query("SELECT * FROM $table_cat WHERE id_cat2='0' ORDER BY id_cat");
   while ($i= sql_fetch_assoc($select)) {
      echo '<div class="card my-3">';

      $id_cat=$i[id_cat];
      $categorie=stripslashes($i[categorie]);
   echo '
    <div class="card-header" role="tab" id="">
      <h5 class="mb-0">
        <a data-toggle="collapse" data-parent="#'.$id_cat.'" href="#cat_'.$id_cat.'" aria-expanded="true" aria-controls="cat_'.$id_cat.'">';
      echo '<strong><i data-toggle="tooltip" data-placement="top" title="Cliquer pour déplier" class="toggle-icon fa fa-caret-down"></i></a><small class="text-muted"> Catégorie</small> ';
	  echo '<a data-toggle="tooltip" data-placement="top" title="Cliquer pour administrer" href="admin.php?op=Extend-Admin-SubModule&ModPath='.$ModPath.'&ModStart=admin/adm_ann&id_cat='.$id_cat.'">';	  
      echo $categorie;
      echo '</a></strong>';
      if (!$num_ann[$id_cat]) $num_ann[$id_cat]=0;
      if (!$num_ann_apub[$id_cat]) $num_ann_apub[$id_cat]=0;
      if (!$num_ann_archive[$id_cat]) $num_ann_archive[$id_cat]=0;
//      echo '<span class="badge badge-default float-right"><span class="text-success">'.$num_ann[$id_cat].'</span> / <span class="text-warning">'.$num_ann_apub[$id_cat].'</span> / <span class="text-danger">'.$num_ann_archive[$id_cat].'</span></span></h5>';
	  
      echo '<span data-toggle="tooltip" data-placement="left" title="Annonces archivées dans la catégorie" class="badge badge-danger float-right">'.$num_ann_archive[$id_cat].'</span><span data-toggle="tooltip" data-placement="left" title="Annonces à valider dans la catégorie" class="badge badge-warning mx-2 float-right">'.$num_ann_apub[$id_cat].'</span><span data-toggle="tooltip" data-placement="left" title="Annonces en ligne dans la catégorie" class="badge badge-success float-right">'.$num_ann[$id_cat].'</span></h5>';	  
   echo '</div>'; 

      $select2= sql_query("SELECT * FROM $table_cat WHERE id_cat2='$id_cat' ORDER BY id_cat");
   echo '<div id="cat_'.$id_cat.'" class="collapse" role="tabpanel" aria-labelledby="heading_'.$id_cat.'">';

      while ($i2= sql_fetch_assoc($select2)) {
		 $id_cat=$i2[id_cat];		  
      echo '<div class="my-2 mx-3 px-1">';
         echo '<h5><small class="text-muted"> Sous-catégorie</small> ';
         echo '<a data-toggle="tooltip" data-placement="top" title="Cliquer pour administrer" href="admin.php?op=Extend-Admin-SubModule&ModPath='.$ModPath.'&ModStart=admin/adm_ann&id_cat='.$id_cat.'">';
		 echo stripslashes($i2[categorie]);
		 echo '</a>';
         if (!$num_ann[$id_cat]) $num_ann[$id_cat]=0;
         if (!$num_ann_apub[$id_cat]) $num_ann_apub[$id_cat]=0;
         if (!$num_ann_archive[$id_cat]) $num_ann_archive[$id_cat]=0;
//         echo '<span class="badge badge-default float-right"><span class="text-success">'.$num_ann[$id_cat].'</span> / <span class="text-warning">'.$num_ann_apub[$id_cat].' / <span class="text-danger">'.$num_ann_archive[$id_cat].'</span></span></h5>';

      echo '<span data-toggle="tooltip" data-placement="left" title="Annonces archivées dans la sous-catégorie" class="badge badge-danger float-right">'.$num_ann_archive[$id_cat].'</span><span data-toggle="tooltip" data-placement="left" title="Annonces à valider dans la sous-catégorie" class="badge badge-warning mx-2 float-right">'.$num_ann_apub[$id_cat].'</span><span data-toggle="tooltip" data-placement="left" title="Annonces en ligne dans la sous-catégorie" class="badge badge-success float-right">'.$num_ann[$id_cat].'</span></h5>';


         echo '</div>';
      }
      echo "</div></div>";
   }

   echo '<div><p><a href="modules.php?ModPath='.$ModPath.'&ModStart=index" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> P.A en ligne</a></p></div>';

   echo '</div>';

   include ("footer.php");
?>