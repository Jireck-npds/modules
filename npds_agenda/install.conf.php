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

$name_module = "npds_agenda";

#autodoc $path_adm_module: chemin depuis $ModInstall #required si admin avec interface
$path_adm_module = 'admin/adm';

$req_adm='';//do not fill
$affich='npds_agenda'; // pour l'affichage du nom du module
$icon='npds_agenda'; // c'est un nom de fichier(sans extension) !!

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
$sql = array("CREATE TABLE ".$NPDS_Prefix."agend (

  id int(11) NOT NULL auto_increment,
  date date default NULL,
  liaison int(11) NOT NULL,
  KEY id (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;",
"CREATE TABLE IF NOT EXISTS agendsujet (
  topicid int(3) NOT NULL auto_increment,
  topicimage varchar(20) collate utf8_unicode_ci default NULL,
  topictext mediumtext collate utf8_unicode_ci,
  PRIMARY KEY  (topicid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;",
"CREATE TABLE IF NOT EXISTS agend_dem (
  id int(11) NOT NULL auto_increment,
  titre mediumtext collate utf8_unicode_ci NOT NULL,
  intro longtext collate utf8_unicode_ci NOT NULL,
  descript longtext collate utf8_unicode_ci NOT NULL,
  lieu varchar(100) collate utf8_unicode_ci NOT NULL,
  topicid int(11) NOT NULL,
  posteur varchar(100) collate utf8_unicode_ci NOT NULL,
  groupvoir int(3) NOT NULL,
  valid int(1) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;");

if($path_adm_module!='') $sql[]=$req_adm;

#autodoc $blocs = array(array(""), array(""), array(""), array(""), array(""), array(""), array(""), array(""), array(""))
#autodoc                titre      contenu    membre     groupe     index      rétention  actif      aide       description
#autodoc Configuration des blocs

$blocs = array(array("Agenda"), array("include#modules/npds_agenda/bloc/agbloc.php"), array("0"), array(""), array("1"), array("0"), array("1"), array("Affiche l\'agenda"), array("Affiche l'agenda"));


#autodoc $txtdeb : Vous pouvez mettre ici un texte de votre choix avec du html qui s'affichera au début de l'install
#autodoc Si rien n'est mis, le texte par défaut sera automatiquement affiché

$txtdeb = "<div align=\"center\"><font size=\"4\" color=\"#0000ff\"><b><u>Installation du module Agenda V1.2</u></b></font><br />\n</div><br />\nFaite une sauvegarde de votre site par pr&eacute;caution avant l'installation du module.<br />\n<br />\nLes nouveaut&eacute;s de cette version :<br />\n<ul>\n<li>Fichier de traduction rajout&eacute;.</li><li>D&eacute;filement des mois dans le bloc tout en restant sur la m&ecirc;me page.</li><li>Possibilit&eacute; de changer les couleurs dans l'admin.</li><li>Gestion des groupes pour l'ajout d'un &eacute;v&egrave;nement mais &eacute;galement pour l'affichage d'un &eacute;v&egrave;nement.</li><li>L'agenda peut-&ecirc;tre plac&eacute; dans un bloc avec une popup (fait en css) permettant d'afficher le titre d'un &eacute;v&egrave;nement.</li><li>Correction du mois &quot;suivant et pr&eacute;c&eacute;dent&quot; qui ne tenait pas compte du nombre de jour (restait sur le nombre de jour du mois actuel dans certaines situations) et cr&eacute;eait une erreur de correspondance entre la date et le jour.</li><li>Correction de la couleur qui affiche le jour du mois actuel dans le calendrier (elle apparaissait sur tous les mois).</li><li>Choix d'une validation par un admin pour l'ajout d'un &eacute;v&egrave;nement par un membre ou alors inscription automatique, si le groupe choisie est '0' c'est-&agrave;-dire que m&ecirc;me les anonymes peuvent poster un &eacute;v&egrave;nement alors la validation sera obligatoire pour les anonymes mais pas forc&eacute;ment pour les membres, vous avez le choix.</li><li>Supporte multilangue.</li><li>Css personnalis&eacute;e.</li><li>Fonctionne pour toutes les versions de NPDS.<br /></li>\n</ul>\n<br />\nCe module vous permet d'avoir un agenda sur votre site.<br />\n";


#autodoc $txtfin : Vous pouvez mettre ici un texte de votre choix avec du html qui s'affichera à la fin de l'install

$txtfin = "<div align=\"center\"><font size=\"4\" color=\"#0000ff\"><b><u>Votre installation est maintenant <font color=\"#ff0000\">PRESQUE TERMINEE</font></u></b></font><br /></div><br />Copier le fichier /install/agenda.css dans le dossier style de votre th&egrave;me.<br />Copier le dossier /install/agenda dans le dossier html/modules de votre th&egrave;me.<br /><br />Penser &eacute;galement aux chmods :<br /><ul><li>Chmod 755 ou 777 aux dossiers.</li><li>Chmod 766 &agrave; 2 fichiers :</li><ol><li>cache.timings.php</li><li>admin/config.php</li></ol><li>Chmod 666 aux fichiers se terminant par .html.</li><li>Chmod 744 aux autres fichiers.<br /></li></ul>";


#autodoc $link: Lien sur lequel sera redirigé l'utilisateur à la fin de l'install (si laissé vide, redirigé sur index.php)
#autodoc N'oubliez pas les '\' si vous utilisez des guillemets !!!

$end_link = "";
?>