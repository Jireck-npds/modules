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

// DEBUT MENU PRINCIPAL
function menuprincipal()
{
   global $NPDS_Prefix, $ModPath;
   global $ThisFile;
   $version = 'V.2.0';
   echo '<h2><img class="img_fluid col-sm-1" src="modules/npds_agenda/npds_agenda.png" alt="icon_npds_agenda"> '.ag_translate('Agenda').'<small class="float-right">'.$version.'</small></h2>
   <div class="card mb-2"><div class="card-block">
   <div class="mr-2"><a class="btn btn-outline-primary btn-sm" href='.$ThisFile.'>'.ag_translate('Accueil').'</a>
   <a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;subop=topicsmanager">'.ag_translate('Catégories').'</a>
   <a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;subop=configuration">'.ag_translate('Configuration').'</a>
   <a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=calendrier">'.ag_translate('Calendrier').'</a></div>';

//Requete compte nbre d'évènements suivant état
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
   echo '<p class="card-text mt-2">'.ag_translate('En Ligne').'<span class="badge badge-success mx-2">'.$en_l.'</span>'.ag_translate('Hors Ligne').'<span class="badge badge-default mx-2">'.$hors_l.'</span>'.ag_translate('A valider').'<span class="badge badge-danger mx-2">'.$avalid.'</span></p>';
   echo '</div></div>';
}
// FIN MENU PRINCIPAL

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

   echo '<div class="">
   <h4>'.ag_translate('Liste des évènements').'</h4>
   <p>'.ag_translate('Trier par').'&nbsp;
   <a class="text-success" href="'.$ThisFile.'&amp;order=1">'.ag_translate('En Ligne').'</a>&nbsp;-&nbsp;
   <a class="text-muted" href="'.$ThisFile.'&amp;order=2">'.ag_translate('Hors Ligne').'</a>&nbsp;-&nbsp;
   <a class="text-danger" href="'.$ThisFile.'&amp;order=3">'.ag_translate('A valider').'</a>&nbsp;-&nbsp;
   <a href="'.$ThisFile.'&amp;order=4">'.ag_translate('ID').'</a></p>';
   
   echo '
   <table class="table table-responsive">
   <thead class="thead-default">
   <tr>
   <th>'.ag_translate('ID').'</th>
   <th>'.ag_translate('Titre').'</th>
   <th>'.ag_translate('Catégorie').'</th>
   <th class="text-center">'.ag_translate('Groupe').'</th>
   <th>'.ag_translate('Auteur').'</th>
   <th class="text-center">'.ag_translate('Statut').'</th>
   <th class="text-center">'.ag_translate('Fonctions').'</th>
   </tr>
   </thead>';
   /*Requete liste evenements avec pagination*/
   $result = sql_query("SELECT id, titre, topicid, posteur, groupvoir, valid FROM ".$NPDS_Prefix."agend_dem ORDER BY $order1 DESC, titre ASC LIMIT $start,$nb_admin");
   while(list($id, $titre, $topicid, $posteur, $groupvoir, $valid) = sql_fetch_row($result))
   {
      $titre = stripslashes(aff_langue($titre));
      echo '<tr><tbody>
      <td>'.$id.'</td>
      <td>'.$titre.'</td>';
      $toplist = sql_query("SELECT topictext FROM ".$NPDS_Prefix."agendsujet WHERE topicid = $topicid");
      while(list($topictext) = sql_fetch_row($toplist))
      {
         $topictext = stripslashes(aff_langue($topictext));
         echo '<td>'.$topictext.'</td>';
      }
      echo '<td class="text-center">'.$groupvoir.'</td>
      <td><a href="replypmsg.php?send='.$posteur.'">'.$posteur.'</a></td>
      <td class="text-center">';
      if ($valid == 1)
      {
         echo '<span class="badge badge-success">'.ag_translate('En Ligne').'</span>';
      }
      else if ($valid == 2)
      {
         echo '<span class="badge badge-default">'.ag_translate('Hors Ligne').'</span>';
      }
      else if ($valid == 3)
      {
         echo '<span class="badge badge-danger">'.ag_translate('A valider').'</span>';
      }
         
      echo '</td>
      <td class="text-center"><a class="btn btn-outline-primary btn-sm mr-1" href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'" class=""><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><a class="btn btn-outline-danger btn-sm" href="'.$ThisFile.'&amp;subop=deleteevt&amp;id='.$id.'" class=""><i class="fa fa-trash" aria-hidden="true"></i></a></td>
      </tr>';
   }
   echo '</tbody></table>';

