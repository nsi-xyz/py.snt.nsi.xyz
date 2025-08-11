const cssColorKeywords = ["aliceblue", "antiquewhite", "aqua", "aquamarine", "azure","beige", "bisque", "black", "blanchedalmond", "blue", "blueviolet", "brown", "burlywood","cadetblue", "chartreuse", "chocolate", "coral", "cornflowerblue", "cornsilk", "crimson", "cyan","darkblue", "darkcyan", "darkgoldenrod", "darkgray", "darkgreen", "darkgrey", "darkkhaki","darkmagenta", "darkolivegreen", "darkorange", "darkorchid", "darkred", "darksalmon","darkseagreen", "darkslateblue", "darkslategray", "darkslategrey", "darkturquoise", "darkviolet","deeppink", "deepskyblue", "dimgray", "dimgrey", "dodgerblue","firebrick", "floralwhite", "forestgreen", "fuchsia","gainsboro", "ghostwhite", "gold", "goldenrod", "gray", "green", "greenyellow", "grey","honeydew", "hotpink","indianred", "indigo", "ivory","khaki","lavender", "lavenderblush", "lawngreen", "lemonchiffon", "lightblue", "lightcoral", "lightcyan","lightgoldenrodyellow", "lightgray", "lightgreen", "lightgrey", "lightpink", "lightsalmon","lightseagreen", "lightskyblue", "lightslategray", "lightslategrey", "lightsteelblue","lightyellow", "lime", "limegreen", "linen","magenta", "maroon", "mediumaquamarine", "mediumblue", "mediumorchid", "mediumpurple","mediumseagreen", "mediumslateblue", "mediumspringgreen", "mediumturquoise", "mediumvioletred","midnightblue", "mintcream", "mistyrose", "moccasin","navajowhite", "navy","oldlace", "olive", "olivedrab", "orange", "orangered", "orchid","palegoldenrod", "palegreen", "paleturquoise", "palevioletred", "papayawhip", "peachpuff", "peru","pink", "plum", "powderblue", "purple","rebeccapurple", "red", "rosybrown", "royalblue","saddlebrown", "salmon", "sandybrown", "seagreen", "seashell", "sienna", "silver", "skyblue","slateblue", "slategray", "slategrey", "snow", "springgreen", "steelblue","tan", "teal", "thistle", "tomato", "turquoise","violet","wheat", "white", "whitesmoke","yellow", "yellowgreen"];
let ArrowUp = document.getElementById('ArrowUp')
let ArrowLeft = document.getElementById('ArrowLeft')
let ArrowRight = document.getElementById('ArrowRight')
let ArrowDown = document.getElementById('ArrowDown')
let pos
let t_grille = 5
let grille = [];
let pos_ori={}
let parcours=[]
let consignes={}
let inelem = window.r
let stop
let niv = window.p
let session = window.session
let lvl
let dic_affich = {};
let traduc_parcours = {
    "←":"ArrowLeft",
    "→":"ArrowRight",
    "↑":"ArrowUp",
    "↓":"ArrowDown"
}

if (localStorage.getItem("progress_sig") !== null) {
    lvl=JSON.parse(localStorage.getItem('lvl'))
    const storedSig = localStorage.getItem("progress_sig");
    console.log(storedSig)
    const expectedSig = CryptoJS.HmacSHA256(JSON.stringify(lvl), str).toString();
    console.log(expectedSig,lvl)
    if (storedSig !== expectedSig) {
        lvl = {"start":[], "loop":[], "condition":[], "function":[], "dev":[]};
        if (!(String(inelem) in lvl)) {
            lvl[inelem] = []
        }
        localStorage.setItem('lvl',JSON.stringify(lvl))
        signProgress(lvl,str);
    }
}

if (typeof window.lvl !== 'undefined') {
    console.log("aa")
    lvl = JSON.parse(window.lvl)
    if (!(String(inelem) in lvl)) {
        lvl[inelem] = []
    }
    console.log(lvl)
    localStorage.setItem('lvl',JSON.stringify(lvl))
    signProgress(lvl,str);
}

