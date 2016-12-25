<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/* ===========================                                          */
/*                                                                      */
/*                                                                      */
/*                                                                      */
/* NPDS Copyright (c) 2002-2011 by Philippe Brunier                     */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* module photosize version 2.1                                         */
/* photosize.php file 2009/2011                                         */
/* jpb et phr                                                           */
/*                                                                      */
/************************************************************************/

/*Debut Securite*/
	if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
	if (strstr($ModPath,'..') || strstr($ModStart,'..') || stristr($ModPath,'script') || stristr($ModPath, 'cookie') || stristr($ModPath, 'iframe') || stristr($ModPath, 'applet') || stristr($ModPath, 'object') || stristr($ModPath, 'meta') || stristr($ModStart, 'script') || stristr($ModStart, 'cookie') || stristr($ModStart, 'iframe') || stristr($ModStart, 'applet') || stristr($ModStart, 'object') || stristr($ModStart, 'meta'))
	{
	die();
	}
/*Fin Securite*/

if (file_exists('modules/'.$ModPath.'/admin/pages.php')) {
	include ('modules/'.$ModPath.'/admin/pages.php');
}

	$mNom = "Outil automatique pour redimensionner une photo initialement au format jpg";
	$quidam = getusrinfo($user);
	$ModPath = photosize;
	$dossier_traite = "modules/photosize/images";
	$repertoire = opendir($dossier_traite); //on d�finit le r�pertoire dans lequel on souhaite travailler

	include ('header.php');

	echo '<h2>'.$mNom.'</h2>';
	while (false !== ($fichier = readdir($repertoire))) //on lit chaque fichier du r�pertoire dans la boucle
	{
	$chemin = $dossier_traite."/".$fichier; //on d�finit le chemin du fichier � effacer
 
//si le fichier n'est pas un r�pertoire
	if ($fichier != ".." AND $fichier != "." AND !is_dir($fichier) AND strstr($fichier,"$quidam[uname]_"))
	{
	unlink($chemin); //on efface
	}
	}
	closedir;
	$nomorigine = $_FILES['monfichier']['name'];
	if (empty($_FILES['monfichier']['name']))
	{
	echo '<h5>S&eacute;lectionner sur votre ordinateur le fichier image .jpg &agrave; redimensionner <i>(3000 Ko max.)</i></h5>';
	}
	$elementschemin = pathinfo($nomorigine);
	$extensionfichier = $elementschemin['extension'];
	$extensionsautorisees = array("jpeg", "jpg", "JPG", "JPEG");
	if (!(in_array($extensionfichier, $extensionsautorisees))) 
	{
	echo '<p align="center" class="rouge">Le fichier doit &ecirc;tre imp&eacute;rativement une image au format jpg</p>';
	}
	else //si c'est bon
	{
// Copie dans le repertoire du script avec un nom
// incluant l'heure � la seconde pr�s 
	$repertoiredestination = dirname(__FILE__)."/images/";
	$nomdestination = $quidam[uname]."_original.jpg";
	if (move_uploaded_file($_FILES["monfichier"]["tmp_name"],$repertoiredestination.$nomdestination))
	{
	echo '<p align="center" class="rouge">L\'op&eacute;ration s\'est bien pass&eacute;e</p>';
	}
	else
	{
	echo '<p align="center" class="rouge">Le fichier n\'a pas &eacute;t&eacute; upload&eacute;, trop volumineux</p>';
	}
	}
