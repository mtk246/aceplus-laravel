<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class CompanyController extends Controller
{
    public function index()
    {
        $request = Request::create('/api/company', 'GET');

        $response = Route::dispatch($request);

        $responseBody = $response->getContent();

        return view('company', compact('responseBody'));
    }
    public function postCompany()
    {
        $com_name = request()->get('com_name');
        $email = request()->get('email');
        $date = date("Y-m-d H:i:s");

        $sql = DB::insert("INSERT INTO companies (name, email_address,created_at) VALUES (?,?,?)", [$com_name, $email, $date]);
        DB::disconnect('company');
        if ($sql == true) {
            return redirect('/company?status=created');
        }
    }
    public function putCompany()
    {
        $com_name = request()->get('com_name');
        $email = request()->get('email');
        $date = date("Y-m-d H:i:s");
        $id = request()->get('id');

        $sql = DB::update("UPDATE companies SET name=?, email_address=?,updated_at=? WHERE id=?", [$com_name, $email, $date, $id]);
        DB::disconnect('company');
        if ($sql == true) {
            return redirect('/company?status=updated');
        }
    }
    public function deleteCompany()
    {
        $id = request()->get('id');
        $sql = DB::delete("DELETE FROM companies WHERE id=?", [$id]);
        DB::disconnect('company');
        if ($sql == true) {
            return redirect('/company?status=deleted');
        }
    }
}
