<?php
class arrfile
{
static function code($str)
{
return str_replace(array('\\','\''),array('\\\\','\\\''),$str);
}
static function add($file,$name,$arr,$notass=true)
{
$str='';
if(!is_file($file)){file_put_contents($file,"<?php\n?>");$i='1';}
else $i='';
$p=fopen($file,'r+');
if(!$p) return false;
fseek($p,-2,SEEK_END);
$str='$'.$name."[$i]=".self::var2str($arr,$notass).";\n?>";
$ok=fwrite($p,$str);
fclose($p);
return $ok;
}
static function var2str($var,$notass=false)
{
if(is_int($var) || is_float($var))
 return "$var";
if(is_string($var))
 return "'".self::code($var)."'";
if(is_null($var))
 return 'NULL';
if(is_bool($var))
 return $var ? 'TRUE' : 'FALSE';
if(!is_array($var))
 return "unserialize('".self::code(serialize($var))."')";
else
 {
$str=array();

foreach($var as $n=>$v)
  {
$str[]=($notass ? '' : self::var2str($n).'=>').self::var2str($v);
  }
return 'array('.implode(',',$str).')';
 }
}
//class end
}
?>