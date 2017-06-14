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
/* Module npds_annonces 3.0                                             */
/*                                                                      */
/*                                                                      */
/* Basé sur gadjo_annonces v 1.2 - Adaptation 2008 par Jireck et lopez  */
/* MAJ conformité XHTML pour REvolution 10.02 par jpb/phr en mars 2010  */
/* MAJ Dev - 2011                                                       */
/* Changement de nom du module version Rev16 par jpb/phr janv 2017      */
/************************************************************************/

// For More security
if (!stristr($_SERVER['PHP_SELF'],'modules.php')) { die(); }
if (strstr($ModPath,'..') || strstr($ModStart,'..') || stristr($ModPath, 'script') || stristr($ModPath, 'cookie') || stristr($ModPath, 'iframe') || stristr($ModPath, 'applet') || stristr($ModPath, 'object') || stristr($ModPath, 'meta') || stristr($ModStart, 'script') || stristr($ModStart, 'cookie') || stristr($ModStart, 'iframe') || stristr($ModStart, 'applet') || stristr($ModStart, 'object') || stristr($ModStart, 'meta')) {
   die();
}
// For More security

if (file_exists('modules/'.$ModPath.'/admin/pages.php')) {
   include ('modules/'.$ModPath.'/admin/pages.php');
}

include ("modules/$ModPath/annonce.conf.php");
include ("modules/$ModPath/lang/annonces-$language.php");
settype($op,'string');
   if ($op=="Soumettre") {
      if (autorisation(1)) {
         if (($id_user!='') and ($prix!='')) {
            $id_user=removeHack($id_user);
            $id_cat=removeHack($id_cat);
            $tel=addslashes(trim(removeHack($tel)));
            $tel_2=addslashes(trim(removeHack($tel_2)));
            $code=addslashes(trim(removeHack($code)));
            $ville=addslashes(trim(removeHack($ville)));
            $text=removeHack(stripslashes(FixQuotes($xtext)));
            $prix=str_replace(",",".",$prix);
            settype($prix, "double");
            settype ($id_user,"integer");
            settype ($id_cat,"integer");

            $query="INSERT INTO $table_annonces (id, id_user, id_cat, tel, tel_2, code, ville, date, text, en_ligne, prix)";
            $query.=" VALUES ('','$id_user', '$id_cat', '$tel', '$tel_2', '$code', '$ville', '".time()."', '$text', '0', '$prix')";
            $res=sql_query($query);

            $quer="SELECT categorie FROM $table_cat WHERE id_cat='$id_cat'";
            $sel=sql_query($quer);
            $sel=sql_fetch_assoc($sel);
            $categorie=$sel['categorie'];

            global $notify_email, $notify_from;
            $message='catégorie : '.StripSlashes($categorie).'<br /><br />';
            $message.="texte de l'annonce : ".StripSlashes(StripSlashes($text)).'<br />';
            include ("signat.php");
            @send_email($notify_email, "Nouvelle annonce publiée (module annonces)", $message, $notify_from , false, "html");
            redirect_url ("modules.php?ModPath=$ModPath&ModStart=index");
            die();
         }
         else {
            redirect_url("modules.php?ModPath=$ModPath&ModStart=index");
         }
      }
   }
   $filename = 'modules/'.$ModPath.'/intro.html';

   include ("header.php");
   echo '
   <div class="card">
      <div class="card-block">
         <p class="lead">'.aff_langue($mess_acc).'</p>
         <p><a class="btn btn-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=photosize" data-toggle="tooltip" data-placement="left" title="'.ann_translate("Pour préparer une image").'"><i class="fa fa-picture-o" aria-hidden="true"></i> '.ann_translate("Outil").'</a></p>
         <p class="text-center"><button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#intro">'.ann_translate("Mode d'emploi").'</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#ment">'.ann_translate("Mentions légales").'</button></p>
         <div class="modal fade" id="intro" tabindex="-1" role="dialog" aria-labelledby="explication" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h4 class="modal-title" id="explication">'.ann_translate("Mode d'emploi").'</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">';
               include($filename);
               echo '
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">'.ann_translate("Fermer").'</button>
                  </div>
               </div>
            </div>
         </div>';

   $filename2 = "modules/$ModPath/corps.html";

   echo '
   <div class="modal fade" id="ment" tabindex="-1" role="dialog" aria-labelledby="mentlegal" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" id="mentlegal">'.ann_translate("Mentions légales des conditions d'utilisation des petites annonces").'</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">';
   include($filename2);
   echo '
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">'.ann_translate("Fermer").'</button>
            </div>
         </div>
      </div>
   </div>';

   if (isset($user)) {
      $userinfo=getusrinfo($user);
   } else {
      redirect_url("modules.php?ModPath=$ModPath&ModStart=index");
   }

   echo '
   <form method="post" action="modules.php" name="adminForm">
      <input type="hidden" name="ModPath" value="'.$ModPath.'" />
      <input type="hidden" name="ModStart" value="annonce_form" />
      <input type="hidden" name="id_user" value="'.$userinfo['uid'].'" />
      <p class="lead"><i class="fa fa-info-circle" aria-hidden="true"></i> '.aff_langue($mess_requis).'</p>
      <fieldset disabled>
         <div class="form-group row">
            <label for="" class="col-sm-4 form-control-label">'.ann_translate("Nom").'</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="" placeholder="'.$userinfo["uname"].'">
            </div>
         </div>
         <div class="form-group row">
            <label for="" class="col-sm-4 form-control-label">'.ann_translate("Email").'</label>
            <div class="col-sm-8">
               <input type="email" class="form-control" id="" placeholder="'.$userinfo['email'].'">
            </div>
         </div>
      </fieldset>
      <div class="form-group row">
         <label for="tel" class="col-sm-4 form-control-label">'.ann_translate("Tél fixe").'</label>
         <div class="col-sm-8">
            <div class="input-group">
               <div class="input-group-addon">+33.0</div>
               <input type="text" name="tel" class="form-control" id="" value="" placeholder="'.ann_translate("sans").' 0">
            </div>
         </div>
      </div>
      <div class="form-group row">
         <label for="tel_2" class="col-sm-4 form-control-label">'.ann_translate("Tél portable").'</label>
         <div class="col-sm-8">
            <div class="input-group">
               <div class="input-group-addon">+33.0</div>
               <input type="text" name="tel_2" class="form-control" id="" value="" placeholder="'.ann_translate("sans").' 0">
            </div>
         </div>
      </div>
      <div class="form-group row">
         <label for="code" class="col-sm-4 form-control-label">'.ann_translate("Code postal").'</label>
         <div class="col-sm-8">
            <input type="text" name="code" class="form-control" id="code" value="" placeholder="">
            <small id="" class="form-text text-muted">format 00000</small>
         </div>
      </div>
      <div class="form-group row">
         <label for="ville" class="col-sm-4 form-control-label">'.ann_translate("Ville").'</label>
         <div class="col-sm-8">
            <input type="text" name="ville" class="form-control" id="ville" value="" placeholder="">
         </div>
      </div>
      <div class="form-group row">
         <label for="id_cat" class="col-sm-4 form-control-label">'.ann_translate("Catégorie").' <span class="text-danger"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
         <div class="col-sm-8">
            <select class="custom-select" name="id_cat">';
   $select = sql_query("SELECT * FROM $table_cat WHERE id_cat2='0' ORDER BY id_cat");
   settype($sel,'string');
   while($e= sql_fetch_assoc($select)) {
      echo '<option value="'.$e['id_cat'].'"';
      if ($sel=='') {
         $sel='selected="selected"';
         echo $sel;
      }
      echo '>'.stripslashes($e['categorie']).'</option>';
      $select2 = sql_query("SELECT * FROM $table_cat WHERE id_cat2='".$e['id_cat']."' ORDER BY id_cat");
      while ($e2 = sql_fetch_assoc($select2)) {
         echo '<option value="'.$e2['id_cat'].'"';
         echo '>&nbsp;&nbsp;&nbsp;'.stripslashes($e2['categorie']).'</option>';
      }
   }
   echo '
            </select>
         </div>
      </div>
      <div class="form-group row">
         <label for="xtext" class="col-sm-12 form-control-label">'.ann_translate("Libellé de l'annonce").' <span class="text-danger"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
         <div class="col-sm-12">
            <textarea name="xtext" class="tin form-control" rows="40"></textarea>';
   if ($editeur)
      echo aff_editeur('xtext','');
   echo '
         </div>
      </div>';

   //prix
   if ($aff_prix) {
   settype($prix,'string');// en attendant de savoir vraiment ce qui peut et doit arrivé pour cette valeur
   echo '
   <div class="form-group row">
      <label for="prix" class="col-sm-4 form-control-label">'.ann_translate("Prix en").' '.aff_langue($prix_cur).' <span class="text-danger"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
      <div class="col-sm-8">
         <div class="input-group">
            <input type="text" name="prix" class="form-control" required="required" id="prix" value="'.$prix.'" placeholder="" />
            <div class="input-group-addon">.00</div>
         </div>
      </div>
   </div>';
   } else {
      echo '
            <input type="hidden" name="prix" value="'.$prix.'" />';
   }

   if ($tiny_mce) {
      echo '<button type="submit" name="op" class="btn btn-outline-primary btn-sm" value="Soumettre"><i class="fa fa-check" aria-hidden="true"></i> '.ann_translate("Soumettre").'</button>';
   } else {
      echo "<input type=\"submit\" class=\"btn btn-primary\" name=\"op\" value=\"Soumettre\" onClick=\"MM_validateForm('nom','','R','mail','','RisEmail','xtext','','R');return document.MM_returnValue\" />";
   }
   echo '
   </form>';

   $filename = "modules/$ModPath/pied.html";
   if (file_exists($filename)) {
      include($filename);
   }

   echo '
   <p><a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=index"><i class="fa fa-home" aria-hidden="true"></i> '.ann_translate("Retour").'</a></p>
   </div>
   </div>';
include ("footer.php");
?>