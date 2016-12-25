<?php
	/***************************************************************************\
		*  phpPetitions, serveur de pétition pour php/Mysql                       *
		*                                                                         *
		*  Copyleft (c) 2003-2005                                                *
		*  Francois Sauterey, Asdrad Torres, Joel Pothier                         *
		*                                                                         *
		*  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
		*  Pour plus de details voir le fichier COPYING.txt                       *
	\***************************************************************************/

/* admin/inc_sql.php			regroupe les requetes sql				*/

#function LireInfosPetition($petition) 					charge les infos d'une petitions en global
#function ListePetitions($flag)							renvoie la liste des petitions
#function chercheSignature($petition,$nom,$prenom,$p3) 	cherche une signature (nom+prenom+courriel)
#function ValideSignature($petition,$cle)				Validation si signature valide
#function Pet_sauveSignature($petition,$nom,$prenom,$info,$courriel) enregistre une proposition de signature
#function NombreTotalSignatures($petition,$n)			Renvoi le nombre de signatures (papier compris)
#function NombreSignatures($petition,$n)				Renvoi le nombre de signatures
#function ListeSignataires($petition,$n)				liste des signataires validés du niveau $n
#function ListeRetardataires($petition,$d)	 			Liste des signatures non validées
#function LireVariables();								Lire le tableau des variables (s'il existe)

#function is_super($l)									le login est-il super admin
#function lireIdeAdmin($l)								retourne l'ide du login
#function ListeAdministrateurs()						tableau des administrateurs et leur statut
#function LireAdminInfos($ide)							tableau des administrateurs et leur statut
#function nouvelAdmin()									création d'un nouvel administrateur
#function sauveAdministrateur($ide)						enregistre les modifications d'un administrateur
#function gereKelPetitions($ide)						retourne les ide_petitions gérées par $ide
#function adm_ListePetitions()							version admin de la liste des pétitions
#function adm_ListeSignatures($p)						Liste des signatures de la pétition $p
#function existePetition($n)							vérification de l'existence d'une petition
#function nouvellePetition($n)							création d'une nouvelle pétition
#function nouvelleTableSignatures($n) 					création de la table des signatures
#function enregistrePetition($petition)					enregistre les parametres
#function detruire($petition)							suppression d'une pétitions (radicale)
#function insertSignature($petition,$n,$p,$i,$e,$l)		insertion d'une signatures 'en force'
#function enleveSignature($p,$n,$pn,$i,$e)				Suppression d'une signature
#function adm_Pet_propre($s) 							nettoyage des chaines
#function Pet_faireSauvegarde($dir)							faire une sauvegarde
#function Pet_faireRestauration()							restaure une sauvegarde
#function ajouterPapier($p,$n)

// Ce fichier ne sera execute qu'une fois
if (defined("_ADMIN_INC_SQL")) return;
define("_ADMIN_INC_SQL", "1");

// les données de la pétition 
//   entrée: n° de petition
//   renvoi un tableau des infos.
function LireInfosPetition($p) {
	global $prefixe,$langSite;

	$aRet	= array();

	// chargement des données langue par defaut
	$query	= "SELECT * FROM ${prefixe}petitions WHERE ide='$p'";
	$qdb	= mysql_query($query) or tuer("LireInfosPetition::".mysql_error());
	$r		= mysql_fetch_assoc($qdb);
			foreach ($r as $c => $v) {
		if ($c=='langue') $laLangue=$v;
		if ( $c == 'ide' ) continue;
		elseif ($c == 'statut' || $c == 'nom' ||
				$c == 'robot' || $c == 'date_init' ||
				$c == 'cc_request' || $c == 'langue')
			$aRet[$c]				= $v;
		else
			$aRet[$c][$laLangue]	= $v;
	}

	// chargement des traductions eventuelles
	$query	= "SELECT * FROM ${prefixe}traductions WHERE ide_petition= $p";
	$qdb	= mysql_query($query) or tuer("LireInfosPetition::".mysql_error());
	while ($r      = mysql_fetch_assoc($qdb)) 
		foreach ( array('titre','sous_titre','texte') as $c)
			$aRet[$c][$r['langue']]    = $r[$c];
	
	return ($aRet);
}

