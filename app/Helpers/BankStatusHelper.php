<?php

namespace App\Helpers;

use App\Models\AssetLookup;

class BankStatusHelper {

    public static function countFrom($data) {
    $currentPage=null;
    $perPage=null;
 
                $currentPage=$data->currentPage();
                $perPage=$data->perPage();
                if($currentPage !=1){
                    $currentPage=$currentPage-1;
                    $startcount=$currentPage*$perPage;
                }else{
                    $startcount=0;
                }

                return $startcount; 
    }

}


?>