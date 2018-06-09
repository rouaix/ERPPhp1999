<!--
function ecrire(num,cetexte){
  isIE = (document.all)
  isNN6 = (!isIE) && (document.getElementById)
  if (isIE) formulaire = document.all[num];
  if (isNN6) formulaire = document.getElementById(num);
  formulaire.innerHTML = cetexte;
}

function bouge(num){
  isIE = (document.all)
  isNN6 = (!isIE) && (document.getElementById)
  if (isIE) formulaire = document.all[num];
  if (isNN6) formulaire = document.getElementById(num);
  formulaire.style.top = event.clientY - 80;
  formulaire.style.left = event.clientX - 150;
}

function voir(num) {
  isIE = (document.all)
  isNN6 = (!isIE) && (document.getElementById)
  if (isIE) formulaire = document.all[num];
  if (isNN6) formulaire = document.getElementById(num);
  if (formulaire.style.display == "none"){
    formulaire.style.display = "";
    formulaire.focus();
  } else {
    formulaire.style.display = "none";
  }
}

function Cache(num) {
  isIE = (document.all)
  isNN6 = (!isIE) && (document.getElementById)
  if (isIE) formulaire = document.all[num];
  if (isNN6) formulaire = document.getElementById(num);
  formulaire.style.display = "none";
}

function flotter(num){
  isIE = (document.all)
  isNN6 = (!isIE) && (document.getElementById)
  if (isIE) formulaire = document.all[num];
  if (isNN6) formulaire = document.getElementById(num);
  formulaire.style.cssFloat = "none";
  formulaire.focus();
}

function AfficheInLine(num){
  isIE = (document.all)
  isNN6 = (!isIE) && (document.getElementById)
  if (isIE) formulaire = document.all[num];
  if (isNN6) formulaire = document.getElementById(num);
  formulaire.style.display = "inline";
}

function AfficheBlock(num){
  isIE = (document.all)
  isNN6 = (!isIE) && (document.getElementById)
  if (isIE) formulaire = document.all[num];
  if (isNN6) formulaire = document.getElementById(num);
  formulaire.style.display = "block";
}

function setvaleurid(des,valeur){
   document.getElementById(des).value = valeur;
}

function donnerfocus(chp){
  document.getElementById(chp).focus();
}

function affiche(num) {
  isIE = (document.all)
  isNN6 = (!isIE) && (document.getElementById)
  if (isIE) formulaire = document.all[num];
  if (isNN6) formulaire = document.getElementById(num);
  if (formulaire.style.visibility == "hidden"){
    formulaire.style.visibility = "visible";
    formulaire.focus();
  } else {
    formulaire.style.visibility = "hidden";
  }
}

function couleurfond(num,couleur) {
  isIE = (document.all)
  isNN6 = (!isIE) && (document.getElementById)
  if (isIE) formulaire = document.all[num];
  if (isNN6) formulaire = document.getElementById(num);
    formulaire.style.backgroundColor =  '#'+couleur;
}

function couleurtexte(num,couleur) {
  isIE = (document.all)
  isNN6 = (!isIE) && (document.getElementById)
  if (isIE) formulaire = document.all[num];
  if (isNN6) formulaire = document.getElementById(num);
    formulaire.style.color =  '#'+couleur;
}

function couleurbord(num,couleur) {
  isIE = (document.all)
  isNN6 = (!isIE) && (document.getElementById)
  if (isIE) formulaire = document.all[num];
  if (isNN6) formulaire = document.getElementById(num);
    formulaire.style.borderColor =  '#'+couleur;
}

function radio(rad){
  window.open(rad,'window','width=300,height=190');
}

function valider(x){
  document.forms[x].submit();
}

//-->