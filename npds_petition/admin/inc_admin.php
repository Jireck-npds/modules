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


/* admin/inc_admin			les fonctions utiles pour la partie admin	*/

#function creer()
#function editionPetition($petition,$new)
#function editerAdministrateur()		Editer un administrateur
#function FautMiseAJour()				teste s'il faut une mise à jour
#function make_seed()
#function getMD5()
#function Pet_listeSauvegardes()
#function Pet_maintenance()					maintenance de la base et des tables.
####function menuAdministrateur()
#function menuAdministrateurs()
#function mort($msg,$flag)
#function Pet_restauration()
#function Pet_sauvegarde()
#function supprimerAdministrateur($ide)	Suppression d'un administrateur
#function pbsDroits()					test les droit d'écriture dans les repertoires config et tmp
#function verifDroit($t='')

####################

// Ce fichier ne sera execute qu'une fois
if (defined("_ADMIN_INC_ADMIN_")) return;
define("_ADMIN_INC_ADMIN_", "1");

function Debut($t,$f=0) {
	global $L;

	$sep	= ($t) ? ' - ' : '';
	$p		= ($f) ? '' : '../';
	$titre = $L['Titre']."${sep}$t";

	echo doctype();
	echo entetes($titre,"../");
	echo body();
	echo FaireLeTitre($L['Titre']." - ".$t);
}


function menuAdministrateurs(){
	global $L,$login;

	$flag = array(
		"<b><font color='blue'>*</font></b>",
		"<b><font color='red'>*</font></b>"
	);

	$up="<a href='../index.php'>".$L['T_Petition']."</a> / <a href='index.php'>";
	$up .= $L['T_Administration']."</a> / ".$L['Admins'];
	Pet_debutHtml($L['Titre_Administrateurs'],$up);

	if ($_POST['edition_x']) {
		editerAdministrateur($_POST['idadmin']);
		exit;
	} elseif ($_POST['efface_x']) {
		supprimerAdministrateur($_POST['idadmin']);
	} elseif ($_POST['ajouter_x']) {
		editerAdministrateur();
		exit;
	} elseif ($_POST['Bouton'] == $L['Bouton_Sauve']) {
		sauveAdministrateur($_POST['ide']);
	}
	echo <<<FIN
	<script>
	function chargeAdmin(v){
		document.getElementById('idadmin').value    = v;
	}
	</script>
	
	<form method=POST>
		<input type=hidden id=idadmin name=idadmin value='' />
FIN;

	if (is_Super($login)){
		echo "<table width='100%'>\n";
		foreach (ListeAdministrateurs() as $ide => $admin) {
			echo " <tr>\n";
			echo "  <td>".$flag[$admin['statut']]."</td>\n";
			echo "  <td>".$admin['login']." (".$admin['courriel'].")</td>\n";
			echo "  <td width='50%'>&nbsp;</td>\n";
			echo "  <td width='35'>";
			echo "   <input type=image name=edition value=$ide src='images/editerAdministrateur.png' title='".$L['title_EditerAdmin']."' onClick='chargeAdmin($ide)' />";
	  		echo "  </td>\n";
			echo "  <td width='35'>";
			echo "   <input type=image name=efface value=$ide Onclick='return confirm(\"" . $L['JS_Confirm_Suppression_Admin'] . "(ide=$ide)\");' src='images/retirerAdministrateur.png' title='".$L['title_EffacerAdmin']."' onClick='chargeAdmin($ide)' />";
	  		echo "  </td>\n";
			echo " </tr>\n";
		}
		echo " <tr>\n  <td colspan='5' style='text-align: center'>\n";
		echo "   <input type=image name=ajouter value=999 src='images/ajouterAdministrateur.png' title='".$L['title_AjouterAdmin']."'>";
		echo "  </td></tr>";
		echo "</table>\n";
		echo "</form>";
		echo "<br /><center>".$flag[0]."administrateur simple &nbsp;".$flag[1]." super administrateur</center>";
	}
//admin simple
	else {
		echo"Tsss va-t-en de là, simple admin<br>"; 
	}
	Pet_admin_finHtml(); 
}

