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

/* admin/index.php : fichier d'entrée dans la partie administration des petitions */

#function main($listePetitions)

// avant tout autre chose...
define('ROOTDIR',dirname(dirname (__FILE__)));

$LangueSite		= 'fr_FR'; # ben oui, faut bien commencer...

// désactiver les erreurs
//error_reporting(0);
// en phase de test
error_reporting(E_ALL ^ E_NOTICE);

include ROOTDIR . '/options.php';

// le paquet est-il déja configuré ?
if (is_file(ROOTDIR . '/config/config.php')) {
	include_once ROOTDIR . '/config/config.php';
}
elseif (is_file(ROOTDIR . "/admin/inc_config.php")) {
	include_once ROOTDIR . '/admin/inc_config.php';
}
// Non on lance l'install
else {
	header("Location: install.php");
	exit();
}

//echo "savepath: " . session_save_path();
session_save_path(ROOTDIR . '/tmp');
session_start();

include 'inc_admin.php';
include 'inc_sql.php';
include 'inc_version.php';
include 'inc_html.php';
include 'inc_texte.php';
include 'inc_signatures.php';
include 'inc_courriel.php';

// on commence par tester la sécurité, i.e. htaccess fonctionne
foreach (array('config','tmp') as $dir)
	if ( ! VerifierHtaccess($dir))
		$GLOBALS['PasSecure']   = true;

# gestion des langues
lireVariables();
if (!empty($variables['LangueSite']))
	$LangueSite	= $LangueUtilisateur	= $variables['LangueSite'];
include_once 'inc_langue.php';

// on se logge
include 'login.php';

include ROOTDIR . "/langues/$LangueUtilisateur.php";


// test d'une mise à jour
// prevoir une verif 'a la spip'
if (FautMiseAJour()) {
	include_once('./inc_maj.php');
	MiseAJour();
	exit ;
}

if ( $a = pbsDroits())
	YaPbsDroits($a);

// ADMINISTRATION -- AUTOMATE
$sauve = $_POST['sauve'];
$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : "zaza";
$petition = $_REQUEST['petition'];
$debug = $_REQUEST['debug'];

if ($petition)
	$infosPetition = LireInfosPetition($petition);

//echo "action: $action<br>";
//phpinfo(INFO_VARIABLES);

switch ($action) {
	case 'perso':
		Pet_AfficheIndex(ROOTDIR . '/modele/tutoriel_perso.html');
		break;
	case $L['AjoutAdministrateur']:
		editerAdministrateur(0);
		break;
	case $L['EditAdmin']:
		if ($ideAdmin=$_REQUEST['ide']) editerAdministrateur($ideAdmin);
		else main();
		break;
	case $L['SupprimerAdmin']:
		supprimerAdministrateur($_REQUEST['ide']);
		header("Location: index.php?action=admin");
		break;
	case 'admin1':
		editerAdministrateur(lireIdeAdmin($login));
		break;
	case 'admin':
		menuAdministrateurs();
		break;
	case 'signatures':
	// sous-automate signatures
		if (($_POST['action2_x'] + $_POST['action2_y']) > 0) {
			if ($petition) voirSignatures($petition);
		}
		else {
			$action2 = ($_POST['ajout']=='+') ? 'AjoutPapier' :$_REQUEST['action2'];
			switch ($action2) {
				case $L['Bouton_Ajouter']:
					if ($petition) ajouterSignatures($petition);
					break;
				case $L['Bouton_Supprimer']:
					if ($petition) delSignatures($petition);
					break;
				case 'AjoutPapier' :
					ajouterPapier($petition,$_POST['nombre']);
				default:
					menuSignatures($petition);
			}
		}
		break;
	//nouvelle petition
	case 'creer':
		creer();
		break;
	case 'edition':
		if ($sauve == $L['Bouton_Sauve']) {
			enregistrePetition($petition);
			//header("Location: index.php");
			main();
		}
		else
			editionPetition($petition);
		exit;
	//suppression d'une petition
	case 'supprimer':
		detruire($petition);
		break;
	// Relance
	case 'relance':
		Pet_relance($petition);
		break;
	case 'maintenance':
		switch ($action2=$_REQUEST['action2']) {
			case $L['Bouton_Sauvegarder']:
				Pet_sauvegarde();
				break;
			case $L['Bouton_Restaurer']:
				Pet_restauration();
				break;
		}
		Pet_maintenance();
		break;
	default:
		main();
}

