<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return $this->view('pages.welcome', [
            'page' => $this->pageInfo('Laravel 11 Boilerplate (Enhanced Edition) by Refkinscallv'),
        ]);
    }
}
