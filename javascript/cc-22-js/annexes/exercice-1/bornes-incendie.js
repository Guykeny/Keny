// Q1
// Supprimez le premier et le dernier élément du tableau `bornesIncendie`.
// Après ces suppressions, la taille de `bornesIncendie` est de 3474.
bornesIncendie.shift();
bornesIncendie.pop();
// Q2
// Affichez dans la console le nombre de bornes à incendie présentes 
// au sein de la commune dénommée `LES PONTS-DE-CE`.
function countBornesInCommune(commune) {
    let count = 0;
    for (let i = 0; i < bornesIncendie.length; i++) {
        if (bornesIncendie[i].commune === commune) {
            count++;
        }
    }
    return count;
}
console.log("BornesIncendies a LES PONTS-DE-CE " + countBornesInCommune("LES PONTS-DE-CE"));
// Q3
// Créez un tableau contenant un code, créé sur mesure, pour chaque borne. 
// Le code sera composé des 3 premières lettres de la commune 
// suivies d'un tiret et du numéro pompier (`num_pompier`).


// Création du tableau de codes pour chaque borne
var table = bornesIncendie.map(function (s) {
    var communePre = s.commune.slice(0, 3);
    var num = s.num_pompier;
    return communePre + "-" + num;
});
console.log("Bornes Incendies :" + table);
// Q4
// Affichez dans une popup s'il existe au moins une borne incendie 
// dans une ville saisie par l'utilisateur. Attention : les noms de communes 
// sont stockés en majuscules dans le tableau `bornesIncendie`.
function verification() {
    let commune=prompt(" saisir une ville :");
    commune = commune.toUpperCase();
    for (let i = 0; i < bornesIncendie.length; i++) {
        if (bornesIncendie[i].commune === commune) {
        alert("il y au au moins une bornes a incendies");
        return
        }
       
    }
    alert("il n'y a pas de bornes a incendies");
}
//verification();
// Q5
// Affichez dans la console le débit d'eau cumulé des bornes à incendie 
// du tableau `bornesIncendie`. Attention, pour certaines bornes, le débit prend 
// la valeur `null`.
function debit(){
    let count=0;
    for (let i = 0; i < bornesIncendie.length; i++) {
        if (bornesIncendie[i].debit !==null && !isNaN(parseFloat(bornesIncendie[i].debit))) {
            count+=parseFloat(bornesIncendie[i].debit);
        }
    }
    console.log("Debit d'eau cumule est :"+count);
}
debit();