/*Affiche pagination*/
   echo ag_pag($total_pages,$page_courante,'2',''.$ThisFile.'&amp;subop=adminagenda&amp;order='.$order.'','_admin');
   echo '</div>';
}
// FIN INDEX

// DEBUT GESTION SUJET
function topicsmanager(){
   global $NPDS_Prefix, $tipath;
   global $ThisFile;
   menuprincipal();
   echo '<div class="">';
   /*Requete liste sujet*/
   $result = sql_query("SELECT * FROM ".$NPDS_Prefix."agendsujet ORDER BY topictext");
   if (sql_num_rows($result) > 0)
   {
   echo '<h4>'.ag_translate('Sélectionnez une catégorie, cliquez pour modifier').'</h4>
   <div class="row">';
   while(list($topicid, $topicimage, $topictext) = sql_fetch_row($result))
   {
   $topictext = stripslashes($topictext);
   echo '';
   if (($topicimage) or ($topicimage != ""))
   {
   echo '<div class="col-md-3">
   <div class="card-block"><p class="card-text">'.aff_langue(''.$topictext.'').'</p><a href="'.$ThisFile.'&amp;subop=topicedit&amp;topicid='.$topicid.'"><img class="card-img-top img-thumbnail" src="'.$tipath.''.$topicimage.'" data-toggle="tooltip" data-placement="bottom" title="'.ag_translate('Cliquez pour éditer').'" /></a></div></div>';
   }
   else
   {
   echo '<div class="col-2"><a class="" href="'.$ThisFile.'&amp;subop=topicedit&amp;topicid='.$topicid.'">'.aff_langue(''.$topictext.'').'</a></div>';
   }
   echo '';
   $count++;
   if ($count == 4)
   {
   echo '</div><div class="row">';
   $count = 0;
   }
   }
   echo '</div>';
   }
   echo '<h4>'.ag_translate('Ajouter une catégorie').'</h4>
   <form action="'.$ThisFile.'" method="post" name="adminForm">';
   echo '<fieldset class="form-group">
   <label for="">'.ag_translate('Titre de la catégorie').'</label>
   <input class="form-control" type="text" name="topictext" size="40">
   </fieldset>';   
   echo '<fieldset class="form-group">
   <label class="mr-2" for="">'.ag_translate('Image de la catégorie').'</label>';
   imgcate($topicimage);
   echo '<small id="" class="form-text text-muted">'.ag_translate('Chemin des images').' : '.$tipath.'</small>
   </fieldset>';
   echo '
   <input type="hidden" name="subop" value="topicmake">
   <button type="submit" class="btn btn-outline-primary btn-sm">'.ag_translate('Ajouter une catégorie').'</button>
   </form>
   </div>';
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
   echo '<select class="custom-select" name="topicimage" '.$val.'">';
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
   echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Pas de catégorie ajoutée').'</span></p>
   <div><a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;subop=topicsmanager">'.ag_translate('Retour').'</a></div>';
   }
   else
   {
   sql_query("INSERT INTO ".$NPDS_Prefix."agendsujet VALUES (NULL, '$topicimage', '$topictext')");
   echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('La catégorie est créée').'</span></p>
   <div><a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;subop=topicsmanager">'.ag_translate('Retour édition catégorie').'</a></div>';
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
   echo '<div class="">
   <h4>'.ag_translate('Modifier la catégorie').' '.aff_langue(''.$topictext.'').'</h4>
   <img class="img-thumbnail mb-2" src="'.$tipath.''.$topicimage.'" />
   <form action="'.$ThisFile.'" method="post" name="adminForm">';   
   echo '<fieldset class="form-group">
   <label class="mr-2" for="">'.ag_translate('Titre de la catégorie').'</label>
   <input class="form-control" type="text" name="topictext" size="40" value="'.$topictext.'">
   </fieldset>';
   echo '<fieldset class="form-group">
   <label class="mr-2" for="">'.ag_translate('Image de la catégorie').'</label>';
   imgcate($topicimage);
   echo '<small id="" class="form-text text-muted">'.('Chemin des images').' : '.$tipath.'</small>
   </fieldset>';
   echo '
   <input type="hidden" name="topicid" value="'.$topicid.'">
   <input type="hidden" name="subop" value="topicchange">
   <div class="btn-group" role="group" aria-label="">   
   <button type="submit" class="btn btn-outline-primary btn-sm mr-2">'.ag_translate('Sauver les modifications').'</button>
   </form>
   <form action="'.$ThisFile.'" method="post" name="adminForm">
   <input type="hidden" name="topicid" value="'.$topicid.'">
   <input type="hidden" name="subop" value="topicdelete">
   <button type="submit" class="btn btn-outline-danger btn-sm">'.ag_translate('Supprimer la catégorie').'</button>
   </form>
   </div>
   <p class=""><a class="btn btn-secondary btn-sm float-right" href="'.$ThisFile.'&amp;subop=topicsmanager">'.ag_translate('Retour édition catégorie').'</a></p>
   </div>';
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
   echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Pas de catégorie').'</p>
   <div><a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;subop=topicedit&topicid='.$topicid.'">'.ag_translate('Retour').'</a></div>';
   }
   else
   {
   sql_query("UPDATE ".$NPDS_Prefix."agendsujet SET topicimage = '$topicimage', topictext = '$topictext' WHERE topicid = $topicid");
   echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('La catégorie est mise à jour').'</p>
   <div><a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;subop=topicsmanager">'.ag_translate('Retour édition catégorie').'</a></div>';
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
   echo '<p class="lead text-danger"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('La catégorie est effacée').'</p>
   <div><a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;subop=topicsmanager">'.ag_translate('Retour édition catégorie').'</a></div>';
   }
   else
   {
   $result2 = sql_query("SELECT topicimage, topictext FROM ".$NPDS_Prefix."agendsujet WHERE topicid = '$topicid'");
   list($topicimage, $topictext) = sql_fetch_row($result2);
   $topictext = stripslashes($topictext);
   echo '<p><img class="img-thumbnail" src="'.$tipath.''.$topicimage.'" /></p>
   <p class="lead text-danger"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Supprimer la catégorie').' '.aff_langue(''.$topictext.'').' ?</p>
   <p class="lead">'.ag_translate('Confirmez la suppression').' '.aff_langue(''.$topictext.'').'</p>
   <div class="btn-group"><a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;subop=topicsmanager">'.ag_translate('NON').'</a><a class="btn btn-outline-danger btn-sm" href="'.$ThisFile.'&amp;subop=topicdelete&amp;topicid='.$topicid.'&amp;ok=1">'.ag_translate('OUI').'</a></div>';
   }
}
// FIN GESTION SUJET