// la listes des  pétitions.
// $flag permet de n'avoir que les pétition en cours, que les pétitions archivées, ou toutes
// 		$flag = 0 : petition invisible
// 		$flag = 1 : petition en cours
// 		$flag = 2 : petition archivée (visible mais non signable)
function ListePetitions($flag,$lg){
	global $prefixe;

	$aTmp	= array();
	$query	= "SELECT ide,titre,langue FROM ${prefixe}petitions WHERE statut='$flag'";
	$qdb	= mysql_query($query) or tuer ("[LireListePetitions] ".mysql_error());
	// pour chaque pétition 
	while ($row=mysql_fetch_array($qdb)){
		// lire le titre dans la langue de la pétition
		$aTmp[$row['ide']][$row['langue']] = $row['titre'];
		$aTmp[$row['ide']]['defaut'] = $row['titre'];
		$query	= "SELECT *  FROM ${prefixe}traductions WHERE ide_petition='" . $row['ide'] . "'";
		$qdb2	= mysql_query($query) or tuer ("[LireListePetitions] ".mysql_error());
		while ($r= mysql_fetch_array($qdb2))
			// et ses traductions
			$aTmp[$row['ide']][$r['langue']] = $r['titre'];
	}
	$ul	 = '<ul>';
	foreach ($aTmp as $i=>$p) {
		$sTmp	= (!empty($p[$lg])) ? $p[$lg] : $p['defaut'];
		// afficher le titre dans la langue de l'utilisateur ou à défaut dans celle de la pétition
		$ul .= "<li class='listepetitions'><a href='?petition=$i'>$sTmp</a></li>\n";
	}
	$ul .="</ul>";
	return $ul;
}

function chercheSignature($p,$nom,$prenom,$p3) {
	global $prefixe;

	$query	 = "SELECT ide FROM ${prefixe}signatures";
	$query	.= " WHERE ide_petition=$p AND nom='$nom' AND prenom='$prenom' AND courriel='$p3'";
	$d=mysql_query($query) or tuer ('Bleme(1) : ' . mysql_error());
	$r		 = mysql_fetch_assoc($d);
	if ($r) return($r['ide']);
	$query	 ="SELECT ide FROM ${prefixe}signatures";
	$query	.=" WHERE ide_petition=$p AND nom='$nom' AND prenom='$prenom' AND infos='$p3'";
	$d		 =mysql_query($query) or tuer ('Bleme(2) : ' . mysql_error());
	$r		 =mysql_fetch_assoc($d);
	return($r['ide']);
}

// valid une signature avec l'aide la clé
// ne surtout pas effacer la clé (sinon, "j'arrive pas à valider" alors que c'est déjà fait!!!
// met à jour le timestamp
// retourne faux si pas de clé correspondante
function ValideSignature($p,$cle){
	global $prefixe;

	$query="SELECT * FROM ${prefixe}signatures WHERE ide_petition=$p AND cookie='$cle'";
	$qdb=mysql_query($query) or tuer("pb: ". mysql_error());
	if ($sign=mysql_fetch_array($qdb)) {
		$query="UPDATE ${prefixe}signatures SET valid='1' WHERE ide_petition=$p AND cookie='$cle'";
		mysql_query($query) or tuer ("SignatureValide : ".mysql_error());
	}
	return($sign);
}

