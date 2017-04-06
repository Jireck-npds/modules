<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/*                                                                      */
/* NPDS Copyright (c) 2002-2017 by Philippe Brunier                     */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/* Module de gestion de galeries pour NPDS                              */
/*                                                                      */
/* (c) 2004-2005 Tribal-Dolphin - http://www.tribal-dolphin.net         */
/* (c) 2007 Xgonin, Lopez - http://modules.npds.org                     */
/* MAJ conformité XHTML pour REvolution 10.02 par jpb/phr en mars 2010  */
/* MAJ Dev - 2011                                                       */
/* npds_galerie v 3.0                                                   */
/* Changement de nom du module version Rev16 par jpb/phr janv 2017      */
/************************************************************************/



/**************************************************************************************************/
//ok 03/03/2017
/**************************************************************************************************/
function PrintFormCat() {
   global $ModPath, $ModStart, $NPDS_Prefix, $ThisFile;
   $num = sql_fetch_row(sql_query("SELECT COUNT(id) FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='0'"));
   if ($num[0] == 0) {
      echo '<p class="lead font-weight-bold text-danger"><i class="fa fa-info-circle"></i> '.gal_translate("Aucune catégorie trouvée").'</p>';
   } else {
      echo '<p class="lead font-weight-bold"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Nombre de catégories").'<span class="badge badge-default ml-2">'.$num[0].'</span></p>';
   }

   echo '
      <form action="'.$ThisFile.'" method="post" name="FormCat">
      <input type="hidden" name="subop" value="addcat">
      <div class="form-group row">
      <label class="col-sm-3 form-control-label">'.gal_translate("Nom de la catégorie").'</label>
      <div class="col-sm-8">
      <input type="text" class="form-control" name="newcat">
      </div></div>
      <div class="form-group row">
      <label class="col-sm-3 form-control-label">'.gal_translate("Accès pour").'</label>
      <div class="col-sm-8">
      <select class="custom-select" id="">';
   echo Fab_Option_Group("");
   echo '
      </select>
      </div></div>
      <div class="form-group row">
      <span class="col-sm-3 form-control-label"></span>
      <div class="col-sm-8">
      <button class="btn btn-outline-primary" type="submit">'.gal_translate("Ajouter").'</button>
      </div></div>
      </form>';
}

/**************************************************************************************************/
//ok 03/03/2017
/**************************************************************************************************/
function AddACat($newcat,$acces) {
   global $ModPath, $ModStart, $NPDS_Prefix, $ThisRedo;
   if (!empty($newcat)) {
      $newcat = addslashes(removeHack($newcat));
      if (sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='0' AND nom='$newcat'"))) {
         echo '<p class="lead text-warning"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Cette catégorie existe déjà").'</p>';
      } else {
         if ($add = sql_query("INSERT INTO ".$NPDS_Prefix."tdgal_cat VALUES ('','0','$newcat','$acces')")) {
            redirect_url($ThisRedo);
         } else {
            echo '<p class="lead text-danger"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Erreur lors de l'ajout de la catégorie").'</p>';
         }
      }
   } else {
      redirect_url($ThisRedo."&subop=formcat");
   }
}

/**************************************************************************************************/
//ok 03/03/2017
/**************************************************************************************************/
function PrintFormSSCat() {
   global $ModPath, $ModStart, $NPDS_Prefix, $ThisFile, $ThisRedo;
   $qnum = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='0'"));
   if ($qnum == 0) { redirect_url($ThisRedo); }
   PrintJavaCodeGal();
   $num = sql_fetch_row(sql_query("SELECT COUNT(id) FROM ".$NPDS_Prefix."tdgal_cat WHERE cid!=0"));
   if ($num[0] == 0) {
      echo '<p class="lead"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Aucune sous-catégorie trouvée").'</p>';
   } else {
      echo '<p class="lead font-weight-bold"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Nombre de sous-catégories").' <span class="badge badge-default">'.$num[0].'</span></p>';
   }

   echo '<form action="'.$ThisFile.'" method="post" name="FormCreer">';
   echo '<input type="hidden" name="subop" value="addsscat">';   
   echo '
      <div class="form-group row">
      <label class="col-sm-3 form-control-label">'.gal_translate("Catégorie parente").'</label>
      <div class="col-sm-8">
      <select class="custom-select" name="cat" id="" onChange="remplirAcces(this.selectedIndex,this.options[this.selectedIndex].text);">';
   echo "<option value=\"none\" selected>".gal_translate("Choisissez")."</option>";     
   $query = sql_query("SELECT id,nom,acces FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='0' ORDER BY nom ASC");
   while ($row = sql_fetch_row($query)) {
      echo "<option value=".$row[0].">".stripslashes($row[1])." (".Get_Name_Group("",$row[2]).")</option>\n";
   }
      echo '</select>
      </div></div>';
      echo '
      <div class="form-group row">
      <label class="col-sm-3 form-control-label">'.gal_translate("Nom de la sous-catégorie").' '.$row[2].'</label>
      <div class="col-sm-8">
      <input type="text" class="form-control" name="newsscat" id="" placeholder="">
      </div></div>';
      echo '
      <div class="form-group row">
      <label class="col-sm-3 form-control-label">'.gal_translate("Accès pour").'</label>
      <div class="col-sm-8">
      <select class="custom-select" id="">
         '.Fab_Option_Group().'
      </select>
      </div></div>';
      echo '
      <div class="form-group row">
      <span class="col-sm-3 form-control-label"></span>
      <div class="col-sm-8">
      <input class="btn btn-outline-primary" type="submit" value="'.gal_translate("Ajouter").'">
      </div></div>';
   echo "</form>";
}

/**************************************************************************************************/
//ok 03/03/2017
/**************************************************************************************************/
function AddSsCat($idparent,$newcat,$acces) {
   global $ModPath, $ModStart, $NPDS_Prefix, $ThisRedo;
   if (!empty($newcat)) {
      $newcat = addslashes(removeHack($newcat));
      if (sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='$idparent' AND nom='$newcat'"))) {
         echo '<p class="lead text-warning"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Cette sous-catégorie existe déjà").'</p>';
      } else {
         if ($add = sql_query("INSERT INTO ".$NPDS_Prefix."tdgal_cat VALUES ('','$idparent','$newcat','$acces')")) {
            redirect_url($ThisRedo);
         } else {
            echo '<p class="lead text-danger"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Erreur lors de l'ajout de la sous-catégorie").'</p>';
         }
      }
   } else {
      redirect_url($ThisRedo."&subop=formsscat");
   }
}

/**************************************************************************************************/
//ok 03/03/2017
/**************************************************************************************************/
function PrintCreerGalery() {
   global $ModPath, $ModStart, $NPDS_Prefix, $ThisFile, $ThisRedo;
   $qnum = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_cat"));
   if ($qnum == 0) {
      redirect_url($ThisRedo);
   }
   PrintJavaCodeGal();
 
   $num = sql_fetch_row(sql_query("SELECT COUNT(id) FROM ".$NPDS_Prefix."tdgal_gal"));
   
   $num[0] = ($num[0] -1);   
   
   if ($num[0] == 0) {
      echo '<p class="lead font-weight-bold"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Aucune galerie trouvée").'</p>';
   } else {
      echo '<p class="lead font-weight-bold"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Nombre de galeries").'<span class="badge badge-default ml-2">'.$num[0].'</span></p>';
   }

   echo '<form action="'.$ThisFile.'" method="post" name="FormCreer">';
   echo '<input type="hidden" name="subop" value="addsscat">';   
   echo '
      <div class="form-group row">
      <label class="col-sm-3 form-control-label">'.gal_translate("Catégorie").'</label>
      <div class="col-sm-8">
      <input type="hidden" name="subop" value="creegal">
      <select class="custom-select" name="galcat" id="" onChange="remplirAcces(this.selectedIndex,this.options[this.selectedIndex].text);">
      <option value="none" selected>'.gal_translate("Choisissez").'</option>';
      echo cat_arbo("");
      echo '
      </select>
      </div></div>';
      echo '
      <div class="form-group row">
      <label class="col-sm-3 form-control-label">'.gal_translate("Nom de la galerie").' '.$row[2].'</label>
      <div class="col-sm-8">
      <input type="text" class="form-control" name="newgal" id="" placeholder="">
      </div></div>';
      echo '      
      <div class="form-group row">
      <label class="col-sm-3 form-control-label">'.gal_translate("Accès pour").'</label>
      <div class="col-sm-8">
      <select class="custom-select" id="">';
      echo Fab_Option_Group("");
      echo '
      </select>
      </div></div>
      <div class="form-group row">
      <span class="col-sm-3 form-control-label"></span>
      <div class="col-sm-8">
      <button class="btn btn-outline-primary" type="submit">'.gal_translate("Ajouter").'</button>
      </div></div>
      </form>';
}

