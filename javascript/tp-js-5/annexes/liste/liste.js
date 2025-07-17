var clone=document.getElementById("modele");
var ok=clone.cloneNode(true);
var newNode=document.getElementById("output");
newNode.insertBefore(ok,newNode.lastChild);


/////////////////////

var output=document.getElementById("output");

let Languege =[
    document.createTextNode('Javascript'),
    document.createTextNode('JScript'),
    document.createTextNode('Action'),
    document.createTextNode('Ex4')


];
let p=document.createElement('p');
let text=document.createTextNode('Langages basés sur ECMAScript :');
p.appendChild(text);

let uList=document.createElement("ul");
let uItem;

Languege.forEach(function(lang) {
    uItem=document.createElement('li');
    uItem.appendChild(lang);
    uList.appendChild(uItem);
    
});
output.appendChild(p);
output.appendChild(uList);

