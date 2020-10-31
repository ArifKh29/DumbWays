<?php

$kata = 'se2dang pel4atihan meng3ikuti Sa1ya dumbw5ays onli6ne pad7a har8i i9ni';

function urutKata($kata){
	$kataUrut = array();
	$kataArr = explode(" ",$kata);
    $j=1;
    for($i=0;$i<count($kataArr);$i++){
    	foreach($kataArr as $data){
        	if(strpbrk($data, $j)){
            $kataUrut[] = $data;
                $j++;
                break;
            }
        }
   }
    return implode(" ",$kataUrut);
  }
  
  echo urutKata($kata);
?>