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
/* npds_encapsuleur  v 5.0                                              */
/*                                                                      */
/* 05.01.2001 - martvin@box43.pl                                        */
/* 12.09.2002 - Achel_Jay, Benjee, Capcaverne                           */
/* 02.11.2002 - Snipe                                                   */
/* 25.11.2008 - Lopez - MAJ pouir Evolution                             */
/* 2010 et 2011 - Adaptation REvolution                                 */
/* Changement de nom du module version Rev16 par jpb/phr jan  2017      */
/************************************************************************/

if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}

include ("modules/$ModPath/lang/encapsuleur-$language.php");
include ("modules/$ModPath/encap.conf.php");

$iconinfo = '<i class="fa fa-info-circle mr-2" aria-hidden="true"></i>';
$message = 'Page en cours de cr&eacute;ation';
$message = html_entity_decode($message, ENT_COMPAT, 'UTF-8');

$pg=removeHack(stripslashes(urldecode($page)));

$result = sql_query("SELECT * FROM ".$NPDS_Prefix."encapsulation where nom = '$pg'");
if ($result) {
   global $pdst,$language;
   $data = sql_fetch_assoc($result);
   $pdst = $data['block'];
   $src = $data['form']."://".$data['adresse'];

   if ($data['type']=="interne") {
      $adr_site=str_replace('http://','',$nuke_url);
      if (substr($adr_site,strlen($adr_site)-1,1)=="/") {
         $adr_site=substr($adr_site,0,strlen($adr_site)-1);
      }
      $src = $data[form]."://".$adr_site."/".substr($static_url,2).$data[adresse];
   }

   include("header.php");
   
   $title  = '<h3>'.$data['titre'];
   $title .= '<a class="btn btn-secondary btn-sm float-right mb-2" href="'.$src.'" target="_blank">'.encap_translate("Pleine Page").'</a></h3>';

   echo '<div class="card"><div class="card-body">';

   if  ($data['display'] == 1) {
   $tit=$data['tit'];
   if ($tit==1) echo $title;

switch($data['type']) {
   case "interne" :
   if (($data['adresse']!="") and ($data['adresse'])) {
   if (preg_match('#[^a-zA-Z0-9-]#',$data['adresse']) and !stristr($data['adresse'],"..") and !stristr($data['adresse'], "script") and !stristr($data['adresse'], "cookie") and !stristr($data['adresse'], "iframe") and  !stristr($op, "applet") and !stristr($data['adresse'], "object") and !stristr($data['adresse'], "meta")) {
   if (file_exists($static_url.$data['adresse'])) {
   $src=$static_url.$data['adresse'];
   echo '<iframe class="embed-responsive-item" src="'.$src.'" name="'.$data['nom'].'" id="'.$data['nom'].'" width="100%" height="'.$data['height'].'" marginwidth="0" align="middle" scrolling="'.$data['scroll'].'" frameborder="'.$encap_bordint.'" title="'.$title.'"></iframe>';
   echo '<p><a class="btn btn-outline-primary btn-sm mt-2" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=printenc&amp;eid='.$data['id'].'"><i class="fa fa-print" aria-hidden="true"></i></a></p>';
   }
   }
   else {
   echo '<p class="lead">'.$iconinfo.''.encap_translate("Veuillez saisir les informations selon les spécifications").'</p>';
   }
   }
break;

case "externe" :
   echo '<iframe class="embed-responsive-item" src="'.$src.'" name="'.$data['nom'].'" id="'.$data['nom'].'" width="100%" height="'.$data['height'].'" marginwidth="0" align="middle" scrolling="'.$data['scroll'].'" frameborder="'.$encap_bordext.'" title="'.$title.'"></iframe>';
   echo '<p><a class="btn btn-outline-primary btn-sm mt-2" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=printenc&amp;eid='.$data['id'].'"><i class="fa fa-print" aria-hidden="true"></i></a></p>';
break;

default :
   echo '<iframe class="embed-responsive-item" src="'.$src.'" name="'.$data['nom'].'" id="'.$data['nom'].'" width="100%" height="'.$data['height'].'" marginwidth="0" align="middle" scrolling="'.$data['scroll'].'" frameborder="0" title="'.$title.'"></iframe>';
   echo '<p><a class="btn btn-outline-primary btn-sm mt-2" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=printenc&amp;eid='.$data['id'].'"><i class="fa fa-print" aria-hidden="true"></i></a></p>';
break;
   }
   }
   else {
   echo '<p class="lead text-info">'.$iconinfo.''.encap_translate($message).'</p>';
   }
   echo '</div></div>';
}
   include("footer.php");
?>