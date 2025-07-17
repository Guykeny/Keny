// Q1
function Dalton(p) {
	this.prénom = p;
}

// Q2
let averell = new Dalton('Averell');

// Q3
function log(obj) {
	console.log("Obj :" + obj);
	console.log("Prénom : " + obj.prénom);
}
log(averell);

// Q4
// Méthode recommandée pour clonage
let jack = Object.create(averell);
jack.prénom = "Jack";
log(jack);

// Q5
// Méthode NON recommandée pour clonage
let joe = {
	prénom : "Joe"
};
Object.setPrototypeOf(joe, new Dalton());
log(joe);

// Q6
// Attention au format JSON
let william = JSON.parse('{ "prénom" : "William" }');
Object.setPrototypeOf(william, new Dalton());
log(william);

// Q7
// Erreur : let william1 = JSON.parse("{ 'prénom' : 'William' }");
// Erreur : let william2 = JSON.parse('{ "prénom" : William }');
// Erreur : let william3 = JSON.parse('{ "prénom" : "William", }');

// Q8
console.log(Dalton.prototype === Object.getPrototypeOf(averell)); // true
console.log(Dalton.prototype === Object.getPrototypeOf(Object.getPrototypeOf(jack))); // true
console.log(Dalton.prototype === Object.getPrototypeOf(Object.getPrototypeOf(joe))); // true
console.log(Dalton.prototype === Object.getPrototypeOf(Object.getPrototypeOf(william))); // true

// Q9
console.log(william.hasOwnProperty('prénom'));
console.log(Object.getOwnPropertyNames(william));
console.log(Object.keys(william));
for(p in william) {
	console.log(p);
}