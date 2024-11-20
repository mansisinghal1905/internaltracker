<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoiceRoute;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Mail;
use DB;
use Hash;
use Auth;

class RouteVoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new VoiceRoute;
        $this->middleware('permission:Route-Management', ['only' => ['index','store','create','edit','destroy','update']]);

       
    }

    public function index()
    {
       $voiceroute = null;
        $customerlist = User::where("status","1")->where('id', '!=', 31)->where('type','2')->get(['id',"first_name","last_name"]);
        $vendorlist = User::where("status","1")->where('id', '!=', 31)->where('type','1')->get(['id',"first_name","last_name"]);
      
        return view('admin.routes.voice_create',compact('voiceroute','customerlist','vendorlist'));
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
            return redirect()->route('admin.voiceroutes.create')
                             ->withInput($request->all())
                             ->withErrors($validate);
        } else {
            try {
               $voiceroute = new VoiceRoute;
               $voiceroute->customer_id = $request->customer_id;
               $voiceroute->customer_description = $request->customer_description;
               $voiceroute->vendor_id = $request->vendor_id;
               $voiceroute->vendor_description = $request->vendor_description;
               $voiceroute->save();
    
                $request->session()->flash('success', 'voice Route added successfully');
                return redirect()->route('admin.nocvoice.index');
            } catch (Exception $e) {
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.voiceroutes.index');
            }
        }
    }
    
  
   
}
