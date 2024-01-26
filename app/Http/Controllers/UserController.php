<?php

namespace App\Http\Controllers;

use App\Facades\Telegram;
use App\Models\User;
use App\Services\Storage\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    protected $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::with('role');
        if($request->input('user_name') && $request->input('user_name') != 'null')
        {
            $users = $users->where('name', 'like', '%'.$request->input('user_name').'%');
        }
        if($request->input('role_id') && $request->input('role_id') != 'null')
        {
            $users =  $users->where('role_id', $request->input('role_id'));
        }
        if($request->input('sortByAsc') && $request->input('sortByAsc') != 'null')
        {
            $users = $users->orderBy($request->input('sortByAsc'), 'asc');
        }
        if($request->input('sortByDesc')  && $request->input('sortByDesc') != 'null')
        {
            $users = $users->orderBy($request->input('sortByDesc'), 'desc');
        }
        return Response::json($users->get(), 200);
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
     $user = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'avatar' => $request->input('avatar')
        ]);
     $this->storage->save($user, $request->file('avatar'));
     return Response::json($user, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        return Response::json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if($request->input('password') && $request->input('password') != 'null'){
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        $this->storage->save($user, $request->file('avatar'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::destroy($id);
    }

    public function executors()
    {
        $users = User::whereHas('permissions', function ($query){
            $query->where('orders_executor', 1);
        })->get();
        return Response::json($users, 200);
    }
}
