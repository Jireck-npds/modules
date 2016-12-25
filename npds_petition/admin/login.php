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

// détruire les cookie anciens
if (glob(ROOTDIR . "/tmp/sess_*"))
	foreach (glob(ROOTDIR . "/tmp/sess_*") as $cookie)
		if ((time() - filectime($cookie)) >= 1800 )
			unlink($cookie);

include_once 'inc_sql.php';

if (! isset($_SESSION['petition_login'])) {
	if (! ($_POST['Bouton']==$L['Bouton_Connecter'])) {
		LireLogin();
		exit();
	} else {
		if (testLogin($login=$_POST['login'],$password=$_POST['password'])) {
			$_SESSION['petition_login']	= $login;
			$_SESSION['petition_langue']	= $_POST['LangueUtilisateur'];
			EcrireJournal("connection de $login");
			header('Location: index.php');
			exit();
		} else {
			LireLogin();
			exit();
		}
	}
} else {		// utilisateur déjà loggé
	$login				= $_SESSION['petition_login'];
}

// verifie le login et le mot de passe dans la table petition_admin
//return true si c'est bon et false sinon
function testLogin($l,$p){
	global $prefixe, $lang;
	$q		= "select * from ${prefixe}admin where login='$l'";
	$r		= mysql_query($q) or die("test_login : " . mysql_error());
	$e		= mysql_fetch_array($r);
	if (! $e ) return false;
	$lang	= $e['lang'];
	$u		= $e['login'];$pd=$e['password'];
	$cle	= (preg_match('/^\$1\$/',$pd)) ? substr($pd,0,11) : substr($pd,0,2);
	$cpw	= crypt($p,$cle);
	#echo "mdp: $p, cle: $cle attendu: $cpw lu: $pd<br>"; 
	return ( $pd == crypt($p,$cle));
}

function LireLogin(){
	global $prefixe;
	global $L;

	$sel	= selectionLangue('','LangueUtilisateur',1);
	echo " <html>
<head>
<meta content='text/html; charset=UTF-8'
http-equiv='content-type'>
<title>".$L['Connection']."</title>
<link rel='stylesheet' href='../admin.css'>
</head>
<body>
<center><table><tr><td class='bigbox'>".$L['Connection']."</td></tr></table>
<br /><hr width='50%' align='center>
<br />
<div style='text-align: center;'>
<form action='index.php' method='POST'>
$sel
<center><table class='login'>
<tr>
<td style='vertical-align: top;'>".$L['Nom']."<br>
</td>
<td style='vertical-align: top;'><input type='text' name='login'
value=''> </td>
</tr>
<tr>
<td style='vertical-align: top;'>".$L['Password']."<br>
</td>
<td style='vertical-align: top;'><input type='password'
name='password' value=''> </td>
</tr>
</table>
<p><br />
<input type='submit' name='Bouton' value='".$L['Bouton_Connecter']."'> <br>
</center>
</form>
</div>
<br>
<br>
</body>
</html>
";

}

# vim: ts=4 ai
?>
