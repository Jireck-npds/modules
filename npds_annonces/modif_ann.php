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
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security

if (file_exists('modules/'.$ModPath.'/admin/pages.php')) {
   include ('modules/'.$ModPath.'/admin/pages.php');
}
include ("modules/$ModPath/annonce.conf.php");

if (isset($user)) {
   settype($id,"integer");
   settype($id_cat,"integer");
   if ($op=="Modifier") {
      $tel=trim(removeHack($tel));
      $tel_2=trim(removeHack($tel_2));
      $code=trim(removeHack($code));
      $ville=addslashes(trim(removeHack($ville)));
      $text=removeHack(stripslashes(FixQuotes($xtext)));
      $prix=str_replace(",",".",$prix);
      settype($prix, "double");

      $query="UPDATE $table_annonces";
      $query.=" SET id_cat='$id_cat', tel='$tel', tel_2='$tel_2', code='$code', ville='$ville', date='".time()."', text='$text', en_ligne='0', prix='$prix'";
      $query.=" WHERE id='$id' AND id_user='$cookie[0]'";
      $succes = sql_query($query);
      global $notify_email, $notify_from;
      $message="Catégorie : ".StripSlashes($categorie)."<br /><br />";
      $message.="Texte de l'annonce : ".StripSlashes(StripSlashes($text))."<br />";
      include ("signat.php");
      @send_email($notify_email, "Annonce revalidation (module annonces)", $message, $notify_from , true, "html");
   }
   if ($op=="Supprimer") {
      $query="DELETE FROM $table_annonces WHERE id='$id' AND id_user='$cookie[0]'";
      $succes = sql_query($query);
   }
   if ($succes)
      redirect_url ("modules.php?ModPath=$ModPath&ModStart=$ModStart");
}

   $succes = sql_query("SELECT count(*) FROM $table_annonces WHERE id_user='$cookie[0]' AND en_ligne='1'");
   $count = sql_fetch_row($succes);
   $count=$count[0];
   if ($count==0) {
      redirect_url("modules.php?ModPath=$ModPath&ModStart=index");
   } else {
      include ("header.php");

   echo '<div class="card"><div class="card-block">';
   echo '<h3>Gestion de vos petites annonces</h3>';
   echo '<p>'.$del_sup_chapo.'</p>';
   echo '<p class="text-warning">'.$warning.'</p>';
   }
   $query="SELECT count(*) FROM $table_annonces WHERE id_user='$cookie[0]' AND en_ligne='0'";
   $succes = sql_query($query);
   $count2 = sql_fetch_row($succes);

   if (!isset($min)) $min=0;
   $inf=$min+1;
   $max=1;
   echo '<p><a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=annonce_form">Ajouter une annonce</a></p>';
   echo '<h4>Vous avez <span class="badge badge-pill badge-success">'.$count.'</span> annonce(s) en ligne et <span class="badge badge-pill badge-warning">'.$count2[0].'</span> en attente de validation</h4>';

   settype ($min, "integer");
   settype ($max, "integer");
   $query = "SELECT * FROM $table_annonces WHERE id_user='$cookie[0]' AND en_ligne='1' ORDER BY id DESC LIMIT $min,$max";
   $result = sql_query($query);
   while ($i=sql_fetch_array($result)) {
      $id=$i['id'];
      $tel=stripslashes($i['tel']);
      $tel_2=stripslashes($i['tel_2']);
      $code=$i['code'];
      $ville=stripslashes($i['ville']);
      $text=stripslashes($i['text']);
      $id_cat_sel=$i['id_cat'];
      $prix=$i['prix'];
      echo "<form method=\"post\" action=\"modules.php\" name=\"adminForm\">\n";
      echo "<input type=\"hidden\" name=\"ModPath\" value=\"$ModPath\" />\n";
      echo "<input type=\"hidden\" name=\"ModStart\" value=\"$ModStart\" />\n";
      echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\" />\n";

      echo '<p><span class="badge badge-default">Annonce ID '.$id.'</span></p>';
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">Tél fixe</label>
    <div class="col-sm-8">
         <div class="input-group">
            <div class="input-group-addon">+33.0</div>
            <input type="text" name="tel" class="form-control" id="" value="'.$tel.'" placeholder="'.$tel.'">
         </div>
      </div>
  </div>';
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">Tél portable</label>
    <div class="col-sm-8">
         <div class="input-group">
            <div class="input-group-addon">+33.0</div>
            <input type="text" name="tel_2" class="form-control" id="" value="'.$tel_2.'" placeholder="'.$tel_2.'">
         </div>
      </div>
  </div>';
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">Code postal</label>
    <div class="col-sm-8">
      <input type="text" name="code" class="form-control" id="" value="'.$code.'" placeholder="'.$code.'">
    </div>
  </div>';
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">Ville</label>
    <div class="col-sm-8">
      <input type="text" name="ville" class="form-control" id="" value="'.$ville.'" placeholder="'.$ville.'">
    </div>
  </div>';
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">Catégorie</label>
    <div class="col-sm-8">';

      echo '<select class="form-control c-select" name="id_cat">';
      $select = sql_query("SELECT * FROM $table_cat WHERE id_cat2='0' ORDER BY id_cat");
      while($e= sql_fetch_assoc($select)) {
         echo "<option value='".$e['id_cat']."'";
         if ($e['id_cat']==$id_cat_sel) echo "selected";
         echo ">".stripslashes($e['categorie'])."</option>\n";
         $select2 = sql_query("SELECT * FROM $table_cat WHERE id_cat2='".$e['id_cat']."' ORDER BY id_cat");
         while ($e2= sql_fetch_assoc($select2)) {
            echo "<option value='".$e2['id_cat']."'";
            if ($e2['id_cat']==$id_cat_sel) echo "selected";
            echo ">&nbsp;&nbsp;&nbsp;".stripslashes($e2['categorie'])."</option>\n";
         }
      }
      echo '</select>';
   echo '</div></div>';

   echo '
   <div class="form-group row">
    <label for="" class="col-sm-12 form-control-label">Libellé de l\'annonce</label>
    <div class="col-sm-12">';

      echo "<textarea name=\"xtext\" class=\"tin form-control\" rows=\"40\">$text</textarea>\n";
      if ($editeur)
         echo aff_editeur("xtext", "true");
   echo '</div></div>';
//prix
      if ($aff_prix) {
   echo '
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">Prix en '.$prix_cur.'</label>
    <div class="col-sm-8">

      <input type="text" name="prix" class="form-control" id="" value="'.$prix.'" placeholder="'.$prix.'">
    </div>
  </div>';

      } else {
         echo '<input type="hidden" name="prix" value="'.$prix.'">';
      }

      if ($tiny_mce) {
         echo '<button type="submit" name="op" class="btn btn-outline-primary btn-sm" value="Modifier"><i class="fa fa-check" aria-hidden="true"></i> Modifier</button>';
      } else {
         echo "<input type=\"submit\" class=\"btn btn-outline-danger btn-sm\" name=\"op\" value=\"Modifier\" onClick=\"MM_validateForm('nom','','R','mail','','RisEmail','xtext','','R');return document.MM_returnValue\" />";
      }
      echo '&nbsp;&nbsp;';
      echo '<button type="submit" name="op" class="btn btn-outline-danger btn-sm" value="Supprimer"><i class="fa fa-trash" aria-hidden="true"></i> Supprimer</button>';
      echo '</form>';
   }

   $pp=false;
  echo '<nav aria-label="">
       <ul class="pagination pagination-sm justify-content-center">';   
   if ($min>0) {
      echo '<li class="page-item"><a class="page-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=modif_ann&amp;min='.($min-$max).'">Annonce précédente</a></li>';
      $pp=true;
   }
   if (($min+$max)<$count) {
      echo '<li class="page-item"><a class="page-link" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=modif_ann&amp;min='.($min+$max).'">Annonce suivante</a></li>';
   }
   echo '</ul></nav>';
   echo '<p><a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=index"><i class="fa fa-home" aria-hidden="true"></i> Retour</a></p>';
   echo '</div></div>';
include ('footer.php');
?>