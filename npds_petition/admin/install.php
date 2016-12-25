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

/*	admin/install.php			procédure d'installation		*/

// gestion des messages d'erreurs
error_reporting(E_ALL ^ E_NOTICE);

// avant tout autre chose... Attention il faut remonter d'un cran !
define('ROOTDIR',dirname(dirname (__FILE__)));

$LangueSite		= 'fr_FR'; # ben oui, faut bien commencer...

include_once 'inc_admin.php';
include_once 'inc_langue.php';

include_once 'inc_html.php';
include_once 'inc_version.php';

if ( $a = pbsDroits())
	YaPbsDroits($a);

// DEBUT DU SCRIPT
$etape	= $_POST['etape'];

if (is_file(ROOTDIR . '/config/config.php') && $etape != 3)
	die($L['Err_ReInstallation']);

$sel	= SelectionLangue('','LangueSite',1);
$etape	= $_POST['etape'] * 1 ;

// première étape de l'installation :
// saisie parametres sql
if ($etape == 1) {
	session_save_path(ROOTDIR . '/tmp');
	session_start();

	// on commence par tester la sécurité, i.e. htaccess fonctionne
	foreach (array('config','tmp') as $dir)
		if ( ! VerifierHtaccess($dir))
			$GLOBALS['PasSecure']	= true;

	debut($L['Titre_ParametresSql'],1);
	echo FaireLeTitre2($L['Titre_ParametresSql']);
   	echo FaireLeMessage(SaisieParametresSql());
	echo finbody();
}

// test de la connexion
elseif ($etape == 2) {
	$LangueSite	= $_POST['LangueSite'];
	$serveurSql	= $_POST['serveurSql'];
	$baseSql	= $_POST['baseSql'];
	$loginSql	= $_POST['loginSql'];
	$mdpSql		= $_POST['mdpSql'];
	$prefixe	= $_POST['prefixe'];

	debut($L['T_Connexion']);

   	echo FaireLeMessage($L['Test_Connexion']."...");

	if (! ConnectSql($serveurSql,$baseSql,$loginSql,$mdpSql)){
		die; // normalement c'est ConnectSql qui affiche le message d'erreur et s'arrête. On n'arrive jamais là.
	}

   	echo FaireLeMessage($L['Connexion_Ok']);

	echo FaireLeMessage($L['Etape12']);

	$texte = "    <form action='install.php' method='POST'>
     <input type='hidden' name='etape' value='3'>
     <input type='hidden' name='LangueSite' value='$LangueSite'>
     <input type='hidden' name='serveurSql' value='$serveurSql'>
     <input type='hidden' name='baseSql' value='$baseSql'>
     <input type='hidden' name='loginSql' value='$loginSql'>
     <input type='hidden' name='mdpSql' value='$mdpSql'>
     <input type='hidden' name='prefixe' value='$prefixe'>
     <input type='submit' value='".$L['Bouton_CreationTables']."'>
    </form>\n";

	echo FaireLeMessage($texte);

	echo finbody();
}

