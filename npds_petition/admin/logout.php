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

include 'inc_admin.php';

define (ROOTDIR,dirname(dirname(__FILE__)));
session_save_path(ROOTDIR . '/tmp');

session_start();
EcrireJournal("Deconnection de " . $_SESSION['petition_login']);
$cookie="sess_".session_id();

//vider $_SESSION
$_SESSION = array();

// et vider le cookie de connexion
if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-42000, '/');
}
 
// Finalement, on détruit la session.
session_destroy();
 

// pour être tranquille
unset($login);
@unlink(ROOTDIR . "/tmp/$cookie");

// et hop
header('Location: index.php');

# vim: ts=4 ai
?>
