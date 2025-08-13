# py.snt.nsi.xyz

Dépot github du projet python.snt.nsi.xyz

En ligne sur https://python.snt.nsi.xyz/


python.snt.nsi.xyz est un site interactif permettant d’apprendre à lire et comprendre du code Python. À travers une grille de jeu, les élèves découvrent des concepts clés tels que les boucles, les conditions et les fonctions. Les exercices sont ludiques et accessibles, conçus pour une initiation au Python destinée aux élèves de SNT en seconde.



### Débuter
Bien débuter en python, suivre les instructions 🚀  
Dans la catégorie Débuter, vous trouverez plusieurs niveaux introduisant progressivement différentes notions fondamentales de la programmation en Python. Les premiers exercices sont conçus pour être très accessibles, afin de permettre une prise en main en douceur et de poser des bases solides pour la suite de l’apprentissage.

### Les boucles
Tourner en rond, mais avec intelligence 🔄  
La catégorie sur les boucles propose plusieurs niveaux permettant d’apprendre à lire et à comprendre une boucle en Python, en découvrant comment elles permettent de répéter des instructions de manière efficace et automatisée. 

### Les tests conditionnels
Quand Python doit faire un choix 🐭🧀  
Dans cette catégorie, plusieurs niveaux permettent d'explorer les tests conditionnels et de comprendre comment ils influencent le déroulement d'un programme en Python.

### Les fonctions
Quand Python devient un super-héros 🦸‍♂️  
Cette dernière catégorie propose plusieurs niveaux permettant d’apprendre à lire et à comprendre les fonctions en Python, en explorant leur utilité pour structurer et optimiser un programme.

### Comment ça marche

Le fonctionnement du jeu repose sur plusieurs fichiers, en plus de celui de la page d'accueil.  
Un fichier play.php récupère dans l'URL les variables correspondant à la catégorie dans laquelle on se trouve et au niveau actuel. Ce fichier sert également à afficher les éléments basiques de la page qui ne changent pas en fonction des niveaux. Ensuite, play.php appelle le fichier play.js, qui se charge de charger le niveau en cours ainsi que les éléments dynamiques de la page, à savoir la grille, les instructions et le menu horizontal. À partir du paramètre dans l'URL qui indique le niveau à charger, play.js va chercher dans le répertoire correspondant à la catégorie le fichier .json approprié. Ce fichier .json contient les informations nécessaires pour charger le niveau. C’est ce fichier .json que vous pouvez créer pour définir un niveau.  

## Créer un niveau, des parties


### Créer un dossier
Pour l'instant, il n'est pas possible de créer des dossiers, mais il est envisageable que des dossiers soient créés pour le dépôt des niveaux codés par les élèves.

### Créer un niveau
Pour créer un niveau, il faut partir du fichier 01.json, qui sert d'exemple pour la création d'un niveau. Il suffit ensuite de modifier ce fichier en fonction des spécifications du niveau que vous souhaitez créer. Ce fichier modèle est disponible à la racine du projet sur GitHub, et vous pouvez l'utiliser comme point de départ pour définir les éléments nécessaires à votre niveau (grille, instructions, titre...). Assurez-vous de respecter la structure et le format du fichier .json afin de garantir le bon fonctionnement du niveau dans le jeu.


### Ajouter un dossier au site

Pour l'instant le dépot des dossiers / fichiers sur le site est réalisé uniquement par les concepteurs du jeu pour des raisons de sécurité.  
Les élèves de spécialité NSI du lycée Louis Pasteur auront, prochainement, des niveaux à créer. 

Lorsque le dépot sera possible est sécurisé, vous pourrez déposer vos propres niveaux, ils ne seront pas nécessairement accessible via le menu mais seront accessible via une URL unique.




## Contributeurs :
- Vincent ROBERT : Front only, UI / UX, debuguage, débugage CSS, création des 10 niveaux "start". 
- Ilyas RAHMOUN : Adapatation d'un layouts de https://pure-css.github.io/ pour https://web.snt.nsi.xyz/ réutilisé ici, testeur.
- Vivien G.R.
-- Back : php, html, et beaucoup de JS, portage du concpet https://compute-it.toxicode.fr/?progression=python
-- Front : html, css, responsive, 
