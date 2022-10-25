<?php

namespace App\Tool;

class Treatment {

    //---Retour du nombe d'heure a parti d'un table de startHour et endHour
    public static function currencyFormat($m){
        return number_format($m, 0, '', ' ');
    }

}
