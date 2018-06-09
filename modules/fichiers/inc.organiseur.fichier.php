<?php
if (file_exists("securite.php")){include("securite.php");}
$mime = array();
$dir = "images/mime/";
if ($handle = opendir($dir)) {
  while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && $file != "index.php"){
      $ext = pathinfo($file, PATHINFO_FILENAME);
      array_push($mime, $ext);
    }
  }
}
if(!is_dir('fichiers/users/".$_SESSION["userid"]."')){
  creer_repertoire($_SESSION["userid"]);
}
$format = array("png","pdf","txt","jpg");
      echo "<div class=\"admin\"><b>Liste des fichiers</b></div>\n";
      $dir = "fichiers/users/".$_SESSION["userid"]."/";
        if ($handle = opendir($dir)) {
          while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != "index.php"){
              $ext = pathinfo($file, PATHINFO_EXTENSION);
              echo "<div class=\"admin\" id=\"fixe\">";
              echo "<a class=\"admin\" href=\"".$_SESSION["lien"]."?action=effacefichier&doc=".$file."&dir=".$dir."\" title=\"Supprimer !\nAttention, cette action est d&eacute;finitive !\">";
              echo "<img src=\"".$_SESSION["ico"]["rouge"]."\" id=\"image10\">";
              echo "</a>";
              echo "&nbsp;&nbsp;&nbsp;";
              $lien = $_SESSION["location"]."scripts/inc.download.php?";
              $lien .= "action=fdownload";
              $lien .= "&fdownload=".$file;
              $lien .= "&fichier_type=fichieruser";
              if(in_array($ext, $format)){
                echo "<a class=\"admin\" target=\"Fichier\" href=\"".$_SESSION["location"].$dir.$file."\" title=\"Afficher\">";
                if(in_array($ext, $mime)){echo "<img src=\"images/mime/".$ext.".png\" id=\"image32\">";}else{echo "<img src=\"images/mime/vide.png\" id=\"image32\">";}
                echo "</a>";
              }else{
                if(in_array($ext, $mime)){echo "<img src=\"images/mime/".$ext.".png\" id=\"image32\">";}else{echo "<img src=\"images/mime/vide.png\" id=\"image32\">";}
              }
              echo "&nbsp;&nbsp;&nbsp;".$ext."---";
              echo "<a class=\"admin\" title=\"Chargement !\" href=\"".$lien."\">";
              //echo ucfirst(substr($file,0,-3));
              echo ucfirst($file).taille_fichier($dir.$file);
              echo "</a>";
              echo "</div>\n";
            }
          }
          closedir($handle);
        }
        echo "<div class=\"admin\" id=\"fixe\">";
        echo "<form class=\"admin\" method=\"POST\" action=\"".$_SESSION["lien"]."\" enctype=\"multipart/form-data\">";
        echo "<div>";
        echo "<b>Ajouter un fichier !</b>&nbsp;<br>";
        echo "<input type=\"file\" name=\"fichier\" style=\"width:350px;padding:2px;\">";
        echo "<input type=\"image\" id=\"image16\" style=\"margin-left:5px;\" src =\"".$_SESSION["ico"]["vert"]."\" title=\"Cliquez pour valider\">";
        echo "<input type=\"hidden\" name=\"fichier_type\" value=\"fichieruser\"><input type=\"hidden\" name=\"action\" value=\"fichierupload\">";
        echo "</div>";
        echo "</form></div>\n";
?>