<?php
function menu_ligne_fichier($dir,$fichier){
  $temp = "";
  $icone = $_SESSION["ico"]["bleu"];
  $iconex = $_SESSION["ico"]["x"];
  
  if(is_dir($dir.$fichier)){$type = "d";}else{$type = "f";}
  if(administrateur($_SESSION["userid"]) && $_SESSION["page"] == "fichiers"){
    $racine = './';
    $qui = "admin";
  }else{
    $racine = 'fichiers/users/'.$_SESSION["userid"].'';
    $qui = "user";
  }
  
  $image = array("png","jpg","gif","jpeg");
  $visible = array("pdf","txt","png","jpg","gif","jpeg");     
  $exclusion = array(".","..",".htaccess","index.php");
  
  if($type == "f"){
    if(!isset($_SESSION["type"]["mime"])){
      $_SESSION["type"]["mime"] = array();
      $dir = "images/mime/";
      if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
          if(!in_array($file,$exclusion)){
          //if($file != '.' && $file != '..' && $file != '.htaccess' && $file != 'index.php') {
            $ext = strtolower(pathinfo($file, PATHINFO_FILENAME));
            array_push($_SESSION["type"]["mime"], $ext);
          }
        }
      }
      closedir($handle);    
    }
    $tx = explode(".",$fichier);
    $ext = strtolower($tx[count($tx)-1]);
    if(in_array($ext,$_SESSION["type"]["mime"])){$ico = $ext.".png";}else{$ico = "vide.png";} 
  }
  


  $temp .= "<ul class=\"info\" id=\"ul".$fichier."\">\n";
  
  $temp .= "<div id=\"titre\">\n";
  if($type == "f"){  
    if(in_array($ext, $visible)){
      $temp .= "<a target=\"Affichage\" href=\"".$dir.$fichier."\" title=\"Afficher\"><img src=\"images/mime/".$ico."\" id=\"ico\"><br>".ucfirst($fichier)."</a>\n";
    }elseif($ext == "mm"){
      $temp .= "<a href=\"".$_SESSION["lien"]."?page=cartes&carte=".$dir.$fichier."\" title=\"Afficher\"><img src=\"images/mime/".$ico."\" id=\"ico\"><br>".ucfirst($fichier)."</a>\n";
    }else{
      $temp .= "<a href=\"\" style=\"cursor:pointer;\"><img src=\"images/mime/".$ico."\" id=\"ico\"><br>".ucfirst($fichier)."</a>\n";
    }        
  }else{
    $temp .= "<a href=\"".$_SESSION["lien"]."?rep=".$dir.$fichier."/\" title=\"Ouvrir\"><img src=\"".$_SESSION["ico"]["dossier"]."\" id=\"ico\"><br>".ucfirst($fichier)."</a>\n";
  }

  $temp .= "<span id=\"pop".$fichier."\">";
  $temp .= "<img src=\"".$icone."\" id=\"f\">";
  $temp .= "<p id=\"centre\"><b>".ucfirst(substr_replace($fichier,'',strlen(pathinfo($dir.$fichier, PATHINFO_FILENAME))))."</b></p>"; 
  if($type == "f"){
    $size = @filesize($dir.$fichier);
    $unite = array('B','Kb','Mb','Gb');
    @$taille = round(@$size/pow(1024,($i=floor(log(@$size,1024)))),2).' '.@$unite[$i];    
    $temp .= "<p id=\"centre\"><i>".$taille." - ".date("d/m/Y H:i", @filemtime($dir.$fichier))."</i></p>";                       
  }
    
  if($type == "f"){  
    if(in_array($ext, $visible)){
      $temp .= "<a target=\"Affichage\" href=\"".$dir.$fichier."\" title=\"Afficher\"><li>Afficher</li></a>\n";
    }elseif($ext == "mm"){
      $temp .= "<a href=\"".$_SESSION["lien"]."?page=cartes&carte=".$dir.$fichier."\" title=\"Afficher\"><li>Afficher</li></a>\n";
    } 
  }else{
    $temp .= "<a href=\"".$_SESSION["lien"]."?rep=".$dir.$fichier."/\" title=\"Ouvrir\"><li>Ouvrir</li></a>\n";
  }  
  
  
  
  if($type == "f"){$temp .= "<a target=\"fichier\" title=\"Chargement !\" href=\"".$_SESSION["location"]."scripts/inc.download.php?action=fdownload&fdownload=".$fichier."&fichier_type=x&fichier_dir=".$dir."\"><li>T&eacute;l&eacute;charger</li></a>";    }
  
  $temp .= "<li onclick=\"javascript:AfficheInLine('rename".$fichier."');\">Renommer</li>";
  //$temp .= "<li onclick=\"javascript:flotter('ul".$fichier."');\">Renommer</li>";
  if($type == "f"){$temp .= "<li onclick=\"javascript:AfficheInLine('copy".$fichier."');\">Copier</li>";}
  $temp .= "<li onclick=\"javascript:AfficheInLine('move".$fichier."');\">D&eacute;placer</li>";
  $temp .= "<li onclick=\"javascript:AfficheInLine('delete".$fichier."');\">Supprimer.</li>";
  
  if($type == "f"){          
    if(in_array($ext, $image)){
      $temp .= "<a target=\"Affichage\" href=\"".$dir.$fichier."\"><img width=\"100%\" src=\"".$dir.$fichier."\"></a>"; 
    }            
  }
  $temp .= "</span>\n";
  $temp .= "</div>\n";
  
    
  //$temp .= "<div id=\"block\" onmouseover=\"Cache('pop".$fichier."');\" onmouseout=\"voir('pop".$fichier."');\">\n"; 
  $temp .= "<div id=\"block\">\n"; 
    
  $temp .= "<div id=\"rename".$fichier."\">";
    $temp .= "<fieldset><legend onclick=\"Cache('rename".$fichier."');\" title=\"Fermer\"><img src=\"".$iconex."\" id=\"x\">Renommer</legend>";
    $temp .= "<form id=\"r".$fichier."\" method=\"POST\" action=\"".$_SESSION["lien"]."\">";
    $temp .= "<input type=\"text\" name=\"renommer\" id=\"renommer\" style=\"width:200px;padding:2px;\" value=\"".substr_replace($fichier,'',strlen(pathinfo($dir.$fichier, PATHINFO_FILENAME)))."\">";
    $temp .= "<input type=\"image\" id=\"i16\" style=\"margin-left:5px;\" src =\"".$_SESSION["ico"]["valider"]."\" title=\"Cliquez pour valider\">";
    $temp .= "<input type=\"hidden\" name=\"dir\" value=\"".$dir."\">";
    $temp .= "<input type=\"hidden\" name=\"fichier\" value=\"".$fichier."\">";
    $temp .= "<input type=\"hidden\" name=\"action\" value=\"renommer\">";
    $temp .= "</form></fieldset>";
  $temp .= "</div>\n";
  
  $temp .= "<div id=\"copy".$fichier."\">";
  if($type == "f"){ 
    if($_SESSION["arbre"][$qui]){
      reset($_SESSION["arbre"][$qui]);
      sort($_SESSION["arbre"][$qui]);
      if($_SESSION["arbre"][$qui]!= ""){
        $temp .= "<fieldset><legend onclick=\"Cache('copy".$fichier."');\" title=\"Fermer\"><img src=\"".$iconex."\" id=\"x\">Copier</legend>";    
        $temp .= "<form id=\"c".$fichier."\" method=\"POST\" action=\"".$_SESSION["lien"]."\">\n";         
        //$temp .= "<img src=\"".$iconex."\" id=\"x\" onclick=\"Cache('copy".$fichier."');\">";
        $temp .= "<select name=\"copier\" id=\"copier\" style=\"width:200px;padding:2px;\">";
        $temp .= "<option></option>";
        reset($_SESSION["arbre"][$qui]);
        foreach ($_SESSION["arbre"][$qui] as $key){
          $x = strlen($key) - strlen($racine);
          if($x == 0){$x = 1;}
          $texte = substr($key,- $x);          
          if($key != $dir){            
            $temp .= "<option value=\"".$texte."\">".$texte."</option>";
          }
        }
        $temp .= "</select>\n";
        $temp .= "<input type=\"image\" id=\"i16\" style=\"margin-left:5px;\" src=\"".$_SESSION["ico"]["valider"]."\" title=\"Cliquez pour valider\">";
        $temp .= "<input type=\"hidden\" name=\"dir\" value=\"".$dir."\">";
        $temp .= "<input type=\"hidden\" name=\"fichier\" value=\"".$fichier."\">";
        $temp .= "<input type=\"hidden\" name=\"action\" value=\"copier\">";
        $temp .= "</form></fieldset>";           
      } 
    }
  }
  $temp .= "</div>\n";
  
  $temp .= "<div id=\"move".$fichier."\">";
    if($_SESSION["arbre"][$qui]){
      reset($_SESSION["arbre"][$qui]);
      sort($_SESSION["arbre"][$qui]);
      if($_SESSION["arbre"][$qui]!= ""){
        $temp .= "<fieldset><legend onclick=\"Cache('move".$fichier."');\" title=\"Fermer\"><img src=\"".$iconex."\" id=\"x\">D&eacute;placer</legend>";      
        $temp .= "<form id=\"d".$fichier."\" method=\"POST\" action=\"".$_SESSION["lien"]."\">\n";
        //$temp .= "<img src=\"".$iconex."\" id=\"x\" onclick=\"Cache('move".$fichier."');\">";
        $temp .= "<select name=\"deplacer\" id=\"deplacer\" style=\"width:200px;padding:2px;\">";
        $temp .= "<option></option>";
        reset($_SESSION["arbre"][$qui]);
        foreach ($_SESSION["arbre"][$qui] as $key){
          $x = strlen($key) - strlen($racine);
          if($x == 0){$x = 1;}
          $texte = substr($key,- $x);
          
          if($key != $dir){            
            $temp .= "<option value=\"".$texte."\">".$texte."</option>";
          }
        }
        $temp .= "</select>\n";
        $temp .= "<input type=\"image\" id=\"i16\" style=\"margin-left:5px;\" src=\"".$_SESSION["ico"]["valider"]."\" title=\"Cliquez pour valider\">";
        $temp .= "<input type=\"hidden\" name=\"dir\" value=\"".$dir."\">";
        $temp .= "<input type=\"hidden\" name=\"fichier\" value=\"".$fichier."\">";
        $temp .= "<input type=\"hidden\" name=\"action\" value=\"deplacer\">";
        $temp .= "</form></fieldset>";           
      }   
    }
  $temp .= "</div>\n";
  
  $temp .= "<div id=\"delete".$fichier."\">";
  $temp .= "<fieldset><legend onclick=\"Cache('delete".$fichier."');\" title=\"Fermer\"><img src=\"".$iconex."\" id=\"x\">Supprimer</legend>";
  $temp .="<form id=\"del".$fichier."\">";
  //$temp .= "<img src=\"".$iconex."\" id=\"x\" onclick=\"Cache('delete".$fichier."');\">";
    if($type == "f"){
      $temp .= "<a href=\"".$_SESSION["lien"]."?action=effacefichier&doc=".$fichier."&dir=".$dir."\" title=\"Supprimer !\nAttention, cette action est d&eacute;finitive !\"><center><img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"i24\"></center></a>";    
    }else{
      $temp .= "<a href=\"".$_SESSION["lien"]."?effacedossier=../".$dir.$fichier."\" title=\"Supprimer !\nAttention, cette action est d&eacute;finitive !\"><center><img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"i24\"></center></a>"; 
    }  
  $temp .= "</form></fieldset></div>\n";
  
  $temp .= "</div>\n"; 
  
  
  
                        
  $temp .= "</ul>\n";  
   
  return $temp;   
}
?>