<?php
function menu_ligne_fichier($dir,$fichier){
  $code = "";
  $icone = $_SESSION["ico"]["bleu"];
  $iconex = $_SESSION["ico"]["x"];
  
  if(is_dir($dir.$fichier)){$type = "d";}else{$type = "f";}
  if(administrateur($_SESSION["userid"]) && $_SESSION["page"] == "fichiers"){
    $racine = './';
    //$racine = $_SESSION["location"];
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

  $code .= "<ul class=\"info\" id=\"ul".$fichier."\">\n";
  
  
  $code .= "<div class=\"module\" id=\"hover\">";
  if($type == "f"){  
    if(in_array($ext, $visible)){
      $code .= "<a target=\"Affichage\" href=\"".$dir.$fichier."\" title=\"Afficher\"><img src=\"images/mime/".$ico."\" id=\"ico\"></a>\n";
    }elseif($ext == "mm"){
      $code .= "<a href=\"".$_SESSION["lien"]."?page=cartes&carte=".$dir.$fichier."\" title=\"Afficher\"><img src=\"images/mime/".$ico."\" id=\"ico\"></a>\n";
    }else{
      $code .= "<img src=\"images/mime/".$ico."\" id=\"ico\" style=\"cursor:default;\">\n";
    }        
  }else{
    $code .= "<a href=\"".$_SESSION["lien"]."?rep=".$dir.$fichier."/\" title=\"Ouvrir\"><img src=\"".$_SESSION["ico"]["dossier"]."\" id=\"ico\"></a>\n";
  }
    
  $code .= "<b>".ucfirst(substr_replace($fichier,'',strlen(pathinfo($dir.$fichier, PATHINFO_FILENAME))))."&nbsp;</b>"; 
  if($type == "f"){
    $size = @filesize($dir.$fichier);
    $unite = array('B','Kb','Mb','Gb');
    @$taille = round(@$size/pow(1024,($i=floor(log(@$size,1024)))),2).' '.@$unite[$i];    
    $code .= "&nbsp;<i>(".$fichier." - ".$taille." - ".date("d/m/Y H:i", @filemtime($dir.$fichier)).")</i>";                       
  }
  //$code .= "</div>\n";  
  
  
  
  $code .= "<div style=\"display:inline;float:right;margin-top:10px;\">"; 
  if($type == "f"){  
    if(in_array($ext, $visible)){
      //$code .= "<img src=\"".$_SESSION["ico"]["loupe"]."\" id=\"y\" title=\"Voir\" onclick=\"javascript:AfficheInLine('apercu".$fichier."');\">\n";
      $lien = "onClick=\"javascript:voir('apercu".$fichier."');ajaxpage(rootdomain+'scripts/inc.pop.image.php?origine=apercu".$fichier."&image=".$dir.$fichier."','apercu".$fichier."');\"";
      //$contenu ="<img src='".$dir.$fichier."'>";
      //$lien = "onClick=\"javascript:voir('apercu".$fichier."');ecrire('apercu".$fichier."','".$contenu."');\"";
      $code .= "<img src=\"".$_SESSION["ico"]["loupe"]."\" id=\"y\" title=\"Voir\" ".$lien.">\n";
      //$code .= "<br>".$dir.$fichier;
    }elseif($ext == "mm"){
      $code .= "<a href=\"".$_SESSION["lien"]."?page=cartes&carte=".$dir.$fichier."\"><img src=\"".$_SESSION["ico"]["loupe"]."\" id=\"y\" title=\"Afficher\"></a>\n";
    } 
  }else{
    $code .= "<a href=\"".$_SESSION["lien"]."?rep=".$dir.$fichier."/\"><img src=\"".$_SESSION["ico"]["loupe"]."\" id=\"y\" title=\"Ouvrir\"></a>\n";
  } 

  if($type == "f"){
    $code .= "<a target=\"fichier\" href=\"".$_SESSION["location"]."scripts/inc.download.php?action=fdownload&fdownload=".$fichier."&fichier_type=x&fichier_dir=".$dir."\"><img src=\"".$_SESSION["ico"]["restaurer"]."\" id=\"y\" title=\"Chargement !\"></a>";
  }  
  $code .= "<img src=\"".$_SESSION["ico"]["modifier"]."\" id=\"y\" title=\"Renommer\" onclick=\"javascript:AfficheInLine('rename".$fichier."');\">";
  if($type == "f"){$code .= "<img src=\"".$_SESSION["ico"]["ajouter"]."\" id=\"y\" title=\"Copier\" onclick=\"javascript:AfficheInLine('copy".$fichier."');\">";}
  $code .= "<img src=\"".$_SESSION["ico"]["droite"]."\" id=\"y\" title=\"Déplacer\" onclick=\"javascript:AfficheInLine('move".$fichier."');\">";
  $code .= "<img src=\"".$_SESSION["ico"]["effacer"]."\" id=\"y\" title=\"Supprimer\" onclick=\"javascript:AfficheInLine('delete".$fichier."');\">";
  $code .= "</div>\n";
  
  
  
  if($type == "f"){
    $code .= "<div id=\"apercu".$fichier."\" style=\"display:none;\">";           
    //if(in_array($ext, $image)){
      //$code .= "<a target=\"Affichage\" href=\"".$dir.$fichier."\"><img src=\"".$dir.$fichier."\"></a>"; 
      //$code .= "<p>Test</p>"; 
    //} 
    $code .= "</div>\n";           
  }
    
    
  //$code .= "<div id=\"block\" onmouseover=\"Cache('pop".$fichier."');\" onmouseout=\"voir('pop".$fichier."');\">\n"; 

    
  $code .= "<div id=\"rename".$fichier."\" style=\"display:none;\">";
    $code .= "<fieldset><legend onclick=\"Cache('rename".$fichier."');\" title=\"Fermer\"><img src=\"".$iconex."\" id=\"x\">Renommer</legend>";
    $code .= "<form id=\"r".$fichier."\" method=\"POST\" action=\"".$_SESSION["lien"]."\">";
    $code .= "<input type=\"text\" name=\"renommer\" id=\"renommer\" style=\"width:200px;padding:2px;\" value=\"".substr_replace($fichier,'',strlen(pathinfo($dir.$fichier, PATHINFO_FILENAME)))."\">";
    $code .= "<input type=\"image\" id=\"i16\" style=\"margin-left:5px;\" src =\"".$_SESSION["ico"]["valider"]."\" title=\"Cliquez pour valider\">";
    $code .= "<input type=\"hidden\" name=\"dir\" value=\"".$dir."\">";
    $code .= "<input type=\"hidden\" name=\"fichier\" value=\"".$fichier."\">";
    $code .= "<input type=\"hidden\" name=\"action\" value=\"renommer\">";
    $code .= "</form></fieldset>";
  $code .= "</div>\n";
  
  $code .= "<div id=\"copy".$fichier."\" style=\"display:none;\">";
  if($type == "f"){ 
    if($_SESSION["arbre"][$qui]){
      reset($_SESSION["arbre"][$qui]);
      sort($_SESSION["arbre"][$qui]);
      if($_SESSION["arbre"][$qui]!= ""){
        $code .= "<fieldset><legend onclick=\"Cache('copy".$fichier."');\" title=\"Fermer\"><img src=\"".$iconex."\" id=\"x\">Copier</legend>";    
        $code .= "<form id=\"c".$fichier."\" method=\"POST\" action=\"".$_SESSION["lien"]."\">\n";         
        //$code .= "<img src=\"".$iconex."\" id=\"x\" onclick=\"Cache('copy".$fichier."');\">";
        $code .= "<select name=\"copier\" id=\"copier\" style=\"width:200px;padding:2px;\">";
        $code .= "<option></option>";
        reset($_SESSION["arbre"][$qui]);
        foreach ($_SESSION["arbre"][$qui] as $key){
          $x = strlen($key) - strlen($racine);
          if($x == 0){$x = 1;}
          $texte = substr($key,- $x);          
          if($key != $dir){            
            $code .= "<option value=\"".$texte."\">".$texte."</option>";
          }
        }
        $code .= "</select>\n";
        $code .= "<input type=\"image\" id=\"i16\" style=\"margin-left:5px;\" src=\"".$_SESSION["ico"]["valider"]."\" title=\"Cliquez pour valider\">";
        $code .= "<input type=\"hidden\" name=\"dir\" value=\"".$dir."\">";
        $code .= "<input type=\"hidden\" name=\"fichier\" value=\"".$fichier."\">";
        $code .= "<input type=\"hidden\" name=\"action\" value=\"copier\">";
        $code .= "</form></fieldset>";           
      } 
    }
  }
  $code .= "</div>\n";
  
  $code .= "<div id=\"move".$fichier."\" style=\"display:none;\">";
    if($_SESSION["arbre"][$qui]){
      reset($_SESSION["arbre"][$qui]);
      sort($_SESSION["arbre"][$qui]);
      if($_SESSION["arbre"][$qui]!= ""){
        $code .= "<fieldset><legend onclick=\"Cache('move".$fichier."');\" title=\"Fermer\"><img src=\"".$iconex."\" id=\"x\">D&eacute;placer</legend>";      
        $code .= "<form id=\"d".$fichier."\" method=\"POST\" action=\"".$_SESSION["lien"]."\">\n";
        //$code .= "<img src=\"".$iconex."\" id=\"x\" onclick=\"Cache('move".$fichier."');\">";
        $code .= "<select name=\"deplacer\" id=\"deplacer\" style=\"width:200px;padding:2px;\">";
        $code .= "<option></option>";
        reset($_SESSION["arbre"][$qui]);
        foreach ($_SESSION["arbre"][$qui] as $key){
          $x = strlen($key) - strlen($racine);
          if($x == 0){$x = 1;}
          $texte = substr($key,- $x);
          
          if($key != $dir){            
            $code .= "<option value=\"".$texte."\">".$texte."</option>";
          }
        }
        $code .= "</select>\n";
        $code .= "<input type=\"image\" id=\"i16\" style=\"margin-left:5px;\" src=\"".$_SESSION["ico"]["valider"]."\" title=\"Cliquez pour valider\">";
        $code .= "<input type=\"hidden\" name=\"dir\" value=\"".$dir."\">";
        $code .= "<input type=\"hidden\" name=\"fichier\" value=\"".$fichier."\">";
        $code .= "<input type=\"hidden\" name=\"action\" value=\"deplacer\">";
        $code .= "</form></fieldset>";           
      }   
    }
  $code .= "</div>\n";
  
  
  $code .= "<div id=\"delete".$fichier."\" style=\"display:none;\">";
  $code .= "<fieldset><legend onclick=\"Cache('delete".$fichier."');\" title=\"Fermer\"><img src=\"".$iconex."\" id=\"x\">Supprimer</legend>";
  $code .="<form id=\"del".$fichier."\">";
  //$code .= "<img src=\"".$iconex."\" id=\"x\" onclick=\"Cache('delete".$fichier."');\">";
    if($type == "f"){
      $code .= "<a href=\"".$_SESSION["lien"]."?action=effacefichier&doc=".$fichier."&dir=".$dir."\" title=\"Supprimer !\nAttention, cette action est d&eacute;finitive !\"><center><img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"i24\"></center></a>";    
    }else{
      $code .= "<a href=\"".$_SESSION["lien"]."?effacedossier=../".$dir.$fichier."\" title=\"Supprimer !\nAttention, cette action est d&eacute;finitive !\"><center><img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"i24\"></center></a>"; 
    }  
  $code .= "</form></fieldset>\n";
  $code .= "</div>\n";
  
  $code .= "</div>\n";
  $code .= "</ul>\n";  
  return $code;   
}
?>