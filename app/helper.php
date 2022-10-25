<?php

function currencyFormat($m){
    return number_format($m, 0, '', ' ');
}

function dateDbFormat($date){
    $dateTab = explode("/", $date);
    if(count($dateTab)==3 && is_numeric($dateTab[0]) && is_numeric($dateTab[1]) && is_numeric($dateTab[2])){
        $date = $dateTab[2].'-'.$dateTab[1].'-'.$dateTab[0];
        $date = date('Y-m-d', strtotime($date));

        return $date;
    }
    else{
        $date = date('Y-m-d');
        return $date;
    }
}

function s($numb){
    if(is_numeric($numb) && $numb>1){
        return "s";
    }
    return "";
}
