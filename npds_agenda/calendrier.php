<?php
/*************************************************/
/* NPDS : Net Portal Dynamic System              */
/* ==========================                    */
/* Fichier : modules/agenda/calendrier.php       */
/*                                               */
/* Module Agenda                                 */
/* Version 1.0                                   */
/* Auteur Oim                                    */
/*************************************************/
// For More security
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}// For More security

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
function listsuj($sujet, $niv)
{	global $NPDS_Prefix, $ModPath, $theme, $cookie;
	global $ThisFile, $nb_news, $tipath, $page;
	/*Debut securite*/
	settype($sujet,"integer");
	settype($niv,"integer");
	settype($page,"integer");
	/*Fin securite*/
	require_once('modules/'.$ModPath.'/pag_fonc.php');

	suj();
	//debut theme html partie 1/2
//	$inclusion = false;
      $inclusion = "modules/".$ModPath."/html/listsuj.html";
	/*fin theme html partie 1/2*/
	/*Gestion naviguation en cours ou passe*/
	$now = date('Y-m-d');
	/*Total pour pagination*/
	$req1 = sql_query("SELECT 
			ut.groupvoir 
		FROM 
			".$NPDS_Prefix."agend_dem ut, 
			".$NPDS_Prefix."agend us 
		WHERE 
			ut.topicid = '$sujet'  
			AND us.liaison = ut.id 
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
	/*Total pour pagination*/
	$req1 = sql_query("SELECT 
			ut.groupvoir 
		FROM 
			".$NPDS_Prefix."agend_dem ut, 
			".$NPDS_Prefix."agend us 
		WHERE 
			ut.topicid = '$sujet'  
			AND us.liaison = ut.id 
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
		$cs = 'class="text-danger"';
		$nb_entrees = ''.$sup.'';
		$cond = "date >= '$now'";
	}
	else if($niv == '1')
	{
		$cs1 = 'class="text-danger"';
		$nb_entrees = ''.$inf.'';
		$cond = "date < '$now'";
	}
	/*Pour la navigation*/
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
	/*Requete affiche sujet suivant $sujet*/
	$res = sql_query("SELECT topicimage, topictext FROM ".$NPDS_Prefix."agendsujet WHERE topicid = '$sujet'");
	list($topicimage, $topictext) = sql_fetch_row($res);
	$topictext = stripslashes(aff_langue($topictext));
	if ($sup == '0' && $inf == '0')
	{
		$affres = '<p>'.ag_trad('Vide').'</p>';
	}
	else
	{
		$affres = '<ul><li>'.ag_trad('Evènements à venir').' <a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;subop=listsuj&amp;sujet='.$sujet.'&amp;niv=0" '.$cs.'>'.$sup.'</a></li>'
		.'<li>'.ag_trad('Evènements en cours ou passés').' <a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;subop=listsuj&amp;sujet='.$sujet.'&amp;niv=1" '.$cs1.'>'.$inf.'</a></li></ul>';

		$affres .= '<hr />';
      
		/*Requete liste evenement suivant $sujet*/
		$result = sql_query("SELECT 
				us.id, us.date, us.liaison, 
				ut.titre, ut.intro, ut.descript, ut.lieu, ut.posteur, ut.groupvoir 
			FROM 
				".$NPDS_Prefix."agend us, 
				".$NPDS_Prefix."agend_dem ut 
			WHERE 
				ut.topicid = '$sujet' 
				AND us.liaison = ut.id 
				AND ut.valid = '1' 
				AND us.$cond 
			GROUP BY us.liaison 
			ORDER BY us.date DESC LIMIT $start,$nb_news");
		while(list($id, $date, $liaison, $titre, $intro, $descript, $lieu, $posteur, $groupvoir) = sql_fetch_row($result))
		{
			$titre = stripslashes(aff_langue($titre));
			$intro = stripslashes(aff_langue($intro));
			$lieu = stripslashes(aff_langue($lieu));
			/*Si membre appartient au bon groupe*/
			if(autorisation($groupvoir))
			{
				/*Si evenement plusieurs jours*/
				$result1 = sql_query("SELECT date FROM ".$NPDS_Prefix."agend WHERE liaison = '$liaison' ORDER BY date DESC");
				$tot = sql_num_rows($result1);

            $affres .= '<div class="row">'
				.'<div class="col-md-2"><h4>'.ag_trad('Titre').'</h4></div>'
				.'<div class="col-md-10"><h4>'.$titre.'</h4></div>'
				.'</div>';            

            $affres .='<div class="row"><div class="col-md-6">';
				if ($tot > 1)
				{
					$affres .= '<i class="fa fa-info-circle" aria-hidden="true"></i> '.ag_trad('Cet évènement dure plusieurs jours').'&nbsp;:</div>'
               .'<div class="col-md-6">'
					.'<select>'
					.'<option>'.ag_trad('Voir').'</option>';
					while (list($ddate) = sql_fetch_row($result1))
					{
						if($ddate > $now){$etat = 'text-success';}
						else if($ddate == $now){$etat = 'text-warning';}
						else if($ddate < $now){$etat = 'text-danger';}
						$newdate = formatfrancais($ddate);
						$affres .= '<option class="'.$etat.'">'.$newdate.'</option>';
					}
					$affres .= '</select>';
				}
				else
				{
					list($ddate) = sql_fetch_row($result1);
					$newdate = formatfrancais($ddate);
					if($ddate > $now){$etat = 'text-success';}
					else if($ddate == $now){$etat = 'text-warning';}
					else if($ddate < $now){$etat = 'text-danger';}
					$affres .= '<i class="fa fa-info-circle" aria-hidden="true"></i> '.ag_trad('Cet évènement dure 1 jour').'&nbsp;&nbsp;<span class="'.$etat.'">'.$newdate.'</span>';
				}
				$affres .= '</div>'
				.'</div>';

            
				$affres .= '<div class="row">'
				.'<div class="col-md-2">'.ag_trad('Résumé').'</div>'
				.'<div class="col-md-10">'.str_replace("\n","<br />",$intro).'</div>'
				.'</div>';
            
				$affres .= '<div class="row">'
				.'<div class="col-md-2">'.ag_trad('Lieu').'</div>'
				.'<div class="col-md-10">'.$lieu.'</div>'
				.'</div>';
            
/*				$affres .= '<div class="row">'
				.'<div class="col-md-12"><a class="btn btn-secondary btn-sm" href="'.$ThisFile.'&amp;subop=fiche&amp;date='.$date.'&amp;id='.$liaison.'">'.ag_trad('Voir la fiche complète...').'</a></div>'
				.'</div>';*/

$affres .= '<div class="row"><div class="col-md-12">
            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#ficheone">
  '.ag_trad('Voir la fiche complète').'
            </button>
<div class="modal fade" id="ficheone" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="ficheoneLabel">'.$titre.'</h4>
      </div>
      <div class="modal-body">
<h4 class="'.$etat.'"><strong>'.ag_trad('Le').' '.$newdate.'</strong></h4>



            <div class="row">
				<div class="col-md-2">'.ag_trad('Résumé').'</div>
				<div class="col-md-10">'.str_replace("\n","<br />",$intro).'</div>
				</div>

            <div class="row">
				<div class="col-md-2">'.ag_trad('Descriptif').'</div>
				<div class="col-md-10">'.str_replace("\n","<br />",$descript).'</div>
				</div>
            
            <div class="row">
				<div class="col-md-2">'.ag_trad('Lieu').'</div>
				<div class="col-md-10">'.$lieu.'</div>
				</div>
            

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</div></div>

';





            

				$affres .= '<div class="row">'
				.'<div class="col-md-offset-10 col-md-2">';
				if ($posteur == $cookie[1])
				{
					$affres .= '<a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=editevt&amp;id='.$liaison.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;'
					.'<a class="btn btn-danger-outline btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=suppevt&amp;id='.$liaison.'"><i class="fa fa-trash" aria-hidden="true"></i></a></div>';
				}
				else
				{
					$affres .= '<p>'.ag_trad('posté par').' '.$posteur.'</p></div>';
				}
				$affres .= '</div>';
            
            $affres .= '<hr />';
			}
		}

		/*Affiche pagination*/
		echo ag_pag($total_pages,$page_courante,'2',''.$ThisFile.'&amp;subop=listsuj&amp;sujet='.$sujet.'&amp;niv='.$niv.'','_mod');
	}
	/*debut theme html partie 2/2*/
	ob_start();
	include ($inclusion);
	$Xcontent = ob_get_contents();
	ob_end_clean();
	$npds_METALANG_words = array(
		"'!topictext!'i"=>"$topictext",
		"'!affres!'i"=>"$affres"
	);
	echo meta_lang(aff_langue(preg_replace(array_keys($npds_METALANG_words),array_values($npds_METALANG_words), $Xcontent)));
	/*fin theme html partie 2/2*/
	
}
/// FIN LISTE EVENEMENT ///


/// DEBUT CALENDRIER ///
function calend($an, $month)
{	global $ModPath, $NPDS_Prefix, $theme;
	global $ThisFile;
	/*Debut securite*/
	settype($an,"integer");
	settype($month,"integer");
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
			''.ag_trad('JANVIER').'',
			''.ag_trad('FEVRIER').'',
			''.ag_trad('MARS').'',
			''.ag_trad('AVRIL').'',
			''.ag_trad('MAI').'',
			''.ag_trad('JUIN').'',
			''.ag_trad('JUILLET').'',
			''.ag_trad('AOUT').'',
			''.ag_trad('SEPTEMBRE').'',
			''.ag_trad('OCTOBRE').'',
			''.ag_trad('NOVEMBRE').'',
			''.ag_trad('DECEMBRE').'');
	$mois_en_clair = $mois_de_annee[$month - 1];
	/*Creation tableau a 31 entrees sans reservation*/
	for($j = 1; $j < 32; $j++)
	{
		$tab_jours[$j] = (bool)false;
	}
	/*Requete liste jour avec evenement*/
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
	
	suj();
	/*debut theme html partie 1/2*/
	$inclusion = false;

      $inclusion = "modules/".$ModPath."/html/calendrier.html";

	/*fin theme html partie 1/2*/
	$naviguation = '<a class="btn" href="'.$ThisFile.'&amp;month='.$mois_prec.'&amp;an='.$an_prec.'"><i class="fa fa-lg fa-chevron-left" aria-hidden="true"></i></a>'
	.'<span class="label label-default">'.$mois_en_clair.'&nbsp;'.$an.'</span>'
	.'<a class="btn" href="'.$ThisFile.'&amp;month='.$mois_suivant.'&amp;an='.$an_suivant.'"><i class="fa fa-lg fa-chevron-right" aria-hidden="true"></i></a>';
	$affcal .= '<tr>';
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
		$affcal .= '<th scope="row" class="text-xs-center">'.$semaine0.'</th>';
		/*Boucle pour les 6 premieres colonnes/jours*/
		for ($debutdimanche = 1; $debutdimanche <= 6; $debutdimanche++)
		{
			/*Si case calendrier vide*/
			$affcal .= '<td class="text-xs-center">&nbsp;</td>'; 
		}
		/*Permet la naviguation du calendrier*/
		$date = ajout_zero(01, $month, $an);
		/*Met en rouge ce jour*/
		if (01 == $jour && $month == $mois_actuel && $an == $an_actuel) {$cs = 'text-danger';}else{$cs = 'text-muted';}
		/*Si ce premier dimanche est "reserve"*/
		if($tab_jours[1])
		{
			/*Si jour ferie sans evenement*/
			if ($afftitre[$tab_jours[1]] == '' && $fetetitre[$tab_jours[1]] != ''){$cla = 'table-warning';}
			else if ($afftitre[$tab_jours[1]] != '' && $fetetitre[$tab_jours[1]] == ''){$cla = 'table-info';}
			else if ($afftitre[$tab_jours[1]] != '' && $fetetitre[$tab_jours[1]] != ''){$cla = 'table-info';}
			$affcal .= '<td class="text-xs-center '.$cla.'">'
			.'<a href="'.$ThisFile.'&amp;subop=jour&amp;date='.$date.'" data-toggle="tooltip" data-placement="bottom" title="'.$fetetitre[$tab_jours[1]].'&nbsp;'.$afftitre[1].'"><span class="'.$cs.'">1</span></a>'
			.'</td>';
		}
		else
		{
			/*Css jour libre*/
			$affcal .= '<td class="text-xs-center">'
			.'<span class="'.$cs.'">1</span>'
			.'</td>';
		}
		$affcal .= '</tr>'
		.'<tr>';
	}
	else
	{
		/*Calcul numero semaine +0 pour enlever le 0 de 01,02,...*/
		$semaine1 = $semaine + 0;
		
	}
	$affcal .= '<th scope="row" class="text-xs-center">'.$semaine1.'</th>';
	/*7 premiers jour du mois*/
	for ($i = 1; $i < 8; $i++)
	{
		/*Si case calendrier vide*/
		if ($i < $premier_jour)
		{
			$affcal .= '<td class="text-xs-center">&nbsp;</td>';
		}
		else
		{
			/*Case avec class pour reserver*/
			$ce_jour = ($i + 1) - $premier_jour;
			/*Permet la naviguation du calendrier*/
			$date = ajout_zero($ce_jour, $month, $an);
			/*Met en rouge ce jour*/
			if ($ce_jour == $jour && $month == $mois_actuel && $an == $an_actuel) {$cs = 'text-danger';}else{$cs = 'text-muted';}
			if($tab_jours[$ce_jour])
			{
				/*Si jour ferie sans evenement*/
				if ($afftitre[$ce_jour] == '' && $fetetitre[$ce_jour] != ''){$cla = 'table-warning';}
				else if ($afftitre[$ce_jour] != '' && $fetetitre[$ce_jour] == ''){$cla = 'table-info';}
				else if ($afftitre[$ce_jour] != '' && $fetetitre[$ce_jour] != ''){$cla = 'table-info';}
				$affcal .= '<td class="text-xs-center '.$cla.'">'
				.'<a href="'.$ThisFile.'&amp;subop=jour&amp;date='.$date.'" data-toggle="tooltip" data-placement="bottom" title="'.$fetetitre[$ce_jour].'&nbsp;'.$afftitre[$ce_jour].'"><span class="'.$cs.'">'.$ce_jour.'</span></a>'
				.'</td>';
			}
			else
			{
				/*Css libre*/
				$affcal .= '<td class="text-xs-center">'
				.'<span class="'.$cs.'">'.$ce_jour.'</span>'
				.'</td>';
			}
		}
	}
	/*Affichage fin du calendrier*/
	$jour_suiv = ($i + 1) - $premier_jour;
	for ($rangee = 0; $rangee <= 3; $rangee++)
	{
		$affcal .= '</tr>'
		.'<tr>';
		/*Calcul numero semaine*/
		$semaine2 = $semaine1 + $rangee + 1;
		if ($semaine2 == 53){$semaine2 = "1";}
		$affcal .= '<th scope="row" class="text-xs-center">'.$semaine2.'</th>';
		for ($i = 1; $i < 8; $i++)
		{
			if($jour_suiv > $dernier_jour)
			{
				/*Case avec class pour vide*/
				$affcal .= '<td class="text-xs-center">&nbsp;</td>';
			}
			else
			{
				/*Permet la naviguation du calendrier*/
				$date = ajout_zero($jour_suiv, $month, $an);
				/*Met en rouge ce jour*/
				if ($jour_suiv == $jour && $month == $mois_actuel && $an == $an_actuel) {$cs = 'text-danger';}else{$cs = 'text-muted';}
				/*Case avec class pour reserver*/
				if($tab_jours[$jour_suiv])
				{
					/*Si jour ferie sans evenement*/
					if ($afftitre[$jour_suiv] == '' && $fetetitre[$jour_suiv] != ''){$cla = 'table-warning';}
					else if ($afftitre[$jour_suiv] != '' && $fetetitre[$jour_suiv] == ''){$cla = 'table-info';}
					else if ($afftitre[$jour_suiv] != '' && $fetetitre[$jour_suiv] != ''){$cla = 'table-info';}
					$affcal .= '<td class="text-xs-center '.$cla.'">'
					.'<a href="'.$ThisFile.'&amp;subop=jour&amp;date='.$date.'" data-toggle="tooltip" data-placement="bottom" title="'.$fetetitre[$jour_suiv].'&nbsp;'.$afftitre[$jour_suiv].'"><span class="'.$cs.'">'.$jour_suiv.'</span></a>'
					.'</td>';
				}
				else
				{
					/*Css libre*/
					$affcal .= '<td class="text-xs-center">'
					.'<span class="'.$cs.'">'.$jour_suiv.'</span>'
					.'</td>';
				}
			}
			$jour_suiv++;
		}
	}
	$affcal .= '</tr>';
	/*debut theme html partie 2/2*/
	ob_start();
	include ($inclusion);
	$Xcontent = ob_get_contents();
	ob_end_clean();
	$npds_METALANG_words = array(
		"'!naviguation!'i"=>"$naviguation",
		"'!affcal!'i"=>"$affcal"
	);
	echo meta_lang(aff_langue(preg_replace(array_keys($npds_METALANG_words),array_values($npds_METALANG_words), $Xcontent)));
	/*fin theme html partie 2/2*/
	
}
/// FIN CALENDRIER ///


