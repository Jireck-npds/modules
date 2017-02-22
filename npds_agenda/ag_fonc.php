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

// Transforme date (aaa-mm-jj) en deux variables $mois (mm) et $an (aa)
function convertion($date)
{

// Récupère les 2 caractères après le 5eme caractère de $ date (aaaa-mm-jj donne mm)
   $mois = substr($date, 5, 2);

// Récupère les 4 premiers caratères de $ date (aaaa-mm-jj donne aaaa)
   $an  = substr($date, 0, 4);

// On retourne un tableau contenant les deux variables
   return array( $mois, $an);
}
// Date au format aaaa-mm-jj et rajoute 0 quand inferieur a 10
function ajout_zero($jj, $mm, $aa)
{

// Ajoute un 0 pour jour
   if($jj <= 9 && substr($jj, 0, 1)!= 0)
   {
      $jj  = '0'.$jj;
   }

// Ajoute un 0 pour mois
   if($mm <= 9 && substr($mm, 0, 1)!= 0)
   {
      $mm  = '0'.$mm;
   }

// Retourne sous la forme aaaa-mm-jj
   $retour = (string)$aa.'-'.$mm.'-'.$jj;
   return $retour;
}

// Retourne la date au format français
function formatfrancais($time)
{
   $tab = explode("-",$time);
   $nouvelledate = $tab[2]."-".$tab[1]."-".$tab[0];
   return $nouvelledate;
}

// Calcul pour les fêtes mobiles
function easter_date2($Year)
{
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
function ferie($mois, $an)
{

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




?>