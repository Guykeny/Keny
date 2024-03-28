// Q1
// Créez un objet littéral `maine_et_loire possédant 
var maine_et_loire={
    departement: 49,
    toText: function(){
        console.log("Departement :"+this.departement)
    }
}
  
/// une propriété entière dénommée `département` de valeur `49`
// et une méthode `toText`. 

// Q1 - résultat attendu
// maine_et_loire.toText(); // Département : 49

// Q2
// Implémentez un constructeur `Lieu` acceptant 2 arguments `type` et `département` -
// le premier étant une chaîne de caractères dénotant un type de lieu (p. ex. ''université'', ''palais''),
// le second, optionnel, étant un entier dénotant un numéro de département (p. ex. 49).
// Assurez-vous que chaque objet construit avec `Lieu` :
// - possède une propriété propre dénommée `type` et égale au premier argument
// - ait pour prototype l'objet `maine_et_loire`,
// - possède une propriété propre dénommée `département` uniquement dans le cas où le second argument n'est pas passé à la construction.
function Lieu(type,Departement){
    this.type=type;
    this.Departement=Departement;
}
Lieu.prototype=maine_et_loire;
Lieu.prototype.toText=function(){
    console.log("Type: "+ this.type+"-"+"Departement :"+this.departement);
}
var moi=new Lieu("Université", 48);
moi.toText();
// Q2 - résultat attendu
// var ua = new Lieu("université");
// ua.département; // 49
// ua.type; // université
// var elysee = new Lieu("palais", 75);
// elysee.département; // 75
// elysee.type; // palais

// Q3
// Ajoutez une méthode `toText()` au constructeur `Lieu`.

// Q3 - résultat attendu
// ua.toText(); // type : université - Département : 49
// elysee.toText(); // type : palais - Département : 75