function Professeur(nom, prenom,age,genre,interet, matiere){
    Personne.call(this,nom, prenom,age,genre,interet);
    this.matiere=matiere;
}
Professeur.prototype=Object.create(Personne.prototype);
Professeur.prototype.constructor= Professeur;
var professeur1 = new Professeur('Cédric', 'Villani', 44, 'h', ['football', 'cuisine'], 'les mathématiques');
professeur1.bio();
Professeur.prototype.saluer= function(){
    var prefix;

  if (this.genre === 'homme' || this.genre === 'Homme' || this.genre === 'h' || this.genre === 'H') {
    prefix = 'M.';
  } else if (this.genre === 'femme' || this.genre === 'Femme' || this.genre === 'f' || this.genre === 'F') {
    prefix = 'Mme';
  } else {
    prefix = '';
  }

  alert('Bonjour. Mon nom est ' + prefix + ' ' + this.nom+ ', et j\'enseigne ' + this.matiere + '.');
}
professeur1.saluer();