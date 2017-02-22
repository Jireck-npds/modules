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

include ('modules/'.$ModPath.'/admin/pages.php');

global $pdst, $language;

include_once('modules/'.$ModPath.'/lang/agenda-'.$language.'.php');

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
         <li class="nav-item"><a class="nav-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration">'.ag_translate('Vos ajouts').'</a></li>
         <li class="nav-item"><a class="nav-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=agenda_add"><i class="fa fa-plus mr-2" aria-hidden="true"></i>'.ag_translate('Evènement').'</a></li>';
   }

//Accès direct à un sujet   
   $accesuj = '<li class="nav-item ml-3">
   <select class="custom-select" onchange="window.location=(\''.$ThisRedo.'&subop=listsuj&sujet='.$stopicid.'\'+this.options[this.selectedIndex].value)">
   <option>'.aff_langue('Accès catégorie(s)').'</option>';

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
      $rech = ''.ag_translate('Par').' '.$bouton.'';
   }
   $accesuj .= '</select></li>';
   
// fin Accès direct à un sujet
   $vuannu ='<li class="nav-item"><a class="nav-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=annee">'.ag_translate('Vue annuelle').'</a></li>';
   $vulieu ='<li class="nav-item"><a class="nav-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=lieu">'.$rech.'</a></li>';
   
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

// DEBUT LISTE EVENEMENT PAR CHOIX
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

   suj();
   
