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
if (!strstr($PHP_SELF,'admin.php')) { Access_Error(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security
$f_meta_nom ='npds_annonces';
//==> controle droit
admindroits($aid,$f_meta_nom);
//<== controle droit

include ("modules/$ModPath/annonce.conf.php");
include ("modules/$ModPath/lang/annonces-$language.php");
settype($action,'string');

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
   $prix=str_replace(',','.',$prix);
   settype($prix, "double");

   $query="UPDATE $table_annonces SET id_cat='$Xid_cat', tel='$tel', tel_2='$tel_2', code='$code', ville='$ville', date='".time()."', text='$text', en_ligne='1', prix='$prix' WHERE id='$id'";
   $succes= sql_query($query);
}
if ($action=="Supprimer") {
   settype($id,"integer");
   $query="DELETE FROM $table_annonces WHERE id='$id'";
   $succes= sql_query($query);
   if ($succes) {
      $succes= sql_query($query);
   }
}

   GraphicAdmin($hlpfile);

   echo '<div id="adm_men">';
   echo aff_langue($mess_acc);
   echo '
   <h3>Administration des annonces</h3>
   <p><a data-toggle="tooltip" data-placement="top" title="'.ann_translate("Pour préparer une image").'" class="btn btn-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&ModStart=photosize"><i class="fa fa-picture-o" aria-hidden="true"></i> '.ann_translate("Outil").'</a></p>';
   if (!isset($id_cat_sel)) {
   
      if(!strstr($id_cat, '|')) {
         $q ="='$id_cat'";
         settype($id_cat,'integer');
      } else {
         $q =" REGEXP '[[:<:]]".str_replace('|', '[[:>:]]|[[:<:]]',$id_cat)."[[:>:]]'";
      }

      $id_cat_sel=$id_cat;
      $select= sql_query("SELECT categorie FROM $table_cat WHERE id_cat$q");
      list($categorie)= sql_fetch_row($select);
      echo '<p class="lead">Catégorie : <span class="text-info">'.stripslashes($categorie).'</span></p>';
   }
   if (!isset($min))
      $min=0;

   if (!isset($sel)) {
      $query_count="SELECT COUNT(*) FROM $table_annonces WHERE id_cat$q";
      $succes_count= sql_query($query_count);
      $count= sql_fetch_row($succes_count);
      $count=$count[0];
      $sel2="WHERE id_cat$q ORDER BY en_ligne,id DESC LIMIT $min,$max";
   } else {
      if ($sel==1) {
         $sel2="ORDER BY en_ligne,id DESC LIMIT 0,1";
      } else {
         $sel2="ORDER BY en_ligne,id DESC LIMIT 0,$sel";
      }
   }

   $query="SELECT * FROM $table_annonces $sel2";
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
      $query_2="SELECT uname, email FROM ".$NPDS_Prefix."users WHERE uid='$id_user'";
      $succes_2= sql_query($query_2);
      list ($nom, $mail)= sql_fetch_row($succes_2);

      echo '
      <form method="post" action="admin.php" name="adminForm">
         <input type="hidden" name="op" value="Extend-Admin-SubModule" />
         <input type="hidden" name="ModPath" value="'.$ModPath.'" />
         <input type="hidden" name="ModStart" value="admin/adm_ann" />
         <input type="hidden" name="id_cat" value="'.$id_cat_sel.'" />
         <input type="hidden" name="min" value="'.$min.'" />
         <input type="hidden" name="id" value="'.$id.'" />';
      if (isset($sel))
         echo '
         <input type="hidden" name="sel" value="'.$sel.'" />';

//id de l'annonce
      echo '
      <p class="lead">'.ann_translate("Annonce").' ID : <span class="badge badge-secondary">'.$id.'</span>';
      if ($values['en_ligne']=="1") {
         echo '<span class="badge badge-success float-right">'.ann_translate("En ligne").'</span>';
      } elseif ($values['en_ligne']=="0") {
         echo '<span class="badge badge-danger mt-1 float-right">'.ann_translate("En attente").'</span>';
      } else {
      echo '<span class="badge badge-secondary float-right">'.ann_translate("En archive").'</span>';
      }
      echo '</p>';

      echo '
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">'.ann_translate("Nom").'</label>
         <div class="col-sm-8">
         <span class="form-control">'.$nom.'</span>
         </div>
      </div>
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">'.ann_translate("Email").'</label>
         <div class="col-sm-8">
         <span class="form-control">'.$mail.'</span>
         </div>
      </div>
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">'.ann_translate("Tél fixe").'</label>
         <div class="col-sm-8">
         <input type="text" class="form-control" id="" name="tel" placeholder="'.$tel.'" value="'.$tel.'">
         </div>
      </div>
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">'.ann_translate("Tél portable").'</label>
         <div class="col-sm-8">
         <input type="text" class="form-control" id="" name="tel_2" placeholder="'.$tel_2.'" value="'.$tel_2.'">
         </div>
      </div>
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">'.ann_translate("Code postal").'</label>
         <div class="col-sm-8">
         <input type="text" class="form-control" id="" name="code" placeholder="'.$code.'" value="'.$code.'">
         </div>
      </div>
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">'.ann_translate("Ville").'</label>
         <div class="col-sm-8">
         <input type="text" class="form-control" id="" name="ville" placeholder="'.$ville.'" value="'.$ville.'">
         </div>
      </div>
      <div class="form-group row">
         <label for="" class="col-sm-4 form-control-label">'.ann_translate("Catégorie").' <i class="fa fa-asterisk text-danger" aria-hidden="true"></i></label>
         <div class="col-sm-8">
            <select class="custom-select" name="Xid_cat">';

      $select= sql_query("SELECT * FROM $table_cat WHERE id_cat2='0' ORDER BY id_cat");
      while($e= sql_fetch_assoc($select)) {
         echo "<option value='".$e['id_cat']."'";
         if ($e['id_cat']==$id_cat) echo "selected=\"selected\"";
         echo ">".stripslashes($e['categorie'])."</option>\n";
         $select2= sql_query("SELECT * FROM $table_cat WHERE id_cat2='".$e['id_cat']."' ORDER BY id_cat");
         while ($e2= sql_fetch_assoc($select2)) {
            echo "<option value='".$e2['id_cat']."'";
            if ($e2['id_cat']==$id_cat) echo "selected=\"selected\"";
            echo ">&nbsp;&nbsp;&nbsp;".stripslashes($e2['categorie'])."</option>\n";
         }
      }
      echo '
            </select>
         </div>
      </div>
      <div class="form-group row">
         <label for="" class="col-sm-12 form-control-label">'.ann_translate("Libellé de l'annonce").' <span class="text-danger"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
         <div class="col-sm-12">';
      echo '<textarea name="xtext" class="tin form-control" rows="50">'.$text.'</textarea>';
      if ($editeur)
         echo aff_editeur("xtext", "true");
         echo '</div></div>';

//prix
      if ($aff_prix) {
         echo '
         <div class="form-group row">
            <label for="" class="col-sm-4 form-control-label" required="required">'.ann_translate("Prix en").' '.aff_langue($prix_cur).' <span class="text-danger"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
            <div class="col-sm-8">
            <input type="text" name="prix" class="form-control" id="" value="'.$prix.'" placeholder="'.$prix.'">
            </div>
         </div>';
      } else {
         echo '
         <input type="hidden" name="prix" value="'.$prix.'" />';
      }
//boutons supp modif
      echo '
         <div class="form-group row">
            <div class="col-md-1"><button class="btn btn-outline-primary btn-sm mb-1" type="submit" name="action" value="Valider">'.ann_translate("Valider").'</button></div>
            <div class="col-md-1"><button class="btn btn-outline-danger btn-sm" type="submit" name="action" value="Supprimer">'.ann_translate("Supprimer").'</button></div>
         </div>
      </form>';
   }


   $pp=false;
   if (!isset($sel)) {
   echo '
   <nav aria-label="">
     <ul class="pagination pagination-sm justify-content-center">';
      if ($min>0) {
         echo '
         <li class="page-item"><a class="page-link" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm_ann&amp;id_cat='.$id_cat_sel.'&amp;min='.($min-$max).'"><i class="fa fa-angle-double-left mx-2"></i><span class="hidden-sm-down">'.ann_translate("Précédente").'</span></span></a></li>';
         $pp=true;
      }
      if (($min+$max)<$count) {
         echo '
         <li class="page-item"><a class="page-link" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm_ann&amp;id_cat='.$id_cat_sel.'&amp;min='.($min+$max).'"><span class="hidden-sm-down">'.ann_translate("Suivante").' </span><i class="fa fa-angle-double-right mx-2"></i></a></li>';
      }
   echo '
      </ul>
   </nav>';
   }

   echo '<p><a class="btn btn-outline-primary btn-sm" role="button" href="admin.php?op=Extend-Admin-SubModule&amp;ModPath='.$ModPath.'&amp;ModStart=admin/adm"><i class="fa fa-home" aria-hidden="true"></i> '.ann_translate("Admin P.A").'</a></p>';
   echo '</div>';
include ("footer.php");
?>