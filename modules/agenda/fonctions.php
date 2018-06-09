<?php
//if(file_exists("securite.php")){include("securite.php");}
//if(!isset($_SESSION["preferences"])){cherche_heure_travail();}

//-----------------------------------------------------------------------------------
function compte_evenement_jour($ligne,$datejour){
  $_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))]="00:00";
  $table = "agenda";  
  if(isset($ligne)){ 
    @reset($ligne);    
    while (list($key, $val) = @each($ligne)){
      $xdebut = explode("/",date_numerique(strtotime($val["debut_agenda"])));
      $xdatedebut = mktime(0, 0, 0, $xdebut[1],$xdebut[0], $xdebut[2]);    
      $xfin = explode("/",date_numerique(strtotime($val["fin_agenda"])));
      $xdatefin = mktime(0, 0, 0, $xfin[1],$xfin[0], $xfin[2]); 
      $xsemaine = semaine_numero($datejour);
      $xsemaine = str_pad($xsemaine, 2, "0", STR_PAD_LEFT);        
      $tdx = explode(":",heure_numerique(strtotime($val["debut_agenda"])));
      $tfx = explode(":",heure_numerique(strtotime($val["fin_agenda"])));
      $ok = false;
      $resultat = 0;                                              
      if($xdatedebut == $datejour && $xdatefin == $datejour){
        $resultat = (($tfx[0]*60) + $tfx[1]) - (($tdx[0]*60) + $tdx[1]);
        $ok = true;
      }                                
      if($ok){
        if(isset($_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))])){
          $_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))] += $resultat;
        }else{
          $_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))] = $resultat;
        }      
        if (isset($_SESSION["total"]["evenement"]["semaine"])){
          $_SESSION["total"]["evenement"]["semaine"] += $resultat; 
        }else{
          $_SESSION["total"]["evenement"]["semaine"] = $resultat;
        }      
        if(isset($_SESSION["total"]["evenement"]["nb"]["semaine"])){
          $_SESSION["total"]["evenement"]["nb"]["semaine"]++;
        }else{
          $_SESSION["total"]["evenement"]["nb"]["semaine"] = 1;
        }      
        if(isset($_SESSION["total"]["evenement"]["nb"][strtolower(jour_texte($datejour))])){
          $_SESSION["total"]["evenement"]["nb"][strtolower(jour_texte($datejour))]++; 
        }else{
          $_SESSION["total"]["evenement"]["nb"][strtolower(jour_texte($datejour))] = 1; 
        }          
      }
    }
  }  
  if(isset($_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))])){
    $_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))] = temps_formate($_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))]);
  }                
}

//-----------------------------------------------------------------------------------

