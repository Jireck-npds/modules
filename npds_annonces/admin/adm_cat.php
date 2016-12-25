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
   echo '<div class="row" id="adm_men">';
//   echo '<p class="lead">'.$mess_acc.'</p>';
   echo '<h3>Administration des catégories</h3>';

// Categories
if ($action=="ajouter") {
   if ($categorie!="") {
      $query="insert into $table_cat (id_cat,id_cat2,categorie) values ('','0','".addslashes($categorie)."')";
      $result= sql_query($query);
   } elseif ($categorieSCAT!="") {
      $query="insert into $table_cat (id_cat,id_cat2,categorie) values ('',$id_catSCAT,'".addslashes($categorieSCAT)."')";
      $result= sql_query($query);
   }
} elseif ($action=="supprimer") {
   if ($id_cat) {
      // annonces
      $query="delete from $table_annonces where id_cat='$id_cat'";
      $succes= sql_query($query);
      $query="select id_cat from $table_cat where id_cat2='$id_cat'";
      $succes= sql_query($query);
      while(list($id_Scat)= sql_fetch_row($succes)) {
         $query="delete from $table_annonces where id_cat='$id_Scat'";
         $succes2= sql_query($query);
      }
      // categories
      $query="delete from $table_cat where id_cat2='$id_cat'";
      $succes= sql_query($query);
      $query="delete from $table_cat where id_cat='$id_cat'";
      $succes= sql_query($query);
   } elseif ($id_catSCAT) {
      $query="delete from $table_annonces where id_cat='$id_catSCAT'";
      $succes= sql_query($query);
      $query="delete from $table_cat where id_cat='$id_catSCAT'";
      $succes= sql_query($query);
   }
} elseif ($action=="Modifier") {
   if ($categorie!="") {
      $query="update $table_cat set categorie='".addslashes($categorie)."' where id_cat=$id_cat";
      $succes= sql_query($query);
   } elseif ($categorieSCAT!="") {
      $query="update $table_cat set categorie='".addslashes($categorieSCAT)."' where id_cat=$id_catSCAT";
      $succes= sql_query($query);
   }
}

echo "<form method=\"post\" action=\"admin.php\">";
echo "<input type=\"hidden\" name=\"op\" value=\"Extend-Admin-SubModule\">\n";
echo "<input type=\"hidden\" name=\"ModPath\" value=\"$ModPath\">\n";
echo "<input type=\"hidden\" name=\"ModStart\" value=\"admin/adm_cat\">\n";
echo '
   <div class="form-group row">
      <label for="" class="col-sm-4 form-control-label"><i class="fa fa-plus fa-lg" aria-hidden="true"></i> Ajouter une cat&eacute;gorie</label>
      <div class="col-sm-8">
         <input type="text" name="categorie" class="form-control">
      </div>
   </div>
   <div class="form-group row">
      <div class="col-sm-offset-4 col-sm-8">
         <button name="action" class="btn btn-primary-outline" type="submit" value="ajouter"><i class="fa fa-check" aria-hidden="true"></i> Valider</button>
      </div>
   </div>
  ';
echo '<hr />';

echo '
   <div class="form-group row">
      <label for="" class="col-sm-4 form-control-label"><i class="fa fa-plus fa-lg" aria-hidden="true"></i> Ajouter une sous-cat&eacute;gorie dans</label>
      <div class="col-sm-8">';
echo "<select class=\"form-control c-select\" name=\"id_catSCAT\">\n";
$query_list="select * from $table_cat where id_cat2='0' order by id_cat";
$list= sql_query($query_list);
while($e= sql_fetch_assoc($list)) {
   $categorie=$e['categorie'];
   $id_cat=$e['id_cat'];
   echo "<option value='";
   echo $id_cat."'";
   if ($id_cat==$id_catSCAT) echo "selected=\"selected\"";
   echo ">";
   echo stripslashes($categorie);
   echo "</option>\n";
}
echo '</select></div></div>';
echo '
   <div class="form-group row">
      <div class="col-sm-offset-4 col-sm-8">';
