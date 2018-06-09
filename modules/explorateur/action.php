<?php
$myFile = isset($_FILES['myFile'])?$_FILES['myFile']:null;
if ($myFile!=null) {
  include_once("classes/UserUpload.classe");
  $myUpload=new UserUpload(); // instanciation de la classe
  $myUpload->addFileType($_FILES['myFile']['type']); // appel des m�thodes publiques pour le param�trage de l'upload types de fichiers accept�es 
  $myUpload->setFile($myFile);// je d�clare le fichier � envoyer 
  $myUpload->setMaxSize(250000000); // taille maximale du fichier en octets je la place � 250 mo
  $myUpload->setMyDir($_SESSION["rep"]); // dossier de destination du fichier 
  $myUpload->setMyName(ucfirst(strtolower($_FILES['myFile']['name']))); // je cr�e le nom du fichier 
  $myUpload->myUpload(); // j'ex�cute l'upload
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