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

include ("modules/npds_annonces/annonce.conf.php");

if ($title=='') $title="Petites Annonces";

global $long_chain;
if (!$long_chain) {$long_chain=20;}

$result = sql_query("SELECT id_cat, COUNT(en_ligne) FROM $table_annonces WHERE en_ligne='1' GROUP BY id_cat");
while (list($cat, $count) = sql_fetch_row($result)) {
   $num_ann[$cat]=$count;
   $num_ann_total+=$count;
}

if ( $num_ann_total > 1 ){ $pluriel = "s"; }
$content = '<p class="text-center">Il y a <span class="badge badge-default">'.$num_ann_total.'</span> annonce'.$pluriel.' publiée'.$pluriel.'</span>';
$select = sql_query("SELECT * FROM $table_cat WHERE id_cat2='0' ORDER BY id_cat");
while ($i= sql_fetch_assoc($select)) {
   $allcat=array('');
   $sous_content='';
   $id_cat=$i['id_cat'];
   $allcat[]=$i['id_cat'];
   $categorie=stripslashes($i['categorie']);
   $select2=sql_query("SELECT * FROM $table_cat WHERE id_cat2='$id_cat' ORDER BY id_cat");
   $cumu_num_ann=0;
   $content .= '
   <div class="card my-3">
      <h6 class="card-header card-title">
         <a data-toggle="collapse" data-parent="#'.$id_cat.'" href="#catbb3_'.$id_cat.'" aria-expanded="true" aria-controls="catbb3_'.$id_cat.'"><i data-toggle="tooltip" data-placement="top" title="Cliquer pour déplier" class="toggle-icon fa fa-caret-down fa-lg mr-2"></i></a>';

   while ($i2=sql_fetch_array($select2)) {
      $id_catx=$i2['id_cat'];
      $allcat[]=$i2['id_cat'];
      $categoriex=stripslashes($i2[categorie]);
      $sous_content .='
         <div class="mb-2 mx-4 my-1">
            <a data-toggle="tooltip" data-placement="top" title="Cliquer pour visualiser" href="modules.php?ModPath=npds_annonces&amp;ModStart=list_ann&amp;id_cat='.$id_catx.'&amp;categorie='.urlencode($categoriex).'&amp;num_ann='.$num_ann[$id_catx].'">'.$categoriex.'</a>
            <span class="badge badge-pill badge-default float-right">'.$num_ann[$id_catx].'</span>
         </div>';
      $cumu_num_ann += $num_ann[$id_catx];
   }

   $oo = trim(implode("|", $allcat),'|');


   if ($cumu_num_ann!=($num_ann[$id_cat]+$cumu_num_ann))
      $sous_content .='
         <div class="mb-2 mx-4 my-1">
            <a data-toggle="tooltip" data-placement="top" title="Cliquer pour visualiser" href="modules.php?ModPath=npds_annonces&amp;ModStart=list_ann&amp;id_cat='.$id_cat.'&amp;categorie='.$categorie.'&amp;num_ann='.(($num_ann[$id_cat]-$cumu_num_ann)+($cumu_num_ann)).'">Autres</a>
            <span class="badge badge-pill badge-default float-right">'.(($num_ann[$id_cat]-$cumu_num_ann)+($cumu_num_ann)).'</span>
         </div>';
   $content .= '<a href="modules.php?ModPath=npds_annonces&amp;ModStart=list_ann&amp;id_cat='.$oo.'&amp;categorie='.$categorie.'&amp;num_ann='.($num_ann[$id_cat]+$cumu_num_ann).'">'.$categorie.'</a>
         <span class="badge badge-pill badge-default float-right">'.($num_ann[$id_cat]+$cumu_num_ann).'</span>
      </h6>
      <div id="catbb3_'.$id_cat.'" class="collapse" role="tabpanel" aria-labelledby="headingb3_'.$id_cat.'">';
   $content .= $sous_content;
   $content .='
      </div>
   </div>';
}
   $content .='
   <p class="text-center"><a href="modules.php?ModPath=npds_annonces&amp;ModStart=index" class="btn btn-outline-primary btn-sm">Consulter</a>';

if ($user)
   $content .=' <a href="modules.php?ModPath=npds_annonces&amp;ModStart=annonce_form" class="btn btn-outline-primary btn-sm">Ajouter</a>';
   $content .='
   </p>';
if ($admin) 
   $content .='
   <p class="text-center"><a class="btn btn-outline-primary btn-sm" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath=npds_annonces&amp;ModStart=admin/adm"><i class="fa fa-cogs" aria-hidden="true"></i> Admin P.A</a></p>';
?>