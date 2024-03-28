function sMatrix(matrice){
    var result= "";
    matrice.forEach(element => {
        //element c'est la premiere ligne
    element.forEach(cell => {
        //cell est chaque caractere de la premiere ligne
            result += (cell + " ");
        });
        result += "\n";
    });
    return result.slice(0,-1);
}