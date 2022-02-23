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
                return '
                <button type="button" class="btn btn-warning btn-icon"
                onclick=\'EmployeeEdit(
                ' . $data->employee_id . ',
                "' . $data->employee_name . '",
                "' . $data->employee_email . '",
                "' . $data->employee_position . '",
                "' . $data->employee_password . '"
                )\'><i data-feather="file"></i></button>
                <button type="button" class="btn btn-danger btn-icon mx-2" onclick="EmployeeRemove(' . $data->employee_id . ')"><i data-feather="trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    // Employees Store Functions --------------------------------
    public function EmployeeStore(Request $req)
    {
        // Create New Function(if the req has no employee_id)--------------------------------
        if ($req->input('employee_id') == null && $req->input('employee_id') == "") {
            // Validation--------------------------------
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

            // Employee Profile Save--------------------------------
            if ($req->hasFile('employee_profile')) {
                $imageName = 'employee_image_' . rand(1000, 9000) . '.' . $req->file('employee_profile')->extension();
                $req->file('employee_profile')->move('public/images/employee_profile/', $imageName);
            }

            // Insert into DB--------------------------------
            $data = DB::table('employees')->insert([
                'employee_name' => $req->input('employee_name'),
                'employee_email' => $req->input('employee_email'),
                'employee_position' => $req->input('employee_position'),
                'employee_password' => $req->input('employee_password'),
                'employee_profile' => $imageName,
            ]);
            return response()->json(['success' => true, 'message' => 'Employee is created successfully']);
        }
        // Update Function(if the req has employee_id)--------------------------------
        else {
            // Validation--------------------------------
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

            // Delete Old Profile And add new one--------------------------------
            if ($req->hasFile('employee_profile')) {
                $dbname  = DB::table('employees')->where('employee_id', $req->input('employee_id'))->first();
                $imageName = 'employee_image_' . rand(1000, 9000) . '.' . $req->file('employee_profile')->extension();
                $req->file('employee_profile')->move('public/images/employee_profile/', $imageName);
                if ($dbname->employee_profile != "" && $dbname->employee_profile != null) {
                    if (file_exists("public/images/employee_profile/" . $dbname->employee_profile)) {
                        unlink("public/images/employee_profile/" . $dbname->employee_profile);
                    }
                } else {
                    $imageName = $dbname->employee_profile;
                }
            }
            $dbupdate =  DB::table('employees')
            ->where('employee_id', $req->input('employee_id'))
            ->update([
                'employee_name' => $req->input('employee_name'),
                'employee_email' => $req->input('employee_email'),
                'employee_position' => $req->input('employee_position'),
                'employee_password' => $req->input('employee_password'),
                'employee_profile' => $imageName,
            ]);
            return response()->json(['success' => true, 'message' => 'Employee is created successfully']);
        }

    }

    // Employee Remove --------------------------------------
    public function EmployeeRemove(Request $req)
    {
        $data  = DB::table('employees')->where('employee_id', $req->input('employee_id'))->first();
        $removefromdb = DB::table('employees')->where('employee_id', $req->input('employee_id'))->delete();
        // --- === Delete Image === --- //
        if (file_exists("public/images/employee_profile/" . $data->employee_profile)) {
            unlink("public/images/employee_profile/" . $data->employee_profile);
        }
        // --- === Delete Image === --- //
        if ($removefromdb == 1) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