/// DEBUT JOUR ///
function jour($date)
{	global $ModPath, $NPDS_Prefix, $theme, $cookie;
	global $ThisFile, $nb_news, $tipath, $page;
	/*Debut securite*/
	settype($page,"integer");
	$date = removeHack($date);
	/*Fin securite*/
	require_once('modules/'.$ModPath.'/pag_fonc.php');
	
	suj();
	/*debut theme html partie 1/2*/
	$inclusion = false;

      $inclusion = "modules/".$ModPath."/html/jour.html";

	/*fin theme html partie 1/2*/
	/*Gestion naviguation en cours ou passe*/
	$now = date('Y-m-d');
	/*Total pour naviguation*/
	$req1 = sql_query("SELECT 
			ut.groupvoir 
		FROM 
			".$NPDS_Prefix."agend us, 
			".$NPDS_Prefix."agend_dem ut 
		WHERE 
			us.date = '$date' 
			AND us.liaison = ut.id 
			AND valid = '1'");
	while(list($groupvoir) = sql_fetch_row($req1))
	{
		if(autorisation($groupvoir))
		{
			$nb_entrees++;
		}
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
	$retour = convertion($date);
	$datetime = formatfrancais($date);
	$bandeau = '<a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;month='.$retour[0].'&amp;an='.$retour[1].'">'.ag_trad('Retour au calendrier').'</a>';
	$lejour = $datetime;
	if ($nb_entrees == 0)
	{
		$affeven = '<p>'.ag_trad('Rien de prévu ce jour').'</p>';
	}
	else
	{
		$affeven .= '<table class="table">';
		/*Requete liste evenement suivant $date*/
		$result = sql_query("SELECT 
				us.id, us.liaison, 
				ut.titre, ut.intro, ut.lieu, ut.topicid, ut.posteur, ut.groupvoir, 
				uv.topicimage, uv.topictext 
			FROM 
				".$NPDS_Prefix."agend us, 
				".$NPDS_Prefix."agend_dem ut, 
				".$NPDS_Prefix."agendsujet uv 
			WHERE 
				us.date = '$date' 
				AND us.liaison = ut.id 
				AND ut.valid = '1' 
				AND ut.topicid = uv.topicid 
			LIMIT $start,$nb_news");
		while(list($id, $liaison, $titre, $intro, $lieu, $topicid, $posteur, $groupvoir, $topicimage, $topictext) = sql_fetch_row($result))
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
				.'<td colspan="4">'
				.''
				.'';
				if ($posteur == $cookie[1])
				{
					$affeven .= '<a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=editevt&amp;id='.$liaison.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;'
					.'<a class="btn btn-danger-outline btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=suppevt&amp;id='.$liaison.'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>';
				}
				else
				{
					$affeven .= '<p>'.ag_trad('posté par').'&nbsp;'.$posteur.'</p></td>';
				}
				$affeven .= '</tr><tr><td>';
				if ($tot > 1)
				{
					$affeven .= '<i class="fa fa-info-circle" aria-hidden="true"></i> '.ag_trad('Cet évènement dure plusieurs jours').'&nbsp;:&nbsp;</td><td>'
					.'<select class="form-control">'
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
					$affeven .= '<i class="fa fa-info-circle" aria-hidden="true"></i> '.ag_trad('Cet évènement dure 1 jour').'';
				}
				$affeven .= ''
				.'</td>'
				.'</tr>'
				.'<tr>'
				.'<td>'.ag_trad('Titre').'</td>'
				.'<td>'.$titre.'</td>'
				.'<td>&nbsp;</td>'
				.'<td><img src="'.$tipath.''.$topicimage.'" /><br />'.$topictext.'</td>'
				.'</tr>'
				.'<tr>'
				.'<td>'.ag_trad('Résumé').'</td>'
				.'<td>'.str_replace("\n","<br />",$intro).'</td>'
				.'</tr>'
				.'<tr>'
				.'<td>'.ag_trad('Lieu').'</td>'
				.'<td>'.$lieu.'</td>'
				.'</tr>'
				.'<tr>'
				.'<td><a class="btn btn-secondary btn-sm" href="'.$ThisFile.'&amp;subop=fiche&amp;date='.$date.'&amp;id='.$liaison.'">'.ag_trad('Voir la fiche complète...').'</a></td>'
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
		"'!bandeau!'i"=>"$bandeau",
		"'!lejour!'i"=>"$lejour",
		"'!affeven!'i"=>"$affeven"
	);
	echo meta_lang(aff_langue(preg_replace(array_keys($npds_METALANG_words),array_values($npds_METALANG_words), $Xcontent)));
	/*fin theme html partie 2/2*/
	/*Affiche pagination*/
	echo ag_pag($total_pages,$page_courante,'2',''.$ThisFile.'&amp;subop=jour&amp;date='.$date.'','_mod');
	
}
/// FIN JOUR ///
/// DEBUT FICHE ///
function fiche($date, $id)
{	global $ModPath, $NPDS_Prefix, $cookie, $theme;
	global $ThisFile, $nb_news, $tipath;
	/*Debut securite*/
	settype($id,"integer");
	$date = removeHack($date);
	/*Fin securite*/
	
	suj();
	/*debut theme html partie 1/2*/
	$inclusion = false;

      $inclusion = "modules/".$ModPath."/html/fiche.html";

	/*fin theme html partie 1/2*/
	/*Gestion naviguation en cours ou passe*/
	$now = date('Y-m-d');
	$retour = convertion($date);
	$datetime = formatfrancais($date);
	$bandeau = '<a class="btn btn-secondary" href="'.$ThisFile.'&amp;month='.$retour[0].'&amp;an='.$retour[1].'">'.ag_trad('Retour au calendrier').'</a>';
	$bandeau1 = '<a class="btn btn-secondary" href="'.$ThisFile.'&amp;subop=jour&amp;date='.$date.'">'.ag_trad('Retour au jour').'</a>';
	$lejour = ''.$datetime.'';
	/*Requete affiche evenement suivant $id*/
	$result = sql_query("SELECT titre, intro, descript, lieu, topicid, posteur, groupvoir FROM ".$NPDS_Prefix."agend_dem WHERE id = '$id' AND valid = '1'");
	$total = sql_num_rows($result);
	if ($total == 0)
	{
		$vide = '<p class="lead">'.ag_trad('Aucun évènement trouvé.').'</p>';
	}
	else
	{
		list($titre, $intro, $descript, $lieu, $topicid, $posteur, $groupvoir) = sql_fetch_row($result);
		/*Si membre appartient au bon groupe*/
		if(autorisation($groupvoir))
		{
			/*Si evenement plusieur jours*/
			$result1 = sql_query("SELECT date FROM ".$NPDS_Prefix."agend WHERE liaison = '$id' ORDER BY date DESC");
			$tot = sql_num_rows($result1);
			if ($posteur == $cookie[1])
			{
				$postepar = '<a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=editevt&amp;id='.$id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;'
				.'<a class="btn btn-danger-outline btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=suppevt&amp;date='.$date.'&amp;id='.$id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
			}
			else
			{
				$postepar = ''.ag_trad('posté par').'&nbsp;'.$posteur.'</td>';
			}
				$affres .= '</tr><tr><td>';
			if ($tot > 1)
			{
				$imgfle .= '<i class="fa fa-info-circle" aria-hidden="true"></i> '.ag_trad('Cet évènement dure sur plusieurs jours').'&nbsp;:&nbsp;'
				.'<select>'
				.'<option>'.ag_trad('Voir').'</option>';
				while (list($ddate) = sql_fetch_row($result1))
				{
					if($ddate > $now){$etat = ' style="color:#009900;"';}
					else if($ddate == $now){$etat = ' style="color:#0000FF;"';}
					else if($ddate < $now){$etat = ' style="color:#FF0000;"';}
					$newdate = formatfrancais($ddate);
					$imgfle .= '<option'.$etat.'>'.$newdate.'</option>';
				}
				$imgfle .= '</select>';
			}
			else
			{
				$imgfle .= '<img src="modules/'.$ModPath.'/images/fle.gif" /> '.ag_trad('Cet évènement dure 1 jour').'';
			}
			$imgfle .= '</div>';
			/*Requete liste categorie*/
			$result2 = sql_query("SELECT topicimage, topictext FROM ".$NPDS_Prefix."agendsujet WHERE topicid = '$topicid'");
			list($topicimage, $topictext) = sql_fetch_row($result2);
			$titrefiche = ''.stripslashes(aff_langue($titre)).'';
			$imgsuj = '<img src="'.$tipath.''.$topicimage.'" /><br />'.stripslashes(aff_langue($topictext)).'';
			$resume = ''.str_replace("\n","<br />",stripslashes(aff_langue($intro))).'';
			$detail = ''.stripslashes(aff_langue($descript)).'';
			$lieu = ''.stripslashes(aff_langue($lieu)).'';
		}
	}
	/*debut theme html partie 2/2*/
	ob_start();
	include ($inclusion);
	$Xcontent = ob_get_contents();
	ob_end_clean();
	$npds_METALANG_words = array(
		"'!bandeau!'i"=>"$bandeau",
		"'!bandeau1!'i"=>"$bandeau1",
		"'!lejour!'i"=>"$lejour",
		"'!vide!'i"=>"$vide",
		"'!imgfle!'i"=>"$imgfle",
		"'!listjour!'i"=>"$listjour",
		"'!titrefiche!'i"=>"$titrefiche",
		"'!imgsuj!'i"=>"$imgsuj",
		"'!resume!'i"=>"$resume",
		"'!detail!'i"=>"$detail",
		"'!lieu!'i"=>"$lieu",
		"'!postepar!'i"=>"$postepar"
	);
	echo meta_lang(aff_langue(preg_replace(array_keys($npds_METALANG_words),array_values($npds_METALANG_words), $Xcontent)));
	/*fin theme html partie 2/2*/
	
}
/// FIN FICHE ///
////////////////////
/// FIN FONCTION ///
////////////////////

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
	$tipath = 'modules/'.$ModPath.'/images/categories/';
	include('header.php');
	include('modules/'.$ModPath.'/admin/config.php');
	require_once('modules/'.$ModPath.'/ag_fonc.php');
	include ('modules/'.$ModPath.'/cache.timings.php');
	echo '<div class="card"><div class="card-block">';
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
				calend($an, $month);
			break;
			case 'listsuj':
				listsuj($sujet, $niv);
			break;
			case 'jour':
				jour($date);
			break;
			case 'fiche':
				fiche($date, $id);
			break;
			}
	}
	if ($SuperCache)
	{
		$cache_obj->endCachingPage();
	}
   echo '</div></div>';
	include("footer.php");
?>