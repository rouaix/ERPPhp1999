<?php
switch (@$inc) {
  default :
  break;  
  case "a":
    switch (@$_SESSION["web"]) {
      default : 
      break;
      case "mobile":
      ?>
        <center><a href="<?php echo $_SESSION["location"];?>scripts/index.php?page=accueil" title="Site en cours de développement"><img src="images/logo/logo10.png" border="0" class="logo"></a></center>  
      <?php
      break;
      case "standard":
      ?>
        <a href="<?php echo $_SESSION["location"];?>scripts/index.php?page=accueil" title="Site en cours de développement"><img src="images/logo/logo10.png" border="0" class="logo"></a>  
      <?php
      break;  
    }       
  break; 
  case "b":
    switch (@$_SESSION["web"]) {
      default : 
      break;
      case "mobile":
      ?>
        <a href="scripts/index.php?web=standard"><img src="images/png/ecran.png" height="32px" border="0" title="Version standard (En construction)" height="32px"></a>
      <?php
      break;
      case "standard":
      ?>
        <i>Version Bêta</i><a href="javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=afficherradio','surpopup');loadobjs();"><img src="images/png/casque.png" title="Ecouter la radio" border="0" class="logo" id="menu"></a>
        <a href="scripts/index.php?web=mobile"><img src="images/png/mobile.png" border="0" title="Version mobile (En construction)" class="logo" id="menu"></a>
      <?php
      break;  
    } 
  break;
}
unset($_SESSION["inc"]);
?>