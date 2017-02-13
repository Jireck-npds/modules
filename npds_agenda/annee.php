<?php
/********************************************/
/* NPDS : Net Portal Dynamic System         */
/* ==========================               */
/* Fichier : modules/agenda/annee.php       */
/*                                          */
/* Module Agenda                            */
/* Version 1.0                              */
/* Auteur Oim                               */
/********************************************/
// For More security
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security
//////////////////////
/// DEBUT FONCTION ///
//////////////////////

/// DEBUT LISTE SUJET ///
function suj()
{	global $NPDS_Prefix, $ModPath, $theme, $bouton;
	global $ThisRedo, $ThisFile, $gro;
	/*debut theme html partie 1/2*/
//	$inclusion = false;

		$inclusion = "modules/".$ModPath."/html/sujet.html";

	/*fin theme html partie 1/2*/
	/*Si membre appartient au bon groupe*/
	if(autorisation($gro))
	{
		$ajeven = '
         <div class="btn-group" role="group" aria-label="">
            <a class="btn btn-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration">'.ag_trad('Vos ajouts').'</a>
         </div>
         <div class="btn-group" role="group" aria-label="">
            <a class="btn btn-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=agenda_add"><i class="fa fa-plus" aria-hidden="true"></i> '.ag_trad('Ajouter un évènement').'</a>
         </div>';
	}

	$accesuj = '<label><strong>'.ag_trad('Accès direct à un sujet').'</strong></label>'
	.'<select class="form-control c-select" onchange="window.location=(\''.$ThisRedo.'&subop=listsuj&sujet='.$stopicid.'\'+this.options[this.selectedIndex].value)">'
	.'<option>'.aff_langue('Liste des sujets disponibles').'</option>';
	/*Requete liste sujet*/
	$result = sql_query("SELECT topicid, topictext FROM ".$NPDS_Prefix."agendsujet ORDER BY topictext ASC"); 
	while(list($stopicid, $topictext) = sql_fetch_row($result))
	{
		$topictext = stripslashes(aff_langue($topictext));
		$accesuj .= '<option value="'.$stopicid.'">'.$topictext.'</option>';
	}
	if($bouton == '1')
	{
		$rech = ''.ag_trad('Par ville').'';
	}
	else
	{
		$rech = ''.ag_trad('Par').'&nbsp;'.$bouton.'';
	}
	$accesuj .= '</select>';
     
	$vuannu ='<div class="btn-group" role="group" aria-label="">
               <a class="btn btn-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=annee">'.ag_trad('Vue annuelle').'</a>
            </div>';

	$vulieu ='<div class="btn-group" role="group" aria-label="">
               <a class="btn btn-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=lieu">'.$rech.'</a>
            </div>';
   
	/*debut theme html partie 2/2*/
	ob_start();
	include ($inclusion);
	$Xcontent = ob_get_contents();
	ob_end_clean();
	$npds_METALANG_words = array(
		"'!titre!'i"=>"<a class=\"btn btn-outline-primary btn-sm pull-xs-right\" href=\"$ThisFile\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i> ".ag_trad("Agenda")."</a>",
		"'!ajeven!'i"=>"$ajeven",
		"'!accesuj!'i"=>"$accesuj",
		"'!vuannu!'i"=>"$vuannu",
		"'!vulieu!'i"=>"$vulieu"
	);
	echo meta_lang(aff_langue(preg_replace(array_keys($npds_METALANG_words),array_values($npds_METALANG_words), $Xcontent)));
	/*fin theme html partie 2/2*/
}
/// FIN LISTE SUJET ///

