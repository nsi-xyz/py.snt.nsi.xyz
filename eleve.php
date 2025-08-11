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

if (isset($_SESSION['id'])) {
    $sql=$conn->prepare("SELECT user_data FROM logUsers WHERE id = ?");
    if ($sql) {
        $sql->bind_param("s",$_SESSION['id']);
        if ($sql->execute()) {
            $result=$sql->get_result();
            $row=$result->fetch_assoc();
        }
    }
} elseif (isset($_SESSION['session_name'])) {
    $table_name=$_SESSION['session_name'];
    $sql="SELECT user_data FROM `$table_name` WHERE user_pseudo=?";
    $sql=$conn->prepare($sql);
    $sql->bind_param("s",$_SESSION['pseudo']);
    if ($sql->execute()) {
        $result=$sql->get_result();
        $row=$result->fetch_assoc();
    }

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
  <script src="./niveleve.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
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
            <li class="menu-ko" id="start"><a href="./play.php?r=start&p=1" class="pure-menu-link">🟠 Débuter</a></li>
            <li class="menu-ko" id="loop"><a href="./play.php?r=loop&p=1" class="pure-menu-link">🟠 Les boucles</a></li>
            <li class="menu-ko" id="condition"><a href="./play.php?r=condition&p=1" class="pure-menu-link">🟠 Les tests conditionnels</a></li>
            <li class="menu-ko" id="function"><a href="./play.php?r=function&p=1" class="pure-menu-link">🟠 Les fonctions</a></li>
            <li class="menu-ko" id="dev"><a href="./play.php?r=dev&p=1" class="pure-menu-link">🟠 Dev</a></li>
            <li id="eleve"><a href="./eleve.php" class="pure-menu-link"> </a></li>
            <li class="pure-menu-item menu-item-divided pure-menu-item-login" id="log"><a class="pure-menu-link" href="./login.php">&#x1F464; Se connecter</a></li>
            <li class="pure-menu-item menu-item-divided pure-menu-item-login" id="gestion" style="display:none;"><a class="pure-menu-link" href="./csession.php" >&#x1F464; Gestion</a></li>
            <li class="pure-menu-item menu-item-divided pure-menu-item-login" id="session" style="display:none;"><a class="pure-menu-link" href="" >&#x1F464; Session</a></li>
            <li class="pure-menu-item-help"><a href="https://github.com/nsi-xyz/py.snt.nsi.xyz" class="pure-menu-link">🔷 Créer un niveau</a></li>
          </ul>
      </div>            
      <div class="menu-bottom">
        <li class="pure-menu-item-timer" id="pseudo" style="display:none;">🚹 Utilisateur : </li>
        <li class="pure-menu-item-timer" id="timer">Il reste <timer>60</timer> minutes</li>
            <li class="pure-menu-item-reset" id="reset"><a onclick="reset();" class="pure-menu-link" >❌ Effacer / Recommencer</a></li>
        </div>
    </div>
    <div id="main">
      <div class="header">
        <h1>python.snt.nsi.xyz</h1>
        <h2 id="titre-json"></h2>
              </div>
    
      <div class="content">
        <h2 class="subhead-content">
            <cons-page></cons-page>
        </h2>
        <h2 class="content-subhead" id="text-intro"></h2>

        
    </div>
  </div>
  <script>
        // Définir les variables JS
        <?php if (isset($row['user_data']) && !is_null($row['user_data'])): ?>
            window.lvl=<?= json_encode($row['user_data']); ?>;
            window.nom_u = <?= json_encode($_SESSION['pseudo']) ?>;
            document.getElementById('pseudo').textContent+=window.nom_u
            document.getElementById('pseudo').style.display='block'
        <?php endif; ?>
        window.listdir = <?php echo json_encode($listdir); ?>;
        window.eleveJsonFilesCount=<?php echo json_encode($eleveJsonFilesCount); ?>;
        window.devJsonFilesCount = <?php echo $devJsonFilesCount; ?>;
        window.startJsonFilesCount = <?php echo $startJsonFilesCount; ?>;
        window.loopJsonFilesCount = <?php echo $loopJsonFilesCount; ?>;
        window.conditionJsonFilesCount = <?php echo $conditionJsonFilesCount; ?>;
        window.functionJsonFilesCount = <?php echo $functionJsonFilesCount; ?>;
        let sum = 0
        for (let i=0;i<eleveJsonFilesCount.length;i++) {
            sum+=eleveJsonFilesCount[i]
        }
        document.getElementById('eleve').querySelector('a').textContent=`💻 Les ${sum} codés`
        <?php if (isset($_SESSION['id'])): ?>
          document.getElementById('reset').querySelector('a').textContent="❌ Se déconnecter"
          document.getElementById('timer').style.display='none'
          document.getElementById('log').style.display='none'
          <?php if ($_SESSION['admin']===1):?>
              document.getElementById("gestion").style.display='block'
          <?php endif;?>
        <?php endif;?>
        <?php if (isset($_SESSION['session_name'])): ?>
            document.getElementById('reset').querySelector('a').textContent="❌ Sortir de la session"
            window.folder=<?= json_encode($_SESSION['folder']);?>;
            document.getElementById('session').querySelector('a').href=`./play.php?r=${window.folder}&p=1`
        <?php endif;?>
        let lvl
        if (localStorage.getItem('lvl') !== null) {
	        lvl = JSON.parse(localStorage.getItem('lvl'))
            localStorage.setItem('lvl',JSON.stringify(lvl))
        } else {
	        lvl = {"start":[], "loop":[], "condition":[], "function":[], "dev":[]};
            localStorage.setItem('lvl',JSON.stringify(lvl))
        };
        if (lvl['start'].length===window.startJsonFilesCount) {
            document.getElementById('start').classList.remove('menu-ko')
            document.getElementById('start').classList.add('menu-ok')
            document.getElementById('start').querySelector('a').textContent="🟢 Débuter"
        }
        if (lvl['loop'].length===window.loopJsonFilesCount) {
            document.getElementById('loop').classList.remove('menu-ko')
            document.getElementById('loop').classList.add('menu-ok')
            document.getElementById('loop').querySelector('a').textContent="🟢 Les boucles"
        }
        if (lvl['condition'].length===window.conditionJsonFilesCount) {
            document.getElementById('condition').classList.remove('menu-ko')
            document.getElementById('condition').classList.add('menu-ok')
            document.getElementById('condition').querySelector('a').textContent="🟢 Les tests conditionnels"
        }
        if (lvl['function'].length===window.functionJsonFilesCount) {
            document.getElementById('function').classList.remove('menu-ko')
            document.getElementById('function').classList.add('menu-ok')
            document.getElementById('function').querySelector('a').textContent="🟢 Les fonctions"
        }
        if (lvl['dev'].length===window.devJsonFilesCount) {
            document.getElementById('dev').classList.remove('menu-ko')
            document.getElementById('dev').classList.add('menu-ok')
            document.getElementById('dev').querySelector('a').textContent="🟢 Dev"
        }
        if (window.devJsonFilesCount>1) {
            document.getElementById('dev').style.display = 'block'
        } else {
            document.getElementById('dev').style.display = 'none'
        }
        <?php if (isset($_SESSION['folder'])):?>
          document.getElementById('session').style.display="block"
          document.getElementById('log').style.display='none'
        <?php endif;?>
    </script>
  <script src="./css/ui.js"></script>
<script>

function reset() {
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
}
if (document.getElementById('timer').style.display==='block') {
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
}
</script>
</body></html>