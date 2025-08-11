<?php
$listdir=array();
$dirorigin=__DIR__;
$dirpresent=scandir($dirorigin);

foreach ($dirpresent as $elements) {
    if ($elements === "." || $elements === ".." || $elements === "start" || $elements === "loop" || $elements === "condition" || $elements === "function" || $elements === "dev" || substr($elements,0,1)!=='J') {
        continue;
    }
    $path = $dirorigin . DIRECTORY_SEPARATOR . $elements;
    if (is_dir($path)) {
        $jsonfile=$path . DIRECTORY_SEPARATOR . '00.json';
        if (file_exists($jsonfile)) {
            $listdir[]=$jsonfile;
        }
    }
}

function genererCodeSession($longueur = 6) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    for ($i = 0; $i < $longueur; $i++) {
        $code .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }
    return $code;
}


$eleveJsonFilesCount = array();
foreach ($listdir as $dir) {
    $Directory = substr($dir,0,strlen($dir)-8);
    if (is_dir($Directory)) {
        $Files = glob($Directory . "/[0-9][0-9].json");
        $Files = array_filter($Files, function($file) {
            return basename($file) !== '00.json';
    });

    $eleveJsonFilesCount[] = count($Files);
    }
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

$startJsonFilesCount = 0;
$startDirectory = __DIR__ . "/start";

if (is_dir($startDirectory)) {
  $startFiles = glob($startDirectory . "/[0-9][0-9].json");
  $startFiles = array_filter($startFiles, function($file) {
      return basename($file) !== '00.json';
  });

  $startJsonFilesCount = count($startFiles);
}

$loopJsonFilesCount = 0;
$loopDirectory = __DIR__ . "/loop";

if (is_dir($loopDirectory)) {
  $loopFiles = glob($loopDirectory . "/[0-9][0-9].json");
  $loopFiles = array_filter($loopFiles, function($file) {
      return basename($file) !== '00.json';
  });

  $loopJsonFilesCount = count($loopFiles);
}

$conditionJsonFilesCount = 0;
$conditionDirectory = __DIR__ . "/condition";

if (is_dir($conditionDirectory)) {
  $conditionFiles = glob($conditionDirectory . "/[0-9][0-9].json");
  $conditionFiles = array_filter($conditionFiles, function($file) {
      return basename($file) !== '00.json';
  });

  $conditionJsonFilesCount = count($conditionFiles);
}

$functionJsonFilesCount = 0;
$functionDirectory = __DIR__ . "/function";

if (is_dir($functionDirectory)) {
  $functionFiles = glob($functionDirectory . "/[0-9][0-9].json");
  $functionFiles = array_filter($functionFiles, function($file) {
      return basename($file) !== '00.json';
  });

  $functionJsonFilesCount = count($functionFiles);
}

include 'base.php';


if (!isset($_SESSION['id']) || $_SESSION['admin'] === 0) {
    header("Location: play.php?r=start&p=1");
    exit;
} 

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    global $conn;
    $session_name=$_POST['name'];
    $folder=$_POST['folder'];
    $expire=$_POST['time'];
    $session_code=genererCodeSession();
    $request=$conn->prepare("INSERT INTO sessions (session_name,creator_name,session_code,folder,date_creation) VALUES(?,?,?,?,NOW())");
    $request->bind_param("ssss",$session_name,$_SESSION['pseudo'],$session_code,$folder);
    $request->execute();
    $sql="CREATE TABLE `$session_name` (id INT AUTO_INCREMENT PRIMARY KEY,user_pseudo VARCHAR(21),user_data TEXT,user_last_connexion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
    if ($conn->query($sql)) {
    } else {
        echo "AIE AIE AIE";
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="fr"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Apprends à lire et comprendre du code Python en explorant un jeu interactif ! Découvre les boucles, les conditions et les fonctions tout en te déplaçant dans une grille. Idéal pour débuter en programmation ! 🚀">
  <title>Accueil • python.snt.nsi.xyz</title>
  <link rel="stylesheet" href="./css/pure-min.css">
  <link rel="stylesheet" href="./css/css2">
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <div id="layout">
    <a href="" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <div id="menu">
      <div class="pure-menu">
        <a class="pure-menu-heading" href="./index.php">Découvrir Python au lycée</a>
          <ul class="pure-menu-list">
            <li class="pure-menu-item menu-item-divided pure-menu-item-login" id="create"><a class="pure-menu-link" href="./create.php">&#x1F464; Créer une session</a></li>
            <li class="pure-menu-item menu-item-divided pure-menu-item-login" id="session"><a class="pure-menu-link" href="./csession.php">&#x1F464; Gérer les sessions</a></li>
            <li class="pure-menu-item menu-item-divided pure-menu-item-login" id="retour" ><a class="pure-menu-link" href="./index.php" >↩️ Retour au jeu</a></li>
          </ul>
      </div>            
      <div class="menu-bottom">
            <li class="pure-menu-item-reset" id="reset"><a onclick="reset();" class="pure-menu-link">❌ Effacer / Recommencer</a></li>
          </div>
    </div>
    <div id="main">
      <div class="header">
        <h1>python.snt.nsi.xyz</h1>
        <h2>Découvrir python en lycée 🐍</h2>
      </div>
      <div class="content">
      <h2 id="S'identifier" class="content-subhead">Créer une session</h2>
        <!--<p class="p-content">Rejoignez facilement une session avec le code fourni par votre enseignant, connectez-vous ou créez un compte en tant qu'enseignant pour gérer vos sessions et bien plus.</p>
        <p class="p-content">Le site web est également accessible sans connexion pour une exploration et une découverte rapide et facile.</p>-->
        <msg></msg>
              <form method="POST" class="pure-form ">
                  <legend>Création de la session</legend>
                    <input type="text" id="nom" name="name" placeholder="Nom de la session" required minlength="1" />
                    <input type="text" id="fol" name="folder" placeholder="Dossier concerné" required minlength="3" maxlength="24" />
                    <input type="text" id="duration" name="time" placeholder="Durée de la session" required minlength="1" />
                <button type="submit" class="pure-button pure-button-primary-join" name="create">Créer</button>
              </form>
                <h2 class="content-subhead"></h2>
                <h2 class="content-subhead" id="generate-code"></h2>
                          </div>
                  </section>

        </div>
    </div>
    <div class="footer">
      <p class="footer-content">Une idée de Vincent ROBERT, enseignant de spécialité NSI au Lycée Louis Pasteur d'Avignon, librement inspiré de <a href="https://compute-it.toxicode.fr/?progression=python" class="link">compute-it</a>.</p>
      <p class="footer-content">Développé par Vivien G.R. au cours de l'année 2024-2025 dans le cadre d'un projet de spécialité NSI. Version 1.42</p>
      <div class="pure-menu-horizontal">
        <ul>
          <li class="pure-menu-item"><a href="https://github.com/nsi-xyz/py.snt.nsi.xyz" class="pure-menu-link-hidden" target="_blank">github</a></li>
          <li class="pure-menu-item"> </li>
          <li class="pure-menu-item"><a href="https://nsi.xyz/" class="pure-menu-link-hidden" target="_blank">nsi.xyz</a></li>
          <li class="pure-menu-item"> </li>
          <li class="pure-menu-item"><a href="https://purecss.io/" class="pure-menu-link-hidden" target="_blank">Pure CSS</a></li>
          <li class="pure-menu-item"> </li>
          <li class="pure-menu-item"><a href="https://nsi42.net" class="pure-menu-link-hidden" target="_blank">nsi42.net</a></li>
        </ul>
      </div>
    </div>
  </div>
  <script src="./css/ui.js"></script>
  <script> function reset() {
    if (document.getElementById('reset').querySelector('a').textContent==="❌ Effacer / Recommencer") {
        localStorage.removeItem('lvl')
        window.location.reload()
    } else {
        fetch('logout.php')
            .then(() => {
                localStorage.removeItem('lvl')
                window.location.reload()
            })
    }
}</script>
<script>
<?php if (isset($_SESSION['id'])): ?>
    document.getElementById('reset').querySelector('a').textContent="❌ Se déconnecter"

<?php endif;?>
<?php if (isset($session_code)): ?>
    code="<?php echo $session_code; ?>";
    document.getElementById('generate-code').textContent=`Code : ${code}`;
<?php endif;?>

<?php if (isset($erreur)): ?>
    document.getElementById('alert').style.display='block'
<?php endif;?>

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
if (document.getElementById('timer').style.display==='block') {
    setInterval(updateTimer, 60000);
}
window.devJsonFilesCount = <?php echo $devJsonFilesCount; ?>;
window.startJsonFilesCount = <?php echo $startJsonFilesCount; ?>;
window.loopJsonFilesCount = <?php echo $loopJsonFilesCount; ?>;
window.conditionJsonFilesCount = <?php echo $conditionJsonFilesCount; ?>;
window.functionJsonFilesCount = <?php echo $functionJsonFilesCount; ?>;

let lvl
if (localStorage.getItem('lvl') !== null) {
	  lvl = JSON.parse(localStorage.getItem('lvl'))
    localStorage.setItem('lvl',JSON.stringify(lvl))
} else {
	  lvl = {"start":[], "loop":[], "condition":[], "function":[], "dev":[]};
    localStorage.setItem('lvl',JSON.stringify(lvl))
};

</script>
</body></html>