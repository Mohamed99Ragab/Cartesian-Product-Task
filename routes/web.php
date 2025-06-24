<?php

use App\Services\CartesianProduct;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/cartesian-product',function(){

      
    // Example usage of CartesianProduct service
    foreach (CartesianProduct::cartesianProduct([1,2],['a','b'],function($combo){
         return implode('-', $combo);

         
    }) as $combo) {
    // Process $combo
        echo "<pre>";
            print_r($combo);
        echo "</pre>";

         
    }


})->name('cartesian.product');

