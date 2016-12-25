<?php
 /***************************************************************************\
  *  phpPetitions, serveur de pétition pour php/Mysql                       *
  *                                                                         *
  *  Copyright (c) 2003-2005                                                *
  *  Francois Sauterey, Asdrad Torres, Joel Pothier                         *
  *                                                                         *
  *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
  *  Pour plus de details voir le fichier COPYING.txt                       *
 \***************************************************************************/

include_once "class.phpmailer.php";

/*	admin/courriel.php			les fonctions de courrier		*/

#function Pet_testMx($host)
#function Pet_AdresseValide($courriel)
#function Pet_demandeConfirmation($petition,$cle)
#function Pet_EnvoyerCourrier($a, $de, $sujet,$message)
#function Pet_relance($p)
#function Pet_a1ami($petition)
#function Pet_avis($sign='')

function Pet_testMx($host){
	if (getmxrr ( $host, $mx)) return true;
	return (gethostbyname($host)!=$host);
}

// teste la validité d'une adresse
function Pet_AdresseValide($courriel) {
	if (! $courriel) return false;
	preg_match("/([-a-zA-Z0-9_\.]+)@([-a-zA-Z0-9_]+)\.([-a-zA-Z0-9_\.]+)/",$courriel,$parties);
	if (! $parties[0] ) return false;
	$domaine	= $parties[2] . "." . $parties[3];
	if (! Pet_testMx($domaine)) return false;
	return true;
}

// envoi un courriel de demande de confirmation
function Pet_demandeConfirmation($petition,$cle){
//,$nom,$prenom,$info,$courriel,$pays_prefere,$langue_preferee,$volontaire_trad){
	global $L,$infosPetition,$LangueUtilisateur,$erreur;
	
	$nom        = trim(Pet_propre($_POST['nom']));
	$prenom     = trim(Pet_propre($_POST['prenom']));
	$info       = trim(Pet_propre($_POST['info']));
	$courriel   = trim(Pet_propre($_POST['courriel']));
	$titre		= (!empty($infosPetition['titre'][$LangueUtilisateur]))	? stripslashes($infosPetition['titre'][$LangueUtilisateur]) 
	: stripslashes($infosPetition['titre'][$infosPetition['langue']]);

	$lien="http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"])."/index.php?p=$petition&cle=$cle"; 

	$robot=$infosPetition['robot'];
	if (! file_exists($modele='modele/' . $infosPetition['nom'] . "/courrier-${LangueUtilisateur}.txt") &&
		! file_exists($modele="modele/defaut/courrier-${LangueUtilisateur}.txt") &&
		! file_exists($modele="modele/" . $infosPetition['nom'] . "/courrier.txt") &&
		! file_exists($modele="modele/defaut/courrier.txt"))
		mort("affichePetitionPage : ".$L[Pas_Modele]." $page",0);
	$msg=implode('',file($modele));

	$msg = Pet_remplir_info($petition,$msg,$lien,$_POST);

	return Pet_EnvoyerCourrier($courriel,$robot,$titre,$msg);
}

// la fonction est maintenant unn frontal de la class phpmailer
function Pet_EnvoyerCourrier($a, $de, $sujet,$msg) {
	global $erreur;

	$mel			= new phpmailer();
	$mel->FromName	= 'Petitions';
	$mel->From 		= $de;
	//$mel->IsSMTP(true);
	$mel->addAddress($a);
	$mel->AddReplyTo($de);
	$mel->Subject	= $sujet;
	$mel->Body		= utf8_decode($msg);
	if(!($retour=$mel->Send())) $erreur	= $mel->ErrorInfo; 
	$mel->SmtpClose();
	unset($mel);
	return $retour;
}