function compte_evenement_semaine($ligne,$datejour){
  $_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))]="00:00";
  $table = "agenda";
  if(isset($ligne)){ 
    @reset($ligne);    
    while (list($key, $val) = @each($ligne)){
      $xdebut = explode("/",date_numerique(strtotime($val["debut_agenda"])));
      $xdatedebut = mktime(0, 0, 0, $xdebut[1],$xdebut[0], $xdebut[2]);    
      $xfin = explode("/",date_numerique(strtotime($val["fin_agenda"])));
      $xdatefin = mktime(0, 0, 0, $xfin[1],$xfin[0], $xfin[2]); 
      $xsemaine = semaine_numero($datejour);
      $xsemaine = str_pad($xsemaine, 2, "0", STR_PAD_LEFT);
      $ok = false;
      $tdx = explode(":",heure_numerique(strtotime($val["debut_agenda"])));
      $tfx = explode(":",heure_numerique(strtotime($val["fin_agenda"])));
      if(date("W",strtotime($val["debut_agenda"])) == $xsemaine && date("W",strtotime($val["fin_agenda"])) == $xsemaine){
        $resultat = 0;                                              
        if($xdatedebut == $datejour && $xdatefin == $datejour){
          $resultat = (($tfx[0]*60) + $tfx[1]) - (($tdx[0]*60) + $tdx[1]);
          $ok = true;
        }
        if($xdatedebut < $datejour && $xdatefin == $datejour){
          $resultat = (($tfx[0]*60) + $tfx[1]);
        //$ok = true;
        }
        if($xdatedebut == $datejour && $xdatefin > $datejour){
          $resultat = ((23*60) + 60) - (($tdx[0]*60) + $tdx[1]);
          $ok = true;
        }
        if($xdatedebut < $datejour && $xdatefin > $datejour){
          $resultat = ((23*60) + 60);
        //$ok = true;
        }                                 
      }
      if(date("W",strtotime($val["debut_agenda"])) < $xsemaine && date("W",strtotime($val["fin_agenda"])) == $xsemaine){
        $resultat = 0;
        $tfx = explode(":",heure_numerique(strtotime($val["fin_agenda"])));                      
        if($xdatefin == $datejour){
            $resultat = (($tfx[0]*60) + $tfx[1]);
        $ok = true;
        }
        if($xdatefin > $datejour){
          $resultat = ((23*60) + 60);
          $ok = true;
        }         
      }       
      if(date("W",strtotime($val["debut_agenda"])) == $xsemaine && date("W",strtotime($val["fin_agenda"])) > $xsemaine){
        $resultat = 0;
        $tdx = explode(":",heure_numerique(strtotime($val["debut_agenda"])));                     
        if($xdatedebut == $datejour){
          $resultat = ((23*60) + 60) - (($tdx[0]*60) + $tdx[1]);
          $ok = true;
        }
        if($xdatedebut < $datejour){
          $resultat = ((23*60) + 60);
          $ok = true;
        }             
      }
      if(date("W",strtotime($val["debut_agenda"])) < $xsemaine && date("W",strtotime($val["fin_agenda"])) > $xsemaine){
        $resultat = ((23*60) + 60);
        $ok = true;          
      }
      if($ok){
        if(isset($_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))])){
          $_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))] += $resultat;
        }else{
          $_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))] = $resultat;
        }
        if (isset($_SESSION["total"]["evenement"]["semaine"])){
          $_SESSION["total"]["evenement"]["semaine"] += $resultat; 
        }else{
          $_SESSION["total"]["evenement"]["semaine"] = $resultat;
        }
        if(isset($_SESSION["total"]["evenement"]["nb"]["semaine"])){
          $_SESSION["total"]["evenement"]["nb"]["semaine"]++;
        }else{
          $_SESSION["total"]["evenement"]["nb"]["semaine"] = 1;
        }                             
        if(isset($_SESSION["total"]["evenement"]["nb"][strtolower(jour_texte($datejour))])){
          $_SESSION["total"]["evenement"]["nb"][strtolower(jour_texte($datejour))]++; 
        }else{
          $_SESSION["total"]["evenement"]["nb"][strtolower(jour_texte($datejour))] = 1; 
        }          
      }
    }
  }
  if(isset($_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))])){
    $_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))] = temps_formate($_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))]);
  }                
  //$_SESSION["total"]["evenement"]["semaine"] = compte_temp_travail($_SESSION["total"]["evenement"]["semaine"]);
}

//-----------------------------------------------------------------------

function temps_formate($x){
  $tp = @floor($x/60);
  $tp = str_pad($tp, 2, "0", STR_PAD_LEFT);  
  $tpm = @fmod($x, "60");
  $tpm = str_pad($tpm, 2, "0", STR_PAD_LEFT);
  $temp = $tp."h".$tpm;
  return $temp;
}

function cherche_evenement(){
  $sql = "select * from agenda where id_user='".$_SESSION["userid"]."' and type_agenda='agenda' and etat_agenda='' order by debut_agenda,fin_agenda ASC";
  $result = mysql_query($sql);
  if($result){
    while ($ligne = mysql_fetch_array($result)){$liste[$ligne["id_agenda"]] = $ligne;}
  }
  return @$liste;
}

function lien_nouveau($heure){
  $temp = "<a title=\"Ajouter\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=agenda&acte=formulaire&formulaire=nouveau','surpopup');loadobjs();\"><img src=\"images/jpg/plus.jpg\" class=\"module\"></a>";
  return $temp;
}

function lien_editer($val){
  $temp = "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=agenda&acte=formulaire&formulaire=modifier&modifier=".$val["id_agenda"]."','surpopup');loadobjs();\"><b>".$val["nom_agenda"]."</b>&nbsp;</a>";
  return $temp;
}

function lien_supprimer($val){
  $temp = "<a href=\"".$_SESSION["lien"]."?table=agenda&action=effaceligne&effaceligne=".$val["id_agenda"]."\" title=\"Supprimer !\"><img src=\"images/jpg/x.jpg\" class=\"module\"></a>"; 
  return $temp;
}