//test droit d'écriture des repertoires config et tmp
function pbsDroits(){

	$file='test.php';
	$dirs	= array( 'config','tmp');

	foreach ($dirs as $dir) {
		// si la config existe, ce n'est pas un pb, au contraire, que l'on ne puisse pas écrire dessus!
		if (is_file(ROOTDIR . "/$dir/config.php")) continue;
		$f=@fopen(ROOTDIR . "/$dir/$file",'w');
		if (! $f)
			$aRet[]	= $dir;
		else {
			fclose($f);
			if (! unlink(ROOTDIR . "/$dir/$file"))
				$aRet[]	= $dir;
		}
	}
	return $aRet;
}

function make_seed() {
	list($usec, $sec) = explode(' ', microtime());
	return (float) $sec + ((float) $usec * 100000);
}

function getMD5(){
	return(md5(uniqid(rand())));
}

// mort propre
function mort($msg,$flag) {
	global $L;

	switch ($flag) {
		case 0 :
			$ret = $L['Page_Reload'];
			$cmd = "location.reload()";
			break;
		case 1:
			$ret = $L['Page_Avant'];
			$cmd = "history.go($flag)";
			break;
		case 2:
			$ret = $L['Page_Reload']; 
			$cmd = "location=index.php?".$_SERVER['QUERY_STRING']."&action2=".$_REQUEST['action2'];
			break;
		default:
			exit;
	}
	list($a,$v) = split('=',$_SERVER['QUERY_STRING']);
	echo " <p>&nbsp;&nbsp;$msg</p>
   <br>
    <form method='post' action='index.php'>
     <input type='hidden' name='$a' value='$v'>
     <input type='hidden' name='action2' value='".$_REQUEST['action2']."'>
     <center><input type='submit' onclick='javascript:$cmd; return 1;' value='$ret']'></center>
    </form>\n";

	Pet_admin_finHTML();
	exit();
}

function editerAdministrateur($ide=0)	{
	global $L,$lang,$login;

	$sel[$lang]='selected="selected"';
	$selects = array();

	$admin=LireAdminInfos($ide);
	if ( ! $admin['statut'])
		$selects = gereKelPetitions($ide);
	$up  = "<a href='../index.php'>".$L['T_Petition']."</a> ";
	$up .= "/ <a href='index.php'>".$L['T_Administration']."</a> ";
	$up .= ($super = is_super($login))	? "/ <a href='index.php?action=admin'>".$L['Admins']."</a> "
						: "";
	if ($ide) {
		$up .= "/ ".$L['EditionAdmin'];
		Pet_debutHtml($L['EditionAdmin'],$up);
	} else {
		$up .= "/ ".$L['title_AjouterAdmin'];
		Pet_debutHtml($L['title_AjouterAdmin'],$up);
	}

	$tdlogin = ($super)	? "<td><input type='text' name='login' value='".$admin['login']."'></td>"
				: "<td><b>$login</b></td>";
	$checked[$admin['statut']] = 'checked';
	echo "  <form method='POST' name='formadmin'>";
	echo "   <input type='hidden' name='ide' value='$ide'>";
	echo "   <table width='100%'>";
	echo "    <tr>";
	echo "     <td>".$L['Login']."</td>";
	echo "      $tdlogin";
	echo "    </tr><tr>";
	echo "     <td>".$L['Password']."</td>";
	echo "     <td><input type='text' name='password' value=''></td>";
	echo "    </tr><tr>";
	echo "     <td>".$L['Courriel']."</td>";
	echo "     <td><input type='text' name='courriel' value='".$admin['courriel']."'></td>";
	echo "    </tr><tr>";
	echo "     <td>".$L['Langage']."</td>";
	echo "     <td>";
	echo "      <select name='nouvellelang'>";
	echo "       <option value='en_US' ".$sel['en_EN'].">English</option>";
	echo "       <option value='es_ES' ".$sel['es_ES'].">Espagnol</option>";
	echo "       <option value='fr_FR' ".$sel['fr_FR'].">Français</option>";
	echo "      </select>";
	echo "     </td>";
	echo "    </tr>\n";
	// ============ super utilisateur
	if ($super) {
		if (!$checked[1]=='checked') $checked[0]='checked';
		echo "    <tr>";
		echo "     <td>".$L['TypeAdmin']."</td>";
		echo "     <td>";
		echo "      <input type='radio' name='typeadmin' value='1' ".$checked[1].">Super Administrateur&nbsp;";
		echo "      &nbsp;<input type='radio' name='typeadmin' value='0' ".$checked[0].">Administrateur restreint";
		echo "    </tr><tr>";
		echo "      <td>".$L['GerePetoches']."</td>";
		echo "     <td>";
		echo "      <select name='pets[]' multiple>\n";
		foreach (adm_ListePetitions() as $ide => $pet) {
			echo "       <option value='$ide' ".$selects[$ide].">".$pet['nom']."</option>\n";
		}
    		echo "     </select>\n    </td>";
		echo "    </tr><tr>";
		echo "     <td colspan=3 style='text-align: center'>";
		echo "      <input type='submit' name='Bouton' value='".$L['Bouton_Sauve']."'>";
		echo "     </td>";
		echo "    </tr>";
		echo "   </table>";
		echo "  <form>\n";
	}
	// ============ simple super
	else echo "
   </table>
  <form>\n";
	Pet_admin_finHtml();
}

