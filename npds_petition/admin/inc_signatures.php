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

/* admin/inc_signaures.php : 		Gestion des signatures			*/

#function menuSignatures($petition)
#function ajouterSignatures($petition)
#function voirSignatures($p)
#function delSignatures($petition)

function menuSignatures($petition){
	global $L,$infosPetition,$variables;

	$n=$infosPetition['nom'];
	$up="<a href='../index.php'>".$L['T_Petition']."</a> / <a href='index.php'>";
	$up .= $L['T_Administration']."</a> / ". $L['Gerer'];
	$n = ($n=$variables['papier_'.$infosPetition['nom']]) ? $n : 0 ;
	
	Pet_debutHtml($L['Titre_Signatures'].$infosPetition['nom'],$up);
	
	echo "
  <center>
  <form name=ajoutPapier method=post>
   <b>Il y a $n signatures papier</b><br>
". $L['NombrePapier'] . " <input name=nombre>
   <input type=submit name=ajout value='+'><br>
  </form>
  <br><hr width=50%><br>
  </center>
  <form action='index.php?petition=$petition&action=signatures' method='POST'>
   <table width='100%'><tr>
    <td width='15%'></td>
    <td><div align='justify' style='font-size: smaller'>".$L['Gestion']."</td>
    <td width='15%'></td>
   </tr></table>
   <br /><br />
   <center>
   <font size='+1'><b>".$L['Signatures']."</b></font><br />
   <textarea name='signatures' cols=50 rows=15></textarea>
   <br /><br>
   <input type='hidden' name='petition' value='$petition'>
   <table width='100%' align='center'><tr align='center'>
    <td width='15%'></td>
    <td align='center'><input type='Submit' name='action2' value='".$L['Bouton_Ajouter']."'></td>
    <td align='center'><input type='image' name='action2' value='voir' src='images/imprimer.png'></td>
    <td align='center'><input type='Submit' name='action2' value='".$L['Bouton_Supprimer']."'></td>
    <td width='15%'></td>
   </table>
   </center>
   </div>
  </form>
 ";

	Pet_admin_finHtml();
}

function ajouterSignatures($petition){
	global $L,$infosPetition;
	$n=$infosPetition['nom'];
	$sigs=$_POST['signatures'];
	$ajouts=array(); $rejects=array();
	$up="<a href='../index.php'>".$L['Petition']."</a> / <a href='index.php'>";
	$up .= $L['Administration']."</a> / ".$L['Gerer'];

	Pet_debutHtml($L['Titre_Ajout'].$infosPetition['nom'],$up);
	$s=explode("\n",$sigs);
	foreach ($s as $r){
		$ajout++;
		$o->nom=$o->prenom=$o->info=$o->courriel=$o->niveau='';
		list($o->prenom,$o->nom,$o->info,$o->n,$o->courriel)=explode(':',$r);
		$o->niveau = ($o->n) ? 1 : 0;
		if ($o->nom != '')
			if (insertSignature($petition,$o->nom,$o->prenom,$o->info,$o->courriel,$o->niveau))
					array_push($ajouts,"[$ajout] $o->nom, $o->prenom, $o->info, $o->courriel");
            else array_push($rejects,"[$ajout] $o->nom, $o->prenom, $o->info, $o->courriel");
        else array_push($rejects,"[$ajout] $o->nom, $o->prenom, $o->info, $o->courriel");
	}
	echo "\n<p>".$L['signaturesAjoutees']."
  <br />";
		foreach ($ajouts as $a)
			echo "$a<br />";
		echo "</p>".$L['signaturesRejetees']."
  <br />";
		foreach ($rejects as $r)
			echo "$r<br />";
		Pet_admin_finHtml();
}

function voirSignatures($p){
 global $L,$infosPetition;

 if ($_POST['exporter']==$L['Exporter'])
  ExporterSignatures($p);
 else {
  $up="<a href='../index.php'>".$L['T_Petition']."</a> / <a href='index.php'>";
  $up .= $L['T_Administration']."</a> / <a href='index.php?action=signatures&petition=$p'>";
  $up .= $L['T_Signatures']."</a> / ".$L['T_LSignatures'];
  Pet_debutHtml($L['Titre_VoirSignature'].$infosPetition['nom']."&raquo;","$up");
  echo adm_ListeSignatures($p);
  echo "<p><br /></p>";
  echo "<form method='post'>
   <input type='hidden' name='action2_x' value='2'>
   <input type='Submit' name='exporter' value='".$L['Exporter']."'>
   </form>";
  Pet_admin_finHtml();
 }
}

function delSignatures($petition) {
 global $L,$infosPetition;
 $n=$infosPetition['nom'];
 $sigs=$_POST['signatures'];
 $retraits=array(); $rejects=array();
 $up="<a href='../index.php'>".$L['T_Petition']."</a> / <a href='index.php'>";
 $up .= $L['T_Administration']."</a> / ".$L['T_Signatures']; 

 Pet_debutHtml($L['Titre_Retrait'].$infosPetition['nom'],$up);
 $s=explode("\n",$sigs);
 foreach ($s as $r){
  $retrait++;
  $nom=$prenom=$info=$courriel=$niveau='';
  list($nom,$prenom,$info,$courriel,$niveau)=explode(':',$r);
  //echo "nom: $nom, prenom: $prenom, info: $info, courriel: $courriel niveau:$niveau<br>";
  if ($nom != '' && $prenom != '')
   if (enleveSignature($petition,$nom,$prenom,$info,$courriel,$niveau))
    array_push($retraits,"[$retrait] $nom, $prenom, $info, $courriel");
   else array_push($rejects,"[$retrait] $nom, $prenom, $info, $courriel");
  else array_push($rejects,"[$retrait] $nom, $prenom, $info, $courriel");
 }
 echo "\n<p>".$L['signaturesRetires']."
  <br />";
  foreach ($retraits as $a)
   echo "$a<br />";
  echo "</p>".$L['signaturesRejetees']."
  <br />";
  foreach ($rejects as $r)
   echo "$r<br />";
 Pet_admin_finHtml();
}

# vim: ts=4 ai
?>
