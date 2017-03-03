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
if (stristr($_SERVER['PHP_SELF'],"imgalea_priv.php")) { die(); }
/**************************************************************************************************/
/* Page du block                                                                                  */
/**************************************************************************************************/
/* appel du bloc gauche ou droite: include#modules/td-galerie/imgalea.php                         */
/**************************************************************************************************/
global $language, $NPDS_Prefix;
$ModPath="npds_galerie";
include_once("modules/$ModPath/lang/$language.php");

//Fonction d'affichage dans un popup
$content  =  "<script type=\"text/javascript\">\n//<![CDATA[\n";
$content .= "function picview(chemin, image, comment, iwidth, iheight)";
$content .= "{";
$content .=  "if (iheight>screen.height) {";
$content .= "iheight=screen.height-100;";
$content .= "}";
$content .= "if (iwidth>screen.width) {";
$content .= "iwidth=screen.width-60;";
$content .= "}";
$content .= " var windowTitle= comment;";
$content .= " ";
$content .= " var TheComment= comment;";
$content .= " var CouleurFont = \"#FFFAEA\";";
$content .= " var CouleurBord = \"#ffefdb\";";
$content .= " var CouleurComment = \"#000000\";";
$content .= " var windowHeight = iheight ;";
$content .= " var windowWidth = iwidth ;";
$content .= " var globalURL = chemin  ;";
$content .= " var t = \"\";";
$content .= " theWindow = window.open(\"\",\"_blank\",\"toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,width=\"+windowWidth+\",height=\"+windowHeight+\",screenX=0,left=0,screenY=0,top=0\");";
$content .= " t += \"<html><head><title>\" + unescape(windowTitle) + \"</title></head><body>\\n\";   ";
$content .= " t += \"<a href=\\\"javascript:self.close()\\\" onmouseover=\\\"window.status='fermer'\\; return true\\\">\\n\";";
$content .= " t += \"<p align=\\\"center\\\"><img src=\\\"\" + globalURL + \"\\\" border=\\\"0\\\" alt=\\\"Cliquez sur l'image pour fermer la fenetre.\\\" /></a></p>\\n\";";
$content .= " t += \"</body></html>\\n\";";
$content .= " theWindow.document.clear();";
$content .= " theWindow.document.write(t);";
$content .= " theWindow.document.close();";
$content .= "}";
$content .= "\n//]]>\n</script>";

   if (isset($user)) {
      $tab_groupe = valid_group($user);
      $tab_groupe[] = 1;
   }
   if (isset($admin) && $admin!="") {
      $tab_groupe[] = 127;
   }
   $tab_groupe[] = 0;

   // Fabrication de la requête 1 pour prise en compte des droits d'accès aux galeries
   $where1="";
   $count = count($tab_groupe); $i = 0;
   while (list($X, $val) = each($tab_groupe)) {
      $where1.= "(acces='$val')";
      $i++;
      if ($i < $count) {$where1.= " OR ";}
   }
   
   // Modif pour prendre en compte les droits d'accès dans l'affichage de l'image dans le bloc
   // si anonyme: on ne prend pas en compte la requête 1
   // si membre: on prend ses droits d'accès en compte pour l'affichage
   if (isset($user)) {
      $query = sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_gal WHERE $where1");
   } else {
      $query = sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_gal");
   }
   
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
   list($gallery)=sql_fetch_row(sql_query("select nom from ".$NPDS_Prefix."tdgal_gal where id='$row[1]'"));
   list($gal_acces)=sql_fetch_row(sql_query("select acces from ".$NPDS_Prefix."tdgal_gal where id='$row[1]'"));

   $chemin="modules/$ModPath/imgs/".$image;
   list($width, $height, $type, $attr) = @getimagesize("$chemin");
   $h_i = $height+40;
   $w_i = $width+40;

   if (file_exists($chemin)) {
      if ($width>100) $width=100;
      $ibid ='<img class="img-fluid card-img-top" src="modules/'.$ModPath.'/imgs/'.$image.'" border="0" />';
   }

   //Affichage de l'image
   $content .='<div class="card">';
   if ($image!="") {
      $content .="<a href=\"javascript:picview('$chemin', '$image', '$comment', '$w_i', '$h_i')\">$ibid</a>";
   } else {
      $content .="<p class=\"card-text text-xs-center\">".gal_translate("vous n'avez accés à aucune galerie")."</p>";
   }

   //Affichage de l'invite de connexion dans le bloc si galerie privée
   if( (!isset($user) and $gal_acces!=0)) { /* 0 pour accès public */
       $content .="<div class=\"card-block\"><p class=\"card-text text-xs-center\"><a href=\"user.php\">".gal_translate("Galerie Privée, connectez vous")."</a></p>";
       $content .='</div></div>';
   } else {
       $content .="<div class=\"card-block\"><p class=\"card-text text-xs-center\"><a href=\"modules.php?ModPath=$ModPath&ModStart=gal&op=gal&galid=$row[1]\">".$gallery."</a></p>";
       $content .='</div></div>';
   }
?>