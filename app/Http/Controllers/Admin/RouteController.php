<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Route;
use App\Models\Task;

use DB;
use Hash;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new Route;
        $this->Model1 = new User;
        $this->middleware('permission:Route-Management', ['only' => ['index','store','create','edit','destroy','update']]);

        $this->columns = [
            "id",
            "first_name",
            "last_name",
            "email",
            "phone_number",
            "avatar",
            "dob",
            "status",
        ];
    }

    public function index()
    {
        // $route = Route::all();
    
        return view('admin.routes.index');
    }

    public function customerAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
         // Fetch project statuses
        // $projectStatuses = ProjectStatus::all();
        $records = $this->Model->fetchRoute($request, $this->columns);
        $total = $records->get();
        // dd($total);
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
            $data['fullname'] = ucfirst($value->first_name . ' ' . $value->last_name);
            $data['email'] = $value->email;
            $data['phone_number'] = $value->phone_number;
            // $data['role'] = $value->role;
            // $data['role'] = $value->role == 2 ? 'Customer' : ($value->role == 3 ? 'Vendor' : 'Unknown');

            $data['avatar'] = ($value->avatar != null) ? '<img src="'. $value->avatar.'" height="40%"width="40%" />' : '-';

            // $status = "<div class='form-check form-switch form-switch-sm'><input class='form-check-input c-pointer userStatusToggle' type='checkbox' id='formSwitchDropbox_{$value->id}' data-id='{$value->id}'" . ($value->status == 1 ? 'checked' : '') . "><label class='form-check-label fw-500 text-dark c-pointer' for='formSwitchDropbox_{$value->id}'>" . ($value->status == 1 ? 'Active' : 'Inactive') . "</label></div>";

            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            // $action .= '<a href="' . route('admin.users.edit', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>';
            
            $action .= '<a href="' . route('admin.customershow', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Detail"><i class="fa fa-eye"></i></a>';

            // $action .= '<a href="javascript:void(0)" onclick="deleteUsers(this)" data-url="' . route('admin.userdestory') . '" class="toolTip deleteUsers" data-toggle="tooltip" data-id="' . $value->id . '" data-placement="bottom" title="Delete"><i class="fa fa-times"></i></a>';
            
            $action.="</div>";

            $data['view'] = $action;
            // $data['status'] = $status;
            $result[] = $data;

        }
        $data = json_encode([
            'data' => $result,
            'recordsTotal' => count($total),
            'recordsFiltered' => count($total),
        ]);
        return $data;
    }

    public function customershow(string $id)
    {
        $customer=User::find($id);
        $usercustomer = User::with('tasks')->find($id);
        // dd($usercustomer);
        return view('admin.routes.customerview',compact('customer','usercustomer'));
    }


    public function vendorindex()
    {
        // $route = Route::all();
    
        return view('admin.routes.vendorindex');
    }

    public function vendorAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
         // Fetch project statuses
        // $projectStatuses = ProjectStatus::all();
        $records = $this->Model->fetchvendor($request, $this->columns);
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
            $data['fullname'] = ucfirst($value->first_name . ' ' . $value->last_name);
            $data['email'] = $value->email;
            $data['phone_number'] = $value->phone_number;
            // $data['role'] = $value->role;
            // $data['role'] = $value->role == 2 ? 'Customer' : ($value->role == 3 ? 'Vendor' : 'Unknown');

            $data['avatar'] = ($value->avatar != null) ? '<img src="'. $value->avatar.'" height="40%"width="40%" />' : '-';

            // $status = "<div class='form-check form-switch form-switch-sm'><input class='form-check-input c-pointer userStatusToggle' type='checkbox' id='formSwitchDropbox_{$value->id}' data-id='{$value->id}'" . ($value->status == 1 ? 'checked' : '') . "><label class='form-check-label fw-500 text-dark c-pointer' for='formSwitchDropbox_{$value->id}'>" . ($value->status == 1 ? 'Active' : 'Inactive') . "</label></div>";

            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            // $action .= '<a href="' . route('admin.users.edit', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>';
            
            $action .= '<a href="' . route('admin.vendorshow', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Detail"><i class="fa fa-eye"></i></a>';

            // $action .= '<a href="javascript:void(0)" onclick="deleteUsers(this)" data-url="' . route('admin.userdestory') . '" class="toolTip deleteUsers" data-toggle="tooltip" data-id="' . $value->id . '" data-placement="bottom" title="Delete"><i class="fa fa-times"></i></a>';
            
            $action.="</div>";

            $data['view'] = $action;
            // $data['status'] = $status;
            $result[] = $data;

        }
        $data = json_encode([
            'data' => $result,
            'recordsTotal' => count($total),
            'recordsFiltered' => count($total),
        ]);
        return $data;
    }
    // public function vendorshow(string $id)
    // {
    //     $vendor=User::find($id);
    //     // $uservendor = Task::where('vendor_id','5')->where('status','!=',2)->get();
    //     // $uservendor = User::with('tasksAsVendor', 'customers')->find($id);
    //     // dd($uservendor);
    //     $customerIds = Task::where('vendor_id', $id)
    //     ->where('status', '!=', 2)
    //     ->pluck('user_id');

    //     // If you want to get the customer details, you can retrieve the User models
    //     $customers = User::whereIn('id', $customerIds)
    //         ->where('role', '2')
    //         ->get();
    //         dd($customers);
    //     return view('admin.routes.vendorview',compact('vendor','customers'));
    // }

    public function vendorshow(string $id)
    {
        // Find the vendor
        $vendor = User::find($id);

        // Get customers and their related tasks based on the vendor's tasks
        $customers = User::whereIn('id', function ($query) use ($id) {
                $query->select('user_id')
                    ->from('tasks')
                    ->where('vendor_id', $id)
                    ->where('status', '!=', 2);
            })
            ->with(['tasks' => function ($query) use ($id) {
                $query->where('vendor_id', $id)
                    ->where('status', '!=', 2);
            }])
            ->where('type', '2') // Assuming '2' is the type for customers
            ->where('role', '3') // Assuming '3' is the role for customers
            ->get();

        return view('admin.routes.vendorview', compact('vendor', 'customers'));
    }

    

   

}
