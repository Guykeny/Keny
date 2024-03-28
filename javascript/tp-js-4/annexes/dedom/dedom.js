let f=document.querySelector('form');
f.parentElement.removeChild(f.previousElementSibling);
f.parentElement.removeChild(f);


document.querySelectorAll('th,td').forEach(e=>e.style.textAlign="center");

//let tbd=Array.from(document.querySelectorAll('table,th,td'));
//tbd.map(e=>e.style.border="solid 1px purple");
document.querySelectorAll('table,th,td').forEach(e=>e.style.border="solid 1px purple");

let h2p = document.querySelector('h2:nth-child(4)');
h2p.style.display = "none";
h2p.nextElementSibling.style.display = "none";

let dub= Array.from(document.querySelectorAll('ol:first-of-type>li'));
dub.map(e=>e.textContent[0]=="D" ? e.style.fontFamily = 'Cursive' : e.textContent = "\u26A0" );

