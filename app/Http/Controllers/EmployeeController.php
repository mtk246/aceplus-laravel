<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user(); // here the user should exist from the session
            return $next($request);
        });
    }
    public function index()
    {
        $request = Request::create('/api/employee', 'GET');
        $request2 = Request::create('/api/company', 'GET');

        $response = Route::dispatch($request);
        $response2 = Route::dispatch($request2);

        $responseBody = $response->getContent();
        $responseBody2 = $response2->getContent();

        return view('employee', compact('responseBody', 'responseBody2'));
    }
    public function postEmployee()
    {
        $first_name = request()->get('first_name');
        $last_name = request()->get('last_name');
        $company = request()->get('company');
        $department = request()->get('department');
        $email = request()->get('email');
        $phone = request()->get('phone');
        $address = request()->get('address');
        $date = date("Y-m-d H:i:s");

        $sql = DB::insert("INSERT INTO employees (first_name,last_name,company,department, email,phone,address,created_at) VALUES (?,?,?,?,?,?,?,?)", [$first_name, $last_name, $company, $department, $email, $phone, $address, $date]);
        DB::disconnect('company');
        if ($sql == true) {
            return redirect('/employee?status=created');
        }
    }
    public function putEmployee()
    {
        $first_name = request()->get('first_name');
        $last_name = request()->get('last_name');
        $company = request()->get('company');
        $department = request()->get('department');
        $email = request()->get('email');
        $phone = request()->get('phone');
        $address = request()->get('address');
        $date = date("Y-m-d H:i:s");
        $id = request()->get('id');

        $sql = DB::update("UPDATE employees SET first_name=?, last_name=?,company=?,department=?,email=?,phone=?,address=?,updated_at=? WHERE staff_id=?", [$first_name, $last_name, $company, $department, $email, $phone, $address, $date, $id]);
        DB::disconnect('company');
        if ($sql == true) {
            return redirect('/employee?status=updated');
        }
    }
    public function deleteEmployee()
    {
        $id = request()->get('id');
        $sql = DB::delete("DELETE FROM employees WHERE staff_id=?", [$id]);
        DB::disconnect('company');
        if ($sql == true) {
            return redirect('/employee?status=deleted');
        }
    }
}
