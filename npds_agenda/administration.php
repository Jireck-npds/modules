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
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security

// DEBUT FONCTION


// DEBUT FONCTION LISTE SUJET
function suj() {
   global $NPDS_Prefix, $ModPath, $theme, $bouton;
   global $ThisRedo, $ThisFile, $gro;
   /*debut theme html partie 1/2*/
//   $inclusion = false;

$inclusion = "modules/".$ModPath."/html/sujet.html";

/*fin theme html partie 1/2*/

/*Si membre appartient au bon groupe*/
   if(autorisation($gro)) {
      $ajeven = '
         <li class="nav-item">
            <a class="nav-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration">'.ag_translate('Vos ajouts').'</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=agenda_add"><i class="fa fa-plus" aria-hidden="true"></i> '.ag_translate('Evénement').'</a>
         </li>';
   }

//Accès direct à un sujet

   $accesuj = '<li class="nav-item ml-3">
   <select class="custom-select" onchange="window.location=(\''.$ThisRedo.'&subop=listsuj&sujet='.$stopicid.'\'+this.options[this.selectedIndex].value)">
   <option>'.ag_translate('Sélectionner catégorie').'</option>';

/*Requete liste sujet*/
   $result = sql_query("SELECT topicid, topictext FROM ".$NPDS_Prefix."agendsujet ORDER BY topictext ASC");
   while(list($stopicid, $topictext) = sql_fetch_row($result))
   {
      $topictext = stripslashes(aff_langue($topictext));
      $accesuj .= '<option value="'.$stopicid.'">'.$topictext.'</option>';
   }
   if($bouton == '1')
   {
      $rech = ag_translate('Par ville');
   }
   else
   {
      $rech = ''.ag_translate('Par').'&nbsp;'.$bouton.'';
   }
   $accesuj .= '</select></li>';

// fin Accès direct à un sujet

   $vuannu ='<li class="nav-item">
               <a class="nav-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=annee">'.ag_translate('Vue annuelle').'</a>
            </li>';
   $vulieu ='<li class="nav-item">
               <a class="nav-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=lieu">'.$rech.'</a>
            </li>';

/*debut theme html partie 2/2*/
   ob_start();
   include ($inclusion);
   $Xcontent = ob_get_contents();
   ob_end_clean();
   $npds_METALANG_words = array(
      "'!titre!'i"=>"<a class=\"btn btn-outline-primary btn-sm\" href=\"$ThisFile\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i> ".ag_translate("Agenda")."</a>",
      "'!ajeven!'i"=>"$ajeven",
      "'!accesuj!'i"=>"$accesuj",
      "'!vuannu!'i"=>"$vuannu",
      "'!vulieu!'i"=>"$vulieu"
   );
   echo meta_lang(aff_langue(preg_replace(array_keys($npds_METALANG_words),array_values($npds_METALANG_words), $Xcontent)));
/*fin theme html partie 2/2*/
}
// FIN LISTE SUJET


