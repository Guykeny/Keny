function Famille(nom){
    this.nom=nom || '';
    this.membres= [];

}
let DALTONS = new Famille("Dalton");
Famille.prototype.ajouter= function(m){
    console.log("appel "+ m.prénom);
    this.membres.push(m);
}

DALTONS.ajouter(averell);
Famille.prototype.ajouter.call(DALTONS, jack);

[joe,william].map(function(m){
    Famille.prototype.ajouter.call(DALTONS, m);
});

Famille.prototype.afficher= function(){
    let texte= this.nom + " :\n";
    for ( let i in this.membres){
        texte += "prenom :"+ this.membres[i].prénom + "\n";

    }
    console.log(texte);
    
}
DALTONS.afficher();
