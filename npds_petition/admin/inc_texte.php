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

/*	admin/inc_texte.php			toutes les fonctions sur les textes	 */


#function Pet_afficheIndex($petition,$page)			Affichage la page d'index
#function Pet_affichePetitionPage($petition,$page)	Affiche une page à partir d'un modèle
#function Pet_aff_date($date)						affichage de la date au format dd mmmm yyy (25 décembre 1990)
#function Pet_CRLFtoP_BR($t)						transforme les \n en saut de ligne ou en paragraphe
#function Pet_raccourci_typo($t)
#function Pet_tplname2html($petition,$page)
#function Pet_tpl2html($petition,$tpl)
#function Pet_remplir_info($p,$t,$l,$a)
#function Pet_propre($txt)							nettoie le texte (balise, js,...)
#function Pet_majuscules($texte) 					mettre $texte en majuscule
#function Pet_nbjours()								renvoi le nombre de jour depuis le début de l'inititaive

// affichage d'une page
// calcul de toutes les balises pétitions
function Pet_affichePage($petition,$page){
	echo Pet_tpl2html($petition,implode('',file($page)));
}

// affiche une page à partir d'un modèle
function Pet_affichePetitionPage($p,$page){
	global $L,$infosPetition;

	 if (file_exists($fichier='modele/' .$infosPetition['nom']. "/$page") ||
		 file_exists($fichier="modele/defaut/$page"))
		echo Pet_tpl2html($p,implode('',file($fichier)));
	else
		mort("affichePetitionPage :".$L['Pas_Modele']." $page",-1);
}

// affichage de la date au format dd mmmm yyy (25 décembre 1990)
function Pet_aff_date($d) {
	global $lesmois,$langue;
	
	$aTmp	= explode ('-', $d);
	$m		= $lesmois[1 * $aTmp[1] - 1]; 

	switch ($langue) {
		case 'fr_FR' : 
		case 'es_ES' : 
			return ( $aTmp[2] . " $m " . $aTmp[0]) ;
		case 'en_EN' :
			return ( "$m " . $aTmp[2] . ", " . $aTmp[0] ) ;
		default : 
			#return ( $jour." ".$lesmois[$mois]." ".$regs[1]) ;
	}
}

// transforme les doubles retour chariots en sauts de paragraphe
// et les simple en break
function Pet_CRLFtoP_BR($t) {
	$t	= preg_replace("/\r\n\r\n/",'<p>',$t);
	$t	= preg_replace("/\n\r\n\r/",'<p>',$t);
	$t	= preg_replace("/\n\n/",'<p>',$t);
	$t	= preg_replace("/\n\r/",'<br>',$t);
	$t	= preg_replace("/\r\n/",'<br>',$t);
	$t	= preg_replace("/\n/",'<br>',$t);
	return($t);
}

//
// sauvagement inspiré de la syntaxe et du code de SPIP
// www.spip.net
// Calcul les raccourcis typographiques
//
function Pet_raccourci_typo($t) {
	$t	= preg_replace("/\n- */","\n<li>",$t);
	$t	= preg_replace("/<p>- */","<p>\n<li>",$t);
	$t	= str_replace("{{{", "<h2>", $t);
	$t	= str_replace("}}}", "</h2>", $t);
	$t	= str_replace("{{", "<strong>", $t);
	$t	= str_replace("}}", "</strong>", $t);
	$t	= str_replace("{", "<i>", $t);
	$t	= str_replace("}", "</i>", $t);
	//$t	= preg_replace("!{{{(.*)}}}!","<h2>$1</h2>",$t);
	$t	= str_replace("<cadre>", "<div class='bigbox'>", $t);
	$t	= str_replace("</cadre>", "</div>", $t);
	$t	= preg_replace("/&gt;&gt;(.*)&gt;&gt;/","<div align='right'>\\1</div>",$t);
	$t	= preg_replace("/&gt;&gt;(.*)&lt;&lt;/","<div align='center'>\\1</div>",$t);
	$t	= preg_replace("/&lt;&lt;(.*)&gt;&gt;/","<div align='jutify'>\\1</div>",$t);
	$t	= preg_replace("/\[([-a-zA-Z0-9_\.]*@[-a-zA-Z0-9_\.]*)\]/","<a href=\"mailto:\\1\">\\1</a>",$t);
	$t	= preg_replace("/\[(.*)\]/","<a href='\\1'>\\1</a>",$t);
	return ($t);
}

