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
/*
$ModPath ='npds_agenda';
global $ModPath;
*/
// Transforme date (aaa-mm-jj) en deux variables $mois (mm) et $an (aa)
function convertion($date) {

// Récupère les 2 caractères après le 5eme caractère de $ date (aaaa-mm-jj donne mm)
   $mois = substr($date, 5, 2);

// Récupère les 4 premiers caratères de $ date (aaaa-mm-jj donne aaaa)
   $an  = substr($date, 0, 4);

// On retourne un tableau contenant les deux variables
   return array( $mois, $an);
}

// Date au format aaaa-mm-jj et rajoute 0 quand inferieur a 10
function ajout_zero($jj, $mm, $aa) {

// Ajoute un 0 pour jour
   if($jj <= 9 && substr($jj, 0, 1)!= 0)
      $jj  = '0'.$jj;

// Ajoute un 0 pour mois
   if($mm <= 9 && substr($mm, 0, 1)!= 0)
      $mm  = '0'.$mm;

// Retourne sous la forme aaaa-mm-jj
   $retour = (string)$aa.'-'.$mm.'-'.$jj;
   return $retour;
}

// Retourne la date au format français
function formatfrancais($time) {
   $tab = explode("-",$time);
   $nouvelledate = $tab[2]."-".$tab[1]."-".$tab[0];
   return $nouvelledate;
}

// Calcul pour les fêtes mobiles
function easter_date2($Year) {
   $G = $Year % 19;
   $C = (int)($Year / 100);
   $H = (int)($C - ($C / 4) - ((8*$C+13) / 25) + 19*$G + 15) % 30;
   $I = (int)$H - (int)($H / 28)*(1 - (int)($H / 28)*(int)(29 / ($H + 1))*((int)(21 - $G) / 11));
   $J = ($Year + (int)($Year/4) + $I + 2 - $C + (int)($C/4)) % 7;
   $L = $I - $J;
   $m = 3 + (int)(($L + 40) / 44);
   $d = $L + 28 - 31 * ((int)($m / 4));
   $y = $Year;
   $E = mktime(0, 0, 0, $m, $d, $y);
   return $E;
}

// Calcul les jours fériés
function ferie($mois, $an) {

/* pour avoir tous les jours fériés de l'année,
   passez un tableau de mois (férié(range(1, 12), $an);
   pour les avoir sur plusieurs années
   férié(range(1, 24), $an); férié(range(36, 12), $an);*/
   if (is_array($mois))
   {
      $retour = array();
      foreach ($mois as $m)
      {
         $r = ferie($m, $an);
         $retour[$m] = ferie($m, $an);
      }
      return $retour;
   }

// Calcul des jours fériés pour un seul mois.
   if (mktime(0, 0, 0, $mois, 1, $an) == -1)
   {
      return FALSE;
   }
   list($mois, $an) = explode("-", date("m-Y", mktime(0, 0, 0, $mois, 1, $an)));
   $an = intval($an);
   $mois = intval($mois);

// Une constante
   $jour = 3600*24;
   
// Quelques fêtes mobiles
   $lundi_de_paques['mois'] = date( "n", easter_date2($an)+1*$jour);
   $lundi_de_paques['jour'] = date( "j", easter_date2($an)+1*$jour);
   $lundi_de_paques['nom'] = ag_translate('Lundi de Pâques');
   $ascencion['mois'] = date( "n", easter_date2($an)+39*$jour);
   $ascencion['jour'] = date( "j", easter_date2($an)+39*$jour);
   $ascencion['nom'] = ag_translate('Jeudi de l\'ascension');
   $vendredi_saint['mois'] = date( "n", easter_date2($an)-2*$jour);
   $vendredi_saint['jour'] = date( "j", easter_date2($an)-2*$jour);
   $vendredi_saint['nom'] = ag_translate('Vendredi Saint');
   $lundi_de_pentecote['mois'] = date( "n", easter_date2($an)+50*$jour);
   $lundi_de_pentecote['jour'] = date( "j", easter_date2($an)+50*$jour);
   $lundi_de_pentecote['nom'] = ag_translate('Lundi de Pentecôte');

// France
   $ferie[ag_translate('Jour de l\'an')][1] = 1;
   $ferie[ag_translate('Armistice 39-45')][5] = 8;
   $ferie[ag_translate('Toussaint')][11] = 1;
   $ferie[ag_translate('Armistice 14-18')][11] = 11;
   $ferie[ag_translate('Assomption')][8] =15;
   $ferie[ag_translate('Fête du travail')][5] =1;
   $ferie[ag_translate('Fête nationale')][7] =14;
   $ferie[ag_translate('Noël')][12] = 25;
   $ferie[$lundi_de_paques['nom']][$lundi_de_paques['mois']] = $lundi_de_paques['jour'];
   $ferie[$lundi_de_pentecote['nom']][$lundi_de_pentecote['mois']] = $lundi_de_pentecote['jour'];
   $ferie[$ascencion['nom']][$ascencion['mois']] = $ascencion['jour'];
   $vendredi_saint['jour'];
   
// Réponse
   $reponse = array();
   while(list($nom, $date) = each($ferie))
   {
      if (isset($date[$mois]))
      {
         
// Une fête à date calculable
         $reponse[$date[$mois]]=$nom;
      }
   }
   ksort($reponse);
   return $reponse;
}

