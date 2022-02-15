<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // Dashboard View Functions --------------------------------

    public function Dashboard()
    {
        return view('Admin.Dashboard.Dashboard');
    }
}
