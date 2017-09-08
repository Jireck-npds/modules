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
if (!strstr($PHP_SELF,'admin.php')) { Access_Error(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security

$f_meta_nom ='npds_agenda';
//==> controle droit
admindroits($aid,$f_meta_nom);
//<== controle droit

if ($admin) {
   include_once("modules/$ModPath/admin/adm_func.php");
   include ('modules/'.$ModPath.'/admin/pages.php');
   include_once('modules/'.$ModPath.'/lang/agenda-'.$language.'.php');

   /*Parametres utilises par le script*/
   $ThisFile = 'admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart='.$ModStart.'';
   $ThisRedo = 'admin.php?op=Extend-Admin-SubModule&ModPath='.$ModPath.'&ModStart='.$ModStart.'';
   $tipath = 'modules/'.$ModPath.'/images/categories/';

   $tabMois = array();
   $tabMois[1] = ag_translate('Janvier');
   $tabMois[2] = ag_translate('Février');
   $tabMois[3] = ag_translate('Mars');
   $tabMois[4] = ag_translate('Avril');
   $tabMois[5] = ag_translate('Mai');
   $tabMois[6] = ag_translate('Juin');
   $tabMois[7] = ag_translate('Juillet');
   $tabMois[8] = ag_translate('Août');
   $tabMois[9] = ag_translate('Septembre');
   $tabMois[10] = ag_translate('Octobre');
   $tabMois[11] = ag_translate('Novembre');
   $tabMois[12] = ag_translate('Décembre');
   /*css perso admin en attendant evolution page.php*/

   GraphicAdmin($hlpfile);
   echo '<div id="adm_men">';
   settype($subop,'string');
   settype($month,'integer');
   settype($an,'integer');
   settype($debut,'string');
   settype($ok,'string');

   switch($subop) {
   default:
      adminagenda();
   break;
   case 'menuprincipal':
      menuprincipal();
   break;
   case 'editevt':
      editevt($id, $month, $an, $debut);
   break;
   case 'saveevt':
      saveevt($debut, $statut, $sujet, $groupvoir, $titre, $intro, $descript, $lieu, $id);
   break;
   case 'retire':
      retire($ladate, $debut, $id, $month, $an);
   break;
   case 'deleteevt':
      deleteevt($id, $ok);
   break;
   case "topicsmanager":
      topicsmanager();
   break;
   case "topicedit":
      topicedit($topicid);
   break;
   case "topicmake":
      topicmake($topicimage, $topictext);
   break;
   case "topicdelete":
      topicdelete($topicid, $ok);
   break;
   case "topicchange":
      topicchange($topictext, $topicimage, $topicid);
   break;
   case 'configuration':
      configuration();
   break;
   case 'ConfigSave':
      ConfigSave($xgro, $xvalid, $xcourriel, $xreceveur, $xrevalid, $xnb_admin, $xnb_news, $xbouton, $xbouton1, $xtps);
   break;
   }
   }
   echo '</div>';
   include ("footer.php");
?>