// DEBUT EDITER
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

/*Requete affiche evenement suivant $id*/
   $result = sql_query("SELECT titre, intro, descript, lieu, topicid, posteur, groupvoir, valid FROM ".$NPDS_Prefix."agend_dem WHERE id = $id");
   list($titre, $intro, $descript, $lieu, $topicid, $posteur, $groupvoir, $valid) = sql_fetch_row($result);
   $titre = stripslashes($titre);
   $intro = stripslashes($intro);
   $descript = stripslashes($descript);
   $lieu = stripslashes($lieu);
   echo '<h4>'.ag_translate('Editer').' : '.$titre.'</h4>
   '.ag_translate('Posté par').' '.$posteur;
   echo '<form name="adminForm" action="'.$ThisFile.'" method="post">';
   echo '<fieldset class="form-group my-2">
   <label class="mr-2" for=""><strong>'.ag_translate('Statut').'</strong></label>';
   if($valid == 1)
   {
      $onligne = "selected=\"selected\"";
   }
   else if($valid == 2)
   {
      $offligne = "selected=\"selected\"";
   }
   echo '<select class="custom-select" name="statut" size="1">
   <option class="text-success" value="1" '.$onligne.'>'.ag_translate('En Ligne').'</option>
   <option class="text-danger" value="2" '.$offligne.'>'.ag_translate('Hors Ligne').'</option>
   </select>
   </fielset>';
   echo '<fieldset class="form-group">
   <label>'.ag_translate('Jour(s) sélectionné(s)').' :</label>';
   echo '<ul class="list-inline">';
   $name = explode(",",$debut);
   for ($i = 0; $i < sizeof($name); $i++ )
   {
   echo '<li class="list-inline-item">'.formatfrancais($name[$i]).' <a class="text-danger mx-2" data-toggle="tooltip" data-placement="bottom" title="'.ag_translate("Supprimer").'" href="'.$ThisFile.'&amp;subop=retire&amp;ladate='.$name[$i].'&amp;debut='.$debut.'&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'"><i class="fa fa-times" aria-hidden="true"></i></a></li>';
   }
   echo '</ul></label>
   <input type="hidden" name="debut" value="'.$debut.'">
   </fieldset>';
   cal($id, $month, $an, $debut);
   echo '<fieldset class="form-group">
   <label class="mr-2" for=""><strong>'.ag_translate('Catégorie').'</strong></label>
   <select class="custom-select" name="sujet" value="'.$topicid.'">';
   /*Requete liste sujet*/
   $res = sql_query("SELECT topicid, topictext FROM ".$NPDS_Prefix."agendsujet ORDER BY topictext ASC");
   while($categorie = sql_fetch_assoc($res))
   {
      $categorie['topictext'] = stripslashes($categorie['topictext']);
      echo '<option value=\''.$categorie['topicid'].'\'';
      if($categorie['topicid'] == $topicid)
      echo 'selected=\'selected\'';
      echo '>'.aff_langue(''.$categorie['topictext'].'').'</option>';
   }
   echo '</select>
   </fieldset>';  
   echo '<fieldset class="form-group">
   <label for=""><strong>'.ag_translate('Groupe').'</strong></label>
   <input class="form-control" type="text" name="groupvoir" value="'.$groupvoir.'" size="3">
   </fieldset>';
   echo '<fieldset class="form-group">
   <label for=""><strong>'.ag_translate('Titre').'</strong></label>
   <input class="form-control" type="text" name="titre" value="'.$titre.'">
   </fieldset>';
   echo '<fieldset class="form-group">
   <label for=""><strong>'.ag_translate('Résumé de l\'évènement').'</strong></label>   
   <textarea class="form-control tin" cols="30" rows="4" name="intro">'.$intro.'</textarea>';
   echo aff_editeur("descript","false");
   echo '</fieldset>';
   echo '<fieldset class="form-group">
   <label for=""><strong>'.ag_translate('Description').'</strong></label>
   <textarea class="form-control tin" name="descript" cols="50" rows="20" style="width: 90%;">'.$descript.'</textarea>';
   echo aff_editeur("descript","false");
   echo '</fieldset>';
   echo '<fieldset class="form-group">
   <label class="mr-2" for=""><strong>'.ag_translate('Lieu').'</strong></label>';
   if ($bouton == '1')
   {
      echo '<input class="form-control" maxLength=50 name="lieu" size=50 value="'.$lieu.'">';
   }
   else
   {
      include('modules/'.$ModPath.'/recherche/'.$bouton.'.php');
      echo '<select class="custom-select" name="lieu">
      <option></option>';
      foreach($try as $na)
      {
         if($lieu == $na){$af = ' selected';}else{$af = '';}
         echo '<option value="'.$na.'" '.$af.'>'.$na.'</option>';
      }
      echo '</select>';
   }
   echo '</fieldset>';
   echo '
   <input type="hidden" name="id" value="'.$id.'">
   <input type="hidden" name="subop" value="saveevt">
   <button type="submit" class="btn btn-outline-primary btn-sm">'.ag_translate('Sauver les modifications').'</button>
   <a class="btn btn-outline-danger btn-sm" href="'.$ThisFile.'&amp;subop=deleteevt&amp;id='.$id.'">'.ag_translate('Supprimer').'</a>';
   echo '</form>';
}
// FIN EDITER