/**************************************************************************************************/
//ok 03/03/2017
/**************************************************************************************************/
function AddNewGal($galcat,$newgal,$acces) {
   global $ModPath, $ModStart, $gmt, $NPDS_Prefix, $ThisRedo;  
   if (!empty($newgal)) {
      $newgal = addslashes(removeHack($newgal));
      if (sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_gal WHERE cid='$galcat' AND nom='$newgal'"))) {
         echo '<p class="lead font-weight-bold text-warning"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Cette galerie existe déjà").'</p>';
      } else {
         $regdate = time()+((integer)$gmt*3600);
         if ($add = sql_query("INSERT INTO ".$NPDS_Prefix."tdgal_gal VALUES ('','$galcat','$newgal','$regdate','$acces')")) {
            $new_gal_id = sql_last_id();
//   echo '<h4><i class="fa fa-plus"></i> '.gal_translate("Ajouter des photos à cette nouvelle galerie").'</h4>';
   echo '<form enctype="multipart/form-data" method="post" action="'.$ThisFile.'" name="FormImgs">';
   echo '<input type="hidden" name="subop" value="addimgs">';
   echo '<input type="hidden" name="imggal" value="'.$new_gal_id.'">';
   echo '
      <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Image 1").'</label>
      <div class="col-sm-10">
      <input type="file" class="form-control-file" name="newcard1" id="">
      <small class="text-muted">'.gal_translate("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc1" placeholder="'.gal_translate("Description").'">
      </div></div>';
   echo '
      <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Image 2").'</label>
      <div class="col-sm-6">
      <input type="file" class="form-control-file" name="newcard2" id="">
      <small class="text-muted">'.gal_translate("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc2" placeholder="'.gal_translate("Description").'">
      </div></div>';
   echo '
      <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Image 3").'</label>
      <div class="col-sm-6">
      <input type="file" class="form-control-file" name="newcard3" id="">
      <small class="text-muted">'.gal_translate("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc3" placeholder="'.gal_translate("Description").'">
      </div></div>';
   echo '
      <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Image 4").'</label>
      <div class="col-sm-6">
      <input type="file" class="form-control-file" name="newcard4" id="">
      <small class="text-muted">'.gal_translate("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc4" placeholder="'.gal_translate("Description").'">
      </div></div>'; 
   echo '
      <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Image 5").'</label>
      <div class="col-sm-6">
      <input type="file" class="form-control-file" name="newcard5" id="">
      <small class="text-muted">'.gal_translate("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc5" placeholder="'.gal_translate("Description").'">
      </div></div>';
   echo '   
      <div class="form-group row">
      <span class="col-sm-2 form-control-label"></span>
      <div class="col-sm-10">
      <input class="btn btn-outline-primary" type="submit" value="'.gal_translate("Ajouter").'">
      </div></div>';
   echo '</form>';
         } else {
            echo '<p class="lead text-danger">'.gal_translate("Erreur lors de l'ajout de la galerie").'</p>';
         }
      }
   } else {
      redirect_url($ThisRedo."&subop=formcregal");
   }
}

/**************************************************************************************************/
//à voir pour transformer cela
/**************************************************************************************************/
function select_arbo($sel) {
   global $NPDS_Prefix;

   $ibid='<option value="-1">'.gal_translate("Galerie temporaire").'</option>';
   $sql_cat = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='0' ORDER BY nom ASC");
   $num_cat = sql_num_rows($sql_cat);
   if ($num_cat != 0) {
      $sql_sscat = "SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE cid!=0";
      $sql_gal = "SELECT * FROM ".$NPDS_Prefix."tdgal_gal";
      // CATEGORIE
      while ($row_cat = sql_fetch_row($sql_cat)) {
         $ibid.='<optgroup label="'.stripslashes($row_cat[2]).'">';
         $queryX = sql_query("SELECT id, nom  FROM ".$NPDS_Prefix."tdgal_gal WHERE cid='".$row_cat[0]."' ORDER BY nom ASC");
         while ($rowX_gal = sql_fetch_row($queryX)) {
            if ($rowX_gal[0] == $sel) { $IsSelected = ' selected'; } else { $IsSelected = ''; }
            $ibid.='<option value="'.$rowX_gal[0].'"'.$IsSelected.'>'.stripslashes($rowX_gal[1]).' </option>';
         } // Fin Galerie Catégorie

         // SOUS-CATEGORIE
         $query = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='".$row_cat[0]."' ORDER BY nom ASC");
         while ($row_sscat = sql_fetch_row($query)) {
            $ibid.='<optgroup label="&nbsp;&nbsp;'.stripslashes($row_sscat[2]).'">';
            $querx = sql_query("SELECT id, nom FROM ".$NPDS_Prefix."tdgal_gal WHERE cid='".$row_sscat[0]."' ORDER BY nom ASC");
            while ($row_gal = sql_fetch_row($querx)) {
               if ($row_gal[0] == $sel) { $IsSelected = " selected"; } else { $IsSelected = ""; }
               $ibid.='<option value="'.$row_gal[0].'"'.$IsSelected.'>'.stripslashes($row_gal[1]).' </option>';
            } // Fin Galerie Sous Catégorie
            $ibid.='</optgroup>';
         } // Fin Sous Catégorie
         $ibid.='</optgroup>';
      } // Fin Catégorie
   }
   return ($ibid);
}
function cat_arbo($sel) {
   global $NPDS_Prefix;

      $ibid="";
      $queryX = sql_query("SELECT id,nom,acces FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='0' ORDER BY nom ASC");
      while ($rowX = sql_fetch_row($queryX)) {
         if ($sel==$rowX[0]) $selected="selected"; else $selected="";
         $ibid.='<option value="'.$rowX[0].'" '.$selected.'>'.stripslashes($rowX[1]).' ('.Get_Name_Group("",$rowX[2]).')</option>';
         $queryY = sql_query("SELECT id,nom,acces FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='".$rowX[0]."' ORDER BY nom ASC");
         while ($rowY = sql_fetch_row($queryY)) {
            if ($sel==$rowY[0]) $selected="selected"; else $selected="";
            $ibid.='<option value="'.$rowY[0].'" '.$selected.'>&nbsp;&nbsp;'.stripslashes($rowY[1]).' ('.Get_Name_Group("",$rowY[2]).')</option>';
         }
      }
      return ($ibid);
}

/*******************************************************/
//ok 03/03/2017
/*******************************************************/

function PrintFormImgs() {
   global $ModPath, $ModStart, $NPDS_Prefix, $ThisFile, $ThisRedo;

   $qnum = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_cat"));
   if ($qnum == 0) {
      redirect_url($ThisRedo);
   }
   echo '<form enctype="multipart/form-data" method="post" action="'.$ThisFile.'" name="FormImgs">';
   echo '<input type="hidden" name="subop" value="addimgs">';
   echo '
   <div class="form-group row">
      <label class="col-sm-2 form-control-label" for="exampleSelect1">'.gal_translate("Affectation").'</label>
      <div class="col-sm-6">
      <select name="imggal" class="custom-select">';
   echo select_arbo("");
   echo '</select><br /><small class="text-muted">'.gal_translate("Sélectionner une galerie").'</small>';
   echo '</div></div>';
   echo '
   <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Image 1").'</label>
      <div class="col-sm-10">
      <input type="file" class="form-control-file" name="newcard1" id="">
      <small class="text-muted">'.gal_translate("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc1" placeholder="'.gal_translate("Description").'">
      </div></div>';
   echo '
   <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Image 2").'</label>
      <div class="col-sm-10">
      <input type="file" class="form-control-file" name="newcard2" id="">
      <small class="text-muted">'.gal_translate("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc2" placeholder="'.gal_translate("Description").'">
   </div></div>';
   echo '
   <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Image 3").'</label>
      <div class="col-sm-10">
      <input type="file" class="form-control-file" name="newcard3" id="">
      <small class="text-muted">'.gal_translate("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc3" placeholder="'.gal_translate("Description").'">
   </div></div>';
   echo '
   <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Image 4").'</label>
      <div class="col-sm-10">
      <input type="file" class="form-control-file" name="newcard4" id="">
      <small class="text-muted">'.gal_translate("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc4" placeholder="'.gal_translate("Description").'">
   </div></div>';
   echo '
   <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Image 5").'</label>
      <div class="col-sm-10">
      <input type="file" class="form-control-file" name="newcard5" id="">
      <small class="text-muted">'.gal_translate("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc5" placeholder="'.gal_translate("Description").'">
   </div></div>';
   echo '   
      <div class="form-group row">
      <span class="col-sm-2 form-control-label"></span>
      <div class="col-sm-10">
      <input class="btn btn-outline-primary" type="submit" value="'.gal_translate("Ajouter").'">
      </div></div>';
   echo '</form>';
}
/*******************************************************/

/*******************************************************/
function AddImgs($imgscat,$newcard1,$newdesc1,$newcard2,$newdesc2,$newcard3,$newdesc3,$newcard4,$newdesc4,$newcard5,$newdesc5) {
   global $language, $MaxSizeImg, $MaxSizeThumb, $ModPath, $ModStart, $NPDS_Prefix;
   include_once("modules/upload/lang/upload.lang-$language.php");
   include_once("modules/upload/clsUpload.php");

   $year = date("Y"); $month = date("m"); $day = date("d");
   $hour = date("H"); $min = date("i"); $sec = date("s");

   $i=1;
   while($i <= 5) {
      $img = "newcard$i";
      $tit = "newdesc$i";
      if (!empty($$img)) {
         $newimg = stripslashes(removeHack($$img));
         if (!empty($$tit)) {
            $newtit = addslashes(removeHack($$tit));
         } else {
            $newtit = "";
         }
         $upload = new Upload();
         $upload->maxupload_size=200000*100;
         $origin_filename = trim($upload->getFileName("newcard".$i));
         $filename_ext = strtolower(substr(strrchr($origin_filename, "."),1));

         if ( ($filename_ext=="jpg") or ($filename_ext=="gif") or ($filename_ext=="png") ) {
            $newfilename = $year.$month.$day.$hour.$min.$sec."-".$i.".".$filename_ext;
            if ($upload->saveAs($newfilename,"modules/$ModPath/imgs/", "newcard".$i,true)) {
               if ((function_exists('gd_info')) or extension_loaded('gd')) {
                  @CreateThumb($newfilename, "modules/$ModPath/imgs/", "modules/$ModPath/imgs/", $MaxSizeImg, $filename_ext);
                  @CreateThumb($newfilename, "modules/$ModPath/imgs/", "modules/$ModPath/mini/", $MaxSizeThumb, $filename_ext);
               }
                  echo '<ul class="list-group">';
               if (sql_query("INSERT INTO ".$NPDS_Prefix."tdgal_img VALUES ('','$imgscat','$newfilename','$newtit','','0','0')")) {
                  echo '<li class="list-group-item list-group-item-success"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Image ajoutée avec succès").'</li>';
               } else {
                  echo '<li class="list-group-item list-group-item-danger"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Impossible d'ajouter l'image en BDD").'</li>';
                  @unlink ("modules/$ModPath/imgs/$newfilename");
                  @unlink ("modules/$ModPath/mini/$newfilename");
               }
            } else {
               echo '<li class="list-group-item list-group-item-danger"><i class="fa fa-info-circle mr-2"></i>'.$upload->errors.'</li>';
            }
         } else {
            if ($filename_ext!="")
               echo '<li class="list-group-item list-group-item-danger"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Ce fichier n'est pas un fichier jpg ou gif").'</li>';
         }
         echo '</ul>';
      }
      $i++;
   }
}

