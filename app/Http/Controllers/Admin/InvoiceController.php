<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use App\Models\ClientUser;
use App\Models\TaskClient;
use App\Models\User;
use App\Models\Invoice;

use DB;
use Hash;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new Invoice;

        $this->columns = [
            "id",
            "title",
            "project_id",
            "project status",
            

        ];
    }

    public function index()
    {
        // $invoice = Invoice::all();
    
        return view('admin.invoices.index');
    }

    public function invoiceAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchInvoice($request, $this->columns);
        $total = $records->get();
        if (isset($request->start)) {
            $categories = $records->offset($request->start)->limit($request->length)->get();
        } else {
            $categories = $records->offset($request->start)->limit(count($total))->get();
        }
        $result = [];
        $i = 1;
        foreach ($categories as $value) {
            $data = [];
            $data['id'] = $i++;
            $data['invoice_id'] = $value->invoice_id;
            $data['client_id'] = $value->client_id;
            $data['project_id'] = $value->getProject->title;


            // Fetch and display multiple user names
            // $clientUsers = $value->clientUsers;
            // $userNames = $clientUsers->pluck('first_name')->map(function($name) {
            //     return ucfirst($name);
            // })->implode(', ');

            // $data['user_id'] = !empty($userNames) ? $userNames : '-';

            // $data['user_id'] = !empty($value->getClientuser->first_name) ?  ucfirst($value->getClientuser->first_name) : '-'  ;
            $data['project_status'] = ucfirst($value->project_status);
            // $data['position'] = ucfirst($value->position);
            // $data['timezone'] = $value->timezone;
            $status = "<div class='form-check form-switch form-switch-sm'><input class='form-check-input c-pointer clientuserStatusToggle' type='checkbox' id='formSwitchDropbox_{$value->id}' data-id='{$value->id}'" . ($value->status == 1 ? 'checked' : '') . "><label class='form-check-label fw-500 text-dark c-pointer' for='formSwitchDropbox_{$value->id}'>" . ($value->status == 1 ? 'Active' : 'Inactive') . "</label></div>";
        
            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            $action .= '<a href="' . route('admin.invoices.edit', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>';
            
            $action .= '<a href="' . route('admin.invoices.show', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Detail"><i class="fa fa-eye"></i></a>';

            $action .= '<a href="javascript:void(0)" onclick="deleteTasks(this)" data-url="' . route('admin.invoices') . '" class="toolTip deleteTasks" data-toggle="tooltip" data-id="' . $value->id . '" data-placement="bottom" title="Delete"><i class="fa fa-times"></i></a>';
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
        $clientlist = User::where("status","1")->where('id', '!=', 1)->get(['id',"name"]);
        $clientuserlist = ClientUser::where("status","1")->get(['id',"first_name","last_name"]);
        $categorylist = Category::where("status","1")->get(['id',"name"]);

        // dd($clientlist);
        $projectlist = Project::where("status","1")->get(['id',"title"]);

        return view('admin.invoices.create',compact('task','clientlist','projectlist','clientuserlist','categorylist'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
    public function store(Request $request) {
        $input = $request->all();
      
        $validate = Validator($request->all(), [
            'title' => 'required',
            'project_id' => 'required',
            'user_id' => 'required|array',
            'client_id' => 'required|array',
    
        ]);
        $attr = [
            'title' => 'Title',
            'project_id' => 'project Name',
            'user_id' => 'User Name',
            'client_id' => 'Client Name'
        ];
        $validate->setAttributeNames($attr);
        if ($validate->fails()) {
            return redirect()->route('admin.tasks.create')->withInput($request->all())->withErrors($validate);
        } else {
            try {
                $task = new Task;

                $task->project_id = $request->project_id;
                $task->title =  $request->title;
                $task->project_status = $request->project_status;
                $task->priority = $request->priority;
                $task->description = $request->description;
                // $task->user_id = $request->user_id;
                // $task->client_id = $request->client_id;
                $task->created_at = date('Y-m-d H:i:s');
                $task->updated_at = date('Y-m-d H:i:s');
                if ($task->save()) {

                    $user = $request->input('user_id', []); 
                    $client = $request->input('client_id', []); 

                    foreach ($user as $key => $user) {
                        
                            $userdata = new TaskUser;
                            $userdata->task_id = $task->id;
                            $userdata->user_id = $user;
                            $userdata->save();
                    }

                    foreach ($client as $key => $client) {
                        
                        $clientdata = new TaskClient;
                        $clientdata->task_id = $task->id;
                        $clientdata->client_id = $client;
                        $clientdata->save();
                    }
            
                    // Attach the selected users to the task
                    // $task->taskusers()->attach($request->user_id);
                    // $task->taskclients()->attach($request->client_id);


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
        $task=Task::with('getclienttask','getusertask')->find($id);
        return view('admin.tasks.view',compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id = null) {
        if (isset($id) && $id != null) {
            // $task = Task::where('id', $id)->first();
            $task = Task::with('getclienttask','getusertask')->find($id);
            // dd($task);
            
            if (isset($task->id)) {
            
                $type = 'edit';
               
                $clientlist = User::where("status","1")->where('id', '!=', 1)->get(['id',"name"]);
                
                // Fetch selected client IDs for the task (assuming many-to-many relationship)
                $selectedClientIds = $task->getclienttask->pluck('client_id')->toArray();
            
                $clientuserlist = ClientUser::where("status","1")->get(['id',"first_name","last_name"]);

                // Fetch selected clientuser IDs for the task (assuming many-to-many relationship)
                $selectedClientUserIds = $task->getusertask->pluck('user_id')->toArray();
            
                $projectlist = Project::where("status","1")->get(['id',"title"]);
            
                return view('admin.tasks.create', compact('task', 'type','clientlist','clientuserlist','projectlist','selectedClientIds','selectedClientUserIds'));
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
                    'project_id' => 'required',
                    'user_id' => 'required|array',
                    'client_id' => 'required|array',
                ]);
                $attr = [
                    'title' => 'Title',
                    'project_id' => 'project Name',
                    'user_id' => 'User Name',
                    'client_id' => 'Client Name'
                ];

                $validate->setAttributeNames($attr);

                if ($validate->fails()) {
                    return redirect()->route('edittasks', ['id' => $task->id])->withInput($request->all())->withErrors($validate);
                } else {
                    try {
                        $task->project_id = $request->project_id;
                        $task->title =  $request->title;
                        $task->project_status = $request->project_status;
                        $task->priority = $request->priority;
                        $task->description = $request->description;
                        $task->updated_at = date('Y-m-d H:i:s');
                        
                        // dd($task);
                        if ($task->save()) {

                            // $user = $request->input('user_id', []); 
                            // $client = $request->input('client_id', []); 
        
                            // foreach ($user as $key => $user) {
                                
                            //         $userdata = new TaskUser;
                            //         $userdata->task_id = $task->id;
                            //         $userdata->user_id = $user;
                            //         $userdata->save();
                            // }
        
                            // foreach ($client as $key => $client) {
                                
                            //     $clientdata = new TaskClient;
                            //     $clientdata->task_id = $task->id;
                            //     $clientdata->client_id = $client;
                            //     $clientdata->save();
                            // }

                             // Delete existing user and client relationships
                            TaskUser::where('task_id', $task->id)->delete();
                            TaskClient::where('task_id', $task->id)->delete();

                            // Re-insert the new user relationships
                            foreach ($request->input('user_id', []) as $userId) {
                                TaskUser::create([
                                    'task_id' => $task->id,
                                    'user_id' => $userId
                                ]);
                            }

                            // Re-insert the new client relationships
                            foreach ($request->input('client_id', []) as $clientId) {
                                TaskClient::create([
                                    'task_id' => $task->id,
                                    'client_id' => $clientId
                                ]);
                            }

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
        $record->status = 2; 
        $record->save();
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
}
