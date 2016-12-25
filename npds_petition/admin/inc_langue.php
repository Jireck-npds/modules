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

/* admin/inc_langue.php			regroupe les fonctions de langue				*/
# function selectionLangue()	retourne un 'select' pour les langues

if (isset($_POST['LangueSite'])) 
	$LangueSite			= $_POST['LangueSite'];

$LangueUtilisateur		=	(isset($LangueUtilisateur))	? $LangueUtilisateur	: 
							(isset($LangueSite))		? $LangueSite			:
							'fr_FR';

if (! empty($_SESSION['petition_langue']))
	$LangueUtilisateur	= $_SESSION['petition_langue'];

if (!empty($_POST['LangueUtilisateur'])) 
	$LangueUtilisateur	= $_POST['LangueUtilisateur'];

$petition_langue			= $LangueUtilisateur;
$SESSION['petition_langue'] = $LangueUtilisateur;

include ROOTDIR . "/langues/$LangueUtilisateur.php";
if (is_file($f=ROOTDIR . "/langues/mes_$LangueUtilisateur.php"))
	include ROOTDIR . "/langues/mes_$LangueUtilisateur.php";

function selectionLangue($page='',$l='LangueUtilisateur',$f=1){
	global $LangueUtilisateur, $LesLangues;

	$sel[$LangueUtilisateur]	= 'selected="selected"';
	$onChange					= ($f) ? "this.form.submit()" : '';

	$sRet	.= "  <select name='$l' onChange='$onChange'>\n";
	foreach ($LesLangues as $c => $v) {
		if (is_file(ROOTDIR . "/langues/$c.php"))
			$sRet	.= "    <option value='$c' " . $sel[$c] . ">" . ucfirst($v) . "</option>\n";
	}
	$sRet	.= "  </select>\n";

	return $sRet;
}

function A_selectionLangue($p,$l){
	global $LesLangues,$infosPetition;

	$sLangue	= ($p) ? 'LangueTraduction' : 'LanguePetition' ;
	$sel[$l]	= 'selected="selected"';

	$sRet	.= "  <select name='$sLangue' onChange='ModifChamps(this.form)'>\n";
		foreach ($LesLangues as $c => $v) {
			if (! traductionExiste($p,$c) && $infosPetition['langue'] != $c)
				$sRet	.= "    <option value=$c " . $sel[$c] . ">" . ucfirst($v) . "</option>\n";
		}
	$sRet	.= "  </select>\n";

	return $sRet;
}

# vim: ts=4 ai
?>
