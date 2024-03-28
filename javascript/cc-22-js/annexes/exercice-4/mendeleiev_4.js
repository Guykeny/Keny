// Q1
// Complétez l'implémentation de la fonction `estElement` qui prend en argument une cellule du tableau
// et détermine si elle contient ou non des données.
// Précisément, la fonction retournera `true` si :
// - la cellule n'est pas vide (autrement dit, elle a au moins 1 noeud enfant), et
// - le nom indiqué dans la cellule est différent de `*` et `**`.
// Testez la fonction en console qui retournera `true` sur la 1ère cellule du tableau 
// et faux sur la 59ème cellule.
function estElement(td) {
    // A COMPLETER
    if (td.childNodes.length > 0) {
        // Vérifier si le contenu de la td est différent de '*' et '**'
        const contenu = td.textContent.trim();
        if (contenu !== '*' && contenu !== '**') {
            return true; // La cellule contient des données
        }
    }
    return false; 
}

// Q2
// La fonction `transformerTableau` vise à remplacer le tableau périodique
// par un nouveau tableau HTML contenant une ligne par élément atomique,
// chaque ligne étant décomposée en 4 cellules contenant, respectivement,
// le numéro, nom, symbole et masse de l'élément.
// L'implémentation partielle qui vous est donnée crée le tableau et sa ligne d'en-têtes. 
// Votre implémentation devra donc récupérer les données correspondant à chaque élément,
// créer et ajouter la ligne de l'élément au tableau,
// ajouter ce dernier à la page, puis supprimer le tableau d'origine.
// Utilisez la fonction `estElement` développée en question précédente 
// pour ne traiter que les  cellules ``non vides'' du tableau d'origine.
function transformerTableau() {
    // tableau
    var tableHTML = document.createElement("table");
    tableHTML.id = "tabular";
    // en-têtes du tableau
    var rowHTML = document.createElement("tr");
    const headers = ["Numero", "Nom", "Symbole", "Masse"];
    for (const i in headers) {
        let headerHTML = document.createElement("th");
        headerHTML.innerText = headers[i];
        rowHTML.appendChild(headerHTML);
    }
    tableHTML.appendChild(rowHTML);

    // A COMPLETER
}