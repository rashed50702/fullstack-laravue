<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        return Role::orderBy('roleName', 'asc')->get();
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'roleName' => 'required|unique:roles',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()->all(), 'status' => 422]);
        }
        $data = Role::create([
            'roleName' => $request->roleName
        ]);

        return $data;
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'roleName' => 'required|unique:roles,roleName,' . $request->id,

        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()->all(), 'status' => 422]);
        }
        $data = Role::where('id', $request->id)->update([
            'roleName' => $request->roleName
        ]);

        return $data;
    }
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',

        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()->all(), 'status' => 422]);
        }
        $data = Role::where('id', $request->id)->delete();
        return $data;
    }
}
