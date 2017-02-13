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


global $language, $NPDS_Prefix;
// For More security

   echo '
   <form class="form-horizontal" method="post" action="modules.php">
      <input type="hidden" name="ModPath" value="'.$ModPath.'" />
      <input type="hidden" name="ModStart" value="search" />
      <div class="form-group row">
         <label for="search" class="form-control-label col-md-5 lead">'.ann_translate("Rechercher dans les annonces").'</label>
         <div class="col-md-7">
            <input type="text" class="form-control" name="search" value="'.$search.'" />
         </div>
      </div>
      <div class="form-group row">
         <div class="col-md-7 offset-md-5">
            <button class="btn btn-outline-primary btn-sm" type="submit" name="action"><i class="fa fa-check" aria-hidden="true"></i> '.ann_translate("Valider").'</button>
         </div>
      </div>
   </form>
   <hr />';

   if ($user) {
      echo '<p><a class="btn btn-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=annonce_form">'.ann_translate("Passer P.A").'</a> <a class="btn btn-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=modif_ann">'.ann_translate("Gérer P.A").'</a></p>';
   } else {
      echo '<p class="lead"><i class="fa fa-info-circle" aria-hidden="true"></i> '.ann_translate("Pour passer ou gérer vos annonces vous devez être membre inscrit connecté").' <span class="float-right"><a class="btn btn-outline-primary btn-sm" href="user.php">Connexion</a></span></p>';
   }
   echo '<hr />';
?>