function verif_heure_travail($heure,$minute,$xjour){
  $verif = false;
  $jour = date("N",$xjour);
  $semaine = date("W",$xjour);  
  if(isset($_SESSION["preferences"]["horaire"]["jour"][$jour]) && !isset($_SESSION["preferences"]["horaire"]["semaine"][$semaine]["jour"][$jour])){
    for($nb=1;$nb <= $_SESSION["preferences"]["horaire"]["jour"][$jour]["nb"];$nb ++){
      $d_heure = date("H",$_SESSION["preferences"]["horaire"]["jour"][$jour]["debut"][$nb]);
      $d_minute = date("i",$_SESSION["preferences"]["horaire"]["jour"][$jour]["debut"][$nb]);
      $f_heure = date("H",$_SESSION["preferences"]["horaire"]["jour"][$jour]["fin"][$nb]);
      $f_minute = date("i",$_SESSION["preferences"]["horaire"]["jour"][$jour]["fin"][$nb]);      
      if($d_heure < $heure){
        if($f_heure > $heure){$verif = true;}
        if($f_heure == $heure){
          if($f_minute > $minute){$verif = true;}
        }
      }
      if($d_heure == $heure){
        if($d_minute <= $minute){
          if($f_heure == $heure){
            if($f_minute > $minute){$verif = true;}
          }
          if($f_heure > $heure){$verif = true;}
        }
      }
    }
  }else{
    if(isset($_SESSION["preferences"]["horaire"]["semaine"][$semaine]["jour"][$jour])){
      for($nb=1;$nb <= $_SESSION["preferences"]["horaire"]["semaine"][$semaine]["jour"][$jour]["nb"];$nb ++){
        $d_heure = date("H",$_SESSION["preferences"]["horaire"]["semaine"][$semaine]["jour"][$jour]["debut"][$nb]);
        $d_minute = date("i",$_SESSION["preferences"]["horaire"]["semaine"][$semaine]["jour"][$jour]["debut"][$nb]);
        $f_heure = date("H",$_SESSION["preferences"]["horaire"]["semaine"][$semaine]["jour"][$jour]["fin"][$nb]);
        $f_minute = date("i",$_SESSION["preferences"]["horaire"]["semaine"][$semaine]["jour"][$jour]["fin"][$nb]);
        if($d_heure < $heure){
          if($f_heure > $heure){$verif = true;}
          if($f_heure == $heure){
            if($f_minute > $minute){$verif = true;}
          }
        }
        if($d_heure == $heure){
          if($d_minute <= $minute){
            if($f_heure == $heure){
              if($f_minute > $minute){$verif = true;}
            }
            if($f_heure > $heure){$verif = true;}
          }
        }
      }
    }  
  }
  return $verif;
}

function old_cherche_heure_travail(){
  if(isset($_SESSION["preferences"])){unset($_SESSION["preferences"]);}
  if($result = mysql_query("select id_preferences,debut_preferences,fin_preferences from preferences where type_preferences='hv' and id_user='".$_SESSION["userid"]."' order by debut_preferences")){
    while ($ligne = mysql_fetch_array($result)){
      if(!isset($_SESSION["preferences"]["hv"][date("W",strtotime($ligne["debut_preferences"]))])){
        $_SESSION["preferences"]["hv"][date("W",strtotime($ligne["debut_preferences"]))]["nb"] = 1;
      }else{
        $_SESSION["preferences"]["hv"][date("W",strtotime($ligne["debut_preferences"]))]["nb"] ++;
      }
      $x = $_SESSION["preferences"]["hv"][date("W",strtotime($ligne["debut_preferences"]))]["nb"];
      $_SESSION["preferences"]["hv"][date("W",strtotime($ligne["debut_preferences"]))][$x] = $ligne;
    }
  }

  if($result = mysql_query("select id_preferences,debut_preferences,fin_preferences from preferences where type_preferences='hf' and id_user='".$_SESSION["userid"]."' order by debut_preferences")){
    while ($ligne = mysql_fetch_array($result)){
      if(!isset($_SESSION["preferences"]["hf"][date("N",strtotime($ligne["debut_preferences"]))])){
        $_SESSION["preferences"]["hf"][date("N",strtotime($ligne["debut_preferences"]))]["nb"] = 1;
      }else{
        $_SESSION["preferences"]["hf"][date("N",strtotime($ligne["debut_preferences"]))]["nb"] ++;
      }
      $x = $_SESSION["preferences"]["hf"][date("N",strtotime($ligne["debut_preferences"]))]["nb"];
      $_SESSION["preferences"]["hf"][date("N",strtotime($ligne["debut_preferences"]))][$x] = $ligne;
    }
  }
}

