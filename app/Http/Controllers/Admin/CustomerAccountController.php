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
use Exception;


class CustomerAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new Payment;
        $this->Model1 = new PaymentHistory;
        $this->middleware('permission:Account-Management', ['only' => ['index','store','create','edit','destroy','update']]);


        $this->columns = [
            "id",
            "customer_id",
            "total_amount",
            "created_at",
        ];

        $this->columns1 = [
            "id",
            "payment_id",
            "customer_id",
            "amount",
            "created_at",
        ];
    }

    public function index()
    {
        $payment = Payment::all();
    
        return view('admin.accounts.index',compact('payment'));
    }

    public function paymentAjax(Request $request)
    {
        try
        {

        $request->search = $request->search;
        
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchPayment($request, $this->columns);
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
            $data['customer_id'] = ucfirst(($value->getCustomer->first_name ?? '') . ' ' . ($value->getCustomer->last_name ?? ''));
            $data['total_amount'] = $value->total_amount;
            $data['created_at'] = date('Y-m-d', strtotime($value->created_at));

            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            $action .= '<a href="' . route('admin.customer-payments.show', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Customer Payment History"><i class="fa fa-eye"></i></a>';
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
    }catch(Exception $e){
        dd($e);
    }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $payment = null;
        $customerlist = User::where("status","1")->where('id', '!=', 31)->where('type','2')->get(['id',"first_name","last_name"]);
      
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
            return redirect()->route('admin.customer-payments.create')->withInput($request->all())->withErrors($validate);
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
                    $payment->payment_purpose =  $request->payment_purpose;
                    $payment->created_at = date('Y-m-d H:i:s');
                    $payment->updated_at = date('Y-m-d H:i:s');
                    $payment->save();
                }
                if($payment){

                
                    $paymenthistory = new PaymentHistory;
                    $paymenthistory->payment_id = $payment->id;
                    $paymenthistory->customer_id = $request->customer_id;
                    $paymenthistory->amount =  $request->total_amount;
                    $paymenthistory->payment_purpose =  $request->payment_purpose;
                    $paymenthistory->created_at = date('Y-m-d H:i:s');
                    $paymenthistory->updated_at = date('Y-m-d H:i:s');


                    if ($paymenthistory->save()) {
                        $request->session()->flash('success', 'Payment added successfully');
                        return redirect()->route('admin.customer-payments.index');
                    } else {
                        $request->session()->flash('error', 'Something went wrong. Please try again later.');
                        return redirect()->route('admin.customer-payments.index');
                    }
                }
                else{
                    $request->session()->flash('error', 'Something went wrong. Please try again later.');
                    return redirect()->route('admin.customer-payments.index');
                }
            } catch (Exception $e) {
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.customer-payments.index');
            }

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment=PaymentHistory::with('getpayment')->where('payment_id', $id)->get();
        // dd($payment);
        $customerlist = User::where("status","1")->where('id', '!=', 31)->get(['id',"first_name","last_name"]);

        return view('admin.accounts.view',compact('payment','customerlist','id'));
    }
    public function paymenthistoryAjax(Request $request)
    {
        try
        {

        $request->search = $request->search;
        
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model1->fetchPayment1($request, $this->columns1);
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
            $data['customer_id'] = ucfirst(($value->getCustomer->first_name ?? '') . ' ' . ($value->getCustomer->last_name ?? ''));
            $data['amount'] = $value->amount;
            // $data['payment_purpose'] = $value->payment_purpose;
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
        $record = Payment::findOrFail($id);
        $record->delete();
        return redirect()->route('admin.customer-payments.index')->with('success', 'Payment deleted successfully.');;
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
