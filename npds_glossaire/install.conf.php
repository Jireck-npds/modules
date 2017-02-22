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
/* Module npds_glossaire v 3.0 pour revolution 16                       */
/* by team jpb/phr 2017                                                 */
/*                                                                      */
/* From Glossaire version 1.3 pour myPHPNuke 1.8                        */
/* Copyright © 2001, Pascal Le Boustouller                              */
/* Tribal-dolphin 2008                                                  */
/************************************************************************/

global $ModInstall;
#autodoc $name_module: Nom du module

$name_module = "npds_glossaire 3.0";

#autodoc $path_adm_module: chemin depuis $ModInstall #required si admin avec interface
$path_adm_module = 'admin/glossadmin';

$req_adm='';//do not fill
$affich='npds_glossaire'; // pour l'affichage du nom du module
$icon='npds_glossaire'; // c'est un nom de fichier(sans extension) !!

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
$sql = array("CREATE TABLE ".$NPDS_Prefix."td_glossaire (
  id int(10) NOT NULL auto_increment,
  gcat varchar(30) default NULL,
  lettre varchar(8) NOT NULL default '',
  nom longtext NOT NULL,
  definition longtext NOT NULL,
  affiche int(1) NOT NULL default '0',
  lien varchar(255) NOT NULL default '',
  PRIMARY KEY (id)
) TYPE=MyISAM;");

if($path_adm_module!='') $sql[]=$req_adm;

#autodoc $blocs = array(array(""), array(""), array(""), array(""), array(""), array(""), array(""), array(""), array(""))
#autodoc                titre      contenu    membre     groupe     index      rétention  actif      aide       description
#autodoc Configuration des blocs

$blocs = array(array(""), array(""), array("0"), array(""), array(""), array("0"), array(""), array(""), array(""));


#autodoc $txtdeb : Vous pouvez mettre ici un texte de votre choix avec du html qui s'affichera au début de l'install
#autodoc Si rien n'est mis, le texte par défaut sera automatiquement affiché

$txtdeb = "";


#autodoc $txtfin : Vous pouvez mettre ici un texte de votre choix avec du html qui s'affichera à la fin de l'install

$txtfin = "Merci d'utiliser npds_glossaire<br /><br /><a href=\"http://modules.npds.org\" target=\"_blank\">modules.npds.org</a><br />";


#autodoc $link: Lien sur lequel sera redirigé l'utilisateur à la fin de l'install (si laissé vide, redirigé sur index.php)
#autodoc N'oubliez pas les '\' si vous utilisez des guillemets !!!

$end_link = "";
?>