// DEBUT AFFICHAGE CALENDRIER
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
      ''.ag_translate('Janvier').'',
      ''.ag_translate('Février').'',
      ''.ag_translate('Mars').'',
      ''.ag_translate('Avril').'',
      ''.ag_translate('Mai').'',
      ''.ag_translate('Juin').'',
      ''.ag_translate('Juillet').'',
      ''.ag_translate('Ao&ucirc;t').'',
      ''.ag_translate('Septembre').'',
      ''.ag_translate('Octobre').'',
      ''.ag_translate('Novembre').'',
      ''.ag_translate('Décembre').'');
   $mois_en_clair = $mois_de_annee[$month - 1];
   /*Creation tableau a 31 entree sans reservation*/
   for($j = 1; $j < 32; $j++)
   {
      $tab_jours[$j] = (bool)false;
   }
   echo '<h4 class="text-center">
   
   <a class="mr-2" href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$mois_prec.'&amp;an='.$an_prec.'&amp;debut='.$debut.'" class="ag_lidate"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
   <span class="label label-default">'.$mois_en_clair.'&nbsp;'.$an.'</span>   
   <a class="ml-2" href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$mois_suivant.'&amp;an='.$an_suivant.'&amp;debut='.$debut.'" class="ag_lidate"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></h4>';
   echo '<table class="table table-bordered table-sm">
    <thead class="thead-default">
   <tr>
   <th class="text-center">'.ag_translate('Sem').'</th>
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
   <tr class="text-center">';   
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
         echo '<td class="text-center">&nbsp;</td>'; 
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
         echo '<td class="text-center"><a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">1</a></td>';
      }
      else
      {
         echo '<td class="text-center">1</td>';
      }
      echo '</tr>
      <tr>';
   }
   else
   {
      /*Calcul numero semaine +0 pour enlever le 0 de 01,02,...*/
      $semaine1 = $semaine + 0;
   }
   echo '<td class="text-center">'.$semaine1.'</td>';
   /*7 premiers jour du mois*/
   for ($i = 1; $i < 8; $i++)
   {
      /*Si case calendrier vide*/
      if ($i < $premier_jour)
      {
         echo '<td class="text-center">&nbsp;</td>';
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
            echo '<td class="text-center"><a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">'.$ce_jour.'</a></td>';
         }
         else
         {
            echo '<td class="text-center">'.$ce_jour.'</td>';
         }
      }
   }
   /*Affichage fin du calendrier*/
   $jour_suiv = ($i + 1) - $premier_jour;
   for ($rangee = 0; $rangee <= 3; $rangee++)
   {
      echo '</tr>
      <tr align="center">';
      /*Calcul numero semaine*/
      $semaine2 = $semaine1 + $rangee + 1;
      if ($semaine2 == 53){$semaine2 = "01";}
      echo '<td class="ag_sem">'.$semaine2.'</td>';
      for ($i = 1; $i < 8; $i++)
      {
         if($jour_suiv > $dernier_jour)
         {
            /*Case avec class pour vide*/
            echo '<td class="text-center">&nbsp;</td>';
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
               echo '<td class="text-center"><a href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'&amp;month='.$month.'&amp;an='.$an.'&amp;debut='.$newlien.'">'.$jour_suiv.'</a></td>';
            }
            else
            {
               echo '<td class="text-center">'.$jour_suiv.'</td>';
            }
         }
         $jour_suiv++;
      }
   }
   echo '</tr></table>';
}
// FIN AFFICHAGE CALENDRIER

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
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Cet évènement est mis à jour').'<br /><br /><a class="btn btn-secondary btn-sm" href="'.$ThisFile.'">'.ag_translate('Retour').'</a></p>';
   }
   else
   {
      echo ''.sql_error().'<br />';
      return;
   }
}
// FIN SAUVER EDITER

