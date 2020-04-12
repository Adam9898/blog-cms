<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index() {
        echo "the apache webserver is saying hello to you!";
    }
}
