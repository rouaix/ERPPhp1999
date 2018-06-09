<?php 
//if (file_exists("securite.php")){include("securite.php");}
?>
<h3><img src="images/png/carre-jaune.png" border="0" width="32px"> Inscription</h3>
<center>
<form style="width:450px;" enctype="multipart/form-data" method="post" action="<?php echo $_SESSION["lien"];?>">
<p><img src="images/png/carre-jaune.png" border="0" height="32px">
<p><b>L'inscription est gratuite.</b>
<p><br>Votre identifiant doit contenir un minimum de 3 caract&#269;res. Vous pouvez utiliser des points et des espaces mais &eacute;vitez les caract&#269;res accentu&eacute;s.
<p><br>La taille minimum de votre mot de passe est de 5 caract&#269;res.
<br>Apr&#269;s l'ouverture de votre compte, vous recevrez par e-mail une copie de votre code d'acc&#269;s et de votre identifiant.
<br><br><label>Vous êtes</label>
<?php
$sql = "select * from civilite where etat=''";
$result = mysql_query($sql)or die("Erreur dans Civilite !");
echo "<select  name=\"form_civilite\">";
while ($ligne = mysql_fetch_array($result)){
  //$temp = html_entity_decode($ligne["civilite"], ENT_QUOTES, 'UTF-8');
  //$titre = html_entity_decode($ligne["nom"], ENT_QUOTES, 'UTF-8');
  $temp = $ligne["civilite"];
  $titre = $ligne["nom"];
  echo "<option value=\"".$temp."\" ";
  if(isset($_SESSION["form_civilite"])&& $_SESSION["form_civilite"]==$temp){echo "selected";}
  echo ">".$temp." (".$titre.")";
  echo "</option>";
}
echo "</select>";
unset($temp);
unset($ligne);
mysql_free_result($result);
?>
<label>Identifiant de connexion</label>
<input type="text" name="form_user" value="<?php if(isset($_SESSION["form_user"]) && $_SESSION["form_user"] != ""){echo $_SESSION["form_user"];}else{echo "";}?>">
<label>Mot de passe</label>
<input type="password" name="form_motdepasse" value="<?php if(isset($_SESSION["form_motdepasse"]) && $_SESSION["form_motdepasse"] != ""){echo $_SESSION["form_motdepasse"];}else{echo "";}?>" title="Votre Mot de passe">
<label>Confirmation du Mot de passe</label>
<input type="password" name="form_confirmationmotdepasse" value="<?php if(isset($_SESSION["form_confirmationmotdepasse"]) && $_SESSION["form_confirmationmotdepasse"] != ""){echo $_SESSION["form_confirmationmotdepasse"];}else{echo "";}?>" title="Confirmer votre Mot de passe">
<label>Email</label>
<input type="text" name="form_email" value="<?php if(isset($_SESSION["form_email"]) && $_SESSION["form_email"] != ""){echo $_SESSION["form_email"];}else{echo "";}?>">
<label>Prénom</label>
<input type="text" name="form_prenom" value="<?php if(isset($_SESSION["form_prenom"]) && $_SESSION["form_prenom"] != ""){echo $_SESSION["form_prenom"];}else{echo "";}?>">
<label>Nom</label>
<input type="text" name="form_nom" value="<?php if(isset($_SESSION["form_nom"]) && $_SESSION["form_nom"] != ""){echo $_SESSION["form_nom"];}else{echo "";}?>">
<input type="hidden" name="action" value="inscription">
<input type="hidden" name="table" value="user">
<input type="hidden" name="form_id" value="<?php if(isset($_SESSION["form_id"]) && $_SESSION["form_id"] != ""){echo $_SESSION["form_id"];}else{echo nouvelle_id();}?>">
<input type="hidden" name="form_pere" value="<?php if(isset($_SESSION["userid"]) && $_SESSION["userid"] != ""){echo $_SESSION["userid"];}else{echo "";}?>">
<br><br>
<input type="image" src="images/jpg/valider.jpg" id="image32" name="submit" title="Cliquez pour valider">
</form>
</center>