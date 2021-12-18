<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyApiController extends Controller
{
    public function getCompany()
    {
        $sql = DB::select("SELECT * FROM companies");

        DB::disconnect('company');

        return response()->json($sql);
    }
    public function postCompany(Request $request)
    {
        $com_name = $request->name;
        $email = $request->email_address;
        $address = $request->address;
        $date = date("Y-m-d H:i:s");
        $sql = DB::insert('INSERT INTO companies(name,email_address,address,created_at) VALUES(?,?,?,?)', [$com_name, $email, $address, $date]);
        if ($sql == true) {
            return response()->json(['create' => 'success']);
        }
    }
    public function putCompany(Request $request)
    {
        $com_name = $request->name;
        $email = $request->email_address;
        $address = $request->address;
        $date = date("Y-m-d H:i:s");
        $id = $request->id;

        $sql = DB::update('UPDATE companies SET name=?,email_address=?,address=?,updated_at=? WHERE id=?', [$com_name, $email, $address, $date, $id]);
        if ($sql == true) {
            return response()->json(['update' => 'success']);
        }
    }
    public function deleteCompany(Request $request)
    {
        $id = $request->id;

        $sql = DB::update('DELETE FROM companies WHERE id=?', [$id]);
        if ($sql == true) {
            return response()->json(['delete' => 'success']);
        }
    }
}
