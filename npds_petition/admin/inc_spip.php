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

// ce fichier regroupe a peu près tout ce qui a été piqué à spip

// les constants utilisées (parfois renommées)

@define('_INC_DISTANT_VERSION_HTTP', "HTTP/1.0");
@define('_ACCESS_FILE_NAME', '.htaccess');
@define('_SPIP_CHMOD', 0777);


// et les fonction utilisées
//
// Installe ou verifie un .htaccess, y compris sa prise en compte par Apache
//
// http://doc.spip.org/@verifier_htaccess
function verifier_htaccess($rep, $force=false) {
	$htaccess = rtrim($rep,"/") . "/" . _ACCESS_FILE_NAME;
	if (((@file_exists($htaccess)) OR defined('_TEST_DIRS')) AND !$force)
		return true;
	if ($_SERVER['SERVER_ADMIN'] == 'www@nexenservices.com')
		return nexen($rep);
	if ($ht = @fopen($htaccess, "w")) {
		fputs($ht, "deny from all\n");
		fclose($ht);
		@chmod($htaccess, _SPIP_CHMOD & 0666);
		$t = rtrim($rep,"/") . "/.ok";
		if ($ht = @fopen($t, "w")) {
			@fclose($ht);
			$t = substr($t,strlen(ROOTDIR));
			$t = url_de_base() . $t;
			$ht = recuperer_lapage($t, false, 'HEAD', 0);
			// htaccess inoperant si on a recupere des entetes HTTP
			// (ignorer la reussite si connexion par fopen)
			$ht = !(isset($ht[0]) AND $ht[0]);
		}
	}
//	spip_log("Creation de $htaccess " . ($ht ? " reussie" : " manquee"));
	return $ht;
}	

// retourne l'URL en cas de 301, un tableau (entete, corps) si ok, false sinon
// si $trans est null -> on ne veut que les headers
// si $trans est une chaine, c'est un nom de fichier pour ecrire directement dedans
// http://doc.spip.org/@recuperer_lapage
function recuperer_lapage($url, $trans=false, $get='GET', $taille_max = 1048576, $datas='', $refuser_gz = false, $date_verif = '', $uri_referer = '') {
	// $copy = copier le fichier ?
	$copy = (is_string($trans) AND strlen($trans) > 5); // eviter "false" :-)

	// si on ecrit directement dans un fichier, pour ne pas manipuler
	// en memoire refuser gz
	if ($copy)
		$refuser_gz = true;

	// ouvrir la connexion et envoyer la requete et ses en-tetes
	list($f, $fopen) = init_http($get, $url, $refuser_gz, $uri_referer, $datas, _INC_DISTANT_VERSION_HTTP, $date_verif);
	if (!$f) {
		spip_log("ECHEC init_http $url");
		return false;
	}

	// Sauf en fopen, envoyer le flux d'entree
	// et recuperer les en-tetes de reponses
	if ($fopen)
		$headers = '';
	else {
		$headers = recuperer_entetes($f, $date_verif);
		if (is_numeric($headers)) {
			fclose($f);
			// Chinoisierie inexplicable pour contrer 
			// les actions liberticides de l'empire du milieu
			if ($headers) {
				spip_log("HTTP status $headers pour $url");
				return false;
			} elseif ($result = @file_get_contents($url))
			    return array('', $result);
			else return false;
		}
		if (!is_array($headers)) { // cas Location
			fclose($f);
			include_spip('inc/filtres');
			return suivre_lien($url, $headers);
		}
		$headers = join('', $headers);
	}

	if ($trans === NULL) return array($headers, '');

	// s'il faut deballer, le faire via un fichier temporaire
	// sinon la memoire explose pour les gros flux

	$gz = preg_match(",\bContent-Encoding: .*gzip,is", $headers) ?
		(_DIR_TMP.md5(uniqid(mt_rand())).'.tmp.gz') : '';
	  
#	spip_log("entete ($trans $copy $gz)\n$headers"); 
	$result = recuperer_body($f, $taille_max, $gz ? $gz : ($copy ? $trans : ''));
	fclose($f);
	if (!$result) return array($headers, $result);

	// Decompresser au besoin
	if ($gz) {
		$result = join('', gzfile($gz));
		supprimer_fichier($gz);
	}
	// Faut-il l'importer dans notre charset local ?
	if ($trans === true) {
		include_spip('inc/charsets');
		$result = transcoder_page ($result, $headers);
	}

	return array($headers, $result);
}

// Lit les entetes de reponse HTTP sur la socket $f et retourne:
// la valeur (chaine) de l'en-tete Location si on l'a trouvee
// la valeur (numerique) du statut si different de 200, notamment Not-Modified
// le tableau des entetes dans tous les autres cas

// http://doc.spip.org/@recuperer_entetes
function recuperer_entetes($f, $date_verif='')
{
	$s = @trim(fgets($f, 16384));

	if (!preg_match(',^HTTP/[0-9]+\.[0-9]+ ([0-9]+),', $s, $r)) {
		return 0;
	}
	$status = intval($r[1]);
	$headers = array();
	$not_modif = $location = false;
	while ($s = trim(fgets($f, 16384))) {
		$headers[]= $s."\n";
		preg_match(',^([^:]*): *(.*)$,i', $s, $r);
		list(,$d, $v) = $r;
		if (strtolower(trim($d)) == 'location' AND $status >= 300 AND $status < 400) {
			$location = $v;
		}
		elseif ($date_verif AND ($d == 'Last-Modified')) {
			if ($date_verif>=strtotime($v)) {
				//Cas ou la page distante n'a pas bouge depuis
				//la derniere visite
				$not_modif = true;
			}
		}
	}

	if ($location) return $location;
	if ($status != 200 or $not_modif) return $status;
	return $headers;
}
