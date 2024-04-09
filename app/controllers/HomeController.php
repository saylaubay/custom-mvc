<?php

namespace App\Controllers;

class HomeController
{

    public function index($name,$t,$a)
    {

        echo $name . " - ".$t." - ".$a;
    }
}