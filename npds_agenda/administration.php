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

// DEBUT FONCTION

// DEBUT LISTE AUTEUR
function vosajouts() {
   global $ModPath, $NPDS_Prefix, $cookie, $ThisFile, $nb_news, $order, $page;
   /*Debut securite*/
   settype($page,"integer");
   settype($order,"integer");
   //Fin securite
   require_once('modules/'.$ModPath.'/pag_fonc.php');

   /*Total pour naviguation*/
   $nb_entrees = sql_num_rows(sql_query("SELECT * FROM ".$NPDS_Prefix."agend_dem us WHERE posteur = '$cookie[1]' GROUP BY titre"));
   //Pour la naviguation
   $total_pages = ceil($nb_entrees/$nb_news);
   if($page == 1)
      $page_courante = 1;
   else {
      if ($page < 1)
         $page_courante = 1;
      elseif ($page > $total_pages)
         $page_courante = $total_pages;
      else
         $page_courante = $page;
   }
   $start = ($page_courante * $nb_news - $nb_news);

   //Ordre par defaut
   if($order == '0'){$order1 = 'valid = 3 DESC';}else if($order == '4'){$order1 = 'titre ASC';}else{$order1 = "valid = $order DESC";}
   echo '
   <div class="card card-body">
   <h4>'.ag_translate('Liste de vos événements').'</h4>
   <hr />
   <p>'.ag_translate('Trier par').'
   <a class="btn btn-outline-success btn-sm mr-1" href="'.$ThisFile.'&amp;order=1">'.ag_translate('En Ligne').'</a>
   <a class="btn btn-secondary btn-sm mr-1" href="'.$ThisFile.'&amp;order=2">'.ag_translate('Hors Ligne').'</a>
   <a class="btn btn-outline-danger btn-sm mr-1" href="'.$ThisFile.'&amp;order=3">'.ag_translate('A valider').'
   <a class="btn btn-secondary btn-sm" href="'.$ThisFile.'&amp;order=4">'.ag_translate('Titre').'</a>
   </p>
   <table class="table table-bordered table-sm table-responsive w-100">
      <thead class="table-secondary">
         <tr>
            <th class="text-center">'.ag_translate('Titre').'</th>
            <th class="text-center">'.ag_translate('Catégorie').'</th>
            <th class="text-center n-t-col-xs-2">'.ag_translate('Date').'</th>
            <th class="text-center n-t-col-xs-2">'.ag_translate('Statut').'</th>
            <th class="text-center n-t-col-xs-2">'.ag_translate('Fonctions').'</th>
         </tr>
       </thead>
       <tbody>';
   /*Requete liste evenement suivant $cookie*/
   $result = sql_query("SELECT id, titre, topicid, valid FROM ".$NPDS_Prefix."agend_dem us WHERE posteur = '$cookie[1]' GROUP BY titre ORDER BY $order1 LIMIT $start,$nb_news");
   while(list($id, $titre, $topicid, $valid) = sql_fetch_row($result)) {
      $titre = stripslashes(aff_langue($titre));
      echo '
         <tr>
            <td class="align-middle">'.$titre.'</td>
               <td class="align-middle">';
      $res = sql_query("SELECT topictext FROM ".$NPDS_Prefix."agendsujet WHERE id = '$topicid'");
      list($topictext) = sql_fetch_row($res);
      echo stripslashes(aff_langue($titre)).'</td>
               <td class="text-center align-middle">';
      $res1 = sql_query("SELECT id, date FROM ".$NPDS_Prefix."agend WHERE liaison = '$id' ORDER BY date DESC");
      while(list($sid, $date) = sql_fetch_row($res1)) {
         echo $date.'<br />';
      }
      echo '</td>';
      if ($valid == 1)
         echo '
            <td class="table-success text-center align-middle">'.ag_translate('En Ligne').'</td>';
      else if ($valid == 2)
         echo '
            <td class="table-secondary text-center align-middle">'.ag_translate('Hors Ligne').'</td>';
      else if ($valid == 3)
         echo '
            <td class="table-danger text-center align-middle">'.ag_translate('A valider').'</td>';

      echo '
            <td class="text-center  align-middle"><a class="mr-1" href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'"><i class="fa fa-lg fa-pencil-square-o"></i></a>
      <a href="'.$ThisFile.'&amp;subop=suppevt&amp;id='.$id.'"><i class="fa fa-lg fa-trash-o text-danger"></i></a></td>
         </tr>';
   }
   echo '
      </tbody>
   </table>';

   //Affiche pagination
   echo ag_pag($total_pages,$page_courante,'2',''.$ThisFile.'&amp;order='.$order.'','_mod');
   
   echo '</div>';
}
// FIN LISTE AUTEUR
// DEBUT SUPPRIME EVENEMENT PAR SON AUTEUR
function suppevt($id, $ok=0) {
   global $NPDS_Prefix, $ModPath, $cookie, $ThisFile;
   //Debut securite
   settype($id,"integer");
   //Fin securite

   if ($ok) {
      $result = sql_query("DELETE FROM ".$NPDS_Prefix."agend WHERE liaison = $id");
      $result1 = sql_query("DELETE FROM ".$NPDS_Prefix."agend_dem WHERE id = $id");
      if (!$result1) {
         echo sql_error().'<br />';
         return;
      }
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Cet événement est maintenant effacé').'</p>
      <div class=""><a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'">'.ag_translate('Retour').'</a></div>';
   }
   else {
      //Verif id - auteur
      $tot = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."agend_dem WHERE id = '$id' AND posteur = '$cookie[1]'"));
      if ($tot != 0) {
         echo '
         <div class="alert alert-danger">'.ag_translate('Etes-vous certain de vouloir supprimer cet événement').'</div>
         <a class="btn btn-outline-primary btn-sm mr-2" href="'.$ThisFile.'">'.ag_translate('NON').'</a>
         <a class="btn btn-outline-danger btn-sm" href="'.$ThisFile.'&amp;subop=suppevt&amp;id='.$id.'&amp;ok=1">'.ag_translate('OUI').'</a>';
      }
      else
         redirect_url('index.php');
   }
}
// DEBUT SUPPRIME EVENEMENT PAR SON AUTEUR
// DEBUT EDITER EVENEMENT PAR SON AUTEUR
function editevt($id, $month, $an, $debut) {
   global $ModPath, $ModStart, $NPDS_Prefix, $cookie, $ThisFile, $bouton, $subop;
   //Debut securite
   settype($id,"integer");
   $debut = removeHack($debut);
   //Fin securite

   //Requete affiche evenement suivant $id
   $result = sql_query("SELECT titre, intro, descript, lieu, topicid, posteur, groupvoir, valid FROM ".$NPDS_Prefix."agend_dem WHERE id = '$id' AND posteur = '$cookie[1]'");
   list($titre, $intro, $descript, $lieu, $topicid, $posteur, $groupvoir, $valid) = sql_fetch_row($result);
   if (!$result)
      redirect_url('index.php');

   if ($debut == '') {
      $month = date("m", time());
      $an = date("Y", time());
      //Requete affiche date suivant $id
      $result = sql_query("SELECT id, date FROM ".$NPDS_Prefix."agend WHERE liaison = '$id'");
      while(list($sid, $date) = sql_fetch_row($result)) {
         $debut .= $date.',';
      }
      $debut = substr("$debut", 0, -1);
   }

   $titre = stripslashes($titre);
   $intro = stripslashes($intro);
   $descript = stripslashes($descript);
   $lieu = stripslashes($lieu);
   echo '
   <div class="card card-body">
   <h4>'.ag_translate('Editer un événement').'</h4>
   <hr />
   <ul>
      <li>'.ag_translate('Etape 1 : Sélectionner vos dates').'</li>
      <li>'.ag_translate('Etape 2 : Remplisser le formulaire').'</li>
      <!--<li><span class="text-danger">*</span> '.ag_translate('Champ obligatoire').'</li>-->
   </ul>
   <form method="post" action="modules.php" name="adminForm">
   <input type="hidden" name="ModPath" value="'.$ModPath.'" />
   <input type="hidden" name="ModStart" value="'.$ModStart.'" />
   <input type="hidden" name="id" value="'.$id.'" />
   <input type="hidden" name="debut" value="'.$debut.'" />
   <label class="form-control-label">'.ag_translate('Jour(s) sélectionné(s)').'</label>
   <div class="border rounded p-2 mb-3">';
   $name = explode(',',$debut);
   for ($i = 0; $i < sizeof($name); $i++ ) {
      echo '<li class="list-inline-item">'.formatfrancais($name[$i]).'<a class="text-danger mx-2" data-toggle="tooltip" data-placement="bottom" title="'.ag_translate("Supprimer").'" href="'.$ThisFile.'&amp;subop=retire&amp;ladate='.$name[$i].'&amp;debut='.$debut.'&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'"><i class="fa fa-times" aria-hidden="true"></i></a></li>';
   }
   echo '</div>';
   echo cal($month, $an, $debut,'&amp;subop='.$subop.'&amp;id='.$id);
   echo '
   <div class="form-group">
      <label class="form-control-label" for="titre">'.ag_translate('Titre').'&nbsp;<span class="text-danger">*</span></label>
      <input class="form-control" id="titre" name="titre" value="'.$titre.'" />
      <input type="hidden" name="groupvoir" value="0" />
  </div>
   <div class="form-group">
      <label class="form-control-label" for="desc">'.ag_translate('Résumé de l\'événement').'&nbsp;<span class="text-danger">*</span></label>
      <textarea class="tin form-control" rows="10" id="desc" name="desc">'.$intro.'</textarea>
   </div>
   <div class="form-group">
      <label class="form-control-label" for="longdesc">'.ag_translate('Description complète').'</label>
      <textarea class="tin form-control" rows="20" id="longdesc" name="longdesc">'.$descript.'</textarea>';
   echo aff_editeur("longdesc","short");
   echo '
   </div>
   <div class="form-group row">
      <label class="form-control-label col-sm-3" for="topicid">'.ag_translate('Catégorie').'&nbsp;<span class="text-danger">*</span></label>
      <div class="col-sm-9">
         <select class="custom-select form-control" id="topicid" name="topicid" value="'.$topicid.'">';

   //Requete liste categorie
   $res = sql_query("SELECT topicid, topictext FROM ".$NPDS_Prefix."agendsujet ORDER BY topictext ASC");
   while($categorie = sql_fetch_assoc($res)) {
      $categorie['topictext'] = stripslashes($categorie['topictext']);
      echo '
            <option value=\''.$categorie['topicid'].'\'';
      if($categorie['topicid'] == $topicid)
      echo ' selected=\'selected\'';
      echo '>'.aff_langue(''.$categorie['topictext'].'').'</option>';
   }
   echo '
         </select>
      </div>
   </div>
   <div class="form-group row">
      <label class="form-control-label col-sm-3" for="lieu">'.ag_translate('Lieu').'</label>
      <div class="col-sm-9">';
   if ($bouton == '1')
      echo '
         <input class="form-control" maxLength="50" id="lieu" name="lieu" value="'.$lieu.'" />';
   else {
      include('modules/'.$ModPath.'/recherche/'.$bouton.'.php');
      echo '
         <select class="custom-select" id="lieu" name="lieu">
            <option></option>';
      foreach($try as $na) {
         if($lieu == $na) $af = ' selected'; else $af = '';
         echo '
            <option value="'.$na.'"'.$af.'>'.$na.'</option>';
      }
      echo '
         </select>';
   }
      echo '
      </div>
   </div>
   <input type="hidden" name="subop" value="validedit" />
   <input type="submit" class="btn btn-outline-primary btn-sm" value="'.ag_translate('Modifier l\'Evénement').'" />
    <a class="btn btn-outline-danger btn-sm" href="'.$ThisFile.'&amp;subop=suppevt&amp;id='.$id.'">'.ag_translate('Supprimer cet événement').'</a>
   </form>
   <div class=""><a class="btn btn-secondary btn-sm float-right" href="javascript:history.back()">'.ag_translate('Retour').'</a></div>
   <div>
   </div>
   </div>';
}
// FIN EDITER EVENEMENT PAR SON AUTEUR


