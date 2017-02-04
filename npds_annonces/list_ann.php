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

   include ("header.php");
   if(!strstr($id_cat, '|')) {
      $q ="='$id_cat'";
      settype($id_cat,"integer");
   } else {
      $q =" REGEXP '[[:<:]]".str_replace('|', '[[:>:]]|[[:<:]]',$id_cat)."[[:>:]]'";
   }

//   settype($id_cat,"integer");
   settype($num_ann,"integer");
   $categorie=removeHack(StripSlashes($categorie));
   $inf=$min+1;
   if (($min+$max)>=$num_ann) {
      $sup=$num_ann;
   } else {
      $sup=$min+$max;
   }

   echo '
   <div class="card">
      <div class="card-block">
         <p class="lead">'.$mess_acc.'</p>';


   if ( $num_ann > 1 ){ $pluriel = "s"; }
   echo '<p class="lead">'.$inf.' à '.$sup.' &nbsp;&nbsp; Il y a <span class="badge badge-default">'.$num_ann.'</span> annonce'.$pluriel.' en ligne dans : <strong>'.$categorie.'</strong></p>';
   include ("modules/$ModPath/include/search_form.php");
   include ("modules/$ModPath/include/annonce.php");

   if (!isset($min))
      $min=0;
   settype ($min, "integer");
   settype ($max, "integer");

   $query="SELECT * FROM $table_annonces WHERE id_cat$q AND en_ligne='1' ORDER BY id DESC LIMIT $min,$max";

//   $query="SELECT * FROM $table_annonces WHERE id_cat='$id_cat' AND en_ligne='1' ORDER BY id DESC LIMIT $min,$max";
   $select = sql_query($query);
   aff_annonces($select);

   $categorie=urlencode($categorie);

   $pp=false;
   if ($min>0) {
      echo "<p><a class=\"btn btn-secondary btn-sm\" href='modules.php?ModPath=$ModPath&amp;ModStart=list_ann&amp;id_cat=$id_cat&amp;categorie=$categorie";
      echo "&amp;min=".($min-$max)."&amp;num_ann=".$num_ann."'>";
      echo "Page précédente</a>&nbsp;&nbsp;";
      $pp=true;
   }
   if (($min+$max)<$num_ann) {
      echo "<a class=\"btn btn-secondary btn-sm\" href='modules.php?ModPath=$ModPath&amp;ModStart=list_ann&amp;id_cat=$id_cat&amp;categorie=$categorie";
      echo "&amp;min=".($min+$max)."&amp;num_ann=".$num_ann."'>";

      echo "Page suivante</a>&nbsp;&nbsp;";
   }
   echo '</p>';
   echo '<p><a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=index"><i class="fa fa-home" aria-hidden="true"></i> Retour</a></p>';

   echo '</div></div>';
   include ("footer.php");
?>