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

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new Task;
        $this->middleware('permission:Task-Management', ['only' => ['index','store','create','edit','destroy','update']]);
        $this->columns = [
            "id",
            "company_name",
            "am_name",
            "status",
            "task_status"

        ];
    }

    public function index()
    {
        $task = Task::all();
    
        return view('admin.tasks.index',compact('task'));
    }

    public function taskAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
         // Fetch project statuses
        // $projectStatuses = ProjectStatus::all();
        $records = $this->Model->fetchTask($request, $this->columns);
        $total = $records->get();
        if (isset($request->start)) {
            $categories = $records->offset($request->start)->limit($request->length)->get();
        } else {
            $categories = $records->offset($request->start)->limit(count($total))->get();
        }
        $result = [];
        $i = $request->start;
        // dd($value->getUser);
        foreach ($categories as $value) {
            $data = [];
            $data['id'] = ++$i;
            $data['company_name'] = $value->company_name;
            // $data['user_id'] = $value->getUser->first_name;
            $data['am_name'] = $value->am_name ?? 'N/A';
            // $data['vendor_id'] = $value->getVendor ? $value->getVendor->first_name . ' ' . $value->getVendor->last_name : 'N/A';


            $data['task_status'] = '<select class="form-control status-select" name="task_status" data-id="' . $value->id . '">';
            $data['task_status'] .= '<option value="open"' . ($value->task_status == 'open' ? ' selected' : '') . '>Open</option>';
            $data['task_status'] .= '<option value="process"' . ($value->task_status == 'process' ? ' selected' : '') . '>Process</option>';
            $data['task_status'] .= '<option value="close"' . ($value->task_status == 'close' ? ' selected' : '') . '>Close</option>';
            $data['task_status'] .= '</select>';

            $status = "<div class='form-check form-switch form-switch-sm'><input class='form-check-input c-pointer taskStatusToggle' type='checkbox' id='formSwitchDropbox_{$value->id}' data-id='{$value->id}'" . ($value->status == 1 ? 'checked' : '') . "><label class='form-check-label fw-500 text-dark c-pointer' for='formSwitchDropbox_{$value->id}'>" . ($value->status == 1 ? 'Active' : 'Inactive') . "</label></div>";
        
            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            $action .= '<a href="' . route('admin.tasks.edit', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>';
            
            $action .= '<a href="' . route('admin.tasks.show', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Detail"><i class="fa fa-eye"></i></a>';

            $action .= '<a href="javascript:void(0)" onclick="deleteTasks(this)" data-url="' . route('admin.taskdestory') . '" class="toolTip deleteTasks" data-toggle="tooltip" data-id="' . $value->id . '" data-placement="bottom" title="Delete"><i class="fa fa-times"></i></a>';
            $action.="</div>";

            $data['view'] = $action;
            $data['status'] = $status;
            $result[] = $data;

        }
        $data = json_encode([
            'data' => $result,
            'recordsTotal' => count($total),
            'recordsFiltered' => count($total),
        ]);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = null;
        // $clientlist = User::where("status","1")->where('id', '!=', 31)->where('type','2')->get(['id',"first_name","last_name"]);
        // $vendorlist = User::where("status","1")->where('id', '!=', 31)->where('type','1')->get(['id',"first_name","last_name"]);
        $countrylist = Country::where("status","active")->get(['id',"name"]);

        return view('admin.tasks.create',compact('task','countrylist'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
    public function store(Request $request) {
        // dd($request->all());
        $input = $request->all();
      
        $validate = Validator($request->all(), [
            'company_name' => 'required',
            'register_country_id' => 'required',
            'am_name' => 'required',
            'am_email' => 'required',
            'whatsapp_no' => 'required',
            'register_year' => 'required',

          
        ]);
        $attr = [
            'company_name' => 'Company Name',
            'register_country_id' => 'Register Country',
            'am_name' => 'Am Name',
            'am_email' => 'Am Email',
            'whatsapp_no' => 'AM Skype/Whatsapp',
            'register_year' => 'Registered Year',
        ];
        $validate->setAttributeNames($attr);
        if ($validate->fails()) {
            return redirect()->route('admin.tasks.create')->withInput($request->all())->withErrors($validate);
        } else {
            try {
                $task = new Task;
                $task->company_name = $request->company_name;
                $task->register_country_id = $request->register_country_id;
                $task->am_name = $request->am_name;
                $task->am_email = $request->am_email;
                $task->whatsapp_no = $request->whatsapp_no;
                $task->register_year = $request->register_year;
                $task->created_at = date('Y-m-d H:i:s');
                $task->updated_at = date('Y-m-d H:i:s');
                if ($task->save()) {

                    // $fields = $request->input('description',[]);
                    $fields = (array) $request->input('description', []);


                    foreach ($fields as $field) {
                            $taskdescription = new TaskDescription;
                            $taskdescription->task_id = $task->id;
                            $taskdescription->description = $field;
                            $taskdescription->save();
                    }

                    $tradeverification = new TradeVerification;
                    $tradeverification->task_id = $task->id;
                    $tradeverification->response_of_tr = $request->response_of_tr;
                    $tradeverification->propose_credit_limit = $request->propose_credit_limit;
                    $tradeverification->billing_cycle = $request->billing_cycle;
                    $tradeverification->created_at = date('Y-m-d H:i:s');
                    $tradeverification->updated_at = date('Y-m-d H:i:s');
                    $tradeverification->save();

                    $agreementreview = new AgreementReview;
                    $agreementreview->task_id = $task->id;
                    $agreementreview->review_description = $request->review_description;
                    $agreementreview->financial_statement = $request->financial_statement;
                    $agreementreview->billing_cycle_review = $request->billing_cycle_review;
                    $agreementreview->created_at = date('Y-m-d H:i:s');
                    $agreementreview->updated_at = date('Y-m-d H:i:s');
                    $agreementreview->save();

                    $agreementsign = new AgreementSign;
                    $agreementsign->task_id = $task->id;
                    $agreementsign->agreement = $request->agreement;
                    $agreementsign->unilateral = $request->unilateral;
                    $agreementsign->sign_description = $request->sign_description;
                    $agreementsign->created_at = date('Y-m-d H:i:s');
                    $agreementsign->updated_at = date('Y-m-d H:i:s');
                    $agreementsign->save();

                    $request->session()->flash('success', 'Task added successfully');
                    return redirect()->route('admin.tasks.index');
                    
                } else {
                    $request->session()->flash('error', 'Something went wrong. Please try again later.');
                    return redirect()->route('admin.tasks.index');
                }
            } catch (Exception $e) {
            
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.tasks.index');
            }

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // dd($id);
        try{
            $task=Task::find($id);
            // dd($task);
                $taskDescriptions = TaskDescription::where('task_id', $id)->get();

                $tradeverification = TradeVerification::where('task_id', $id)->first();
                $agreementreview = AgreementReview::where('task_id', $id)->first();
                $agreementsign = AgreementSign::where('task_id', $id)->first();
            
            return view('admin.tasks.view',compact('task','tradeverification','agreementreview','agreementsign','taskDescriptions'));
        }catch (Exception $e) {
            dd($e);
            $request->session()->flash('error', 'Something went wrong. Please try again later.');
            return redirect()->route('admin.tasks.index');
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id = null) {
        if (isset($id) && $id != null) {
            // $task = Task::where('id', $id)->first();
            $task = Task::find($id);
            // dd($task);
            $taskDescriptions = TaskDescription::where('task_id', $id)->get();
            
            
            if (isset($task->id)) {
            
                $type = 'edit';
                $tradeverification = TradeVerification::where('task_id', $id)->first();
                $agreementreview = AgreementReview::where('task_id', $id)->first();
                $agreementsign = AgreementSign::where('task_id', $id)->first();
                $countrylist = Country::where("status","active")->get(['id',"name"]);
            
                return view('admin.tasks.create', compact('tradeverification','agreementreview','agreementsign','task', 'type','countrylist','taskDescriptions'));
            } else {
                $request->session()->flash('error', 'Invalid Data');
                return redirect()->route('admin.tasks.index');
            }
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->route('admin.tasks.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (isset($id) && $id != null) {

            $task = Task::where('id', $id)->first();

            if (isset($task->id)) {
                $validate = Validator($request->all(), [
                    'company_name' => 'required',
                    'register_country_id' => 'required',
                    'am_name' => 'required',
                    'am_email' => 'required',
                    'whatsapp_no' => 'required',
                    'register_year' => 'required',
        
                  
                ]);
                $attr = [
                    'company_name' => 'Company Name',
                    'register_country_id' => 'Register Country',
                    'am_name' => 'Am Name',
                    'am_email' => 'Am Email',
                    'whatsapp_no' => 'AM Skype/Whatsapp',
                    'register_year' => 'Registered Year',
                ];

                $validate->setAttributeNames($attr);

                if ($validate->fails()) {
                    return redirect()->route('admin.tasks.edit', ['id' => $id])->withInput($request->all())->withErrors($validate);
                } else {
                    try {
                        $task->company_name = $request->company_name;
                        $task->register_country_id = $request->register_country_id;
                        $task->am_name = $request->am_name;
                        $task->am_email = $request->am_email;
                        $task->whatsapp_no = $request->whatsapp_no;
                        $task->register_year = $request->register_year;
                        $task->updated_at = date('Y-m-d H:i:s');
                        
                        // dd($task);
                        if ($task->save()) {

                            TaskDescription::where('task_id', $task->id)->delete();

                            // Now, insert the new descriptions
                            // $fields = $request->input('description');
                            $fields = (array) $request->input('description', []);
            
                            foreach ($fields as $field) {
                                $taskdescription = new TaskDescription;
                                $taskdescription->task_id = $task->id;
                                $taskdescription->description = $field; // Save each description
                                $taskdescription->save();
                            }

                            $tradeverification = TradeVerification::firstOrNew(['task_id' => $id]);
                            $tradeverification->task_id = $task->id;
                            $tradeverification->response_of_tr = $request->response_of_tr;
                            $tradeverification->propose_credit_limit = $request->propose_credit_limit;
                            $tradeverification->billing_cycle = $request->billing_cycle;
                            $tradeverification->updated_at = date('Y-m-d H:i:s');
                            $tradeverification->save();

                            $agreementreview = AgreementReview::firstOrNew(['task_id' => $id]);
                            $agreementreview->task_id = $task->id;
                            $agreementreview->review_description = $request->review_description;
                            $agreementreview->financial_statement = $request->financial_statement;
                            $agreementreview->billing_cycle_review = $request->billing_cycle_review;
                            $agreementreview->updated_at = date('Y-m-d H:i:s');
                            $agreementreview->save();

                            $agreementsign = AgreementSign::firstOrNew(['task_id' => $id]);
                            $agreementsign->task_id = $task->id;
                            $agreementsign->agreement = $request->agreement;
                            $agreementsign->unilateral = $request->unilateral;
                            $agreementsign->sign_description = $request->sign_description;
                            $agreementsign->updated_at = date('Y-m-d H:i:s');
                            $agreementsign->save();

                            $request->session()->flash('success', 'Task updated successfully');
                            return redirect()->route('admin.tasks.index');
                        } else {
                            $request->session()->flash('error', 'Something went wrong. Please try again later.');
                            return redirect()->route('admin.tasks.edit', ['id' => $id]);
                        }
                    } catch (Exception $e) {
                        $request->session()->flash('error', 'Something went wrong. Please try again later.');
                        return redirect()->route('admin.tasks.edit', ['id' => $id]);
                    }
                }
            } else {
                $request->session()->flash('error', 'Invalid Data');
                return redirect()->route('admin.tasks.edit', ['id' => $id]);
            }
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->route('admin.tasks.edit', ['id' => $id]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function taskdestory(Request $request)
    {
        $id = $request->id;
        $record = Task::findOrFail($id);
        $record->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully.');;
    }

    public function ChangeTaskStatus(Request $request)
    {
        $response = $this->Model->where('id', $request->id)->update(['status' => $request->status]);
        if ($response) {
            return json_encode([
                'status' => true,
                "message" => "Status Changes Successfully"
            ]);
        } else {
            return json_encode([
                'status' => false,
                "message" => "Status Changes Fails"
            ]);
        }
    }

    public function updateProjectStatus(Request $request)
    {
        $response = $this->Model->where('id', $request->id)->update(['task_status' => $request->task_status]);
        
        // dd($response);
        if ($response) {
            return json_encode([
                'status' => true,
                "message" => "Task Status Changes Successfully"
            ]);
        } else {
            return json_encode([
                'status' => false,
                "message" => "Task Status Changes Fails"
            ]);
        }
      
    }
}
