let pos
let t_grille = 5
let grille = [];
let pos_ori={}
let parcours=[]
let consignes={}
let lvl
let inelem = window.r
let stop
let niv = window.p
let dic_affich = {};
let traduc_parcours = {
    "←":"ArrowLeft",
    "→":"ArrowRight",
    "↑":"ArrowUp",
    "↓":"ArrowDown"
}

if (localStorage.getItem('lvl') !== null) {
	lvl = JSON.parse(localStorage.getItem('lvl'))
    localStorage.setItem('lvl',JSON.stringify(lvl))
} else {
	lvl = {"start":[], "loop":[], "condition":[], "function":[]};
    localStorage.setItem('lvl',JSON.stringify(lvl))
};



for (let i = 0;i<t_grille;i++) {
    grille.push([])
    for (let j = 0;j<t_grille;j++) {
        grille[i].push(0);
    };
};
fetch(`./${inelem}/${window.jsonFile}`)
    .then(res => res.json())
    .then(infos => {
        pos_ori=infos["position_depart"]
    });



class case_js extends HTMLElement {
    constructor() {
        super();
        fetch(`./${inelem}/${window.jsonFile}`) 
            .then(res => res.json())
            .then(infos => {
                let set_g = infos["grille"]
                for (let i = 0;i<t_grille;i++) {
                    for (let j = 0;j<t_grille;j++) {
                        let conteneur = document.getElementById('conteneur')
                        conteneur.style.gridTemplateColumns = 'repeat(5, 1fr)';
                        conteneur.style.gridTemplateRows = 'repeat(5, 1fr)'; 
                        let test = document.createElement("div");
                        test.id = `case${i*t_grille+j+1}`;
                        test.classList.add('disque')
                        this.appendChild(test)
                        let style = document.createElement("style");
                        if (!avec_emo(set_g[t_grille*i+j]) || set_g[t_grille*i+j][0] ==="#") {
                            style.innerHTML += `#case${i*t_grille+j+1} {background-color:${set_g[t_grille*i+j]||"#CBCBCB"};}`
                        } else {
                            test.innerHTML = set_g[t_grille*i+j]
                            test.classList.add('emoji')
                            style.innerHTML += `#case${i*t_grille+j+1} {justify-content:center;align-items:center;display:flex; font-size:2.2em;}`
                        }
                        conteneur.appendChild(style)
                        dic_affich[`${j},${i}`]=document.getElementById(`case${i*t_grille+j+1}`);
                    };
                };
            },)
    };
};

class instru_js extends HTMLElement {
    constructor() {
        super();
        fetch(`./${inelem}/${window.jsonFile}`) 
            .then(res => res.json())
            .then(infos => {
                let consignes = infos["script"]
                for (let i = 0;i<infos["parcours"][0].length;i++) { 
                    parcours.push(traduc_parcours[infos["parcours"][0][i]])
                }
                for (let i = 0;i<consignes.length;i++) {
                    let test = document.createElement("div");
                    test.id = `instru${i+1}`;
                    let space=0
                    if (consignes[i].slice(0,1) ===" ") {
                        while (consignes[i].slice(space,space+1) === " ") {
                            space++;
                        }   
                        console.log('space',space)
                    }
                    if (consignes[i].slice(space,space+2) === 'if' || consignes[i].slice(space,space+4) === 'elif') {
                        console.log('true')
                        let ifelif =0
                        if (consignes[i].slice(space,space+4) === 'elif') {
                            ifelif = 2
                        }
                        if (consignes[i].slice(space+3+ifelif,space+6+ifelif) === 'not') {
                            let couleur=consignes[i].slice(space+7+ifelif,consignes[i].indexOf(":"))
                            console.log(couleur)
                            let posi = consignes[i].indexOf(couleur)
                            let str = consignes[i].slice(0,posi)
                            console.log(str)
                            if (avec_emo(couleur)) {
                                str=str+`<div style='height:15px;width:15px;display:inline-block;'>${couleur}</div>`+" :"
                            } else {
                                str=str+`<div style='height:15px;width:15px;background-color:${couleur};border-radius:50%;display:inline-block;'></div>`+":"
                            }
                            console.log(str)
                            test.innerHTML = str
                        } else {
                            let couleur=consignes[i].slice(space+3+ifelif,consignes[i].indexOf(":"))
                            console.log(couleur)
                            let posi = consignes[i].indexOf(couleur)
                            let str = consignes[i].slice(0,posi)
                            console.log(str)
                            if (avec_emo(couleur)) {
                                str=str+`<div style='height:15px;width:15px;display:inline-block;'>${couleur}</div>`+" :"
                            } else {
                                str=str+`<div style='height:15px;width:15px;background-color:${couleur};border-radius:50%;display:inline-block;'></div>`+":"
                            }
                            console.log(str)
                            test.innerHTML = str
                        }
                    } else {
                        test.innerHTML = consignes[i]
                    }
                    this.appendChild(test)
                }
        
            });
        
    };
};

class menu_lvl extends HTMLElement {
    constructor() {
        super();
        for (let i = 0;i<jsonFilesCount;i++) { 
            let test = document.createElement("div");
            test.id = `menu${i+1}`;
            if (i<9) {
                test.innerHTML = `0${i+1}`
            } else {
                test.innerHTML = `${i+1}`
            }
            this.classList.add('table')
            test.classList.add('td-any')
            if (lvl[inelem].includes(i+1)) {
                test.classList.add('ok')
            } else {
                test.classList.add('ko')
            }
            if (niv === i+1) {
                test.classList.add('now')
             }
            test.setAttribute("onclick", `location.href='https://python.snt.nsi.xyz/play.php?r=${inelem}&p=${i+1}'`);
            this.appendChild(test)
        }
        
    };
};


