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
if (strstr($ModPath,'..') || strstr($ModStart,'..') || stristr($ModPath, 'script') || stristr($ModPath, 'cookie') || stristr($ModPath, 'iframe') || stristr($ModPath, 'applet') || stristr($ModPath, 'object') || stristr($ModPath, 'meta') || stristr($ModStart, 'script') || stristr($ModStart, 'cookie') || stristr($ModStart, 'iframe') || stristr($ModStart, 'applet') || stristr($ModStart, 'object') || stristr($ModStart, 'meta'))
   die();
// For More security

/// DEBUT FONCTION

/// DEBUT AJOUT ///
function ajout($month, $an, $debut) {
   global $NPDS_Prefix, $ModPath, $ModStart, $ThisFile, $user, $cookie, $menu, $bouton;

   //Debut securite
//   settype($month,"integer");
   settype($an,"integer");
   settype($fin,"string");
   $debut = removeHack($debut);
   $fin = removeHack($fin);
   // Fin securite

   echo '
   <div class="card">
   <div class="card-body">
   <h4>'.ag_translate('Proposer un événement').'</h4><hr />
   <form method="post" action="modules.php" name="adminForm">
      <input type="hidden" name="ModPath" value="'.$ModPath.'" />
      <input type="hidden" name="ModStart" value="'.$ModStart.'" />
      <input type="hidden" name="debut" value="'.$debut.'" />';
   if ($debut != '') {
      echo '
      <label class="form-control-label">'.ag_translate('Jour(s) sélectionné(s)').'</label>
      <span class="text-danger ml-2">*</span>
      <div class="border rounded p-2 mb-3">';
      $name = explode(',',$debut);
      $ibidcount =sizeof($name);
      for ($i = 0; $i < $ibidcount; $i++ ) {
//         echo '<li class="list-inline-item"><span class="badge badge-secondary">'.formatfrancais($name[$i]).'</span><a class="text-danger mx-2" data-toggle="tooltip" data-placement="bottom" title="'.ag_translate("Supprimer").'" href="'.$ThisFile.'&amp;subop=retire&amp;ladate='.$name[$i].'&amp;debut='.$debut.'&amp;month='.$month.'&amp;an='.$an.'"><i class="fa fa-window-close" aria-hidden="true"></i></a></li>';
         echo '<a class="code btn btn-outline-secondary btn-sm mr-1 mt-1 border-0" href="'.$ThisFile.'&amp;subop=retire&amp;ladate='.$name[$i].'&amp;debut='.$debut.'&amp;month='.$month.'&amp;an='.$an.'">
  '.formatfrancais($name[$i]).'<i class="fa fa-times text-danger ml-1 align-middle" data-toggle="tooltip" data-placement="bottom" title="'.ag_translate("Supprimer").'"></i>
</a>';
      }
      echo '</div>';
   }
   else
      echo '<p class=""><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Pour ajouter des dates, sélectionner le(s) jour(s) dans le calendrier').'<i class="fa fa-asterisk text-danger ml-2" aria-hidden="true"></i></p>';
   echo cal($month, $an, $debut,'');
   echo '
   <div class="form-group">
      <label class="form-control-label" for="titre">'.ag_translate('Titre').'<span class="text-danger ml-2">*</span></label>
      <input class="form-control" id="titre" name="titre" />
      <input type="hidden" id="groupvoir" name="groupvoir" value="0" />
   </div>
   <div class="form-group">
      <label class="form-control-label" for="desc">'.ag_translate('Résumé de l\'événement').'<span class="text-danger ml-2">*</span></label>
      <textarea class="tin form-control" rows="10" id="desc" name="desc"></textarea>
   </div>
   <div class="form-group">
      <label class="form-control-label" for="longdesc">'.ag_translate('Description complète').'<span class="text-danger ml-2">*</span></label>
      <textarea class="tin form-control" id="longdesc" name="longdesc" rows=""></textarea>';
   echo aff_editeur('longdesc', '');
   echo '
   </div>
      <div class="form-group form-row">
         <label class="form-control-label col-sm-3" for="topicid">'.ag_translate('Catégorie').'<span class="text-danger ml-2">*</span></label>
         <div class="col-sm-9">
            <select class="custom-select form-control" id="topicid" name="topicid">';
   //Requete liste categorie
   $toplist = sql_query("SELECT topicid, topictext FROM ".$NPDS_Prefix."agendsujet ORDER BY topictext");
   echo '
               <option value="">'.ag_translate('Choix catégorie').'</option>';
   while(list($topicid, $topics) = sql_fetch_row($toplist)) {
      $topics = stripslashes(aff_langue($topics));
      if ($topicid == $topic) $sel = 'selected="selected"';
      echo '
               <option '.$sel.' value="'.$topicid.'">'.$topics.'</option>';
      $sel = '';
   }
   echo '
         </select>
      </div>
   </div>
   <div class="form-group form-row">
      <label class="form-control-label col-sm-3" for="lieu">'.ag_translate('Lieu').'<span class="text-danger mx-2">*</span></label>
      <div class="col-sm-9">';
   if ($bouton == '1')
      echo '
         <input class="form-control" type="text" id="lieu" name="lieu" />';
   else {
      include('modules/'.$ModPath.'/recherche/'.$bouton.'.php');
      echo '
      <select class="custom-select form-control" name="lieu">
         <option>'.ag_translate('Sélection région ou département').'</option>';
      foreach($try as $na) {
         echo '
         <option value="'.$na.'">'.$na.'</option>';
      }
      echo '
      </select>';
   }
   echo '
   </div>
   </div>
      <p><span class="text-danger">* '.ag_translate('Saisie obligatoire').'</span></p>
      <input type="hidden" name="member" value="'.$cookie[1].'" />
      <input type="hidden" name="subop" value="catcreer" />
      <button type="submit" class="btn btn btn-outline-primary btn-sm"><i class="fa fa-check"></i> '.ag_translate('Valider').'</button>
   </form>
   <div class="float-right"><a class="btn btn-secondary btn-sm" href="javascript:history.back()">'.ag_translate('Retour').'</a></div>
