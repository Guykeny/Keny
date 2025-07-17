/*
document.getElementById("TAB");
/*
h23 = document.getElementById("TAB");
/*
h23 === document.querySelector("#TAB");
/*
h23.__proto__;
/*
h23.__proto__ === Object.getPrototypeOf(h23);
/*
h23.nodeType;
/*
h23.nodeName;

/*
div = h23.parentNode;
/*
h23 === div.querySelector("h2:nth-child(17)");
/*
h23 === div.querySelector("h2:nth-of-type(3)");
/*
h23 === div.querySelectorAll("h2")[2];
/*
"BODY" === h23.parentNode.parentNode.tagName;

/*
h23.hasChildNodes();
/*
h23.firstChild;
/*
h23.firstElementChild === null;

/*
p = h23.nextElementSibling;
/*
p === div.querySelector("dl+h2+p");
/*


/*
form = div.lastElementChild.previousElementSibling;
/*
form.getAttributeNames();
/*
true === form.hasAttributes();
/*
"post" === form.getAttribute("method");
/*
form.action === form.getAttribute("method");

/*
div.textContent;
/*
div.innerText;

/*
document.querySelector("h1").textContent = "Nouveau titre";
/*
document.querySelector("pre").style.textAlign = "right";
/*
P = document.querySelectorAll("p");
/*
P.item(0).style.fontFamily = "Cursive";
/*
P.item(2).classList;
/*
P.item(2).classList.remove("important");
/*
P.item(1).classList.add("important");


/*
thds = document.querySelectorAll("th,td");
/*
thds.forEach((e) => { e.style.visibility = "hidden"; });
/*
Array.from(thds).map((e) => { e.style.display = "none"; });

/*
form.querySelector("input[type='text']").value = "Tchatgémiolé";
/*
(select = form.querySelector("select[name='h_adr_ville']")).options;
/*
form.querySelectorAll("input[type='radio']").item(2).checked = true;
/** */