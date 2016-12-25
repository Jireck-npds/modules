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
if (!strstr($PHP_SELF,'admin.php')) { Access_Error(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security

include ("modules/$ModPath/annonce.conf.php");

if ($editeur)
   $max=1;

if ($action=="Valider") {
   settype($id,"integer");
   settype($id_cat,"integer");
   settype($Xid_cat,"integer");
   $tel=addslashes(trim(removeHack($tel)));
   $tel_2=addslashes(trim(removeHack($tel_2)));
   $code=trim(removeHack($code));
   $ville=addslashes(trim(removeHack($ville)));
   $text=removeHack(stripslashes(FixQuotes($xtext)));
   $prix=str_replace(",",".",$prix);
   settype($prix, "double");

   $query="UPDATE $table_annonces";
   $query.=" SET id_cat='$Xid_cat', tel='$tel', tel_2='$tel_2', code='$code', ville='$ville', date='".time()."', text='$text', en_ligne='1', prix='$prix'";
   $query.=" WHERE id='$id'";
   $succes= sql_query($query);
}
if ($action=="Supprimer") {
   settype($id,"integer");
   $query="delete from $table_annonces where id='$id'";
   $succes= sql_query($query);
   if ($succes) {
      $succes= sql_query($query);
   }
}

   echo '<div class="row" id="adm_men">';
   echo '<p class="lead">'.$mess_acc.'<span class="pull-xs-right"><a class="btn btn-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&ModStart=photosize"><i class="fa fa-picture-o" aria-hidden="true"></i> Outil</a></span></p>';
   if (!isset($id_cat_sel)) {
      $id_cat_sel=$id_cat;
      $select= sql_query("select categorie from $table_cat where id_cat='$id_cat'");
      list($categorie)= sql_fetch_row($select);
      echo '<p class="lead">Catégorie <span class="text-info">'.stripslashes($categorie).'</span>';
   }
   if (!isset($min))
      $min=0;

   if (!isset($sel)) {
      $query_count="select count(*) from $table_annonces where id_cat='$id_cat_sel'";
      $succes_count= sql_query($query_count);
      $count= sql_fetch_row($succes_count);
      $count=$count[0];
      $sel2="where id_cat='$id_cat_sel' order by en_ligne,id DESC limit $min,$max";
   } else {
      if ($sel==1) {
         $sel2="order by en_ligne,id DESC limit 0,1";
      } else {
         $sel2="order by en_ligne,id DESC limit 0,$sel";
      }
   }

   $query="select * from $table_annonces $sel2";
   $succes= sql_query($query);
   while ($values= sql_fetch_assoc($succes)) {
      $id = $values['id'];
      $id_user = $values['id_user'];
      $id_cat= $values['id_cat'];
      $tel = stripslashes($values['tel']);
      $tel_2 = stripslashes($values['tel_2']);
      $code = $values['code'];
      $ville = stripslashes($values['ville']);
      $text = stripslashes($values['text']);
      $prix = $values['prix'];

      //recup données utilisateur de l'annonce
      $query_2="select uname, email from ".$NPDS_Prefix."users where uid=$id_user";
      $succes_2= sql_query($query_2);
      list ($nom, $mail)= sql_fetch_row($succes_2);

      echo "<form method=\"post\" action=\"admin.php\" name=\"adminForm\">\n";
      echo "<input type=\"hidden\" name=\"op\" value=\"Extend-Admin-SubModule\" />\n";
      echo "<input type=\"hidden\" name=\"ModPath\" value=\"$ModPath\" />\n";
      echo "<input type=\"hidden\" name=\"ModStart\" value=\"admin/adm_ann\" />\n";
      echo "<input type=\"hidden\" name=\"id_cat\" value=\"$id_cat_sel\" />\n";
      echo "<input type=\"hidden\" name=\"min\" value=\"$min\" />\n";
      echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
      if (isset($sel))
         echo "<input type=\"hidden\" name=\"sel\" value=\"$sel\" />\n";

      //id de l'annonce
      echo '<p class="lead">
         <span class="label label-default label-pill pull-xs-right">';
      if ($values['en_ligne']=="1") {
         echo 'EN LIGNE';
      } elseif ($values['en_ligne']=="0") {
         echo '<span class="text-danger">EN ATTENTE</span>';
      } else {
      echo '<span class="text-warning">EN ARCHIVE</span>';
      }   
      echo '</span>
      Annonce ID '.$id.'
      </p>';
      echo '  
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">Nom</label>
         <div class="col-sm-8">
         <span class="form-control" readonly>'.$nom.'</span>
         </div>
      </div>';
      echo '  
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">M&egrave;l</label>
         <div class="col-sm-8">
         <span class="form-control" readonly>'.$mail.'</span>
         </div>
      </div>';
      echo '  
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">T&eacute;l fixe</label>
         <div class="col-sm-8">
         <input type="text" class="form-control" id="" name="tel" placeholder="'.$tel.'" value="'.$tel.'" readonly>
         </div>
      </div>';
      echo '  
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">T&eacute;l portable</label>
         <div class="col-sm-8">
         <input type="text" class="form-control" id="" name="tel_2" placeholder="'.$tel_2.'" value="'.$tel_2.'" readonly>
         </div>
      </div>';
      echo '  
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">Code postal</label>
         <div class="col-sm-8">
         <input type="text" class="form-control" id="" name="code" placeholder="'.$code.'" value="'.$code.'" readonly>
         </div>
      </div>';
      echo '  
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">Ville</label>
         <div class="col-sm-8">
         <input type="text" class="form-control" id="" name="ville" placeholder="'.$ville.'" value="'.$ville.'" readonly>
         </div>
      </div>';
      //cat de l'annonce
      echo '  
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">Catégorie</label>
         <div class="col-sm-8">';

      echo '<select class="form-control c-select" name="Xid_cat">';

      $select= sql_query("select * from $table_cat where id_cat2='0' order by id_cat");
      while($e= sql_fetch_assoc($select)) {
         echo "<option value='".$e['id_cat']."'";
         if ($e['id_cat']==$id_cat) echo "selected=\"selected\"";
         echo ">".stripslashes($e['categorie'])."</option>\n";
         $select2= sql_query("select * from $table_cat where id_cat2='".$e['id_cat']."' order by id_cat");
         while ($e2= sql_fetch_assoc($select2)) {
            echo "<option value='".$e2['id_cat']."'";
            if ($e2['id_cat']==$id_cat) echo "selected=\"selected\"";
            echo ">&nbsp;&nbsp;&nbsp;".stripslashes($e2['categorie'])."</option>\n";
         }
      }
      echo '</select>';
      echo '</div></div>';

      echo '
      <div class="form-group row">
         <label for="" class="col-sm-12 form-control-label">Libell&eacute; de l\'annonce <span class="text-danger"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
         <div class="col-sm-12">';
      echo '<textarea name="xtext" class="tin form-control" rows="50">'.$text.'</textarea>';
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
         echo "<input type=\"hidden\" name=\"prix\" value=\"$prix\" />\n";
      }
      //boutons supp modif

      echo "<input type=\"submit\" class=\"btn btn-primary-outline btn-sm\" name=\"action\" value=\"Valider\" />\n";
      echo "&nbsp;&nbsp;";
      echo "<input type=\"submit\" class=\"btn btn-danger-outline btn-sm\" name=\"action\" value=\"Supprimer\" />\n";

      echo "</form>\n";
   }

      echo '<br />';
   $pp=false;
   if (!isset($sel)) {
      if ($min>0) {
         echo '<a class="btn btn-secondary btn-sm pull-xs-right" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm_ann&amp;id_cat='.$id_cat_sel.'&amp;min='.($min-$max).'">Annonce pr&eacute;c&eacute;dente</a>';
         $pp=true;
      }
      if (($min+$max)<$count) {
         echo '<a class="btn btn-secondary btn-sm pull-xs-right" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm_ann&amp;id_cat='.$id_cat_sel.'&amp;min='.($min+$max).'">Annonce suivante</a>';
      }
   }

   echo '<p><a class="btn btn-primary-outline" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm"><i class="fa fa-home" aria-hidden="true"></i> Admin</a></p>';
   echo '</div>';
include ("footer.php");
?>