/*debut theme html partie 1/2*/
//   $inclusion = false;

   $inclusion = "modules/".$ModPath."/html/lieu.html";

   /*fin theme html partie 1/2*/
   /*Recherche*/
   if ($bouton == '1')
   {
      if($lettre != ''){$cond = "AND ut.lieu LIKE '$lettre%'";$suite = ''.ag_translate('pour la lettre').' <span class="badge badge-default">'.$lettre.'</span>';}
      $rech = '<span class="ml-1">'.ag_translate('par ville(s)').'</span> '.$suite.'';
      $alphabet = array ("A","B","C","D","E","F","G","H","I","J","K","L","M",
      "N","O","P","Q","R","S","T","U","V","W","X","Y","Z","".ag_translate("Autre")."");
      $num = count($alphabet);
      $counter = 0;
      while (list(, $ltr) = each($alphabet))
      {
         if ($ltr != ag_translate("Autre"))
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
            $alph .= " | ";
         $counter++;
      }
   }
   else
   {
      include('modules/'.$ModPath.'/recherche/'.$bouton.'.php');
      if($lettre != ''){$cond = "AND ut.lieu LIKE '$lettre%'";$suite = ' '.ag_translate('pour').' '.$lettre.'';}
      $rech = ''.ag_translate('par').' '.$bouton.' '.$suite.'';
      if($lettre != ''){$cond = "AND ut.lieu = '$lettre'";}
      $alph .= '<select class="custom-select" onchange="window.location=(\''.$ThisFile.'&amp;lettre='.$na[$i].'\'+this.options[this.selectedIndex].value)">'
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
      $cs = 'class="text-danger"';
      $nb_entrees = ''.$sup.'';
      $cond1 = "date >= '$now'";
   }
   else if($niv == '1')
   {
      $cs1 = 'class="text-danger"';
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
      $affeven = '<p class="lead"><i class="fa fa-info-circle" aria-hidden="true"></i> '.ag_translate('Vide').'</p>';
   }
   else
   {
      $affeven = '<ul>
      <li>'.ag_translate('Evènement(s) à venir').'<a class="badge badge-success ml-2" data-toggle="tooltip" data-placement="bottom" title="Visualiser" href="'.$ThisFile.'&amp;subop=listsuj&amp;lettre='.$lettre.'&amp;niv=0">'.$sup.'</a></li>
      <li>'.ag_translate('Evènement(s) en cours ou passé(s)').'<a class="badge badge-default ml-2" data-toggle="tooltip" data-placement="bottom" title="Visualiser" href="'.$ThisFile.'&amp;subop=listsuj&amp;lettre='.$lettre.'&amp;niv=1">'.$inf.'</a></li>
      </ul>';
      $affeven .= '';
      /*Requete liste evenement suivant $date*/
      $result = sql_query("SELECT 
            us.id, us.date, us.liaison, 
            ut.titre, ut.intro,ut.descript, ut.lieu, ut.topicid, ut.posteur, ut.groupvoir, 
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
      while(list($id, $date, $liaison, $titre, $descript, $intro, $lieu, $topicid, $posteur, $groupvoir, $topicimage, $topictext) = sql_fetch_row($result))
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
            $affeven .= '<div class="card my-3">
                <div class="card-block">';
				
            $affeven .= '<img class="img-thumbnail mb-2" src="'.$tipath.''.$topicimage.'" />';
            $affeven .= '<h4 class="card-title">'.$titre.'</h4>';
            $affeven .='<p class="card-text">';
            if ($tot > 1)
            {
               $affeven .= '<i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Cet évènement dure sur plusieurs jours').'</p>';
               while (list($ddate) = sql_fetch_row($result1))
               {
                  if($ddate > $now){$etat = 'badge badge-success';}
                  else if($ddate == $now){$etat = 'badge badge-warning';}
                  else if($ddate < $now){$etat = 'badge badge-warning';}
                  $newdate = formatfrancais($ddate);
                  $affeven .= '<div class="'.$etat.' mr-2 mb-2">'.$newdate.'</div>';
				  $datepourmonmodal .= '<span class="'.$etat.'">'.$newdate.'</span>';
               }
            }
            else
            {
               list($ddate) = sql_fetch_row($result1);
               if($ddate > $now){$etat = 'badge badge-success';}
               else if($ddate == $now){$etat = 'badge badge-warning';}
               else if($ddate < $now){$etat = 'badge badge-warning';}
               $newdate = formatfrancais($ddate);
               $affeven .= '<p class="card-text"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Cet évènement dure 1 jour').'</p>';
			   $affeven .= '<div class="'.$etat.' mr-2 mb-2">'.$newdate.'</div>';			   
            }			
		
            if ($posteur == $cookie[1])
            {            
               $affeven .= '<a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=editevt&amp;id='.$liaison.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
               <a class="btn btn-outline-danger btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=suppevt&amp;id='.$liaison.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            }
            else
            {
               $affeven .= '<p>'.ag_translate('posté par').' '.$posteur.'</p>';
            }
            $affeven .= '<p class="card-text">';

            $affeven .= '<div class="row">
            <div class="col-md-2">'.ag_translate('Résumé').'</div>
            <div class="col-md-10">'.$intro.'</div>
            </div>';

            $affeven .= '<div class="row">
            <div class="col-md-2">'.ag_translate('Lieu').'</div>
            <div class="col-md-10">'.$lieu.'</div>
            </div>';
//début modal fiche
$affeven .= '<div class="row">
            <div class="col-md-12">
            <button type="button" class="btn btn-secondary btn-sm my-2" data-toggle="modal" data-target="#'.$id.'">
  '.ag_translate('Voir la fiche').'
            </button>
<div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg"" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="'.$id.'Label">'.$titre.'</h4>     
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <h5 class="'.$etat.'"><strong>';
				if ($tot > 1)
				{
	  $affeven .= ag_translate('Les').' '.$datepourmonmodal;
				}
				else{
	  $affeven .= ag_translate('Le').' '.$newdate;
				
				}
	  $affeven .= '</strong></h5>
            <div class="row">
            <div class="col-md-2">'.ag_translate('Résumé').'</div>
            <div class="col-md-10">'.$intro.'</div>
            </div>
            <div class="row">
            <div class="col-md-2">'.ag_translate('Descriptif').'</div>
            <div class="col-md-10">'.$descript.'</div>
            </div>
            
            <div class="row">
            <div class="col-md-2">'.ag_translate('Lieu').'</div>
            <div class="col-md-10">'.$lieu.'</div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div></div>';
//fin modal fiche

         }
      $affeven .= '</div></div>';
         }

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
}
// FIN LISTE EVENEMENT PAR CHOIX




	/*Parametres utilises par le script*/
	$ThisFile = 'modules.php?ModPath='.$ModPath.'&amp;ModStart='.$ModStart.'';
	$ThisRedo = 'modules.php?ModPath='.$ModPath.'&ModStart=calendrier';
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
				lieu($lettre, $niv);
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