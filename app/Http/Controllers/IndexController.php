<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return $this->view('layouts.index', 'index.welcome');
    }
}
