// Q1
// Appliquez la police `Arial` au corps de la page.
// Incorporez le texte ``Tableau périodique des éléments chimiques'' 
// dans l’élément d'identifiant `titre-principal`.
document.querySelector("body").style.fontFamily="Arial";
document.getElementById("titre-principal").textContent="Tableau Periodique des elements chimiques";
document.querySelectorAll("div input[type='checkbox']").forEach((e)=>e.checked=true);
document.querySelectorAll("div input[type='radio']").forEach((e)=>e.checked=true);
// Q2
// Cochez toutes les cases à cocher.

// Q3
// Colorez les éléments de classe `Gaz_noble` en `lightblue` 
// sauf les libellés des cases à cocher qui sont dans cette classe.
document.querySelectorAll(".Gaz_noble").forEach((e)=> {
    const checkbox = e.querySelector('input[type="checkbox"]');
    if (checkbox === null) { // Si l'élément n'est pas une case à cocher
        // Appliquer le style lightblue
        e.style.backgroundColor = 'lightblue';
    }
});
// Q4
// Affichez en console les données (numéro, nom, symbole et masse) 
// contenues dans la 5ème cellule du tableau (le Béryllium).
// Sélectionner la cellule correspondant au Béryllium (5ème cellule, index 4 car les indices commencent à 0)
 // L'indice 1 correspond à la 2ème cellule dans la première ligne
var cellule=document.querySelectorAll("#mendeleiev td")[4];
// Extraire les données de la cellule
const numero = cellule.querySelector('.numéro').textContent;
const nom = cellule.querySelector('a').textContent;
const masse = cellule.querySelector('.masse').textContent;

// Afficher les données en console
console.log("Numéro: " + numero);
console.log("Nom: " + nom);
console.log("Masse: " + masse);

// Q5
// Implémentez la fonction `decolorer()` qui encadrera chaque cellule du tableau 
// appartenant à (au moins) une classe par une bordure de style `1px solid black`.
// Testez la fonction en cochant le bouton ``Noir et blanc'' ou en l'appelant dans 
// la console.
function decolorer() {
    var cellule=document.querySelectorAll("#mendeleiev td");

    cellule.forEach((e)=>{
        if(e.classList.length >O){
            e.style.border= "1px solid black";
        }
    });
}