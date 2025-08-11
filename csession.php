<?php




$session = isset($_GET['session']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['session']) : '';

$table="sessions";
if (isset($session) && $session !== '') {
    $table=$session;
    
}

include 'base.php';

if (!isset($_SESSION['id']) || $_SESSION['admin'] === 0) {
    header("Location: play.php?r=start&p=1");
    exit;
}

global $conn;



$sql="SELECT * FROM $table";
$result=$conn->query($sql);
$rows = []; 
while ($r = $result->fetch_assoc()) {
    $rows[] = $r; 
}

if (isset($session) && $session !== '') {
    $request="SELECT folder FROM sessions WHERE session_name='$table'";
    $result=$conn->query($request);
    $dir=$result->fetch_assoc();
    $direc= $dir['folder'];
    $directory = __DIR__ . "/$direc";
    $jsonFilesCount = 0;
    if (is_dir($directory)) {
        $files = glob($directory . "/[0-9][0-9].json");

        $files = array_filter($files, function($file) {
            return basename($file) !== '00.json';
        });

        $jsonFilesCount = count($files);
    }
    
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    global $conn;    
    $conn->set_charset("utf8mb4");
    $test=$conn->prepare("UPDATE sessions SET statut='terminée' WHERE session_name=?");
    $test->bind_param("s",$_GET['session']);
    $test->execute();
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
        <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc !important; padding: 8px; text-align: center; }
        .niv_ko {display:flex;aspect-ratio: 1; justify-content: center;  align-items: center; background-color: #FF9800; border: 0.5px solid black;width:9.7%;}
        .niv_ok {display:flex;aspect-ratio: 1; justify-content: center;  align-items: center; background-color: #7CB342; border: 0.5px solid black;width:9.7%;}
        </style>
      <div class="content" id="general" style="display:block;">
      <h2 id="S'identifier" class="content-subhead">Gérer les sessions</h2>
        <p class="p-content">Depuis cette page vous pouvez gérer les différentes sessions et voir leurs statistiques.</p>
        <msg></msg>
        <table id="sessions_table" style="">
        <thead>
        <tr>
        <th>Hôte</th>
        <th>Nom</th>
        <th>Code</th>
        <th>Dossier</th>
        <th>Statut</th>
        <th>Date de création</th>
        <th>Gestion des session</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
            </div>
        <div class="content" id="view_session" style="display:none;">
        <h2 id="S'identifier" class="content-subhead">Statistiques de la session</h2>
        <msg></msg>
        <table id="session_table" style="">
        <thead>
        <tr>
        <th>Pseudo</th>
        <th style="width:450px;">Progrès</th>
        <th>Dernière connexion</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
        <h2 id="" class="content-subhead">Fermer la session</h2>
        <p class="p-content">Si vous fermer la session les utilisateurs actuels seront déconnectés et personne ne pourras s'y reconnecter.</p>
        <form method="POST">
            <input type="hidden" name="statut" value="close">
        <button type="submit" class="pure-button" style="background-color: rgb(255, 0, 0); border-radius: 4px; text-shadow: rgba(0, 0, 0, 0.2) 0px 1px 1px; color: white;">Fermer la session</button>
        </form>


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
<?php if (isset($erreur)): ?>
    document.getElementById('alert').style.display='block'
<?php endif;?>
<?php if (isset($_GET['session']) && $_GET['session']!==''): ?>
    document.getElementById('general').style.display="none"
    document.getElementById('view_session').style.display="block"
<?php endif; ?>
let infos = <?= json_encode($rows);?>;
<?php if (isset($direc)): ?>;
    let folder_data=<?= json_encode($direc); ?>;
<?php endif;?>


<?php if (!isset($_GET['session']) || $_GET['session']===''):?>
    const nbLignes = infos.length; 
    const tbody = document.querySelector("#sessions_table tbody");

    for (let i = 0; i < nbLignes; i++) {
        const row = document.createElement("tr");

        const hote = document.createElement("td");
        hote.textContent = infos[i]["creator_name"];

        const session_name = document.createElement("td");
        session_name.textContent = infos[i]["session_name"];

        const session_code = document.createElement("td");
        session_code.textContent = infos[i]["session_code"];

        const session_folder = document.createElement("td");
        session_folder.textContent = infos[i]["folder"];

        const session_statut = document.createElement("td");
        if (infos[i]["statut"] === "active") {
            session_statut.textContent = `🟢 ${infos[i]["statut"]}`;
        } else {
            session_statut.textContent = `🔴 ${infos[i]["statut"]}`;
        }

        const creation_date = document.createElement("td");
        let heure = infos[i]["date_creation"].slice(8,10)+"/"+infos[i]["date_creation"].slice(5,7)+"/"+infos[i]["date_creation"].slice(0,4)+" ("+infos[i]["date_creation"].slice(-8)+")"
        creation_date.textContent = heure;

        const conteneur = document.createElement('td');
        const gestion = document.createElement("button");
        gestion.textContent = "Gestion de la session"
        gestion.style.backgroundColor="rgb(66, 184, 221)";
        gestion.style.borderRadius="4px"
        gestion.style.textShadow="0 1px 1px rgba(0, 0, 0, 0.2)"
        gestion.style.color="white"
        gestion.classList.add('pure-button')
        gestion.onclick = () => window.location.href = `./csession.php?session=${infos[i]["session_name"]}`;
        conteneur.appendChild(gestion)
        row.appendChild(hote);
        row.appendChild(session_name);
        row.appendChild(session_code);
        row.appendChild(session_folder);
        row.appendChild(session_statut);
        row.appendChild(creation_date);
        row.appendChild(conteneur);
        tbody.appendChild(row);
    }
<?php endif;?>

<?php if (isset($_GET['session']) && $_GET['session']!==''):?>
    let JsonFilesCount = <?php echo $jsonFilesCount;?>;
    const nbLignes = infos.length; 
    const tbody = document.querySelector("#session_table tbody");

    for (let i = 0; i < nbLignes; i++) {
        const row = document.createElement("tr");
        const session_name = document.createElement("td");
        session_name.textContent = infos[i]["user_pseudo"];
        const user_data = document.createElement("td");
        user_data.style.padding="0px"
        user_data.style.width="450px"
        let conteneur = document.createElement("div")
        conteneur.style.display="flex"
        conteneur.style.flexWrap="wrap"
        conteneur.style.alignItems="center"
        conteneur.style.overflow="visible"
        conteneur.style.width="100%"
        conteneur.style.boxSizing = "border-box"

        user_data.appendChild(conteneur)

        for (let j=0;j<JsonFilesCount;j++) {
            let temp = document.createElement("div")
            temp.innerHTML=j+1
            let data=JSON.parse(infos[i]["user_data"]);
            if (data !== null && typeof data[folder_data] !== "undefined" && data[folder_data].includes(j+1)) {
                temp.classList.add("niv_ok");
            } else {
                temp.classList.add("niv_ko");
            }
            temp.classList.add("niv_ko");
            conteneur.appendChild(temp)
        }


        const creation_date = document.createElement("td");
        let heure = infos[i]["user_last_connexion"].slice(8,10)+"/"+infos[i]["user_last_connexion"].slice(5,7)+"/"+infos[i]["user_last_connexion"].slice(0,4)+" ("+infos[i]["user_last_connexion"].slice(-8)+")"
        creation_date.textContent = heure;



        row.appendChild(session_name);
        row.appendChild(user_data);
        row.appendChild(creation_date);
        tbody.appendChild(row);
    }


<?php endif;?>
</script>
</body></html>