// le mois en texte
function mois($nb) {
   $key = $nb - 1;
   $ap = array(
      ag_translate('Janvier'),
      ag_translate('Février'),
      ag_translate('Mars'),
      ag_translate('Avril'),
      ag_translate('Mai'),
      ag_translate('Juin'),
      ag_translate('Juillet'),
      ag_translate('Août'),
      ag_translate('Septembre'),
      ag_translate('Octobre'),
      ag_translate('Novembre'),
      ag_translate('Décembre'));
   return $ap[$key];
}

// construction calendrier visualisation
function calend($an, $month, $calblock) {
   global $ModPath, $NPDS_Prefix, $ThisFile;
   $p_m='month';$p_a='an';
   if ($calblock==1) { 
      $ThisFile=$_SERVER['REQUEST_URI'];
       $p_m='b_mois';
       $p_a='b_an';
      //var_dump($debug);
      }
   $output='';
   $jour_actuel = date("j", time());
   $mois_actuel = date("m", time());
   $an_actuel = date("Y", time());
   //Si la variable mois nexiste pas, mois et annee correspondent au mois et a lannee courante
/*
   if(!isset($_GET["month"])) {
      $month = $mois_actuel;
      $an = $an_actuel;
   }
*/
   //Creation des tableaux
   for($j = 1; $j < 32; $j++) {
      $tab_jours[$j] = (bool)false;
      $afftitre[$j] = (bool)false;
      $tab_jours_ferie[$j] = (bool)false;
      $fetetitre[$j] = (bool)false;
   }

   //Requete recupere evenement
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
   //Recupere les jours feries
   foreach (ferie ($month, $an) as $day => $fete) {
      $tab_jours_ferie[$day] = 1;
      $fetetitre[$day] = $fete.'&lt;br /&gt;';
   }
   while(list($date, $titre, $groupvoir) = sql_fetch_row($requete)) {
      //Si membre appartient au bon groupe
      if(autorisation($groupvoir)) {
         $titre = stripslashes(aff_langue($titre));
         //Transforme aaaa/mm/jj en jj
         $jour_reserve = (int)substr($date, 8, 2);
         //Insertion des jours reserve dans le tableau
         $tab_jours[$jour_reserve] = (bool)true;
         //Recupere titre des evenements
         $afftitre[$jour_reserve] .= $titre.'&lt;br /&gt;';
      }
   }

   $nbjour = cal_days_in_month( CAL_GREGORIAN, $month, $an); // nombre de jour dans le mois
   $m_prec=($month-1); $m_suiv=($month+1);
   $a_prec=$an; $a_suiv=$an;
   if($month==1) {$m_prec=12;$a_prec=$an-1;};
   if($month==12) {$m_suiv=1;$a_suiv=$an+1;};

   $output .= '
   <p class="text-center">
      <a class="btn btn-outline-secondary btn-sm border-0" href="'.$ThisFile.'&amp;'.$p_m.'='.$m_prec.'&amp;'.$p_a.'='.$a_prec.'"><i class="fa fa-chevron-left align-middle"></i></a>
      <a class="btn btn-outline-secondary btn-sm border-0" href="modules.php?ModPath=npds_agenda&ModStart=calendrier&amp;month='.$month.'&amp;an='.$an.'">'.mois($month).'</a>
      <a class="btn btn-outline-secondary btn-sm border-0" href="'.$ThisFile.'&amp;'.$p_m.'='.$m_suiv.'&amp;'.$p_a.'='.$a_suiv.'"><i class="fa fa-chevron-right align-middle"></i></a><br />
      <a class="btn btn-outline-secondary btn-sm border-0 mt-1" href="modules.php?ModPath=npds_agenda&amp;ModStart=annee&amp;an='.$an.'">'.$an.'</a>
  </p>
   <table class="table table-bordered table-sm">
      <thead class="table-secondary">
         <tr >
            <th class="text-center">'.ag_translate('L').'</th>
            <th class="text-center">'.ag_translate('M').'</th>
            <th class="text-center">'.ag_translate('M').'</th>
            <th class="text-center">'.ag_translate('J').'</th>
            <th class="text-center">'.ag_translate('V').'</th>
            <th class="text-center">'.ag_translate('S').'</th>
            <th class="text-center">'.ag_translate('D').'</th>
         </tr>
      </thead>
      <tbody>';
   for($i = 1; $nbjour >= $i; $i++) {
      $date = ajout_zero($i, $month, $an);
      settype($jour_actuel,'integer');
      $cs='';
      if ($i == $jour_actuel and $month == $mois_actuel and $an == $an_actuel) $cs = 'text-danger font-weight-bold';
      if ($tab_jours[$i] == 1 and $tab_jours_ferie[$i] == 1){
         $cla='table-warning'; 
         $lk='<a href="modules.php?ModPath=npds_agenda&amp;ModStart=calendrier&amp;subop=jour&amp;date='.$date.'"><span data-toggle="tooltip" data-placement="bottom" data-html="true" title="'.$fetetitre[$i].$afftitre[$i].'" style="padding:1px;" class="small d-block table-info '.$cs.'" >'.$i.'</span></a>';
      } else if($tab_jours[$i] == 1) {
         $cla='table-info';
         $lk='<a href="modules.php?ModPath=npds_agenda&amp;ModStart=calendrier&amp;subop=jour&amp;date='.$date.'"><span data-toggle="tooltip" data-placement="bottom" data-html="true" title="'.$afftitre[$i].'" style="padding:1px;" class="small d-block '.$cs.'">'.$i.'</span></a>';
      } else if($tab_jours_ferie[$i] == 1) {
         $cla='table-warning';
         $lk='<span data-toggle="tooltip" data-placement="bottom" data-html="true" title="'.$fetetitre[$i].'" style="padding:1px;"class="small d-block '.$cs.'">'.$i.'</span>';
      }  
      else {
         $cla='';
         $lk='<span class="small d-block '.$cs.'">'.$i.'</span>';
      }

      $p = cal_to_jd(CAL_GREGORIAN, $month, $i, $an); // formater jour
      $jourweek = jddayofweek($p); // jour de la semaine
      if($i == $nbjour) {
         if($jourweek == 1)
            $output .= '
         <tr>';
         $output .= '
            <td class="'.$cla.' text-center">'.$lk.'</td>
         </tr>';
      }
      else if($i == 1) {
         $output .= '
      <tr>';
         if($jourweek == 0)
            $jourweek = 7;
         for($b = 1 ;$b != $jourweek; $b++) {
            $output .= '
         <td></td>';
         }
         $output .= '
         <td class="'.$cla.' text-center">'.$lk.'</td>';
         if($jourweek == 7)
            $output .= '
      </tr>';
      } else {
         if($jourweek == 1)
            $output .= '
      <tr>';
         $output .= '
         <td class="'.$cla.' text-center">'.$lk.'</td>';
         if($jourweek == 0)
            $output .= '
      </tr>';
      }
   }
   $output .= '
      </tbody>
   </table>';
   return $output;
}

