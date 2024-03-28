document.querySelector("h2:nth-of-type(4)").textContent="Bonjour";
document.querySelector("table").style.width="80%";
document.querySelectorAll("dd,dt").forEach((e)=>e.style.backgroundColor="lightcyan");
document.querySelectorAll("li").forEach((e)=>e.textContent="Hello");
p=document.querySelectorAll('table').item(1);
p.parentElement.removeChild(p);

tr=document.querySelector('table').querySelectorAll('tr').item(2);
tr.parentElement.removeChild(tr);

Array.from(document.querySelectorAll("th,td").filter(e=>e.cellIndex==2).map(e=>e.parentElement.removechild(e)));
document.getElementsByName("h_adr_rue").item(0).value=49100;
document.querySelectorAll("input [type='h_hab_options[]']").forEach((e)=>e.checked=true);