<?php
/**************************************************************************************************/
/* Module de gestion de galeries pour NPDS                                                        */
/* ===================================================                                            */
/* (c) 2004-2005 Tribal-Dolphin - http://www.tribal-dolphin.net                                   */
/* (c) 2007 Xgonin, Lopez - http://modules.npds.org                                               */
/* MAJ conformité XHTML pour REvolution 10.02 par jpb/phr en mars 2010                            */
/* MAJ Dev - 2011                                                                                 */
/*                                                                                                */
/* This program is free software. You can redistribute it and/or modify it under the terms of     */
/* the GNU General Public License as published by the Free Software Foundation; either version 2  */
/* of the License.                                                                                */
/**************************************************************************************************/
if (stristr($_SERVER['PHP_SELF'],"imgalea.php")) { die(); }
/**************************************************************************************************/
/* Page du block                                                                                  */
/**************************************************************************************************/
/* appel du bloc gauche ou droite: include#modules/npds_galerie/imgalea.php                         */
/**************************************************************************************************/
global $language, $NPDS_Prefix;
$ModPath="npds_galerie";
include_once("modules/$ModPath/lang/$language.php");

   if (isset($user)) {
      $tab_groupe = valid_group($user);
      $tab_groupe[] = 1;
   }
   if (isset($admin) && $admin!="") {
      $tab_groupe[] = 127;
   }
   $tab_groupe[] = 0;

   // Fabrication de la requête 1
   $where1="";
   $count = count($tab_groupe); $i = 0;
   while (list($X, $val) = each($tab_groupe)) {
      $where1.= "(acces='$val')";
      $i++;
      if ($i < $count) {$where1.= " OR ";}
   }
   $query = sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_gal WHERE $where1");
   // Fabrication de la requête 2
   $where2="";
   $count = sql_num_rows($query); $i = 0;
   while ($row = sql_fetch_row($query)) {
      $where2.= "(gal_id='$row[0]')";
      $i++;
      if ($i < $count) {$where2.= " OR ";}
   }
   $query = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE $where2 ORDER BY RAND() LIMIT 0,1");
   $row = sql_fetch_row($query);

   // Affichage
   $image=$row[2];
   $comment=$row[3];
   list($gallery)=sql_fetch_row(sql_query("SELECT nom FROM ".$NPDS_Prefix."tdgal_gal WHERE id='$row[1]'"));

   $chemin="modules/$ModPath/imgs/".$image;
   list($width, $height, $type, $attr) = @getimagesize("$chemin");
   $h_i = $height+40;
   $w_i = $width+40;

   if (file_exists($chemin)) {
      if ($width>100) $width=100;
      $ibid ='<img class="img-fluid card-img-top center-block" src="modules/'.$ModPath.'/imgs/'.$image.'" border="0" />';
   }

   $content ='<div class="card">';
   if ($image!="") {
      $content .= '<span data-toggle="modal" data-target="#photomodal"><span data-toggle="tooltip" data-placement="bottom" title="'.gal_trans("Cliquer sur image").'">'.$ibid.'</span></span>';
   echo '
   <div class="modal fade" id="photomodal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
         '.$ibid.'
         </div>
      </div>
   </div>';
   } else {
      $content .= '<p class="card-text text-xs-center">'.gal_trans("vous avez accès à aucune galerie").'</p>';
   }
   $content .='<div class="card-block"><p class="card-text text-xs-center"><a class="" data-toggle="tooltip" data-placement="bottom" title="'.gal_trans("Accès à la galerie").'" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=gal&amp;op=gal&amp;galid='.$row[1].'">';
   $content .= stripslashes("$gallery");
   $content .='</a></p>';
   $content .='</div></div>';
?>