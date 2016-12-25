<?php
 /***************************************************************************\
  *  phpPetitions, serveur de pétition pour php/Mysql                       *
  *                                                                         *
  *  Copyleft (c) 2003-2005                                                 *
  *  Francois Sauterey, Asdrad Torres, Joel Pothier                         *
  *                                                                         *
  *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
  *  Pour plus de details voir le fichier COPYING.txt                       *
 \***************************************************************************/


/*		admin/inc_maj.php				teste et effectue la mise à jour		*/


function MiseAJour (){
	global $L,$LangueUtilisateur,$LangueSite;
	global $version,$base_version,$variables;
	global $prefixe;

	debut($L['MiseAJour']);

	$f	= creerNomAuthFichier();
	if (! is_file(ROOTDIR . "/tmp/$f"))
		demandeAuthFichier($f);

	# Ici il faut prévoir un verrou!
	if (is_file(ROOTDIR . '/tmp/maj.lock'))
		die("Il semble qu'une mise à jour soit déjà en cours");
	else
		fopen(ROOTDIR . '/tmp/maj.lock',w);
	
	echo "Ici 0";
	exit;

	#Mettre éventuellement config à sa nouvelle place
	if (is_file(ROOTDIR . "/admin/inc_config.php")) {
		echo "la:" . ROOTDIR . "/admin/inc_config.php <br>";
		require_once ROOTDIR . "/admin/inc_config.php";
		echo "serveur: $serveur, base: $base, ladmin: $ladmin, mdp: $mdp<br>";
		ecrireConfig($serveur,$base,$ladmin,$mdp);
		if (is_file(ROOTDIR . "/config/config.php"))
			unlink(ROOTDIR . "/admin/inc_config.php");
	}

	#MISE A JOUR DE LA BD
	# Mettre la table var à jour
	$table	= "${prefixe}var";
	if (!tableExiste($table)) {
		$query  = "CREATE TABLE IF NOT EXISTS $table (
			cle varchar(100) NOT NULL default '',
			valeur varchar(100) NOT NULL default '',
			PRIMARY KEY (cle)
			) TYPE=MyISAM;";
		$aTmp	= array("$table");
		echo FaireListeMaJ($L['Msg_CreationTable'],$aTmp);
		$db     = mysql_query($query) or die("[Erreur_Table]::$query: ".mysql_error());

		// remplir la table
		echo FaireListeMaJ($L['Msg_RemplirTable'],$aTmp);
		$query  = "INSERT $table SET cle='LangueSite',valeur='$LangueSite'";
		$db     = @mysql_query($query) or die("[Erreur_Remplissage]::$query: ".mysql_error());
		$query  = "INSERT $table SET cle='version',valeur='$version'";
		$db     = @mysql_query($query) or die("[Erreur_Remplissage]::$query: ".mysql_error());
		$query  = "INSERT $table SET cle='base_version',valeur='$base_version'";
		$db     = @mysql_query($query) or die("[Erreur_Remplissage]::$query: ".mysql_error());
	} else {
		if (!IndexExiste($table,'PRIMARY')) {
			$aTmp	= array("var","cle");
			echo FaireListeMaj($L['Msg_CreationIndexTable'],$aTmp);
			$query	= " ALTER TABLE $table ADD PRIMARY (cle)";
			$db     = @mysql_query($query) or die("[Erreur_Table]::$query: ".mysql_error());
		}
		// mise à jour
		$aTmp   = array("$table");
		echo FaireListeMaj($L['Msg_MajTable'],$aTmp);
		$query  = "UPDATE $table SET valeur='$version' WHERE cle='version'";
//		$db     = @mysql_query($query) or die("[Erreur_Remplissage]::$query: ".mysql_error());
		$query  = "UPDATE $table SET  valeur='$base_version' WHERE cle='base_version'";
//		$db     = mysql_query($query) or die("[Erreur_Remplissage]::$query: ".mysql_error());
	}

	# Mettre la table petitions à jour
	$table	= "${prefixe}petitions";
	if (!champsExiste($table,'langue')){
		$aTmp	= array('langue',$table);
		echo FaireListeMaj($L['Msg_AjoutChamps'],$aTmp);
		$query	= "ALTER TABLE $table ADD langue CHAR(5) NOT NULL AFTER statut";
		$db     = @mysql_query($query) or die("[Erreur_Table]::$query: ".mysql_error());
		$query  = "UPDATE $table SET langue='$LangueSite'";
		$db     = @mysql_query($query) or die("[Erreur_Remplissage]::$query: ".mysql_error());
	}
	if (!IndexExiste($table,'nom')) {
		$aTmp	= array("nom","$table");
		echo FaireListeMaj($L['Msg_CreationIndexTable'],$aTmp);
		$query	= " ALTER TABLE $table ADD UNIQUE (nom)";
		$db     = @mysql_query($query) or die("[Erreur_Table]::$query: ".mysql_error());
	}

	# mettre à jour la table admin
	$table = "${prefixe}admin";
	// ajout du champs courriel ?
	if (! champsExiste($table,'courriel')) {
		echo FaireListeMaj($L['Msg_AjoutChamps'],array($table,'courriel'));
		ajoutChamps($table,'courriel','VARCHAR',255,1,'password');
	}
	
	// le champs langue
	if (champsExiste($table,'lang')) {
		echo FaireListeMaj($L['Msg_ModifChamps'],array($table,'lang=>langue'));
		ModifChamps($table,'lang','langue','CHAR',5,1);
	}
	if (! champsExiste($table,'langue')) {
		echo FaireListeMaj($L['Msg_AjoutChamps'],array($table,'langue'));
		ajoutChamps($table,'langue','CHAR',5,1,'langue');
	}
	
	// le champs status => statut
	if (champsExiste($table,'status')) {
		echo FaireListeMaj($L['Msg_ModifChamps'],array('status=>statut',$table));
		modifChamps($table,'status','statut','TINYINT',1,1);
	}

	// un index Unique sur le login
	if (!IndexExiste($table,'login')) {
		$aTmp	= array("login","$table");
		echo FaireListeMaj($L['Msg_CreationIndexTable'],$aTmp);
		$query	= " ALTER TABLE $table ADD UNIQUE (login)";
		$db     = @mysql_query($query) or die("[Erreur_Table]::$query: ".mysql_error());
	}

	# mettre à jour la table admin_petitions
	# La table admin_petitions existe-elle ?
	$table	= "${prefixe}admin_petitions";
	if (! tableExiste($table)) {
		$q      = "CREATE TABLE IF NOT EXISTS $table (
			ide_petition int(10) NOT NULL default '0',
			ide_login int(10) NOT NULL default '0',
			UNIQUE KEY ides (ide_petition,ide_login)
			) TYPE=MyISAM";
		$aTmp	= array("$table");
		echo FaireListeMaJ($L['Msg_CreationTable'],$aTmp);
		$db     = @mysql_query($q) or die("MiseAJour::$q:".mysql_error());
	}

	# Création de la tables signatures
	$table	= "${prefixe}signatures";
	if (!TableExiste("$table")) {
		$aTmp	= array("$table");
		echo FaireListeMaJ($L['Msg_CreationTable'],$aTmp);
		$query  = "CREATE TABLE IF NOT EXISTS ${prefixe}signatures (
			ide int(10) unsigned NOT NULL auto_increment,
			ide_petition int(10) NOT NULL,
			niveau tinyint(4) default '0',
			valid tinyint(4) default '0',
			nom varchar(255) NOT NULL default '',
			prenom varchar(255) NOT NULL default '',
			courriel varchar(255) NOT NULL default '',
			infos varchar(255) NOT NULL default '',
			liste tinyint(1) NOT NULL default '0',
			date_soumission datetime NOT NULL,
			date timestamp(14) NOT NULL,
			relance tinyint(1) NOT NULL default '0',
			ip varchar(15) NOT NULL default '',
			cookie varchar(60) NOT NULL default '',
			PRIMARY KEY  (ide)
			) TYPE=MyISAM;";
		$db     = mysql_query($query) or die($L['Erreur_Table']."petitions::$query:".mysql_error());
	}

	# Mise à jour des tables signatures
	$t1	= "${prefixe}petitions";
	$t2	= "${prefixe}signatures";
	echo FaireListeMaj($L['Msg_MajTable'],array($t2));

	$qdb        = mysql_query("SHOW TABLES LIKE '${prefixe}%'");
	while ($t = mysql_fetch_row($qdb)) {
		if (! champsExiste($table=$t[0],'prenom')) continue;
		if ($table==$t2) continue;

		# ajout du champs liste ?
		if (! champsExiste($table,'liste'))
			ajoutChamps($table,'liste','TINYINT',1,1,'infos');
		
		# ajout du champ date_soumission ?
		if (! champsExiste($table,'date_soumission'))
			ajoutChamps($table,'date_soumission','DATETIME','',1,'liste');
		
		# ajout du champ relance ?
		if (! champsExiste($table,'relance'))
			ajoutChamps($table,'relance','TINYINT','1',1,'date');
		
		# ajout du champ ip ?
		if (! champsExiste($table,'ip'))
			ajoutChamps($table,'ip','CHAR','15',1,'relance');
		
		# modification email => courriel
		if (champsExiste($table,'email'))
			modifChamps($table,'email','courriel','VARCHAR',255,1);
		
		# modification level => niveau
		if (champsExiste($table,'level'))
			modifChamps($table,'level','niveau','TINYINT',4,1);
		
		# et on remplit ${prefixe}signatures
		echo "<li> <=table : $table</li>";
		$nom	= preg_replace("/$prefixe/","",$table);
		$query	= "INSERT IGNORE $t2
			(ide_petition,niveau,valid,nom,prenom,courriel,infos,liste,date_soumission,relance,ip,cookie) 
			SELECT p.ide,t.niveau,t.valid,t.nom,t.prenom,t.courriel,t.infos,t.liste,t.date_soumission,t.relance,t.ip,t.cookie
			FROM $table as t, $t1 as p WHERE p.nom='$nom'";
		echo "------------ query : $query<br>";
		$db     = @mysql_query($query) or die("[Erreur_Remplissage]::$query: ".mysql_error());

	}
die("ICI");
	@mysql_free_result();
	unlink (ROOTDIR . "/tmp/$f");
}

# vim: ts=4 ai
?>
