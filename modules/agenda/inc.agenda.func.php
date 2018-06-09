<?php
if(file_exists("securite.php")){include("securite.php");}
if(!isset($_SESSION["pref"])){cherche_heure_travail();}

//-----------------------------------------------------------------------------------

function affiche_heuredetravail($j){
  if(!isset($_SESSION["preference"]["compteur"][$j])){$_SESSION["preference"]["compteur"][$j]=0;}
  
  if(!isset($_SESSION["total"]["travail"][$j])){$_SESSION["total"]["travail"][$j]=0;}
  if(!isset($_SESSION["total"]["travail"]["semaine"])){$_SESSION["total"]["travail"]["semaine"]=0;}  
  if(!isset($_SESSION["total"]["travail"]["nb"][$j])){$_SESSION["total"]["travail"]["nb"][$j]=0;}
  if(!isset($_SESSION["total"]["travail"]["nb"]["semaine"])){$_SESSION["total"]["travail"]["nb"]["semaine"]=0;}
      
  $temp_code ="";       
  for($z=0;$z <= $_SESSION["preference"]["compteur"][$j];$z ++) {     
    if(isset($_SESSION["preference"]["jour"][$j][$z]["debut"]) && isset($_SESSION["preference"]["jour"][$j][$z]["fin"])){
      $tempd = explode(":",$_SESSION["preference"]["jour"][$j][$z]["debut"]);
      $tempdh = $tempd[0]*20;
      $tempdm = $tempd[1]/3;     
      $tempd = $tempdh + $tempdm;
      $tempf = explode(":",$_SESSION["preference"]["jour"][$j][$z]["fin"]);
      $tempfh = $tempf[0]*20;
      $tempfm = $tempf[1]/3;
      $tempf = $tempfh + $tempfm;        
      $pos = ($tempd - 1);
      $long = ($tempf - $tempd); 
         
      $td = explode(":",$_SESSION["preference"]["jour"][$j][$z]["debut"]);
      $tf = explode(":",$_SESSION["preference"]["jour"][$j][$z]["fin"]);
      
      $_SESSION["total"]["travail"][$j] += (($tf[0]*60) + $tf[1]) - (($td[0]*60) + $td[1]) ;
      $_SESSION["total"]["travail"]["semaine"] += (($tf[0]*60) + $tf[1]) - (($td[0]*60) + $td[1]); 
      $_SESSION["total"]["travail"]["nb"][$j]++;
      $_SESSION["total"]["travail"]["nb"]["semaine"]++;            
      $zi = 5 + $z;
      $titre = "title=\"De ".$_SESSION["preference"]["jour"][$j][$z]["debut"]." à ".$_SESSION["preference"]["jour"][$j][$z]["fin"]."\"";
      $temp_code .= "<div ".$titre." class=\"agenda\" id=\"plage\" style=\"top:".$pos."px;height:".$long."px;z-index:".$zi.";\">&nbsp;</div>";
    }    
  }
  return $temp_code;
}
//-----------------------------------------------------------------------------------

