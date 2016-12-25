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
      $query.=" WHERE id='$id' and id_user='$cookie[0]'";
      $succes = sql_query($query);	  
	  global $notify_email, $notify_from;
      $message="Cat&eacute;gorie : ".StripSlashes($categorie)."<br /><br />";
      $message.="Texte de l'annonce : ".StripSlashes(StripSlashes($text))."<br />";
      include ("signat.php");
      @send_email($notify_email, "Annonce revalidation (module annonces)", $message, $notify_from , true, "html");	
   }
   if ($op=="Supprimer") {
      $query="delete from $table_annonces where id='$id' and id_user='$cookie[0]'";
      $succes = sql_query($query);
   }
   if ($succes)
      redirect_url ("modules.php?ModPath=$ModPath&ModStart=$ModStart");
}

   $succes = sql_query("select count(*) from $table_annonces where id_user='$cookie[0]' and en_ligne='1'");
   $count = sql_fetch_row($succes);
   $count=$count[0];
   if ($count==0) {
      redirect_url("modules.php?ModPath=$ModPath&ModStart=index");
   } else {
      include ("header.php");

   echo '<div class="card"><div class="card-block">';
//   echo '<p class="lead">'.$mess_acc.'</p>';      

      echo '<p>'.$del_sup_chapo.'</p>';
      echo '<p class="text-danger">'.$warning.'</p>';
   }
   $query="select count(*) from $table_annonces where id_user='$cookie[0]' and en_ligne='0'";
   $succes = sql_query($query);
   $count2 = sql_fetch_row($succes);

   if (!isset($min)) $min=0;
   $inf=$min+1;
   $max=1;
   echo '<p><a class="btn btn-primary-outline btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=annonce_form">Ajouter une annonce</a></p>';
   echo '<p>Vous avez <strong>'.$count.'</strong> annonce(s) en ligne et <strong>'.$count2[0].'</strong> en attente pour validation</p>';


   settype ($min, "integer");
   settype ($max, "integer");
   $query = "select * from $table_annonces where id_user='$cookie[0]' and en_ligne='1' order by id desc limit $min,$max";
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

      echo '<p><span class="label label-default">Annonce ID '.$id.'</span></p>';
   echo '  
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">T&eacute;l fixe</label>
    <div class="col-sm-8">
         <div class="input-group">
            <div class="input-group-addon">+33.0</div>
            <input type="text" name="tel" class="form-control" id="" value="'.$tel.'" placeholder="'.$tel.'">
         </div>
      </div>
  </div>';   
   echo '  
   <div class="form-group row">
    <label for="" class="col-sm-4 form-control-label">T&eacute;l portable</label>
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
    <label for="" class="col-sm-4 form-control-label">Cat&eacute;gorie</label>
    <div class="col-sm-8">';


      echo '<select class="form-control c-select" name="id_cat">';
      $select = sql_query("select * from $table_cat where id_cat2='0' order by id_cat");
      while($e= sql_fetch_assoc($select)) {
         echo "<option value='".$e['id_cat']."'";
         if ($e['id_cat']==$id_cat_sel) echo "selected";
         echo ">".stripslashes($e['categorie'])."</option>\n";
         $select2 = sql_query("select * from $table_cat where id_cat2='".$e['id_cat']."' order by id_cat");
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
    <label for="" class="col-sm-12 form-control-label">Libell&eacute; de l\'annonce</label>
    <div class="col-sm-12">';

      echo "<textarea name=\"xtext\" class=\"tin form-control\" rows=\"40\">$text</textarea>\n";
      if ($editeur)
         echo aff_editeur("xtext", "true");

//      if (!$tiny_mce) {
//         echo "<script type=\"text/javascript\" src=\"modules/$ModPath/js/verif_form.js\"></script>";
//      }
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


      if ($tiny_mce) {
         echo '<button type="submit" name="op" class="btn btn-primary-outline btn-sm" value="Modifier"><i class="fa fa-check" aria-hidden="true"></i> Modifier</button>';
      } else {
         echo "<input type=\"submit\" class=\"bouton_standard\" name=\"op\" value=\"Modifier\" onClick=\"MM_validateForm('nom','','R','mail','','RisEmail','xtext','','R');return document.MM_returnValue\" />";
      }
      echo "&nbsp;&nbsp;";
      echo '<button type="submit" name="op" class="btn btn-danger-outline btn-sm" value="Supprimer"><i class="fa fa-trash" aria-hidden="true"></i> Supprimer</button>';

      echo "</form>\n";
   }

      echo '<br />';
   $pp=false;
   if ($min>0) {
      echo "<a href=\"modules.php?ModPath=$ModPath&amp;ModStart=modif_ann&amp;min=".($min-$max)."\" class=\"noir\">";
      echo "Annonce pr&eacute;cedente</a>&nbsp;&nbsp;";
      $pp=true;
   }
   if (($min+$max)<$count) {
      echo "<a href='modules.php?ModPath=$ModPath&amp;ModStart=modif_ann&amp;min=".($min+$max)."' class=\"noir\">";
      if ($pp) echo "|&nbsp;&nbsp;";
      echo "Annonce suivante</a>&nbsp;&nbsp;";
   }
   echo '<br /><br />'; 
   echo '<p><a class="btn btn-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&amp;ModStart=index"><i class="fa fa-home" aria-hidden="true"></i> Retour</a></p>';
   echo '</div></div>';
include ("footer.php");
?>