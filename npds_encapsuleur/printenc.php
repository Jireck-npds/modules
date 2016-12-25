<?php
/************************************************************************/
/* NPDS V : Net Portal Dynamic System                                   */
/* ===========================                                          */
/*                                                                      */
/* This version name NPDS Copyright (c) 2001-2011 by Philippe Brunier   */
/*                                                                      */
/* Encapsuleur  V 5.0                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
/* 05.01.2001 - martvin@box43.pl                                        */
/* 12.09.2002 - Achel_Jay, Benjee, Capcaverne                           */
/* 02.11.2002 - Snipe                                                   */
/* 25.11.2008 - Lopez - MAJ pouir Evolution                             */
/* 2010 et 2011 - Adaptation REvolution                                 */
/* Changement de nom du module version Rev16 par jpb/phr mars 2016      */
/************************************************************************/
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}


// Inclusion fichiers de langue
if (file_exists('modules/'.$ModPath.'/lang/'.$language.'.php')) {
   include_once('modules/'.$ModPath.'/lang/'.$language.'.php');
} else {
   include_once('modules/'.$ModPath.'/lang/french.php');
}

include ("modules/$ModPath/encap.conf.php");

   global $user,$cookie, $theme,$Default_Theme, $language, $site_logo, $sitename, $nuke_url, $site_font;
   include("meta/meta.php");
   echo "<title>$sitename</title>";
   if (isset($user)) {
      if ($cookie[9]=="") $cookie[9]=$Default_Theme;
      if (isset($theme)) $cookie[9]=$theme;
      $tmp_theme=$cookie[9];
      if (!$file=@opendir("themes/$cookie[9]")) {
         $tmp_theme=$Default_Theme;
      }
   } else {
      $tmp_theme=$Default_Theme;
   }
   echo import_css($tmp_theme, $language, $site_font,"","");
   echo "</head>\n<body style=\"background-color: #ffffff; background-image: none;\">";

   echo "";
   $pos = strpos($site_logo, "/");
   if ($pos)
      echo "<img class=\"img-fluid\" src=\"$site_logo\" border=\"0\" alt=\"\" />";
   else
      echo "<img class=\"img-fluid\" src=\"images/$site_logo\" border=\"0\" alt=\"\" />";

   settype($eid, 'integer');
   $result = sql_query("select id, type, nom, form, adresse, height from ".$NPDS_Prefix."encapsulation where id='$eid'");
   $data = sql_fetch_assoc($result);

   if ($data['id']) {
      if ($data['nom']!="") { echo "<br />".$data['nom']."<br />"; }

      switch ($data['type']) {
      case "interne" :
      // si le fichier et de type static (inclusion du fichier static.php)

         if (($data['adresse']!="") and ($data['adresse'])) {
            if (preg_match('#[^a-zA-Z0-9-]#',$data['adresse']) and !stristr($data['adresse'],"..") and !stristr($data['adresse'], "script") and !stristr($data['adresse'], "cookie") and !stristr($data['adresse'], "iframe") and  !stristr($op, "applet") and !stristr($data['adresse'], "object") and !stristr($data['adresse'], "meta")) {
               if (file_exists($static_url.$data['adresse'])) {
                  // Modif pour affichage des pages internes contenant des frames - 19/06/2006
                  $src=$static_url.$data['adresse'];
                  echo  "<iframe src=\"$src\" name=\"frame\" id=\"frame\" width=\"100%\" height=\"600\" marginwidth=\"0\" align=\"middle\" frameborder=\"0\" title=\"chaine\"></iframe>";
               }
            }
         }

         break;

      case "externe" :
      // si le fichier est une url externe
         echo  "<iframe src=\"".$data['form']."://".$data['adresse']."\" name=\"frame\" id=\"frame\" width=\"100%\" height=\"600\" marginwidth=\"0\" align=\"middle\" frameborder=\"0\" title=\"chaine\"></iframe>";
         break;

      default :
     // affichage par défaut
        echo  "<iframe src=\"".$data['form']."://".$data['adresse']."\" name=\"frame\" id=\"frame\" width=\"100%\" height=\"600\" marginwidth=\"0\" align=\"middle\" frameborder=\"0\" title=\"chaine\"></iframe>";
        break;
      }
   }
   echo '<hr />';
   echo '<p class="text-xs-center">'.$sitename.'</p>';
   echo '</body></html>';
?>