// DEBUT LISTE AUTEUR
function vosajouts()
{
   global $ModPath, $NPDS_Prefix, $cookie;
   global $ThisFile, $nb_news, $order, $page;
   /*Debut securite*/
   settype($page,"integer");
   settype($order,"integer");
   /*Fin securite*/
   require_once('modules/'.$ModPath.'/pag_fonc.php');

   suj();
   /*Total pour naviguation*/
   $nb_entrees = sql_num_rows(sql_query("SELECT * FROM ".$NPDS_Prefix."agend_dem us WHERE posteur = '$cookie[1]' GROUP BY titre"));
   //Pour la naviguation
   $total_pages = ceil($nb_entrees/$nb_news);
   if($page == 1)
   {
      $page_courante = 1;
   }
   else
   {
      if ($page < 1)
         $page_courante = 1;
      elseif ($page > $total_pages)
         $page_courante = $total_pages;
      else
         $page_courante = $page;
   }
   $start = ($page_courante * $nb_news - $nb_news);

/*Ordre par defaut*/
   if($order == '0'){$order1 = 'valid = 3 DESC';}else if($order == '4'){$order1 = 'titre ASC';}else{$order1 = "valid = $order DESC";}
   echo '<h4>'.ag_translate('Liste de vos événements').'</h4>';
   echo '<p>'.ag_translate('Trier par').'
   <a class="btn btn-outline-success btn-sm mr-1" href="'.$ThisFile.'&amp;order=1">'.ag_translate('En Ligne').'</a>
   <a class="btn btn-secondary btn-sm mr-1" href="'.$ThisFile.'&amp;order=2">'.ag_translate('Hors Ligne').'</a>
   <a class="btn btn-outline-danger btn-sm mr-1" href="'.$ThisFile.'&amp;order=3">'.ag_translate('A valider').'
   <a class="btn btn-secondary btn-sm" href="'.$ThisFile.'&amp;order=4">'.ag_translate('Titre').'</a>
   </p>';
   echo '<table class="table table-bordered table-sm table-responsive">
    <thead class="thead-default">
   <tr>
   <th class="text-center">'.ag_translate('Titre').'</th>
   <th class="text-center">'.ag_translate('Catégorie').'</th>
   <th class="text-center px-5">'.ag_translate('Date').'</th>
   <th class="text-center px-3">'.ag_translate('Statut').'</th>
   <th class="text-center px-2">'.ag_translate('Fonctions').'</th>
   </tr>
    </thead>';
   /*Requete liste evenement suivant $cookie*/
   $result = sql_query("SELECT id, titre, topicid, valid FROM ".$NPDS_Prefix."agend_dem us WHERE posteur = '$cookie[1]' GROUP BY titre ORDER BY $order1 LIMIT $start,$nb_news");
   while(list($id, $titre, $topicid, $valid) = sql_fetch_row($result))
   {
      $titre = stripslashes(aff_langue($titre));
      echo '<tbody><tr>
      <td class="align-top">'.$titre.'</td>
      <td class="align-top">';
      $res = sql_query("SELECT topictext FROM ".$NPDS_Prefix."agendsujet WHERE id = '$topicid'");
      list($topictext) = sql_fetch_row($res);
      echo ''.stripslashes(aff_langue($titre)).'
      </td>
      <td class="text-center">';
      $res1 = sql_query("SELECT id, date FROM ".$NPDS_Prefix."agend WHERE liaison = '$id' ORDER BY date DESC");
      while(list($sid, $date) = sql_fetch_row($res1))
      {
         echo ''.$date.'<br />';
      }
      echo '</td>';
      if ($valid == 1)
      {
         echo '<td class="text-center align-top"><span class="badge badge-success">'.ag_translate('En Ligne').'</span></td>';
      }
      else if ($valid == 2)
      {
         echo '<td class="text-center align-top"><span class="badge badge-secondary">'.ag_translate('Hors Ligne').'</span></td>';
      }
      else if ($valid == 3)
      {
         echo '<td class="text-center align-top"><span class="badge badge-danger">'.ag_translate('A valider').'</span></td>';
      }

      echo '<td class="text-center align-top"><a class="mr-1" href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'"><i class="fa fa-lg fa-pencil-square-o" aria-hidden="true"></i></a>
      <a href="'.$ThisFile.'&amp;subop=suppevt&amp;id='.$id.'"><i class="fa fa-lg fa-trash text-danger" aria-hidden="true"></i></a></td></tr></tbody>';
   }
   echo '</table>';

/*Affiche pagination*/
   echo ag_pag($total_pages,$page_courante,'2',''.$ThisFile.'&amp;order='.$order.'','_mod');
   
}
// FIN LISTE AUTEUR
// DEBUT SUPPRIME EVENEMENT PAR SON AUTEUR
function suppevt($id, $ok=0)
{
   global $NPDS_Prefix, $ModPath, $cookie;
   global $ThisFile;

/*Debut securite*/
   settype($id,"integer");
/*Fin securite*/

   suj();
   if ($ok)
   {
      $result = sql_query("DELETE FROM ".$NPDS_Prefix."agend WHERE liaison = $id");
      $result1 = sql_query("DELETE FROM ".$NPDS_Prefix."agend_dem WHERE id = $id");
      if (!$result1)
      {
         echo ''.sql_error().'<br />';
         return;
      }
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Cet événement est maintenant effacé').'</p>
      <div class=""><a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'">'.ag_translate('Retour').'</a></div>';
   }
   else
   {

/*Verif id - auteur*/
      $tot = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."agend_dem WHERE id = '$id' AND posteur = '$cookie[1]'"));
      if ($tot != 0)
      {
         echo '<p class="lead text-danger font-weight-bold">'.ag_translate('Etes-vous certain de vouloir supprimer cet événement').'</p>
         <div class="btn-group"><a class="btn btn-outline-primary btn-sm mr-2" href="'.$ThisFile.'">'.ag_translate('NON').'</a>
         <a class="btn btn-outline-danger btn-sm" href="'.$ThisFile.'&amp;subop=suppevt&amp;id='.$id.'&amp;ok=1">'.ag_translate('OUI').'</a></div>';
      }
      else 
      {
         redirect_url('index.php');
      }
   }
}
// DEBUT SUPPRIME EVENEMENT PAR SON AUTEUR
// DEBUT EDITER EVENEMENT PAR SON AUTEUR
function editevt($id, $month, $an, $debut)
{
   global $ModPath, $ModStart, $NPDS_Prefix, $cookie;
   global $ThisFile, $bouton;
   /*Debut securite*/
   settype($id,"integer");
   $debut = removeHack($debut);
   /*Fin securite*/

   suj();
   /*Requete affiche evenement suivant $id*/
   $result = sql_query("SELECT titre, intro, descript, lieu, topicid, posteur, groupvoir, valid FROM ".$NPDS_Prefix."agend_dem WHERE id = '$id' AND posteur = '$cookie[1]'");
   list($titre, $intro, $descript, $lieu, $topicid, $posteur, $groupvoir, $valid) = sql_fetch_row($result);
   if (!$result)
   {
      redirect_url('index.php');
   }
   if ($debut == '')
   {
      $month = date("m", time());
      $an = date("Y", time());
      /*Requete affiche date suivant $id*/
      $result = sql_query("SELECT id, date FROM ".$NPDS_Prefix."agend WHERE liaison = '$id'");
      while(list($sid, $date) = sql_fetch_row($result))
      {
         $debut .= ''.$date.',';
      }
      $debut = substr("$debut", 0, -1);
   }
   $titre = stripslashes($titre);
   $intro = stripslashes($intro);
   $descript = stripslashes($descript);
   $lieu = stripslashes($lieu);
   echo '<h4 class="lead">'.ag_translate('Editer un événement').'</h4>';
   echo '<ul>
   <li>'.ag_translate('Etape 1 : Sélectionner vos dates').'</li>
   <li>'.ag_translate('Etape 2 : Remplisser le formulaire').'</li>
<!--<li><span class="text-danger">*</span> '.ag_translate('Champ obligatoire').'</li>-->
   </ul>';

   echo '<form method="post" action="modules.php" name="adminForm">
   <input type="hidden" name="ModPath" value="'.$ModPath.'" />
   <input type="hidden" name="ModStart" value="'.$ModStart.'" />
   <input type="hidden" name="id" value="'.$id.'" />
    <input type="hidden" name="debut" value="'.$debut.'" />'.ag_translate('Jour(s) sélectionné(s)').' :';
    echo '<ul class="list-inline">';
   $name = explode(",",$debut);
   for ($i = 0; $i < sizeof($name); $i++ )
   {
      echo '<li class="list-inline-item">'.formatfrancais($name[$i]).'<a class="text-danger mx-2" data-toggle="tooltip" data-placement="bottom" title="'.ag_translate("Supprimer").'" href="'.$ThisFile.'&amp;subop=retire&amp;ladate='.$name[$i].'&amp;debut='.$debut.'&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'"><i class="fa fa-times" aria-hidden="true"></i></a></li>';
   }
    echo '</ul>';

   cal($id, $month, $an, $debut);

   echo '<fieldset class="form-group">
   <label class="mr-sm-2" for=""><strong>'.ag_translate('Catégorie').'&nbsp;<span class="text-danger">*</span></strong></label>
   <select class="custom-select" name="topicid" value="'.$topicid.'">';

/*Requete liste categorie*/
   $res = sql_query("SELECT topicid, topictext FROM ".$NPDS_Prefix."agendsujet ORDER BY topictext ASC");
   while($categorie = sql_fetch_assoc($res))
   {
      $categorie['topictext'] = stripslashes($categorie['topictext']);
      echo '<option value=\''.$categorie['topicid'].'\'';
      if($categorie['topicid'] == $topicid)
      echo ' selected=\'selected\'';
      echo '>'.aff_langue(''.$categorie['topictext'].'').'</option>';
   }
   echo '</select>
   </fieldset>';
   echo '<fieldset class="form-group">
   <label for=""><strong>'.ag_translate('Titre').'&nbsp;<span class="text-danger">*</span></strong></label>
   <input type="hidden" name="groupvoir" value="0" />
   <input class="form-control" rows="1" name="titre" value="'.$titre.'">
   </fieldset>';
   echo '<fieldset class="form-group">
   <label for=""><strong>'.ag_translate('Résumé de l\'événement').'&nbsp;<span class="text-danger">*</span></strong></label>
   <textarea class="tin form-control" rows="2" name="desc">'.$intro.'</textarea>
   </fieldset>';
   echo '<fieldset class="form-group">
    <label for=""><strong>'.ag_translate('Description complète').'</strong></label>
    <textarea class="tin form-control" rows="20" name="longdesc">'.$descript.'</textarea>';
   echo aff_editeur("longdesc","short");
   echo '</fieldset>';
   echo '<fieldset class="form-group">
   <label class="mr-2" for=""><strong>'.ag_translate('Lieu').'</strong></label>';
   if ($bouton == '1')
   {
      echo '<input class="form-control" maxLength="50" name="lieu" value="'.$lieu.'">';
   }
   else
   {
      include('modules/'.$ModPath.'/recherche/'.$bouton.'.php');
      echo '<select class="custom-select" name="lieu">
      <option></option>';
      foreach($try as $na)
      {
         if($lieu == $na){$af = ' selected';}else{$af = '';}
         echo '<option value="'.$na.'"'.$af.'>'.$na.'</option>';
      }
      echo '</select>';
   }
      echo '</fieldset>';
   echo '
   <input type="hidden" name="subop" value="validedit" />
   <input type="submit" class="btn btn-outline-primary btn-sm" value="'.ag_translate('Modifier l\'Evénement').'" />
    <a class="btn btn-outline-danger btn-sm" href="'.$ThisFile.'&amp;subop=suppevt&amp;id='.$id.'">'.ag_translate('Supprimer cet événement').'</a>
   </form>
   <div class=""><a class="btn btn-secondary btn-sm float-right" href="javascript:history.back()">'.ag_translate('Retour').'</a></div>';
   echo '<div></div>';
}
// FIN EDITER EVENEMENT PAR SON AUTEUR