function Pet_listeSauvegardes() {
	$dir    = '../tmp/sauvegarde';
	$sRet   = "<select name='fichier'>\n";
	
	if (is_dir($dir)) {
		$hdl    = opendir($dir);
		while (($fichier = readdir($hdl)) !== false) {
			if (($fichier=='.') or ($fichier=='..')) continue;
			$sRet   .= "<option value='$fichier'>$fichier</option>\n";
		}
	}
	$sRet   .= "</select>\n";
	return $sRet;
}

function Pet_maintenance() {
	global $L;

	$up  = "<a href='../index.php'>".$L['T_Petition']."</a> ";
	$up .= "/ <a href='index.php'>".$L['T_Administration']."</a> ";
	$up .= "/ ".$L['Maintenance'];
	Pet_debutHtml($L['Outils'],$up);

	$fichiers   = Pet_listeSauvegardes();

	if (! $GLOBALS['PasSecure']) 
		echo "<div class='admin'>
	<form name='maintenance' method='post'>
     <fieldset>
      <h1>".$L['Sauvegarde']."</h1>
	  ".$L['AideSauvegarde']."
	  <p>&nbsp;</p>
	  <center>
	   <input type='checkbox' name='compress' value='oui'> &nbsp;".$L['Compression']."<br /><br />
	   <input type='submit' name='action2' value='".$L['Bouton_Sauvegarder']."'>
	  </center>
	 </fieldset>
	 <br />
	 <fieldset>
	  <h1>".$L['Restauration']."</h1>".$L['AideRestauration']."
	  <br />
	  <center>
	   $fichiers <br /><br />
	   <input type='submit' name='action2' value='".$L['Bouton_Restaurer']."'></center>
	  </center>
	 </fieldset>
	</form>
    <br /><!--
    <h1>".$L['Recuperation']."</h1>".$L['AideRecuperation']."
    <br />
    <form name='recuperation' method='post'>
     <center><input type='submit' name='bouton' value='".$L['Bouton_Recuperer']."'></center>
     <input type='hidden' name='action2' value='recuperation'>
    </form> -->
    </div>
    	";
	else {
		echo $L['PasSauvegarde'];
	}
	Pet_admin_finHtml();
}

function creerNomAuthFichier(){
	$q	= ceil(date('m') / 15);
	return "admin_".substr(md5($login.date("Ymd").$q),0,10);
}

