<?php

if(!isset($_SESSION)){session_start();}

//if (file_exists("securite.php")){include("securite.php");}
$_SESSION["alerte"] = "";
//$target = ""; // Repertoire cible
$max_size = 2500000000; // Taille max en octets du fichier

if(isset($_SESSION["userid"])&& @$_SESSION["userid"]!=""){

if(@$_FILES['fichier']['name']){
   $nom_file = $_FILES['fichier']['name'];
   $nom_file = ucfirst(strtr($nom_file,' ÀÁÂÃÄÅÇèéÊËÌÍÎÏÒÓÔÕÖÙÚÛÜ¯àâãäåçèéêëìíîï©£òóôõöùúûü~ÿ-','_AAAAAACEEEEIIIIOOOOOUUUUYaaaaaceeeeiiiioooooouuuuyyy_'));
   $taille = $_FILES['fichier']['size'];
   $tmp = $_FILES['fichier']['tmp_name'];
   $fin = explode(".",$nom_file);
   if($fin[0] == $fin[count($fin)-1]){
    $nom_file .= ".inc";
   }else{
    $ext = ".".strtolower($fin[count($fin)-1]);
   }

   if($_FILES['fichier']['name']){
      $infos_fichier = filesize($_FILES['fichier']['tmp_name']);
      if(($taille <= $max_size)){
        if($_SESSION["fichier_type"]=="userphoto"){$nom_file = $_SESSION["fichier_nom"].$ext;}
         if(@move_uploaded_file($_FILES['fichier']['tmp_name'],$target.$nom_file)){
              $_SESSION["alerte"].="<b>Fichier envoy&eacute; !</b>";
              $_SESSION["alerte"].="<br><b>Fichier :</b> ".$_FILES["fichier"]["name"]." <b>Vers</b> ".$nom_file;
              $_SESSION["alerte"].=" <b>Taille :</b> ".round($_FILES["fichier"]["size"]/1000000,1)." Mo";
         }else{
              $_SESSION["alerte"].= "<b>Transfert impossible !</b> ".$_FILES["fichier"]["error"];
         }
      }else{
         $_SESSION["alerte"].= "<b>Transfert impossible !</b> Le poids de votre fichier est de <b>".round($taille/1000000,1)." Mo</b> pour un poids maximum autoris&eacute; de <b>".round($max_size/1000000,1)." Mo</b>";
      }
   }else{
      $_SESSION["alerte"].= "<b>Transfert impossible !</b> Le nom du fichier est inconnu.";
   }
}
}
?>