// DEBUT AFFICHAGE CALENDRIER
function cal($id, $month, $an, $debut)
{
   global $ModPath, $NPDS_Prefix;
   global $ThisFile;
   /*Debut securite*/
   settype($id,"integer");
   settype($month,"integer");
   settype($an,"integer");
   $debut = removeHack($debut);
   /*Fin securite*/
   /*Recuperation du jour, mois, et annee actuel*/
   $jour_actuel = date("j", time());
   $mois_actuel = date("m", time());
   $an_actuel = date("Y", time());
   $jour = $jour_actuel;
   /*Si la variable mois nexiste pas, mois et annee correspondent au mois et a lannee courante*/
   if(!isset($_GET["month"]))
   {
      $month = $mois_actuel;
      $an = $an_actuel;
   }
   /*Mois suivant*/
   $mois_suivant = $month + 1;
   $an_suivant = $an;
   if ($mois_suivant == 13)
   {
      $mois_suivant = 1;
      $an_suivant = $an + 1;
   }
   /*Mois precedent*/
   $mois_prec = $month - 1;
   $an_prec = $an;
   if ($mois_prec == 0)
   {
      $mois_prec = 12;
      $an_prec = $an - 1;
   }
   /*Affichage du mois et annee*/
   $mois_de_annee = array(
      ''.ag_translate('Janvier').'',
      ''.ag_translate('Février').'',
      ''.ag_translate('Mars').'',
      ''.ag_translate('Avril').'',
      ''.ag_translate('Mai').'',
      ''.ag_translate('Juin').'',
      ''.ag_translate('Juillet').'',
      ''.ag_translate('Ao&ucirc;t').'',
      ''.ag_translate('Septembre').'',
      ''.ag_translate('Octobre').'',
      ''.ag_translate('Novembre').'',
      ''.ag_translate('Décembre').'');
   $mois_en_clair = $mois_de_annee[$month - 1];
   /*Creation tableau a 31 entree sans reservation*/
   for($j = 1; $j < 32; $j++)
   {
      $tab_jours[$j] = (bool)false;
   }
   echo '<h4 class="text-center">
   <a class="mr-2" href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$mois_prec.'&amp;an='.$an_prec.'&amp;debut='.$debut.'"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
   <span class="label label-default">'.$mois_en_clair.'&nbsp;'.$an.'</span>
   <a class="ml-2" href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$mois_suivant.'&amp;an='.$an_suivant.'&amp;debut='.$debut.'"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
   </h4>';
   echo '<table class="table table-bordered table-sm">
    <thead class="thead-default">
   <tr>
   <th class="text-center">'.ag_translate('Sem').'</th>
   <th class="text-center">'.ag_translate('L').'</th>
   <th class="text-center">'.ag_translate('M').'</th>
   <th class="text-center">'.ag_translate('M ').'</th>
   <th class="text-center">'.ag_translate('J').'</th>
   <th class="text-center">'.ag_translate('V').'</th>
   <th class="text-center">'.ag_translate('S').'</th>
   <th class="text-center">'.ag_translate('D').'</th>
   </tr>
   </thead>
   <tbody>
   <tr class="text-center">';
   /*Detection du 1er et dernier jour du mois*/
   $nombre_date = mktime(0,0,0, $month, 1, $an);
   $premier_jour = date('w', $nombre_date);
   $dernier_jour = 28;
   while (checkdate($month, $dernier_jour + 1, $an))
   {
      $dernier_jour++;
   }
   /*Ajoute un 0 pour mois*/
   if($month <= 9 && substr($month, 0, 1)!= 0)
   {
      $month  = '0'.$month;
   }
   $sdate = "01/$month/$an";
   $sEngDate = substr ($sdate, -4).substr ($sdate, 3, 2).substr ($sdate, 0, 2);
   $iTime = strtotime ($sEngDate);
   $semaine = "".date ('W', $iTime)."";
   /*Si premier jour dimanche (code "0" en php)*/
   if ($premier_jour == 0)
   {
      /*Calcul numero semaine +0 pour enlever le 0 de 01,02,...*/
      $semaine0 = $semaine + 0;
      $semaine1 = $semaine + 1;
      echo '<td class="text-center">'.$semaine0.'</td>';
      /*Boucle pour les 6 premieres colonnes/jours*/
      for ($debutdimanche = 1; $debutdimanche <= 6; $debutdimanche++)
      {
         /*Si case calendrier vide*/
         echo '<td class="text-center">&nbsp;</td>'; 
      }
      /*Permet la naviguation du calendrier*/
      $date = ajout_zero(01, $month, $an);
      if ($debut == '')
      {
         $newlien = ''.$date.'';
      }
      else
      {
         $newlien = ''.$debut.','.$date.'';
      }
      /*Ajoute le jour et reste sur la meme page + css jour libre*/
      $pos = strpos($debut, $date);
      if ($pos === false)
      {
         echo '<td class="text-center"><a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">1</a></td>';
      }
      else
      {
         echo '<td class="text-center">1</td>';
      }
      echo '</tr>'
      .'<tr>';
   }
   else
   {
      /*Calcul numero semaine +0 pour enlever le 0 de 01,02,...*/
      $semaine1 = $semaine + 0;
   }
   echo '<td class="text-center">'.$semaine1.'</td>';
   /*7 premiers jour du mois*/
   for ($i = 1; $i < 8; $i++)
   {
      /*Si case calendrier vide*/
      if ($i < $premier_jour)
      {
         echo '<td class="text-center">&nbsp;</td>';
      }
      else
      {
         /*Case avec class pour reserver*/
         $ce_jour = ($i + 1) - $premier_jour;
         /*Permet la naviguation du calendrier*/
         $date = ajout_zero($ce_jour, $month, $an);
         if ($debut == '')
         {
            $newlien = ''.$date.'';
         }
         else
         {
            $newlien = ''.$debut.','.$date.'';
         }
         /*Ajoute le jour et reste sur la meme page + css jour libre*/
         $pos = strpos($debut, $date);
         if ($pos === false)
         {
            echo '<td class="text-center"><a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">'.$ce_jour.'</a></td>';
         }
         else
         {
            echo '<td class="text-center">'.$ce_jour.'</td>';
         }
      }
   }
   /*Affichage fin du calendrier*/
   $jour_suiv = ($i + 1) - $premier_jour;
   for ($rangee = 0; $rangee <= 3; $rangee++)
   {
      echo '</tr>'
      .'<tr>';
      /*Calcul numero semaine*/
      $semaine2 = $semaine1 + $rangee + 1;
      if ($semaine2 == 53){$semaine2 = "01";}
      echo '<td class="text-center">'.$semaine2.'</td>';
      for ($i = 1; $i < 8; $i++)
      {
         if($jour_suiv > $dernier_jour)
         {
            /*Case avec class pour vide*/
            echo '<td class="text-center">&nbsp;</td>';
         }
         else
         {
            /*Permet la naviguation du calendrier*/
            $date = ajout_zero($jour_suiv, $month, $an);
            if ($debut == '')
            {
               $newlien = ''.$date.'';
            }
            else
            {
               $newlien = ''.$debut.','.$date.'';
            }
            /*Ajoute le jour et reste sur la meme page + css jour libre*/
            $pos = strpos($debut, $date);
            if ($pos === false)
            {
               echo '<td class="text-center"><a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">'.$jour_suiv.'</a></td>';
            }
            else
            {
               echo '<td class="text-center">'.$jour_suiv.'</td>';
            }
         }
         $jour_suiv++;
      }
   }
   echo '</tr></table>';
}
// FIN AFFICHAGE CALENDRIER

