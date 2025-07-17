// Q1 - Créez un tableau JS qui stocke chaque triplet d'entiers figurant dans une ligne du tableau HTML sous la forme d'un tableau JS à 3 éléments.
// Ce tableau ne doit contenir ni les en-têtes, ni les noms de continents.
// Tableau attendu : [[48,3,5],[0,0,1],[31,12,6],[29,10,6],[13,10,14],[7,7,14],[12,0,2]]


// Q2 Créez un tableau JS qui stocke chaque ligne du tableau HTML, sauf la ligne d'en-têtes, sous la forme d'un objet
// ayant 4 propriétés dénommées continent, republic, monarchy et other.
// Tableau attendu :
// [
// {
// "continent": "Africa",
// "republic": 48,
// "monarchy": 3,
// "other": 5
// },
// {
// "continent": "Antarctica",
// "republic": 0,
// "monarchy": 0,
// "other": 1
// },
// {
// "continent": "Asia",
// "republic": 31,
// "monarchy": 12,
// "other": 6
// },
// {
// "continent": "Europe",
// "republic": 29,
// "monarchy": 10,
// "other": 6
// },
// {
// "continent": "North America",
// "republic": 13,
// "monarchy": 10,
// "other": 14
// },
// {
// "continent": "Oceania",
// "republic": 7,
// "monarchy": 7,
// "other": 14
// },
// {
// "continent": "South America",
// "republic": 12,
// "monarchy": 0,
// "other": 2
// }
// ]

// Q3 - Fonction effacerFormattage() 
// Applique à toute cellule du tableau HTML contenant un entier la mise en forme suivante : 
// son fond est blanc, le texte est en noir, et la graisse (weight) des chiffres est normale.

// Q4 - Fonction formaterMinMax(ncol) 
// Prend en entrée un numéro de colonne du tableau HTML (ncol) et applique aux 2 cellules contenant les valeurs minimale et maximale de la colonne la mise en forme suivante :
// - le texte est en gras,
// - le texte est de couleur rouge pour la valeur minimale et vert clair pour la valeur maximale,
// - le fond est de couleur rose pour la valeur minimale et vert pour la valeur maximale.


// Q5 - Remplacez le texte des en-têtes du tableau HTML ``Republic'', ``Monarchy'' et ``Other'' par des boutons (éléments 
// button ou input de type button). Chaque bouton affiche le même texte que l’en-tête qu'il remplace.


// A COMPLETER

th.forEach(function(header,index) {
    if (index > 0) 
    {
        btn = header.firstElementChild;
        btn.addEventListener("click", function(event) {
            effacerFormattage();
            formaterMinMax(index);
        });
    }
})
