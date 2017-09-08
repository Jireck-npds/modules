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
   global $language, $user, $cookie, $nuke_url, $mois, $annee;
   $ModPath = 'npds_agenda';

   include_once('modules/'.$ModPath.'/lang/agenda-'.$language.'.php');
   require_once('modules/'.$ModPath.'/ag_fonc.php');
   include('modules/'.$ModPath.'/admin/config.php');
   
//   $ThisFile=$_SERVER['REQUEST_URI'];
   $content='';

// Récupération du jour, mois, et année actuelle
   $Bjour_actuel = date("j", time());
   $Bmois_actuel = date("m", time());
   $Ban_actuel = date("Y", time());
   $Bjour = $Bjour_actuel;

// Si la variable mois n'existe pas, mois et année correspondent au mois et à l'année courante
   if(!isset($_GET["b_mois"])) {
      $month = $Bmois_actuel;
      $an = $Ban_actuel;
   }
   else {
      $Bmois_actuel = $_GET["b_mois"];
      $Ban_actuel=$_GET["b_an"];
   }

   $content .= calend($Ban_actuel,$Bmois_actuel,1);

   // Si membre appartient au bon groupe
   if(autorisation($gro)) {
      $content .= '
      <p>
         <a class="btn btn-block btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=agenda_add"><i class="fa fa-plus" aria-hidden="true"></i> '.ag_translate('Proposer événement').'</a>
      </p>';
   }
   $content .= '
   <table>
   <tr>
   <td class="table-info" width="20px"></td>
   <td class="pl-2">'.ag_translate('Jour avec événement(s)').'</td>
   </tr>
   <tr>
   <td class="table-warning"></td>
   <td class="pl-2">'.ag_translate('Jour férié').'</td>
   </tr>
   </table>';
   if(autorisation(-127))
      $content .= '
   <div class="mt-2 text-right">
      <a href="admin.php?op=Extend-Admin-SubModule&amp;ModPath=npds_agenda&amp;ModStart=admin/adm" title="Admin" data-toggle="tooltip"><i id="cogs" class="fa fa-cogs fa-lg"></i></a>
   </div> ';
?>