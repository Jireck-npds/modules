<?php
/************************************************************************/
/* NPDS V : Net Portal Dynamic System                                   */
/* ===========================                                          */
/*                                                                      */
/* This version name NPDS Copyright (c) 2001-2011 by Philippe Brunier   */
/*                                                                      */
/* Module GS-annonces 2.3                                               */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
// Basé sur gadjo_annonces v 1.2 - Adaptation 2008 par Jireck et lopez
// Normalisation du module pour Evolution, retro-compatibilité sable 5.10
// MAJ conformité XHTML pour REvolution 10.02 par jpb/phr en mars 2010
// MAJ Dev - 2011
//***********************************************************************/
// For More security
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security

include ("modules/$ModPath/annonce.conf.php");

   global $user,$cookie, $theme,$Default_Theme, $language, $site_logo, $sitename, $datetime, $nuke_url, $site_font;
   formatTimestamp($time);
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
   echo "</head>\n<body style=\"background-color: #ffffff; background-image: none;\">


   <table border=\"0\" width=\"640\" cellpadding=\"20\" cellspacing=\"1\" style=\"background-color: #ffffff;\"><tr><td>";
   echo "<p align=\"center\">";
   $pos = strpos($site_logo, "/");
   if ($pos)
      echo "<img src=\"$site_logo\" border=\"0\" alt=\"\" />";
   else
      echo "<img src=\"images/$site_logo\" border=\"0\" alt=\"\" />";
   echo "<br /><br /><b>".aff_langue(removehack($title))."</b><br /><br />";
   $remp=rawurldecode(removehack($text));
   echo "</p><span class=\"font-size: 10px;\">".$remp."</span>";
   echo "</td></tr><tr><td><br /><hr noshade class=\"ongl\"><br />
   <p align=\"center\">Cette annonce provient de : $sitename<br /><br />
   <a href=\"$nuke_url/modules.php?ModStart=index&amp;ModPath=$ModPath\">$nuke_url/modules.php?ModStart=index&amp;ModPath=$ModPath</a></p>";

   echo "</td></tr></table></body></html>";
?>