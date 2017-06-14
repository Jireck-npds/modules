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


// For More security
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security
   include ("modules/$ModPath/admin/pages.php");
include ("modules/$ModPath/annonce.conf.php");
include ("modules/$ModPath/lang/annonces-$language.php");

include ("header.php");
   echo '<div class="card"><div class="card-block">';
   echo '<p class="lead">'.aff_langue($mess_acc).'</p>';
   
// Purge
$obsol=time()-($obsol*25*86400);
$query="UPDATE $table_annonces SET en_ligne='2' WHERE (date<'$obsol')";
$succes= sql_query($query);

include ("modules/$ModPath/include/search_form.php");
settype($num_ann_apub_total,'integer');
settype($num_ann_total,'integer');
settype($content,'string');
settype($ibid,'integer');

$result= sql_query("SELECT id_cat, COUNT(en_ligne) FROM $table_annonces WHERE en_ligne='1' GROUP BY id_cat");
while (list($cat, $count)= sql_fetch_row($result)) {
$num_ann[$cat]=$count;
}
$result = sql_query("SELECT id_cat, COUNT(en_ligne) FROM $table_annonces WHERE en_ligne='0' GROUP BY id_cat");
while (list($cat, $count)= sql_fetch_row($result)) {
$num_ann_apub[$cat]=$count;
$num_ann_apub_total+=$count;
}
$result= sql_query("SELECT id_cat, COUNT(en_ligne) FROM $table_annonces WHERE en_ligne='2' GROUP BY id_cat");
while (list($cat, $count)= sql_fetch_row($result)) {
$num_ann_archive[$cat]=$count;
}

$result2 = sql_query("SELECT id_cat, COUNT(en_ligne) FROM $table_annonces WHERE en_ligne='1' GROUP BY id_cat");
while (list($cat, $count) = sql_fetch_row($result2)) {
   $num_ann[$cat]=$count;
   $num_ann_total+=$count;
}

echo '<p class="lead"><i class="fa fa-info-circle" aria-hidden="true"></i> '.ann_translate("Il y a").' <span class="badge badge-default">'.$num_ann_total.'</span> '.ann_translate("annonce(s)").' '.ann_translate("publiée(s)").'</p>';

$select= sql_query("SELECT * FROM $table_cat WHERE id_cat2='0' ORDER BY id_cat");
while ($i= sql_fetch_assoc($select)) {
   $allcat=array('');
   $sous_content='';
   $id_cat=$i['id_cat'];
   $allcat[]=$i['id_cat'];
   $categorie=stripslashes($i['categorie']);
   $select2= sql_query("SELECT * FROM $table_cat WHERE id_cat2='$id_cat' ORDER BY id_cat");
   $cumu_num_ann=0;
   $content .= '
   <div class="card my-3">
      <h6 class="card-header card-title">
         <a data-toggle="collapse" data-parent="#'.$id_cat.'" href="#catb3_'.$id_cat.'" aria-expanded="true" aria-controls="catb3_'.$id_cat.'"><i data-toggle="tooltip" data-placement="top" title="'.ann_translate("Cliquer pour déplier").'" class="toggle-icon fa fa-caret-down fa-lg mr-2"></i></a>';

   while ($i2= sql_fetch_assoc($select2)) {
      $id_catx=$i2['id_cat'];
      $allcat[]=$i2['id_cat'];
      $categoriex=stripslashes($i2['categorie']);
      $sous_content .='
         <div class="mb-2 mx-4 my-1">
            <a data-toggle="tooltip" data-placement="top" title="'.ann_translate("Cliquer pour visualiser").'" href="modules.php?ModPath=npds_annonces&amp;ModStart=list_ann&amp;id_cat='.$id_catx.'&amp;categorie='.urlencode($categoriex).'&amp;num_ann=';
      if(array_key_exists($id_catx,$num_ann))
         $sous_content .= $num_ann[$id_catx];
      $sous_content .='"><span class="ml-3">'.$categoriex.'</span>
            </a>
            <span class="badge badge-pill badge-default float-right">';
      if(array_key_exists($id_catx, $num_ann))
         $sous_content .= $num_ann[$id_catx];
      $sous_content.= '</span>
         </div>';
      if(array_key_exists($id_catx, $num_ann))
         $cumu_num_ann += $num_ann[$id_catx];
   }

   $oo = trim(implode('|', $allcat),'|');
   if(array_key_exists($id_cat, $num_ann)) $ibid = $num_ann[$id_cat]+$cumu_num_ann; else $ibid = $cumu_num_ann;
   if ($cumu_num_ann!=($ibid))

//   if ($cumu_num_ann!=($num_ann[$id_cat]+$cumu_num_ann))
      $sous_content .='
         <div class="mb-2 mx-4 my-1">
            <a data-toggle="tooltip" data-placement="top" title="'.ann_translate("Cliquer pour visualiser").'" href="modules.php?ModPath=npds_annonces&amp;ModStart=list_ann&amp;id_cat='.$id_cat.'&amp;categorie=&amp;num_ann='.(($num_ann[$id_cat]-$cumu_num_ann)+($cumu_num_ann)).'"><span class="ml-3">'.ann_translate("Autres").'</span></a>
            <span class="badge badge-pill badge-default float-right">'.(($num_ann[$id_cat]-$cumu_num_ann)+($cumu_num_ann)).'</span>
         </div>';
   $content .= '<a data-toggle="tooltip" data-placement="top" title="'.ann_translate("Cliquer pour visualiser").'" href="modules.php?ModPath=npds_annonces&amp;ModStart=list_ann&amp;id_cat='.$oo.'&amp;categorie='.$categorie.'&amp;num_ann='.$ibid.'">'.$categorie.'</a>
         <span class="badge badge-pill badge-default mr-1 float-right">'.$ibid.'</span>
      </h6>
      <div id="catb3_'.$id_cat.'" class="collapse" role="tabpanel" aria-labelledby="headingb3_'.$id_cat.'">';
/*
   echo '<i data-toggle="tooltip" data-placement="top" title="Cliquer pour déplier" class="toggle-icon fa fa-caret-down"></i></a> Catégorie :  ';

	echo '<a data-toggle="tooltip" data-placement="top" title="Cliquer pour visualiser les annonces de cette catégorie" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=list_ann&amp;id_cat='.$id_cat.'&amp;categorie='.urlencode($categorie).'&amp;num_ann='.$num_ann[$id_cat].'">';
   echo '<strong>'.$categorie;
   echo '</a></strong>';


if (!$num_ann[$id_cat]) $num_ann[$id_cat]=0;
if (!$num_ann_apub[$id_cat]) $num_ann_apub[$id_cat]=0;
if (!$num_ann_archive[$id_cat]) $num_ann_archive[$id_cat]=0;
   echo '<span class="badge badge-pill badge-default float-right">'.$num_ann[$id_cat].'</span>';
   echo '</h6>';

   echo '<div id="cat_'.$id_cat.'" class="collapse" role="tabpanel" aria-labelledby="heading_'.$id_cat.'">';
*/

   
   $content .= $sous_content;
   $content .='
      </div>
   </div>';
}
echo $content;
if (($admin) and $num_ann_apub_total>0)
   echo '<hr /><p><a class="btn btn-outline-warning btn-sm" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm">'.$num_ann_apub_total.' '.ann_translate("annonce(s) à valider").'</a></p>';
   echo '
      </div>
   </div>';
include ("footer.php");
?>