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

if (include 'base.php') {
    if ($_SERVER['REQUEST_METHOD']==='POST') {
        if (isset($_POST['create'])) {
            global $conn;
            $username=$_POST['username'];
            $mdp=trim($_POST['mdp']);
            $test=$conn->prepare("SELECT user_name FROM logUsers WHERE user_name=?");
            $test->bind_param("s",$username);
            $test->execute();
            $r_test=$test->get_result();
            if ($r_test->num_rows===0) {
                $hash_mdp=password_hash($mdp, PASSWORD_DEFAULT);
                $sql=$conn->prepare("INSERT INTO logUsers (user_name,user_mdp,reg_date) VALUES (?,?,NOW())");
                if ($sql) {
                    $sql->bind_param("ss",$username,$hash_mdp);
                    if ($sql->execute()) {
                    } else {
                    }
                } else {
                }
            } else {
                $erreur=1;
            }
        } elseif (isset($_POST['search'])) {
            global $conn;
            $username=$_POST['username'];
            $mdp=trim($_POST['mdp']);
            $sql=$conn->prepare("SELECT * FROM logUsers WHERE user_name=?");
            if ($sql) {
                $sql->bind_param("s",$username);
                if ($sql->execute()) {
                    $result=$sql->get_result();
                    if ($result->num_rows>0) {
                        $row=$result->fetch_assoc();
                        if (password_verify($mdp,$row['user_mdp'])) {
                            $_SESSION['id']=$row['id'];
                            $_SESSION['pseudo']=$row['user_name'];
                            $_SESSION['admin']=$row['admin'];
                            header("Location: play.php?r=start&p=1");
                        } else {
                            echo "mdp faux<br>";
                        }
                    } else {
                        echo "le compte n'existe pas<br>";
                    }
                } else {
                }
            } else {
            }
        } elseif (isset($_POST['join'])) {
            $code_session=$_POST['c_session'];
            $user_pseudo=$_POST['p_session'];
            $sql=$conn->prepare("SELECT session_name FROM sessions WHERE statut='active' AND session_code=?");
            $sql->bind_param("s",$code_session);
            $sql->execute();
            $result=$sql->get_result();
            if ($result->num_rows === 1) {
                $row=$result->fetch_assoc();
                $table_name=$row['session_name'];
                $test="SELECT user_pseudo FROM `$table_name` WHERE user_pseudo=?";
                $tests=$conn->prepare($test);
                $tests->bind_param("s",$user_pseudo);
                $tests->execute();
                $test_result=$tests->get_result();
                if ($test_result->num_rows === 0) {
                    $join_session="INSERT INTO `$table_name` (user_pseudo,user_last_connexion) VALUES (?,NOW())";
                    $join=$conn->prepare($join_session);
                    $join->bind_param("s",$user_pseudo);
                    if ($join->execute()) {
                        session_unset();
                        $sql=$conn->prepare("SELECT folder FROM sessions WHERE session_name=?");
                        $sql->bind_param("s",$table_name);
                        $sql->execute();
                        $response=$sql->get_result();
                        $folder_concerned=$response->fetch_assoc();
                        $_SESSION['folder']=$folder_concerned['folder'];
                        $_SESSION['session_name']=$table_name;
                        $_SESSION['pseudo']=$user_pseudo;
                        $folder_session=$_SESSION['folder'];
                        $_SESSION['delete']=1;
                        header("Location: play.php?r=$folder_session&p=1");
                    }
                } elseif ($test_result->num_rows === 1 && isset($_COOKIE['userPseudo']) && $_COOKIE['userPseudo'] === $user_pseudo) {
                    $sql=$conn->prepare("SELECT folder FROM sessions WHERE session_name=?");
                    $sql->bind_param("s",$table_name);
                    $sql->execute();
                    $response=$sql->get_result();
                    $folder_concerned=$response->fetch_assoc();
                    $_SESSION['folder']=$folder_concerned['folder'];
                    $_SESSION['session_name']=$table_name;
                    $_SESSION['pseudo']=$user_pseudo;
                    $folder_session=$_SESSION['folder'];
                    $_SESSION['delete']=1;
                    header("Location: play.php?r=$folder_session&p=1");
                } else {
                    $failed=1;
                }
            }
        }
    }
    $conn->close();
}

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
            <li class="menu-ko" id="start"><a href="./play.php?r=start&p=1" class="pure-menu-link">🟠 Débuter</a></li>
            <li class="menu-ko" id="loop"><a href="./play.php?r=loop&p=1" class="pure-menu-link">🟠 Les boucles</a></li>
            <li class="menu-ko" id="condition"><a href="./play.php?r=condition&p=1" class="pure-menu-link">🟠 Les tests conditionnels</a></li>
            <li class="menu-ko" id="function"><a href="./play.php?r=function&p=1" class="pure-menu-link">🟠 Les fonctions</a></li>
            <li class="menu-ko" id="dev"><a href="./play.php?r=dev&p=1" class="pure-menu-link">🟠 Dev</a></li>
            <li id="eleve"><a href="./eleve.php" class="pure-menu-link"> </a></li>
            <li class="pure-menu-item menu-item-divided pure-menu-item-login" id="log"><a class="pure-menu-link" href="./login.php">&#x1F464; Se connecter</a></li>
            <li class="pure-menu-item menu-item-divided pure-menu-item-login" id="gestion" style="display:none;"><a class="pure-menu-link" href="./csession.php" >&#x1F464; Gestion</a></li>
            <li class="pure-menu-item-help"><a href="https://github.com/nsi-xyz/py.snt.nsi.xyz" class="pure-menu-link">🔷 Créer un niveau</a></li>
          </ul>
      </div>            
      <div class="menu-bottom">
        <li class="pure-menu-item-timer" id="timer">Il reste <timer>60</timer> minutes</li>
            <li class="pure-menu-item-reset" id="reset"><a onclick="reset();" class="pure-menu-link">❌ Effacer / Recommencer</a></li>
          </div>
    </div>
    <div id="main">
      <div class="header">
        <h1>python.snt.nsi.xyz</h1>
        <h2>Découvrir python en lycée 🐍</h2>
      </div>
      <div class="content">
      <h2 id="S'identifier" class="content-subhead">S'identifier</h2>
        <p class="p-content">Créer facilement un compte pour sauvgarder votre progression sur le site et pouvoir la retrouver de n'importe où.</p>
        <p class="p-content">Vous pouvez aussi juste naviguer sur le site sans vous connecter mais la progression ne sera pas sauvgardée durablement.</p>
        <msg></msg>
        <section class="forms">
                      <div class="form">
              <form method="POST" class="pure-form pure-form-stacked">
                <fieldset>
                  <legend>Se connecter</legend>
                  <div class="form-group">
                    <label for="pseudo">Nom d'utilisateur</label>
                    <input type="text" id="pseudo" name="username" placeholder="Nom d'utilisateur" required pattern="^(?![\-' .])(?!.*[\-'.]{3})(?!.* {2})(?!.*\.\.)(?!.*[\-']$)[A-Za-zÀ-ÖØ-öø-ÿ' .\-]+[.]?$" minlength="3" maxlength="24" />
                  </div>
                  <div class="form-group">
                    <label for="code">Mot de passe</label>
                    <input type="password" id="code" name="mdp" placeholder="Mot de passe" required minlength="1" />
                  </div>
                </fieldset>
                <button type="submit" class="pure-button pure-button-primary-join" name="search">Connexion</button>
              </form>
                          </div>
            <div class="form">
              <form method="POST" class="pure-form pure-form-stacked">
                <fieldset>
                  <legend>Créer un compte</legend>
                  <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required minlength="3" maxlength="16" />
                  </div>
                  <div class="form-group">
                    <label for="stacked-password">Mot de passe</label>
                    <input type="password" id="stacked-password" name="mdp" placeholder="Mot de passe" required minlength="1" maxlength="32" />
                  </div>
                </fieldset>
                <button type="submit" class="pure-button pure-button-primary-join" name="create">Créer le compte</button>
                <div id="alert" style="color:red;display:none;">Ce pseudo existe déjà</div>
              </form>
                          </div>

                <div class="form">
              <form method="POST" class="pure-form pure-form-stacked">
                <fieldset>
                  <legend>Rejoindre une session</legend>
                  <div class="form-group">
                    <label for="username">Pseudo</label>
                    <input type="text" name="p_session" placeholder="Pseudo" required minlength="3" maxlength="16" />
                  </div>
                  <div class="form-group">
                    <label for="stacked-password">Code de la session</label>
                    <input type="text" name="c_session" placeholder="Code de la session" required minlength="1" maxlength="32" />
                  </div>
                </fieldset>
                <button type="submit" class="pure-button pure-button-primary-join" name="join">Rejoindre la session</button>
                <div id="alert_s" style="color:red;display:none;">Ce pseudo existe déjà</div>
              </form>
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
    document.getElementById('timer').style.display='none'
    document.getElementById('log').style.display='none'
    <?php if ($_SESSION['admin']===1):?>
        document.getElementById("gestion").style.display='block'
    <?php endif;?>
<?php endif;?>
<?php if (isset($_SESSION['session_name'])): ?>
    document.getElementById('reset').querySelector('a').textContent="❌ Sortir de la session"
    document.getElementById('timer').style.display='none'
    document.getElementById('log').style.display='none'
<?php endif;?>
<?php if (isset($erreur)): ?>
    document.getElementById('alert').style.display='block'
<?php endif;?>
<?php if (isset($failed)): ?>
    document.getElementById('alert_s').style.display='block'
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


</script>
</body></html>