<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the buyer dashboard.
     */
    public function index()
    {
        return view('buyer.dashboard');
    }
}
