<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/* ===========================                                          */
/*                                                                      */
/* monmodule : moi 2016                                                 */
/*                                                                      */
/* NPDS Copyright (c) 2002-2017 by Philippe Brunier                     */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

function ann_translate($phrase) {
 switch ($phrase) {
   case "Français" : $tmp = "Liste der Sessions"; break;
   case "Anglais" : $tmp = "Name"; break;
   case "Allemand" : $tmp = "@IP"; break;
   case "Espagnol" : $tmp = "entschlossen @IP"; break;
   case "Chinois" : $tmp = "entschlossen @IP"; break;
   case "à" : $tmp = "to"; break;
   case "Admin P.A" : $tmp = "管理员"; break;
   case "Administration des catégories et sous-catégories" : $tmp = "类别和子类别的管理"; break;
   case "Ajouter ou modifier une catégorie": $tmp = "添加或编辑类别"; break;
   case "Ajouter une annonce" : $tmp = "公告栏"; break;
   case "Ajouter une catégorie" : $tmp = "添加类别"; break;
   case "Ajouter une sous-catégorie dans" : $tmp = "添加子类别"; break;
   case "Annonce de" : $tmp = "公告"; break;
   case "Annonce" : $tmp = "广告"; break;
   case "annonce(s) à valider" : $tmp = "广告来验证"; break;
   case "annonce(s) en ligne" : $tmp = "在线广告"; break;
   case "annonce(s)" : $tmp = "广告"; break;
   case "Annonces à valider" : $tmp = "即将投放的广告"; break;
   case "Annonces archivées" : $tmp = "封存广告"; break;
   case "Annonces en ligne" : $tmp = "在线广告"; break;
   case "Annonces(s)" : $tmp = "通告"; break;
   case "Arborescense en ligne" : $tmp = "树形结构的在线"; break;
   case "Autres" : $tmp = "其他"; break;
   case "Catégorie" : $tmp = "类别"; break;
   case "Clic droit sur l'image puis enregistrer l'image sous": $tmp = "右键点击图片并保存图像"; break;
   case "Cliquer pour administrer": $tmp = "点击管理"; break; 
   case "Cliquer pour déplier" : $tmp = "点击展开"; break;
   case "Cliquer pour visualiser" : $tmp = "点击查看"; break;
   case "Code postal" : $tmp = "拉链"; break;
   case "Email" : $tmp = "电子邮件"; break;
   case "en attente de validation" : $tmp = "等待验证"; break;
   case "En ligne" : $tmp = "在线"; break;
   case "Enregistrer sur votre bureau sans changer le nom du fichier qui est spécialement codifié": $tmp = "在桌面上保存而不改变其特殊编码的文件名"; break;
   case "et" : $tmp = "和"; break;
   case "Fermer" : $tmp = "关闭"; break;
   case "Gérer P.A" : $tmp = "管理广告"; break;
   case "Gestion de vos annonces" : $tmp = "管理您的广告"; break;
   case "Il y a" : $tmp = "前"; break;
   case "Instructions": $tmp = "说明"; break;
   case "Le fichier doit être impérativement une image au format jpg": $tmp = "该文件必须是jpg图像"; break;
   case "Libellé de l'annonce" : $tmp = "标签广告"; break;
   case "L'opération s'est bien passée": $tmp = "操作顺利"; break;
   case "Maxi = largeur 900 pixels": $tmp = "=最大宽度900个像素"; break;
   case "Mentions légales des conditions d'utilisation des petites annonces" : $tmp = "利用广告的法律条款"; break;
   case "Mentions légales" : $tmp = "版本说明"; break;
   case "Mini = largeur 400 pixels": $tmp = "最小宽度= 400个像素"; break;
   case "Mode d'emploi" : $tmp = "说明"; break;
   case "Modifier" : $tmp = "变化"; break;
   case "Nom" : $tmp = "名"; break;
   case "Normal = largeur 600 pixels": $tmp = "正常= 600个像素宽"; break;
   case "Outil de préparation image initialement au format jpg" : $tmp = "图片准备工具最初JPG"; break;
   case "Outil" : $tmp = "工具"; break;
   case "P.A en ligne": $tmp = "网上小广告"; break;
   case "Passer P.A" : $tmp = "跳过广告"; break;
   case "Placer ensuite le curseur à l'endroit où vous voulez mettre la photo puis cliquer sur l'icone téléchargement": $tmp = "然后把你想要把照片中的指针，点击下载图标"; break;
   case "Pour passer ou gérer vos annonces vous devez être membre inscrit connecté" : $tmp = "要更改或管理您的广告，你必须注册登录"; break;
   case "Pour préparer une image" : $tmp = "为了准备图像"; break;
   case "Précédente" : $tmp = "前"; break;
   case "Prix en" : $tmp = "价格"; break;
   case "Prix" : $tmp = "价格"; break;
   case "publiée(s)" : $tmp = "发表"; break;
   case "Rechercher dans les annonces" : $tmp = "搜索广告"; break;
   case "Redimensionner": $tmp = "调整"; break;
   case "Retour P.A": $tmp = "返回广告"; break;
   case "Retour" : $tmp = "回报"; break;
   case "Retournez sur la page de saisie de votre annonce": $tmp = "把你的广告条目页面上"; break;
   case "sans" : $tmp = "无"; break;
   case "Sélectionner sur votre ordinateur le fichier image .jpg à redimensionner": $tmp = "选择您的电脑.JPG图像文件来调整"; break;
   case "Soumettre" : $tmp = "提交"; break;
   case "Sous-catégorie" : $tmp = "子目录"; break;
   case "Suivante" : $tmp = "下"; break;
   case "Supprimer" : $tmp = "清除"; break;
   case "Tél fixe" : $tmp = "固定电话"; break;
   case "Tél portable" : $tmp = "手机"; break;
   case "une fenêtre s'ouvrira où vous sélectionnerez le fichier photo préparée puis cliquez sur le bouton joindre": $tmp = "将打开一个窗口，你选择准备好的图片文件，然后点击加入按钮"; break;
   case "Valider" : $tmp = "验证"; break;
   case "Ville" : $tmp = "城市"; break;
   case "vous avez" : $tmp = "您"; break;

   default: $tmp = "需要翻译稿 [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>