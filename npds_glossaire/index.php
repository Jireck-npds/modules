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
/* Module npds_glossaire v 3.0 pour revolution 16                       */
/* by team jpb/phr 2017                                                 */
/*                                                                      */
/* From Glossaire version 1.3 pour myPHPNuke 1.8                        */
/* Copyright © 2001, Pascal Le Boustouller                              */
/* Tribal-dolphin 2008                                                  */
/************************************************************************/

// For More security
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security
if (!function_exists("Mysql_Connexion")) {
   include ("mainfile.php");
}

include ("modules/$ModPath/glossaire.conf.php");
include ("modules/$ModPath/lang/glossaire-$language.php");
include ("modules/$ModPath/cache.timings.php");

function glohead() {
   global $ModPath, $ModStart, $activ_rech, $NPDS_Prefix;

   include("header.php");
   echo '<div class="card"><div class="card-body">';
   echo '<h2><img src="modules/$ModPath/npds_glossaire.png" alt="icon_npds_glossaire"> '.glo_translate('Glossaire').'</h2>';

   $acounter = sql_query("SELECT count(*) FROM ".$NPDS_Prefix."td_glossaire WHERE affiche!='0'");
   list($acount) = sql_fetch_row($acounter);
   if($acount == 0) {
     echo '<p class="lead text-danger"><i class="fa fa-info-circle" aria-hidden="true"></i> '.glo_translate("La base est vide").'</p>';
   } else {
     tlist($acount);
     if ($activ_rech) {
        aff_forme_rech();
        aff_alpha("");
     }
   }
}

function glofoot() {
   global $ModPath, $ModStart, $ok_submit, $NPDS_Prefix;

   if ($ok_submit) {
      echo '<p class="lead"><a data-toggle="collapse" href="#saisiform" aria-expanded="true" aria-controls="saisiform"><i data-toggle="tooltip" data-placement="top" title="'.glo_translate("Cliquer pour cacher ou déployer").'" class="toggle-icon fa fa-lg fa-caret-down"></i></a> '.glo_translate("Soumettre une définition").'</p>';
      echo'<div id="saisiform" class="collapse" role="tabpanel" aria-labelledby="">
      <div class="card-body">';
      echo '<form action="modules.php?ModPath='.$ModPath.'&ModStart='.$ModStart.'" method="POST" name="adminForm">';
      echo '<div class="form-group row">';
      echo '<div class="col-sm-3"><label for="">'.glo_translate("Terme").'</label></div>';
      echo '<div class="col-sm-8"><input class="form-control" type="text" name="terme" size="45" maxsize="100"></div>';
      echo '</div>';
      echo '<div class="form-group row">';
      echo '<div class="col-sm-3"><label for="">'.glo_translate("Catégorie").'</div>';
      echo '<div class="col-sm-4 mb-1"><input class="form-control" type="text" name="gcategory" size="25" maxlength="30"></div>';
      echo '<div class="col-sm-4"><select class="custom-select" name="sgcategory">';

      $result = sql_query("SELECT DISTINCT gcat FROM ".$NPDS_Prefix."td_glossaire ORDER BY gcat");

      while (list($dcategory) = sql_fetch_row($result)) {
      $dcategory=stripslashes($dcategory);
      echo '<option '.$sel.' value="'.$dcategory.'">'.$dcategory.'</option>';
      }
      echo '</select></div>';
      echo '</div>';
      echo '<div class="form-group row">';
      echo '<div class="col-sm-3"><label for="">'.glo_translate("Définition").'</div>';
      echo '<div class="col-sm-8"><textarea name="content" class="form-control tin" rows="10"></textarea>';
//         echo aff_editeur("content", "true");
      echo '</div></div>';
      echo '<div class="form-group row">';
      echo '<div class="col-sm-3"><label for="">'.glo_translate("Site internet").'</div>';	  
      echo '<div class="col-sm-8"><input class="form-control" type="text" name="xurl" size="45" maxsize="255"><small id="" class="form-text text-muted">exemple : http://npds.org</small></div>';
      echo '</div>';
      echo '<input type="hidden" name="op" value="submit_terme">';
      echo Q_spambot();
      echo '<input class="btn btn-outline-primary" type="submit" value="'.glo_translate("Valider").'">';
      echo '</form>';
      echo '</div>
    </div>';
   }
}

