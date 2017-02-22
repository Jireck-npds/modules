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
/* Module npds_glossaire v 3.0 pour revolution 16                       */
/* by team jpb/phr 2017                                                 */
/*                                                                      */
/* From Glossaire version 1.3 pour myPHPNuke 1.8                        */
/* Copyright © 2001, Pascal Le Boustouller                              */
/* Tribal-dolphin 2008                                                  */
/************************************************************************/

function glo_translate($phrase) {
 switch ($phrase) {
   case "Français" : $tmp = "法国"; break;
   case "Anglais" : $tmp = "英语"; break;
   case "Allemand" : $tmp = "德国"; break;
   case "Espagnol" : $tmp = "西班牙语"; break;
   case "Chinois" : $tmp = "中国"; break;
   case "Glossaire": $tmp = "词汇表"; break;
   case "Réponse(s)": $tmp = "答案"; break;
   case "Définitions": $tmp = "定义"; break;
   case "Termes": $tmp = "术语"; break;
   case "Terme": $tmp = "项"; break;
   case "Catégorie": $tmp = "类别"; break;
   case "Quelques définitions": $tmp = "一些定义"; break;
   case "Définition": $tmp = "定义"; break;
   case "Soumettre une définition": $tmp = "提交定义"; break;
   case "Une définition identique existe déjà !": $tmp = "相同的定义已经存在"; break;
   case "Liste des définitions": $tmp = "定义列表"; break;
   case "La base est vide": $tmp = "该基地是空的"; break;
   case "Configuration": $tmp = "组态"; break;
   case "Administration": $tmp = "管理"; break;
   case "Retour à l'administration": $tmp="回到管理"; break;
   case "Meta": $tmp = "Meta"; break;
   case "Editer": $tmp = "编辑"; break;
   case "Supprimer": $tmp = "清除"; break;
   case "Définitions par page": $tmp = "每页定义"; break;
   case "Autorise la soumission": $tmp = "授权提交"; break;
   case "Autorise la recherche": $tmp = "授权研究"; break;
   case "Site internet": $tmp = ""; break;
   case "Cliquer pour cacher ou déployer": $tmp = "点击隐藏或部署"; break;
   case "Sélectionner un dossier": $tmp = "选择文件夹"; break;
   case "Sélectionner": $tmp = "选择"; break;
   case "Rechercher par choix multiples": $tmp = "由选择题搜索"; break;
   case "Rechercher par lettre": $tmp = "按字母搜索"; break;
   case "Merci pour votre proposition": $tmp = "感谢您的建议"; break;
   case "Merci de respecter les consignes": $tmp = "谢谢按照指示"; break;
   case "Tous": $tmp = "所有"; break;
   case "Valider": $tmp = "验证"; break;
   case "Autres": $tmp = "其他"; break;
   case "Validation ou suppression des demandes": $tmp = "验证或删除请求"; break;
   case "Oui": $tmp = "是的"; break;
   case "Non": $tmp = "不"; break;
   case "Fonctions": $tmp = "功能"; break;
   case "Liste des définitions dans la base de données": $tmp = "在数据库中定义的列表"; break;
   case "Validation ou suppression des demandes": $tmp = "验证或删除请求"; break;   
   case "Edition d'une définition": $tmp = "编辑定义"; break;
   default: $tmp = "需要翻译稿 [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>