function compte_evenement($ligne,$datejour){
  $table = "agenda";
  if(isset($ligne)){ 
  @reset($ligne);    
  while (list($key, $val) = @each($ligne)){
    $xdebut = explode("/",date_num($val["debut"]));
    $xdatedebut = mktime(0, 0, 0, $xdebut[1],$xdebut[0], $xdebut[2]);
    
    $xfin = explode("/",date_num($val["fin"]));
    $xdatefin = mktime(0, 0, 0, $xfin[1],$xfin[0], $xfin[2]); 

    $xsemaine = num_semaine($datejour);
    $xsemaine = str_pad($xsemaine, 2, "0", STR_PAD_LEFT);
    $ok = false;
    
    $tdx = explode(":",heure_nume($val["debut"]));
    $tfx = explode(":",heure_nume($val["fin"]));
    
    if(date("W",$val["debut"]) == $xsemaine && date("W",$val["fin"]) == $xsemaine){
      $resultat = 0;                                              
      if($xdatedebut == $datejour && $xdatefin == $datejour){
        $resultat = (($tfx[0]*60) + $tfx[1]) - (($tdx[0]*60) + $tdx[1]);
        $ok = true;
      }
      if($xdatedebut < $datejour && $xdatefin == $datejour){
        $resultat = (($tfx[0]*60) + $tfx[1]);
        $ok = true;
      }
      if($xdatedebut == $datejour && $xdatefin > $datejour){
        $resultat = ((23*60) + 60) - (($tdx[0]*60) + $tdx[1]);
        $ok = true;
      }
      if($xdatedebut < $datejour && $xdatefin > $datejour){
        $resultat = ((23*60) + 60);
        $ok = true;
      }                                 
    }
        
    if(date("W",$val["debut"]) < $xsemaine && date("W",$val["fin"]) == $xsemaine){
      $resultat = 0;
      $tfx = explode(":",heure_nume($val["fin"]));                      
      if($xdatefin == $datejour){
        $resultat = (($tfx[0]*60) + $tfx[1]);
        $ok = true;
      }
      if($xdatefin > $datejour){
        $resultat = ((23*60) + 60);
        $ok = true;
      }         
    }       
    
    if(date("W",$val["debut"]) == $xsemaine && date("W",$val["fin"]) > $xsemaine){
      $resultat = 0;
      $tdx = explode(":",heure_nume($val["debut"]));                     
      if($xdatedebut == $datejour){
        $resultat = ((23*60) + 60) - (($tdx[0]*60) + $tdx[1]);
        $ok = true;
      }
      if($xdatedebut < $datejour){
        $resultat = ((23*60) + 60);
        $ok = true;
      }             
    }
    
    if(date("W",$val["debut"]) < $xsemaine && date("W",$val["fin"]) > $xsemaine){
      $resultat = ((23*60) + 60);
      $ok = true;          
    }
    
    if($ok){
      $_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))] += $resultat;
      $_SESSION["total"]["evenement"]["semaine"] += $resultat;                        
      $_SESSION["total"]["evenement"]["nb"]["semaine"]++;
      $_SESSION["total"]["evenement"]["nb"][strtolower(jour_texte($datejour))]++;     
    }
  }
  }                
  $_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))] = compte_temp_travail($_SESSION["total"]["evenement"][strtolower(jour_texte($datejour))]);
  //$_SESSION["total"]["evenement"]["semaine"] = compte_temp_travail($_SESSION["total"]["evenement"]["semaine"]);
}

//-----------------------------------------------------------------------

function affiche_temp_travail($x,$tjour){
  $temp = compte_temp_travail($x);
  $z = "";
  if ($temp != "00h00"){
    if($tjour == "semaine"){
      $z .= $_SESSION["total"]["travail"]["nb"][$tjour]." plage".pluriel($_SESSION["total"]["travail"]["nb"][$tjour])." horaire".pluriel($_SESSION["total"]["travail"]["nb"][$tjour])." = ".$temp;
    }else{  
      $z .= $_SESSION["total"]["travail"]["nb"][$tjour]."&nbsp;".$temp."";
    }
  }else{
    $z .= "&nbsp;";
  }  
  $z .= "";
  return $z;
}

function compte_temp_travail($x){
  $tp = @floor($x/60);
  $tp = str_pad($tp, 2, "0", STR_PAD_LEFT);  
  $tpm = @fmod($x, "60");
  $tpm = str_pad($tpm, 2, "0", STR_PAD_LEFT);
  $temp = $tp."h".$tpm;
  return $temp;
}

function cherche_evenement(){
  //connexionmysql();
  $sql = "select * from agenda where id_user='".$_SESSION["userid"]."' and type_agenda='agenda' and etat_agenda='' order by debut_agenda,fin_agenda ASC";
  $result = mysql_query($sql);
  if($result){
    while ($ligne = mysql_fetch_array($result)){
      $liste[$ligne["id_agenda"]] = $ligne;
    }
  }
  return @$liste;
}