function demandeAuthFichier($f,$a,$a2) {
	global $L;

	$sel	= SelectionLangue();
	$sTmp	.= FaireLeTitre2($L['Titre_Verification']);
	$sTmp	.= "<form method='post'>\n";
	$sTmp	.= $sel;
	$sTmp	.= $L['VerificationDroits'] . $f;
	$sTmp	.= $L['VerificationDroits2'];
	$sTmp	.= "<input type='submit' name='reload' value='".$L['Bouton_Recharger_Page']."' onClick=''>\n";
	$sTmp   .= "<input type='hidden' name='action' value='$a'>\n";
	$sTmp   .= "<input type='hidden' name='action2' value='$a2'>\n";
	$sTmp	.= "</form>\n";
	echo FaireLeMessage($sTmp);
	echo finbody();
	exit;
} 

function verifDroit($af,$up='',$t,$f){
	global $L,$authfichier,$msgVerifDroit;

	if ( is_file( $af) or is_dir($cookie)) {
		unlink($af);
		return true;
	} else {
		$p = (isset($msgVerifDroit) && ($msgVerifDroit !='')) ? "\n   <p>$msgVerifDroit</p>\n" : "\n";
		Pet_debutHtml($L['EditionAdmin'],$up);
		echo "   <h1>$t</h1>$p   ".
	$L['VerifDroit']."<br />
    <center><input type='text' value='$af'></center><br />".
	$L['VerifDroit2']."
    $f";
		Pet_admin_finHtml();
		exit;
	}
	exit; // jamais atteint ?
}

function Pet_sauvegarde() {
	global $L;
	$dir    = '../tmp/sauvegarde';

	$authfichier = creerNomAuthFichier();

	$up  = "<a href='../index.php'>".$L['T_Petition']."</a> ";
	$up .= "/ <a href='index.php'>".$L['T_Administration']."</a> ";
	$up .= "/ <a href='index.php?action=maintenance'>".$L['Maintenance']."</a> ";
	$up .= "/ ".$L['Sauvegarde'];
	Pet_debutHtml($L['Sauvegarde'],$up);

	if (! (is_file(ROOTDIR . "/tmp/$authfichier")))
		demandeAuthFichier($authfichier,'maintenance','sauvegarde');

	if (! is_dir($dir))
		if (! mkdir($dir)) {
			echo "Pas de répertoire d'arrivée";
			exit;
		}

	Pet_FaireSauvegarde($dir);
	unlink(ROOTDIR . "/tmp/$authfichier");
	exit;
}

function Pet_restauration(){
	global $L;

	$authfichier = creerNomAuthFichier();

	$fichier	=$_REQUEST['fichier'];

	$up  = "<a href='../index.php'>".$L['T_Petition']."</a> ";
	$up .= "/ <a href='index.php'>".$L['T_Administration']."</a> ";
	$up .= "/ <a href='index.php?action=maintenance'>".$L['Maintenance']."</a> ";
	$up .= "/ ".$L['Restauration'];
	$t = $L['Restauration']." (<b>$fichier</b>)";
	Pet_debutHtml($L['Restauration']." - $fichier",$up);

	if (! (is_file(ROOTDIR . "/tmp/$authfichier")))
		demandeAuthFichier($authfichier,'maintenance','sauvegarde');

	Pet_faireRestauration($fichier);
	Pet_admin_finHtml();
	exit;
}

