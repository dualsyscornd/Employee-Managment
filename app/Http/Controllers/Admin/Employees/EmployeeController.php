<?php

namespace App\Http\Controllers\Admin\Employees;

use App\Http\Controllers\Controller;
use DataTables;
use DB;
use Illuminate\Http\Request;

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
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<p><button type="button" class="btn btn-primary btn-icon" ><i data-feather="file"></i></button> </p>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    // Employees List Functions --------------------------------
    public function EmployeeStore(Request $req)
    {
        $validated = validator($req->all(), [
            'employee_name' => 'bail|required',
            'employee_email' => 'email|required',
            'employee_position' => 'required',
            'employee_password' => 'required|digits:4',
            'employee_profile' => 'mimes:jpeg,png,gif|max:3000',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => $validated->errors('message')]);
        }

        // emolyee profile save in folder
        if ($req->hasFile('employee_profile')) {
            $imageName = 'employee_image_' . rand(1000, 9000) . '.' . $req->file('employee_profile')->extension();
            $req->file('employee_profile')->move('public/images/employee_profile/', $imageName);
        }

        // insert record in database

        $data = DB::table('employees')->insert([
            'employee_name' => $req->input('employee_name'),
            'employee_email' => $req->input('employee_email'),
            'employee_position' => $req->input('employee_position'),
            'employee_password' => $req->input('employee_password'),
            'employee_profile' => $imageName,
        ]);

        return response()->json(['success' => true, 'message' => 'Employee is created successfully']);

    }
}