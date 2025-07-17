// Tableau

function creerTableau(N) {
	// Tableau nu
	// Q1
	var div=document.querySelector("div");
	var table=document.createElement("TABLE");
	for( let i=0; i<N; i++){
		let tr=table.insertRow(-1);
		for(let j=0 ; j<N; j++){
			let td=tr.insertCell(-1);
		}
	}
	div.appendChild(table);

	// Coefficients
	// Q2

	// Abbréviations
	// Q3
}

// Listeners
window.addEventListener("load", function () {
	var input = document.querySelector("INPUT[type=number]");
	var N = parseInt(input.value);
	creerTableau(N + 1);
})

document.querySelector("INPUT[type=number]").addEventListener("change", function (e) {
	var N = parseInt(e.target.value);
	var div = document.querySelector("DIV");
	var table = div.querySelector("TABLE");
	div.removeChild(table);
	creerTableau(N + 1);

})