function editionPetition($petition,$new=0){
	global $L,$infosPetition,$LangueUtilisateur,$LesLangues;
	
	$LanguePetition	= $infosPetition['langue'];
	$new			= ($new) ? $new : $_POST['new'];
	
	if ($l=$_POST['efface']) {
		SupprimerTraduction($petition, $l);
	}

	$up			= "<a href='../index.php'>".$L['T_Petition']."</a> ";
	$up			.= "/ <a href='index.php'>".$L['T_Administration']."</a> ";

	if ($new) {
		$up			.= "/ " . $L['Titre_Creation'] ;
		$leNom		= "<input type='text' name='leNom' value='".$_POST['leNom']."'>";
		$leNom		.= " <input type='hidden' name='new' value='$new'>";
		$leTitre	= $L['Titre_Creation'];
		# On crée la pétition dans la langue de l'utilisateur.. à moins qu'il en demande une autre
		$laLangue	= ($l=$_POST['LanguePetition'] ) ? $l : $LangueUtilisateur;
		$sel		= A_SelectionLangue($petition,$laLangue);
		$titre		= $_POST['titre'];
		$sous_titre	= $_POST['sous_titre'];
		$texte		= $_POST['texte'];
		$date_init	= $_POST['date_init'];
		$statut		= ($s=$_POST['statut']) ? $s : 0;
		$robot		= $_POST['robot'];
		$cc_request	= $_POST['cc_request'];
		$block		= "  <tr>
   <td>". $L['Label_Date_Init']."</td><td><input type='text' name='date_init' value='$date_init' /></td>
  </tr><tr>
   <td>".$L['Label_Adresse_Robot']."</td><td><input type='text' name='robot' value='$robot'></td>
  </tr><tr>
   <td>".$L['Info_Signature']."</td><td><input type='checkbox' name='cc_request' value='1' $checked></td>
  </tr>";
	} elseif ( ($ajout=$_POST['ajouterTraduction']) == 'ajouter') {
		$up			.= "/ " . $L['Titre_Edition'];
		$sel		= A_SelectionLangue($petition,$LanguePetition);
		$nom		= $infosPetition['nom'];
		$leNom		= $infosPetition['nom'] . "<input type='hidden' name='nom' value='$nom'>";
		$leTitre	= $L['Titre_Edition']." ".$infosPetition['nom'];
	} else {
		$up			.= "/ " . $L['Titre_Edition'];
		$laLangue	= ($LangueTraduction=$_POST['LangueTraduction'] ) ? $LangueTraduction : $LanguePetition;
		$nom		= $infosPetition['nom'];
		$leNom		= $infosPetition['nom'] . "<input type='hidden' name='nom' value='$nom'>";
		$leTitre	= $L['Titre_Edition']." ".$infosPetition['nom'];
		$leTitre	.= ($LangueTraduction) ? " " . $L['en'] . " " . $LesLangues[$laLangue] : '' ;
		$statut		= (isset($_POST['statut']))	? $_POST['statut'] : $infosPetition['statut'];
		$robot		= ($t=$_POST['robot'])		? $t : $infosPetition['robot'];
		$date_init	= (isset($_POST['date_init'])) ? $_POST['date_init'] : $infosPetition['date_init'];
		$cc_request	= ($t=$_POST['cc_request'])	? $t : $infosPetition['cc_request'];

		if ($laLangue == $LanguePetition) 
			$block		= "  <tr>
   <td>". $L['Label_Date_Init']."</td><td><input type='text' name='date_init' value='$date_init' /></td>
  </tr><tr>
   <td>".$L['Label_Adresse_Robot']."</td><td><input type='text' name='robot' value='$robot'></td>
  </tr><tr>
   <td>".$L['Info_Signature']."</td><td><input type='checkbox' name='cc_request' value='1' $checked></td>
  </tr>";

		$titre		= stripslashes($infosPetition['titre'][$laLangue]);
		$sous_titre	= stripslashes($infosPetition['sous_titre'][$laLangue]);
		$texte		= stripslashes($infosPetition['texte'][$laLangue]);
	}

	Pet_debutHtml($leTitre,$up);

	$select[$statut]	= 'checked';
	$checked			= ($cc_request) ? 'checked' : '';
	echo "
 <form method='POST'>
  <input type='hidden' name='LanguePetition' value='$LanguePetition'>
  <input type='hidden' name='LangueTraduction' value='$LangueTraduction'>
  $sel
  <table>
   <tr>
    <td>".$L['Label_Nom']."</td>
    <td>$leNom</td>";
	if (! $new) {
		echo "
	<td width='15'> </td>
	<td rowspan=5 valign='top'> 
	 <table border=1 width=100%>
	  <caption>" . $L['TraductionsDisponibles'] . "</caption>";
		foreach ($infosPetition['texte'] as $l => $t) {
			echo "    <tr>\n";
			echo "     <td>" . $LesLangues[$l] . "</td>\n";
			if ($l == $laLangue) 
				echo "<td class='fgrey'>&nbsp;</td><td class='fgrey'>&nbsp;</td>\n";
			else {
				echo "     <td>\n";
				echo "      <input type=image name='LangueTraduction' value='$l' src='images/b_edit.png' title='".$L['title_Editer']."'>\n";
				echo "     </td>\n";
				if ( $l == $LanguePetition) 
					echo "<td class='fgrey'>&nbsp;</td>\n";
				else
					echo "     <td>
     <input type=image name='efface' value='$l' src='images/b_drop.png' title='" . $L['title_Effacer']. "'
		Onclick='return confirm(\"" . $L['interro1'] . $L['JS_Confirm_Suppression_Traduction'] . " " .$LesLangues[$l] . $L['interro2'] . "\");'>
				</td>\n";
				echo "    </tr>\n";
			}
		}
		echo "    <tr>\n";
		echo "     <td colspan=3 align=center>\n";
		echo "      <input type=image name=ajouterTraduction value='ajouter' src='images/add.png'>\n";
		echo "     </td>\n";
		echo "    </tr>\n";
		echo "	  </table>";
	}
	echo "
   </tr><tr>
    <td>".$L['Form_Titre']."</td>
    <td><input type='text' name='titre' value='$titre' title='".$L['Titre_Titre']."'></td>
   </tr><tr>
    <td>".$L['sousTitre']."</td>
    <td>
     <input type='text' name='sous_titre' value=\"$sous_titre\" title='".$L['Titre_Sous_Titre']."'>
    </td>
	<td width='15'> </td>
  </tr><tr>
   <td>".$L['Statut']."</td>
   <td>
    ".$L['Label_Brouillon']."<input type='radio' name='statut' value='0' ".$select[0].">&nbsp;
    ".$L['Label_Enligne']."<input type='radio' name='statut' value='1' ".$select[1].">&nbsp;
    ".$L['Label_Archive']."<input type='radio' name='statut' value='2' ".$select[2].">&nbsp;
   </td>
  </tr><tr>
   <td>".$L['Label_TextePetition']."</td><td><textarea rows='10' cols='50' name='texte'>$texte</textarea></td>
  </tr>
$block
  </table>
  <br>
  <input type='hidden' name='action' value='edition'>
  <input type='hidden' name='petition' value='$petition'>
  <input type='Submit' name='sauve' value='".$L['Bouton_Sauve']."'>
 </form>
";
	Pet_admin_finHtml();
} // fin edition

