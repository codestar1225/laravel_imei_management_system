<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceCenterController extends Controller
{
    public function service_center() 
    {
        $service_centers = DB::table('service_center_locations')->get();
        $admins = DB::table('users')->where('role', 1)->get();

        return view('service_center', compact('service_centers', 'admins'));
    }

    public function add_location(Request $request)
    {
        $input = $request->all();

        $check = DB::table('service_center_locations')->where('admin_id', $input['admin_id'])->where('location', $input['location'])->get();

        if(count($check) == 0) DB::table('service_center_locations')->insert(['location' => $input['location'], 'admin_id' => $input['admin_id']]);

        return redirect()->route('service_center');
    }

    public function edit_location(Request $request)
    {
        $input = $request->all();

        $check = DB::table('service_center_locations')->where('admin_id', $input['editadmin_id'])->where('location', $input['editlocation'])->get();

        if(count($check) == 0) DB::table('service_center_locations')->where('id', $input['editid'])->update(['location' => $input['editlocation'], 'admin_id' => $input['editadmin_id']]);

        return redirect()->route('service_center');
    }

    public function delete_location(Request $request)
    {
        $input = $request->all();

        DB::table('service_center_locations')->where('id', $input['deleteLocationId'])->delete();

        return redirect()->route('service_center');
    }
}
