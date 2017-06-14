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
/* NPDS Copyright (c) 2002-2017 by Philippe Brunier                     */
/*                                                                      */
/* v2.0 for NPDS 16 jpb 2016                                            */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/************************************************************************/

global $ModInstall;

#autodoc $name_module: Nom du module

$name_module = "npds_annonces 3.0";


#autodoc $path_adm_module: chemin depuis $ModInstall #required si admin avec interface
$path_adm_module = 'admin/adm';


//do not fill
$req_adm='';

// pour l'affichage du nom du module
$affich='npds_annonces';

// c'est un nom de fichier(sans extension) !!
$icon='npds_annonces';

if ($path_adm_module!='')
$req_adm="INSERT INTO fonctions (fid,fnom,fdroits1,fdroits1_descr,finterface,fetat,fretour,fretour_h,fnom_affich,ficone,furlscript,fcategorie,fcategorie_nom,fordre) VALUES ('', '".$ModInstall."', 1, '', 1, 1, '', '', '".$affich."', '".$icon."', 'href=\"admin.php?op=Extend-Admin-SubModule&ModPath=".$ModInstall."&ModStart=".$path_adm_module."\"', 6, 'Modules', 0);";


#autodoc $list_fich : Modifications de fichiers: Dans le premier tableau, tapez le nom du fichier
#autodoc et dans le deuxième, A LA MEME POSITION D'INDEX QUE LE PREMIER, tapez le code à insérer dans le fichier.
#autodoc Si le fichier doit être créé, n'oubliez pas les < ? php et ? > !!! (sans espace!).
#autodoc Synopsis: $list_fich = array(array("nom_fichier1","nom_fichier2"), array("contenu_fchier1","contenu_fichier2"));
$list_fich = '';

#autodoc $sql = array(""): Si votre module doit exécuter une ou plusieurs requêtes SQL, tapez vos requêtes ici.
#autodoc Attention! UNE requête par élément de tableau!
#autodoc Synopsis: $sql = array("requête_sql_1","requête_sql_2");

$sql='';
$sql = array("CREATE TABLE ".$NPDS_Prefix."g_annonces (
  id bigint(20) NOT NULL auto_increment,
  id_user bigint(20) DEFAULT NULL,
  id_cat mediumint(11) DEFAULT NULL,
  tel varchar(20) NOT NULL DEFAULT '',
  tel_2 varchar(20) NOT NULL DEFAULT '',
  code varchar(5) NOT NULL DEFAULT '',
  ville varchar(40) NOT NULL DEFAULT '',
  date varchar(20) NOT NULL DEFAULT '',
  text mediumtext NOT NULL,
  en_ligne tinyint(1) NOT NULL DEFAULT '0',
  prix decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
"CREATE TABLE ".$NPDS_Prefix."g_categories (
  id_cat mediumint(11) NOT NULL auto_increment,
  id_cat2 mediumint(11) NOT NULL DEFAULT '0',
  categorie varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (id_cat)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

if($path_adm_module!='') $sql[]=$req_adm;

#autodoc $blocs = array(array(""), array(""), array(""), array(""), array(""), array(""), array(""), array(""), array(""))
#autodoc                titre      contenu    membre     groupe     index      rétention  actif      aide       description
#autodoc Configuration des blocs

$blocs = array(array("Petites Annonces"), array("include#modules/npds_annonces/bloc1.php"), array("0"), array(""), array("1"), array("0"), array("1"), array(""), array("Petites Annonces"));


#autodoc $txtdeb : Vous pouvez mettre ici un texte de votre choix avec du html qui s'affichera au début de l'install
#autodoc Si rien n'est mis, le texte par défaut sera automatiquement affiché

$txtdeb = "";


#autodoc $txtfin : Vous pouvez mettre ici un texte de votre choix avec du html qui s'affichera à la fin de l'install

$txtfin = '<p>Merci d\'utiliser npds_annonces<br /><br /><a href="http://modules.npds.org" target="_blank">modules.npds.org</a></p>';


#autodoc $link: Lien sur lequel sera redirigé l'utilisateur à la fin de l'install (si laissé vide, redirigé sur index.php)
#autodoc N'oubliez pas les '\' si vous utilisez des guillemets !!!

$end_link = "";
?>