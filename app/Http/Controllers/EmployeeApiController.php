<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeApiController extends Controller
{
    public function getEmployee()
    {
        $sql = DB::select("SELECT * FROM employees");
        DB::disconnect('company');
        return response()->json($sql);
    }
    public function postEmployee(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $company = $request->company;
        $department = $request->department;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;
        $date = date("Y-m-d H:i:s");

        $sql = DB::insert('INSERT INTO employees(first_name,last_name,company,department,email,phone,address,created_at) VALUES(?,?,?,?,?,?,?,?)', [$first_name, $last_name, $company, $department, $email, $phone, $address, $date]);
        if ($sql == true) {
            return response()->json(['create' => 'success']);
        }
    }
    public function putEmployee(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $company = $request->company;
        $department = $request->department;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;
        $date = date("Y-m-d H:i:s");
        $id = $request->staff_id;

        $sql = DB::update('UPDATE employees SET first_name=?,last_name=?,company=?,department=?,email=?,phone=?,address=?,updated_at=? WHERE staff_id=?', [$first_name, $last_name, $company, $department, $email, $phone, $address, $date, $id]);
        if ($sql == true) {
            return response()->json(['update' => 'success']);
        }
    }
    public function deleteEmployee(Request $request)
    {
        $id = $request->staff_id;

        $sql = DB::update('DELETE FROM employees WHERE staff_id=?', [$id]);
        if ($sql == true) {
            return response()->json(['delete' => 'success']);
        }
    }
}
