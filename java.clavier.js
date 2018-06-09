<?php if (file_exists("../scripts/securite.php")){include("../scripts/securite.php");} ?>
<!--
var isCtrl = false;
var isAlt = false;

function clavier(ev)
{   var alt      = ev.altKey;
    var shift    = ev.shiftKey;
    var ctrl     = ev.ctrlKey;
    var touche   = ev.keyCode;
    var codeHTML='';
    if (shift)    codeHTML += 'shift + ';
    if (ctrl)     codeHTML += 'ctrl + ';
    if (alt)      codeHTML += 'alt + ';
    if (touche>31)   // à partir de espace
    {  codeHTML = 'Clavier = '+touche;;
       document.getElementById('codeclavier').innerHTML = codeHTML;        
       formulaire = document.all['codeclavier'];
       if(formulaire.style.display = ""){voir('codeclavier');}
    }
    if(shift){
        if(touche == 223){               
          voir('administrateur');                             
          ajaxpage(rootdomain+'scripts/admin.php','administrateur');
        }      
    }
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

//-->