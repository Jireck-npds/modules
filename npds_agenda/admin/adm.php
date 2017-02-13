<?php
/*******************************************************/
/* NPDS : Net Portal Dynamic System                    */
/* ==========================                          */
/* Fichier : modules/agenda/admin/admin.php            */
/*                                                     */
/* Module Agenda                                       */
/* Version 1.0                                         */
/* Auteur Oim                                          */
/*******************************************************/

if (!strstr($PHP_SELF,'admin.php')) { Access_Error(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}

/// DEBUT MENU PRINCIPAL ///
function menuprincipal()
{
	global $NPDS_Prefix, $ModPath;
	global $ThisFile;
	$version = 'V.1.0';
	echo '<div class="titre_module">'.adm_ag_trad('Administration d\'Agenda').'&nbsp;'.$version.'</div>'
	.'<div class="cadre_admin">'
	.'<div class="titre_admin" align="center">[&nbsp;<a href='.$ThisFile.'>'.adm_ag_trad('Accueil').'</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;'
	.'<a href="'.$ThisFile.'&amp;subop=topicsmanager">'.adm_ag_trad('Cat&eacute;gories').'</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;'
	.'<a href="'.$ThisFile.'&amp;subop=configuration">'.adm_ag_trad('Configuration').'</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;'
	.'<a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=calendrier">'.adm_ag_trad('Voir le module').'</a>&nbsp;]</div><br />';
	/*Requete compte nbre devenements suivant etat*/
	$query = sql_query("SELECT count(id), valid FROM ".$NPDS_Prefix."agend_dem GROUP BY valid");
	while (list($count, $valid) = sql_fetch_row($query))
	{
		if ($valid == 1)
		{
			$en_l = $count;
		}
		else if ($valid == 2)
		{
			$hors_l = $count;
		}
		else if ($valid == 3)
		{
			$avalid = $count;
		}
	}
	if (empty($en_l)) { $en_l = 0; }
	if (empty($hors_l)) { $hors_l = 0; }
	if (empty($avalid)) { $avalid = 0; }
	echo '<div align="center">'.adm_ag_trad('En Ligne').'&nbsp;:&nbsp;'.$en_l.'&nbsp;|&nbsp;'
	.''.adm_ag_trad('Hors Ligne').'&nbsp;:&nbsp;'.$hors_l.'&nbsp;|&nbsp;'
	.''.adm_ag_trad('A Valider').'&nbsp;:&nbsp;<span class="text_rouge">'.$avalid.'</span></div>'
	.'</div>';
}
/// FIN MENU PRINCIPAL ///
/// DEBUT INDEX ///
function adminagenda()
{
	global $NPDS_prefix, $ModPath;
	global $ThisFile, $page, $order;
	/*Debut securite*/
	settype($page,"integer");
	settype($order,"integer");
	/*Fin securite*/
	include('modules/'.$ModPath.'/admin/config.php');
	require_once('modules/'.$ModPath.'/ag_fonc.php');
	require_once('modules/'.$ModPath.'/pag_fonc.php');
	menuprincipal();
	/*Total pour la naviguation*/
	$nb_entrees = sql_num_rows(sql_query("SELECT * FROM ".$NPDS_Prefix."agend_dem"));
	/*Pour la naviguation*/
	$total_pages = ceil($nb_entrees/$nb_admin);
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
	$start = ($page_courante * $nb_admin - $nb_admin);
	/*Ordre par defaut*/
	if($order == '0'){$order1 = "valid = 3";}else if($order == '4'){$order1 = 'id';}else{$order1 = "valid = $order";}

	echo '<div class="cadre_admin">'
	.'<div class="sous_titre_module" align="center">'.adm_ag_trad('Liste des &eacute;v&egrave;nements').'</div><br />'
	.'<div align="left">'.adm_ag_trad('Trier par').'&nbsp;'
	.'<a href="'.$ThisFile.'&amp;order=1"><font color="#009900">'.adm_ag_trad('En Ligne').'</font></a>&nbsp;-&nbsp;'
	.'<a href="'.$ThisFile.'&amp;order=2"><font color="#FF0000">'.adm_ag_trad('Hors Ligne').'</font></a>&nbsp;-&nbsp;'
	.'<a href="'.$ThisFile.'&amp;order=3"><font color="#0000FF">'.adm_ag_trad('A valider').'</font></a>&nbsp;-&nbsp;'
	.'<a href="'.$ThisFile.'&amp;order=4">'.adm_ag_trad('ID').'</a></div><br />'
	.'<table border="0" width="98%" cellpadding="2" cellspacing="5" align="center">'
	.'<tr class="sous_titre_module" align="center">'
	.'<td width="5%">'.adm_ag_trad('ID').'</td>'
	.'<td width="25%">'.adm_ag_trad('Titre').'</td>'
	.'<td width="20%">'.adm_ag_trad('Sujet').'</td>'
	.'<td width="10%">'.adm_ag_trad('Groupe').'</td>'
	.'<td width="15%">'.adm_ag_trad('Auteur').'</td>'
	.'<td width="10%">'.adm_ag_trad('Statut').'</td>'
	.'<td width="15%">'.adm_ag_trad('Fonctions').'</td>'
	.'</tr>';
	/*Requete liste evenements avec pagination*/
	$result = sql_query("SELECT id, titre, topicid, posteur, groupvoir, valid FROM ".$NPDS_Prefix."agend_dem ORDER BY $order1 DESC, titre ASC LIMIT $start,$nb_admin");
	while(list($id, $titre, $topicid, $posteur, $groupvoir, $valid) = sql_fetch_row($result))
	{
		$titre = stripslashes(aff_langue($titre));
		echo '<tr class="titre_admin">'
		.'<td align="center">'.$id.'</td>'
		.'<td align="left">&nbsp;&nbsp;'.$titre.'</td>';
		$toplist = sql_query("SELECT topictext FROM ".$NPDS_Prefix."agendsujet WHERE topicid = $topicid");
		while(list($topictext) = sql_fetch_row($toplist))
		{
			$topictext = stripslashes(aff_langue($topictext));
			echo '<td>&nbsp;&nbsp;'.$topictext.'</td>';
		}
		echo '<td align="center">'.$groupvoir.'</td>'
		.'<td align="left"><a href="replypmsg.php?send='.$posteur.'">&nbsp;&nbsp;'.$posteur.'</a></td>'
		.'<td align="center">';
		if ($valid == 1)
		{
			echo '<font color="#009900">'.adm_ag_trad('En Ligne').'</font>';
		}
		else if ($valid == 2)
		{
			echo '<font color="#FF0000">'.adm_ag_trad('Hors Ligne').'</font>';
		}
		else if ($valid == 3)
		{
			echo '<font color="#0000FF">'.adm_ag_trad('A valider').'</font>';
		}
			
		echo '</td>'
		.'<td align="center" class="text_rouge">[&nbsp;<a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'" class="text_rouge">'.adm_ag_trad('Editer').'</a>&nbsp;|&nbsp;<a href="'.$ThisFile.'&amp;subop=deleteevt&amp;id='.$id.'" class="text_rouge">'.adm_ag_trad('Supprimer').'</a>&nbsp;]</td>'
		.'</tr>';
	}
	echo '</table><br />';
	/*Affiche pagination*/
	echo ag_pag($total_pages,$page_courante,'2',''.$ThisFile.'&amp;subop=adminagenda&amp;order='.$order.'','_admin');
	echo '</div>';
}
/// FIN INDEX ///
/// DEBUT EDITER ///
function editevt($id, $month, $an, $debut)
{
	global $NPDS_Prefix, $ModPath;
	global $ThisFile, $tabMois;
	/*Debut securite*/
	settype($id,"integer");
	settype($month,"integer");
	settype($an,"integer");
	$debut = removeHack($debut);
	/*Fin securite*/
	menuprincipal();
	include('modules/'.$ModPath.'/admin/config.php');
	require_once('modules/'.$ModPath.'/ag_fonc.php');
	
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
	echo '<div class="cadre_admin">'
	.'<div class="sous_titre_module" align="center">'.adm_ag_trad('Editer un &eacute;v&egrave;nement').'</div><br />'
	.'<div<img src="modules/'.$ModPath.'/images/fle.gif" border="0" />&nbsp;&nbsp;<a href="'.$ThisFile.'&amp;subop=deleteevt&amp;id='.$id.'" class="text_rouge">'.adm_ag_trad('Supprimer cette &eacute;v&egrave;nement').'</a></div><br />';
	/*Requete affiche evenement suivant $id*/
	$result = sql_query("SELECT titre, intro, descript, lieu, topicid, posteur, groupvoir, valid FROM ".$NPDS_Prefix."agend_dem WHERE id = $id");
	list($titre, $intro, $descript, $lieu, $topicid, $posteur, $groupvoir, $valid) = sql_fetch_row($result);
	$titre = stripslashes($titre);
	$intro = stripslashes($intro);
	$descript = stripslashes($descript);
	$lieu = stripslashes($lieu);
	echo '<form name="adminForm" action="'.$ThisFile.'" method="post">'
	.'<table border="0" width="98%" cellspacing="5" cellpadding="2" align="center">'
	.'<tr align="center" class="sous_titre_module">'
	.'<td colspan="3"><input type="hidden" name="debut" value="'.$debut.'" />'.adm_ag_trad('Jours s&eacute;l&eacute;ctionn&eacute;s').'&nbsp;:&nbsp;';
	$name = explode(",",$debut);
	for ($i = 0; $i < sizeof($name); $i++ )
	{
		echo ''.formatfrancais($name[$i]).'&nbsp;<a href="'.$ThisFile.'&amp;subop=retire&amp;ladate='.$name[$i].'&amp;debut='.$debut.'&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'" class="text_rouge">X</a>&nbsp;-&nbsp;';
	}
	echo '</td>'
	.'</tr>'
	.'<tr>'
	.'<td width="10%" class="sous_titre_module">&nbsp;'.adm_ag_trad('post&eacute; par').'</td>'
	.'<td width="60%" class="titre_admin">'.$posteur.'</td>'
	.'<td width="30%" rowspan="4" valign="top" class="titre_admin">';
	cal($id, $month, $an, $debut);
	echo '</td>'
	.'</tr>'
	.'<tr>'
	.'<td class="sous_titre_module">&nbsp;'.adm_ag_trad('Statut').'</td>';
	if($valid == 1)
	{
		$onligne = "selected=\"selected\"";
	}
	else if($valid == 2)
	{
		$offligne = "selected=\"selected\"";
	}
	echo '<td class="titre_admin">'
	.'<select name="statut" size="1">'
	.'<option value="1" '.$onligne.'>'.adm_ag_trad('En Ligne').'</option>'
	.'<option value="2" '.$offligne.'>'.adm_ag_trad('Hors Ligne').'</option>'
	.'</select>'
	.'</td>'
	.'</tr>'
	.'<tr>'
	.'<td class="sous_titre_module">&nbsp;'.adm_ag_trad('Sujet').'</td>'
	.'<td class="titre_admin">'
	.'<select name="sujet" value="'.$topicid.'">';
	/*Requete liste sujet*/
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
	.'</tr>'
	.'<tr>'
	.'<td class="sous_titre_module">&nbsp;'.adm_ag_trad('Groupe').'</td>'
	.'<td class="titre_admin"><input type="text" name="groupvoir" value="'.$groupvoir.'" size="3" /></td>'
	.'</tr>'
	.'<tr>'
	.'<td class="sous_titre_module">&nbsp;'.adm_ag_trad('Titre').'</td>'
	.'<td colspan="3" class="titre_admin"><textarea class="textarea" cols="80" rows="2" name="titre">'.$titre.'</textarea></td>'
	.'</tr>'
	.'<tr>'
	.'<td class="sous_titre_module">&nbsp;'.adm_ag_trad('Pr&eacute;sentation').'</td>'
	.'<td colspan="3" class="titre_admin"><textarea class="textbox" cols="80" rows="4" name="intro">'.$intro.'</textarea></td>'
	.'</tr>'
	.'<tr>'
	.'<td colspan="3" align="center" class="sous_titre_module">'.adm_ag_trad('Description').'</td>'
	.'</tr>'
	.'<tr>'
	.'<td colspan="3" class="titre_admin"><textarea class="textarea" name="descript" cols="50" rows="20" style="width: 90%;">'.$descript.'</textarea>';
	echo aff_editeur("descript","false");
	echo '</td>'
	.'</tr>'
	.'<tr>'
	.'<td class="sous_titre_module">&nbsp;'.adm_ag_trad('Lieu').'</td>'
	.'<td colspan="3" class="titre_admin">';
	if ($bouton == '1')
	{
		echo '<input maxLength=50 name="lieu" size=50 value="'.$lieu.'" />';
	}
	else
	{
		include('modules/'.$ModPath.'/recherche/'.$bouton.'.php');
		echo '<select name="lieu">'
		.'<option></option>';
		foreach($try as $na)
		{
   		if($lieu == $na){$af = ' selected';}else{$af = '';}
			echo '<option value="'.$na.'" '.$af.'>'.$na.'</option>';
		}
		echo '</select>';
	}
	echo '</td>'
	.'</tr>'
	.'<tr class="sous_titre_module">'
	.'<input type="hidden" name="id" value="'.$id.'" />'
	.'<input type="hidden" name="subop" value="saveevt" />'
	.'<td align="center" colspan="3"><input type="submit" class="adm_bouton" value="'.adm_ag_trad('Sauver les modifications').'" /></td>'
	.'</tr>'
	.'</table>'
	.'</form>'
	.'</div>';

}
/// FIN EDITER ///
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
		''.adm_ag_trad('Janvier').'',
		''.adm_ag_trad('F&eacute;vrier').'',
		''.adm_ag_trad('Mars').'',
		''.adm_ag_trad('Avril').'',
		''.adm_ag_trad('Mai').'',
		''.adm_ag_trad('Juin').'',
		''.adm_ag_trad('Juillet').'',
		''.adm_ag_trad('Ao&ucirc;t').'',
		''.adm_ag_trad('Septembre').'',
		''.adm_ag_trad('Octobre').'',
		''.adm_ag_trad('Novembre').'',
		''.adm_ag_trad('D&eacute;cembre').'');
	$mois_en_clair = $mois_de_annee[$month - 1];
	/*Creation tableau a 31 entree sans reservation*/
	for($j = 1; $j < 32; $j++)
	{
		$tab_jours[$j] = (bool)false;
	}
	echo '<table border="0" cellspacing="2" cellpadding="3" align="center">'
	.'<tr>'
	.'<td colspan="8" class="ag_une">'
	.'<a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$mois_prec.'&amp;an='.$an_prec.'&amp;debut='.$debut.'" class="ag_lidate">&lt;&lt;</a>'
	.'&nbsp;&nbsp;'.$mois_en_clair.'&nbsp;'.$an.'&nbsp;&nbsp;'
	.'<a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$mois_suivant.'&amp;an='.$an_suivant.'&amp;debut='.$debut.'" class="ag_lidate">&gt;&gt;</a>'
	.'</td>'
	.'</tr>'
	.'<tr align="center">'
	.'<td width="20px" class="ag_jours">'.adm_ag_trad('Sem').'</td>'
	.'<td width="10px" class="ag_jours">'.adm_ag_trad('L').'</td>'
	.'<td width="10px" class="ag_jours">'.adm_ag_trad('M').'</td>'
	.'<td width="10px" class="ag_jours">'.adm_ag_trad('M ').'</td>'
	.'<td width="10px" class="ag_jours">'.adm_ag_trad('J').'</td>'
	.'<td width="10px" class="ag_jours">'.adm_ag_trad('V').'</td>'
	.'<td width="10px" class="ag_jours">'.adm_ag_trad('S').'</td>'
	.'<td width="10px" class="ag_jours">'.adm_ag_trad('D').'</td>'
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
/// DEBUT SAUVER EDITER ///
function saveevt($debut, $statut, $sujet, $groupvoir, $titre, $intro, $descript, $lieu, $id)
{
	global $ModPath, $NPDS_Prefix;
	global $ThisFile;
	/*Debut securite*/
	settype($statut,"integer");
	settype($sujet,"integer");
	settype($groupvoir,"integer");
	settype($id,"integer");
	$titre = removeHack(addslashes($titre));
	$intro = removeHack(addslashes($intro));
	$lieu = removeHack(addslashes($lieu));
	$debut = removeHack($debut);
	$descript = removeHack($descript);
	/*Fin securite*/
	menuprincipal();
	$result = sql_query("UPDATE ".$NPDS_Prefix."agend_dem SET titre = '$titre', intro = '$intro', descript = '$descript', lieu = '$lieu', topicid = '$sujet', groupvoir = '$groupvoir', valid = '$statut' WHERE id = $id");
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
		echo '<div class="cadre_admin" align="center"><span class="text_rouge">'.adm_ag_trad('Cet &eacute;v&egrave;nement est mis &agrave; jour.').'</span><br /><br />[&nbsp;<a href="'.$ThisFile.'">'.adm_ag_trad('Retour').'</a>&nbsp;]</div>';
	}
	else
	{
		echo ''.sql_error().'<br />';
		return;
	}
}
/// FIN SAUVER EDITER ///
/// DEBUT ENLEVER JOUR ///
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
/// FIN ENLEVER JOUR ///
/// DEBUT SUPPRIMER ///
function deleteevt($id, $ok=0)
{
	global $NPDS_Prefix;
	global $ThisFile;
	/*Debut securite*/
	settype($liaison,"integer");
	settype($ok,"integer");
	/*Fin securite*/
	menuprincipal();
	if ($ok)
	{
		$result = "DELETE FROM ".$NPDS_Prefix."agend WHERE liaison = $id";
		$succes = sql_query($result) or die ("erreur : ".sql_error());
		$result1 = "DELETE FROM ".$NPDS_Prefix."agend_dem WHERE id = $id";
		$succes1 = sql_query($result1) or die ("erreur : ".sql_error());
		echo '<div class="cadre_admin" align="center"><span class="text_rouge">'.adm_ag_trad('Cet &eacute;v&egrave;nement est maintenant effac&eacute;.').'</span><br /><br />[&nbsp;<a href="'.$ThisFile.'">'.adm_ag_trad('Retour').'</a>&nbsp;]';
	}
	else
	{
		echo '<div class="cadre_admin" align="center"><span class="text_rouge">'.adm_ag_trad('Etes-vous s&ucirc;r de vouloir supprimer cet &eacute;v&egrave;nement ?').'</span><br /><br />'
		.'[&nbsp;<a href="'.$ThisFile.'">'.adm_ag_trad('NON - Index').'</a>&nbsp;|&nbsp;'
		.'<a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'">'.adm_ag_trad('NON - Fiche').'</a>&nbsp;|&nbsp;'
		.'<a href="'.$ThisFile.'&amp;subop=deleteevt&amp;id='.$id.'&amp;ok=1">'.adm_ag_trad('OUI').'</a>&nbsp;]</div>';
	}
}
/// FIN SUPPRIMER ///
///////////////////////////
/// DEBUT GESTION SUJET ///
///////////////////////////
function topicsmanager()
{
	global $NPDS_Prefix, $tipath;
	global $ThisFile;
	menuprincipal();
	echo '<div class="cadre_admin">';
	/*Requete liste sujet*/
	$result = sql_query("SELECT * FROM ".$NPDS_Prefix."agendsujet ORDER BY topictext");
	if (sql_num_rows($result) > 0)
	{
		echo '<div align="center" class="sous_titre_module">'.adm_ag_trad('Sujet s&eacute;lectionn&eacute; - Cliquez pour modifier').'</div><br />'
		.'<table border="0" width="100%" align="center" cellpadding="2" class="titre_admin">'
		.'<tr>';
		while(list($topicid, $topicimage, $topictext) = sql_fetch_row($result))
		{
			$topictext = stripslashes($topictext);
			echo '<td align="center">';
			if (($topicimage) or ($topicimage != ""))
			{
				echo '<a href="'.$ThisFile.'&amp;subop=topicedit&amp;topicid='.$topicid.'"><img src="'.$tipath.''.$topicimage.'" border="0" /></a><br />'.aff_langue(''.$topictext.'').'';
			}
			else
			{
				echo '<a href="'.$ThisFile.'&amp;subop=topicedit&amp;topicid='.$topicid.'">'.aff_langue(''.$topictext.'').'</a><br />';
			}
			echo '</td>';
			$count++;
			if ($count == 3)
			{
				echo '</tr>';
				$count = 0;
			}
		}
		echo '</tr>'
		.'</table><br />';
	}
	echo '<div class="sous_titre_module" align="center">'.adm_ag_trad('Ajouter un sujet').'</div><br />'
	.'<table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="titre_admin">'
	.'<form action="'.$ThisFile.'" method="post" name="adminForm">'
	.'<tr>'
	.'<td align="center">'
	.''.adm_ag_trad('Titre du sujet').'<br />'
	.'<input class="textarea" type="text" name="topictext" size="40" /><br /><br />'
	.''.adm_ag_trad('Image du sujet').'&nbsp;"'.$tipath.'"<br />';
	imgcate($topicimage);
	echo '<br /><br />'
	.'<input type="hidden" name="subop" value="topicmake" />'
	.'<input type="submit" class="adm_bouton" value="'.adm_ag_trad('Ajouter un sujet').'" /><br /><br />'
	.'</td>'
	.'</tr>'
	.'</form>'
	.'</table>'
	.'</div>';
}
function imgcate($topicimage)
{
	global $ModPath;
	/*Ouvre le repertoire*/
	$imgrep = 'modules/'.$ModPath.'/images/categories';
	$dp = opendir($imgrep);
	while ( $file = readdir($dp) )
	{
		/*Enleve les fichiers . et ..*/
		if ($file != '.' && $file != '..' && $file != 'index.html')
		{
			/*On passe les datas dans un tableau*/
			$ListFiles[$i] = $file;
			$i++;
		}
	}
	closedir($dp);
	/*Tri par ordre decroissant*/
	if(count($ListFiles) != 0)
	{
		if($list_tri == 'DESC')
		{
			rsort($ListFiles);
		}
		else
		{
			sort($ListFiles);
		}
	}
	if ($topicimage != ''){ $val = 'value="'.$topicimage.'';}else{}
	echo '<select name="topicimage" '.$val.'">';
	$nb = count($ListFiles);
	for($i = 0;$i < $nb;$i++)
	{
		echo '<option value=\''.$ListFiles[$i].'\'';
		if($ListFiles[$i] == $topicimage)
		echo ' selected=\'selected\'';
		echo '>'.$ListFiles[$i].'</option>';
	}
	echo '</select>';
}
function topicmake($topicimage, $topictext)
{
	global $NPDS_Prefix;
	global $ThisFile;
	/*Debut securite*/
	$topictext = removeHack(addslashes($topictext));
	$topicimage = removeHack($topicimage);
	/*Fin securite*/
	menuprincipal();
	if ($topictext == '')
	{
		echo '<div class="cadre_admin" align="center"><span class="text_rouge">'.adm_ag_trad('Pas de sujet.').'</span><br /><br />[&nbsp;<a href="'.$ThisFile.'&amp;subop=topicsmanager">'.adm_ag_trad('Retour').'</a>&nbsp;]</div>';
	}
	else
	{
		sql_query("INSERT INTO ".$NPDS_Prefix."agendsujet VALUES (NULL, '$topicimage', '$topictext')");
		echo '<div class="cadre_admin" align="center"><span class="text_rouge">'.adm_ag_trad('Le sujet est cr&eacute;&eacute;.').'</span><br /><br />[&nbsp;<a href="'.$ThisFile.'&amp;subop=topicsmanager">'.adm_ag_trad('Retour &agrave; la page d\'&eacute;dition des Sujets').'</a>&nbsp;]</div>';
	}
}
function topicedit($topicid)
{
	global $NPDS_Prefix;
	global $tipath, $ThisFile;
	/*Debut securite*/
	settype($topicid,"integer");
	/*Fin securite*/
	menuprincipal();
	/*Requete affiche sujet suivant $topicid*/
	$result = sql_query("SELECT * FROM ".$NPDS_Prefix."agendsujet WHERE topicid = $topicid");
	list($topicid, $topicimage, $topictext) = sql_fetch_row($result);
	$topictext = stripslashes($topictext);
	echo '<div class="cadre_admin">'
	.'<div class="sous_titre_module" align="center">'.adm_ag_trad('Modifier un sujet').'&nbsp;'.aff_langue(''.$topictext.'').'</div><br />'
	.'<div valign="center" align="center" class="titre_admin"><img src="'.$tipath.''.$topicimage.'" border="0" />'
	.'<br /><br />'
	.'<form action="'.$ThisFile.'" method="post" name="adminForm"><br />'
	.''.adm_ag_trad('Titre du sujet').'<br />'
	.'<input class="textarea" type="text" name="topictext" size="40" value="'.$topictext.'" /><br /><br />'
	.''.adm_ag_trad('Image du sujet').'&nbsp;"'.$tipath.'"<br />';
	imgcate($topicimage);
	echo '<br /><br />'
	.'<input type="hidden" name="topicid" value="'.$topicid.'" />'
	.'<input type="hidden" name="subop" value="topicchange" />'
	.'<input type="submit" class="adm_bouton" value="'.adm_ag_trad('Sauver les modifications').'" />'
	.'</form>'
	.'<form action="'.$ThisFile.'" method="post" name="adminForm"><br />'
	.'<input type="hidden" name="topicid" value="'.$topicid.'" />'
	.'<input type="hidden" name="subop" value="topicdelete" />'
	.'<input type="submit" class="adm_bouton" value="'.adm_ag_trad('Supprimer le sujet !').'" />'
	.'</form><br />'
	.'</div><br />'
	.'<div align="center" class="sous_titre_module">[ <a href="'.$ThisFile.'&amp;subop=topicsmanager">'.adm_ag_trad('Retour &agrave; la page d\'&eacute;dition des Sujets').'</a> ]</div>'
	.'</div>';
}
function topicchange($topictext, $topicimage, $topicid)
{
	global $NPDS_Prefix;
	global $ThisFile;	
	/*Debut securite*/
	settype($topicid,"integer");
	$topictext = removeHack(addslashes($topictext));
	/*Fin securite*/
	menuprincipal();
	
	if ($topictext =='')
	{
		echo '<div class="cadre_admin" align="center"><span class="text_rouge">'.adm_ag_trad('Pas de sujet.').'</span><br /><br />[&nbsp;<a href="'.$ThisFile.'&amp;subop=topicedit&topicid='.$topicid.'">'.adm_ag_trad('Retour').'</a>&nbsp;]</div>';
	}
	else
	{
		sql_query("UPDATE ".$NPDS_Prefix."agendsujet SET topicimage = '$topicimage', topictext = '$topictext' WHERE topicid = $topicid");
		echo '<div class="cadre_admin" align="center"><span class="text_rouge">'.adm_ag_trad('Le sujet est mis &agrave; jour.').'</span><br /><br />[&nbsp;<a href="'.$ThisFile.'&amp;subop=topicsmanager">'.adm_ag_trad('Retour &agrave; la page d\'&eacute;dition des Sujets').'</a>&nbsp;]</div>'
		.'</div>';
	}
}
function topicdelete($topicid, $ok=0)
{
	global $NPDS_Prefix, $tipath;
	global $ThisFile;
	/*Debut securite*/
	settype($topicid,"integer");
	settype($ok,"integer");
	/*Fin securite*/
	menuprincipal();
	if ($ok == 1)
	{
		$result = "DELETE FROM ".$NPDS_Prefix."agendsujet WHERE topicid = '$topicid'";
		$succes = sql_query($result) or die ("erreur : ".sql_error());
		echo '<div class="cadre_admin" align="center"><span class="text_rouge">'.adm_ag_trad('Le sujet est effac&eacute;.').'</span><br /><br />[&nbsp;<a href="'.$ThisFile.'&amp;subop=topicsmanager">'.adm_ag_trad('Retour &agrave; la page d\'&eacute;dition des Sujets').'</a>&nbsp;]</div>';
	}
	else
	{
		$result2 = sql_query("SELECT topicimage, topictext FROM ".$NPDS_Prefix."agendsujet WHERE topicid = '$topicid'");
		list($topicimage, $topictext) = sql_fetch_row($result2);
		$topictext = stripslashes($topictext);
		echo '<div class="cadre_admin" align="center"><img src="'.$tipath.''.$topicimage.'" border="0" /><br /><br />'
		.'<span class="text_rouge">'.adm_ag_trad('Supprimer le sujet').'&nbsp;'.aff_langue(''.$topictext.'').'<br /><br />'
		.''.adm_ag_trad('Etes-vous s&ucirc;r de vouloir supprimer le sujet :').'&nbsp;'.aff_langue(''.$topictext.'').'</span><br /><br />'
		.'[&nbsp;<a href="'.$ThisFile.'&amp;subop=topicsmanager">'.adm_ag_trad('NON').'</a>&nbsp;|&nbsp;<a href="'.$ThisFile.'&amp;subop=topicdelete&amp;topicid='.$topicid.'&amp;ok=1">'.adm_ag_trad('OUI').'</a>&nbsp;]</div>';
	}
}
/////////////////////////
/// FIN GESTION SUJET ///
/////////////////////////
//////////////////////////
///DEBUT CONFIGURATION ///
//////////////////////////
/// DEBUT CONFIGURATION ///
function configuration()
{
	global $ModPath;
	global $ThisFile;
	menuprincipal();	
	include('modules/'.$ModPath.'/admin/config.php');
	include('modules/'.$ModPath.'/cache.timings.php');
	/*Ouvre le repertoire*/
	$imgrep = 'modules/'.$ModPath.'/recherche';
	$dp = opendir($imgrep);
	while ( $file = readdir($dp) )
	{
		/*Enleve les fichiers . et ..*/
		if ($file != '.' && $file != '..' && $file != 'index.html' && $file != 'message-english.php' && $file != 'message-french.php')
		{
			/*On passe les datas dans un tableau*/
			$ListFiles[$i] = $file;
			$i++;
		}
	}
	closedir($dp);
	/*Tri par ordre decroissant*/
	if(count($ListFiles) != 0)
	{
		if($list_tri == 'DESC')
		{
			rsort($ListFiles);
		}
		else
		{
			sort($ListFiles);
		}
	}
	if ($bouton == '1')
	{
		$def = '<input type="radio" name="xbouton" value="1" checked />';
		$def1 = '<input type="radio" name="xbouton" value="2" />&nbsp;&nbsp;'
		.'<select name="xbouton1">'
		.'<option></option>';
		$nb = count($ListFiles);
		for($i = 0;$i < $nb;$i++)
		{
			$name = ''.substr($ListFiles[$i], 0, -4).'';
			$def1 .= '<option value="'.$name.'">'.$name.'</option>';
		}
		$def1 .= '</select>';
	}
	else
	{
		$def = '<input type="radio" name="xbouton" value="1" />';		
		$def1 .= '<input type="radio" name="xbouton" value="2" checked />&nbsp;&nbsp;'
		.'<select name="xbouton1">'
		.'<option></option>';
		$nb = count($ListFiles);
		for($i = 0;$i < $nb;$i++)
		{
			$name = ''.substr($ListFiles[$i], 0, -4).'';
			if ($bouton == $name){$stat = ' selected';}else{$stat = '';}
			$def1 .= '<option value="'.$name.'"'.$stat.'>'.$name.'</option>';
		}
		$def1 .= '</select>';
	}
	echo '<div class="cadre_admin">'
	.'<div class="titre_admin" align="center">'.adm_ag_trad('Pr&eacute;f&eacute;rences de l\'Agenda').'</div><br />'
	.'<table width="98%" align="center" cellpadding="2" cellspacing="5" border="0">'
	.'<form action="'.$ThisFile.'" method="post" name="adminForm">'
	.'<tr>'
	.'<td colspan="2" class="sous_titre_module" align="center">'.adm_ag_trad('Ajout + Groupe').'</td>'
	.'</tr>'
	.'<tr class="titre_admin">'
	.'<td>'.adm_ag_trad('Ajout d\'&eacute;v&eacute;nement : 1 Tous les membres - ou groupe').'</td>'
	.'<td><input type="text" name="xgro" size="3" value="'.$gro.'" /></td>'
	.'</tr>'
	.'<tr class="titre_admin">'
	.'<td>'.adm_ag_trad('Validation par l\'admin').'</td>';
	if($valid == 1)
	{
		$onligne = "selected=\"selected\"";
	}
	if($valid == 3)
	{
		$avalider = "selected=\"selected\"";
	}
	echo '<td>'
	.'<select name="xvalid" size="1">'
	.'<option value="3" '.$avalider.'>'.adm_ag_trad('Oui').'</option>'
	.'<option value="1" '.$onlignee.'>'.adm_ag_trad('Non').'</option>'
	.'</select>'
	.'</td>'
	.'</tr>'
	.'<tr class="titre_admin">'
	.'<td>'.adm_ag_trad('Etre averti par mail d\'un nouvel evenement').'</td>';
	if($courriel == 1)
	{
		$oui = "selected=\"selected\"";
	}
	if($courriel == 0)
	{
		$non = "selected=\"selected\"";
	}
	echo '<td>'
	.'<select name="xcourriel" size="1">'
	.'<option value="1" '.$oui.'>'.adm_ag_trad('Oui').'</option>'
	.'<option value="0" '.$non.'>'.adm_ag_trad('Non').'</option>'
	.'</select>'
	.'</td>'
	.'</tr>'
	.'<tr class="titre_admin">'
	.'<td>'.adm_ag_trad('Mail du receveur').'</td>'
	.'<td><input type="text" name="xreceveur" size="30" value="'.$receveur.'" /></td>'
	.'</tr>'
	.'<tr class="titre_admin">'
	.'<td>'.adm_ag_trad('Validation apr&egrave;s modification').'</td>';
	if($revalid == 1)
	{
		$reonligne = "selected=\"selected\"";
	}
	if($revalid == 3)
	{
		$reavalider = "selected=\"selected\"";
	}
	echo '<td>'
	.'<select name="xrevalid" size="1">'
	.'<option value="3" '.$reavalider.'>'.adm_ag_trad('Oui').'</option>'
	.'<option value="1" '.$reonligne.'>'.adm_ag_trad('Non').'</option>'
	.'</select>'
	.'</td>'
	.'</tr>'
	.'<tr>'
	.'<td colspan="2" class="sous_titre_module" align="center">'.adm_ag_trad('Pagination').'</td>'
	.'</tr>'
	.'<tr class="titre_admin">'
	.'<td>'.adm_ag_trad('Nbre d\'&eacute;v&egrave;nements dans la partie admin (pagination)').'</td>'
	.'<td><input type="text" name="xnb_admin" size="3" value="'.$nb_admin.'" /></td>'
	.'</tr>'
	.'<tr class="titre_admin">'
	.'<td>'.adm_ag_trad('Nbre d\'&eacute;v&egrave;nements dans la partie module (pagination)').'</td>'
	.'<td><input type="text" name="xnb_news" size="3" value="'.$nb_news.'" /></td>'
	.'</tr>'
	.'<tr>'
	.'<td colspan="2" class="sous_titre_module" align="center">'.adm_ag_trad('Recherche').'</td>'
	.'</tr>'
	.'<tr class="titre_admin">'
	.'<td>'.adm_ag_trad('D&eacute;faut (par ville)').'</td>'
	.'<td>'.$def.'</td>'
	.'</tr>';
	echo '<tr class="titre_admin">'
	.'<td>'.adm_ag_trad('Fichier perso (doit se trouver dans le dossier recherche)').'</td>'
	.'<td>'.$def1.'</td>'
	.'</tr>'
	.'<tr>'
	.'<td colspan="2" class="sous_titre_module" align="center">'.adm_ag_trad('Supercache').'</td>'
	.'</tr>'
	.'<tr class="titre_admin">'
	.'<td>'.adm_ag_trad('Temps du cache (en secondes)').'</td>'
	.'<td><input type="text" name="xtps" size="10" value="'.$CACHE_TIMINGS['modules.php'].'" /></td>'
	.'</tr>'
	.'<tr class="sous_titre_module">'
	.'<td colspan="2" align="center">'
	.'<input type="hidden" name="subop" value="ConfigSave" />'
	.'<input class="adm_bouton" type=submit value="'.adm_ag_trad('Sauver les changements').'" />'
	.'</td>'
	.'</tr>'
	.'</form>'
	.'</table>'
	.'</div>';
}
/// FIN CONFIGURATION ///
/// DEBUT SAUVER CONFIGURATION ///
function ConfigSave($xgro, $xvalid, $xcourriel, $xreceveur, $xrevalid, $xnb_admin, $xnb_news, $xbouton, $xbouton1, $xtps)
{
	global $ModPath;
	/*Debut securite*/
	settype($xgro,"integer");
	settype($xvalid,"integer");
	settype($xcourriel,"integer");
	settype($xrevalid,"integer");
	settype($xnb_admin,"integer");
	settype($xnb_news,"integer");
	settype($xbouton,"integer");
	settype($xtps,"integer");
	$xreceveur = removeHack($xreceveur);
	$xbouton = removeHack($xbouton);
	/*Fin securite*/
	if($xbouton == '1'){$fich = '1';}else{$fich = ''.$xbouton1.'';}
	if ($xgro == '0')
	{
		$xgro = '1';
	}
	menuprincipal();
	$file = fopen('modules/'.$ModPath.'/admin/config.php', 'w');
	$content = "<?php\n";
	$content .= "/*******************************************************/\n";
	$content .= "/* NPDS : Net Portal Dynamic System                    */\n";
	$content .= "/* ==========================                          */\n";
	$content .= "/* Fichier : modules/agenda/admin/config.php           */\n";
	$content .= "/*                                                     */\n";
	$content .= "/* Module Agenda                                       */\n";
	$content .= "/* Version 1.0                                         */\n";
	$content .= "/* Auteur Oim                                          */\n";
	$content .= "/*******************************************************/\n";
	$content .= "\n";
	$content .= "\$gro   = \"$xgro\";\n";
	$content .= "\$valid   = \"$xvalid\";\n";
	$content .= "\$courriel   = \"$xcourriel\";\n";
	$content .= "\$revalid   = \"$xrevalid\";\n";
	$content .= "\$receveur   = \"$xreceveur\";\n";
	$content .= "\$nb_admin   = \"$xnb_admin\";\n";
	$content .= "\$nb_news   = \"$xnb_news\";\n";
	$content .= "\$bouton   = \"$fich\";\n";
	$content .= "\n";
	$content .= "?>";
	fwrite($file, $content);
	fclose($file);
	if($xtps)
	{
		$file = fopen('modules/'.$ModPath.'/cache.timings.php', 'w');
		$content = "<?php\n";
		$content .= "/*******************************************************/\n";
		$content .= "/* NPDS : Net Portal Dynamic System                    */\n";
		$content .= "/* ==========================                          */\n";
		$content .= "/* Fichier : modules/agenda/cache.timings.php          */\n";
		$content .= "/*                                                     */\n";
		$content .= "/* Module Agenda                                       */\n";
		$content .= "/* Version 1.0                                         */\n";
		$content .= "/* Auteur Oim                                          */\n";
		$content .= "/*******************************************************/\n";
		$content .= "\n";
		$content .= "\$CACHE_TIMINGS['modules.php']   = $xtps;\n";
		$content .= "\$CACHE_QUERYS['modules.php']   = \"^ModPath=$ModPath&ModStart=calendrier\";\n";
		$content .= "\$CACHE_QUERYS['modules.php']   = \"^ModPath=$ModPath&ModStart=annee\";\n";
		$content .= "\$CACHE_QUERYS['modules.php']   = \"^ModPath=$ModPath&ModStart=lieu\";\n";
		$content .= "\n";
		$content .= "?>";
		fwrite($file, $content);
		fclose($file);
	}	
	echo '<div class="cadre_admin" align="center"><span class="text_rouge">'.adm_ag_trad('Les pr&eacute;f&eacute;rences pour l\'Agenda sont enregistr&eacute;es.').'</span></div>';
}
/// FIN SAUVER CONFIGURATION ///
/////////////////////////
/// FIN CONFIGURATION ///
/////////////////////////

	if (file_exists('modules/'.$ModPath.'/admin/pages.php'))
	{
		include ('modules/'.$ModPath.'/admin/pages.php');
	}
	if ($admin)
	{
		/*Parametres utilises par le script*/
		$ThisFile = 'admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart='.$ModStart.'';
		$ThisRedo = 'admin.php?op=Extend-Admin-SubModule&ModPath='.$ModPath.'&ModStart='.$ModStart.'';
		$tipath = 'modules/'.$ModPath.'/images/categories/';
		if (file_exists('modules/'.$ModPath.'/admin/lang/'.$language.'.php'))
		{
			include_once('modules/'.$ModPath.'/admin/lang/'.$language.'.php');
		}
		else
		{
			include_once('modules/'.$ModPath.'/admin/lang/french.php');
		}
		$tabMois = array();
		$tabMois[1] = ''.adm_ag_trad('Janvier').'';
		$tabMois[2] = ''.adm_ag_trad('F&eacute;vrier').'';
		$tabMois[3] = ''.adm_ag_trad('Mars').'';
		$tabMois[4] = ''.adm_ag_trad('Avril').'';
		$tabMois[5] = ''.adm_ag_trad('Mai').'';
		$tabMois[6] = ''.adm_ag_trad('Juin').'';
		$tabMois[7] = ''.adm_ag_trad('Juillet').'';
		$tabMois[8] = ''.adm_ag_trad('Ao&ucirc;t').'';
		$tabMois[9] = ''.adm_ag_trad('Septembre').'';
		$tabMois[10] = ''.adm_ag_trad('Octobre').'';
		$tabMois[11] = ''.adm_ag_trad('Novembre').'';
		$tabMois[12] = ''.adm_ag_trad('D&eacute;cembre').'';
		/*css perso admin en attendant evolution page.php*/

		switch($subop)
		{
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
?>