/// DEBUT LISTE EVENEMENT ///
function listsuj($an)
{
	global $NPDS_Prefix, $ModPath, $theme;
	global $ThisFile;
	/*Debut securite*/
	settype($an,"integer");
	/*Fin securite*/
	if ($an == '')
	{
		$an = date("Y", time());
	
	}
	$prec = ($an - 1);
	$suiv = ($an + 1);
   echo '<div class="card"><div class="card-block">';
	suj();
	/*debut theme html partie 1/2*/
	$inclusion = false;
      $inclusion = "modules/".$ModPath."/html/annee.html";

	/*fin theme html partie 1/2*/



	echo '<h3 class="text-xs-center">'
	.'<a class="btn btn-lg" href="'.$ThisFile.'&amp;an='.$prec.'"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>'
	.'<a href="modules.php?ModPath='.$ModPath.'&ModStart=calendrier&month=01&an='.$an.'"><span class="label label-default">'.ag_trad('Année').'&nbsp;'.$an.'</span></a>'
	.'<a class="btn btn-lg" href="'.$ThisFile.'&amp;an='.$suiv.'"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>'
   .'</h3>';
	echo '<div class="row">';
  
	for ($month = 1; $month < 4; $month++)
	{
		echo '<div class="col-md-4">';
		calend($an, $month);
		echo '</div>';
	}
	echo '</div>'
	.'<div class="row">';
  for ($month = 4; $month < 7; $month++)
  {
		echo '<div class="col-md-4">';
		calend($an, $month);
		echo '</div>';
	}
	echo '</div>'
	.'<div class="row">';   
  for ($month = 7; $month < 10; $month++)
  {
		echo '<div class="col-md-4">';
		calend($an, $month);
		echo '</div>';
	}  
	echo '</div>'
	.'<div class="row">';
	for ($month = 10; $month < 13; $month++)
	{
		echo '<div class="col-md-4">';
		calend($an, $month);
		echo '</div>';
	}
	echo '</div>'
	.'<br />';
	/*debut theme html partie 2/2*/
	ob_start();
	include ($inclusion);
	$Xcontent = ob_get_contents();
	ob_end_clean();
	$npds_METALANG_words = array(
	);
	echo meta_lang(aff_langue(preg_replace(array_keys($npds_METALANG_words),array_values($npds_METALANG_words), $Xcontent)));
	/*fin theme html partie 2/2*/
	Closetable();
}
/// FIN LISTE EVENEMENT ///
/// DEBUT CALENDRIER ///
function calend($an, $month)
{
	global $ModPath, $NPDS_Prefix;
	/*Debut securite*/
	settype($an,"integer");
	settype($month,"integer");
	/*Fin securite*/
	/*Recuperation du jour, mois, et annee actuel*/
	$jour_actuel = date("j", time());
	$mois_actuel = date("m", time());
	$an_actuel = date("Y", time());
	/*Affichage du mois et annee*/
	$mois_de_annee = array(
						''.ag_trad('Janvier').'',
						''.ag_trad('Février').'',
						''.ag_trad('Mars').'',
						''.ag_trad('Avril').'',
						''.ag_trad('Mai').'',
						''.ag_trad('Juin').'',
						''.ag_trad('Juillet').'',
						''.ag_trad('Août').'',
						''.ag_trad('Septembre').'',
						''.ag_trad('Octobre').'',
						''.ag_trad('Novembre').'',
						''.ag_trad('Décembre').'');
	$mois_en_clair = $mois_de_annee[$month - 1];
	/*Creation tableau a 31 entree sans reservation*/
	for($j = 1; $j < 32; $j++)
	{
		$tab_jours[$j] = (bool)false;
	}
	/*Requete recupere evevement*/
	$requete = sql_query("SELECT 
			us.date, 
			ut.titre, ut.groupvoir 
		FROM 
			".$NPDS_Prefix."agend us, 
			".$NPDS_Prefix."agend_dem ut 
		WHERE 
			YEAR(us.date) = '$an' 
			AND MONTH(us.date) = '$month'
			AND us.liaison = ut.id 
			AND ut.valid = '1'");
		/*Recupere les jours feries*/
		foreach (ferie ($month, $an) as $day => $fete)
		{
			$tab_jours[$day] = 1;
			$fetetitre[$day] = $fete;
		}
	/*Affiche resultat*/
	while(list($date, $titre, $groupvoir) = sql_fetch_row($requete))
	{
		/*Si membre appartient au bon groupe*/
		if(autorisation($groupvoir))
		{
			$titre = stripslashes(aff_langue($titre));
			/*Transforme aaaa/mm/jj en jj*/
			$jour_reserve = (int)substr($date, 8, 2);
			/*Insertion des jours reserve dans le tableau*/
			$tab_jours[$jour_reserve] = (bool)true;
			/*Recupere titre des evenements*/
			$afftitre[$jour_reserve] .= $titre;
		}
	}
	echo '<p class="text-xs-center"><a class="btn btn-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=calendrier&amp;month='.$month.'&an='.$an.'">'.$mois_en_clair.'</a></p>';
   echo '<table class="table table-bordered table-sm table-striped">'
   .'<thead class="thead-default">'
	.'<tr >'
	.'<th class="text-xs-center">'.ag_trad('L').'</th>'
	.'<th class="text-xs-center">'.ag_trad('M').'</th>'
	.'<th class="text-xs-center">'.ag_trad('M').'</th>'
	.'<th class="text-xs-center">'.ag_trad('J').'</th>'
	.'<th class="text-xs-center">'.ag_trad('V').'</th>'
	.'<th class="text-xs-center">'.ag_trad('S').'</th>'
	.'<th class="text-xs-center">'.ag_trad('D').'</th>'
	.'</tr>'
   .'</thead>'
   .'<tbody>'
	.'<tr>';
	/*Detection du 1er et dernier jour du mois*/
	$nombre_date = mktime(0,0,0, $month, 1, $an);
	$premier_jour = date('w', $nombre_date);
	$dernier_jour = 28;
	while (checkdate($month, $dernier_jour + 1, $an))
	{
		$dernier_jour++;
	}
	$sdate = "01/$month/$an";
	$sEngDate = substr ($sdate, -4).substr ($sdate, 3, 2).substr ($sdate, 0, 2);
	$iTime = strtotime ($sEngDate);
	$num = "".date ('W', $iTime)."";
	/*Si premier jour dimanche (code "0" en php)*/
	if ($premier_jour == 0)
	{
		/*Boucle pour les 6 premieres colonnes/jours*/
		for ($debutdimanche = 1; $debutdimanche <= 6; $debutdimanche++)
		{
			/*Si case calendrier vide*/
			echo  '<td class="text-xs-center">&nbsp;</td>'; 
		}
		/*Permet la naviguation du calendrier*/
		$date = ajout_zero(01, $month, $an);
		/*Met en rouge ce jour*/
		if ($jour_suiv == $jour_actuel && $month == $mois_actuel && $an == $an_actuel) {$cs = 'text-danger';}else{$cs = 'text-muted';}
		/*Si ce premier dimanche est "reserve"*/
		if($tab_jours[1])
		{
			/*Si jour ferie sans evenement*/
			if ($afftitre[$tab_jours[1]] == '' && $fetetitre[$tab_jours[1]] != ''){$cla = 'text-warning';}
			else if ($afftitre[$tab_jours[1]] != '' && $fetetitre[$tab_jours[1]] == ''){$cla = 'text-info';}
			else if ($afftitre[$tab_jours[1]] != '' && $fetetitre[$tab_jours[1]] != ''){$cla = 'text-info';}
			/*Ajoute le jour et reste sur la meme page + css jour evenement*/
			echo  '<td class="text-xs-center '.$cla.'">'
			.'<a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=calendrier&amp;subop=jour&amp;date='.$date.'" class="" data-toggle="tooltip" data-placement="bottom" title="'.aff_langue($fetetitre[$tab_jours[1]]).''.$afftitre[1].'"><span class="'.$cs.'">1</span></a>'
			.'</td>';
		}
		else
		{
			//css jour libre
			echo  '<td class="text-xs-center"><span class="'.$cs.'">1</span></td>';
		}
		echo  '</tr>'
		.'<tr>';
	}
	/*7 premiers jour du mois*/
	for ($i = 1; $i < 8; $i++)
	{
		/*Si case calendrier vide*/
		if ($i < $premier_jour)
		{
			echo  '<td class="text-xs-center">&nbsp;</td>';
		}
		else
		{
			/*Case avec class pour reserver*/
			$ce_jour = ($i + 1) - $premier_jour;
			/*Permet la naviguation du calendrier*/
			$date = ajout_zero($ce_jour, $month, $an);
			/*Met en rouge ce jour*/
			if ($jour_suiv == $jour_actuel && $month == $mois_actuel && $an == $an_actuel) {$cs = 'text-danger';}else{$cs = 'text-muted';}
			if($tab_jours[$ce_jour])
			{
				/*Si jour ferie sans evenement*/
				if ($afftitre[$ce_jour] == '' && $fetetitre[$ce_jour] != ''){$cla = 'table-warning';}
				else if ($afftitre[$ce_jour] != '' && $fetetitre[$ce_jour] == ''){$cla = 'text-info';}
				else if ($afftitre[$ce_jour] != '' && $fetetitre[$ce_jour] != ''){$cla = 'text-info';}
				/*Ajoute le jour et reste sur la meme page + css jour evenement*/
				echo  '<td class="text-xs-center '.$cla.'">'
				.'<a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=calendrier&amp;subop=jour&amp;date='.$date.'" class="" data-toggle="tooltip" data-placement="bottom" title="'.aff_langue($fetetitre[$ce_jour]).''.$afftitre[$ce_jour].'"><span class="'.$cs.'">'.$ce_jour.'</span></a>'
				.'</td>';
			}
			else
			{
				//css libre
				echo  '<td class="text-xs-center"><span class="'.$cs.'">'.$ce_jour.'</span></td>';
			}
		}
	}
	/*Affichage fin du calendrier*/
	$jour_suiv = ($i + 1) - $premier_jour;
	for ($rangee = 0; $rangee <= 3; $rangee++)
	{
		echo  '</tr>'
		.'<tr>';
		for ($i = 1; $i < 8; $i++)
		{
			if($jour_suiv > $dernier_jour)
			{
				/*Case avec class pour vide*/
				echo  '<td class="text-xs-center">&nbsp;</td>';
			}
			else
			{
				/*Permet la naviguation du calendrier*/
				$date = ajout_zero($jour_suiv, $month, $an);
				/*Met en rouge ce jour*/
				if ($jour_suiv == $jour_actuel && $month == $mois_actuel && $an == $an_actuel) {$cs = 'text-danger';}else{$cs = 'text-muted';}
				/*Case avec class pour reserver*/
				if($tab_jours[$jour_suiv])
				{
					/*Si jour ferie sans evenement*/
					if ($afftitre[$jour_suiv] == '' && $fetetitre[$jour_suiv] != ''){$cla = 'table-warning';}
					else if ($afftitre[$jour_suiv] != '' && $fetetitre[$jour_suiv] == ''){$cla = 'table-info';}
					else if ($afftitre[$jour_suiv] != '' && $fetetitre[$jour_suiv] != ''){$cla = 'table-info';}
					/*Ajoute le jour et reste sur la meme page + css jour evenement*/
					echo  '<td class="text-xs-center '.$cla.'">'
					.'<a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=calendrier&amp;subop=jour&amp;date='.$date.'" class="" data-toggle="tooltip" data-placement="bottom" title="'.aff_langue($fetetitre[$jour_suiv]).''.$afftitre[$jour_suiv].'"><span class="'.$cs.'">'.$jour_suiv.'</span></a>'
					.'</td>';
				}
				else
				{
					//css libre
					echo  '<td class="text-xs-center"><span class="'.$cs.'">'.$jour_suiv.'</span></td>';
				}
			}
			$jour_suiv++;
		}
	}
	echo  '</tr>'
   .'</tbody>'
	.'</table>';
}
/// FIN CALENDRIER ///
////////////////////
/// FIN FONCTION ///
////////////////////
	/*Debut Retro compatibilité SABLE*/
	if (!function_exists('sql_connect'))
	{
		include ('modules/'.$ModPath.'/retro-compat/mysql.php');
	} 
	/*Fin Retro compatibilité SABLE*/
	if (file_exists('modules/'.$ModPath.'/admin/pages.php'))
	{
		include ('modules/'.$ModPath.'/admin/pages.php');
	}
	global $pdst, $language;
	if (file_exists('modules/'.$ModPath.'/lang/'.$language.'.php'))
	{
		include_once('modules/'.$ModPath.'/lang/'.$language.'.php');
	}
	else
	{
		include_once('modules/'.$ModPath.'/lang/french.php');
	}
	/*Parametres utilises par le script*/
	$ThisFile = 'modules.php?ModPath='.$ModPath.'&amp;ModStart='.$ModStart.'';
	include('header.php');
	include('modules/'.$ModPath.'/admin/config.php');
	require_once('modules/'.$ModPath.'/ag_fonc.php');
	include ('modules/'.$ModPath.'/cache.timings.php');

	if ($SuperCache)
	{
		$cache_obj = new cacheManager();
		$cache_obj->startCachingPage();
	}
	if (($cache_obj->genereting_output == 1) or ($cache_obj->genereting_output == -1) or (!$SuperCache))
	{
		switch($subop)
		{
			default:
				listsuj($an);
			break;
			case 'calend':
				calend($an, $month);
			break;
			case 'petit':
				petit($date, $id);
			break;
	
		}
	}
	if ($SuperCache)
	{
		$cache_obj->endCachingPage();
	}
	include("footer.php");
?>