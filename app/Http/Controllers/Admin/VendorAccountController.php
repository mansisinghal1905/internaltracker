<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorPaymentHistory;
use App\Models\VendorPayment;
use App\Models\User;
use DB;
use Hash;

class VendorAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new VendorPayment;
        $this->Model1 = new VendorPaymentHistory;
        $this->middleware('permission:Account-Management', ['only' => ['index','store','create','edit','destroy','update']]);


        $this->columns = [
            "id",
            "vendor_id",
            "total_amount",
            "created_at",
        ];

        $this->columns1 = [
            "id",
            "vendor_payment_id",
            "vendor_id",
            "amount",
            "created_at",
        ];
    }

    public function index()
    {
        $vendorpayment = VendorPayment::all();
    
        return view('admin.vendoraccounts.index',compact('vendorpayment'));
    }

    public function vendorpaymentAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchVendorPayment($request, $this->columns);
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
            $data['vendor_id'] = ucfirst(($value->getVendor->first_name ?? '') . ' ' . ($value->getVendor->last_name ?? ''));

            $data['total_amount'] = $value->total_amount;
            $data['created_at'] = date('Y-m-d', strtotime($value->created_at));
 
            // $status = "<div class='form-check form-switch form-switch-sm'><input class='form-check-input c-pointer paymentStatusToggle' type='checkbox' id='formSwitchDropbox_{$value->id}' data-id='{$value->id}'" . ($value->status == 1 ? 'checked' : '') . "><label class='form-check-label fw-500 text-dark c-pointer' for='formSwitchDropbox_{$value->id}'>" . ($value->status == 1 ? 'Active' : 'Inactive') . "</label></div>";
        
            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            // $action .= '<a href="' . route('admin.payments.edit', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>';
            
            $action .= '<a href="' . route('admin.vendor-payments.show', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Payment History Detail"><i class="fa fa-eye"></i></a>';

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
        $vendorpayment = null;
        $vendorlist = User::where("status","1")->where('id', '!=', 31)->where('type','1')->get(['id',"first_name","last_name"]);
      
        return view('admin.vendoraccounts.create',compact('vendorpayment','vendorlist'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
    public function store(Request $request) {
        $input = $request->all();
      
        $validate = Validator($request->all(), [
            'vendor_id' => 'required',
        ]);
        $attr = [
            'vendor_id' => 'Vendor Name',

        ];
        $validate->setAttributeNames($attr);
        if ($validate->fails()) {
            return redirect()->route('admin.vendor-payments.create')->withInput($request->all())->withErrors($validate);
        } else {
            try {
                $vendorpayment =  VendorPayment::where("vendor_id",$request->vendor_id)->first();
                if($vendorpayment){
                    $vendorpayment->total_amount = $vendorpayment->total_amount +  $request->total_amount;
                    $vendorpayment->updated_at = date('Y-m-d H:i:s');
                    $vendorpayment->save();
                }
                else{
                    $vendorpayment = new VendorPayment;
                    $vendorpayment->vendor_id = $request->vendor_id;
                    $vendorpayment->total_amount =  $request->total_amount;
                    $vendorpayment->payment_purpose =  $request->payment_purpose;
                    $vendorpayment->created_at = date('Y-m-d H:i:s');
                    $vendorpayment->updated_at = date('Y-m-d H:i:s');
                    $vendorpayment->save();
                }
                if($vendorpayment){

                
                $vendorpaymenthistory = new VendorPaymentHistory;
                $vendorpaymenthistory->vendor_payment_id = $vendorpayment->id;
                $vendorpaymenthistory->vendor_id = $request->vendor_id;
                $vendorpaymenthistory->amount =  $request->total_amount;
                $vendorpaymenthistory->payment_purpose =  $request->payment_purpose;
                $vendorpaymenthistory->created_at = date('Y-m-d H:i:s');
                $vendorpaymenthistory->updated_at = date('Y-m-d H:i:s');


                if ($vendorpaymenthistory->save()) {
                    $request->session()->flash('success', 'Payment added successfully');
                    return redirect()->route('admin.vendor-payments.index');
                } else {
                    $request->session()->flash('error', 'Something went wrong. Please try again later.');
                    return redirect()->route('admin.vendor-payments.index');
                }
            }
            else{
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.vendor-payments.index');
            }
            } catch (Exception $e) {
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.vendor-payments.index');
            }

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vendorpayment=VendorPaymentHistory::with('getvendorpayment')->where('vendor_payment_id', $id) // Filter by payment_id
                                ->get();
    
        return view('admin.vendoraccounts.view',compact('vendorpayment','id'));
    }

    // vendor payment history ajax
    public function vendorpaymenthistoryAjax(Request $request)
    {
        try
        {

        $request->search = $request->search;
        
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model1->fetchVendorPayment1($request, $this->columns1);
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
            $data['vendor_id'] = ucfirst(($value->getVendor->first_name ?? '') . ' ' . ($value->getVendor->last_name ?? ''));            
            $data['amount'] = $value->amount;
            $data['payment_purpose'] = substr((string)($value->payment_purpose ?? 'Null'), 0, 20);
            $data['created_at'] = date('Y-m-d', strtotime($value->created_at));

            $result[] = $data;

        }
      //  dd($result);
        $data = json_encode([
            'data' => $result,
            'recordsTotal' => count($total),
            'recordsFiltered' => count($total),
        ]);
        return $data;
    }catch(Exception $e){
        dd($e);
    }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function paymentdestory(Request $request)
    {
        $id = $request->id;
        $record = VendorPayment::findOrFail($id);
        $record->delete();
        return redirect()->route('admin.vendor-payments.index')->with('success', 'Payment deleted successfully.');;
    }

    // public function ChangePaymentStatus(Request $request)
    // {
    //     $response = $this->Model->where('id', $request->id)->update(['status' => $request->status]);
    //     if ($response) {
    //         return json_encode([
    //             'status' => true,
    //             "message" => "Status Changes Successfully"
    //         ]);
    //     } else {
    //         return json_encode([
    //             'status' => false,
    //             "message" => "Status Changes Fails"
    //         ]);
    //     }
    // }

}
