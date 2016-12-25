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
   settype($id_cat,"integer");
   settype($num_ann,"integer");
   $categorie=removeHack(StripSlashes($categorie));
   $inf=$min+1;
   if (($min+$max)>=$num_ann) {
      $sup=$num_ann;
   } else {
      $sup=$min+$max;
   }

   echo '<div class="card"><div class="card-block">';
   echo '<p class="lead">'.$mess_acc.'</p>';
   
   
   if ( $num_ann > 1 ){ $pluriel = "s"; }
   echo "<p><span class=\"label label-default\">$inf à $sup &nbsp;&nbsp; Il y a $num_ann annonce$pluriel en ligne dans : <strong>$categorie</strong></span></p>";
   include ("modules/$ModPath/include/search_form.inc");
   include ("modules/$ModPath/include/annonce.inc");

   if (!isset($min))
      $min=0;
   settype ($min, "integer");
   settype ($max, "integer");

   $query="select * from $table_annonces where id_cat='$id_cat' and en_ligne='1' order by id desc limit $min,$max";
   $select = sql_query($query);
   aff_annonces($select);

   $categorie=urlencode($categorie);

   $pp=false;
   if ($min>0) {
      echo "<p><a class=\"btn btn-secondary btn-sm\" href='modules.php?ModPath=$ModPath&amp;ModStart=list_ann&amp;id_cat=$id_cat&amp;categorie=$categorie";
      echo "&amp;min=".($min-$max)."&amp;num_ann=".$num_ann."'>";
      echo "Page pr&eacute;c&eacute;dente</a>&nbsp;&nbsp;";
      $pp=true;
   }
   if (($min+$max)<$num_ann) {
      echo "<a class=\"btn btn-secondary btn-sm\" href='modules.php?ModPath=$ModPath&amp;ModStart=list_ann&amp;id_cat=$id_cat&amp;categorie=$categorie";
      echo "&amp;min=".($min+$max)."&amp;num_ann=".$num_ann."'>";

      echo "Page suivante</a>&nbsp;&nbsp;";
   }
   echo '</p>';
   echo '<p><a class="btn btn-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=index"><i class="fa fa-home" aria-hidden="true"></i> Retour</a></p>';

   echo '</div></div>';
   include ("footer.php");
?>