// DEBUT ENLEVER JOUR
function retire($ladate, $debut, $id, $month, $an)
{
   global $ThisRedo;
   /*Debut securité*/
   settype($id,"integer");
   settype($month,"integer");
   settype($an,"integer");
   $debut = removeHack($debut);
   /*Fin securité*/
   /*On rajoute une virgule qu'on enlève après sinon double virgules*/
   $debut1 = ''.$debut.',';
   $newdebut = str_replace("$ladate,", "", "$debut1");
   $newdebut = substr("$newdebut", 0, -1);
   redirect_url(''.$ThisRedo.'&subop=editevt&id='.$id.'&month='.$month.'&an='.$an.'&debut='.$newdebut.'');
}
// FIN ENLEVER JOUR

// DEBUT SUPPRIMER
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
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Cet évènement est maintenant effacé').'</p>';
      echo '<p><a class="btn btn-secondary btn-sm" href="'.$ThisFile.'">'.ag_translate('Retour').'</a></p>';     
   }
   else
   {
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Etes-vous certain de vouloir supprimer cet évènement').'</p>
      <div class="btn-group"><a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;subop=editevt&amp;id='.$id.'">'.ag_translate('NON').'</a>
      <a class="btn btn-outline-danger btn-sm" href="'.$ThisFile.'&amp;subop=deleteevt&amp;id='.$id.'&amp;ok=1">'.ag_translate('OUI').'</a></div>';
      echo '<p><a class="btn btn-secondary btn-sm mt-2" href="'.$ThisFile.'">'.ag_translate('Retour').'</a></p>';     
   }
}
// FIN SUPPRIMER

