<?php
//if (file_exists("securite.php")){include("securite.php");}
if(isset($_SESSION["retourtable"]) && @$_SESSION["retourtable"]!= ""){
  $_SESSION["table"] = $_SESSION["retourtable"];
  unset($_SESSION["retourtable"]);
}
if(@$_SESSION["page"] == ""){$_SESSION["page"] = "accueil";}
?>
<table class="logo" id="ancre_haut" <?php echo style_cherche('','logo','couleur'); ?>><tr>
<td><span>www.rouaix.com</span></td>
<td width="500px"><?php login_affiche();?></td>
</tr>
</table>
<div style="margin:2px;"><p id="droite">En d&eacute;veloppement <i> / Ouvert (Version mobile en construction)</i></p></div>
<div class="site">
<?php
module("navigation","menu");
?>
<div class="pop" id="leformulaire" style="display:none;"><center><img src="images/loader/chargement2.gif"></center></div>
<div class="pop" id="max" style="display:none;"><div id="surmax"><center><img src="images/loader/chargement2.gif"></center></div></div>
<div class="pop" id="popup" style="display:none;"><div id="surpopup"><center><img src="images/loader/chargement2.gif"></center></div></div>
<div class="pop" id="pop" style="display:none;"><div id="surpop"><center><img src="images/loader/chargement2.gif"></center></div></div>
<div class="site" id ="cadre">
<?php
alertes();
if(isset($_SESSION["modules"]["117"][$_SESSION["page"]]) && !isset($_SESSION["mpage"]))
{module($_SESSION["page"],"affichage.table");}

if(isset($_SESSION["modules"]["118"][$_SESSION["page"]]) && !isset($_SESSION["mpage"]))
{module($_SESSION["page"],"affichage.liste");}

if(isset($_SESSION["mpage"]) && $_SESSION["mpage"] != "")
{
  module($_SESSION["page"],$_SESSION["mpage"]);  
}else{
  module($_SESSION["page"],"index");
}

unset($_SESSION["mpage"]);
?>
<div style="margin:2px 2px 2px 2px;"><a href="scripts/index.php?erreur=<?php echo $_SESSION["page"];?>&action=erreur" title="Cliquez pour signaler une erreur."><p id="centre">Signaler une erreur sur cette page : <img src="<?php echo module_icone("erreurs"); ?>" id="i16"></a></p></div>
</div>

<?php
if(file_exists("scripts/inc.footer.php")){include("scripts/inc.footer.php");}
//unset($_SESSION["ico"]);
//$_SESSION["page_precedente"] = $_SESSION["page"];
array_push($_SESSION["navigation"],$_SESSION["page"]);
?>  
</div>