function rand_glo() {
   global $nb_affichage, $NPDS_Prefix;
   
   $acounter = sql_query("SELECT COUNT(*) FROM ".$NPDS_Prefix."td_glossaire WHERE affiche!='0'");
   list($acount) = sql_fetch_row($acounter);
   if ($acount != 0) {
      echo '<p class="lead"><a data-toggle="collapse" href="#qqdef" aria-expanded="true" aria-controls="qqdef"><i data-toggle="tooltip" data-placement="top" title="'.glo_translate("Cliquer pour cacher ou déployer").'" class="toggle-icon fa fa-lg fa-caret-down"></i></a> '.glo_translate("Quelques définitions").'</p>';
      echo'<div id="qqdef" class="collapse" role="tabpanel" aria-labelledby="">
      <div class="card-body">';
      echo '<table class="table table-sm table-hover">';
      echo '<thead><tr><th>'.glo_translate("Termes").'</th><th>'.glo_translate("Définitions").'</th></tr></thead><tbody>';
      settype($nb_affichage,"integer");
      $TableRep=sql_query("SELECT id, nom, definition, lien FROM ".$NPDS_Prefix."td_glossaire WHERE affiche!='0' ORDER BY RAND() LIMIT $nb_affichage");
      while (list($id_terme,$terme,$terme_def, $terme_lien) = sql_fetch_row($TableRep)) {
      echo '<tr><td class="align-top">'.$terme.'</td><td>'.$terme_def.'';
      if ($terme_lien) {
      echo '<br /><a href="'.$terme_lien.'" target="_blank" class="btn btn-outline-primary btn-sm">'.glo_translate("Site internet").'</a>';
      }
      echo '</td></tr>';
      }
      echo '</tbody></table>';
      echo '</div></div>';
   }
}

function categ_glo($gcat, $debut) {
   global $ModPath, $ModStart, $SuperCache, $nb_affichage, $NPDS_Prefix;

   $cate = removeHack(StripSlashes(strip_tags(urldecode($gcat), ENT_NOQUOTES)));
   settype($debut,"integer");
   if ($debut=="") { $debut=0; }

   $TableRep=sql_query("SELECT id FROM ".$NPDS_Prefix."td_glossaire WHERE affiche!='0' AND gcat='$cate' ORDER BY nom");
   $nbe=sql_num_rows($TableRep);
   
   // Include cache manager
   if ($SuperCache) {
      $cache_obj = new cacheManager();
      $cache_obj->startCachingPage();
   } else {
      $cache_obj = new SuperCacheEmpty();
   }
   if (($cache_obj->genereting_output==1) or ($cache_obj->genereting_output==-1) or (!$SuperCache)) {
      
      settype($nb_affichage,"integer");
      $TableRep=sql_query("SELECT id, nom, definition, lien FROM ".$NPDS_Prefix."td_glossaire WHERE affiche!='0' AND gcat='$cate' ORDER BY nom LIMIT $debut,$nb_affichage");
      $top=1;
      $topsuivant="modules.php?ModPath=$ModPath&amp;ModStart=$ModStart&amp;gcat=$cate";

      if ($top==1) {
      echo '<p class="lead text-success"><i class="fa fa-info-circle" aria-hidden="true"></i> '.$nbe.' '.glo_translate("Réponse(s)").'</p>';
      echo '<table class="table table-sm table-hover">';
      echo '<thead><tr><th>'.glo_translate("Termes").'</th><th>'.glo_translate("Définitions").'</th></tr></thead><tbody>';
         while (list($glo_id, $glo_nom, $glo_definition, $glo_lien)=sql_fetch_row($TableRep)) {
            echo '<tr><td class="align-top">'.$glo_nom.'</td><td>'.$glo_definition;
            if ($glo_lien) {
            echo '<br /><a href="'.$glo_lien.'" target="_blank" class="btn btn-outline-primary btn-sm">'.glo_translate("Site internet").'</a>';
            }
         echo '</td></tr>';
         }
         echo '</tbody></table>';
      }
      pagination ($top, $debut, $topsuivant, $nb_affichage, $nbe);
      
   }
   if ($SuperCache) {
      $cache_obj->endCachingPage();
   }
}

