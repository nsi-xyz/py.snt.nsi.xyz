<?php
// Récupérer les paramètres r et p dans l'URL
$r = isset($_GET['r']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['r']) : '';
$p = isset($_GET['p']) ? intval($_GET['p']) : 0;

// Vérifier que les paramètres sont valides
if (!$r || $p <= 0) {
    die("Paramètres invalides");
}

// Construire le chemin du fichier JSON
$directory = __DIR__ . "/$r";
$jsonFile = sprintf("%s/%02d.json", $directory, $p);

// Vérifier si le fichier JSON existe
if (!file_exists($jsonFile)) {
    die("Fichier JSON introuvable");
}

$jsonFilesCount = 0;
if (is_dir($directory)) {
    // Chercher tous les fichiers deux chiffres suivis de ".json"
    $files = glob($directory . "/[0-9][0-9].json");

    // Filtrer pour exclure "00.json"
    $files = array_filter($files, function($file) {
        return basename($file) !== '00.json';
    });

    // Compter les fichiers valides
    $jsonFilesCount = count($files);
}

$devJsonFilesCount = 0;
$devDirectory = __DIR__ . "/dev";

if (is_dir($devDirectory)) {
    $devFiles = glob($devDirectory . "/[0-9][0-9].json");
    $devFiles = array_filter($devFiles, function($file) {
        return basename($file) !== '00.json';
    });

    $devJsonFilesCount = count($devFiles);
}

?>
<!DOCTYPE html>
<html lang="fr"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Apprends à lire et comprendre du code Python en explorant un jeu interactif ! Découvre les boucles, les conditions et les fonctions tout en te déplaçant dans une grille. Idéal pour débuter en programmation ! 🚀">
  <title>Accueil • python.snt.nsi.xyz</title>
  <link rel="stylesheet" href="./css/pure-min.css">
  <link rel="stylesheet" href="./css/css2"> 
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./style.css">
  <script src="./play.js" defer></script>
</head>
<body>
  <div id="layout">
    <a href="" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <div id="menu">
      <div class="pure-menu">
        <a class="pure-menu-heading" onclick="link_acceuil();" onmouseover="this.style.cursor='pointer'">Découvrir Python au lycée</a>
          <ul class="pure-menu-list">
            <li class="menu-ko" id="start"><a onclick="link_start();"  onmouseover="this.style.cursor='pointer'" class="pure-menu-link">🟠 Débuter</a></li>
            <li class="menu-ko" id="loop"><a onclick="link_loop();" onmouseover="this.style.cursor='pointer'" class="pure-menu-link">🟠 Les boucles</a></li>
            <li class="menu-ko" id="condition"><a onclick="link_condition();" onmouseover="this.style.cursor='pointer'" class="pure-menu-link">🟠 Les tests conditionnels</a></li>
            <li class="menu-ko" id="function"><a onclick="link_function();" onmouseover="this.style.cursor='pointer'" class="pure-menu-link">🟠 Les fonctions</a></li>
            <li class="menu-ko" id="dev"><a onclick="link_dev();" onmouseover="this.style.cursor='pointer'" class="pure-menu-link">🟠 Dev</a></li>
            <li class="pure-menu-item-help"><a href="https://github.com/nsi-xyz/py.snt.nsi.xyz" class="pure-menu-link">🔷 Créer un niveau</a></li>
          </ul>
      </div>            <div class="menu-bottom"><li class="pure-menu-item-timer">Il reste <timer>60</timer> minutes</li>
            <li class="pure-menu-item-reset"><a onclick="reset();" class="pure-menu-link">❌ Effacer / Recommencer</a></li></div>
    </div>
    <div id="main">
      <div class="header">
        <h1>python.snt.nsi.xyz</h1>
        <h2 id="titre-json"></h2>
              </div>
    
      <div class="content">
        <h2 class="subhead-content">
          <menu-lvl></menu-lvl>
        </h2>
        <h2 class="content-subhead" id="text-intro"></h2>
      <div class="pure-g">
      <div class="pure-u-2-5">
        <const-js id="conteneur"></const-js>
        </div>
        
      <div class="pure-u-2-5">
        <instru-js></instru-js>
        </div>
        </div>
        <div class="pure-g">
      <div class="pure-u-2-5 pave-tact">
        <div></div>
        <div class="fleche" id="ArrowUp">⇧</div>
        <div></div>
        <div class="fleche" id="ArrowLeft">⇦</div>
        <div></div>
        <div class="fleche" id="ArrowRight">⇨</div>
        <div></div>
        <div class="fleche" id="ArrowDown">⇩</div>
        <div></div>
      </div>
      </div>
    </div>
  </div>
  <script>
        // Définir les variables JS
        window.jsonFile = "<?php echo basename($jsonFile); ?>";
        window.jsonFilesCount = <?php echo $jsonFilesCount; ?>;
        window.devJsonFilesCount = <?php echo $devJsonFilesCount; ?>;
        window.p=<?php echo $p; ?>;
        window.r="<?php echo $r; ?>"
    </script>
  <script src="./css/ui.js"></script>
<script>
val = 60
document.querySelector("timer").textContent = val.toString().padStart(2, "0")
const timer = document.querySelector("timer");
function updateTimer() {
    let value = parseInt(timer.textContent);
    if (value > 0) {
        value--;
        timer.textContent = value.toString().padStart(2, "0");
    } else {
        reset();
        window.location.replace(window.location.href);
    }
}

setInterval(updateTimer, 60000);
</script>
</body></html>