<?php
//if (file_exists("securite.php")){include("securite.php");}
if(@$_SESSION["page"] == ""){$_SESSION["page"] = "accueil";}

?>


  <ul class="site" id="m">
    <li><a <?php if($_SESSION["page"]=="accueil" or $_SESSION["page"]==""){echo "class=\"site\" id=\"ma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=accueil"><img src="images/png/ecran.png" class="site" id="m">Accueil</a></li>
    <li><a <?php if($_SESSION["page"]=="agenda"){echo "class=\"site\" id=\"ma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=agenda">Agenda</a></li>
    <li><a <?php if($_SESSION["page"]=="organiseur"){echo "class=\"site\" id=\"ma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=organiseur">Organiseur</a></li>
    <li><a <?php if($_SESSION["page"]=="planning"){echo "class=\"site\" id=\"ma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=planning">Planning</a></li>
    <?php if(utilisateur(@$_SESSION["userid"])){ ?>
    <li><a <?php if($_SESSION["page"]=="gestion"){echo "class=\"site\" id=\"ma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=gestion">Gestion</a></li>
    <?php }
    if(administrateur(@$_SESSION["userid"])){?>
    <li><a <?php if($_SESSION["page"]=="carte"){echo "class=\"site\" id=\"ma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=carte">Carte</a></li>
    <li><a <?php if($_SESSION["page"]=="admin"){echo "class=\"site\" id=\"ma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=admin">Administration</a></li>
    <?php }
    ?>
  </ul>


<?php
switch (@$_SESSION["page"]) {
  default :
  break;
    case "accueil":
      if(!isset($_SESSION["inc"])){$_SESSION["voir"] = "information";}else{
      $x = array("information","inscription","secour");
      if(!in_array($_SESSION["inc"],$x)){$_SESSION["voir"] = "information";}
    }
      ?>
      <ul class="site" id="sm">
        <li><a <?php if(@$_SESSION["inc"]=="" or $_SESSION["inc"]=="information"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=accueil&inc=information">Informations</a></li>
        <li><a <?php if(@$_SESSION["inc"]=="inscription"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=accueil&inc=inscription">Inscription</a></li>
        <li><a <?php if(@$_SESSION["inc"]=="secour"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=accueil&inc=secour">Identifiant ou mot de passe perdu ?</a></li>
      </ul>
    <?php
  break; 
  case "**message":
    ?>
      <ul class="site" id="sm">
        <li><a <?php if(@$_SESSION["inc"]=="nouveau"){echo "class=\"site\" id=\"sma\"";}?> href="javascript:voir('leformulaire');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=nouveaumessage','leformulaire');">Nouveau</a></li>
      </ul>
    <?php
  break;
  case "agenda":
    if(!isset($_SESSION["voir"])){$_SESSION["voir"] = "jour";}
    $x = array("jour","mois","semaine","an","preference");
    if(!in_array($_SESSION["voir"],$x)){$_SESSION["voir"] = "jour";}
      ?>
      <ul class="site" id="sm">
        <li><a <?php if(@$_SESSION["voir"]=="jour"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"]."?page=agenda&voir=jour";?>">Journalier</a></li>
        <li><a <?php if(@$_SESSION["voir"]=="semaine"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"]."?page=agenda&voir=semaine";?>">Hebdomadaire</a></li>
        <li><a <?php if(@$_SESSION["voir"]=="mois"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"]."?page=agenda&voir=mois";?>">Mensuel</a></li>
        <li><a <?php if(@$_SESSION["voir"]=="annuel"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"]."?page=agenda&voir=an";?>">Annuel</a></li>
        <li><a <?php if(@$_SESSION["voir"]=="preference"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=agenda&voir=preference">Pr&eacute;f&eacute;rences</a></li>
      </ul>
    <?php
  break;
  case "gestion":
      ?>
      <ul class="site" id="sm">
        <?php if(utilisateur(@$_SESSION["userid"])){?>
        <li><a <?php if(@$_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href="">Stock</a></li>
        <li><a <?php if(@$_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href="">Facturation</a></li>
        <li><a <?php if(@$_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href="">Client</a></li>
        <li><a <?php if(@$_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href="">Fournisseur</a></li>
        <li><a <?php if(@$_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href="">Article</a></li>
        <li><a <?php if(@$_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href="">Nomenclature</a></li>
        <li><a <?php if(@$_SESSION["voir"]=="depense"){echo "class=\"site\" id=\"sma\"";}?>><a href="<?php echo $_SESSION["lien"]."?page=gestion&voir=depense";?>">D&eacute;penses</a></li>
        <?php }?>
      </ul>
    <?php
  break;
  case "planning":
      ?>
      <ul class="site" id="sm">
        <li <?php if(@$_SESSION["voir"]=="planning"){echo "class=\"site\" id=\"sma\"";}?>>&nbsp;</li>
      </ul>
    <?php
  break;
  case "organiseur":
      if(!isset($_SESSION["voir"])){$_SESSION["voir"] = "message";}else{
      $x = array("memoire","message","groupe","tache","preference","fichier");
      if(!in_array($_SESSION["voir"],$x)){$_SESSION["voir"] = "message";}
    }
      ?>
      <ul class="site" id="sm">
        <li><a <?php if(@$_SESSION["voir"]=="memoire"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=organiseur&voir=memoire">Aide m&eacute;moire</a></li>
        <li><a <?php if(@$_SESSION["voir"]=="message"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=organiseur&voir=message">Messagerie</a></li>
        <li><a <?php if(@$_SESSION["voir"]=="groupe"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=organiseur&voir=groupe">Groupe</a></li>
        <li><a <?php if(@$_SESSION["voir"]=="tache"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=organiseur&voir=tache">T&acirc;che</a></li>
        <li><a <?php if(@$_SESSION["voir"]=="preference"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=organiseur&voir=preference">Pr&eacute;f&eacute;rences</a></li>
        <li><a <?php if(@$_SESSION["voir"]=="fichier"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=organiseur&voir=fichier">Fichiers</a></li>
      </ul>
    <?php
  break;
  case "carte":
      ?>
      <ul class="site" id="sm">
        <?php
        $x = array();
        $y = array();
        // array_push($x,substr($file,0,-3));
        


        $dir = "fichiers/fichiers/fichiers/cartes/";
        if ($handle = opendir($dir)) {
          while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != "index.php"){array_push($y,$file);}
          }
          closedir($handle);
        }
        
        if(!isset($_SESSION["carte"])){$_SESSION["carte"] = "Default.mm";}else{
          if(!in_array($_SESSION["carte"],$y)){$_SESSION["carte"] = "Default.mm";}
        }
        
        reset($y);
        while(list($key,$val) = each($y)){
          echo "<li>";

          echo "";
          echo "<a";
          if(@$_SESSION["carte"] == $val){echo " class=\"site\" id=\"sma\" ";}else{echo " class=\"site\" id=\"sm\" ";}
          echo "href=\"".$_SESSION["lien"]."?page=carte&carte=".$val."\">";
          echo ucfirst(substr($val,0,-3));
          echo "</a></li>";
        }

        
        ?>
        <li><a <?php if($_SESSION["carte"]==""){echo "class=\"site\" id=\"sm\"";}?> href=""></a></li>
      </ul>
    <?php
  break;
  case "user":
      ?>
      <ul class="site" id="sm">
        <li><a <?php if($_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href="#">Vos Informations</a></li>
        <li><a <?php if($_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href=""></a></li>
        <li><a <?php if($_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href=""></a></li>
        <li><a <?php if($_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href=""></a></li>
        <li><a <?php if($_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href=""></a></li>
        <li><a <?php if($_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href=""></a></li>
      </ul>
    <?php
  break;
  case "admin":
    if(!isset($_SESSION["voir"])){$_SESSION["voir"] = "modules";}else{
      $x = array("nouvelles","tables","utilisateurs","fichiers","sessions","actions","redactionnel","pages","erreur","modules");
      if(!in_array($_SESSION["voir"],$x)){$_SESSION["voir"] = "modules";}
    }
      ?>
      <ul class="site" id="sm">
        <li><a <?php if($_SESSION["voir"]=="nouvelles"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=admin&voir=nouvelles">Nouvelles</a></li>
        <li><a <?php if($_SESSION["voir"]=="tables"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=admin&voir=tables">Tables</a></li>
        <li><a <?php if($_SESSION["voir"]=="utilisateurs"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=admin&voir=utilisateurs">Utilisateurs</a></li>
        <li><a <?php if($_SESSION["voir"]=="fichiers"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=admin&voir=fichiers">Fichiers</a></li>
        <li><a <?php if($_SESSION["voir"]=="pages"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=admin&voir=pages">Pages</a></li>
        <li><a <?php if($_SESSION["voir"]=="redactionnel"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=admin&voir=redactionnel">R&eacute;dactionnel</a></li>
        <li><a <?php if($_SESSION["voir"]=="sessions"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=admin&voir=sessions">Sessions</a></li>
        <li><a <?php if($_SESSION["voir"]=="actions"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=admin&voir=actions">Actions</a></li>
        <li><a <?php if($_SESSION["voir"]=="erreur"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=admin&voir=erreur">Erreurs</a></li>
        <li><a <?php if($_SESSION["voir"]=="modules"){echo "class=\"site\" id=\"sma\"";}?> href="<?php echo $_SESSION["lien"];?>?page=admin&voir=modules">Modules</a></li>
      </ul>
    <?php
  break;
  case "":
      ?>
      <ul class="site" id="sm">
        <li><a <?php if($_SESSION["voir"]==""){echo "class=\"site\" id=\"sma\"";}?> href=""></a></li>
      </ul>
    <?php
  break;
}
?>