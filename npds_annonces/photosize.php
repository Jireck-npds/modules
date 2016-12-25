<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/*                                                                      */
/* NPDS Copyright (c) 2002-2015 by Philippe Brunier                     */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* Module npds_annonces 3.0                                             */
/*                                                                      */
/*                                                                      */
/* Basé sur gadjo_annonces v 1.2 - Adaptation 2008 par Jireck et lopez  */
/* MAJ conformité XHTML pour REvolution 10.02 par jpb/phr en mars 2010  */
/* MAJ Dev - 2011                                                       */
/* Changement de nom du module version Rev16 par jpb/phr mars 2016      */
/************************************************************************/

/*Debut Securite*/
   if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
   if (strstr($ModPath,'..') || strstr($ModStart,'..') || stristr($ModPath,'script') || stristr($ModPath, 'cookie') || stristr($ModPath, 'iframe') || stristr($ModPath, 'applet') || stristr($ModPath, 'object') || stristr($ModPath, 'meta') || stristr($ModStart, 'script') || stristr($ModStart, 'cookie') || stristr($ModStart, 'iframe') || stristr($ModStart, 'applet') || stristr($ModStart, 'object') || stristr($ModStart, 'meta'))
   {
   die();
   }
/*Fin Securite*/

   $mNom = 'Outil de préparation image initialement au format jpg';
   $quidam = getusrinfo($user);
   $dossier_traite = 'modules/'.$ModPath.'/images';
   $repertoire = opendir($dossier_traite); //on définit le répertoire dans lequel on souhaite travailler

   include ('header.php');
   echo '<div class="card">';
   echo '<div class="card-block"><h3 class="card-title">'.$mNom.'</h3>';
   while (false !== ($fichier = readdir($repertoire))) //on lit chaque fichier du répertoire dans la boucle
   {
   $chemin = $dossier_traite."/".$fichier; //on définit le chemin du fichier à effacer
//si le fichier n'est pas un répertoire
   if ($fichier != ".." AND $fichier != "." AND !is_dir($fichier) AND strstr($fichier,"$quidam[uname]_"))
   {
   unlink($chemin); //on efface
   }
   }
   closedir;
   $nomorigine = $_FILES['monfichier']['name'];
   if (empty($_FILES['monfichier']['name']))
   {
   $selection = '<p class="card-text">S&eacute;lectionner sur votre ordinateur le fichier image .jpg &agrave; redimensionner <i>(3000 Ko max.)</i></p>';
   }
   echo '</div>';
   echo '<div class="card-block">';
   $elementschemin = pathinfo($nomorigine);
   $extensionfichier = $elementschemin['extension'];
   $extensionsautorisees = array("jpeg", "jpg", "JPG", "JPEG");
   if (!(in_array($extensionfichier, $extensionsautorisees)))
   {
   $messagefjpg = '<p class="text-danger"><i class="fa fa-info-circle" aria-hidden="true"></i> Le fichier doit &ecirc;tre imp&eacute;rativement une image au format jpg</p>';
   }
   else //si c'est bon
   {
// Copie dans le repertoire du script avec un nom
// incluant l'heure à la seconde près 
   $repertoiredestination = dirname(__FILE__)."/images/";
   $nomdestination = $quidam[uname]."_original.jpg";
   if (move_uploaded_file($_FILES["monfichier"]["tmp_name"],$repertoiredestination.$nomdestination))
   {
   echo '<p class="lead text-info"><i class="fa fa-info-circle" aria-hidden="true"></i> L\'op&eacute;ration s\'est bien pass&eacute;e</p>';
   }
   else
   {
   echo '<p class="lead text-danger">Le fichier n\'a pas &eacute;t&eacute; upload&eacute;, trop volumineux</p>';
   }
   }
//fonction de redimensionnement de l'image
   $img_src = "modules/$ModPath/images/".$quidam[uname]."_original.jpg";
   $img_dest = "modules/$ModPath/images/".$quidam[uname]."_".mktime().".jpg";
   if ($choix =="Demi")
   {
   $dst_w = 400;
   $dst_h = 300;
   }
   elseif ($choix =="Normal")
   {
   $dst_w = 600;
   $dst_h = 450;
   }
   elseif ($choix =="Maxi")
   {
   $dst_w = 900;
   $dst_h = 675;
   }
   function redim_image($img_src, $img_dest, $dst_w, $dst_h)
   {
// récupération de la taille
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
// crée la copie redimensionnée
   imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

   imagejpeg($dst_img, $img_dest);

// destruction des images temporaires
   imagedestroy($dst_img);
   imagedestroy($src_img);
   }

echo '<form enctype="multipart/form-data" action="modules.php?ModPath='.$ModPath.'&amp;ModStart=photosize" method="post">
         <fieldset class="form-group">
         <label for="">'.$selection.'</label>
            <input type="hidden" name="max_file_size" value="5000000" />
            <input class="form-control" type="file" name="monfichier" />
            <p class="text-muted">'.$messagefjpg.'</p>
         </fieldset>
         <fieldset class="form-group has-success">
            <select class="form-control c-select" name="choix" id="choix">
               <option>Maxi</option>
               <option>Normal</option>
               <option>Demi</option>
            </select>
         </fieldset>
         <fieldset class="form-group">
            <button type="submit" class="btn btn-primary-outline btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Redimensionner</button>
         </fieldset>
      </form>';
   echo '<p class="lead"><i class="fa fa-info-circle" aria-hidden="true"></i> Informations</p>';
   echo '<div class="alert alert-info" role="alert"><ul class="lead">
   <li>Choix Maxi donnera une largeur d\'image de 900 pixels</li>
   <li>Choix Normal donnera une largeur d\'image de 600 pixels</li>
   <li>Choix Demi donnera une largeur d\'image de 400 pixels</li>
   </ul></div>';
   if(file_exists('modules/'.$ModPath.'/images/'.$quidam[uname].'_original.jpg'))
   {
   redim_image($img_src, $img_dest, $dst_w, $dst_h);
   echo '<p><img src='.$img_dest.' alt="" class="img-fluid" /></p>';

   echo '<p class="jumbotron">Une fois l\'image affich&eacute;e, il vous faut faire un clic droit sur l\'image puis enregistrer l\'image sous...<br />Il est conseill&eacute; de l\'enregistrer sur votre bureau sans changer le nom du fichier qui est sp&eacute;cialement cod&eacute;.<br />';
   echo 'Cette opération r&eacute;alis&eacute;e, retournez sur la page de saisie de votre annonce. <a class="btn btn-primary-outline btn-sm" href="modules.php?ModPath='.$ModPath.'&ModStart=annonce_form">Retour P.A</a><br />';

   echo 'Placer ensuite le curseur clignotant à l\'endroit o&ugrave; vous voulez mettre la photo puis cliquer sur l\'icone t&eacute;l&eacute;chargement <img src="editeur/tinymce/plugins/npds/images/npds_upload.png" width="20px" /> de l\'&eacute;diteur int&eacute;gr&eacute;, cela ouvrira une fen&ecirc;tre o&ugrave; vous pointerez vers le fichier photo pr&eacute;par&eacute; puis cliquerez sur le bouton joindre, votre photo arrivera dans l\'&eacute;diteur.</p>';
   }
   echo '</div></div>';
   include ('footer.php');
?>