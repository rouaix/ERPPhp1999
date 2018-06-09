<?php
@session_start(); 
if (file_exists("securite.php")){include("securite.php");}
?>



<?php
switch (@$_SESSION["web"]) {
  default : 
  break;
  case "mobile":
if(!utilisateur()){?>
<div class="menu"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=user&inc=inscription">Inscrivez-vous</a></div>
<div class="menu"><a href="<?php echo $_SESSION["lien"];?>?page=user&inc=secour" title="Identifiant ou mot de passe perdu ?">Identifiant ou mot de passe perdu ?</a></div>
<?php }else{?>
<div class="menu"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=accueil">Accueil</a></div>
<div class="menu"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=agenda&voir=jour">Agenda</a></div>
<div class="menu"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=planning">Planning</a></div>
<div class="menu"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=tache">Taches</a></div>
<div class="menu"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=memoire">Aide mémoire</a></div>
<div class="menu"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=message">Messages</a></div>
<div class="menu"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=groupe">Groupes</a></div>
<div class="menu"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=gestion">Gestion</a></div>
<div class="menu"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=preference&preference=&voir=">Préférences</a></div>
<div class="menu"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=carte&carte=default.mm">Carte</a></div>
<div class="menu"><a class="menu" href="<?php echo $_SESSION["location"];?>/fichiers/">Fichiers</a></div>
<?php 
if (administrateur()){?>
<div class="menu<?php if($_SESSION["page"]=="admin"){echo "actif";}?>"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=admin">Administration</a></div>
<?php }
}  
  break;
  case "standard":
echo "<table width=\"100%\"><tr>";  
if(!utilisateur()){?>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=user&inc=inscription'" class="menu<?php if($_SESSION["page"]=="user" && @$_SESSION["inc"]=="inscription"){echo "actif";}?>">Inscrivez-vous</td>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=user&inc=secour'" class="menu<?php if($_SESSION["page"]=="user" && @$_SESSION["inc"]=="secour"){echo "actif";}?>">Identifiant ou mot de passe perdu ?</td>
<?php }else{?>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=accueil'" class="menu<?php if($_SESSION["page"]=="accueil" or $_SESSION["page"]==""){echo "actif";}?>">Accueil</td>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=agenda&voir=jour'" class="menu<?php if($_SESSION["page"]=="agenda"){echo "actif";}?>">Agenda</td>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=planning'" class="menu<?php if($_SESSION["page"]=="planning"){echo "actif";}?>">Planning</td>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=tache'" class="menu<?php if($_SESSION["page"]=="tache"){echo "actif";}?>">Taches</td>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=memoire'" class="menu<?php if($_SESSION["page"]=="memoire"){echo "actif";}?>">Aide mémoire</td>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=message'" class="menu<?php if($_SESSION["page"]=="message"){echo "actif";}?>">Messages</td>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=groupe'" class="menu<?php if($_SESSION["page"]=="groupe"){echo "actif";}?>">Groupes</td>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=gestion'" class="menu<?php if($_SESSION["page"]=="gestion"){echo "actif";}?>">Gestion</td>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=preference&preference=&voir='" class="menu<?php if($_SESSION["page"]=="preference"){echo "actif";}?>">Préférences</td>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=carte&carte=default.mm'" class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>">Carte</td>
<td onclick="location.href='<?php echo $_SESSION["location"];?>/fichiers/'" class="menu">Fichiers</td>
<?php 
if (administrateur()){?>
<td onclick="location.href='<?php echo $_SESSION["lien"];?>?page=admin'" class="menu<?php if($_SESSION["page"]=="admin"){echo "actif";}?>">Administration</td>
<?php }
}
echo "</tr></table>";  
  break;  
}






function en_attente(){
?>
<td class="menu<?php if($_SESSION["page"]=="reseau"){echo "actif";}?>"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=reseau">Réseau Social</a></td>
<td class="menu<?php if($_SESSION["page"]=="messagerie"){echo "actif";}?>"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=messagerie">Messagerie</a></td>
<td class="menu<?php if($_SESSION["page"]=="rdv"){echo "actif";}?>"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=rdv">Prise de rendez-vous</a></td>
<td class="menu<?php if($_SESSION["page"]=="appel"){echo "actif";}?>"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=appel">Gestion d'appels</a></td>
<td class="menu<?php if($_SESSION["page"]=="stock"){echo "actif";}?>"><a class="menu<?php if($_SESSION["page"]=="carte" or $_SESSION["page"]==""){echo "actif";}?>" href="<?php echo $_SESSION["lien"];?>?page=stock">Gestion de stock</a></td>
<?php
}


?>