//
// fonction remplacant les TAG #XYZ par ce qui va bien
//
function Pet_tpl2html($petition,$tpl){
	global $lesmois,$L,$infosPetition,$message_erreur,$variables,$LangueUtilisateur;

	if (file_exists($fichier='modele/' .$infosPetition['nom']. "/langue/" . $LangueUtilisateur . ".php"))
		include $fichier;
	$titre		= (!empty($infosPetition['titre'][$LangueUtilisateur]))	? stripslashes($infosPetition['titre'][$LangueUtilisateur]) 
	: stripslashes($infosPetition['titre'][$infosPetition['langue']]);
	$sous_titre	= (!empty($infosPetition['sous_titre'][$LangueUtilisateur]))	? stripslashes($infosPetition['sous_titre'][$LangueUtilisateur]) 
																				: stripslashes($infosPetition['sous_titre'][$infosPetition['langue']]);
	$texte		= (!empty($infosPetition['texte'][$LangueUtilisateur]))	? stripslashes($infosPetition['texte'][$LangueUtilisateur]) 
																		: stripslashes($infosPetition['texte'][$infosPetition['langue']]);
	$texte=Pet_CRLFtoP_BR(Pet_raccourci_typo($texte));
	$aujourdhui= date('Y-m-d');
	
	$sRet	= $tpl;
	$sRet	= (is_dir("modele/" . $infosPetition['nom'])) ? preg_replace('/#REPERTOIRE/',$infosPetition['nom'],$sRet) : preg_replace('/#REPERTOIRE/','defaut',$sRet);
	$sRet	= preg_replace('/#PETITION/',$petition,$sRet);
	$sRet	= preg_replace('/#TITRE/',$titre,$sRet);
	$sRet	= preg_replace('/#SOUS_TITRE/',$sous_titre,$sRet);
	$sRet	= preg_replace('/#TEXTE/',$texte,$sRet);
	$sRet	= preg_replace('/#IDE/',$petition,$sRet);
	$sRet	= preg_replace('/#DATE_INIT/',Pet_aff_date($infosPetition['date_init']),$sRet);
	$sRet	= preg_replace('/#DATE/',$L['Aujourdhui'] . " " . Pet_aff_date($aujourdhui),$sRet);
	$sRet	= preg_replace('/#HEURE/',date("G:i"),$sRet);
	$sRet	= preg_replace('/#DIFFDATE/',Pet_nbJours(),$sRet);
	$sRet	= preg_replace('/#IP/',$_SERVER["REMOTE_ADDR"],$sRet);
	//$sRet = preg_replace('/#MESSAGE_ERREUR/',$L[$message_erreur],$sRet);
	$sRet	= preg_replace('/#PAPIER/',$variables['papier_'.$infosPetition['nom']],$sRet);

	if (preg_match('/#LANG/',$sRet))
		$sRet = preg_replace('/#LANG/',"<form method='post'>\n" . selectionLangue(basename($page)) . "</form>\n",$sRet);

	if (preg_match('/#INITIATEURS/',$sRet))
		$sRet = preg_replace('/#INITIATEURS/',ListeSignataires($petition,1),$sRet);

	if (preg_match('/#LISTE_PETITIONS_EC/',$sRet))
		$sRet = preg_replace('/#LISTE_PETITIONS_EC/',ListePetitions("1",$LangueUtilisateur),$sRet);

	if (preg_match('/#LISTE_PETITIONS_ARCHIVE/',$sRet))
 		$sRet = preg_replace('/#LISTE_PETITIONS_ARCHIVE/',ListePetitions("2",$LangueUtilisateur),$sRet);

	if (preg_match('/#COMPTE_TOTAL/',$sRet))
 		$sRet = preg_replace('/#COMPTE_TOTAL/',NombreTotalSignatures($petition),$sRet);

	if (preg_match('/#COMPTE/',$sRet))
		$sRet = preg_replace('/#COMPTE/',NombreSignatures($petition),$sRet);

	if (preg_match('/#LIEN_PETITION/',$sRet)) {
		$url="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/?petition=".$petition;
		//$url="<a href='http://$url'>$url</a>";
		$sRet = preg_replace('/#LIEN_PETITION/',$url,$sRet);
	}

	if (preg_match('/#A1AMI/',$sRet)){
		$a1ami  = "<form method='post'>";
		$a1ami .= "<button type='submit' value='oui' title='a 1 ami' name='a1ami'>";
		$a1ami .= "<img src='admin/images/a1ami.png' border='0'></button>";
		$a1ami .= "</form>";
		$sRet = preg_replace('/#A1AMI/',$a1ami,$sRet);
	}

	if (preg_match('/#TOUS_SIGNATAIRES/',$sRet))
		$sRet = preg_replace('/#TOUS_SIGNATAIRES/',ListeSignataires($petition,-1),$sRet);

	if (preg_match('/#SIGNATAIRES8/',$sRet))
		$sRet = preg_replace('/#SIGNATAIRES8/',ListeSignataires($petition,8),$sRet);

	if (preg_match('/#SIGNATAIRES/',$sRet))
		$sRet = preg_replace('/#SIGNATAIRES/',ListeSignataires($petition,0),$sRet);

	if (preg_match('/#URLSIGNER/',$sRet)){
		if ($infosPetition['statut'] == 1) {
			$url_pour_signer="index.php?petition=$petition&signe=oui";
			$sRet = preg_replace('/#URLSIGNER/',$url_pour_signer,$sRet);
		}
		else
			$sRet = preg_replace('/#URLSIGNER/','',$sRet);
	}

	if (preg_match('/#SIGNER/',$sRet)){
		if ($infosPetition['statut'] == 1) {
			$url_pour_signer="<a href=\"index.php?petition=$petition&signe=oui\" class='signer'>".$L['Signer']."</a>";
			$sRet = preg_replace('/#SIGNER/',$url_pour_signer,$sRet);
		}
		else
			$sRet = preg_replace('/#SIGNER/','',$sRet);
	}

	if (preg_match('/#URLVOIR/',$sRet)){
		if ($infosPetition['statut']) {
			$url_pour_voir="index.php?petition=$petition&pour_voir=oui";
			$sRet = preg_replace('/#URLVOIR/',$url_pour_voir,$sRet);
		}
		else
			$sRet = preg_replace('/#URLVOIR/','',$sRet);
	}

	if (preg_match('/#VOIR/',$sRet)){
		if ($infosPetition['statut']) {
			$url_pour_voir="<a href=\"index.php?petition=$petition&pour_voir=oui\" class='voir'>".$L['Voir_Signatures']."</a>";
			$sRet = preg_replace('/#VOIR/',$url_pour_voir,$sRet);
		}
		else
			$sRet = preg_replace('/#VOIR/','',$sRet);
	}

	if (preg_match('/#SOMMAIRE/',$sRet))
			$sRet = preg_replace('/#SOMMAIRE/',"<a href='/?petition=$petition'>Sommaire</a>",$sRet);

	if (preg_match('/#ENTETES0/',$sRet)) {
	   	$enteteperso = doctype() . entetes0();
		$sRet = preg_replace('/#ENTETES0/',$enteteperso,$sRet);
	}
	if (preg_match('/#ENTETES1/',$sRet)) {
	   	$enteteperso = entetes1();
		$sRet = preg_replace('/#ENTETES1/',$enteteperso,$sRet);
	}
	if (preg_match('/#ENTETES2/',$sRet)) {
	   	$enteteperso = entetes2();
		$sRet = preg_replace('/#ENTETES2/',$enteteperso,$sRet);
	}

// texte internationalisé
// chaque balise <:aaa:> est remplacée par $L['aaa'], si elle existe, sinon elle est bouffée
	while (preg_match("/#:(([a-z0-9_]+):)?#/i", $sRet,$regs))
		$sRet = preg_replace("/$regs[0]/",$L[$regs[2]],$sRet);

// balise personnalisées :
// une balise #AAA appelle une fonction aaa() définie dans options.php
	if (preg_match("/#[A-Z]*/",$sRet,$regs)) {
		foreach ($regs as $reg) {
			$fonction = substr(strtolower($reg),1);
			if (function_exists($fonction)) $sRet = $fonction($sRet);
		}
	}

	return html_entity_decode(stripslashes($sRet));
}

