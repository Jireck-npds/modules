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
global $language, $NPDS_Prefix;
// For More security

   echo '<form class="form-horizontal" method="post" action="modules.php">';
   echo "<input type=\"hidden\" name=\"ModPath\" value=\"$ModPath\" />";
   echo "<input type=\"hidden\" name=\"ModStart\" value=\"search\" />";

   echo '<div class="form-group row">
   <div class="col-sm-4">
   <label for="" class="control-label">Rechercher dans les annonces : </label></div>
                <div class="col-sm-8">';
   echo '<input type="text" class="form-control" name="search" value="'.$search.'" /></div></div>
         <div class="form-group">
         <div class="col-sm-offset-4 col-sm-8">
         <button class="btn btn-primary-outline btn-sm" type="submit" name="action"><i class="fa fa-check" aria-hidden="true"></i> Valider</button>
         </div></div>';
   echo "</form>";

   echo '<br /><br /><hr />';

   if ($user) {
      echo "<p><a class=\"btn btn-secondary btn-sm\" href=\"modules.php?ModPath=$ModPath&amp;ModStart=annonce_form\">Passer une annonce</a> <a class=\"btn btn-secondary btn-sm\" href=\"modules.php?ModPath=$ModPath&amp;ModStart=modif_ann\">G&eacute;rer mes annonces</a></p>";
   } else {
      echo '<p class="lead text-info text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Pour passer ou g&eacute;rer vos annonces vous devez &ecirc;tre membre inscrit connect&eacute; <a class="btn btn-primary-outline" href="user.php">Connexion</a></p>';
   }
   echo '<hr />';
?>