// petit formulaire pour saisir le nom de la nouvelle petition
function creer() {
	editionPetition($p,1);
}

function debug($a,$t=''){
	if ($t) echo "************* $t *************";
 echo "<pre>" . print_r($a,1) . "</pre>";
}

function FautMiseAJour() {
	global $variables,$version,$base_version;

	if (is_file(ROOTDIR . "/admin/inc_config.php"))
		return true;
	if ( ( $variables['version'] != $version  ) || ( $variables['base_version'] != $base_version ) )
		return true;
	return false;
}

// ecriture du fichier config.php
function ecrireConfig($s,$b,$l,$p) {
	global $prefixe;

    $f   = "<?php\n";
    $f  .= '  $serveurSql	= "' . $s . '";'."\n";
    $f  .= '  $baseSql	= "' . $b .'";'."\n";
    $f  .= '  $loginSql	= "' . $l .'";'."\n";
    $f  .= '  $mdpSql	= "' . $p .'";'."\n";
    $f  .= '  $prefixe	= "' . $prefixe . '";'."\n";
    $f  .= '  @mysql_connect($serveurSql,$loginSql,$mdpSql) or tuer("config error::connection:".mysql_error());'."\n";
    $f  .= '  @mysql_select_db($baseSql) or tuer("config error::choix base:".mysql_error());'."\n";
    $f  .= "  @mysql_query(\"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'\");\n";
	$f	.= '?' . ">\n";
    $hdl = fopen(ROOTDIR . '/config/config.php','wb');
    fputs($hdl,$f);
    fclose($hdl);
}

