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
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) die();
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta"))
   die();
// For More security
global $title;
if (!function_exists("Mysql_Connexion")) include ("mainfile.php");

include ("modules/$ModPath/annonce.conf.php");

   global $user,$cookie, $theme,$Default_Theme, $language, $site_logo, $sitename, $datetime, $nuke_url, $site_font;
//   formatTimestamp($time);
   include("meta/meta.php");
   echo "<title>$sitename</title>";
   if (isset($user)) {
      if ($cookie[9]=='') $cookie[9]=$Default_Theme;
      if (isset($theme)) $cookie[9]=$theme;
      $tmp_theme=$cookie[9];
      if (!$file=@opendir("themes/$cookie[9]")) {
         $tmp_theme=$Default_Theme;
      }
   } else {
      $tmp_theme=$Default_Theme;
   }  
       echo '
      <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <link rel="stylesheet" href="lib/bootstrap/dist/css/bootstrap.min.css" />';
       echo import_css($tmp_theme, $language, $site_font, '','');
       echo '
       </head>
       <body>
          <div max-width="640" class="container p-1 n-hyphenate">
             <div>';
       $pos = strpos($site_logo, '/');
       if ($pos)
          echo '<img class="img-fluid d-block mx-auto" src="'.$site_logo.'" alt="website logo" />';
       else
          echo '<img class="img-fluid d-block mx-auto" src="images/'.$site_logo.'" alt="website logo" />';
          echo '<h1 class="d-block text-center my-4">'.aff_langue($title).'</h1>';
   $remp=rawurldecode(removehack($text));
   echo '
         <div>'.$remp.'</div>
      </div>
   </div>
   <hr />
   <p class="text-center">Cette annonce provient de : '.$sitename.'<br />
   <a href="'.$nuke_url.'/modules.php?ModStart=index&amp;ModPath='.$ModPath.'">'.$nuke_url.'/modules.php?ModStart=index&amp;ModPath='.$ModPath.'</a></p>
   </body>
   </html>';
?>