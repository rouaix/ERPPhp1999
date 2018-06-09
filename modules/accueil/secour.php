<?php
if(file_exists("../../securite.php")){include("../../securite.php");}
?>

<h3><img src="images/divers/user_277.png" border="0" id="i32"> Identifiant ou mot de passe perdu ?</h3>

<center>
<form enctype="multipart/form-data" style="width:400px;" method="post" action="<?php echo $_SESSION["lien"];?>">
<p id="centre">Pour recevoir un email contenant vos informations de connexion, veuillez saisir votre adresse email, votre prénom et votre nom.</p>
<br><br>
<label>Email</label>
<input type="text" name="form_email_user" value="">
<label>Prénom</label>
<input type="text" name="form_prenom_user" value="">
<label>Nom</label>
<input type="text" name="form_nom_user" value="">
<p><br><p id="centre">Ou votre identifiant</p><p><br>
<label>Identifiant</label>
<input type="text" name="form_login_user" value="">
<br><br>
<input type="image" src="images/jpg/valider.jpg" id="image32" name="submit" title="Cliquez pour valider">
<input type="hidden" name="action" value="usersecour">
</form>
</center>