// DEBUT VALID EDIT
function validedit ($id, $debut, $topicid, $titre, $desc, $longdesc, $lieu)
{
   global $ModPath, $ModStart, $NPDS_Prefix;
   global $ThisFile, $revalid, $menu, $courriel, $receveur;
   /*Debut securite*/
   settype($id,"integer");
   settype($topicid,"integer");
   $titre = removeHack(addslashes($titre));
   $desc = removeHack(addslashes($desc));
   $lieu = removeHack(addslashes($lieu));
   $debut = removeHack($debut);
   $longdesc = removeHack($longdesc);
   /*Fin securite*/

   suj();
   echo ''.$menu.'';
   if ($debut == '' || $topicid == '' || $titre == '' || $desc == '' || $longdesc == '')
   {
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Vous n\'avez pas remplis les champs obligatoires').'</p>
      <div class=""><i class="fa fa-info-circle mr-2" aria-hidden="true"></i><a href="javascript:history.back()">'.ag_translate('Retour').'</a></div>';
   }
   else
   {
      /*Insertion modifs evenement*/
      $result = "UPDATE ".$NPDS_Prefix."agend_dem SET titre = '$titre', intro = '$desc', descript = '$longdesc', lieu = '$lieu', topicid = '$topicid', valid = '$revalid' WHERE id = $id";
      $succes = sql_query($result) or die ("erreur : ".sql_error());
      /*Recupere id demande*/
      $result1 = "DELETE FROM ".$NPDS_Prefix."agend WHERE liaison = '$id'";
      $succes1 = sql_query($result1) or die ("erreur : ".sql_error());
      $namel = explode(",",$debut);
      sort($namel);
      for ($i = 0; $i < sizeof($namel); $i++)
      {
         /*Insertion des dates*/
         $query = "INSERT INTO ".$NPDS_Prefix."agend values ('', '$namel[$i]', '$id')";
         sql_query($query) or die(sql_error());
      }
      if ($query)
      {
         /*Envoie mail si actif dans config*/
         if ($courriel == 1 || $receveur != '')
         {
            $sujet = ag_translate('Modification événement pour agenda');
            $sujet=html_entity_decode($sujet, ENT_COMPAT, 'UTF-8');
            $message = ag_translate('Un événement modifié est à valider pour agenda').'.<br /><br />';
            include("signat.php");
            send_email($receveur,$sujet, $message, "", true, "html");
         }
         if ($revalid == 3)
         {
            echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Un administrateur validera vos changements rapidement').'</p';
         }
         else if ($revalid == 1)
         {
            echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Vos changements ont bien été ajoutés à l\'agenda').'</p>';
         }
      }
   }
}
// FIN VALID EDIT

