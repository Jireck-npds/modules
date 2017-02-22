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

//////////////////////
/// DEBUT FONCTION ///
//////////////////////

/// DEBUT AJOUT ///
function ajout($month, $an, $debut)
{
	global $NPDS_Prefix, $ModPath, $ModStart;
	global $ThisFile, $user, $cookie, $menu, $bouton;

//Debut securite
   settype($month,"integer");
   settype($an,"integer");
   $debut = removeHack($debut);
   $fin = removeHack($fin);
// Fin securite

   echo '<form method="post" action="modules.php" name="adminForm">
   <input type="hidden" name="ModPath" value="'.$ModPath.'">
   <input type="hidden" name="ModStart" value="'.$ModStart.'">
   <input type="hidden" name="debut" value="'.$debut.'">';   
   cal($month, $an, $debut);
   echo '<fieldset class="form-group">';
   if ($debut != '')
   {
   echo '<label><strong>'.ag_translate('Jour(s) séléctionné(s)').'</strong><span class="text-danger ml-2"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>';
   echo '<ul class="list-inline">';
   $name = explode(",",$debut);
		for ($i = 0; $i < sizeof($name); $i++ )
		{
			echo '<li class="list-inline-item"><span class="badge badge-default">'.formatfrancais($name[$i]).'</span><a class="text-danger mx-2" data-toggle="tooltip" data-placement="bottom" title="'.ag_translate("Supprimer").'" href="'.$ThisFile.'&amp;subop=retire&amp;ladate='.$name[$i].'&amp;debut='.$debut.'&amp;month='.$month.'&amp;an='.$an.'"><i class="fa fa-window-close" aria-hidden="true"></i></a></li>';
		}
      echo '</ul>';
	}
	else
	{
		echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Pour ajouter des dates, sélectionner le(s) jour(s) dans le calendrier').'<i class="fa fa-asterisk text-danger ml-2" aria-hidden="true"></i></p>';
	}
   echo '</fieldset>';

   echo '<fieldset class="form-group">
   <label class="mr-sm-2" for=""><strong>'.ag_translate('Sujet').'</strong><span class="text-danger ml-2"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
	<select class="custom-select" name="topicid">';

/*Requete liste categorie*/
	$toplist = sql_query("SELECT topicid, topictext FROM ".$NPDS_Prefix."agendsujet ORDER BY topictext");
	echo '<option value="">'.aff_langue('Choix catégorie').'</option>';
	while(list($topicid, $topics) = sql_fetch_row($toplist))
	{
		$topics = stripslashes(aff_langue($topics));
		if ($topicid == $topic)
		{
			$sel = "selected ";
		}
		echo '<option '.$sel.' value="'.$topicid.'">'.$topics.'</option>';
		$sel = "";
	}
	echo '</select>
	</fieldset>';

	echo '<fieldset class="form-group">
	<label for=""><strong>'.ag_translate('Titre').'</strong><span class="text-danger ml-2"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
	<input type="hidden" name="groupvoir" value="0">
	<input class="form-control" name="titre">
	</fieldset>';
	echo '<fieldset class="form-group">
	<label for=""><strong>'.ag_translate('Résumé de l\'évènement').'</strong><span class="text-danger ml-2"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
	<textarea class="tin form-control" rows="" name="desc"></textarea>
	</fieldset>';
	echo '<fieldset class="form-group">
	<label for=""><strong>'.ag_translate('Description complète').'</strong><span class="text-danger ml-2"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
	<textarea class="tin form-control" name="longdesc" rows=""></textarea>';
    echo aff_editeur("longdesc", "true");
	echo '</fieldset>';
	echo '<fieldset class="form-group">
	<label for=""><strong>'.ag_translate('Lieu').'</strong><span class="text-danger mx-2"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>';
	if ($bouton == '1')
	{
		echo '<input class="form-control" type="text" name="lieu">';
	}
	else
	{
		include('modules/'.$ModPath.'/recherche/'.$bouton.'.php');
		echo '<select class="custom-select" name="lieu">'
		.'<option>'.ag_translate('Sélection région ou département').'  </option>';
		foreach($try as $na)
		{
			echo '<option value="'.$na.'">'.$na.'</option>';
		}
		echo '</select>';
	}
	echo '</fieldset>';
	echo '
	<input type="hidden" name="member" value="'.$cookie[1].'">
	<input type="hidden" name="subop" value="catcreer">
	<button type="submit" class="btn btn btn-outline-primary btn-sm"><i class="fa fa-check"></i> '.ag_translate('Valider').'</button>
	</form>';
	
	echo '<div class="float-right"><a class="btn btn-secondary btn-sm" href="javascript:history.back()">'.ag_translate('Retour').'</a></div>';
}
/// FIN AJOUT ///