// ecrire un fichier de log
// Le choix d'ecrire un fichier 'à la main' permet l'utilisation d'un serveur WAMP
function EcrireJournal($msg) {
	$sFichierJournal	= ROOTDIR . "/tmp/phpPetitions.log";
	$date	= "[" . date("Y-m-d H:i:s") . "] - ";

	if (is_file($sFichierJournal)) {
		$aTmp	= stat($sFichierJournal);
		$jours7	= 7 * 24 * 60 * 60;
		$Mo10	= 1024*1024*10;
		
		// faire tourner si la taille dépasse xxxx octets ou que la date est +7j
		if ( ($aTmp['size'] > $Mo10) || (time() - $aTmp['ctime'])> $jours7 )  {
			for ($i=9 ; $i; $i--) {
				if (is_file($sFichierJournal . "$i" . ".zip"))
					rename($sFichierJournal . ".$i" . ".zip", $sFichierJournal . "." . $i+1 . ".zip");
				if ($i==1 && is_file($sFichierJournal . ".1")) {
					rename($sFichierJournal . ".1", $sFichierJournal . ".2");
					$zip = new ZipArchive;
					if ($zip->open($sFichierJournal . ".2.zip") === TRUE) {
					    $zip->addFile($sFichierJournal . ".2.zip");
						$zip->close();
					}
				}	
			}
			rename($sFichierJournal, $sFichierJournal . ".1");
		}
	}

	$hdl	= fopen(ROOTDIR . "/tmp/phpPetitions.log", 'a+');
	fputs($hdl,$date . $msg . "\n");
	fclose($hdl);
}

// ecrire un message dans le journal et s'arrêter
function tuer($msg) {
	if (! preg_match("/\n/",$msg))
		$msg	.= "\n";
	EcrireJournal($msg);
	exit(0);
}

// cette fonction vérifie l'existance d'un .htaccess, sa conformité, et son efficacité
// retourne false si la sécurité n'est pas assurée
// un .htaccess "non conforme" sera affiché pour vérification, mais cela peut avoir été fait volontairement
function VerifierHtaccess($dir='tmp'){
	$htaccess	= ROOTDIR . "/$dir/.htaccess";
	$fichier	= ROOTDIR . "/$dir/.ok";			//comme dans spip :-)
	$deny		= "deny from all\n";

	//Le .htaccess existe-il
	if (is_file($htaccess)) {
		# verifier qu'il n'est pas altéré
		$sTmp   = implode('',file($htaccess));
		if ($sTmp !== $deny)
			$GLOBALS['htaccessModifie']	.= "$htaccess:\n$sTmp\n";
	} else {
		$hdl    = fopen($htaccess, "w");
		fputs($hdl,$deny);
		fclose($hdl);
		chmod($htaccess,0666);
	}
	
	// on crée un fichier ok dans le répertoire
	$hdl    = fopen($fichier,"w");
	if (! $hdl) die ("VerifierHtaccess::pb d'écriture $fichier");
	fclose($hdl);
    // et on essaye de la récupérer !
	$proto  = ( (isset($_SERVER["SCRIPT_URI"])  && (substr($_SERVER["SCRIPT_URI"],0,5) == 'https')) ||
				(isset($_SERVER['HTTPS'])       && (strtolower($_SERVER['HTTPS'])=='on') ) )
				? 'https' : 'http';
	$host   = $_SERVER['HTTP_HOST'];
	$port   = $_SERVER['SERVER_PORT'];
	if ( !preg_match("/:/",$host) && (! ($port==80 || $port==443)))
		$host   .=  ":$port";
	$uri    = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF'];
	$url    = $proto . "://" . $host . preg_replace("#/admin/.*#","",$uri) . "/$dir/.ok";
	$hdl	= @fopen($url, "r");
	if ($hdl)
		fclose($hdl);
	return (! $hdl); 
}

# vim: ts=4 ai
?>
