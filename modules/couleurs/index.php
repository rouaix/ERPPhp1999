<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

$l = 100;
$pas = 17;
$min = 0;
$max = 255;

echo "<table><tr><td>\n";

  echo "<table class=\"couleur\"><tr>\n";
    affiche_x($max,$min,$min,$l);
    for($x = $min;$x <= $max;$x += $pas){affiche_x($max,$x,$min,$l);}
    affiche_x($max,$max,$min,$l);
    for($X = $max;$x > $min;$x -= $pas){affiche_x($x,$max,$min,$l);}
    affiche_x($min,$max,$min,$l);
    for($x = $min;$x <= $max;$x += $pas){affiche_x($min,$max,$x,$l);} 
    affiche_x($min,$max,$max,$l);
    for($X = $max;$x > $min;$x -= $pas){affiche_x($min,$x,$max,$l);}
    affiche_x($min,$min,$max,$l);
    for($x = $min;$x <= $max;$x += $pas){affiche_x($x,$min,$max,$l);}
    affiche_x($max,$min,$max,$l);
    for($X = $max;$x > $min;$x -= $pas){affiche_x($x,$min,$x,$l);}
    affiche_x($min,$min,$min,$l);
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($y = $min;$y <= $max;$y += $pas/6.8){affiche_x($y,$y,$y,$l);}
  echo "</tr></table>\n";

echo "</td>\n";

echo "<td id=\"milieu\">\n";
  echo "<img src=\"".$_SESSION["ico"]["ajouter"]."\" id=\"i16\" title=\"Plus de couleurs\" onclick=\"voir('tcouleurs');\">";
echo "</td></tr></table>\n";

echo "<table id=\"tcouleurs\" style=\"display:none;\"><tr><td>\n";

  echo "<table class=\"couleur\">\n";
    for($x = $min;$x <= $max;$x += $pas/2){
      echo "<tr>\n";  
      for($y = $min;$y <= $max;$y += $pas/2){affiche_x($y,$x,$x - $y,$l);}
      echo "</tr>\n";
    }
  echo "</table>\n";


  echo "<table class=\"couleur\"><tr>\n";
    for($y = $min;$y <= $max;$y += $pas/2){affiche_x($y,$y,$y,$l);}
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($x = $min;$x < $max;$x += $pas){
      $l = round($x/($max/100));
      affiche_x($max,0,0,$l);
    }
    for($y = $min;$y <= $max;$y += $pas){affiche_y($max,$y,$y);}
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($x = $min;$x < $max;$x += $pas){
      $l = round($x/($max/100));
      affiche_x($max,0,$x,$l);
    }
    for($y = $min;$y <= $max;$y += $pas){affiche_y($max,$y,255);}
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($x = $min;$x < $max;$x += $pas){
      $l = round($x/($max/100));
      affiche_x($max,$max,0,$l);
    }
    for($y = $min;$y <= $max;$y += $pas){affiche_y($max,$max,$y);}
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($x = $min;$x < $max;$x += $pas){
      $l = round($x/($max/100));
      affiche_x(0,$max,0,$l);
    }
    for($y = $min;$y <= $max;$y += $pas){affiche_y($y,$max,$y);}
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($x = $min;$x < $max;$x += $pas){
      $l = round($x/($max/100));
      affiche_x(0,0,$max,$l);
    }
    for($y = $min;$y <= $max;$y += $pas){affiche_y($y,$y,$max);}
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($x = $min;$x < $max;$x += $pas){
      $l = round($x/($max/100));
      affiche_x(0,$max,$max,$l);
    }
    for($y = $min;$y <= $max;$y += $pas){affiche_y($y,$max,$max);}
  echo "</tr></table>\n";

echo "</td></tr></table>\n";

function affiche_x($r,$v,$b,$l){
  if($l > 100){$l = 100;}
  $r = round(($r * $l)/100);
  $v = round(($v * $l)/100);
  $b = round(($b * $l)/100);
  $c = couleur_rgb2html($r,$v,$b);
  echo "<td class=\"couleur\" style=\"background-color:".$c."\" title=\"Couleur ".$c."\"></td>\n";
}

function affiche_y($r,$v,$b){
  $c = couleur_rgb2html($r,$v,$b);
  echo "<td class=\"couleur\" style=\"background-color:".$c."\" title=\"Couleur ".$c."\"></td>\n";
} 
?>