/// DEBUT AFFICHAGE CALENDRIER ///
function cal($month, $an, $debut)
{
	global $ModPath, $NPDS_Prefix;
	global $ThisFile;
	/*Debut securite*/
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
		''.ag_translate('Août').'',
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
	<a href="'.$ThisFile.'&amp;month='.$mois_prec.'&amp;an='.$an_prec.'&amp;debut='.$debut.'" class="mr-2"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
	<span class="label label-default">'.$mois_en_clair.'&nbsp;'.$an.'</span>
	<a href="'.$ThisFile.'&amp;month='.$mois_suivant.'&amp;an='.$an_suivant.'&amp;debut='.$debut.'" class="ml-2"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
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
			echo '<td class="text-center"><a href="'.$ThisFile.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">1</a></td>';
		}
		else
		{
			echo '<td class="text-center">1</td>';
		}
		echo '</tr>
		<tr>';
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
				$newlien = $date;
			}
			else
			{
				$newlien = ''.$debut.', '.$date.'';
			}
			/*Ajoute le jour et reste sur la meme page + css jour libre*/
			$pos = strpos($debut, $date);
			if ($pos === false)
			{
				echo '<td class="text-center"><a href="'.$ThisFile.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">'.$ce_jour.'</a></td>';
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
					$newlien = $date;
				}
				else
				{
					$newlien = ''.$debut.', '.$date.'';
				}
				/*Ajoute le jour et reste sur la meme page + css jour libre*/
				$pos = strpos($debut, $date);
				if ($pos === false)
				{
					echo '<td class="text-center"><a href="'.$ThisFile.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">'.$jour_suiv.'</a></td>';
				}
				else
				{
					echo '<td data-toggle="tooltip" data-placement="bottom" title="Réservée" class="text-center font-weight-bold alert alert-info">'.$jour_suiv.'</td>';
				}
			}
			$jour_suiv++;
		}
	}
	echo '</tr>
   </tbody>
	</table>';
}
/// FIN AFFICHAGE CALENDRIER ///
/// DEBUT VALID AJOUT ///
function catcreer ($debut, $topicid, $groupvoir, $titre, $desc, $longdesc, $lieu, $statut, $member)
{
	global $ModPath, $ModStart, $NPDS_Prefix;
	global $ThisFile, $valid, $menu, $courriel, $receveur;
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
	if ($debut == '' || $topicid == '' || $titre == '' || $desc == '' || $longdesc == '' || $lieu == '')
	{
		echo '<p class="lead text-danger"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Vous n\'avez pas rempli les champs obligatoires').'</p>
		<div class="float-right"><a class="btn btn-secondary btn-sm" href="javascript:history.back()">'.ag_translate('Retour').'</a></div>';
	}
	else
	{

/*Enregistrement demande*/
   $result = sql_query("INSERT INTO ".$NPDS_Prefix."agend_dem SET id = '', titre = '$titre', intro = '$desc', descript = '$longdesc', lieu = '$lieu', topicid = '$topicid', posteur = '$member', groupvoir = '$groupvoir', valid = '$valid'");

/*Recupere id demande*/
   $result1 = sql_query("SELECT id FROM ".$NPDS_Prefix."agend_dem ORDER BY id DESC LIMIT 0,1");
   list($sid) = sql_fetch_row($result1);
   $namel = explode(",",$debut);
   sort($namel);
   for ($i = 0; $i < sizeof($namel); $i++)
   {

/*Insertion des dates*/
   $query = "INSERT INTO ".$NPDS_Prefix."agend values ('', '$namel[$i]', '$sid')";
   sql_query($query) or die(sql_error());
   }
   if ($query)
   {

/*Envoie mail si actif dans config*/
   if ($courriel == 1 || $receveur != '')
   {
   $subject = ag_translate('Evènement nouveau dans agenda');
   $message = ag_translate('Un Evènement nouveau est à valider dans l\'agenda.');
   send_email($receveur,$subject, $message, "", true, "html");
   }
   if ($valid == 3)
   {
   echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Merci pour votre contribution, un administrateur la validera rapidement').'</p>';
   }
   else if ($valid == 1)
   {
   echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Votre nouvel évènement à bien été ajouté à l\'agenda').'</p>';
   }
   }
   }
}
// FIN VALID AJOUT

// DEBUT RETIRE DATE
function retire($ladate, $debut, $month, $an)
{
   global $ThisRedo;
   /*Debut securite*/
   settype($id,"integer");
   settype($month,"integer");
   settype($an,"integer");
   $debut = removeHack($debut);
   /*Fin securite*/

/*On rajoute une virgule qu'on enlève après sinon double virgules*/
   $debut1 = ''.$debut.',';
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

/*Parametres utilises par le script*/
   $ThisFile = 'modules.php?ModPath='.$ModPath.'&amp;ModStart='.$ModStart.'';
   $ThisRedo = 'modules.php?ModPath='.$ModPath.'&ModStart='.$ModStart.'';

echo '<div class="card"><div class="card-block">';
echo '<h4><i class="fa fa-plus mr-2" aria-hidden="true"></i>'.ag_translate('Proposer un évènement').'</h4>';

/*Si membre appartient au bon groupe*/

   if(autorisation($gro)) {
   switch($subop) {
   default:
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
   else {
   redirect_url('index.php');
   }
   echo '</div></div>';
   include('footer.php');
?>