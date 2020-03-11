<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function claimdetail(Request $request)
    {
        $imei = $request['imei'];
        $search_result = DB::table('detail_imeis')->where('imei', $imei)->get();
        $search_imei = DB::table('imeis')->where('imei', $imei)->get();

        if(Auth::user()->role == 1) $service_center_locations = DB::table('service_center_locations')->where('admin_id', Auth::user()->id)->get();
        elseif(Auth::user()->role > 1) $service_center_locations = DB::table('service_center_locations')->where('admin_id', Auth::user()->admin_id)->get();
        elseif(Auth::user()->role == 0) $service_center_locations = DB::table('service_center_locations')->get();
        return view('claimdetail', compact('search_result', 'search_imei', 'service_center_locations'));
    }

    public function search_result(Request $request)
    {
        $input = $request->all();

        $imei = $input['searchinput'];
        
        $check = DB::table('imeis')->where('imei', $imei)->get();

        if(count($check)>0)
        {
            $search_result = DB::table('detail_imeis')->where('imei', $imei)->get();
            $service_center_locations = DB::table('service_center_locations')->get();
            
            if(count($search_result)>0)
            {
                if(Auth::user()->role == 0)
                {
                    $claimed = $search_result[0]->claimed;
                    return view('search_result', compact('search_result','imei','claimed','service_center_locations'));
                }
                
                if(Auth::user()->role > 0)
                {
                    if(Auth::user()->role == 1) $check1 = DB::table('detail_imeis')->where('imei', $imei)->where('admin_id', Auth::user()->id)->get();
                    elseif(Auth::user()->role > 1)  $check1 = DB::table('detail_imeis')->where('imei', $imei)->where('admin_id', Auth::user()->admin_id)->get();
                    if(count($check1) > 0)
                    {
                        $claimed = $search_result[0]->claimed;
                        return view('search_result', compact('search_result','imei','claimed','service_center_locations'));
                    }
                    else
                    {
                        $message = "File caimed";
                        return view('home')->with('message', $message);
                    }
                }
                
            }
            else{
                $claimed = 0;
                return view('search_result', compact('search_result','imei','claimed','service_center_locations'));
            }
        }
        else
        {
            $message = "IMEI doesn't exist";
            return view('home')->with('message', $message);
        }
    }

    public function submit_detail(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $purchase_invoice_name = '';
        $pre_repair_photo_name = '';
        $post_repair_photo_name = '';
        $service_repair_report_name = '';

        if($purchage_invoice   =  $request->file('purchase_invoice')) {

            $file= $request->file('purchase_invoice');
            $name=$file->getClientOriginalName();
            $file->move(public_path().'/files/purchase_invoice/', $name);  
            $purchase_invoice_name = '/files/purchase_invoice/'. $name;
        }
        elseif($input['purchase_invoice1'] != '0') $purchase_invoice_name = $input['purchase_invoice1']??'';
        if($pre_repair_photo   =   $request->file('pre_repair_photo')) {

            $file= $request->file('pre_repair_photo');
            $name=$file->getClientOriginalName();
            $file->move(public_path().'/files/pre_repair_photo/', $name);  
            $pre_repair_photo_name = '/files/pre_repair_photo/'. $name;
        }
        elseif($input['pre_repair_photo1'] != '0') $pre_repair_photo_name = $input['pre_repair_photo1']??'';

        if($post_repair_photo   =   $request->file('post_repair_photo')) {

            $file= $request->file('post_repair_photo');
            $name=$file->getClientOriginalName();
            $file->move(public_path().'/files/post_repair_photo/', $name);  
            $post_repair_photo_name = '/files/post_repair_photo/'. $name;
        }
        elseif($input['post_repair_photo1'] != '0') $post_repair_photo_name = $input['post_repair_photo1']??'';

        if($service_repair_report   =   $request->file('service_repair_report')) {

            $file= $request->file('service_repair_report');
            $name=$file->getClientOriginalName();
            $file->move(public_path().'/files/service_repair_report/', $name);  
            $service_repair_report_name = '/files/service_repair_report/'. $name;
        }
        elseif($input['service_repair_report1'] != '0') $service_repair_report_name = $input['service_repair_report1']??'';

        if($input['incident_date'] != ''&& $input['incident_time'] != ''&& $input['incident_location'] != ''&& $input['incident_detail'] != ''&& $input['customer_name'] != ''&& $input['contact_number'] != ''&& $input['email_address'] != '') 
        {
            $claimed = 1;
        }
        else $claimed = 0;
        
        if(isset($input['admin_id'])) $admin_id = $input['admin_id'];
        else {
            if(Auth::user()->role == 0) $admin_id = 0;
            elseif(Auth::user()->role == 1) $admin_id = Auth::user()->id;
            else $admin_id = Auth::user()->admin_id;
        }

        $data = [
            'imei' => $input['imei']??'',
            'brand' => $input['brand']??'',
            'model' => $input['model']??'',
            'purchase_date' => $input['purchase_date']??'',
            'start_coverage' => $input['start_coverage']??'',
            'purchase_invoice' => $purchase_invoice_name,
            'incident_date' => $input['incident_date']??'',
            'incident_time' => $input['incident_time']??'',
            'incident_location' => $input['incident_location']??'',
            'incident_detail' => $input['incident_detail']??'',
            'customer_name' => $input['customer_name']??'',
            'contact_number' => $input['contact_number']??'',
            'email_address' => $input['email_address']??'',
            'repair_type' => $input['repair_type']??'',
            'repair_date' => $input['repair_date']??'',
            'repair_amount' => $input['repair_amount']??'',
            'charges' => $input['charges']??'',
            'service_centre_location' => $input['service_centre_location']??'',
            'pre_repair_photo' => $pre_repair_photo_name,
            'post_repair_photo' => $post_repair_photo_name,
            'service_repair_report' => $service_repair_report_name,
            'admin_id' => $admin_id,
            'claimed' => $claimed
        ];

        // dd($data);

        $check = DB::table('detail_imeis')->where('imei', $data['imei'])->get();
        if(count($check) == 0)
        {
            DB::table('detail_imeis')->insert($data);
        }
        else {
            // dd($data);
            DB::table('detail_imeis')->where('imei', $data['imei'])->update($data);
        }

        return redirect()->route('success');
    }

    public function success() {
        $success = 'SUBMITTED SUCCESSFULLY';

        return view('success')->with('success', $success);
    }

    public function imei_data() {
        if(Auth::user()->role == 0) $data = DB::table('detail_imeis')->rightJoin('imeis', 'imeis.imei', '=', 'detail_imeis.imei')->get();
        if(Auth::user()->role == 1) $data = DB::table('detail_imeis')->rightJoin('imeis', 'imeis.imei', '=', 'detail_imeis.imei')->where('admin_id', Auth::user()->id)->orWhere('admin_id', null)->get();
        if(Auth::user()->role == 3) $data = DB::table('detail_imeis')->where('claimed', 1)->where('admin_id', Auth::user()->admin_id)->get();
        // dd($data);
        $states = DB::table('states')->get();
        $service_center_locations = DB::table('service_center_locations')->get();
        return view('imei_data', compact('data', 'states', 'service_center_locations'));
    }

    public function delete_imei(Request $request) {
        $input = $request->all();
        DB::table('detail_imeis')->where('imei', $input['deleteImeiId'])->delete();
        DB::table('imeis')->where('imei', $input['deleteImeiId'])->delete();

        return redirect()->route('imei_data');
    }

    public function edit_imei($imei) {
        $search_result = DB::table('detail_imeis')->where('imei', $imei)->get();
        $search_imei = DB::table('imeis')->where('imei', $imei)->get();
        if(Auth::user()->role == 1) $service_center_locations = DB::table('service_center_locations')->where('admin_id', Auth::user()->id)->get();
        elseif(Auth::user()->role == 0) 
        {
            if($search_result[0]->admin_id == 0) $service_center_locations = DB::table('service_center_locations')->get();
            else $service_center_locations = DB::table('service_center_locations')->where('admin_id', $search_result[0]->admin_id)->get();
        }
        return view('claimdetail', compact('search_result', 'search_imei', 'service_center_locations'));
    }

    public function search_imei(Request $request) {
        $input = $request->all();

        if(Auth::user()->role == 0) $data = DB::table('detail_imeis')->rightJoin('imeis', 'imeis.imei', '=', 'detail_imeis.imei');
        if(Auth::user()->role == 1) $data = DB::table('detail_imeis')->rightJoin('imeis', 'imeis.imei', '=', 'detail_imeis.imei')->where(function ($query) {
            $query->where('admin_id', '=',  Auth::user()->id)
                  ->orWhereNull('admin_id');
        });
        if(Auth::user()->role == 3) $data = DB::table('detail_imeis')->where('claimed', 1)->where('admin_id', Auth::user()->admin_id);
        // $data = DB::table('detail_imeis');
        if(isset($input['claimed']))
        {
            if($input['claimed'] == '0') $data = $data->where('claimed', 0);
            else $data = $data->where('claimed', 1);
        }
        if(isset($input['service_center_location'])) $data = $data->where('service_centre_location', $input['service_center_location']);

        if(isset($input['fromdate']) || isset($input['todate']))
        {
            if(isset($input['fromdate'])) $from = $input['fromdate'];
            else $from = '1900-01-01';
            if(isset($input['todate'])) $to = $input['todate'];
            else $to = '2050-12-31';
            $data = $data->whereBetween('purchase_date', [$from, $to]);
        }

        $data = $data->get();
        
        $service_center_locations = DB::table('service_center_locations')->get();
        return view('imei_data', compact('data', 'service_center_locations'));

    }
}
