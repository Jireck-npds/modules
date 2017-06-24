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
/* module photosize version 2.2                                         */
/* photosize.php file 2009/2017                                         */
/* version rev16 jpb et phr                                             */
/*                                                                      */
/************************************************************************/

function phot_translate($phrase) {
 switch ($phrase) {
   case "Français" : $tmp = "Liste der Sessions"; break;
   case "Anglais" : $tmp = "Name"; break;
   case "Allemand" : $tmp = "@IP"; break;
   case "Espagnol" : $tmp = "entschlossen @IP"; break;
   case "Chinois" : $tmp = "entschlossen @IP"; break;
   case "Clic droit sur l'image puis enregistrer l'image sous": $tmp = "右键点击图片并保存图像"; break;
   case "Enregistrer sur votre bureau sans changer le nom du fichier qui est spécialement codifié": $tmp = "在桌面上保存而不改变其特殊编码的文件名"; break;
   case "Le fichier doit être impérativement une image au format jpg": $tmp = "该文件必须是jpg图像"; break;
   case "L'opération s'est bien passée": $tmp = "操作顺利"; break;
   case "Maxi = largeur 900 pixels": $tmp = "=最大宽度900个像素"; break;
   case "Mini = largeur 400 pixels": $tmp = "最小宽度=400个像素"; break;
   case "Normal = largeur 600 pixels": $tmp = "正常=600个像素宽"; break;
   case "Outil de préparation image initialement au format jpg" : $tmp = "图片准备工具最初JPG"; break;
   case "Placer ensuite le curseur à l'endroit où vous voulez mettre la photo puis cliquer sur l'icone téléchargement": $tmp = "然后把你想要把照片中的指针，点击下载图标"; break;
   case "Redimensionner": $tmp = "调整"; break;
   case "Retournez sur la page de saisie de votre publication": $tmp = "打开您的出版物的进入页面"; break;
   case "Sélectionner sur votre ordinateur le fichier image .jpg à redimensionner": $tmp = "选择您的电脑.JPG图像文件来调整"; break;
   case "une fenêtre s'ouvrira où vous sélectionnerez le fichier photo préparée puis cliquez sur le bouton joindre": $tmp = "将打开一个窗口，你选择准备好的图片文件，然后点击加入按钮"; break;
   default: $tmp = "需要翻译稿 [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>