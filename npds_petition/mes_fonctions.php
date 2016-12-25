<?
 $petition=2;

function nbjours(){
 $d1="2005-04-04";
 $u1=strtotime($d1);
 $u2=strtotime("now");
 return "".round(($u2 -$u1)/ (60*60*24));
} 

?>
