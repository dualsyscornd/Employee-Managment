<?php

namespace App\Http\Controllers\Admin\Employees;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables,DB;

class EmployeeController extends Controller
{
    // Employees View Functions --------------------------------
    public function Employees()
    {
        return view('Admin.Employees.Employee');
    }
    // Employees List Functions --------------------------------
    public function EmployeeList()
    {
        $data = DB::table('employees')->get();
        return DataTables::of($data)->make(true);
    }
    // Employees List Functions --------------------------------
    public function EmployeeStore(Request $req)
    {
        return $req->input('employee_position');
    }
}