// DEBUT CONFIGURATION
function configuration()
{
   global $ModPath;
   global $ThisFile;

//   menuprincipal();

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
      $def = '<div class="form-check"><label><input class="form-check-input mr-2" type="radio" name="xbouton" value="1" checked>'.ag_translate('Par ville (défaut)').'</label></div>';
     
      $def1 = '<div class="form-check"><label><input class="form-check-input mt-2" type="radio" name="xbouton" value="2">'.ag_translate('Autres').'<select class="custom-select ml-2" name="xbouton1">
      <option></option>';
      $nb = count($ListFiles);
      for($i = 0;$i < $nb;$i++)
      {
         $name = ''.substr($ListFiles[$i], 0, -4).'';
         $def1 .= '<option value="'.$name.'">'.$name.'</option>';
      }
      $def1 .= '</select></label></div>';
   }
   else
   {
      $def = '<div class="form-check"><label><input class="form-check-input mr-2" type="radio" name="xbouton" value="1" />'.ag_translate('Par ville (défaut)').'</label></div>';
      
      $def1 .= '<div class="form-check"><label><input class="form-check-input mt-2" type="radio" name="xbouton" value="2" checked>'.ag_translate('Autres').'<select class="custom-select ml-2" name="xbouton1">
      <option></option>';
      $nb = count($ListFiles);
      for($i = 0;$i < $nb;$i++)
      {
         $name = ''.substr($ListFiles[$i], 0, -4).'';
         if ($bouton == $name){$stat = ' selected';}else{$stat = '';}
         $def1 .= '<option value="'.$name.'"'.$stat.'>'.$name.'</option>';
      }
      $def1 .= '</select></label></div>';
   }
   echo '<h4>'.ag_translate('Configuration').'</h4>  
   <form action="'.$ThisFile.'" method="post" name="adminForm">';
   
   echo '<fieldset class="form-group">
   <label for="">'.ag_translate('Ajout + Groupe').'</label>
   <input class="form-control" type="text" name="xgro" size="3" value="'.$gro.'">
   <small id="" class="form-text text-muted">'.ag_translate('Ajout d\'événement : 1 Tous les membres - ou groupe').'</small>
   </fieldset>';
   echo '<fieldset class="form-group">
   <label for="">'.ag_translate('Validation par l\'admin').'</label>';
   if($valid == 1)
   {
   $onligne = "selected=\"selected\"";
   }
   if($valid == 3)
   {
   $avalider = "selected=\"selected\"";
   }
   echo '
   <select class="custom-select" name="xvalid" size="1">
   <option value="3" '.$avalider.'>'.ag_translate('Oui').'</option>
   <option value="1" '.$onlignee.'>'.ag_translate('Non').'</option>
   </select>
   </fieldset>';
   echo '<fieldset class="form-group">
   <label for="">'.ag_translate('Etre averti par mail d\'un nouvel evenement').'</label>';
   if($courriel == 1)
   {
   $oui = "selected=\"selected\"";
   }
   if($courriel == 0)
   {
   $non = "selected=\"selected\"";
   }
   echo '
   <select class="custom-select" name="xcourriel" size="1">
   <option value="1" '.$oui.'>'.ag_translate('Oui').'</option>
   <option value="0" '.$non.'>'.ag_translate('Non').'</option>
   </select>
   </fieldset>';
   echo '<fieldset class="form-group">
   <label for="">'.ag_translate('Mail du receveur').'</label>
   <input class="form-control" type="text" name="xreceveur" size="30" value="'.$receveur.'">
   </fieldset>';   
   echo '<fieldset class="form-group">
   <label for="">'.ag_translate('Validation après modification').'</label>';
   if($revalid == 1)
   {
   $reonligne = "selected=\"selected\"";
   }
   if($revalid == 3)
   {
   $reavalider = "selected=\"selected\"";
   }
   echo '
   <select class="custom-select" name="xrevalid" size="1">
   <option value="3" '.$reavalider.'>'.ag_translate('Oui').'</option>
   <option value="1" '.$reonligne.'>'.ag_translate('Non').'</option>
   </select>
   </fieldset>';
   echo '<fieldset class="form-group">
   <label for="">'.ag_translate('Nbre d\'évènements (pagination)').'</label>
   <input class="form-control" type="text" name="xnb_admin" size="3" value="'.$nb_admin.'">
   <small id="" class="form-text text-muted">'.ag_translate('Dans la partie admin').'</small>
   </fieldset>';
   echo '<fieldset class="form-group">
   <label for="">'.ag_translate('Nbre d\'évènements (pagination)').'</label>
   <input class="form-control" type="text" name="xnb_news" size="3" value="'.$nb_news.'">
   <small id="" class="form-text text-muted">'.ag_translate('Dans la partie module').'</small>
   </fieldset>';
   echo '<fieldset class="form-group">
   <legend for="">'.ag_translate('Recherche').'</legend>
   <div class=row">
   <div class="col-sm-10">';
   echo $def;
   echo $def1;
   echo '</div></div>
   <small id="" class="form-text text-muted">'.ag_translate('Sélectionner si nécessaire').'</small>
   </fieldset>';
   echo '<fieldset class="form-group">
   <label for="">'.ag_translate('Supercache').'</label>
   <input class="form-control" type="text" name="xtps" size="10" value="'.$CACHE_TIMINGS['modules.php'].'">
   <small id="" class="form-text text-muted">'.ag_translate('Temps du cache (en secondes)').'</small>
   </fieldset>';
   echo '<input type="hidden" name="subop" value="ConfigSave">
   <button type="submit" class="btn btn-outline-primary btn-sm mt-2"><i class="fa fa-check-square fa-lg mr-2"></i>'.ag_translate('Valider').'</button>';
   echo '</form>';
}
// FIN CONFIGURATION