if (localStorage.getItem('lvl') !== null && ((("co" in JSON.parse(localStorage.getItem('lvl'))) && window.session===1) || ((!("co" in JSON.parse(localStorage.getItem('lvl'))) && !(window.session===1))))) {    lvl = JSON.parse(localStorage.getItem('lvl'))
    console.log("aie")
    if (!(String(inelem) in lvl)) {
        lvl[inelem] = []
    }
    localStorage.setItem('lvl',JSON.stringify(lvl))
    signProgress(lvl,str);
} else {
	lvl = {"start":[], "loop":[], "condition":[], "function":[], "dev":[]};
    if (!(String(inelem) in lvl)) {
        lvl[inelem] = []
    }
    localStorage.setItem('lvl',JSON.stringify(lvl))
    signProgress(lvl,str);
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
                            style.innerHTML += `#case${i*t_grille+j+1} {justify-content:center;align-items:center;display:flex;}`
                        }
                        conteneur.appendChild(style)
                        dic_affich[`${j},${i}`]=document.getElementById(`case${i*t_grille+j+1}`);
                        ajusterTailleEmoji()
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
                let consignes = infos["script"];
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
                    }
                    if (consignes[i].slice(space,space+2) === 'if' || consignes[i].slice(space,space+4) === 'elif' || consignes[i].slice(space,space+5) === 'while') {
                        let ifelif = 0
                        if (consignes[i].slice(space,space+4) === 'elif') {
                            ifelif = 2
                        } else if (consignes[i].slice(space,space+5) === 'while') {
                            ifelif = 3
                        }
                        if (consignes[i].slice(space+3+ifelif,space+6+ifelif) === 'not') {
                            let couleur=consignes[i].slice(space+7+ifelif,consignes[i].indexOf(":"))
                            let posi = consignes[i].indexOf(couleur)
                            let str = consignes[i].slice(0,posi)
                            if (avec_emo(couleur)) {
                                str=str+`<div style='height:15px;width:15px;display:inline-block;'>${couleur}</div>`+" :"
                            } else {
                                str=str+`<div style='height:15px;width:15px;background-color:${couleur};border-radius:50%;display:inline-block;'></div>`+":"
                            }
                            test.innerHTML = str
                        } else {
                            let couleur = consignes[i].slice(space+3+ifelif,consignes[i].indexOf(":"))
                            let posi = consignes[i].indexOf(couleur)
                            let str = consignes[i].slice(0,posi)
                            if (avec_emo(couleur)) {
                                str=str+`<div style='height:15px;width:15px;display:inline-block;'>${couleur}</div>`+" :"
                            } else if (couleur[0]==="#" || cssColorKeywords.includes(couleur)) {
                                str=str+`<div style='height:15px;width:15px;background-color:${couleur};border-radius:50%;display:inline-block;'></div>`+":"
                            } else {
                                str = consignes[i]
                            }
                            test.innerHTML = str
                        }
                    } else {
                        test.innerHTML = consignes[i]
                    }
                    this.appendChild(test)
                    if (consignes.length>12) {
                        let size=consignes.length
                        if (consignes.length>21) {
                            size=21
                        }
                        this.style.transform=`scale(${12/size})`
                        this.style.transformOrigin = "top left";
                    }
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
            let act_url=window.location.href
            let pos_inter=act_url.indexOf("?")
            let url_fin=act_url.slice(0,pos_inter)+`?r=${inelem}&p=${i+1}`
            test.setAttribute("onclick", `location.href='${url_fin}'`);
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
            dic_affich[String(pos)].classList.add('emoji')
            dic_affich[String(pos)].style.justifyContent="center"
            dic_affich[String(pos)].style.display="flex"
            dic_affich[String(pos)].style.alignItems="center"
            ajusterTailleEmoji()
        } else {
            dic_affich[String(pos)].style.backgroundColor=color
        }
    }
};