/**************************************************************************************************/
//ok 03/03/2017
/**************************************************************************************************/
function PrintFormConfig() {
   global $ModPath, $ModStart, $ThisFile, $MaxSizeImg, $MaxSizeThumb, $imglign, $imgpage, $nbtopcomment, $nbtopvote, $view_alea, $view_last, $vote_anon, $comm_anon, $post_anon, $aff_vote, $aff_comm, $notif_admin;

   echo '<h5 class="card-title"><i class="fa fa-cogs mr-2" aria-hidden="true"></i>'.gal_translate("Configuration").'</h5>';
   echo '<form action="'.$ThisFile.'" method="post" name="FormConfig">';
   echo '<input type="hidden" name="subop" value="wrtconfig">';

   echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Dimension maximale de l'image en pixels").'&nbsp;(1024px Max)</label>
         <div class="col-sm-3">
         <input type="text" class="form-control" name="maxszimg" id="" value="'.$MaxSizeImg.'" placeholder="">
      </div></div>';   
   echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Dimension maximale de la miniature en pixels").'&nbsp;(240px Max)</label>
         <div class="col-sm-3">
         <input type="text" class="form-control" name="maxszthb" id="" value="'.$MaxSizeThumb.'" placeholder="">
      </div></div>';

   echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Nombre d'images par ligne").'</label>
         <div class="col-sm-3">
         <input type="text" class="form-control" name="nbimlg" id="" value="'.$imglign.'" placeholder="">
      </div></div>';

   echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Nombre d'images par page").'</label>
         <div class="col-sm-3">
         <input type="text" class="form-control" name="nbimpg" id="" value="'.$imgpage.'" placeholder="">
      </div></div>';

   echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Nombre d'images à afficher dans le top commentaires").'</label>
         <div class="col-sm-3">
         <input type="text" class="form-control" name="nbimcomment" id="" value="'.$nbtopcomment.'" placeholder="">
      </div></div>';

   echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Nombre d'images à afficher dans le top votes").'</label>
         <div class="col-sm-3">
         <input type="text" class="form-control" name="nbimvote" id="" value="'.$nbtopvote.'" placeholder="">
      </div></div>';

   if ($view_alea) { $rad1 = " checked"; $rad2 = ""; } else { $rad1 = ""; $rad2 = " checked"; }

   echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Afficher des photos aléatoires ?").'</label>
         <div class="col-sm-3">
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="viewalea" value="true"'.$rad1.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Oui").'</span>
         </label>
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="viewalea" value="false"'.$rad2.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Non").'</span>
         </label>
      </div></div>';

   if ($view_last) { $rad1 = " checked"; $rad2 = ""; } else { $rad1 = ""; $rad2 = " checked"; }
   echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Afficher les derniers ajouts ?").'</label>
         <div class="col-sm-3">
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" type="radio" name="viewlast" value="true"'.$rad1.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Oui").'</span>
         </label>
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" type="radio" name="viewlast" value="false"'.$rad2.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Non").'</span>
         </label>
      </div></div>';

   if ($aff_vote) { $rad1 = " checked"; $rad2 = ""; } else { $rad1 = ""; $rad2 = " checked"; }
   echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Afficher les votes ?").'</label>
         <div class="col-sm-3">
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="votegal" value="true"'.$rad1.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Oui").'</span>
         </label>
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="votegal" value="false"'.$rad2.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Non").'</span>
         </label>
      </div></div>';

   if ($aff_comm) { $rad1 = " checked"; $rad2 = ""; } else { $rad1 = ""; $rad2 = " checked"; }
   echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Afficher les commentaires ?").'</label>
         <div class="col-sm-3">
          <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="commgal" value="true"'.$rad1.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Oui").'</span>
         </label>
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="commgal" value="false"'.$rad2.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Non").'</span>
         </label>
      </div></div>';

   if ($vote_anon) { $rad1 = " checked"; $rad2 = ""; } else { $rad1 = ""; $rad2 = " checked"; }
    echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Les anonymes peuvent voter ?").'</label>
         <div class="col-sm-3">
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="votano" value="true"'.$rad1.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Oui").'</span>
         </label>
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="votano" value="false"'.$rad2.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Non").'</span>
         </label>
      </div></div>';

   if ($comm_anon) { $rad1 = " checked"; $rad2 = ""; } else { $rad1 = ""; $rad2 = " checked"; }
    echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Les anonymes peuvent poster un commentaire ?").'</label>
         <div class="col-sm-3">
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="comano" value="true"'.$rad1.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Oui").'</span>
         </label>
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="comano" value="false"'.$rad2.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Non").'</span>
         </label>
      </div></div>';

   if ($post_anon) { $rad1 = " checked"; $rad2 = ""; } else { $rad1 = ""; $rad2 = " checked"; }
    echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Les anonymes peuvent envoyer des E-Cartes ?").'</label>
         <div class="col-sm-3">
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="postano" value="true"'.$rad1.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Oui").'</span>
         </label>
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="postano" value="false"'.$rad2.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Non").'</span>
         </label>
      </div></div>';

   if ($notif_admin) { $rad1 = " checked"; $rad2 = ""; } else { $rad1 = ""; $rad2 = " checked"; }
     echo '
      <div class="form-group row">
         <label class="col-sm-7 form-control-label">'.gal_translate("Notifier par email l'administrateur de la proposition de photos ?").'</label>
         <div class="col-sm-3">
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="notifadmin" value="true"'.$rad1.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Oui").'</span>
         </label>
         <label class="custom-control custom-radio">
         <input class="custom-control-input" type="radio" name="notifadmin" value="false"'.$rad2.'>
         <span class="custom-control-indicator"></span>
         <span class="custom-control-description">'.adm_translate("Non").'</span>
         </label>
      </div></div>';
   echo '<button class="btn btn-outline-primary" type="submit">'.gal_translate("Valider").'</button>';
   echo "</form>";
}
/**************************************************************************************************/
//ok 03/03/2017
/**************************************************************************************************/
function WriteConfig($maxszimg,$maxszthb,$nbimlg,$nbimpg,$nbimcomment,$nbimvote,$viewalea,$viewlast,$vote,$comm,$votano,$comano,$postano,$notifadmin) {
   global $ModPath, $ModStart, $ThisRedo;

   if (!is_integer($maxszimg) && ($maxszimg > 1024)) {
      $msg_erreur = gal_translate("Dimension maximale de l'image incorrecte");
      $erreur=true;
   }
   
   if (!is_integer($maxszthb) && ($maxszthb > 300) && !isset($erreur)) {
      $msg_erreur = gal_translate("Dimension maximale de la miniature incorrecte");
      $erreur=true;
   }

   if (isset($erreur)) {
      echo '<p class="lead text-danger">'.$msg_erreur.'</p>';
      exit;
   }
   
   if ($nbimpg < $nbimlg) { $nbimpg = $nbimlg; }
   $filename = "modules/".$ModPath."/gal_conf.php";
   $content = "<?php\n";
   $content.= "/************************************************************************/\n";
   $content.= "/* DUNE by NPDS                                                         */\n";
   $content.= "/*                                                                      */\n";
   $content.= "/* NPDS Copyright (c) 2002-2017 by Philippe Brunier                     */\n";
   $content.= "/*                                                                      */\n";
   $content.= "/* This program is free software. You can redistribute it and/or modify */\n";
   $content.= "/* it under the terms of the GNU General Public License as published by */\n";
   $content.= "/* the Free Software Foundation; either version 2 of the License.       */\n";
   $content.= "/* Module de gestion de galeries pour NPDS                              */\n";
   $content.= "/*                                                                      */\n";
   $content.= "/* (c) 2004-2005 Tribal-Dolphin - http://www.tribal-dolphin.net         */\n";
   $content.= "/* (c) 2007 Xgonin, Lopez - http://modules.npds.org                     */\n";
   $content.= "/* MAJ conformité XHTML pour REvolution 10.02 par jpb/phr en mars 2010  */\n";
   $content.= "/* MAJ Dev - 2011                                                       */\n";
   $content.= "/* npds_galerie v 3.0                                                   */\n";
   $content.= "/* Changement de nom du module version Rev16 par jpb/phr mars 2017      */\n";
   $content.= "/************************************************************************/\n\n";
   $content.= "// Dimension max des images\n";
   $content.= "\$MaxSizeImg = ".$maxszimg.";\n\n";
   $content.= "// Dimension max des images miniatures\n";
   $content.= "\$MaxSizeThumb = ".$maxszthb.";\n\n";
   $content.= "// Nombre d'images par ligne\n";
   $content.= "\$imglign = ".$nbimlg.";\n\n";
   $content.= "// Nombre de photos par page\n";
   $content.= "\$imgpage = ".$nbimpg.";\n\n";
   $content.= "// Nombre d'images à afficher dans le top commentaires\n";
   if (!$nbimcomment) $nbimcomment=5;
   $content.= "\$nbtopcomment = ".$nbimcomment.";\n\n";
   $content.= "// Nombre d'images à afficher dans le top votes\n";
   if (!$nbimvote) $nbimvote=5;
   $content.= "\$nbtopvote = ".$nbimvote.";\n\n";   
   $content.= "// Personnalisation de l'affichage\n";
   $content.= "\$view_alea = ".$viewalea.";\n";
   $content.= "\$view_last = ".$viewlast.";\n";
   $content.= "\$aff_vote = ".$vote.";\n";
   $content.= "\$aff_comm = ".$comm.";\n\n";
   $content.= "// Autorisations pour les anonymes\n";
   $content.= "\$vote_anon = ".$votano.";\n";
   $content.= "\$comm_anon = ".$comano.";\n";
   $content.= "\$post_anon = ".$postano.";\n\n";
   $content.= "// Notification admin par email de la proposition\n";
   $content.= "\$notif_admin = ".$notifadmin.";\n\n";
   $content.= "// Version du module\n";
   $content.= "\$npds_gal_version = \"V 3.0\";\n";
   $content.= "?>";
     
   if ($myfile = fopen("$filename", "wb")) {
      fwrite($myfile, "$content");
      fclose($myfile);
      unset($content);
      redirect_url($ThisRedo);
   } else {
      redirect_url($ThisRedo."&subop=config");
   }
}
/**************************************************************************************************/
//
/**************************************************************************************************/

