
function createSimpleNoede(tag, options,text){
    var node=document.createElement(tag);
    for(let o in options){
        node.setAttribute(o,options[o]);
    }
    if(text){
        node.textContent=text;
    }
    return node;
}

let img= createSimpleNoede('img',{
    src: 'pix.png',
    alt: "Pas d'image",
	width: "10%",
	height: "auto"
});
let br=document.createElement("br");
let a= createSimpleNoede('a',{
    href:'https://www.laquadrature.net/'
}, "un site");
let p= createSimpleNoede('p',{},"du texte");

let body= document.querySelector("body");
body.insertBefore(img,body.lastChild);
body.insertBefore(br,body.lastChild);
body.insertBefore(a,body.lastChild);
body.insertBefore(br.cloneNode(),body.lastChild);
body.insertBefore(p,body.lastChild);