// Enregistre les données de la signature, et renvoi une clé MD5 de validation
// la fonction récupère ses datas directement dans l'environnement.
function Pet_sauveSignature(){

	$prefixe	= $GLOBALS['prefixe'];
	$langue		= $GLOBALS['LangueUtilisateur'];		// la langueUtilisateur sera utilisée pour envoyer le mèl.

	$cle=substr(getMD5(),0,8);							// 8 caractères, ça suffit, et ça évite un lien trop long

	//nettoyage des variables !
	$petition	= trim(Pet_propre($_POST['petition']));
	$nom		= trim(Pet_propre($_POST['nom']));
	$prenom		= trim(Pet_propre($_POST['prenom']));
	$info		= trim(Pet_propre($_POST['info']));
	$courriel	= trim(Pet_propre($_POST['courriel']));
	$liste		= isset($_POST['liste']);
	$ip			= $_SERVER["REMOTE_ADDR"];				// loggé l'ip: question de sécurité
	$date		= date("Y-m-d H:i:s");					// la date complète de la soumission de cette signature

	$query="INSERT ${prefixe}signatures SET
		ide_petition=$petition,
		nom='$nom',
		prenom='$prenom',
		infos='$info',
		langue='$langue',
		courriel='$courriel',
		liste='$liste',
		date_soumission='$date',
		ip='$ip',
		cookie='$cle'";
	mysql_query($query) or tuer("sauveSignature::$query:" . mysql_error());

	$ide	= mysql_insert_id();
	$nom	= $GLOBALS['infosPetition']['nom'];
	if (tableExiste($table="${prefixe}ChampsAdd_$nom")) {
		$query	= "INSERT $table SET ide_signature=$ide";
		foreach (ListeChamps($table) as $l){
			if ( ($c=$l['Field'])=='ide_signature') continue;
			if ( preg_match('/varchar/',$l['Type']))
				$query  .= "," . $l['Field'] . "='" . $_POST[$l['Field']] . "'";
			if ( preg_match('/tinyint/',$l['Type']))
				$query  .= "," . $l['Field'] . "='" . isset($_POST[$l['Field']]) . "'";
		}
		mysql_query($query) or tuer("sauveSignature::$query:" . mysql_error());
	}
	return($cle);
}

function NombreTotalSignatures($p,$n=0) {
	global $variables,$infosPetition;

	return "".NombreSignatures($p) + NombreSignatures($p,'1') + $variables['papier_' . $infosPetition['nom']]."";
}

// Renvoi le nombre le signatures du niveau $n de la pétition n° $p
function NombreSignatures($p,$n=0){
	global $prefixe;

	$niv	= ($n<0) ? 'AND niveau < 7' : "AND niveau='$n'";
	$query="SELECT count(*) FROM ${prefixe}signatures WHERE ide_petition=$p AND valid='1' $niv";
	$qdb	= mysql_query($query) or tuer ("NombreSignatures::$query:".mysql_error());
	$r		= mysql_fetch_array($qdb);
	return($r[0]);
}

// liste des signataires de niveau $n de la petition $p
function ListeSignataires($p,$n){
	global $alpha,$derniers;
	$prefixe	= $GLOBALS['prefixe'];
	$nom        = $GLOBALS['infosPetition']['nom'];

	$niv	= ($n<0) ? 'AND niveau <7' : "AND niveau='$n'";
	$clniv	= ($n<0) ? 0 : $n ;

	if (tableExiste("${prefixe}ChampsAdd_$nom")){
		$tableplus	= ",${prefixe}ChampsAdd_$nom as a";
		$champsplus	= ",a.*";
	}

	//ordre="ORDER BY date DESC"; // faire les modifs en-dessous...
	if (isset($_GET['alpha'])) $alpha=$_GET['alpha'];
	$alpha1		= "ORDER BY upper(nom),upper(prenom)";
	$alpha		= ($alpha=='oui') ? "ORDER BY upper(nom),upper(prenom)" : $alpha;
	$alpha		= "ORDER BY upper(nom),upper(prenom)";
	$lettre		= $_GET['lettre'];
	$url		= $_SERVER["SCRIPT_URL"];

	$nombre=NombreSignatures($p,$n);

	if ($nombre < $derniers) {
		$q		= "SELECT s.*$champsplus FROM ${prefixe}signatures as s$tableplus WHERE s.ide_petition=$p AND s.valid='1' $niv $alpha";
		$sRet	= '<ul>';
	} else {
		$sRet   = Pet_ChoixAlpha($p,$lettre);
		$z		= chr(64+$lettre);

		if ($lettre && $lettre < 50) {
			$sRet	.= "<hr width='50%'><p>\n<br /><br />Signatures enregistrées commencant par $z<br /></p>\n<p class='signatures' align='justify'><ul>";
			$q		= "SELECT s.*$champsplus FROM ${prefixe}signatures as s$tableplus WHERE s.ide_petition=$p $niv AND s.valid='1' AND upper(nom) LIKE '$z%' $alpha1";
		} elseif ($lettre > 50 ) {
		 $sRet	.= "<hr width='50%'><p>\n<br /><br />Toutes les signatures enregistrées...<br /></p>\n<p class='signatures' align='justify'><ul>";
		 $q		= "SELECT s.*$champsplus FROM ${prefixe}signatures as s$tableplus WHERE s.ide_petition=$p $niv AND s.valid='1' $alpha1";
		} else {
		 $sRet	.= "<hr width='50%'><p><br /><br />$derniers dernières signatures enregistrées<br /></p>\n<p class='signatures' align='justify'><ul><li class='niveau$clniv'>...";
		 $debut	= $nombre-$derniers;
		 $q		= "SELECT s.*$champsplus FROM ${prefixe}signatures as s$tableplus WHERE s.ide_petition=$p $niv AND s.valid='1' LIMIT $debut,999999999";
		}
	}

	$d	= mysql_query($q) or tuer("ListeSignataires::query:$q:".mysql_error());
	while ($row=mysql_fetch_array($d)) {
		$t		 = ($sRet2) ? ",</li>\n <li class='niveau$clniv'>" : "\n<li class='niveau$clniv'>";
		$prenom	 = ucfirst(strtolower(stripslashes($row['prenom'])));
		$nom	 = Pet_majuscules(stripslashes($row['nom']));
		//$pays_prefere	= ucfirst(strtolower(stripslashes($row['pays_prefere'])));
		$infos	 = ucfirst(strtolower(stripslashes($row['infos'])));
		$sRet2	.= "${t}$prenom $nom";
		//$sRet2	.= "${t}${init1}$prenom $nom${init2}";
		//$sRet2	.= " [ ".$pays_prefere." ]";
		$sRet2	.= (trim($infos)!='') ? " ($infos)":'';
	}
	return($sRet.$sRet2."</li></ul>\n");
}

