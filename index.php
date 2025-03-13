<?php

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
        <a class="pure-menu-heading" href="https://python.snt.nsi.xyz/index.php">Découvrir Python au lycée</a>
          <ul class="pure-menu-list">
            <li class="menu-ko" id="start"><a href="https://python.snt.nsi.xyz/play.php?r=start&p=1" class="pure-menu-link">🟠 Débuter</a></li>
            <li class="menu-ko" id="loop"><a href="https://python.snt.nsi.xyz/play.php?r=loop&p=1" class="pure-menu-link">🟠 Les boucles</a></li>
            <li class="menu-ko" id="condition"><a href="https://python.snt.nsi.xyz/play.php?r=condition&p=1" class="pure-menu-link">🟠 Les tests conditionnels</a></li>
            <li class="menu-ko" id="function"><a href="https://python.snt.nsi.xyz/play.php?r=function&p=1" class="pure-menu-link">🟠 Les fonctions</a></li>
            <li class="menu-ko" id="dev"><a href="https://python.snt.nsi.xyz/play.php?r=dev&p=1" class="pure-menu-link">🟠 Dev</a></li>
            <li class="pure-menu-item-help"><a href="https://github.com/nsi-xyz/py.snt.nsi.xyz" class="pure-menu-link">🔷 Créer un niveau</a></li>
          </ul>
      </div>            <div class="menu-bottom"><li class="pure-menu-item-timer">Il reste <timer>60</timer> minutes</li>
            <li class="pure-menu-item-reset"><a onclick="reset();" class="pure-menu-link">❌ Effacer / Recommencer</a></li></div>
    </div>
    <div id="main">
      <div class="header">
        <h1>python.snt.nsi.xyz</h1>
        <h2>Découvrir python en lycée 🐍</h2>
      </div>
      <div class="content">
        <h2 class="content-subhead">Bienvenue sur python.snt.nsi.xyz ! 🎉</h2>
        <p class="p-content">Au collège, tu as utilisé Scratch pour programmer avec des blocs. En seconde, tu découvres Python, un langage très utilisé en science et en technologie<br>Ici, tu ne vas pas écrire de code, mais apprendre à le lire et le comprendre. En observant un programme et en suivant les instructions, tu verras comment un ordinateur exécute du code. Pour cela, tu utiliseras simplement les touches de ton clavier pour te déplacer dans une grille.<br>Prêt à <a href="https://python.snt.nsi.xyz/play.php?r=start&p=1" class="link">débuter sur Python</a> ? 🚀</p>
        <h2 class="content-subhead">Les boucles : quand Python tourne en rond (mais avec intelligence)</h2>
        <p class="p-content">Quand un programme exécute plusieurs fois la même action, il ne va pas tout réécrire à la main (il n’a pas que ça à faire, et toi non plus !). Il utilise une boucle : une sorte de tourniquet qui répète des instructions tant qu’on ne lui dit pas d’arrêter.<br>Par exemple, pour avancer de 10 cases, au lieu d’écrire "avance" dix fois, on dit à Python de le faire en boucle. Magique, non ? 🔄✨<br>Tu veux voir ça en action ? C’est par ici 👉 <a href="https://python.snt.nsi.xyz/play.php?r=loop&p=1" class="link">Explorer les boucles</a></p>
        <h2 class="content-subhead">Les tests conditionnels : quand Python doit faire un choix 🐭🧀</h2>
        <p class="p-content">Un programme, c’est comme une petite souris face à un morceau de fromage : elle doit décider. Si le fromage est là, elle le grignote. Sinon, elle repart bredouille (ou se fait piéger).<br>En Python, ces choix se font grâce aux tests conditionnels. On pose une question ("Le fromage est-il là ?") et on agit en fonction de la réponse.<br>Prêt à voir Python éviter les pièges ? C’est par ici  👉 <a href="https://python.snt.nsi.xyz/play.php?r=condition&p=1" class="link">Explorer les conditions</a> </p>
        <h2 class="content-subhead">Les fonctions : quand Python devient un super-héros 🦸‍♂️</h2>
        <p class="p-content">Un super-héros ne réfléchit pas à chaque fois qu’il doit sauver quelqu’un : il enfile son costume, saute dans l’action et applique ses techniques secrètes. 🦸‍♀️💥<br>En Python, une fonction, c’est pareil : on lui apprend une mission (comme voler ou lancer une toile 🕸️), et ensuite, il suffit de l’appeler pour qu’elle fasse le boulot automatiquement !<br>Prêt à voir Python devenir un héros du code ? C’est par ici 👉 <a href="https://python.snt.nsi.xyz/play.php?r=function&p=1" class="link">Explorer les fonctions</a></p>
        <h2 class="content-subhead">Amusez-vous !</h2>
        <p class="p-content">Sur ce site, tu vas apprendre à <a class="link" href="https://python.snt.nsi.xyz/play.php?r=start&p=1">lire et comprendre</a> du code Python en suivant des instructions. En te déplaçant dans une grille avec les flèches, tu verras comment Python <a href="https://python.snt.nsi.xyz/play.php?r=loop&p=1" class="link">utilise des boucles</a>, fait des <a href="https://python.snt.nsi.xyz/play.php?r=condition&p=1" class="link">choix conditionnels</a> et <a href="https://python.snt.nsi.xyz/play.php?r=function&p=1" class="link">exécute des fonctions</a>. À chaque étape, tu suivras les consignes données par le code pour comprendre son fonctionnement. Et ne t’inquiète pas si tu fais une erreur, ce n’est pas grave ! Tu peux toujours recommencer, l’important c’est d’apprendre et de progresser à ton rythme</p>
        </div>
    </div>
    <div class="footer">
      <p class="footer-content">Une idée de Vincent ROBERT, enseignant de spécialité NSI au Lycée Louis Pasteur d'Avignon, librement inspiré de <a href="https://compute-it.toxicode.fr/?progression=python" class="link">compute-it</a>.</p>
      <p class="footer-content">Développé par Vivien G.R. au cours de l'année 2024-2025 dans le cadre d'un projet de spécialité NSI. Version 0.99.</p>
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
  <script> function reset(){localStorage.removeItem('lvl') ;window.location.reload()}</script>
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
window.devJsonFilesCount = <?php echo $devJsonFilesCount; ?>;

let lvl = JSON.parse(localStorage.getItem('lvl'))
if (lvl['start'][lvl['start'].length-1]===0) {
    document.getElementById('start').classList.remove('menu-ko')
    document.getElementById('start').classList.add('menu-ok')
    document.getElementById('start').querySelector('a').textContent="🟢 Débuter"
}
if (lvl['loop'][lvl['loop'].length-1]===0) {
    document.getElementById('loop').classList.remove('menu-ko')
    document.getElementById('loop').classList.add('menu-ok')
    document.getElementById('loop').querySelector('a').textContent="🟢 Les boucles"
}
if (lvl['condition'][lvl['condition'].length-1]===0) {
    document.getElementById('condition').classList.remove('menu-ko')
    document.getElementById('condition').classList.add('menu-ok')
    document.getElementById('condition').querySelector('a').textContent="🟢 Les tests conditionnels"
}
if (lvl['function'][lvl['function'].length-1]===0) {
    document.getElementById('function').classList.remove('menu-ko')
    document.getElementById('function').classList.add('menu-ok')
    document.getElementById('function').querySelector('a').textContent="🟢 Les fonctions"
}
if (lvl['dev'][lvl['dev'].length-1]===0) {
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