function PrintArbo() {
   global $ModPath, $ModStart, $ThisFile, $NPDS_Prefix;
   echo "<script type=\"text/javascript\">\n//<![CDATA[\n";
   echo "   function aff_image(img_id, img_src) {\n";
   echo "   var image_open = new Image();\n";
   echo "   image_open.src = img_src;\n";
   echo "   var image_closed = new Image();\n";
   echo "   image_closed.src = 'modules/$ModPath/data/img.png'\n";
   echo "      if (document.all) {\n";
   echo "         if (document.all[img_id].src == image_closed.src) {\n";
   echo "            document.all[img_id].src = image_open.src;\n";
   echo "         } else {\n";
   echo "            document.all[img_id].src = image_closed.src;\n";
   echo "         }\n";
   echo "      } else {\n";
   echo "         if (document.getElementById(img_id).src == image_closed.src) {\n";
   echo "            document.getElementById(img_id).src = image_open.src;\n";
   echo "         } else {\n";
   echo "            document.getElementById(img_id).src = image_closed.src;\n";
   echo "         }\n";
   echo "      }\n";
   echo "   }";
   echo "   \n//]]>\n</script>\n";


   $queryZ = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='-1' ORDER BY id");

// Image de la galerie temporaire
   echo '<div class="card mb-2">';
   echo '<div class="card-header alert-info">';
   echo '<h5>';
   echo '<a class="" data-toggle="collapse" href="#gt" aria-expanded="false" aria-controls="gt">
   <i class="toggle-icon fa fa-caret-down fa-lg mr-2" data-toggle="tooltip" data-placement="top" title="'.gal_translate("Cliquer pour déplier").'"></i></a>Galerie temporaire</h5>';
   echo '</div>';
   echo '<div class="card-block collapse" id="gt">';
   
   $rowZ_img = sql_num_rows($queryZ);
      if ($rowZ_img == 0){
         echo '<p class="card-text"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Vide").'</p>';}
      else {   
   while ($rowZ_img = sql_fetch_row($queryZ)) {
      echo '<div class="row">';
      echo '<div class="col-md-2 col-sm-4 col-xs-4">';
      echo '<a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=gal&amp;op=one-img&amp;galid=-1&amp;pos='.$rowZ_img[0].'" target="_blank"><img class="img-fluid img-thumbnail mb-1" src="modules/'.$ModPath.'/mini/'.$rowZ_img[2].'" alt="'.$rowZ_img[3].'" data-toggle="tooltip" data-placement="top"  title="'.$rowZ_img[3].'" /></a>';
      echo '</div>';
      echo '<div class="col-md-7"><span class="badge badge-default">ref : '.$rowZ_img[2].'</span>';
      echo '<br />'.stripslashes($rowZ_img[3]).'</div>';
      echo '<div class="col-md-3"><span class="pull-right">';
      
      if ($rowZ_img[6]==1)
         echo '<a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'&amp;subop=validimg&amp;imgid='.$rowZ_img[0].'">'.gal_translate("Valider").'</a>';
      else
         echo '<a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=editimg&amp;imgid='.$rowZ_img[0].'"><i class="fa fa-edit fa-lg" data-original-title="Editer" data-toggle="tooltip"></i></a>';
      echo '<a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=delimg&amp;imgid='.$rowZ_img[0].'"><i class="fa fa-trash-o fa-lg text-danger" data-original-title="Effacer" data-toggle="tooltip"></i></a>';
      echo '</div></div>';
     }
}

   echo '</div>';
   echo '</div>';
   echo '<hr />';
   $sql_cat = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='0' ORDER BY nom ASC");
   $num_cat = sql_num_rows($sql_cat);

   if ($num_cat == 0) {
      echo '<p class="lead"><i class="fa fa-info-circle"></i> '.gal_translate("Aucune catégorie trouvée").'</p>';
   } else {
      $sql_sscat = "SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE cid!=0";
      $num_sscat = sql_num_rows(sql_query($sql_sscat));
      $sql_gal = "SELECT * FROM ".$NPDS_Prefix."tdgal_gal";
      $num_gal = sql_num_rows(sql_query($sql_gal));

 // CATEGORIE

      while ($row_cat = sql_fetch_row($sql_cat)) {
   echo '<div class="card mb-2">';
   echo '<div class="card-header">';
   echo '<h5>';
   echo '<a class="" data-toggle="collapse" href="#cat'.$row_cat[0].'" aria-expanded="false" aria-controls="cat'.$row_cat[0].'">
   <i class="toggle-icon fa fa-caret-down fa-lg mr-2" data-toggle="tooltip" data-placement="top" title="'.gal_translate("Cliquer pour déplier").'"></i></a>'.stripslashes($row_cat[2]).' <small>( '.gal_translate("Catégorie").' )</small>';
   echo '<span class="pull-right"><a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=editcat&amp;catid='.$row_cat[0].'"><i class="fa fa-edit fa-lg" data-original-title="Editer" data-toggle="tooltip"></i></a>';
   echo '<a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=delcat&amp;catid='.$row_cat[0].'"><i class="fa fa-trash-o fa-lg text-danger" data-original-title="Effacer" data-toggle="tooltip"></i></a></span></h5>';
   echo '</div>';

        $queryX = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_gal WHERE cid='".$row_cat[0]."' ORDER BY nom ASC");
   echo '<div class="collapse" id="cat'.$row_cat[0].'">';
// Image de la galerie
        while ($rowX_gal = sql_fetch_row($queryX)) {
           echo '<div class="card-header alert-info"><h5><a class="" data-toggle="collapse" href="#galcat'.$rowX_gal[0].'" aria-expanded="false" aria-controls="galcat'.$rowX_gal[0].'">
           <i class="toggle-icon fa fa-caret-down fa-lg mr-2" data-toggle="tooltip" data-placement="top" title="'.gal_translate("Cliquer pour déplier").'"></i></a>'.stripslashes($rowX_gal[2]).' <small>( '.gal_translate("Galerie").' )</small>';
           echo '<span class="float-right"><a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=editgal&amp;galid='.$rowX_gal[0].'"><i class="fa fa-edit fa-lg" data-original-title="Editer" data-toggle="tooltip"></i></a>';
           echo '<a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=delgal&amp;galid='.$rowX_gal[0].'"><i class="fa fa-trash-o fa-lg text-danger" data-original-title="Effacer" data-toggle="tooltip"></i></a></span></h5></div>';

           $queryZ = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='".$rowX_gal[0]."' ORDER BY ordre,id,noaff");

// Image de la galerie
           echo '<div class="card-block collapse" id="galcat'.$rowX_gal[0].'">';
           echo '<form action="'.$ThisFile.'&amp;subop=ordre" method="post" name="FormArbo'.$rowX_gal[0].'">';
           echo '<input type="hidden" name="subop" value="ordre">';
           $i=1;
           while ($rowZ_img = sql_fetch_row($queryZ)) {
              echo '<div class="row mb-2">';              
              echo '<div class="col-md-2"><input class="form-control" type="number" name="ordre['.$i.']" value="'.$rowZ_img[5].'" maxlength="11"></div>';
              echo '<input type="hidden" name="img_id['.$i.']" value="'.$rowZ_img[0].'">';
              if ($rowZ_img[6]==1) {
                 echo '<div class="col-md-2"><a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=gal&amp;op=one-img&amp;galid='.$rowX_gal[0].'&amp;pos='.$rowZ_img[0].'" target="_blank"><img class="img-fluid img-thumbnail mb-1" src="modules/'.$ModPath.'/mini/'.$rowZ_img[2].'"  alt="mini/'.$rowZ_img[2].'" data-toggle="tooltip" data-placement="top"  title="mini/'.$rowZ_img[2].'" /></a></div>';
              }
              else {
                 echo '<div class="col-md-2">';
                 echo "<a href=\"javascript: void(0);\" onMouseDown=\"aff_image('image$rowX_gal[0]_$i','modules/$ModPath/mini/$rowZ_img[2]');\">";
                echo '<img class="img-fluid img-thumbnail mb-1" src="modules/'.$ModPath.'/data/img.png" id="image'.$rowX_gal[0].'_'.$i.'" alt="mini/'.$rowZ_img[2].'" data-toggle="tooltip" data-placement="right" title="mini/'.$rowZ_img[2].'" />';
                 echo '</a></div>';              
              }
              echo '<div class="col-md-6">'.stripslashes($rowZ_img[3]).'</div>';
              echo '';
              $i++;
              echo '';
              if ($rowZ_img[6]==1)
                 echo '<span class="float-right"><a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=validimg&amp;imgid='.$rowZ_img[0].'">'.gal_translate("Valider").'</a>';
              else
                 echo '<span class="col-md-2 text-right"><a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=editimg&amp;imgid='.$rowZ_img[0].'"><i class="fa fa-edit fa-lg" data-original-title="Editer" data-toggle="tooltip"></i></a>';
              echo '<a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=delimg&amp;imgid='.$rowZ_img[0].'"><i class="fa fa-trash-o fa-lg text-danger" data-original-title="Effacer" data-toggle="tooltip"></i></a></span></div>';
           }   // Fin Image De La Galerie
           if ($i!=1) {
              echo '<input class="btn btn-outline-primary form-control btn-sm" type="submit" value="'.gal_translate("MAJ ordre").'">';
           }
           echo '';
           echo '</form>';
           echo '</div>';
        } // Fin Galerie Catégorie

        $query = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='".$row_cat[0]."' ORDER BY nom ASC");
        // SOUS-CATEGORIE
        while ($row_sscat = sql_fetch_row($query)) {
           echo '<div class="card-header"><h5 class="ml-3">';
           echo '<a class="" data-toggle="collapse" href="#scat'.$row_sscat[0].'" aria-expanded="false" aria-controls="scat'.$row_sscat[0].'">
           <i class="toggle-icon fa fa-caret-down fa-lg mr-2" data-toggle="tooltip" data-placement="top" title="'.gal_translate("Cliquer pour déplier").'"></i></a>'.stripslashes($row_sscat[2]).' <small>( '.gal_translate("Sous-catégorie").' )</small>';
           echo '<span class="float-right"><a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=editcat&amp;catid='.$row_sscat[0].'">';
           echo '<i class="fa fa-edit fa-lg" data-original-title="Editer" data-toggle="tooltip"></i></a>';
           echo '<a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=delsscat&amp;sscatid='.$row_sscat[0].'">';
           echo '<i class="fa fa-trash-o fa-lg text-danger" data-original-title="Effacer" data-toggle="tooltip"></i></a>';
           echo '</span></h5></div>';
           echo '<div class="collapse" id="scat'.$row_sscat[0].'">';

           $querx = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_gal WHERE cid='".$row_sscat[0]."' ORDER BY nom ASC");
           // SOUS-CATEGORIE
           while ($row_gal = sql_fetch_row($querx)) {
           echo '<div class="card-header alert-info">
           <h5 class="ml-3"><a class="" data-toggle="collapse" href="#galscat'.$row_gal[0].'" aria-expanded="false" aria-controls="galscat'.$row_sscat[0].'">
           <i class="toggle-icon fa fa-caret-down fa-lg mr-2" data-toggle="tooltip" data-placement="top" title="'.gal_translate("Cliquer pour déplier").'"></i></a>'.stripslashes($row_gal[2]).' <small>( '.gal_translate("Galerie").' )</small>';
           echo '<span class="float-right"><a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=editgal&amp;galid='.$row_gal[0].'"><i class="fa fa-edit fa-lg" data-original-title="Editer" data-toggle="tooltip"></i></a>';
           echo '<a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=delgal&amp;galid='.$row_gal[0].'"><i class="fa fa-trash-o fa-lg text-danger" data-original-title="Effacer" data-toggle="tooltip"></i></a></span></h5>
           </div>';

           $querz = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='".$row_gal[0]."' ORDER BY ordre,id,noaff");
           // Image de la galerie

           echo '<div class="card-block collapse" id="galscat'.$row_gal[0].'">';
           echo '<form action="'.$ThisFile.'&amp;subop=ordre" method="post" name="FormArbo'.$row_gal[0].'">';
           echo '<input type="hidden" name="subop" value="ordre">';
           $i=1;
           while($row_img = sql_fetch_row($querz)) {
           echo '<div class="row mb-2">';
           echo '<div class="col-md-2"><input  class="form-control" type="number" name="ordre['.$i.']" value="'.$row_img[5].'" maxlength="11"></div>';
           echo '<input type="hidden" name="img_id['.$i.']" value="'.$row_img[0].'">';
              if ($row_img[6]==1) {
                 echo '<div class="col-md-2"><a href="modules.php?ModPath='.$ModPath.'&amp;ModStart=gal&amp;op=one-img&amp;galid='.$row_gal[0].'&amp;pos='.$row_img[0].'" target="_blank"><img class="img-fluid img-thumbnail mb-1" src="modules/'.$ModPath.'/mini/'.$row_img[2].'" alt="mini/'.$row_img[2].'" data-toggle="tooltip" data-placement="top"  title="mini/'.$row_img[2].'" /></a></div>';
                 } else {
                    echo "<div class=\"col-md-2\"><a href=\"javascript: void(0);\" onMouseDown=\"aff_image('image$row_gal[0]_$i','modules/$ModPath/mini/$row_img[2]');\"><img class=\"img-fluid img-thumbnail mb-1\" src=\"modules/$ModPath/data/img.png\" id=\"image$row_gal[0]_$i\" alt=\"mini/$row_img[2]\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"mini/$row_img[2]\" /></a></div>";
                 }
                 echo '<div class="col-md-6">'.stripslashes($row_img[3]).'</div>';
                 echo '';
                 $i++;
                 echo '';
                 if ($row_img[6]==1)
                    echo '<a href="'.$ThisFile.'&amp;subop=validimg&amp;imgid='.$row_img[0].'">Valider</a>';
                 else
               echo '<span class="col-md-2 text-right"><a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=editimg&amp;imgid='.$row_img[0].'"><i class="fa fa-edit fa-lg" data-original-title="Editer" data-toggle="tooltip"></i></a>';
              echo '<a class="btn btn-sm" href="'.$ThisFile.'&amp;subop=delimg&amp;imgid='.$row_img[0].'"><i class="fa fa-trash-o fa-lg text-danger" data-original-title="Effacer" data-toggle="tooltip"></i></a></span></div>';
              }   // Fin Image De La Galerie
              if ($i!=1) {
              echo '<input class="btn btn-outline-primary form-control btn-sm" type="submit" value="'.gal_translate("MAJ ordre").'">';
              }
              echo '';
              echo '</form>';
              echo '</div>';
           } // Fin Galerie Sous Catégorie
              echo '</div>';
        } // Fin Sous Catégorie
        echo '</div></div>';
      } // Fin Catégorie
   }
}

/**************************************************************************************************/
//revu phr 12/03/16 ok
/**************************************************************************************************/

function DelCat($id,$go) {
   global $ThisFile, $NPDS_Prefix, $ModPath;

   if (empty($go)) {
      $q_cat = sql_query("SELECT nom FROM ".$NPDS_Prefix."tdgal_cat WHERE id='$id'");
      $r_cat = sql_fetch_row($q_cat);
      echo "";
      echo '<p class="lead">'.gal_translate("Vous allez supprimer la catégorie").' : '.$r_cat[0].'</p>';
      echo '<a href="'.$ThisFile.'&amp;subop=delcat&amp;catid='.$id.'&amp;go=true" class=" btn btn-outline-danger btn-sm">';
      echo gal_translate("Confirmer").'</a> <a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'">'.gal_translate("Annuler").'</a>';
   } else {
      $q_cat = sql_query("SELECT nom FROM ".$NPDS_Prefix."tdgal_cat WHERE id='$id'");
      $r_cat = sql_fetch_row($q_cat);
      $q_sscat = sql_query("SELECT nom,id FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='$id'");

      echo '';
      echo '<h5 class="font-weight-bold">'.gal_translate("Catégorie").' '.$r_cat[0].'</h5>';

      // Il peut ne pas y avoir de sous-catégories
      $r_sscat = sql_fetch_row($q_sscat);
      do {

         echo ''.$r_sscat[0].'';
         $q_gal = sql_query("SELECT nom,id,cid FROM ".$NPDS_Prefix."tdgal_gal WHERE cid='$r_sscat[1]' OR cid='$id'");
         while ($r_gal = sql_fetch_row($q_gal)) {

            if ($r_gal[2]==$r_sscat[1]) {
               $remp="";
            } else {
               $remp="";
            }
            echo ''.$remp.''.$r_gal[0].'';
            $q_img = sql_query("SELECT name,id FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='$r_gal[1]'");
            while ($r_img = sql_fetch_row($q_img)) {
               $m_img = "modules/$ModPath/mini/$r_img[0]";
               $g_img = "modules/$ModPath/imgs/$r_img[0]";
       echo '<ul class="list-group">';              
               echo '<li class="list-group-item">'.$r_img[0].'</li>';
               if (@unlink($m_img)) {
                  echo '<li class="list-group-item list-group-item-success">'.gal_translate("Miniature supprimée").'</li>';
               } else {
                  echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Miniature non supprimée").'</li>';
               }
               if (@unlink($g_img)) {
                  echo '<li class="list-group-item list-group-item-success">'.gal_translate("Image supprimée").'</li>';
               } else {
                  echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Image non supprimée").'</li>';
               }
               if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_vot WHERE pic_id='$r_img[1]'")) {
                  echo '<li class="list-group-item list-group-item-success">'.gal_translate("Votes supprimés").'</li>';
               } else {
                  echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Votes non supprimés").'</li>';
               }
               if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_com WHERE pic_id='$r_img[1]'")) {
                  echo '<li class="list-group-item list-group-item-success">'.gal_translate("Commentaires supprimés").'</li>';
               } else {
                  echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Commentaires non supprimés").'</li>';
               }
               if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_img WHERE id='$r_img[1]'")) {
                  echo '<li class="list-group-item list-group-item-success">'.gal_translate("Enregistrement supprimé").'</li>';
               } else {
                  echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Enregistrement non supprimé").'</li>';
               }
            } // Fin du while img
            if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_gal WHERE id='$r_gal[1]'")) {
               echo '<li class="list-group-item list-group-item-success">'.$remp.'&nbsp;&nbsp;&nbsp; '.gal_translate("Galerie supprimée").'</li>';
            } else {
               echo '<li class="list-group-item list-group-item-danger">'.$remp.' '.gal_translate("Galerie non supprimée").'</li>';
            }
         } // Fin du while galerie
         if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='$id'")) {
            echo '<li class="list-group-item list-group-item-success">'.gal_translate("Sous-catégorie supprimée").'</li>';
         } else {
            echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Sous-catégorie non supprimée").'</li>';
         }
      } while ($r_sscat = sql_fetch_row($q_sscat));
       // SousCat
      if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_cat WHERE id='$id'")) {
         echo '<li class="list-group-item list-group-item-success">'.gal_translate("Catégorie supprimée").'</li>';
      } else {
         echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Catégorie non supprimée").'</li>';
      }
      echo '</ul>';
   }
}