// DEBUT RETIRE DATE
function retire($ladate, $debut, $id, $month, $an)
{
   global $ThisRedo;
   /*Debut securite*/
   settype($id,"integer");
   settype($month,"integer");
   settype($an,"integer");
   $debut = removeHack($debut);
   /*Fin securite*/
   /*On rajoute une virgule quon enleve apres sinon double virgules*/
   $debut1 = ''.$debut.',';
   $newdebut = str_replace("$ladate,", "", "$debut1");
   $newdebut = substr("$newdebut", 0, -1);
   redirect_url(''.$ThisRedo.'&subop=editevt&id='.$id.'&month='.$month.'&an='.$an.'&debut='.$newdebut.'');
}
// FIN RETIRE DATE

// FIN FONCTION


include ('modules/'.$ModPath.'/admin/pages.php');
include_once('modules/'.$ModPath.'/lang/agenda-'.$language.'.php');
   global $pdst, $language;

   /*Parametres utilises par le script*/
   $ThisFile = 'modules.php?ModPath='.$ModPath.'&amp;ModStart='.$ModStart.'';
   $ThisRedo = 'modules.php?ModPath='.$ModPath.'&ModStart=calendrier';
   include('header.php');
   include('modules/'.$ModPath.'/admin/config.php');
   require_once('modules/'.$ModPath.'/ag_fonc.php');
   echo '<div class="card"><div class="card-body">';
   /*Verifie si bon groupe*/
   if(!autorisation($gro))
   {
      redirect_url('index.php');
   }

   switch($subop)
   {
      default:
         vosajouts();
      break;
      case 'suppevt':
         suppevt($id, $ok);
      break;
      case 'editevt':
         editevt($id, $month, $an, $debut);
      break;
      case 'validedit':
         validedit ($id, $debut, $topicid, $titre, $desc, $longdesc, $lieu);
      break;
      case 'retire':
         retire($ladate, $debut, $id, $month, $an);
      break;
   }
   echo '</div></div>';
   include("footer.php");
?>