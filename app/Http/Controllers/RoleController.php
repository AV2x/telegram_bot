<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Response::json(Role::where('id', '!=', 1)->get()->load('users'), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $array = [];
        foreach ($request->input('permissions') as $key => $permission)
        {
            foreach ($permission as $permissionKey => $value)
            {
                if(is_array($value))
                {
                    foreach ($value as $settingName => $sattingValue)
                    {
                        $array[$key.'_'.$permissionKey.'_'.$settingName] = $sattingValue;
                    }
                }
                else{
                    $array[$key.'_'.$permissionKey] = $value;
                }
            }
        }
        $role = Role::create(['name' => $request->input('name')]);
        $role->permissions()->create($array);
        return Response::json($role->load('permissions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return Response::json(Role::with('permissions')->where('id', $id)->where('id', '!=', 1)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $role = Role::where('id', '!=', 1)->where('id', $id)->first();
       $role->name = $request->input('name');
       $role->save();
       $role->permissions->update($request->input('permissions'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Role::where('id', '!=', 1)->where('id', $id)->delete();
    }

    public function attach(Request $request)
    {
        if(!isset($request->input('role')['users'][0]['id']))
        {
            User::where('role_id', $request->input('role')['id'])->where('id', '!=', 1)->update(['role_id' => null]);
            User::whereIn('id', $request->input('role')['users'])->where('id', '!=', 1)->update(['role_id' => $request->input('role')['id']]);
        }

    }

}
