<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the seller dashboard.
     */
    public function index()
    {
        return view('seller.dashboard');
    }
}