// nombre de signatures non validées de la pétition $p
function NombreRetardataires($p,$d=0) {
	global $prefixe;

	//echo "petition: $p<br>";
	//echo "petition: ".$infosPetition['nom']."<br>";

	$aRet=array();

	$d=($d) ? $d : 0;
	$q="SELECT count(*)
		FROM ${prefixe}signatures
		WHERE ide_petition=$p AND valid=0 AND relance=0
		AND CURDATE() - DATE_FORMAT(date,\"%Y%m%d\") >= ".$d;
	$b=mysql_query($q);
	$r=mysql_fetch_array($b) or tuer('[NombreRetardataires] : '.mysql_error()." ($q)");
//	echo "Nombre de relance à faire : ".$r[0]."<br />";
	return $r[0];
}

// Retourne une array contenant la liste des retardataires
function ListeRetardataires($p,$d=0) {
	global $prefixe;

	$aRet=array();
	nombreRetardataires($d);
	$q="SELECT *
		FROM ${prefixe}signatures
		WHERE ide_petition=$p AND valid=0 AND relance=0
		AND CURDATE() - DATE_FORMAT(date,\"%Y%m%d\") >= ".$d;
	$b=mysql_query($q) or tuer('[NombreRetardataires] : '.mysql_error()." ($q)");
	while ($r=mysql_fetch_assoc($b)) {
		array_push($aRet,$r);
	}
	return $aRet;
}

////////// ADMIN ////////
// construction de la table des petition
function adm_ListePetitions(){
	global $prefixe,$login,$L;

	$aRet = array();

	if (is_super($login))
		$q = "SELECT * FROM ${prefixe}petitions order by ide";
	else {
		$ide = lireIdeAdmin($login);
		$q ="SELECT * FROM ${prefixe}petitions as p,${prefixe}admin_petitions as ap
			 where p.ide=ap.ide_petition and ap.ide_login='$ide' order by p.ide";
	}
	$q=mysql_query($q) or tuer("inc_sql.php::adm_ListePetitions:".mysql_error()." [$q]");
	while ($r=mysql_fetch_array($q))
		$aRet[$r['ide']] = array (
			'statut'	=> $r['statut'],
			'nom'		=> $r['nom']
		);
	return $aRet;
}

function nouvelleTableSignatures($n) {
	global $prefixe;

	$q= "CREATE TABLE IF NOT EXISTS ${prefixe}$n (
		    ide int(11) NOT NULL auto_increment,
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
		    PRIMARY KEY  (ide)) TYPE=MyISAM;";
	mysql_query($q) or mort("nouvelleTableSignatures : ".mysql_error(),10);
}

function nouvellePetition($n){
	global $prefixe;

	$aujourdhui= date('Y-m-d');
	$query="INSERT INTO ${prefixe}petitions SET date_init='$aujourdhui', nom='$n'";
	$r1=mysql_query($query) or mort("nouvellePetition : ".mysql_error(),10);
	$ide=mysql_insert_id();
	nouvelleTableSignatures($n);
	return($ide);
}

function existePetition($n){
	global $prefixe;

	$q="SELECT * FROM ${prefixe}petitions WHERE nom='$n'";
	$q=mysql_query($q) or mort("[existPetition] ".mysql_error(),10);
	$q=mysql_fetch_array($q);
	return ($q);
}

// sauvegarde des parametre d'une petition
function enregistrePetition($petition){
	global $prefixe,$infosPetition;

	$nom				= adm_Pet_propre($_POST["leNom"]);
	$titre				= adm_Pet_propre($_POST["titre"]);
	$sous_titre			= adm_Pet_propre($_POST["sous_titre"]);
	$texte				= adm_Pet_propre($_POST["texte"]);
	$LanguePetition		= $_POST['LanguePetition'];
	$LangueTraduction	= $_POST['LangueTraduction'];
	$statut				= $_POST["statut"];
	$date_init			= $_POST['date_init'];
	$robot				= $_POST['robot'];
	$cc_request			= $_POST['cc_request'];

	$q1			="titre='$titre',
		sous_titre='$sous_titre',
		texte='$texte'";

	if (! $petition) {
		//$cas = 1;
		$query		= "INSERT ${prefixe}petitions  SET
		statut='$statut',
		langue='$LanguePetition',
		nom='$nom',
		$q1,
		robot='$robot',
		date_init='$date_init',
		cc_request='$cc_request'";
	} elseif ( ($LangueTraduction == $LanguePetition) || empty($LangueTraduction)) {
		//$cas = 2;
		$query		= "UPDATE ${prefixe}petitions  SET
		statut='$statut',
		$q1,
		robot='$robot',
		date_init='$date_init',
		cc_request='$cc_request'
		WHERE ide='$petition'";
	} elseif (traductionExiste($petition,$LangueTraduction)){
		//$cas = 3;
		$query		= "UPDATE ${prefixe}traductions  SET
		$q1
		WHERE ide_petition='$petition' AND langue='$LangueTraduction'";
	} else {
		//$cas = 4;
		$query		= "INSERT ${prefixe}traductions  SET
		$q1,
		ide_petition=$petition,
		langue='$LangueTraduction'";
	}

	//echo "cas $cas<br>$query";
	//return;
	mysql_query($query) or tuer ("enregistrePetition::$query:".mysql_error());
}

// supprime totalement une petition
// ne supprime pas les modeles
function detruire($petition){
	global $prefixe,$infosPetition;

	$query="DROP TABLE IF EXISTS ${prefixe}".$infosPetition['nom'];
	mysql_query($query) or mort("detruire (1) : ".mysql_error(),10);
	$query="DELETE FROM ${prefixe}petitions WHERE ide='$petition'";
	mysql_query($query) or mort("detruire (2) : ".mysql_error(),10);
}

//insertion une nouvelle signature
/*
 * id_petition		l'ide de la petition
 * $nom				le nom du signataire
 * $prenom			le prenom
 * $mel				le mel du signataire
 * $infos			infos sur le signataire
 * $niveau			le niveau de signature
*/
// retourne faux si la signature existe déja
function insertSignature($ide_petition,$nom,$prenom,$infos,$mel,$niveau){
	global $prefixe,$infosPetition;

	if (chercheSignature($ide_petition,$n,$p,$e)) return false;
	$date	= date('Y-m-d H:i:00');
	$liste	= ($mel) ? 1 : 0;
	$q		= "INSERT INTO ${prefixe}signatures 
		(`ide_petition`,`niveau`,`valid`,`nom`,`prenom`,`courriel`,`infos`,`liste`,`date_soumission`)
	VALUES 
		($ide_petition,$niveau,1,'$nom','$prenom','$mel','$infos',$liste,'$date')";
	mysql_query($q) or tuer("insertSignature:$q::".mysql_error());
	return true;
}

//suppression d'une signature
function enleveSignature($p,$n,$pn,$i,$e){
	global $prefixe,$infosPetition;

	if (($ide=chercheSignature($p,$n,$pn,$i)) || ($ide=chercheSignature($p,$n,$pn,$e))) {
		$q="DELETE FROM ${prefixe}".$infosPetition['nom']." WHERE ide='$ide'";
		//echo "q: $q<br>";
		mysql_query($q) or mort("enleveSignature : ".mysql_error(),10);
		return true;
	}
	return false;
}

// Lire le tableau des variables
function LireVariables(){
	global $prefixe,$variables;

	$q = "select * from ${prefixe}var";
	$b = mysql_query($q) or tuer("LireVariables::".mysql_error());
	while ($r = mysql_fetch_array($b)) {
		$variables[$r['cle']] = $r['valeur'];
	}
}

// est-ce un super-admin
function is_super($l){
	global $prefixe;

	$q="SELECT * FROM ${prefixe}admin WHERE login='$l'";
	$r=mysql_query($q) or dir("is_super::".mysql_error());
	$a=mysql_fetch_array($r);
	return ($a['statut'] == 1);
}

function ListeAdministrateurs() {
	global $prefixe;

	$aRet=array();
	$q = "select * from ${prefixe}admin";
	$h = mysql_query($q) or tuer("ListeAdministrateurs::pb ".mysql_error());
	while ($r = mysql_fetch_array($h)) {
		$aRet[$r['ide']]=array(
			'login'		=> $r['login'],
			'courriel'	=> $r['courriel'],
			'statut'	=> $r['statut']
		);
	}
	return $aRet;
}

function LireAdminInfos($ide=0) {
	global $prefixe;

	$q = "select * from ${prefixe}admin where ide='$ide'";
	$h = mysql_query($q) or tuer("LireAdminInfos::pb ".mysql_error());
	return mysql_fetch_array($h);
}

function LireIdeAdmin($l=0) {
	global $prefixe;

	$q = "select ide from ${prefixe}admin where login='$l'";
	$h = mysql_query($q) or tuer("LireAdminInfos::pb ".mysql_error());
	$r=mysql_fetch_array($h);
	return $r['ide'];
}

function sauveAdministrateur($ide=0) {
	global $prefixe;

	if ($ide)
		{ $cmd	= "update"; $where	= "where ide='$ide'"; }
	else
		{ $cmd	= "insert"; $where	= '';}

	if ( ($l = ($_POST["login"])) == '') {
		echo "Pas de login ?";
		exit;
	} else
		$query	= "login='$l'";

	$query	.= ",courriel='" . $_POST['courriel'] . "'";
	$t	.= ($type=$_POST['typeadmin']) ? $type : 0 ;
	$query	.= ",statut=$t";
	$query	.= ",langue='" . $_POST['nouvellelang'] . "'";
	if (isset($_REQUEST['password']) && $_REQUEST['password']) {
		$jumble	 = md5(time() . getmypid());
		$salt	 = "$1$".substr($jumble,0,8);
		$p	 = crypt($_POST['password'],$salt);
		$query	.= ",password='$p'";
	}

	$q = "$cmd ${prefixe}admin set $query $where";
	$h = mysql_query($q) or tuer("sauveAdministrateur::pb:$q:".mysql_error());

	// on lie l'admin avec les petition
	if ( ! $_REQUEST['typeadmin']) {
		// vidange
		$q = "delete from ${prefixe}admin_petitions where ide_login='$ide'";
		$h = mysql_query($q) or tuer ("sauveAdministrateur::".mysql_error());
		// et on insere
		foreach ($_REQUEST['pets'] as $pet) {
			$q = "insert into ${prefixe}admin_petitions (ide_petition,ide_login) values ('$pet','$ide')";
			$h = mysql_query($q) or tuer ("sauveAdministrateur::".mysql_error());
		}
	}
}

// renvoie le tableau des ide_petitions gérées par $ide
function gereKelPetitions($ide) {
	global $prefixe;

	$aRet = array();
	$q = "select ide_petition from ${prefixe}admin_petitions where ide_login='$ide'";
	$h = mysql_query($q);
	while ($r = mysql_fetch_array($h))
		$aRet[$r['ide_petition']]='selected';
	return $aRet;
}

// cette fonction nettoie les chaines... trop ?
// a revoir
function adm_Pet_propre($s) {
	return(addslashes($s));
	//return ($s);
	return htmlentities($s,ENT_QUOTES,"UTF-8");
}

function adm_ListeSignatures($p) {
	global $prefixe;

	$infosPetition=LireInfosPetition($p);
	$q="SELECT * FROM ${prefixe}signatures WHERE ide_petition='$p' ORDER BY nom";
	$d=mysql_query($q) or tuer("adm_ListeSignature::".mysql_error());
	$sRet="<table>\n";
	$sRet .= "<tr><td>Nom</td><td>Prenom</td><td>courriel</td><td>infos</td></tr>";
	while ($row=mysql_fetch_array($d)) {
		$type = ($row['valid']) ? 'valide' : 'attente';
		$sRet .= "<tr class='$type'><td>".$row['nom']."</td><td>".$row['prenom']."</td>";
		$sRet .= "<td>".$row['courriel']."</td><td>".$row['infos']."</td></tr>";
	}
	return $sRet."</table>";
}

function ExporterSignatures($p){
	global $prefixe;

	$dir=dirname(__FILE__);
	$fichier="$dir/signature.csv";
	$q="SELECT * FROM ${prefixe}signatures WHERE ide_petition='$p'";
	$d=mysql_query($q) or tuer("adm_ListeSignature::".mysql_error());
	while ($row=mysql_fetch_assoc($d)) {
		$texte .= implode('|',$row)."\n";
	}
	if (!($hdl = fopen($fichier,'w'))) {
		echo "impossible d'ouvrir $fichier<br>";
		exit;
	}
	fwrite($hdl,$texte) or tuer ("merde");;
	fclose($hdl);
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // some day in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Content-type: application/x-download");
	header("Content-Disposition: attachment; filename={$fichier}");
	header("Content-Transfer-Encoding: binary");
	readfile($fichier);
}

function nouvelAdmin() {
	global $prefixe;

	$q	= "insert into ${prefixe}admin set statut=1";
	$d	= mysql_query($q);
	$ide	= mysql_insert_id();
	echo "<script>alert('nouvel admin : $ide');</script>";
	return $ide;
}

function supprimerAdministrateur($ide=0) {
	global $prefixe;

	$q = "delete from ${prefixe}admin where ide='$ide'";
	$h = mysql_query($q) or tuer("supprimerAdministrateur::erreur:".mysql_error());
}

function lireLangueSite(){
	global $prefixe;
	$q = "select valeur from ${prefixe}var where cle='LangueSite'";
	$h = mysql_query($q) or tuer("LireLangueSite::pb ".mysql_error());
	$r = mysql_fetch_array($h);
	return $r['valeur'];
}

function Pet_faireSauvegarde($dir) {
	global $prefixe,$L,$serveurSql,$loginSql,$mdpSql,$baseSql;

	$fichier="sauvegarde-" . strftime("%F") . ".sql";

	// recuperer le nom des tables
	$q = "show tables like '${prefixe}%'";
	$h = mysql_query($q);
	while ($r = mysql_fetch_array($h)) {
		echo "<li>sauvegarde de ".$r[0]."</li>";
		$tables .= " ".$r[0];
	}
	// version 1... ça marche
	$cmd="mysqldump --opt -h $serveurSql -u $loginSql --password=$mdpSql $baseSql $tables"; 
	system("$cmd > $dir/$fichier");

	// compression
	if ($_REQUEST['compress'] == 'oui')
		system("gzip $dir/$fichier");

	echo "...<br />".$L['SauvegardeTermine'];
}

function Pet_faireRestauration($fichier) {
	global $prefixe,$L,$serveurSql,$loginSql,$mdpSql,$baseSql;

    $fichier    = "../tmp/sauvegarde/$fichier";

	// version 1 ça marche (pa bô)
	$cmd	= "mysql -h $serveurSql -u $loginSql --password=$mdpSql $baseSql $tables";
	system("zcat $fichier | $cmd", $iRet);
	echo "...<br />".$L['RestaurationTermine'];
}

function ajouterPapier($p,$n){
    global $L,$infosPetition,$prefixe;
	
	$cle= "papier_".$infosPetition['nom'];
	$q  = "INSERT INTO ${prefixe}var (cle,valeur)
		VALUES ('$cle',valeur+'$n')
		ON DUPLICATE KEY UPDATE valeur=valeur+'$n'";
	$qdb    = mysql_query($q) or tuer ("ajouterPapier::$q:".mysql_error());
	LireVariables();
	return;
}

function ajoutChamps($table,$n,$t,$s='',$nn='',$a='') {
	global  $prefixe;

	echo "<li><b>${prefixe}$table </b> : Ajout du champs $n</li>i\n";
	$s	= ($s ) ? "($s)" : $s;
	$nn	= ($nn) ? "NOT NULL" : $nn;
	$a	= ($a)  ? "AFTER $a" : $a;
	$q="ALTER TABLE $table ADD $n $t $s $nn $a ;";
	$db=mysql_query($q) or tuer("MiseAJour::$q:".mysql_error());
	@mysql_free_result($db);
	return true;
}

function tableExiste($t) {
	return mysql_fetch_assoc(mysql_query("SHOW TABLES LIKE '$t'"));
}

function ListeChamps($t) {
	$q	= "SHOW COLUMNS FROM $t";
	$d	= mysql_query("SHOW COLUMNS FROM $t like '$n'");
	while ($r = mysql_fetch_array($d))
		$aRet[]	= $r;
	return $aRet;
}

function champsExiste($t,$n) {
		return mysql_fetch_array(mysql_query("SHOW COLUMNS FROM $t like '$n'"));
}

function IndexExiste($t,$i ) {
	$q="SHOW INDEX FROM $t";
	$qdb    = mysql_query($q);
	while ( $t = mysql_fetch_assoc($qdb)){
		if ($t[Key_name]==$i)
			return true;
	}
	return false;
}

function modifChamps($table,$co,$cd,$t,$s='',$nn='') {
	$s	= ($s)  ? "($s)"  : $s;
	$nn	= ($nn) ? "NOT NULL" : $nn;
	$q	= "ALTER TABLE `$table` CHANGE `$co` `$cd` $t $s $nn";
	$db=mysql_query($q) or tuer("MiseAJour::$q:".mysql_error());
	@mysql_free_result($db);
}

function traductionExiste($ide,$l) {
	global $prefixe;
	return mysql_fetch_assoc(mysql_query("SELECT ide FROM ${prefixe}traductions WHERE ide_petition='$ide' AND langue='$l'"));
}

function SupprimerTraduction($ide,$l) {
	global $prefixe;
	$q	= "DELETE FROM ${prefixe}traductions WHERE ide_petition=$ide AND langue='$l'";
	echo "q: $q";
}

function ValideSignatureParMel($p,$mel) {
	global $prefixe;
	$requete    = "SELECT count(*) FROM ${prefixe}signatures WHERE ide_petition=$p and courriel='$mel'";
	$resultat   = mysql_query($requete) or die ("SignatureValideParMel::requete:$requete::".mysql_error());
	$return     = mysql_fetch_array($resultat);
	$requete    = "UPDATE ${prefixe}signatures SET valid=1 WHERE ide_petition=$p and courriel='$mel'";
	mysql_query($requete) or die ("SignatureValideParMel::requete:$requete::".mysql_error());
	return $return[0];
}

function CorrigeSignature($ide,$m){
	global $prefixe;
	$requete    = "UPDATE ${prefixe}signatures SET courriel='$m' WHERE ide=$ide";
	//echo "req: $requete<br>";
	$return	= mysql_query($requete) or die ("CorrigeSignature::requete:$requete::".mysql_error());
	return $return[0];
}

function TrouveSignaturesParMel($p,$m){
	global $prefixe;

	$requete    = "SELECT * FROM ${prefixe}signatures WHERE ide_petition=$p and courriel='$m'";
	//echo "req: $requete<br>";
	$resultat   = mysql_query($requete) or die ("TrouveSignaturesParMel::requete:$requete::".mysql_error());
	if (($oRet->nb=mysql_num_rows($resultat))==1)
		$oRet->enregistrement=mysql_fetch_assoc($resultat);
	else 
		while ($oRet->liste[]=mysql_fetch_assoc($resultat))
			$i++;
	return $oRet;
}
# vim: ts=4 ai