function lvl_jeu(matrice_lvl) {
    window.addEventListener('keydown', function(e) {
        const keysToBlock = ['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'Space', 'PageUp', 'PageDown'];
        if (keysToBlock.includes(e.key)) {
            e.preventDefault();
        }
    });
    let prog = 0;
    ArrowUp.addEventListener("click",take_key)
    ArrowLeft.addEventListener("click",take_key)
    ArrowRight.addEventListener("click",take_key)
    ArrowDown.addEventListener("click",take_key)
    document.addEventListener("keyup",take_key);
    function take_key(event) {
        if (event instanceof KeyboardEvent) {
            jeu(event.key)
        } else if (event instanceof PointerEvent) {
            jeu(event.target.id)
        }
        
    }
    function jeu(event) {
        if (event==="ArrowUp" || event==="ArrowDown" || event==="ArrowRight" || event==="ArrowLeft") {
            if (event===matrice_lvl[prog] && prog+1===matrice_lvl.length) {
                affich_gr(event,"#7CB342");
                if (!lvl[inelem].includes(niv)) {
                    lvl[inelem].push(niv)
                }
                localStorage.setItem("lvl",JSON.stringify(lvl))
                signProgress(lvl,str);
                const form = new FormData()
                form.append('lvl',JSON.stringify(lvl))
                fetch('save_data.php', {
                    method:'POST',
                    body:form
                })
                document.removeEventListener("keyup",take_key);
                if (niv < jsonFilesCount) {
                    wait(1500,lvl[inelem][lvl[inelem].length-1]+1)
                } else  {
                    wait(1500)
                }
            } else if (event!==matrice_lvl[prog]) {
                affich_gr(event,'⛔')
                document.removeEventListener("keyup",take_key);
                wait(1500)
            } else if (event===matrice_lvl[prog]) {
                affich_gr(event,'');
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
        let act_url=window.location.href
        let pos_inter=act_url.indexOf("?")
        let url_fin=act_url.slice(0,pos_inter)+`?r=${inelem}&p=${n_lvl}`
        setTimeout(() => {window.location.href=`${url_fin}`}, ms);
    }
};


function avec_emo(str) {
    const test_emo = /[\p{Extended_Pictographic}]/gu;
    return test_emo.test(str);
}

function ajusterTailleEmoji() {
    setInterval(() => {
        const items = document.querySelectorAll('.emoji');
        items.forEach(item => {
        if (item.textContent.trim()) { 
            const size = document.getElementById("case1").clientWidth; 
            item.style.fontSize = `${size * 0.90}px`; 
        }
        });
    }, 500)
}

function signProgress(lvl,str) {
    const signature = CryptoJS.HmacSHA256(JSON.stringify(lvl), str).toString();
    localStorage.setItem("progress_sig", signature);
    console.log(signature)
}

fetch(`./${inelem}/00.json`)
    .then(res => res.json())
    .then(infos => {
        document.getElementById('titre-json').innerHTML=infos["titre"]
    },)


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
    document.getElementById("dev").style.display = 'block'
}
if (inelem==='start' || inelem==='loop' || inelem==='condition' || inelem==='function' || inelem==='dev') {
    if (document.getElementById(inelem).classList.contains('menu-ko')) {
        document.getElementById(inelem).classList.remove('menu-ko')
        document.getElementById(inelem).classList.add('menu-now-ko')
    } else {
        document.getElementById(inelem).classList.remove('menu-ok')
        document.getElementById(inelem).classList.add('menu-now-ok')
    }
}
if (typeof window.folder !== null && window.folder === inelem) {
    console.log('ai')
    document.getElementById('session').style.backgroundColor="#1976d2"
    document.getElementById('session').classList.remove('menu-session')
    if (inelem==='start' || inelem==='loop' || inelem==='condition' || inelem==='function' || inelem==='dev') {
        if (document.getElementById(inelem).classList.contains('menu-now-ko')) {
            document.getElementById(inelem).classList.remove('menu-now-ko')
        } else {
            document.getElementById(inelem).classList.remove('menu-now-ok')
        }

    }
    
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



addEventListener('load',ajusterTailleEmoji)

/*
      MOV R0,#42
      MOV R1,#42
      MOV R2,#0
      CMP R2,R1
      BLT mult
mult:
      ADD R4,R4,R0
      ADD R2,R2,#1
      CMP R2,R1
      BLT mult
      B end
end:
      STR R4,50
      HALT*/

/*
      MOV R0,#17
      MOV R1,#2
      MOV R2,#0
      CMP R0,R1
      BLT end
      B divi
divi:
      SUB R0,R0,R1
      ADD R2,R2,#1
      CMP R0,R1
      BLT end
      B divi
end:
      STR R2,45
      STR R0,50
      HALT
*/

/*
https://python.snt.nsi.xyz/play.php?r=J16&p=17
https://python.snt.nsi.xyz/play.php?r=J16&p=18
https://python.snt.nsi.xyz/play.php?r=J16&p=21
https://python.snt.nsi.xyz/play.php?r=J06&p=9
dans chrome
faire page check
bug émoji composé
émoji qui ne s'affichent pas
bug if elif else while avec syntaxe précise
*/
/*
liste niveaux buggés
https://python.snt.nsi.xyz/play.php?r=J01&p=2
https://python.snt.nsi.xyz/play.php?r=J01&p=5
https://python.snt.nsi.xyz/play.php?r=J01&p=10
https://python.snt.nsi.xyz/play.php?r=J01&p=14
https://python.snt.nsi.xyz/play.php?r=J01&p=19
https://python.snt.nsi.xyz/play.php?r=J01&p=20
https://python.snt.nsi.xyz/play.php?r=J01&p=21


*/