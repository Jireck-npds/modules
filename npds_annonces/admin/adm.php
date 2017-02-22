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
include ("modules/$ModPath/lang/annonces-$language.php");

// Création automatique des tables
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
// Création automatique des tables

   $result= sql_query("SELECT id FROM $table_annonces WHERE en_ligne='1'");
   $num_ann_total= sql_num_rows($result);
   $result= sql_query("SELECT id FROM $table_annonces WHERE en_ligne='0'");
   $num_ann_apub_total= sql_num_rows($result);
   $result= sql_query("SELECT id FROM $table_annonces WHERE en_ligne='2'");
   $num_ann_archive_total= sql_num_rows($result);

   GraphicAdmin($hlpfile);

   echo '
   <div id="adm_men">';
   echo aff_langue($mess_acc);
   echo '
   <p class="lead">'.ann_translate("Annonces en ligne").'<span class="badge badge-success float-right">'.$num_ann_total.'</span></p>
   <p class="lead">'.ann_translate("Annonces à valider").'<span class="badge badge-danger float-right">'.$num_ann_apub_total.'</span></p>
   <p class="lead">'.ann_translate("Annonces archivées").'<span class="badge badge-default float-right">'.$num_ann_archive_total.'</span></p>
   <hr />
   <p><a href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm_cat" class="btn btn-outline-primary btn-sm">'.ann_translate("Ajouter ou modifier une catégorie").'</a></p>
   <hr />';

   $result= sql_query("SELECT id_cat, COUNT(en_ligne) FROM $table_annonces WHERE en_ligne='1' GROUP BY id_cat");
   while (list($cat, $count)= sql_fetch_row($result)) {
      $num_ann[$cat]=$count;
   }
   $result= sql_query("SELECT id_cat, COUNT(en_ligne) FROM $table_annonces WHERE en_ligne='0' GROUP BY id_cat");
   while (list($cat, $count)= sql_fetch_row($result)) {
      $num_ann_apub[$cat]=$count;
   }
   $result= sql_query("SELECT id_cat, COUNT(en_ligne) FROM $table_annonces WHERE en_ligne='2' GROUP BY id_cat");
   while (list($cat, $count)= sql_fetch_row($result)) {
      $num_ann_archive[$cat]=$count;
   }

   $select= sql_query("SELECT * FROM $table_cat WHERE id_cat2='0' ORDER BY id_cat");
   while ($i= sql_fetch_assoc($select)) {
      $allcat=array('');
      $sous_content='';
      $id_cat=$i['id_cat'];
      $allcat[]=$i['id_cat'];
      $categorie=stripslashes($i['categorie']);
      $select2= sql_query("SELECT * FROM $table_cat WHERE id_cat2='$id_cat' ORDER BY id_cat");
      $cumu_num_ann=0;$cumu_num_ann_apub=0;$cumu_num_ann_archive=0;
      $content .= '
      <div class="card my-3">
         <div class="card-header" role="tab" id="">
            <h5 class="mb-0">
           <a data-toggle="collapse" data-parent="#'.$id_cat.'" href="#cat_'.$id_cat.'" aria-expanded="true" aria-controls="cat_'.$id_cat.'"><i data-toggle="tooltip" data-placement="top" title="'.ann_translate("Cliquer pour déplier").'" class="toggle-icon fa fa-caret-down fa-lg mr-2"></i></a>';
      while ($i2= sql_fetch_assoc($select2)) {
         $id_catx=$i2['id_cat'];
         $allcat[]=$i2['id_cat'];
         $categoriex=stripslashes($i2['categorie']);
         $sous_content .='
            <div class="my-2 mx-3 px-1">
               <h5>
                  <a data-toggle="tooltip" data-placement="top" title="'.ann_translate("Cliquer pour administrer").'" href="admin.php?op=Extend-Admin-SubModule&ModPath='.$ModPath.'&ModStart=admin/adm_ann&id_cat='.$id_catx.'"><span class="ml-1 pl-4">'.$categoriex.'</span></a>
                  <span class="float-right">
                     <span data-toggle="tooltip" data-placement="left" title="'.ann_translate("Annonces archivées dans la sous-catégorie").'" class="badge badge-default mr-2">'.$num_ann_archive[$id_catx].'</span>
                     <span data-toggle="tooltip" data-placement="left" title="'.ann_translate("Annonces à valider dans la sous-catégorie").'" class="badge badge-danger mr-2">'.$num_ann_apub[$id_catx].'</span>
                     <span data-toggle="tooltip" data-placement="left" title="'.ann_translate("Annonces en ligne dans la sous-catégorie").'" class="badge badge-success">'.$num_ann[$id_catx].'</span>
                  </span>
               </h5>
            </div>';
         $cumu_num_ann += $num_ann[$id_catx];
         $cumu_num_ann_apub += $num_ann_apub[$id_catx];
         $cumu_num_ann_archive += $num_ann_archive[$id_catx];
      }
      $oo = trim(implode("|", $allcat),'|');
      if ($cumu_num_ann!=($num_ann[$id_cat]+$cumu_num_ann) or $cumu_num_ann_apub!=($num_ann_apub[$id_cat]+$cumu_num_ann_apub))
         $sous_content .='
            <div class="my-2 mx-3 px-1">
               <h5>
                  <a data-toggle="tooltip" data-placement="top" title="'.ann_translate("Cliquer pour administrer").'" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm_ann&amp;id_cat='.$id_cat.'"><span class="ml-1 pl-4">'.ann_translate("Autres").'</span></a>
                  <span class=" float-right">
                     <span class="badge badge-danger mr-2">'.(($num_ann_apub[$id_cat]-$cumu_num_ann_apub)+($cumu_num_ann_apub)).'</span>
                     <span class="badge badge-success">'.(($num_ann[$id_cat]-$cumu_num_ann)+($cumu_num_ann)).'</span>
                  </span>
               </h5>
            </div>';
      $content .=  '
            <a data-toggle="tooltip" data-placement="top" title="'.ann_translate("Cliquer pour administrer").'" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm_ann&amp;id_cat='.$oo.'">'.$categorie.'</a>
            <span class=" float-right">
               <span data-toggle="tooltip" data-placement="left" title="'.ann_translate("Annonces archivées dans la catégorie").'" class="badge badge-default mr-2">'.($num_ann_archive[$id_cat]+$cumu_num_ann_archive).'</span>
               <span data-toggle="tooltip" data-placement="left" title="'.ann_translate("Annonces à valider dans la catégorie").'" class="badge badge-danger mr-2">'.($num_ann_apub[$id_cat]+$cumu_num_ann_apub).'</span>
               <span data-toggle="tooltip" data-placement="left" title="'.ann_translate("Annonces en ligne dans la catégorie").'" class="badge badge-success">'.($num_ann[$id_cat]+$cumu_num_ann).'</span>
            </span>
         </h5>
         </div>
         <div id="cat_'.$id_cat.'" class="collapse" role="tabpanel" aria-labelledby="heading_'.$id_cat.'">';
   $content .= $sous_content;
   $content .='
         </div>
      </div>';
   }
   echo $content;
   echo '
      <div><p><a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=index" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> '.ann_translate("P.A en ligne").'</a></p></div>
   </div>';
   include ("footer.php");
?>