<?php
/**************************************************************************************************/
/* Module de gestion de galeries pour NPDS                                                        */
/* ===================================================                                            */
/* (c) 2004-2005 Tribal-Dolphin - http://www.tribal-dolphin.net                                   */
/* (c) 2007 Xgonin, Lopez - http://modules.npds.org                                               */
/* MAJ conformité XHTML pour REvolution 10.02 par jpb/phr en mars 2010                            */
/* MAJ Dev - 2011                                                                                 */
/*                                                                                                */
/* This program is free software. You can redistribute it and/or modify it under the terms of     */
/* the GNU General Public License as published by the Free Software Foundation; either version 2  */
/* of the License.                                                                                */
/**************************************************************************************************/

// For More security
if (!strstr($PHP_SELF,'admin.php')) { Access_Error(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security

$f_meta_nom ='npds_galerie';
//==> controle droit
admindroits($aid,$f_meta_nom);
//<== controle droit

/**************************************************************************************************/
/* Administration du MODULE                                                                       */
/**************************************************************************************************/
if ($admin) {
   global $language, $ModPath, $ModStart, $NPDS_Prefix, $f_meta_nom, $f_titre, $adminimg;
   include_once("modules/$ModPath/gal_conf.php");
   include_once("modules/$ModPath/admin/adm_func.php");
   include_once("modules/$ModPath/lang/$language.php");
   $f_titre = gal_trans("Administration des galeries");

   //update Tables for 2.2 release
   $result=sql_query("SELECT noaff from ".$NPDS_Prefix."tdgal_img");
   if (sql_num_rows($result)==0) {
      sql_query("ALTER TABLE ".$NPDS_Prefix."tdgal_img ADD `noaff` int(1) unsigned default '0'");
   }
   //update Tables for 2.1 release

   // Paramètres utilisé par le script
   $ThisFile = "admin.php?op=Extend-Admin-SubModule&amp;ModPath=$ModPath&amp;ModStart=$ModStart";
   $ThisRedo = "admin.php?op=Extend-Admin-SubModule&ModPath=$ModPath&ModStart=$ModStart";

   // En-Tête
   GraphicAdmin($hlpfile);   
//   adminhead ($f_meta_nom, $f_titre, $adminimg);
   echo '<div class="row" id="adm_men">';
   echo '<h3>'.gal_trans("Administration des galeries").'</h3>';
   echo '
<div class="btn-toolbar" role="toolbar" aria-label="commandes admin">
   <div class="btn-group" role="group" aria-label="group1">
      <a class="btn btn-primary-outline" href="'.$ThisFile.'" role="button" data-original-title="'.gal_trans("Accueil").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home" aria-hidden="true"></i></a>
   </div>
   <div class="btn-group" role="group" aria-label="group2">
      <a class="btn btn-primary-outline" href="'.$ThisFile.'&amp;subop=config" role="button" data-original-title="'.gal_trans("Configuration").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-cogs" aria-hidden="true"></i></a>
   </div> 
   <div class="btn-group" role="group" aria-label="group3">  
      <a class="btn btn-primary-outline" href="'.$ThisFile.'&amp;subop=viewarbo" role="button" data-original-title="'.gal_trans("Arborescence").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-sitemap" aria-hidden="true"></i></a>
   </div>      
   <div class="btn-group" role="group" aria-label="group4">
      <a class="btn btn-primary-outline" href="'.$ThisFile.'&amp;subop=formcregal" role="button" data-original-title="'.gal_trans("Ajout galerie").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-plus" aria-hidden="true"></i> Gal</a>
      <a class="btn btn-primary-outline" href="'.$ThisFile.'&amp;subop=formcat" role="button" data-original-title="'.gal_trans("Ajout catégorie").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-plus" aria-hidden="true"></i> Cat</a>
      <a class="btn btn-primary-outline" href="'.$ThisFile.'&amp;subop=formsscat" role="button" data-original-title="'.gal_trans("Ajout sous-catégorie").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-plus" aria-hidden="true"></i> s-Cat</a>
      <a class="btn btn-primary-outline" href="'.$ThisFile.'&amp;subop=formimgs" role="button" data-original-title="'.gal_trans("Ajout images").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-picture-o"></i></a>
   </div>
   <div class="btn-group" role="group" aria-label="group5">
      <a class="btn btn-primary-outline" href="'.$ThisFile.'&amp;subop=import" role="button" data-original-title="'.gal_trans("Import images").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></a>
   </div>
   <div class="btn-group" role="group" aria-label="group6">
      <a class="btn btn-primary-outline" href="'.$ThisFile.'&amp;subop=export" role="button" data-original-title="'.gal_trans("Export catégorie").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></a>
   </div>
</div>
';

   switch($subop) {
   case "formcat" :
     PrintFormCat();
     break;
   case "addcat" :
     AddACat($newcat,$acces);
     break;
   case "formsscat" :
     PrintFormSSCat();
     break;
   case "addsscat" :
     AddSsCat($cat,$newsscat,$acces);
     break;
   case "formcregal" :
     PrintCreerGalery();
     break;
   case "creegal" :
     AddNewGal($galcat,$newgal,$acces);
     break;
   case "formimgs" :
     PrintFormImgs();
     break;
   case "addimgs" :
     AddImgs($imggal,$newcard1,$newdesc1,$newcard2,$newdesc2,$newcard3,$newdesc3,$newcard4,$newdesc4,$newcard5,$newdesc5);
     break;
   case "viewarbo" :
     PrintArbo();
     break;
   case "delcat" :
     DelCat($catid,$go);
     break;
   case "editcat" :
     Edit("Cat",$catid);
     break;
   case "delsscat" :
     DelSsCat($sscatid,$go);
     break;
   case "delgal" :
     DelGal($galid,$go);
     break;
   case "editgal" :
     Edit("Gal",$galid);
     break;
   case "editimg" :
     EditImg($imgid);
     break;
   case "doeditimg" :
     DoEditImg($imgid,$imggal,$newdesc);
     break;
   case "delimg" :
     DelImg($imgid,$go);
     break;
   case "validimg" :
     DoValidImg($imgid);
     break;
   case "delcomimg" :
     DelComImg($id,$picid);
     break;
   case "rename" :
     if ($actualname == $newname) { redirect_url($ThisRedo); }
     ChangeName($type,$gcid,$newname,$newgalcat,$newacces);
     break;
   case "config" :
     PrintFormConfig();
     break;
   case "wrtconfig" :
     WriteConfig($maxszimg,$maxszthb,$nbimlg,$nbimpg,$nbimcomment,$nbimvote,$viewalea,$viewlast,$votegal,$commgal,$votano,$comano,$postano,$notifadmin);
     break;
   case "import" :
     import();
     break;
   case "massimport" :
     massimport($imggal, $descri);
     break;
   case "export" :
     PrintExportCat();
     break;
   case "massexport" :
     MassExportCat($cat);
     break;
   case "ordre" :
     ordre($img_id, $ordre);
     break;

   default :
     $ncateg = sql_fetch_row(sql_query("SELECT COUNT(id) FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='0'"));
     $nsscat = sql_fetch_row(sql_query("SELECT COUNT(id) FROM ".$NPDS_Prefix."tdgal_cat WHERE cid!='0'"));
     $numgal = sql_fetch_row(sql_query("SELECT COUNT(id) FROM ".$NPDS_Prefix."tdgal_gal"));
     $ncards = sql_fetch_row(sql_query("SELECT COUNT(id) FROM ".$NPDS_Prefix."tdgal_img"));
     $ncomms = sql_fetch_row(sql_query("SELECT COUNT(id) FROM ".$NPDS_Prefix."tdgal_com"));
     $nvotes = sql_fetch_row(sql_query("SELECT COUNT(id) FROM ".$NPDS_Prefix."tdgal_vot"));
     $nviews = sql_fetch_row(sql_query("SELECT SUM(view) FROM ".$NPDS_Prefix."tdgal_img"));

   echo '<br />';
   
   echo '<h4><i class="fa fa-info-circle" aria-hidden="true"></i> '.gal_trans("Tableau récapitulatif").'</h4>';
   echo '<ul class="list-group">
   <li class="list-group-item">'.gal_trans("Nombre de catégories").'<span class="label label-default pull-xs-right">'.$ncateg[0].'</span></li>
   <li class="list-group-item">'.gal_trans("Nombre de sous-catégories").'<span class="label label-default pull-xs-right">'.$nsscat[0].'</span></li>   
   <li class="list-group-item">'.gal_trans("Nombre de galeries").'<span class="label label-default pull-xs-right">'.$numgal[0].'</span></li>
   <li class="list-group-item">'.gal_trans("Nombre d'images").'<span class="label label-default pull-xs-right">'.$ncards[0].'</span></li>   
   <li class="list-group-item">'.gal_trans("Nombre de commentaires").'<span class="label label-default pull-xs-right">'.$ncomms[0].'</span></li> 
   <li class="list-group-item">'.gal_trans("Nombre de votes").'<span class="label label-default pull-xs-right">'.$nvotes[0].'</span></li>   
   <li class="list-group-item">'.gal_trans("Images vues").'<span class="label label-default pull-xs-right">'.$nviews[0].'</span></li>
   <li class="list-group-item">'.gal_trans("Version du module").'<span class="label label-default pull-xs-right">Version : '.$npds_gal_version.'</span></li>   
   </ul>
   ';
     break;
   }
   echo '</div>';
include "footer.php";
}
?>