function DelSsCat($id,$go) {
   global $ThisFile, $NPDS_Prefix, $ModPath;
   if (empty($go)) {
      $q_sscat = sql_query("SELECT nom FROM ".$NPDS_Prefix."tdgal_cat WHERE id='$id'");
      $r_sscat = sql_fetch_row($q_sscat);
      echo '<p class="card-text lead">'.gal_translate("Vous allez supprimer la sous-catégorie").' : '.$r_sscat[0].'</p>';
      echo '<p><a class="btn btn-outline-danger btn-sm mr-2" href="'.$ThisFile.'&amp;subop=delsscat&amp;sscatid='.$id.'&amp;go=true">';
      echo gal_translate("Confirmer").'</a><a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'">'.gal_translate("Annuler").'</a>'; 
   } else {
      $q_sscat = sql_query("SELECT nom FROM ".$NPDS_Prefix."tdgal_cat WHERE id='$id'");
      $r_sscat = sql_fetch_row($q_sscat);
      $q_gal = sql_query("SELECT nom,id FROM ".$NPDS_Prefix."tdgal_gal WHERE cid='$id'");

      echo "<table class=\"table\" width=\"100%\" cellspacing=\"2\" cellpadding=\"0\" border=\"0\">";
      echo "<tr><td colspan=\"2\" class=\"header\"><strong>&nbsp;".$r_sscat[0]."</strong></td></tr>";
      while ($r_gal = sql_fetch_row($q_gal)) {
         
         echo "<tr><td colspan=\"2\">&nbsp;&nbsp;&nbsp;".$r_gal[0]."</td></tr>";
         $q_img = sql_query("SELECT name,id FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='$r_gal[1]'");
         while ($r_img = sql_fetch_row($q_img)) {
            $m_img = "modules/$ModPath/mini/$r_img[0]";
            $g_img = "modules/$ModPath/imgs/$r_img[0]";
            
            echo "<tr><td colspan=\"2\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$r_img[0]."</td></tr>";
            if (@unlink($m_img)) {
               echo "<tr><td width=\"40%\"></td><td>".gal_translate("Miniature supprimée")."</td></tr>";
            } else {
               echo "<tr><td width=\"40%\"></td><td class=\"text-danger\">".gal_translate("Miniature non supprimée")."</td></tr>";
            }
            if (@unlink($g_img)) {
               echo "<tr><td></td><td>".gal_translate("Image supprimée")."</td></tr>";
            } else {
               echo "<tr><td></td><td class=\"text-danger\">".gal_translate("Image non supprimée")."</td></tr>";
            }
            if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_vot WHERE pic_id='$r_img[1]'")) {
               echo "<tr><td></td><td>".gal_translate("Votes supprimés")."</td></tr>";
            } else {
               echo "<tr><td></td><td class=\"text-danger\">".gal_translate("Votes non supprimés")."</td></tr>";
            }
            if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_com WHERE pic_id='$r_img[1]'")) {
               echo "<tr><td></td><td>".gal_translate("Commentaires supprimés")."</td></tr>";
            } else {
               echo "<tr><td></td><td class=\"text-danger\">".gal_translate("Commentaires non supprimés")."</td></tr>";
            }
            if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_img WHERE id='$r_img[1]'")) {
               echo "<tr><td></td><td>".gal_translate("Enregistrement supprimé")."</td></tr>";
            } else {
               echo "<tr><td></td><td class=\"text-danger\">".gal_translate("Enregistrement non supprimé")."</td></tr>";
            }
         } // Fin du while img
         if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_gal WHERE id='$r_gal[1]'")) {
            echo "<tr><td colspan=\"2\">&nbsp;&nbsp;&nbsp;".gal_translate("Galerie supprimée")."</td></tr>";
         } else {
            echo "<tr><td colspan=\"2\" class=\"text-danger\">&nbsp;&nbsp;&nbsp;".gal_translate("Galerie non supprimée")."</td></tr>";
         }
      } // Fin du while galerie
      
      if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_cat WHERE id='$id'")) {
         echo "<tr><td colspan=\"2\"><strong>".gal_translate("Sous-catégorie supprimée")."</strong></td></tr>";
      } else {
         echo "<tr><td colspan=\"2\" class=\"text-danger\">".gal_translate("Sous-catégorie non supprimée")."</td></tr>";
      }
      echo "</table>";
   }
}