function rech_lettre($lettre, $gcat, $debut) {
   global $ModPath, $ModStart, $SuperCache, $nb_affichage, $NPDS_Prefix;

   $lettre = removeHack(StripSlashes(strip_tags(urldecode($lettre), ENT_NOQUOTES)));
   if (empty($gcat)) { $cate = translate("All"); } else { $cate = removeHack(StripSlashes(strip_tags(urldecode($gcat), ENT_NOQUOTES))); }
   settype($debut,"integer");
   if ($debut=="") { $debut=0; }

   $TableRep=sql_query("SELECT id FROM ".$NPDS_Prefix."td_glossaire WHERE affiche!='0' AND lettre='$lettre'".($cate!=translate("All")?" AND gcat='$cate'":"")." ORDER BY nom");
   $nbe=sql_num_rows($TableRep);
   // Include cache manager
   if ($SuperCache) {
      $cache_obj = new cacheManager();
      $cache_obj->startCachingPage();
   } else {
      $cache_obj = new SuperCacheEmpty();
   }
   if (($cache_obj->genereting_output==1) or ($cache_obj->genereting_output==-1) or (!$SuperCache)) {
      
      settype($nb_affichage,"integer");
      $TableRep=sql_query("SELECT id, nom, definition, lien FROM ".$NPDS_Prefix."td_glossaire WHERE affiche!='0' AND lettre='$lettre'".($cate!=translate("All")?" AND gcat='$cate'":"")." ORDER BY nom LIMIT $debut,$nb_affichage");
      $top=1;
      $topsuivant="modules.php?ModPath=$ModPath&amp;ModStart=$ModStart&amp;gcat=$cate&amp;op=rech_lettre&amp;lettre=$lettre";
      if ($top==1) {
      echo '<p class="lead text-success"><i class="fa fa-info-circle" aria-hidden="true"></i> '.$nbe.' '.glo_translate("Réponse(s)").'</p>';
      echo '<table class="table table-sm table-hover">';
      echo '<thead><tr><th>'.glo_translate("Termes").'</th><th>'.glo_translate("Définitions").'</th></tr></thead><tbody>';
      while (list($glo_id, $glo_nom, $glo_definition, $glo_lien)=sql_fetch_row($TableRep)) {
      echo '<tr><td class="align-top">'.$glo_nom.'</td><td>'.$glo_definition;
      if ($glo_lien) {
      echo '<br /><a href="'.$glo_lien.'" target="_blank" class="btn btn-outline-primary btn-sm">'.glo_translate("Site internet").'</a>';
      }
      echo '</td></tr>';
      }
      echo '</tbody></table>';
      }
      pagination ($top, $debut, $topsuivant, $nb_affichage, $nbe);
   }
   if ($SuperCache) {
      $cache_obj->endCachingPage();
   }
}

function rech_terme($type, $terme, $debut) {
   global $ModPath, $ModStart, $SuperCache, $nb_affichage, $NPDS_Prefix;

   settype($type, "integer");
   $query=removeHack(StripSlashes(strip_tags(urldecode($terme), ENT_NOQUOTES))); // electrobug
   settype($debut,"integer");

   if ($type =="1") {
      $types = "nom LIKE '%$query%'";
   }
   if ($type =="2") {
      $types = "definition LIKE '%$query%'";
   }
   if ($type =="3") {
      $types = "nom LIKE '%$query%' OR definition LIKE '%$query%'";
   }

   if ($debut=="") { $debut=0; }
   $TableRep=sql_query("SELECT id, nom, definition, lettre FROM ".$NPDS_Prefix."td_glossaire WHERE $types AND affiche!='0' ORDER BY nom ");
   $nbe=sql_num_rows($TableRep);
   // Include cache manager
   if ($SuperCache) {
      $cache_obj = new cacheManager();
      $cache_obj->startCachingPage();
   } else {
      $cache_obj = new SuperCacheEmpty();
   }
   if (($cache_obj->genereting_output==1) or ($cache_obj->genereting_output==-1) or (!$SuperCache)) {
      
      settype($nb_affichage,"integer");
      $result = sql_query("SELECT id, nom, definition, lien FROM ".$NPDS_Prefix."td_glossaire WHERE $types AND affiche!='0' ORDER BY nom LIMIT $debut,$nb_affichage");
      $top=1;
      $topsuivant="modules.php?ModPath=$ModPath&amp;ModStart=$ModStart&amp;op=rech_terme&amp;terme=$terme&amp;type=$type";
      if ($top==1) {
      echo '<p class="lead text-success"><i class="fa fa-info-circle" aria-hidden="true"></i> '.$nbe.' '.glo_translate("Réponse(s)").'</p>';
      echo '<table class="table table-sm table-hover">';
      echo '<thead><tr><th>'.glo_translate("Termes").'</th><th>'.glo_translate("Définitions").'</th></tr></thead><tbody>';
      while (list($glo_id, $glo_nom, $glo_definition, $glo_lien)=sql_fetch_row($result)) {
      echo '<tr><td class="align-top">'.$glo_nom.'</td><td>'.$glo_definition;
      if ($glo_lien) {
      echo '<br /><a href="'.$glo_lien.'" target="_blank" class="btn btn-outline-primary btn-sm">'.glo_translate("Site internet").'</a>';
      }
      echo '</td></tr>';
      }
      echo '</tbody></table>';
      }
      pagination ($top, $debut,$topsuivant,$nb_affichage,$nbe);
      
      }
      if ($SuperCache) {
      $cache_obj->endCachingPage();
   }
}

