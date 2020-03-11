<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class UserController extends Controller
{
    public function getusers()
    {
        if(Auth::user()->role == 0) $users = DB::table('users')->where('role', 1)->get();
        else $users = DB::table('users')->where('admin_id', Auth::user()->id)->get();

        return view('usermanage')->with('users', $users);
    }

    public function adduser(Request $request) 
    {
        $input = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'role'     => 'required',
        ]);

        $check = DB::table('users')->where('username', $input['username'])->get();

        if(count($check) == 0){
            DB::table('users')->insert(
                ['username' => $input['username'], 'password' => Hash::make($input['password']), 'role' => $input['role'], 'admin_id' => Auth::user()->id]
            );
        }

        return redirect()->route('usermanage');
    }

    public function edituser(Request $request)
    {
        $input = $request->all();
        $data = [
            'username' => $input['editusername'],
            'password' => Hash::make($input['editpassword']),
            'role'     => $input['editrole']
        ];

        $check = DB::table('users')->where('username', $input['username'])->get();

        if(count($check) == 0) DB::table('users')->where('id', $input['editid'])->update($data);

        return redirect()->route('usermanage');
    }

    public function deleteuser(Request $request)
    {
        $input = $request->all();

        DB::table('users')->where('id', $input['deleteUserId'])->delete();

        if(Auth::user()->role == 0) DB::table('service_center_locations')->where('admin_id', $input['deleteUserId'])->delete();

        return redirect()->route('usermanage');
    }
}