// DEBUT AFFICHAGE CALENDRIER

// FIN AFFICHAGE CALENDRIER

// DEBUT VALID EDIT
function validedit ($id, $debut, $topicid, $titre, $desc, $longdesc, $lieu) {
   global $ModPath, $ModStart, $NPDS_Prefix, $ThisFile, $revalid, $menu, $courriel, $receveur;
   //Debut securite
   settype($id,"integer");
   settype($topicid,"integer");
   $titre = removeHack(addslashes($titre));
   $desc = removeHack(addslashes($desc));
   $lieu = removeHack(addslashes($lieu));
   $debut = removeHack($debut);
   $longdesc = removeHack($longdesc);
   //Fin securite
   echo $menu;
   if ($debut == '' || $topicid == '' || $titre == '' || $desc == '' || $longdesc == '') {
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Vous n\'avez pas remplis les champs obligatoires').'</p>
      <div class=""><i class="fa fa-info-circle mr-2" aria-hidden="true"></i><a href="javascript:history.back()">'.ag_translate('Retour').'</a></div>';
   }
   else {
      //Insertion modifs evenement
      $result = "UPDATE ".$NPDS_Prefix."agend_dem SET titre = '$titre', intro = '$desc', descript = '$longdesc', lieu = '$lieu', topicid = '$topicid', valid = '$revalid' WHERE id = $id";
      $succes = sql_query($result) or die ("erreur : ".sql_error());
      //Recupere id demande
      $result1 = "DELETE FROM ".$NPDS_Prefix."agend WHERE liaison = '$id'";
      $succes1 = sql_query($result1) or die ("erreur : ".sql_error());
      $namel = explode(',',$debut);
      sort($namel);
      for ($i = 0; $i < sizeof($namel); $i++) {
         //Insertion des dates
         $query = "INSERT INTO ".$NPDS_Prefix."agend values ('', '$namel[$i]', '$id')";
         sql_query($query) or die(sql_error());
      }
      if ($query) {
         /*Envoie mail si actif dans config*/
         if ($courriel == 1 || $receveur != '') {
            $sujet = ag_translate('Modification événement pour agenda');
            $sujet=html_entity_decode($sujet, ENT_COMPAT, 'UTF-8');
            $message = ag_translate('Un événement modifié est à valider pour agenda').'.<br /><br />';
            include("signat.php");
            send_email($receveur,$sujet, $message, '', true, 'html');
         }
         if ($revalid == 3)
            echo '<div class="alert alert-warning"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Un administrateur validera vos changements rapidement').'</div';
         else if ($revalid == 1)
            echo '<div class="alert alert-success"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Vos changements ont bien été ajoutés à l\'agenda').'</div>';
      }
   }
}
// FIN VALID EDIT