// deuxième étape : création et remplissage des tables
elseif ($etape == '3') {
	$LangueSite	= $_POST['LangueSite'];
	$serveurSql	= $_POST['serveurSql'];
	$baseSql	= $_POST['baseSql'];
	$loginSql	= $_POST['loginSql'];
	$mdpSql		= $_POST['mdpSql'];
	$prefixe	= ($p = $_POST['prefixe']) ? "${p}_" : "petitions_";
	$prefixe	= preg_replace("/__/","_",trim($prefixe));
	debut($L['T_Table']);

	ConnectSql($serveurSql,$baseSql,$loginSql,$mdpSql);

	//creation de la table pricipale
	$query	= "CREATE TABLE IF NOT EXISTS ${prefixe}petitions (
		ide int(10) unsigned NOT NULL auto_increment,
		statut tinyint(1) NOT NULL default '0',
		langue char(5) NOT NULL,
		nom varchar(100) NOT NULL default '',
		texte longtext NOT NULL,
		titre varchar(100) NOT NULL default '',
		sous_titre varchar(100) NOT NULL default '',
		robot varchar(255) NOT NULL default '',
		cc_request tinyint(1) NOT NULL default 0,
		date_init date NOT NULL default '0000-00-00',
		UNIQUE KEY nom (nom), 
		PRIMARY KEY  (ide)) ENGINE=MyISAM;";
	$db		= mysql_query($query) or die($L['Erreur_Table']."petitions::$query:".mysql_error());

 	// et de la table traduction
	$query = "CREATE TABLE IF NOT EXISTS ${prefixe}traductions (
		ide int(10) unsigned NOT NULL auto_increment,
		ide_petition int(10) NOT NULL,
		langue char(5) NOT NULL,
		texte longtext NOT NULL,
		titre varchar(100) NOT NULL default '',
		sous_titre varchar(100) NOT NULL default '',
		PRIMARY KEY  (ide),
		UNIQUE  KEY IdeLangue (ide_petition,langue)
		) ENGINE=MyISAM;";
	$db		= mysql_query($query) or die($L['Erreur_Table']."traduction::$query:".mysql_error());

	// et la table des signatures
	$query	= "CREATE TABLE IF NOT EXISTS ${prefixe}signatures (
	    ide int(10) unsigned NOT NULL auto_increment,
		ide_petition int(10) NOT NULL,
		niveau tinyint(4) default '0',
		valid tinyint(4) default '0',
		nom varchar(255) NOT NULL default '',
		prenom varchar(255) NOT NULL default '',
		courriel varchar(255) NOT NULL default '',
		langue char(5) NOT NULL default 'fr_FR',
		infos varchar(255) NOT NULL default '',
		liste tinyint(1) NOT NULL default '0',
		date_soumission datetime NOT NULL,
		date timestamp NOT NULL,
		relance tinyint(1) NOT NULL default '0',
		ip varchar(15) NOT NULL default '',
		cookie varchar(60) NOT NULL default '',
		PRIMARY KEY  (ide)) ENGINE=MyISAM;";
	$db		= mysql_query($query) or die($L['Erreur_Table']."petitions::$query:".mysql_error());

	// la table des administrateurs
	$query	= "CREATE TABLE IF NOT EXISTS ${prefixe}admin (
		ide int(10) unsigned NOT NULL auto_increment,
		login varchar(255) NOT NULL,
		password varchar(100) NOT NULL,
		courriel varchar(255) NOT NULL,
		langue varchar(5) NOT NULL default '$LangueSite',
		statut tinyint(1) NOT NULL default 0,
		UNIQUE  KEY login (login),
		PRIMARY KEY  (ide)) ENGINE=MyISAM;";
	$db		= mysql_query($query) or die($L['Erreur_Table']."${prefixe}admin::$query:".mysql_error());
  
	// et la table relation admin/petitions
	$query	= "CREATE TABLE IF NOT EXISTS ${prefixe}admin_petitions (
		ide_petition int(10) unsigned NOT NULL default '0',
		ide_login int(10) NOT NULL default '0',
		UNIQUE  KEY ides (ide_petition,ide_login)
		) ENGINE=MyISAM";
	$db		= mysql_query($query) or die("[Erreur_Table]::$query: ".mysql_error());

	// table var
	$query	= "CREATE TABLE IF NOT EXISTS ${prefixe}var (
      cle varchar(100) NOT NULL default '',
      valeur varchar(100) NOT NULL default '',
	  PRIMARY KEY (cle)
      ) ENGINE=MyISAM;";
	$db		= mysql_query($query) or die("[Erreur_Table]::$query: ".mysql_error());

	// on remplit les tables...
	$query	= "INSERT ${prefixe}var SET cle='version',valeur='$version'";
	$db		= mysql_query($query) or die("[Erreur_Remplissage]::$query: ".mysql_error());

	$query	= "INSERT ${prefixe}var SET cle='base_version',valeur='$base_version'";
	$db		= mysql_query($query) or die("[Erreur_Remplissage]::$query: ".mysql_error());

	$query	= "INSERT ${prefixe}var SET cle='LangueSite',valeur='$LangueSite'";
	$db		= mysql_query($query) or die("[Erreur_Remplissage]::$query: ".mysql_error());


	// creation de la petition demo1
	// l'enregistrement de demo1
	$query	= "INSERT IGNORE INTO ${prefixe}petitions 
	    (ide,statut,langue,nom,texte,titre,sous_titre,robot,date_init) VALUES
		('','0','fr_FR','demo1','Petit essai de création de pétition','Test','petition de test','nobody@nowhere.org',CURDATE( ))";
	$db		= mysql_query($query) or die($L['Erreur_Remplissage']."test::$query:".mysql_error());
	// et sa version anglaise
	$query	= "INSERT IGNORE INTO ${prefixe}traductions (ide_petition,langue,texte,titre,sous_titre)
		VALUES ('1','en_EN','Timid try at creating a petition in English','Test En','Test English petition');";
	$db		= mysql_query($query) or die($L['Erreur_Remplissage']."test::$query:".mysql_error());
	
	// l'enregistrement de demo2
	$query	= "INSERT IGNORE INTO ${prefixe}petitions 
	    (ide,statut,langue,nom,texte,titre,sous_titre,robot,date_init) VALUES
		('','0','fr_FR','demo2','Petit essai de création de pétition','Test','petition de test','nobody@nowhere.org',CURDATE( ))";
	$db		= mysql_query($query) or die($L['Erreur_Remplissage']."test::$query:".mysql_error());
	// et sa version anglaise
	$query	= "INSERT IGNORE INTO ${prefixe}traductions (ide_petition,langue,texte,titre,sous_titre)
		VALUES ('2','en_EN','Timid try at creating a petition in English','Test En','Test English petition');";
	$db		= mysql_query($query) or die($L['Erreur_Remplissage']."test::$query:".mysql_error());
	
	// et la table de champs additionnels
	$query	= "CREATE TABLE IF NOT EXISTS ${prefixe}ChampsAdd_demo2 (
	    ide_signature int(10) unsigned NOT NULL,
		pays_prefere varchar(255) NOT NULL default '',
		langue_preferee varchar(255) NOT NULL default '',
		volontaire_trad tinyint(1) NOT NULL default '0',
		UNIQUE KEY ide_signature (ide_signature)) ENGINE=MyISAM;";
	$db		= mysql_query($query) or die($L['Erreur_Table']."${prefixe}ChampsAdd_demo2::$query:".mysql_error());
 
	$sel	= SelectionLangue();

	$sTmp	 = "<p>".$L['Creation_Ok']."</p>\n";
   	$sTmp	.= "<hr width='50%' align='center'>\n";
	$sTmp	.=   "<br />".$L['Admin1']." <p>&nbsp;</p>\n";
	$sTmp	.=   "<form action='install.php' method='POST'>\n";
	$sTmp	.=    "<input type='hidden' name='etape' value='4'>\n";
	$sTmp	.=    "<input type='hidden' name='LangueSite' value='$LangueSite'>\n";
	$sTmp	.=    "<input type='hidden' name='serveurSql' value='$serveurSql'>\n";
	$sTmp	.=    "<input type='hidden' name='baseSql' value='$baseSql'>\n";
	$sTmp	.=    "<input type='hidden' name='loginSql' value='$loginSql'>\n";
	$sTmp	.=    "<input type='hidden' name='mdpSql' value='$mdpSql'>\n";
	$sTmp	.=    "<input type='hidden' name='prefixe' value='$prefixe'>\n";
	$sTmp	.=    "<table>\n";
	$sTmp	.=     "<tr>\n";
	$sTmp	.=      "<td>".$L['Login']."</td>\n";
	$sTmp	.=      "<td><input type='text' name='login' value=''></td>\n";
	$sTmp	.=     "</tr><tr>\n";
	$sTmp	.=      "<td>".$L['Courriel']."</td>\n";
	$sTmp	.=      "<td><input type='text' name='courriel' value=''></td>\n";
	$sTmp	.=     "</tr><tr>\n";
	$sTmp	.=      "<td>".$L['Langage']."</td>\n";
	$sTmp	.=	  "<td> $sel\n";
	$sTmp	.=      "</td>\n";
	$sTmp	.=     "</tr><tr>\n";
	$sTmp	.=     "</tr><tr>\n";
	$sTmp	.=      "<td>".$L['Password']."</td>\n";
	$sTmp	.=      "<td><input type='text' name='password' value=''></td>\n";
	$sTmp	.=     "</tr><tr>\n";
	$sTmp	.=      "<td colspan='2 align='center'><p>&nbsp;</p>\n";
	$sTmp	.=       "<input type='submit' value='".$L['Bouton_Admin2']."'></td>\n";
	$sTmp	.=     "</tr>\n";
	$sTmp	.=    "</table>\n";
	$sTmp	.=   "</form>\n";
	$sTmp	.=   "</body>\n";
	$sTmp	.=   "</html>\n";
	echo $sTmp;
}
elseif ($etape == 4) {
	$serveurSql			= $_POST['serveurSql'];
	$baseSql			= $_POST['baseSql'];
	$loginSql			= $_POST['loginSql'];
	$mdpSql				= $_POST['mdpSql'];
	$LangueSite			= $_POST['LangueSite'];
	$LangueUtilisateur	= $_POST['LangueUtilisateur'];
	$prefixe			= $_POST['prefixe'];
	$login				= $_POST['login'];
	$courriel			= $_POST['courriel'];
	$password			= $_POST['password'];

	// ecriture du fichier config.php
	ecrireConfig($serveurSql,$baseSql,$loginSql,$mdpSql);

	include ROOTDIR . '/config/config.php';

  // preparation d'une clé MD5
	$jumble		= md5(time() . getmypid());
	$salt		= "$1$".substr($jumble,0,8);
	$password	= crypt($password,$salt);
	$query		= "INSERT ${prefixe}admin SET 
    	login='$login',
    	courriel='$courriel',
    	langue='$LangueUtilisateur',
    	password='$password',
    	statut='1'";
	@mysql_query($query) or mort($L['Erreur_Remplissage']."admin ".mysql_error(),-1);
	header("Location: index.php");
}
 // premiere entrée
 // l'instalation commence
