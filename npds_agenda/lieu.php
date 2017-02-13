<?php
/********************************************/
/* NPDS : Net Portal Dynamic System         */
/* ==========================               */
/* Fichier : modules/agenda/lieu.php        */
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


/// DEBUT LISTE EVENEMENT PAR CHOIX ///
function lieu($lettre, $niv)
{
	global $ModPath, $NPDS_Prefix, $theme, $cookie;
	global $ThisFile, $nb_news, $tipath, $bouton, $page;
	require_once('modules/'.$ModPath.'/pag_fonc.php');
	/*Debut securite*/
	settype($page,"integer");
	settype($niv,"integer");
	$lettre = removeHack($lettre);
	/*Fin securite*/
	Opentable();
	suj();
	/*debut theme html partie 1/2*/
	$inclusion = false;

      $inclusion = "modules/".$ModPath."/html/lieu.html";

	/*fin theme html partie 1/2*/
	/*Recherche*/
	if ($bouton == '1')
	{
		if($lettre != ''){$cond = "AND ut.lieu LIKE '$lettre%'";$suite = ' '.ag_trad('Pour la lettre').' <span class="text-danger">'.$lettre.'</span>';}
		$rech = ''.ag_trad('Par ville').'<span class="text-danger">'.$suite.'</span>';
		$alphabet = array ("A","B","C","D","E","F","G","H","I","J","K","L","M",
		"N","O","P","Q","R","S","T","U","V","W","X","Y","Z","".ag_trad("Autre")."");
		$num = count($alphabet);
		$counter = 0;
		while (list(, $ltr) = each($alphabet))
		{
			if ($ltr != ag_trad("Autre"))
			{
				$alph .= '<a href="'.$ThisFile.'&amp;lettre='.$ltr.'">'.$ltr.'</a>';
			}
			else
			{
				$alph .= '<a href="'.$ThisFile.'&amp;lettre=!AZ">'.$ltr.'</a>';
			}
			/*Remplacer 1 pour saut de ligne*/
			if ($counter == round($num/1))
				$alph .= " ]<br />[ ";
			elseif ($counter != $num)
				$alph .= "&nbsp;|&nbsp;";
			$counter++;
		}
	}
	else
	{
		include('modules/'.$ModPath.'/recherche/'.$bouton.'.php');
		if($lettre != ''){$cond = "AND ut.lieu LIKE '$lettre%'";$suite = ' '.ag_trad('Pour').'&nbsp;<span class="text-danger">'.$lettre.'</span>';}
		$rech = ''.ag_trad('Par').'&nbsp;<span class="text-danger">'.$bouton.'</span>'.$suite.'';
		if($lettre != ''){$cond = "AND ut.lieu = '$lettre'";}
		$alph .= '<select onchange="window.location=(\''.$ThisFile.'&amp;lettre='.$na[$i].'\'+this.options[this.selectedIndex].value)">'
		.'<option></option>';
		foreach($try as $na)
		{
   		if($lettre == $na){$af = ' selected';}else{$af = '';}
			$alph .= '<option value="'.$na.'"'.$af.'>'.$na.'</option>';
		}
		$alph .= '</select>';
	}
	/*Gestion naviguation en cours ou passe*/
	$now = date('Y-m-d');
	/*Total pour naviguation*/
	$req1 = sql_query("SELECT 
			ut.groupvoir 
		FROM 
			".$NPDS_Prefix."agend us, 
			".$NPDS_Prefix."agend_dem ut 
		WHERE 
			us.liaison = ut.id 
			$cond 
			AND ut.valid = '1' 
			AND us.date >= '$now' 
		GROUP BY us.liaison");
	while(list($groupvoir) = sql_fetch_row($req1))
	{
		if(autorisation($groupvoir))
		{
			$sup++;
		}
	}
	/*Total pour naviguation*/
	$req1 = sql_query("SELECT 
			ut.groupvoir 
		FROM 
			".$NPDS_Prefix."agend us, 
			".$NPDS_Prefix."agend_dem ut 
		WHERE 
			us.liaison = ut.id 
			$cond 
			AND ut.valid = '1' 
			AND us.date < '$now' 
		GROUP BY us.liaison");
	while(list($groupvoir) = sql_fetch_row($req1))
	{
		if(autorisation($groupvoir))
		{
			$inf++;
		}
	}
	if ($sup == ''){$sup = '0';}
	if ($inf == ''){$inf = '0';}
	if($niv == '0')
	{
		$cs = 'class="rouge"';
		$nb_entrees = ''.$sup.'';
		$cond1 = "date >= '$now'";
	}
	else if($niv == '1')
	{
		$cs1 = 'class="rouge"';
		$nb_entrees = ''.$inf.'';
		$cond1 = "date < '$now'";
	}
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
	if ($sup == '0' && $inf == '0')
	{
		$affeven = '<div align="center" class="ag_deux">'.ag_trad('Vide').'</div>';
	}
	else
	{
		$affeven = '<div>'
		.'&nbsp;&nbsp;<img src="modules/'.$ModPath.'/images/fle.gif" />&nbsp;<a href="'.$ThisFile.'&amp;subop=listsuj&amp;lettre='.$lettre.'&amp;niv=0" '.$cs.'>'.ag_trad('Evènements à venir').'&nbsp;('.$sup.')</a>&nbsp;&nbsp;'
		.'<img src="modules/'.$ModPath.'/images/fle.gif" />&nbsp;<a href="'.$ThisFile.'&amp;subop=listsuj&amp;lettre='.$lettre.'&amp;niv=1" '.$cs1.'>'.ag_trad('Evènements en cours ou passés').'&nbsp;('.$inf.')</a></div><br />';
		$affeven .= '<table width="95%" border="0" cellspacing="3" cellpadding="3" align="center">';
		/*Requete liste evenement suivant $date*/
		$result = sql_query("SELECT 
				us.id, us.date, us.liaison, 
				ut.titre, ut.intro, ut.lieu, ut.topicid, ut.posteur, ut.groupvoir, 
				uv.topicimage, uv.topictext 
			FROM 
				".$NPDS_Prefix."agend us, 
				".$NPDS_Prefix."agend_dem ut, 
				".$NPDS_Prefix."agendsujet uv 
			WHERE 
				us.liaison = ut.id 
				$cond 
				AND us.$cond1 
				AND ut.valid = '1' 
				AND ut.topicid = uv.topicid 
			GROUP BY us.liaison 
			ORDER BY us.date DESC 
			LIMIT $start,$nb_news");
		while(list($id, $date, $liaison, $titre, $intro, $lieu, $topicid, $posteur, $groupvoir, $topicimage, $topictext) = sql_fetch_row($result))
		{
			$titre = stripslashes(aff_langue($titre));
			$intro = stripslashes(aff_langue($intro));
			$lieu = stripslashes(aff_langue($lieu));
			$topictext = stripslashes(aff_langue($topictext));
			/*Si membre appartient au bon groupe*/
			if(autorisation($groupvoir))
			{
				/*Si evenement plusieurs jours*/
				$result1 = sql_query("SELECT date FROM ".$NPDS_Prefix."agend WHERE liaison = '$liaison' ORDER BY date DESC");
				$tot = sql_num_rows($result1);
				$affeven .= '<tr>'
				.'<td colspan="4" class="ag_trois">'
				.'<div style="conteneur">'
				.'<div style="float: right">';
				if ($posteur == $cookie[1])
				{
					$affeven .= '<i>[&nbsp;<a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=editevt&amp;id='.$liaison.'">'.ag_trad('Editer').'</a>&nbsp;-&nbsp;'
					.'<a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=suppevt&amp;id='.$liaison.'">'.ag_trad('Supprimer').'</a>&nbsp;]</i>';
				}
				else
				{
					$affeven .= '<i>'.ag_trad('posté par').'&nbsp;'.$posteur.'</i>&nbsp;';
				}
				$affeven .= '</div>';
				if ($tot > 1)
				{
					$affeven .= '<img src="modules/'.$ModPath.'/images/fle.gif" />&nbsp;'.ag_trad('Cet évènement dure sur plusieurs jours').'&nbsp;:&nbsp;'
					.'<select>'
					.'<option>'.ag_trad('Voir').'</option>';
					while (list($ddate) = sql_fetch_row($result1))
					{
						if($ddate > $now){$etat = ' style="color:#009900;"';}
						else if($ddate == $now){$etat = ' style="color:#0000FF;"';}
						else if($ddate < $now){$etat = ' style="color:#FF0000;"';}
						$newdate = formatfrancais($ddate);
						$affeven .= '<option'.$etat.'>'.$newdate.'</option>';
					}
					$affeven .= '</select>';
				}
				else
				{
					list($ddate) = sql_fetch_row($result1);
					if($ddate > $now){$etat = ' style="color:#009900;"';}
					else if($ddate == $now){$etat = ' style="color:#0000FF;"';}
					else if($ddate < $now){$etat = ' style="color:#FF0000;"';}
					$newdate = formatfrancais($ddate);
					$affeven .= '<img src="modules/'.$ModPath.'/images/fle.gif" />&nbsp;'.ag_trad('Cet évènement dure 1 jour').'&nbsp;&nbsp;<span'.$etat.'>'.$newdate.'</span>';
				}
				$affeven .= '</div>'
				.'</td>'
				.'</tr>'
				.'<tr>'
				.'<td width="10%" class="ag_trois">'.ag_trad('Titre').'</td>'
				.'<td width="70%" class="ag_deux">'.$titre.'</td>'
				.'<td width="1%">&nbsp;</td>'
				.'<td width="19%" align="center" class="ag_deux" Valign="top" rowspan="3"><img src="'.$tipath.''.$topicimage.'" /><br />'.$topictext.'</td>'
				.'</tr>'
				.'<tr>'
				.'<td Valign="top" class="ag_trois">'.ag_trad('Résumé').'</td>'
				.'<td Valign="top" class="ag_deux">'.str_replace("\n","<br />",$intro).'</td>'
				.'</tr>'
				.'<tr>'
				.'<td class="ag_trois">'.ag_trad('Lieu').'</td>'
				.'<td class="ag_deux">'.$lieu.'</td>'
				.'</tr>'
				.'<tr>'
				.'<td colspan="4" align="right" class="ag_trois"><a href="modules.php?ModPath='.$ModPath.'&ModStart=calendrier&subop=fiche&date='.$date.'&id='.$liaison.'">'.ag_trad('Voir la fiche complète...').'</a></td>'
				.'</tr>';
			}
		}
		$affeven .= '</table>';
	}
	/*debut theme html partie 2/2*/
	ob_start();
	include ($inclusion);
	$Xcontent = ob_get_contents();
	ob_end_clean();
	$npds_METALANG_words = array(
		"'!rech!'i"=>"$rech",
		"'!alph!'i"=>"$alph",
		"'!affeven!'i"=>"$affeven"
	);
	echo meta_lang(aff_langue(preg_replace(array_keys($npds_METALANG_words),array_values($npds_METALANG_words), $Xcontent)));
	/*fin theme html partie 2/2*/
	/*Affiche pagination*/
	echo ag_pag($total_pages,$page_courante,'2',''.$ThisFile.'&amp;lettre='.$lettre.'&amp;niv='.$niv.'','_mod');
	Closetable();
}
/// FIN LISTE EVENEMENT PAR CHOIX ///
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
	$pdst = "0";
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
				lieu($lettre, $niv);
			break;
	
		}
	}
	if ($SuperCache)
	{
		$cache_obj->endCachingPage();
	}
	include("footer.php");
?>