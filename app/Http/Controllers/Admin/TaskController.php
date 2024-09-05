<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\ClientUser;
use App\Models\TaskClient;
use App\Models\User;
use App\Models\TaskUser;
use App\Models\ProjectStatus;
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
            "title",
            "user_id",
            "status",
            

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
        $i = 1;
        // dd($value->getUser);
        foreach ($categories as $value) {
            $data = [];
            $data['id'] = $i++;
            $data['title'] = $value->title;
            // $data['user_id'] = $value->getUser->first_name;
            $data['user_id'] = $value->getUser ? $value->getUser->first_name . ' ' . $value->getUser->last_name : 'N/A';
            $data['vendor_id'] = $value->getVendor ? $value->getVendor->first_name . ' ' . $value->getVendor->last_name : 'N/A';


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
        $clientlist = User::where("status","1")->where('id', '!=', 31)->where('type','2')->get(['id',"first_name","last_name"]);
        $vendorlist = User::where("status","1")->where('id', '!=', 31)->where('type','1')->get(['id',"first_name","last_name"]);

        return view('admin.tasks.create',compact('task','clientlist','vendorlist'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
    public function store(Request $request) {
        $input = $request->all();
      
        $validate = Validator($request->all(), [
            'title' => 'required',
            'user_id' => 'required',
            'vendor_id' => 'required',

    
        ]);
        $attr = [
            'title' => 'Title',
            'user_id' => 'Customer Name',
            'vendor_id' => 'Vendor Name',

        ];
        $validate->setAttributeNames($attr);
        if ($validate->fails()) {
            return redirect()->route('admin.tasks.create')->withInput($request->all())->withErrors($validate);
        } else {
            try {
                $task = new Task;

                $task->user_id = $request->user_id;
                $task->vendor_id = $request->vendor_id;
                $task->title =  $request->title;
                $task->description = $request->description;
                $task->destination = $request->destination;
                $task->credit_limit = $request->credit_limit;
                $task->billing_cycle = $request->billing_cycle;
                $task->agreement_review = $request->agreement_review;
                $task->agreement_sign = $request->agreement_sign;
                $task->technical_interconnection = $request->technical_interconnection;
                $task->created_at = date('Y-m-d H:i:s');
                $task->updated_at = date('Y-m-d H:i:s');
                if ($task->save()) {
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
    public function show(string $id)
    {
        $task=Task::find($id);
        $clientlist = User::where("status","1")->where('id', '!=', 31)->get(['id',"first_name","last_name"]);

        return view('admin.tasks.view',compact('task','clientlist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id = null) {
        if (isset($id) && $id != null) {
            // $task = Task::where('id', $id)->first();
            $task = Task::find($id);
            // dd($task);
            
            if (isset($task->id)) {
            
                $type = 'edit';
               
                $clientlist = User::where("status","1")->where('id', '!=', 31)->where('type','2')->get(['id',"first_name","last_name"]);
                $vendorlist = User::where("status","1")->where('id', '!=', 31)->where('type','1')->get(['id',"first_name","last_name"]);
            
                return view('admin.tasks.create', compact('task', 'type','clientlist','vendorlist'));
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
                $validate = Validator($request->all(),  [
                    'title' => 'required',
                    'user_id' => 'required',
                    'vendor_id' => 'required',

                ]);
                $attr = [
                    'title' => 'Title',
                    'user_id' => 'Customer Name',
                    'vendor_id' => 'Vendor Name'

                ];

                $validate->setAttributeNames($attr);

                if ($validate->fails()) {
                    return redirect()->route('admin.tasks.edit', ['id' => $id])->withInput($request->all())->withErrors($validate);
                } else {
                    try {
                        $task->user_id = $request->user_id;
                        $task->vendor_id = $request->vendor_id;
                        $task->title =  $request->title;
                        $task->description = $request->description;
                        $task->destination = $request->destination;
                        $task->credit_limit = $request->credit_limit;
                        $task->billing_cycle = $request->billing_cycle;
                        $task->agreement_review = $request->agreement_review;
                        $task->agreement_sign = $request->agreement_sign;
                        $task->technical_interconnection = $request->technical_interconnection;
                        $task->updated_at = date('Y-m-d H:i:s');
                        
                        // dd($task);
                        if ($task->save()) {

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
