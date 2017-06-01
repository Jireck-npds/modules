<?php
/************************************************************************/
/* NMIG : NPDS Module Installer Generator                               */
/* --------------------------------------                               */
/* Version 2.0 - 2015                                                   */
/* --------------------------                                           */
/* Générateur de fichier de configuration pour Module-Install 1.1       */
/* Développé par Boris - http://www.lordi-depanneur.com                 */
/* Module-Install est un installeur inspiré du programme d'installation */
/* d'origine du module Hot-Projet développé par Hotfirenet              */
/*                                                                      */
/* NPDS : Net Portal Dynamic System                                     */
/*                                                                      */
/* NPDS Copyright (c) 2002-2015 by Philippe Brunier                     */
/*                                                                      */
/* v2.0 for NPDS 16 jpb 2016                                            */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/************************************************************************/
global $ModInstall;
#autodoc $name_module: Nom du module
$name_module = 'npds_galerie';

#autodoc $path_adm_module: chemin depuis $ModInstall #required si admin avec interface
$path_adm_module = 'admin/adm';

$req_adm='';//do not fill
if ($path_adm_module!='')
$req_adm="INSERT INTO fonctions (fid,fnom,fdroits1,fdroits1_descr,finterface,fetat,fretour,fretour_h,fnom_affich,ficone,furlscript,fcategorie,fcategorie_nom,fordre) VALUES ('', '".$ModInstall."', 1, '', 1, 1, '', '', 'npds_galerie 3.0', 'npds_galerie', 'href=\"admin.php?op=Extend-Admin-SubModule&ModPath=".$ModInstall."&ModStart=".$path_adm_module."\"', 6, 'Modules', 0);";


#autodoc $sql = array(""): Si votre module doit exécuter une ou plusieurs requêtes SQL, tapez vos requêtes ici.
#autodoc Attention! UNE requête par élément de tableau!
#autodoc Synopsis: $sql = array("requête_sql_1","requête_sql_2");
global $NPDS_Prefix;
$sql = array("CREATE TABLE ".$NPDS_Prefix."tdgal_cat (
  id int(11) NOT NULL auto_increment,
  cid int(11) NOT NULL default '0',
  nom varchar(150) NOT NULL default '',
  acces tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=utf8;",
"CREATE TABLE ".$NPDS_Prefix."tdgal_com (
  id int(11) NOT NULL auto_increment,
  pic_id int(11) NOT NULL default '0',
  user varchar(60) NOT NULL default '',
  comment text NOT NULL,
  comhostname varchar(60) NOT NULL default '',
  comtimestamp varchar(14) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=utf8;",
"CREATE TABLE ".$NPDS_Prefix."tdgal_gal (
  id int(11) NOT NULL auto_increment,
  cid int(11) NOT NULL default '0',
  nom varchar(150) NOT NULL default '',
  date varchar(14) default NULL,
  acces tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=utf8;",
"INSERT INTO ".$NPDS_Prefix."tdgal_gal VALUES (1, -1, 'Import', NULL, -127);",
"CREATE TABLE ".$NPDS_Prefix."tdgal_img (
  id int(11) NOT NULL auto_increment,
  gal_id int(11) NOT NULL default '0',
  name varchar(40) NOT NULL default '',
  comment varchar(255) NOT NULL default '',
  view int(11) NOT NULL default '0',
  ordre int(11) NOT NULL default '0',
  noaff int(1) unsigned default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=utf8;",
"CREATE TABLE ".$NPDS_Prefix."tdgal_vot (
  id int(11) NOT NULL auto_increment,
  pic_id int(11) NOT NULL default '0',
  user varchar(60) NOT NULL default '',
  rating tinyint(4) NOT NULL default '0',
  ratinghostname varchar(60) NOT NULL default '',
  ratingtimestamp varchar(14) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=utf8;");

if($path_adm_module!='') $sql[]=$req_adm;


#autodoc $blocs = array(array(""), array(""), array(""), array(""), array(""), array(""), array(""), array(""), array(""))
#autodoc                titre      contenu    membre     groupe     index      rétention  actif      aide       description
#autodoc Configuration des blocs

$blocs = array(array("Galeries Photo"), array("include#modules/".$ModInstall."/imgalea.php"), array("0"), array(""), array("1"), array("0"), array("1"), array(""), array("Galeries Photo"));


#autodoc $txtdeb : Vous pouvez mettre ici un texte de votre choix avec du html qui s'affichera au début de l'install
#autodoc Si rien n'est mis, le texte par défaut sera automatiquement affiché

$txtdeb = '<br /><strong>Attention:</strong> si le module '.$ModInstall.' est déjà installé sur votre site, veuillez sauter l\'étape de création de la base de données<br /><br />Sinon les tables tdgal_* de votre base de données seront écrasées</b><br /><br />';


#autodoc $txtfin : Vous pouvez mettre ici un texte de votre choix avec du html qui s'affichera à la fin de l'install

$txtfin = 'Nous vous recommandons de lire le tutorial situé dans le répertoire install du module.<br />Pour les questions et le support rendez vous sur <a href="http://modules.npds.org" target="_blank">modules.npds.org</a>';


#autodoc $link: Lien sur lequel sera redirigé l'utilisateur à la fin de l'install (si laissé vide, redirigé sur index.php)
#autodoc N'oubliez pas les '\' si vous utilisez des guillemets !!!

$end_link = 'admin.php?op=Extend-Admin-SubModule&ModPath='.$ModInstall.'&ModStart=admin/adm';
?>