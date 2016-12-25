<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/*                                                                      */
/* NPDS Copyright (c) 2002-2015 by Philippe Brunier                     */
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
/* Changement de nom du module version Rev16 par jpb/phr mars 2016      */
/************************************************************************/

// For More security
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security

if (file_exists('modules/'.$ModPath.'/admin/pages.php')) {
   include ('modules/'.$ModPath.'/admin/pages.php');
}

include ("modules/$ModPath/annonce.conf.php");

   if ($op=="Soumettre") {
      if (isset($user) and ($id_user!="") and ($prix!="")) {
      } else {
         redirect_url("modules.php?ModPath=$ModPath&amp;ModStart=index");
      }
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

      $query="insert into $table_annonces (id, id_user, id_cat, tel, tel_2, code, ville, date, text, en_ligne, prix)";
      $query.=" values ('','$id_user', '$id_cat', '$tel', '$tel_2', '$code', '$ville', '".time()."', '$text', '0', '$prix')";
      $res=sql_query($query);

      $quer="select categorie from $table_cat where id_cat='$id_cat'";
      $sel=sql_query($quer);
      $sel=sql_fetch_assoc($sel);
      $categorie=$sel['categorie'];

      global $notify_email, $notify_from;
      $message="catégorie : ".StripSlashes($categorie)."<br /><br />";
      $message.="texte de l'annonce : ".StripSlashes(StripSlashes($text))."<br />";
      include ("signat.php");
      @send_email($notify_email, "Nouvelle annonce publiée (module annonces)", $message, $notify_from , true, "html");
      redirect_url ("modules.php?ModPath=$ModPath&ModStart=index");
      die();
   }

   include ("header.php");
   echo '<div class="card"><div class="card-block">';
   echo '<p class="lead">'.$mess_acc.'<span class="pull-xs-right"><a class="btn btn-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&ModStart=photosize" data-toggle="tooltip" data-placement="left" title="Pour redimensionner une image"><i class="fa fa-picture-o" aria-hidden="true"></i> Outil</a></span></p>';
  
   $filename = 'modules/'.$ModPath.'/intro.html';

   echo '<p class="text-xs-center">
<button type="button" class="btn btn-primary-outline btn-sm" data-toggle="modal" data-target="#intro">Mode d\'emploi</button>&nbsp;&nbsp;<button type="button" class="btn btn-primary-outline btn-sm" data-toggle="modal" data-target="#ment">Mentions légales</button></p>

<div class="modal fade" id="intro" tabindex="-1" role="dialog" aria-labelledby="explication" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="explication">Mode d\'emploi</h4>
      </div>
      <div class="modal-body">';
   include($filename);
   echo '
   </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="mentlegal">Mentions l&eacute;gales des conditions d\'utilisation des petites annonces</h4>
      </div>
      <div class="modal-body">';
   include($filename2);
   echo '
   </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>';



   if (isset($user)) {
      $userinfo=getusrinfo($user);
   } else {
      redirect_url("modules.php?ModPath=$ModPath&amp;ModStart=index");
   }

   echo "<form class=\"form-horizontal\" method=\"post\" action=\"modules.php\" name=\"adminForm\">
         <input type=\"hidden\" name=\"ModPath\" value=\"$ModPath\" />
         <input type=\"hidden\" name=\"ModStart\" value=\"annonce_form\" />
         <input type=\"hidden\" name=\"id_user\" value=\"".$userinfo['uid']."\" />";
   echo '<p>'.$mess_requis.'</p>';
   echo '<fieldset disabled>';
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">Nom</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="" placeholder="'.$userinfo["uname"].'">
    </div>
  </div>';
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">M&egrave;l</label>
    <div class="col-sm-8">
      <input type="email" class="form-control" id="" placeholder="'.$userinfo['email'].'">
    </div>
  </div>';
  echo '</fieldset>';
  
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">T&eacute;l fixe</label>
    <div class="col-sm-8">
        <div class="input-group">
      <div class="input-group-addon">+33.0</div>
      <input type="text" name="tel" class="form-control" id="" value="" placeholder="num&eacute;ro sans le 0">
      </div>
    </div>
  </div>';
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">T&eacute;l portable</label>
    <div class="col-sm-8">
        <div class="input-group">
      <div class="input-group-addon">+33.0</div>
      <input type="text" name="tel_2" class="form-control" id="" value="" placeholder="num&eacute;ro sans le 0">
      </div>
    </div>
  </div>';
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">Code postal</label>
    <div class="col-sm-8">
      <input type="text" name="code" class="form-control" id="" value="" placeholder="format 00000">
    </div>
  </div>';
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">Ville</label>
    <div class="col-sm-8">
      <input type="text" name="ville" class="form-control" id="" value="" placeholder="">
    </div>
  </div>';
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">Cat&eacute;gorie</label>
    <div class="col-sm-8">';

   echo '<select class="form-control c-select" name="id_cat">';
   $select = sql_query("select * from $table_cat where id_cat2='0' order by id_cat");
   while($e= sql_fetch_assoc($select)) {
      echo "<option value='".$e['id_cat']."'";
      if ($sel=="") {
         $sel="selected=\"selected\"";
         echo $sel;
      }
      echo ">".stripslashes($e['categorie'])."</option>\n";
      $select2 = sql_query("select * from $table_cat where id_cat2='".$e['id_cat']."' order by id_cat");
      while ($e2 = sql_fetch_assoc($select2)) {
         echo "<option value='".$e2['id_cat']."'";
         echo ">&nbsp;&nbsp;&nbsp;".stripslashes($e2['categorie'])."</option>\n";
      }
   }
   echo '</select>';
   echo '</div></div>';

   echo '
   <div class="form-group row">
    <label for="" class="col-sm-12 form-control-label">Libell&eacute; de l\'annonce <span class="text-danger"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
    <div class="col-sm-12">';

   echo "<textarea name=\"xtext\" class=\"tin form-control\" rows=\"40\"></textarea>\n";

   if ($editeur)
      echo aff_editeur("xtext", "true");
/*   global $tiny_mce;
   if (!$tiny_mce) {
      echo "<script type=\"text/javascript\" src=\"modules/$ModPath/js/verif_form.js\"></script>";
   }*/


   echo '</div></div>';

   //prix
   if ($aff_prix) {
   echo '
   <div class="form-group row">
      <label for="" class="col-sm-4 form-control-label">Prix en '.$prix_cur.'</label>
      <div class="col-sm-8">
      <div class="input-group">
      <input type="text" name="prix" class="form-control" id="" value="'.$prix.'" placeholder="">
      <div class="input-group-addon">.00</div>
      </div>
      </div>
   </div>';
   } else {
      echo "<input type=\"hidden\" name=\"prix\" value=\"$prix\" />\n";
   }

   if ($tiny_mce) {
      echo '<button type="submit" name="op" class="btn btn-primary-outline btn-sm" value="Soumettre"><i class="fa fa-check" aria-hidden="true"></i> Soumettre</button>';
   } else {
      echo "<input type=\"submit\" class=\"btn btn-primary\" name=\"op\" value=\"Soumettre\" onClick=\"MM_validateForm('nom','','R','mail','','RisEmail','xtext','','R');return document.MM_returnValue\" />";
   }
   echo '</form>';
   
   $filename = "modules/$ModPath/pied.html";
   if (file_exists($filename)) {
      include($filename);
   }

   echo '<p><a class="btn btn-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=index"><i class="fa fa-home" aria-hidden="true"></i> Retour</a></p>';
   echo '</div></div>';
include ("footer.php");
?>