#funtion relance1($sign){
#	global $prefixe,$L,$robot,$robot,$infosPetition;
#
#	$lien="http://".$_SERVER["HTTP_HOST"]."$lien/?p=$p&cle=".$sign->cookie;		//*fonctionne*cle/cle *14062006
#
#}
function Pet_relance($p) {
	global $prefixe,$L,$robot,$robot,$infosPetition;

	$nom=$infosPetition['nom'];
	$robot=$infosPetition['robot'];
	$up="<a href='../index.php'>".$L['T_Petition']."</a> / <a href='index.php'>";
	$up .= $L['T_Administration']."</a> / ".$L['Rappel'];
	Pet_debutHtml($L['Titre_Relance'].$infosPetition['nom'],$up);

	if ($_REQUEST['go'] == $L['Bouton_Envoyer']) {
		$message=$_POST['message'];
		$o=1;
		$lien=preg_replace('#/admin#','',dirname($_SERVER["PHP_SELF"]));
		$lien="http://".$_SERVER["HTTP_HOST"]."$lien/?p=$p&cle=";		//*fonctionne*cle/cle *14062006
		$retardataires=listeRetardataires($p,$_POST['nbj']);
		//debug($retardataires);exit;
		$nbRetardataires=count($retardataires);
		echo "Retardataires: $nbRetardataires<br />";
		foreach ($retardataires as $r) {
			$l=$lien . $r['cookie'];
			$r['info']=$r['infos'];
			$m=Pet_remplir_info($p,$message,$l,$r);
			$m=stripslashes(preg_replace("/#DATE/",$r['date'],$m));
			$sujet	= "[REPOST] " . $L['Demande_Confirmation'] . ": signature de la pétition '".$infosPetition['titre']["fr_FR"]."'";

			if ($_POST['essai'] == 'oui') {
				echo "<p>To: ".$r['courriel']."<br>
	  Subject: $sujet<br>
      From: $robot<br>".
      nl2br($m)."<hr></p>";
			} else {
				if (!Pet_EnvoyerCourrier($r['courriel'], $robot, $sujet,$m))
					die("Y a un bleme");
				$qq="UPDATE ${prefixe}signatures SET relance=1 WHERE ide='".$r['ide']."'";
				$z=mysql_query($qq) or die("relance::$qq:".mysql_error());
				if ( ($o++ % 5) == 0)
					echo ".";
				}
			}
		}
	else {
		echo $L['Relance'];			// modif FS : relance/rappel !!!
		echo "<p>
  <form method='post'>
   <center>
    <p>
     <table>
      <tr>
       <td>Test: <input type='checkbox' name='essai' value='oui'></td>
       <td> nombre de jours de retard: &nbsp;
         <input type='text' name='nbj' value='".$_POST['nbj']."' size='3'></td>
      </tr>
     </table>
    </p><br />
    <textarea cols='60' rows='10' name='message'>".$_POST['message']."</textarea>
    </p><p>
    <input type='submit' name='go' value='".$L['Bouton_Envoyer']."'>
    <input type='hidden' name='action' value='relance'>
    <input type='hidden' name='petition' value='$p'>
   </center>
  </form>\n";
	}
	Pet_finHtml();
}


function Pet_a1ami($petition) {
	global $L,$infosPetition;

	if ($_POST['bouton'] == $L['Bouton_Envoyer']) {
		if (Pet_AdresseValide(trim($_POST['to']))) {
		//	$headers="from: ".$infosPetition['robot']."\r\nX-PETITION: ".$infosPetition['nom']."\r\n\r\n";
		// TODO : protéger $to d'une tentative de hacker les entêtes
			$msg  = $L['BonjourC'].$_POST['from']."\n\n";
			$msg .= $L['IntroMsgA1Ami']."\n-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-";
			$msg .= "\n".$infosPetition['titre'];
			$msg .= "\n".$infosPetition['sous_titre'];
			$msg .= "\n".$infosPetition['texte'];
			echo "on envoi a : $to<br>";
			Pet_EnvoyerCourrier($to,$infosPetition['robot'],$L['SujetA1Ami'],$msg);
		}
		else {
			echo $L['Adresse_Invalide'];
			exit;
		}
	}
	else
		Pet_affichePetitionPage($petition,'a1ami.html');
	exit;
}

function Pet_avis($sign='') {
	global $L,$infosPetition;

	$sujet   = "Nouvelle signature";
	$msg     = "Prénom Nom : " . $sign['prenom'] . " " . $sign['nom'] . "\n";
	$msg    .= "infos : " .$sign['info'] . "\n";
	$msg    .= "mèl : " .$sign['courriel'] . " Ip: " . $sign['ip'] . "\n";
	$de      = $a    = $infosPetition['robot'];
	Pet_EnvoyerCourrier($a,$de,$sujet,$msg);
}


# vim: ts=4 ai
