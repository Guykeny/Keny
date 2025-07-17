// Q1
document.querySelector('h2:nth-of-type(4)').textContent="my content";

// Q2
document.querySelector('table').style.width="80%"
// Q3
document.querySelectorAll('dd,dt').forEach(e=> e.style.backgroundColor="lightcyan");
// Q4
document.querySelectorAll('li').forEach(e=> e.textContent= "Hello");
// Q5
p=document.querySelectorAll('table').item(1);
p.parentElement.removeChild(p);

// Q6
tr=document.querySelector('table').querySelectorAll('tr').item(2);
tr.parentElement.removeChild(tr);
// Q7
Array.from(document.querySelectorAll('th,td')).filter(e=>e.cellIndex==2).map(e=>e.parentElement.removeChild(e));

// Q8
document.getElementByName('h_adr_rue').item(0).value=49100;

// Q9
Array.from(querySelectorAll('input[name="h_hab_options[]"')).filter(e=>e.value =="garage"||e.value == "piscine").forEach(a=>a.checked=true);