// DEBUT RETIRE DATE
function retire($ladate, $debut, $id, $month, $an) {
   global $ThisRedo;
   //Debut securite
   settype($id,"integer");
   settype($month,"integer");
   settype($an,"integer");
   $debut = removeHack($debut);
   //Fin securite
   //On rajoute une virgule quon enleve apres sinon double virgules
   $debut1 = ''.$debut.',';
   $newdebut = str_replace("$ladate,", '', "$debut1");
   $newdebut = substr("$newdebut", 0, -1);
   redirect_url($ThisRedo.'&subop=editevt&id='.$id.'&month='.$month.'&an='.$an.'&debut='.$newdebut);
}
// FIN RETIRE DATE

// FIN FONCTION

include ('modules/'.$ModPath.'/admin/pages.php');
include_once('modules/'.$ModPath.'/lang/agenda-'.$language.'.php');
   global $pdst, $language;

   //Parametres utilises par le script
   $ThisFile = 'modules.php?ModPath='.$ModPath.'&amp;ModStart='.$ModStart.'';
   $ThisRedo = 'modules.php?ModPath='.$ModPath.'&ModStart=calendrier';
   include('header.php');
   include('modules/'.$ModPath.'/admin/config.php');
   require_once('modules/'.$ModPath.'/ag_fonc.php');
   /*Verifie si bon groupe*/
   if(!autorisation($gro))
      redirect_url('index.php');
   settype($subop,'string');
   settype($ok,'integer');
   settype($month,'integer');
   settype($an,'integer');
   settype($debut,'string');
   
   switch($subop) {
      default:
         echo suj();
         vosajouts();
      break;
      case 'suppevt':
         echo suj();
         suppevt($id, $ok);
      break;
      case 'editevt':
         echo suj();
         editevt($id, $month, $an, $debut);
      break;
      case 'validedit':
         echo suj();
         validedit ($id, $debut, $topicid, $titre, $desc, $longdesc, $lieu);
      break;
      case 'retire':
         retire($ladate, $debut, $id, $month, $an);
      break;
   }
   include("footer.php");
?>