// SOUS-FONCTIONS
function tlist($acount) {
   global $ModPath, $ModStart, $sortby, $gcat, $NPDS_Prefix;
   $cate = stripslashes($gcat);
   echo '<p class="lead"><a data-toggle="collapse" href="#rechdo" aria-expanded="true" aria-controls="rechdo"><i data-toggle="tooltip" data-placement="top" title="'.glo_translate("Cliquer pour cacher ou déployer").'" class="toggle-icon fa fa-lg fa-caret-up"></i></a> '.glo_translate("Sélectionner un dossier").'</p>';
   echo'<div id="rechdo" class="collapse show" role="tabpanel" aria-labelledby="">
      <div class="card-body">';
   echo '<div class="row">
      <div class="col-sm-3">';
   if (($cate == translate("All")) OR ($cate == "")) {
   echo "<i class=\"fa fa-folder-open fa-2x text-muted\"></i> <strong>".translate("All")." ($acount)</strong>\n";
   } else {
   echo "<a href=\"modules.php?ModPath=$ModPath&amp;ModStart=$ModStart&amp;gcat=".translate("All")."&amp;sortby=$sortby\" class=\"\"><i class=\"fa fa-2x fa-folder\"></i> ".translate("All")."</a> ($acount)\n"; 
   }
   $result = sql_query("SELECT DISTINCT gcat, count(gcat) FROM ".$NPDS_Prefix."td_glossaire WHERE affiche!='0' GROUP BY gcat ORDER BY gcat");
   echo '</div>';
   $rup=1;
   while (list($category, $dcount) = sql_fetch_row($result)) {
   $rup++;
   $category=stripslashes($category);
   echo '<div class="col-sm-3">';
   if ($category == $cate) {
   echo "<i class=\"fa fa-folder-open fa-2x text-muted\"></i><span class=\"\"> <strong>$category ($dcount)</strong></span> \n";
    } else {
        $category2 = urlencode($category);
        echo "<a href=\"modules.php?ModPath=$ModPath&amp;ModStart=$ModStart&amp;gcat=$category2&amp;sortby=$sortby\"><i class=\"fa fa-2x fa-folder\"></i> $category</a> ($dcount) \n";
    }
      echo '</div>';
    if ($rup>=5) {
       $rup=0;
    }
  }
echo '</div></div></div>';
}
function aff_forme_rech() {
   global $ModPath, $ModStart;
   echo '<p class="lead"><a data-toggle="collapse" href="#rechcho" aria-expanded="true" aria-controls="rechcho"><i data-toggle="tooltip" data-placement="top" title="'.glo_translate("Cliquer pour cacher ou déployer").'" class="toggle-icon fa fa-lg fa-caret-up"></i></a> '.glo_translate("Rechercher par choix multiples").'</p>';
   echo'<div id="rechcho" class="collapse show" role="tabpanel" aria-labelledby="">';
   echo '<div class="card-body">';   
   echo '<form action="modules.php?ModPath='.$ModPath.'&ModStart='.$ModStart.'" method="post">';
   echo '<div class="form-group row">';	  
   echo '<div class="col-md-2 mt-1"><label for=""><strong>'.glo_translate("Sélectionner").'</strong></div>';
   echo '<div class="col-md-4 mb-1"><select class="custom-select" name="type">';
   echo '<option value="1"> '.glo_translate("Termes")."\n";
   echo '<option value="2"> '.glo_translate("Définitions");
   echo '<option value="3"> '.glo_translate("Termes").' & '.glo_translate("Définitions");
   echo '</select></div>';
   echo '<input type="hidden" name="op" value="rech_terme">';
   echo '<div class="col-md-4 mb-1"><input class="form-control" type="text" name="terme" size="13" maxsize="100"></div>';
   echo '<div class="col-md-2 mb-1"><input class="btn-outline-primary btn-sm" type="submit" value="'.glo_translate("Valider").'"></div></div>';
   echo '</form>';
   echo '</div></div>';
}
function aff_alpha($type) {
   global $ModPath, $ModStart, $gcat;
   echo '<p class="lead"><a data-toggle="collapse" href="#rechlet" aria-expanded="true" aria-controls="rechlet"><i data-toggle="tooltip" data-placement="top" title="'.glo_translate("Cliquer pour cacher ou déployer").'" class="toggle-icon fa fa-lg fa-caret-up"></i></a> '.glo_translate("Rechercher par lettre").'</p>';
   echo'<div id="rechlet" class="collapse show" role="tabpanel" aria-labelledby=""><div class="card-body">';
   echo '<p class="lead text-center">';
   
   $alphabet = array ("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","".glo_translate("Autres")."");
   $num = count($alphabet) - 1;
   $counter = 0;
   while (list(, $ltr) = each($alphabet)) {
      if ($ltr!=translate("Other")) {
         echo '<a href="modules.php?ModPath='.$ModPath.'&amp;ModStart='.$ModStart.'&amp;gcat='.$gcat.'&amp;op=rech_lettre&amp;lettre='.$ltr.'" class="">'.$ltr.'</a>';
      } else {
         echo '<a href="modules.php?ModPath='.$ModPath.'&amp;ModStart='.$ModStart.'&amp;gcat='.$gcat.'&amp;op=rech_lettre&amp;lettre=!AZ" class="">'.$ltr.'</a>';
      }
      if ( $counter != $num )
         echo ' | ';
         $counter++;
   }
   echo '</p></div></div>';
}
function pagination ($top, $debut, $topsuivant, $nb_affichage, $nbe) {
   global $ModPath, $ModStart;
   if ($top==1) {
       echo '<ul class="pagination pagination-sm">
    ';
       if ($debut != 0) {
          echo '<li class="page-item"><a href="'.$topsuivant.'&debut=';
          $resultat = ($debut-$nb_affichage);
          if ($resultat < 0) {
             $resultat = 0;
          }
          echo $resultat.'" class="page-link"><span aria-hidden="true">&laquo;</span> '.glo_translate("précédente").'</a></li>';
//          $deb=true;
       }
       if (($debut+$nb_affichage) < $nbe) {
//          if ($deb)
//             echo ' ';
          echo '<li class="page-item"><a href="'.$topsuivant.'&debut=';
          $final =($debut+$nb_affichage);
          if ($final >= $nbe) {
             $final=($nbe - $nb_affichage);
          }
          echo $final.'" class="page-link">'.glo_translate("suivante").' <span aria-hidden="true">&raquo;</span></a></li>';
       }
    echo '</ul>';
   }
}
// SWITCH AFFICHAGE PAGE
settype($op,'string');
settype($debut,'string');
switch($op) {
   case "submit_terme":
      if (!R_spambot($asb_question, $asb_reponse, $content)) {
         header("location: modules.php?ModPath=$ModPath&ModStart=$ModStart");
         die();
      }
      global $NPDS_Prefix;
      glohead();

      if (!$gcategory) { $gcategory = $sgcategory; }

      if (($gcategory!="") and ($terme!="") and ($content!="")) {
         $lettre=substr(ucfirst($terme),0,1);
         if (!preg_match("#[A-Z]#",$lettre)) {$lettre="!AZ";}
         $gcategory=removeHack(addslashes(strip_tags(urldecode($gcategory), ENT_NOQUOTES))); // electrobug
         $terme=removeHack(stripslashes(strip_tags(urldecode($terme), ENT_NOQUOTES))); // electrobug
         $content=removeHack($content);
         $result=sql_query("select * from ".$NPDS_Prefix."td_glossaire where gcat='$gcategory' and nom='$terme' and definition='$content'");
         list($id)=sql_fetch_row($result);
         
         if (!$id) {
            sql_query("insert into ".$NPDS_Prefix."td_glossaire values (NULL, '$gcategory', '$lettre', '$terme', '$content', '0', '$xurl')");
      echo '<p class="lead text-info"><i class="fa fa-info-circle" aria-hidden="true"></i> '.glo_translate("Merci pour votre proposition").'.</p>';
         } else {
            echo '<p class="lead text-info"><i class="fa fa-info-circle" aria-hidden="true"></i> '.glo_translate("Une définition identique existe déjà").'.</p>';
         }
      } else {
            echo '<p class="lead text-info"><i class="fa fa-info-circle" aria-hidden="true"></i> '.glo_translate("Merci de respecter les consignes").'.</p>';
      }
      glofoot();
      break;

   case "rech_terme":
      glohead();
      rech_terme($type, $terme, $debut);
      glofoot();
      break;

   case "rech_lettre":
      glohead();
      rech_lettre($lettre, $gcat, $debut);
      glofoot();
      break;

    default:
      glohead();
      if (empty($gcat) || (stripslashes($gcat)==translate("All"))) {
         rand_glo();
      } else {
         categ_glo($gcat, $debut);
      }
      glofoot();
      break;
}
   echo '</div></div>';
   include ("footer.php");
?>
