<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/*                                                                      */
/* NPDS Copyright (c) 2002-2017 by Philippe Brunier                     */
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
/* Changement de nom du module version Rev16 par jpb/phr janv 2017      */
/************************************************************************/

/*Debut Securite*/
   if (!stristr($_SERVER['PHP_SELF'],"modules.php")) die();
   if (strstr($ModPath,'..') || strstr($ModStart,'..') || stristr($ModPath,'script') || stristr($ModPath, 'cookie') || stristr($ModPath, 'iframe') || stristr($ModPath, 'applet') || stristr($ModPath, 'object') || stristr($ModPath, 'meta') || stristr($ModStart, 'script') || stristr($ModStart, 'cookie') || stristr($ModStart, 'iframe') || stristr($ModStart, 'applet') || stristr($ModStart, 'object') || stristr($ModStart, 'meta'))
      die();
/*Fin Securite*/

   $mNom = 'Outil de préparation image initialement au format jpg';
   $selection='';
   $messagefjpg='';
   $extensionfichier='xyz';
   $quidam = getusrinfo($user);
   //on définit le répertoire dans lequel on souhaite travailler
   $dossier_traite = 'modules/'.$ModPath.'/images';
   $repertoire = opendir($dossier_traite);

   include ('header.php');
   include ("modules/$ModPath/lang/annonces-$language.php");
   if (autorisation(1)) {
      echo '
   <div class="card">
      <div class="card-body"><h4 class="card-title">'.ann_translate("$mNom").'</h4>';

   //on lit chaque fichier du répertoire dans la boucle
   while (false !== ($fichier = readdir($repertoire))) {
   //on définit le chemin du fichier à effacer
   $chemin = $dossier_traite.'/'.$fichier;
   //si le fichier n'est pas un répertoire
      if ($fichier != ".." AND $fichier != "." AND !is_dir($fichier) AND strstr($fichier,"$quidam[uname]_")) {
         unlink($chemin); //on efface
      }
   }
   closedir($repertoire);
   settype($monfichier,'string');
   $extensionsautorisees = array("jpeg", "jpg", "JPG", "JPEG");
   if (!empty($_FILES['monfichier']['name'])) $nomorigine = $_FILES['monfichier']['name'];
   if (empty($_FILES['monfichier']['name'])) {
      $selection = '<p class="card-text lead">'.ann_translate("Sélectionner sur votre ordinateur le fichier image .jpg à redimensionner").' <i>(3000 Ko max)</i></p>';
   }
   echo '
      </div>
      <div class="card-block">';
   if (!empty($_FILES['monfichier']['name'])) 
      $elementschemin = pathinfo($nomorigine);
   if (!empty($_FILES['monfichier']['name'])) 
      $extensionfichier = $elementschemin['extension'];
   if (!(in_array($extensionfichier, $extensionsautorisees))) {
      $messagefjpg = '
         <p class="text-danger"><i class="fa fa-info-circle" aria-hidden="true"></i> '.ann_translate("Le fichier doit être impérativement une image au format jpg").'</p>';
   }
   else {
   // Copie dans le repertoire du script avec un nom incluant l'heure à la seconde près
      $repertoiredestination = dirname(__FILE__)."/images/";
      $nomdestination = $quidam['uname']."_original.jpg";
      if (move_uploaded_file($_FILES["monfichier"]["tmp_name"],$repertoiredestination.$nomdestination)) {
         echo '
         <p class="lead text-info"><i class="fa fa-info-circle" aria-hidden="true"></i> '.ann_translate("L'opération s'est bien passée").'</p>';
      }
      else {
         echo '
         <p class="lead text-danger">'.ann_translate("Le fichier n'a pas été uploadé, trop volumineux").'</p>';
      }
   }

   //fonction de redimensionnement de l'image
   $img_src = "modules/$ModPath/images/".$quidam['uname']."_original.jpg";
   $img_dest = "modules/$ModPath/images/".$quidam['uname']."_".mktime().".jpg";
   settype($choix,'string');
   if ($choix =="Mini") {
      $dst_w = 400;
      $dst_h = 300;
   }
   elseif ($choix =="Normal") {
      $dst_w = 600;
      $dst_h = 450;
   }
   elseif ($choix =="Maxi") {
      $dst_w = 900;
      $dst_h = 675;
   }
   function redim_image($img_src, $img_dest, $dst_w, $dst_h) {

// récupération de la taille
   $size = @getimagesize($img_src);
   $src_w = $size[0];
   $src_h = $size[1];

// redimensionnement de l'image (garde le ratio)
   if($src_w < $dst_w & $src_h < $dst_h) {
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
            <select class="custom-select" name="choix" id="choix">
               <option>Maxi</option>
               <option selected>Normal</option>
               <option>Mini</option>
            </select>
            <p class="form-text">
               <ul class="text-muted list-unstyled">
                  <li>'.ann_translate("Maxi = largeur 900 pixels").'</li>
                  <li>'.ann_translate("Normal = largeur 600 pixels").'</li>
                  <li>'.ann_translate("Mini = largeur 400 pixels").'</li>
               </ul>
            </p>
         </fieldset>
         <fieldset class="form-group">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> '.ann_translate("Redimensionner").'</button>
         </fieldset>
      </form>';
   if(file_exists('modules/'.$ModPath.'/images/'.$quidam['uname'].'_original.jpg')) {
      redim_image($img_src, $img_dest, $dst_w, $dst_h);
      echo '
      <p><img src='.$img_dest.' alt="" class="img-fluid" /></p>
      <div class="alert alert-info">
         <p>'.ann_translate("Clic droit sur l'image puis enregistrer l'image sous").'...<br />'.ann_translate("Enregistrer sur votre bureau sans changer le nom du fichier qui est spécialement codifié").'.</p>
         <p>'.ann_translate("Retournez sur la page de saisie de votre annonce").'.</p>
         <p>'.ann_translate("Placer ensuite le curseur à l'endroit où vous voulez mettre la photo puis cliquer sur l'icone téléchargement").' <img src="editeur/tinymce/plugins/npds/images/npds_upload.png" width="20px" /> '.ann_translate("une fenêtre s'ouvrira où vous sélectionnerez le fichier photo préparée puis cliquez sur le bouton joindre").'.</p><p><a class="btn btn-outline-primary btn-sm" href="modules.php?ModPath='.$ModPath.'&ModStart=annonce_form">'.ann_translate("Retour P.A").'</a></p>
      </div>';
   }
   echo '
      </div>
   </div>';
   }
   else {
      redirect_url("index.php");
   }
   include ('footer.php');
?>