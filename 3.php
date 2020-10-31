<?php
$dataKey = ['dumb','ways','the','best'];
$word = 'dumbways';

function check($dataKey,$word){
    $newArr = array();
    foreach($dataKey as $key){
        $data = str_split($key);
        foreach($data as $satu){
            if (strpos($word, $satu)) {
                    $newArr[$key] = "true";
                }
                else {
                    $newArr[$key] = "false";
                break;
                }
        }
    }
    return $newArr;
}

print_r(check($dataKey,$word));
?>