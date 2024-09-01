<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Models\Payment;
use App\Models\User;
use App\Models\ProjectStatus;
use DB;
use Hash;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new Payment;

        $this->columns = [
            "id",
            "client_id",
            "total_amount",
        ];
    }

    public function index()
    {
        $payment = Payment::all();
    
        return view('admin.accounts.index',compact('payment'));
    }

    public function paymentAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
         // Fetch project statuses
        // $projectStatuses = ProjectStatus::all();
        $records = $this->Model->fetchPayment($request, $this->columns);
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
            $data['customer_id'] = ucfirst(($value->getCustomer->first_name ?? '') . ' ' . ($value->getCustomer->last_name ?? ''));

            $data['total_amount'] = $value->total_amount;

            // $data['user_id'] = $value->getUser->first_name;
            
            // $status = "<div class='form-check form-switch form-switch-sm'><input class='form-check-input c-pointer paymentStatusToggle' type='checkbox' id='formSwitchDropbox_{$value->id}' data-id='{$value->id}'" . ($value->status == 1 ? 'checked' : '') . "><label class='form-check-label fw-500 text-dark c-pointer' for='formSwitchDropbox_{$value->id}'>" . ($value->status == 1 ? 'Active' : 'Inactive') . "</label></div>";
        
            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            // $action .= '<a href="' . route('admin.payments.edit', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>';
            
            $action .= '<a href="' . route('admin.payments.show', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Detail"><i class="fa fa-eye"></i></a>';

            // $action .= '<a href="javascript:void(0)" onclick="deletePayments(this)" data-url="' . route('admin.paymentdestory') . '" class="toolTip deletePayments" data-toggle="tooltip" data-id="' . $value->id . '" data-placement="bottom" title="Delete"><i class="fa fa-times"></i></a>';
            $action.="</div>";

            $data['view'] = $action;
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
        $payment = null;
        $customerlist = User::where("status","1")->where('id', '!=', 1)->where('role','2')->get(['id',"first_name","last_name"]);
      
        return view('admin.accounts.create',compact('payment','customerlist'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
    public function store(Request $request) {
        $input = $request->all();
      
        $validate = Validator($request->all(), [
            'customer_id' => 'required',
        ]);
        $attr = [
            'customer_id' => 'Customer Name',

        ];
        $validate->setAttributeNames($attr);
        if ($validate->fails()) {
            return redirect()->route('admin.payments.create')->withInput($request->all())->withErrors($validate);
        } else {
            try {
                $payment =  Payment::where("customer_id",$request->customer_id)->first();
                if($payment){
                    $payment->total_amount = $payment->total_amount +  $request->total_amount;
                    $payment->updated_at = date('Y-m-d H:i:s');
                    $payment->save();
                }
                else{
                    $payment = new Payment;
                    $payment->customer_id = $request->customer_id;
                    $payment->total_amount =  $request->total_amount;
                    $payment->created_at = date('Y-m-d H:i:s');
                    $payment->updated_at = date('Y-m-d H:i:s');
                    $payment->save();
                }
                if($payment){

                
                $paymenthistory = new PaymentHistory;
                $paymenthistory->payment_id = $payment->id;
                $paymenthistory->customer_id = $request->customer_id;
                $paymenthistory->amount =  $request->total_amount;
                $paymenthistory->created_at = date('Y-m-d H:i:s');
                $paymenthistory->updated_at = date('Y-m-d H:i:s');


                if ($paymenthistory->save()) {
                    $request->session()->flash('success', 'Payment added successfully');
                    return redirect()->route('admin.payments.index');
                } else {
                    $request->session()->flash('error', 'Something went wrong. Please try again later.');
                    return redirect()->route('admin.payments.index');
                }
            }
            else{
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.payments.index');
            }
            } catch (Exception $e) {
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.payments.index');
            }

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment=Payment::find($id);
        $customerlist = User::where("status","1")->where('id', '!=', 1)->get(['id',"first_name","last_name"]);

        return view('admin.accounts.view',compact('payment','customerlist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id = null) {
        if (isset($id) && $id != null) {
            // $payment = Payment::where('id', $id)->first();
            $payment = Payment::find($id);
            // dd($payment);
            
            if (isset($payment->id)) {
            
                $type = 'edit';
               
                $customerlist = User::where("status","1")->where('id', '!=', 1)->where('role','2')->get(['id',"first_name","last_name"]);
               
                return view('admin.accounts.create', compact('payment', 'type','customerlist'));
            } else {
                $request->session()->flash('error', 'Invalid Data');
                return redirect()->route('admin.payments.index');
            }
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->route('admin.payments.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (isset($id) && $id != null) {

            $payment = Payment::where('id', $id)->first();

            if (isset($payment->id)) {
                $validate = Validator($request->all(),  [
                    'customer_id' => 'required',
                ]);
                $attr = [
                    'customer_id' => 'Customer Name',

                ];

                $validate->setAttributeNames($attr);

                if ($validate->fails()) {
                    return redirect()->route('editpayments', ['id' => $payment->id])->withInput($request->all())->withErrors($validate);
                } else {
                    try {
                        
                        $payment->customer_id = $request->customer_id;
                        $payment->total_amount =  $request->total_amount;
                        $payment->updated_at = date('Y-m-d H:i:s');
                        
                        // dd($payment);
                        if ($payment->save()) {

                            $request->session()->flash('success', 'Payment updated successfully');
                            return redirect()->route('admin.payments.index');
                        } else {
                            $request->session()->flash('error', 'Something went wrong. Please try again later.');
                            return redirect()->route('admin.payments.edit', ['id' => $id]);
                        }
                    } catch (Exception $e) {
                        $request->session()->flash('error', 'Something went wrong. Please try again later.');
                        return redirect()->route('admin.payments.edit', ['id' => $id]);
                    }
                }
            } else {
                $request->session()->flash('error', 'Invalid Data');
                return redirect()->route('admin.payments.edit', ['id' => $id]);
            }
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->route('admin.payments.edit', ['id' => $id]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function paymentdestory(Request $request)
    {
        $id = $request->id;
        $record = Payment::findOrFail($id);
        $record->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully.');;
    }

    public function ChangePaymentStatus(Request $request)
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
