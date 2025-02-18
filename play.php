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
?>
<!DOCTYPE html>
<html lang="fr"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="nothing, I delete it">
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
        <a class="pure-menu-heading" href="https://python.snt.nsi.xyz/index.php">Découvrir Python au lycée</a>
          <ul class="pure-menu-list">
            <li class="menu-ko" id="start"><a href="https://python.snt.nsi.xyz/play.php?r=start&p=1" class="pure-menu-link">🟠 Débuter</a></li>
            <li class="menu-ko" id="loop"><a href="https://python.snt.nsi.xyz/play.php?r=loop&p=1" class="pure-menu-link">🟠 Les boucles</a></li>
            <li class="menu-ko" id="condition"><a href="https://python.snt.nsi.xyz/play.php?r=condition&p=1" class="pure-menu-link">🟠 Les tests conditionnels</a></li>
            <li class="menu-ko" id="function"><a href="https://python.snt.nsi.xyz/play.php?r=function&p=1" class="pure-menu-link">🟠 Les fonctions</a></li>
            <li class="pure-menu-item-help"><a href="" class="pure-menu-link">🔷 Aide &amp; Boite à outils</a></li>
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
      <div class="pure-u-3-5">
        <const-js></const-js>
        </div>
        
      <div class="pure-u-1-6">
        <instru-js></instru-js>
        </div>
        </div>
        <!--<button onclick="reset();" id ="reset">Reset</button>-->

    </div>
  </div>
  <script>
        // Définir les variables JS
        window.jsonFile = "<?php echo basename($jsonFile); ?>";
        window.jsonFilesCount = <?php echo $jsonFilesCount; ?>;
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
        window.location.replace(window.location.href);
    }
}

setInterval(updateTimer, 60000);
</script>
</body></html>