</div>
</div>';
}
// FIN AJOUT

// DEBUT VALID AJOUT
function catcreer ($debut, $topicid, $groupvoir, $titre, $desc, $longdesc, $lieu, $statut, $member) {
   global $ModPath, $ModStart, $NPDS_Prefix, $ThisFile, $valid, $menu, $courriel, $receveur;
   /*Debut securite*/
   settype($topicid,"integer");
   settype($groupvoir,"integer");
   settype($statut,"integer");
   $titre = removeHack(addslashes($titre));
   $desc = removeHack(addslashes($desc));
   $lieu = removeHack(addslashes($lieu));
   $debut = removeHack($debut);
   $member = removeHack($member);
   $longdesc = removeHack($longdesc);
   /*Fin securite*/

   echo $menu;
   if ($debut == '' || $topicid == '' || $titre == '' || $desc == '' || $longdesc == '' || $lieu == '') {
      echo '<p class="lead text-danger"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Vous n\'avez pas rempli les champs obligatoires').'</p>
      <div class="float-right"><a class="btn btn-secondary btn-sm" href="javascript:history.back()">'.ag_translate('Retour').'</a></div>';
   }
   else {

   /*Enregistrement demande*/
   $result = sql_query("INSERT INTO ".$NPDS_Prefix."agend_dem SET id = '', titre = '$titre', intro = '$desc', descript = '$longdesc', lieu = '$lieu', topicid = '$topicid', posteur = '$member', groupvoir = '$groupvoir', valid = '$valid'");

   /*Recupere id demande*/
   $result1 = sql_query("SELECT id FROM ".$NPDS_Prefix."agend_dem ORDER BY id DESC LIMIT 0,1");
   list($sid) = sql_fetch_row($result1);
   $namel = explode(',',$debut);
   sort($namel);
   for ($i = 0; $i < sizeof($namel); $i++) {
      /*Insertion des dates*/
      $query = "INSERT INTO ".$NPDS_Prefix."agend values ('', '$namel[$i]', '$sid')";
      sql_query($query) or die(sql_error());
   }
   if ($query) {

   //Envoi mail si actif dans config
   if ($courriel == 1 || $receveur != '') { 
   $sujet = ag_translate('Evénement nouveau dans agenda');
   $sujet=html_entity_decode($sujet, ENT_COMPAT, 'UTF-8');
   $message = ag_translate('Un événement nouveau est à valider dans agenda').'.<br /><br />';
   include("signat.php");
   send_email($receveur,$sujet,$message,'',true,"html");
   }
   if ($valid == 3)
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Merci pour votre contribution, un administrateur la validera rapidement').'</p>';
   else if ($valid == 1)
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Votre nouvel événement à bien été ajouté à l\'agenda').'</p>';
   }
   }
}
// FIN VALID AJOUT

// DEBUT RETIRE DATE
function retire($ladate, $debut, $month, $an) {
   global $ThisRedo;
   //Debut securite
   settype($id,"integer");
   settype($month,"integer");
   settype($an,"integer");
   $debut = removeHack($debut);
   //Fin securite

   /*On rajoute une virgule qu'on enlève après sinon double virgules*/
   $debut1 = $debut.',';
   $newdebut = str_replace("$ladate,", "", "$debut1");
   $newdebut = substr("$newdebut", 0, -1);
   redirect_url(''.$ThisRedo.'&subop=editevt&month='.$month.'&an='.$an.'&debut='.$newdebut.'');
}
// FIN RETIRE DATE

/// FIN FONCTION

//Affichage de la page

include ('modules/'.$ModPath.'/admin/pages.php');
include_once('modules/'.$ModPath.'/lang/agenda-'.$language.'.php');
include('modules/'.$ModPath.'/admin/config.php');
include_once('modules/'.$ModPath.'/ag_fonc.php');
include('header.php');

/*Paramètres utilisés par le script*/
   $ThisFile = 'modules.php?ModPath='.$ModPath.'&ModStart='.$ModStart;
   $ThisRedo = 'modules.php?ModPath='.$ModPath.'&ModStart='.$ModStart;

   settype($subop,'string');
   settype($month,'integer');
   settype($an,'integer');
   settype($debut,'string');
   settype($statut,'string');
      settype($titre,'string');

   //Si membre appartient au bon groupe
   if(autorisation($gro)) {
      switch($subop) {
         default:
            echo suj();
            ajout($month, $an, $debut);
         break;
         case 'catcreer':
            catcreer ($debut, $topicid, $groupvoir, $titre, $desc, $longdesc, $lieu, $statut, $member);
         break;
         case 'retire':
            retire($ladate, $debut, $month, $an);
         break;
      }
   }
   else
      redirect_url('index.php');
   include('footer.php');
?>