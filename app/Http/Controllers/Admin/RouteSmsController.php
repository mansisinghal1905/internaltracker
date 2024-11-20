<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsRoute;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Mail\TicketMail;
use App\Models\TicketDocument;
use Illuminate\Support\Facades\Log;
use Mail;
use DB;
use Hash;
use Auth;

class RouteSmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new SmsRoute;
        $this->middleware('permission:Route-Management', ['only' => ['index','store','create','edit','destroy','update']]);

       
    }

    public function index()
    {
        $smsroute = null;
        $customerlist = User::where("status","1")->where('id', '!=', 31)->where('type','2')->get(['id',"first_name","last_name"]);
        $vendorlist = User::where("status","1")->where('id', '!=', 31)->where('type','1')->get(['id',"first_name","last_name"]);
      
        return view('admin.routes.sms_create',compact('smsroute','customerlist','vendorlist'));
    }

  

   

    public function store(Request $request) {
        $input = $request->all();
        $validate = Validator($request->all(), [
            'customer_id' => 'required',
            'vendor_id' => 'required',
        ]);
    
        $attr = [
            'customer_id' => 'Customer',
            'vendor_id' => 'Vendor',
        ];
        $validate->setAttributeNames($attr);
    
        if ($validate->fails()) {
            return redirect()->route('admin.smsroutes.create')
                             ->withInput($request->all())
                             ->withErrors($validate);
        } else {
            try {
                $smsroute = new SmsRoute;
                $smsroute->customer_id = $request->customer_id;
                $smsroute->customer_description = $request->customer_description;
                $smsroute->vendor_id = $request->vendor_id;
                $smsroute->vendor_description = $request->vendor_description;
                $smsroute->save();
    
                $request->session()->flash('success', 'SMS Route added successfully');
                return redirect()->route('admin.nocsms.index');
            } catch (Exception $e) {
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.smsroutes.index');
            }
        }
    }
    
  
   
}
