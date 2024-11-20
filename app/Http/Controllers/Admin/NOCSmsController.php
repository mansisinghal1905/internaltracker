<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsRoute;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Mail;
use DB;
use Hash;
use Auth;

class NOCSmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new SmsRoute;
        // $this->middleware('permission:Ticket-System', ['only' => ['index','store','create','edit','destroy','update']]);

        $this->columns = [
            "id",
            "customer_id",
            "customer_description",
            "vendor_id",
            "vendor_description",
            "created_at",
        ];
    }

    public function index()
    {
        $nocsms = SmsRoute::all();
       
        return view('admin.nocsms.index',compact('nocsms'));
    }

    public function SmsAjax(Request $request)
    {
        // dd($request->start);
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchSms($request, $this->columns);
        $total = $records->get();
        if (isset($request->start)) {
            $categories = $records->offset($request->start)->limit($request->length)->get();
        } else {
            $categories = $records->offset($request->start)->limit(count($total))->get();
        }
        $result = [];
        $i =  $request->start;
        foreach ($categories as $value) {
            
            $data = [];
            $data['id'] = ++$i;
       
            $data['customer_id'] = ucfirst(($value->getCustomer->first_name ?? '') . ' ' . ($value->getCustomer->last_name ?? ''));

            $data['customer_description'] = substr($value->customer_description, 0, 50);
            $data['vendor_id'] = ucfirst(($value->getVendor->first_name ?? '') . ' ' . ($value->getVendor->last_name ?? ''));

            $data['vendor_description'] = substr($value->vendor_description, 0, 50);

            $data['created_at'] = date('Y-m-d', strtotime($value->created_at));


            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            $action .= '<a href="' . route('admin.nocsms.show', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Detail"><i class="fa fa-eye"></i></a>';

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


    public function show(string $id)
    {
        $nocsms=SmsRoute::find($id);
      
        return view('admin.nocsms.view',compact('nocsms'));
    }

   
}
