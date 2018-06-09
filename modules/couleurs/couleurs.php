<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

$blanc = 100;
$noir = 100;
 
$pas = 51;
$min = 0;
$max = 255;

$r = $max;
$v = $max;
$b = $max;

$l = 100;

echo "<table class=\"couleur\">\n";

for($x = $min;$x <= $max;$x += $pas){
  echo "<tr>\n";
  for($r = $min;$r <= $max;$r += $pas){affiche_y($x,$x,$x);}

  for($r = $min;$r <= $max;$r += $pas){affiche_y($r,0,0);}
  for($v = $min;$v <= $max;$v += $pas){affiche_y(0,$v,0);}
  for($b = $min;$b <= $max;$b += $pas){affiche_y(0,0,$b);}
    
  for($r = $min;$r <= $max;$r += $pas){affiche_y($r,$v,$b);}
  for($v = $min;$v <= $max;$v += $pas){affiche_y($r,$v,$b);}
  for($b = $min;$b <= $max;$b += $pas){affiche_y($r,$v,$b);}

  //for($r = $min;$r <= $max;$r += $pas){affiche_y($r,$x,$b);}
  for($v = $min;$v <= $max;$v += $pas){affiche_y($r,$v,$x);}
  //for($b = $min;$b <= $max;$b += $pas){affiche_y($x,$v,$b);}
  
  for($r = $min;$r <= $max;$r += $pas){affiche_y($r,$v,$x);}
  for($v = $min;$v <= $max;$v += $pas){affiche_y($x,$v,$b);}
  //for($b = $min;$b <= $max;$b += $pas){affiche_y($r,$x,$b);}
    
  for($r = $min;$r <= $max;$r += $pas){affiche_y($r,$x,$x);}
  for($v = $min;$v <= $max;$v += $pas){affiche_y($x,$v,$x);}
  for($b = $min;$b <= $max;$b += $pas){affiche_y($x,$x,$b);}
  echo "</tr>\n";
}   

echo "</table>\n";
//----------------------------------------------------

echo "<table class=\"couleur\">\n";
for($l = 0;$l < 100 ;$l += round(100/($max / $pas))){
  echo "<tr>\n";
  affiche_x($max,$min,$min,$l);
  for($x = $min;$x < $max;$x += $pas){affiche_x($max,$x,$min,$l);}
  affiche_x($max,$max,$min,$l);
  for($x = $max;$x > $min;$x -= $pas){affiche_x($x,$max,$min,$l);}
  affiche_x($min,$max,$min,$l);
  for($x = $min;$x < $max;$x += $pas){affiche_x($min,$max,$x,$l);}
  affiche_x($min,$max,$max,$l);
  for($x = $max;$x > $min;$x -= $pas){affiche_x($min,$x,$max,$l);}
  affiche_x($min,$min,$max,$l);
  for($x = $min;$x < $max;$x += $pas){affiche_x($x,$min,$max,$l);}
  affiche_x($max,$min,$max,$l);
  for($x = $max;$x > $min;$x -= $pas){affiche_x($x,$min,$x,$l);}
  affiche_x($min,$min,$min,$l);
  echo "</tr>\n";  
}
echo "</table>\n";

echo "<table class=\"couleur\">\n";
for($z = $min;$z < $max;$z += $pas){
  echo "<tr>\n";
  affiche_x($max,$min + $z,$min + $z,100);
  for($x = $min;$x < $max;$x += $pas){affiche_x($max,$x + $z,$min + $z,100);}  
  affiche_x($max,$max,$min + $z,100);
  for($x = $max;$x > $min;$x -= $pas){affiche_x($x + $z,$max,$min + $z,100);}
  affiche_x($min + $z,$max,$min + $z,100);
  for($x = $min;$x < $max;$x += $pas){affiche_x($min + $z,$max,$x + $z,100);}
  affiche_x($min + $z,$max,$max,100);
  for($x = $max;$x > $min;$x -= $pas){affiche_x($min + $z,$x + $z,$max,100);}
  affiche_x($min + $z,$min + $z,$max,100);
  for($x = $min;$x < $max;$x += $pas){affiche_x($x + $z,$min + $z,$max,100);}
  affiche_x($max,$min + $z,$max,100);
  for($x = $max;$x > $min;$x -= $pas){affiche_x($x + $z,$min + $z,$x + $z,100);}
  affiche_x($min + $z,$min + $z,$min + $z,100);
  echo "</tr>\n";
}
echo "</table>\n";

$l = 100;

echo "<table cellspacing=\"0\" cellpadding=\"0\" class=\"couleur\">\n";
echo "<tr>\n";
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
echo "</tr>\n";
echo "</table>\n";

echo "<table class=\"couleur\">\n";
for($x = $min;$x <= $max;$x += $pas){
  echo "<tr>\n";  
  for($y = $min;$y <= $max;$y += $pas){affiche_x($y,$x,$x - $y,$l);}
  echo "</tr>\n";
}
echo "</table>\n";


echo "<table class=\"couleur\">\n";
echo "<tr>\n";
for($y = $min;$y <= $max;$y += $pas){affiche_x($y,$y,$y,$l);}
echo "</tr>\n";
echo "</table>\n";

echo "<table class=\"couleur\">\n";
echo "<tr>\n";
for($x = $min;$x < $max;$x += $pas*2){
  $l = round($x/($max/100));
  affiche_x($max,0,0,$l);
}
for($y = $min;$y <= $max;$y += $pas*2){affiche_y($max,$y,$y);}
echo "</tr>\n";
echo "</table>\n";

echo "<table class=\"couleur\">\n";
echo "<tr>\n";
for($x = $min;$x < $max;$x += $pas*2){
  $l = round($x/($max/100));
  affiche_x($max,$max,0,$l);
}
for($y = $min;$y <= $max;$y += $pas*2){affiche_y($max,$max,$y);}
echo "</tr>\n";
echo "</table>\n";

echo "<table class=\"couleur\">\n";
echo "<tr>\n";
for($x = $min;$x < $max;$x += $pas*2){
  $l = round($x/($max/100));
  affiche_x(0,$max,0,$l);
}
for($y = $min;$y <= $max;$y += $pas*2){affiche_y($y,$max,$y);}
echo "</tr>\n";
echo "</table>\n";

echo "<table class=\"couleur\">\n";
echo "<tr>\n";
for($x = $min;$x < $max;$x += $pas*2){
  $l = round($x/($max/100));
  affiche_x(0,0,$max,$l);
}
for($y = $min;$y <= $max;$y += $pas*2){affiche_y($y,$y,$max);}
echo "</tr>\n";
echo "</table>\n";

echo "<table class=\"couleur\">\n";
echo "<tr>\n";
for($x = $min;$x < $max;$x += $pas*2){
  $l = round($x/($max/100));
  affiche_x(0,$max,$max,$l);
}
for($y = $min;$y <= $max;$y += $pas*2){affiche_y($y,$max,$max);}
echo "</tr>\n";
echo "</table>\n";

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