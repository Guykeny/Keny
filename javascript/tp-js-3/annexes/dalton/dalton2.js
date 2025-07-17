
Dalton.prototype.nom= "Dalton";

Dalton.prototype.afficher= function(){
    if(this.nom)
    console.log("nom" + this.nom + "prenom "+ this.prénom);
    else  console.log("Sans non" + "prenom "+ this.prénom);
};

let Daltons= [ averell, jack, joe , william];
for( let p of Daltons){
    p.afficher();
};

Daltons.map(function(p){
    p.afficher();
});

console.log(william.hasOwnProperty("nom"));
for ( k in william){
    console.log( p + william[p]);
}
for( d in Daltons){
    console.log(d + Daltons[d].prénom );
}
delete Dalton.prototype.nom;
Daltons.map(function(m){
    m.afficher();
});

Daltons.filter(function(m){
    return m.prénom[0]=== "J";
}).map(function(m){
    m.afficher();
});