function cherche_preferences_horaire_travail(){
  if(isset($_SESSION["preferences"]["horaire"])){unset($_SESSION["preferences"]["horaire"]);}
  if($result = mysql_query("select id_preferences,debut_preferences,fin_preferences from preferences where type_preferences='hv' and id_user='".$_SESSION["userid"]."' order by debut_preferences")){
    while ($ligne = mysql_fetch_array($result)){      
      $njour = date("N",strtotime($ligne["debut_preferences"]));
      $nsemaine = date("W",strtotime($ligne["debut_preferences"]));
      $debut = strtotime($ligne["debut_preferences"]);
      $fin = strtotime($ligne["fin_preferences"]);         
      if(!isset($_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["nb"])){
        $_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["nb"] = 1;
      }else{
        $_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["nb"] ++;
      }
      $nb = $_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["nb"];            
      $_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["debut"][$nb] = $debut;
      $_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["fin"][$nb] = $fin;      
    }                                                                                       
  }
  if($result = mysql_query("select id_preferences,debut_preferences,fin_preferences from preferences where type_preferences='hf' and id_user='".$_SESSION["userid"]."' order by debut_preferences")){
    while ($ligne = mysql_fetch_array($result)){
      $njour = date("N",strtotime($ligne["debut_preferences"]));
      $debut = strtotime($ligne["debut_preferences"]);
      $fin = strtotime($ligne["fin_preferences"]);    
      if(!isset($_SESSION["preferences"]["horaire"]["jour"][$njour]["nb"])){
        $_SESSION["preferences"]["horaire"]["jour"][$njour]["nb"] = 1;
      }else{
        $_SESSION["preferences"]["horaire"]["jour"][$njour]["nb"] ++;
      }
      $nb = $_SESSION["preferences"]["horaire"]["jour"][$njour]["nb"];            
      $_SESSION["preferences"]["horaire"]["jour"][$njour]["debut"][$nb] = $debut;
      $_SESSION["preferences"]["horaire"]["jour"][$njour]["fin"][$nb] = $fin;  
    }
  }
}

function verif_debut_fin_journee_travail($xjour){
  $njour = date("N",$xjour);
  $nsemaine = date("W",$xjour);
  
  $_SESSION["debut_agenda"] = 0;
  $_SESSION["fin_agenda"] = 23;
  
  if(isset($_SESSION["preferences"]["horaire"]["jour"][$njour])){
    $nb = $_SESSION["preferences"]["horaire"]["jour"][$njour]["nb"];
    $_SESSION["debut_agenda"] = date("H",$_SESSION["preferences"]["horaire"]["jour"][$njour]["debut"][1]);
    $_SESSION["fin_agenda"] = date("H",$_SESSION["preferences"]["horaire"]["jour"][$njour]["fin"][$nb]);
  }

  if(isset($_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour])){
    $nb = $_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["nb"];
    $_SESSION["debut_agenda"] = date("H",$_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["debut"][1]);
    $_SESSION["fin_agenda"] = date("H",$_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["fin"][$nb]);
  }
}

function compte_temps_jour($xjour){
  $code = "";
  $somme = 0;
  $njour = date("N",$xjour);
  $nsemaine = date("W",$xjour);  
  if(isset($_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour])){
    for($nb = 1;$nb <= $_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["nb"];$nb ++){
      $dh = date("H",$_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["debut"][$nb]);
      $dm = date("i",$_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["debut"][$nb]);        
      $fh = date("H",$_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["fin"][$nb]);
      $fm = date("i",$_SESSION["preferences"]["horaire"]["semaine"][$nsemaine]["jour"][$njour]["fin"][$nb]);
      if($dh < $fh){$somme += (($fh - $dh)*60) + $fm - $dm;}
      if($dh == $fh){$somme += ($fm - $dm);}        
    }   
  }else{  
    if(isset($_SESSION["preferences"]["horaire"]["jour"][$njour])){
      for($nb = 1;$nb <= $_SESSION["preferences"]["horaire"]["jour"][$njour]["nb"];$nb ++){
        $dh = date("H",$_SESSION["preferences"]["horaire"]["jour"][$njour]["debut"][$nb]);
        $dm = date("i",$_SESSION["preferences"]["horaire"]["jour"][$njour]["debut"][$nb]);        
        $fh = date("H",$_SESSION["preferences"]["horaire"]["jour"][$njour]["fin"][$nb]);
        $fm = date("i",$_SESSION["preferences"]["horaire"]["jour"][$njour]["fin"][$nb]);
        if($dh < $fh){$somme += (($fh - $dh)*60) + $fm - $dm;}
        if($dh == $fh){$somme += ($fm - $dm);}        
      }  
    }
  }
  if($somme < 60){
    $code = "00h".str_pad($somme % 60, 2, "0", STR_PAD_LEFT);
  }else{
    $code = str_pad(round($somme / 60), 2, "0", STR_PAD_LEFT) ."h".str_pad($somme % 60, 2, "0", STR_PAD_LEFT);
  }
  return $code;
}
?>
