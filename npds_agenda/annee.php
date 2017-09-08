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
/* Module npds_agenda 2.0                                               */
/*                                                                      */
/* Auteur Oim                                                           */
/* Changement de nom du module version Rev16 par jpb/phr janv 2017      */
/************************************************************************/
// For More security
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) die();
if (strstr($ModPath,'..') || strstr($ModStart,'..') || stristr($ModPath, 'script') || stristr($ModPath, 'cookie') || stristr($ModPath, 'iframe') || stristr($ModPath, 'applet') || stristr($ModPath, 'object') || stristr($ModPath, 'meta') || stristr($ModStart, 'script') || stristr($ModStart, 'cookie') || stristr($ModStart, 'iframe') || stristr($ModStart, 'applet') || stristr($ModStart, 'object') || stristr($ModStart, 'meta')) {
   die();
}
// For More security

/// DEBUT FONCTION

// DEBUT LISTE EVENEMENT
function listsuj($an) {
   global $NPDS_Prefix, $ModPath, $theme, $ThisFile;
   settype($an,'integer');
   if ($an == '')
      $an = date("Y", time());
   $prec = ($an - 1);
   $suiv = ($an + 1);
   echo '
   <div class="card">
   <div class="card-body">';
   //debut theme html partie 1/2
   $inclusion = false;
      $inclusion = "modules/".$ModPath."/html/annee.html";
   echo '
   <h4 class="text-center mb-3">
      <a class="btn btn-outline-secondary border-0" href="'.$ThisFile.'&amp;an='.$prec.'"><i class="fa fa-chevron-left align-middle" aria-hidden="true"></i></a>
      <a class="btn btn-outline-secondary border-0" href="modules.php?ModPath='.$ModPath.'&ModStart=calendrier&month=01&an='.$an.'"><span class="label label-default">'.ag_translate('Année').' '.$an.'</span></a>
      <a class="btn btn-outline-secondary border-0" href="'.$ThisFile.'&amp;an='.$suiv.'"><i class="fa fa-chevron-right align-middle" aria-hidden="true"></i></a>
   </h4>
   <div class="form-row mb-3">';
   for ($month = 1; $month < 13; $month++) {
      echo '
      <div class="col-sm-6 col-md-6 col-lg-4">
      '.calend($an, $month, 0).'
      </div>';
   }
   echo '
   </div>';
   //debut theme html partie 2/2
   ob_start();
   include ($inclusion);
   $Xcontent = ob_get_contents();
   ob_end_clean();
   $npds_METALANG_words = array(
   );
   echo meta_lang(aff_langue(preg_replace(array_keys($npds_METALANG_words),array_values($npds_METALANG_words), $Xcontent)));
   //fin theme html partie 2/2
}
// FIN LISTE EVENEMENT


/// FIN FONCTION

include ('modules/'.$ModPath.'/admin/pages.php');
include_once('modules/'.$ModPath.'/lang/agenda-'.$language.'.php');
global $pdst, $language;

   /*Paramètres utilisés par le script*/
   $ThisFile = 'modules.php?ModPath='.$ModPath.'&amp;ModStart='.$ModStart;
   $ThisRedo = 'modules.php?ModPath='.$ModPath.'&ModStart=calendrier';
   include('header.php');
   include('modules/'.$ModPath.'/admin/config.php');
   require_once('modules/'.$ModPath.'/ag_fonc.php');
   include ('modules/'.$ModPath.'/cache.timings.php');

   settype($subop,'string');
   settype($an,'integer');//à controler effet

   if ($SuperCache) {
      $cache_obj = new cacheManager();
      $cache_obj->startCachingPage();
   }
   else
      $cache_obj = new SuperCacheEmpty();
   if (($cache_obj->genereting_output == 1) or ($cache_obj->genereting_output == -1) or (!$SuperCache)) {
      switch($subop) {
         default:
            echo suj();
            listsuj($an);
         break;
         case 'calend':
            echo calend($an, $month);
         break;
         case 'petit':
            petit($date, $id);
         break;
      }
   }
   if ($SuperCache)
      $cache_obj->endCachingPage();
   include("footer.php");
?>