function DelGal($id,$go) {
   global $ThisFile, $NPDS_Prefix, $ModPath;

   if (empty($go)) {
      $q_gal = sql_query("SELECT nom FROM ".$NPDS_Prefix."tdgal_gal WHERE id='$id'");
      $r_gal = sql_fetch_row($q_gal);
      echo '';
      echo '<p class="lead"><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Vous allez supprimer").' : <strong>'.$r_gal[0].'</strong></p>';
      echo '<a class="btn btn-outline-danger btn-sm mr-2" href="'.$ThisFile.'&amp;subop=delgal&amp;galid='.$id.'&amp;go=true">'.gal_translate("Confirmer").'</a><a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'">'.gal_translate("Annuler").'</a>';
      echo '';
   } else {
      $q_gal = sql_query("SELECT nom FROM ".$NPDS_Prefix."tdgal_gal WHERE id='$id'");
      $r_gal = sql_fetch_row($q_gal);
      $q_img = sql_query("SELECT name,id FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='$id'");

       if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_gal WHERE id='$id'")) {
         echo '<h5 class="font-weight-bold">'.gal_translate("Galerie").' '.$r_gal[0].' <span class="text-success">'.gal_translate("supprimée").'</span></h5>';
      } else {
         echo '<h5 class="font-weight-bold">'.gal_translate("Galerie").' '.$r_gal[0].' <span class="text-danger">'.gal_translate(" non supprimée").'</span></h5>';
      }
      while ($r_img = sql_fetch_row($q_img)) {
         $m_img = "modules/$ModPath/mini/$r_img[0]";
         $g_img = "modules/$ModPath/imgs/$r_img[0]";
      echo '<ul class="list-group">';
      echo '<li class="list-group-item lead font-weight-bold">'.$r_img[0].'</li>';
         if (@unlink($m_img)) {
            echo '<li class="list-group-item list-group-item-success">'.gal_translate("Miniature supprimée").'</li>';
         } else {
            echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Miniature non supprimée").'</li>';
         }
         if (@unlink($g_img)) {
            echo '<li class="list-group-item list-group-item-success">'.gal_translate("Image supprimée").'</li>';
         } else {
            echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Image non supprimée").'</li>';
         }
         if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_vot WHERE pic_id='$r_img[1]'")) {
            echo '<li class="list-group-item list-group-item-success">'.gal_translate("Votes supprimés").'</li>';
         } else {
            echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Votes non supprimés").'</li>';
         }
         if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_com WHERE pic_id='$r_img[1]'")) {
            echo '<li class="list-group-item list-group-item-success">'.gal_translate("Commentaires supprimés").'</li>';
         } else {
            echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Commentaires non supprimés").'</li>';
         }
         if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_img WHERE id='$r_img[1]'")) {
            echo '<li class="list-group-item list-group-item-success">'.gal_translate("Enregistrement supprimé").'</li>';
         } else {
            echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Enregistrement non supprimé").'</li>';
         }
      }
      echo '</ul>';
   }
}

/**************************************************************************************************/
//revu phr 02/02/16
/**************************************************************************************************/
function EditImg($id) {
   global $ThisFile, $NPDS_Prefix, $ModPath;

   $queryA = sql_query("SELECT name,comment,gal_id FROM ".$NPDS_Prefix."tdgal_img WHERE id='$id'");
   $rowA = sql_fetch_row($queryA);
   echo '<form action="'.$ThisFile.'" method="post" name="FormModifImg">';
   echo '<input type="hidden" name="subop" value="doeditimg">';
   echo '<input type="hidden" name="imgid" value="'.$id.'">';
   echo '<h4>'.gal_translate("Edition").'</h4>';
   echo '<fieldset class="form-group">';
   echo '<label class="mr-2">'.gal_translate("Catégorie").'</label>';   
   echo '<select name="imggal" class="custom-select">';
   echo select_arbo($rowA[2]);
   echo '</select>
      </fieldset>';
   echo '<fieldset class="form-group">';
   echo '<label>'.gal_translate("Image").'</label>';
   echo '<div class="col-md-12"><img class="img-fluid img-thumbnail" src="modules/'.$ModPath.'/mini/'.$rowA[0].'" alt="'.$rowA[0].'" data-toggle="tooltip" data-placement="bottom" title="'.$rowA[0].'" /></div>';
   echo '</fieldset>';
   echo '<fieldset class="form-group">';
   echo '<label>'.gal_translate("Description").'</label>';
   echo '<input class="form-control" type="text" name="newdesc" value="'.stripslashes($rowA[1]).'">';
   echo '</fieldset>';
   echo '<input class="btn btn-secondary" type="submit" value="'.gal_translate("Modifier").'">';
   echo '</form>';

   $qcomment = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_com WHERE pic_id='$id' ORDER BY comtimestamp DESC");
   $num_comm = sql_num_rows($qcomment);

   echo '<p><ul class="list-group">';
   while ($rowC = sql_fetch_row($qcomment)) {
     
      echo '<li class="list-group-item list-group-item-info justify-content-between">
      '.$rowC[2].' '.gal_translate("a posté le").' '.date(translate("dateinternal"),$rowC[5]).'
      <a class="" href="'.$ThisFile.'&amp;subop=delcomimg&amp;id='.$rowC[0].'&amp;picid='.$rowC[1].'"><i class="fa fa-trash-o fa-lg text-danger" data-original-title="Effacer" data-toggle="tooltip"></i></a></li>';
      echo '<li class="list-group-item">'.stripslashes($rowC[3]).'</li>';
   }
   echo '</ul></p>';
}

function DoEditImg($id,$imggal,$newdesc) {
   global $ThisRedo, $NPDS_Prefix;

   $newtit = addslashes(removeHack($newdesc));
   if ($imggal=='') $imggal="-1";
   if (sql_query("UPDATE ".$NPDS_Prefix."tdgal_img SET gal_id='$imggal', comment='$newtit' WHERE id='$id'")) {
      redirect_url($ThisRedo."&subop=viewarbo");
   } else {
      echo "<script type=\"text/javascript\">\n//<![CDATA[\nalert('Erreur lors de la modification de l'image');\n//]]>\n</script>";
      redirect_url($ThisRedo."&subop=editimg&imgid=$id");
   }
}

/**************************************************************************************************/
//ok 07/03/17
/**************************************************************************************************/