function lien_nouveau($heure){
  $temp = "<a title=\"Ajouter\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=agenda&acte=formulaire&formulaire=nouveau','surpopup');loadobjs();\"><img src=\"images/jpg/plus.jpg\" class=\"agenda\"></a>";
  return $temp;
}

function lien_editer($val){
  $temp = "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=agenda&acte=formulaire&formulaire=modifier&modifier=".$val["id"]."','surpopup');loadobjs();\"><b>".$val["nom"]."</b>&nbsp;</a>";
  return $temp;
}

function lien_supprimer($val){
  $temp = "<a href=\"".$_SESSION["lien"]."?table=agenda&action=effaceligne&effaceligne=".$val["id"]."\" title=\"Supprimer !\"><img src=\"images/jpg/x.jpg\" class=\"agenda\"></a>"; 
  return $temp;
}

function verif_debutfin_travail($xjour){
  $jour = date("N",$xjour);
  $_SESSION["debut_agenda"] = 0;
  $_SESSION["fin_agenda"] = 23;
  if(isset($_SESSION["pref"]["hf"][$jour])){
    $x = $_SESSION["pref"]["hf"][$jour]["nb"];
    $_SESSION["debut_agenda"] = date("H",strtotime($_SESSION["pref"]["hf"][$jour][1]["debut"]));
    $_SESSION["fin_agenda"] = date("H",strtotime($_SESSION["pref"]["hf"][$jour][$x]["fin"]));
  }
}

function verif_heure_travail($heure,$minute,$xjour){
  $verif = false;
  $jour = date("N",$xjour);
  $semaine = date("W",$xjour);
  if(isset($_SESSION["pref"]["hf"][$jour])){
    for($nb=1;$nb <= $_SESSION["pref"]["hf"][$jour]["nb"];$nb ++){
      $d_heure = date("H",strtotime($_SESSION["pref"]["hf"][$jour][$nb]["debut"]));
      $d_minute = date("i",strtotime($_SESSION["pref"]["hf"][$jour][$nb]["debut"]));
      $f_heure = date("H",strtotime($_SESSION["pref"]["hf"][$jour][$nb]["fin"]));
      $f_minute = date("i",strtotime($_SESSION["pref"]["hf"][$jour][$nb]["fin"]));
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
  return $verif;
}

function cherche_heure_travail(){
  if(isset($_SESSION["pref"])){unset($_SESSION["pref"]);}
  if($result = mysql_query("select id,debut,fin from preference where type='hv' and pere='".$_SESSION["userid"]."' order by debut")){
  while ($ligne = mysql_fetch_array($result)){
    if(!isset($_SESSION["pref"]["hv"][date("W",strtotime($ligne["debut"]))])){
      $_SESSION["pref"]["hv"][date("W",strtotime($ligne["debut"]))]["nb"] = 1;
    }else{
      $_SESSION["pref"]["hv"][date("W",strtotime($ligne["debut"]))]["nb"] ++;
    }
    $x = $_SESSION["pref"]["hv"][date("W",strtotime($ligne["debut"]))]["nb"];
    $_SESSION["pref"]["hv"][date("W",strtotime($ligne["debut"]))][$x] = $ligne;
  }
  }

  if($result = mysql_query("select id,debut,fin from preference where type='hf' and pere='".$_SESSION["userid"]."' order by debut")){
  while ($ligne = mysql_fetch_array($result)){
    if(!isset($_SESSION["pref"]["hf"][date("N",strtotime($ligne["debut"]))])){
      $_SESSION["pref"]["hf"][date("N",strtotime($ligne["debut"]))]["nb"] = 1;
    }else{
      $_SESSION["pref"]["hf"][date("N",strtotime($ligne["debut"]))]["nb"] ++;
    }
    $x = $_SESSION["pref"]["hf"][date("N",strtotime($ligne["debut"]))]["nb"];
    $_SESSION["pref"]["hf"][date("N",strtotime($ligne["debut"]))][$x] = $ligne;
  }
  }
}
?>
