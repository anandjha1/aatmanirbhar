<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Inspiring;

Route::get('/', function () {
    $qoute = Inspiring::quote();

    return view('welcome', ["qoute"=>$qoute, "name"=>"Anand Jha"]);
});
