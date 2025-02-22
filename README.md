# py.snt.nsi.xyz

Dépot github du projet python.snt.nsi.xyz

En ligne sur https://python.snt.nsi.xyz/


python.snt.nsi.xyz est un site interactif permettant d’apprendre à lire et comprendre du code Python. À travers une grille de jeu, les élèves découvrent des concepts clés comme les boucles, les conditions et les fonctions. Les exercices sont ludiques et accessibles, conçus pour les élèves de SNT en seconde.


### Débuter
Bien débuter en python, suivre les instructions 🚀
Dans la catégorie débuter, il y a des niveux avec toutes les différentes catégories, les niveaux sont au départ très simple pour s'initier au langage python.

### Les boucles
Tourner en rond, mais avec intelligence 🔄

### Les tests conditionnels
Quand Python doit faire un choix 🐭🧀

### Les fonctions
Quand Python devient un super-héros 🦸‍♂️

### Comment ça marche

Le fonctionnement du jeu repose sur plusieurs fichiers, en plus de la page d'acceuil.
Un fichier play.php s'occupe de récupérer dans l'url les variables correspondant à la catégorie dans la quelle on est et le niveau actuel, le fichier sert aussi a afficher les éléments basiques de la page qui ne changent pas selon les niveaux. play.php appelle le fichier play.js qui lui s'occupe de chargé le niveau dans lequel on est et les éléments dynamiques de la page c'est a dire la grille, les instruction et le menu horizontal. Ce ficher play.js va a partir du paramètre dans l'url qui indique le niveau qu'il doit charger aller chercher dans le repertoire corresondant a la catégorie dans laquelle ont est, le fichier .json correspondant. Du fichier .json il va extraire les information pour charger le lvl, c'est ce fichier .json que vous pouvez créer pour faire un niveau.

## Créer un niveau, des parties


### Créer un dossier
Pour l'instant il n'est pas possible de créer des dossier, il est possible que des dossiers soient créés pour le dépot des niveaux codés par les élèves.

### Créer un niveau
Pour créé un niveau, il faut prendre comme base le fichier 01.json donné comme exemple pour la création d'un niveeau et le modifier pour créé le niveau que l'on veut, le fichier est disponible a la racine du projet github.

### Ajouter un dossier au site

Pour l'instant le dépot des dossiers / fichiers sur le site est réalisé uniquement par les concepteurs du jeu pour des raisons de sécurité.
Les élèves de spécialité NSI du lycée Louis Pasteur auront, prochainement, des niveaux à créer. 

Lorsque le dépot sera possible est sécurisé, vous pourrez déposer vos propres niveaux, ils ne seront pas nécessairement accessible via le menu mais seront accessible via une URL unique.




## Contributeurs :
- Vincent ROBERT : Front only, UI / UX, debuguage, débugage CSS, création des 10 niveaux "start". 
- Ilyas RAHMOUN : Adapatation d'un layouts de https://pure-css.github.io/ pour https://web.snt.nsi.xyz/ réutilisé ici, testeur.
- Vivien G.R. (n'a pas le droit de mettre son nom de famille car il n'est pas majeur 😅)
-- Back : php, html, et beaucoup de JS, portage du concpet https://compute-it.toxicode.fr/?progression=python
-- Front : html, css, responsive, 
