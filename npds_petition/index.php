<?php
 /***************************************************************************\
  *  phpPetitions, serveur de pétition pour php/Mysql                       *
  *                                                                         *
  *  Copyleft (c) 2003-2005                                                 *
  *  Francois Sauterey, Asdrad Torres, Joel Pothier                         *
  *  le Centre Ressource du Réseau Associatif et Syndical                   *
  *                                                                         *
  *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
  *  Pour plus de details voir le fichier COPYING.txt                       *
 \***************************************************************************/

/*		index.php				fichier d'entrée du programme			*/

// avant tout autre chose...
define('ROOTDIR',dirname (__FILE__));

$LangueSite		= 'fr_FR'; # ben oui, faut bien commencer...

// désactiver les erreurs dans la partie publique
error_reporting(0);

session_save_path(ROOTDIR . '/tmp');
session_start();

// les options locales
include('options.php');

include_once 'admin/inc_langue.php';
include_once('admin/inc_html.php');

if (is_file('config/config.php')) {
	include_once('config/config.php');
}
else {
	pasConfigure();
	exit();
}

include_once('admin/inc_admin.php');
include_once('admin/inc_sql.php');
include_once('admin/inc_version.php');
include_once('admin/inc_texte.php');
include_once('admin/inc_courriel.php');

srand(make_seed());

$variables	= array();
lireVariables();
$LangueSite	= $variables['LangueSite'];

if (! $petition) 
	if ($_GET['petition']) $petition	= intval($_GET['petition']);
	elseif ($_GET['p']) $petition		= intval($_GET['p']);

if (! $cle) 
    if ($_GET['cle'])   $cle    = $_GET['cle'];
	elseif ($_GET['c']) $cle    = $_GET['c'];

$pour_voir	= $_GET["pour_voir"];
$signe		= $_GET["signe"];
$validation	= $_GET["validation"];
$a1ami		= $_GET['a1ami'];

$a_signe	= $_POST["a_signe"];

if ($petition) {
	$infosPetition=LireInfosPetition($petition);

	if (! $infosPetition['statut']) {
		Pet_AfficheIndex();
		exit;
	}

	// Analyse les parametres et gere l'automate
	if ($cle)						{ $etat	= 'validation';}	// validation 
	elseif ($a_signe	== 'oui')	{ $etat = 'a_signe'; }		// retour du formulaire
	elseif ($signe	== 'oui')		{ $etat = 'signe'; }		// signature: formulaire
	elseif ($pour_voir	== 'oui')	{ $etat = 'pour_voir'; }	// voir les signature
	elseif ($a1ami	== 'oui')		{ $etat = 'a1ami'; }		// envoyer à un ami
	else							{ $etat	= 'defaut'; }		// defaut: voir le texte de la petition
	 
	// etat de l'automate
	switch ($etat) {
		case 'a1ami':
			Pet_a1ami($petition);
			break;
		case 'validation':
			if (ValideSignature($petition,$cle))
				Pet_affichePetitionPage($petition,'confirm_ok.html');
			else
				Pet_affichePetitionPage($petition,'confirm_err.html');
			exit;
		case 'a_signe':
		// le formulaire est-il bien rempli ?
			if (! ($nom=$_POST['nom']) or ! ($prenom=$_POST['prenom'])) {
				$message_erreur='champ_manquant';
				Pet_affichePetitionPage($petition,'form_err.html');
			} 
			elseif ( ! Pet_AdresseValide($courriel=$_POST['courriel'])) {
				$message_erreur='Adresse_Invalide';
				Pet_affichePetitionPage($petition,'form_err.html');
			}
			// Test une signature anterieure
			elseif (chercheSignature($petition,$nom,$prenom,$courriel))
				echo $L['DejaSigne'];
			else {
				$info=$_POST['info'];
				// sauvegarde des données dans la BD, et recuperation de la cle de confirmation
				// la fonction Pet_sauveSignature récupère ses datas directement dans l'environnement
				if ($cle	= Pet_sauveSignature())
					// envoi du courriel de demande de confirmation (idem)
					if (Pet_demandeConfirmation($petition,$cle))
						Pet_affichePetitionPage($petition,'form_ok.html');
					else
						Pet_affichePetitionPage($petition,'form_err.html');
						
			}
			exit;
		case 'signe':
			Pet_affichePetitionPage($petition,'form.html');
			break;
		case 'pour_voir':
			Pet_affichePetitionPage($petition,'vsign.html');
			break;
		default:
			Pet_affichePetitionPage($petition,'index.html');
	}
} else 
	Pet_AfficheIndex();

exit (0);
# vim: ts=4 ai
?>
