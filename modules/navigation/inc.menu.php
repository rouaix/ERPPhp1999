<?php if (file_exists("securite.php")){include("securite.php");}?>
<ul class="menu"">
<?php 
if(isset($_SESSION["userid"])){
?>
<li class="menu"><a class="menu" href="<?php echo $_SESSION["lien"];?>?page="> </a></li>
<?php }?>
<li class="menu"><a class="menu" href="<?php echo $_SESSION["lien"];?>?page=accueil">Accueil</a></li>
</ul>
<?php
//switch (@$_SESSION["menu"]) {
//  default :
//  break;
//  case "login" :
//    echo "<td>";
//    echo "<ul class=\"menu\">";
//    echo "<li>000</li>";
//    echo "<li>001</li>";
//    echo "<li>002</li>";
//    echo "</ul>";
//    echo "</td>";    
//  break;
//  case "menu" :
//    echo "<td>";
//    echo "<ul class=\"menu\">";
//    echo "<li>000</li>";
//    echo "<li>001</li>";
//    echo "<li>002</li>";
//    echo "</ul>";
//    echo "</td>";    
//  break;
//}
?>