exit;

// affiche la liste de petitions
function main(){
	global $L,$login;

	$titre = $L['Titre_Gestion'];
	$nouvelle = $L['Nouvelle_Petition'];

	$up  = "<a href='../index.php'>".$L['T_Petition']."</a> ";
	$up .= "/ ".$L['T_Administration'];

	Pet_debutHtml($titre,$up,"1");
	echo "
 <table width='100%'>
  <tr>
   <td width='60%' class='box' valign='top'>
    <table width='100%' cellpadding='0' cellspacing='0'>
     <tr bgcolor='#dedede'>
      <td width='35%'>" . $L['Label_Colonne_Nom'] . "</td>
      <td width='35%' align='center'>" . $L['Label_Colonne_Statut'] . "</td>
      <td colspan=4 align='center'>" . $L['Label_Colonne_Action'] . "</td>
     </tr>\n";

	//echo $listePetitions;
	foreach (adm_ListePetitions() as $ide => $pet) {
		echo "     <tr>\n";
		switch ($pet['statut']) {
			case 1: $etat="<font color='red'>*</font>"; break;
			case 2: $etat="<font color='blue'>*</font>"; break;
			default:$etat="<font color='black'>*</font>";
		}
		echo "      <td width='35'>
       <a href='../index.php?petition=$ide' title='".$L['TitreVoir']."'>".$pet['nom']."</a>
      </td>
      <td align='center'>$etat</td>
      <td width='35'>
       <a href='index.php?action=signatures&petition=$ide'>
        <img src='images/signature.png' alt='".$L['Gerer']."' title='".$L['Gerer']."' border='0'>
       </a>
      </td><td width='35'>
       <a href='index.php?action=edition&petition=$ide'>
        <img src='images/configure.png' alt='".$L['Propriete']."' title='".$L['Propriete']."' border='0'>
       </a>
      </td><td width='35'>
       <a href='index.php?action=relance&petition=$ide'>
        <img src='images/relance.png' alt='".$L['Rappel']."' title='".$L['Rappel']."' border='0'>
       </a>
      </td><td width='35'>
       <a href='index.php?action=supprimer&petition=$ide'
          Onclick='return confirm(\"" . $L['interro1'] . $L['JS_Confirm_Suppression_Petition'] . " " .$pet['nom'] . $L['interro2'] . "\");'>
        <img src='images/poubelle.png' alt='".$L['Supprimer']."' title='".$L['Supprimer']."' border='0'>
       </a>
      </td>
     </tr>\n";
	}

	echo "   </table><p>&nbsp;</p>
   </td>
   <td width='20%'>&nbsp;</td>\n";

// boite admin
	if (is_super($login))
	//  =========== super admin
     echo "   <td class='box' align='center'>
    <a href='index.php?action=creer'>
     <img src='images/nouvelle-petition.png' title='$nouvelle' border='0'>
    </a><br />
    <a href='index.php?action=creer'>$nouvelle</a>
    <br /><br />
    <a href='index.php?action=perso'>
     <img src='images/design.png' title=\"".$L['Personnaliser_Petition']."\" border='0'>
    </a><br/><a href='index.php?action=perso'>".$L['Personnaliser_Petition']."</a>
    <br /><br />
    <a href='index.php?action=admin'>
     <img src='images/administrateurs.png' title='".$L['Admins']."' border='0'>
    </a><br /><a href='index.php?action=admin'>".$L['Admins']."</a>
    <br /><br />
    <a href='index.php?action=maintenance'>
     <img src='images/outils.png' title='".$L['Outils']."' border='0'>
    </a><br/><a href='index.php?action=maintenance'>".$L['Outils']."</a>
   </td>\n";
	//  =========== admin simple
	else echo "   <td class='box' align='center'>
    <a href='index.php?action=admin1'>
     <img src='images/administrateur.png' title='".$L['Admin']."' border='0'>
    </a><br/><a href='index.php?action=admin1'>".$L['Admin']."</a>
    <br /><br />
   </td>\n";
    echo "  </tr>
  <tr>
   <td height='50'></td>
  </tr>
 </table>
    * " . $L['Label_Brouillon'] . "&nbsp;&nbsp;<font color='red'>*</font> " . $L['Label_Enligne'] . "&nbsp;&nbsp;<font color='blue'>*</font> " . $L['Label_Archive'] . " \n";

	Pet_admin_finHtml();
} // fin main

# vim: ts=4 ai
?>