customElements.define("const-js", case_js);
customElements.define("instru-js", instru_js);
customElements.define("menu-lvl", menu_lvl);

function affich_gr(move,color) {
    if (move==="ArrowLeft") {
        grille[pos[1]][pos[0]] = 0
        pos[0]-=1
        if (pos[0]<0) {
            pos[0] = t_grille-1
        }
        grille[pos[1]][pos[0]] = 1
    } else if (move==="ArrowRight") {
        grille[pos[1]][pos[0]] = 0
        pos[0]+=1
        if (pos[0]>t_grille-1) {
            pos[0] = 0
        }
        grille[pos[1]][pos[0]] = 1
    } else if (move==="ArrowDown") {
        grille[pos[1]][pos[0]] = 0
        pos[1]+=1
        if (pos[1]>t_grille-1) {
            pos[1] = 0
        }
        grille[pos[1]][pos[0]] = 1
    } else if (move==="ArrowUp") {
        grille[pos[1]][pos[0]] = 0
        pos[1]-=1
        if (pos[1]<0) {
            pos[1] = t_grille-1
        }
        grille[pos[1]][pos[0]] = 1
    };
    if (color) {
        if (avec_emo(color)) {
            dic_affich[String(pos)].innerHTML=color
            dic_affich[String(pos)].style.backgroundColor="#FFFFFF"
            dic_affich[String(pos)].style.fontSize="2.2em"
            dic_affich[String(pos)].style.justifyContent="center"
            dic_affich[String(pos)].style.display="flex"
            dic_affich[String(pos)].style.alignItems="center"
        } else {
            dic_affich[String(pos)].style.backgroundColor=color
        }
    }
};


function lvl_jeu(matrice_lvl) {
    let prog = 0;
    document.addEventListener("keyup",jeu);
    function jeu(event) {
        if (event.key==="ArrowUp" || event.key==="ArrowDown" || event.key==="ArrowRight" || event.key==="ArrowLeft") {
            if (event['key']===matrice_lvl[prog] && prog+1===matrice_lvl.length) {
                affich_gr(event['key'],"#7CB342");
                if (!lvl[inelem].includes(niv)) {
                    lvl[inelem].push(niv)
                }
                if (lvl[inelem].length===window.jsonFilesCount) {
                    lvl[inelem].push(0)
                }
                localStorage.setItem("lvl",JSON.stringify(lvl))
                document.removeEventListener("keyup",jeu);
                if (niv < jsonFilesCount) {
                    wait(1500,lvl[inelem][lvl[inelem].length-1]+1)
                } else  {
                    wait(1500)
                }
            } else if (event['key']!==matrice_lvl[prog]) {
                affich_gr(event['key'],'⛔')
                document.removeEventListener("keyup",jeu);
                wait(1500)
            } else if (event['key']===matrice_lvl[prog]) {
                affich_gr(event['key'],'');
            };
            prog++;
        }
    };

};

function set_grille() {
    grille[pos_ori[1]][pos_ori[0]] = 1;
    pos = pos_ori
    dic_affich[String(pos)].style.borderColor="#000000"
};

function wait(ms,n_lvl=0) {
    if (n_lvl===0) { 
        setTimeout(() => {window.location.reload()}, ms);
    } else {
        setTimeout(() => {window.location.href=`https://python.snt.nsi.xyz/play.php?r=${inelem}&p=${n_lvl}`}, ms);
    }
};

function reset() {
    localStorage.removeItem('lvl')
    window.location.reload()
}

function avec_emo(str) {
    const test_emo = /[\p{Extended_Pictographic}]/gu;
    return test_emo.test(str);
}

function ajusterTailleEmoji() {
    console.log("ousp")
    const items = document.querySelectorAll('.emoji');
    items.forEach(item => {
    if (item.textContent.trim()) { // Vérifie que le div contient bien un emoji
        const size = item.clientWidth; // Taille du carré
        console.log(size)
        item.style.fontSize = `${size * 0.9}px`; // Ajuste la taille de l'emoji
    }
    });
}

fetch(`./${inelem}/00.json`)
    .then(res => res.json())
    .then(infos => {
        document.getElementById('titre-json').innerHTML=infos["titre"]
    },)


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
if (document.getElementById(inelem).classList.contains('menu-ko')) {
    console.log('jsp')
    document.getElementById(inelem).classList.remove('menu-ko')
    document.getElementById(inelem).classList.add('menu-now-ko')
} else {
    console.log('pourquoi')
    document.getElementById(inelem).classList.remove('menu-ok')
    document.getElementById(inelem).classList.add('menu-now-ok')
}



fetch(`./${inelem}/${window.jsonFile}`)
    .then(res => res.json())
    .then(infos => {
        if ("texte" in infos) {
            document.getElementById("text-intro").innerHTML=infos["texte"]
        }
        pos_ori=infos["position_depart"]
        set_grille()
        lvl_jeu(parcours);
        let sens = 1
        let zoom = 0
        var actu = String(pos)
        console.log("oui",String(pos))
        stop = setInterval(() => {
            if (actu!==String(pos)) {
                dic_affich[actu].style.transform=`scale(${1})`
            } else {
                if (sens === 1 && zoom<0.2) { 
                    zoom+=0.0225
                    dic_affich[String(pos)].style.transform=`scale(${1+zoom})`
                } else if (sens === 0 && zoom>0) {
                    zoom-=0.0225
                    dic_affich[String(pos)].style.transform=`scale(${1+zoom})`
                } else {
                    sens=1-sens
                }
            }
            actu = String(pos)
        }, 75);
    });

/*
symbole quand l'on gagne
mieux placer les instruction du script
*/