//construction calendrier sélection 
function cal($an, $month, $debut, $morurl) {
   global $ModPath, $ThisFile, $ModStart;
   $debut = removeHack($debut);

   $output='';
   $jour_actuel = date("j", time());
   $mois_actuel = (integer)date("m", time());
   $an_actuel = (integer)date("Y", time());
   //Si la variable mois nexiste pas, mois et annee correspondent au mois et a lannee courante

   if(!isset($_GET["month"])) {
      $month = $mois_actuel;
      $an = $an_actuel;
   } else { 
      $month=$_GET["month"];
      $an=$_GET["an"];
   }

   settype($month,'integer');
   settype($an,'integer');

   $nbjour = cal_days_in_month( CAL_GREGORIAN, $month, $an); // nombre de jour dans le mois
   $m_prec=($month-1); $m_suiv=($month+1);
   $a_prec=$an; $a_suiv=$an;
   if($month==1) {$m_prec=12;$a_prec=$an-1;};
   if($month==12) {$m_suiv=1;$a_suiv=$an+1;};

   $output .= '
   
   <p class="text-center">
      <a class="btn btn-outline-secondary btn-sm border-0" href="'.$ThisFile.$morurl.'&amp;month='.$m_prec.'&amp;an='.$a_prec.'&amp;debut='.$debut.'"><i class="fa fa-chevron-left align-middle"></i></a>
      <a class="btn btn-outline-secondary btn-sm border-0" href="'.$ThisFile.$morurl.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$debut.'">'.mois($month).'</a>
      <a class="btn btn-outline-secondary btn-sm border-0" href="'.$ThisFile.$morurl.'&amp;month='.$m_suiv.'&amp;an='.$a_suiv.'&amp;debut='.$debut.'"><i class="fa fa-chevron-right align-middle"></i></a><br />
      <a class="btn btn-outline-secondary btn-sm border-0" href="'.$ThisFile.$morurl.'&amp;month='.$month.'&amp;an='.($an-1).'&amp;debut='.$debut.'"><i class="fa fa-chevron-left align-middle"></i></a>
      <a class="btn btn-outline-secondary btn-sm border-0 mt-1" href="'.$ThisFile.$morurl.'&amp;month='.$mois_actuel.'&amp;an='.$an_actuel.'&amp;debut='.$debut.'">'.$an.'</a>
      <a class="btn btn-outline-secondary btn-sm border-0" href="'.$ThisFile.$morurl.'&amp;month='.$month.'&amp;an='.($an+1).'&amp;debut='.$debut.'"><i class="fa fa-chevron-right align-middle"></i></a>
   </p>
   <table class="table table-bordered table-sm">
      <thead class="table-dark">
         <tr >
            <th class="text-center">'.ag_translate('Sem').'</th>
            <th class="text-center">'.ag_translate('L').'</th>
            <th class="text-center">'.ag_translate('M').'</th>
            <th class="text-center">'.ag_translate('M').'</th>
            <th class="text-center">'.ag_translate('J').'</th>
            <th class="text-center">'.ag_translate('V').'</th>
            <th class="text-center">'.ag_translate('S').'</th>
            <th class="text-center">'.ag_translate('D').'</th>
         </tr>
      </thead>
      <tbody>';
   for($i = 1; $nbjour >= $i; $i++) {
      $date = ajout_zero($i, $month, $an);
      settype($jour_actuel,'integer');
      $cs='';
      if ($i == $jour_actuel and $month == $mois_actuel and $an == $an_actuel) $cs = 'text-danger font-weight-bold';

      if ($debut == '')
         $newlien = $date;
      else
         $newlien = $debut.','.$date;
         //Ajoute le jour et reste sur la meme page + css jour libre
         $pos = strpos($debut, $date);
         if ($pos === false) {
            $lk = '<a class="btn btn-outline-primary btn-sm w-100" href="'.$ThisFile.$morurl.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">'.$i.'</a>';
            $cla='table-primary';
         } else {
            $lk= '<span class="d-block w-100 border rounded '.$cs.'" data-toggle="tooltip" data-placement="bottom" title="Réservée">'.$i.'</span>';
            $cla='table-light';
         }

         $sem_num = date('W', strtotime($date));

      $p = cal_to_jd(CAL_GREGORIAN, $month, $i, $an); // formater jour
      $jourweek = jddayofweek($p); // jour de la semaine
      if($i == $nbjour) {
         if($jourweek == 1)
            $output .= '
         <tr>
            <td class="table-dark text-center">'.$sem_num.'</td>';
         $output .= '
            <td class="'.$cla.' text-center">'.$lk.'</td>
         </tr>';
      }
      else if($i == 1) {
         $output .= '
      <tr>
         <td class="table-dark text-center">'.$sem_num.'</td>';
         if($jourweek == 0)
            $jourweek = 7;
         for($b = 1 ;$b != $jourweek; $b++) {
            $output .= '
         <td></td>';
         }
         $output .= '
         <td class="'.$cla.' text-center">'.$lk.'</td>';
         if($jourweek == 7)
            $output .= '
      </tr>';
      } else {
         if($jourweek == 1)
            $output .= '
      <tr>
         <td class="table-dark text-center">'.$sem_num.'</td>';
         $output .= '
         <td class="'.$cla.' text-center">'.$lk.'</td>';
         if($jourweek == 0)
            $output .= '
      </tr>';
      }
   }
   $output .= '
      </tbody>
   </table>';
   return $output;
}

