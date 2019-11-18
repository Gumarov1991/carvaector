<?php

function aj_get($sql,$cache_min=0,$debug=0) {
  $f = 'tmp/'.md5($sql); 
  if ( $cache_min!=0 && file_exists($f) && ( (time()-filemtime($f))/60 < $cache_min ) ) {
    $arr = unserialize(file_get_contents($f));
    if ($debug==1) {prn($sql,$arr);}
  }
  else {
    $arr = aj_get_clean($sql,$debug);
    if ($cache_min!=0) {
      $fp = fopen($f,'w');
      fwrite($fp,serialize($arr));
      fclose($fp);
    }
  }
  return $arr;
}

function aj_get_clean($sql,$debug=0) {
  $xml = get_xml($sql);
  $xml2 = iconv("cp1251", "UTF-8", $xml);
  $arr = xml2array($xml2);
  if ($debug==1) {prn($sql,$xml,$arr);}
  $aaa = "";
  if (isset($arr['aj'][0]['row']))$aaa = $arr['aj'][0]['row'];
  if ($aaa) return $arr['aj'][0]['row']; else return false;
}

function get_xml($sql) {
  $is_gzip=1;                       
  $f = 'http://autopatrul.ru/xml/xml?'.($is_gzip?'gzip&':'').'code=Lk2f_3Swqv&sql='.urlencode(preg_replace("/%25/","%",$sql));
  if ($is_gzip) {
    $xml = file_get_contents($f);
    return gzuncompress(preg_replace("/^\\x1f\\x8b\\x08\\x00\\x00\\x00\\x00\\x00/","",$xml));
  }
  else { return file_get_contents($f); }
}

function xml2array($text) {
  $reg_exp = '/<(\w+)[^>]*>(.*?)<\/\\1>/s';
  preg_match_all($reg_exp, $text, $match);
  foreach ($match[1] as $key=>$val) {
    if ( preg_match($reg_exp, $match[2][$key]) ) {
      $array[$val][] = xml2array($match[2][$key]);
    } else {
      $array[$val] = $match[2][$key];
    }
  } return $array;
}

function prn() {
  $vars = func_get_args(); echo '<br>';
  foreach($vars as $var) {
    echo "<table border=0 cellpadding=0 cellspacing=0 style='float:left'><tr><td style='padding:0px 0px 10px 20px'><textarea style='overflow:auto;border:solid 2px #999;font-family:San serif;font-size:12px;width:560px;height:450px'>";
    print_r($var);
    echo '</textarea></td></tr></table>';
  } die();
}

?>