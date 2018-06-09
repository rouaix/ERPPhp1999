<?php
$myFile = isset($_FILES['myFile'])?$_FILES['myFile']:null;
if ($myFile!=null) {
  include_once("classes/UserUpload.classe");
  $myUpload=new UserUpload(); // instanciation de la classe
  $myUpload->addFileType($_FILES['myFile']['type']); // appel des méthodes publiques pour le paramétrage de l'upload types de fichiers acceptées 
  $myUpload->setFile($myFile);// je déclare le fichier à envoyer 
  $myUpload->setMaxSize(250000000); // taille maximale du fichier en octets je la place à 250 mo
  $myUpload->setMyDir($_SESSION["rep"]); // dossier de destination du fichier 
  $myUpload->setMyName(ucfirst(strtolower($_FILES['myFile']['name']))); // je crée le nom du fichier 
  $myUpload->myUpload(); // j'exécute l'upload
}
unset($myFile);
unset($_FILES['myFile']); 

$myDir = isset($_SESSION['myDir'])?$_SESSION['myDir']:null;
if ($myDir!=null) {
  if(strrpos($_SESSION["rep"], "fichiers/users/".$_SESSION["userid"]) === false){
    $_SESSION["alerte"] = "Chemin interdit";
  }else{
    repertoire_creation($_SESSION["userid"]);
    if(!is_dir("../".$_SESSION["rep"]."/".$myDir)){
      mkdir ("../".$_SESSION["rep"]."/".$myDir);
      $Fnm = "../".$_SESSION["rep"]."/".$myDir."/index.php";
      $inF = fopen($Fnm,"w");
      $texte = "<"."?php"."\n"."\n"."?".">";
      fwrite($inF,$texte);
      fclose($inF);     
    }
  }    
}
unset($myDir);
unset($_SESSION['myDir']);

if(isset($_SESSION['effacedossier'])?$_SESSION['effacedossier']:null){
  repertoire_supprimer($_SESSION['effacedossier']);
  unset($_SESSION['effacedossier']);
}
?>