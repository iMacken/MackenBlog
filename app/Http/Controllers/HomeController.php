<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{

    /**
     * Display the dashboard page.
     * 
     * @return mixed
     */
    public function index()
    {
        return view('admin.index');
    }
}