echo '<input type="text" class="form-control" name="categorieSCAT">';
echo '</div></div>';
echo '
   <div class="form-group row">
      <div class="col-sm-offset-4 col-sm-8">';
echo '<button name="action" class="btn btn-primary-outline" type="submit" value="ajouter"><i class="fa fa-check" aria-hidden="true"></i> Valider</button>';
echo '</div></div>';
echo '</form>';
echo '<hr />';

$select= sql_query("select id_cat, categorie from $table_cat where id_cat2='0' order by id_cat");
$count= sql_num_rows($select);
if (!$count)
   echo '<p class="text-danger">Aucune cat&eacute;gorie pour le moment</p>';
while ($i= sql_fetch_assoc($select)) {
   $id_cat=$i['id_cat'];
   $categorie=stripslashes($i['categorie']);
   echo "<form method=\"post\" action=\"admin.php\">\n";
   echo "<input type=\"hidden\" name=\"op\" value=\"Extend-Admin-SubModule\">\n";
   echo "<input type=\"hidden\" name=\"ModPath\" value=\"$ModPath\">\n";
   echo "<input type=\"hidden\" name=\"ModStart\" value=\"admin/adm_cat\">\n";
   echo "<input type=\"hidden\" name=\"id_cat\" value=\"$id_cat\">\n";

echo '
   <div class="form-group row">
      <label for="" class="col-sm-2 form-control-label m-y-1"><strong>Cat&eacute;gorie</strong></label>
      <div class="col-sm-6">
         <input type="text" name="categorie" class="form-control m-y-1" value="'.$categorie.'">
      </div>
      <div class="col-sm-2">
         <input type="submit" name="action" class="btn btn-primary-outline btn-sm form-control m-y-1" value="Modifier">
      </div>
      <div class="col-sm-2">
      <button type="submit" class="btn btn-danger-outline btn-sm form-control m-y-1" name="action" value="Supprimer"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
      </div>  
   </div>';

   echo "</form>\n";


   $select2= sql_query("select id_cat, categorie from $table_cat where id_cat2='".$i['id_cat']."' order by id_cat");
   while ($i2= sql_fetch_assoc($select2)) {
   echo "<form method=\"post\" action=\"admin.php\">\n";
   echo "<input type=\"hidden\" name=\"op\" value=\"Extend-Admin-SubModule\" />\n";
   echo "<input type=\"hidden\" name=\"ModPath\" value=\"$ModPath\" />\n";
   echo "<input type=\"hidden\" name=\"ModStart\" value=\"admin/adm_cat\" />\n";

   echo '<div class="form-group row">
         <label for="" class="col-sm-2 form-control-label m-y-1"><em>Sous-cat&eacute;gorie</em></label>
         <div class="col-sm-6">';
   echo "<input type=\"hidden\" name=\"id_catSCAT\" value=\"".$i2['id_cat']."\" />\n";
   echo "<input type=\"text\" class=\"form-control m-y-1\" maxlength=\"55\" name=\"categorieSCAT\" value=\"".stripslashes($i2['categorie'])."\" />\n";
   echo '</div>';
   echo '<div class="col-sm-2">
         <input type="submit" class="btn btn-primary-outline btn-sm form-control m-y-1" name="action" value="Modifier" />
         </div>';
   echo '<div class="col-sm-2">';
   echo '<button type="submit" class="btn btn-danger-outline btn-sm form-control m-y-1" name="action" value="supprimer"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
   echo '</div></div>';
   echo "</form>\n";
   }
}

   echo '<p><a class="btn btn-primary-outline" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm"><i class="fa fa-home" aria-hidden="true"></i> Admin</a></p>';
   echo '</div>';
include ("footer.php");
?>