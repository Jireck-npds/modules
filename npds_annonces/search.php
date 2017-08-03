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

include ("modules/$ModPath/annonce.conf.php");
include ("modules/$ModPath/lang/annonces-$language.php");
   include ("header.php");
   echo '<div class="card"><div class="card-body">';
echo '<p class="lead">'.aff_langue($mess_acc).'</p>';
   include ("modules/$ModPath/include/search_form.php");
   include ("modules/$ModPath/include/annonce.php");
   $search=removeHack(stripslashes(htmlentities(urldecode($search), ENT_NOQUOTES))); // electrobug
   $search = trim($search);
   $search = str_replace('+', ' ', $search);
   $search = str_replace('\'', ' ', $search);
   $search = str_replace(',', ' ', $search);
   $search = str_replace(':', ' ', $search);
   $search = strtoupper($search);
   $search = explode(' ',$search);
   $tot=count($search);
   $query= "SELECT COUNT(*) FROM $table_annonces WHERE UPPER(text) LIKE '%$search[0]%'";
   for ($i=1; $i<$tot; $i++) {
      $query.=" OR TEXT LIKE '%$search[$i]%'";
   }
   $query.=" AND en_ligne='1'";
   $res = sql_query($query);
   $count = sql_fetch_row($res);
   $nombre=$count[0];

   if (!isset($min))
      $min=0;
   if ($nombre==0) {
      echo '<p class="lead text-danger"><i class="fa fa-circle" aria-hidden="true"></i> '.aff_langue($mess_no_result).'</p>';
   } else {
      $inf=$min+1;
      if (($min+$max)>=$nombre) {
         $sup=$nombre;
      } else {
         $sup=$min+$max;
      }
      echo '<p class="lead"><i class="fa fa-circle" aria-hidden="true"></i> Annonces <span class="badge badge-primary">'.$inf.' à '.$sup.'</span> sur <span class="badge badge-secondary">'.$nombre.'</span> correspondant à votre recherche</p>';
   }

   $query="SELECT * FROM $table_annonces WHERE UPPER(text) LIKE '%$search[0]%'";
   for ($i=1; $i<$tot; $i++) {
      $query.=" OR TEXT LIKE '%$search[$i]%'";
   }
   $query .=" AND en_ligne='1' ORDER BY id DESC LIMIT $min,$max";
   $select = sql_query($query);
   aff_annonces($select);

   $search = implode('+',$search);

   $pp=false;
  
    echo '<ul class="pagination pagination-sm">
            <li class="page-item disabled">
               <a class="page-link" href="#" aria-label="Annonces(s)">'.$nombre.' '.ann_translate("Annonces(s)").'</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">'.$inf.' à '.$sup.'</a></li>';	
   
   if ($min>0) {
      echo '<li class="page-item"><a class="page-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=search&amp;min='.($min-$max).'&amp;search='.$search.'">'.ann_translate("Précédente").'</a></li>';
      $pp=true;
   }
   if (($min+$max)<$nombre) {
      echo '<li class="page-item"><a class="page-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=search&amp;min='.($min+$max).'&amp;search='.$search.'">'.ann_translate("Suivante").'</a></li>';
   }
    echo '</ul>';  
   
   echo '<p><a class="btn btn-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=index"><i class="fa fa-home" aria-hidden="true"></i> '.ann_translate("Retour").'</a></p>';
   echo '</div></div>';
include ("footer.php");
?>