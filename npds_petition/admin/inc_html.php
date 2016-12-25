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

/*	admin/inc_html.php				les fonctions html		*/

#function Pet_debutHtml($t,$up,$a)
#function Pet_finHtml()						pied de page standart
#function pet_admin_finHtml()				pied de page administration
#function afficheIndex()				Affiche l'index pricipal (listes des pétitions)

function docType(){
	return "<!DOCTYPE (de la fonction DocType de inc_html) html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"  \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
}

function body($p=''){
	return "<body $p>\n";
}

function finbody(){
	return "</body>\n</html>\n";
}

function AttentionErreur($texte) {
	return "<div class=\"erreur\">".$texte."</div>\n";
}

function FaireLeTitre($texte) {
	return "<h1 class=\"letitre\">".$texte."</h1>\n";
}

function FaireLeTitre2($texte) {
	return "<h2 class=\"letitre2\">".$texte."</h2>\n";
}

function BoutonLangue($texte) {
	return "<div id=choixLangue>\n".$texte."</div>\n";
}

function FormLangue($texte) {
	return "<form method='post' id=choixLangue>\n".$texte."</form>\n";
}

function FaireLeMessage($texte,$s='') {
	return "\n<div class=\"lemessage\">" . ($s) ? $texte : printf($texte,$s) . "</div>\n\n";
}

function entetes($titre='',$repcss='',$head_entry=''){
	$sRet    = entetes0() . $titre . entetes1($repcss) . $head_entry . entetes2();
	return $sRet;
}

function entetes0(){
	$sRet    = "<html>\n";
	$sRet   .= "<head>\n";
	$sRet   .= " <title>";
	return $sRet;
}

function entetes1($repcss=''){
	$sRet   = "</title>\n";
	$sRet   .= " <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
	$sRet   .= " <link rel='stylesheet' type='text/css' href='".$repcss."admin.css'>\n";
	return $sRet;
}

function entetes2(){
	$sRet   = "</head>\n";
	return $sRet;
}

function Pet_debutHtml($t,$up){
	global $L,$lang;

	$sel	= selectionLangue();

	echo docType();
	echo entetes($t,"../");
	echo body();

	echo "<div id='admin'>
 <div class='bigbox'>$t</div>
 <br />
<!-- choix de la langue -->
 <form method='post' id='choixLangue'>
  $sel
 </form>
 <hr width='50%' align='center' />
 <br /><br>
 <table width='100%' class='box'>
 <tr>
  <td>$up</td>
  <td>&nbsp;</td>
  <td align='right'><a href='logout.php'>".$L['Deconnexion']."</a></td>
 </tr>
 </table><br /><br />
 <table width='100%'>
 <tr>
  <td width='10%'>&nbsp;</td>
  <td class='box'>\n";
}

function Pet_finHtml(){
 echo "
  </td>
  <td width='10%'>&nbsp;</td>
 </tr>
 </table>\n";
 echo finbody();
}

function Pet_admin_finHtml(){
 global $version,$sous_version;

 echo "
  </td>
  <td width='10%'>&nbsp;</td>
 </tr>
 </table>
 <br />
 <p class='footer'>
  phpPetitions &nbsp; &nbsp <font color=red>${version}-$sous_version</font>
 </div><!-- id=admin -->
</body>\n</html>";
}

// affiche l'index pricipal (listes des pétitions)
function Pet_AfficheIndex($page='modele/index.html'){
	global $db,$L;

	if (file_exists($page))
		echo Pet_tpl2html("1",implode('',file($page)));
	else {
		echo entetes0().$L['ListePetitions'].entetes1().entetes2()."\n";
		echo "<body>\n";
		echo "<p class=\"erreur\">\n".Pet_tpl2html("1",$L['Erreur_voici_fichier_manquant'])." $page\n</p>\n";
		echo "</body>\n</html>\n";
	}
}

function pasConfigure() {
	global $L;
	$selectLangue	= selectionLangue('');

	$texte = $L['PasConfigure'];

	echo docType();
	echo entetes($L['Titre'],"");
	echo body();
	echo FaireLeTitre($L['Titre']);
	echo FormLangue($selectLangue);
	echo FaireLeMessage($texte);
	echo finbody();
}

function YaPbsDroits($a) {
	global $L;
	$selectLangue	= selectionLangue('');

	$texte = "<p>" . $L['Erreur_Droits'] . "</p>\n";
	$texte .= " <ul>\n";
	foreach ($a as $dir)
	  $texte .= "  <li>$dir</li>\n";
	$texte .= " </ul>\n";
	$texte .= "<p>" . $L['Erreur_Droits2'] . "</p>\n";
	$texte .= "<form method=Post>\n";
	$texte .= " <input type=submit name=recharge value='" . $L['Recharger'] . "' onClick='window.location.reload();'>\n";
	$texte .= "</form>\n";

	echo docType();
	echo entetes("phpPetitions","../");
	echo body();
	echo FaireLeTitre($L['Titre'] . " - " . $L['T_Erreur_Droits']);
	echo FormLangue($selectLangue);
	echo FaireLeMessage($texte);
	echo finbody();
	exit (1);
}

function FaireListeMaJ($t,$a=''){
	return "<li class=\"maj\">".vsprintf($t,$a)."</li>\n";
}

function Pet_ChoixAlpha($p,$l=''){
	$url     = $_SERVER["SCRIPT_URL"];
	$sRet    = "<div id=choixlettre>";
	for ($i=1;$i<27;$i++) {
		$z       = chr(64+$i);
		$sRet   .= ($i == $lettre) ? "$z - ": "<a href='${url}?petition=$p&pour_voir=oui&lettre=$i'>$z</a> -\n ";
	}
	$sRet   .= ($lettre > 50) ? "Tous" : "<a href=${url}?petition=$p&pour_voir=oui&lettre=100'>Tous</a>\n</div>\n";
	return $sRet;
}

# vim: ts=4 ai
?>
