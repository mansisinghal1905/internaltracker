<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TestResult;
use App\Models\User;
use DB;
use Hash;

class TestResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->Model = new TestResult;

        $this->columns = [
            "id",
            "network_name",
            "result",
            "test_by_user",
            "date",
            "note",
            "created_at",
        ];
    }

    public function index()
    {
        $testresult = TestResult::all();
    
        return view('admin.testresults.index',compact('testresult'));
    }

    public function testresultAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchTestResult($request, $this->columns);
        $total = $records->get();
        if (isset($request->start)) {
            $categories = $records->offset($request->start)->limit($request->length)->get();
        } else {
            $categories = $records->offset($request->start)->limit(count($total))->get();
        }
        $result = [];
        $i = $request->start;
        foreach ($categories as $value) {
            $data = [];
            $data['id'] = ++$i;
            $data['network_name'] = $value->network_name;
            $data['result'] = $value->result;
            $data['test_by_user'] = $value->test_by_user;
            $data['date'] = $value->date;
            $data['note'] = $value->note;
            $data['created_at'] = date('Y-m-d', strtotime($value->created_at));
        
        
            $action = '<div class="actionBtn d-flex align-itemss-center" style="gap:8px">';

            
            $action .= '<a href="' . route('admin.testresults.show', $value->id) . '" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Detail"><i class="fa fa-eye"></i></a>';

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
        $testresult = null;
      
        return view('admin.testresults.create',compact('testresult'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
    public function store(Request $request) {
        $input = $request->all();
      
        $validate = Validator($request->all(), [
          
        ]);
        $attr = [
           
        ];
        $validate->setAttributeNames($attr);
        if ($validate->fails()) {
            return redirect()->route('admin.testresults.create')->withInput($request->all())->withErrors($validate);
        } else {
            try {
                $testresult = new TestResult;

                $testresult->network_name = $request->network_name;
                $testresult->result =  $request->result;
                $testresult->test_by_user = $request->test_by_user;
                $testresult->date = $request->date;
                $testresult->note = $request->note;
                $testresult->created_at = date('Y-m-d H:i:s');
                $testresult->updated_at = date('Y-m-d H:i:s');
                if ($testresult->save()) {
                    $request->session()->flash('success', 'Test Result added successfully');
                    return redirect()->route('admin.testresults.index');
                } else {
                    $request->session()->flash('error', 'Something went wrong. Please try again later.');
                    return redirect()->route('admin.testresults.index');
                }
            } catch (Exception $e) {
                $request->session()->flash('error', 'Something went wrong. Please try again later.');
                return redirect()->route('admin.testresults.index');
            }

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $testresult=TestResult::find($id);
        return view('admin.testresults.view',compact('testresult'));
    }

   
  
}
