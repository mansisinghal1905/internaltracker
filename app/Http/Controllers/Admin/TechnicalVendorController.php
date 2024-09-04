<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDocumentUpload;
use DB;
use Hash;
use Exception;


class TechnicalVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new User;
        $this->Model1 = new UserDocumentUpload;


        $this->columns = [
            "id",
            "first_name",
            "last_name",
            "created_at",
        ];

        
    }

    public function index()
    {
        $technicalvendor = User::all();
    
        return view('admin.technicalvendors.index',compact('technicalvendor'));
    }

    public function technicalvendorAjax(Request $request)
    {
        // dd($request->all());
        try
        {

        $request->search = $request->search;
        
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model1->FetchTechnicalVendor($request, $this->columns);
        $total = $records->get();
        if (isset($request->start)) {
            $categories = $records->offset($request->start)->limit($request->length)->get();
        } else {
            $categories = $records->offset($request->start)->limit(count($total))->get();
        }
        $result = [];
        $i = 1;
        foreach ($categories as $value) {
            $getUserDocumentUpload = UserDocumentUpload::where(["user_id"=>$value->id,'department_type'=> 'technical_document'])->whereNull('deleted_at')->first();

            $data = [];
            $data['id'] = $i++;
            $data['fullname'] = ucfirst($value->first_name . ' ' . $value->last_name);
            $data['created_at'] = date('Y-m-d', strtotime($value->created_at));

            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            // Check if the document_type is 'technical_document'
            if (isset($getUserDocumentUpload)) {
                
                $action .= '<a href="' .route('admin.file.vendorfiledownload', ['filename' => $getUserDocumentUpload->document]) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Download PDF"><i class="fa fa-download"></i></a>';
            }else{
                $action.="N/A";

            }
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

    public function vendorfiledownload($filename)
    {
        // Define the path to the file
        $filePath = public_path('user_documents/' . $filename);

        // Check if the file exists
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        // Return a 404 response if the file does not exist
        return abort(404, 'File not found');
    }

}
