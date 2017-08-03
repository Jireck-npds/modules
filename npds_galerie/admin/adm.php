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
   include_once("modules/$ModPath/lang/galerie-$language.php");

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

   echo '<div id="adm_men">';
   echo '<h2><img class="mr-2" src="modules/npds_galerie/npds_galerie.png" alt="icon_npds_galerie">'.gal_translate('Galeries de photos').'<small class="float-right">'.$npds_gal_version.'</small></h2>';
   echo '<div class="card mb-2"><div class="card-body"><ul class="list-inline">
   <li class="list-inline-item"><a class="btn btn-secondary my-1" href="'.$ThisFile.'" role="button" data-original-title="'.gal_translate("Accueil").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-home" aria-hidden="true"></i></a></li>
   <li class="list-inline-item"><a class="btn btn-secondary my-1" href="'.$ThisFile.'&amp;subop=config" role="button" data-original-title="'.gal_translate("Configuration").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-cogs" aria-hidden="true"></i></a></li>
   <li class="list-inline-item"><a class="btn btn-secondary my-1" href="'.$ThisFile.'&amp;subop=viewarbo" role="button" data-original-title="'.gal_translate("Arborescence").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-sitemap" aria-hidden="true"></i></a></li>
   <li class="list-inline-item"><a class="btn btn-secondary my-1" href="'.$ThisFile.'&amp;subop=formcregal" role="button" data-original-title="'.gal_translate("Ajout galerie").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-plus mr-2" aria-hidden="true"></i>Gal</a></li>
   <li class="list-inline-item"><a class="btn btn-secondary my-1" href="'.$ThisFile.'&amp;subop=formcat" role="button" data-original-title="'.gal_translate("Ajout catégorie").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-plus mr-2" aria-hidden="true"></i>Cat</a></li>
   <li class="list-inline-item"><a class="btn btn-secondary my-1" href="'.$ThisFile.'&amp;subop=formsscat" role="button" data-original-title="'.gal_translate("Ajout sous-catégorie").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-plus mr-2" aria-hidden="true"></i>S-Cat</a></li>
   <li class="list-inline-item"><a class="btn btn-secondary my-1" href="'.$ThisFile.'&amp;subop=formimgs" role="button" data-original-title="'.gal_translate("Ajout images").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-plus mr-2" aria-hidden="true"></i><i class="fa fa-picture-o"></i></a></li>
   <li class="list-inline-item"><a class="btn btn-secondary my-1" href="'.$ThisFile.'&amp;subop=import" role="button" data-original-title="'.gal_translate("Import images").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></a></li>
   <li class="list-inline-item"><a class="btn btn-secondary my-1" href="'.$ThisFile.'&amp;subop=export" role="button" data-original-title="'.gal_translate("Export catégorie").'" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></a></li>
   </ul>
   </div></div>';
   settype($subop,'string');
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

     $numgal[0] = ($numgal[0] -1);

   echo '<p class="lead"><i class="fa fa-info-circle mr-2" aria-hidden="true"></i>'.gal_translate("Tableau récapitulatif").'</p>';
   echo '<ul class="list-group">
   <li class="list-group-item justify-content-between">'.gal_translate("Nombre de catégories").'<span class="badge badge-secondary">'.$ncateg[0].'</span></li>
   <li class="list-group-item justify-content-between">'.gal_translate("Nombre de sous-catégories").'<span class="badge badge-secondary">'.$nsscat[0].'</span></li>
   <li class="list-group-item justify-content-between">'.gal_translate("Nombre de galeries").'<span class="badge badge-secondary">'.$numgal[0].'</span></li>
   <li class="list-group-item justify-content-between">'.gal_translate("Nombre d'images").'<span class="badge badge-secondary">'.$ncards[0].'</span></li>
   <li class="list-group-item justify-content-between">'.gal_translate("Nombre de commentaires").'<span class="badge badge-secondary">'.$ncomms[0].'</span></li> 
   <li class="list-group-item justify-content-between">'.gal_translate("Nombre de votes").'<span class="badge badge-secondary">'.$nvotes[0].'</span></li>
   <li class="list-group-item justify-content-between">'.gal_translate("Images vues").'<span class="badge badge-secondary">'.$nviews[0].'</span></li>
   </ul>
   ';
     break;
   }
   echo '</div>';
include "footer.php";
}
?>