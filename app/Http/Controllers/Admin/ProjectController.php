<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\Project;
use App\Models\User;
use DB;
use Hash;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new Project;

        $this->columns = [
            "id",
            "title",
            "client",
            "start_date",
            "end_date",
            "status",

        ];
    }

    public function index()
    {
        $project = Project::all();
    
        return view('admin.projects.index',compact('project'));
    }

    public function projectAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchProject($request, $this->columns);
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
            $data['title'] = $value->title;
            $data['client'] = $value->getCLient->name;
            $data['start_date'] = date('Y-m-d', strtotime($value->start_date));
            $data['end_date'] = date('Y-m-d', strtotime($value->end_date));

            $status = "<div class='form-check form-switch form-switch-sm'><input class='form-check-input c-pointer projectStatusToggle' type='checkbox' id='formSwitchDropbox_{$value->id}' data-id='{$value->id}'" . ($value->status == 1 ? 'checked' : '') . "><label class='form-check-label fw-500 text-dark c-pointer' for='formSwitchDropbox_{$value->id}'>" . ($value->status == 1 ? 'Active' : 'Inactive') . "</label></div>";
        
            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            $action .= '<a href="' . route('admin.projects.edit', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>';
            
            $action .= '<a href="' . route('admin.projects.show', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Detail"><i class="fa fa-eye"></i></a>';

            $action .= '<a href="javascript:void(0)" onclick="deleteProjects(this)" data-url="' . route('admin.projectdestory') . '" class="toolTip deleteProjects" data-toggle="tooltip" data-id="' . $value->id . '" data-placement="bottom" title="Delete"><i class="fa fa-times"></i></a>';
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
        $project = null;
        $clientlist = User::where("status","1")->where('id', '!=', 1)->get(['id',"name"]);
        // dd($clientlist);
        return view('admin.projects.create',compact('project','clientlist'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
    public function store(Request $request) {
        $input = $request->all();
      
        $validate = Validator($request->all(), [
            'title' => 'required',
            'client' => 'required',
    
        ]);
        $attr = [
            'title' => 'Title',
            'client' => 'Client',
            
        ];
        $validate->setAttributeNames($attr);
        if ($validate->fails()) {
            return redirect()->route('admin.projects.create')->withInput($request->all())->withErrors($validate);
        } else {
            try {
                $project = new Project;

                $project->title = $request->title;
                $project->client =  $request->client;
                $project->start_date = $request->start_date;
                $project->end_date = $request->end_date;
                $project->created_at = date('Y-m-d H:i:s');
                $project->updated_at = date('Y-m-d H:i:s');
                if ($project->save()) {
                    $request->session()->flash('success', 'Project added successfully');
                    return redirect()->route('admin.projects.index');
                } else {
                    $request->session()->flash('error', 'Something went wrong. Please try again later.');
                    return redirect()->route('admin.projects.index');
                }
            } catch (Exception $e) {
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.projects.index');
            }

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project=Project::find($id);
        return view('admin.projects.view',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id = null) {
        if (isset($id) && $id != null) {
            // $project = Project::where('id', $id)->first();
            $project = Project::find($id);
            // dd($project);
            
            if (isset($project->id)) {
            
                $type = 'edit';
               
                 $clientlist = User::where("status","1")->where('id', '!=', 1)->get(['id',"name"]);
                    // dd($clientlist);
                return view('admin.projects.create', compact('project', 'type','clientlist'));
            } else {
                $request->session()->flash('error', 'Invalid Data');
                return redirect()->route('admin.projects.index');
            }
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->route('admin.projects.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (isset($id) && $id != null) {

            $project = Project::where('id', $id)->first();

            if (isset($project->id)) {
                $validate = Validator($request->all(),  [
                    'title' => 'required',
                    'client' => 'required',
                ]);
                $attr = [
                    'title' => 'Title',
                    'client' => 'Client Name',
                ];

                $validate->setAttributeNames($attr);

                if ($validate->fails()) {
                    return redirect()->route('editProjects', ['id' => $project->id])->withInput($request->all())->withErrors($validate);
                } else {
                    try {
                        $project->title = $request->title;
                        $project->client =  $request->client;
                        $project->start_date = $request->start_date;
                        $project->end_date = $request->end_date;
                        $project->updated_at = date('Y-m-d H:i:s');
                        
                        // dd($project);
                        if ($project->save()) {
                            // DB::table('model_has_roles')->where('model_id',$id)->delete();
                            //$project->assignRole($request->post('roles'));
                            $request->session()->flash('success', 'Project updated successfully');
                            return redirect()->route('admin.projects.index');
                        } else {
                            $request->session()->flash('error', 'Something went wrong. Please try again later.');
                            return redirect()->route('admin.projects.edit', ['id' => $id]);
                        }
                    } catch (Exception $e) {
                        $request->session()->flash('error', 'Something went wrong. Please try again later.');
                        return redirect()->route('admin.projects.edit', ['id' => $id]);
                    }
                }
            } else {
                $request->session()->flash('error', 'Invalid Data');
                return redirect()->route('admin.projects.edit', ['id' => $id]);
            }
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->route('admin.projects.edit', ['id' => $id]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function projectdestory(Request $request)
    {
        $id = $request->id;
        $record = Project::findOrFail($id);
        $record->status = 2; 
        $record->save();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted Successfully.');;
    }

    public function changeProjectStatus(Request $request)
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
