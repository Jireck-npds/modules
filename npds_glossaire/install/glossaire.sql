#
# Structure de la table `glossaire`
#
CREATE TABLE td_glossaire (
  id int(10) NOT NULL auto_increment,
  gcat varchar(30) default NULL,
  lettre varchar(8) NOT NULL default '',
  nom longtext NOT NULL,
  definition longtext NOT NULL,
  affiche int(1) NOT NULL default '0',
  lien varchar(255) NOT NULL default '',
  PRIMARY KEY (id)
) TYPE=MyISAM;

#--------------------------------------------------------
# npds glossaire MySql updater
#--------------------------------------------------------

