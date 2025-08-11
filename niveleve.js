let listdir = window.listdir;
let JsonFilesCount = window.eleveJsonFilesCount;

if (localStorage.getItem('lvl') !== null) {
	lvl = JSON.parse(localStorage.getItem('lvl'))
}



class page extends HTMLElement {
    constructor() {
        super();
        for (let i=0;i<listdir.length;i++) {
            let credits = document.createElement("h5")
            credits.id=`credits${i+1}`
            let elem = document.createElement("h2")
            elem.id=`titre${i+1}`;
            let url_dir=listdir[i].slice(44)
            url_dir=url_dir.slice(0,-8)
            console.log(`./${url_dir}`)
            elem.style.lineHeight="1.2"
            this.appendChild(elem)
            this.appendChild(credits)
            fetch(`./${url_dir}/00.json`)
                .then(res => res.json())
                .then(infos => {
                    elem.innerHTML=infos["titre"]
                    credits.innerHTML=infos["créateurs"]
                },)
            let contenant = document.createElement("menu-lvl")
            contenant.style.gap="7px"
            this.appendChild(contenant)
            for (let j = 0;j<JsonFilesCount[i];j++) { 
                let test = document.createElement("div");
                test.id = `menu${i+1}-${j+1}`;
                if (j<9) {
                    test.innerHTML = `0${j+1}`
                } else {
                    test.innerHTML = `${j+1}`
                }
                contenant.classList.add('table')
                test.classList.add('td-any_ele')
                test.style.aspectRatio = "1";

                if (!(String(url_dir) in lvl)) {
                    test.classList.add('ko_ele')
                } else if (lvl[String(url_dir)].includes(j+1)) {
                    test.classList.add('ok_ele')
                } else {
                    test.classList.add('ko_ele')
                }       
                let act_url=`./play.php?r=${url_dir}&p=${j+1}`
                test.setAttribute("onclick",`location.href='${act_url}'` );
                contenant.appendChild(test)

        }

            
        }

    }
}
customElements.define("cons-page", page);





/*
régler pb bouton déconnecter 
régler pb connexion 
idées:
créer session voir progression, selectionner un répertoire pour la session redirection automatique
régler pb déco automatique
Iwn
réglé pb progression sauvgardée avant début session
afficher pseudo dans session comme connecté 
*/