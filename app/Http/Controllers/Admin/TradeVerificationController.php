<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskDescription;
use App\Models\TradeVerification;
use App\Models\AgreementReview;
use App\Models\AgreementSign;
use App\Models\User;
use App\Models\TaskUser;
use App\Models\ProjectStatus;
use App\Models\Country;
use DB;
use Hash;

class TradeVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new Task;
        $this->middleware('permission:Task-Management', ['only' => ['index','store','create','edit','destroy','update']]);
    }

    public function index()
    {
        // $task = Task::all();
    
        return view('admin.tradeverification.create');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = null;
        $customerlist = User::where("status","1")->where('id', '!=', 31)->where('type','2')->get(['id',"first_name","last_name"]);

        return view('admin.tradeverification.create',compact('task','customerlist'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
    public function store(Request $request) {
        // dd($request->all());
        $input = $request->all();
      
        // $validate = Validator($request->all(), [
        //     'company_name' => 'required',
        //     'register_country_id' => 'required',
        //     'am_name' => 'required',
        //     'am_email' => 'required',
        //     'whatsapp_no' => 'required',
        //     'register_year' => 'required',
        // ]);
        // $attr = [
        //     'company_name' => 'Company Name',
        //     'register_country_id' => 'Register Country',
        //     'am_name' => 'Am Name',
        //     'am_email' => 'Am Email',
        //     'whatsapp_no' => 'AM Skype/Whatsapp',
        //     'register_year' => 'Registered Year',
        // ];
        // $validate->setAttributeNames($attr);
        // if ($validate->fails()) {
        //     return redirect()->route('admin.tradeverifications.create')->withInput($request->all())->withErrors($validate);
        // } else {
            try {
                $tradeverification = new TradeVerification;
                $tradeverification->task_id = $task->id;
                $tradeverification->response_of_tr = $request->response_of_tr;
                $tradeverification->propose_credit_limit = $request->propose_credit_limit;
                $tradeverification->billing_cycle = $request->billing_cycle;
                $tradeverification->created_at = date('Y-m-d H:i:s');
                $tradeverification->updated_at = date('Y-m-d H:i:s');
               
                if ($tradeverification->save()){

                    // $agreementreview = new AgreementReview;
                    // $agreementreview->task_id = $task->id;
                    // $agreementreview->review_description = $request->review_description;
                    // $agreementreview->financial_statement = $request->financial_statement;
                    // $agreementreview->billing_cycle_review = $request->billing_cycle_review;
                    // $agreementreview->created_at = date('Y-m-d H:i:s');
                    // $agreementreview->updated_at = date('Y-m-d H:i:s');
                    // $agreementreview->save();

                    // $agreementsign = new AgreementSign;
                    // $agreementsign->task_id = $task->id;
                    // $agreementsign->agreement = $request->agreement;
                    // $agreementsign->unilateral = $request->unilateral;
                    // $agreementsign->sign_description = $request->sign_description;
                    // $agreementsign->created_at = date('Y-m-d H:i:s');
                    // $agreementsign->updated_at = date('Y-m-d H:i:s');
                    // $agreementsign->save();

                    $request->session()->flash('success', 'Trade Verification added successfully');
                    return redirect()->route('admin.tasks.index');
                    
                } else {
                    $request->session()->flash('error', 'Something went wrong. Please try again later.');
                    return redirect()->route('admin.tasks.index');
                }
            } catch (Exception $e) {
            
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.tasks.index');
            }

        // }
    }

  
}
