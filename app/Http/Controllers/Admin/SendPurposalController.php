<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SendPurposal;
use App\Models\QuotationDetail;
use App\Models\QuotationMoreDetail;
use App\Models\User;
use DB;
use Hash;

class SendPurposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new SendPurposal;

        $this->columns = [
            "id",
            "client_id",
            "quatation_id",
            "status",
        ];
    }

    public function index()
    {
        $sendpurposal = SendPurposal::all();
    
        return view('admin.sendpurposal.index',compact('sendpurposal'));
    }

    public function sendpurposalAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchmailQuotation($request, $this->columns);
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
            $data['client_id'] = $value->getClient->name;
            $data['created_at'] = date('Y-m-d', strtotime($value->created_at));
          
            

            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            $action .= '<a href="' . route('admin.sendpurposal.edit', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>';
            
            $action .= '<a href="' . route('admin.sendpurposal.show', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Detail"><i class="fa fa-eye"></i></a>';

            //    $action .= '<a href="javascript:void(0)" onclick="deleteQuotation(this)" data-url="' . route('admin.sendpurposaldestory') . '" class="toolTip deleteQuotation" data-toggle="tooltip" data-id="' . $value->id . '" data-placement="bottom" title="Delete"><i class="fa fa-times"></i></a>';
 
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sendpurposal = null;
        $clientlist = User::where("status","1")->where('id', '!=', 1)->get(['id',"name"]);
        $quotationlist = QuotationDetail::where("status","1")->get(['id',"quotation_subject"]);
        
        return view('admin.sendpurposal.create',compact('sendpurposal','clientlist','quotationlist'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
    public function store(Request $request) {
        // dd($request->all());
        $input = $request->all();
      
        $validate = Validator($request->all(), [
            'quotation_id' => 'required',
        ]);
        $attr = [
            'quotation_id' => 'Quotation Name',
        ];
        $validate->setAttributeNames($attr);
        if ($validate->fails()) {
            return redirect()->route('admin.sendpurposal.create')->withInput($request->all())->withErrors($validate);
        } else {
            try {
                

                $sendpurposal = new SendPurposal;
       
                $sendpurposal->quotation_id = $request->quotation_id;
                $sendpurposal->client_id = $request->client_id;
                $sendpurposal->created_at = date('Y-m-d H:i:s');
                $sendpurposal->updated_at = date('Y-m-d H:i:s');
                // dd($sendpurposal);
                if ($sendpurposal->save()) {

                    $request->session()->flash('success', 'Quotation added successfully');
                    return redirect()->route('admin.sendpurposal.index');
                } else {
                    $request->session()->flash('error', 'Something went wrong. Please try again later.');
                    return redirect()->route('admin.sendpurposal.index');
                }
            } catch (Exception $e) {
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.sendpurposal.index');
            }

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sendpurposal=SendPurposal::find($id);

        // Retrieve the related more details for the quotation
        // $quotationMoreDetails = QuotationMoreDetail::where('quotation_details_id', $id)->get();

        return view('admin.sendpurposal.view',compact('sendpurposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id = null) {
        if (isset($id) && $id != null) {

            $sendpurposal = SendPurposal::with('getQotation')->find($id);
            // dd($quotation);
            
            if (isset($sendpurposal->id)) {
            
                $type = 'edit';
                $categorylist = Category::where("status","1")->get(['id',"name"]);
               
               
                return view('admin.sendpurposal.create', compact('sendpurposal', 'type','categorylist'));
            } else {
                $request->session()->flash('error', 'Invalid Data');
                return redirect()->route('admin.sendpurposal.index');
            }
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->route('admin.sendpurposal.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (isset($id) && $id != null) {

            $sendpurposal = SendPurposal::where('id', $id)->first();

            if (isset($sendpurposal->id)) {
                $validate = Validator($request->all(),  [
                    'quotation_name' => 'required',
            
                ]);
                $attr = [
                    'quotation_name' => 'Quotation Name',
                ];

                $validate->setAttributeNames($attr);

                if ($validate->fails()) {
                    return redirect()->route('editProjects', ['id' => $sendpurposal->id])->withInput($request->all())->withErrors($validate);
                } else {
                    try {
                        $item1 = $request->input('quotation_name', []); // Assuming 'items' is an array of item data
                        $item2 = $request->input('short_description', []); // Assuming 'items' is an array of item data
                        
                        // $quotation_code = "Q-" .rand(100000,999999);
                     
                        $sendpurposal =  SendPurposal::find($id);
                       
                        $sendpurposal->quotation_code = $quotation->quotation_code;
                        $sendpurposal->description = $request->description;
                        $sendpurposal->category_id = $request->category_id;
                        $sendpurposal->updated_at = date('Y-m-d H:i:s');
                        if ($sendpurposal->save()) {

                            $request->session()->flash('success', 'Quotationupdate successfully');
                            return redirect()->route('admin.sendpurposal.index');
                        } else {
                            
                            $request->session()->flash('error', 'Something went wrong. Please try again later.');
                            return redirect()->route('admin.sendpurposal.index');
                        }
                    } catch (Exception $e) {
                        $request->session()->flash('error', 'Something went wrong. Please try again later.');
                        return redirect()->route('admin.sendpurposal.edit', ['id' => $id]);
                    }
                }
            } else {
                $request->session()->flash('error', 'Invalid Data');
                return redirect()->route('admin.sendpurposal.edit', ['id' => $id]);
            }
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->route('admin.sendpurposal.edit', ['id' => $id]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    // public function quotationdestory(Request $request)
    // {
    //     $id = $request->id;
    //     $record = SendPurposal::findOrFail($id);
    //     $record->status = 2; 
    //     $record->save();
    //     return redirect()->route('admin.sendpurposal.index')->with('success', 'Quotation deleted Successfully.');
    // }

    public function changeQuotationStatus(Request $request)
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
