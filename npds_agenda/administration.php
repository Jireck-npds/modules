<?php
/*************************************************/
/* NPDS : Net Portal Dynamic System              */
/* ==========================                    */
/* Fichier : modules/agenda/administration.php   */
/*                                               */
/* Module Agenda                                 */
/* Version 1.0                                   */
/* Auteur Oim                                    */
/*************************************************/
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


/// DEBUT LISTE AUTEUR ///
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
   echo '<h3>'.ag_trad('Liste de vos évènements').'</h3>';
echo '<p>'.ag_trad('Trier par').'&nbsp;'
	.'<a class="btn btn-success-outline btn-sm" href="'.$ThisFile.'&amp;order=1">'.ag_trad('En Ligne').'</a>&nbsp;&nbsp;'
	.'<a class="btn btn-danger-outline btn-sm" href="'.$ThisFile.'&amp;order=2">'.ag_trad('Hors Ligne').'</a>&nbsp;&nbsp;'
	.'<a class="btn btn-warning-outline btn-sm" href="'.$ThisFile.'&amp;order=3">'.ag_trad('A valider').'</a>&nbsp;&nbsp;'
	.'<a class="btn btn-secondary btn-sm" href="'.$ThisFile.'&amp;order=4">'.ag_trad('Titre').'</a>'
	.'</p>';
	echo '<table class="table table-bordered">'   
   .'<thead class="thead-default">'
	.'<tr>'
	.'<th class="text-xs-center">'.ag_trad('Titre').'</th>'
	.'<th class="text-xs-center">'.ag_trad('Sujet').'</th>'
	.'<th class="text-xs-center">'.ag_trad('Date').'</th>'
	.'<th class="text-xs-center">'.ag_trad('Statut').'</th>'
	.'<th class="text-xs-center">'.ag_trad('Fonctions').'</th>'
	.'</tr>'
   .'</thead>';
	/*Requete liste evenement suivant $cookie*/
	$result = sql_query("SELECT id, titre, topicid, valid FROM ".$NPDS_Prefix."agend_dem us WHERE posteur = '$cookie[1]' GROUP BY titre ORDER BY $order1 LIMIT $start,$nb_news");
	while(list($id, $titre, $topicid, $valid) = sql_fetch_row($result))
	{
		$titre = stripslashes(aff_langue($titre));
		echo '<tbody><tr>'
		.'<td>'.$titre.'</td>'
		.'<td>';
		$res = sql_query("SELECT topictext FROM ".$NPDS_Prefix."agendsujet WHERE id = '$topicid'");
		list($topictext) = sql_fetch_row($res);
		echo ''.stripslashes(aff_langue($titre)).''
		.'</td>'
		.'<td class="text-xs-center">';
		$res1 = sql_query("SELECT id, date FROM ".$NPDS_Prefix."agend WHERE liaison = '$id' ORDER BY date DESC");
		while(list($sid, $date) = sql_fetch_row($res1))
		{
			echo ''.$date.'<br />';
		}
		echo '</td>';
		if ($valid == 1)
		{
			echo '<td class="table-success text-xs-center"><span class="text-success">'.ag_trad('En Ligne').'</span></td>';
		}
		else if ($valid == 2)
		{
			echo '<td class="table-danger text-xs-center"><span class="text-danger">'.ag_trad('Hors Ligne').'</span></td>';
		}
		else if ($valid == 3)
		{
			echo '<td class="table-warning text-xs-center"><span class="text-warning">'.ag_trad('A valider').'</span></td>';
		}
			
		echo '<td class="text-xs-center"><a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'"><i class="fa fa-lg fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;'
		.'<a href="'.$ThisFile.'&amp;subop=suppevt&amp;id='.$id.'"><i class="fa fa-lg fa-trash text-danger" aria-hidden="true"></i></a></td>'
		.'</tr>'
      .'</tbody>';
	}
	echo '</table>';
	/*Affiche pagination*/
	echo ag_pag($total_pages,$page_courante,'2',''.$ThisFile.'&amp;order='.$order.'','_mod');
	
}
/// FIN LISTE AUTEUR ///
/// DEBUT SUPPRIME EVENEMENT PAR SON AUTEUR ///
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
		echo '<div class="ag_deux" align="center"><span class="ag_rouge">'.ag_trad('Cet évènement est maintenant effacé.').'</span><br /><br />[&nbsp;<a href="'.$ThisFile.'">'.ag_trad('Retour').'</a>]';
	}
	else
	{
		/*Verif id - auteur*/
		$tot = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."agend_dem WHERE id = '$id' AND posteur = '$cookie[1]'"));
		if ($tot != 0)
		{
			echo '<div class="ag_deux" align="center"><span class="ag_rouge">'.ag_trad('Etes-vous s&ucirc;r de vouloir supprimer cet évènement ?').'</span><br /><br />'
			.'[&nbsp;<a href="'.$ThisFile.'">'.ag_trad('NON').'</a>&nbsp;|&nbsp;'
			.'<a href="'.$ThisFile.'&amp;subop=suppevt&amp;id='.$id.'&amp;ok=1">'.ag_trad('OUI').'</a>&nbsp;]</div>';
		}
		else 
		{
			redirect_url('index.php');
		}
	}
	
}
/// DEBUT SUPPRIME EVENEMENT PAR SON AUTEUR ///
/// DEBUT EDITER EVENEMENT PAR SON AUTEUR ///
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
	echo '<div class="ag_menu">'.ag_trad('Editer un évènement').'</div>'
	.'<form method="post" action="modules.php" name="adminForm">'
	.'<input type="hidden" name="ModPath" value="'.$ModPath.'" />'
	.'<input type="hidden" name="ModStart" value="'.$ModStart.'" />'
	.'<input type="hidden" name="id" value="'.$id.'" />'
	.'<div style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;'
	.'<img src="modules/'.$ModPath.'/images/fle.gif" border="0" />&nbsp;&nbsp;'
	.''.ag_trad('Etape 1 : Séléctionner vos dates').'<br />'
	.'&nbsp;&nbsp;&nbsp;&nbsp;<img src="modules/'.$ModPath.'/images/fle.gif" border="0" />&nbsp;&nbsp;'
	.''.ag_trad('Etape 2 : Remplisser le formulaire').'<br />'
	.'&nbsp;&nbsp;&nbsp;&nbsp;<img src="modules/'.$ModPath.'/images/fle.gif" border="0" />&nbsp;&nbsp;'
	.'<span class="ag_rouge">*</span>&nbsp;'.ag_trad('Champ obligatoire').'<br />'
	.'&nbsp;&nbsp;&nbsp;&nbsp;<img src="modules/'.$ModPath.'/images/fler.gif" border="0" />&nbsp;&nbsp;'
	.'<a href="'.$ThisFile.'&amp;subop=suppevt&amp;id='.$id.'" class="ag_rouge">'.ag_trad('Supprimer cette évènement').'</a>'
	.'</div>'
	.'<table class="table table-bordered">'
	.'<tr align="center" class="ag_trois">'
	.'<td colspan="3"><input type="hidden" name="debut" value="'.$debut.'" />'.ag_trad('Jours séléctionnés').'&nbsp;:&nbsp;';
	$name = explode(",",$debut);
	for ($i = 0; $i < sizeof($name); $i++ )
	{
		echo ''.formatfrancais($name[$i]).'&nbsp;<a href="'.$ThisFile.'&amp;subop=retire&amp;ladate='.$name[$i].'&amp;debut='.$debut.'&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'" class="ag_rouge">X</a>&nbsp;-&nbsp;';
	}
	echo '</td>'
	.'</tr>'
	.'<tr>'
	.'<td width="15%" class="ag_trois">'.ag_trad('Sujet').'&nbsp;<span class="ag_rouge">*</span></td>'
	.'<td width="55%" class="ag_deux">'
	.'<select name="topicid" value="'.$topicid.'">';
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
	echo '</select>'
	.'</td>'
	.'<td width="30%" rowspan="3" valign="top">';
	cal($id, $month, $an, $debut);
	echo '</td>'
	.'</tr>'
	.'<tr>'
	.'<input type="hidden" name="groupvoir" value="0" />'
	.'<td class="ag_trois">'.ag_trad('Titre').'&nbsp;<span class="ag_rouge">*</span></td>'
	.'<td class="ag_deux"><textarea class="textbox" cols="80" rows="2" name="titre">'.$titre.'</textarea></td>'
	.'</tr>'
	.'<tr>'
	.'<td class="ag_trois">'.ag_trad('Résumé de l\'évènement').'&nbsp;<span class="ag_rouge">*</span></td>'
	.'<td class="ag_deux"><textarea class="textbox" cols="80" rows="4" name="desc">'.$intro.'</textarea></td>'
	.'</tr>'
	.'<tr class="ag_trois" align="center">'
	.'<td colspan="3">'.ag_trad('Description complète (facultative)').'</td>'
	.'</tr>'
	.'<tr class="ag_deux" align="center">'
	.'<td colspan="3"><textarea class="textbox" name="longdesc" cols="50" rows="20" style="width: 90%;">'.$descript.'</textarea></td>';
	echo aff_editeur("longdesc","false");
	echo '</tr>'
	.'<tr>'
	.'<td class="ag_trois">'.ag_trad('Lieu').'</td>'
	.'<td colspan ="2"class="ag_deux">';
	if ($bouton == '1')
	{
		echo '<input maxLength="50" name="lieu" value="'.$lieu.'" size="50" />';
	}
	else
	{
		include('modules/'.$ModPath.'/recherche/'.$bouton.'.php');
		echo '<select name="lieu">'
		.'<option></option>';
		foreach($try as $na)
		{
   		if($lieu == $na){$af = ' selected';}else{$af = '';}
			echo '<option value="'.$na.'"'.$af.'>'.$na.'</option>';
		}
		echo '</select>';
	}
	echo '</td>'
	.'</tr>'
	.'<tr class="ag_trois">'
	.'<td align="center" colspan="3">'
	.'<input type="hidden" name="subop" value="validedit" />'
	.'<input type="submit" class="ag_bouton" value="'.ag_trad('Modifier l\'Evènement').'" />'
	.'</td>'
	.'</tr>'
	.'</table>'
	.'</form>'
	.'<div align="center" class="ag_trois"><a href="javascript:history.back()">'.ag_trad('Retour').'</a></div>';
	
}
/// FIN EDITER EVENEMENT PAR SON AUTEUR ///
/// DEBUT AFFICHAGE CALENDRIER ///
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
		''.ag_trad('Janvier').'',
		''.ag_trad('Février').'',
		''.ag_trad('Mars').'',
		''.ag_trad('Avril').'',
		''.ag_trad('Mai').'',
		''.ag_trad('Juin').'',
		''.ag_trad('Juillet').'',
		''.ag_trad('Ao&ucirc;t').'',
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
	echo '<table class="table table-bordered">'
	.'<tr>'
	.'<td colspan="8" class="ag_une">'
	.'<a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$mois_prec.'&amp;an='.$an_prec.'&amp;debut='.$debut.'" class="ag_lidate">&lt;&lt;</a>'
	.'&nbsp;&nbsp;'.$mois_en_clair.'&nbsp;'.$an.'&nbsp;&nbsp;'
	.'<a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$mois_suivant.'&amp;an='.$an_suivant.'&amp;debut='.$debut.'" class="ag_lidate">&gt;&gt;</a>'
	.'</td>'
	.'</tr>'
	.'<tr align="center">'
	.'<td width="20px" class="ag_jours">'.ag_trad('Sem').'</td>'
	.'<td width="10px" class="ag_jours">'.ag_trad('L').'</td>'
	.'<td width="10px" class="ag_jours">'.ag_trad('M').'</td>'
	.'<td width="10px" class="ag_jours">'.ag_trad('M ').'</td>'
	.'<td width="10px" class="ag_jours">'.ag_trad('J').'</td>'
	.'<td width="10px" class="ag_jours">'.ag_trad('V').'</td>'
	.'<td width="10px" class="ag_jours">'.ag_trad('S').'</td>'
	.'<td width="10px" class="ag_jours">'.ag_trad('D').'</td>'
	.'</tr>'
	.'<tr align="center">';
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
		echo '<td class="ag_sem">'.$semaine0.'</td>';
		/*Boucle pour les 6 premieres colonnes/jours*/
		for ($debutdimanche = 1; $debutdimanche <= 6; $debutdimanche++)
		{
			/*Si case calendrier vide*/
			echo '<td class="ag_vide">&nbsp;</td>'; 
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
			echo '<td class="ag_libre"><a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">1</a></td>';
		}
		else
		{
			echo '<td class="ag_reserve">1</td>';
		}
		echo '</tr>'
		.'<tr align="center">';
	}
	else
	{
		/*Calcul numero semaine +0 pour enlever le 0 de 01,02,...*/
		$semaine1 = $semaine + 0;
	}
	echo '<td class="ag_sem">'.$semaine1.'</td>';
	/*7 premiers jour du mois*/
	for ($i = 1; $i < 8; $i++)
	{
		/*Si case calendrier vide*/
		if ($i < $premier_jour)
		{
			echo '<td class="ag_vide">&nbsp;</td>';
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
				echo '<td class="ag_libre"><a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">'.$ce_jour.'</a></td>';
			}
			else
			{
				echo '<td class="ag_reserve">'.$ce_jour.'</td>';
			}
		}
	}
	/*Affichage fin du calendrier*/
	$jour_suiv = ($i + 1) - $premier_jour;
	for ($rangee = 0; $rangee <= 3; $rangee++)
	{
		echo '</tr>'
		.'<tr align="center">';
		/*Calcul numero semaine*/
		$semaine2 = $semaine1 + $rangee + 1;
		if ($semaine2 == 53){$semaine2 = "01";}
		echo '<td class="ag_sem">'.$semaine2.'</td>';
		for ($i = 1; $i < 8; $i++)
		{
			if($jour_suiv > $dernier_jour)
			{
				/*Case avec class pour vide*/
				echo '<td class="ag_vide">&nbsp;</td>';
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
					echo '<td class="ag_libre"><a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">'.$jour_suiv.'</a></td>';
				}
				else
				{
					echo '<td class="ag_reserve">'.$jour_suiv.'</td>';
				}
			}
			$jour_suiv++;
		}
	}
	echo '</tr>'
	.'</table><br />';
}
/// FIN AFFICHAGE CALENDRIER ///
/// DEBUT VALID EDIT ///
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
		echo '<div align="center" class="rouge">'.ag_trad('Vous n\'avez pas remplis les champs obligatoires').'</div><br />'
		.'<div align="center" class="rouge"><a href="javascript:history.back()">'.ag_trad('Retour').'</a></div><br />';
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
				$subject = ag_trad('Modification évènement pour agenda');
				$message = ag_trad('Un évènement modifié est à valider pour l\'agenda.');
				send_email($receveur,$subject, $message, "", true, "html");
			}
			if ($revalid == 3)
			{
				echo '<div align="center" class="rouge">'.ag_trad('Un administrateur validera vos changements rapidement').'.</div><br />';
			}
			else if ($revalid == 1)
			{
				echo '<div align="center" class="rouge">'.ag_trad('Vos changements ont bien été ajoutés à l\'agenda').'.</div><br />';
			}
		}
	}
	
}
/// FIN VALID EDIT ///
/// DEBUT RETIRE DATE ///
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
/// FIN RETIRE DATE ///
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
	$ThisRedo = 'modules.php?ModPath='.$ModPath.'&ModStart='.$ModStart.'';
	include('header.php');
	include('modules/'.$ModPath.'/admin/config.php');
	require_once('modules/'.$ModPath.'/ag_fonc.php');
   echo '<div class="card"><div class="card-block">';
	/*Verifie si bon groupe*/
	if(!autorisation($gro))
	{
		redirect_url('index.php');
	}
	$pdst = "0";
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