function DelImg($id,$go) {
   global $ThisFile, $NPDS_Prefix, $ModPath;
   if (empty($go)) {
      $q_img = sql_query("SELECT name FROM ".$NPDS_Prefix."tdgal_img WHERE id='$id'");
      $r_img = sql_fetch_row($q_img);
      echo '<p class="card-text lead">'.gal_translate("Vous allez supprimer une image").' : '.$r_img[0].'</p>';
      echo '<p><a class="btn btn-outline-danger btn-sm mr-2" href="'.$ThisFile.'&amp;subop=delimg&amp;imgid='.$id.'&amp;go=true">'.gal_translate("Confirmer").'</a>';
      echo '<a class="btn btn-outline-primary btn-sm" href="'.$ThisFile.'">'.gal_translate("Annuler").'</a>';
      echo '</p>';
   } else {
      $q_img = sql_query("SELECT name FROM ".$NPDS_Prefix."tdgal_img WHERE id='$id'");
      $r_img = sql_fetch_row($q_img);
      $m_img = "modules/$ModPath/mini/$r_img[0]";
      $g_img = "modules/$ModPath/imgs/$r_img[0]";
      echo '<ul class="list-group">';
      echo '<li class="list-group-item lead font-weight-bold">'.$r_img[0].'</li>';
      if (@unlink($m_img)) {
         echo '<li class="list-group-item list-group-item-success">'.gal_translate("Miniature supprimée").'</li>';
      } else {
         echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Miniature non supprimée").'</li>';
      }
      if (@unlink($g_img)) {
         echo '<li class="list-group-item list-group-item-success">'.gal_translate("Image supprimée").'</li>';
      } else {
         echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Image non supprimée").'</li>';
      }
      if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_vot WHERE pic_id='$id'")) {
         echo '<li class="list-group-item list-group-item-success">'.gal_translate("Votes supprimés").'</li>';
      } else {
         echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Votes non supprimés").'</li>';
      }
      if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_com WHERE pic_id='$id'")) {
         echo '<li class="list-group-item list-group-item-success">'.gal_translate("Commentaires supprimés").'</li>';
      } else {
         echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Commentaires non supprimés").'</li>';
      }
      if (sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_img WHERE id='$id'")) {
         echo '<li class="list-group-item list-group-item-success"><strong>'.gal_translate("Enregistrement supprimé").'</strong></li>';
      } else {
         echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Enregistrement non supprimé").'</li>';
      }
      echo '</ul>';
   }
}

function DelComImg($id, $picid) {
   global $ThisRedo, $NPDS_Prefix;

   sql_query("DELETE FROM ".$NPDS_Prefix."tdgal_com WHERE pic_id='$picid' and id='$id'");
   redirect_url($ThisRedo."&subop=editimg&imgid=$picid");
}

function DoValidImg($id) {
   global $ThisRedo, $NPDS_Prefix;

   if (sql_query("UPDATE ".$NPDS_Prefix."tdgal_img SET noaff='0' WHERE id='$id'")) {
      redirect_url($ThisRedo."&subop=viewarbo");
   }
}

function Edit($type,$id) {
   global $ThisFile, $NPDS_Prefix, $ThisRedo;
   if ($type=="Cat") {$query = "SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE id='$id'";}
   if ($type=="Gal") {$query = "SELECT * FROM ".$NPDS_Prefix."tdgal_gal WHERE id='$id'";}
  
   $result = sql_query($query);
   if (!$row=sql_fetch_row($result)) {
      redirect_url($ThisRedo);
   } else {
      $actualname = stripslashes($row[2]);
   }

   echo '<form action="'.$ThisFile.'" method="post" name="FormRename">';
   echo '<input type="hidden" name="subop" value="rename">';
   echo '<input type="hidden" name="type" value="'.$type.'">';
   echo '<input type="hidden" name="gcid" value="'.$id.'">';
   echo '<p>';
   echo '<h5><i class="fa fa-info-circle mr-2"></i>'.gal_translate("Edition").'</h5>';
   echo '</p>';
   //déplacement d'une galerie
   if ($type=="Gal") {
      
      echo '
      <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Catégorie").'</label>
      <div class="col-sm-10">';
      echo '<select class="custom-select" name="newgalcat" size="1">';
      echo cat_arbo($row[1]);
      echo '</select>';
      echo '</div></div>';
   }
      echo '
      <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Accès pour").'</label>
      <div class="col-sm-10">';
   if ($type=="Cat") {
      echo '<select class="custom-select" type="select" name="newacces" size="1">'.Fab_Option_Group($row[3]).'</select>';
   }
   if ($type=="Gal") {
      echo '<select class="custom-select" type="select" name="newacces" size="1">'.Fab_Option_Group($row[4]).'</select>';     
   }
      echo '</div></div>';

      echo '
      <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Nom").'</label>
      <div class="col-sm-10">';
   echo '<input class="form-control" type="text" name="actualname" value="'.$actualname.'" disabled="true">';
   echo '</div></div>';

      echo '
      <div class="form-group row">
      <label class="col-sm-2 form-control-label">'.gal_translate("Nouveau nom").'</label>
      <div class="col-sm-10">';
   echo '<input class="form-control" type="text" name="newname" maxlength="150" value="'.$actualname.'">';
   echo '</div></div>';
   
   echo '<input class="btn btn-outline-primary" type="submit" value='.gal_translate("Modifier").'>';
   echo '</form>';
}

function ChangeName($type,$id,$valeur,$galcat,$acces) {
   global $NPDS_Prefix, $ThisRedo;

   if ($type=="Cat") {$query = "UPDATE ".$NPDS_Prefix."tdgal_cat SET nom=\"$valeur\", acces=\"$acces\" WHERE id=$id";}
   if ($type=="Gal") {$query = "UPDATE ".$NPDS_Prefix."tdgal_gal SET cid=\"$galcat\", nom=\"$valeur\", acces=\"$acces\" WHERE id=$id";}
   $update = sql_query($query);
   redirect_url($ThisRedo);
}

function PrintJavaCodeGal() {
   global $NPDS_Prefix;
   $query = sql_query("SELECT groupe_id, groupe_name FROM ".$NPDS_Prefix."groupes ORDER BY groupe_name");
   $nbgrp = sql_num_rows($query);

   while ($mX = sql_fetch_row($query)) {
      $tmp_groupe[$mX['groupe_id']]=$mX['groupe_name'];
   }

   echo "<script type=\"text/javascript\">\n//<![CDATA[\n";
   echo "var cde_all = new Array;\n";
   echo "var txt_all = new Array;\n";
   echo "var cde_usr = new Array;\n";
   echo "var txt_usr = new Array;\n";
   echo "cde_all[0] = '0'; txt_all[0] = '".adm_translate("Public")."';\n";
   echo "cde_usr[0] = '1'; txt_usr[0] = '".adm_translate("Utilisateur enregistré")."';\n";
   echo "cde_all[1] = '1'; txt_all[1] = '".adm_translate("Utilisateur enregistré")."';\n";
   echo "cde_usr[1] = '-127'; txt_usr[1] = '".gal_translate("Administrateurs")."';\n";
   echo "cde_all[2] = '-127'; txt_all[2] = '".gal_translate("Administrateurs")."';\n";
   if (count($tmp_groupe) != 0) {
      $i = 3;
      while (list($val, $nom) = each($tmp_groupe)) {
         echo "cde_usr[".($i-1)."] = '".$val."'; txt_usr[".($i-1)."] = '".$nom."';\n";
         echo "cde_all[".$i."] = '".$val."'; txt_all[".$i."] = '".$nom."';\n";
         $i++;
      }
   }
   echo "\n";
   echo "function verif() {\n";
   echo "  if (document.layers) {\n";
   echo "    formulaire = document.forms.FormCreer;\n";
   echo "  } else {\n";
   echo "    formulaire = document.FormCreer;\n";
   echo "  }\n";
   echo "  formulaire.acces.options.length = 1;\n";
   echo "}\n\n";
   echo "function remplirAcces(index,code) {\n";
   echo "  verif();\n";
   echo "  if(code.substring(code.lastIndexOf('(')+1) == '".adm_translate("Public").")') { //All\n";
   echo "    formulaire.acces.options.length = cde_all.length;\n";
   echo "    for(i=0; i<cde_all.length; i++) {\n";
   echo "      formulaire.acces.options[i].value = cde_all[i];\n";
   echo "      formulaire.acces.options[i].text = txt_all[i];\n";
   echo "    }\n";
   echo "  } else if(code.substring(code.lastIndexOf('(')+1) == '".adm_translate("Utilisateur enregistré").")') { //User\n";
   echo "    formulaire.acces.options.length = cde_usr.length;\n";
   echo "    for(i=0; i<cde_usr.length; i++) {\n";
   echo "      formulaire.acces.options[i].value = cde_usr[i];\n";
   echo "      formulaire.acces.options[i].text = txt_usr[i];\n";
   echo "    }\n";
   echo "  } else {\n";
   echo "    formulaire.acces.options.length = 1;\n";
   echo "    for(i=0; i<cde_all.length; i++) {\n;";
   echo "      if(code.substring(code.lastIndexOf('(')+1) == txt_all[i]+')') {\n";
   echo "        formulaire.acces.options[0].value = cde_all[i];\n";
   echo "        formulaire.acces.options[0].text = txt_all[i];\n";
   echo "      }\n";
   echo "    }\n";
   echo "  }\n";
   echo "}";
   echo "\n//]]>\n</script>\n";
}

function Fab_Option_Group($GrpActu="0") {
   $tmp_group = Get_Name_Group("list", $GrpActu);
   while (list($val, $nom) = each($tmp_group)) {
      if ($val == $GrpActu) {
         $txt.= '<option value="'.$val.'" selected>&nbsp;'.$nom.'&nbsp;</option>';
      } else {
         $txt.= '<option value="'.$val.'">&nbsp;'.$nom.'&nbsp;</option>';
      }
   }
   return $txt;
}

function Get_Name_Group($ordre, $GrpActu) {
   $tmp_groupe = liste_group("");
   $tmp_groupe[127] = gal_translate("Administrateurs");
   $tmp_groupe[0] = adm_translate("Public");
   $tmp_groupe[1] = adm_translate("Utilisateur enregistré");
   if ($ordre=="list") {
      asort($tmp_groupe);
      return ($tmp_groupe);
   } else {
      return ($tmp_groupe[abs($GrpActu)]);
   }
}

function GetGalCat($galcid) {
   global $NPDS_Prefix;

   $query = sql_query("SELECT nom,cid FROM ".$NPDS_Prefix."tdgal_cat WHERE id='".$galcid."'");
   $row = sql_fetch_row($query);
  
   if ($row[1] == 0) {
      return stripslashes($row[0]);
   } else {
      $queryX = sql_query("SELECT nom FROM ".$NPDS_Prefix."tdgal_cat WHERE id='".$row[1]."'");
      $rowX = sql_fetch_row($queryX);
      return stripslashes($rowX[0])." - ".stripslashes($row[0]);
   }
}

