<?php
/************************************************************************/
/* Module de gestion de galeries pour NPDS                              */
/* ===========================                                          */
/*                                                                      */
/* TD-Galerie Language File Copyright (c) 2004-2005 by Tribal-Dolphin   */
/*                                                                      */
/************************************************************************/

function adm_gal_trans($phrase) {
    switch ($phrase) {
       case "Administration des galeries": $tmp = "Administraci&oacute;n Albumes fotos"; break;
       case "Accueil": $tmp = "Inicio"; break;
       case "Ajouter une cat�gorie": $tmp = "A&ntilde;adir una categor&iacute;a"; break;
       case "Ajouter une sous-cat�gorie": $tmp = "A&ntilde;adir una subcategor&iacute;a"; break;
       case "Ajouter des images": $tmp = "A&ntilde;adir im&aacute;genes"; break;
       case "Ajouter une galerie": $tmp = "A&ntilde;adir un Album"; break;
       case "Voir l'arborescence": $tmp = "Ver la estructura"; break;
       case "Configuration": $tmp = "Configuraci&oacute;n"; break;
       case "Nombre de cat�gories :": $tmp = "Cantidad de categor&iacute;as :"; break;
       case "Nombre de sous-cat�gories :": $tmp = "Cantidad de subcategor&iacute;as :"; break;
       case "Nombre d'images :": $tmp = "Cantidad de im&aacute;geness :"; break;
       case "Nombre de galeries :": $tmp = "Cantidad de Albumes :"; break;
       case "Informations": $tmp = "Informaci&oacute;nes"; break;
       case "Aucune cat�gorie trouv�e": $tmp = "Ninguna categor&iacute;a encontrada"; break;
       case "Aucune sous-cat�gorie trouv�e": $tmp = "Ninguna subcategor&iacute;a encontrada"; break;
       case "Aucune galerie trouv�e": $tmp = "Ningun Album encontrado"; break;
       case "Nom de la cat�gorie :": $tmp = "Nombre de la categor&iacute;a :"; break;
       case "Nom de la sous-cat�gorie :": $tmp = "Nombre de la subcategor&iacute;a :"; break;
       case "Nom de la galerie :": $tmp = "Nombre del album :"; break;
       case "Ajouter": $tmp = "A&ntilde;adir"; break;
       case "Valider": $tmp = "Validar"; break;
       case "Cette cat�gorie existe d�j�": $tmp = "Esta categor&iacute;a ya existe"; break;
       case "Erreur lors de l'ajout de la cat�gorie": $tmp = "Error incluyendo la categor&iacute;a"; break;
       case "Administrateurs": $tmp = "Administradores"; break;
       case "Acc�s pour :": $tmp = "Acceso para :"; break;
       case "Cat�gorie parente :": $tmp = "Categor&iacute;a pariente :"; break;
       case "Cette sous-cat�gorie existe d�j�": $tmp = "Esta subcategor&iacute;a ya existe"; break;
       case "Cette galerie existe d�j�": $tmp = "Este Album ya existe"; break;
       case "Erreur lors de l'ajout de la sous-cat�gorie": $tmp = "Error incluyendo la subcategor&iacute;a"; break;
       case "Erreur lors de l'ajout de la galerie": $tmp = "Error incluyendo el album"; break;
       case "Cat�gorie :": $tmp = "Categor&iacute;a :"; break;
       case "Sous-cat�gorie": $tmp = "subcategor&iacute;a"; break;
       case "Galerie": $tmp = "Album"; break;
       case "Galerie :": $tmp = "Album :"; break;
       case "Image :": $tmp = "Imagen :"; break;
       case "Description :": $tmp = "Descripci&oacute;n :"; break;
       case "Ce fichier n'est pas un fichier jpg ou gif": $tmp = "Este fichero no es un fichero jpg o gif"; break;
       case "Image ajout�e avec succ�s": $tmp = "Imagen a&ntilde;adida con &eacute;xito"; break;
       case "Impossible d'ajouter l'image en BDD": $tmp = "Imposible de a&ntilde;adir la imagen en la BDD"; break;
       case "Dimension maximale de l'image en pixels :": $tmp = "Dimensi&oacute;n m&aacute;xima de la imagen en pixeles:"; break;
       case "Dimension maximale de la miniature en pixels :": $tmp = "Dimensi&oacute;n m&aacute;xima de la miniatura en pixeles:"; break;
       case "Dimension maximale de l'image incorrecte": $tmp = "Dimensi&oacute;n m&aacute;xima incorrecta de la imagen"; break;
       case "Dimension maximale de la miniature incorrecte": $tmp = "Dimensi&oacute;n m&aacute;xima incorrecta de la miniatura"; break;
       case "Nombre d'images par ligne :": $tmp = "Im&aacute;genes por l&iacute;nea :"; break;
       case "Nombre d'images par page :": $tmp = "Im&aacute;genes por p&aacute;gina:"; break;
       case "Choisissez": $tmp = "Elija"; break;
       case "Les anonymes peuvent voter ?": $tmp = "&iquest;Los an&oacute;nimos pueden votar?"; break;
       case "Les anonymes peuvent poster un commentaire ?": $tmp = "&iquest;Los an&oacute;nimos pueden comentar?"; break;
       case "Les anonymes peuvent envoyer des E-Cartes ?": $tmp = "&iquest;Los an&oacute;nimos pueden enviar E-tarjetas?"; break;
       case "Nombre de commentaires :": $tmp = "Cantidad de comentarios :"; break;
       case "Nombre de votes :": $tmp = "Cantidad de votos :"; break;
       case "Afficher des photos al�atoires ?": $tmp = "&iquest;Mostrar fotograf&iacute;as aleatorias?"; break;
       case "Afficher les derniers ajouts ?": $tmp = "&iquest;Mostrar las &uacute;ltimas a&ntilde;adidas?";break;
       case "Vous allez supprimer la cat�gorie": $tmp = "La categor&iacute;a ser&aacute; suprimida"; break;
       case "Vous allez supprimer la sous-cat�gorie": $tmp = "La subcategor&iacute;a ser&aacute; suprimida"; break;
       case "Vous allez supprimer la galerie": $tmp = "El album ser&aacute; suprimido"; break;
       case "Vous allez supprimer une image": $tmp = "La imagen ser&aacute; suprimida"; break;
       case "Confirmer": $tmp = "Confirmar"; break;
       case "Annuler": $tmp = "Cancelar"; break;
       case "Miniature supprim�e": $tmp = "Miniatura suprimida"; break;
       case "Miniature non supprim�e": $tmp = "Miniatura NO suprimida"; break;
       case "Image supprim�e": $tmp = "Imagen suprimida"; break;
       case "Image non supprim�e": $tmp = "Imagen NO suprimida"; break;
       case "Enregistrement supprim�": $tmp = "Registro suprimido"; break;
       case "Enregistrement non supprim�": $tmp = "Registro NO suprimido"; break;
       case "Galerie supprim�e": $tmp = "Album suprimido"; break;
       case "Galerie non supprim�e": $tmp = "Galer&iacute;a NO suprimida"; break;
       case "Sous-cat�gorie supprim�e": $tmp = "Subcategor&iacute;a suprimida"; break;
       case "Sous-cat�gorie non supprim�e": $tmp = "Subcategor&iacute;a NO suprimida"; break;
       case "Cat�gorie supprim�e": $tmp = "Categor&iacute;a suprimida"; break;
       case "Cat�gorie non supprim�e": $tmp = "Categor&iacute;a NO suprimida"; break;
       case "Votes supprim�s": $tmp = "Votos suprimidos"; break;
       case "Votes non supprim�s": $tmp = "Votos NO suprimidos"; break;
       case "Commentaires supprim�s": $tmp = "Comentarios suprimidos"; break;
       case "Commentaires non supprim�s": $tmp = "Comentarios NO suprimidos"; break;
       case "Effacer": $tmp = "Suprimir"; break;
       case "Modifier": $tmp = "Modificar"; break;
       case "Nom actuel :": $tmp = "Nombre actual :"; break;
       case "Nouveau nom :": $tmp = "Nuevo nombre :"; break;
       case "Images vues :": $tmp = "Imagenes vistas :"; break;
       case "Afficher les votes ?": $tmp = "&iquest;Mostrar los votos?"; break;
       case "Afficher les commentaires ?": $tmp = "&iquest;Mostrar los comentarios?"; break;
       case "Galerie temporaire": $tmp = "Album Temporal"; break;
       case "Importer des images": $tmp = "Importaci&oacute;n Imagenes"; break;
       case "MAJ ordre": $tmp = "actualizar el orden"; break;
       case "Importer": $tmp = "Importar"; break;
       case "Nombre d'images � afficher dans le top commentaires": $tmp = "Numero de cuadros para exhibir en top comment"; break;
       case "Nombre d'images � afficher dans le top votes": $tmp = "Numero de cuadros para exhibir en top votos"; break;
       case "Notifier par email l'administrateur de la proposition de photos ?": $tmp = "Email notificar al administrador de la proquesta fotos ?"; break;
       case "Exporter une cat�gorie": $tmp = "Exportar una categor�a"; break;
       case "Exporter": $tmp = "Exportar"; break;

       default: $tmp = "Necesita ser traducido <b>[** $phrase **]</b>"; break;
    }
    return $tmp;
}
?>