// pour préparer un mail
// $t est le texte balisé
// $l est le lien cliquable pour la confirmation
// il faudrait analyser le charset et vériffier les entêtes nécessaires
function Pet_remplir_info($p,$t,$l,$a){
	global $L,$infosPetition;
	
	$nom	= trim(Pet_propre($a['nom']));
	$prenom	= trim(Pet_propre($a['prenom']));
	$info	= trim(Pet_propre($a['info']));
	$mel	= trim(Pet_propre($a['courriel']));
	$titre		= (!empty($infosPetition['titre'][$LangueUtilisateur]))	? stripslashes($infosPetition['titre'][$LangueUtilisateur]) 
	: stripslashes($infosPetition['titre'][$infosPetition['langue']]);

	$sRet	= preg_replace('/#NOM/',$nom,$t);
	$sRet	= preg_replace('/#PRENOM/',$prenom,$sRet);
	$sRet	= preg_replace('/#COURRIEL/',$mel,$sRet);
	$sRet	= preg_replace('/#INFOS/',$info,$sRet);
	$sRet	= preg_replace('/#LIEN/',$l,$sRet);
	$sRet	= preg_replace('/#TITRE/',$titre,$sRet);
	return(Pet_tpl2html($p,$sRet));
}

// SECURITE !!!!
// suppression sauvage des tag hteumeuleu,
// addslashes
function Pet_propre($txt) {
	$sRet = preg_replace("/<[^>]*>/",'',$txt);
	return addslashes($sRet);
}


//sauvagement inspire des filtre de spip ;~}

// mes en majuscule htmlisées tous les caractères, même acentués
function Pet_majuscules($s='') {
    $s=utf8_decode($s);
    $from= utf8_decode("äâàáåãéèëêòóôõöøìíîïùúûüýñçþÿæœðø");
    $to=utf8_decode("ÄÂÀÁÅÃÉÈËÊÒÓÔÕÖØÌÍÎÏÙÚÛÜÝÑÇÞÝÆŒÐØ");
    return  utf8_encode(strtoupper(strtr($s, $from, $to)));
}

function Pet_nbjours(){
	$d1="2005-04-04";
	$u1=strtotime($d1);
	$u2=strtotime("now");
	return "".round(($u2 -$u1)/ (60*60*24));
}

# vim: ts=4 ai
?>
