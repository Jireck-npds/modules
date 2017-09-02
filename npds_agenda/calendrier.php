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

// DEBUT FONCTION LISTE SUJET
function suj() {
   global $NPDS_Prefix, $ModPath, $theme, $bouton, $ThisRedo, $ThisFile, $gro, $stopicid;
/*debut theme html partie 1/2*/

$inclusion = "modules/".$ModPath."/html/sujet.html";

/*fin theme html partie 1/2*/

/*Si membre appartient au bon groupe*/
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

/*Requete liste sujet*/
   $result = sql_query("SELECT topicid, topictext FROM ".$NPDS_Prefix."agendsujet ORDER BY topictext ASC");
   while(list($stopicid, $topictext) = sql_fetch_row($result))
   {
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
   settype($niv,"integer");
   settype($sup,"integer");//à voir cohérence
   settype($inf,"integer");//à voir cohérence


// DEBUT LISTE EVENEMENT
function listsuj($sujet, $niv) {
   global $NPDS_Prefix, $ModPath, $theme, $cookie, $ThisFile, $nb_news, $tipath, $page;
   /*Debut securite*/
   settype($sujet,"integer");
   settype($niv,"integer");
   settype($page,"integer");
   settype($cs1,"string");
   settype($sup,"integer");
   settype($inf,"integer");
   settype($datepourmonmodal,"string");

   /*Fin securite*/
   require_once('modules/'.$ModPath.'/pag_fonc.php');
   suj();
//debut theme html partie 1/2
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
   while(list($groupvoir) = sql_fetch_row($req1)) {
      if(autorisation($groupvoir)) $sup++;
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
   while(list($groupvoir) = sql_fetch_row($req1)) {
      if(autorisation($groupvoir)) $inf++;
   }
   if ($sup == ''){$sup = '0';}
   if ($inf == ''){$inf = '0';}
   if($niv == '0') {
      $cs = 'class="text-danger"';
      $nb_entrees = $sup;
      $cond = "date >= '$now'";
   }
   else if($niv == '1') {
      $cs1 = 'class="text-danger"';
      $nb_entrees = $inf;
      $cond = "date < '$now'";
   }

/*Pour la navigation*/
   $total_pages = ceil($nb_entrees/$nb_news);
   if($page == 1) {
      $page_courante = 1;
   } 
   else {
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
   if ($sup == '0' && $inf == '0') {
      $affres = '<p><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Vide').'</p>';
   }
   else {
      $affres = '<ul><li>'.ag_translate('Evénement(s) à venir').' <a data-toggle="tooltip" data-placement="bottom" title="Visualiser" href="'.$ThisFile.'&amp;subop=listsuj&amp;sujet='.$sujet.'&amp;niv=0" '.$cs.'><span class="badge badge-success">'.$sup.'</span></a></li>
      <li>'.ag_translate('Evénement(s) en cours ou passé(s)').' <a data-toggle="tooltip" data-placement="bottom" title="Visualiser" href="'.$ThisFile.'&amp;subop=listsuj&amp;sujet='.$sujet.'&amp;niv=1" '.$cs1.'><span class="badge badge-secondary">'.$inf.'</span></a></li></ul>';

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
      while(list($id, $date, $liaison, $titre, $intro, $descript, $lieu, $posteur, $groupvoir) = sql_fetch_row($result)) {
         $titre = stripslashes(aff_langue($titre));
         $intro = stripslashes(aff_langue($intro));
         $lieu = stripslashes(aff_langue($lieu));
         /*Si membre appartient au bon groupe*/
         if(autorisation($groupvoir)) {
         /*Si evenement plusieurs jours*/
            $result1 = sql_query("SELECT date FROM ".$NPDS_Prefix."agend WHERE liaison = '$liaison' ORDER BY date DESC");
            $tot = sql_num_rows($result1);

            $affres .= '
            <div class="card my-3">
                <div class="card-body">
                  <h4 class="card-title">'.$titre.'</h4>
                  <p class="card-text">';
            if ($tot > 1) {
               $affres .= '<i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Cet événement dure plusieurs jours').'</p>';
               while (list($ddate) = sql_fetch_row($result1)) {
                  if($ddate > $now) $etat = 'badge badge-success';
                  else if($ddate == $now) $etat = 'badge badge-warning';
                  else if($ddate < $now) $etat = 'badge badge-warning';
                  $newdate = formatfrancais($ddate);
                  $affres .= '<div class="'.$etat.' mr-2 mb-2">'.$newdate.'</div>';
                  $datepourmonmodal .= '<span class="'.$etat.'">'.$newdate.'</span>';
               }
            }
            else {
               list($ddate) = sql_fetch_row($result1);
               $newdate = formatfrancais($ddate);
               if($ddate > $now) $etat = 'badge badge-success';
               else if($ddate == $now){$etat = 'badge badge-warning';}
               else if($ddate < $now){$etat = 'badge badge-warning';}
               $affres .= '<i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Cet événement dure 1 jour').'</p>';
               $affres .= '<div class="'.$etat.' mr-2 mb-2">'.$newdate.'</div>';
            }
            $affres .= '
            <div class="row">
               <div class="col-md-2">'.ag_translate('Résumé').'</div>
               <div class="col-md-10">'.$intro.'</div>
            </div>
            <div class="row">
               <div class="col-md-2">'.ag_translate('Lieu').'</div>
               <div class="col-md-10">'.$lieu.'</div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <button type="button" class="btn btn-secondary btn-sm my-2" data-toggle="modal" data-target="#'.$id.'">'.ag_translate('Voir la fiche').'</button>
                  <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                     <div class="modal-dialog modal-lg"" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h4 class="modal-title" id="'.$id.'Label">'.$titre.'</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                           </div>
                           <div class="modal-body">
                              <h5 class="'.$etat.'"><strong>';
            if ($tot > 1)
               $affres .= $datepourmonmodal;
            else
               $affres .= $newdate;
            $affres .= '</strong></h5>
                              <div class="row">
                                 <div class="col-md-2">'.ag_translate('Résumé').'</div>
                                 <div class="col-md-10">'.$intro.'</div>
                              </div>
                              <div class="row">
                                 <div class="col-md-2">'.ag_translate('Description').'</div>
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
               </div>
            </div>
            <p class="card-text">';
            if ($posteur == $cookie[1])
               $affres .= '
               <a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=editevt&amp;id='.$liaison.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
               <a class="btn btn-outline-danger btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=suppevt&amp;id='.$liaison.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            else
               $affres .= ag_translate('Posté par').' '.$posteur;
            $affres .= '
            </p>
         </div>
      </div>';
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
   $npds_METALANG_words = array("'!topictext!'i"=>"$topictext","'!affres!'i"=>"$affres");
   echo meta_lang(aff_langue(preg_replace(array_keys($npds_METALANG_words),array_values($npds_METALANG_words), $Xcontent)));
   /*fin theme html partie 2/2*/

}
/// FIN LISTE EVENEMENT ///

/// DEBUT CALENDRIER ///
function calend($an, $month) {
   global $ModPath, $NPDS_Prefix, $theme;
   global $ThisFile,$affcal;

   /*Debut securite*/
   settype($an,"integer");
   settype($month,"integer");
   $afftitre=array();
   /*Fin securite*/

   /*Recuperation du jour, mois, et annee actuel*/
   $jour_actuel = date("j", time());
   $mois_actuel = date("m", time());
   $an_actuel = date("Y", time());
   $jour = $jour_actuel;

   /*Si la variable mois nexiste pas, mois et annee correspondent au mois et a lannee courante*/
   if(!isset($_GET["month"])) {
      $month = $mois_actuel;
      $an = $an_actuel;
   }

   /*Mois suivant*/
   $mois_suivant = $month + 1;
   $an_suivant = $an;
   if ($mois_suivant == 13) {
      $mois_suivant = 1;
      $an_suivant = $an + 1;
   }

   /*Mois precedent*/
   $mois_prec = $month - 1;
   $an_prec = $an;
   if ($mois_prec == 0) {
      $mois_prec = 12;
      $an_prec = $an - 1;
   }

/*Affichage du mois et annee*/
   $mois_de_annee = array(
         ag_translate('JANVIER'),
         ag_translate('FEVRIER'),
         ag_translate('MARS'),
         ag_translate('AVRIL'),
         ag_translate('MAI'),
         ag_translate('JUIN'),
         ag_translate('JUILLET'),
         ag_translate('AOUT'),
         ag_translate('SEPTEMBRE'),
         ag_translate('OCTOBRE'),
         ag_translate('NOVEMBRE'),
         ag_translate('DECEMBRE'));
   $mois_en_clair = $mois_de_annee[$month - 1];

/*Creation tableau a 31 entrees sans reservation*/
   for($j = 1; $j < 32; $j++) {
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
   foreach (ferie ($month, $an) as $day => $fete) {
      $tab_jours[$day] = 1;
      $fetetitre[$day] = $fete.'&lt;br /&gt;';
   }

/*Affiche resultat*/
   while(list($date, $titre, $groupvoir) = sql_fetch_row($requete)) {
      /*Si membre appartient au bon groupe*/
      if(autorisation($groupvoir)) {
         $titre = stripslashes(aff_langue($titre));
      /*Transforme aaaa/mm/jj en jj*/
         $jour_reserve = (int)substr($date, 8, 2);
      /*Insertion des jours reserve dans le tableau*/
         $tab_jours[$jour_reserve] = (bool)true;
      /*Recupere titre des evenements*/
         $afftitre[$jour_reserve] .= $titre.'&lt;br /&gt;';
      }
   }

   suj();

/*debut theme html partie 1/2*/
   $inclusion = false;
   $inclusion = 'modules/'.$ModPath.'/html/calendrier.html';


/*fin theme html partie 1/2*/
   $naviguation = '<a class="mr-2" href="'.$ThisFile.'&amp;month='.$mois_prec.'&amp;an='.$an_prec.'"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
   <span class="badge badge-secondary">'.$mois_en_clair.' '.$an.'</span>
   <a class="ml-2" href="'.$ThisFile.'&amp;month='.$mois_suivant.'&amp;an='.$an_suivant.'"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>';
   $affcal .= '<tr>';

/*Detection du 1er et dernier jour du mois*/
   $nombre_date = mktime(0,0,0, $month, 1, $an);
   $premier_jour = date('w', $nombre_date);
   $dernier_jour = 28;
   while (checkdate($month, $dernier_jour + 1, $an)) {
      $dernier_jour++;
   }

/*Ajoute un 0 pour mois*/
   if($month <= 9 && substr($month, 0, 1)!= 0) {
      $month  = '0'.$month;
   }
   $sdate = "01/$month/$an";
   $sEngDate = substr ($sdate, -4).substr ($sdate, 3, 2).substr ($sdate, 0, 2);
   $iTime = strtotime ($sEngDate);
   $semaine = date ('W', $iTime);

/*Si premier jour dimanche (code "0" en php)*/
   if ($premier_jour == 0) {

/*Calcul numero semaine +0 pour enlever le 0 de 01,02,...*/
      $semaine0 = $semaine + 0;
      $semaine1 = $semaine + 1;
      $affcal .= '<th scope="row" class="text-center">'.$semaine0.'</th>';

/*Boucle pour les 6 premieres colonnes/jours*/
      for ($debutdimanche = 1; $debutdimanche <= 6; $debutdimanche++)
      {

/*Si case calendrier vide*/
      $affcal .= '<td class="text-center">&nbsp;</td>';
      }

/*Permet la naviguation du calendrier*/
      $date = ajout_zero(01, $month, $an);

/*Met en rouge ce jour*/
      if (01 == $jour && $month == $mois_actuel && $an == $an_actuel) {$cs = 'text-danger font-weight-bold';}else{$cs = 'text-muted';}

/*Si ce premier dimanche est "reserve"*/
      if($tab_jours[1]) {

/*Si jour ferie sans evenement*/
         if ($afftitre[$tab_jours[1]] == '' && $fetetitre[$tab_jours[1]] != '') $cla = 'table-warning';
         else if ($afftitre[$tab_jours[1]] != '' && $fetetitre[$tab_jours[1]] == '') $cla = 'table-info';
         else if ($afftitre[$tab_jours[1]] != '' && $fetetitre[$tab_jours[1]] != '') $cla = 'table-info';
         $affcal .= '
         <td class="text-center '.$cla.'">
            <a href="'.$ThisFile.'&amp;subop=jour&amp;date='.$date.'" data-toggle="tooltip" data-html="true" data-placement="bottom" title="'.$fetetitre[$tab_jours[1]].''.$afftitre[1].'"><span class="'.$cs.'">1</span></a>
         </td>';
      }
      else {
/*Css jour libre*/
         $affcal .= '
         <td class="text-center">
            <span class="'.$cs.'">1</span>
         </td>';
      }
      $affcal .= '
      </tr>
      <tr>';
   }
   else {

/*Calcul numero semaine +0 pour enlever le 0 de 01,02,...*/
      $semaine1 = $semaine + 0;
   }
   $affcal .= '<th scope="row" class="text-center">'.$semaine1.'</th>';

/*7 premiers jour du mois*/
   for ($i = 1; $i < 8; $i++) {

/*Si case calendrier vide*/
      if ($i < $premier_jour) 
         $affcal .= '
         <td class="text-center">&nbsp;</td>';
      else
      {

/*Case avec class pour reserver*/
         $ce_jour = ($i + 1) - $premier_jour;

/*Permet la naviguation du calendrier*/
         $date = ajout_zero($ce_jour, $month, $an);

/*Met en rouge ce jour*/
         if ($ce_jour == $jour && $month == $mois_actuel && $an == $an_actuel) {$cs = 'text-danger font-weight-bold';}else{$cs = 'text-muted';}
         if($tab_jours[$ce_jour])
         {

/*Si jour ferie sans evenement*/
            if (!array_key_exists($ce_jour, $afftitre) && $fetetitre[$ce_jour] != ''){$cla = 'table-warning';}
            else if ($afftitre[$ce_jour] != '' && $fetetitre[$ce_jour] == ''){$cla = 'table-info';}
            else if ($afftitre[$ce_jour] != '' && $fetetitre[$ce_jour] != ''){$cla = 'table-info';}
            $affcal .= '
            <td class="text-center '.$cla.'">
            <a href="'.$ThisFile.'&amp;subop=jour&amp;date='.$date.'" data-toggle="tooltip" data-html="true" data-placement="bottom" title="'.$fetetitre[$ce_jour];
            if(array_key_exists($ce_jour, $afftitre))
               $affcal .= $afftitre[$ce_jour];
            $affcal .= '"><span class="'.$cs.'">'.$ce_jour.'</span></a>
            </td>';
         }
         else {

/*Css libre*/
            $affcal .= '
            <td class="text-center">
               <span class="'.$cs.'">'.$ce_jour.'</span>
            </td>';
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
      $affcal .= '<th scope="row" class="text-center">'.$semaine2.'</th>';
      for ($i = 1; $i < 8; $i++)
      {
         if($jour_suiv > $dernier_jour)
         {

/*Case avec class pour vide*/
            $affcal .= '<td class="text-center">&nbsp;</td>';
         }
         else
         {

/*Permet la naviguation du calendrier*/
            $date = ajout_zero($jour_suiv, $month, $an);

/*Met en rouge ce jour*/
            if ($jour_suiv == $jour && $month == $mois_actuel && $an == $an_actuel) {$cs = 'text-danger font-weight-bold';}else{$cs = 'text-muted';}

/*Case avec class pour reserver*/
            if($tab_jours[$jour_suiv]) {

/*Si jour ferie sans evenement*/
               if (!array_key_exists($jour_suiv, $afftitre) && $fetetitre[$jour_suiv] != ''){$cla = 'table-warning';}
               else if ($afftitre[$jour_suiv] != '' && $fetetitre[$jour_suiv] == ''){$cla = 'table-info';}
               else if ($afftitre[$jour_suiv] != '' && $fetetitre[$jour_suiv] != ''){$cla = 'table-info';}
               $affcal .= '<td class="text-center '.$cla.'">
               <a href="'.$ThisFile.'&amp;subop=jour&amp;date='.$date.'" data-toggle="tooltip" data-html="true" title="';
               if(isset($fetetitre) and array_key_exists($jour_suiv,$fetetitre))
                  $affcal .= aff_langue($fetetitre[$jour_suiv]);

            if(array_key_exists($jour_suiv, $afftitre))
               $affcal .= $afftitre[$jour_suiv];
            $affcal .='" data-placement="bottom"><span class="'.$cs.'">'.$jour_suiv.'</span></a>
               </td>';
            }
            else {

/*Css libre*/
               $affcal .= '<td class="text-center">
               <span class="'.$cs.'">'.$jour_suiv.'</span>
               </td>';
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


/// DEBUT FONCTION JOUR ///
function jour($date) {
   global $ModPath, $NPDS_Prefix, $theme, $cookie;
   global $ThisFile, $nb_news, $tipath, $page;
   $affeven='';
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
   settype($nb_entrees,'integer');
   $req1 = sql_query("SELECT
         ut.groupvoir
      FROM
         ".$NPDS_Prefix."agend us,
         ".$NPDS_Prefix."agend_dem ut
      WHERE
         us.date = '$date'
         AND us.liaison = ut.id
         AND valid = '1'");
   while(list($groupvoir) = sql_fetch_row($req1)) {
      if(autorisation($groupvoir)) $nb_entrees++;
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
   $bandeau = '<a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;month='.$retour[0].'&amp;an='.$retour[1].'">'.ag_translate('Retour au calendrier').'</a>';
   $lejour = $datetime;
   if ($nb_entrees == 0)
      $affeven = '<p><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Rien de prévu ce jour').'</p>';
   else {
   
/*Requete liste evenement suivant $date*/
      $result = sql_query("SELECT
            us.id, us.date, us.liaison,
            ut.titre, ut.intro, ut.descript, ut.lieu, ut.topicid, ut.posteur, ut.groupvoir,
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
      while(list($id, $date, $liaison, $titre, $intro, $descript, $lieu, $topicid, $posteur, $groupvoir, $topicimage, $topictext) = sql_fetch_row($result))
      {
         $titre = stripslashes(aff_langue($titre));
         $intro = stripslashes(aff_langue($intro));
         $lieu = stripslashes(aff_langue($lieu));
         $topictext = stripslashes(aff_langue($topictext));
         $affeven .= '
         <div class="card my-3">
            <div class="card-body">
               <p class="card-text">';

/*Si membre appartient au bon groupe*/
         if(autorisation($groupvoir)) {

/*Si evenement plusieurs jours*/
            $result1 = sql_query("SELECT date FROM ".$NPDS_Prefix."agend WHERE liaison = '$liaison' ORDER BY date DESC");
            $tot = sql_num_rows($result1);
            $affeven .= '<img class="img-thumbnail col-2" src="'.$tipath.''.$topicimage.'" />';
            $affeven .= '<h4 class="card-title">'.$titre.'</h4>';

            if ($posteur == $cookie[1])
               $affeven .= '<a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=editevt&amp;id='.$liaison.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
               <a class="btn btn-outline-danger btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=suppevt&amp;id='.$liaison.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            else
               $affeven .= '<p>'.ag_translate('Posté par').'&nbsp;'.$posteur.'</p>';
            $affeven .= '<p class="card-text">';
            if ($tot > 1) {
               $affeven .= '<i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Cet événement dure plusieurs jours').'</p>';
               while (list($ddate) = sql_fetch_row($result1)) {
                  if($ddate > $now){$etat = 'badge badge-success';}
                  else if($ddate == $now){$etat = 'badge badge-warning';}
                  else if($ddate < $now){$etat = 'badge badge-warning';}
                  $newdate = formatfrancais($ddate);
                  $affeven .= '<div class="'.$etat.' mr-2 mb-2">'.$newdate.'</div>';
                  $datepourmonmodal .= '<span class="'.$etat.'">'.$newdate.'</span>';
               }
            }
            else {
               list($ddate) = sql_fetch_row($result1);
               $newdate = formatfrancais($ddate);
               if($ddate > $now){$etat = 'badge badge-success';}
               else if($ddate == $now){$etat = 'badge badge-warning';}
               else if($ddate < $now){$etat = 'badge badge-warning';}
               $affeven .= '<i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Cet événement dure 1 jour').'</p>';
               $affeven .= '<div class="'.$etat.' mr-2 mb-2">'.$newdate.'</div>';
            }
            $affeven .= '
            <div class="row">
               <div class="col-md-2">'.ag_translate('Résumé').'</div>
               <div class="col-md-10">'.$intro.'</div>
            </div>
            <div class="row">
               <div class="col-md-2">'.ag_translate('Lieu').'</div>
               <div class="col-md-10">'.$lieu.'</div>
            </div>';
//événement du calendrier 
            $affeven .= '
            <div class="row">
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
               $affeven .= $datepourmonmodal;
            else
               $affeven .= $newdate;
           $affeven .= '</strong></h5>
               <div class="row">
                  <div class="col-md-2">'.ag_translate('Résumé').'</div>
                  <div class="col-md-10">'.$intro.'</div>
               </div>
               <div class="row">
                  <div class="col-md-2">'.ag_translate('Description').'</div>
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
</div>
</div>';
      $affeven .= '</div></div>';
   }
   }
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
function fiche($date, $id) {
   global $ModPath, $NPDS_Prefix, $cookie, $theme;
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
   $bandeau = '<a class="btn btn-secondary" href="'.$ThisFile.'&amp;month='.$retour[0].'&amp;an='.$retour[1].'">'.ag_translate('Retour au calendrier').'</a>';
   $bandeau1 = '<a class="btn btn-secondary" href="'.$ThisFile.'&amp;subop=jour&amp;date='.$date.'">'.ag_translate('Retour au jour').'</a>';
   $lejour = ''.$datetime.'';

/*Requete affiche evenement suivant $id*/
   $result = sql_query("SELECT titre, intro, descript, lieu, topicid, posteur, groupvoir FROM ".$NPDS_Prefix."agend_dem WHERE id = '$id' AND valid = '1'");
   $total = sql_num_rows($result);
   if ($total == 0)
   {
      $vide = '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Aucun événement trouvé').'</p>';
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
            $postepar = '<a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=editevt&amp;id='.$id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;
            <a class="btn btn-danger-outline btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=administration&amp;subop=suppevt&amp;date='.$date.'&amp;id='.$id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
         }
         else
         {
            $postepar = ''.ag_translate('Posté par').'&nbsp;'.$posteur.'</td>';
         }
            $affres .= '</tr><tr><td>';
         if ($tot > 1)
         {
            $imgfle .= '<i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Cet événement dure sur plusieurs jours').'&nbsp;:&nbsp;
            <select>
            <option>'.ag_translate('Voir').'</option>';
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
            $imgfle .= '<img src="modules/'.$ModPath.'/images/fle.gif" /> '.ag_translate('Cet événement dure 1 jour').'';
         }
         $imgfle .= '</div>';

/*Requete liste categorie*/
         $result2 = sql_query("SELECT topicimage, topictext FROM ".$NPDS_Prefix."agendsujet WHERE topicid = '$topicid'");
         list($topicimage, $topictext) = sql_fetch_row($result2);
         $titrefiche = stripslashes(aff_langue($titre));
         $imgsuj = '<img src="'.$tipath.''.$topicimage.'" /><br />'.stripslashes(aff_langue($topictext));
         $resume = str_replace("\n","<br />",stripslashes(aff_langue($intro)));
         $detail = stripslashes(aff_langue($descript));
         $lieu = stripslashes(aff_langue($lieu));
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

   include ('modules/'.$ModPath.'/admin/pages.php');
   global $pdst, $language;
   include_once('modules/'.$ModPath.'/lang/agenda-'.$language.'.php');
   settype($subop,'string');
   settype($an,'integer');
   settype($month,'integer');

/*Paramètres utilisés par le script*/
   $ThisFile = 'modules.php?ModPath='.$ModPath.'&amp;ModStart='.$ModStart;
   $ThisRedo = 'modules.php?ModPath='.$ModPath.'&ModStart='.$ModStart;
   $tipath = 'modules/'.$ModPath.'/images/categories/';
   include('header.php');
   include('modules/'.$ModPath.'/admin/config.php');
   require_once('modules/'.$ModPath.'/ag_fonc.php');
   include ('modules/'.$ModPath.'/cache.timings.php');
echo '<div class="card"><div class="card-body">';
   if ($SuperCache) {
      $cache_obj = new cacheManager();
      $cache_obj->startCachingPage();
   }
   else $cache_obj = new SuperCacheEmpty();

   if (($cache_obj->genereting_output == 1) or ($cache_obj->genereting_output == -1) or (!$SuperCache)) {
      switch($subop) {
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
   if ($SuperCache) $cache_obj->endCachingPage();
echo '</div></div>';
include("footer.php");
?>