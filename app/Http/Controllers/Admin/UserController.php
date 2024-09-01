<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Category;
use App\Models\BankInformation;
use App\Models\User;
use DB;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new User;

        $this->columns = [
            "id",
            "first_name",
            "last_name",
            "email",
            "phone_number",
            "avatar",
            "status",

        ];
    }

    public static function generateReferralCode($user_id) {
		
		$letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$code = substr($letters, mt_rand(0, 24), 2) . mt_rand(1000, 9999) . substr($letters, mt_rand(0, 23), 3) . mt_rand(10, 99).$user_id;

		return $code;
	}
    public function index()
    {
        $user = User::all();
        // dd($user);
        return view('admin.users.index',compact('user'));
    }

    public function userAjax(Request $request)
    {
        // dd($request->search);
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchUser($request, $this->columns);
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

            $data['fullname'] = ucfirst($value->first_name . ' ' . $value->last_name);
            $data['email'] = $value->email;
            $data['phone_number'] = $value->phone_number;
            // $data['role'] = $value->role;
            $data['role'] = $value->role == 2 ? 'Customer' : ($value->role == 3 ? 'Vendor' : 'Unknown');

            $data['avatar'] = ($value->avatar != null) ? '<img src="'. $value->avatar.'" height="40%"width="40%" />' : '-';

        
            $status = "<div class='form-check form-switch form-switch-sm'><input class='form-check-input c-pointer userStatusToggle' type='checkbox' id='formSwitchDropbox_{$value->id}' data-id='{$value->id}'" . ($value->status == 1 ? 'checked' : '') . "><label class='form-check-label fw-500 text-dark c-pointer' for='formSwitchDropbox_{$value->id}'>" . ($value->status == 1 ? 'Active' : 'Inactive') . "</label></div>";
        
            // $view = "<a href='" . route('admin.users.show', $value->id) . "' data-status='1' class='badge badge-secondary userStatus'>View</a>";

            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            $action .= '<a href="' . route('admin.users.edit', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>';
            
            $action .= '<a href="' . route('admin.users.show', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Detail"><i class="fa fa-eye"></i></a>';

            $action .= '<a href="javascript:void(0)" onclick="deleteUsers(this)" data-url="' . route('admin.userdestory') . '" class="toolTip deleteUsers" data-toggle="tooltip" data-id="' . $value->id . '" data-placement="bottom" title="Delete"><i class="fa fa-times"></i></a>';
 
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
        $user = null;

        return view('admin.users.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
   

    public function store(Request $request) {
        $input = $request->all();
        
        $validate = Validator($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'role' => 'required',

        ]);
    
        $attr = [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone_number' => 'Phone no',
            'role' => 'Role',
        ];
        $validate->setAttributeNames($attr);
    
        if ($validate->fails()) {
            return redirect()->route('admin.users.create')->withInput($request->all())->withErrors($validate);
        } else {
            try {
                $checkedPhone = User::where("phone_number", $request->phone_number)
                                    ->where("status", "!=", "delete")
                                    ->first();
                if ($checkedPhone) {
                    $request->session()->flash('error', 'Phone number already exists');
                    return redirect()->back();
                }
    
                $user = new User;
                $filename = "";
                if ($request->hasfile('avatar')) {
                    $file = $request->file('avatar');
                    $filename = time() . $file->getClientOriginalName();
                    $filename = str_replace(' ', '', $filename);
                    $filename = str_replace('.jpeg', '.jpg', $filename);
                    $file->move(public_path('profileimage'), $filename);
                }
                if ($filename != "") {
                    $user->avatar = $filename;
                }

                $password = $this->generateReferralCode(1);
    
                $user->first_name = ucfirst($request->first_name);
                $user->last_name = ucfirst($request->last_name);
                // $user->company_name = $request->company_name;
                $user->email = $request->email;
                $user->phone_number = $request->phone_number;
                $user->password = Hash::make($password);
                // $user->dob = $request->dob;
                $user->role = $request->role;
                // $user->state_id = $request->state_id;
                // $user->city_id = $request->city_id;
                // $user->zip_code = $request->zip_code;
                // $user->website = $request->website;
                // $user->address = $request->address;
                // $user->role = 2;
                $user->save();
                $request->session()->flash('success', 'User added successfully');
                return redirect()->route('admin.users.index');
            } catch (Exception $e) {
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.users.index');
            }
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user=User::find($id);
        // $usercustomer = User::with('tasks')->find($id);
        // dd($usercustomer);
        return view('admin.users.view',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id = null) {
        if (isset($id) && $id != null) {
            // $user = User::where('id', $id)->first();
            $user = User::find($id);
            // $CountryCode =Country::select('shortname')->first();
            
            if (isset($user->id)) {
                // $user->country_flag = $CountryCode->shortname ??'IL';
            
                $type = 'edit';
                // $url = route('admin.users.update', ['id' => $user->id]);
                // $roles = Role::pluck('name','name')->all();
                // $userRole = $user->roles->pluck('name','name')->all();
                // Fetch related bank information
                // $bankInformation = BankInformation::where('user_id', $id)->first();
               
                //  $countrylist = Country::where("status","active")->get(['id',"name"]);
                //  $statelist = State::where("status","active")->where("country_id",$user->country_id)->get(['id',"name"]);
                //  $cityList = City::where("state_id",$user->state_id)->get(['id',"name"]);
                //  $categorylist = Category::where("status","1")->get(['id',"name"]);

                return view('admin.users.create', compact('user', 'type'));
            } else {
                $request->session()->flash('error', 'Invalid Data');
                return redirect()->route('admin.users.index');
            }
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (isset($id) && $id != null) {

            $user = User::where('id', $id)->first();
            $checkedMail = User::where("id","!=",$id)->where("email",$request->email)->first();
            if($checkedMail)
            {
                 $request->session()->flash('error', 'Email address already exists');
                 return redirect()->back();
            }
             $checkedPhone = User::where("status","!=","delete")->where("phone_number",$request->phone_number)->where("id","!=",$id)->first();
                if($checkedPhone)
                {
                    $request->session()->flash('error', 'Phone number already exists');
                    return redirect()->back();
                }

            if (isset($user->id)) {
                $validate = Validator($request->all(),  [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email',
                    'phone_number' => 'required|min:8|numeric',
                    'role' => 'required',
                ]);
                $attr = [
                    'first_name' => 'First Name',
                    'last_name' => 'Last Name',
                    'user_email' => 'Email',
                    'phone_number' => 'Mobile',
                    'role' => 'Role',
                ];

                $validate->setAttributeNames($attr);

                if ($validate->fails()) {
                    return redirect()->route('editUsers', ['id' => $user->id])->withInput($request->all())->withErrors($validate);
                } else {
                    try {
                        $filename = "";
                        if ($request->hasfile('avatar')) {
                            $file = $request->file('avatar');
                            $filename = time() . $file->getClientOriginalName();
                            $filename = str_replace(' ', '', $filename);
                            $filename = str_replace('.jpeg', '.jpg', $filename);
                            $file->move(public_path('profileimage'), $filename);
                            if ($user->avatar != null && file_exists(public_path('profileimage/' . $user->avatar))) {
                                if ($user->avatar != 'noimage.jpg') {
                                    unlink(public_path('profileimage/' . $user->avatar));
                                }
                            }
                        }
                        if ($filename != "") {
                            $user->avatar = $filename;
                        }

                        $user->first_name = ucfirst($request->first_name);
                        $user->last_name = ucfirst($request->last_name);
                        // $user->company_name =  $request->company_name;
                        $user->email = $request->email;
                        $user->phone_number = $request->phone_number;
                        // $user->dob = $request->dob;
                        $user->role = $request->role;

                        // $user->category = $request->category;
                        // $user->country_id = $request->country_id;
                        // $user->state_id = $request->state_id;
                        // $user->city_id = $request->city_id;
                        // $user->zip_code = $request->zip_code;
                        // $user->website = $request->website;
                        // $user->address = $request->address;
                        $user->updated_at = date('Y-m-d H:i:s');
                        
                        // dd($user);
                        if ($user->save()) {
                            $request->session()->flash('success', 'User updated successfully');
                            return redirect()->route('admin.users.index');
                        } else {
                            $request->session()->flash('error', 'Something went wrong. Please try again later.');
                            return redirect()->route('admin.users.edit', ['id' => $id]);
                        }
                    } catch (Exception $e) {
                        $request->session()->flash('error', 'Something went wrong. Please try again later.');
                        return redirect()->route('admin.users.edit', ['id' => $id]);
                    }
                }
            } else {
                $request->session()->flash('error', 'Invalid Data');
                return redirect()->route('admin.users.edit', ['id' => $id]);
            }
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->route('admin.users.edit', ['id' => $id]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function userdestory(Request $request)
    {
        $id = $request->id;
        $record = User::findOrFail($id);
        $record->delete();

        // BankInformation::where('user_id', $user->id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted Successfully.');;
   
    }

    public function changeUserStatus(Request $request)
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


    public function getStatelistByCountryId(Request $request){
    	if($request->selectedValues){
    	try{
    		$data = State::whereIn("country_id",$request->selectedValues)->where("status","active")->get(['id',"name"]);
	     	
            if ($data->count() > 0) {
	     		
	     		$response['status'] = true;
	     		$response['data'] = $data;
	     	} else {
	     		$response['status'] =  true;
	     		$response['data'] = null;
			}
			}catch (\Exception $ex) {
				$response['status'] =  false;
	     		$response['data'] = null;
			}
		}
		else{
				$response['status'] =  false;
     		$response['data'] = null;
	
		}
		return response()->json($response);
    }

    public function getCitylistByStateId(Request $request){
    	if($request->selectedValues){
 		
 		try{
    		$data = City::whereIn("state_id",$request->selectedValues)->where("status","active")->get(['id',"name"]);
	     	if ($data->count() > 0) {
	     		
	     		$response['status'] = true;
	     		$response['data'] = $data;
	     	} else {
	     		$response['status'] =  true;
	     		$response['data'] = null;
			}
			}catch (\Exception $ex) {
				$response['status'] =  false;
	     		$response['data'] = null;
			}
			return response()->json($response);	
    	}
    }
}