// DEBUT SAUVER CONFIGURATION
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
   $content .= "/************************************************************************/\n";
   $content .= "/* DUNE by NPDS      */\n";
   $content .= "/*       */\n";
   $content .= "/* NPDS Copyright (c) 2002-2017 by Philippe Brunier   */\n";
   $content .= "/*       */\n";
   $content .= "/* This program is free software. You can redistribute it and/or modify */\n";
   $content .= "/* it under the terms of the GNU General Public License as published by */\n";
   $content .= "/* the Free Software Foundation; either version 2 of the License.   */\n";
   $content .= "/*       */\n";
   $content .= "/* Module npds_agenda 2.0     */\n";
   $content .= "/*       */\n";
   $content .= "/* Auteur Oim      */\n";
   $content .= "/* Changement de nom du module version Rev16 par jpb/phr janv 2017   */\n";
   $content .= "/************************************************************************/\n";
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
   $content .= "/************************************************************************/\n";
   $content .= "/* DUNE by NPDS      */\n";
   $content .= "/*       */\n";
   $content .= "/* NPDS Copyright (c) 2002-2017 by Philippe Brunier   */\n";
   $content .= "/*       */\n";
   $content .= "/* This program is free software. You can redistribute it and/or modify */\n";
   $content .= "/* it under the terms of the GNU General Public License as published by */\n";
   $content .= "/* the Free Software Foundation; either version 2 of the License.   */\n";
   $content .= "/*       */\n";
   $content .= "/* Module npds_agenda 2.0     */\n";
   $content .= "/*       */\n";
   $content .= "/* Auteur Oim      */\n";
   $content .= "/* Changement de nom du module version Rev16 par jpb/phr janv 2017   */\n";
   $content .= "/************************************************************************/\n";
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
   echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.ag_translate('Les préférences pour l\'agenda ont été enregistrées').'</p>';
}
// FIN SAUVER CONFIGURATION
?>