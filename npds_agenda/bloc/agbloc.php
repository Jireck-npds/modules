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
   global $language, $user, $cookie, $Default_Theme, $nuke_url, $NPDS_Prefix, $mois, $annee;
   $ModPath = 'npds_agenda';

   include_once('modules/'.$ModPath.'/lang/agenda-'.$language.'.php');
   require_once('modules/'.$ModPath.'/ag_fonc.php');
   include('modules/'.$ModPath.'/admin/config.php');
   
   settype($Bcla,'string');

// Récupération du jour, mois, et année actuelle
   $Bjour_actuel = date("j", time());
   $Bmois_actuel = date("m", time());
   $Ban_actuel = date("Y", time());
   $Bjour = $Bjour_actuel;

// Si la variable mois n'existe pas, mois et année correspondent au mois et à l'année courante
   if(!isset($_GET["mois"])) {
      $mois = $Bmois_actuel;
      $annee = $Ban_actuel;
   }

// Mois suivant
   $Bmois_suivant = $mois + 1;
   $Ban_suivant = $annee;
   if ($Bmois_suivant == 13) {
      $Bmois_suivant = 1;
      $Ban_suivant = $annee + 1;
   }

   // Mois précédent
   $Bmois_prec = $mois - 1;
   $Ban_prec = $annee;
   if ($Bmois_prec == 0) {
      $Bmois_prec = 12;
      $Ban_prec = $annee - 1;
   }

   // Affichage du mois et année
   $Bmois_de_annee = 
   array(
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
   $Bmois_en_clair = $Bmois_de_annee[$mois - 1];

   // Création tableau à 31 entrées sans réservation
   for($j = 1; $j < 32; $j++) {
      $Btab_jours[$j] = (bool)false;
      $Bafftitre[$j] = (bool)false;
   }

   // Requête pour récupérer les évévements
   $requete = sql_query("SELECT
         us.date,
         ut.titre, ut.groupvoir
      FROM
         ".$NPDS_Prefix."agend us,
         ".$NPDS_Prefix."agend_dem ut
      WHERE
         YEAR(us.date) = '$annee'
         AND MONTH(us.date) = '$mois'
         AND us.liaison = ut.id
         AND ut.valid = '1'");

   // Récupére les jours fériés
      foreach (ferie ($mois, $annee) as $Bday => $Bfete) {
         $Btab_jours[$Bday] = 1;
         $Bfetetitre[$Bday] = $Bfete.'&lt;br /&gt;';
      }
   // Affiche résultat
   while(list($Bdate, $Btitre, $Bgroupvoir) = sql_fetch_row($requete)) {
      // Si membre appartient au bon groupe
      if(autorisation($Bgroupvoir)) {
         $Btitre = stripslashes(aff_langue($Btitre));
         // Transforme aaaa/mm/jj en jj
         $Bjour_reserve = (int)substr($Bdate, 8, 2);
         // Insertion des jours réservés dans le tableau
         $Btab_jours[$Bjour_reserve] = (bool)true;
         // Récupére titre des événements
//      if(array_key_exists($Bjour_reserve, $Bafftitre))
         $Bafftitre[$Bjour_reserve] .= $Btitre.'&lt;br /&gt;';
      }
   }

   // Vérifie qu'adresse n'est pas modules.php (fin ajout)
   $Brest = substr($_SERVER['REQUEST_URI'], -11);
   $Brest1 = "modules.php";
   if ($Brest == $Brest1)
      $Bpagin = $nuke_url.'modules.php?ModPath='.$ModPath.'&amp;ModStart=calendrier';
   else
      $Bpagin = $_SERVER['REQUEST_URI'];

   // Vérifie si un ? nest pas déjà présent
   $Bpos = strpos($Bpagin, "?");
   if ($Bpos === false) $Bliais = '?&amp;';
   else $Bliais = '&amp;';

   $content = '
   <p class="text-center"><a href="'.$Bpagin.''.$Bliais.'mois='.$Bmois_prec.'&amp;annee='.$Ban_prec.'" class="mr-2"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
      <a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=calendrier&amp;month='.$mois.'&amp;an='.$annee.'"><span class="badge badge-secondary">'.$Bmois_en_clair.'&nbsp;'.$annee.'</span></a>
      <a href="'.$Bpagin.''.$Bliais.'mois='.$Bmois_suivant.'&amp;annee='.$Ban_suivant.'" class="ml-2"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
   </p>
   <table class="table table-bordered table-sm">
      <thead class="thead-default">
         <tr>
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
   <tr>';

   // Détection du 1er et dernier jour du mois
   $Bnombre_date = mktime(0,0,0, $mois, 1, $annee);
   $Bpremier_jour = date('w', $Bnombre_date);
   $Bdernier_jour = 28;
   while (checkdate($mois, $Bdernier_jour + 1, $annee)) {
      $Bdernier_jour++;
   }
   $Bsdate = "01/$mois/$annee";
   $BsEngDate = substr ($Bsdate, -4).substr ($Bsdate, 3, 2).substr ($Bsdate, 0, 2);
   $BiTime = strtotime ($BsEngDate);

   // Si premier jour dimanche (code "0" en php)
   if ($Bpremier_jour == 0) {
      // Boucle pour les 6 premieres colonnes/jours
      for ($Bdebutdimanche = 1; $Bdebutdimanche <= 6; $Bdebutdimanche++) {
         // Si case calendrier vide
         $content .= '
         <td class="text-center">&nbsp;</td>';
      }

   // Permet la navigation du calendrier
      $Bdate = ajout_zero(01, $mois, $annee);

   // Met en rouge ce jour
      if (01 == $Bjour && $mois == $Bmois_actuel && $annee == $Ban_actuel) {$Bcs = 'text-danger font-weight-bold';}else{$Bcs = 'text-muted';}
      
   // Si ce premier dimanche est réservé
      if($Btab_jours[1]) {

   // Si jour férié sans événement
         if ($Bafftitre[$Btab_jours[1]] == '' && $Bfetetitre[$Btab_jours[1]] != '') $Bcla = 'table-warning';
         else if ($Bafftitre[$Btab_jours[1]] != '' && $Bfetetitre[$Btab_jours[1]] == '') $Bcla = 'table-info';
         else if ($Bafftitre[$Btab_jours[1]] != '' && $Bfetetitre[$Btab_jours[1]] != '') $Bcla = 'table-info';
         /*Ajoute le jour et reste sur la meme page + css jour evenement*/
         $content .= '<td class="text-center '.$Bcla.'">'
         .'<a class="" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=calendrier&amp;month='.$mois.'&amp;an='.$annee.'" data-toggle="tooltip" data-placement="bottom" title="'.aff_langue($Bfetetitre[$Btab_jours[1]]).''.$Bafftitre[1].'"><span class="'.$Bcs.'">1</span></a>'
         .'</td>';
      }
      else
      {
   // css jour libre
         $content .= '
         <td class="text-center"><span class="'.$Bcs.'">1</span></td>';
      }
      $content .= '
      </tr>
      <tr>';
   }

   // 7 premiers jour du mois
   for ($i = 1; $i < 8; $i++) {
      // Si case calendrier vide
      if ($i < $Bpremier_jour)
         $content .= '
         <td class="text-center">&nbsp;</td>';
      else {
         // Case avec class pour réserver
         $Bce_jour = ($i + 1) - $Bpremier_jour;
         // Permet la navigation du calendrier
         $Bdate = ajout_zero($Bce_jour, $mois, $annee);
         // Met en rouge ce jour
         if ($Bce_jour == $Bjour && $mois == $Bmois_actuel && $annee == $Ban_actuel) {$Bcs = 'text-danger font-weight-bold';}else{$Bcs = 'text-muted';}
         if($Btab_jours[$Bce_jour]) {
            // Si jour férié sans événement
            if (!array_key_exists($Bce_jour,$Bafftitre) && $Bfetetitre[$Bce_jour] != '') $Bcla = 'table-warning';
            else if ($Bafftitre[$Bce_jour] != '' && !array_key_exists($Bce_jour,$Bfetetitre) ) $Bcla = 'table-info';
            else if ($Bafftitre[$Bce_jour] != '' && $Bfetetitre[$Bce_jour] != '') $Bcla = 'table-info';

            // Ajoute le jour et reste sur la même page + css jour événement
            $content .= '
            <td class="text-center '.$Bcla.'"><a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=calendrier&amp;month='.$mois.'&amp;an='.$annee.'" data-toggle="tooltip" data-html="true" data-placement="bottom" title="';
            if(array_key_exists($Bce_jour,$Bfetetitre))
               $content .= aff_langue($Bfetetitre[$Bce_jour]);
            if(array_key_exists($Bce_jour,$Bafftitre))
               $content .=$Bafftitre[$Bce_jour];
            $content .='"><span class="'.$Bcs.'">'.$Bce_jour.'</span></a></td>';
         }
         else {
            //css libre
            $content .= '
            <td class="text-center"><span class="'.$Bcs.'">'.$Bce_jour.'</span></td>';
         }
      }
   }

   // Affichage fin du calendrier
   $Bjour_suiv = ($i + 1) - $Bpremier_jour;
   for ($Brangee = 0; $Brangee <= 3; $Brangee++) {
      $content .= '
      </tr>
      <tr>';
      for ($i = 1; $i < 8; $i++) {
         if($Bjour_suiv > $Bdernier_jour) {
            // Case avec class pour vide
            $content .= '
         <td class="text-center">&nbsp;</td>';
         }
         else {
            // Permet la navigation du calendrier
            $Bdate = ajout_zero($Bjour_suiv, $mois, $annee);

            // Met en rouge ce jour
            if ($Bjour_suiv == $Bjour && $mois == $Bmois_actuel && $annee == $Ban_actuel) {$Bcs = 'text-danger font-weight-bold';}else{$Bcs = 'text-muted';}

            // Case avec class pour réserver
            if($Btab_jours[$Bjour_suiv]) {
               // Si jour ferie sans événement
               if (!array_key_exists($Bjour_suiv,$Bafftitre) and $Bfetetitre[$Bjour_suiv] != '') $Bcla = 'table-warning';
               else if ($Bafftitre[$Bjour_suiv] != '' ) $Bcla =  'table-info';
               else if ($Bafftitre[$Bjour_suiv] != '' && $Bfetetitre[$Bjour_suiv] != '') $Bcla = 'table-info';

               // Ajoute le jour et reste sur la même page + css jour événement
               $content .= '
               <td class="text-center '.$Bcla.'"><a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=calendrier&subop=jour&date='.$Bdate.'" data-toggle="tooltip" data-placement="bottom" data-html="true" title="';
               if(isset($Bfetetitre) and array_key_exists($Bjour_suiv,$Bfetetitre))
                  $content .= aff_langue($Bfetetitre[$Bjour_suiv]);
               if(array_key_exists($Bjour_suiv,$Bafftitre))
                  $content .= $Bafftitre[$Bjour_suiv];
               $content .= '"><span class="'.$Bcs.'">'.$Bjour_suiv.'</span></a></td>';
            }
            else {
               //css libre
               $content .= '
               <td class="text-center"><span class="'.$Bcs.'">'.$Bjour_suiv.'</span></td>';
            }
         }
         $Bjour_suiv++;
      }
   }
   $content .= '
   </tr>
   </tbody>
   </table>';

   // Si membre appartient au bon groupe
   if(autorisation($gro)) {
      $content .= '
      <p>
         <a class="btn btn-block btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=agenda_add"><i class="fa fa-plus" aria-hidden="true"></i> '.ag_translate('Proposer événement').'</a>
      </p>';
   }
   $content .= '
   <table>
   <tr>
   <td class="table-info" width="20px"></td>
   <td class="pl-2">'.ag_translate('Jour avec événement(s)').'</td>
   </tr>
   <tr>
   <td class="table-warning"></td>
   <td class="pl-2">'.ag_translate('Jour férié').'</td>
   </tr>
   </table>';
   if(autorisation(-127))
      $content .= '
   <div class="mt-2 text-right">
      <a href="admin.php?op=Extend-Admin-SubModule&amp;ModPath=npds_agenda&amp;ModStart=admin/adm" title="Admin" data-toggle="tooltip"><i id="cogs" class="fa fa-cogs fa-lg"></i></a>
   </div> ';
?>