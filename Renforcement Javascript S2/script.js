        //CALCULATRICE 1

function calculer() {
    // Fonction permettant de réaliser l'intégralité de nos calculs

    // Déclaration de nos variables pour récupérer les 2 nombres à calculer (Les 2 champs)
    var capture1 = parseInt(document.getElementById('PremierNb').value);
    var capture2 = parseInt(document.getElementById('SecondNb').value);

    //Ensemble des conditions qui vont permettre de faire les calcules et afficher le résulat selon ce que nous désirons
    // On va pouvoir calculer et afficher le résultat d'un addition, d'une multiplication, d'un soustraction et d'une division
    if (document.getElementById('r1').checked) {

        var addition = capture1 + capture2; //Calcul pour l'addition
        let afficher = document.getElementById('afficher').innerHTML = addition;//Affichage du résulat

    } else if (document.getElementById('r2').checked) {

        var soustraction = capture1 - capture2;
        afficher.innerHTML = soustraction;

    } else if (document.getElementById('r3').checked) {

        var multiplication = capture1 * capture2;
        document.getElementById('afficher').innerHTML = multiplication;

    } else if (document.getElementById('r4').checked) {

        var division = capture1 / capture2;
        document.getElementById('afficher').innerHTML = division;

    } else {
        //Affiche un message d'erreur si un champ n'est pas rempli et donne un couleur rouge à "Résulat"
        document.getElementById('afficher').innerHTML = "Veuillez cocher ou remplir les champs manquants";
        document.getElementById('result').style.color = 'red';
    }
}





        //CALCULATRICE 2

//insertion des numéros pour le calcul
function insert(num) {
    document.form.textview.value = document.form.textview.value + num;
}

//fonction qui permet d'exécuter le calcul
function equal() {
    var exp = document.form.textview.value;
    if (exp) {
        document.form.textview.value = eval(exp);
    }
}

//fonction qui permet de supprimer le calcul
function clean() {
    document.form.textview.value = "";
}

//fonction qui permet de supprimer un élément et non la totalité du calcul
function back() {
    var exp = document.form.textview.value;
    document.form.textview.value = exp.substring(0, exp.length - 1);
}





        //CAROUSEL

const carouselSlide = document.querySelector('.carousel-slide');
const carouselImages = document.querySelectorAll('.carousel-slide img');

//Bouttons
const prevBtn = document.querySelector('#prevBtn');
const nextBtn = document.querySelector('#nextBtn');

//Compteur
let counter = 1;
const size = carouselImages[0].clientWidth; //clientWidth = la largeur intérieur d'un élément

carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)';

//Button Listeners = écouteur de boutton (évèmement)

//fonction pour ajouter un évènement au click sur le bouton next. On va avancer d'une image.
nextBtn.addEventListener('click', () => {
    if (counter >= carouselImages.length - 1) return;
    carouselSlide.style.transition = "transform 0.4s ease-in-out";
    counter++; //incrémentation de +1
    carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)';
});

//Fonction pour ajouter un évènement au click sur le bouton prev. On va reculer d'une image.
prevBtn.addEventListener('click', () => {
    if (counter <= 0) return;
    carouselSlide.style.transition = "transform 0.4s ease-in-out"; // permet de faire la transition
    counter--; //incrémentation de +1
    carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)';
});

carouselSlide.addEventListener('transitionend', () => {
    if (carouselImages[counter].id === 'lastClone') {
        carouselSlide.style.transform = "none";
        counter = carouselImages.length - 2;
        carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)';
    }

    if (carouselImages[counter].id === 'firstClone') {
        carouselSlide.style.transform = "none";
        counter = carouselImages.length - counter;
        carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)';
    }
});






//Pierre feuille ciseau

//Récupération des bouttons dans le HTML
const buttons = document.querySelectorAll("button");
// const resultat = document.querySelector(".resultat");

// Boucle "for" pour répéter les tours de jeu
for (let i = 0; i < buttons.length; i++) {

    //Au click, éxécution du jeu grâce à la fonction 
    buttons[i].addEventListener('click', function() 
   {
        //Déclaration de nos variables joueur et robot
        const joueur = buttons[i].innerHTML;
        const robot = buttons[Math.floor(Math.random() * buttons.length)].innerHTML;
        let resultat = "";

        // resultat.innerHTML = joueur + "       " + robot;
        //Conditions permettant de comparer les jeux de chacun des jours 
        if (joueur===robot) {
        resultat = "Egalité";
        }
        else if ((joueur === "Pierre" && robot === "Ciseaux") || (joueur === "Ciseaux" && robot === "Feuilles") || (joueur === "Feuilles") && (robot === "Pierre")) {
        resultat = "Gagné";
        }
        else {
        resultat = "Perdu";
        }
        
        //Affichage des variables et retourne la victoire ou la défaite
        document.querySelector(".resultat").innerHTML = `
        Joueur : ${joueur} </br>
        Robot : ${robot} <br/>
        Résultat : ${resultat}`;
    
    });
  
}





// // Le juste prix 

// console.log("Bienvenue dans ce jeu de devinette !");
// console.log("Votre objectif est de trouver un nombre ENTIER entre 1 et 100");
// console.log("Pour se faire, vous n'aurez droit qu'à 6 essais");

// // Cette ligne génère aléatoirement un nombre entre 1 et 100
// var solution = Math.floor(Math.random() * 100) + 1;
// var nombre = 0;

// //Boucle permettant d'executer plusieurs essais 
// for (var nombreEssais = 1; nombreEssais < 7; nombreEssais++) {

//     nombre = Number(prompt("Entrez un nombre entre 1 et 100"));
    
//     //Tout le jeu se fait dans la console 
// 	console.log ("Essai numéro : " + nombreEssais + "." + " Vous avez entré le nombre " + nombre); //J'ai ajouté le numéro d'essais et le nombre choisi pour un meilleur suivi

// 	if ((nombre < 1)||(nombre > 100)) { // Si la personne met un nombre plus grand que 100 ou plus petit que 1
// 		console.log("Ce nombre n'est pas autorisé, merci d'entrer un nombre entre 1 et 100");
// 	}	 

// 	else if (nombre < solution) { // Si le nombre du joueur est inférieur à la solution
// 		console.log("Le nombre à trouver est plus grand");
// 	}
// 	else if (nombre > solution) { // Si le nombre du joueur est supérieur à la solution
// 	console.log("Le nombre à trouver est plus petit");
// 	}
// 	else if (nombre === solution) { // Quand on trouve la solution
// 		console.log("Félicitation, la réponse était bien " + solution);
// 		break;
// 	}		

// }

// if (nombre !== solution) {
// //Si le joueur dépasse un nombre d'essai
// 	console.log("Dommage, tu n'as pas trouvé la réponse dans les 6 essais impartis. La réponse était " + solution);
// }
alert ("50"==50);
alert ("50"===50);