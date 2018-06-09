<?php 
//if(file_exists("../../securite.php")){include("../../securite.php");}
//echo "<div style=\"color:#".@$_SESSION["modules"]["couleurtexte"][$_SESSION["page"]].";background-color:#".@$_SESSION["modules"]["couleurfond"][$_SESSION["page"]].";\">";

?>
 <div class="module" id="titre">Inscription</div>
<center>
<form style="width:100%;" enctype="multipart/form-data" method="post" action="<?php echo $_SESSION["lien"];?>">
<p>
<?php
//if(isset($_SESSION["modules"]["icone"]["inscription"])){echo "<img title=\"Accueil\" src=\"".$_SESSION["modules"]["icone"]["inscription"]."\" id=\"i64\">";}
?>

<p><b>L'inscription est gratuite.</b>
<p><br>Votre identifiant doit contenir un minimum de 3 caractères. Vous pouvez utiliser des points et des espaces mais évitez les caractères accentués.
<p><br>La taille minimum de votre mot de passe est de 5 caractères.
<br>Après l'ouverture de votre compte, vous recevrez par courriel une copie de votre code d'accès et de votre identifiant.
<br>
<br>

<table style="border-collapse: separate; border-spacing: 5px; margin: 0 auto; clear:both;">
<tr>
<td><label id="droite">Vous êtes</label></td>
<td><?php
$sql = "select * from civilite where etat_civilite =''";
$result = mysql_query($sql)or die("Erreur dans Civilite !");
echo "<select id=\"l250\" name=\"form_id_civilite\">";
while ($ligne = mysql_fetch_array($result)){
  //$temp = html_entity_decode($ligne["civilite"], ENT_QUOTES, 'UTF-8');
  //$titre = html_entity_decode($ligne["nom"], ENT_QUOTES, 'UTF-8');
  $temp = $ligne["nom_civilite"];
  $titre = $ligne["info_civilite"];
  echo "<option value=\"".$temp."\" ";
  if(isset($_SESSION["form_id_civilite"])&& $_SESSION["form_id_civilite"]==$temp){echo "selected";}
  echo ">".$temp." (".$titre.")";
  echo "</option>";
}
echo "</select>";
unset($temp);
unset($ligne);
?></td>
</tr>

<tr>
<td><label id="droite">Identifiant de connexion</label></td>
<td><input id="l250" type="text" name="form_login_user" value="<?php if(isset($_SESSION["form_login_user"]) && $_SESSION["form_login_user"] != ""){echo $_SESSION["form_login_user"];}else{echo "";}?>"></td>
</tr>

<tr>
<td><label id="droite">Mot de passe</label></td>
<td><input id="l250" type="password" name="form_motdepasse_user" value="<?php if(isset($_SESSION["form_motdepasse_user"]) && $_SESSION["form_motdepasse_user"] != ""){echo $_SESSION["form_motdepasse_user"];}else{echo "";}?>" title="Votre Mot de passe"></td>
</tr>

<tr>
<td><label id="droite">Confirmation du Mot de passe</label></td>
<td><input id="l250" type="password" name="form_confirmationmotdepasse" value="<?php if(isset($_SESSION["form_confirmationmotdepasse"]) && $_SESSION["form_confirmationmotdepasse"] != ""){echo $_SESSION["form_confirmationmotdepasse"];}else{echo "";}?>" title="Confirmer votre Mot de passe"></td>
</tr>

<tr>
<td><label id="droite">Email</label></td>
<td><input id="l250" type="text" name="form_email_user" value="<?php if(isset($_SESSION["form_email_user"]) && $_SESSION["form_email_user"] != ""){echo $_SESSION["form_email_user"];}else{echo "";}?>"></td>
</tr>

<tr>
<td><label id="droite">Prénom</label></td>
<td><input id="l250" type="text" name="form_prenom_user" value="<?php if(isset($_SESSION["form_prenom_user"]) && $_SESSION["form_prenom_user"] != ""){echo $_SESSION["form_prenom_user"];}else{echo "";}?>"></td>
</tr>

<tr>
<td><label id="droite">Nom</label></td>
<td><input id="l250" type="text" name="form_nom_user" value="<?php if(isset($_SESSION["form_nom_user"]) && $_SESSION["form_nom_user"] != ""){echo $_SESSION["form_nom_user"];}else{echo "";}?>"></td>
</tr>

</table>
<input type="hidden" name="action" value="inscription">
<input type="hidden" name="table" value="user">
<input type="hidden" name="form_id_user" value="<?php if(isset($_SESSION["form_id_user"]) && $_SESSION["form_id_user"] != ""){echo $_SESSION["form_id_user"];}?>">
<input type="hidden" name="form_id_lien" value="<?php if(isset($_SESSION["userid"]) && $_SESSION["userid"] != ""){echo $_SESSION["userid"];}else{echo "";}?>">
<br><br>

<input type="image" src="<?php echo $_SESSION["ico"]["valider"];?>" id="i64" name="submit" title="Cliquez pour valider">
</form>
</center>
<?php
//echo "</div>";
?>