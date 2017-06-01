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
/* npds_encapsuleur  v 5.0                                              */
/*                                                                      */
/* 05.01.2001 - martvin@box43.pl                                        */
/* 12.09.2002 - Achel_Jay, Benjee, Capcaverne                           */
/* 02.11.2002 - Snipe                                                   */
/* 25.11.2008 - Lopez - MAJ pour Evolution                              */
/* 2010 et 2011 - Adaptation REvolution                                 */
/* Changement de nom du module version Rev16 par jpb/phr jan  2017      */
/************************************************************************/

// cartouche de sécurité ==> requis !!
if (!strstr($PHP_SELF,'admin.php')) { Access_Error(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}

$f_meta_nom ='npds_encapsuleur';
//==> controle droit
admindroits($aid,$f_meta_nom);
//<== controle droit

$hlpfile ='';

if ($admin) {
   global $language, $ModPath, $ModStart, $NPDS_Prefix;
   include ("modules/$ModPath/encap.conf.php");
   include_once('modules/'.$ModPath.'/lang/encapsuleur-'.$language.'.php');

// Paramètres utilisé par le script
$ThisFile = "admin.php?op=Extend-Admin-SubModule&amp;ModPath=$ModPath&amp;ModStart=$ModStart";

function AfficheHaut($ModPath, $ModStart) {
   global $ThisFile, $NPDS_Prefix, $hlpfile;
   $version = 'V.5.0';

   GraphicAdmin($hlpfile);
   echo '
   <div id="adm_men">
   <h2><img class="" src="modules/npds_encapsuleur/npds_encapsuleur.png" alt="icon_npds_encapsuleur"> '.encap_translate('Encapsuleur').'<small class="float-right">'.$version.'</small></h2>';

   $result = sql_query("SELECT * FROM ".$NPDS_Prefix."encapsulation ORDER BY id ASC");
   if ($result) {
      $nombre = sql_num_rows($result);
      echo '<p class="lead"><span class="badge badge-default">'.$nombre.'</span> '.encap_translate("encapsulation(s) dans la table").'</p>';
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.encap_translate("Pour modifier un enregistrement, cliquez sur son nom").'</p>';
      echo '<table class="table table-responsive table-bordered table-hover table-sm"><thead class="thead-default"><tr><th>Id</th><th>'.encap_translate("Nom").'</th><th>'.encap_translate("Forme").'</th><th>'.encap_translate("Adresse").'</th><th>'.encap_translate("Type").'</th><th>'.encap_translate("Display").'</th><th>'.encap_translate("Hauteur").'</th><th>'.encap_translate("Scroll").'</th><th>'.encap_translate("Bloc").'</th><th>'.encap_translate("Titre").'</th><th colspan="2" width="50">&nbsp;</th></tr></thead>';
      while ($ligne = sql_fetch_assoc($result)) {
         echo "<tbody><tr><td>".$ligne['id']."</td><td><a href=\"$ThisFile&amp;subop=editform&amp;id=".$ligne['id']."#edit\">".$ligne['nom']."</a></td><td>".$ligne['form']."</td><td style=\"font-size:10px;\">".$ligne['adresse']."</td><td>".$ligne['type']."</td>";
         if ($ligne['display']==1)
            echo "<td>".encap_translate("Oui")."</td>";
         else
            echo "<td>".encap_translate("Non")."</td>";
         echo "<td>".$ligne['height']."</td><td>".$ligne['scroll']."</td><td>".$ligne['block']."</td><td style=\"font-size:10px;\">".$ligne['titre']."</td>";
         echo '<td><a href="'.$ThisFile.'&amp;subop=accdelete&amp;id='.$ligne['id'].'"><span  data-toggle="tooltip" data-placement="bottom" title="'.encap_translate("Effacer").'"><i class="fa fa-trash-o fa-lg text-danger" aria-hidden="true"></i></span></a></td>';
         echo '<td><a href="'.$ThisFile.'&amp;subop=acclien&amp;nom='.$ligne['nom'].'"><span  data-toggle="tooltip"  data-placement="bottom" title="'.encap_translate("Lien").'"><i class="fa fa-link fa-lg" aria-hidden="true"></i></span></a></td></tr>
         </tbody>';
      }
      echo '</table>';
     echo '<br />';
   } else {
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.encap_translate("Désolé, cette requête ne renvoie aucun résultat").'</p>';
   }
}

function AddEditBas($ModPath, $ModStart, $subop){
   global $ThisFile, $encap_height, $id, $NPDS_Prefix;
   settype($nom,'string');
   settype($display,'string');
   settype($type,'string');
   settype($form,'string');
   settype($scroll,'string');
   settype($adresse,'string');
   settype($height,'integer');
   settype($block,'integer');
   settype($titre,'string');
   settype($tit,'integer');

   if ($subop=='addform'){
      echo '<p class="lead"><i class="fa fa-plus mr-2" aria-hidden="true"></i>'.encap_translate("Ajouter un enregistrement").'</p>';
   } elseif ($subop=='editform') {
      echo '<a name="edit"></a>';
      echo '<p class="lead">'.encap_translate("Modifier cet enregistrement").'</p>';
      $sql = "SELECT * FROM ".$NPDS_Prefix."encapsulation WHERE id='$id'";
      $result = sql_query($sql);
      $ligne = sql_fetch_assoc($result);
      $id = $ligne['id'];
      $nom = $ligne['nom'];
      $display = $ligne['display'];
      $type= $ligne['type'];
      $form= $ligne['form'];
      $adresse = $ligne['adresse'];
      $height = $ligne['height'];
      $scroll = $ligne['scroll'];
      $block = $ligne['block'];
      $titre = $ligne['titre'];
      $tit = $ligne['tit'];
   } else {
     exit();
   }  
   echo '
   <div class="card mb-2">
      <div class="card-block">
         <form action="admin.php" method="post">
            <input type="hidden" name="op" value="Extend-Admin-SubModule" />
            <input type="hidden" name="ModPath" value="'.$ModPath.'" />
            <input type="hidden" name="ModStart" value="'.$ModStart.'" />';
   if ($subop=='addform'){
      echo '
            <input type="hidden" name="subop" value="accadd" />';
   } else {
      echo '
            <input type="hidden" name="subop" value="accedit" />
            <input type="hidden" name="id" value="'.$id.'" />';
   }
   echo '
            <div class="form-group row">
               <label for="" class="col-sm-3 col-form-label"><strong>'.encap_translate("Nom").'</strong></label>
               <div class="col-sm-9">
                  <input type="text" class="form-control" id="" name="nom" value="'.$nom.'" placeholder="'.encap_translate("Nom").'">
               </div>
            </div>
            <div class="form-group row">
               <label for="" class="col-sm-3 col-form-label"><strong>'.encap_translate("Display").'</strong></label>
               <div class="col-sm-3">
                  <select name="display" class="custom-select">
                     <option value="1"';
   if (!strcmp("$display", "1")) {echo 'selected="selected"';}
      echo '>1
                     <option value="0"';
   if (!strcmp("$display", "0")) {echo 'selected="selected"';}
      echo '>0
                  </select>
               </div>
            </div>
            <div class="form-group row">
               <label for="" class="col-sm-3 col-form-label"><strong>'.encap_translate("Type").'</strong></label>
               <div class="col-sm-4">
                  <select name="type" class="custom-select">
                     <option value="interne"';
   if (!strcmp("$type", "interne")) {echo 'selected="selected"';}
      echo '>'.encap_translate("Interne").'
                     <option value="externe"';
   if (!strcmp("$type", "externe")) {echo 'selected="selected"';}
      echo '>'.encap_translate("Externe").'
                  </select>
               </div>
            </div>
            <div class="form-group row">
               <label for="" class="col-sm-3 col-form-label"><strong>'.encap_translate("Forme").'</strong></label>
               <div class="col-sm-4">
                  <select name="form" class="custom-select">
                     <option value="http"';
   if (!strcmp("$form", "http")) {echo 'selected="selected"';}
      echo '>http
                     <option value="https"';
   if (!strcmp("$form", "https")) {echo 'selected="selected"';}
      echo '>https
                     <option value="ftp"';
   if (!strcmp("$form", "ftp")) {echo 'selected="selected"';}
      echo '>ftp
                  </select>
               </div>
            </div>
            <div class="form-group row">
               <label for="" class="col-sm-3 col-form-label"><strong>'.encap_translate("Adresse").'</strong></label>
               <div class="col-sm-9">
                  <input type="text" class="form-control" id="" name="adresse" value="'.$adresse.'" placeholder="'.encap_translate("Adresse").'" />
                  <small class="form-text text-muted">'.encap_translate("Adresse web sans http:// si externe ou nom du fichier si interne").'</small>
               </div>
            </div>
            <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>'.encap_translate("Hauteur").'</strong></label>
            <div class="col-sm-3">
            <input type="text" class="form-control" id="" name="height" value="'.$height.'" placeholder="'.$encap_height.'">
            </div>
         </div>
         <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>'.encap_translate("Scroll").'</strong></label>
            <div class="col-sm-4">
               <select name="scroll" class="custom-select">
                  <option value="non"';
   if (!strcmp("$scroll", "non")) {echo 'selected="selected"';}
      echo '>'.encap_translate("Non").'
                  <option value="oui"';
   if (!strcmp("$scroll", "oui")) {echo 'selected="selected"';}
      echo '>'.encap_translate("Oui").'
                  <option value="auto"';
   if (!strcmp("$scroll", "auto")) {echo 'selected="selected"';}
      echo '>Auto
               </select>
            </div>
         </div>
         <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label"><strong>'.encap_translate("Bloc").'</strong></label>
            <div class="col-sm-3">
               <select name="block" class="custom-select">
                  <option value="0"';
   if (!strcmp("$block", "0")) {echo 'selected="selected"';}
      echo '>0
                  <option value="1"';
   if (!strcmp("$block", "1")) {echo 'selected="selected"';}
      echo '>1
                  <option value="-1"';
   if (!strcmp("$block", "-1")) {echo 'selected="selected"';}
      echo '>-1
                  <option value="2"';
   if (!strcmp("$block", "2")) {echo 'selected="selected"';}
      echo '>2  
                  <option value="3"';
   if (!strcmp("$block", "3")) {echo 'selected="selected"';}
      echo '>3 
                  <option value="4"';
   if (!strcmp("$block", "4")) {echo 'selected="selected"';}
      echo '>4 
            </select>
            <div>
               <button type="button" class="btn btn-outline-info btn-sm mt-2" data-toggle="modal" data-target="#bd-conf">'.encap_translate("Aide").'</button>
            </div>
            <div class="modal fade" id="bd-conf" tabindex="-1" role="dialog" aria-labelledby="configuration" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title">'.encap_translate("Configuration des blocs du portail").'</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <p><strong>'.encap_translate("choix").' <span class="badge badge-default">-1</span></strong> = '.encap_translate("centrale seule").'<br />
                        <strong>'.encap_translate("choix").' <span class="badge badge-default ml-1">0</span></strong> = '.encap_translate("colonne gauche").' + '.encap_translate("colonne centrale").'<br />
                        <strong>'.encap_translate("choix").' <span class="badge badge-default ml-1">1</span></strong> = '.encap_translate("colonne gauche").' + '.encap_translate("colonne centrale").' + '.encap_translate("colonne droite").'<br />
                        <strong>'.encap_translate("choix").' <span class="badge badge-default ml-1">2</span></strong> = '.encap_translate("colonne centrale").' + '.encap_translate("colonne droite").'<br />
                        <strong>'.encap_translate("choix").' <span class="badge badge-default ml-1">3</span></strong> = '.encap_translate("colonne gauche").' + '.encap_translate("colonne droite").' + '.encap_translate("colonne centrale").'<br />
                        <strong>'.encap_translate("choix").' <span class="badge badge-default ml-1">4</span></strong> = '.encap_translate("colonne centrale").' + '.encap_translate("colonne gauche").' + '.encap_translate("colonne droite").'</p>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">'.encap_translate("Fermer").'</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="form-group row">
      <label for="" class="col-sm-3 col-form-label"><strong>'.encap_translate("Titre").'</strong></label>
      <div class="col-sm-9">
      <input type="text" class="form-control" id="" name="titre" value="'.$titre.'" placeholder="'.encap_translate("Titre").'">
      </div>
      </div>';
echo '<div class="form-group row">
      <label for="" class="col-sm-3 col-form-label"><strong>'.encap_translate("Affichage du titre").'</strong></label>
      <div class="col-sm-3">';
echo '<select name="tit" class="custom-select">
         <option value="1"';
            if (!strcmp("$tit", "1")) {echo "selected";}
            echo ">".encap_translate("Oui")."
         <option value=\"0\"";
            if (!strcmp("$tit", "0")) {echo "selected";}
            echo ">".encap_translate("Non")."
      </select>";
echo '
         </div>
            </div>
            <button type="submit" class="btn btn-outline-primary btn-sm mr-2" name="valider" value="'.encap_translate("Enregistrer").'" ><i class="fa fa-check" aria-hidden="true"></i> '.encap_translate("Enregistrer").'</button>
            <a class="btn btn-outline-danger btn-sm" href="'.$ThisFile.'">'.encap_translate("Annuler").'</a>
         </form>
      </div>
   </div>
</div>';
}

function AccAdd($nom,$display,$type,$form,$adresse,$height,$scroll,$block,$tit,$titre){
   global  $encap_height, $NPDS_Prefix;
   if ($nom!='') {
      $verif = "SELECT id from ".$NPDS_Prefix."encapsulation WHERE nom='$nom'";
      if ($num = sql_num_rows(sql_query($verif))) {
         echo '<p class="lead text-danger"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.encap_translate("Le nom saisi existe déjà").'</p>';
      } else {
        if ($height=="") { $height=$encap_height; }
        $sql = "INSERT INTO ".$NPDS_Prefix."encapsulation (nom,display,type,form,adresse,height,scroll,block,tit,titre) VALUES ('$nom','$display','$type','$form','$adresse','$height','$scroll','$block', '$tit', '$titre')";
        $result = sql_query($sql);
        echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.encap_translate("Enregistrement effectué").'</p>';
      }
   }
}

function AccEdit($id,$nom,$display,$type,$form,$adresse,$height,$scroll,$block,$tit,$titre){
   global  $encap_height, $NPDS_Prefix;
   $uid=0;
    if($height=="") { $height=$encap_height; }
   $sql = "UPDATE ".$NPDS_Prefix."encapsulation SET nom='$nom', display=$display, type='$type', form='$form', adresse='$adresse',height='$height',scroll='$scroll',block='$block', tit='$tit',titre='$titre'  WHERE id=$id";
   if($result = sql_query($sql)){
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.encap_translate("Mise à Jour effectuée").'</p>';
   }
   else {
      echo '<p class="lead text-danger"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.encap_translate("Mise à Jour non effectuée").'</p>';
   }
}

function Accdelete($id){
   global  $NPDS_Prefix;
   $sql = "DELETE FROM ".$NPDS_Prefix."encapsulation WHERE id=$id";
   if ($result = sql_query($sql)) {
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.encap_translate("Enregistrement N°").' '.$id.' '.encap_translate("effacé").'</p>';
   } else {
      echo '<p class="lead text-danger"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.encap_translate("Erreur de suppression de l'enregistrement N°").' '.$id.'</p>';
   }
}

function Acclink($nom){
   global  $nuke_url, $NPDS_Prefix;
   $sql = "SELECT * FROM ".$NPDS_Prefix."encapsulation WHERE nom='$nom'";
   if ($result = sql_query($sql)) {
      echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.encap_translate("Le lien de votre page encapsulée est").' :</p>';
      echo '<div class="alert alert-info" role="alert"><a href="'.$nuke_url.'/modules.php?ModPath=npds_encapsuleur&amp;ModStart=encapsulation&amp;page='.$nom.'">'.$nuke_url.'/modules.php?ModPath=npds_encapsuleur&amp;ModStart=encapsulation&amp;page='.$nom.'</a></div>';
   } else {
      echo '<p class="lead text-danger"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.encap_translate("Le lien n'existe pas").'</p>';
   }
}

   settype($subop,'string');
   switch($subop) {
      case "accadd":
      if ($nom!='')
         AfficheHaut($ModPath, $ModStart);
         Accadd($nom,$display,$type,$form,$adresse,$height,$scroll,$block,$tit,$titre);
         Acclink($nom);
         AddEditBas($ModPath,$ModStart,'addform');
         break;
      case "accedit":
         AfficheHaut($ModPath, $ModStart);
         Accedit($id,$nom,$display,$type,$form,$adresse,$height,$scroll,$block,$tit,$titre);
         Acclink($nom);
         AddEditBas($ModPath,$ModStart,'addform');
         break;
      case "accdelete":
         AfficheHaut($ModPath, $ModStart);
         Accdelete($id);
         AddEditBas($ModPath,$ModStart,'addform');
         break;
      case "acclien":
         AfficheHaut($ModPath, $ModStart);
         Acclink($nom);
         AddEditBas($ModPath,$ModStart,'addform');
         break;
      case "editform":
         AfficheHaut($ModPath, $ModStart);
         AddEditBas($ModPath,$ModStart,'editform');
         break;
      default:
         AfficheHaut($ModPath, $ModStart);
         AddEditBas($ModPath,$ModStart,'addform');
         break;
   }
}

   include("footer.php");
?>