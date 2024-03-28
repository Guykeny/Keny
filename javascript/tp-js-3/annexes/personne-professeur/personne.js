function Personne(nom, prenom,age,genre,interet){
    this.nom=nom;
    this.prenom=prenom;
    this.age=age;
    this.genre=genre;
    this.interet=interet;
    this.salutation = function(){
        alert( "Bonjour , Je m'appelle "+ this.nom + " " +this.prenom);
    };
    this.bio= function()
    {
        alert("Nom : "+this.nom + "Prenom "+ this.prenom + "age "+this.age + "centre d'interets :"+ this.interet[0]+ "et "+this.interet[1]);

    };
}
var Umuntu = new Personne("SAMie ", " NZEYIMANA ",30 , "homme" , [" DANSE "," Basketball"]);
Umuntu.salutation();
Umuntu.bio();

Personne.prototype.aurevoir= function(){
    alert(this.prenom+ " est sorti au revoir !");
}
Umuntu.aurevoir();