//fonction de redimensionnement de l'image
	$img_src = "modules/$ModPath/images/".$quidam[uname]."_original.jpg";
	$img_dest = "modules/$ModPath/images/".$quidam[uname]."_".mktime().".jpg";
	if ($choix =="Mini deux photos cote � cote")
	{
	$dst_w = 250;
	$dst_h = 188;
	}
	elseif ($choix =="Normal")
	{
	$dst_w = 400;
	$dst_h = 300;
	}
	elseif ($choix =="Calibrage sp�cial albums Blog")
	{
	$dst_w = 567;
	$dst_h = 425;
	}
	elseif ($choix =="Avatar")
	{
	$dst_w = 100;
	$dst_h = 100;
	}
	function redim_image($img_src, $img_dest, $dst_w, $dst_h)
	{
// r�cup�ration de la taille
	$size = @getimagesize($img_src);
	$src_w = $size[0];
	$src_h = $size[1];
 
// redimensionnement de l'image (garde le ratio)   
	if($src_w < $dst_w & $src_h < $dst_h)
	{
	$dst_w = $src_w;
	$dst_h = $src_h;
	}
	else
	@$dst_h = round(($dst_w / $src_w) * $src_h);
	@$dst_w = round(($dst_h / $src_h) * $src_w);
	$dst_img = imagecreatetruecolor($dst_w, $dst_h);
	$src_img = imagecreatefromjpeg($img_src);
// cr�e la copie redimensionn�e
	imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

//ajout pour le markermark du 17 mars 2011 avec une photo, vous pouvez choisir ce que vous voulez en commentant la partie non utilis�e
	if ($dst_w >= 250) {
/*
//ajout pour le markermark du 17 mars 2011 avec du texte

$stamp = imagecreatetruecolor(85, 15);
$marge_right = 5;
$marge_bottom = 5;
$sx = imagesx($stamp);
$sy = imagesy($stamp);

imagestring($stamp, 1, 5, 3, 'infocapagde.com', 0xFFFFFF);

imagecopymerge($dst_img, $stamp, imagesx($dst_img) - $sx - $marge_right, imagesy($dst_img) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 60);

//fin ajout

*/
	$stamp = imagecreatefrompng("modules/photosize/wm.png");
	$marge_right = 5;
	$marge_bottom = 5;
	$sx = imagesx($stamp);
	$sy = imagesy($stamp);
	imagecopymerge($dst_img, $stamp, imagesx($dst_img) - $sx - $marge_right, imagesy($dst_img) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 70);
	}
imagejpeg($dst_img, $img_dest);	
//fin ajout

// --> jpg

// destruction des images temporaires
	imagedestroy($dst_img);
	imagedestroy($src_img);
	}
/*	echo '<form class="form-horizontal" enctype="multipart/form-data" action="modules.php?ModPath=photosize&amp;ModStart=photosize" method="post">'
	.'<div class="form-group">'
	.'<input type="hidden" name="max_file_size" value="4000000" />'
	.'<input type="file" name="monfichier" />'
	.'<div class="col-sm-3"><select class="form-control" name="choix" id="choix">'
	.'<option>Normal</option>'
	.'<option>Mini deux photos cote &agrave; cote</option>'
	.'<option>Avatar</option>'
	.'<option>Calibrage sp&eacute;cial albums Blog</option>'
	.'</select></div>'
	.'<div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-primary">Redimensionner la photo</button></div>'
	.'</div>'
	.'</form>';*/
	
 echo '<div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <div class="col-sm-10">
									<input type="hidden" name="max_file_size" value="4000000" />
									<input type="file" name="monfichier" />
                                </div>
                            </div>
                            <div class="form-group">
								<div class="col-sm-3"><select class="form-control" name="choix" id="choix">
									<option>Normal</option>
									<option>Mini deux photos cote &agrave; cote</option>
									<option>Avatar</option>
									<option>Calibrage sp&eacute;cial albums Blog</option>
									</select></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Redimensionner la photo</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';	
	
	
	
	
	
	
	
	echo '<p align="center">Choisir <b>Normal</b> pour une photo illustrant article<br />Choisir <b>Mini</b> pour mettre dans un tableau deux images cote &agrave; cote ou quatre images en carr&eacute;.<br />Choisir <b>Avatar</b> pour calibrer la photo de votre Avatar dans votre profil</p>';
	if(file_exists('modules/photosize/images/'.$quidam[uname].'_original.jpg'))
	{
	redim_image($img_src, $img_dest, $dst_w, $dst_h);
	echo '<p align="center"><img src='.$img_dest.' alt="" align="middle" /></p>'
	.'<p align="center">Une fois l\'image affich&eacute;e, il vous faut faire un clic droit sur l\'image puis Enregistrer la photo sous...<br />'
	.'Il est conseill&eacute; de l\'enregistrer sur votre bureau sans changer le nom du fichier<br />'
	.'Vous la transf&eacute;rez dans Infocapagde sans changer le nom du fichier qui est sp&eacute;cialement codifi&eacute;<br />'
	.'Vous la supprimez de votre bureau</p>';
	}
	echo '<p align="center"><b>R&eacute;alisation &copy; <a href="http://infocapagde.com" target="_blank">Infocapagde</a></b></p>';
//	include ('footer.php');	
?>