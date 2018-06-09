<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

//module_titre("images","");

if(!isset($_SESSION["rep"]) or $_SESSION["rep"] == ""){$_SESSION["rep"] = "images/";}
$format = array("png","jpg","gif");
$liste_dir = array();

echo "<div class=\"module\" id=\"titre\">".ucfirst($_SESSION["rep"])."</div>\n";

$x = strrpos($_SESSION["rep"], "images");
if($x === false){
  $_SESSION["rep"] = "images/";
  if ($handle = opendir($_SESSION["rep"] )){
    while (false !== ($f = readdir($handle))){
      if(is_dir($f)){array_push ($liste_dir,$f);}
    }
  }
}

  
if($_SESSION["rep"] != "images/"){
  echo "<a href=\"".$_SESSION["lien"]."?rep=images/\" title=\"Dossier\">";
  echo "<div class=\"module\" id=\"ligne\">";
    
    echo "<img src=\"".$_SESSION["ico"]["retour"]."\" id=\"i32\">";
    echo "<b>Retour</b>";
   
  echo "</div>";
  echo "</a>";
}
       
if ($handle = opendir($_SESSION["rep"])){
  $x = array();
  while (false !== ($f = readdir($handle))){array_push ($x,$f); }
  reset($x);
  asort($x);
  while(list(,$file) = each($x)){
  if ($file != "." && $file != ".." && $file != "index.php"){
    if(is_dir($_SESSION["rep"].$file)){
      
        echo "<a href=\"".$_SESSION["lien"]."?rep=".$_SESSION["rep"].$file."/\" title=\"Dossier\">";
        echo "<div class=\"module\" id=\"ligne\">";
        echo "<img src=\"".$_SESSION["ico"]["dossier"]."\" id=\"i32\">";
        echo "<b>".ucfirst($file)."</b>";
        echo "</div>";
        echo "</a>";
      
    }
  }
  }
  reset($x);
  asort($x);
  while(list(,$file) = each($x)){
  if ($file != "." && $file != ".." && $file != "index.php"){
    if(!is_dir($_SESSION["rep"].$file)){
      $ext = pathinfo($file, PATHINFO_EXTENSION);
      if(in_array($ext, $format)){
      
        $t = getimagesize($_SESSION["rep"].$file);
        echo "<img class=\"image\" src=\"".$_SESSION["location"].$_SESSION["rep"].$file."\" title=\"".ucfirst($file)." - ".taille_convertir(filesize($_SESSION["rep"].$file))."\">";
        echo "<a class=\"image\" style=\"top:-".round(($t[1]/2))."px;left:-".round(($t[0]))."px;\" href=\"".$_SESSION["lien"]."?action=effacefichier&doc=".$file."&dir=".$_SESSION["rep"]."\" title=\"Supprimer !\nAttention, cette action est d&eacute;finitive !\">";
        echo "<img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"image10\">";
        echo "</a>";

      }
    }
  }
  }

  echo "<label class=\"module\" id=\"centre\">Ajouter un fichier !</label>";
  echo "<form class=\"module\" id=\"centre\" method=\"POST\" action=\"".$_SESSION["lien"]."\" enctype=\"multipart/form-data\">";
  echo "<input type=\"file\" name=\"fichier\" style=\"width:350px;padding:2px;\">";
  echo "<input type=\"image\" id=\"i24\" style=\"margin-left:5px;\" src =\"".$_SESSION["ico"]["valider"]."\" title=\"Cliquez pour valider\">";
  echo "<input type=\"hidden\" name=\"fichier_type\" value=\"x\">";
  echo "<input type=\"hidden\" name=\"action\" value=\"fichierupload\">";
  echo "</form><br>\n";
}

unset($x);
unset($f);
unset($lien);
closedir($handle);
?>