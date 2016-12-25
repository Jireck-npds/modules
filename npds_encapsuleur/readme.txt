########################################################################################################
##
## Nom: npds_encapsuleur
## Version: 5.0
## Auteur: Achel Jay - Capitain Caverne - Benjee - Snipe - Patrice Lopez - Jpb/Phr - Dev
##
########################################################################################################
##
## ENCAPSULER - Enfermer dans une capsule.
##
## L'encapsuleur est un module cr�e pour les portails NPDS.
## Ce module vous permet, par l'ajout dans une table SQL,
## d'int�ger n'importe quelle page interne ou externe � votre site
## Cette encapsulation vous permet d'ajouter n'importe quelle page
## de fa�on int�gr�e au portail NPDS.
##
## Ainsi, vous aurez une page "encapsul�e" entre le header.php, le footer.php et la frame
## sup�rieure.
##
## Bonne encapsulation
##
########################################################################################################
##
## Nom: npds_encapsuleur
## Version: 5.0 pour Rev 16
## Auteur: Achel Jay - Capitain Caverne - Benjee - Snipe - Patrice Lopez - Jpb/Phr - Dev
##
########################################################################################################

## UTILISATION
##                        Nom		: nom de l'encapsulation
##                        Display		: La pages est 'ouverte' (1) ou ferm�e (0) � la consultation
##                        Type		: Interne ... au site (page static (donc avec le style css du site)
##                                          Externe ... page d'une autre site web (dans une iframe)
##                        Forme		: Protocole http ou https ou ftp (http par d�faut).  
##                        Adresse		: Si Interne : le nom de la page (exemple.html ou static/exemple.html, ...)
##                                          Si Externe : l'url complete (sans le protocole - http://, https://, ftp://)
##                        Hauteur		: hauteur de la page (par d�faut 800 pixels - voir encap.conf.php)
##                        Scroll		: Affiche les scrollbars
##                        Bloc		: Format d'affichage souhait� (si le th�me le prend en charge)
##							   1 = entre les blocs Droite et Gauche,
##							   0 = bloc de Gauche seulement
##							  -1 = pas de block
##							   2 = bloc de Droite seulement 
##				  Titre 		: Titre de la page
##				  Affichage Titre	: Affiche le Titre ... ou pas 
##
## APPEL DES PAGES
##
##        Voir le lien g�n�r� (Lien) 
