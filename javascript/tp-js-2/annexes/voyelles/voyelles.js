var tab=s.split('');
//La méthode split() divise une chaîne de caractères en une liste ordonnée de sous-chaînes, place ces sous-chaînes dans un tableau et retourne le tableau. La division est effectuée en recherchant un motif ; où le motif est fourni comme premier paramètre dans l'appel de la méthode
console.log(tab);
var filtre= function(e){
    if (voyelles.includes(e)){
        return true;
    }else return false;
}

//La méthode filter() crée et retourne un nouveau tableau contenant tous les éléments du tableau d'origine qui remplissent une condition déterminée par la fonction callback.
//arr.filter(callback); 
tabv= tab.filter(filtre);
console.log(tabv);

map =new Map();
Array.from(voyelles).forEach( e=>
    {
        map.set(e,tabv.filter(v=>v==e).length);
    });

console.log(map);
var o=0;
maxv="";
var myMax= (val, key) =>{
    if( val > o){
        o=val;
        maxv=key;
    }
}
map.forEach(myMax);
console.log(maxv);
console.log(map.get(maxv));
