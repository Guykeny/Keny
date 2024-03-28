// Question 1 : Coloration
document.querySelector("body").style.backgroundColor="black";
document.querySelector("div, #intro").style.backgroundColor="orange";
document.getElementById("sondage").style.backgroundColor="red";
document.querySelectorAll("div").forEach((e)=>e.style.color="white");
// Question 2 : Cenr images de la div intro 
document.querySelectorAll("#intro img").forEach((e)=>e.className="center");

// Question 3 : Ajout indication sondage
document.querySelectorAll("#sondage input[type='email']").forEach((e)=>e.value="nom.prenom@univ-angers.fr");
document.querySelector("#sondage input[value='non']").checked=true;
document.querySelectorAll("#sondage input[type='radio']").forEach(function (e){
    if(e.value=="oui"){
        e.nextElementSibling.textContent="Yes";
      
    }else if(e.value=="non"){
        e.nextElementSibling.textContent="Non";
    }
});


// Question 4 : Ajout d'une description textuelle aux images
document.querySelectorAll("img").forEach(function(e){
	el = e.parentNode
	msg = "Image "
	while(el.tagName != "BODY"){
		msg += "-- "+el.tagName + " (" +el.id+ ") ";
		el = el.parentNode;
	}
	e.alt = msg;
});