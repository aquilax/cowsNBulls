<?php
session_start();
function r($c){echo '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>CowsNBulls</title></head><body style="width:300px;margin:0 auto;text-align:center"><h1>CowsNBulls</h1>'.$c.'<p>If you don\'t know the rules, check <a href="http://en.wikipedia.org/wiki/Bulls_and_cows">this article.</a></p></body>';die();}

function getRes($n, $num){
  $c=0;$b=0;
  for($i = 0; $i<4;$i++){
    if($n[$i] == $num[$i]) $b++;
    else if(strpos($num, $n[$i]) !== FALSE) $c++;
  }
  $c==1?$t='1 Cow ':$t=$c.' Cows ';
  $b==1?$t.='1 Bull':$t.=$b.' Bulls';
  return $t;
}

if (!isset($_SESSION['n'])){
  if(isset($_POST['play'])){
    $num = range(1,9);
    $k = array_rand($num, 4);
    $n = '';
    for($i=0;$i<4;$i++) $n.= $num[$k[$i]];
    $_SESSION['n'] = $n;
    $_SESSION['hist'] = array();
  } else {
    r('<h2>Welcome to CowsNBulls</h2><p>Do you wanna play?</p><form action="" method="post"><input name="play" type="submit" value="play"></form>');
  }
}  
$h = '';
if(isset($_POST['number'])){
  $g = $_POST['number'];
  if(preg_match('/^[1-9]{4}$/', $g) && count(array_unique(str_split($g))) == 4){
    if ($g == $_SESSION['n']){
      unset($_SESSION['n']);
      unset($_SESSION['hist']);
      r('<h2>Congratulations!</h2><p>You win</p><p>Play another one?</p><form action="" method="post"><input name="play" type="submit" value="play"></form>');
    } else {
      $r = getRes($g, $_SESSION['n']);
      $_SESSION['hist'][] = array('n' => $g, 'r' => $r); 
    }
  } else {
    $h = '<p style="color:red">Wrong input man</p>';
  }
}
if($_SESSION['hist']){
  $h .= '<table style="width:100%; text-align:right"><tr><th>#</th><th>guess</th><th>result</th></tr>';
  $r = 1;
  foreach($_SESSION['hist'] as $hr)
    $h .= '<tr><td>'.$r++.'</td><td>'.$hr['n'].'</td><td>'.$hr['r'].'</td></tr>';
  $h .= '<table>';
} 
r($h.'<p>Enter a four digit guess.</p><form method="post" action=""><input name="number" size="4"><input type="submit" value="submit"></form>');
?>