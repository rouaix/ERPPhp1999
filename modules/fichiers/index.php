<?php
if(!isset($_SESSION)){session_start();}
//if($_SESSION["page"] != $_SESSION["page"]["historique"]){unset($_SESSION["rep"]);}

if(!isset($_SESSION["arbre"]["admin"])){repertoire_liste("./","admin");}

if(administrateur($_SESSION["userid"])){
  if(!isset($_SESSION["rep"]) or @$_SESSION["rep"]== ""){$_SESSION["rep"] = "./";}
  $racine = "./";
  $lien = substr($_SESSION["rep"],strlen($racine));
  //$lien = $racine;
  
  echo "<div class=\"module\" id=\"titre\">";
  if($_SESSION["rep"] != $racine){
    echo "<a class=\"module\" href=\"".$_SESSION["lien"]."?rep=".$racine."\" title=\"Vos Fichiers\">";
    //echo "<img src=\"".$_SESSION["ico"]["retour"]."\" class=\"module\">";
    echo "www.rouaix.com ";
    echo "</a>";
  }else{echo "www.rouaix.com ";}
  
  $dossier = explode("/",$lien);
  
  for($x = 0; $x < count($dossier); $x++) {
    if ($x < count($dossier)-2){
      echo " > ";
      echo "<a class=\"module\" href=\"".$_SESSION["lien"]."?rep=".$racine;    
      for ($y = 0; $y <= $x; $y++){echo $dossier[$y]."/";}
      echo "\" title=\"Fichiers du site\">";
      echo ucfirst($dossier[$x]);
      echo "</a>";
    }else{
      echo " > ".ucfirst($dossier[$x]);
    }
  }
  
  echo "</div>";
         
  if ($handle = @opendir($_SESSION["rep"])) {
    $listefichiers = array ();
    while (false !== ($listefile = readdir($handle))){array_push ($listefichiers,$listefile);}
    sort($listefichiers);
    while (list($key,$file) = each($listefichiers)){
      if($file != '.' && $file != '..' && $file != '.htacces' && $file != 'index.php') {
        echo "<div class=\"module\" id=\"block\">";
        echo menu_ligne_fichier($_SESSION["rep"],$file);
        echo "</div>\n";
      }
    }
    closedir($handle);
  }
  
  echo "<table class=\"table\"><tr id=\"form\"><td id=\"form\">";
  
    echo "<label class=\"module\" id=\"centre\">Ajouter un fichier !</label>";
    echo "<form class=\"module\" id=\"centre\" method=\"POST\" action=\"".$_SESSION["lien"]."\" enctype=\"multipart/form-data\">";
    //echo "<input type=\"file\" name=\"fichier\" style=\"width:350px;padding:2px;\">";
    echo "<input type=\"file\" name=\"myFile\" id=\"myFile\" style=\"width:350px;padding:2px;\">";
    echo "<input type=\"image\" id=\"i24\" style=\"margin-left:5px;\" src =\"".$_SESSION["ico"]["valider"]."\" title=\"Cliquez pour valider\">";
    //echo "<input type=\"hidden\" name=\"fichier_type\" value=\"x\">";
    //echo "<input type=\"hidden\" name=\"action\" value=\"fichierupload\">";
    echo "</form><br>\n";
  
  echo "</td><td>";  
    echo "<label class=\"module\" id=\"centre\">Ajouter un dossier !</label>";
    echo "<form class=\"module\" id=\"centre\" method=\"POST\" action=\"".$_SESSION["lien"]."\" enctype=\"multipart/form-data\">";
    //echo "<input type=\"file\" name=\"fichier\" style=\"width:350px;padding:2px;\">";
    echo "<input type=\"text\" name=\"myDir\" id=\"myDir\" style=\"width:350px;padding:2px;\">";
    echo "<input type=\"image\" id=\"i24\" style=\"margin-left:5px;\" src =\"".$_SESSION["ico"]["valider"]."\" title=\"Cliquez pour valider\">";
    //echo "<input type=\"hidden\" name=\"fichier_type\" value=\"x\">";
    //echo "<input type=\"hidden\" name=\"action\" value=\"fichierupload\">";
    echo "</form><br>\n";
    
  echo "</td></tr></table>";
}
//------------------------------------------------------------------------------
?>