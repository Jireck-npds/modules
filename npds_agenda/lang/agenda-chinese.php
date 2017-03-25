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
/* Module npds_agenda 2.0                                               */
/*                                                                      */
/* Auteur Oim                                                           */
/* Changement de nom du module version Rev16 par jpb/phr janv 2017      */
/************************************************************************/

function ag_translate($phrase) {
 switch ($phrase) {
   case "A valider": $tmp = "为了验证"; break;
   case "Accès catégorie(s)": $tmp = "访问类别"; break;
   case "Accueil": $tmp = "欢迎"; break;
   case "Agenda": $tmp = "日记"; break;
   case "Ajout + Groupe": $tmp = "添加+集团"; break;
   case "Ajout d'événement : 1 Tous les membres - ou groupe": $tmp = "添加事件：所有成员 - 或组"; break;
   case "Ajouter une catégorie": $tmp = "添加类别"; break;
   case "Allemand" : $tmp = "德国"; break;
   case "Anglais" : $tmp = "英语"; break;
   case "Année": $tmp = "年"; break;
   case "Août": $tmp = "八月"; break;
   case "AOUT": $tmp = "八月"; break;
   case "Armistice 14-18": $tmp = "停战14-18"; break;
   case "Armistice 39-45": $tmp = "39-45停战"; break;
   case "Assomption": $tmp = "假设"; break;
   case "Astérisque = saisie obligatoire": $tmp = "星号=输入强制"; break;
   case "Aucun évènement trouvé": $tmp = "没有找到事件"; break;
   case "Auteur": $tmp = "作者"; break;
   case "Autre(s)": $tmp = "其他"; break;
   case "Autres": $tmp = "其他"; break;
   case "AVRIL": $tmp = "四月"; break;
   case "Avril": $tmp = "四月"; break;
   case "Calendrier": $tmp = "日历"; break;
   case "Catégories": $tmp = "分类"; break;
   case "Catégorie": $tmp = "分类"; break;
   case "Cet évènement est maintenant effacé": $tmp = "此事件已被删除"; break;
   case "Cet évènement est mis à jour": $tmp = "此事件被更新"; break;
   case "Cet évènement dure 1 jour": $tmp = "本次活动是1天"; break;
   case "Cet évènement dure plusieurs jours": $tmp = "此事件持续数天"; break;
   case "Cet évènement est maintenant effacé": $tmp = "此事件已被清除"; break;
   case "Champ obligatoire": $tmp = "必填字段"; break;
   case "Chemin des images": $tmp = "照片道路"; break;
   case "Choix catégorie": $tmp = "选择类别"; break;
   case "Chinois": $tmp = "中国"; break;
   case "Cliquez pour éditer": $tmp = "点击编辑"; break;
   case "Configuration": $tmp = "组态"; break;
   case "Confirmez la suppression": $tmp = "确认删除"; break;
   case "D": $tmp = "ð"; break;
   case "Décembre": $tmp = "十二月"; break;
   case "Date": $tmp = "日期"; break;
   case "DECEMBRE": $tmp = "十二月"; break;
   case "Description complète": $tmp = "充分说明"; break;
   case "Description": $tmp = "描述"; break;
   case "Editer un évènement": $tmp = "编辑事件"; break;
   case "Editer": $tmp = "编辑"; break;
   case "En Ligne": $tmp = "在线"; break;
   case "Espagnol" : $tmp = "西班牙语"; break;
   case "Etape 1 : Séléctionner vos dates": $tmp = "第1步：选择您的日期"; break;
   case "Etape 2 : Remplisser le formulaire": $tmp = "第2步：填写表格"; break;
   case "Etes-vous certain de vouloir supprimer cet évènement": $tmp = "你确定要删除这个活动？"; break;
   case "Etre averti par mail d'un nouvel evenement": $tmp = "被新的事件时发送电子邮件通知"; break;
   case "Evènement": $tmp = "事件"; break;
   case "Evènement(s) à venir": $tmp = "即将发生的事件"; break;
   case "Evènement(s) en cours ou passé(s)": $tmp = "时事或过去的"; break;
   case "Evènement nouveau dans agenda": $tmp = "日历新事件"; break;
   case "Février": $tmp = "二月"; break;
   case "Fête du travail": $tmp = "劳动节"; break;
   case "Fête nationale": $tmp = "国庆"; break;
   case "FEVRIER": $tmp = "二月"; break;
   case "Fonctions": $tmp = "功能"; break;
   case "Français" : $tmp = "法国"; break;
   case "Groupe": $tmp = "组"; break;
   case "Hors Ligne": $tmp = "当前离线"; break;
   case "ID": $tmp = "注册"; break;
   case "Image de la catégorie": $tmp = "图片为类别"; break;
   case "J": $tmp = "Ĵ"; break;
   case "JANVIER": $tmp = "一月"; break;
   case "Janvier": $tmp = "一月"; break;
   case "Jeu": $tmp = "游戏"; break;
   case "Jeudi de l'ascension": $tmp = "阿森松周四"; break;
   case "Jour avec évènement(s)": $tmp = "日活动与"; break;
   case "Jour de l'an": $tmp = "新年"; break;
   case "Jour férié": $tmp = "节日"; break;
   case "Jour(s) sélectionné(s)": $tmp = "选择天"; break;
   case "JUILLET": $tmp = "七月"; break;
   case "Juillet": $tmp = "七月"; break;
   case "JUIN": $tmp = "六月"; break;
   case "Juin": $tmp = "六月"; break;
   case "L": $tmp = "大号"; break;
   case "La catégorie est créée": $tmp = "被创建的类别"; break;
   case "La catégorie est effacée": $tmp = "类别被清除"; break;
   case "La catégorie est mise à jour": $tmp = "类别更新"; break;
   case "Les préférences pour l'agenda ont été enregistrées": $tmp = "该议程首录"; break;
   case "Lieu": $tmp = "地方"; break;
   case "Liste des évènements": $tmp = "事件列表"; break;
   case "Liste de vos évènements": $tmp = "列出您的活动"; break;
   case "Lundi de Pâques": $tmp = "复活节后的星期一"; break;
   case "Lundi de Pentecôte": $tmp = "圣灵降临节"; break;
   case "M ": $tmp = "中号"; break;
   case "M": $tmp = "中号"; break;
   case "MAI": $tmp = "五月"; break;
   case "Mai": $tmp = "五月"; break;
   case "Mail du receveur": $tmp = "邮件收件人"; break;
   case "Mar": $tmp = "三月"; break;
   case "Mars": $tmp = "三月"; break;
   case "MARS": $tmp = "三月"; break;
   case "Mer": $tmp = "海"; break;
   case "Merci pour votre contribution, un administrateur la validera rapidement": $tmp = "感谢您的贡献，管理员将验证迅速"; break;
   case "Modification évènement pour agenda": $tmp = "事件变革议程"; break;
   case "Modifier l'Evènement": $tmp = "编辑事件"; break;
   case "Modifier la catégorie": $tmp = "变更类别"; break;
   case "Nbre d'évènements (pagination)": $tmp = "事件数"; break;
   case "Dans la partie module": $tmp = "在模块部"; break;
   case "Dans la partie admin": $tmp = "在部分管理"; break;
   case "Noël": $tmp = "圣诞节"; break;
   case "NON": $tmp = "不"; break;
   case "Non": $tmp = "不"; break;
   case "npds_agenda": $tmp = "NPDS议程"; break;
   case "NOVEMBRE": $tmp = "十一月"; break;
   case "Novembre": $tmp = "十一月"; break;
   case "OCTOBRE": $tmp = "十月"; break;
   case "Octobre": $tmp = "十月"; break;
   case "OUI": $tmp = "是的"; break;
   case "Oui": $tmp = "是的"; break;
   case "Par ville": $tmp = "城市"; break;
   case "par ville": $tmp = "城市"; break;
   case "Par ville (défaut)": $tmp = "城市"; break;
   case "Par": $tmp = "由"; break;
   case "Pas de catégorie": $tmp = "无类别"; break;
   case "Pas de catégorie ajoutée": $tmp = "不添加任何类别"; break;
   case "Posté par": $tmp = "发表"; break;
   case "pour la lettre": $tmp = "不折不扣"; break;
   case "pour": $tmp = "为"; break;
   case "Proposer évènement": $tmp = "提交事件"; break;
   case "Proposer un évènement": $tmp = "提交事件"; break;
   case "Pour ajouter des dates, sélectionner le(s) jour(s) dans le calendrier": $tmp = "要在日历中添加日期，选择日期"; break;
   case "Résumé de l'évènement": $tmp = "事件摘要"; break;
   case "Recherche": $tmp = "搜索"; break;
   case "Résumé": $tmp = "摘要"; break;
   case "Retour édition catégorie": $tmp = "返回出版类"; break;
   case "Retour au calendrier": $tmp = "返回到日历"; break;
   case "Retour au jour": $tmp = "早在一天"; break;
   case "Retour": $tmp = "回报"; break;
   case "S": $tmp = "小号"; break;
   case "Sam": $tmp = "山姆"; break;
   case "Sauver les modifications": $tmp = "保存更改"; break;
   case "Sélectionner catégorie": $tmp = "选择类别"; break;
   case "Sélectionnez une catégorie, cliquez pour modifier": $tmp = "选择一个类别，点击修改"; break;
   case "Sélectionner si nécessaire": $tmp = "如果必要，选择"; break;
   case "Sélection région ou département": $tmp = "选择区域或部门"; break;
   case "Etape 1 : Sélectionner vos dates": $tmp = "第1步：选择您的日期"; break;
   case "Sem": $tmp = "周"; break;
   case "SEPTEMBRE": $tmp = "九月"; break;
   case "Septembre": $tmp = "九月"; break;
   case "Statut": $tmp = "状态"; break;
   case "Categorie": $tmp = "类别"; break;
   case "Supercache": $tmp = "超高速缓存"; break;
   case "Supprimer la catégorie": $tmp = "删除类别"; break;
   case "Supprimer cet évènement": $tmp = "删除此活动"; break;
   case "Supprimer": $tmp = "清除"; break;
   case "Temps du cache (en secondes)": $tmp = "缓存时间（秒）"; break;
   case "Titre de la catégorie": $tmp = "分类标题"; break;
   case "Titre": $tmp = "标题"; break;
   case "Toussaint": $tmp = "杜桑"; break;
   case "Trier par": $tmp = "排序方式"; break;
   case "Un administrateur validera vos changements rapidement": $tmp = "管理员将迅速确认自己的更改"; break;
   case "Un évènement nouveau est à valider dans agenda": $tmp = "一个新的事件是在议程验证"; break;
   case "V": $tmp = "V"; break;
   case "Validation après modification": $tmp = "修改后的验证"; break;
   case "Validation par l'admin": $tmp = "验证由管理员"; break;
   case "Valider": $tmp = "验证"; break;
   case "Vendredi Saint": $tmp = "耶稣受难日"; break;
   case "Vide": $tmp = "空"; break;
   case "Voir la fiche": $tmp = "查看详情"; break;
   case "Voir": $tmp = "视图"; break;
   case "Vos ajouts": $tmp = "您添加"; break;
   case "Vous n'avez pas rempli les champs obligatoires": $tmp = "您还没有填写必填字段"; break;
   case "Vue annuelle": $tmp = "年"; break;
   default: $tmp = "需要翻译稿 [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>