else {

	debut($L['Titre_Installation'],1);

	$texte = FaireLeTitre2($L['ChoixLangue']);
	$texte .= "  <form action='install.php' method='POST'>\n";
	$texte .= "  " . $sel;
	$texte .= "   <div>\n    <input type='hidden' name='etape' value='0'>\n";
	$texte .= "   <input type=submit name=suite value='" . $L['Bouton_Suite'] . "' onClick='this.form.etape.value=1'>\n";
	$texte .= "   </div>\n";
	$texte .= "  </form>\n";

   	echo FaireLeMessage($texte);

}


function SaisieParametresSql() {
	 global $L;

	$texte	.= "  <form action='install.php' method='POST'>\n";
	$texte	.= "   <div>\n    <input type='hidden' name='etape' value='2'>\n";
	$texte	.= "   <input type='hidden' name='LangueSite' value='" . $_POST['LangueSite'] . "'>\n";
	$texte	.= "   <table>\n    <tr>\n     <td>".$L['Label_ServeurSql']."</td>\n";
	$texte	.= "     <td><input type='text' name='serveurSql' value='localhost'></td>\n    </tr><tr>\n";
	$texte	.= "     <td>".$L['Label_BaseSql']."</td>\n     <td><input type='text' name='baseSql' value=''></td>\n    </tr><tr>\n";
	$texte	.= "     <td>".$L['Label_LoginSql']."</td>\n     <td><input type='text' name='loginSql' value=''></td>\n    </tr><tr>\n";
	$texte	.= "     <td>".$L['Label_PasswordSql']."</td>\n     <td><input type='text' name='mdpSql' value=''></td>\n    </tr><tr>\n";
	$texte	.= "     <td>".$L['Prefixe']."</td>\n     <td><input type='text' name='prefixe' value=''></td>\n    </tr>\n   </table>";
	$texte	.= "   <input type='submit' value='" . $L['Bouton_Suite'] . "'>\n";
	$texte	.= "   </div>\n";
	$texte	.= "  </form>\n";

	// si htaccess ne marche pas... i.e. on peut lire le .ok
	if ( $GLOBALS['PasSecure'])
		$texte	.= "<div id='pasSecure'>" . $L['Msg_PasHtaccess'] . "</div>";

	return ($texte);
}

function ConnectSql($s,$b,$l,$p,$f=1){
	mysql_connect("$s","$l","$p") or die($L['Erreur_Connexion'].mysql_error());
	$db = mysql_select_db($b) or die($L['Erreur_Base'].mysql_error());
	if ($f)
		mysql_query("SET character_set_results = 'utf8', 
					character_set_client = 'utf8', 
					character_set_connection = 'utf8', 
					character_set_database = 'utf8', 
					character_set_server = 'utf8'") or
			die(mysql_error());
	return true;
}

# vim: ts=4 ai
?>