// menu
function suj() {
   global $NPDS_Prefix, $ModPath, $theme, $bouton, $ThisRedo, $ThisFile, $gro, $stopicid;
   //debut theme html partie 1/2
   settype($ajeven,'string');
   $inclusion = "modules/".$ModPath."/html/sujet.html";
   //fin theme html partie 1/2
   //Si membre appartient au bon groupe
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
   <option>'.ag_translate('Accès catégorie(s)').'</option>';

   //Requete liste sujet
   $result = sql_query("SELECT topicid, topictext FROM ".$NPDS_Prefix."agendsujet ORDER BY topictext ASC");
   while(list($stopicid, $topictext) = sql_fetch_row($result)) {
      $topictext = stripslashes(aff_langue($topictext));
      $accesuj .= '<option value="'.$stopicid.'">'.$topictext.'</option>';
   }
   if($bouton == '1')
      $rech = ag_translate('Par ville');
   else
      $rech = ag_translate('Par').' '.$bouton;
   $accesuj .= '</select></li>';
   
// fin Accès direct à un sujet

   $vuannu ='<li class="nav-item">
            <a class="nav-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=annee">'.ag_translate('Vue annuelle').'</a>
            </li>';
   $vulieu ='<li class="nav-item">
            <a class="nav-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=lieu">'.$rech.'</a>
            </li>';

   //debut theme html partie 2/2
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
   $men = meta_lang(aff_langue(preg_replace(array_keys($npds_METALANG_words),array_values($npds_METALANG_words), $Xcontent)));
   return $men;
//fin theme html partie 2/2
}

?>