// CreateThumb($newfilename, "modules/$ModPath/imgs/", "modules/$ModPath/mini/", $MaxSizeThumb, $filename_ext);
function CreateThumb($Image, $Source, $Destination, $Max, $ext) {
   if ($ext=="gif") {
      if (function_exists("imagecreatefromgif"))
         $src=@imagecreatefromgif($Source.$Image);
   } else {
      $src=@imagecreatefromjpeg($Source.$Image);
   }
   if ($src) {
      $size = getimagesize($Source.$Image);
      $h_i = $size[1]; //hauteur
      $w_i = $size[0]; //largeur

      if (($h_i > $Max) || ($w_i > $Max)) {
         if ($h_i > $w_i) {
            $convert = $Max/$h_i;
            $h_i = $Max;
            $w_i = ceil($w_i*$convert);
         } else {
            $convert = $Max/$w_i;
            $w_i = $Max;
            $h_i = ceil($h_i*$convert);
         }
       }

      if (function_exists("imagecreatetruecolor")) {
         $im = @imagecreatetruecolor($w_i, $h_i);
      } else {
         $im = @imagecreate($w_i, $h_i);
      }
  
      @imagecopyresized($im, $src, 0, 0, 0, 0, $w_i, $h_i, $size[0], $size[1]);
      @imageinterlace ($im,1);
      if ($ext=="gif") {
         @imagegif($im, $Destination.$Image);
      } else {
         @imagejpeg($im, $Destination.$Image, 100);
      }
      @chmod($Dest.$Image,0766);
   }
}

/**************************************************************************************************/
//revu phr 02/02/16
/**************************************************************************************************/
function import() {
   global $ModPath, $ModStart, $NPDS_Prefix, $ThisFile, $ThisRedo;

   echo '<form method="post" action="'.$ThisFile.'" name="MassImport">';
   echo '<input type="hidden" name="subop" value="massimport">';
   echo '
      <fieldset class="form-group">
      <label for="">'.gal_translate("Affectation").'</label>
      <select name="imggal" class="custom-select" id="">';
   echo select_arbo("");
   echo '
      </select>
      </fieldset>
      <fieldset class="form-group">
      <label for="">'.gal_translate("Description").'</label>
      <input type="text" class="form-control" name="descri" id="" placeholder="">
      </fieldset>
      <button class="btn btn-outline-primary" type="submit">'.gal_translate("Importer").'</button>
      </form>';   
}

function massimport($imggal, $descri) {
   global $MaxSizeImg, $MaxSizeThumb, $ModPath, $ModStart, $NPDS_Prefix;

   $year = date("Y"); $month = date("m"); $day = date("d");
   $hour = date("H"); $min = date("i"); $sec = date("s");

   $handle=opendir("modules/$ModPath/import");
   while ($file = readdir($handle)) $filelist[] = $file;
   closedir($handle);
   asort($filelist);

   $i=1;
   while (list ($key, $file) = each ($filelist)) {
      if (preg_match('#\.gif|\.jpg$#i', strtolower($file))) {
         $filename_ext = strtolower(substr(strrchr($file, "."),1));
         $newfilename = $year.$month.$day.$hour.$min.$sec."-".$i.".".$filename_ext;
         rename("modules/$ModPath/import/$file","modules/$ModPath/import/$newfilename");
         if ((function_exists('gd_info')) or extension_loaded('gd')) {
            @CreateThumb($newfilename, "modules/$ModPath/import/", "modules/$ModPath/imgs/", $MaxSizeImg, $filename_ext);
            @CreateThumb($newfilename, "modules/$ModPath/import/", "modules/$ModPath/mini/", $MaxSizeThumb, $filename_ext);
         }
      echo '<ul class="list-group">';
         if (sql_query("INSERT INTO ".$NPDS_Prefix."tdgal_img VALUES ('','$imggal','$newfilename','$descri','','0','0')")) {
            echo '<li class="list-group-item list-group-item-success"><i class="fa fa-info-circle"></i> '.gal_translate("Image ajoutée avec succès").' : '.$file.'</li>';
            $i++;
         } else {
            echo '<li class="list-group-item list-group-item-danger">'.gal_translate("Impossible d'ajouter l'image en BDD").'</li>';
            @unlink ("modules/$ModPath/imgs/$newfilename");
            @unlink ("modules/$ModPath/mini/$newfilename");
         }
         echo '</ul>';
         @unlink ("modules/$ModPath/import/$newfilename");
      }
   }
}

function ordre($ximg, $xordre) {
   global $ThisRedo, $NPDS_Prefix;

   while(list($ibid,$img_id)=each($ximg)) {
      echo $img_id, $xordre[$ibid]."<br />";
      sql_query("UPDATE ".$NPDS_Prefix."tdgal_img SET ordre='$xordre[$ibid]' WHERE id='$img_id'");
   }
   redirect_url($ThisRedo."&subop=viewarbo");
}

/**************************************************************************************************/
//revu phr 02/02/16
/**************************************************************************************************/
function PrintExportCat() {
   global $NPDS_Prefix, $ThisFile;
   echo '<form action="'.$ThisFile.'" method="post" name="FormCat">';
   echo '<input type="hidden" name="subop" value="massexport">';
   echo '
      <fieldset class="form-group">
      <label for="">'.gal_translate("Nom de la catégorie").'</label>
      <select name="cat" class="custom-select" id="">
      <option value="none" selected>'.gal_translate("Choisissez").'</option>';
   $query = sql_query("SELECT id,nom,acces FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='0' ORDER BY nom ASC");
   while ($row = sql_fetch_row($query)) {
      echo '<option value='.$row[0].'>'.stripslashes($row[1]).'</option>';
   }
   echo '
      </select>
      </fieldset>
      <button class="btn btn-outline-primary" type="submit">'.gal_translate("Exporter").'</button>
      </form>';
}

/**************************************************************************************************/
//revu phr 02/02/16 voir pour ajout message pour informer du bon déroulement de l'op
/**************************************************************************************************/
function MassExportCat($cat) {
   global $NPDS_Prefix, $ThisRedo, $ModPath;

   $sql_cat = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE id='$cat'");
   $num_cat = sql_num_rows($sql_cat);
   if ($num_cat != 0) {
      $sql_sscat = "SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE cid=$cat";
      $sql_gal = "SELECT * FROM ".$NPDS_Prefix."tdgal_gal";
      // CATEGORIE
      $nb_gal=0;
      $nb_img=0;
      while ($row_cat = sql_fetch_row($sql_cat)) {
         $ibid.="INSERT INTO tdgal_cat VALUES ($row_cat[0], $row_cat[1], '".htmlentities($row_cat[2])."',$row_cat[3]);\n";
         $queryX = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_gal WHERE cid='".$row_cat[0]."' ORDER BY nom ASC");
         while ($rowX_gal = sql_fetch_row($queryX)) {
            $ibid.="INSERT INTO tdgal_gal VALUES ($rowX_gal[0], $rowX_gal[1], '".htmlentities($rowX_gal[2])."', $rowX_gal[3], $rowX_gal[4]);\n";
            $nb_gal++;
            // trouver les images
            $queryZ = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='".$rowX_gal[0]."' ORDER BY ordre,id");
            while ($rowZ_img = sql_fetch_row($queryZ)) {
               copy("modules/$ModPath/mini/$rowZ_img[2]","modules/$ModPath/export/mini/$rowZ_img[2]");
               copy("modules/$ModPath/imgs/$rowZ_img[2]","modules/$ModPath/export/imgs/$rowZ_img[2]");
               $ibid.="INSERT INTO ".$NPDS_Prefix."tdgal_img VALUES (NULL, $rowX_gal[0], '".htmlentities($rowZ_img[2])."', '".htmlentities($rowZ_img[3])."', 0, $rowZ_img[5], 0);\n";
               $nb_img++;
            }
         }
         $ibid.="\n";
         // SOUS-CATEGORIE
         $query = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='".$row_cat[0]."' ORDER BY nom ASC");
         while ($row_sscat = sql_fetch_row($query)) {
            $ibid.="INSERT INTO tdgal_cat VALUES ($row_sscat[0], $row_sscat[1], '".htmlentities($row_sscat[2])."',$row_sscat[3]);\n";
            $querx = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_gal WHERE cid='".$row_sscat[0]."' ORDER BY nom ASC");
            while ($row_gal = sql_fetch_row($querx)) {
               $ibid.="INSERT INTO tdgal_gal VALUES ($row_gal[0], $row_gal[1], '".htmlentities($row_gal[2])."', $row_gal[3], $row_gal[4]);\n";
               $nb_gal++;
               // trouver les images
               $queryZ = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='".$row_gal[0]."' ORDER BY ordre,id");
               while ($rowZ_img = sql_fetch_row($queryZ)) {
                  copy("modules/$ModPath/mini/$rowZ_img[2]","modules/$ModPath/export/mini/$rowZ_img[2]");
                  copy("modules/$ModPath/imgs/$rowZ_img[2]","modules/$ModPath/export/imgs/$rowZ_img[2]");
                  $ibid.="INSERT INTO ".$NPDS_Prefix."tdgal_img VALUES (NULL, $row_gal[0], '".htmlentities($rowZ_img[2])."', '".htmlentities($rowZ_img[3])."', 0, $rowZ_img[5], 0);\n";
                  $nb_img++;
               }
            }
         }
      }
   }
   $ibid.="\n";
   $ibid.="# ----------------------------------------\n";
   $ibid.="# Nombre de galeries exportées $nb_gal\n";
   $ibid.="# Nombre d'images exportées : $nb_img\n";
   $ibid.="# ----------------------------------------\n";
   $ibid.="# Attention les numeros de catégories et  \n";
   $ibid.="# de galeries peuvent être en conflit avec\n";
   $ibid.="# ceux de votre TD-Galerie.  \n";
   $ibid.="# ----------------------------------------\n";
   
   if ($myfile = fopen("modules/$ModPath/export/sql/export.sql", "wb")) {
      fwrite($myfile, "$ibid");
      fclose($myfile);
      unset($content);
      redirect_url($ThisRedo);
   } else {
      redirect_url($ThisRedo);
   }
}
?>